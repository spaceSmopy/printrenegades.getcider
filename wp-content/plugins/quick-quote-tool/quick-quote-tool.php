<?php
/*
Plugin Name: Quick quote tool
Plugin URI: #
Description: Quick quote tool. Для создания кнопки показа модального окна используйте либо аттрибут href="#quote_link" либо шорткод [quick_quote_button class="{ваш класс для кастомизации ссылки}"]
Version: 1.3.24
Author: ShariFF
Author URI: https://freelancehunt.com/freelancer/serifsafarov.html
License:
*/


add_shortcode('quick_quote_button', 'show_quick_quote_button');
add_action('wp_body_open', 'body_opened');
add_action('wp_enqueue_scripts', 'load_script');
add_action('admin_enqueue_scripts', 'load_script');
add_action('admin_menu', 'add_plugin_page');
add_action('admin_init', 'plugin_settings_apparel_printing');
add_action('admin_init', 'plugin_settings_tote_bags');
add_action('admin_init', 'plugin_settings_posters_flatstock');
add_action('admin_init', 'plugin_settings_stencil_vinyl_cutting');
add_action('admin_init', 'plugin_settings_buttons');
add_action('admin_init', 'plugin_settings_embroidery');
add_action('init','init_ajax');


//Функции
function dump($var)
{
    echo '<pre>';
    echo var_dump($var);
    echo '</pre>';
}

function init_ajax(){
    if( current_user_can('editor') || current_user_can('administrator') ) {
        $ajaxPrefix = 'wp_ajax_';
    }else{
        $ajaxPrefix = 'wp_ajax_nopriv_';
    }
    add_action("{$ajaxPrefix}quick_quote_tool_get_settings", 'quick_quote_tool_get_settings');
    add_action("{$ajaxPrefix}quick_quote_tool_add_order", 'quick_quote_tool_add_order');
}

function quick_quote_tool_get_settings()
{
    // Подтверждение WP_Ajax_Response
    $response = new WP_Ajax_Response;

    $section = $_REQUEST['section'];

    $section = get_option($section);

    // Обработка
    $response->add(array(
        'data' => 'success',
        'supplemental' => array(
            'data' => json_encode($section),
        ),
    ));
    // В любом случае отправляем ответ
    $response->send();

    // Всегда выходим, когда Ajax выполнен
    exit();
}

function quick_quote_tool_add_order()
{
    // Подтверждение WP_Ajax_Response
    $response = new WP_Ajax_Response;

    $order = $_REQUEST['order'];
    $order = json_decode(stripslashes($order), true);

    $adminEmail = get_option('admin_email');

    $message = '';

    $message .= "ORDER OPTIONS ({$order['currentSection']['title']})" . PHP_EOL;
    foreach ($order['orderData']['fields'] as $field) {
        $message .= $field . PHP_EOL;
    }
    $message .= "Sum: {$order['orderData']['sum']}$" . PHP_EOL . PHP_EOL;
    $message .= "CONTACT DATA" . PHP_EOL;
    foreach ($order['contactData'] as $key => $value) {
        $message .= "$key: $value" . PHP_EOL;
    }
    $message .= PHP_EOL . "ADDITIONAL DATA" . PHP_EOL;
    foreach ($order['tellMoreData'] as $key => $value) {
        $message .= "$key: $value" . PHP_EOL;
    }
    $message .= PHP_EOL . "SHIPPING DATA" . PHP_EOL;
    foreach ($order['shippingData'] as $key => $value) {
        $message .= "$key: $value" . PHP_EOL;
    }

    $headers = [];
    $headers[] = 'Content-type: text/plain; charset=utf-8';
    $headers[] = 'From:' . "testing@gmail.com";
    $files = [];
    foreach ($_FILES as $FILE) {
        $files[] = $FILE['tmp_name'];
    }
    $result = wp_mail( /*$adminEmail*/'serifsafarovgoycayxaker@gmail.com', 'Quote From PrintRenegades', $message, $headers, $files);

    // Обработка
    $response->add(array(
        'data' => 'success',
        'supplemental' => array(
            'data' => json_encode($result),
        ),
    ));
    // В любом случае отправляем ответ
    $response->send();

    // Всегда выходим, когда Ajax выполнен
    exit();
}

function show_quick_quote_button($atts)
{
    return "<a href='#quote_link' class='{$atts['class']}'></a>";
}

function load_script()
{
    wp_register_script('quick-quote-tool-script1', plugins_url('/assets/js/jquery-3.5.1.min.js', __FILE__));
    wp_enqueue_script('quick-quote-tool-script1');
    wp_register_script('quick-quote-tool-script2', plugins_url('/assets/js/common.js', __FILE__));
    $local_arr = array(
        'ajaxurl'   => admin_url( 'admin-ajax.php' ),
        'security'  => wp_create_nonce( 'my-special-string' )
    );
    wp_localize_script( 'quick-quote-tool-script2', 'specialObj', $local_arr );
    wp_enqueue_script('quick-quote-tool-script2');
}

function body_opened()
{
    $assetsPath = plugins_url('/assets/', __FILE__);
    echo '<style type="text/css">';
    echo file_get_contents(plugins_url('/assets/css/style.css', __FILE__));
    echo '</style>';
    $html = file_get_contents(plugins_url('/index.html', __FILE__));
    $html = str_replace('assets/', $assetsPath, $html);
    echo $html;
}

function add_plugin_page()
{
    add_options_page('Quick quote tool settings', 'Quick quote tool settings', 'manage_options', 'primer_slug', 'options_page_output');
}

function options_page_output()
{
    ?>
    <div class="wrap">
        <style type="text/css">
            #adminmenu .wp-has-current-submenu .wp-submenu, #adminmenu .wp-has-current-submenu .wp-submenu.sub-open, #adminmenu .wp-has-current-submenu.opensub .wp-submenu, #adminmenu a.wp-has-current-submenu:focus+.wp-submenu, .no-js li.wp-has-current-submenu:hover .wp-submenu{
                margin-left: 0;
            }
        </style>
        <h2><?php echo get_admin_page_title() ?></h2>

        <style type="text/css">
            <?= file_get_contents(plugins_url('/assets/css/style.css', __FILE__)) ?>
        </style>

        <div class="quickQuoteToolPluginSettingsFormSelector">
            <button data-target="apparel_printing_page">Apparel Printing</button>
            <button data-target="tote_bags_page">Tote Bags</button>
            <button data-target="posters_flatstock_page">Posters/Flatstock</button>
            <button data-target="stencil_vinyl_cutting_page">Stencil/Vinyl Cutting</button>
            <button data-target="buttons_page">Buttons</button>
            <button data-target="embroidery_page" class="active">Embroidery</button>
        </div>

        <?
        //update_option('apparel_printing', []);
        //update_option('tote_bags', []);

        ?>

        <form class="quickQuoteToolPluginSettingsForm" data-page="apparel_printing_page" action="options.php"
              method="POST">
            <?php
            settings_fields('apparel_printing_option_group');     // скрытые защитные поля
            do_settings_sections('apparel_printing_page'); // секции с настройками (опциями). У нас она всего одна 'section_id'
            submit_button();
            ?>
        </form>

        <form class="quickQuoteToolPluginSettingsForm" data-page="tote_bags_page" action="options.php" method="POST">
            <?php
            settings_fields('tote_bags_option_group');     // скрытые защитные поля
            do_settings_sections('tote_bags_page'); // секции с настройками (опциями). У нас она всего одна 'section_id'
            submit_button();
            ?>
        </form>

        <form class="quickQuoteToolPluginSettingsForm" data-page="posters_flatstock_page" action="options.php"
              method="POST">
            <?php
            settings_fields('posters_flatstock_option_group');     // скрытые защитные поля
            do_settings_sections('posters_flatstock_page'); // секции с настройками (опциями). У нас она всего одна 'section_id'
            submit_button();
            ?>
        </form>

        <form class="quickQuoteToolPluginSettingsForm" data-page="stencil_vinyl_cutting_page" action="options.php"
              method="POST">
            <?php
            settings_fields('stencil_vinyl_cutting_option_group');     // скрытые защитные поля
            do_settings_sections('stencil_vinyl_cutting_page'); // секции с настройками (опциями). У нас она всего одна 'section_id'
            submit_button();
            ?>
        </form>

        <form class="quickQuoteToolPluginSettingsForm" data-page="buttons_page" action="options.php" method="POST">
            <?php
            settings_fields('buttons_option_group');     // скрытые защитные поля
            do_settings_sections('buttons_page'); // секции с настройками (опциями). У нас она всего одна 'section_id'
            submit_button();
            ?>
        </form>

        <form class="quickQuoteToolPluginSettingsForm active" data-page="embroidery_page" action="options.php"
              method="POST">
            <?php
            settings_fields('embroidery_option_group');     // скрытые защитные поля
            do_settings_sections('embroidery_page'); // секции с настройками (опциями). У нас она всего одна 'section_id'
            submit_button();
            ?>
        </form>

    </div>
    <?php
}

