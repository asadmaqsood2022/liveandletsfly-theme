<?php /* Template Name: Meals */
?>

<?php get_header(); ?>
<!----- Banner Sec Start ------>
<div class="banner-wrapper">
    <div class="inner">
        <div class="banner-title">
            <h1><?php the_title(); ?></h1>
            <span>nothing but my own Airline<br> meals over the years</span>
        </div>
        <div class="banner-text">
            <?php the_content(); ?>
        </div>
    </div>
</div>

<!----- Content Sec Start ------>
<div class="content-row1">
    <div class="inner">
        <h2 class="sec-title">Meal OF THE WEEK</h2>
        <div class="meals-row">

            <?php
            $args = array(
                'post_type' => 'meals',
                'post_status' => 'publish',
                'meta_key'   => 'meal_date',
                'orderby' => 'meta_value',
                'order'   => 'ASC',
                'posts_per_page' => 4 // this will retrive all the post that is published 
            );
            $result = new WP_Query($args);
            if ($result->have_posts()) : ?>
                <?php while ($result->have_posts()) : $result->the_post(); ?>
                    <div class="meal-item">
                        <a href="<?php echo  get_permalink() ?>">
                            <?php
                            the_post_thumbnail(); ?>
                            <h3> <?php the_title(); ?></h3>
                        </a>
                    </div>

                <?php endwhile; ?>
            <?php endif;
            wp_reset_postdata(); ?>
        </div>
    </div>
</div>

<!----- Browse Categories Sec Start ------>
<div class="browse-categories">
    <h2 class="browse-all"><a href="<?php echo get_bloginfo('wpurl'); ?>/matthews-meals/">BrOwse my full archive Of airline meals</a></h2>
    <!-- <div class="alphabetic-categories">
        <ul>
            <li><a href="#">A</a></li>
            <li><a href="#">B</a></li>
            <li><a href="#">C</a></li>
            <li><a href="#">D</a></li>
            <li><a href="#">E</a></li>
            <li><a href="#">G</a></li>
            <li><a href="#">H</a></li>
            <li><a href="#">I</a></li>
            <li><a href="#">J</a></li>
            <li><a href="#">K</a></li>
            <li><a href="#">L</a></li>
            <li><a href="#">M</a></li>
            <li><a href="#">N</a></li>
            <li><a href="#">O</a></li>
            <li><a href="#">P</a></li>
            <li><a href="#">Q</a></li>
            <li><a href="#">R</a></li>
            <li><a href="#">S</a></li>
            <li><a href="#">T</a></li>
            <li><a href="#">U</a></li>
            <li><a href="#">V</a></li>
            <li><a href="#">W</a></li>
            <li><a href="#">Y</a></li>
            <li><a href="#">Z</a></li>
        </ul>
    </div> -->
    <div class="search-meal-form">
        <form class="form-inline" action="<?php echo  home_url('/meals-search'); ?>" method="GET">
            <label>Select Airline:</label>
            <select name="airlines-cat">
                <option>--Select--</option>
                <?php $terms = get_terms([
                    'taxonomy' => 'airlines',
                    'hide_empty' => false,
                ]);
                foreach ($terms as $term) { ?>
                    <option value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
                <?php } ?>
            </select>
            <label>Meal Type:</label>
            <select name="meal-type">
                <option>--Select--</option>
                <option value="breakfast">Breakfast</option>
                <option value="lunch">Lunch</option>
                <option value="dinner">Dinner</option>
            </select>
            <input type="submit" name="submit" value="Search">
        </form>
    </div>
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