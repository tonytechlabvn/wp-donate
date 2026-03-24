# Code Standards & Codebase Guidelines

## Overview

This document defines coding standards, architectural patterns, and best practices for the TonyTechLab Donate Landing Page plugin. All developers must adhere to these standards for consistency, maintainability, and quality.

**Plugin Context**: As a standalone WordPress plugin (not a theme), the codebase includes WordPress Settings API integration, admin panel rendering, and shortcode handlers in addition to frontend components.

---

## PHP Standards

### File Organization

**Naming Convention**
- Use kebab-case for file names: `section-payment.php`, `donate-page.css`
- Template files: `template-{purpose}.php`
- Section files: `section-{name}.php`
- Asset files: descriptive names (e.g., `donate-page.js`)

**File Structure**
```php
<?php
/**
 * File description (one line)
 *
 * Detailed description of what this file does,
 * including key responsibilities and dependencies.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Prevent direct file access
}

// ── Helper Functions ──

// ── Main Logic ──

// ── Output/Markup ──
```

### Coding Style

**WordPress Coding Standards**
- Follow [WordPress Coding Standards](https://developer.wordpress.org/plugins/intro/all-about-plugins/) (not WordPress Plugin Handbook)
- Use tabs (not spaces) for indentation
- Line length: 100 characters recommended (hard limit: 120)
- Use double quotes for strings (unless single quotes needed)

**Naming Conventions**
```php
// Plugin file: tonytechlab-donate.php
// All plugin code scoped under 'tonytechlab_donate' or 'ttl_' prefix

// Functions: snake_case with prefix
function tonytechlab_donate_activate() {
    // Activation hook
}

// Classes: PascalCase with prefix
class TonyTechLab_Donate_Settings_Manager {
    // Manages WordPress Settings API
}

// Constants: UPPER_SNAKE_CASE with prefix
define( 'TONYTECHLAB_DONATE_VERSION', '1.0.0' );
define( 'TONYTECHLAB_DONATE_PATH', plugin_dir_path( __FILE__ ) );

// Variables: $lower_snake_case
$bank_name = get_option( 'tonytechlab_payment' )['bank_name'] ?? 'Your Bank';

// wp_options: snake_case with prefix
// tonytechlab_hero, tonytechlab_payment, tonytechlab_design, etc.
```

**Documentation**
```php
/**
 * Brief description of the function.
 *
 * Longer description explaining what the function does,
 * including edge cases and important notes.
 *
 * @param string $bank_name The name of the bank.
 * @param int    $amount    The donation amount in cents.
 *
 * @return string The formatted bank transfer instruction.
 */
function tonytechlab_format_bank_transfer( $bank_name, $amount ) {
    // Function body
}
```

### Security Best Practices

**Input Handling**
```php
// GOOD: Check with isset() before accessing
if ( isset( $_POST['donate_amount'] ) ) {
    $amount = sanitize_text_field( $_POST['donate_amount'] );
}

// GOOD: Sanitize user input
$name = sanitize_text_field( $user_input );
$url = esc_url( $user_input );
$html = wp_kses_post( $user_input );

// BAD: Direct use of superglobals
echo $_POST['name']; // XSS vulnerability!
```

**Output Escaping**
```php
// GOOD: Escape based on context
echo esc_html( $bank_name );                    // HTML context
echo esc_attr( $account_number );               // HTML attribute
echo esc_url( $redirect_url );                  // URL
echo esc_js( $paypal_button_id );               // JavaScript
wp_kses_post( $html_content );                  // HTML with allowed tags

// BAD: No escaping
echo $bank_name;  // Could contain HTML/JS!
```

**Credential Storage**
```php
// GOOD: Use WordPress options (primary method for plugin)
$payment_settings = get_option( 'tonytechlab_payment', array() );
$bank_name = $payment_settings['bank_name'] ?? 'Your Bank Name';

// ACCEPTABLE: Fallback to wp-config.php constants (backward compat)
$bank_name = defined( 'TONYTECHLAB_BANK_NAME' )
    ? TONYTECHLAB_BANK_NAME
    : 'Your Bank Name';

// BAD: Hardcode sensitive data in plugin files
define( 'TONYTECHLAB_BANK_NAME', 'Techcombank' ); // In plugin file!

// BEST PRACTICE: Admin UI for configuration
// Admins edit settings via Settings > TonyTechLab Donate
// Settings are automatically sanitized and validated
```

### Error Handling

**Graceful Fallbacks**
```php
// GOOD: Check if constant exists, fall back to default
if ( defined( 'TONYTECHLAB_BANK_NAME' ) ) {
    $bank_name = TONYTECHLAB_BANK_NAME;
} else {
    $bank_name = 'Your Bank Name'; // Fallback
}

// Or shorter:
$bank_name = defined( 'TONYTECHLAB_BANK_NAME' )
    ? TONYTECHLAB_BANK_NAME
    : 'Your Bank Name';

// GOOD: Check WP function results
$file_path = get_stylesheet_directory() . '/assets/donate/donate-page.css';
if ( file_exists( $file_path ) ) {
    $version = filemtime( $file_path );
}
```

**Error Logging**
```php
// GOOD: Use error_log for debugging (development only)
if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
    error_log( 'PayPal SDK initialized: ' . TONYTECHLAB_PAYPAL_BUTTON_ID );
}

// BAD: var_dump or print_r in production
var_dump( $bank_name );  // Outputs to page!
print_r( $config );      // Outputs to page!
```

### Conditional Loading

**Template Checks**
```php
// GOOD: Check if correct template before enqueuing
if ( ! is_page_template( 'page-templates/template-donate.php' ) ) {
    return; // Exit early if not donate template
}

// Load assets only on donate page
wp_enqueue_style( 'tonytechlab-donate', ... );
wp_enqueue_script( 'tonytechlab-donate', ... );
```

---

## JavaScript Standards

### File Organization

**Naming Convention**
- Use kebab-case: `donate-page.js`, `payment-handler.js`
- Descriptive names that indicate purpose

**File Structure**
```javascript
/**
 * TonyTechLab Donate Page — {Feature Name}
 *
 * Description of what this module does.
 * Key responsibilities and dependencies.
 *
 * Zero dependencies. Progressive enhancement.
 */
(function () {
    'use strict';

    // ── Constants ──
    var SELECTORS = {
        page: '.donate-page',
        faqQuestion: '.donate-faq__question'
    };

    // ── Initialization ──
    function init() {
        initFaqAccordion();
        initPaymentTabs();
    }

    // ── Feature 1: FAQ Accordion ──
    function initFaqAccordion() {
        // Implementation
    }

    // ── Feature 2: Payment Tabs ──
    function initPaymentTabs() {
        // Implementation
    }

    // ── Event Listeners ──
    document.addEventListener('DOMContentLoaded', init);
})();
```

### Coding Style

**Naming Conventions**
```javascript
// Variables: lowerCamelCase
var pageContainer = document.querySelector('.donate-page');
var faqItems = pageContainer.querySelectorAll('.donate-faq__item');

// Constants: UPPER_SNAKE_CASE
var ANIMATION_DURATION = 2000; // ms
var STAT_TARGET_THRESHOLD = 0.3; // 30% visibility

// Functions: lowerCamelCase
function initFaqAccordion() { }
function activateTab(tab) { }

// Classes: PascalCase (if used)
function DonatePageController() { }
```

**Documentation**
```javascript
/**
 * Initialize FAQ accordion expansion/collapse.
 *
 * Finds all FAQ items and attaches click handlers.
 * Expands/collapses answer sections with smooth animation.
 *
 * @returns {void}
 */
function initFaqAccordion() {
    var buttons = page.querySelectorAll('.donate-faq__question');
    buttons.forEach(function (btn) {
        // Implementation
    });
}
```

### Browser Compatibility

**ES5 Compatibility**
- Target ES5 syntax (IE11 and above)
- No arrow functions, destructuring, or const/let (use var)
- Use `var` for all variable declarations
- Use `function` declarations for named functions

```javascript
// GOOD: ES5 compatible
var numbers = [1, 2, 3];
numbers.forEach(function (n) {
    console.log(n);
});

// BAD: ES6+ syntax (may break in older browsers)
const numbers = [1, 2, 3];
numbers.forEach(n => console.log(n));
```

**Feature Detection**
```javascript
// GOOD: Check for feature before using
if ( 'IntersectionObserver' in window ) {
    var observer = new IntersectionObserver(function (entries) {
        // Use IntersectionObserver
    });
} else {
    // Fallback behavior or skip feature
    console.warn( 'IntersectionObserver not supported' );
}

// GOOD: Check for Clipboard API before using
if ( navigator.clipboard && navigator.clipboard.writeText ) {
    navigator.clipboard.writeText( text );
} else {
    // Fallback to execCommand
    document.execCommand( 'copy' );
}
```

### DOM Manipulation

**Selector Efficiency**
```javascript
// GOOD: Cache selectors in variables
var page = document.querySelector( '.donate-page' );
var buttons = page.querySelectorAll( '.donate-btn' );

buttons.forEach(function (btn) {
    // Reuse cached DOM reference
});

// BAD: Repeated selectors (inefficient)
document.querySelectorAll( '.donate-page' ).forEach(function () {
    document.querySelectorAll( '.donate-btn' ).forEach(function () {
        // Querying twice per iteration!
    });
});
```

**Event Delegation**
```javascript
// GOOD: Single listener on parent
var container = document.querySelector( '.donate-faq' );
container.addEventListener( 'click', function (e) {
    if ( e.target.classList.contains( 'donate-faq__question' ) ) {
        // Handle FAQ question click
    }
});

// ACCEPTABLE: Listener on each element (for this project's scale)
page.querySelectorAll( '.donate-faq__question' ).forEach(function (btn) {
    btn.addEventListener( 'click', handleFaqClick );
});
```

### Error Handling

**Defensive Programming**
```javascript
// GOOD: Check for null before accessing
function showCopiedFeedback( btn ) {
    if ( !btn ) return; // Safety check

    var original = btn.textContent;
    btn.textContent = 'Copied!';
    btn.classList.add( 'is-copied' );

    setTimeout(function () {
        if ( btn ) { // Check in case DOM was removed
            btn.textContent = original;
            btn.classList.remove( 'is-copied' );
        }
    }, 2000);
}

// GOOD: Check for element existence
var target = document.querySelector( targetId );
if ( !target ) return; // Exit if target not found
```

**Try-Catch for Risky Operations**
```javascript
// GOOD: Wrap clipboard operation in try-catch
try {
    document.execCommand( 'copy' );
    showCopiedFeedback( btn );
} catch ( err ) {
    console.warn( 'Copy failed:', err );
    // Silently fail, don't break page
}
```

### Performance

**Animation Performance**
```javascript
// GOOD: Use requestAnimationFrame for animations
function animateNumber( el ) {
    var target = parseInt( el.getAttribute( 'data-target' ), 10 );
    var start = performance.now();
    var duration = 2000;

    function tick( now ) {
        var elapsed = now - start;
        var progress = Math.min( elapsed / duration, 1 );
        var value = Math.round( easeOutQuad( progress ) * target );

        el.textContent = value.toLocaleString();

        if ( progress < 1 ) {
            requestAnimationFrame( tick ); // Smooth 60fps animation
        }
    }

    requestAnimationFrame( tick );
}

// GOOD: Use IntersectionObserver for visibility detection
var observer = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
        if ( entry.isIntersecting ) {
            // Element is visible, trigger animation
            animateNumber( entry.target );
        }
    });
});
```

**Memory Management**
```javascript
// GOOD: Remove listeners when done
var observer = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
        if ( entry.isIntersecting && !animated ) {
            animated = true;
            animateNumbers();
            observer.disconnect(); // Clean up
        }
    });
});

// GOOD: Avoid memory leaks with timers
var timeoutId = setTimeout(function () {
    resetButton( btn );
}, 2000);

// If needed, can clear:
// clearTimeout( timeoutId );
```

---

## CSS Standards

### File Organization

**Mobile-First Approach**
```css
/* ── Design Tokens ── */
:root {
    --donate-primary: #2563eb;
    --donate-secondary: #f59e0b;
    --donate-text: #1f2937;
    --donate-bg: #ffffff;
    --donate-radius: 8px;
    --donate-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

/* ── Base / Mobile Styles ── */
.donate-page {
    font-family: 'Inter', system-ui, sans-serif;
    color: var(--donate-text);
    line-height: 1.6;
}

.donate-section {
    padding: 2rem 1rem; /* Mobile: more padding on block, less on sides */
}

/* ── Tablet Breakpoint ── */
@media (min-width: 640px) {
    .donate-section {
        padding: 3rem 2rem;
    }
}

/* ── Desktop Breakpoint ── */
@media (min-width: 1024px) {
    .donate-section {
        padding: 4rem 2rem;
    }
}
```

### Naming Convention (BEM)

**Block-Element-Modifier Pattern**
```css
/* Block: top-level component */
.donate-payment {
    /* styles */
}

/* Element: child of block, scoped with double underscore */
.donate-payment__header {
    /* styles */
}

.donate-payment__content {
    /* styles */
}

/* Modifier: variant of block/element, scoped with double dash */
.donate-payment--disabled {
    /* styles */
}

.donate-tabs__btn--active {
    /* styles */
}
```

**Scoping Under `.donate-page`**
```css
/* All rules scoped under .donate-page to prevent LearnPress conflicts */
.donate-page {
    /* base styles */
}

.donate-page .donate-hero {
    /* hero section */
}

.donate-page .donate-hero__title {
    /* hero title */
}

.donate-page .donate-btn {
    /* buttons */
}

.donate-page .donate-btn--primary {
    /* primary button variant */
}
```

### Styling Best Practices

**CSS Custom Properties (Variables)**
```css
/* Define at :root for global access */
:root {
    /* Colors */
    --donate-primary: #2563eb;
    --donate-primary-dark: #1d4ed8;
    --donate-text: #1f2937;
    --donate-text-light: #6b7280;

    /* Spacing */
    --donate-spacing-xs: 0.5rem;
    --donate-spacing-sm: 1rem;
    --donate-spacing-md: 1.5rem;
    --donate-spacing-lg: 2rem;

    /* Other */
    --donate-radius: 8px;
    --donate-transition: 0.2s ease-in-out;
}

/* Use variables consistently */
.donate-btn {
    background: var(--donate-secondary);
    padding: var(--donate-spacing-sm) var(--donate-spacing-md);
    border-radius: var(--donate-radius);
    transition: background-color var(--donate-transition);
}
```

**Fluid Typography with `clamp()`**
```css
/* Scales smoothly between min and max viewport widths */
.donate-section-title {
    /* (min, preferred, max) */
    font-size: clamp(1.5rem, 4vw, 2rem);
    line-height: clamp(1.4, 4vw, 1.6);
}

/* Fallback for older browsers (ignored if clamp() supported) */
@supports not (font-size: clamp(1rem, 2vw, 3rem)) {
    .donate-section-title {
        font-size: 1.75rem;
    }
}
```

**Transitions & Animations**
```css
/* Always specify transition properties explicitly */
.donate-btn {
    transition: background-color 0.2s, transform 0.1s;
}

.donate-faq__answer {
    transition: max-height 0.3s ease-out;
    max-height: 0;
    overflow: hidden;
}

.donate-faq__item.is-open .donate-faq__answer {
    max-height: 1000px; /* Generous max-height for any content */
}

/* Avoid transition: all (too broad, performance impact) */
```

**Focus & Accessibility**
```css
/* Always provide visible focus indicators */
.donate-btn:focus-visible {
    outline: 3px solid var(--donate-secondary);
    outline-offset: 2px;
}

/* High contrast for interactive elements */
.donate-tabs__btn {
    color: var(--donate-text);
    border-bottom: 2px solid transparent;
    padding-bottom: 1rem;
}

.donate-tabs__btn.is-active {
    border-bottom-color: var(--donate-primary);
    color: var(--donate-primary);
}

/* Reduced motion support */
@media (prefers-reduced-motion: reduce) {
    .donate-page * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
}
```

**Color Contrast (WCAG AA)**
```css
/* Verify contrast ratios with tools like WebAIM Contrast Checker */

/* GOOD: 4.5:1 ratio on body text */
.donate-page {
    color: #1f2937;     /* Dark gray */
    background: #ffffff; /* White */
    /* Contrast: ~14:1 ✓ */
}

/* GOOD: 3:1 ratio on large text */
.donate-section-title {
    color: #2563eb;      /* Blue */
    background: #ffffff; /* White */
    /* Contrast: ~7:1 ✓ */
}

/* BAD: Insufficient contrast */
.donate-text-light {
    color: #9ca3af;      /* Light gray */
    background: #ffffff; /* White */
    /* Contrast: ~3.5:1 ✗ Too light */
}
```

### Responsive Design

**Breakpoints**
```css
/* Mobile-first: default styles are for mobile */

/* Tablet and up */
@media (min-width: 640px) {
    /* Tablet-specific styles */
}

/* Desktop and up */
@media (min-width: 1024px) {
    /* Desktop-specific styles */
}

/* Large desktop */
@media (min-width: 1280px) {
    /* Large desktop-specific styles */
}
```

**Touch-Friendly Targets**
```css
/* Minimum touch target size: 44px × 44px */
.donate-btn {
    padding: 0.75rem 2rem;      /* ~48px height */
    min-width: 44px;            /* Minimum width */
    min-height: 44px;           /* Minimum height */
}

.donate-tabs__btn {
    padding: 1rem;              /* Ample padding for touch */
    min-height: 44px;
}

.donate-faq__question {
    padding: 1rem;              /* Comfortable touch area */
}
```

---

## Architecture & Patterns

### Progressive Enhancement

**Principle**: Page works without JavaScript

```javascript
// GOOD: Provide baseline HTML functionality
// JavaScript adds interactivity, not required for functionality

// FAQ: Without JS, all items visible (no collapse)
// With JS: Accordion functionality added

// Payment Tabs: Without JS, both tabs visible (no switching)
// With JS: Tab switching functionality added

// Smooth Scroll: Without JS, anchor links jump (no animation)
// With JS: Smooth scroll animation added
```

### Feature Detection, Not Browser Detection

```javascript
// GOOD: Feature detection
if ( 'IntersectionObserver' in window ) {
    // Use IntersectionObserver for visible triggers
} else {
    // Fallback: skip animation or use simpler approach
}

// BAD: Browser detection
if ( navigator.userAgent.indexOf( 'Chrome' ) !== -1 ) {
    // Chrome-specific code
}
```

### Separation of Concerns

**HTML**: Structure & semantics only
```html
<button class="donate-btn donate-btn--primary" aria-label="Donate now">
    Donate
</button>
```

**CSS**: Presentation & layout only
```css
.donate-btn {
    background: var(--donate-secondary);
    padding: 0.75rem 2rem;
}

.donate-btn--primary {
    background: var(--donate-secondary);
}
```

**JavaScript**: Behavior & interactivity only
```javascript
button.addEventListener( 'click', function () {
    // Handle donation flow
});
```

### DRY (Don't Repeat Yourself)

**Reusable Components**
```php
// GOOD: Section template with reusable structure
<?php
// Each section follows same pattern: container, title, content
echo '<section class="donate-' . $section . '">';
echo '  <div class="donate-container">';
echo '    <h2 class="donate-section-title">' . $title . '</h2>';
echo '    <!-- Section-specific content -->';
echo '  </div>';
echo '</section>';
```

**CSS Variables for Consistency**
```css
/* Define once, use everywhere */
:root {
    --donate-radius: 8px;
}

.donate-btn {
    border-radius: var(--donate-radius);
}

.donate-card {
    border-radius: var(--donate-radius);
}

.donate-input {
    border-radius: var(--donate-radius);
}
```

---

## Testing Standards

### Manual Testing Checklist

**Functionality**
- [ ] All sections render correctly
- [ ] Payment tabs switch properly
- [ ] FAQ accordion expands/collapses
- [ ] Stat counters animate
- [ ] Smooth scroll works
- [ ] Copy button functions

**Responsive Design**
- [ ] Mobile (320px, 375px, 414px)
- [ ] Tablet (768px, 1024px)
- [ ] Desktop (1280px, 1920px)
- [ ] No horizontal scroll
- [ ] Text readable on all sizes

**Cross-Browser**
- [ ] Chrome (latest)
- [ ] Firefox (latest)
- [ ] Safari (latest)
- [ ] Edge (latest)
- [ ] Mobile browsers (iOS Safari, Chrome Android)

**Accessibility**
- [ ] Keyboard navigation (Tab, Enter, Arrow keys)
- [ ] Screen reader (NVDA, JAWS, VoiceOver)
- [ ] Color contrast (WCAG AA)
- [ ] Focus indicators visible

**Performance**
- [ ] Page load < 3 seconds
- [ ] No console errors
- [ ] Lighthouse score ≥ 90

---

## Documentation Standards

### Code Comments

**When to Comment**
```javascript
// GOOD: Explain WHY, not WHAT
// Stat counter animation disabled if not visible for performance
if ( !entry.isIntersecting ) {
    return; // Skip animation for offscreen elements
}

// BAD: Obvious comments are noise
counter = counter + 1; // Increment counter
```

**Comment Format**
```javascript
// Single line comment
var amount = parseInt( value, 10 ); // Parse as base-10

/* Multi-line comment
   for longer explanations or
   temporary disabling of code */

// ── Section Delimiter ──
// Use for organizing code into logical sections
```

### File Headers

**PHP Files**
```php
<?php
/**
 * Donate page — Payment section
 *
 * Implements a tabbed interface for Bank Transfer (VietQR) and PayPal payments.
 * Configuration via wp-config.php constants.
 *
 * @package tonytechlab-child-theme
 * @subpackage Sections
 * @version 1.0.0
 */
```

**JavaScript Files**
```javascript
/**
 * TonyTechLab Donate Page — Interactions
 *
 * Features:
 *   1. FAQ accordion
 *   2. Payment tab switching
 *   3. Stat counter animation
 *   4. Smooth scroll
 *   5. Copy to clipboard
 *
 * Zero dependencies. Progressive enhancement.
 */
```

---

## Version Control

### Commit Messages

**Format**: Follow Conventional Commits
```
feat: add FAQ accordion functionality
fix: correct stat counter animation timing
docs: update architecture documentation
refactor: simplify payment tab switching
chore: update dependencies
```

**Examples**
```
feat: add VietQR QR code generation

Implement dynamic QR code generation for bank transfer details.
Requires TONYTECHLAB_BANK_BIN and TONYTECHLAB_ACCOUNT_NUMBER constants.

Closes #42
```

```
fix: resolve payment tab focus management

Arrow key navigation now properly manages tab focus and ARIA attributes.
Keyboard users can now navigate between payment methods with arrow keys.
```

### Branching Strategy

**Branch Naming**
```
feat/feature-name       — New feature
fix/bug-description     — Bug fix
docs/doc-topic          — Documentation
refactor/component      — Refactoring
```

---

## Performance Guidelines

### Asset Optimization

**JavaScript**
- Target size: ≤ 8 KB (uncompressed)
- Vanilla JS (zero external dependencies)
- Minify before deployment
- Load in footer (defer)

**CSS**
- Target size: ≤ 15 KB combined
- Mobile-first responsive
- Minimal media queries
- Minify before deployment

**Images**
- Use modern formats (WebP with JPEG fallback)
- Optimize with tools (ImageOptim, TinyPNG)
- Lazy-load offscreen images
- Responsive images with srcset

### Rendering Performance

**Layout Stability**
- Avoid forced reflows (reading layout properties then modifying)
- Batch DOM updates
- Use transform for animations (GPU-accelerated)

**JavaScript Performance**
- Use `IntersectionObserver` for visibility detection
- Debounce scroll/resize events
- Cache DOM references
- Use event delegation where appropriate

---

## Deprecated Practices

**Do Not Use**
- Inline styles (`style=""` attribute)
- Inline event handlers (`onclick=""`)
- Global variables (use IIFE scope)
- `eval()` or `new Function()`
- `setTimeout()` for polling (use MutationObserver, IntersectionObserver)

---

## Related Documentation

See other docs files for complementary information:
- `docs/codebase-summary.md` — Project structure overview
- `docs/system-architecture.md` — Architecture diagrams and data flow
- `docs/project-overview-pdr.md` — Requirements and specifications

