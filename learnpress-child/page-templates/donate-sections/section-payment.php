<?php
/**
 * Donate page — Payment section
 * Tabbed interface: Bank Transfer (VietQR) | PayPal Donate Button.
 *
 * Configuration: Define these constants in wp-config.php before going live:
 *   TONYTECHLAB_BANK_NAME, TONYTECHLAB_BANK_BIN, TONYTECHLAB_ACCOUNT_NUMBER,
 *   TONYTECHLAB_ACCOUNT_HOLDER, TONYTECHLAB_TRANSFER_NOTE, TONYTECHLAB_PAYPAL_BUTTON_ID
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Read from wp-config.php constants, fall back to placeholders
$bank_name      = defined( 'TONYTECHLAB_BANK_NAME' ) ? TONYTECHLAB_BANK_NAME : 'Your Bank Name';
$bank_bin       = defined( 'TONYTECHLAB_BANK_BIN' ) ? TONYTECHLAB_BANK_BIN : '970436';
$account_number = defined( 'TONYTECHLAB_ACCOUNT_NUMBER' ) ? TONYTECHLAB_ACCOUNT_NUMBER : '1234567890';
$account_holder = defined( 'TONYTECHLAB_ACCOUNT_HOLDER' ) ? TONYTECHLAB_ACCOUNT_HOLDER : 'ACCOUNT HOLDER NAME';
$transfer_note  = defined( 'TONYTECHLAB_TRANSFER_NOTE' ) ? TONYTECHLAB_TRANSFER_NOTE : 'Donate TonyTechLab';
?>

<section class="donate-payment" id="donate-section">
    <div class="donate-container">
        <h2 class="donate-section-title">Make a Donation</h2>

        <!-- Tab navigation -->
        <div class="donate-tabs" role="tablist" aria-label="<?php echo esc_attr( 'Payment methods' ); ?>">
            <button class="donate-tabs__btn is-active"
                    role="tab"
                    id="tab-bank"
                    aria-selected="true"
                    aria-controls="panel-bank">
                Bank Transfer
            </button>
            <button class="donate-tabs__btn"
                    role="tab"
                    id="tab-paypal"
                    aria-selected="false"
                    aria-controls="panel-paypal"
                    tabindex="-1">
                PayPal
            </button>
        </div>

        <!-- Bank Transfer tab panel -->
        <div class="donate-tabs__panel is-active"
             role="tabpanel"
             id="panel-bank"
             aria-labelledby="tab-bank">
            <div class="donate-bank">
                <div class="donate-bank__qr">
                    <img src="https://img.vietqr.io/image/<?php echo esc_attr( $bank_bin ); ?>-<?php echo esc_attr( $account_number ); ?>-compact.jpg?amount=0&addInfo=<?php echo rawurlencode( $transfer_note ); ?>"
                         alt="<?php echo esc_attr( 'VietQR code for bank transfer' ); ?>"
                         class="donate-bank__qr-img"
                         width="250"
                         height="250"
                         loading="lazy" />
                </div>
                <div class="donate-bank__info">
                    <dl class="donate-bank__details">
                        <dt>Bank</dt>
                        <dd><?php echo esc_html( $bank_name ); ?></dd>
                        <dt>Account Number</dt>
                        <dd>
                            <span id="bank-account-number"><?php echo esc_html( $account_number ); ?></span>
                            <button class="donate-btn donate-btn--copy"
                                    type="button"
                                    data-copy-target="#bank-account-number"
                                    aria-label="<?php echo esc_attr( 'Copy account number' ); ?>">
                                Copy
                            </button>
                        </dd>
                        <dt>Account Holder</dt>
                        <dd><?php echo esc_html( $account_holder ); ?></dd>
                        <dt>Transfer Note</dt>
                        <dd><?php echo esc_html( $transfer_note ); ?></dd>
                    </dl>
                    <p class="donate-bank__hint">
                        Scan the QR code with any Vietnamese banking app, or transfer manually using the details above.
                    </p>
                </div>
            </div>
        </div>

        <!-- PayPal tab panel -->
        <div class="donate-tabs__panel"
             role="tabpanel"
             id="panel-paypal"
             aria-labelledby="tab-paypal"
             hidden>
            <div class="donate-paypal">
                <p class="donate-paypal__intro">Support us securely via PayPal — accepts all major credit and debit cards.</p>
                <!-- PayPal Donate Button renders here (SDK enqueued via functions.php) -->
                <div id="donate-button-container" class="donate-paypal__btn-wrap"></div>
            </div>
        </div>
    </div>
</section>
