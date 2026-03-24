<?php
/**
 * Admin tab — Payment credentials settings (Bank Transfer + PayPal).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$payment = TonyTechLab_Donate_Settings_Manager::get( 'payment' );
?>
<form method="post" action="options.php">
    <?php settings_fields( 'tonytechlab_payment_group' ); ?>

    <p class="ttl-admin-description">
        Configure your bank account and PayPal details for receiving donations.
    </p>

    <h3>Bank Transfer (VietQR)</h3>
    <table class="form-table">
        <tr>
            <th><label for="ttl-bank-name">Bank Name</label></th>
            <td>
                <input type="text" id="ttl-bank-name" name="tonytechlab_payment[bank_name]"
                       value="<?php echo esc_attr( $payment['bank_name'] ); ?>" class="regular-text" />
                <p class="description">e.g. Vietcombank, Techcombank, MB Bank</p>
            </td>
        </tr>
        <tr>
            <th><label for="ttl-bank-bin">Bank BIN Code</label></th>
            <td>
                <input type="text" id="ttl-bank-bin" name="tonytechlab_payment[bank_bin]"
                       value="<?php echo esc_attr( $payment['bank_bin'] ); ?>" class="regular-text" />
                <p class="description">VietQR bank identification number. Find yours at vietqr.io/danh-sach-ngan-hang</p>
            </td>
        </tr>
        <tr>
            <th><label for="ttl-account-number">Account Number</label></th>
            <td>
                <input type="text" id="ttl-account-number" name="tonytechlab_payment[account_number]"
                       value="<?php echo esc_attr( $payment['account_number'] ); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="ttl-account-holder">Account Holder</label></th>
            <td>
                <input type="text" id="ttl-account-holder" name="tonytechlab_payment[account_holder]"
                       value="<?php echo esc_attr( $payment['account_holder'] ); ?>" class="regular-text" />
                <p class="description">Must match bank records exactly (usually UPPERCASE).</p>
            </td>
        </tr>
        <tr>
            <th><label for="ttl-transfer-note">Default Transfer Note</label></th>
            <td>
                <input type="text" id="ttl-transfer-note" name="tonytechlab_payment[transfer_note]"
                       value="<?php echo esc_attr( $payment['transfer_note'] ); ?>" class="regular-text" />
            </td>
        </tr>
    </table>

    <h3>PayPal</h3>
    <table class="form-table">
        <tr>
            <th><label for="ttl-paypal-id">Hosted Button ID</label></th>
            <td>
                <input type="text" id="ttl-paypal-id" name="tonytechlab_payment[paypal_button_id]"
                       value="<?php echo esc_attr( $payment['paypal_button_id'] ); ?>" class="regular-text" />
                <p class="description">Create a Donate button at paypal.com/buttons and paste the hosted_button_id here.</p>
            </td>
        </tr>
    </table>

    <?php submit_button(); ?>
</form>
