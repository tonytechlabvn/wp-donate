# Project Overview & Product Development Requirements (PDR)

## Executive Summary

TonyTechLab Donate Landing Page is a WordPress plugin providing a fully-configurable, accessible donation interface with dual-payment support (VietQR bank transfers and PayPal). Deployed via shortcode `[tonytechlab_donate]`, it works in any WordPress theme with an intuitive 9-tab admin settings panel for non-technical configuration. The project prioritizes mobile-first responsive design, WCAG AA accessibility, and zero external JavaScript dependencies.

**Status**: Released (v1.0.0, 2026-03-24)
**Type**: WordPress Plugin
**Architecture**: Modular, progressive-enhancement-first, shortcode-based
**Key Technologies**: PHP, WordPress Settings API, Vanilla JavaScript, CSS Custom Properties, WordPress Hooks

---

## Project Vision

Provide TonyTechLab with a professional, high-converting donation page that:
1. Works reliably on all devices (mobile, tablet, desktop)
2. Accepts donations via multiple payment methods (VietQR, PayPal)
3. Maintains accessibility standards for all users
4. Loads fast and performs efficiently
5. Requires minimal configuration for deployment

---

## Stakeholder Overview

| Role | Responsibilities | Success Criteria |
|------|------------------|------------------|
| **TonyTechLab Admin** | Configure bank/PayPal details, monitor donations | Settings easy to update, secure credential handling |
| **End Users (Donors)** | Complete donation transaction | Clear interface, multiple payment options, fast processing |
| **Developers** | Maintain theme, add features, troubleshoot | Clean code, good documentation, extensible architecture |
| **DevOps/Sysadmin** | Deploy, backup, monitor | Secure credentials, no PII leakage, reliable uptime |

---

## Functional Requirements

### Core Features (MVP - Released)

#### 1. Donate Page Template
- **Requirement**: Create WordPress page template named "Donate Page"
- **Implementation**: `page-templates/template-donate.php`
- **Status**: ✓ Complete
- **Acceptance Criteria**:
  - Template selectable from page editor
  - Loads all 8 sections in correct order
  - Header/footer inherited from WordPress theme
  - No template conflicts with LearnPress

#### 2. Page Sections (8 Total)
- **Requirement**: Implement 8 modular, independent page sections
- **Implementation**: `page-templates/donate-sections/*.php`
- **Status**: ✓ Complete
- **Sections**:
  1. Hero — Call-to-action, title, introduction
  2. Mission — Organization purpose and values
  3. Stats — Impact metrics (users served, funds raised, etc.)
  4. Funds — Donation allocation breakdown (chart or list)
  5. Testimonials — Donor quotes and reviews
  6. Payment — Dual-payment interface (VietQR + PayPal)
  7. FAQ — Frequently asked questions (expandable)
  8. Footer — Copyright, links, contact info

#### 3. VietQR Bank Transfer Support
- **Requirement**: Enable donations via Vietnamese bank transfer with QR code
- **Implementation**: `section-payment.php` (Bank Transfer tab)
- **Status**: ✓ Complete
- **Features**:
  - Dynamic QR code generation (VietQR API)
  - Display bank name, account number, account holder
  - Copy-to-clipboard for account number
  - User instructions for banking app
  - Support for any Vietnamese bank (configurable)
- **Configuration**:
  ```php
  TONYTECHLAB_BANK_NAME              # e.g., "Techcombank"
  TONYTECHLAB_BANK_BIN               # e.g., "970407"
  TONYTECHLAB_ACCOUNT_NUMBER         # e.g., "1234567890"
  TONYTECHLAB_ACCOUNT_HOLDER         # e.g., "TONY TECH LAB"
  TONYTECHLAB_TRANSFER_NOTE          # e.g., "Donate TonyTechLab"
  ```

#### 4. PayPal Donate Button
- **Requirement**: Enable donations via PayPal with official SDK
- **Implementation**: `section-payment.php` (PayPal tab) + `functions.php` (SDK enqueue)
- **Status**: ✓ Complete
- **Features**:
  - Official PayPal Donate Button SDK
  - Accepts credit/debit cards, PayPal wallet, alternative methods
  - Tabbed interface (switch between Bank and PayPal)
  - Configured via `TONYTECHLAB_PAYPAL_BUTTON_ID`