//APPAREL PRINTING
function plugin_settings_apparel_printing()
{
    register_setting('apparel_printing_option_group', 'apparel_printing', 'sanitize_callback');

    //garment type
    add_settings_section('garment_type', 'Garment Type', '', 'apparel_printing_page');

    add_settings_field('short_sleeve_tee', 'Short Sleeve Tee', 'fill_apparel_printing_garment_type_short_sleeve_tee', 'apparel_printing_page', 'garment_type');
    add_settings_field('long_sleeve_tee', 'Long Sleeve Tee', 'fill_apparel_printing_garment_type_long_sleeve_tee', 'apparel_printing_page', 'garment_type');
    add_settings_field('pullover_hood', 'Pullover Hood', 'fill_apparel_printing_garment_type_pullover_hood', 'apparel_printing_page', 'garment_type');
    add_settings_field('zip_up_hood', 'Zip-up Hood', 'fill_apparel_printing_garment_type_zip_up_hood', 'apparel_printing_page', 'garment_type');
    add_settings_field('do_you_have_own_garment', 'Do you have own garment?', 'fill_apparel_printing_garment_type_do_you_have_own_garment', 'apparel_printing_page', 'garment_type');

    //total quantity
    add_settings_section('total_quantity', 'Total Quantity', '', 'apparel_printing_page');

    add_settings_field('10_24', '10-24', 'fill_apparel_printing_total_quantity_10_24', 'apparel_printing_page', 'total_quantity');
    add_settings_field('25_49', '25-49', 'fill_apparel_printing_total_quantity_25_49', 'apparel_printing_page', 'total_quantity');
    add_settings_field('50_99', '50-99', 'fill_apparel_printing_total_quantity_50_99', 'apparel_printing_page', 'total_quantity');
    add_settings_field('100_249', '100-249', 'fill_apparel_printing_total_quantity_100_249', 'apparel_printing_page', 'total_quantity');
    add_settings_field('250_plus', '250+', 'fill_apparel_printing_total_quantity_250_plus', 'apparel_printing_page', 'total_quantity');

    //total print locations
    add_settings_section('total_print_locations', 'Total Print Locations', '', 'apparel_printing_page');

    add_settings_field('1', '1', 'fill_apparel_printing_total_print_locations_1', 'apparel_printing_page', 'total_print_locations');
    add_settings_field('2', '2', 'fill_apparel_printing_total_print_locations_2', 'apparel_printing_page', 'total_print_locations');
    add_settings_field('3', '3', 'fill_apparel_printing_total_print_locations_3', 'apparel_printing_page', 'total_print_locations');
    add_settings_field('4', '4', 'fill_apparel_printing_total_print_locations_4', 'apparel_printing_page', 'total_print_locations');
    add_settings_field('5', '5', 'fill_apparel_printing_total_print_locations_5', 'apparel_printing_page', 'total_print_locations');

    //number of inc colors
    add_settings_section('number_of_ink_colors', 'Number of Ink Colors', '', 'apparel_printing_page');

    add_settings_field('1', '1', 'fill_apparel_printing_number_of_ink_colors_1', 'apparel_printing_page', 'number_of_ink_colors');
    add_settings_field('2', '2', 'fill_apparel_printing_number_of_ink_colors_2', 'apparel_printing_page', 'number_of_ink_colors');
    add_settings_field('3', '3', 'fill_apparel_printing_number_of_ink_colors_3', 'apparel_printing_page', 'number_of_ink_colors');
    add_settings_field('4', '4', 'fill_apparel_printing_number_of_ink_colors_4', 'apparel_printing_page', 'number_of_ink_colors');
    add_settings_field('5', '5', 'fill_apparel_printing_number_of_ink_colors_5', 'apparel_printing_page', 'number_of_ink_colors');
    add_settings_field('6', '6', 'fill_apparel_printing_number_of_ink_colors_6', 'apparel_printing_page', 'number_of_ink_colors');
    add_settings_field('full_color_dtg', 'Full Color (DTG)', 'fill_apparel_printing_number_of_ink_colors_full_color_dtg', 'apparel_printing_page', 'number_of_ink_colors');
}

//garment type
function fill_apparel_printing_garment_type_short_sleeve_tee($setting)
{
    $settings = get_option('apparel_printing');
    $settings['garment_type']['short_sleeve_tee'] = $settings['garment_type']['short_sleeve_tee'] ? $settings['garment_type']['short_sleeve_tee'] : '+0';
    ?>
    <input type="text" name="apparel_printing[garment_type][short_sleeve_tee]"
           value="<?php echo esc_attr($settings['garment_type']['short_sleeve_tee']) ?>">
    <?php
}

function fill_apparel_printing_garment_type_long_sleeve_tee($setting)
{
    $settings = get_option('apparel_printing');
    $settings['garment_type']['long_sleeve_tee'] = $settings['garment_type']['long_sleeve_tee'] ? $settings['garment_type']['long_sleeve_tee'] : '+0';
    ?>
    <input type="text" name="apparel_printing[garment_type][long_sleeve_tee]"
           value="<?php echo esc_attr($settings['garment_type']['long_sleeve_tee']) ?>">
    <?php
}

function fill_apparel_printing_garment_type_pullover_hood($setting)
{
    $settings = get_option('apparel_printing');
    $settings['garment_type']['pullover_hood'] = $settings['garment_type']['pullover_hood'] ? $settings['garment_type']['pullover_hood'] : '+0';
    ?>
    <input type="text" name="apparel_printing[garment_type][pullover_hood]"
           value="<?php echo esc_attr($settings['garment_type']['pullover_hood']) ?>">
    <?php
}

function fill_apparel_printing_garment_type_zip_up_hood($setting)
{
    $settings = get_option('apparel_printing');
    $settings['garment_type']['zip_up_hood'] = $settings['garment_type']['zip_up_hood'] ? $settings['garment_type']['zip_up_hood'] : '+0';
    ?>
    <input type="text" name="apparel_printing[garment_type][zip_up_hood]"
           value="<?php echo esc_attr($settings['garment_type']['zip_up_hood']) ?>">
    <?php
}

function fill_apparel_printing_garment_type_do_you_have_own_garment($setting)
{
    $settings = get_option('apparel_printing');
    $settings['garment_type']['do_you_have_own_garment'] = $settings['garment_type']['do_you_have_own_garment'] ? $settings['garment_type']['do_you_have_own_garment'] : '+0';
    ?>
    <input type="text" name="apparel_printing[garment_type][do_you_have_own_garment]"
           value="<?php echo esc_attr($settings['garment_type']['do_you_have_own_garment']) ?>">
    <?php
}

//total quantity
function fill_apparel_printing_total_quantity_10_24($setting)
{
    $settings = get_option('apparel_printing');
    $settings['total_quantity']['10_24'] = $settings['total_quantity']['10_24'] ? $settings['total_quantity']['10_24'] : '+0';
    ?>
    <input type="text" name="apparel_printing[total_quantity][10_24]"
           value="<?php echo esc_attr($settings['total_quantity']['10_24']) ?>">
    <?php
}

function fill_apparel_printing_total_quantity_25_49($setting)
{
    $settings = get_option('apparel_printing');
    $settings['total_quantity']['25_49'] = $settings['total_quantity']['25_49'] ? $settings['total_quantity']['25_49'] : '+0';
    ?>
    <input type="text" name="apparel_printing[total_quantity][25_49]"
           value="<?php echo esc_attr($settings['total_quantity']['25_49']) ?>">
    <?php
}

function fill_apparel_printing_total_quantity_50_99($setting)
{
    $settings = get_option('apparel_printing');
    $settings['total_quantity']['50_99'] = $settings['total_quantity']['50_99'] ? $settings['total_quantity']['50_99'] : '+0';
    ?>
    <input type="text" name="apparel_printing[total_quantity][50_99]"
           value="<?php echo esc_attr($settings['total_quantity']['50_99']) ?>">
    <?php
}

