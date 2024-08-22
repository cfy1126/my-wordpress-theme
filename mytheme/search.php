<?php get_header(); ?>

<section class="page-wrap">
    <div class="container">

        <h1>Search Result for '<?php echo get_search_query(); ?>'</h1>
        <?php get_template_part('includes/section', 'searchresults'); ?>

        <!-- 方案一 -->
        <?php previous_posts_link(); ?>
        <?php next_posts_link(); ?>

    </div>
</section>
<?php get_footer(); ?>