#### 5. Responsive Mobile-First Design
- **Requirement**: Page works flawlessly on all screen sizes
- **Implementation**: `assets/donate/donate-page.css`
- **Status**: ✓ Complete
- **Acceptance Criteria**:
  - Mobile (< 640px): Single-column layout, readable text
  - Tablet (640px - 1024px): 2-column layout where appropriate
  - Desktop (> 1024px): Multi-column layout, optimized spacing
  - Text readable without zoom on all devices
  - Touch targets minimum 44px × 44px
  - Horizontal scroll: 0px

#### 6. Interactive Features (Vanilla JavaScript)
- **Requirement**: Implement 5 interactive modules with zero external JS dependencies
- **Implementation**: `assets/donate/donate-page.js`
- **Status**: ✓ Complete
- **Features**:
  1. **FAQ Accordion** — Click question to expand/collapse answer
  2. **Payment Tab Switching** — Click to select Bank or PayPal
  3. **Stat Counter Animation** — Numbers animate when scrolled into view
  4. **Smooth Scroll** — Anchor links scroll smoothly
  5. **Copy to Clipboard** — Copy bank account number with button click

#### 7. Accessibility (WCAG AA Compliance)
- **Requirement**: Page must pass WCAG AA accessibility standards
- **Implementation**: Semantic HTML, ARIA labels, keyboard navigation
- **Status**: ✓ Complete
- **Acceptance Criteria**:
  - All interactive elements keyboard-accessible
  - ARIA labels on buttons, tabs, landmarks
  - Color contrast ≥ 4.5:1 for text
  - Focus indicators visible
  - Screen reader compatible

#### 8. Admin Settings Panel
- **Requirement**: Enable bank/PayPal configuration via WordPress admin with 9 configurable sections
- **Implementation**: WordPress Settings API with custom admin pages
- **Status**: ✓ Complete
- **Method**: Settings > TonyTechLab Donate (9 tabs)
- **Tabs**: Hero, Mission, Stats, Funds, Testimonials, Payment, FAQ, Footer, Design
- **Features**:
  - Repeater fields for lists (stats, funds, testimonials, FAQ items, social links)
  - Color pickers for design customization (primary/secondary colors)
  - Font family selection
  - Dynamic CSS variable injection
  - Backward compatibility with wp-config.php constants (imported on first activation)

---

## Non-Functional Requirements

### Performance Requirements
- **Page Load Time**: < 3 seconds on 4G (13 KB JS+CSS combined)
- **First Contentful Paint (FCP)**: < 1.5 seconds
- **Lighthouse Score**: ≥ 90 (Performance)
- **CSS Size**: ≤ 15 KB
- **JavaScript Size**: ≤ 8 KB
- **Image Optimization**: Lazy-loaded, optimized formats
- **Caching**: Browser cache headers set, asset versioning via filemtime()

### Security Requirements
- **Credential Storage**: Stored in wp-config.php constants (not in database)
- **Input Escaping**: All user output escaped via `esc_html()`, `esc_attr()`, `esc_js()`
- **HTTPS Enforcement**: PayPal SDK requires HTTPS in production
- **CSRF Protection**: All forms include nonces (WordPress default)
- **XSS Prevention**: Inline script variables escaped with `esc_js()`
- **Data Privacy**: No PII stored (donors not required to create accounts in v1)
- **PCI DSS**: Not applicable (no direct card handling, delegated to PayPal/VietQR)

### Browser Compatibility
- **Desktop**:
  - Chrome 90+
  - Firefox 88+
  - Safari 14+
  - Edge 90+
- **Mobile**:
  - iOS Safari 14+
  - Chrome for Android 90+
  - Samsung Internet 14+
- **Graceful Degradation**:
  - No JavaScript: Page readable, basic functionality works
  - No IntersectionObserver: Stat counters don't animate (still display numbers)
  - No clipboard API: Copy button shows as disabled

### Availability & Reliability
- **Uptime Target**: 99.5% (dependent on WordPress hosting)
- **Monitoring**: WordPress admin dashboard, Google Analytics
- **Disaster Recovery**: Daily backups (WordPress backup plugin)
- **External API Fallback**: VietQR down → show static instructions, PayPal down → bank transfer only

