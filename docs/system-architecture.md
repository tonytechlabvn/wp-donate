# System Architecture

## High-Level Overview

TonyTechLab Donate Landing Page is a WordPress plugin that implements a sophisticated, accessible donation interface. The architecture emphasizes:
- **Theme Agnostic**: Works with any WordPress theme via shortcode
- **Modularity**: 8 independent page sections loaded conditionally
- **Progressive Enhancement**: Functional without JavaScript
- **Performance**: Lightweight CSS/JS with deferred loading
- **Accessibility**: WCAG AA compliant with ARIA support
- **Configurability**: Full admin UI for non-technical configuration
- **Backward Compatibility**: Supports wp-config.php constants for migration

## Architecture Diagram

```
┌─────────────────────────────────────────────────────────────┐
│                     WordPress Core                          │
│            (Theme Hooks, Enqueue System, Settings)         │
└────────────────────────┬────────────────────────────────────┘
                         │
        ┌────────────────┴────────────────┐
        │                                 │
   ┌────▼──────────┐          ┌──────────▼────┐
   │ LearnPress    │          │ Child Theme   │
   │ Parent Theme  │          │ Functions     │
   │               │          │               │
   │ - Base styles │          │ - Asset queue │
   │ - Layouts     │          │ - PayPal SDK  │
   │ - Templates   │          │ - Preconnect  │
   └───────────────┘          └───────┬──────┘
                                      │
        ┌─────────────────────────────┴─────────────────────┐
        │                                                   │
   ┌────▼───────────────┐                      ┌───────────▼──┐
   │  Donate Page       │                      │ Assets       │
   │  Template          │                      │ (CSS/JS)     │
   │                    │                      │              │
   │ ┌────────────────┐ │                      │ CSS Variables│
   │ │ Hero Section   │ │                      │ Mobile-first │
   │ │ Mission        │ │                      │ Responsive   │
   │ │ Stats          │ │                      │              │
   │ │ Funds          │ │◄─────────────────────┤ JS Features │
   │ │ Testimonials   │ │                      │ - FAQ        │
   │ │ Payment        │ │                      │ - Tabs       │
   │ │ FAQ            │ │                      │ - Counter    │
   │ │ Footer         │ │                      │ - Smooth     │
   │ └────────────────┘ │                      │ - Copy       │
   └────────────────────┘                      └──────────────┘
        │
        ├─────────────────┬────────────────────┬───────────────┐
        │                 │                    │               │
   ┌────▼──┐        ┌─────▼────┐         ┌────▼──┐      ┌─────▼────┐
   │ Hero  │        │ Mission  │         │ Stats │      │ Funds    │
   │       │        │          │         │       │      │ Alloca   │
   │ CTA   │        │ Purpose  │         │ Count │      │ tion     │
   │       │        │          │         │       │      │          │
   └───────┘        └──────────┘         └──┬────┘      └──────────┘
                                            │
                                    IntersectionObserver
                                    (animate on scroll)
        │
        ├──────────────────┬──────────────┬─────────────┐
        │                  │              │             │
   ┌────▼──────────┐ ┌────▼───┐  ┌──────▼──┐  ┌──────▼─────┐
   │ Testimonials  │ │ Payment│  │ FAQ    │  │ Footer    │
   │               │ │        │  │        │  │           │
   │ Reviews       │ │ TABS   │  │Accordion│  │ Links     │
   │ Carousel      │ │        │  │        │  │ Copyright │
   └───────────────┘ └────┬───┘  └────────┘  └───────────┘
                          │
                  ┌───────┴────────┐
                  │                │
            ┌─────▼──────┐   ┌─────▼──────┐
            │ VietQR     │   │ PayPal     │
            │ Bank Tab   │   │ Donate     │
            │            │   │ Button SDK │
            │ - QR Code  │   │            │
            │ - Details  │   │ Renders    │
            │ - Copy     │   │ button     │
            └────────────┘   └────────────┘
                  │                │
            ┌─────▼──────────────┬─▼─────────────┐
            │                    │               │
        ┌───▼────────┐    ┌──────▼────┐  ┌─────▼────┐
        │ wp-config  │    │ VietQR    │  │ PayPal   │
        │ Constants  │    │ API       │  │ SDK      │
        │            │    │           │  │          │
        │ Bank info  │    │ Generate  │  │ Initialize│
        │ PayPal ID  │    │ QR codes  │  │ Button   │
        └────────────┘    └───────────┘  └──────────┘
```

## Data Flow

### Page Load Sequence

