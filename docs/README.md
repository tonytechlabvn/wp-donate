# TonyTechLab Donate Landing Page Plugin — Documentation Index

Welcome to the comprehensive documentation for the TonyTechLab Donate Landing Page WordPress plugin. This directory contains all project documentation organized by purpose.

**Current Release**: v1.0.0 (2026-03-24) — WordPress plugin with 9-tab admin settings panel
**Deployment**: Via shortcode `[tonytechlab_donate]` on any WordPress page/post
**Compatibility**: Works with any WordPress theme (not just LearnPress)

---

## Quick Start by Role

### For New Developers
Start here to understand the project and codebase:
1. **[Project Overview & PDR](./project-overview-pdr.md)** — Project goals, requirements, and acceptance criteria
2. **[Codebase Summary](./codebase-summary.md)** — Project structure, components, and dependencies
3. **[System Architecture](./system-architecture.md)** — Architecture diagrams, data flow, and design patterns
4. **[Code Standards](./code-standards.md)** — Coding standards, best practices, and style guides
5. **[Development Roadmap](./development-roadmap.md)** — Future phases and feature planning

### For Project Managers
Track progress, plan resources, and manage timelines:
1. **[Project Overview & PDR](./project-overview-pdr.md)** — Stakeholders, requirements, success metrics
2. **[Development Roadmap](./development-roadmap.md)** — Phase planning, timeline, priorities
3. **[Project Changelog](./project-changelog.md)** — Release notes, features, known issues

### For Architects & Tech Leads
Design decisions, system structure, and scalability:
1. **[System Architecture](./system-architecture.md)** — High-level design, component interactions, data flow
2. **[Code Standards](./code-standards.md)** — Design patterns, architectural principles, best practices
3. **[Development Roadmap](./development-roadmap.md)** — Future architecture enhancements, scaling strategies

### For DevOps & Sysadmins
Deployment, security, and operations:
1. **[Project Overview & PDR](./project-overview-pdr.md)** — Security requirements, dependencies, configuration
2. **[Codebase Summary](./codebase-summary.md)** — External APIs, dependencies, performance characteristics
3. **[Code Standards](./code-standards.md)** — Security best practices, credential storage

---

## Documentation Files

### Core Documentation (Essential Reading)

| File | Purpose | Length | Audience |
|------|---------|--------|----------|
| **[project-overview-pdr.md](./project-overview-pdr.md)** | Project vision, requirements, acceptance criteria | 582 lines | Everyone |
| **[codebase-summary.md](./codebase-summary.md)** | Project structure, components, dependencies | 418 lines | Developers, Architects |
| **[system-architecture.md](./system-architecture.md)** | Architecture, data flow, design patterns | 465 lines | Architects, Tech Leads |
| **[code-standards.md](./code-standards.md)** | Coding standards, best practices, style guides | 678 lines | Developers |

### Supporting Documentation

| File | Purpose | Length | Audience |
|------|---------|--------|----------|
| **[development-roadmap.md](./development-roadmap.md)** | Future phases, features, timeline | 528 lines | Project Managers, Tech Leads |
| **[project-changelog.md](./project-changelog.md)** | Version history, release notes, known issues | 280 lines | Everyone |

---

## Document Overview

### project-overview-pdr.md
**Your quick reference for "what is this project about?"**

Covers:
- Executive summary and vision
- Stakeholder overview
- Functional requirements (8 core features)
- Non-functional requirements (performance, security, browser compatibility)
- Technical specifications
- Acceptance criteria (all met ✓)
- Risk assessment and mitigation
- Configuration reference

**Read this if you need to...**
- Understand the project goals and scope
- Know what was built and why
- Understand acceptance criteria and success metrics
- Reference configuration constants (wp-config.php)
- Understand security requirements

### codebase-summary.md
**Your quick reference for "how is the code organized?"**

Covers:
- Project structure (directory tree)
- Core components (theme setup, template, sections, assets)
- Payment section (VietQR + PayPal)
- Styling system (design tokens, responsive approach)
- JavaScript features (5 interaction modules)
- Configuration system
- External dependencies
- Accessibility features
- Performance characteristics
- Browser support
- Known limitations

