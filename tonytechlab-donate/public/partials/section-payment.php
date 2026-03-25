<?php
/**
 * Frontend — Payment section (two-column card: impact info + donation form).
 * Left: where your money goes. Right: amount, message, payment method.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$payment        = TonyTechLab_Donate_Settings_Manager::get( 'payment' );
$funds          = TonyTechLab_Donate_Settings_Manager::get( 'funds' );
$bank_name      = $payment['bank_name'];
$bank_bin       = $payment['bank_bin'];
$account_number = $payment['account_number'];
$account_holder = $payment['account_holder'];
$transfer_note  = $payment['transfer_note'];
$qr_label       = $payment['qr_label'] ?? 'Quét Mã VietQR';
$qr_desc        = $payment['qr_description'] ?? '';
$paypal_id      = $payment['paypal_button_id'] ?? '';
$has_paypal     = ! empty( $paypal_id ) && 'YOUR_BUTTON_ID' !== $paypal_id;

/* Fund items for impact column (max 3) */
$fund_items = array_slice( $funds['items'] ?? array(), 0, 3 );

/* Color map for fund icons */
$color_map = array(
    'blue'   => array( 'bg' => '#dbeafe', 'fg' => '#2563eb' ),
    'green'  => array( 'bg' => '#d1fae5', 'fg' => '#059669' ),
    'purple' => array( 'bg' => '#ede9fe', 'fg' => '#7c3aed' ),
    'orange' => array( 'bg' => '#ffedd5', 'fg' => '#ea580c' ),
);

/* Preset donation amounts */
$amounts = array( 50000, 100000, 200000, 500000 );
?>

