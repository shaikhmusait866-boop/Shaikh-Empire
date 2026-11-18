/**
 * SHAIKH EMPIRE - INTERACTIVE CLIENT ENGINE & FORM CONTROLLER
 * Ultra Luxury Real Estate & MySQL Lead Pipeline
 */

document.addEventListener('DOMContentLoaded', () => {
  initHeroSlider();
  initTowersShowcase();
  initResidencesBlueprints();
  initEmiCalculator();
  initModals();
  initEnquiryForms();
  trackVisitor();
});

/* ==========================================================================
   1. Hero Background Slider
   ========================================================================== */
function initHeroSlider() {
  const slides = document.querySelectorAll('.hero-slide');
  if (slides.length <= 1) return;

  let currentSlide = 0;
  setInterval(() => {
    slides[currentSlide].classList.remove('active');
    currentSlide = (currentSlide + 1) % slides.length;
    slides[currentSlide].classList.add('active');
  }, 5000);
}

/* ==========================================================================
   2. 6 Iconic Towers Dynamic Showcase
   ========================================================================== */
const TOWERS_DATA = {
  sultan: {
    name: 'Tower Sultan',
    tag: 'The Sovereign Landmark (G+52 Storeys)',
    height: 'G+52 Royal Storeys (210 Meters)',
    view: 'Unobstructed Panoramic Arabian Sea & Marina View',
    lifts: '6 Ultra High-Speed Private Elevators (6 m/s)',
    residences: 'Exclusive 3 & 4 BHK Imperial Residences',
    curtain: 'Double-Glazed Soundproof Acoustic Glass Façade',
    img: 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=1200&q=80'
  },
  shehanshah: {
    name: 'Tower Shehanshah',
    tag: 'Emperor of Modern Luxury (G+52 Storeys)',
    height: 'G+52 Royal Storeys (210 Meters)',
    view: 'Royal Central Parkland & Imperial Musical Fountains',
    lifts: '6 High-Speed Smart Elevators with Biometric Call',
    residences: '4 BHK Emperor Penthouses & Sky Duplexes',
    curtain: 'Thermodynamic Gold-Tinted Structural Glazing',
    img: 'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=1200&q=80'
  },
  badshah: {
    name: 'Tower Badshah',
    tag: 'Majestic Architectural Supremacy (G+52 Storeys)',
    height: 'G+52 Royal Storeys (210 Meters)',
    view: 'Lush Green Kharghar Hills & Golf Course View',
    lifts: '4 High-Speed Passenger Lifts + 2 Stretcher Service Lifts',
    residences: '2 & 3 BHK Royal Residences',
    curtain: 'Acoustic Insulated Wind-Resistant Glass Curtain',
    img: 'https://images.unsplash.com/photo-1580674684081-7617fbf3d745?auto=format&fit=crop&w=1200&q=80'
  },
  nizam: {
    name: 'Tower Nizam',
    tag: 'Aristocratic Heritage Elegance (G+52 Storeys)',
    height: 'G+52 Royal Storeys (210 Meters)',
    view: 'Private Marina Bay & Skyline Horizon',
    lifts: '6 Smart Destination-Controlled High Speed Lifts',
    residences: '3 BHK Imperial Suites with Wrap-Around Balconies',
    curtain: 'Energy Efficient Low-E Solar Acoustic Glazing',
    img: 'https://images.unsplash.com/photo-1526495124232-a04e1849168c?auto=format&fit=crop&w=1200&q=80'
  },
  jahangir: {
    name: 'Tower Jahangir',
    tag: 'Imperial Sky Sanctuary (G+52 Storeys)',
    height: 'G+52 Royal Storeys (210 Meters)',
    view: 'Sunrise Valley & 85,000 Sq. Ft. Club Sultanate',
    lifts: '6 High-Speed Lifts with Private Access Foyer',
    residences: '2 & 3 BHK Royal Suites with 11.5 Ft. High Ceilings',
    curtain: 'Reinforced Shatterproof Architectural Glass',
    img: 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1200&q=80'
  },
  royal_crown: {
    name: 'Tower Royal Crown',
    tag: 'The Presidential Pinnacle (G+52 Storeys)',
    height: 'G+52 Royal Storeys (210 Meters)',
    view: '360° Sky Lounge Observatory & Helipad Access',
    lifts: 'Direct-to-Residence Private High-Speed Elevators',
    residences: '5 BHK Presidential Sky Villas with Private Plunge Pools',
    curtain: 'Ultra-Luxury Triple Glazed Frameless Curtain Wall',
    img: 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=1200&q=80'
  }
};