**Read this if you need to...**
- Understand the codebase structure
- Learn how components interact
- Understand payment integration
- Find specific features
- Understand dependencies

### system-architecture.md
**Your quick reference for "how do things work together?"**

Covers:
- High-level architecture with diagrams
- Component interaction diagram
- Data flow (page load and configuration)
- Component architecture details
- Asset structure (CSS/JS organization)
- Theme integration
- Data storage approach
- Security considerations
- Performance optimizations
- Scalability and extensibility
- Testing strategy

**Read this if you need to...**
- Understand system design
- See architecture diagrams
- Understand data flow
- Plan scalability improvements
- Understand security design
- Plan migrations or refactoring

### code-standards.md
**Your quick reference for "how should I write code?"**

Covers:
- PHP standards (naming, documentation, security, error handling)
- JavaScript standards (ES5 compatibility, DOM manipulation, performance)
- CSS standards (mobile-first, BEM naming, accessibility, responsive design)
- Architecture patterns (progressive enhancement, feature detection, separation of concerns, DRY)
- Testing standards
- Documentation standards
- Version control practices
- Performance guidelines
- Deprecated practices

**Read this if you need to...**
- Write code for this project
- Understand coding conventions
- Learn best practices
- Review code quality
- Understand architectural patterns

### development-roadmap.md
**Your quick reference for "what comes next?"**

Covers:
- Current status (v1.0.0 complete)
- 8 planned phases (2026-2027):
  - Phase 1: Core Page (✓ Complete)
  - Phase 2: Config UI
  - Phase 3: Content CMS
  - Phase 4: Multi-Language
  - Phase 5: Analytics
  - Phase 6: Payment Enhancement
  - Phase 7: Donor CRM
  - Phase 8: API & Webhooks
- Phase details (timeline, features, technical approach, success criteria)
- Priority matrix
- Dependencies and blockers
- Resource requirements
- Maintenance tasks

**Read this if you need to...**
- Understand future features
- Plan resources and timeline
- Prioritize work
- Understand dependencies
- Track progress

### project-changelog.md
**Your quick reference for "what changed?"**

Covers:
- v1.0.0 release notes (2026-03-24)
- Complete feature list with descriptions
- Technical details (project structure, dependencies, browser support)
- Testing notes
- Known issues
- Future release planning

**Read this if you need to...**
- See what was built in v1.0.0
- Understand breaking changes
- Track known issues
- Plan for next release

---

## Navigation Tips

### Find Information By Topic