function fill_apparel_printing_total_quantity_100_249($setting)
{
    $settings = get_option('apparel_printing');
    $settings['total_quantity']['100_249'] = $settings['total_quantity']['100_249'] ? $settings['total_quantity']['100_249'] : '+0';
    ?>
    <input type="text" name="apparel_printing[total_quantity][100_249]"
           value="<?php echo esc_attr($settings['total_quantity']['100_249']) ?>">
    <?php
}

function fill_apparel_printing_total_quantity_250_plus($setting)
{
    $settings = get_option('apparel_printing');
    $settings['total_quantity']['250_plus'] = $settings['total_quantity']['250_plus'] ? $settings['total_quantity']['250_plus'] : '+0';
    ?>
    <input type="text" name="apparel_printing[total_quantity][250_plus]"
           value="<?php echo esc_attr($settings['total_quantity']['250_plus']) ?>">
    <?php
}

//total print locations
function fill_apparel_printing_total_print_locations_1($setting)
{
    $settings = get_option('apparel_printing');
    $settings['total_print_locations']['1'] = $settings['total_print_locations']['1'] ? $settings['total_print_locations']['1'] : '+0';
    ?>
    <input type="text" name="apparel_printing[total_print_locations][1]"
           value="<?php echo esc_attr($settings['total_print_locations']['1']) ?>">
    <?php
}

function fill_apparel_printing_total_print_locations_2($setting)
{
    $settings = get_option('apparel_printing');
    $settings['total_print_locations']['2'] = $settings['total_print_locations']['2'] ? $settings['total_print_locations']['2'] : '+0';
    ?>
    <input type="text" name="apparel_printing[total_print_locations][2]"
           value="<?php echo esc_attr($settings['total_print_locations']['2']) ?>">
    <?php
}

function fill_apparel_printing_total_print_locations_3($setting)
{
    $settings = get_option('apparel_printing');
    $settings['total_print_locations']['3'] = $settings['total_print_locations']['3'] ? $settings['total_print_locations']['3'] : '+0';
    ?>
    <input type="text" name="apparel_printing[total_print_locations][3]"
           value="<?php echo esc_attr($settings['total_print_locations']['3']) ?>">
    <?php
}

function fill_apparel_printing_total_print_locations_4($setting)
{
    $settings = get_option('apparel_printing');
    $settings['total_print_locations']['4'] = $settings['total_print_locations']['4'] ? $settings['total_print_locations']['4'] : '+0';
    ?>
    <input type="text" name="apparel_printing[total_print_locations][4]"
           value="<?php echo esc_attr($settings['total_print_locations']['4']) ?>">
    <?php
}

function fill_apparel_printing_total_print_locations_5($setting)
{
    $settings = get_option('apparel_printing');
    $settings['total_print_locations']['5'] = $settings['total_print_locations']['5'] ? $settings['total_print_locations']['5'] : '+0';
    ?>
    <input type="text" name="apparel_printing[total_print_locations][5]"
           value="<?php echo esc_attr($settings['total_print_locations']['5']) ?>">
    <?php
}

//number of inc colors
function fill_apparel_printing_number_of_ink_colors_1($setting)
{
    $settings = get_option('apparel_printing');
    $settings['number_of_ink_colors']['1'] = $settings['number_of_ink_colors']['1'] ? $settings['number_of_ink_colors']['1'] : '+0';
    ?>
    <input type="text" name="apparel_printing[number_of_ink_colors][1]"
           value="<?php echo esc_attr($settings['number_of_ink_colors']['1']) ?>">
    <?php
}

function fill_apparel_printing_number_of_ink_colors_2($setting)
{
    $settings = get_option('apparel_printing');
    $settings['number_of_ink_colors']['2'] = $settings['number_of_ink_colors']['2'] ? $settings['number_of_ink_colors']['2'] : '+0';
    ?>
    <input type="text" name="apparel_printing[number_of_ink_colors][2]"
           value="<?php echo esc_attr($settings['number_of_ink_colors']['2']) ?>">
    <?php
}

function fill_apparel_printing_number_of_ink_colors_3($setting)
{
    $settings = get_option('apparel_printing');
    $settings['number_of_ink_colors']['3'] = $settings['number_of_ink_colors']['3'] ? $settings['number_of_ink_colors']['3'] : '+0';
    ?>
    <input type="text" name="apparel_printing[number_of_ink_colors][3]"
           value="<?php echo esc_attr($settings['number_of_ink_colors']['3']) ?>">
    <?php
}

function fill_apparel_printing_number_of_ink_colors_4($setting)
{
    $settings = get_option('apparel_printing');
    $settings['number_of_ink_colors']['4'] = $settings['number_of_ink_colors']['4'] ? $settings['number_of_ink_colors']['4'] : '+0';
    ?>
    <input type="text" name="apparel_printing[number_of_ink_colors][4]"
           value="<?php echo esc_attr($settings['number_of_ink_colors']['4']) ?>">
    <?php
}

function fill_apparel_printing_number_of_ink_colors_5($setting)
{
    $settings = get_option('apparel_printing');
    $settings['number_of_ink_colors']['5'] = $settings['number_of_ink_colors']['5'] ? $settings['number_of_ink_colors']['5'] : '+0';
    ?>
    <input type="text" name="apparel_printing[number_of_ink_colors][5]"
           value="<?php echo esc_attr($settings['number_of_ink_colors']['5']) ?>">
    <?php
}

function fill_apparel_printing_number_of_ink_colors_6($setting)
{
    $settings = get_option('apparel_printing');
    $settings['number_of_ink_colors']['6'] = $settings['number_of_ink_colors']['6'] ? $settings['number_of_ink_colors']['6'] : '+0';
    ?>
    <input type="text" name="apparel_printing[number_of_ink_colors][6]"
           value="<?php echo esc_attr($settings['number_of_ink_colors']['6']) ?>">
    <?php
}

function fill_apparel_printing_number_of_ink_colors_full_color_dtg($setting)
{
    $settings = get_option('apparel_printing');
    $settings['number_of_ink_colors']['full_color_dtg'] = $settings['number_of_ink_colors']['full_color_dtg'] ? $settings['number_of_ink_colors']['full_color_dtg'] : '+0';
    ?>
    <input type="text" name="apparel_printing[number_of_ink_colors][full_color_dtg]"
           value="<?php echo esc_attr($settings['number_of_ink_colors']['full_color_dtg']) ?>">
    <?php
}

//TOTE BAGS
function plugin_settings_tote_bags()
{
    register_setting('tote_bags_option_group', 'tote_bags', 'sanitize_callback');

    //weight
    add_settings_section('weight', 'Weight', '', 'tote_bags_page');

    add_settings_field('6oz', '6oz', 'fill_tote_bags_weight_6oz', 'tote_bags_page', 'weight');
    add_settings_field('12oz', '12oz', 'fill_tote_bags_weight_12oz', 'tote_bags_page', 'weight');

    //total quantity
    add_settings_section('total_quantity', 'Total Quantity', '', 'tote_bags_page');

    add_settings_field('10_24', '10-24', 'fill_tote_bags_total_quantity_10_24', 'tote_bags_page', 'total_quantity');
    add_settings_field('25_49', '25-49', 'fill_tote_bags_total_quantity_25_49', 'tote_bags_page', 'total_quantity');
    add_settings_field('50_99', '50-99', 'fill_tote_bags_total_quantity_50_99', 'tote_bags_page', 'total_quantity');
    add_settings_field('100_249', '100-249', 'fill_tote_bags_total_quantity_100_249', 'tote_bags_page', 'total_quantity');
    add_settings_field('250_plus', '250+', 'fill_tote_bags_total_quantity_250_plus', 'tote_bags_page', 'total_quantity');

    //total print locations
    add_settings_section('total_print_locations', 'Total Print Locations', '', 'tote_bags_page');

    add_settings_field('1', '1', 'fill_tote_bags_total_print_locations_1', 'tote_bags_page', 'total_print_locations');
    add_settings_field('2', '2', 'fill_tote_bags_total_print_locations_2', 'tote_bags_page', 'total_print_locations');

    //number of inc colors
    add_settings_section('number_of_ink_colors', 'Number of Ink Colors', '', 'tote_bags_page');

    add_settings_field('1', '1', 'fill_tote_bags_number_of_ink_colors_1', 'tote_bags_page', 'number_of_ink_colors');
    add_settings_field('2', '2', 'fill_tote_bags_number_of_ink_colors_2', 'tote_bags_page', 'number_of_ink_colors');
    add_settings_field('3', '3', 'fill_tote_bags_number_of_ink_colors_3', 'tote_bags_page', 'number_of_ink_colors');
    add_settings_field('4', '4', 'fill_tote_bags_number_of_ink_colors_4', 'tote_bags_page', 'number_of_ink_colors');
    add_settings_field('full_color_dtg', 'Full Color (DTG)', 'fill_tote_bags_number_of_ink_colors_full_color_dtg', 'tote_bags_page', 'number_of_ink_colors');
}