function initTowersShowcase() {
  const tabBtns = document.querySelectorAll('.tower-tab-btn');
  const towerName = document.getElementById('towerName');
  const towerTag = document.getElementById('towerTag');
  const towerHeight = document.getElementById('towerHeight');
  const towerView = document.getElementById('towerView');
  const towerLifts = document.getElementById('towerLifts');
  const towerResidences = document.getElementById('towerResidences');
  const towerCurtain = document.getElementById('towerCurtain');
  const towerImg = document.getElementById('towerImg');

  if (!tabBtns.length || !towerName) return;

  tabBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      tabBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      const towerKey = btn.dataset.tower;
      const data = TOWERS_DATA[towerKey];
      if (!data) return;

      // Update contents
      towerName.textContent = data.name;
      towerTag.textContent = data.tag;
      towerHeight.textContent = data.height;
      towerView.textContent = data.view;
      towerLifts.textContent = data.lifts;
      towerResidences.textContent = data.residences;
      towerCurtain.textContent = data.curtain;
      towerImg.src = data.img;
      towerImg.alt = data.name;
    });
  });
}

/* ==========================================================================
   3. Residences & Interactive SVG Blueprints
   ========================================================================== */
const BLUEPRINTS_DATA = {
  '2bhk': {
    title: '2 BHK Royal Suite',
    carpet: '880 - 920 Sq. Ft. Carpet Area',
    price: 'Starting from ₹ 1.95 Cr* (All Inclusive)',
    features: [
      'Grand Living & Dining Room with 60 sq.ft. Sundeck',
      'Master Bedroom with Italian Marble Ensuite Bath',
      'Gourmet Modular Kitchen with Utility Balcony',
      'Vastu-Compliant East-West Oriented Entry',
      'Smart Home Automation for Lighting & AC'
    ],
    svg: `
      <svg viewBox="0 0 500 350" width="100%" height="320" xmlns="http://www.w3.org/2000/svg">
        <rect x="10" y="10" width="480" height="330" fill="#0d111a" stroke="#d4af37" stroke-width="2" rx="8"/>
        <!-- Living Room -->
        <rect x="25" y="25" width="260" height="180" fill="#151b29" stroke="#997a15" stroke-dasharray="4"/>
        <text x="155" y="110" fill="#f5e6b3" font-size="14" font-weight="bold" text-anchor="middle">GRAND LIVING ROOM</text>
        <text x="155" y="130" fill="#8492a6" font-size="12" text-anchor="middle">14'0" x 22'6"</text>
        <!-- Sundeck -->
        <rect x="25" y="215" width="260" height="60" fill="#192235" stroke="#38bdf8"/>
        <text x="155" y="250" fill="#38bdf8" font-size="12" text-anchor="middle">ROYAL SUNDECK (60 Sq.Ft.)</text>
        <!-- Master Bedroom -->
        <rect x="295" y="25" width="180" height="140" fill="#151b29" stroke="#997a15" stroke-dasharray="4"/>
        <text x="385" y="90" fill="#f5e6b3" font-size="13" font-weight="bold" text-anchor="middle">MASTER SUITE</text>
        <text x="385" y="110" fill="#8492a6" font-size="11" text-anchor="middle">12'0" x 14'0"</text>
        <!-- Bedroom 2 -->
        <rect x="295" y="175" width="180" height="100" fill="#151b29" stroke="#997a15" stroke-dasharray="4"/>
        <text x="385" y="220" fill="#f5e6b3" font-size="13" font-weight="bold" text-anchor="middle">GUEST BEDROOM</text>
        <text x="385" y="240" fill="#8492a6" font-size="11" text-anchor="middle">11'0" x 12'0"</text>
        <!-- Kitchen & Foyer -->
        <rect x="25" y="285" width="160" height="45" fill="#1a202c" stroke="#997a15"/>
        <text x="105" y="312" fill="#d4af37" font-size="11" text-anchor="middle">DESIGNER KITCHEN</text>
        <rect x="195" y="285" width="280" height="45" fill="#131722" stroke="#997a15"/>
        <text x="335" y="312" fill="#f5e6b3" font-size="11" text-anchor="middle">ENTRANCE FOYER &amp; POWDER BATH</text>
      </svg>
    `
  },
  '3bhk': {
    title: '3 BHK Imperial Suite',
    carpet: '1,380 - 1,480 Sq. Ft. Carpet Area',
    price: 'Starting from ₹ 2.85 Cr* (All Inclusive)',
    features: [
      'Palatial Living & Dining with 180° Panoramic Balcony',
      '2 Master Suites with Walk-in Wardrobes & Soak Tubs',
      'Kids / Guest Royal Suite with Attached Bath',
      'Separated Dry & Wet Gourmet Kitchen with Utility',
      'Dedicated Maid / Staff Quarters with Private Entry'
    ],
    svg: `
      <svg viewBox="0 0 500 350" width="100%" height="320" xmlns="http://www.w3.org/2000/svg">
        <rect x="10" y="10" width="480" height="330" fill="#0d111a" stroke="#d4af37" stroke-width="2" rx="8"/>
        <!-- Palatial Living Room -->
        <rect x="25" y="25" width="270" height="190" fill="#151b29" stroke="#997a15" stroke-dasharray="4"/>
        <text x="160" y="110" fill="#f5e6b3" font-size="14" font-weight="bold" text-anchor="middle">PALATIAL LIVING &amp; DINING</text>
        <text x="160" y="130" fill="#8492a6" font-size="12" text-anchor="middle">18'0" x 26'4"</text>
        <!-- Master Suite 1 -->
        <rect x="305" y="25" width="170" height="120" fill="#151b29" stroke="#997a15"/>
        <text x="390" y="80" fill="#f5e6b3" font-size="13" font-weight="bold" text-anchor="middle">MASTER SUITE 1</text>
        <text x="390" y="100" fill="#8492a6" font-size="11" text-anchor="middle">14'0" x 16'0"</text>
        <!-- Master Suite 2 -->
        <rect x="305" y="155" width="170" height="110" fill="#151b29" stroke="#997a15"/>
        <text x="390" y="205" fill="#f5e6b3" font-size="13" font-weight="bold" text-anchor="middle">IMPERIAL SUITE 2</text>
        <text x="390" y="225" fill="#8492a6" font-size="11" text-anchor="middle">13'0" x 14'6"</text>
        <!-- Sundeck Deck -->
        <rect x="25" y="225" width="270" height="50" fill="#192235" stroke="#38bdf8"/>
        <text x="160" y="255" fill="#38bdf8" font-size="12" text-anchor="middle">EXPANSIVE MARINA VIEW SUNDECK</text>
        <!-- Kitchen & Staff -->
        <rect x="25" y="285" width="230" height="45" fill="#1a202c" stroke="#997a15"/>
        <text x="140" y="312" fill="#d4af37" font-size="11" text-anchor="middle">GOURMET CHEF KITCHEN</text>
        <rect x="265" y="275" width="210" height="55" fill="#131722" stroke="#997a15"/>
        <text x="370" y="307" fill="#f5e6b3" font-size="11" text-anchor="middle">BEDROOM 3 + STAFF SUITE</text>
      </svg>
    `
  },
  '4bhk': {
    title: '4 BHK Emperor Penthouse',
    carpet: '2,150 - 2,400 Sq. Ft. Carpet Area',
    price: 'Starting from ₹ 4.50 Cr* (All Inclusive)',
    features: [
      'Double-Height Living Salon with 24-ft Glass Facade',
      'Private High-Speed Elevator with Biometric Foyer',
      '4 Expansive Master Suites with Spa Bathrooms',
      'Dedicated Cigar Lounge / Executive Study Room',
      'Wraparound Sky Terrace with Private Jacuzzi'
    ],
    svg: `
      <svg viewBox="0 0 500 350" width="100%" height="320" xmlns="http://www.w3.org/2000/svg">
        <rect x="10" y="10" width="480" height="330" fill="#0d111a" stroke="#d4af37" stroke-width="2" rx="8"/>
        <rect x="25" y="25" width="300" height="190" fill="#151b29" stroke="#d4af37" stroke-width="2"/>
        <text x="175" y="110" fill="#f5e6b3" font-size="15" font-weight="bold" text-anchor="middle">DOUBLE-HEIGHT LIVING SALON</text>
        <text x="175" y="130" fill="#8492a6" font-size="12" text-anchor="middle">24'0" x 32'0" (Vaulted Ceiling)</text>
        <!-- Sky Jacuzzi Terrace -->
        <rect x="25" y="225" width="300" height="55" fill="#192235" stroke="#38bdf8"/>
        <text x="175" y="258" fill="#38bdf8" font-size="12" font-weight="bold" text-anchor="middle">SKY JACUZZI &amp; PRIVATE TERRACE</text>
        <!-- 4 Master Suites -->
        <rect x="335" y="25" width="140" height="90" fill="#151b29" stroke="#997a15"/>
        <text x="405" y="70" fill="#f5e6b3" font-size="11" font-weight="bold" text-anchor="middle">SUITE 1</text>
        <rect x="335" y="125" width="140" height="90" fill="#151b29" stroke="#997a15"/>
        <text x="405" y="170" fill="#f5e6b3" font-size="11" font-weight="bold" text-anchor="middle">SUITE 2</text>
        <rect x="335" y="225" width="140" height="105" fill="#151b29" stroke="#997a15"/>
        <text x="405" y="275" fill="#f5e6b3" font-size="11" font-weight="bold" text-anchor="middle">SUITES 3 &amp; 4</text>
        <!-- Private Elevator Foyer -->
        <rect x="25" y="290" width="300" height="40" fill="#221e10" stroke="#d4af37"/>
        <text x="175" y="315" fill="#d4af37" font-size="11" font-weight="bold" text-anchor="middle">PRIVATE BIOMETRIC LIFT FOYER</text>
      </svg>
    `
  },
  '5bhk': {
    title: '5 BHK Presidential Sky Villa',
    carpet: '3,600+ Sq. Ft. Carpet Area (Duplex Penthouse)',
    price: 'Starting from ₹ 7.90 Cr* (All Inclusive)',
    features: [
      'Private Temperature-Controlled Infinity Plunge Pool',
      'Exclusive Helipad Direct Access on Tower Crown',
      'Private Internal Capsule Elevator inside Duplex',
      'White-Glove 24/7 Butler & Chef Concierge Services',
      '4 Reserved VIP Basement Parking Pods'
    ],
    svg: `
      <svg viewBox="0 0 500 350" width="100%" height="320" xmlns="http://www.w3.org/2000/svg">
        <rect x="10" y="10" width="480" height="330" fill="#0d111a" stroke="#d4af37" stroke-width="2.5" rx="8"/>
        <!-- Grand Ballroom -->
        <rect x="25" y="25" width="310" height="180" fill="#182030" stroke="#d4af37" stroke-width="2"/>
        <text x="180" y="105" fill="#f5e6b3" font-size="16" font-weight="bold" text-anchor="middle">PRESIDENTIAL BALLROOM &amp; SALON</text>
        <text x="180" y="128" fill="#d4af37" font-size="12" text-anchor="middle">Palatial Horizon Overlook (3,600+ Sq.Ft.)</text>
        <!-- Private Infinity Plunge Pool -->
        <rect x="25" y="215" width="310" height="65" fill="#0e3a53" stroke="#38bdf8" stroke-width="2"/>
        <text x="180" y="252" fill="#38bdf8" font-size="13" font-weight="bold" text-anchor="middle">PRIVATE INFINITY PLUNGE POOL (SKY DECK)</text>
        <!-- Duplex Suites & Amenities -->
        <rect x="345" y="25" width="130" height="120" fill="#151b29" stroke="#997a15"/>
        <text x="410" y="80" fill="#f5e6b3" font-size="11" font-weight="bold" text-anchor="middle">ROYAL MASTER 1</text>
        <text x="410" y="100" fill="#8492a6" font-size="10" text-anchor="middle">+ SPA JACUZZI</text>
        <rect x="345" y="155" width="130" height="125" fill="#151b29" stroke="#997a15"/>
        <text x="410" y="210" fill="#f5e6b3" font-size="11" font-weight="bold" text-anchor="middle">SUITES 2, 3, 4, 5</text>
        <!-- Internal Elevator & Helipad -->
        <rect x="25" y="290" width="450" height="40" fill="#292010" stroke="#d4af37"/>
        <text x="250" y="315" fill="#f5e6b3" font-size="11" font-weight="bold" text-anchor="middle">INTERNAL CAPSULE ELEVATOR &bull; PRIVATE HELIPAD ACCESS</text>
      </svg>
    `
  }
};

