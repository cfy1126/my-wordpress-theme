<?php

function load_css()
{
    wp_register_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '5.3.3', 'all');
    wp_enqueue_style('bootstrap');

    wp_register_style('main', get_template_directory_uri() . '/css/main.css', array(), false, 'all');
    wp_enqueue_style('main');
}

add_action('wp_enqueue_scripts', 'load_css');


function load_js()
{
    wp_enqueue_script('jquery');
    wp_register_script('bootstrapjs', get_template_directory_uri() . '/js/bootstrap.min.js', 'jquery', '5.3.3', true);
    wp_enqueue_script('bootstrapjs');
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
        'supports' => array('title', 'editor', 'thumbnail'),
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
