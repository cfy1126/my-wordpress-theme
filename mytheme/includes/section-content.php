<!-- 如果我们有帖子，当我们在发布帖子的时候，我们所在的特定页面向我们展示了帖子的全部内容 -->
<?php if (have_posts()): while (have_posts()): the_post(); ?>

                <?php the_content(); ?>

<?php endwhile;
else: endif; ?>