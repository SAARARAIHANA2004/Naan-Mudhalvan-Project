<?php
// Hook into 'customize_register' to add Customizer settings
function mytheme_customize_register($wp_customize) {

    // 1. Add a section for Site Identity
    $wp_customize->add_section('mytheme_identity_section', array(
        'title'       => __('Site Identity', 'mytheme'),
        'priority'    => 20,
        'description' => 'Change site logo, colors and fonts here.',
    ));

    // 2. Add setting and control for Logo
    $wp_customize->add_setting('mytheme_logo', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'mytheme_logo_control', array(
        'label'    => __('Upload Logo', 'mytheme'),
        'section'  => 'mytheme_identity_section',
        'settings' => 'mytheme_logo',
    )));

    // 3. Add setting and control for Primary Color
    $wp_customize->add_setting('mytheme_primary_color', array(
        'default'           => '#0073aa',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mytheme_primary_color_control', array(
        'label'    => __('Primary Color', 'mytheme'),
        'section'  => 'mytheme_identity_section',
        'settings' => 'mytheme_primary_color',
    )));

    // 4. Add setting and control for Font Family
    $wp_customize->add_setting('mytheme_font_family', array(
        'default'           => 'Arial, sans-serif',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('mytheme_font_family_control', array(
        'label'    => __('Font Family', 'mytheme'),
        'section'  => 'mytheme_identity_section',
        'settings' => 'mytheme_font_family',
        'type'     => 'text',
    ));
}
add_action('customize_register', 'mytheme_customize_register');


// 5. Enqueue styles for live preview
function mytheme_customize_css() {
    ?>
    <style type="text/css">
        body {
            font-family: <?php echo esc_js(get_theme_mod('mytheme_font_family', 'Arial, sans-serif')); ?>;
            color: <?php echo esc_js(get_theme_mod('mytheme_primary_color', '#0073aa')); ?>;
        }
        .site-logo img {
            max-width: 200px;
        }
    </style>
    <?php
}
add_action('wp_head', 'mytheme_customize_css');


// 6. Output the logo in header.php (or wherever needed)
function mytheme_display_logo() {
    if (get_theme_mod('mytheme_logo')) {
        echo '<div class="site-logo"><img src="'.esc_url(get_theme_mod('mytheme_logo')).'" alt="'.get_bloginfo('name').'"></div>';
    } else {
        echo '<h1>'.get_bloginfo('name').'</h1>';
    }
}