//weight
function fill_tote_bags_weight_6oz($setting)
{
    $settings = get_option('tote_bags');
    $settings['weight']['6oz'] = $settings['weight']['6oz'] ? $settings['weight']['6oz'] : '+0';
    ?>
    <input type="text" name="tote_bags[weight][6oz]" value="<?php echo esc_attr($settings['weight']['6oz']) ?>">
    <?php
}

function fill_tote_bags_weight_12oz($setting)
{
    $settings = get_option('tote_bags');
    $settings['weight']['12oz'] = $settings['weight']['12oz'] ? $settings['weight']['12oz'] : '+0';
    ?>
    <input type="text" name="tote_bags[weight][12oz]" value="<?php echo esc_attr($settings['weight']['12oz']) ?>">
    <?php
}

//total quantity
function fill_tote_bags_total_quantity_10_24($setting)
{
    $settings = get_option('tote_bags');
    $settings['total_quantity']['10_24'] = $settings['total_quantity']['10_24'] ? $settings['total_quantity']['10_24'] : '+0';
    ?>
    <input type="text" name="tote_bags[total_quantity][10_24]"
           value="<?php echo esc_attr($settings['total_quantity']['10_24']) ?>">
    <?php
}

function fill_tote_bags_total_quantity_25_49($setting)
{
    $settings = get_option('tote_bags');
    $settings['total_quantity']['25_49'] = $settings['total_quantity']['25_49'] ? $settings['total_quantity']['25_49'] : '+0';
    ?>
    <input type="text" name="tote_bags[total_quantity][25_49]"
           value="<?php echo esc_attr($settings['total_quantity']['25_49']) ?>">
    <?php
}

function fill_tote_bags_total_quantity_50_99($setting)
{
    $settings = get_option('tote_bags');
    $settings['total_quantity']['50_99'] = $settings['total_quantity']['50_99'] ? $settings['total_quantity']['50_99'] : '+0';
    ?>
    <input type="text" name="tote_bags[total_quantity][50_99]"
           value="<?php echo esc_attr($settings['total_quantity']['50_99']) ?>">
    <?php
}

function fill_tote_bags_total_quantity_100_249($setting)
{
    $settings = get_option('tote_bags');
    $settings['total_quantity']['100_249'] = $settings['total_quantity']['100_249'] ? $settings['total_quantity']['100_249'] : '+0';
    ?>
    <input type="text" name="tote_bags[total_quantity][100_249]"
           value="<?php echo esc_attr($settings['total_quantity']['100_249']) ?>">
    <?php
}

function fill_tote_bags_total_quantity_250_plus($setting)
{
    $settings = get_option('tote_bags');
    $settings['total_quantity']['250_plus'] = $settings['total_quantity']['250_plus'] ? $settings['total_quantity']['250_plus'] : '+0';
    ?>
    <input type="text" name="tote_bags[total_quantity][250_plus]"
           value="<?php echo esc_attr($settings['total_quantity']['250_plus']) ?>">
    <?php
}

//total print locations
function fill_tote_bags_total_print_locations_1($setting)
{
    $settings = get_option('tote_bags');
    $settings['total_print_locations']['1'] = $settings['total_print_locations']['1'] ? $settings['total_print_locations']['1'] : '+0';
    ?>
    <input type="text" name="tote_bags[total_print_locations][1]"
           value="<?php echo esc_attr($settings['total_print_locations']['1']) ?>">
    <?php
}

function fill_tote_bags_total_print_locations_2($setting)
{
    $settings = get_option('tote_bags');
    $settings['total_print_locations']['2'] = $settings['total_print_locations']['2'] ? $settings['total_print_locations']['2'] : '+0';
    ?>
    <input type="text" name="tote_bags[total_print_locations][2]"
           value="<?php echo esc_attr($settings['total_print_locations']['2']) ?>">
    <?php
}

//number of inc colors
function fill_tote_bags_number_of_ink_colors_1($setting)
{
    $settings = get_option('tote_bags');
    $settings['number_of_ink_colors']['1'] = $settings['number_of_ink_colors']['1'] ? $settings['number_of_ink_colors']['1'] : '+0';
    ?>
    <input type="text" name="tote_bags[number_of_ink_colors][1]"
           value="<?php echo esc_attr($settings['number_of_ink_colors']['1']) ?>">
    <?php
}

function fill_tote_bags_number_of_ink_colors_2($setting)
{
    $settings = get_option('tote_bags');
    $settings['number_of_ink_colors']['2'] = $settings['number_of_ink_colors']['2'] ? $settings['number_of_ink_colors']['2'] : '+0';
    ?>
    <input type="text" name="tote_bags[number_of_ink_colors][2]"
           value="<?php echo esc_attr($settings['number_of_ink_colors']['2']) ?>">
    <?php
}

function fill_tote_bags_number_of_ink_colors_3($setting)
{
    $settings = get_option('tote_bags');
    $settings['number_of_ink_colors']['3'] = $settings['number_of_ink_colors']['3'] ? $settings['number_of_ink_colors']['3'] : '+0';
    ?>
    <input type="text" name="tote_bags[number_of_ink_colors][3]"
           value="<?php echo esc_attr($settings['number_of_ink_colors']['3']) ?>">
    <?php
}

function fill_tote_bags_number_of_ink_colors_4($setting)
{
    $settings = get_option('tote_bags');
    $settings['number_of_ink_colors']['4'] = $settings['number_of_ink_colors']['4'] ? $settings['number_of_ink_colors']['4'] : '+0';
    ?>
    <input type="text" name="tote_bags[number_of_ink_colors][4]"
           value="<?php echo esc_attr($settings['number_of_ink_colors']['4']) ?>">
    <?php
}

function fill_tote_bags_number_of_ink_colors_full_color_dtg($setting)
{
    $settings = get_option('tote_bags');
    $settings['number_of_ink_colors']['full_color_dtg'] = $settings['number_of_ink_colors']['full_color_dtg'] ? $settings['number_of_ink_colors']['full_color_dtg'] : '+0';
    ?>
    <input type="text" name="tote_bags[number_of_ink_colors][full_color_dtg]"
           value="<?php echo esc_attr($settings['number_of_ink_colors']['full_color_dtg']) ?>">
    <?php
}

