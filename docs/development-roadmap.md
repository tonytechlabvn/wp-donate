# Development Roadmap

Strategic roadmap for TonyTechLab Donate Landing Page evolution. This document tracks phases, features, and priorities through the project lifecycle.

## Current Status

**Phase**: 1.x Iterative Polish (Active)
**Version**: 1.3.2
**Release Date**: 2026-03-24
**Progress**: 100%

Core donate page with admin settings panel, polished two-column design, and mobile UX optimizations deployed.

---

## Phase Breakdown

### Phase 1: Core Donate Page (COMPLETE) ✓

**Timeline**: Q1 2026
**Status**: Released (v1.0.0)
**Progress**: 100%

#### Objectives
- Implement modular 8-section donate page
- Support VietQR bank transfers and PayPal donations
- Ensure WCAG AA accessibility compliance
- Optimize for mobile-first responsive design
- Zero external JS dependencies

#### Delivered Features
- LearnPress child theme setup
- 8 page sections (hero, mission, stats, funds, testimonials, payment, FAQ, footer)
- VietQR QR code generation with bank account details
- PayPal Donate Button SDK integration
- 5 interactive JavaScript modules (accordion, tabs, counters, scroll, copy)
- CSS custom properties design system
- ARIA-compliant interactive components
- Google Fonts preconnect optimization
- Configuration via wp-config.php constants

#### Success Metrics
- ✓ Page loads < 3 seconds on 4G (13 KB JS+CSS)
- ✓ 100% Lighthouse Accessibility score
- ✓ All payment methods functional in production
- ✓ Mobile responsive on all major devices
- ✓ Zero console errors in modern browsers

---

### Phase 2: Configuration Management UI (PLANNED)

**Timeline**: Q2 2026
**Estimated Duration**: 3-4 weeks
**Priority**: High
**Status**: Not Started

#### Objectives
- Move credentials from wp-config.php to WordPress admin UI
- Enable non-technical admins to manage donation settings
- Reduce configuration friction and security surface
- Maintain backward compatibility with constant-based config

#### Planned Features

| Feature | Description | Effort |
|---------|-------------|--------|
| Settings Dashboard | WordPress admin page for donation config | 2 weeks |
| Bank Details Form | Input fields for bank name, BIN, account, holder | 3 days |
| PayPal Button ID Validator | Test PayPal ID connectivity | 4 days |
| Transfer Note Editor | Customize transfer note for QR code | 2 days |
| Config Migration Tool | Auto-import constants → options on activation | 3 days |
| Settings Sanitization | Validate and escape all inputs | 2 days |

#### Technical Approach
- Create custom WordPress settings page under Donations menu
- Use WordPress Settings API (`register_setting()`, `add_settings_section()`)
- Store in `wp_options` table with `donate_` prefix
- Fallback: read from constants if options undefined (backward compatibility)
- Add nonce verification for CSRF protection

#### Database Schema
```php
Option: donate_bank_name (string, max 100)
Option: donate_bank_bin (string, 6 digits)
Option: donate_account_number (string, max 20)
Option: donate_account_holder (string, max 100)
Option: donate_transfer_note (string, max 100)
Option: donate_paypal_button_id (string, max 100)
```

#### Success Criteria
- ✓ Settings form accessible from WordPress admin
- ✓ All fields validate and sanitize correctly
- ✓ Constants still work if options undefined
- ✓ No breaking changes to existing installations
- ✓ Settings persist across plugin updates

---

### Phase 3: Content Management System (PLANNED)

**Timeline**: Q3 2026
**Estimated Duration**: 4-5 weeks
**Priority**: Medium
**Status**: Not Started

#### Objectives
- Move section content from hardcoded PHP to editable database
- Enable content updates without developer intervention
- Support multi-language content (foundation for Phase 4)

#### Planned Features

| Content Type | Editable Fields | Storage |
|--------------|-----------------|---------|
| Hero Section | Title, subtitle, CTA button text | Post type: `donate-section` |
| Mission | Headline, description, image | Custom post type + meta |
| Stats | Labels, target values | CPT + repeater field (ACF) |
| Funds | Allocation items, percentages | Custom field group |
| Testimonials | Author, quote, image, role | CPT + meta |
| FAQ | Questions & answers | CPT + meta (repeater) |