```
1. WordPress Theme Initialization
   ├─ Load parent LearnPress theme
   ├─ Load child theme functions.php
   │  ├─ Register wp_enqueue_scripts hook
   │  ├─ Register wp_head hook (preconnect)
   │  └─ Check: is_page_template('page-templates/template-donate.php')?
   └─ If Donate template:
       ├─ Enqueue Google Fonts (preconnect)
       ├─ Enqueue donate-page.css
       ├─ Enqueue donate-page.js (footer)
       └─ Enqueue PayPal SDK (footer)

2. Template Rendering
   ├─ get_header() — WordPress header
   ├─ Load 8 section components sequentially:
   │  ├─ section-hero.php
   │  ├─ section-mission.php
   │  ├─ section-stats.php
   │  ├─ section-funds.php
   │  ├─ section-testimonials.php
   │  ├─ section-payment.php (reads wp-config constants)
   │  ├─ section-faq.php
   │  └─ section-footer.php
   └─ get_footer() — WordPress footer

3. CSS Parsing
   ├─ Load parent theme styles (LearnPress)
   ├─ Load Google Fonts (Inter)
   └─ Load donate-page.css
       └─ All rules scoped under .donate-page

4. DOM Ready (DOMContentLoaded event)
   ├─ Initialize FAQ accordion handlers
   ├─ Initialize payment tab switching
   ├─ Initialize stat counter animation setup
   ├─ Initialize smooth scroll for anchors
   └─ Initialize copy-to-clipboard buttons

5. User Interaction
   ├─ Scroll into Stats section
   │  └─ IntersectionObserver triggers counter animation
   ├─ Click FAQ question
   │  └─ Expand/collapse answer (maxHeight animation)
   ├─ Click payment tab
   │  └─ Switch active tab panel
   ├─ Click copy button
   │  └─ Copy text, show "Copied!" feedback (2s)
   └─ Click anchor link
       └─ Smooth scroll to target section
```

### Configuration Data Flow

```
Plugin Activation
    │
    ├─ Check wp-config.php constants
    │   └─ If defined: Import → wp_options (first activation only)
    │
    └─ Create 9 default wp_options rows:
        ├─ tonytechlab_hero
        ├─ tonytechlab_mission
        ├─ tonytechlab_stats
        ├─ tonytechlab_funds
        ├─ tonytechlab_testimonials
        ├─ tonytechlab_payment
        ├─ tonytechlab_faq
        ├─ tonytechlab_footer
        └─ tonytechlab_design

WordPress Admin (Settings > TonyTechLab Donate)
    │
    ├─ 9 tabs (Hero, Mission, Stats, Funds, Testimonials, Payment, FAQ, Footer, Design)
    ├─ Edit/save settings → wp_options
    └─ Color/font changes → injected into CSS variables

Shortcode Rendering [tonytechlab_donate]
    │
    ├─ Read all 9 wp_options
    ├─ Fallback to wp-config.php constants if options undefined
    ├─ Render 8 sections (each reads corresponding option)
    │   └─ section-payment.php reads tonytechlab_payment option
    │       ├─ Generate VietQR URL: img.vietqr.io/image/{BIN}-{ACCOUNT}-compact.jpg
    │       └─ Initialize PayPal SDK with button ID
    │
    └─ Inject CSS variables inline
        ├─ --donate-primary (from tonytechlab_design)
        ├─ --donate-secondary
        ├─ --donate-text-color
        └─ --donate-font-family
```

## Component Architecture

### Section Components (Page Modules)

Each section is a standalone PHP file included by the main template. Design principles:
- **Encapsulation**: Each file manages its own markup and microdata
- **No Interdependencies**: Sections don't reference each other (can reorder)
- **Semantic HTML**: Proper heading hierarchy, ARIA landmarks
- **Responsive**: All use `.donate-container` for max-width and centering

**Payment Section Special Case**
- Reads configuration from wp-config.php constants
- Generates QR code URL dynamically
- Implements ARIA tabs pattern for Bank/PayPal switching
- Copy button tied to bank account number

### Asset Structure

**CSS (donate-page.css)**
- Global variables at `:root` (CSS custom properties)
- `.donate-page` namespace prevents conflicts with LearnPress
- Mobile-first responsive design
- Scoped component classes:
  - `.donate-hero`, `.donate-mission`, `.donate-stats`, etc.
  - `.donate-btn`, `.donate-tabs`, `.donate-faq__*`, `.donate-bank`, `.donate-paypal`
- Uses `clamp()` for fluid typography/spacing
- Interactive states: `.is-open`, `.is-active`, `.is-copied`

**JavaScript (donate-page.js)**
- Single-file, IIFE pattern to avoid globals
- Five independent feature modules
- Uses modern APIs with fallbacks:
  - `IntersectionObserver` for stat animation (skips if unavailable)
  - `navigator.clipboard.writeText()` with `document.execCommand()` fallback
  - `Element.scrollIntoView()` for smooth scroll
- All event listeners scoped to `.donate-page` container
- No external dependencies

### Theme Integration

**LearnPress Parent Theme**
- Provides base styles, typography, spacing
- Child theme inherits all parent functionality
- Donate page CSS scoped to avoid overriding LearnPress styles
- Functions.php enqueues parent styles before child styles

**WordPress Hooks**
- `wp_enqueue_scripts` — conditional asset loading
- `wp_head` — preconnect hints for Google Fonts
- `wp_add_inline_script()` — PayPal button initialization

## Data Storage & Configuration

### Configuration Points