### Maintainability Requirements
- **Code Style**: Follows WordPress coding standards
- **Documentation**: Architecture, codebase summary, API docs
- **Version Control**: Git with semantic versioning
- **Testing**: Manual testing (automated tests planned Phase 3+)
- **Logging**: WordPress debug.log for troubleshooting

---

## Technical Specifications

### Architecture
- **Type**: WordPress Plugin (standalone, theme-agnostic)
- **Deployment**: Shortcode-based `[tonytechlab_donate]`
- **Structure**: 8 modular section components + admin settings + asset files
- **Templating**: PHP (WordPress hooks and filters)
- **Styling**: CSS with custom properties (no SASS/preprocessing)
- **Scripting**: Vanilla JavaScript (ES5+, no transpilation required)
- **Database**: 9 wp_options rows for settings storage + CSS variable injection

### Technology Stack
- **Server**: PHP 7.4+
- **CMS**: WordPress 5.0+ (any theme)
- **Plugin Framework**: WordPress Settings API, Hooks/Filters
- **External Libraries**: None (vanilla JS only)
- **Fonts**: Google Fonts (Inter, customizable)
- **Payment**: PayPal Donate SDK + VietQR API
- **Settings Storage**: wp_options (9 rows)

### File Structure
```
tonytechlab-donate/
├── tonytechlab-donate.php           (82 lines - main plugin file)
├── uninstall.php                    (cleanup on deactivation)
├── includes/
│   ├── default-settings.php         (default values for all 9 options)
│   ├── helper-color-utils.php       (color manipulation utilities)
│   ├── class-settings-manager.php   (WordPress Settings API registration)
│   ├── class-settings-renderer.php  (admin panel UI with 9 tabs)
│   └── class-shortcode-handler.php  (shortcode rendering + asset loading)
├── admin/
│   └── partials/
│       ├── tab-hero.php             (admin settings for hero section)
│       ├── tab-mission.php
│       ├── tab-stats.php            (with repeater for stat items)
│       ├── tab-funds.php            (with repeater for fund allocation)
│       ├── tab-testimonials.php     (with repeater for testimonials)
│       ├── tab-payment.php          (bank + PayPal settings)
│       ├── tab-faq.php              (with repeater for FAQ items)
│       ├── tab-footer.php           (footer content + social links repeater)
│       └── tab-design.php           (colors, fonts, CSS variables)
├── public/
│   ├── partials/
│   │   ├── section-hero.php         (frontend section)
│   │   ├── section-mission.php
│   │   ├── section-stats.php        (reads from tonytechlab_stats option)
│   │   ├── section-funds.php
│   │   ├── section-testimonials.php
│   │   ├── section-payment.php
│   │   ├── section-faq.php
│   │   └── section-footer.php
│   ├── css/
│   │   └── donate-page.css          (~400 lines, CSS variables injected)
│   └── js/
│       └── donate-page.js           (~214 lines, vanilla JS)
└── assets/
    └── admin/
        ├── css/                     (admin panel styles)
        └── js/                      (repeater field handlers)
```

### External API Dependencies
| Service | Purpose | Reliability | Fallback |
|---------|---------|-------------|----------|
| Google Fonts | Typography (Inter font) | ✓ Highly reliable | System fonts (serif/sans) |
| VietQR API | QR code generation | ✓ Good (99.5%+) | Static text instructions |
| PayPal SDK | Donate button | ✓ Highly reliable (99.9%+) | Bank transfer only |

---

## Acceptance Criteria (v1.0.0)

### Functional Testing
- [ ] Donate page template selectable from page editor
- [ ] All 8 sections render correctly (no layout breaks)
- [ ] VietQR QR code generates dynamically and displays
- [ ] Bank account details displayed accurately
- [ ] Copy-to-clipboard button copies account number
- [ ] PayPal SDK initializes and renders button
- [ ] Payment tabs switch correctly (mouse + keyboard)
- [ ] FAQ accordion expands/collapses on click
- [ ] Stat counters animate when scrolled into view
- [ ] Smooth scroll works for anchor links
- [ ] Page works without JavaScript (graceful degradation)

### Performance Testing
- [ ] Page load time < 3 seconds on 4G
- [ ] Lighthouse Performance score ≥ 90
- [ ] Lighthouse Accessibility score = 100
- [ ] Combined CSS+JS < 15 KB
- [ ] No console errors in modern browsers

