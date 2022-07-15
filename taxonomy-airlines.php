<?php get_header(); ?>
<!----- Banner Sec Start ------>
<div class="banner-wrapper">
    <div class="inner">
        <div class="banner-title">
            <h1>MATTHEW'S MEALS</h1>
            <span>nothing but my own Airline<br> meals over the years</span>
        </div>
        <div class="banner-text">
            <p>
                welcome tO my Airline Meals Archive. Here, yOu wilL Find every airline Meal I have Ever Etaen Since 2004.
            </p>
        </div>
    </div>
</div>

<!----- Content Sec Start ------>
<div class="content-row1">
    <?php
    $term = get_queried_object();
    $args = array(
        'post_type' => 'meals',
        'orderby'    => 'ID',
        'post_status' => 'publish',
        'order'    => 'DESC',
        'tax_query' => array(
            array(
                'taxonomy' => 'airlines',
                'field' => 'slug',
                'terms' => $term->slug,
            ),
        ),
        'meta_query' => array(
            array(
                'key' => 'meal',
                'value' => 'breakfast',
            )
        ),
        'posts_per_page' => 4 // this will retrive all the post that is published 
    );
    $result = new WP_Query($args);
    if ($result->have_posts()) : ?>
        <div class="inner">
            <h2 class="sec-title">Breakfast</h2>
            <div class="meals-row">

                <?php while ($result->have_posts()) : $result->the_post(); ?>

                    <div class="meal-item">
                        <a href="<?php echo  get_permalink() ?>">
                            <?php the_post_thumbnail(); ?>
                            <h3> <?php the_title(); ?></h3>
                        </a>
                    </div>

                <?php endwhile; ?>

            </div>
        </div>
    <?php endif;
    wp_reset_postdata(); ?>
</div>

<div class="content-row1 meal-time">
    <?php
    $term = get_queried_object();
    $args = array(
        'post_type' => 'meals',
        'orderby'    => 'ID',
        'post_status' => 'publish',
        'order'    => 'DESC',
        'tax_query' => array(
            array(
                'taxonomy' => 'airlines',
                'field' => 'slug',
                'terms' => $term->slug,
            ),
        ),
        'meta_query' => array(
            array(
                'key' => 'meal',
                'value' => 'lunch',
            )
        ),
        'posts_per_page' => 4 // this will retrive all the post that is published 
    );
    $result = new WP_Query($args);
    if ($result->have_posts()) : ?>
        <div class="inner">
            <h2 class="sec-title">lunch</h2>
            <div class="meals-row">

                <?php while ($result->have_posts()) : $result->the_post(); ?>

                    <div class="meal-item">
                        <a href="<?php echo  get_permalink() ?>">
                            <?php the_post_thumbnail(); ?>
                            <h3> <?php the_title(); ?></h3>
                        </a>
                    </div>

                <?php endwhile; ?>

            </div>
        </div>
    <?php endif;
    wp_reset_postdata(); ?>
</div>

<div class="content-row1 meal-time">
    <?php
    $term = get_queried_object();
    $args = array(
        'post_type' => 'meals',
        'orderby'    => 'ID',
        'post_status' => 'publish',
        'order'    => 'DESC',
        'tax_query' => array(
            array(
                'taxonomy' => 'airlines',
                'field' => 'slug',
                'terms' => $term->slug,
            ),
        ),
        'meta_query' => array(
            array(
                'key' => 'meal',
                'value' => 'dinner',
            )
        ),
        'posts_per_page' => 4 // this will retrive all the post that is published 
    );
    $result = new WP_Query($args);
    if ($result->have_posts()) : ?>
        <div class="inner">
            <h2 class="sec-title">Dinner</h2>
            <div class="meals-row">
                <?php while ($result->have_posts()) : $result->the_post(); ?>
                    <div class="meal-item">
                        <a href="<?php echo  get_permalink() ?>">
                            <?php the_post_thumbnail(); ?>
                            <h3> <?php the_title(); ?></h3>
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    <?php endif;
    wp_reset_postdata(); ?>
</div>

<!----- Browse Categories Sec Start ------>
<div class="browse-categories">
    <h2 class="browse-all"><a href="<?php echo get_bloginfo('wpurl'); ?>/matthews-meals/">BrOwse my full archive Of airline meals</a></h2>
</div>

<!----- Content Logos Sec Start ------>
<div class="content-logos">
    <div class="inner">
        <ul>
            <?php $terms = get_terms([
                'taxonomy' => 'airlines',
                'hide_empty' => false,
            ]);
            foreach ($terms as $term) {
            ?>
                <li><a href="<?php echo get_term_link($term)  ?>">
                        <?php
                        $airline_image = get_term_meta($term->term_id, 'airlines-image-id', true);
                        echo wp_get_attachment_image($airline_image, 'full');
                        ?>
                    </a></li>
            <?php

            }
            ?>
        </ul>
    </div>
</div>
<?php get_footer(); ?>