<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingZone extends Model
{
    protected $fillable = ['name', 'states', 'shipping_method_id', 'rate', 'status'];

    protected $casts = [
        'states' => 'array',
        'status' => 'boolean',
    ];

    public function shippingMethod()
    {
        return $this->belongsTo(ShippingMethod::class);
    }

    public function getStatesAttribute($value)
    {
        $states = is_string($value) ? json_decode($value, true) : $value;

        if (!is_array($states)) {
            \Log::warning('Invalid states JSON for zone ID: ' . $this->id, ['value' => $value]);
            return [];
        }

        $indianStates = [
            'Andaman and Nicobar Islands' => 'AN',
            'Andhra Pradesh' => 'AP',
            'Arunachal Pradesh' => 'AR',
            'Assam' => 'AS',
            'Bihar' => 'BR',
            'Chandigarh' => 'CH',
            'Chhattisgarh' => 'CT',
            'Delhi' => 'DL',
            'Dadra and Nagar Haveli and Daman and Diu' => 'DN',
            'Goa' => 'GA',
            'Gujarat' => 'GJ',
            'Himachal Pradesh' => 'HP',
            'Haryana' => 'HR',
            'Jharkhand' => 'JH',
            'Jammu and Kashmir' => 'JK',
            'Karnataka' => 'KA',
            'Kerala' => 'KL',
            'Ladakh' => 'LA',
            'Lakshadweep' => 'LD',
            'Maharashtra' => 'MH',
            'Meghalaya' => 'ML',
            'Manipur' => 'MN',
            'Madhya Pradesh' => 'MP',
            'Mizoram' => 'MZ',
            'Nagaland' => 'NL',
            'Odisha' => 'OR',
            'Punjab' => 'PB',
            'Puducherry' => 'PY',
            'Rajasthan' => 'RJ',
            'Sikkim' => 'SK',
            'Tamil Nadu' => 'TN',
            'Telangana' => 'TG',
            'Tripura' => 'TR',
            'Uttar Pradesh' => 'UP',
            'Uttarakhand' => 'UT',
            'West Bengal' => 'WB',
        ];

        // Define valid state codes
        $validCodes = array_values($indianStates);

        // Convert full state names to codes and normalize existing codes
        $convertedStates = array_map(function ($state) use ($indianStates, $validCodes) {
            // Handle full state names
            if (in_array($state, array_keys($indianStates))) {
                return $indianStates[$state];
            }
            // Normalize and validate codes
            $state = strtoupper(trim($state));
            return in_array($state, $validCodes) ? $state : null;
        }, $states);

        // Remove null values and ensure unique codes
        $validStates = array_unique(array_filter($convertedStates));

        if (count($validStates) < count($states)) {
            \Log::warning('Invalid or unmapped states for zone ID: ' . $this->id, [
                'original' => $states,
                'converted' => $validStates,
            ]);
        }

        return array_values($validStates);
    }
}
