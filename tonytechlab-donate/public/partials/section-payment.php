<?php
/**
 * Frontend — Payment section (two-tone card: white info + blue QR).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$payment        = TonyTechLab_Donate_Settings_Manager::get( 'payment' );
$bank_name      = $payment['bank_name'];
$bank_bin       = $payment['bank_bin'];
$account_number = $payment['account_number'];
$account_holder = $payment['account_holder'];
$transfer_note  = $payment['transfer_note'];
$qr_label       = $payment['qr_label'] ?? 'Quét Mã VietQR';
$qr_desc        = $payment['qr_description'] ?? '';
?>

<section class="donate-payment" id="donate-section">
    <div class="donate-container">
        <h2 class="donate-section-title">Ủng Hộ Chúng Tôi</h2>
        <p class="donate-section-subtitle">
            Sự đóng góp của bạn là động lực to lớn giúp chúng tôi duy trì các hoạt động phi lợi nhuận.
            Vui lòng chọn phương thức chuyển khoản bên dưới.
        </p>

        <div class="donate-payment__card">
            <!-- Left: bank info fields -->
            <div class="donate-payment__info">
                <div class="donate-payment__field">
                    <span class="donate-payment__field-icon" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
                    </span>
                    <div class="donate-payment__field-content">
                        <span class="donate-payment__field-label">Ngân hàng</span>
                        <span class="donate-payment__field-value"><?php echo esc_html( $bank_name ); ?></span>
                    </div>
                </div>

                <div class="donate-payment__field">
                    <span class="donate-payment__field-icon" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                    </span>
                    <div class="donate-payment__field-content">
                        <span class="donate-payment__field-label">Số tài khoản</span>
                        <span class="donate-payment__field-value">
                            <span id="bank-account-number"><?php echo esc_html( $account_number ); ?></span>
                            <button class="donate-btn donate-btn--copy" type="button"
                                    data-copy-target="#bank-account-number"
                                    aria-label="<?php echo esc_attr( 'Sao chép số tài khoản' ); ?>">
                                Sao chép
                            </button>
                        </span>
                    </div>
                </div>

                <div class="donate-payment__field">
                    <span class="donate-payment__field-icon" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </span>
                    <div class="donate-payment__field-content">
                        <span class="donate-payment__field-label">Tên tài khoản</span>
                        <span class="donate-payment__field-value"><?php echo esc_html( $account_holder ); ?></span>
                    </div>
                </div>

                <div class="donate-payment__field">
                    <span class="donate-payment__field-icon" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    </span>
                    <div class="donate-payment__field-content">
                        <span class="donate-payment__field-label">Nội dung</span>
                        <span class="donate-payment__field-value"><?php echo esc_html( $transfer_note ); ?></span>
                    </div>
                </div>
            </div>

            <!-- Right: QR code -->
            <div class="donate-payment__qr">
                <img src="https://img.vietqr.io/image/<?php echo esc_attr( $bank_bin ); ?>-<?php echo esc_attr( str_replace( ' ', '', $account_number ) ); ?>-compact.jpg?amount=0&addInfo=<?php echo rawurlencode( $transfer_note ); ?>"
                     alt="<?php echo esc_attr( 'VietQR code for bank transfer' ); ?>"
                     class="donate-payment__qr-img" width="200" height="200" loading="lazy" />
                <p class="donate-payment__qr-label"><?php echo esc_html( $qr_label ); ?></p>
                <?php if ( $qr_desc ) : ?>
                    <p class="donate-payment__qr-desc"><?php echo esc_html( $qr_desc ); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
