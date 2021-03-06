<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage travelista
 * @since Travelista 1.0
 */

global $bpxl_travelista_options;

get_header(); ?>

<div class="main-wrapper clearfix">
	<?php
	// Include Slider
	if ($bpxl_travelista_options['bpxl_slider'] == '1') {
		if (!is_paged()) {
			get_template_part('inc/slider');
		}
	}
	?>
	<div id="page">
		<div class="main-content <?php bpxl_layout_class(); ?>">
			<?php
			// Include secondary sidebar
			if ($bpxl_travelista_options['bpxl_layout'] == 'scblayout') {
				get_template_part('sidebar-secondary');
			}
			?>
			<div class="content-area home-content-area">
				<div class="site-main">
					<div id="content" class="content <?php bpxl_masonry_class(); ?>">
						<div class="grid-sizer grid-sizer-3"></div>
						<div class="gutter-sizer"></div>
						<?php
						if (get_query_var('paged')) {
							$paged = get_query_var('paged');
						} elseif (get_query_var('page')) {
							$paged = get_query_var('page');
						} else {
							$paged = 1;
						}

						if ($bpxl_travelista_options['bpxl_home_latest_posts'] == '1') {
							$recent_cats = (isset($bpxl_travelista_options['bpxl_home_latest_cat']) ? $bpxl_travelista_options['bpxl_home_latest_cat'] : '');
							$recent_cat = ($recent_cats ? implode(",", $recent_cats) : '');
							$args = array(
								'cat'   => $recent_cat,
								'paged' => $paged
							);
						} else {
							$args = array(
								'post_type' => 'post',
								'paged'     => $paged
							);
						}

						// The Query
						query_posts($args);

						// Live and Let's Fly Counter
						$liveandletsfly_count = 0;

						// Start the Loop.
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
					<!--content-->
				</div>
				<!--site-main-->
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

			if (!in_array($bpxl_travelista_options['bpxl_layout'], $bpxl_layout_array)) {
				get_sidebar();
			}
			?>
		</div>
		<!--.main-->
		<?php get_footer(); ?>