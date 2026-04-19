<div id="aiSearchOverlay" class="ai-search-overlay">
    <div class="ai-search-container">
        <!-- Close Button -->
        <button class="ai-close-btn" onclick="toggleAISearch(false)">
            <i class="fas fa-times"></i>
        </button>

        <!-- Sidebar / Recent Conversations -->
        <div class="ai-sidebar">
            <div class="ai-logo-wrap">
                <span class="ai-logo-text">myra.AI <span class="beta-tag">beta</span></span>
            </div>
            
            <div class="recent-convos">
                <div class="recent-title"><i class="fas fa-history"></i> Recent Conversations</div>
                <div class="recent-item active">
                    <div class="recent-icon"><i class="fas fa-robot"></i></div>
                    <div class="recent-info">
                        <h6>Jaipur to Delhi Travel</h6>
                        <span>jaipur to delhi</span>
                    </div>
                    <div class="recent-time">12:11 PM</div>
                </div>
                <div class="recent-item">
                    <div class="recent-icon"><i class="fas fa-hotel"></i></div>
                    <div class="recent-info">
                        <h6>Hotels in Mumbai</h6>
                        <span>luxury hotels mumbai</span>
                    </div>
                    <div class="recent-time">Yesterday</div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="ai-main-content">
            <div id="aiWelcomeSection" class="ai-welcome">
                <h1 class="ai-greeting">Hi, <span class="highlight-blue">Monu</span></h1>
                <h2 class="ai-intro">I'm Myra — your personal travel assistant.</h2>
                <p class="ai-subtext">Let's plan your next trip together.</p>
            </div>

            <!-- Search Bar (The one from Image 2) -->
            <div class="ai-search-bar-wrapper">
                <div class="ai-search-bar">
                    <input type="text" id="aiSearchInput" placeholder="Where do you want to go?" onkeypress="handleAISearch(event)">
                    <div class="ai-sparkle-icon">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 3L14.5 9L21 11.5L14.5 14L12 20L9.5 14L3 11.5L9.5 9L12 3Z" fill="currentColor"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Results Section -->
            <div id="aiResultsSection" class="ai-results-container" style="display: none;">
                <div class="results-header-flex">
                    <div class="route-header">
                        <div class="route-main">
                            <span class="bus-icon-circle"><i class="fas fa-bus"></i></span>
                            <h2>Jaipur <i class="fas fa-arrow-right"></i> Delhi</h2>
                        </div>
                        <p class="travel-date">15th Apr</p>
                    </div>
                    <a href="#" class="view-all-link">View All <i class="fas fa-chevron-right"></i></a>
                </div>
                
                <div class="seats-badge-container">
                    <span class="seats-left-badge">41 seats left</span>
                </div>

                <!-- Premium Bus Card -->
                <div class="premium-bus-card">
                    <button class="bookmark-btn"><i class="far fa-bookmark"></i></button>
                    
                    <div class="bus-header">
                        <div class="bus-img-wrap">
                            <img src="https://img.icons8.com/color/96/bus.png" alt="bus">
                        </div>
                        <div class="bus-main-info">
                            <h3 class="bus-name">Goldline Super Deluxe</h3>
                            <div class="bus-meta">
                                <span class="rating"><i class="fas fa-star"></i> 4.8 <span>(498)</span></span>
                                <span class="separator">|</span>
                                <span class="bus-type">Volvo Multi-Axle A/C se...</span>
                            </div>
                        </div>
                    </div>

                    <div class="travel-timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker">
                                <i class="far fa-circle"></i>
                                <div class="timeline-line"></div>
                            </div>
                            <div class="timeline-content">
                                <span class="location">Jaipur</span>
                                <span class="time">10:45 PM</span>
                            </div>
                        </div>
                        
                        <div class="timeline-duration">
                            <span>5 Hours 5 minutes</span>
                        </div>

                        <div class="timeline-item">
                            <div class="timeline-marker">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="timeline-content">
                                <span class="location">Delhi</span>
                                <span class="time">03:50 AM</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer-action">
                        <div class="price-starting">
                            Prices starting at <span class="amount">₹ 350</span>
                        </div>
                        <i class="fas fa-chevron-right action-arrow"></i>
                    </div>
                </div>

                <!-- Horizontal scroll suggestion or more cards -->
                <div class="more-suggestions">
                    <div class="suggest-next"><i class="fas fa-chevron-right"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Floating Trigger Button (Optional) -->
