<div class="weather-widget-mmt reveal rounded-4 overflow-hidden border shadow-sm mb-4 bg-white" id="weatherWidget">
    <div class="weather-header d-flex align-items-center justify-content-between px-4 py-3 border-bottom" style="background: linear-gradient(135deg, #0b3d61 0%, #3b82f6 100%); color: #fff;">
        <div class="d-flex align-items-center gap-3">
            <div class="weather-icon-main fs-2 animation-float">
                <i class="fas fa-cloud-sun-rain"></i>
            </div>
            <div>
                <h6 class="mb-0 fw-900 small text-uppercase letter-spacing-1">Trip Forecast</h6>
                <p class="mb-0 fw-bold small opacity-75" id="weatherCity">{{ $city ?? 'Destination' }}</p>
            </div>
        </div>
        <div class="text-end">
            <h4 class="mb-0 fw-900" id="currentTemp">24°C</h4>
            <span class="small fw-bold opacity-75" id="weatherCondition">Partly Cloudy</span>
        </div>
    </div>
    <div class="weather-body p-4 bg-light-subtle">
        <div class="d-flex justify-content-between align-items-stretch gap-2 overflow-auto pb-2" id="forecastDays">
            @php
            $days = [
                ['day' => 'Tomorrow', 'temp' => '25°/18°', 'icon' => 'fa-sun', 'color' => 'text-warning'],
                ['day' => 'Wed, 15 Apr', 'temp' => '23°/17°', 'icon' => 'fa-cloud-sun', 'color' => 'text-info'],
                ['day' => 'Thu, 16 Apr', 'temp' => '22°/16°', 'icon' => 'fa-cloud-showers-heavy', 'color' => 'text-primary'],
                ['day' => 'Fri, 17 Apr', 'temp' => '24°/18°', 'icon' => 'fa-bolt-lightning', 'color' => 'text-warning'],
                ['day' => 'Sat, 18 Apr', 'temp' => '26°/19°', 'icon' => 'fa-sun', 'color' => 'text-warning'],
            ];
            @endphp
            @foreach($days as $f)
            <div class="forecast-item flex-fill text-center bg-white rounded-3 shadow-sm py-3 px-2 border border-light-subtle hvr-grow">
                <span class="d-block text-muted fw-bold mb-2" style="font-size: 10px;">{{ $f['day'] }}</span>
                <i class="fas {{ $f['icon'] }} {{ $f['color'] }} fs-5 mb-2"></i>
                <span class="d-block fw-900 text-navy" style="font-size: 12px;">{{ $f['temp'] }}</span>
            </div>
            @endforeach
        </div>
        
        <!-- Smart Tip -->
        <div class="weather-tip mt-4 p-3 rounded-3 border d-flex align-items-center gap-3 bg-white shadow-sm border-start-4 border-start-primary">
            <div class="tip-icon"><i class="fas fa-lightbulb text-primary"></i></div>
            <p class="mb-0 small fw-bold text-muted lh-sm">
                <span class="text-primary fw-900 d-block mb-1">Misty AI Advice:</span>
                Expect slight rain on Thursday. Don't forget your umbrella and a light jacket!
            </p>
        </div>
    </div>
</div>

<style>
    .weather-widget-mmt { transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
    .bg-light-subtle { background: rgba(59, 130, 246, 0.03); }
    .forecast-item { min-width: 80px; }
    .animation-float { animation: float 3s ease-in-out infinite; }
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-3px); }
    }
    .letter-spacing-1 { letter-spacing: 1.5px; }
    .border-start-4 { border-left-width: 4px !important; }
    .border-start-primary { border-left-color: #0b3d61 !important; }
</style>
