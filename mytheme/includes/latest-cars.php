<?php 

    $attributes = get_query_var("attributes");

    /**
     *  **echo**：用于输出简单的字符串或变量值，适合用于普通的输出操作。
        **print_r**：用于打印易于理解的变量信息，特别是数组和对象，适合用于调试。
        **var_dump**：用于打印详细的变量信息，包括类型和值，适合用于深入调试。
     */

    // meta_key and meta_value 帖子过滤
    $args = [
        'post_type' => 'cars',
        'posts_per_page' => 0,
        'tax_query' => [],
        'meta_query' => []
    ];

    if(isset($attributes['price_below']))
    {
        $args['meta_query'][] = array(
            'key' => 'price',
            'value' => $attributes['price_below'],
            'type' => 'numeric',
            'compare' => '<='
        );
    }

    if(isset($attributes['price_above']))
    {
        $args['meta_query'][] = array(
            'key' => 'price',
            'value' => $attributes['price_above'],
            'type' => 'numeric',
            'compare' => '>='
        );
    }

    if( isset($attributes["color"]))
    {
        $args['meta_query'][] = array(
            'key' => 'color',
            'value' => $attributes['color'],
            'compare' => '='
        );
    }

    if( isset($attributes["brand"]))
    {
        $args['tax_query'][] = [
            [
                'taxonomy' => 'brands',
                'field' => 'slug',
                'terms' => array($attributes["brand"])
            ]
        ];
    }

    $query = new WP_Query($args);
?>

<?php if($query -> have_posts()): ?>
    <?php while($query -> have_posts()): $query -> the_post(); ?>
    
    <div class="card mb-3">
        <div class="card-body">

        <?php if (has_post_thumbnail()): ?>
            <img src="<?php the_post_thumbnail_url('blog-large'); ?>" alt="<?php the_title() ?>" class="img-fluid mb-3 img-thumbnail" />
        <?php endif; ?>

            <h3><?php the_title(); ?></h3>
            <?php the_field('registration'); ?>
        </div>
    </div>


    <?php endwhile; ?>
<?endif; ?>