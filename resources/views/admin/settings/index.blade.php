@extends('admin.layouts.app')

@section('title', 'Website Settings')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Website Settings</h1>
</div>

<form action="{{ route('admin.settings.bulk-update') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <ul class="nav nav-tabs card-header-tabs" id="settingsTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="general-tab" data-toggle="tab" data-target="#general" href="#general" role="tab">
                        <i class="fas fa-cog"></i> General
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="branding-tab" data-toggle="tab" data-target="#branding" href="#branding" role="tab">
                        <i class="fas fa-image"></i> Branding
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="social-tab" data-toggle="tab" data-target="#social" href="#social" role="tab">
                        <i class="fas fa-share-alt"></i> Social Media
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" data-target="#contact" href="#contact" role="tab">
                        <i class="fas fa-phone"></i> Contact Info
                    </a>
                </li>
            </ul>
        </div>

        <div class="card-body">
            <div class="tab-content" id="settingsTabContent">
                <div class="tab-pane fade show active" id="general" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Site Name</label>
                            <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name'] ?? '' }}" placeholder="My E-Commerce Store">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Site Tagline</label>
                            <input type="text" name="site_tagline" class="form-control" value="{{ $settings['site_tagline'] ?? '' }}" placeholder="Your trusted online shop">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Site Description</label>
                            <textarea name="site_description" class="form-control" rows="3" placeholder="Brief description of your website">{{ $settings['site_description'] ?? '' }}</textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Admin Email</label>
                            <input type="email" name="admin_email" class="form-control" value="{{ $settings['admin_email'] ?? '' }}" placeholder="admin@example.com">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Support Email</label>
                            <input type="email" name="support_email" class="form-control" value="{{ $settings['support_email'] ?? '' }}" placeholder="support@example.com">
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="branding" role="tabpanel">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label class="form-label">Site Logo</label>
                            <div class="border rounded p-3 text-center">
                                @if(isset($settings['site_logo']))
                                    <img src="/storage/{{ $settings['site_logo'] }}" class="img-fluid mb-2" style="max-height: 100px;" id="logo-preview">
                                @else
                                    <img src="/admin/img/undraw_profile.svg" class="img-fluid mb-2" style="max-height: 100px;" id="logo-preview">
                                @endif
                                <input type="file" name="site_logo" class="form-control mt-2" accept="image/*" onchange="previewImage(this, 'logo-preview')">
                                <small class="text-muted">Recommended: 200x60px</small>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <label class="form-label">Site Favicon</label>
                            <div class="border rounded p-3 text-center">
                                @if(isset($settings['site_favicon']))
                                    <img src="/storage/{{ $settings['site_favicon'] }}" class="img-fluid mb-2" style="max-height: 100px;" id="favicon-preview">
                                @else
                                    <img src="/favicon.ico" class="img-fluid mb-2" style="max-height: 100px;" id="favicon-preview">
                                @endif
                                <input type="file" name="site_favicon" class="form-control mt-2" accept="image/*" onchange="previewImage(this, 'favicon-preview')">
                                <small class="text-muted">Recommended: 32x32px or 64x64px</small>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <label class="form-label">Footer Logo</label>
                            <div class="border rounded p-3 text-center">
                                @if(isset($settings['footer_logo']))
                                    <img src="/storage/{{ $settings['footer_logo'] }}" class="img-fluid mb-2" style="max-height: 100px;" id="footer-logo-preview">
                                @else
                                    <img src="/admin/img/undraw_profile.svg" class="img-fluid mb-2" style="max-height: 100px;" id="footer-logo-preview">
                                @endif
                                <input type="file" name="footer_logo" class="form-control mt-2" accept="image/*" onchange="previewImage(this, 'footer-logo-preview')">
                                <small class="text-muted">Recommended: 200x60px</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="social" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fab fa-facebook"></i> Facebook URL</label>
                            <input type="url" name="facebook_url" class="form-control" value="{{ $settings['facebook_url'] ?? '' }}" placeholder="https://facebook.com/yourpage">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fab fa-twitter"></i> Twitter URL</label>
                            <input type="url" name="twitter_url" class="form-control" value="{{ $settings['twitter_url'] ?? '' }}" placeholder="https://twitter.com/yourhandle">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fab fa-instagram"></i> Instagram URL</label>
                            <input type="url" name="instagram_url" class="form-control" value="{{ $settings['instagram_url'] ?? '' }}" placeholder="https://instagram.com/yourprofile">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fab fa-linkedin"></i> LinkedIn URL</label>
                            <input type="url" name="linkedin_url" class="form-control" value="{{ $settings['linkedin_url'] ?? '' }}" placeholder="https://linkedin.com/company/yourcompany">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fab fa-youtube"></i> YouTube URL</label>
                            <input type="url" name="youtube_url" class="form-control" value="{{ $settings['youtube_url'] ?? '' }}" placeholder="https://youtube.com/channel/yourchannel">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fab fa-whatsapp"></i> WhatsApp Number</label>
                            <input type="text" name="whatsapp_number" class="form-control" value="{{ $settings['whatsapp_number'] ?? '' }}" placeholder="+1234567890">
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="contact" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-phone"></i> Phone Number</label>
                            <input type="text" name="contact_phone" class="form-control" value="{{ $settings['contact_phone'] ?? '' }}" placeholder="+1 (234) 567-8900">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-envelope"></i> Contact Email</label>
                            <input type="email" name="contact_email" class="form-control" value="{{ $settings['contact_email'] ?? '' }}" placeholder="contact@example.com">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label"><i class="fas fa-map-marker-alt"></i> Business Address</label>
                            <textarea name="business_address" class="form-control" rows="3" placeholder="123 Business Street, City, State, ZIP">{{ $settings['business_address'] ?? '' }}</textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label"><i class="fas fa-clock"></i> Business Hours</label>
                            <textarea name="business_hours" class="form-control" rows="3" placeholder="Mon-Fri: 9:00 AM - 6:00 PM">{{ $settings['business_hours'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Settings
            </button>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById(previewId).src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