<section class="donate-payment" id="donate-section">
    <div class="donate-container">
        <div class="donate-payment__card">

            <!-- Left column: Impact info -->
            <div class="donate-payment__impact">
                <div class="donate-payment__impact-content">
                    <h2 class="donate-payment__impact-title">Khoản đóng góp của bạn đi về đâu?</h2>

                    <div class="donate-payment__impact-list">
                        <?php foreach ( $fund_items as $item ) :
                            $color = $item['color'] ?? 'blue';
                            $c     = $color_map[ $color ] ?? $color_map['blue'];
                        ?>
                            <div class="donate-payment__impact-item">
                                <div class="donate-payment__impact-icon" style="background:<?php echo esc_attr( $c['bg'] ); ?>;color:<?php echo esc_attr( $c['fg'] ); ?>" aria-hidden="true">
                                    <?php echo wp_kses_post( $item['icon'] ); ?>
                                </div>
                                <div>
                                    <h3 class="donate-payment__impact-name"><?php echo esc_html( $item['title'] ); ?></h3>
                                    <p class="donate-payment__impact-desc"><?php echo esc_html( $item['description'] ); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="donate-payment__trust">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="donate-payment__trust-icon">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        <path d="m9 12 2 2 4-4"/>
                    </svg>
                    <p>Chúng tôi cam kết sử dụng tài chính minh bạch, tất cả đều hướng tới mục tiêu phụng sự cộng đồng.</p>
                </div>
            </div>

            <!-- Right column: Donation form -->
            <div class="donate-payment__form-wrap">

                <!-- Step 1: Amount selection -->
                <div class="donate-payment__step">
                    <h3 class="donate-payment__step-title">1. Chọn mức ủng hộ</h3>
                    <div class="donate-payment__amounts">
                        <?php foreach ( $amounts as $i => $amt ) : ?>
                            <label class="donate-payment__amount-label">
                                <input type="radio" name="donate_amount" value="<?php echo esc_attr( $amt ); ?>"
                                       class="donate-payment__amount-radio sr-only"
                                       <?php echo ( $i === 1 ) ? 'checked' : ''; ?> />
                                <span class="donate-payment__amount-card">
                                    <?php echo esc_html( number_format( $amt, 0, ',', '.' ) ); ?>₫
                                </span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <div class="donate-payment__custom-wrap">
                        <span class="donate-payment__custom-prefix">VNĐ</span>
                        <input type="number" id="donate-custom-amount"
                               class="donate-payment__custom-input"
                               placeholder="Hoặc nhập số tiền khác..." />
                    </div>
                </div>

                <!-- Step 2: Name / Message -->
                <div class="donate-payment__step">
                    <h3 class="donate-payment__step-title">
                        2. Lời nhắn
                        <span class="donate-payment__optional">(Không bắt buộc)</span>
                    </h3>
                    <input type="text" class="donate-payment__input"
                           placeholder="Tên hoặc Biệt danh của bạn" />
                    <textarea rows="2" class="donate-payment__input donate-payment__textarea"
                              placeholder="Chia sẻ cảm nghĩ hoặc lời động viên cho Team..."></textarea>
                </div>

                <!-- Step 3: Payment method -->
                <div class="donate-payment__step">
                    <h3 class="donate-payment__step-title">3. Phương thức chuyển</h3>

                    <label class="donate-payment__method-label donate-payment__method-label--active" data-method="bank">
                        <input type="radio" name="donate_method" value="bank_transfer"
                               class="donate-payment__method-radio sr-only" checked />
                        <div class="donate-payment__method-icon-wrap">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="5" height="5" x="3" y="3" rx="1"/><rect width="5" height="5" x="16" y="3" rx="1"/><rect width="5" height="5" x="3" y="16" rx="1"/><rect width="5" height="5" x="16" y="16" rx="1"/><path d="M11 3h2"/><path d="M11 8h2"/><path d="M11 13h2"/><path d="M11 18h2"/><path d="M3 11v2"/><path d="M8 11v2"/><path d="M13 11v2"/><path d="M18 11v2"/>
                            </svg>
                        </div>
                        <div class="donate-payment__method-text">
                            <strong>Quét mã QR / Chuyển khoản</strong>
                            <span class="donate-payment__method-desc">Khuyên dùng — Nhanh chóng &amp; Miễn phí</span>
                        </div>
                    </label>

                    <?php if ( $has_paypal ) : ?>
                        <label class="donate-payment__method-label" data-method="paypal">
                            <input type="radio" name="donate_method" value="paypal"
                                   class="donate-payment__method-radio sr-only" />
                            <div class="donate-payment__method-icon-wrap">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/>
                                </svg>
                            </div>
                            <div class="donate-payment__method-text">
                                <strong>Thẻ Quốc Tế / PayPal</strong>
                                <span class="donate-payment__method-desc">Dành cho học viên đang ở nước ngoài</span>
                            </div>
                        </label>
                    <?php endif; ?>
                </div>

                <!-- CTA button -->
                <button type="button" class="donate-payment__cta" id="donate-submit-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" stroke="none">
                        <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>
                    </svg>
                    Tiếp tục thanh toán
                </button>

                <!-- Bank transfer details (shown after submit) -->
                <div class="donate-payment__bank-details" id="donate-bank-details" hidden>
                    <div class="donate-payment__bank-header">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                        <span>Vui lòng chuyển khoản theo thông tin bên dưới</span>
                    </div>

                    <div class="donate-payment__qr-center">
                        <img src="https://img.vietqr.io/image/<?php echo esc_attr( $bank_bin ); ?>-<?php echo esc_attr( str_replace( ' ', '', $account_number ) ); ?>-compact.jpg?amount=0&addInfo=<?php echo rawurlencode( $transfer_note ); ?>"
                             alt="<?php echo esc_attr( 'VietQR code for bank transfer' ); ?>"
                             class="donate-payment__qr-img" id="donate-qr-img"
                             data-base-url="https://img.vietqr.io/image/<?php echo esc_attr( $bank_bin ); ?>-<?php echo esc_attr( str_replace( ' ', '', $account_number ) ); ?>-compact.jpg"
                             data-note="<?php echo esc_attr( $transfer_note ); ?>"
                             width="200" height="200" loading="lazy" />
                        <p class="donate-payment__qr-label"><?php echo esc_html( $qr_label ); ?></p>
                    </div>

                    <div class="donate-payment__field-list">
                        <div class="donate-payment__field">
                            <span class="donate-payment__field-label">Ngân hàng</span>
                            <span class="donate-payment__field-value"><?php echo esc_html( $bank_name ); ?></span>
                        </div>
                        <div class="donate-payment__field">
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
                        <div class="donate-payment__field">
                            <span class="donate-payment__field-label">Tên tài khoản</span>
                            <span class="donate-payment__field-value"><?php echo esc_html( $account_holder ); ?></span>
                        </div>
                        <div class="donate-payment__field">
                            <span class="donate-payment__field-label">Nội dung</span>
                            <span class="donate-payment__field-value"><?php echo esc_html( $transfer_note ); ?></span>
                        </div>
                    </div>

                    <button type="button" class="donate-payment__back-btn" id="donate-back-btn">
                        ← Quay lại
                    </button>
                </div>

                <!-- PayPal container (shown after submit with PayPal method) -->
                <?php if ( $has_paypal ) : ?>
                    <div class="donate-payment__paypal-details" id="donate-paypal-details" hidden>
                        <div class="donate-payment__bank-header">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                <polyline points="22 4 12 14.01 9 11.01"/>
                            </svg>
                            <span>Nhấn nút bên dưới để chuyển khoản qua PayPal</span>
                        </div>
                        <div id="donate-button-container"></div>
                        <button type="button" class="donate-payment__back-btn" id="donate-paypal-back-btn">
                            ← Quay lại
                        </button>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>
