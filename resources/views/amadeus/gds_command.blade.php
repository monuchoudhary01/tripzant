@extends('layouts.b2b_master')

@section('title', 'GDS Command Center | Amadeus Partner Panel')

@section('styles')
<style>
    .gds-terminal {
        background: #091e42;
        border-radius: 12px;
        padding: 25px;
        font-family: 'Courier New', Courier, monospace;
        color: #00d9ff;
        box-shadow: inset 0 0 20px rgba(0, 0, 0, 0.5);
        min-height: 300px;
        position: relative;
    }
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 outfit text-uppercase ls-1">Robotic GDS Operations Suite</h4>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-success rounded-pill" style="width: 8px; height: 8px; padding: 0;"></span>
            <p class="text-muted small mb-0 fw-600 uppercase" style="font-size: 10px;">Office ID: DEL1A21RT | Connection: Active (GDS-PROD-AM)</p>
        </div>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-danger btn-sm px-4 fw-700 bg-white shadow-sm border-0"><i class="fas fa-power-off me-2"></i> TERMINATE SESSION</button>
        <button class="btn btn-primary btn-sm px-4 fw-700 shadow-b2b"><i class="fas fa-keyboard me-2"></i> HOTKEYS</button>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-xl-8">
        <div class="b2b-table-card border-0 shadow-lg" style="background: #091e42; color: #fff; border-radius: 16px; overflow: hidden;">
            <div class="p-2 border-bottom border-secondary border-opacity-25 d-flex gap-2 px-4 shadow-sm" style="background: rgba(255,255,255,0.05);">
                <div class="bg-danger rounded-circle" style="width: 10px; height: 10px;"></div>
                <div class="bg-warning rounded-circle" style="width: 10px; height: 10px;"></div>
                <div class="bg-success rounded-circle" style="width: 10px; height: 10px;"></div>
                <div class="ms-auto text-white-50 tiny fw-700 uppercase ls-1" style="font-size: 9px;">AMADEUS CONNECT V4.0 (ACTIVE-TERM-1)</div>
            </div>
            <div class="p-4">
                <div class="gds-terminal mb-3" style="min-height: 450px;">
                    <div id="terminalOutput">
                        <div class="text-white-50 opacity-50 mb-1" style="font-size: 12px;"># SYSTEM READY - BOOT COMPLETED AT 2024-04-07 15:45:10 Z</div>
                        <div class="text-white-50 opacity-50 mb-3" style="font-size: 12px;"># SESSION AUTHENTICATED VIA OFFICE DEL1A21RT (GDS-AMADEUS)</div>
                        
                        <div class="mb-3">
                            <span class="text-warning fw-600">TRIPZANT_GDS_ADMIN></span> <span class="text-info">AN12DECDELDXB</span>
                            <div class="mt-2 text-white-50 ps-3" style="font-size: 13px; line-height: 1.6;">
                                AN 12DEC DEL DXB/A-EK/S-Y/C-5<br>
                                LH 0412 12DEC DEL FRA 1245 1730 &nbsp;74H 0 /E<br>
                                EK 0511 12DEC DEL DXB 1030 1315 &nbsp;380 0 /E<br>
                                AI 0991 12DEC DEL DXB 1945 2210 &nbsp;788 0 /E
                            </div>
                        </div>

                         <div class="mb-3">
                            <span class="text-warning fw-600">TRIPZANT_GDS_ADMIN></span> <span class="text-info">RTXY78WQ</span>
                            <div class="mt-2 text-white-50 ps-3 font-monospace" style="font-size: 13px; line-height: 1.6;">
                                XY78WQ - AMADEUS PNR DETAILS<br>
                                1.SMITH/JOHN MR<br>
                                2 EK 0511 Y 12DEC DELDXB HK1 1030 1315<br>
                                3 AP DEL +91 9988776655 - AMADEUS GSA<br>
                                4 TK OK07APR/DEL1A21RT
                            </div>
                        </div>
                        
                        <div id="activeCommandCursor" class="d-flex align-items-center gap-2">
                             <span class="text-warning fw-600">TRIPZANT_GDS_ADMIN></span>
                             <span class="bg-info" style="width: 8px; height: 18px; display: inline-block; animation: blink 1s infinite;"></span>
                        </div>
                    </div>
                </div>
                
                <div class="input-group">
                    <span class="input-group-text border-0 text-white-50 px-3" style="background: rgba(255,255,255,0.1); border-radius: 8px 0 0 8px;">></span>
                    <input type="text" class="form-control border-0 text-white font-monospace" placeholder="TYPE COMMAND (E.G. AN12DEC...)" style="background: rgba(255,255,255,0.1); border-radius: 0 8px 8px 0; outline: none !important; box-shadow: none;">
                    <button class="btn btn-primary px-4 ms-3 fw-800 uppercase" style="border-radius: 10px; font-size: 12px; letter-spacing: 1px;">EXECUTE COMMAND</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-4">
        <div class="b2b-table-card p-4">
             <h6 class="fw-800 ls-1 uppercase text-navy border-bottom pb-3 mb-4"><i class="fas fa-microchip me-2 text-primary"></i> GDS Robotic Insights</h6>
             <div class="d-flex flex-column gap-3">
                <div class="p-3 bg-light rounded-3 d-flex align-items-start gap-3 border border-secondary border-opacity-10 shadow-sm transition-all hover-translate-right">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px; font-size: 12px;"><i class="fas fa-brain"></i></div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <div class="fw-800 uppercase" style="font-size: 10px; letter-spacing: 0.5px;">Fare Optimizer</div>
                            <span class="badge bg-success-subtle text-success tiny fw-800">SCANNING</span>
                        </div>
                        <div class="fw-600" style="font-size: 13px;">Auto-Robotic Scan Active</div>
                        <div class="text-muted tiny mt-1">Scanning 42 PNRs for cheaper availability on active routes.</div>
                    </div>
                </div>

                <div class="p-3 bg-light rounded-3 d-flex align-items-start gap-3 border border-secondary border-opacity-10 shadow-sm transition-all hover-translate-right">
                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px; font-size: 12px;"><i class="fas fa-sync"></i></div>
                    <div class="flex-grow-1">
                         <div class="d-flex justify-content-between align-items-center mb-1">
                            <div class="fw-800 uppercase" style="font-size: 10px; letter-spacing: 0.5px;">Auto Re-Ticketing</div>
                            <span class="badge bg-warning-subtle text-warning tiny fw-800">IDLE</span>
                        </div>
                        <div class="fw-600" style="font-size: 13px;">Queue Sync Frequency</div>
                        <div class="text-muted tiny mt-1">Current Sync interval: 45 seconds via Robotic Server #2.</div>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="bg-navy p-4 rounded-4 text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #091e42 0%, #172b4d 100%);">
                        <div class="position-absolute opacity-10 end-0 bottom-0 mb-n4 me-n4">
                             <i class="fas fa-terminal fa-8x rotate-12"></i>
                        </div>
                        <h6 class="fw-700 mb-2">Amadeus GDS Pro-Term</h6>
                        <p class="text-white-50 small mb-4">Direct access to Amadeus Global core with TRIPZANT robotic wrapper.</p>
                        <button class="btn btn-info btn-sm w-100 fw-800 rounded-3 border-0 py-2 shadow-sm" style="font-size: 11px;">GET ADVANCED TUTORIAL</button>
                    </div>
                </div>
             </div>
        </div>
    </div>
</div>
<style>
    @keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0; } }
    .ls-1 { letter-spacing: 1px; }
    .tiny { font-size: 11px !important; }
    .hover-translate-right:hover { transform: translateX(5px); }
</style>
@endsection