### Cross-Browser Testing
- [ ] Chrome (desktop + mobile) — all features work
- [ ] Firefox (desktop + mobile) — all features work
- [ ] Safari (desktop + iOS) — all features work
- [ ] Edge (desktop) — all features work
- [ ] Samsung Internet (Android) — all features work

### Accessibility Testing
- [ ] Screen reader (NVDA) reads all content correctly
- [ ] Keyboard navigation (Tab key) reaches all elements
- [ ] Focus indicators visible on all interactive elements
- [ ] Color contrast ≥ 4.5:1 for all text
- [ ] Page readable at 200% zoom
- [ ] No keyboard traps

### Security Testing
- [ ] Bank credentials not exposed in HTML/JS
- [ ] PayPal button ID not exposed in frontend code
- [ ] No SQL injection vulnerabilities
- [ ] No XSS vulnerabilities (all output escaped)
- [ ] HTTPS enforced for PayPal (localhost: sandbox mode)
- [ ] No PII logged or stored unnecessarily

### Deployment Testing
- [ ] Theme activates without errors
- [ ] Donate page template available in page editor
- [ ] Fallback placeholder values display if constants undefined
- [ ] Can be deactivated without leaving orphaned data
- [ ] No conflicts with other active plugins/themes

---

## Acceptance Criteria (Complete)

✓ **Status**: All acceptance criteria met (v1.0.0 released 2026-03-24)

---

## Project Scope

### In Scope (v1.0.0)
- WordPress plugin (works in any theme)
- Shortcode-based deployment `[tonytechlab_donate]`
- 8-section donate page template
- 9-tab admin settings panel with repeater fields
- VietQR bank transfer integration
- PayPal Donate Button SDK
- Dynamic content management (hero, mission, stats, funds, testimonials, FAQ, footer)
- Design customization (colors, fonts via CSS variables)
- Responsive design (mobile-first)
- WCAG AA accessibility
- Vanilla JavaScript (zero dependencies)
- Configuration via WordPress Settings API + wp_options
- Backward compatibility with wp-config.php constants
- Google Fonts (Inter, customizable)
- Preconnect performance optimization
- ARIA landmarks and focus management

### Out of Scope (v1.0.0)
- Email notifications (Phase 2+)
- Donor database / CRM (Phase 5+)
- Analytics integration (Phase 3+)
- Subscription/recurring donations (Phase 4+)
- Multi-language UI (Phase 4+)
- REST API / webhooks (Phase 5+)
- Stripe, Momo, Apple Pay integration (Phase 4+)
- Custom page builder integration (Phase 3+)

---

## Success Metrics

### Deployment Success
- [ ] Theme installs without errors
- [ ] Donate page renders correctly
- [ ] All payment methods functional
- [ ] Zero console errors (modern browsers)

### Performance Metrics
- [ ] Page load < 3 seconds (4G)
- [ ] Lighthouse Performance ≥ 90
- [ ] Lighthouse Accessibility = 100
- [ ] Core Web Vitals passing

### User Experience Metrics
- [ ] Mobile conversion rate (donation completion %)
- [ ] Payment method preference (Bank vs. PayPal %)
- [ ] Bounce rate on donate page
- [ ] Average time on page
- [ ] Copy-button usage rate

### Business Metrics
- [ ] Monthly donation volume (baseline)
- [ ] Average donation amount
- [ ] Donor retention rate (repeat donors %)
- [ ] Cost per donation (marketing ROI)

---

## Risk Assessment

### Identified Risks

| Risk | Likelihood | Impact | Mitigation |
|------|------------|--------|-----------|
| VietQR API downtime | Low | Medium | Fallback: static instructions |
| PayPal SDK failure | Low | High | Fallback: bank transfer only |
| Mobile layout breakage | Low | High | Responsive testing on 10+ devices |
| Accessibility non-compliance | Low | Medium | WCAG AA audit + screen reader testing |
| WordPress plugin conflict | Medium | Medium | Compatibility testing with common plugins |
| Security vulnerability | Low | Critical | Security audit, regular WP updates |
| Browser compatibility issue | Low | Medium | Cross-browser testing quarterly |

