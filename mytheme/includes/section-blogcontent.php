<!-- 循环内部操作的原因：wordpress会知道实际post的ID,通过ID可以在数据库中找到作者、缩略图等内容 -->
<?php if (have_posts()): while (have_posts()): the_post(); ?>
        <?php echo get_the_date('d/m/y h:i:s') ?>

        <?php the_content(); ?>
        <!-- <?php the_author(); ?> -->

        <?php
        $fname = get_the_author_meta('first_name');
        $lname = get_the_author_meta('last_name');
        ?>
        <p>Posted by: <?php echo $fname . ' ' . $lname; ?></p>

        <!-- tag -->
        <?php
        $tags = get_the_tags();
        foreach ($tags as $tag): ?>
            <a href="<?php echo get_tag_link($tag->term_id); ?>" class="badge bg-success">
                <?php echo $tag->name; ?>
            </a>
        <? endforeach; ?>

        <!-- category -->
        <?php
        $categories = get_the_category();
        foreach($categories as $cat): ?>
        <a href="<?php echo get_category_link($cat->term_id); ?>">
            <?php echo $cat->name; ?>
        </a>
        <?php endforeach; ?>

        <!-- comments -->
        <?php //comments_template(); ?>

<?php endwhile;
else: endif; ?>