<div class="ai-trigger-fab" onclick="toggleAISearch(true)">
    <div class="ai-sparkle">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 3L14.5 9L21 11.5L14.5 14L12 20L9.5 14L3 11.5L9.5 9L12 3Z" fill="currentColor"/>
        </svg>
    </div>
    <span>Ask Myra AI</span>
</div>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap');

:root {
    --ai-font-main: 'Inter', sans-serif;
    --ai-font-head: 'Outfit', sans-serif;
    --ai-primary: #3b82f6;
    --ai-primary-glow: rgba(59, 130, 246, 0.5);
    --ai-bg: #ffffff;
    --ai-sidebar-bg: #f8fafc;
    --ai-text-dark: #1e293b;
    --ai-text-muted: #64748b;
}

.ai-search-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.4);
    backdrop-filter: blur(8px);
    z-index: 9999;
    display: none;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.ai-search-overlay.active {
    display: flex;
    opacity: 1;
}

.ai-search-container {
    width: 90%;
    max-width: 1000px;
    height: 80vh;
    background: var(--ai-bg);
    border-radius: 30px;
    display: flex;
    overflow: hidden;
    position: relative;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    transform: translateY(20px);
    transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    font-family: var(--ai-font-main);
}

.ai-search-overlay.active .ai-search-container {
    transform: translateY(0);
}

.ai-close-btn {
    position: absolute;
    top: 20px;
    right: 20px;
    background: #f1f5f9;
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 10;
    transition: all 0.2s;
}

.ai-close-btn:hover {
    background: #e2e8f0;
    transform: rotate(90deg);
}

/* Sidebar */
.ai-sidebar {
    width: 300px;
    background: var(--ai-sidebar-bg);
    border-right: 1px solid #e2e8f0;
    padding: 30px;
    display: flex;
    flex-direction: column;
}

.ai-logo-text {
    font-size: 24px;
    font-weight: 800;
    color: var(--ai-primary);
    font-family: 'Outfit', sans-serif;
    letter-spacing: -0.5px;
}

.beta-tag {
    font-size: 10px;
    vertical-align: super;
    background: #dbeafe;
    color: var(--ai-primary);
    padding: 2px 6px;
    border-radius: 4px;
    font-weight: 700;
}

.recent-convos {
    margin-top: 40px;
}

.recent-title {
    font-weight: 700;
    color: var(--ai-text-muted);
    font-size: 13px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.recent-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    border-radius: 16px;
    cursor: pointer;
    transition: all 0.2s;
    margin-bottom: 8px;
}

.recent-item:hover {
    background: #f1f5f9;
}