function initResidencesBlueprints() {
  const tabs = document.querySelectorAll('.blueprint-tab');
  const frame = document.getElementById('svgPlanFrame');
  const title = document.getElementById('blueprintTitle');
  const carpet = document.getElementById('blueprintCarpet');
  const price = document.getElementById('blueprintPrice');
  const featuresList = document.getElementById('blueprintFeatures');

  if (!tabs.length || !frame) return;

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      tabs.forEach(t => t.classList.remove('active'));
      tab.classList.add('active');

      const configKey = tab.dataset.config;
      const data = BLUEPRINTS_DATA[configKey];
      if (!data) return;

      title.textContent = data.title;
      carpet.textContent = data.carpet;
      price.textContent = data.price;
      frame.innerHTML = data.svg;

      featuresList.innerHTML = data.features.map(f => `
        <li><i class="fas fa-check-circle"></i> <span>${f}</span></li>
      `).join('');
    });
  });
}

/* ==========================================================================
   4. Interactive EMI Loan Estimator
   ========================================================================== */
function initEmiCalculator() {
  const loanSlider = document.getElementById('emiLoanAmount');
  const rateSlider = document.getElementById('emiInterestRate');
  const tenureSlider = document.getElementById('emiTenure');

  const loanVal = document.getElementById('emiLoanVal');
  const rateVal = document.getElementById('emiRateVal');
  const tenureVal = document.getElementById('emiTenureVal');

  const monthlyEmi = document.getElementById('emiMonthlyAmount');
  const totalInterest = document.getElementById('emiTotalInterest');
  const totalPayable = document.getElementById('emiTotalPayable');

  if (!loanSlider || !monthlyEmi) return;

  function calculate() {
    const P = parseFloat(loanSlider.value); // Principal in Rupees
    const annualRate = parseFloat(rateSlider.value);
    const N = parseFloat(tenureSlider.value) * 12; // Total months
    const R = (annualRate / 12) / 100; // Monthly interest rate

    // Display formatted slider inputs
    const croreVal = (P / 10000000).toFixed(2);
    loanVal.textContent = `₹ ${croreVal} Cr (${P.toLocaleString('en-IN')})`;
    rateVal.textContent = `${annualRate.toFixed(1)} %`;
    tenureVal.textContent = `${tenureSlider.value} Years (${N} Months)`;

    // Formula: [P * R * (1+R)^N] / [(1+R)^N - 1]
    const emi = (P * R * Math.pow(1 + R, N)) / (Math.pow(1 + R, N) - 1);
    const totalAmount = emi * N;
    const interestAmount = totalAmount - P;

    monthlyEmi.textContent = `₹ ${Math.round(emi).toLocaleString('en-IN')}`;
    totalInterest.textContent = `₹ ${Math.round(interestAmount).toLocaleString('en-IN')}`;
    totalPayable.textContent = `₹ ${Math.round(totalAmount).toLocaleString('en-IN')}`;
  }

  loanSlider.addEventListener('input', calculate);
  rateSlider.addEventListener('input', calculate);
  tenureSlider.addEventListener('input', calculate);
  calculate();
}