//POSTERS FLATSTOCK
function plugin_settings_posters_flatstock()
{
    register_setting('posters_flatstock_option_group', 'posters_flatstock', 'sanitize_callback');

    //paper size
    add_settings_section('paper_size', 'Paper Size', '', 'posters_flatstock_page');

    add_settings_field('85x11', '8.5x11', 'fill_posters_flatstock_paper_size_85x11', 'posters_flatstock_page', 'paper_size');
    add_settings_field('9x24', '9x24', 'fill_posters_flatstock_paper_size_9x24', 'posters_flatstock_page', 'paper_size');
    add_settings_field('11x17', '11x17', 'fill_posters_flatstock_paper_size_11x17', 'posters_flatstock_page', 'paper_size');
    add_settings_field('12x12', '12x12', 'fill_posters_flatstock_paper_size_12x12', 'posters_flatstock_page', 'paper_size');
    add_settings_field('12x18', '12x18', 'fill_posters_flatstock_paper_size_12x18', 'posters_flatstock_page', 'paper_size');
    add_settings_field('12x24', '12x24', 'fill_posters_flatstock_paper_size_12x24', 'posters_flatstock_page', 'paper_size');
    add_settings_field('18x24', '18x24', 'fill_posters_flatstock_paper_size_18x24', 'posters_flatstock_page', 'paper_size');
    add_settings_field('24x24', '24x24', 'fill_posters_flatstock_paper_size_24x24', 'posters_flatstock_page', 'paper_size');
    add_settings_field('24x36', '24x36', 'fill_posters_flatstock_paper_size_24x36', 'posters_flatstock_page', 'paper_size');

    //total quantity
    add_settings_section('total_quantity', 'Total Quantity', '', 'posters_flatstock_page');

    add_settings_field('50', '50', 'fill_posters_flatstock_total_quantity_50', 'posters_flatstock_page', 'total_quantity');
    add_settings_field('100', '100', 'fill_posters_flatstock_total_quantity_100', 'posters_flatstock_page', 'total_quantity');
    add_settings_field('150', '150', 'fill_posters_flatstock_total_quantity_150', 'posters_flatstock_page', 'total_quantity');
    add_settings_field('200', '200', 'fill_posters_flatstock_total_quantity_200', 'posters_flatstock_page', 'total_quantity');
    add_settings_field('300', '300', 'fill_posters_flatstock_total_quantity_300', 'posters_flatstock_page', 'total_quantity');
    add_settings_field('500', '500', 'fill_posters_flatstock_total_quantity_500', 'posters_flatstock_page', 'total_quantity');
    add_settings_field('1000', '1000', 'fill_posters_flatstock_total_quantity_1000', 'posters_flatstock_page', 'total_quantity');

    //number of ink
    add_settings_section('number_of_inc', 'Number of Ink', '', 'posters_flatstock_page');

    add_settings_field('1', '1', 'fill_posters_flatstock_number_of_inc_1', 'posters_flatstock_page', 'number_of_inc');
    add_settings_field('2', '2', 'fill_posters_flatstock_number_of_inc_2', 'posters_flatstock_page', 'number_of_inc');
    add_settings_field('3', '3', 'fill_posters_flatstock_number_of_inc_3', 'posters_flatstock_page', 'number_of_inc');
    add_settings_field('4', '4', 'fill_posters_flatstock_number_of_inc_4', 'posters_flatstock_page', 'number_of_inc');
    add_settings_field('5', '5', 'fill_posters_flatstock_number_of_inc_5', 'posters_flatstock_page', 'number_of_inc');
    add_settings_field('6', '6', 'fill_posters_flatstock_number_of_inc_6', 'posters_flatstock_page', 'number_of_inc');
    add_settings_field('7', '7', 'fill_posters_flatstock_number_of_inc_7', 'posters_flatstock_page', 'number_of_inc');
    add_settings_field('8', '8', 'fill_posters_flatstock_number_of_inc_8', 'posters_flatstock_page', 'number_of_inc');
    add_settings_field('9', '9', 'fill_posters_flatstock_number_of_inc_9', 'posters_flatstock_page', 'number_of_inc');
    add_settings_field('10', '10', 'fill_posters_flatstock_number_of_inc_10', 'posters_flatstock_page', 'number_of_inc');
}

//paper size
function fill_posters_flatstock_paper_size_85x11($setting)
{
    $settings = get_option('posters_flatstock');
    $settings['paper_size']['85x11'] = $settings['paper_size']['85x11'] ? $settings['paper_size']['85x11'] : '+0';
    ?>
    <input type="text" name="posters_flatstock[paper_size][85x11]"
           value="<?php echo esc_attr($settings['paper_size']['85x11']) ?>">
    <?php
}

function fill_posters_flatstock_paper_size_9x24($setting)
{
    $settings = get_option('posters_flatstock');
    $settings['paper_size']['9x24'] = $settings['paper_size']['9x24'] ? $settings['paper_size']['9x24'] : '+0';
    ?>
    <input type="text" name="posters_flatstock[paper_size][9x24]"
           value="<?php echo esc_attr($settings['paper_size']['9x24']) ?>">
    <?php
}

function fill_posters_flatstock_paper_size_11x17($setting)
{
    $settings = get_option('posters_flatstock');
    $settings['paper_size']['11x17'] = $settings['paper_size']['11x17'] ? $settings['paper_size']['11x17'] : '+0';
    ?>
    <input type="text" name="posters_flatstock[paper_size][11x17]"
           value="<?php echo esc_attr($settings['paper_size']['11x17']) ?>">
    <?php
}

function fill_posters_flatstock_paper_size_12x12($setting)
{
    $settings = get_option('posters_flatstock');
    $settings['paper_size']['12x12'] = $settings['paper_size']['12x12'] ? $settings['paper_size']['12x12'] : '+0';
    ?>
    <input type="text" name="posters_flatstock[paper_size][12x12]"
           value="<?php echo esc_attr($settings['paper_size']['12x12']) ?>">
    <?php
}

function fill_posters_flatstock_paper_size_12x18($setting)
{
    $settings = get_option('posters_flatstock');
    $settings['paper_size']['12x18'] = $settings['paper_size']['12x18'] ? $settings['paper_size']['12x18'] : '+0';
    ?>
    <input type="text" name="posters_flatstock[paper_size][12x18]"
           value="<?php echo esc_attr($settings['paper_size']['12x18']) ?>">
    <?php
}

function fill_posters_flatstock_paper_size_12x24($setting)
{
    $settings = get_option('posters_flatstock');
    $settings['paper_size']['12x24'] = $settings['paper_size']['12x24'] ? $settings['paper_size']['12x24'] : '+0';
    ?>
    <input type="text" name="posters_flatstock[paper_size][12x24]"
           value="<?php echo esc_attr($settings['paper_size']['12x24']) ?>">
    <?php
}

function fill_posters_flatstock_paper_size_18x24($setting)
{
    $settings = get_option('posters_flatstock');
    $settings['paper_size']['18x24'] = $settings['paper_size']['18x24'] ? $settings['paper_size']['18x24'] : '+0';
    ?>
    <input type="text" name="posters_flatstock[paper_size][18x24]"
           value="<?php echo esc_attr($settings['paper_size']['18x24']) ?>">
    <?php
}

function fill_posters_flatstock_paper_size_24x24($setting)
{
    $settings = get_option('posters_flatstock');
    $settings['paper_size']['24x24'] = $settings['paper_size']['24x24'] ? $settings['paper_size']['24x24'] : '+0';
    ?>
    <input type="text" name="posters_flatstock[paper_size][24x24]"
           value="<?php echo esc_attr($settings['paper_size']['24x24']) ?>">
    <?php
}

function fill_posters_flatstock_paper_size_24x36($setting)
{
    $settings = get_option('posters_flatstock');
    $settings['paper_size']['24x36'] = $settings['paper_size']['24x36'] ? $settings['paper_size']['24x36'] : '+0';
    ?>
    <input type="text" name="posters_flatstock[paper_size][24x36]"
           value="<?php echo esc_attr($settings['paper_size']['24x36']) ?>">
    <?php
}

//total quantity
function fill_posters_flatstock_total_quantity_50($setting)
{
    $settings = get_option('posters_flatstock');
    $settings['total_quantity']['50'] = $settings['total_quantity']['50'] ? $settings['total_quantity']['50'] : '+0';
    ?>
    <input type="text" name="posters_flatstock[total_quantity][50]"
           value="<?php echo esc_attr($settings['total_quantity']['50']) ?>">
    <?php
}

function fill_posters_flatstock_total_quantity_100($setting)
{
    $settings = get_option('posters_flatstock');
    $settings['total_quantity']['100'] = $settings['total_quantity']['100'] ? $settings['total_quantity']['100'] : '+0';
    ?>
    <input type="text" name="posters_flatstock[total_quantity][100]"
           value="<?php echo esc_attr($settings['total_quantity']['100']) ?>">
    <?php
}

function fill_posters_flatstock_total_quantity_150($setting)
{
    $settings = get_option('posters_flatstock');
    $settings['total_quantity']['150'] = $settings['total_quantity']['150'] ? $settings['total_quantity']['150'] : '+0';
    ?>
    <input type="text" name="posters_flatstock[total_quantity][150]"
           value="<?php echo esc_attr($settings['total_quantity']['150']) ?>">
    <?php
}

function fill_posters_flatstock_total_quantity_200($setting)
{
    $settings = get_option('posters_flatstock');
    $settings['total_quantity']['200'] = $settings['total_quantity']['200'] ? $settings['total_quantity']['200'] : '+0';
    ?>
    <input type="text" name="posters_flatstock[total_quantity][200]"
           value="<?php echo esc_attr($settings['total_quantity']['200']) ?>">
    <?php
}

function fill_posters_flatstock_total_quantity_300($setting)
{
    $settings = get_option('posters_flatstock');
    $settings['total_quantity']['300'] = $settings['total_quantity']['300'] ? $settings['total_quantity']['300'] : '+0';
    ?>
    <input type="text" name="posters_flatstock[total_quantity][300]"
           value="<?php echo esc_attr($settings['total_quantity']['300']) ?>">
    <?php
}

function fill_posters_flatstock_total_quantity_500($setting)
{
    $settings = get_option('posters_flatstock');
    $settings['total_quantity']['500'] = $settings['total_quantity']['500'] ? $settings['total_quantity']['500'] : '+0';
    ?>
    <input type="text" name="posters_flatstock[total_quantity][500]"
           value="<?php echo esc_attr($settings['total_quantity']['500']) ?>">
    <?php
}

