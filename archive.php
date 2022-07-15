<?php

/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Twenty Fourteen
 * already has tag.php for Tag archives, category.php for Category archives,
 * and author.php for Author archives.
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
    <div class="cat-cover-box archive-cover-box">
        <div class="archive-cover-content">
            <?php
            // var_dump(get_queried_object_id());
            $code_term_id = get_term_meta(get_queried_object_id(), 'airlines-image-id', true);
            //  var_dump($code_term_id);
            echo wp_get_attachment_image($code_term_id, 'full');

            the_archive_title('<h1 class="category-title uppercase">', '</h1>');
            the_archive_description('<h3 class="category-description">', '</h3>');
            ?>
        </div>
    </div>
    <!--."cat-cover-box-->

    <?php
    // Live and Let's Fly Above Content
    do_action('liveandletsfly_above_content');
    ?>

    <div id="page">
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