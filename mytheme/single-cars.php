<?php get_header(); ?>

<section class="page-wrap">
    <div class="container">
        <h1><?php the_title(); ?></h1>
        <?php if (has_post_thumbnail()): ?>
            <img src="<?php the_post_thumbnail_url('blog-large'); ?>" alt="<?php the_title() ?>" class="img-fluid mb-3 img-thumbnail" />
        <?php endif; ?>
        <div class="row">

            <div class="col-lg-6">

                <?php get_template_part('includes/section', 'cars'); ?>

                <!-- 详情内容分页 -->
                <?php wp_link_pages(); ?>
            </div>

            <div class="col-lg-6">
                <!-- 
                    ID: 1
                    Title: Enquire about this car
                    Description: nll
                    active: 不激活是否显示 false
                    params: 是否显示表单参数 false
                    ajax: 是否使用ajax提交 true
                    tabindex: 100        
                -->
                <!-- <div class="enquiry_form">
                    <?php gravity_form(1, "Enquire about this car", null, false, ['rego' => get_field('registration')], true, 100, true); ?>
                </div> -->

                <?php get_template_part('includes/form', 'enquiry'); ?>

                <ul>
                    <!-- <li>Color: <?php echo get_post_meta($post->ID, 'Color', true); ?></li> -->
                    <!-- <li>Price: <?php echo get_post_meta($post->ID, 'Price', true); ?></li> -->

                    <li>Color: <?php the_field('color'); ?></li>
                    <li>Registration: <?php the_field('registration'); ?></li>
                </ul>

                <h3>Features</h3>
                <ul class="features">
                    <?php if (have_rows('features')): ?>
                        <?php
                        while (have_rows('features')): the_row();
                            $feature = get_sub_field('feature');
                        ?>
                            <li><?php echo $feature; ?></li>
                        <?php endwhile; ?>
                    <?php endif; ?>
                    <li></li>
                </ul>

                <?php
                $gallery = get_field('gallery');
                if ($gallery): ?>
                    <div class="gallery">
                        <?php foreach ($gallery as $image): ?>
                            <a href="<?php echo $image['sizes']['blog-large']; ?>">
                                <img src="<?php echo $image['sizes']['blog-small']; ?>" class="img-fluid" />
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>


    </div>
</section>
<?php get_footer(); ?>