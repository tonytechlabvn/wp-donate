<?php
/**
 * Donate page — How Funds Help section
 * Single-column horizontal cards with progress bars.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<section class="donate-funds">
    <div class="donate-container">
        <h2 class="donate-section-title">How Your Donation Helps</h2>
        <div class="donate-funds__grid">
            <div class="donate-funds__card">
                <div class="donate-funds__icon" aria-hidden="true">&#128187;</div>
                <div class="donate-funds__body">
                    <h3 class="donate-funds__title">Equipment &amp; Software</h3>
                    <p class="donate-funds__desc">Laptops, development tools, and cloud services for hands-on practice.</p>
                    <div class="donate-funds__bar-wrap">
                        <div class="donate-funds__bar" style="--bar-width: 40%"></div>
                        <span class="donate-funds__pct">40%</span>
                    </div>
                </div>
            </div>
            <div class="donate-funds__card">
                <div class="donate-funds__icon" aria-hidden="true">&#127891;</div>
                <div class="donate-funds__body">
                    <h3 class="donate-funds__title">Student Scholarships</h3>
                    <p class="donate-funds__desc">Financial support so talented students can focus on learning.</p>
                    <div class="donate-funds__bar-wrap">
                        <div class="donate-funds__bar" style="--bar-width: 25%"></div>
                        <span class="donate-funds__pct">25%</span>
                    </div>
                </div>
            </div>
            <div class="donate-funds__card">
                <div class="donate-funds__icon" aria-hidden="true">&#128218;</div>
                <div class="donate-funds__body">
                    <h3 class="donate-funds__title">Curriculum Development</h3>
                    <p class="donate-funds__desc">Creating up-to-date courses aligned with industry demands.</p>
                    <div class="donate-funds__bar-wrap">
                        <div class="donate-funds__bar" style="--bar-width: 20%"></div>
                        <span class="donate-funds__pct">20%</span>
                    </div>
                </div>
            </div>
            <div class="donate-funds__card">
                <div class="donate-funds__icon" aria-hidden="true">&#127970;</div>
                <div class="donate-funds__body">
                    <h3 class="donate-funds__title">Infrastructure</h3>
                    <p class="donate-funds__desc">Maintaining servers, classrooms, and online learning platforms.</p>
                    <div class="donate-funds__bar-wrap">
                        <div class="donate-funds__bar" style="--bar-width: 15%"></div>
                        <span class="donate-funds__pct">15%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
