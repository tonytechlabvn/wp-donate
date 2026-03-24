# Codebase Summary

## Overview

TonyTechLab Donate Landing Page is a WordPress plugin providing a fully-configurable donation interface with dual-payment support (VietQR bank transfers and PayPal). Deployed via shortcode `[tonytechlab_donate]`, it works with any WordPress theme and features an intuitive 9-tab admin settings panel for managing all content, colors, and payment options. The implementation prioritizes performance, accessibility, mobile-first responsive design, and ease of use for non-technical administrators.

## Project Structure

```
tonytechlab-donate/
├── tonytechlab-donate.php                    # Main plugin file (activation hooks, init)
├── uninstall.php                            # Cleanup on plugin deletion
├── includes/
│   ├── default-settings.php                 # Default values for 9 wp_options
│   ├── helper-color-utils.php               # Color manipulation utilities
│   ├── class-settings-manager.php           # WordPress Settings API registration
│   ├── class-settings-renderer.php          # Admin panel rendering (9 tabs)
│   └── class-shortcode-handler.php          # Shortcode [tonytechlab_donate] handler
├── admin/
│   └── partials/
│       ├── tab-hero.php                     # Hero section admin settings
│       ├── tab-mission.php                  # Mission section admin settings
│       ├── tab-stats.php                    # Stats (repeater field for items)
│       ├── tab-funds.php                    # Fund allocation (repeater field)
│       ├── tab-testimonials.php             # Testimonials (repeater field)
│       ├── tab-payment.php                  # Bank + PayPal credentials
│       ├── tab-faq.php                      # FAQ items (repeater field)
│       ├── tab-footer.php                   # Footer content + social links (repeater)
│       └── tab-design.php                   # Colors, fonts, CSS variable config
├── public/
│   ├── partials/
│   │   ├── section-hero.php                 # Frontend hero section
│   │   ├── section-mission.php              # Frontend mission section
│   │   ├── section-stats.php                # Frontend stats (reads tonytechlab_stats option)
│   │   ├── section-funds.php                # Frontend funds section
│   │   ├── section-testimonials.php         # Frontend testimonials section
│   │   ├── section-payment.php              # Frontend payment section (VietQR + PayPal)
│   │   ├── section-faq.php                  # Frontend FAQ accordion
│   │   └── section-footer.php               # Frontend footer
│   ├── css/
│   │   └── donate-page.css                  # Frontend styles (12.5+ KB, scoped)
│   └── js/
│       └── donate-page.js                   # Frontend interactivity (8+ KB, vanilla JS)
└── assets/
    └── admin/
        ├── css/                             # Admin panel styles
        └── js/                              # Repeater field handlers, color pickers
```

## Core Components

### Plugin Activation (tonytechlab-donate.php)

**Initialization**
- Registers plugin activation hook `tonytechlab_donate_activate()`
- Populates 9 default wp_options rows on first activation
- Imports wp-config.php constants to options on first activation (backward compatibility)
- Re-activation skips constant import to preserve user edits

**Class Instantiation**
- `TonyTechLab_Donate_Settings_Manager` — Registers WordPress Settings API
- `TonyTechLab_Donate_Settings_Renderer` — Renders admin panel with 9 tabs
- `TonyTechLab_Donate_Shortcode_Handler` — Handles `[tonytechlab_donate]` shortcode

**Hooks**
- `admin_init` — register_settings()
- `admin_menu` — add admin page under Settings
- `admin_enqueue_scripts` — load admin assets (color pickers, repeater fields)
- `init` — register shortcode
- `wp_enqueue_scripts` — conditionally load frontend assets (only if shortcode used)
- `wp_head` — preconnect hints (priority 1)

### Settings Manager (class-settings-manager.php)

**WordPress Settings API Integration**
- Registers 9 settings groups (one per section)
- Each setting is an array stored in wp_options
- Option names: `tonytechlab_hero`, `tonytechlab_mission`, `tonytechlab_stats`, etc.
- Sanitization callbacks for each field type

### Settings Renderer (class-settings-renderer.php)

**Admin Panel UI**
- Creates custom admin page under Settings > TonyTechLab Donate
- Renders 9 tabs (one per content section + design)
- Each tab loads from `admin/partials/tab-{name}.php`
- Tab switching via jQuery (WordPress default)

**Repeater Fields**
- Stats, Funds, Testimonials, FAQ, Footer (social links) use repeater pattern
- Add/remove buttons for each row
- Drag-to-reorder via jQuery (sortable)
- Stores as serialized array in wp_options

### Shortcode Handler (class-shortcode-handler.php)

**Shortcode Registration**
- Registers `[tonytechlab_donate]` shortcode (no attributes required)
- Output buffering to capture section HTML
- Includes 8 section partials in sequence

**Asset Loading**
- Enqueues `donate-page.css` and `donate-page.js` only when shortcode is used
- Uses `wp_enqueue_scripts` hook (early priority to ensure proper ordering)
- Conditional enqueue prevents asset bloat on pages without shortcode
- Google Fonts preconnect hints in `wp_head`