#### Technical Approach
- Create `donate-section` custom post type
- Use Advanced Custom Fields (ACF) for flexible field groups
- Store in WordPress `wp_posts` and `wp_postmeta`
- Template files read from post meta instead of hardcoded content
- Admin UI via ACF Pro field builder

#### Data Structure (Post Meta)
```json
{
  "hero": {
    "title": "Support TonyTechLab",
    "subtitle": "Your donation changes lives",
    "cta_text": "Donate Now"
  },
  "mission": {
    "headline": "Our Mission",
    "description": "...",
    "image_id": 123
  },
  "faqs": [
    {
      "question": "How are donations used?",
      "answer": "..."
    }
  ]
}
```

#### Success Criteria
- ✓ All content editable from WordPress admin
- ✓ No database queries in template files
- ✓ Graceful fallback to defaults if content missing
- ✓ Easy content reordering (drag-drop)
- ✓ Image upload support with WordPress media library

---

### Phase 4: Multi-Language Support (PLANNED)

**Timeline**: Q4 2026
**Estimated Duration**: 3 weeks
**Priority**: Medium
**Status**: Not Started

#### Objectives
- Support Vietnamese and English interface
- Enable WPML or Polylang integration
- Prepare groundwork for additional languages (French, Spanish)

#### Planned Features
- i18n string wrapping with `__()`, `_e()` functions
- Translation files (.po/.pot) for Vietnamese
- WPML/Polylang compatibility
- Language switcher in footer
- QR code and PayPal button localization

#### Supported Languages (Phase 4)
- English (en_US)
- Vietnamese (vi)

#### Future Languages (Post-Phase 4)
- French (fr_FR)
- Spanish (es_ES)
- Japanese (ja)
- Korean (ko)

#### Technical Approach
```php
// Before:
<h1>Support TonyTechLab</h1>

// After:
<h1><?php _e( 'Support TonyTechLab', 'donate-page' ); ?></h1>
```

- Create `languages/donate-page-vi.po` for Vietnamese translations
- Use WordPress translation tools (Loco Translate, GlotPress)
- Integrate with WPML/Polylang for multi-language site support
- Translate all user-facing strings in templates and JS

#### Success Criteria
- ✓ 100% of UI strings translatable
- ✓ Vietnamese translation complete
- ✓ WPML/Polylang integration tested
- ✓ Language switcher functional
- ✓ QR code respects selected language

---

### Phase 5: Analytics & Reporting (PLANNED)

**Timeline**: Q1 2027
**Estimated Duration**: 3-4 weeks
**Priority**: Medium
**Status**: Not Started

#### Objectives
- Track donation page engagement metrics
- Measure conversion rates and user behavior
- Generate reports for stakeholders
- Support attribution and campaign tracking

#### Planned Integrations
- Google Analytics 4 (GA4) — page views, events, conversions
- Facebook Pixel — audience building, retargeting
- Hotjar — heatmaps, session recordings, feedback
- WordPress Stats — native WP.com integration
- Custom event tracking — donation button clicks, tab switches

#### Tracked Events

| Event | Trigger | Data |
|-------|---------|------|
| `donate_page_view` | Page load | Referrer, device, language |
| `payment_tab_switched` | Click Bank/PayPal | Selected tab |
| `faq_expanded` | Click FAQ | Question index |
| `stat_counter_viewed` | Stats section scrolled | Time in view |
| `copy_clicked` | Copy account number | Button label |
| `donate_button_clicked` | Click VietQR/PayPal | Payment method |

#### Custom Dashboard
- WordPress admin widget showing daily/weekly donation activity
- Conversion funnel (views → payment method selection → completion)
- Geographic breakdown (if IP geotracking enabled)
- Device/browser breakdown

#### Success Criteria
- ✓ GA4 events firing correctly
- ✓ Conversion funnel tracking functional
- ✓ Admin dashboard displays metrics
- ✓ GDPR/privacy compliant (no PII tracked)
- ✓ Customizable event tracking via hooks

---

