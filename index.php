<?php
/**
 * SHAIKH EMPIRE - ULTRA LUXURY REAL ESTATE LANDING PAGE
 * Developer: Shaikh Group / Shaikh Empire Developers
 * Location: Kharghar Crown, Navi Mumbai
 * Connected to MySQL Database Lead Registry
 */

require_once __DIR__ . '/config/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shaikh Empire | Ultra Luxury Palatial Living | G+52 Iconic Towers Kharghar Navi Mumbai</title>
  <meta name="description" content="Shaikh Empire - An imperial 25+ acre mega-township featuring 6 palatial G+52 storey towers inspired by the world's greatest royal empires and modern skyscraper architecture. 2, 3, 4 & 5 BHK Sky Villas.">
  <meta name="keywords" content="Shaikh Empire, Luxury Apartments Navi Mumbai, Kharghar luxury homes, G+52 Towers, Club Sultanate, 2 BHK, 3 BHK, 4 BHK, 5 BHK Sky Villa">

  <!-- Favicon -->
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>👑</text></svg>">

  <!-- Google Fonts: Cinzel, Playfair Display & Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800;900&family=Playfair+Display:ital,wght@0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Font Awesome 6 Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <!-- Custom Stylesheet -->
  <link rel="stylesheet" href="assets/css/styles.css?v=<?= time() ?>">