.recent-item.active {
    background: #ffffff;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.recent-icon {
    width: 40px;
    height: 40px;
    background: #eff6ff;
    color: var(--ai-primary);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

.recent-info h6 {
    margin: 0;
    font-weight: 700;
    font-size: 14px;
    color: var(--ai-text-dark);
}

.recent-info span {
    font-size: 12px;
    color: var(--ai-text-muted);
}

.recent-time {
    margin-left: auto;
    font-size: 11px;
    color: var(--ai-text-muted);
}

/* Main Content */
.ai-main-content {
    flex: 1;
    padding: 50px;
    display: flex;
    flex-direction: column;
    overflow-y: auto;
}

.ai-greeting {
    font-size: 48px;
    font-weight: 800;
    margin-bottom: 10px;
    color: var(--ai-text-dark);
}

.highlight-blue {
    color: var(--ai-primary);
}

.ai-intro {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 5px;
    color: var(--ai-text-dark);
}

.ai-subtext {
    color: var(--ai-text-muted);
    font-size: 18px;
}

/* Search Bar (Image 2 Style) */
.ai-search-bar-wrapper {
    margin-top: 40px;
    position: relative;
    z-index: 5;
}

.ai-search-bar {
    background: #ffffff;
    border: 2px solid #e2e8f0;
    border-radius: 20px;
    padding: 15px 25px;
    display: flex;
    align-items: center;
    gap: 15px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
}

.ai-search-bar:focus-within {
    border-color: var(--ai-primary);
    box-shadow: 0 0 0 4px var(--ai-primary-glow), 0 10px 30px rgba(59, 130, 246, 0.2);
    transform: translateY(-2px);
}

.ai-search-bar input {
    flex: 1;
    border: none;
    outline: none;
    font-size: 18px;
    font-weight: 500;
    color: var(--ai-text-dark);
}

.ai-sparkle-icon {
    color: var(--ai-primary);
    width: 24px;
    height: 24px;
    animation: sparkle-float 2s infinite ease-in-out;
}

@keyframes sparkle-float {
    0%, 100% { transform: scale(1) rotate(0deg); }
    50% { transform: scale(1.2) rotate(15deg); }
}

/* Results Section (Image 0 Style) */
.ai-results-container {
    margin-top: 40px;
    animation: fadeInUp 0.5s ease;
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.results-header h3 {
    font-size: 18px;
    font-weight: 800;
    color: var(--ai-text-dark);
    margin-bottom: 20px;
}

/* Results Section Header */
.results-header-flex {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 25px;
    padding-bottom: 10px;
}

.route-main {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 5px;
}

.bus-icon-circle {
    width: 32px;
    height: 32px;
    background: #eff6ff;
    color: var(--ai-primary);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
}

.route-main h2 {
    font-size: 24px;
    font-weight: 800;
    color: var(--ai-text-dark);
    margin: 0;
}

.route-main i {
    font-size: 18px;
    color: #94a3b8;
    margin: 0 5px;
}

.travel-date {
    font-size: 18px;
    font-weight: 700;
    color: var(--ai-text-dark);
    margin: 0;
}

.view-all-link {
    color: #3b82f6;
    font-weight: 700;
    text-decoration: none;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.seats-badge-container {
    margin-bottom: -15px;
    position: relative;
    z-index: 2;
    display: flex;
    justify-content: center;
}

.seats-left-badge {
    background: #fff1f2;
    color: #e11d48;
    padding: 4px 16px;
    border-radius: 100px;
    font-size: 12px;
    font-weight: 700;
    border: 1px solid #fecdd3;
    box-shadow: 0 2px 4px rgba(225, 29, 72, 0.1);
}

/* Premium Bus Card */
.premium-bus-card {
    background: #ffffff;
    border-radius: 24px;
    padding: 24px;
    position: relative;
    border: 1px solid #f1f5f9;
    box-shadow: 0 10px 30px -10px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}

.premium-bus-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px -12px rgba(0,0,0,0.12);
}

.bookmark-btn {
    position: absolute;
    top: 24px;
    right: 24px;
    background: none;
    border: none;
    color: #94a3b8;
    font-size: 18px;
    cursor: pointer;
    transition: color 0.2s;
}

.bookmark-btn:hover {
    color: var(--ai-primary);
}

.bus-header {
    display: flex;
    gap: 16px;
    margin-bottom: 24px;
}

.bus-img-wrap {
    width: 60px;
    height: 60px;
    background: #f8fafc;
    border-radius: 16px;
    padding: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.bus-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.bus-name {
    font-size: 18px;
    font-weight: 800;
    color: var(--ai-text-dark);
    margin: 0 0 6px 0;
}

.bus-meta {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: #64748b;
}

.rating {
    display: flex;
    align-items: center;
    gap: 4px;
    color: #059669;
    font-weight: 800;
}

.rating i {
    font-size: 12px;
}

.rating span {
    color: #64748b;
    font-weight: 500;
}

.separator {
    color: #e2e8f0;
}

/* Timeline */
.travel-timeline {
    padding: 0 10px;
    margin-bottom: 24px;
}

.timeline-item {
    display: flex;
    gap: 16px;
}

.timeline-marker {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 20px;
}

.timeline-marker i {
    font-size: 14px;
    color: #94a3b8;
    background: #fff;
    z-index: 1;
}

.timeline-marker i.fa-map-marker-alt {
    color: #059669;
}

.timeline-line {
    width: 1px;
    height: 40px;
    border-left: 1px dashed #cbd5e1;
    margin: 4px 0;
}

.timeline-content {
    display: flex;
    flex-direction: column;
    padding-top: 0;
}

.timeline-content .location {
    font-size: 14px;
    color: #64748b;
    margin-bottom: 2px;
}

.timeline-content .time {
    font-size: 16px;
    font-weight: 800;
    color: var(--ai-text-dark);
}

.timeline-duration {
    margin: 10px 0 10px 36px;
    font-size: 14px;
    color: #64748b;
    font-weight: 500;
}

/* Card Footer */
.card-footer-action {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 20px;
    border-top: 1px solid #f1f5f9;
}

.price-starting {
    font-size: 15px;
    color: #64748b;
    font-weight: 600;
}

.price-starting .amount {
    color: #3b82f6;
    font-weight: 800;
    font-size: 18px;
    margin-left: 4px;
}

.action-arrow {
    color: #3b82f6;
    font-size: 14px;
}

.more-suggestions {
    display: flex;
    justify-content: flex-end;
    margin-top: -100px;
    margin-right: -20px;
    position: relative;
    z-index: 5;
    pointer-events: none;
}

.suggest-next {
    width: 48px;
    height: 48px;
    background: #ffffff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #3b82f6;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    cursor: pointer;
    pointer-events: auto;
    border: 1px solid #f1f5f9;
}

/* Floating FAB */
.ai-trigger-fab {
    position: fixed;
    bottom: 30px;
    right: 30px;
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
    padding: 15px 25px;
    border-radius: 100px;
    box-shadow: 0 10px 25px rgba(37, 99, 235, 0.4);
    display: flex;
    align-items: center;
    gap: 12px;
    cursor: pointer;
    z-index: 1000;
    transition: all 0.3s;
    font-weight: 700;
}

.ai-trigger-fab:hover {
    transform: scale(1.05) translateY(-5px);
    box-shadow: 0 15px 30px rgba(37, 99, 235, 0.5);
}

.ai-sparkle {
    width: 20px;
    height: 20px;
}
</style>

<script>
function toggleAISearch(show) {
    const overlay = document.getElementById('aiSearchOverlay');
    if (show) {
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
        setTimeout(() => {
            document.getElementById('aiSearchInput').focus();
        }, 300);
    } else {
        overlay.classList.remove('active');
        document.body.style.overflow = 'auto';
    }
}

function handleAISearch(event) {
    if (event.key === 'Enter') {
        const query = event.target.value.toLowerCase();
        const searchInput = event.target;
        
        // Add a "thinking" state
        searchInput.disabled = true;
        searchInput.parentElement.style.opacity = '0.7';
        searchInput.placeholder = "Myra is searching...";
        
        // More robust query matching
        const triggers = ['jaipur to delhi', 'jaipur se delhi', 'jaipur to dlhi', 'jaipur delhi'];
        const isMatch = triggers.some(t => query.includes(t));

        setTimeout(() => {
            if (isMatch) {
                showAIResults();
            } else {
                searchInput.disabled = false;
                searchInput.parentElement.style.opacity = '1';
                searchInput.placeholder = "Try 'Jaipur to Delhi'";
            }
        }, 800);
    }
}

function showAIResults() {
    const welcome = document.getElementById('aiWelcomeSection');
    const results = document.getElementById('aiResultsSection');
    const searchBar = document.querySelector('.ai-search-bar-wrapper');
    
    // Smooth transition
    welcome.style.transition = 'all 0.4s ease';
    welcome.style.opacity = '0';
    welcome.style.transform = 'translateY(-20px)';
    
    searchBar.style.transition = 'all 0.4s ease';
    searchBar.style.transform = 'translateY(-20px)';
    
    setTimeout(() => {
        welcome.style.display = 'none';
        results.style.display = 'block';
        results.style.opacity = '0';
        results.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            results.style.transition = 'all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
            results.style.opacity = '1';
            results.style.transform = 'translateY(0)';
        }, 50);
    }, 400);
}
</script>
