<!-- 循环内部操作的原因：wordpress会知道实际post的ID,通过ID可以在数据库中找到作者、缩略图等内容 -->
<?php if (have_posts()): while (have_posts()): the_post(); ?>

        <?php the_content(); ?>


        <!-- tag -->
        <?php
        $tags = get_the_tags();
        if ($tags):
            foreach ($tags as $tag): ?>
                <a href="<?php echo get_tag_link($tag->term_id); ?>" class="badge bg-success">
                    <?php echo $tag->name; ?>
                </a>
        <? endforeach;
        endif; ?>

        <!-- category -->
        <?php
        $categories = get_the_category();
        foreach ($categories as $cat): ?>
            <a href="<?php echo get_category_link($cat->term_id); ?>">
                <?php echo $cat->name; ?>
            </a>
        <?php endforeach; ?>

        <?php echo get_the_date('d/m/y h:i:s') ?>

        <!-- comments -->
        <?php //comments_template(); 
        ?>

<?php endwhile;
else: endif; ?>