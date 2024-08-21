<!-- 如果我们有帖子，当我们在发布帖子的时候，我们所在的特定页面向我们展示了帖子的全部内容 -->
<?php if (have_posts()): while (have_posts()): the_post(); ?>

<div class="card mb-3">
    <div class="card-body d-flex justify-content-center align-items-center">
                <?php if (has_post_thumbnail()): ?>
                    <img src="<?php the_post_thumbnail_url('blog-small'); ?>" alt="<?php the_title() ?>" class="img-fluid mb-3 mr-4 img-thumbnail me-4" />
                <?php endif; ?>

                <div class="blog-content">
                    <h3><?php the_title(); ?></h3>
                    <?php the_excerpt(); ?>
                    <a href="<?php the_permalink(); ?>" class="btn btn-success">Read more</a>
                </div>

            </div>
        </div>

<?php endwhile;
else: endif; ?>