function fill_posters_flatstock_total_quantity_1000($setting)
{
    $settings = get_option('posters_flatstock');
    $settings['total_quantity']['1000'] = $settings['total_quantity']['1000'] ? $settings['total_quantity']['1000'] : '+0';
    ?>
    <input type="text" name="posters_flatstock[total_quantity][1000]"
           value="<?php echo esc_attr($settings['total_quantity']['1000']) ?>">
    <?php
}

//number of inc
function fill_posters_flatstock_number_of_inc_1($setting)
{
    $settings = get_option('posters_flatstock');
    $settings['number_of_inc']['1'] = $settings['number_of_inc']['1'] ? $settings['number_of_inc']['1'] : '+0';
    ?>
    <input type="text" name="posters_flatstock[number_of_inc][1]"
           value="<?php echo esc_attr($settings['number_of_inc']['1']) ?>">
    <?php
}

function fill_posters_flatstock_number_of_inc_2($setting)
{
    $settings = get_option('posters_flatstock');
    $settings['number_of_inc']['2'] = $settings['number_of_inc']['2'] ? $settings['number_of_inc']['2'] : '+0';
    ?>
    <input type="text" name="posters_flatstock[number_of_inc][2]"
           value="<?php echo esc_attr($settings['number_of_inc']['2']) ?>">
    <?php
}

function fill_posters_flatstock_number_of_inc_3($setting)
{
    $settings = get_option('posters_flatstock');
    $settings['number_of_inc']['3'] = $settings['number_of_inc']['3'] ? $settings['number_of_inc']['3'] : '+0';
    ?>
    <input type="text" name="posters_flatstock[number_of_inc][3]"
           value="<?php echo esc_attr($settings['number_of_inc']['3']) ?>">
    <?php
}

function fill_posters_flatstock_number_of_inc_4($setting)
{
    $settings = get_option('posters_flatstock');
    $settings['number_of_inc']['4'] = $settings['number_of_inc']['4'] ? $settings['number_of_inc']['4'] : '+0';
    ?>
    <input type="text" name="posters_flatstock[number_of_inc][4]"
           value="<?php echo esc_attr($settings['number_of_inc']['4']) ?>">
    <?php
}

function fill_posters_flatstock_number_of_inc_5($setting)
{
    $settings = get_option('posters_flatstock');
    $settings['number_of_inc']['5'] = $settings['number_of_inc']['5'] ? $settings['number_of_inc']['5'] : '+0';
    ?>
    <input type="text" name="posters_flatstock[number_of_inc][5]"
           value="<?php echo esc_attr($settings['number_of_inc']['5']) ?>">
    <?php
}

function fill_posters_flatstock_number_of_inc_6($setting)
{
    $settings = get_option('posters_flatstock');
    $settings['number_of_inc']['6'] = $settings['number_of_inc']['6'] ? $settings['number_of_inc']['6'] : '+0';
    ?>
    <input type="text" name="posters_flatstock[number_of_inc][6]"
           value="<?php echo esc_attr($settings['number_of_inc']['6']) ?>">
    <?php
}

function fill_posters_flatstock_number_of_inc_7($setting)
{
    $settings = get_option('posters_flatstock');
    $settings['number_of_inc']['7'] = $settings['number_of_inc']['7'] ? $settings['number_of_inc']['7'] : '+0';
    ?>
    <input type="text" name="posters_flatstock[number_of_inc][7]"
           value="<?php echo esc_attr($settings['number_of_inc']['7']) ?>">
    <?php
}

function fill_posters_flatstock_number_of_inc_8($setting)
{
    $settings = get_option('posters_flatstock');
    $settings['number_of_inc']['8'] = $settings['number_of_inc']['8'] ? $settings['number_of_inc']['8'] : '+0';
    ?>
    <input type="text" name="posters_flatstock[number_of_inc][8]"
           value="<?php echo esc_attr($settings['number_of_inc']['8']) ?>">
    <?php
}

function fill_posters_flatstock_number_of_inc_9($setting)
{
    $settings = get_option('posters_flatstock');
    $settings['number_of_inc']['9'] = $settings['number_of_inc']['9'] ? $settings['number_of_inc']['9'] : '+0';
    ?>
    <input type="text" name="posters_flatstock[number_of_inc][9]"
           value="<?php echo esc_attr($settings['number_of_inc']['9']) ?>">
    <?php
}

function fill_posters_flatstock_number_of_inc_10($setting)
{
    $settings = get_option('posters_flatstock');
    $settings['number_of_inc']['10'] = $settings['number_of_inc']['10'] ? $settings['number_of_inc']['10'] : '+0';
    ?>
    <input type="text" name="posters_flatstock[number_of_inc][10]"
           value="<?php echo esc_attr($settings['number_of_inc']['10']) ?>">
    <?php
}

//STENCIL VINYL CUTTING
function plugin_settings_stencil_vinyl_cutting()
{
    register_setting('stencil_vinyl_cutting_option_group', 'stencil_vinyl_cutting', 'sanitize_callback');

    //material
    add_settings_section('material', 'Material', '', 'stencil_vinyl_cutting_page');

    add_settings_field('cardboard_stencil_cutting', 'Cardboard Stencil Cutting', 'fill_stencil_vinyl_cutting_material_cardboard_stencil_cutting', 'stencil_vinyl_cutting_page', 'material');
    add_settings_field('vinyl_cutting', 'Vinyl Cutting', 'fill_stencil_vinyl_cutting_material_vinyl_cutting', 'stencil_vinyl_cutting_page', 'material');

    //size
    add_settings_section('size', 'Size', '', 'stencil_vinyl_cutting_page');

    add_settings_field('85x11', '8.5x11', 'fill_stencil_vinyl_cutting_size_85x11', 'stencil_vinyl_cutting_page', 'size');
    add_settings_field('17x22', '17x22', 'fill_stencil_vinyl_cutting_size_17x22', 'stencil_vinyl_cutting_page', 'size');

    //quantity
    add_settings_section('quantity', 'Quantity', '', 'stencil_vinyl_cutting_page');

    add_settings_field('1', '1', 'fill_stencil_vinyl_cutting_quantity_1', 'stencil_vinyl_cutting_page', 'quantity');
    add_settings_field('2', '2', 'fill_stencil_vinyl_cutting_quantity_2', 'stencil_vinyl_cutting_page', 'quantity');
    add_settings_field('5', '5', 'fill_stencil_vinyl_cutting_quantity_5', 'stencil_vinyl_cutting_page', 'quantity');
    add_settings_field('10', '10', 'fill_stencil_vinyl_cutting_quantity_10', 'stencil_vinyl_cutting_page', 'quantity');

    //cutting
    add_settings_section('cutting', 'Cutting', '', 'stencil_vinyl_cutting_page');

    add_settings_field('cutting_only', 'Cutting Only', 'fill_stencil_vinyl_cutting_cutting_cutting_only', 'stencil_vinyl_cutting_page', 'cutting');
    add_settings_field('cutting_wedding_transfering', 'Cutting Wedding Transfering', 'fill_stencil_vinyl_cutting_cutting_cutting_wedding_transfering', 'stencil_vinyl_cutting_page', 'cutting');

    //length
    add_settings_section('length', 'Length', '', 'stencil_vinyl_cutting_page');

    add_settings_field('22x12', '22` x 12`', 'fill_stencil_vinyl_cutting_length_22x12', 'stencil_vinyl_cutting_page', 'length');
    add_settings_field('22x24', '22` x 24`', 'fill_stencil_vinyl_cutting_length_22x24', 'stencil_vinyl_cutting_page', 'length');
    add_settings_field('22x60', '22` x 60`', 'fill_stencil_vinyl_cutting_length_22x60', 'stencil_vinyl_cutting_page', 'length');
    add_settings_field('22x120', '22` x 120`', 'fill_stencil_vinyl_cutting_length_22x120', 'stencil_vinyl_cutting_page', 'length');
}

//material
function fill_stencil_vinyl_cutting_material_cardboard_stencil_cutting($setting)
{
    $settings = get_option('stencil_vinyl_cutting');
    $settings['material']['cardboard_stencil_cutting'] = $settings['material']['cardboard_stencil_cutting'] ? $settings['material']['cardboard_stencil_cutting'] : '+0';
    ?>
    <input type="text" name="stencil_vinyl_cutting[material][cardboard_stencil_cutting]"
           value="<?php echo esc_attr($settings['material']['cardboard_stencil_cutting']) ?>">
    <?php
}