/* ==========================================================================
   5. Modal Manager (VIP Tour & Brochure Modals)
   ========================================================================== */
function initModals() {
  const openBtns = document.querySelectorAll('[data-open-modal]');
  const closeBtns = document.querySelectorAll('[data-close-modal]');

  openBtns.forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      const modalId = btn.getAttribute('data-open-modal');
      const modal = document.getElementById(modalId);
      if (modal) modal.classList.add('active');
    });
  });

  closeBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const modal = btn.closest('.modal-overlay');
      if (modal) modal.classList.remove('active');
    });
  });

  document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', (e) => {
      if (e.target === overlay) overlay.classList.remove('active');
    });
  });
}

/* ==========================================================================
   6. WhatsApp VIP Enquiry Submission & Direct Routing (+91 8104129866)
   ========================================================================== */
const OWNER_WHATSAPP_NUMBER = '918104129866';

function buildDirectWhatsAppUrl(formData) {
  const fullName      = (formData.get('full_name') || '').trim();
  const phone         = (formData.get('phone') || '').trim();
  const email         = (formData.get('email') || '').trim();
  const propertyName  = (formData.get('property_name') || 'Shaikh Empire').trim();
  const configuration = (formData.get('configuration') || '3 BHK Imperial Suite').trim();
  const visitDate     = (formData.get('visit_date') || '').trim() || 'Not specified';
  const pickupRaw     = formData.get('chauffeured_pickup');
  const chauffeured   = (pickupRaw === 'Yes' || pickupRaw === '1') ? 'Yes' : 'No';
  const specialReq    = (formData.get('special_request') || '').trim() || 'None provided';

  const lines = [
    "👑 *NEW VIP ENQUIRY - SHAIKH EMPIRE*",
    "━━━━━━━━━━━━━━━━━━━━",
    "👤 *Full Name:* " + fullName,
    "📞 *Mobile Number:* " + phone,
    "✉️ *Email Address:* " + email,
    "🏛️ *Property Selection:* " + propertyName,
    "🏡 *Preferred Configuration:* " + configuration,
    "📅 *Preferred Visit Date:* " + visitDate,
    "🚗 *Chauffeured Pickup:* " + chauffeured,
    "💬 *Special Request / Message:* " + specialReq,
    "━━━━━━━━━━━━━━━━━━━━",
    "✨ *Sent from Shaikh Empire Website*"
  ];

  return 'https://wa.me/' + OWNER_WHATSAPP_NUMBER + '?text=' + encodeURIComponent(lines.join('\n'));
}

