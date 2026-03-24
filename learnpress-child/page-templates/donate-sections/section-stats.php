<?php
/**
 * Donate page — Impact Stats section
 * Animated counter cards showing key metrics.
 * HTML shows real values (for no-JS / SEO). JS resets to 0 then animates.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<section class="donate-stats">
    <div class="donate-container">
        <h2 class="donate-section-title">Our Impact</h2>
        <div class="donate-stats__grid">
            <div class="donate-stats__card">
                <span class="donate-stats__number" data-target="500">500</span>
                <span class="donate-stats__label">Students Coached</span>
            </div>
            <div class="donate-stats__card">
                <span class="donate-stats__number" data-target="30">30</span>
                <span class="donate-stats__label">Courses Offered</span>
            </div>
            <div class="donate-stats__card">
                <span class="donate-stats__number" data-target="2000">2,000</span>
                <span class="donate-stats__label">Hours Taught</span>
            </div>
            <div class="donate-stats__card">
                <span class="donate-stats__number" data-target="95">95</span>
                <span class="donate-stats__suffix">%</span>
                <span class="donate-stats__label">Success Rate</span>
            </div>
        </div>
    </div>
</section>