function fill_stencil_vinyl_cutting_material_vinyl_cutting($setting)
{
    $settings = get_option('stencil_vinyl_cutting');
    $settings['material']['vinyl_cutting'] = $settings['material']['vinyl_cutting'] ? $settings['material']['vinyl_cutting'] : '+0';
    ?>
    <input type="text" name="stencil_vinyl_cutting[material][vinyl_cutting]"
           value="<?php echo esc_attr($settings['material']['vinyl_cutting']) ?>">
    <?php
}

//size
function fill_stencil_vinyl_cutting_size_85x11($setting)
{
    $settings = get_option('stencil_vinyl_cutting');
    $settings['size']['85x11'] = $settings['size']['85x11'] ? $settings['size']['85x11'] : '+0';
    ?>
    <input type="text" name="stencil_vinyl_cutting[size][85x11]"
           value="<?php echo esc_attr($settings['size']['85x11']) ?>">
    <?php
}

function fill_stencil_vinyl_cutting_size_17x22($setting)
{
    $settings = get_option('stencil_vinyl_cutting');
    $settings['size']['17x22'] = $settings['size']['17x22'] ? $settings['size']['17x22'] : '+0';
    ?>
    <input type="text" name="stencil_vinyl_cutting[size][17x22]"
           value="<?php echo esc_attr($settings['size']['17x22']) ?>">
    <?php
}

//quantity
function fill_stencil_vinyl_cutting_quantity_1($setting)
{
    $settings = get_option('stencil_vinyl_cutting');
    $settings['quantity']['1'] = $settings['quantity']['1'] ? $settings['quantity']['1'] : '+0';
    ?>
    <input type="text" name="stencil_vinyl_cutting[quantity][1]"
           value="<?php echo esc_attr($settings['quantity']['1']) ?>">
    <?php
}

function fill_stencil_vinyl_cutting_quantity_2($setting)
{
    $settings = get_option('stencil_vinyl_cutting');
    $settings['quantity']['2'] = $settings['quantity']['2'] ? $settings['quantity']['2'] : '+0';
    ?>
    <input type="text" name="stencil_vinyl_cutting[quantity][2]"
           value="<?php echo esc_attr($settings['quantity']['2']) ?>">
    <?php
}

function fill_stencil_vinyl_cutting_quantity_5($setting)
{
    $settings = get_option('stencil_vinyl_cutting');
    $settings['quantity']['5'] = $settings['quantity']['5'] ? $settings['quantity']['5'] : '+0';
    ?>
    <input type="text" name="stencil_vinyl_cutting[quantity][5]"
           value="<?php echo esc_attr($settings['quantity']['5']) ?>">
    <?php
}

function fill_stencil_vinyl_cutting_quantity_10($setting)
{
    $settings = get_option('stencil_vinyl_cutting');
    $settings['quantity']['10'] = $settings['quantity']['10'] ? $settings['quantity']['10'] : '+0';
    ?>
    <input type="text" name="stencil_vinyl_cutting[quantity][10]"
           value="<?php echo esc_attr($settings['quantity']['10']) ?>">
    <?php
}

//cutting
function fill_stencil_vinyl_cutting_cutting_cutting_only($setting)
{
    $settings = get_option('stencil_vinyl_cutting');
    $settings['cutting']['cutting_only'] = $settings['cutting']['cutting_only'] ? $settings['cutting']['cutting_only'] : '+0';
    ?>
    <input type="text" name="stencil_vinyl_cutting[cutting][cutting_only]"
           value="<?php echo esc_attr($settings['cutting']['cutting_only']) ?>">
    <?php
}

function fill_stencil_vinyl_cutting_cutting_cutting_wedding_transfering($setting)
{
    $settings = get_option('stencil_vinyl_cutting');
    $settings['cutting']['cutting_wedding_transfering'] = $settings['cutting']['cutting_wedding_transfering'] ? $settings['cutting']['cutting_wedding_transfering'] : '+0';
    ?>
    <input type="text" name="stencil_vinyl_cutting[cutting][cutting_wedding_transfering]"
           value="<?php echo esc_attr($settings['cutting']['cutting_wedding_transfering']) ?>">
    <?php
}

//length
function fill_stencil_vinyl_cutting_length_22x12($setting)
{
    $settings = get_option('stencil_vinyl_cutting');
    $settings['length']['22x12'] = $settings['length']['22x12'] ? $settings['length']['22x12'] : '+0';
    ?>
    <input type="text" name="stencil_vinyl_cutting[length][22x12]"
           value="<?php echo esc_attr($settings['length']['22x12']) ?>">
    <?php
}

function fill_stencil_vinyl_cutting_length_22x24($setting)
{
    $settings = get_option('stencil_vinyl_cutting');
    $settings['length']['22x24'] = $settings['length']['22x24'] ? $settings['length']['22x24'] : '+0';
    ?>
    <input type="text" name="stencil_vinyl_cutting[length][22x24]"
           value="<?php echo esc_attr($settings['length']['22x24']) ?>">
    <?php
}

function fill_stencil_vinyl_cutting_length_22x60($setting)
{
    $settings = get_option('stencil_vinyl_cutting');
    $settings['length']['22x60'] = $settings['length']['22x60'] ? $settings['length']['22x60'] : '+0';
    ?>
    <input type="text" name="stencil_vinyl_cutting[length][22x60]"
           value="<?php echo esc_attr($settings['length']['22x60']) ?>">
    <?php
}

function fill_stencil_vinyl_cutting_length_22x120($setting)
{
    $settings = get_option('stencil_vinyl_cutting');
    $settings['length']['22x120'] = $settings['length']['22x120'] ? $settings['length']['22x120'] : '+0';
    ?>
    <input type="text" name="stencil_vinyl_cutting[length][22x120]"
           value="<?php echo esc_attr($settings['length']['22x120']) ?>">
    <?php
}

//BUTTONS
function plugin_settings_buttons()
{
    register_setting('buttons_option_group', 'buttons', 'sanitize_callback');

    //size
    add_settings_section('size', 'Size', '', 'buttons_page');

    add_settings_field('1', '1`', 'fill_buttons_size_1', 'buttons_page', 'size');
    add_settings_field('1_25', '1.25`', 'fill_buttons_size_1_25', 'buttons_page', 'size');
    add_settings_field('2_25', '2.25`', 'fill_buttons_size_2_25', 'buttons_page', 'size');

    //total quantity
    add_settings_section('total_quantity', 'Total Quantity', '', 'buttons_page');

    add_settings_field('10_24', '10-24', 'fill_buttons_total_quantity_10_24', 'buttons_page', 'total_quantity');
    add_settings_field('25_49', '25-49', 'fill_buttons_total_quantity_25_49', 'buttons_page', 'total_quantity');
    add_settings_field('50_99', '50-99', 'fill_buttons_total_quantity_50_99', 'buttons_page', 'total_quantity');
    add_settings_field('100_249', '100-249', 'fill_buttons_total_quantity_100_249', 'buttons_page', 'total_quantity');
    add_settings_field('250_plus', '250+', 'fill_buttons_total_quantity_250_plus', 'buttons_page', 'total_quantity');
}

//size
function fill_buttons_size_1($setting)
{
    $settings = get_option('buttons');
    $settings['size']['1'] = $settings['size']['1'] ? $settings['size']['1'] : '+0';
    ?>
    <input type="text" name="buttons[size][1]" value="<?php echo esc_attr($settings['size']['1']) ?>">
    <?php
}

function fill_buttons_size_1_25($setting)
{
    $settings = get_option('buttons');
    $settings['size']['1_25'] = $settings['size']['1_25'] ? $settings['size']['1_25'] : '+0';
    ?>
    <input type="text" name="buttons[size][1_25]" value="<?php echo esc_attr($settings['size']['1_25']) ?>">
    <?php
}

function fill_buttons_size_2_25($setting)
{
    $settings = get_option('buttons');
    $settings['size']['2_25'] = $settings['size']['2_25'] ? $settings['size']['2_25'] : '+0';
    ?>
    <input type="text" name="buttons[size][2_25]" value="<?php echo esc_attr($settings['size']['2_25']) ?>">
    <?php
}

//total quantity
function fill_buttons_total_quantity_10_24($setting)
{
    $settings = get_option('buttons');
    $settings['total_quantity']['10_24'] = $settings['total_quantity']['10_24'] ? $settings['total_quantity']['10_24'] : '+0';
    ?>
    <input type="text" name="buttons[total_quantity][10_24]"
           value="<?php echo esc_attr($settings['total_quantity']['10_24']) ?>">
    <?php
}