function launchWhatsAppWindow(url) {
  try {
    const waWin = window.open(url, '_blank');
    if (!waWin || waWin.closed || typeof waWin.closed === 'undefined') {
      window.location.href = url;
    }
  } catch (err) {
    window.location.href = url;
  }
}

function initEnquiryForms() {
  const forms = document.querySelectorAll('form[data-ajax-form="enquiry"]');

  forms.forEach(form => {
    form.addEventListener('submit', async (e) => {
      e.preventDefault();

      const submitBtn = form.querySelector('button[type="submit"]');
      const originalBtnHtml = submitBtn.innerHTML;

      // Extract values
      const nameInput = form.querySelector('input[name="full_name"]');
      const phoneInput = form.querySelector('input[name="phone"]');
      const emailInput = form.querySelector('input[name="email"]');

      if (!nameInput.value.trim() || nameInput.value.trim().length < 3) {
        showToast('Please enter your full name (at least 3 characters).', 'error');
        nameInput.focus();
        return;
      }

      const cleanPhone = phoneInput.value.replace(/[^0-9]/g, '');
      if (cleanPhone.length < 10) {
        showToast('Please enter a valid 10-digit mobile number.', 'error');
        phoneInput.focus();
        return;
      }

      if (!emailInput.value.includes('@') || !emailInput.value.includes('.')) {
        showToast('Please enter a valid email address.', 'error');
        emailInput.focus();
        return;
      }

      // UI Loading state
      submitBtn.disabled = true;
      submitBtn.innerHTML = '<i class="fab fa-whatsapp fa-spin"></i> Opening WhatsApp...';

      const formData = new FormData(form);
      const fallbackWaUrl = buildDirectWhatsAppUrl(formData);

      let targetWaUrl = fallbackWaUrl;

      try {
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), 3500);

        const response = await fetch('api/submit_enquiry.php', {
          method: 'POST',
          body: formData,
          signal: controller.signal
        });
        clearTimeout(timeoutId);

        if (response.ok) {
          const result = await response.json();
          if (result && result.whatsapp_url) {
            targetWaUrl = result.whatsapp_url;
          }
        }
      } catch (err) {
        console.log('Background DB archiving notice (proceeding directly to WhatsApp):', err);
      }

      // Close modal if form was inside a modal
      const parentModal = form.closest('.modal-overlay');
      if (parentModal) parentModal.classList.remove('active');

      // Reset form
      form.reset();

      // Show luxury confirmation toast
      showToast('Enquiry received! Opening WhatsApp to +91 8104129866...', 'success');

      // Launch WhatsApp immediately
      setTimeout(() => {
        launchWhatsAppWindow(targetWaUrl);
      }, 300);

      submitBtn.disabled = false;
      submitBtn.innerHTML = originalBtnHtml;
    });
  });
}

