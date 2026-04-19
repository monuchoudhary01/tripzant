@props(['title', 'category', 'desc', 'image', 'discount' => 'Up to 40% Off', 'btnText' => 'Grab Deal'])

<div class="card-premium">
    <div class="card-img-wrap" style="height:200px;">
        <img src="{{ $image }}" alt="{{ $title }}">
        <span class="card-img-overlay-badge" style="background:var(--primary);color:#fff;"><i class="fas fa-bolt me-1"></i> {{ $discount }}</span>
    </div>
    <div class="card-body-premium">
        <span class="tag-premium">{{ $category }}</span>
        <h5 class="card-title-premium">{{ $title }}</h5>
        <p style="font-size:13px;color:var(--gray-300);margin-bottom:16px;line-height:1.5;">{{ $desc }}</p>
        <div class="d-flex justify-content-between align-items-center">
            <span style="font-size:14px;font-weight:700;color:var(--green);"><i class="fas fa-tag me-1"></i> {{ $discount }}</span>
            <a href="#" class="btn btn-outline-custom btn-sm px-3" style="font-size:12px;">{{ $btnText }} <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
    </div>
</div>