function fill_buttons_total_quantity_25_49($setting)
{
    $settings = get_option('buttons');
    $settings['total_quantity']['25_49'] = $settings['total_quantity']['25_49'] ? $settings['total_quantity']['25_49'] : '+0';
    ?>
    <input type="text" name="buttons[total_quantity][25_49]"
           value="<?php echo esc_attr($settings['total_quantity']['25_49']) ?>">
    <?php
}

function fill_buttons_total_quantity_50_99($setting)
{
    $settings = get_option('buttons');
    $settings['total_quantity']['50_99'] = $settings['total_quantity']['50_99'] ? $settings['total_quantity']['50_99'] : '+0';
    ?>
    <input type="text" name="buttons[total_quantity][50_99]"
           value="<?php echo esc_attr($settings['total_quantity']['50_99']) ?>">
    <?php
}

function fill_buttons_total_quantity_100_249($setting)
{
    $settings = get_option('buttons');
    $settings['total_quantity']['100_249'] = $settings['total_quantity']['100_249'] ? $settings['total_quantity']['100_249'] : '+0';
    ?>
    <input type="text" name="buttons[total_quantity][100_249]"
           value="<?php echo esc_attr($settings['total_quantity']['100_249']) ?>">
    <?php
}

function fill_buttons_total_quantity_250_plus($setting)
{
    $settings = get_option('buttons');
    $settings['total_quantity']['250_plus'] = $settings['total_quantity']['250_plus'] ? $settings['total_quantity']['250_plus'] : '+0';
    ?>
    <input type="text" name="buttons[total_quantity][250_plus]"
           value="<?php echo esc_attr($settings['total_quantity']['250_plus']) ?>">
    <?php
}

//EMBROIDERY
function plugin_settings_embroidery()
{
    register_setting('embroidery_option_group', 'embroidery', 'sanitize_callback');

    //placement
    add_settings_section('placement', 'Placement', '', 'embroidery_page');

    add_settings_field('pocket_breast', 'Pocket/Breast', 'fill_embroidery_placement_pocket_breast', 'embroidery_page', 'placement');
    add_settings_field('sleeve', 'Sleeve', 'fill_embroidery_placement_sleeve', 'embroidery_page', 'placement');
    add_settings_field('unstructured_cap', 'Unstructured Cap', 'fill_embroidery_placement_unstructured_cap', 'embroidery_page', 'placement');
    add_settings_field('structured_cap', 'Structured Cap', 'fill_embroidery_placement_structured_cap', 'embroidery_page', 'placement');
    add_settings_field('full_size', 'Full Size', 'fill_embroidery_placement_full_size', 'embroidery_page', 'placement');

    //total quantity
    add_settings_section('total_quantity', 'Total Quantity', '', 'embroidery_page');

    add_settings_field('10_24', '10-24', 'fill_embroidery_total_quantity_10_24', 'embroidery_page', 'total_quantity');
    add_settings_field('25_49', '25-49', 'fill_embroidery_total_quantity_25_49', 'embroidery_page', 'total_quantity');
    add_settings_field('50_99', '50-99', 'fill_embroidery_total_quantity_50_99', 'embroidery_page', 'total_quantity');
    add_settings_field('100_249', '100-249', 'fill_embroidery_total_quantity_100_249', 'embroidery_page', 'total_quantity');
    add_settings_field('250_plus', '250+', 'fill_embroidery_total_quantity_250_plus', 'embroidery_page', 'total_quantity');
}

//placement
function fill_embroidery_placement_pocket_breast($setting)
{
    $settings = get_option('embroidery');
    $settings['placement']['pocket_breast'] = $settings['placement']['pocket_breast'] ? $settings['placement']['pocket_breast'] : '+0';
    ?>
    <input type="text" name="embroidery[placement][pocket_breast]"
           value="<?php echo esc_attr($settings['placement']['pocket_breast']) ?>">
    <?php
}

function fill_embroidery_placement_sleeve($setting)
{
    $settings = get_option('embroidery');
    $settings['placement']['sleeve'] = $settings['placement']['sleeve'] ? $settings['placement']['sleeve'] : '+0';
    ?>
    <input type="text" name="embroidery[placement][sleeve]"
           value="<?php echo esc_attr($settings['placement']['sleeve']) ?>">
    <?php
}

function fill_embroidery_placement_unstructured_cap($setting)
{
    $settings = get_option('embroidery');
    $settings['placement']['unstructured_cap'] = $settings['placement']['unstructured_cap'] ? $settings['placement']['unstructured_cap'] : '+0';
    ?>
    <input type="text" name="embroidery[placement][unstructured_cap]"
           value="<?php echo esc_attr($settings['placement']['unstructured_cap']) ?>">
    <?php
}

function fill_embroidery_placement_structured_cap($setting)
{
    $settings = get_option('embroidery');
    $settings['placement']['structured_cap'] = $settings['placement']['structured_cap'] ? $settings['placement']['structured_cap'] : '+0';
    ?>
    <input type="text" name="embroidery[placement][structured_cap]"
           value="<?php echo esc_attr($settings['placement']['structured_cap']) ?>">
    <?php
}

function fill_embroidery_placement_full_size($setting)
{
    $settings = get_option('embroidery');
    $settings['placement']['full_size'] = $settings['placement']['full_size'] ? $settings['placement']['full_size'] : '+0';
    ?>
    <input type="text" name="embroidery[placement][full_size]"
           value="<?php echo esc_attr($settings['placement']['full_size']) ?>">
    <?php
}

//total quantity
function fill_embroidery_total_quantity_10_24($setting)
{
    $settings = get_option('embroidery');
    $settings['total_quantity']['10_24'] = $settings['total_quantity']['10_24'] ? $settings['total_quantity']['10_24'] : '+0';
    ?>
    <input type="text" name="embroidery[total_quantity][10_24]"
           value="<?php echo esc_attr($settings['total_quantity']['10_24']) ?>">
    <?php
}

function fill_embroidery_total_quantity_25_49($setting)
{
    $settings = get_option('embroidery');
    $settings['total_quantity']['25_49'] = $settings['total_quantity']['25_49'] ? $settings['total_quantity']['25_49'] : '+0';
    ?>
    <input type="text" name="embroidery[total_quantity][25_49]"
           value="<?php echo esc_attr($settings['total_quantity']['25_49']) ?>">
    <?php
}

function fill_embroidery_total_quantity_50_99($setting)
{
    $settings = get_option('embroidery');
    $settings['total_quantity']['50_99'] = $settings['total_quantity']['50_99'] ? $settings['total_quantity']['50_99'] : '+0';
    ?>
    <input type="text" name="embroidery[total_quantity][50_99]"
           value="<?php echo esc_attr($settings['total_quantity']['50_99']) ?>">
    <?php
}

function fill_embroidery_total_quantity_100_249($setting)
{
    $settings = get_option('embroidery');
    $settings['total_quantity']['100_249'] = $settings['total_quantity']['100_249'] ? $settings['total_quantity']['100_249'] : '+0';
    ?>
    <input type="text" name="embroidery[total_quantity][100_249]"
           value="<?php echo esc_attr($settings['total_quantity']['100_249']) ?>">
    <?php
}

function fill_embroidery_total_quantity_250_plus($setting)
{
    $settings = get_option('embroidery');
    $settings['total_quantity']['250_plus'] = $settings['total_quantity']['250_plus'] ? $settings['total_quantity']['250_plus'] : '+0';
    ?>
    <input type="text" name="embroidery[total_quantity][250_plus]"
           value="<?php echo esc_attr($settings['total_quantity']['250_plus']) ?>">
    <?php
}

## Очистка данных
function sanitize_callback($options)
{
    $checkboxes = [/*'do_you_have_own_garment'*/];
    // очищаем
    if (is_null($options)) {
        $options = [];
        return $options;
    }
    foreach ($options as $section => $option) {
        foreach ($option as $key => $item) {
            if (in_array($key, $checkboxes)) {
                $item = intval($item);
            } else {
                $type = substr($item, 0, 1);
                if ($type !== '+' && $type !== '*') {
                    $type = '+';
                    $item = $type . $item;
                }
                $item = floatval(str_replace(['*', '+'], '', $item));
                $item = $type . $item;
            }
            $option[$key] = $item;
        }
        $options[$section] = $option;
    }

    //die(print_r( $options )); // Array ( [input] => aaaa [checkbox] => 1 )

    return $options;
}
