<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Customer;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $orders = Order::with('customer')->select('*');
            return DataTables::of($orders)
                ->addColumn('checkbox', function($row) {
                    return '<input type="checkbox" class="select-item" value="'.$row->id.'">';
                })
                ->addColumn('customer', function($row) {
                    return $row->customer ? $row->customer->name : 'N/A';
                })
                ->addColumn('total', function($row) {
                    return '₹'.number_format($row->total, 2);
                })
                ->addColumn('status', function($row) {
                    $badges = [
                        'pending' => 'warning',
                        'processing' => 'info',
                        'completed' => 'success',
                        'cancelled' => 'danger'
                    ];
                    $badge = $badges[$row->status] ?? 'secondary';
                    return '<span class="badge bg-'.$badge.'">'.ucfirst($row->status).'</span>';
                })
                ->addColumn('payment_status', function($row) {
                    $badge = $row->payment_status == 'paid' ? 'success' : 'warning';
                    return '<span class="badge bg-'.$badge.'">'.ucfirst($row->payment_status).'</span>';
                })
                ->addColumn('action', function($row) {
                    return '
                        <a href="'.route('admin.orders.show', $row->id).'" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                        <a href="'.route('admin.orders.edit', $row->id).'" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                        <form action="'.route('admin.orders.destroy', $row->id).'" method="POST" class="d-inline delete-form">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    ';
                })
                ->rawColumns(['checkbox', 'status', 'payment_status', 'action'])
                ->make(true);
        }
        return view('admin.orders.index');
    }

    public function create()
    {
        $customers = Customer::all();
        return view('admin.orders.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_number' => 'required|string|unique:orders,order_number',
            'customer_id' => 'required|exists:customers,id',
            'subtotal' => 'required|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'shipping' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'status' => 'required|in:pending,processing,completed,cancelled',
            'payment_method' => 'nullable|string',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
            'shipping_address' => 'nullable|string',
            'billing_address' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        $order = Order::create($validated);

        // Send Order Confirmation email if status is 'processing'
        if ($validated['status'] === 'processing') {
            $this->sendOrderEmail($order, 'Order Confirmation');
        }

        return redirect()->route('admin.orders.index')->with('success', 'Order created successfully');
    }

    public function show(Order $order)
    {
        $order->load(['customer', 'items', 'transactions']);
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $customers = Customer::all();
        return view('admin.orders.edit', compact('order', 'customers'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'order_number' => 'required|string|unique:orders,order_number,'.$order->id,
            'customer_id' => 'required|exists:customers,id',
            'subtotal' => 'required|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'shipping' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'status' => 'required|in:pending,processing,completed,cancelled',
            'payment_method' => 'nullable|string',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
            'shipping_address' => 'nullable|string',
            'billing_address' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        $originalStatus = $order->status;
        $order->update($validated);

        // Send email only if status changed
        if ($originalStatus !== $validated['status']) {
            switch ($validated['status']) {
                case 'processing':
                    $this->sendOrderEmail($order, 'Order Confirmation');
                    break;
                case 'completed':
                    $this->sendOrderEmail($order, 'Order Delivered');
                    break;
                case 'cancelled':
                    $this->sendOrderEmail($order, 'Order Cancelled');
                    break;
            }
        }

        return redirect()->route('admin.orders.index')->with('success', 'Order updated successfully');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully');
    }

    public function bulkDelete(Request $request)
    {
        Order::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => 'Orders deleted successfully']);
    }

    /**
     * Send order-related email using Mail::html()
     */
private function sendOrderEmail(Order $order, $templateName)
{
    $template = EmailTemplate::where('name', $templateName)
        ->where('status', 1)
        ->first();

    if (!$template) {
        Log::error("Email template not found: {$templateName} for order #{$order->order_number}");
        return;
    }

    $customer = Customer::find($order->customer_id);
    if (!$customer || !$customer->email) {
        Log::error("Customer not found or missing email for order #{$order->order_number}");
        return;
    }

    // Format Shipping Address (multi-line HTML)
    $shippingAddress = $order->shipping_address ?? 'Not provided';
    $shippingAddress = nl2br(e($shippingAddress)); // Converts \n or plain text to <br>

    // Payment Method (human readable)
    $paymentMethod = $order->payment_method
        ? ucfirst(str_replace('_', ' ', $order->payment_method))
        : 'Not specified';

    // Payment Status
    $paymentStatus = ucfirst($order->payment_status ?? 'pending');

    // Refund Status (only for cancelled)
    $refundStatus = '';
    if ($templateName === 'Order Cancelled') {
        $refundStatus = match ($order->payment_status) {
            'refunded' => 'Refunded',
            'paid'     => 'Refund will be processed within 5-7 days',
            'pending'  => 'No payment made',
            default    => 'Processing',
        };
    }

    // Cancellation Reason
    $cancellationReason = $templateName === 'Order Cancelled'
        ? ($order->notes ?: 'No reason provided')
        : '';

    // Prepare data for ALL templates
    $data = [
        'customer_name'       => trim($customer->first_name . ' ' . $customer->last_name),
        'order_number'        => $order->order_number,
        'order_date'          => $order->created_at->format('d M Y'),
        'order_total'         => '₹' . number_format($order->total, 2),
        'payment_method'      => $paymentMethod,
        'shipping_address'    => $shippingAddress,
        'payment_status'      => $paymentStatus,
        'refund_status'       => $refundStatus,
        'cancellation_reason' => $cancellationReason,
        'site_name'           => config('app.name'),
        'site_url'            => config('app.url'),
        'tracking_url'        => in_array($templateName, ['Order Shipped', 'Order Delivered'])
            ? config('app.url') . '/track-order/' . $order->order_number
            : '',
    ];

    $subject = $this->replaceTemplateVariables($template->subject, $data);
    $body    = $this->replaceTemplateVariables($template->body, $data);

    try {
        Mail::html($body, function ($message) use ($customer, $subject) {
            $message->to($customer->email)
                    ->subject($subject)
                    ->from(config('mail.from.address'), config('mail.from.name'));
        });

        Log::info("{$templateName} email sent to {$customer->email} for order #{$order->order_number}");
    } catch (\Exception $e) {
        Log::error("Failed to send {$templateName} email: " . $e->getMessage());
    }
}

    /**
     * Replace {{placeholders}} in template
     */
    private function replaceTemplateVariables($content, $data)
    {
        foreach ($data as $key => $value) {
            $content = str_replace('{{' . $key . '}}', $value, $content);
        }
        return $content;
    }
}
