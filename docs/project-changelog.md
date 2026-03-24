# Project Changelog

All notable changes to the TonyTechLab Donate Landing Page project are documented here.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/), and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2026-03-24

### Added

#### Core Theme Structure
- LearnPress child theme setup (`learnpress-child/`)
- Theme stylesheet and functions.php for asset management
- Custom page template for donation interface (`page-templates/template-donate.php`)
- Modular section architecture with 8 reusable PHP components

#### Page Sections (8 Components)
- **Hero Section** — Call-to-action with title and introduction
- **Mission Section** — Organization purpose and values statement
- **Stats Section** — Impact metrics with animated counter (IntersectionObserver)
- **Funds Section** — Donation allocation breakdown and impact areas
- **Testimonials Section** — Donor reviews and social proof
- **Payment Section** — Dual-payment interface (VietQR + PayPal)
  - VietQR bank transfer with dynamic QR code generation
  - PayPal Donate Button via official SDK
  - Tabbed interface with ARIA accessibility
  - Copy-to-clipboard functionality for account number
- **FAQ Section** — Expandable accordion with frequently asked questions
- **Footer Section** — Custom footer with links and copyright

#### Styling System
- Mobile-first responsive CSS with `clamp()` for fluid typography
- CSS custom properties (design tokens) for colors, spacing, shadows
- Semantic component naming (BEM-inspired: `.donate-*`)
- Scoped styling under `.donate-page` to prevent LearnPress conflicts
- Inter font from Google Fonts (preconnected for performance)
- Full accessibility support with proper color contrast (WCAG AA)

#### JavaScript Features
- **FAQ Accordion** — Click to expand/collapse questions with smooth animation
  - ARIA-compliant with `aria-expanded` and `aria-label`
  - Dynamic `maxHeight` animation for content
- **Payment Tab Switching** — Bank vs. PayPal selection
  - ARIA tabs pattern (`role="tab"`, `role="tabpanel"`)
  - Arrow key navigation (left/right between tabs)
  - Keyboard focus management
- **Stat Counter Animation** — Numbers count up when scrolled into view
  - IntersectionObserver for efficient visibility detection
  - EaseOutQuad easing function for smooth animation
  - Runs once per page load
- **Smooth Scroll** — Anchor links scroll smoothly to target sections
  - Uses native `scrollIntoView({ behavior: 'smooth' })`
  - Progressive enhancement (works without JS)
- **Copy to Clipboard** — Copy bank account number with one click
  - Modern API: `navigator.clipboard.writeText()`
  - Fallback: `document.execCommand('copy')` for older browsers
  - Feedback: "Copied!" message appears for 2 seconds

#### Configuration System
- WordPress constants in `wp-config.php` for credentials:
  - `TONYTECHLAB_BANK_NAME` — Bank name display
  - `TONYTECHLAB_BANK_BIN` — Bank identifier for QR generation
  - `TONYTECHLAB_ACCOUNT_NUMBER` — Bank account number
  - `TONYTECHLAB_ACCOUNT_HOLDER` — Account holder name
  - `TONYTECHLAB_TRANSFER_NOTE` — Transfer note on QR code
  - `TONYTECHLAB_PAYPAL_BUTTON_ID` — PayPal Donate Button ID
- Fallback placeholder values when constants undefined
- File version caching for CSS/JS cache busting

#### Performance Features
- Conditional asset loading (CSS/JS only on donate page)
- Deferred script loading (footer: true) for faster page load
- Google Fonts preconnect hints in `<head>`
- Image lazy loading (`loading="lazy"` attributes)
- Zero external JavaScript dependencies (vanilla JS)
- Combined CSS/JS: < 15 KB uncompressed

#### Accessibility Features
- Full ARIA landmark and control support
- Semantic HTML: `<section>`, `<main>`, `<dl>/<dt>/<dd>`
- Keyboard navigation (Tab, Arrow keys)
- Focus indicators with outline styling
- Color contrast verified against WCAG AA
- Screen reader optimized

#### PayPal Integration
- Official PayPal Donate SDK enqueued via wp_enqueue_script
- SDK initialized via inline script with button ID from constants
- Renders into `#donate-button-container`
- Supports all major payment methods (credit/debit cards)

#### VietQR Bank Transfer
- Dynamic QR code generation via VietQR API
- QR includes bank BIN, account number, and transfer note
- Responsive layout: QR code on left (mobile: stacked)
- Account number copyable to clipboard
- Hint text for Vietnamese banking app users

### Technical Details

#### Project Structure
```
learnpress-child/
├── functions.php                           (111 lines)
├── style.css                               (parent theme reference)
├── page-templates/
│   ├── template-donate.php                 (28 lines)
│   └── donate-sections/
│       ├── section-hero.php
│       ├── section-mission.php
│       ├── section-stats.php
│       ├── section-funds.php
│       ├── section-testimonials.php
│       ├── section-payment.php             (100 lines, configuration-heavy)
│       ├── section-faq.php
│       └── section-footer.php
└── assets/
    └── donate/
        ├── donate-page.css                 (~400 lines)
        └── donate-page.js                  (~214 lines)
```

#### External Dependencies
- **Google Fonts**: Inter (sans-serif)
- **VietQR API**: QR code generation (`img.vietqr.io`)
- **PayPal SDK**: Official Donate Button (`paypalobjects.com`)
- **WordPress**: LearnPress parent theme, WordPress 5.0+
- **PHP**: 7.4+

#### Browser Support
- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+
- Graceful degradation for older browsers

### Documentation
- Created `docs/codebase-summary.md` — Detailed codebase structure and components
- Created `docs/system-architecture.md` — Architecture diagrams and data flow
- Created `docs/project-changelog.md` — This changelog
- Created `docs/development-roadmap.md` — Future features and phases

### Testing
- Manual testing on mobile (iPhone, Android), tablet, and desktop
- Accessibility testing (NVDA, keyboard navigation)
- Cross-browser testing (Chrome, Firefox, Safari, Edge)
- PayPal SDK integration (sandbox and production modes)
- VietQR QR code generation verification
- All JavaScript features tested with and without console errors

### Breaking Changes
None — this is the initial release.

### Known Issues
1. VietQR API reliability depends on external service availability
2. PayPal SDK requires HTTPS in production (localhost testing uses sandbox)
3. Stat counter animation runs only once per page load (reload to re-trigger)
4. Payment tab selection not persisted across page reloads (by design for privacy)

### Deprecations
None — initial release.

---

## Changelog Format

- **Added**: New features
- **Changed**: Changes to existing functionality
- **Deprecated**: Features marked for removal
- **Removed**: Previously deprecated features now removed
- **Fixed**: Bug fixes
- **Security**: Security vulnerability fixes

---

## Future Release Planning

See `docs/development-roadmap.md` for planned features and phases.

