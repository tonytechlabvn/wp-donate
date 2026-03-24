<?php
/**
 * Default settings for all donate page sections.
 * Single source of truth — used by activation hook and settings getter.
 * Content in Vietnamese for tonytechlab.com audience.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Return all default option values keyed by option name.
 */
function tonytechlab_donate_get_defaults() {
    return array(
        'tonytechlab_hero' => array(
            'title'              => 'Tiếp Sức Thế Hệ Chuyên Gia CNTT Tương Lai',
            'title_highlight'    => 'Chuyên Gia CNTT Tương Lai',
            'tag_text'           => 'KỸ THUẬT & TƯƠNG LAI',
            'subtitle'           => 'Chúng tôi xây dựng nền tảng tri thức vững chắc cho sinh viên Việt Nam, rút ngắn khoảng cách giữa giáo dục và thực tế ngành công nghệ.',
            'cta_text'           => 'Ủng Hộ Ngay',
            'secondary_cta_text' => 'Tìm Hiểu Thêm',
            'image_url'          => '',
            'badge_title'        => 'Đạt tiêu chuẩn quốc tế',
            'badge_description'  => 'Bạn được đào tạo tại các tiêu chuẩn công nghệ hàng đầu.',
        ),
        'tonytechlab_mission' => array(
            'heading'    => 'Sứ Mệnh Của Chúng Tôi',
            'paragraphs' => array(
                'TechEdu Philanthropy tạo công cho mọi tài năng công nghệ đều vững đang có cơ hội được nảy nở. Chúng tôi không chỉ cung cấp tài chính, chúng tôi tối hóa hệ sinh thái tri thức và lòng nhân ái giao thoa để tạo nên những giá trị bền vững cho xã hội số.',
            ),
            'bullets' => array(
                'Tiếp cận giáo dục CNTT chất lượng cao cho vùng sâu vùng xa.',
                'Xây dựng cầu nối việc làm với các doanh nghiệp Top-tier.',
            ),
            'image_url'    => '',
            'badge_top'    => 'Impactful',
            'badge_bottom' => '100%',
        ),
        'tonytechlab_stats' => array(
            'heading' => 'Tác Động Của Chúng Tôi',
            'items'   => array(
                array( 'number' => 500,  'suffix' => '+', 'label' => 'Học Viên' ),
                array( 'number' => 30,   'suffix' => '+', 'label' => 'Khóa Học' ),
                array( 'number' => 2000, 'suffix' => '+', 'label' => 'Đội Giảng' ),
                array( 'number' => 95,   'suffix' => '%', 'label' => 'Thành Công' ),
            ),
        ),
        'tonytechlab_funds' => array(
            'heading'  => 'Đóng Góp Của Bạn Được Sử Dụng Như Thế Nào',
            'subtitle' => 'Mỗi đồng đóng góp đều được phân bổ chiến lược để tối ưu hóa tác động giáo dục.',
            'items'    => array(
                array( 'icon' => '&#128187;', 'title' => 'Thiết Bị',         'description' => 'Cung cấp máy tính và thiết bị cho sinh viên có hoàn cảnh khó khăn để thực hành lập trình.', 'percentage' => 40, 'color' => 'blue' ),
                array( 'icon' => '&#127891;', 'title' => 'Học Bổng',         'description' => 'Hỗ trợ tài chính cho sinh viên tài năng tập trung vào học tập và phát triển kỹ năng.',   'percentage' => 25, 'color' => 'green' ),
                array( 'icon' => '&#128218;', 'title' => 'Phát Triển',       'description' => 'Xây dựng giáo trình, tổ chức workshop và mở rộng các chương trình đào tạo quốc tế.',      'percentage' => 20, 'color' => 'purple' ),
                array( 'icon' => '&#127970;', 'title' => 'Cơ Sở Hạ Tầng',   'description' => 'Nâng cấp phòng giảng dạy và cơ sở hạ tầng mạng lưới cho học viên.',                      'percentage' => 15, 'color' => 'orange' ),
            ),
        ),
        'tonytechlab_testimonials' => array(
            'heading' => 'Học Viên Nói Gì Về Chúng Tôi',
            'items'   => array(
                array( 'quote' => 'Nhờ sự hỗ trợ từ TechEdu, tôi đã hoàn thành khóa học và có được công việc lập trình viên đầu tiên. Cảm ơn chúng tôi đã giúp tôi phát triển sự nghiệp.', 'name' => 'Minh Anh', 'course' => 'LẬP TRÌNH VIÊN FULL-STACK' ),
                array( 'quote' => 'Sự hỗ trợ của các giảng viên và cơ sở vật chất hiện đại đã giúp tôi nhanh chóng nắm bắt và giải quyết vấn đề chuyên nghiệp.',                             'name' => 'Thanh Thảo', 'course' => 'PHÂN TÍCH DỮ LIỆU' ),
                array( 'quote' => 'Nhờ dự án công đồng này, em đã có được công việc mơ ước. Tôi tin tưởng các chương trình đào tạo và hỗ trợ của tổ chức.',                                    'name' => 'Tuấn Kiệt', 'course' => 'KỸ SƯ DEVOPS' ),
            ),
        ),
        'tonytechlab_payment' => array(
            'bank_name'         => 'VIETCOMBANK (VCB)',
            'bank_bin'          => '970436',
            'account_number'    => '123 456 7890',
            'account_holder'    => 'QUỸ GIÁO DỤC TECHEDU',
            'transfer_note'     => 'ỦNG HỘ [TÊN CỦA BẠN]',
            'paypal_button_id'  => 'YOUR_BUTTON_ID',
            'qr_label'          => 'Quét Mã VietQR',
            'qr_description'    => 'Mở ứng dụng ngân hàng hoặc ví điện tử để quét mã QR và ủng hộ thành công.',
        ),
        'tonytechlab_faq' => array(
            'heading' => 'Câu Hỏi Thường Gặp',
            'items'   => array(
                array( 'question' => 'Đóng góp của tôi có được cấp chứng nhận không?',         'answer' => 'Có, chúng tôi sẽ gửi giấy chứng nhận đóng từ và thư cảm ơn đến email của bạn sau khi giao dịch được xác minh thành công.' ),
                array( 'question' => 'Làm sao để biết tiền của tôi được sử dụng mục đích?',    'answer' => 'Chúng tôi công khai báo cáo tài chính hàng quý trên website và gửi bản tóm tắt qua email cho các nhà tài trợ.' ),
                array( 'question' => 'Tôi có thể đăng ký làm tình nguyện viên không?',         'answer' => 'Chắc chắn rồi! Chúng tôi luôn hoàn nghênh các chuyên gia CNTT tham gia giảng dạy hoặc mentor cho học viên.' ),
            ),
        ),
        'tonytechlab_footer' => array(
            'heading'      => 'TechEdu Philanthropy',
            'email'        => 'contact@tonytechlab.com',
            'social_links' => array(
                array( 'label' => 'Facebook', 'url' => 'https://facebook.com/tonytechlab' ),
                array( 'label' => 'YouTube',  'url' => 'https://youtube.com/@tonytechlab' ),
                array( 'label' => 'GitHub',   'url' => 'https://github.com/tonytechlab' ),
            ),
            'disclaimer'   => 'TechEdu Philanthropy. Empowering the next generation of architects.',
            'links'        => array(
                array( 'label' => 'Privacy Policy',    'url' => '#' ),
                array( 'label' => 'Terms of Service',  'url' => '#' ),
                array( 'label' => 'Annual Report',     'url' => '#' ),
                array( 'label' => 'Contact Us',        'url' => '#' ),
            ),
        ),
        'tonytechlab_design' => array(
            'primary_color'   => '#2563eb',
            'secondary_color' => '#f59e0b',
            'font_family'     => 'inter',
        ),
    );
}
