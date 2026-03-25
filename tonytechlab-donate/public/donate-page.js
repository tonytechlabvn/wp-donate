/**
 * TonyTechLab Donate Page — Interactions
 *
 * Features:
 *   1. FAQ accordion (ARIA-compliant)
 *   2. Stat counter animation (IntersectionObserver)
 *   3. Smooth scroll for anchor links
 *   4. Copy-to-clipboard for bank account number
 *   5. Donation form: amount selection, payment method toggle, submit flow
 *   6. Hide parent theme sections (Popular Courses, Last Posts)
 *
 * Zero dependencies. Progressive enhancement — page works without JS.
 */
(function () {
    'use strict';

    var page = document.querySelector('.donate-page');
    if (!page) return;

    /* ── 1. FAQ Accordion ── */
    function initFaqAccordion() {
        var buttons = page.querySelectorAll('.donate-faq__question');
        buttons.forEach(function (btn) {
            btn.addEventListener('click', function () {
                var item = btn.closest('.donate-faq__item');
                var answer = item.querySelector('.donate-faq__answer');
                var isOpen = item.classList.contains('is-open');

                if (isOpen) {
                    item.classList.remove('is-open');
                    btn.setAttribute('aria-expanded', 'false');
                    answer.style.maxHeight = null;
                    answer.setAttribute('hidden', '');
                } else {
                    item.classList.add('is-open');
                    btn.setAttribute('aria-expanded', 'true');
                    answer.removeAttribute('hidden');
                    answer.style.maxHeight = answer.scrollHeight + 'px';
                }
            });
        });
    }

    /* ── 2. Stat Counter Animation ── */
    function initStatCounters() {
        var statsSection = page.querySelector('.donate-stats');
        if (!statsSection || !('IntersectionObserver' in window)) return;

        var numbers = statsSection.querySelectorAll('.donate-stats__number[data-target]');
        var animated = false;

        numbers.forEach(function (el) { el.textContent = '0'; });

        function easeOutQuad(t) {
            return t * (2 - t);
        }

        function animateNumber(el) {
            var target = parseInt(el.getAttribute('data-target'), 10);
            if (isNaN(target)) return;

            var duration = 2000;
            var start = performance.now();

            function tick(now) {
                var elapsed = now - start;
                var progress = Math.min(elapsed / duration, 1);
                var value = Math.round(easeOutQuad(progress) * target);
                el.textContent = value.toLocaleString();

                if (progress < 1) {
                    requestAnimationFrame(tick);
                }
            }

            requestAnimationFrame(tick);
        }

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting && !animated) {
                    animated = true;
                    numbers.forEach(animateNumber);
                    observer.disconnect();
                }
            });
        }, { threshold: 0.3 });

        observer.observe(statsSection);
    }

    /* ── 3. Smooth Scroll ── */
    function initSmoothScroll() {
        page.querySelectorAll('a[href^="#"]').forEach(function (link) {
            link.addEventListener('click', function (e) {
                var targetId = link.getAttribute('href');
                if (targetId === '#') return;

                var target = document.querySelector(targetId);
                if (!target) return;

                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });
    }

    /* ── 4. Copy to Clipboard ── */
    function initCopyButtons() {
        page.querySelectorAll('.donate-btn--copy[data-copy-target]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var selector = btn.getAttribute('data-copy-target');
                var sourceEl = document.querySelector(selector);
                if (!sourceEl) return;

                var text = sourceEl.textContent.trim();

                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(text).then(function () {
                        showCopiedFeedback(btn);
                    }).catch(function () { /* permission denied or non-HTTPS */ });
                } else {
                    var textarea = document.createElement('textarea');
                    textarea.value = text;
                    textarea.style.position = 'fixed';
                    textarea.style.opacity = '0';
                    document.body.appendChild(textarea);
                    textarea.select();
                    try {
                        document.execCommand('copy');
                        showCopiedFeedback(btn);
                    } catch (_) { /* silent fail */ }
                    document.body.removeChild(textarea);
                }
            });
        });
    }

    function showCopiedFeedback(btn) {
        var original = btn.textContent;
        btn.textContent = 'Copied!';
        btn.classList.add('is-copied');
        setTimeout(function () {
            btn.textContent = original;
            btn.classList.remove('is-copied');
        }, 2000);
    }

    /* ── 5. Donation Form Interactions ── */
    function initDonateForm() {
        var customInput = page.querySelector('#donate-custom-amount');
        var amountRadios = page.querySelectorAll('.donate-payment__amount-radio');
        var methodLabels = page.querySelectorAll('.donate-payment__method-label');
        var submitBtn = page.querySelector('#donate-submit-btn');
        var bankDetails = page.querySelector('#donate-bank-details');
        var paypalDetails = page.querySelector('#donate-paypal-details');
        var backBtn = page.querySelector('#donate-back-btn');
        var paypalBackBtn = page.querySelector('#donate-paypal-back-btn');
        var qrImg = page.querySelector('#donate-qr-img');

        if (!submitBtn) return;

        /* Deselect radio buttons when custom amount is typed */
        if (customInput) {
            customInput.addEventListener('input', function () {
                amountRadios.forEach(function (r) { r.checked = false; });
            });
        }

        /* Clear custom input when a preset amount is selected */
        amountRadios.forEach(function (radio) {
            radio.addEventListener('change', function () {
                if (customInput) customInput.value = '';
            });
        });

        /* Payment method toggle */
        methodLabels.forEach(function (label) {
            var radio = label.querySelector('.donate-payment__method-radio');
            if (!radio) return;

            radio.addEventListener('change', function () {
                methodLabels.forEach(function (l) {
                    l.classList.remove('donate-payment__method-label--active');
                });
                label.classList.add('donate-payment__method-label--active');
            });
        });

        /* Get selected amount */
        function getSelectedAmount() {
            if (customInput && customInput.value) {
                return parseInt(customInput.value, 10) || 0;
            }
            var checked = page.querySelector('.donate-payment__amount-radio:checked');
            return checked ? parseInt(checked.value, 10) : 0;
        }

        /* Get selected payment method */
        function getSelectedMethod() {
            var checked = page.querySelector('.donate-payment__method-radio:checked');
            return checked ? checked.value : 'bank_transfer';
        }

        /* Elements to hide/show during form <-> details transition */
        var formSteps = page.querySelectorAll('.donate-payment__step');

        function showFormView() {
            formSteps.forEach(function (s) { s.style.display = ''; });
            submitBtn.style.display = '';
            if (bankDetails) bankDetails.hidden = true;
            if (paypalDetails) paypalDetails.hidden = true;
        }

        function hideFormView() {
            formSteps.forEach(function (s) { s.style.display = 'none'; });
            submitBtn.style.display = 'none';
        }

        /* Submit button click */
        submitBtn.addEventListener('click', function () {
            var amount = getSelectedAmount();
            var method = getSelectedMethod();

            if (method === 'bank_transfer' && bankDetails) {
                /* Update QR image with selected amount */
                if (qrImg && amount > 0) {
                    var baseUrl = qrImg.getAttribute('data-base-url');
                    var note = qrImg.getAttribute('data-note') || '';
                    qrImg.src = baseUrl + '?amount=' + amount + '&addInfo=' + encodeURIComponent(note);
                }
                hideFormView();
                bankDetails.hidden = false;
                bankDetails.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            } else if (method === 'paypal' && paypalDetails) {
                hideFormView();
                paypalDetails.hidden = false;
                paypalDetails.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        });

        /* Back buttons */
        if (backBtn) {
            backBtn.addEventListener('click', function () {
                showFormView();
            });
        }
        if (paypalBackBtn) {
            paypalBackBtn.addEventListener('click', function () {
                showFormView();
            });
        }
    }

    /* ── 6. Hide Parent Theme Sections & Sidebar — Force Single Column ── */
    function hideParentThemeSections() {
        document.body.classList.add('ttl-donate-active');

        /* Hide direct siblings of .donate-page (theme injected sections) */
        var parent = page.parentElement;
        if (!parent) return;
        Array.from(parent.children).forEach(function (child) {
            if (child === page) return;
            var tag = child.tagName.toLowerCase();
            if (tag === 'script' || tag === 'style' || tag === 'link' || tag === 'noscript') return;
            child.style.display = 'none';
        });

        /* Traverse up the DOM and hide any sidebar/complementary elements */
        var current = page;
        while (current && current !== document.body) {
            var container = current.parentElement;
            if (!container) break;
            Array.from(container.children).forEach(function (child) {
                if (child === current) return;
                var tag = child.tagName.toLowerCase();
                if (tag === 'script' || tag === 'style' || tag === 'link' || tag === 'noscript' || tag === 'head') return;
                if (tag === 'aside' || child.getAttribute('role') === 'complementary') {
                    child.style.display = 'none';
                }
            });
            current = container;
        }
    }

    /* ── Init all features ── */
    document.addEventListener('DOMContentLoaded', function () {
        initFaqAccordion();
        initStatCounters();
        initSmoothScroll();
        initCopyButtons();
        initDonateForm();
        hideParentThemeSections();
    });
})();