/* ==========================================================================
   7. Luxury Toast Notification
   ========================================================================== */
function showToast(message, type = 'success') {
  let toast = document.getElementById('luxuryToastNotice');
  if (!toast) {
    toast = document.createElement('div');
    toast.id = 'luxuryToastNotice';
    toast.className = 'toast-notice';
    document.body.appendChild(toast);
  }

  const icon = (type === 'success') 
    ? '<i class="fas fa-crown" style="color: #d4af37; font-size: 24px;"></i>' 
    : '<i class="fas fa-exclamation-triangle" style="color: #ef4444; font-size: 24px;"></i>';

  toast.innerHTML = `
    ${icon}
    <div>
      <h4 style="font-family: 'Cinzel', serif; font-size: 14px; color: #f5e6b3; margin-bottom: 4px;">
        ${type === 'success' ? 'SHAIKH EMPIRE CONCIERGE' : 'ATTENTION'}
      </h4>
      <p style="font-size: 13px; color: #cbd5e1; line-height: 1.4;">${message}</p>
    </div>
  `;

  toast.classList.add('show');
  setTimeout(() => {
    toast.classList.remove('show');
  }, 6000);
}

/* ==========================================================================
   8. Visitor Analytics Tracker
   ========================================================================== */
function trackVisitor() {
  try {
    fetch('api/track_visit.php?page=' + encodeURIComponent(window.location.pathname), {
      method: 'GET',
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    }).catch(() => {});
  } catch (e) {}
}