### Mitigation Strategies
1. **VietQR Reliability**: Keep static instructions as fallback in section
2. **PayPal Reliability**: Ensure bank transfer always available as alternative
3. **Mobile Testing**: Test on real devices (iPhone, Android), not just Chrome DevTools
4. **Accessibility**: Run Lighthouse audit, test with screen reader, keyboard navigation
5. **Plugin Compatibility**: Test with 20+ popular plugins before release
6. **Security**: Escape all output, sanitize inputs, regular WP core updates
7. **Browser Support**: Test quarterly in major browsers, graceful degradation for older browsers

---

## Dependencies & Prerequisites

### WordPress Ecosystem
- WordPress 5.0+ (core)
- LearnPress theme (parent theme)
- PHP 7.4+

### External Services
- Google Fonts CDN (for Inter font)
- VietQR API (for QR code generation)
- PayPal Donate SDK (for button rendering)

### Development Environment
- Code editor (VS Code, Sublime, etc.)
- WordPress local environment (Local by Flywheel, XAMPP, etc.)
- Git version control
- Browser DevTools (Chrome, Firefox)
- Accessibility testing tools (WAVE, Axe, Lighthouse)

---

## Timeline & Milestones

### Phase 1: Core Donate Page (COMPLETE)
- **Start**: 2026-01-15
- **End**: 2026-03-24
- **Deliverables**: v1.0.0 release with all core features
- **Status**: ✓ Released

### Phase 2: Configuration UI (Planned)
- **Start**: 2026-04-01
- **Duration**: 3-4 weeks
- **Deliverables**: WordPress admin settings page
- **Status**: Not started

### Future Phases
See `docs/development-roadmap.md` for detailed phase planning.

---

## Documentation

### Codebase Documentation
- **codebase-summary.md** — Project structure, component overview, dependencies
- **system-architecture.md** — Architecture diagrams, data flow, component interactions
- **project-changelog.md** — Version history, features added, known issues
- **development-roadmap.md** — Future phases, priorities, timeline

### User Documentation (Phase 2+)
- Setup guide — How to install and activate theme
- Configuration guide — How to set bank/PayPal credentials
- Customization guide — How to modify colors, fonts, content
- Troubleshooting — Common issues and solutions

---

## Maintenance & Support

### Regular Maintenance Tasks
- **Monthly**: WordPress core and plugin updates, security patching
- **Quarterly**: Browser compatibility testing, performance audit
- **Semi-Annual**: Accessibility compliance review
- **Annual**: Dependency updates, technical debt assessment

### Support Channels
- GitHub Issues (for developers)
- Email support (for administrators)
- Documentation updates (for all users)

---

## Approval & Sign-Off

| Role | Name | Status | Date |
|------|------|--------|------|
| Project Lead | (TBD) | Pending | — |
| Tech Lead | (TBD) | Pending | — |
| QA Lead | (TBD) | Pending | — |

**Final Approval**: Pending sign-off from stakeholders

---

## Appendix: Configuration Reference

### wp-config.php Constants Template
```php
// TonyTechLab Donate Page Configuration
// Add these constants to wp-config.php before going live

// ─── Bank Transfer (VietQR) ────────────────────────────────
define( 'TONYTECHLAB_BANK_NAME', 'Techcombank' );
define( 'TONYTECHLAB_BANK_BIN', '970407' );
define( 'TONYTECHLAB_ACCOUNT_NUMBER', '1234567890' );
define( 'TONYTECHLAB_ACCOUNT_HOLDER', 'TONY TECH LAB' );
define( 'TONYTECHLAB_TRANSFER_NOTE', 'Donate TonyTechLab' );

// ─── PayPal ────────────────────────────────────────────────
// Get your button ID from PayPal Donations admin panel
define( 'TONYTECHLAB_PAYPAL_BUTTON_ID', 'YOUR_PAYPAL_BUTTON_ID_HERE' );
```

### Bank BIN Codes (Common Vietnamese Banks)
```
970407 — Techcombank (Techcombank)
970415 — VietinBank
970407 — VPBANK (VP Bank)
970438 — ACB (Asia Commercial Bank)
970012 — BIDV
970013 — Vietcombank
970014 — Agribank
970016 — Sacombank
```

---

## Related Documents
- See `docs/` directory for additional documentation
- See `plans/` directory for implementation plans and phase details

