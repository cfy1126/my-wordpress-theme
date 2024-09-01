<?php

use PHPMailer\PHPMailer\SMTP;


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function load_css()
{
    wp_register_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '5.3.3', 'all');
    wp_enqueue_style('bootstrap');

    wp_register_style('magnific', get_template_directory_uri() . '/css/magnific-popup.css', array(), false, 'all');
    wp_enqueue_style('magnific');

    wp_register_style('main', get_template_directory_uri() . '/css/main.css', array(), false, 'all');
    wp_enqueue_style('main');
}

add_action('wp_enqueue_scripts', 'load_css');


function load_js()
{
    wp_enqueue_script('jquery');
    wp_register_script('bootstrapjs', get_template_directory_uri() . '/js/bootstrap.bundle.min.js', 'jquery', '5.3.3', true);
    wp_enqueue_script('bootstrapjs');

    wp_register_script('magnific', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', 'jquery', false, true);
    wp_enqueue_script('magnific');

    wp_register_script('custom', get_template_directory_uri() . '/js/custom.js', 'jquery', false, true);
    wp_enqueue_script('custom');
}

add_action('wp_enqueue_scripts', 'load_js');

// Theme Options
add_theme_support('menus');
add_theme_support('post-thumbnails');
add_theme_support('widgets');

// Menus
register_nav_menus(
    array(
        'top-menu' => 'Top Menu Location',
        'mobile-menu' => 'Mobile Menu Location',
        'footer-menu' => 'Footer Menu Location',
    )
);

// Custom Image Sizes
add_image_size('blog-large', 800, 400, false); // 缩放不裁剪 保持横纵比 自适应
add_image_size('blog-small', 300, 200, true); // 缩放裁剪 保持300*200


//  Register Sidebars
function my_sidebars()
{
    register_sidebar(
        array(
            'name' => 'Page Sidebar',
            'id' => 'page-sidebar',
            'before_title' => '<h4 class="widget-title">',
            'after_tile' => '</hr>'
        )
    );
    register_sidebar(
        array(
            'name' => 'Blog Sidebar',
            'id' => 'blog-sidebar',
            'before_title' => '<h4 class="widget-title">',
            'after_tile' => '</hr>'
        )
    );
}
add_action('widgets_init', 'my_sidebars');


function my_first_post_type()
{
    $args = array(
        'labels' => array(
            'name' => 'Cars',
            'singular_name' => 'Car'
        ),
        // 区别post还是page
        'hierarchical' => true,
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-images-alt2',
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'rewrite' => array('slug' => 'my-cars'),
    );
    register_post_type('cars', $args);
}
add_action('init', 'my_first_post_type');


function my_first_taxonomy()
{
    $args = array(
        'labels' => array(
            'name' => 'Brands',
            'singular_name' => 'Brand'
        ),
        'public' => true,
        // false 默认为tag true 默认为category
        'hierarchical' => true,
    );
    register_taxonomy('brands', array('cars'), $args);
}
add_action('init', 'my_first_taxonomy');


add_action('wp_ajax_enquiry', 'enquiry_form');
add_action('wp_ajax_nopriv_enquiry', 'enquiry_form');
function enquiry_form()
{
    if (!wp_verify_nonce($_POST['nonce'], 'ajax-nonce')) {
        wp_send_json_error('Nonce is incorrect', 401);
        die();
    }

    $formdata = [];

    wp_parse_str($_POST['enquiry'], $formdata);
    // $data = json_encode($_POST);

    // Admin email
    $admin_email = get_option('admin_email');

    // Email headers
    $headers[] = 'Content-Type: text/html; charset=UTF-i';
    $headers[] = 'From: My Website <' . $admin_email . '>';
    $headers[] = 'Reply-to: ' . $formdata['email'];

    /**
     * 调试信息
     * error_log('调试信息: ' . print_r($formdata, true)); 日志文件中
     * wp_die(var_dump($formdata)); 页面中 ajax请求中
     * 断点调试
     */

    // Send to
    $send_to = $admin_email;

    // Subject
    $subject = "Enquiry from " . $formdata['fname'] . ' ' . $formdata['lname'];

    // Message
    $message = '';

    foreach ($formdata as $index => $field) {
        $message .= '<strong>' . $index . '</strong>:' . $field . '<br>';
    }

    try {
        if (wp_mail($send_to, $subject, $message, $headers)) {
            wp_send_json_success("Email send");
        } else {
            wp_send_json_error("Email not send");
        }
    } catch (Exception $e) {
        wp_send_json_error($e->getMessage());
    }
}


/**
 * Register Custom Navigation Walker
 */
function register_navwalker()
{
    require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';
}
add_action('after_setup_theme', 'register_navwalker');

add_filter( 'nav_menu_link_attributes', 'bootstrap5_dropdown_fix' );
function bootstrap5_dropdown_fix( $atts ) {
    if ( array_key_exists( 'data-toggle', $atts ) ) {
        unset( $atts['data-toggle'] );
        $atts['data-bs-toggle'] = 'dropdown';
    }
    return $atts;
}


// add_action('phpmailer_init', 'custom_mailer');
// // $phpmailer 是一个PHPMailer对象 是由wordpress创建的 PHP 邮件程序实例
// function custom_mailer(PHPMailer $phpmailer)
// {
//     $phpmailer->SetFrom('sean@mrdigital.com.au', 'Sean');
//     $phpmailer->Host = 'email-smtp.us-west-2.amazonaws.com';
//     $phpmailer->Port = 587;
//     $phpmailer->SMTPAuth = true;
//     $phpmailer->SMTPSecure = 'tls';
//     /**
//      * SMTP_LOGIN
//      * SMTP_PASSWORD
//      * 是定义在wp-config.php中的常量
//      */
//     $phpmailer->Username = SMTP_LOGIN;
//     $phpmailer->Password = SMTP_PASSWORD;
//     $phpmailer->IsSMTP();
// }


function my_shortcode($attrs, $content = null, $tag = '')
{
    ob_start();

    set_query_var("attributes", $attrs);

    
    get_template_part('includes/latest', 'cars');
    return ob_get_clean();
}
add_shortcode('latest_cars', 'my_shortcode');


function my_phone()
{
    return '18273358731';
}
add_shortcode('phone', 'my_phone');


function search_query()
{

    $paged = (get_query_var('paged'))  ? get_query_var('paged') : 1;


    $args = [

        'paged' => $paged,
        'post_type' => 'cars',
        'posts_per_page' => 1,
        'tax_query' => [],
        'meta_query' => [
            'relation' => 'AND',
        ],

    ];

    if (isset($_GET['keyword'])) {

        if (!empty($_GET['keyword'])) {
            $args['s'] = sanitize_text_field($_GET['keyword']);
        }
    }



    if (isset($_GET['brand'])) {
        if (!empty($_GET['brand'])) {
            $args['tax_query'][] = [

                'taxonomy' => 'brands',
                'field' => 'slug',
                'terms' => array(sanitize_text_field($_GET['brand']))

            ];
        }
    }


    if (isset($_GET['price_above'])) {
        if (!empty($_GET['price_above'])) {
            $args['meta_query'][] = array(

                'key' => 'price',
                'value' => sanitize_text_field($_GET['price_above']),
                'type' => 'numeric',
                'compare' => '>='
            );
        }
    }




    if (isset($_GET['price_below'])) {
        if (!empty($_GET['price_below'])) {


            $args['meta_query'][] = array(

                'key' => 'price',
                'value' => sanitize_text_field($_GET['price_below']),
                'type' => 'numeric',
                'compare' => '<='
            );
        }
    }


    return  new WP_Query($args);
}
