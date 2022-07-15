<?php

/**
 * The template for displaying Category pages
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage travelista
 * @since Travelista 1.0
 */

get_header();

global $bpxl_travelista_options; ?>
<div class="main-wrapper">
    <?php
    $category_ID = get_query_var('cat');


    if (get_tax_meta($category_ID, 'bpxl_cat_cover_img')) {
        $bpxl_cat_bg = get_tax_meta($category_ID, 'bpxl_cat_cover_img');
    }
    ?>
    <div class="cat-cover-box archive-cover-box" <?php if (!empty($bpxl_cat_bg)) { ?>style="background:url('<?php echo esc_url($bpxl_cat_bg['src']); ?>') no-repeat fixed 0 0 / cover" <?php } ?>>
        <div class="archive-cover-content">
            <h1 class="category-title uppercase">
                <?php
                /* translators: %s: category title. */
                printf(wp_kses(__('%1$s <span>%2$s</span>', 'travelista'), array('span' => array())), esc_html($bpxl_travelista_options['bpxl_cat_title']), single_cat_title('', false));
                ?>
            </h1>
            <?php
            the_archive_description('<h3 class="category-description">', '</h3>');
            ?>
        </div>
    </div>

    <?php
    // Live and Let's Fly Above Content
    do_action('liveandletsfly_above_content');
    ?>

    <div id="page">
        <?php if (is_category(array('reviews', 'flight-reviews', 'hotel-reviews', 'lounge-reviews'))) : ?>
            <div class="lalf-reviews-search">
                <form method="get" class="searchform search-form" action="<?php echo esc_url(home_url('/')); ?>">
                    <fieldset>
                        <?php if ($category = get_queried_object()) : ?>
                            <input type="hidden" name="cat" value="<?php echo $category->term_id; ?>">
                            <input type="text" name="s" class="s" value="" placeholder="<?php _e('Search', 'travelista'); ?> <?php echo $category->name; ?>">
                        <?php else : ?>
                            <input type="text" name="s" class="s" value="" placeholder="<?php _e('Search Now', 'travelista'); ?>">
                        <?php endif; ?>
                        <button class="search-button fa fa-search" type="submit" value="<?php _e('Search', 'travelista'); ?>"></button>
                        <span class="search-submit fa fa-search"></span>
                    </fieldset>
                </form>
            </div><!-- .lalf-reviews-search -->

            <div class="lalf-reviews-nav">
                <div class="lalf-nav-menu">
                    <div class="lalf-menu-item"><a href="/category/flight-reviews"><i class="fa fa-plane"></i> Flight Reviews</a></div>
                    <div class="lalf-menu-item"><a href="/category/hotel-reviews"><i class="fa fa-bed"></i> Hotel Reviews</a></div>
                    <div class="lalf-menu-item"><a href="/lounge-reviews"><i class="fa fa-coffee"></i> Lounge Reviews</a></div>
                </div><!-- .lalf-nav-menu -->
            </div><!-- .lalf-reviews-nav -->

            <style type="text/css">
                .lalf-reviews-nav {
                    margin-top: 15px;
                }

                .lalf-reviews-nav * {
                    -webkit-box-sizing: border-box;
                    -moz-box-sizing: border-box;
                    box-sizing: border-box;
                }

                .lalf-nav-menu {
                    margin: -15px -7.5px;
                }

                .lalf-menu-item {
                    float: left;
                    margin: 0;
                    padding: 15px 7.5px;
                    vertical-align: top;
                    width: 33.33333333%;
                }

                .lalf-menu-item a {
                    background: #b78c00;
                    color: #fff;
                    display: block;
                    padding: 8px 16px;
                    text-align: center;
                }

                @media screen and (max-width: 768px) {
                    .lalf-menu-item {
                        float: none;
                        padding-bottom: 0;
                        width: 100%;
                    }
                }
            </style>
        <?php endif; ?>
        <div class="main-content <?php bpxl_layout_class(); ?>">
            <?php
            // Include secondary sidebar
            if ($bpxl_travelista_options['bpxl_archive_layout'] == 'scblayout') {
                get_template_part('sidebar-secondary');
            }
            ?>
            <div class="content-area home-content-area">
                <div class="site-main">
                    <div id="content" class="content <?php bpxl_masonry_class(); ?>">
                        <div class="grid-sizer grid-sizer-3"></div>
                        <div class="gutter-sizer"></div>
                        <?php
                        // Live and Let's Fly Counter
                        $liveandletsfly_count = 0;

                        if (have_posts()) : while (have_posts()) : the_post();

                                // Live and Let's Fly Post Ads
                                if ($liveandletsfly_count == 3) {
                        ?>
                                    <article class="post post-ad">
                                        <?php boardingpack_ad_manager('sidebar_top'); ?>
                                    </article>
                                <?php
                                } else if ($liveandletsfly_count == 6) {
                                ?>
                                    <article class="post post-ad">
                                        <?php boardingpack_ad_manager('sidebar_middle'); ?>
                                    </article>
                                <?php
                                } else if ($liveandletsfly_count == 9) {
                                ?>
                                    <article class="post post-ad">
                                        <?php boardingpack_ad_manager('sidebar_bottom'); ?>
                                    </article>
                        <?php
                                }

                                /*
                             * Include the post format-specific template for the content. If you want to
                             * use this in a child theme, then include a file called called content-___.php
                             * (where ___ is the post format) and that will be used instead.
                             */

                                get_template_part('template-parts/post-formats/content', get_post_format());

                                // Live and Let's Fly Counter
                                $liveandletsfly_count++;

                            endwhile;

                        else :
                            // If no content, include the "No posts found" template.
                            get_template_part('template-parts/post-formats/content', 'none');

                        endif;
                        ?>
                    </div>
                    <!--.content-->
                </div>
                <!--.site-main-->
                <?php
                // Previous/next page navigation.
                bpxl_paging_nav();
                ?>
            </div>
            <!--content-area-->
            <?php
            $bpxl_layout_array = array(
                'clayout',
                'glayout',
                'flayout'
            );
            if (!in_array($bpxl_travelista_options['bpxl_archive_layout'], $bpxl_layout_array)) {
                get_sidebar();
            }
            ?>
        </div>
        <!--.main-content-->
        <?php get_footer(); ?>