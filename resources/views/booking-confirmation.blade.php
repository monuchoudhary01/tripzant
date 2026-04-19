@extends('layouts.app')

@section('title', " Booking Confirmed! — Tripzant Premium " )

@section('styles')
<style>
    :root {
        --tripzant-blue: #005eb8;
        --tripzant-dark: #003366;
        --success-green: #10b981;
        --glass: rgba(255, 255, 255, 0.08);
        --glass-border: rgba(255, 255, 255, 0.1);
    }

    body {
        background-color: #f0f4f8 !important;
        font-family: 'Outfit', sans-serif;
    }

    .premium-hero {
        background: linear-gradient(135deg, var(--tripzant-dark) 0%, var(--tripzant-blue) 100%);
        padding: 100px 0 180px;
        position: relative;
        overflow: hidden;
        text-align: center;
    }

    /* Ambient Take-off Effect */
    .premium-hero::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: radial-gradient(circle at 50% 120%, rgba(56, 189, 248, 0.2), transparent);
        pointer-events: none;
    }

    .success-icon-glow {
        width: 100px;
        height: 100px;
        background: var(--success-green);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 30px;
        color: white;
        font-size: 45px;
        box-shadow: 0 0 50px rgba(16, 185, 129, 0.4);
        position: relative;
        animation: pulse-success 2s infinite;
    }

    @keyframes pulse-success {
        0% { transform: scale(1); box-shadow: 0 0 30px rgba(16, 185, 129, 0.4); }
        50% { transform: scale(1.05); box-shadow: 0 0 60px rgba(16, 185, 129, 0.6); }
        100% { transform: scale(1); box-shadow: 0 0 30px rgba(16, 185, 129, 0.4); }
    }

    .pnr-module {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 15px 30px;
        display: inline-flex;
        align-items: center;
        gap: 15px;
        color: white;
        margin-top: 20px;
    }

    .ticket-glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 30px;
        overflow: hidden;
        box-shadow: 0 30px 60px rgba(0,0,0,0.12);
        margin-top: -100px;
        border: 1px solid white;
        position: relative;
    }

    .ticket-perforation {
        position: relative;
        height: 2px;
        background: repeating-linear-gradient(90deg, #ddd, #ddd 10px, transparent 10px, transparent 20px);
        margin: 0 20px;
    }
    .ticket-perforation::before, .ticket-perforation::after {
        content: '';
        position: absolute;
        width: 30px;
        height: 30px;
        background: #f0f4f8;
        border-radius: 50%;
        top: -15px;
    }
    .ticket-perforation::before { left: -35px; }
    .ticket-perforation::after { right: -35px; }

    .route-visual {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 40px;
    }

    .iata-code { font-size: 48px; font-weight: 900; color: var(--tripzant-dark); margin-bottom: 0; }
    .city-name { font-size: 14px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 1px; }

    .flight-path {
        flex-grow: 1;
        padding: 0 40px;
        position: relative;
        text-align: center;
    }
    .path-line {
        height: 2px;
        background: #e2e8f0;
        width: 100%;
        position: relative;
    }
    .path-plane {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: var(--tripzant-blue);
        background: white;
        padding: 0 15px;
        font-size: 20px;
    }

    .pax-manifest-token {
        background: #fafbfc;
        border: 1px solid #edf2f7;
        border-radius: 18px;
        padding: 20px;
        transition: all 0.3s;
    }
    .pax-manifest-token:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        border-color: var(--tripzant-blue);
    }

    .sidebar-premium {
        background: white;
        border-radius: 24px;
        padding: 30px;
        box-shadow: 0 15px 30px rgba(0,0,0,0.05);
        position: sticky;
        top: 30px;
    }

    .upi-seal {
        background: #f0fdf4;
        border: 1px solid #dcfce7;
        color: #166534;
        padding: 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 900;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .action-btn-main {
        background: var(--tripzant-blue);
        color: white;
        border: none;
        padding: 18px;
        border-radius: 15px;
        width: 100%;
        font-weight: 800;
        transition: 0.3s;
        box-shadow: 0 10px 20px rgba(0, 94, 184, 0.2);
    }
    .action-btn-main:hover {
        background: var(--tripzant-dark);
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(0, 94, 184, 0.4);
    }
</style>
@endsection

@section('content')
<div class="premium-hero">
    <div class="container">
        <div class="success-icon-glow">
            <i class="fas fa-check-double"></i>
        </div>
        <h1 class="fw-900 text-white mb-2" style="font-size: 42px;">Your Trip is Confirmed!</h1>
        <p class="text-white opacity-75" style="font-size: 18px;">Everything is synchronized. Time to start packing!</p>
        
        <div class="pnr-module">
            <div>
                <div class="small fw-800 opacity-60">AMADEUS PNR</div>
                <div class="fs-5 fw-900" id="pnrDisplay" style="letter-spacing: 3px;">--</div>
            </div>
            <div style="width: 1px; height: 30px; background: rgba(255,255,255,0.2);"></div>
            <div>
                <div class="small fw-800 opacity-60">STATUS</div>
                <div class="fw-900 text-success">VERIFIED</div>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-5">
        <!-- Ticket Center -->
        <div class="col-lg-8">
            <div class="ticket-glass-card">
                <div class="p-4 d-flex justify-content-between align-items-center bg-light border-bottom">
                    <div class="d-flex align-items-center gap-3">
                        <img src="https://logowik.com/content/uploads/images/indigo7491.jpg" height="40" style="mix-blend-mode: multiply;">
                        <h6 class="fw-900 text-navy mb-0">IndiGo Flight 6E-2134</h6>
                    </div>
                    <div class="text-end">
                        <div class="small fw-800 text-muted">CLASS</div>
                        <div class="fw-900 text-navy">ECONOMY (Y)</div>
                    </div>
                </div>

                <div class="route-visual">
                    <div class="text-start">
                        <h2 class="iata-code">DEL</h2>
                        <div class="city-name text-navy">New Delhi</div>
                        <div class="small fw-bold text-muted">Terminal 3 | 10:45 AM</div>
                    </div>
                    
                    <div class="flight-path">
                        <div class="small fw-900 text-muted mb-2">2H 15M (Direct)</div>
                        <div class="path-line">
                            <i class="fas fa-plane path-plane"></i>
                        </div>
                        <div class="small fw-900 text-primary mt-2">CONFIRMED SEATS AVAILABLE</div>
                    </div>

                    <div class="text-end">
                        <h2 class="iata-code">BOM</h2>
                        <div class="city-name text-navy">Mumbai</div>
                        <div class="small fw-bold text-muted">Terminal 2 | 01:00 PM</div>
                    </div>
                </div>

                <div class="ticket-perforation"></div>

                <div class="p-4 p-md-5">
                    <h5 class="fw-900 text-navy mb-4"><i class="fas fa-user-check me-2 text-primary"></i> Passenger Manifest</h5>
                    <div class="row g-4" id="manifestGrid">
                        <!-- Dynamic Tokens -->
                    </div>
                </div>

                <div class="p-4 bg-light border-top d-flex justify-content-between">
                    <div class="d-flex align-items-center gap-2 small fw-bold text-muted">
                        <i class="fas fa-suitcase-rolling text-primary"></i> 15KG Check-in + 7KG Cabin
                    </div>
                    <div class="d-flex gap-3">
                        <button class="btn btn-navy-outline px-4 py-2 rounded-pill fw-900" style="font-size: 12px; border: 1.5px solid var(--tripzant-dark);"><i class="fas fa-print me-1"></i> E-TICKET</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Settlement Sidebar -->
        <div class="col-lg-4">
            <div class="sidebar-premium">
                <h6 class="fw-900 text-muted mb-4" style="font-size: 13px; letter-spacing: 1.5px;">FINANCIAL SUMMARY</h6>
                
                <div class="fare-rows mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small fw-bold">Passenger Base Fare</span>
                        <span class="fw-bold">₹80,530</span>
                    </div>
                    <div id="seatBreakdown"></div>
                </div>

                <div class="total-paid-box p-4 rounded-4" style="background: var(--tripzant-dark);">
                    <div class="small fw-900 text-white opacity-50 mb-1">TOTAL TRANSACTION VALUE</div>
                    <h2 class="fw-900 text-white mb-3" id="finalTotal">₹0</h2>
                    
                    <div class="upi-seal mb-2">
                        <i class="fas fa-check-circle"></i> SECURED BY UPI GATEWAY
                    </div>
                    <!-- GST Info Placeholder -->
                    <div id="gstSummary" class="d-none">
                        <div class="mt-3 pt-3 border-top border-secondary text-white-50 x-small fw-bold">
                            <i class="fas fa-file-invoice me-1"></i> GSTIN: <span id="gstinVal" class="text-white"></span><br>
                            <span id="gstCompVal" class="text-white"></span>
                        </div>
                    </div>
                </div>

                <div class="mt-5 d-grid gap-3">
                    <a href="/enhance-trip" class="action-btn-main text-center text-white text-decoration-none">
                        ENHANCE YOUR TRIP <i class="fas fa-magic ms-2"></i>
                    </a>
                    <div class="d-flex gap-2">
                        <a href="/" class="btn btn-light-outline w-50 py-3 fw-900 small" style="border:1px solid #ddd;">NEW BOOKING</a>
                        <a href="/dashboard" class="btn btn-light-outline w-50 py-3 fw-900 small" style="border:1px solid #ddd;">DASHBOARD</a>
                    </div>
                </div>
                
                <div class="mt-4 p-4 rounded-4 bg-light border-start border-4 border-primary">
                    <h6 class="fw-900 mb-1">E-Ticket Sent!</h6>
                    <p class="small text-muted mb-0">We've sent a PDF copy to your primary email address.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const bookingData = JSON.parse(localStorage.getItem('last_booking_result') || 'null');
        
        if (!bookingData) {
            // If No data, maybe it's a test view, show fallback or redirect
            console.log("No dynamic booking data found, showing demo state.");
            return;
        }

        const { pnr, flight, travelers } = bookingData;
        const manifest = document.getElementById('manifestGrid');
        
        // Update PNR
        document.getElementById('pnrDisplay').innerText = pnr;
        
        // Update Flight Card
        if(flight) {
            document.querySelector('.ticket-glass-card h6').innerText = `${flight.airline} Flight ${flight.flight_no || ''}`;
            const iataCodes = document.querySelectorAll('.iata-code');
            const cityNames = document.querySelectorAll('.city-name');
            const times = document.querySelectorAll('.small.fw-bold.text-muted');

            if(iataCodes.length >= 2) {
                iataCodes[0].innerText = flight.dep_city;
                iataCodes[1].innerText = flight.arr_city;
            }
            if(cityNames.length >= 2) {
                cityNames[0].innerText = flight.dep_city;
                cityNames[1].innerText = flight.arr_city;
            }
            if(times.length >= 2) {
                times[0].innerText = `Departure Time: ${flight.dep_time}`;
                times[1].innerText = `Arrival Time: ${flight.arr_time}`;
            }
            
            // Total Price calc
            const perPerson = parseFloat(flight.price) || 0;
            const finalTotal = perPerson * travelers.length;
            document.querySelector('.fare-rows span:last-child').innerText = '₹' + finalTotal.toLocaleString('en-IN');
            document.getElementById('finalTotal').innerText = '₹' + finalTotal.toLocaleString('en-IN');
        }

        // Update Travelers Manifest
        if (travelers && travelers.length > 0) {
            manifest.innerHTML = travelers.map((p, index) => `
                <div class="col-md-6">
                    <div class="pax-manifest-token">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="badge bg-navy-light text-navy fw-900" style="background:#e0f2fe; color:#0369a1;">PASSENGER ${index+1}</span>
                            <div class="d-flex gap-2">
                                <span class="fw-900 text-primary">SEAT ASSIGNED</span>
                            </div>
                        </div>
                        <h6 class="fw-900 text-navy mb-1">${p.first_name || 'Traveler'} ${p.last_name || ''}</h6>
                        <div class="small fw-bold opacity-40">Contact: ${p.email || 'N/A'} | ID: ${p.passport || p.id_type || 'Verified'}</div>
                    </div>
                </div>
            `).join('');
        }

        // Notification Simulation
        setTimeout(() => {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Data Synchronized!',
                text: 'Your live booking is ready.',
                showConfirmButton: false,
                timer: 3000
            });
        }, 1000);
    });

    window.copyPNR = function() {
        const pnr = document.getElementById('pnrDisplay').innerText;
        navigator.clipboard.writeText(pnr);
        Swal.fire({
            title: 'Copied!',
            text: 'PNR copied to clipboard.',
            icon: 'success',
            timer: 1500,
            showConfirmButton: false
        });
    }
</script>
@endsection
