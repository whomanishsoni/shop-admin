<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Vyuga</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCatalog"
            aria-expanded="false" aria-controls="collapseCatalog">
            <i class="fas fa-fw fa-folder"></i>
            <span>Catalog</span>
        </a>
        <div id="collapseCatalog" class="collapse" aria-labelledby="headingCatalog" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Catalog Actions</h6>
                <a class="collapse-item {{ request()->routeIs('admin.categories.index') ? 'active' : '' }}"
                    href="{{ route('admin.categories.index') }}">Categories</a>
                <a class="collapse-item {{ request()->routeIs('admin.subcategories.index') ? 'active' : '' }}"
                    href="{{ route('admin.subcategories.index') }}">Subcategories</a>
                <a class="collapse-item {{ request()->routeIs('admin.brands.index') ? 'active' : '' }}"
                    href="{{ route('admin.brands.index') }}">Brands</a>
                <a class="collapse-item {{ request()->routeIs('admin.products.index') ? 'active' : '' }}"
                    href="{{ route('admin.products.index') }}">Products</a>
                <a class="collapse-item {{ request()->routeIs('admin.product-attributes.index') ? 'active' : '' }}"
                    href="{{ route('admin.product-attributes.index') }}">Attributes</a>
                <a class="collapse-item {{ request()->routeIs('admin.product-reviews.index') ? 'active' : '' }}"
                    href="{{ route('admin.product-reviews.index') }}">Reviews</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider">
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSales"
            aria-expanded="false" aria-controls="collapseSales">
            <i class="fas fa-fw fa-shopping-cart"></i>
            <span>Sales</span>
        </a>
        <div id="collapseSales" class="collapse" aria-labelledby="headingSales" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Sales Actions</h6>
                <a class="collapse-item {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}"
                    href="{{ route('admin.orders.index') }}">Orders</a>
                <a class="collapse-item {{ request()->routeIs('admin.customers.index') ? 'active' : '' }}"
                    href="{{ route('admin.customers.index') }}">Customers</a>
                <a class="collapse-item {{ request()->routeIs('admin.coupons.index') ? 'active' : '' }}"
                    href="{{ route('admin.coupons.index') }}">Coupons</a>
                <a class="collapse-item {{ request()->routeIs('admin.transactions.index') ? 'active' : '' }}"
                    href="{{ route('admin.transactions.index') }}">Transactions</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider">
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOperations"
            aria-expanded="false" aria-controls="collapseOperations">
            <i class="fas fa-fw fa-truck"></i>
            <span>Operations</span>
        </a>
        <div id="collapseOperations" class="collapse" aria-labelledby="headingOperations"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Operations Actions</h6>
                <a class="collapse-item {{ request()->routeIs('admin.shipping-methods.index') ? 'active' : '' }}"
                    href="{{ route('admin.shipping-methods.index') }}">Shipping Methods</a>
                <a class="collapse-item {{ request()->routeIs('admin.shipping-zones.index') ? 'active' : '' }}"
                    href="{{ route('admin.shipping-zones.index') }}">Shipping Zones</a>
                <a class="collapse-item {{ request()->routeIs('admin.taxes.index') ? 'active' : '' }}"
                    href="{{ route('admin.taxes.index') }}">Taxes</a>
                <a class="collapse-item {{ request()->routeIs('admin.currencies.index') ? 'active' : '' }}"
                    href="{{ route('admin.currencies.index') }}">Currencies</a>
                <a class="collapse-item {{ request()->routeIs('admin.payment-gateways.index') ? 'active' : '' }}"
                    href="{{ route('admin.payment-gateways.index') }}">Payment Gateways</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider">
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseContent"
            aria-expanded="false" aria-controls="collapseContent">
            <i class="fas fa-fw fa-images"></i>
            <span>Content</span>
        </a>
        <div id="collapseContent" class="collapse" aria-labelledby="headingContent" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Content Actions</h6>
                <a class="collapse-item {{ request()->routeIs('admin.sliders.index') ? 'active' : '' }}"
                    href="{{ route('admin.sliders.index') }}">Sliders</a>
                <a class="collapse-item {{ request()->routeIs('admin.banners.index') ? 'active' : '' }}"
                    href="{{ route('admin.banners.index') }}">Banners</a>
                <a class="collapse-item {{ request()->routeIs('admin.blog-categories.index') ? 'active' : '' }}"
                    href="{{ route('admin.blog-categories.index') }}">Blog Categories</a>
                <a class="collapse-item {{ request()->routeIs('admin.blog-posts.index') ? 'active' : '' }}"
                    href="{{ route('admin.blog-posts.index') }}">Blog Posts</a>
                <a class="collapse-item {{ request()->routeIs('admin.pages.index') ? 'active' : '' }}"
                    href="{{ route('admin.pages.index') }}">Pages</a>
                <a class="collapse-item {{ request()->routeIs('admin.faqs.index') ? 'active' : '' }}"
                    href="{{ route('admin.faqs.index') }}">FAQs</a>
                <a class="collapse-item {{ request()->routeIs('admin.testimonials.index') ? 'active' : '' }}"
                    href="{{ route('admin.testimonials.index') }}">Testimonials</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider">
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSupport"
            aria-expanded="false" aria-controls="collapseSupport">
            <i class="fas fa-fw fa-ticket-alt"></i>
            <span>Support</span>
        </a>
        <div id="collapseSupport" class="collapse" aria-labelledby="headingSupport" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Support Actions</h6>
                <a class="collapse-item {{ request()->routeIs('admin.tickets.index') ? 'active' : '' }}"
                    href="{{ route('admin.tickets.index') }}">Tickets</a>
                <a class="collapse-item {{ request()->routeIs('admin.subscribers.index') ? 'active' : '' }}"
                    href="{{ route('admin.subscribers.index') }}">Subscribers</a>
                <a class="collapse-item {{ request()->routeIs('admin.email-templates.index') ? 'active' : '' }}"
                    href="{{ route('admin.email-templates.index') }}">Email Templates</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider">
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSystem"
            aria-expanded="false" aria-controls="collapseSystem">
            <i class="fas fa-fw fa-cog"></i>
            <span>System</span>
        </a>
        <div id="collapseSystem" class="collapse" aria-labelledby="headingSystem" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">System Actions</h6>
                <a class="collapse-item {{ request()->routeIs('admin.settings.index') ? 'active' : '' }}"
                    href="{{ route('admin.settings.index') }}">Settings</a>
                <a class="collapse-item {{ request()->routeIs('admin.languages.index') ? 'active' : '' }}"
                    href="{{ route('admin.languages.index') }}">Languages</a>
                <a class="collapse-item {{ request()->routeIs('admin.analytics') ? 'active' : '' }}"
                    href="{{ route('admin.analytics') }}">Analytics</a>
                <a class="collapse-item {{ request()->routeIs('admin.activity-logs.index') ? 'active' : '' }}"
                    href="{{ route('admin.activity-logs.index') }}">Activity Logs</a>
                <a class="collapse-item {{ request()->routeIs('admin.backups.index') ? 'active' : '' }}"
                    href="{{ route('admin.backups.index') }}">Backups</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider d-none d-md-block">
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