**Section Rendering**
1. Hero — call-to-action with title/subtitle
2. Mission — organizational purpose statement
3. Stats — impact metrics with animation (reads tonytechlab_stats option)
4. Funds — allocation breakdown (reads tonytechlab_funds option)
5. Testimonials — social proof (reads tonytechlab_testimonials option)
6. Payment — tabbed interface (reads tonytechlab_payment option)
7. FAQ — expandable Q&A (reads tonytechlab_faq option)
8. Footer — footer content + social links (reads tonytechlab_footer option)

Each section reads from corresponding wp_option, with fallback to hardcoded defaults.

### Payment Section (public/partials/section-payment.php)

**Bank Transfer (VietQR)**
- Dynamically generates QR code via VietQR API: `img.vietqr.io`
- Configuration via wp_options (tonytechlab_payment):
  - `bank_name` — bank display name (editable in admin)
  - `bank_bin` — bank identifier (6-digit code, e.g., 970407)
  - `account_number` — account number
  - `account_holder` — account holder name
  - `transfer_note` — note displayed on transfer (URL-encoded)
- Fallback to wp-config.php constants if options undefined
- Copy-to-clipboard button for account number
- Hint text guiding users through Vietnamese banking apps

**PayPal Integration**
- Tab-based layout (ARIA tabpanel pattern)
- PayPal SDK initialization in class-shortcode-handler.php
- Reads `paypal_button_id` from tonytechlab_payment option
- Renders into `#donate-button-container`
- Fallback to wp-config.php constant if option undefined

### Styles (public/css/donate-page.css)

**Design System**
- CSS custom properties (--donate-*) for colors, spacing, shadows, fonts
- Mobile-first responsive approach using `clamp()` for fluid typography
- Scoped under `.donate-page` to avoid conflicts with any WordPress theme
- Inter font family loaded via Google Fonts (customizable via admin)

**Customizable Color Palette (via admin Design tab)**
- Primary: `#2563eb` (blue) — customizable
- Secondary: `#f59e0b` (amber) — primary CTA button, customizable
- Text: `#1f2937` (dark gray) — customizable
- Backgrounds: white (`#ffffff`), light gray (`#f9fafb`)
- Font family: Inter (default) — customizable via Design tab

**Dynamic CSS Variable Injection**
- Admin Design tab applies colors/fonts to CSS custom properties
- Injected via inline `<style>` tag in shortcode output
- Allows real-time color/font preview in admin
- Persisted in wp_options for frontend display

**Responsive Breakpoints**
- Mobile-first base styles (< 640px implied)
- CSS `clamp()` for adaptive sizing across all viewport widths
- Flexbox/Grid layout for flexible section layouts

### JavaScript (public/js/donate-page.js)

Five independent interaction modules, all vanilla JS (zero dependencies):

1. **FAQ Accordion** — Expands/collapses Q&A items
   - Reads FAQ items from tonytechlab_faq wp_option
   - ARIA-compliant: `aria-expanded`, `aria-label`
   - Dynamic `maxHeight` animation for smooth open/close
   - CSS class toggling (`is-open`)

2. **Payment Tabs** — Switches between Bank/PayPal
   - Reads bank/PayPal details from tonytechlab_payment option
   - ARIA tabs pattern: `role="tab"`, `role="tabpanel"`, `aria-selected`, `aria-controls`
   - Arrow key navigation (left/right between tabs)
   - Keyboard focus management (`tabindex` manipulation)

3. **Stat Counters** — Animates numbers when scrolled into view
   - Reads stat items from tonytechlab_stats wp_option
   - Uses `IntersectionObserver` (modern API, fallback skip)
   - Easing function: `easeOutQuad()`
   - Resets to 0, animates to `data-target` value
   - Runs once per page load

4. **Smooth Scroll** — Anchor links scroll smoothly to target
   - Intercepts `<a href="#id">` links
   - Uses `Element.scrollIntoView({ behavior: 'smooth' })`
   - Progressive enhancement — works without JS

5. **Copy to Clipboard** — Bank account number copy button
   - Modern API: `navigator.clipboard.writeText()` (HTTPS-only)
   - Fallback: `document.execCommand('copy')` for older browsers
   - Feedback: button text changes to "Copied!" for 2 seconds

**Architecture**
- Self-executing function (IIFE) to avoid global scope pollution
- Progressive enhancement: page functions without JS
- DOMContentLoaded event ensures DOM ready before initialization
- All selectors scoped to `.donate-page` root
- Data attributes (`data-*`) carry values from wp_options to frontend

## Configuration

### WordPress Settings API (Primary)

All settings stored in wp_options as serialized arrays:

**Option: tonytechlab_hero**
- `title` — Page title
- `subtitle` — Subtitle/intro text
- `cta_text` — Call-to-action button label
- `cta_url` — CTA button link

**Option: tonytechlab_mission**
- `title` — Section title
- `content` — Mission statement (HTML)