### Phase 6: Payment Enhancement (PLANNED)

**Timeline**: Q2 2027
**Estimated Duration**: 5-6 weeks
**Priority**: High
**Status**: Not Started

#### Objectives
- Expand payment method support beyond VietQR + PayPal
- Improve conversion rates with multiple gateway options
- Support subscription donations

#### New Payment Methods

| Gateway | Market | Type | Effort | Notes |
|---------|--------|------|--------|-------|
| Stripe | International | Card | 2 weeks | Highest priority, supports subscriptions |
| Apple Pay | iOS | Digital wallet | 1 week | Requires Stripe or custom integration |
| Google Pay | Android | Digital wallet | 1 week | Requires Stripe or custom integration |
| 2Checkout | International | Card + local methods | 2 weeks | Regional payment methods |
| Momo | Vietnam | Mobile wallet | 1.5 weeks | Vietnamese e-wallet leader |

#### Planned Features
- Stripe Donate plugin integration or custom Stripe implementation
- Subscription/recurring donations (monthly, quarterly, yearly)
- Donation amount presets or custom amount input
- Donor profile creation (optional)
- Donation receipt generation (email + PDF)
- Payment history (for registered donors)

#### Database Schema (New)
```php
Table: donations
  id (PK)
  donor_email (unique, searchable)
  donor_name
  amount
  currency
  payment_method (stripe, paypal, momo, etc.)
  status (pending, completed, failed, refunded)
  receipt_id
  transaction_date
  created_at
  updated_at
```

#### Success Criteria
- ✓ Multiple payment methods integrated
- ✓ Subscription donations functional
- ✓ Receipt generation and delivery
- ✓ Conversion rate increased by 20%+
- ✓ PCI DSS compliance verified (if handling cards)

---

### Phase 7: Donor Relationship Management (PLANNED)

**Timeline**: Q3 2027
**Estimated Duration**: 4-5 weeks
**Priority**: Medium
**Status**: Not Started

#### Objectives
- Build donor profile and history
- Enable donor communication and engagement
- Track lifetime value and retention
- Support donor recognition/acknowledgment

#### Planned Features
- Donor registration (optional for first-time, required for recurring)
- Donor profile dashboard (donations, receipts, preferences)
- Email notifications (thank you, impact updates, renewal reminders)
- Donor recognition wall (opt-in public listing)
- Impact reports (personalized impact based on donation)
- Recurring donation management (pause, resume, update amount)

#### Database Schema Extension
```php
Table: donors
  id (PK)
  email (unique)
  name
  phone (optional)
  country
  preferences (JSON: {receive_updates, public_recognition})
  created_at
  updated_at

Table: donor_donations (FK: donors.id)
  id (PK)
  donor_id (FK)
  amount
  currency
  payment_method
  receipt_id
  is_recurring
  status
  created_at
```

#### Email Templates
- Welcome email (first donation)
- Thank you email (post-donation)
- Renewal reminder (recurring donors)
- Impact report (quarterly impact update)
- Donation receipt (PDF attachment)

#### Success Criteria
- ✓ Donor registration flow complete
- ✓ Profile dashboard functional
- ✓ Email notifications sent reliably
- ✓ Donor retention rate tracked
- ✓ Recognition wall displays correctly

---

### Phase 8: API & Webhooks (PLANNED)

**Timeline**: Q4 2027
**Estimated Duration**: 3-4 weeks
**Priority**: Low
**Status**: Not Started

#### Objectives
- Expose donation data via REST API
- Support webhook notifications from payment gateways
- Enable third-party integrations (CRM, accounting, etc.)

#### Planned Endpoints
```
GET /wp-json/donate/v1/donations          # List donations
GET /wp-json/donate/v1/donations/{id}     # Get donation details
POST /wp-json/donate/v1/donations         # Create donation
GET /wp-json/donate/v1/donors/{id}        # Get donor info
POST /wp-json/donate/v1/webhooks/stripe   # Stripe webhook
POST /wp-json/donate/v1/webhooks/paypal   # PayPal webhook
```

