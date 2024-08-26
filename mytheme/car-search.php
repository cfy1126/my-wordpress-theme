<?php

/**
 * Template Name: Car Search
 */


$brands = get_terms([
    'taxonomy' => 'brands',
    'hide_empy' => false,
])
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

                    <button type="submit" class="btn btn-success btn-lg w-100 mb-3">Search</button>

                </form>





                <?php
                $args = [
                    'post_type' => 'cars',
                    'post_per_page' => 0,
                    's' => 'keyword',
                    'tax_query' => [],
                    'meta_query' => [
                        'relation' => 'AND'
                    ]
                ];

                if (isset($_GET['keyword'])) {
                    if (!empty($_GET['keyword'])) {
                        $args['s'] = $_GET['keyword'];
                    }
                }

                if($is_search){
                    $query = new WP_Query($args);
                }

                ?>

                <?php if ($query->have_posts()): ?>

                    <?php while ($query->have_posts()): $query->the_post(); ?>

                    <?php if (has_post_thumbnail()): ?>

                        <a href="<?php the_post_thumbnail_url('blog-small'); ?>">

                            <img src="<?php the_post_thumbnail_url('blog-small'); ?>" alt="<?php the_title() ?>" class="img-fluid mb-3 mr-4 img-thumbnail me-4" />
                            
                        </a>
                <?php endif; ?>

                <?php endwhile; ?>

                <?php else: ?>

                    <div class="clearfix mb-3">
                        <div class="alert alert-danger">
                            There are no results
                        </div>
                    </div>

                <?php endif; ?>

            </div>
        </div>
    </div>
</section>


<?php get_footer(); ?>