**VietQR Bank Transfer**
- Overview: [codebase-summary.md § Payment Section](./codebase-summary.md#payment-section-sectionpaymentphp)
- Implementation: [project-overview-pdr.md § VietQR](./project-overview-pdr.md#3-vietqr-bank-transfer-support)
- Config: [project-overview-pdr.md § Configuration](./project-overview-pdr.md#appendix-configuration-reference)

**PayPal Integration**
- Overview: [codebase-summary.md § Payment Section](./codebase-summary.md#payment-section-sectionpaymentphp)
- Implementation: [project-overview-pdr.md § PayPal](./project-overview-pdr.md#4-paypal-donate-button)
- Theme Setup: [codebase-summary.md § Theme Setup](./codebase-summary.md#theme-setup-functionsphp)

**JavaScript Features**
- All 5 modules: [codebase-summary.md § JavaScript](./codebase-summary.md#javascript-donatepaagejs)
- Standards: [code-standards.md § JavaScript](./code-standards.md#javascript-standards)
- Architecture: [system-architecture.md § JavaScript](./system-architecture.md#javascript-donatepaagejs)

**Accessibility**
- Features: [codebase-summary.md § Accessibility](./codebase-summary.md#accessibility)
- Standards: [code-standards.md § Accessibility](./code-standards.md#focus--accessibility)
- Requirements: [project-overview-pdr.md § Accessibility](./project-overview-pdr.md#7-accessibility-wcag-aa-compliance)

**Performance**
- Characteristics: [codebase-summary.md § Performance](./codebase-summary.md#performance-characteristics)
- Optimization: [system-architecture.md § Performance](./system-architecture.md#performance-optimizations)
- Standards: [code-standards.md § Performance](./code-standards.md#performance-guidelines)

**Configuration**
- System Overview: [codebase-summary.md § Configuration](./codebase-summary.md#configuration)
- Detailed Setup: [project-overview-pdr.md § Configuration Reference](./project-overview-pdr.md#appendix-configuration-reference)
- Future Improvements: [development-roadmap.md § Phase 2](./development-roadmap.md#phase-2-configuration-management-ui-planned)

**Security**
- Best Practices: [code-standards.md § Security](./code-standards.md#security-best-practices)
- Requirements: [project-overview-pdr.md § Security](./project-overview-pdr.md#security-requirements)
- Considerations: [system-architecture.md § Security](./system-architecture.md#security-considerations)

---

## Quick Reference

### Project Status
- **Current Version**: 1.0.0
- **Release Date**: 2026-03-24
- **Status**: Released ✓
- **Next Phase**: Phase 2 (Config UI, Q2 2026)

### Key Technologies
- WordPress 5.0+ (CMS)
- Any WordPress Theme (plugin is theme-agnostic)
- WordPress Settings API (configuration)
- PHP 7.4+ (Backend)
- Vanilla JavaScript (Frontend, zero dependencies)
- CSS 3 (Responsive, custom properties)

### External Dependencies
- Google Fonts (Inter typography)
- VietQR API (QR code generation)
- PayPal SDK (Donate button)

### Configuration Methods
**Primary (WordPress Admin UI)**
- Settings > TonyTechLab Donate
- 9 tabs for all content and design settings
- No coding required

**Legacy (wp-config.php Constants)**
- Optional: Import existing constants on first activation
- For backward compatibility only
```php
TONYTECHLAB_BANK_NAME              # Bank display name
TONYTECHLAB_BANK_BIN               # Bank identifier (6 digits)
TONYTECHLAB_ACCOUNT_NUMBER         # Account number
TONYTECHLAB_ACCOUNT_HOLDER         # Account holder name
TONYTECHLAB_TRANSFER_NOTE          # Transfer note for QR
TONYTECHLAB_PAYPAL_BUTTON_ID       # PayPal button ID
```

### File Structure
```
tonytechlab-donate/
├── tonytechlab-donate.php          # Main plugin file
├── includes/
│   ├── class-settings-manager.php  # WordPress Settings API
│   ├── class-settings-renderer.php # Admin panel (9 tabs)
│   ├── class-shortcode-handler.php # Shortcode + asset loading
│   ├── default-settings.php        # Default values
│   └── helper-color-utils.php      # Color utilities
├── admin/partials/
│   ├── tab-hero.php, tab-mission.php, etc. # Admin UI
│   └── ... (9 tabs total)
├── public/partials/
│   ├── section-hero.php, section-mission.php, etc. # Frontend sections
│   └── ... (8 sections)
└── public/
    ├── css/donate-page.css         # Styles (~12.5 KB)
    └── js/donate-page.js           # Features (~8 KB)
```

---

## Maintenance & Updates

This documentation should be reviewed and updated:
- **Quarterly**: Verify accuracy, update performance metrics
- **Per Phase**: Update roadmap status, add phase-specific docs
- **Per Release**: Update changelog, verify code references

See [development-roadmap.md § Continuous Maintenance](./development-roadmap.md#continuous-maintenance) for ongoing tasks.

---

## Related Resources

- **GitHub Issues**: (To be defined)
- **Project Backlog**: See [development-roadmap.md](./development-roadmap.md)
- **Code Repository**: `learnpress-child/` directory
- **Reports**: `plans/reports/` directory

---

## Document Statistics

| Metric | Value |
|--------|-------|
| Total Documentation Files | 6 markdown files |
| Total Lines of Documentation | ~2,951 lines |
| Code Standards Coverage | ✓ Complete |
| Architecture Documentation | ✓ With diagrams |
| Requirements Coverage | ✓ 100% of v1.0.0 |
| Roadmap (future phases) | 8 phases documented |

---

## Questions or Feedback?

For documentation updates, clarifications, or feedback:
- Review the relevant documentation file
- Check if your question is answered in another file
- Refer to code comments in source files for implementation details
- Contact the documentation manager (to be assigned)

---

**Last Updated**: 2026-03-24
**Documentation Version**: 1.0.0 (aligned with code)

