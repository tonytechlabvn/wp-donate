/**
 * TonyTechLab Donate Page — Interactions
 *
 * Features:
 *   1. FAQ accordion (ARIA-compliant)
 *   2. Payment tab switching (ARIA tabs pattern)
 *   3. Stat counter animation (IntersectionObserver)
 *   4. Smooth scroll for anchor links
 *   5. Copy-to-clipboard for bank account number
 *   6. Scroll reveal with staggered delays
 *   7. Hide parent theme sections (Popular Courses, Last Posts)
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

    /* ── 2. Payment Tab Switching ── */
    function initPaymentTabs() {
        var tablist = page.querySelector('.donate-tabs[role="tablist"]');
        if (!tablist) return;

        var tabs = tablist.querySelectorAll('[role="tab"]');
        var panels = page.querySelectorAll('.donate-tabs__panel[role="tabpanel"]');

        function activateTab(tab) {
            tabs.forEach(function (t) {
                t.classList.remove('is-active');
                t.setAttribute('aria-selected', 'false');
                t.setAttribute('tabindex', '-1');
            });
            panels.forEach(function (p) {
                p.classList.remove('is-active');
                p.setAttribute('hidden', '');
            });

            tab.classList.add('is-active');
            tab.setAttribute('aria-selected', 'true');
            tab.removeAttribute('tabindex');

            var panelId = tab.getAttribute('aria-controls');
            var panel = document.getElementById(panelId);
            if (panel) {
                panel.classList.add('is-active');
                panel.removeAttribute('hidden');
            }
        }

        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                activateTab(tab);
            });

            tab.addEventListener('keydown', function (e) {
                var tabArray = Array.from(tabs);
                var index = tabArray.indexOf(tab);

                if (e.key === 'ArrowRight' || e.key === 'ArrowLeft') {
                    e.preventDefault();
                    var next = e.key === 'ArrowRight'
                        ? tabArray[(index + 1) % tabArray.length]
                        : tabArray[(index - 1 + tabArray.length) % tabArray.length];
                    next.focus();
                    activateTab(next);
                }
            });
        });
    }

    /* ── 3. Stat Counter Animation ── */
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

    /* ── 4. Smooth Scroll ── */
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

    /* ── 5. Copy to Clipboard ── */
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

    /* ── 6. Scroll Reveal with Staggered Delays ── */
    function initScrollReveal() {
        if (!('IntersectionObserver' in window)) return;
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

        var sections = page.querySelectorAll(
            '.donate-mission, .donate-stats, .donate-funds, ' +
            '.donate-testimonials, .donate-payment, .donate-faq, .donate-page-footer'
        );

        sections.forEach(function (el, i) {
            el.classList.add('donate-reveal');
            el.style.transitionDelay = (i * 0.05) + 's';
        });

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.08, rootMargin: '0px 0px -50px 0px' });

        sections.forEach(function (el) { observer.observe(el); });
    }

    /* ── 7. Hide Parent Theme Sections ── */
    function hideParentThemeSections() {
        var parent = page.parentElement;
        if (!parent) return;

        Array.from(parent.children).forEach(function (child) {
            if (child === page) return;
            var tag = child.tagName.toLowerCase();
            if (tag === 'script' || tag === 'style' || tag === 'link' || tag === 'noscript') return;

            child.style.display = 'none';
        });
    }

    /* ── Init all features ── */
    document.addEventListener('DOMContentLoaded', function () {
        initFaqAccordion();
        initPaymentTabs();
        initStatCounters();
        initSmoothScroll();
        initCopyButtons();
        initScrollReveal();
        hideParentThemeSections();
    });
})();