**Option: tonytechlab_stats** (repeater)
- Array of stat items: `[ { label, value, icon }, ... ]`

**Option: tonytechlab_funds** (repeater)
- Array of fund allocation items: `[ { label, amount, description }, ... ]`

**Option: tonytechlab_testimonials** (repeater)
- Array of testimonials: `[ { author, text, role }, ... ]`

**Option: tonytechlab_payment**
- `bank_name` — Bank display name
- `bank_bin` — Bank identifier (6 digits)
- `account_number` — Account number
- `account_holder` — Account holder name
- `transfer_note` — Transfer note for QR
- `paypal_button_id` — PayPal Donate Button ID

**Option: tonytechlab_faq** (repeater)
- Array of FAQ items: `[ { question, answer }, ... ]`

**Option: tonytechlab_footer** (repeater + fields)
- `copyright` — Copyright text
- `social_links` (repeater) — `[ { label, url, icon }, ... ]`

**Option: tonytechlab_design**
- `primary_color` — Primary color hex (default: #2563eb)
- `secondary_color` — Secondary color hex (default: #f59e0b)
- `text_color` — Text color hex (default: #1f2937)
- `font_family` — Font family name (default: Inter)

### wp-config.php Constants (Backward Compatibility)

Optionally define these constants for first-time configuration (imported on plugin activation):

```php
// Bank Transfer (VietQR)
define( 'TONYTECHLAB_BANK_NAME', 'Techcombank' );
define( 'TONYTECHLAB_BANK_BIN', '970407' );
define( 'TONYTECHLAB_ACCOUNT_NUMBER', '1234567890' );
define( 'TONYTECHLAB_ACCOUNT_HOLDER', 'TONY TECH LAB' );
define( 'TONYTECHLAB_TRANSFER_NOTE', 'Donate TonyTechLab' );

// PayPal
define( 'TONYTECHLAB_PAYPAL_BUTTON_ID', 'YOUR_PAYPAL_BUTTON_ID' );
```

On first activation, plugin imports these constants to wp_options if defined. On subsequent activations, user-edited options are preserved (constants ignored).

## Dependencies

**External APIs**
- Google Fonts (Inter): `https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700`
- VietQR QR Code Generator: `https://img.vietqr.io/image/{BIN}-{ACCOUNT}-compact.jpg`
- PayPal Donate SDK: `https://www.paypalobjects.com/donate/sdk/donate-sdk.js`

**WordPress**
- LearnPress parent theme (required)
- WordPress 5.0+ (for block editor and modern JS APIs)
- PHP 7.4+ (short array syntax, nullsafe operator not used)

## Accessibility

- ARIA labels and landmarks on all interactive elements
- Semantic HTML (section, main, dl/dt/dd for definitions)
- Tab focus management in payment tabs (arrow key navigation)
- Keyboard-accessible accordion expansion
- Color contrast verified against WCAG AA standards
- Deferred fonts prevent flash of unstyled text (FOUT)

## Performance Characteristics

- **CSS**: ~12.5 KB (uncompressed), scoped to avoid global conflicts
- **JS**: ~8 KB (uncompressed), zero external dependencies
- **Images**: Lazy-loaded (VietQR QR code, testimonial images)
- **Fonts**: Preconnected via HTTP/2 link headers, subset to Latin script
- **Render**: Single-pass layout (no forced reflows in JS)

## Browser Support

- Modern browsers (ES5+ syntax):
  - Chrome 90+
  - Firefox 88+
  - Safari 14+
  - Edge 90+
- Graceful degradation:
  - No `IntersectionObserver` → stats counters don't animate
  - No `navigator.clipboard` → fallback to `document.execCommand('copy')`
  - No JS enabled → page still readable, tabs/accordion not functional
  - No CSS variables → fallback to default colors (plugin still works)

## Installation & Activation

1. **Upload Plugin**: Copy `tonytechlab-donate/` to `wp-content/plugins/`
2. **Activate**: Activate from WordPress Plugins admin page
3. **Configure**: Go to Settings > TonyTechLab Donate
4. **Deploy**: Add `[tonytechlab_donate]` shortcode to any page/post

**First Activation**: If wp-config.php constants are defined, they are automatically imported to wp_options. This allows seamless migration from constant-based configuration.

## Known Limitations

1. **VietQR QR Code API**: Relies on external service; QR generation may fail if API is down
2. **PayPal SDK**: Requires HTTPS in production; localhost testing needs sandbox mode
3. **Payment Tab Switching**: State not persisted across page reloads (by design — privacy)
4. **Stat Counter Animation**: Runs only once per page load, not retriggered on scroll back

## Future Considerations

- Move bank constants to WordPress options (Settings panel) for easier configuration
- Add email notifications on donation via WordPress hooks
- Implement donation receipt generation and delivery
- Support for additional payment methods (Stripe, 2Checkout)
- Multi-language support via WordPress i18n functions
- Analytics integration (Google Analytics, Facebook Pixel)
