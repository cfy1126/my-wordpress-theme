<?php

/**
 * Template Name: Car Search
 */

$is_search = count($_GET);

$brands = get_terms([
    'taxonomy' => 'brands',
    'hide_empty' => false,
]);

if ($is_search) {
    $query = search_query();
}

?>

<?php get_header(); ?>

<section class="page-wrap">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="<?php echo home_url('/car-search'); ?>">

                    <div class="form-group mb-3">
                        <label>Type a keyword</label>
                        <input
                            type="text"
                            name="keyword"
                            placeholder="Type a keyword"
                            class="form-control"
                            value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>">
                    </div>

                    <div class="form-group mb-3">
                        <label>Choose a brand</label>
                        <select name="brand" class="form-control">
                            <option value="">Select a brand</option>

                            <?php foreach ($brands as $brand): ?>

                                <option

                                    <?php if (isset($_GET['brand']) && ($_GET['brand'] == $brand->slug)): ?>
                                    selected
                                    <?php endif; ?>
                                    value="<?php echo $brand->slug; ?>">
                                    <?php echo $brand->name; ?>

                                </option>

                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group row mb-3">
                        <div class="col-lg-6">
                            <label>From price</label>

                            <select name="price_above" class="form-control">
                                <?php for ($i = 0; $i < 210000; $i += 10000): ?>
                                    <option

                                        <?php if (isset($_GET['price_above']) && ($_GET['price_above'] == $i)): ?>
                                        selected
                                        <?php endif; ?>

                                        value="<?php echo $i; ?>"><?php echo '$' . number_format($i, 2); ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="col-lg-6">
                            <label>To price</label>

                            <select name="price_below" class="form-control">
                                <?php for ($i = 0; $i < 210000; $i += 10000): ?>
                                    <option

                                        <?php if (isset($_GET['price_below']) && ($_GET['price_below'] == $i)): ?>
                                        selected
                                        <?php endif; ?>

                                        value="<?php echo $i; ?>"><?php echo '$' . number_format($i, 2); ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success btn-lg w-100 mb-3">Search</button>

                    <a href="<?php echo home_url('/car-search'); ?>">Clear search</a>

                </form>

                <?php if ($is_search): ?>

                    <?php if ($query->have_posts()): ?>

                        <?php while ($query->have_posts()): $query->the_post(); ?>


                            <a href="<?php the_post_thumbnail_url('blog-small'); ?>">

                                <img src="<?php the_post_thumbnail_url('blog-small'); ?>" alt="<?php the_title() ?>" class="img-fluid mb-3 mr-4 img-thumbnail me-4" />

                            </a>

                            <h3><?php the_title() ?></h3>

                        <?php endwhile; ?>

                        <div class="pagination">
                            <?php
                            echo paginate_links(array(
                                'base'         => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                                'total'        => $query->max_num_pages,
                                'current'      => max(1, get_query_var('paged')),
                                'format'       => '?paged=%#%',
                                'show_all'     => false,
                                'type'         => 'plain',
                                'end_size'     => 2,
                                'mid_size'     => 1,
                                'prev_next'    => true,
                                'prev_text'    => sprintf('<i></i> %1$s', __('Prev', 'text-domain')),
                                'next_text'    => sprintf('%1$s <i></i>', __('Next', 'text-domain')),
                                'add_args'     => false,
                                'add_fragment' => '',
                            ));
                            ?>
                        </div>

                        <!-- 
                        wp_reset_postdata 函数使用
                        * 需要使用：如果你使用 WP_Query 类进行自定义查询，并在循环中使用了 the_post() 函数，那么在循环结束后应该调用 wp_reset_postdata()。
                        * 不需要使用：如果你没有使用自定义查询，或者使用了 get_posts() 并且没有在循环中使用 the_post() 函数，那么不需要调用 wp_reset_postdata()。
                        -->

                        <?php wp_reset_postdata(); ?>

                    <?php else: ?>

                        <div class="clearfix mb-3">
                            <div class="alert alert-danger">
                                There are no results
                            </div>
                        </div>

                    <?php endif; ?>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>


<?php get_footer(); ?>