</head>
<body>

  <!-- Top Announcement Bar -->
  <div class="top-bar">
    <div class="container top-bar-content">
      <div class="top-bar-badge">
        <i class="fas fa-crown"></i>
        <span>Exclusive Sovereign Privileges Now Open &bull; MahaRERA Reg. No: P52000049821</span>
      </div>
      <div class="top-bar-links">
        <a href="tel:+918104129866"><i class="fas fa-phone-alt"></i> VIP Sales: +91 81041 29866</a>
        <a href="https://wa.me/918104129866?text=Hello%20Shaikh%20Empire%20Concierge,%20I%20am%20interested%20in%20Shaikh%20Empire%20Kharghar" target="_blank"><i class="fab fa-whatsapp"></i> WhatsApp Concierge</a>
        <a href="admin/login.php" title="Staff &amp; Concierge Portal"><i class="fas fa-user-shield"></i> Admin Login</a>
      </div>
    </div>
  </div>

  <!-- Master Navigation -->
  <nav class="navbar" id="navbar">
    <div class="container nav-wrapper">
      <a href="#hero" class="nav-brand">
        <div class="brand-crest">
          <i class="fas fa-crown"></i>
        </div>
        <div class="brand-titles">
          <span class="brand-developer">SHAIKH GROUP</span>
          <span class="brand-name">SHAIKH EMPIRE</span>
          <span class="brand-location">KHARGHAR, NAVI MUMBAI</span>
        </div>
      </a>

      <ul class="nav-menu" id="navMenu">
        <li><a href="#hero" class="active">Home</a></li>
        <li><a href="#concept">The Concept</a></li>
        <li><a href="#towers">6 Iconic Towers</a></li>
        <li><a href="#residences">Residences</a></li>
        <li><a href="#club">Club Sultanate</a></li>
        <li><a href="#location">Location</a></li>
        <li><a href="#calculator">EMI Estimator</a></li>
        <li><a href="#enquiry">VIP Enquiry</a></li>
      </ul>

      <div class="nav-actions">
        <a href="#enquiry" class="btn btn-gold btn-sm" data-open-modal="vipTourModal">
          <i class="fas fa-calendar-check"></i> Book VIP Visit
        </a>
        <button class="hamburger-btn" id="hamburgerBtn" aria-label="Toggle navigation">
          <i class="fas fa-bars"></i>
        </button>
      </div>
    </div>
  </nav>

  <!-- Hero Section with Slideshow & Sticky Lead Form -->
  <section class="hero" id="hero">
    <div class="hero-slider-bg">
      <div class="hero-slide active" style="background-image: url('https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=1920&q=80');"></div>
      <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1580674684081-7617fbf3d745?auto=format&fit=crop&w=1920&q=80');"></div>
      <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=1920&q=80');"></div>
      <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=1920&q=80');"></div>
    </div>
    <div class="hero-overlay"></div>

    <div class="container hero-content">
      <div class="hero-text">
        <div class="section-tag">
          <i class="fas fa-gem"></i> The Imperial Crest of Living
        </div>

        <h1 class="hero-title">
          WHERE ROYAL HERITAGE <br>
          <span class="gold-text">MEETS MODERN SUPREMACY</span>
        </h1>

        <p class="hero-desc">
          Inspired by the glorious architecture of history's greatest world empires and Dubai's iconic modern skyscrapers.
          Spread across <strong>25+ sprawling acres</strong> with <strong>6 iconic G+52 storey towers</strong>,
          featuring the palatial <strong>85,000 sq. ft. Club Sultanate</strong> in the prime heart of Kharghar, Navi Mumbai.
        </p>

        <div class="hero-chips">
          <div class="hero-chip">
            <i class="fas fa-building"></i>
            <span><strong>6 Majestic Towers</strong> (G+52 Storeys)</span>
          </div>
          <div class="hero-chip">
            <i class="fas fa-home"></i>
            <span><strong>2, 3, 4 &amp; 5 BHK</strong> Palatial Suites</span>
          </div>
          <div class="hero-chip">
            <i class="fas fa-swimming-pool"></i>
            <span><strong>85,000 Sq. Ft.</strong> Club Sultanate</span>
          </div>
          <div class="hero-chip">
            <i class="fas fa-tag"></i>
            <span>Starting at <strong>₹ 1.95 Cr*</strong> All-Inclusive</span>
          </div>
        </div>

        <div class="hero-buttons">
          <a href="#enquiry" class="btn btn-gold" data-open-modal="vipTourModal">
            <i class="fas fa-car-side"></i> Schedule Chauffeured Visit
          </a>
          <a href="#residences" class="btn btn-outline-gold">
            <i class="fas fa-compass"></i> Explore Floor Blueprints
          </a>
        </div>
      </div>

      <!-- Quick Lead Capture Form (Direct to MySQL Database) -->
      <div class="hero-booking-card">
        <h3><i class="fas fa-shield-alt text-gold"></i> VIP Direct Booking</h3>
        <p>Register with Shaikh Empire concierge to unlock private pre-launch pricing and chauffeured site visits.</p>

        <form class="luxury-form" data-ajax-form="enquiry">
          <input type="text" name="website_hp" style="display:none;" tabindex="-1" autocomplete="off">
          <input type="hidden" name="property_name" value="Shaikh Empire">

          <div class="form-group">
            <label><i class="fas fa-user"></i> Full Name *</label>
            <input type="text" name="full_name" class="form-control" placeholder="e.g. Tariq Al-Mansoor" required>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label><i class="fas fa-phone-alt"></i> Mobile Number *</label>
              <input type="tel" name="phone" class="form-control" placeholder="10-digit number" required>
            </div>
            <div class="form-group">
              <label><i class="fas fa-envelope"></i> Email Address *</label>
              <input type="email" name="email" class="form-control" placeholder="name@domain.com" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label><i class="fas fa-bed"></i> Configuration *</label>
              <select name="configuration" class="form-control" required>
                <option value="2 BHK Royal Suite">2 BHK Royal Suite (₹ 1.95 Cr*)</option>
                <option value="3 BHK Imperial Suite" selected>3 BHK Imperial Suite (₹ 2.85 Cr*)</option>
                <option value="4 BHK Emperor Penthouse">4 BHK Emperor Penthouse (₹ 4.50 Cr*)</option>
                <option value="5 BHK Presidential Sky Villa">5 BHK Presidential Sky Villa (₹ 7.90 Cr*)</option>
              </select>
            </div>
            <div class="form-group">
              <label><i class="fas fa-calendar-alt"></i> Preferred Visit Date</label>
              <input type="date" name="visit_date" class="form-control" min="<?= date('Y-m-d') ?>">
            </div>
          </div>

          <label class="form-checkbox">
            <input type="checkbox" name="chauffeured_pickup" value="Yes" checked>
            <span><i class="fas fa-car"></i> Request Complimentary Chauffeured Luxury Pickup</span>
          </label>

          <button type="submit" class="btn btn-gold" style="width: 100%;">
            <i class="fab fa-whatsapp"></i> Submit Enquiry on WhatsApp
          </button>

          <div class="form-privacy-note">
            <i class="fas fa-shield-alt text-gold"></i> 100% Confidential &bull; Instant Confirmation on WhatsApp (+91 81041 29866)
          </div>
        </form>
      </div>
    </div>
  </section>

  <!-- The Imperial Concept & 4 Eras -->
  <section class="section-padding" id="concept">
    <div class="container">
      <div class="text-center">
        <div class="section-tag"><i class="fas fa-landmark"></i> The Imperial Heritage</div>
        <h2 class="section-title">INSPIRED BY THE WORLD'S <span class="gold-text">GREATEST ROYAL ERAS</span></h2>
        <p class="section-desc">
          Shaikh Empire seamlessly fuses the timeless majesty of world empires with cutting-edge 21st-century modern skyscraper engineering.
        </p>
      </div>

      <div class="empires-grid">
        <div class="empire-card">
          <div class="empire-icon"><i class="fas fa-archway"></i></div>
          <h3>The Mughal &amp; Ottoman Era</h3>
          <p>
            Grand reflection pools, intricate golden jali lattices, soaring imperial arched courtyards, and tranquil fragrant botanical gardens.
          </p>
        </div>

        <div class="empire-card">
          <div class="empire-icon"><i class="fas fa-monument"></i></div>
          <h3>The Roman &amp; Greek Classical</h3>
          <p>
            Fluted Corinthian columns, open-air Colosseum amphitheater, Olympian sporting arenas, and royal marble bath sanctuaries.
          </p>
        </div>

        <div class="empire-card">
          <div class="empire-icon"><i class="fas fa-chess-rook"></i></div>
          <h3>The French &amp; British Aristocracy</h3>
          <p>
            Versailles-inspired musical dancing fountains, private cigar and snooker gentlemen’s clubs, and aristocratic high-tea sundecks.
          </p>
        </div>

        <div class="empire-card">
          <div class="empire-icon"><i class="fas fa-city"></i></div>
          <h3>The Modern Skyscraper Era</h3>
          <p>
            Burj Khalifa scale 52-storey aerodynamic silhouettes, 360° glass sky observatories, private rooftop helipad, and 6 m/s high-speed lifts.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- 6 Iconic Towers Showcase -->
  <section class="section-padding" id="towers" style="background: rgba(14, 18, 26, 0.6);">
    <div class="container">
      <div class="text-center">
        <div class="section-tag"><i class="fas fa-building"></i> The Sovereign Skyline</div>
        <h2 class="section-title">6 MAJESTIC <span class="gold-text">G+52 STOREY TOWERS</span></h2>
        <p class="section-desc">
          Engineered to touch the clouds. Each tower is a sovereign landmark offering majestic panoramic vistas and private luxury lobbies.
        </p>
      </div>

      <div class="towers-wrapper">
        <div class="towers-nav">
          <button class="tower-tab-btn active" data-tower="sultan">
            <div>
              <strong>Tower Sultan</strong>
              <span>The Sovereign Landmark</span>
            </div>
            <i class="fas fa-chevron-right"></i>
          </button>

          <button class="tower-tab-btn" data-tower="shehanshah">
            <div>
              <strong>Tower Shehanshah</strong>
              <span>Emperor of Modern Luxury</span>
            </div>
            <i class="fas fa-chevron-right"></i>
          </button>

          <button class="tower-tab-btn" data-tower="badshah">
            <div>
              <strong>Tower Badshah</strong>
              <span>Architectural Supremacy</span>
            </div>
            <i class="fas fa-chevron-right"></i>
          </button>

          <button class="tower-tab-btn" data-tower="nizam">
            <div>
              <strong>Tower Nizam</strong>
              <span>Aristocratic Heritage</span>
            </div>
            <i class="fas fa-chevron-right"></i>
          </button>

          <button class="tower-tab-btn" data-tower="jahangir">
            <div>
              <strong>Tower Jahangir</strong>
              <span>Imperial Sky Sanctuary</span>
            </div>
            <i class="fas fa-chevron-right"></i>
          </button>

          <button class="tower-tab-btn" data-tower="royal_crown">
            <div>
              <strong>Tower Royal Crown</strong>
              <span>The Presidential Pinnacle</span>
            </div>
            <i class="fas fa-chevron-right"></i>
          </button>
        </div>

        <div class="tower-display-panel">
          <div class="tower-image-box">
            <img id="towerImg" src="https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=1200&q=80" alt="Tower Sultan">
          </div>

          <div class="tower-specs">
            <h3 id="towerName">Tower Sultan</h3>
            <div class="tower-specs-lead" id="towerTag">The Sovereign Landmark (G+52 Storeys)</div>

            <div class="specs-grid">
              <div class="spec-item">
                <div class="label">Elevation</div>
                <div class="value" id="towerHeight">G+52 Royal Storeys (210 Meters)</div>
              </div>
              <div class="spec-item">
                <div class="label">Signature View</div>
                <div class="value" id="towerView">Panoramic Arabian Sea &amp; Marina</div>
              </div>
              <div class="spec-item">
                <div class="label">High-Speed Lifts</div>
                <div class="value" id="towerLifts">6 Ultra High-Speed Private Elevators</div>
              </div>
              <div class="spec-item">
                <div class="label">Residences</div>
                <div class="value" id="towerResidences">Exclusive 3 &amp; 4 BHK Suites</div>
              </div>
            </div>

            <p style="font-size: 13.5px; color: var(--text-secondary); margin-bottom: 22px;" id="towerCurtain">
              Double-Glazed Soundproof Acoustic Glass Façade with wind-resistant aerodynamic structural engineering.
            </p>

            <a href="#enquiry" class="btn btn-gold" data-open-modal="vipTourModal">
              <i class="fas fa-file-pdf"></i> Download Tower Specifications
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Palatial Residences & Blueprints -->
  <section class="section-padding" id="residences">
    <div class="container">
      <div class="text-center">
        <div class="section-tag"><i class="fas fa-drafting-compass"></i> Architectural Blueprints</div>
        <h2 class="section-title">PALATIAL RESIDENCES &amp; <span class="gold-text">BLUEPRINTS</span></h2>
        <p class="section-desc">
          Crafted with 11.5-foot vaulted ceilings, Italian marble floors, and expansive sundecks designed for bespoke regal living.
        </p>
      </div>

      <div class="blueprints-tabs">
        <button class="blueprint-tab active" data-config="2bhk">2 BHK Royal Suite</button>
        <button class="blueprint-tab" data-config="3bhk">3 BHK Imperial Suite</button>
        <button class="blueprint-tab" data-config="4bhk">4 BHK Emperor Penthouse</button>
        <button class="blueprint-tab" data-config="5bhk">5 BHK Presidential Sky Villa</button>
      </div>

      <div class="blueprint-showcase">
        <div class="svg-plan-frame" id="svgPlanFrame">
          <!-- Rendered via JS -->
          <svg viewBox="0 0 500 350" width="100%" height="320" xmlns="http://www.w3.org/2000/svg">
            <rect x="10" y="10" width="480" height="330" fill="#0d111a" stroke="#d4af37" stroke-width="2" rx="8"/>
            <rect x="25" y="25" width="260" height="180" fill="#151b29" stroke="#997a15" stroke-dasharray="4"/>
            <text x="155" y="110" fill="#f5e6b3" font-size="14" font-weight="bold" text-anchor="middle">GRAND LIVING ROOM</text>
            <text x="155" y="130" fill="#8492a6" font-size="12" text-anchor="middle">14'0" x 22'6"</text>
            <rect x="25" y="215" width="260" height="60" fill="#192235" stroke="#38bdf8"/>
            <text x="155" y="250" fill="#38bdf8" font-size="12" text-anchor="middle">ROYAL SUNDECK (60 Sq.Ft.)</text>
            <rect x="295" y="25" width="180" height="140" fill="#151b29" stroke="#997a15" stroke-dasharray="4"/>
            <text x="385" y="90" fill="#f5e6b3" font-size="13" font-weight="bold" text-anchor="middle">MASTER SUITE</text>
            <text x="385" y="110" fill="#8492a6" font-size="11" text-anchor="middle">12'0" x 14'0"</text>
            <rect x="295" y="175" width="180" height="100" fill="#151b29" stroke="#997a15" stroke-dasharray="4"/>
            <text x="385" y="220" fill="#f5e6b3" font-size="13" font-weight="bold" text-anchor="middle">GUEST BEDROOM</text>
            <text x="385" y="240" fill="#8492a6" font-size="11" text-anchor="middle">11'0" x 12'0"</text>
            <rect x="25" y="285" width="160" height="45" fill="#1a202c" stroke="#997a15"/>
            <text x="105" y="312" fill="#d4af37" font-size="11" text-anchor="middle">DESIGNER KITCHEN</text>
            <rect x="195" y="285" width="280" height="45" fill="#131722" stroke="#997a15"/>
            <text x="335" y="312" fill="#f5e6b3" font-size="11" text-anchor="middle">ENTRANCE FOYER &amp; POWDER BATH</text>
          </svg>
        </div>

        <div class="blueprint-info">
          <h3 id="blueprintTitle">2 BHK Royal Suite</h3>
          <div class="section-tag" id="blueprintCarpet" style="margin-bottom: 12px;">880 - 920 Sq. Ft. Carpet Area</div>
          <div class="blueprint-price-tag" id="blueprintPrice">Starting from ₹ 1.95 Cr* (All Inclusive)</div>

          <ul class="blueprint-features-list" id="blueprintFeatures">
            <li><i class="fas fa-check-circle"></i> <span>Grand Living &amp; Dining Room with 60 sq.ft. Sundeck</span></li>
            <li><i class="fas fa-check-circle"></i> <span>Master Bedroom with Italian Marble Ensuite Bath</span></li>
            <li><i class="fas fa-check-circle"></i> <span>Gourmet Modular Kitchen with Utility Balcony</span></li>
            <li><i class="fas fa-check-circle"></i> <span>Vastu-Compliant East-West Oriented Entry</span></li>
            <li><i class="fas fa-check-circle"></i> <span>Smart Home Automation for Lighting &amp; AC</span></li>
          </ul>

          <a href="#enquiry" class="btn btn-gold" data-open-modal="vipTourModal">
            <i class="fas fa-phone-alt"></i> Enquire for Detailed Pricing
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- 85,000 Sq. Ft. Club Sultanate & Amenities -->
  <section class="section-padding" id="club" style="background: rgba(14, 18, 26, 0.6);">
    <div class="container">
      <div class="text-center">
        <div class="section-tag"><i class="fas fa-gem"></i> Palatial Club Privileges</div>
        <h2 class="section-title">85,000 SQ. FT. <span class="gold-text">CLUB SULTANATE</span></h2>
        <p class="section-desc">
          More than 50+ world-class lifestyle amenities reserved exclusively for the esteemed residents of Shaikh Empire.
        </p>
      </div>

      <div class="amenities-grid">
        <div class="amenity-card">
          <div class="amenity-icon"><i class="fas fa-swimming-pool"></i></div>
          <h4>Olympic Swimming Pool</h4>
          <p>Temperature-controlled infinity pool with underwater sound systems.</p>
        </div>

        <div class="amenity-card">
          <div class="amenity-icon"><i class="fas fa-spa"></i></div>
          <h4>Turkish Hamam Spa</h4>
          <p>Hydrotherapy jacuzzis, steam, sauna, and royal Ayurvedic massages.</p>
        </div>

        <div class="amenity-card">
          <div class="amenity-icon"><i class="fas fa-helicopter"></i></div>
          <h4>Private Helipad</h4>
          <p>Rooftop executive helipad on Tower Crown for quick airport charters.</p>
        </div>

        <div class="amenity-card">
          <div class="amenity-icon"><i class="fas fa-film"></i></div>
          <h4>Private IMAX Theater</h4>
          <p>Ultra-plush 40-seater gold class screening lounge with Dolby Atmos.</p>
        </div>

        <div class="amenity-card">
          <div class="amenity-icon"><i class="fas fa-wine-glass-alt"></i></div>
          <h4>Gentleman's Lounge</h4>
          <p>Aristocratic cigar room, billiards parlor, and high-tea sundeck.</p>
        </div>

        <div class="amenity-card">
          <div class="amenity-icon"><i class="fas fa-dumbbell"></i></div>
          <h4>Technogym Fitness Club</h4>
          <p>State-of-the-art cardiovascular gymnasium with celebrity trainers.</p>
        </div>

        <div class="amenity-card">
          <div class="amenity-icon"><i class="fas fa-car-side"></i></div>
          <h4>Chauffeured Fleet</h4>
          <p>Rolls-Royce and Mercedes luxury airport &amp; city transfer fleet.</p>
        </div>

        <div class="amenity-card">
          <div class="amenity-icon"><i class="fas fa-concierge-bell"></i></div>
          <h4>24/7 White-Glove Concierge</h4>
          <p>Round-the-clock bespoke butler, travel booking, and valet services.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Interactive EMI Loan Estimator -->
  <section class="section-padding" id="calculator">
    <div class="container">
      <div class="text-center">
        <div class="section-tag"><i class="fas fa-calculator"></i> Investment Planning</div>
        <h2 class="section-title">BESPOKE <span class="gold-text">EMI ESTIMATOR</span></h2>
        <p class="section-desc">
          Plan your prestigious home investment with flexible financing rates from leading luxury banking partners.
        </p>
      </div>

      <div class="calculator-card">
        <div class="calc-controls">
          <!-- Loan Amount -->
          <div class="calc-range-group">
            <div class="calc-range-head">
              <span>Loan Principal Amount</span>
              <strong id="emiLoanVal" style="color: var(--gold-light);">₹ 1.50 Cr</strong>
            </div>
            <input type="range" class="calc-slider" id="emiLoanAmount" min="2000000" max="100000000" step="500000" value="15000000">
          </div>

          <!-- Interest Rate -->
          <div class="calc-range-group">
            <div class="calc-range-head">
              <span>Annual Interest Rate (%)</span>
              <strong id="emiRateVal" style="color: var(--gold-light);">8.5 %</strong>
            </div>
            <input type="range" class="calc-slider" id="emiInterestRate" min="6.5" max="14.0" step="0.1" value="8.5">
          </div>

          <!-- Tenure -->
          <div class="calc-range-group">
            <div class="calc-range-head">
              <span>Loan Tenure (Years)</span>
              <strong id="emiTenureVal" style="color: var(--gold-light);">20 Years</strong>
            </div>
            <input type="range" class="calc-slider" id="emiTenure" min="5" max="30" step="1" value="20">
          </div>
        </div>

        <div class="calc-result-box">
          <div class="label">Estimated Monthly EMI</div>
          <div class="monthly-amount" id="emiMonthlyAmount">₹ 1,30,167</div>

          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; border-top: 1px solid var(--border-subtle); padding-top: 20px;">
            <div>
              <div style="font-size: 11.5px; color: var(--text-muted); text-transform: uppercase;">Total Interest Payable</div>
              <div id="emiTotalInterest" style="font-size: 16px; font-weight: 700; color: #38bdf8;">₹ 1,62,40,111</div>
            </div>
            <div>
              <div style="font-size: 11.5px; color: var(--text-muted); text-transform: uppercase;">Total Repayment</div>
              <div id="emiTotalPayable" style="font-size: 16px; font-weight: 700; color: var(--gold-light);">₹ 3,12,40,111</div>
            </div>
          </div>

          <a href="#enquiry" class="btn btn-gold" style="margin-top: 25px; width: 100%;">
            <i class="fas fa-hand-holding-usd"></i> Request Bank Sanction Assistance
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Complete VIP Enquiry Form Section (All 8 Fields!) -->
  <section class="section-padding" id="enquiry" style="background: radial-gradient(circle at 50% 50%, #151b29 0%, #07090e 100%);">
    <div class="container">
      <div class="text-center">
        <div class="section-tag"><i class="fas fa-envelope-open-text"></i> VIP Lead Registration</div>
        <h2 class="section-title">SCHEDULE A PRIVATE <span class="gold-text">SITE CONCIERGE TOUR</span></h2>
        <p class="section-desc">
          Fill out the registration details below. Your enquiry will be sent directly to our WhatsApp (+91 81041 29866) and verified by our sales concierge.
        </p>
      </div>

      <div style="max-width: 820px; margin: 0 auto; background: var(--bg-card); border: 1px solid var(--border-gold); border-radius: 20px; padding: 46px 40px; box-shadow: 0 25px 60px rgba(0,0,0,0.8), var(--gold-glow);">
        
        <form class="luxury-form" data-ajax-form="enquiry">
          <!-- Anti Spam Honeypot -->
          <input type="text" name="website_hp" style="display:none;" tabindex="-1" autocomplete="off">
          
          <div class="form-row">
            <!-- 1. Full Name -->
            <div class="form-group">
              <label><i class="fas fa-user text-gold"></i> 1. Full Name *</label>
              <input type="text" name="full_name" class="form-control" placeholder="e.g. Dr. Tariq Al-Mansoor" required>
            </div>

            <!-- 2. Mobile Number -->
            <div class="form-group">
              <label><i class="fas fa-phone-alt text-gold"></i> 2. Mobile Number *</label>
              <input type="tel" name="phone" class="form-control" placeholder="10-digit mobile number" required>
            </div>
          </div>

          <div class="form-row">
            <!-- 3. Email Address -->
            <div class="form-group">
              <label><i class="fas fa-envelope text-gold"></i> 3. Email Address *</label>
              <input type="email" name="email" class="form-control" placeholder="name@domain.com" required>
            </div>

            <!-- 4. Property Selection -->
            <div class="form-group">
              <label><i class="fas fa-building text-gold"></i> 4. Property Selection</label>
              <select name="property_name" class="form-control" required>
                <option value="Shaikh Empire" selected>Shaikh Empire (Kharghar Crown, Navi Mumbai)</option>
                <option value="Shaikh Empire - Tower Sultan">Shaikh Empire - Tower Sultan</option>
                <option value="Shaikh Empire - Tower Shehanshah">Shaikh Empire - Tower Shehanshah</option>
                <option value="Shaikh Empire - Tower Royal Crown">Shaikh Empire - Tower Royal Crown (Penthouse Wing)</option>
              </select>
            </div>
          </div>

          <div class="form-row">
            <!-- 5. Preferred Configuration -->
            <div class="form-group">
              <label><i class="fas fa-home text-gold"></i> 5. Preferred Configuration *</label>
              <select name="configuration" class="form-control" required>
                <option value="2 BHK Royal Suite">2 BHK Royal Suite (880-920 sq.ft. carpet) - ₹ 1.95 Cr*</option>
                <option value="3 BHK Imperial Suite" selected>3 BHK Imperial Suite (1380-1480 sq.ft. carpet) - ₹ 2.85 Cr*</option>
                <option value="4 BHK Emperor Penthouse">4 BHK Emperor Penthouse (2150-2400 sq.ft. carpet) - ₹ 4.50 Cr*</option>
                <option value="5 BHK Presidential Sky Villa">5 BHK Presidential Sky Villa (3600+ sq.ft. carpet) - ₹ 7.90 Cr*</option>
              </select>
            </div>

            <!-- 6. Preferred Visit Date -->
            <div class="form-group">
              <label><i class="fas fa-calendar-alt text-gold"></i> 6. Preferred Visit Date</label>
              <input type="date" name="visit_date" class="form-control" min="<?= date('Y-m-d') ?>">
            </div>
          </div>

          <!-- 7. Chauffeured Pickup Request -->
          <div class="form-group" style="background: rgba(7, 9, 14, 0.4); border: 1px solid var(--border-gold); border-radius: 10px; padding: 14px 18px; margin-bottom: 20px;">
            <label style="color: var(--gold-light); font-weight: 700; margin-bottom: 8px;">
              <i class="fas fa-car-side"></i> 7. Chauffeured Luxury Pickup Request
            </label>
            <div style="display: flex; gap: 30px; align-items: center; margin-top: 6px;">
              <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; color: var(--text-primary); font-size: 14px;">
                <input type="radio" name="chauffeured_pickup" value="Yes" checked style="accent-color: var(--gold-primary);">
                <span>Yes, arrange luxury Rolls-Royce / Mercedes transfer</span>
              </label>
              <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; color: var(--text-secondary); font-size: 14px;">
                <input type="radio" name="chauffeured_pickup" value="No" style="accent-color: var(--gold-primary);">
                <span>No, I will arrive in my own vehicle</span>
              </label>
            </div>
          </div>

          <!-- 8. Special Request / Message -->
          <div class="form-group">
            <label><i class="fas fa-comment-dots text-gold"></i> 8. Special Request / Message</label>
            <textarea name="special_request" class="form-control" placeholder="Specify any preferences such as vastu compliance, high-rise floor preference, airport pickup location, or specific tower..."></textarea>
          </div>

          <!-- Submission Button -->
          <button type="submit" class="btn btn-gold" style="width: 100%; padding: 16px; font-size: 16px;">
            <i class="fab fa-whatsapp"></i> Submit Enquiry on WhatsApp
          </button>

          <p class="form-privacy-note">
            <i class="fas fa-shield-alt text-gold"></i> 100% Secure &amp; Confidential &bull; Enquiry will be sent directly to Sales Concierge on WhatsApp (+91 81041 29866).
          </p>
        </form>

      </div>
    </div>
  </section>

  <!-- Location & Connectivity Advantage -->
  <section class="section-padding" id="location">
    <div class="container">
      <div class="text-center">
        <div class="section-tag"><i class="fas fa-map-marked-alt"></i> Imperial Address</div>
        <h2 class="section-title">THE CROWN DESTINATION OF <span class="gold-text">KHARGHAR, NAVI MUMBAI</span></h2>
        <p class="section-desc">
          Situated at the epicenter of rapid infrastructure growth, lush green golf courses, and the upcoming Navi Mumbai International Airport.
        </p>
      </div>

      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px;">
        <div class="spec-item" style="padding: 22px;">
          <div style="color: var(--gold-primary); font-size: 24px; margin-bottom: 10px;"><i class="fas fa-plane-departure"></i></div>
          <div class="value" style="font-size: 16px; margin-bottom: 4px;">15 Minutes</div>
          <div class="label">Upcoming Navi Mumbai International Airport (NMIA)</div>
        </div>

        <div class="spec-item" style="padding: 22px;">
          <div style="color: var(--gold-primary); font-size: 24px; margin-bottom: 10px;"><i class="fas fa-subway"></i></div>
          <div class="value" style="font-size: 16px; margin-bottom: 4px;">5 Minutes</div>
          <div class="label">Sector 34 Metro Station &amp; Mumbai-Pune Expressway</div>
        </div>

        <div class="spec-item" style="padding: 22px;">
          <div style="color: var(--gold-primary); font-size: 24px; margin-bottom: 10px;"><i class="fas fa-tree"></i></div>
          <div class="value" style="font-size: 16px; margin-bottom: 4px;">7 Minutes</div>
          <div class="label">290-Acre Kharghar Central Park &amp; 18-Hole Golf Course</div>
        </div>

        <div class="spec-item" style="padding: 22px;">
          <div style="color: var(--gold-primary); font-size: 24px; margin-bottom: 10px;"><i class="fas fa-building"></i></div>
          <div class="value" style="font-size: 16px; margin-bottom: 4px;">20 Minutes</div>
          <div class="label">Atal Setu (MTHL Sea Link) - Direct South Mumbai Access</div>
        </div>
      </div>
    </div>
  </section>

  <!-- Master Footer -->
  <footer class="footer">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-col">
          <div class="nav-brand" style="margin-bottom: 16px;">
            <div class="brand-crest"><i class="fas fa-crown"></i></div>
            <div class="brand-titles">
              <span class="brand-developer">SHAIKH GROUP</span>
              <span class="brand-name">SHAIKH EMPIRE</span>
            </div>
          </div>
          <p style="color: var(--text-secondary); font-size: 13.5px; line-height: 1.7; margin-bottom: 20px;">
            Shaikh Empire is the imperial crest of luxury living in Navi Mumbai, combining classical world empire craftsmanship with 52-storey skyscraper brilliance.
          </p>
          <div style="display: flex; gap: 12px;">
            <a href="https://wa.me/918104129866" target="_blank" class="btn-action btn-wa" style="width: 38px; height: 38px; font-size: 18px;"><i class="fab fa-whatsapp"></i></a>
            <a href="tel:+918104129866" class="btn-action" style="width: 38px; height: 38px; font-size: 16px;"><i class="fas fa-phone"></i></a>
            <a href="admin/login.php" class="btn-action" title="Admin Concierge CRM" style="width: 38px; height: 38px; font-size: 16px;"><i class="fas fa-user-shield"></i></a>
          </div>
        </div>

        <div class="footer-col">
          <h4>Imperial Towers</h4>
          <ul class="footer-links">
            <li><a href="#towers">Tower Sultan (G+52)</a></li>
            <li><a href="#towers">Tower Shehanshah (G+52)</a></li>
            <li><a href="#towers">Tower Badshah (G+52)</a></li>
            <li><a href="#towers">Tower Nizam (G+52)</a></li>
            <li><a href="#towers">Tower Royal Crown (Sky Villa)</a></li>
          </ul>
        </div>

        <div class="footer-col">
          <h4>Residences</h4>
          <ul class="footer-links">
            <li><a href="#residences">2 BHK Royal Suite</a></li>
            <li><a href="#residences">3 BHK Imperial Suite</a></li>
            <li><a href="#residences">4 BHK Emperor Penthouse</a></li>
            <li><a href="#residences">5 BHK Presidential Sky Villa</a></li>
            <li><a href="#calculator">Loan &amp; EMI Estimator</a></li>
          </ul>
        </div>

        <div class="footer-col">
          <h4>Sales Concierge</h4>
          <p style="font-size: 13.5px; color: var(--text-secondary); margin-bottom: 12px;">
            <i class="fas fa-map-marker-alt text-gold"></i> Imperial Boulevard, Sector 36, Kharghar, Navi Mumbai - 410210
          </p>
          <p style="font-size: 13.5px; color: var(--text-secondary); margin-bottom: 12px;">
            <i class="fas fa-phone-alt text-gold"></i> VIP Sales: +91 81041 29866
          </p>
          <p style="font-size: 13.5px; color: var(--text-secondary); margin-bottom: 16px;">
            <i class="fas fa-envelope text-gold"></i> concierge@shaikhempire.com
          </p>
          <a href="admin/login.php" class="btn btn-outline-gold btn-sm">
            <i class="fas fa-lock"></i> Staff Concierge Login
          </a>
        </div>
      </div>

      <div class="footer-bottom">
        <div>
          &copy; <?= date('Y') ?> Shaikh Empire &bull; Shaikh Group Developers. All Rights Reserved.
        </div>
        <div style="color: var(--gold-light);">
          <i class="fas fa-shield-alt"></i> MahaRERA Registration No: <strong>P52000049821</strong>
        </div>
      </div>
    </div>
  </footer>

  <!-- VIP Tour Modal Dialog -->
  <div class="modal-overlay" id="vipTourModal">
    <div class="modal-card">
      <button class="modal-close-btn" data-close-modal>&times;</button>
      <div style="text-align: center; margin-bottom: 24px;">
        <div class="brand-crest" style="margin: 0 auto 12px; width: 44px; height: 44px; font-size: 20px;"><i class="fas fa-crown"></i></div>
        <h3 style="font-family: 'Cinzel', serif; font-size: 20px; color: var(--gold-light);">VIP CONCIERGE SITE VISIT</h3>
        <p style="font-size: 12.5px; color: var(--text-muted);">Complimentary chauffeured transport &amp; private masterclass tour</p>
      </div>

      <form class="luxury-form" data-ajax-form="enquiry">
        <input type="text" name="website_hp" style="display:none;" tabindex="-1" autocomplete="off">
        <input type="hidden" name="property_name" value="Shaikh Empire">

        <div class="form-group">
          <label>Full Legal Name *</label>
          <input type="text" name="full_name" class="form-control" placeholder="Enter your full name" required>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Mobile Number *</label>
            <input type="tel" name="phone" class="form-control" placeholder="10-digit number" required>
          </div>
          <div class="form-group">
            <label>Email Address *</label>
            <input type="email" name="email" class="form-control" placeholder="name@domain.com" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Configuration Preference *</label>
            <select name="configuration" class="form-control" required>
              <option value="2 BHK Royal Suite">2 BHK Royal Suite</option>
              <option value="3 BHK Imperial Suite" selected>3 BHK Imperial Suite</option>
              <option value="4 BHK Emperor Penthouse">4 BHK Emperor Penthouse</option>
              <option value="5 BHK Presidential Sky Villa">5 BHK Presidential Sky Villa</option>
            </select>
          </div>
          <div class="form-group">
            <label>Preferred Visit Date</label>
            <input type="date" name="visit_date" class="form-control" min="<?= date('Y-m-d') ?>">
          </div>
        </div>

        <label class="form-checkbox">
          <input type="checkbox" name="chauffeured_pickup" value="Yes" checked>
          <span><i class="fas fa-car"></i> Request Complimentary Chauffeured Luxury Transfer</span>
        </label>

        <div class="form-group">
          <label>Special Instructions / Pickup Address</label>
          <textarea name="special_request" class="form-control" placeholder="Pickup location, time preference, or specific architect questions..."></textarea>
        </div>

        <button type="submit" class="btn btn-gold" style="width: 100%;">
          <i class="fab fa-whatsapp"></i> Submit Enquiry on WhatsApp
        </button>
      </form>
    </div>
  </div>

  <!-- Floating WhatsApp Quick Button (+91 81041 29866) -->
  <a href="https://wa.me/918104129866?text=Hello%20Shaikh%20Empire%20Concierge,%20I%20am%20interested%20in%20Shaikh%20Empire%20Kharghar" target="_blank" class="luxury-floating-wa" title="Chat on WhatsApp (+91 81041 29866)" aria-label="WhatsApp Concierge">
    <i class="fab fa-whatsapp"></i>
    <span class="wa-tooltip">WhatsApp (+91 81041 29866)</span>
  </a>

  <!-- Custom JavaScript Engine -->
  <script src="assets/js/main.js?v=<?= time() ?>"></script>

</body>
</html>