#### Webhook Events
- `donation.created` — New donation received
- `donation.completed` — Payment confirmed
- `donation.failed` — Payment failed
- `subscription.activated` — Recurring donation started
- `subscription.cancelled` — Recurring donation stopped

#### Authentication
- API Key authentication for third-party integrations
- OAuth 2.0 for future mobile app
- Webhook signing (HMAC-SHA256)

#### Success Criteria
- ✓ API fully documented with OpenAPI/Swagger
- ✓ Webhooks tested with Stripe and PayPal
- ✓ Rate limiting implemented
- ✓ Error responses standardized
- ✓ Test endpoint for webhook validation

---

## Priority Matrix

| Phase | Priority | Impact | Effort | Timeline |
|-------|----------|--------|--------|----------|
| 1: Core Page | Critical | High | High | Q1 2026 ✓ |
| 2: Config UI | High | High | Medium | Q2 2026 |
| 3: Content CMS | High | High | High | Q3 2026 |
| 4: Multi-Language | Medium | Medium | Medium | Q4 2026 |
| 5: Analytics | Medium | High | Medium | Q1 2027 |
| 6: Payment Expansion | High | High | High | Q2 2027 |
| 7: Donor CRM | Medium | Medium | High | Q3 2027 |
| 8: API | Low | Medium | Medium | Q4 2027 |

---

## Dependencies & Blockers

### Phase 2 Dependencies
- None — can start immediately after Phase 1

### Phase 3 Dependencies
- Phase 2 completion (optional, can proceed independently)
- ACF Pro plugin installation

### Phase 4 Dependencies
- Phase 3 completion recommended (content structure ready)
- WPML or Polylang plugin decision

### Phase 6 Dependencies
- Phase 2 completion (payment method config in admin)
- Payment gateway API keys (Stripe, etc.)
- PCI DSS compliance review

### Phase 7 Dependencies
- Phase 6 completion (donations data must exist)
- Database schema migration

### Phase 8 Dependencies
- Phase 6 completion (donation data structure stable)
- API documentation template established

---

## Resource Requirements

### Development Team
- **Full-Stack Developer**: Phases 2, 3, 6, 7, 8
- **Frontend Developer**: Phases 2, 4, 5
- **QA/Tester**: All phases
- **DevOps/Database Admin**: Phase 6+ (database schema)

### Third-Party Services (Estimated Annual Costs)
- Stripe: 2.9% + $0.30 per transaction
- Google Analytics 4: Free (plus Firebase if needed: ~$25/month)
- Hotjar: ~$99/month (Starter plan)
- WPML: ~$99/year (single site)
- ACF Pro: $99 (one-time license)

---

## Success Metrics by Phase

| Phase | Metric | Target |
|-------|--------|--------|
| 1 | Page speed (Lighthouse) | 90+ |
| 1 | Accessibility score | 100 |
| 2 | Admin UI usability (NPS) | 8/10+ |
| 3 | Content update frequency | Weekly |
| 4 | Vietnamese user retention | +30% |
| 5 | Conversion rate tracked | 100% accuracy |
| 6 | Donation volume increase | +50% (estimated) |
| 7 | Recurring donor rate | 15%+ |
| 8 | API adoption rate | 3+ integrations |

---

## Continuous Maintenance

### Ongoing Tasks
- **Security Updates**: WordPress core, plugins, PayPal/Stripe SDKs (Monthly)
- **Browser Testing**: Chrome, Firefox, Safari, Edge (Quarterly)
- **Performance Monitoring**: Page speed, core web vitals (Monthly)
- **Donation Reconciliation**: Match bank/PayPal transactions (Weekly)
- **User Feedback**: Bug reports, feature requests (As-needed)
- **Documentation Updates**: Keep roadmap, architecture docs current (Quarterly)

---

## Deprecation Policy

- **Minor versions** (1.0 → 1.1): Backward compatible, new features
- **Major versions** (1.x → 2.0): May break compatibility, major architecture changes
- **Deprecation Notice Period**: 6 months before removal
- **LTS (Long Term Support)**: Latest major version only

---

## Contact & Feedback

For questions, feature requests, or bug reports:
- Project Lead: (To be defined)
- GitHub Issues: (To be defined)
- Email: (To be defined)

