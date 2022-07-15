<?php /* Template Name: Meals-search */
?>

<?php get_header(); ?>
<!----- Banner Sec Start ------>

<!----- Content Sec Start ------>
<div class="content-row1">
    <div class="inner">
        <h2 class="sec-title">Search Results</h2>
        <div class="meals-row">
            <?php
            $airlines_cat = $_GET['airlines-cat'];
            $meal_type = $_GET['meal-type'];
            ?>
            <?php $meal_date = get_post_meta($post->ID, 'date', true); ?>
            <?php
            $args = array(
                'post_type' => 'meals',
                'post_status' => 'publish',
                'meta_key'   => 'meal_date',
                'orderby' => 'meta_value',
                'order'   => 'ASC',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'airlines',
                        'field' => 'id',
                        'terms' => $airlines_cat,
                    ),
                ),
                'meta_query' => array(
                    array(
                        'key' => 'meal',
                        'value' => $meal_type,
                    )
                ),
                'posts_per_page' => 4 // this will retrive all the post that is published 
            );
            $result = new WP_Query($args);
            if ($result->have_posts()) { ?>
                <?php while ($result->have_posts()) : $result->the_post(); ?>

                    <div class="meal-item">
                        <a href="<?php echo  get_permalink() ?>">
                            <?php
                            the_post_thumbnail(); ?>
                            <h3> <?php the_title(); ?></h3>
                        </a>
                    </div>

                <?php endwhile; ?>
            <?php } else { ?>
                <p class="no-record">No Meals Found</p>
            <?php }
            wp_reset_postdata(); ?>
        </div>
    </div>
</div>


<!----- Browse Categories Sec Start ------>
<div class="browse-categories">
    <h2 class="browse-all"><a href="<?php echo get_bloginfo('wpurl'); ?>/matthews-meals/">BrOwse my full archive Of airline meals</a></h2>
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

<?php get_footer(); ?>