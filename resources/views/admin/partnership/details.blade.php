@extends('layouts.admin')

@section('title', 'Website Details | ' . $website->domain)

@section('admin_content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row align-items-center mb-4">
        <div class="col-md-8">
            <div class="d-flex align-items-center">
                <a href="{{ route('admin.partnership.index') }}" class="btn btn-icon btn-light rounded-circle me-3 shadow-none">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="fw-900 text-navy mb-0">{{ $website->domain }}</h2>
                    <span class="text-muted small">Category: <strong>{{ $website->category }}</strong> | Joined discovery: {{ $website->created_at->format('M d, Y') }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <form action="{{ route('admin.partnership.status.update', $website->id) }}" method="POST" class="d-inline-block">
                @csrf
                <select name="status" class="form-select rounded-pill px-4 border-2" onchange="this.form.submit()" style="border-color: #0b3d61;">
                    <option value="new" {{ $website->status == 'new' ? 'selected' : '' }}>Mark as New</option>
                    <option value="contacted" {{ $website->status == 'contacted' ? 'selected' : '' }}>Mark as Contacted</option>
                    <option value="partnered" {{ $website->status == 'partnered' ? 'selected' : '' }}>Mark as Partnered</option>
                    <option value="rejected" {{ $website->status == 'rejected' ? 'selected' : '' }}>Reject Lead</option>
                </select>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <!-- Main Stats & Charts -->
        <div class="col-lg-8">
            <div class="card-admin mb-4">
                <h5 class="fw-800 text-navy mb-4"><i class="fas fa-chart-pie me-2 text-primary"></i> Traffic Intelligence</h5>
                
                <div class="row g-4 mb-5">
                    <div class="col-md-6">
                        <div class="p-4 bg-light rounded-4 text-center h-100">
                            <span class="text-muted small fw-bold">MONTHLY AVG. VISITORS</span>
                            <h1 class="fw-900 text-navy mt-2 mb-0">{{ $website->monthly_traffic }}</h1>
                            <small class="text-success fw-bold"><i class="fas fa-level-up-alt"></i> 12% growth vs last month</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-4 bg-light rounded-4 text-center h-100">
                            <span class="text-muted small fw-bold text-uppercase">Bounce Rate</span>
                            <h3 class="fw-900 text-navy mt-2 mb-0">34.2%</h3>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-4 bg-light rounded-4 text-center h-100">
                            <span class="text-muted small fw-bold text-uppercase">Page Order</span>
                            <h3 class="fw-900 text-navy mt-2 mb-0">2.1</h3>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-3">Traffic Sources</h6>
                        @foreach($website->traffic_sources ?? [] as $source => $value)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="small fw-bold">{{ $source }}</span>
                                <span class="small text-muted">{{ $value }}</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-navy" style="width: {{ $value }}"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-3">Top Visiting Countries</h6>
                        <ul class="list-group list-group-flush">
                            @foreach($website->top_countries ?? [] as $country)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent">
                                <span><i class="fas fa-location-dot text-danger me-2"></i> {{ $country }}</span>
                                <span class="badge bg-navy-subtle text-navy">{{ rand(10, 30) }}%</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card-admin">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-800 text-navy mb-0"><i class="fas fa-rocket me-2 text-warning"></i> Outreach & Pitch Module</h5>
                </div>
                
                <div class="row g-4">
                    <div class="col-md-12">
                        <div class="pitch-box p-4 rounded-4 bg-light border-0">
                            <h6 class="fw-bold mb-3 text-uppercase small text-muted">Partnership Pitch Template</h6>
                            <div class="bg-white p-3 rounded-3 border mb-3 position-relative" id="pitchContent">
                                <p class="mb-0 text-dark" style="line-height: 1.6;">
                                    "Hello Management of <strong>{{ $website->domain ?? $website->name }}</strong>,<br><br>
                                    We provide a high-converting travel booking widget (flights, hotels). You can integrate it on your website and earn commission on every booking. No cost, no effort. Let me know if you are interested in boosting your revenue."
                                </p>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-navy rounded-pill px-4" onclick="copyPitch()">
                                    <i class="fas fa-copy me-2"></i> Copy Pitch
                                </button>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $website->contact_phone) }}?text=Hello, we provide a travel booking widget..." target="_blank" class="btn btn-success rounded-pill px-4">
                                    <i class="fab fa-whatsapp me-2"></i> Send WhatsApp
                                </a>
                                <a href="mailto:{{ $website->contact_email }}?subject=Partnership Proposal for {{ $website->domain }}" class="btn btn-primary rounded-pill px-4">
                                    <i class="fas fa-envelope me-2"></i> Send Email
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-lg-4">
            <div class="card-admin mb-4">
                <h5 class="fw-800 text-navy mb-4">Contact Information</h5>
                <div class="mb-4">
                    <label class="small text-muted fw-bold d-block mb-1 text-uppercase">Primary Email</label>
                    <div class="d-flex align-items-center">
                        <span class="text-navy fw-bold">{{ $website->contact_email ?? 'N/A' }}</span>
                        <a href="mailto:{{ $website->contact_email }}" class="ms-auto text-primary"><i class="fas fa-external-link-alt"></i></a>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="small text-muted fw-bold d-block mb-1 text-uppercase">WhatsApp / Phone</label>
                    <div class="d-flex align-items-center">
                        <span class="text-navy fw-bold">{{ $website->contact_phone ?? 'N/A' }}</span>
                        <a href="https://wa.me/{{ $website->contact_phone }}" class="ms-auto text-success"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="small text-muted fw-bold d-block mb-1 text-uppercase">Social Profiles</label>
                    <div class="d-flex gap-3 mt-2">
                        @foreach($website->social_links ?? [] as $platform => $link)
                        <a href="{{ $link }}" target="_blank" class="social-icon bg-light text-navy d-flex align-items-center justify-content-center rounded-circle" style="width: 40px; height: 40px;">
                            <i class="fab fa-{{ $platform }}"></i>
                        </a>
                        @endforeach
                    </div>
                </div>
                <hr>
                <div class="text-center p-3 bg-primary-subtle rounded-3">
                    <small class="text-primary fw-bold d-block mb-1">AUTO-DISCOVERY TOOL</small>
                    <button class="btn btn-sm btn-primary w-100 rounded-pill"><i class="fas fa-robot me-2"></i> Scrape Contact Emails</button>
                    <small class="text-muted mt-2 d-block" style="font-size: 10px;">Powered by BuiltWith & Hunter API</small>
                </div>
            </div>

            <div class="card-admin stats-card" style="border-left-color: #6366f1 !important;">
                <h5 class="fw-800 text-navy mb-4">Partnership Value</h5>
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <span class="text-muted">Est. Monthly Revenue</span>
                    <span class="text-navy fw-bold">${{ number_format($website->traffic_count * 0.05, 2) }}</span>
                </div>
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <span class="text-muted">Total Conversions</span>
                    <span class="text-navy fw-bold">{{ $website->total_bookings }}</span>
                </div>
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <span class="text-muted">Total Commission</span>
                    <span class="text-navy fw-bold text-success">${{ number_format($website->revenue_generated, 2) }}</span>
                </div>
                <hr>
                <a href="{{ route('admin.partnership.widget') }}" class="btn btn-navy w-100 rounded-pill">View Widget Integration</a>
            </div>
        </div>
    </div>
</div>

<script>
    function copyPitch() {
        const text = document.getElementById('pitchContent').innerText;
        navigator.clipboard.writeText(text);
        alert('Pitch copied to clipboard!');
    }
</script>
@endsection

@push('styles')
<style>
    .bg-navy-subtle { background: rgba(11, 61, 97, 0.1); }
    .social-icon:hover { background: #0b3d61; color: #fff; transform: translateY(-3px); transition: all 0.2s; }
    .avatar-sm { width: 32px; height: 32px; font-size: 14px; }
</style>
@endpush
