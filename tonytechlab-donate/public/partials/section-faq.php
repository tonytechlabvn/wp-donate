<?php
/**
 * Frontend — FAQ accordion section (chevron icons).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$faq   = TonyTechLab_Donate_Settings_Manager::get( 'faq' );
$items = $faq['items'] ?? array();
?>

<section class="donate-faq">
    <div class="donate-container">
        <h2 class="donate-section-title"><?php echo esc_html( $faq['heading'] ); ?></h2>
        <div class="donate-faq__list">
            <?php foreach ( $items as $index => $item ) : ?>
                <div class="donate-faq__item">
                    <button class="donate-faq__question" type="button"
                            aria-expanded="false"
                            aria-controls="<?php echo esc_attr( 'faq-answer-' . $index ); ?>">
                        <span><?php echo esc_html( $item['question'] ); ?></span>
                        <span class="donate-faq__icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </span>
                    </button>
                    <div class="donate-faq__answer"
                         id="<?php echo esc_attr( 'faq-answer-' . $index ); ?>" hidden>
                        <p><?php echo esc_html( $item['answer'] ); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
