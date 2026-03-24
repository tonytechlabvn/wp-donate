<?php
/**
 * Admin tab — Design settings (colors + font).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$design = TonyTechLab_Donate_Settings_Manager::get( 'design' );
?>
<form method="post" action="options.php">
    <?php settings_fields( 'tonytechlab_design_group' ); ?>

    <p class="ttl-admin-description">
        Customize the donate page appearance. Changes apply to the frontend immediately after saving.
    </p>

    <table class="form-table">
        <tr>
            <th><label for="ttl-primary-color">Primary Color</label></th>
            <td>
                <input type="text" id="ttl-primary-color" name="tonytechlab_design[primary_color]"
                       value="<?php echo esc_attr( $design['primary_color'] ); ?>"
                       class="ttl-color-picker" data-default-color="#2563eb" />
                <p class="description">Hero gradient, stats numbers, active tabs, fund badges.</p>
            </td>
        </tr>
        <tr>
            <th><label for="ttl-secondary-color">Secondary Color</label></th>
            <td>
                <input type="text" id="ttl-secondary-color" name="tonytechlab_design[secondary_color]"
                       value="<?php echo esc_attr( $design['secondary_color'] ); ?>"
                       class="ttl-color-picker" data-default-color="#f59e0b" />
                <p class="description">CTA buttons, focus outlines, email link color.</p>
            </td>
        </tr>
        <tr>
            <th><label for="ttl-font-family">Font Family</label></th>
            <td>
                <select id="ttl-font-family" name="tonytechlab_design[font_family]">
                    <option value="inter" <?php selected( $design['font_family'], 'inter' ); ?>>Inter</option>
                    <option value="system" <?php selected( $design['font_family'], 'system' ); ?>>System UI</option>
                    <option value="roboto" <?php selected( $design['font_family'], 'roboto' ); ?>>Roboto</option>
                    <option value="open-sans" <?php selected( $design['font_family'], 'open-sans' ); ?>>Open Sans</option>
                    <option value="lato" <?php selected( $design['font_family'], 'lato' ); ?>>Lato</option>
                </select>
                <p class="description">Selecting "System UI" avoids external font loading for fastest performance.</p>
            </td>
        </tr>
    </table>

    <?php submit_button(); ?>
</form>
