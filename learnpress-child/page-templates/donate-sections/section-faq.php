<?php
/**
 * Donate page — FAQ section
 * Accordion Q&A about donations. JS toggles .is-open class.
 * Each button has aria-controls pointing to its answer panel ID.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$faqs = array(
    array(
        'q' => 'How are the funds used?',
        'a' => 'All donations go directly to supporting our students — covering equipment, scholarships, curriculum development, and infrastructure. We publish an annual transparency report so donors can see exactly how funds are allocated.',
    ),
    array(
        'q' => 'Is my donation tax-deductible?',
        'a' => 'TonyTechLab is a registered non-profit organization. Tax deductibility depends on your country\'s regulations. Please consult your local tax advisor for specific guidance.',
    ),
    array(
        'q' => 'Is there a minimum donation amount?',
        'a' => 'No minimum — every contribution matters! Whether it\'s 10,000 VND or $5, your support makes a real difference in a student\'s life.',
    ),
    array(
        'q' => 'Can I donate monthly?',
        'a' => 'Currently we accept one-time donations via bank transfer and PayPal. We are working on a recurring donation option — stay tuned!',
    ),
    array(
        'q' => 'How can I verify my donation was received?',
        'a' => 'For bank transfers, you\'ll see confirmation in your banking app. For PayPal, you\'ll receive an email receipt. You can also contact us directly at our email for confirmation.',
    ),
    array(
        'q' => 'Can I donate equipment instead of money?',
        'a' => 'Yes! We welcome donations of laptops, monitors, and other IT equipment in working condition. Please contact us via email to arrange a drop-off or shipment.',
    ),
);
?>

<section class="donate-faq">
    <div class="donate-container">
        <h2 class="donate-section-title">Frequently Asked Questions</h2>
        <div class="donate-faq__list">
            <?php foreach ( $faqs as $index => $faq ) : ?>
                <div class="donate-faq__item">
                    <button class="donate-faq__question"
                            type="button"
                            aria-expanded="false"
                            aria-controls="<?php echo esc_attr( 'faq-answer-' . $index ); ?>">
                        <span><?php echo esc_html( $faq['q'] ); ?></span>
                        <span class="donate-faq__icon" aria-hidden="true">+</span>
                    </button>
                    <div class="donate-faq__answer"
                         id="<?php echo esc_attr( 'faq-answer-' . $index ); ?>"
                         hidden>
                        <p><?php echo esc_html( $faq['a'] ); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
