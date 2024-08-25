<?php 

    // meta_key and meta_value 帖子过滤
    $args = [
        'post_type' => 'cars',
        // 'meta_key' => 'color',
        // 'meta_value' => 'blue'
        'posts_per_page' => 0

    ];

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