| Configuration | Location | Type | Purpose |
|---|---|---|---|
| Bank Name | `TONYTECHLAB_BANK_NAME` | wp-config.php constant | Display bank name in details |
| Bank BIN | `TONYTECHLAB_BANK_BIN` | wp-config.php constant | Generate VietQR code URL |
| Account Number | `TONYTECHLAB_ACCOUNT_NUMBER` | wp-config.php constant | Display & copy-to-clipboard |
| Account Holder | `TONYTECHLAB_ACCOUNT_HOLDER` | wp-config.php constant | Display in bank details |
| Transfer Note | `TONYTECHLAB_TRANSFER_NOTE` | wp-config.php constant | Include in QR code metadata |
| PayPal Button ID | `TONYTECHLAB_PAYPAL_BUTTON_ID` | wp-config.php constant | Initialize PayPal SDK |

### No Database Dependencies
- Configuration stored only in wp-config.php
- Section content (hero text, mission statement, FAQs, testimonials) hardcoded in section files
- Future enhancement: move to WordPress options/settings for UI management

## Security Considerations

### Input Handling
- All configuration constants read via `defined()` checks
- PayPal button ID escaped via `esc_js()` in inline script
- Bank details escaped via `esc_html()` and `esc_attr()`
- VietQR transfer note URL-encoded via `rawurlencode()`
- Section content treated as trusted (admin-controlled)

### External API Integration
- VietQR API (img.vietqr.io) — public, no authentication
- PayPal SDK (paypalobjects.com) — official CDN, loaded over HTTPS
- Google Fonts (googleapis.com) — public CDN, preconnect optimization

### Cross-Domain Considerations
- VietQR and PayPal SDKs loaded from external CDNs
- Browser CORS/CSPO policies may restrict some interactions
- PayPal requires HTTPS in production (localhost testing uses sandbox)

## Performance Optimizations

### Asset Loading
- **Conditional Enqueuing**: CSS/JS only loaded on donate template
- **Deferred Scripts**: All JS loaded in footer (`true` parameter) for faster DOM rendering
- **File Versioning**: Uses `filemtime()` for cache busting
- **Google Fonts Preconnect**: HTTP/2 preconnect hints reduce font download latency

### Rendering Performance
- **Single-Pass Layout**: JavaScript avoids forced reflows
- **IntersectionObserver**: Stat counter animation triggers only when visible (not on load)
- **Lazy Image Loading**: Images use `loading="lazy"` attribute
- **CSS Animations**: Use GPU-accelerated transforms (smooth scroll, hover effects)

### Bundle Sizes
- CSS: ~12.5 KB (minimized: ~8 KB)
- JS: ~8 KB (minimized: ~5 KB)
- Combined: < 15 KB for functionality

## Scalability & Extensibility

### Adding New Sections
1. Create `page-templates/donate-sections/section-{name}.php`
2. Add `<?php require $sections_dir . '/section-{name}.php'; ?>` to template
3. Add CSS rules to `.donate-{name}` in donate-page.css
4. Add JS handlers if interactive (append to donate-page.js)

### Customization Points
- **Colors**: Modify CSS variables at `:root` in donate-page.css
- **Fonts**: Change `--donate-font` variable or enqueue different font
- **Layout**: Modify `.donate-container` max-width and section padding
- **Copy**: Edit section content files directly
- **Functionality**: Add new feature module to donate-page.js

### Migration to Plugin
- Archive `learnpress-child/` as standalone plugin if needed
- Update asset paths from `get_stylesheet_directory_uri()` to `plugin_dir_url()`
- Register as custom post type or WordPress page template
- No database schema required for migration

## Testing Strategy

### Manual Testing
- Test on mobile, tablet, desktop
- Test with/without JavaScript enabled
- Test payment tab switching (keyboard + mouse)
- Test FAQ accordion (all items)
- Test stat counter visibility (scroll trigger)
- Test copy-to-clipboard functionality
- Verify PayPal SDK initializes (sandbox mode on localhost)

### Accessibility Testing
- Screen reader (NVDA, JAWS, VoiceOver)
- Keyboard navigation (Tab, Arrow keys)
- Color contrast verification (WCAG AA)
- Focus indicators visibility

### Browser Support Validation
- Chrome, Firefox, Safari, Edge (latest versions)
- Test graceful degradation (no JS, no IntersectionObserver)
- Verify PayPal SDK loads correctly

## Future Architecture Enhancements

1. **Move Configuration to WordPress Settings Panel**
   - Admin UI for bank/PayPal credentials
   - Reduces wp-config.php pollution
   - Allows non-technical admins to configure

2. **Content Management**
   - Move section content (hero text, FAQs, testimonials) to WordPress post types
   - Enable easy editing without code knowledge

3. **Analytics Integration**
   - Track donation button clicks
   - Monitor section visibility (heatmap)
   - Attribution tracking (referral source)

4. **Multi-Language Support**
   - Wrap strings with `__()` i18n functions
   - Create language files for Vietnamese, English, etc.

5. **Additional Payment Methods**
   - Stripe integration
   - Apple Pay / Google Pay
   - 2Checkout for international support

6. **Donation Receipts**
   - Automated email generation
   - PDF receipt generation
   - Thank-you page redirect
