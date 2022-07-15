<?php
get_header();

global $bpxl_travelista_options;

if (have_posts()) : the_post();

	if (function_exists('rwmb_meta')) {
		$bpxl_cover = rwmb_meta('bpxl_post_cover_show', $args = array('type' => 'checkbox'), $post->ID);
		$related = rwmb_meta('bpxl_singlerelated', $args = array('type' => 'checkbox'), $post->ID);
		$bpxl_sidebar_position = rwmb_meta('bpxl_layout', $args = array('type' => 'image_select'), get_the_ID());
	} else {
		$bpxl_cover = '';
		$related = '';
		$bpxl_sidebar_position = '';
	}

	if ($bpxl_cover == '1') {
?>
		<div class="cover-box">
			<?php $url = wp_get_attachment_url(get_post_thumbnail_id($post->ID)); ?>
			<div data-type="background" data-speed="3" class="cover-image" style="background-image: url( <?php echo esc_url($url); ?>);">
				<div class="cover-heading">
					<div class="slider-inner">
						<?php if ($bpxl_travelista_options['bpxl_single_meta'] == '1' && $bpxl_travelista_options['bpxl_single_post_meta_options']['3'] == '1') { ?>
							<div class="post-cats slider-cat uppercase">
								<?php
								$category = get_the_category();
								if ($category) {
									echo '<span>' . $category[0]->name . '</span> ';
								}
								?>
							</div>
						<?php } ?>
						<header>
							<h1 class="title f-title">
								<?php the_title(); ?>
							</h1>
						</header>
						<!--.header-->
						<?php if ($bpxl_travelista_options['bpxl_single_meta'] == '1') { ?>
							<div class="slider-meta post-meta">
								<?php if ($bpxl_travelista_options['bpxl_single_post_meta_options']['2'] == '1') { ?>
									<span class="post-date">
										<i class="fa fa-clock-o"></i>
										<?php bpxl_posted_on(); ?>
									</span>
								<?php } ?>
								<?php if ($bpxl_travelista_options['bpxl_single_post_meta_options']['5'] == '1') { ?>
									<span class="post-comments"><i class="fa fa-comments-o"></i> <?php comments_number(__('No Comments Yet', 'travelista'), __('1 Comment', 'travelista'), __('% Comments', 'travelista')); ?></span>
								<?php } ?>
							</div>
						<?php } ?>
					</div>
					<!--.slider-inner-->
				</div>
				<!--.cover-heading-->
			</div>
		</div>
		<!--.cover-box-->
	<?php } ?>
	<div class="main-wrapper">
		<div id="page">
			<div class="main-content <?php bpxl_layout_class(); ?>">
				<?php
				// Include secondary sidebar
				if ($bpxl_travelista_options['bpxl_single_layout'] == 'scblayout') {
					if ($sidebar_position == 'default' || empty($sidebar_position)) {
						get_template_part('sidebar-secondary');
					}
				} ?>
				<div id="content" class="content-area single-content-area">
					<div class="site-main">
						<div class="content content-single <?php bpxl_masonry_class(); ?>">
							<?php if ($bpxl_travelista_options['bpxl_breadcrumbs'] == '1') { ?>
								<div class="breadcrumbs" itemtype="http://schema.org/BreadcrumbList" itemscope="">
									<?php bpxl_breadcrumb(); ?>
								</div>
							<?php }

							rewind_posts();
							while (have_posts()) : the_post();

								if (!current_user_can('edit_post', get_the_ID())) {
									setPostViews(get_the_ID());
								} ?>

								<div class="single-content clearfix">
									<?php get_template_part('template-parts/post-formats/single', get_post_format()); ?>
								</div>
								<!--.single-content-->

								<?php
								// Live and Let's Fly In Content
								do_action('liveandletsfly_in_content');
								?>

						<?php
							endwhile;

						else :
							// If no content, include the "No posts found" template.
							get_template_part('template-parts/post-formats/content', 'none');

						endif;

						if ($bpxl_travelista_options['bpxl_next_prev_article'] == '1') {

							// Previous/next post navigation.
							bpxl_post_nav();
						}
						?>

						<?php if ($bpxl_travelista_options['bpxl_author_box'] == '1') { ?>
							<div class="author-box clearfix single-box">
								<h3 class="section-heading uppercase"><span><?php esc_html_e('About Author', 'travelista'); ?></span></h3>
								<div class="author-box-avtar">
									<?php if (function_exists('get_avatar')) {
										echo get_avatar(get_the_author_meta('email'), '100');
									} ?>
								</div>
								<div class="author-info-container">
									<div class="author-info">
										<div class="author-head">
											<h5><?php esc_attr(the_author_meta('display_name')); ?></h5>
										</div>
										<p><?php esc_attr(the_author_meta('description')); ?></p>
										<div class="author-social">
											<?php
											$social_icons = array();

											$facebook = get_the_author_meta('facebook');
											$twitter = get_the_author_meta('twitter');
											$googleplus = get_the_author_meta('googleplus');
											$linkedin = get_the_author_meta('linkedin');
											$pinterest = get_the_author_meta('pinterest');
											$dribbble = get_the_author_meta('dribbble');

											($facebook) ? $social_icons['facebook'] = esc_html__('Facebook', 'travelista') : '';
											($twitter) ? $social_icons['twitter'] = esc_html__('Twitter', 'travelista') : '';
											($googleplus) ? $social_icons['google-plus'] = esc_html__('Google+', 'travelista') : '';
											($linkedin) ? $social_icons['linkedin'] = esc_html__('Linkedin', 'travelista') : '';
											($pinterest) ? $social_icons['pinterest'] = esc_html__('Pinterest', 'travelista') : '';
											($dribbble) ? $social_icons['dribbble'] = esc_html__('Dribbble', 'travelista') : '';

											foreach ($social_icons as $icon_id => $icon_title) {
												$link = get_the_author_meta($icon_id);
												if (!empty($link)) {
													echo '<span class="author-' . esc_attr($icon_id) . '">';
													echo '<a href="' . esc_url($link) . '">';
													echo '<span class="fa fa-' . esc_attr($icon_id) . '" aria-hidden="true"></span>';
													echo '<span class="screen-reader-text">' . esc_html('Follow us on', 'travelista') . ' ' . esc_attr($icon_title) . '</span>';
													echo '</a>';
													echo '</span>';
												}
											}
											?>
										</div>
										<!--.author-social-->
									</div>
									<!--.author-info-->
								</div>
							</div>
							<!--.author-box-->
						<?php }

						get_template_part('template-parts/related-posts');

						if (comments_open() || get_comments_number()) {
							comments_template();
						} ?>
						</div>
					</div>
					<!--.site-main-->
				</div>
				<!--.content-area-->
				<?php
				/*if ($bpxl_travelista_options['bpxl_single_layout'] != 'flayout') {
					if ($sidebar_position == 'left' || $sidebar_position == 'right' || $sidebar_position == 'default' || empty( $sidebar_position )) {
						get_sidebar();
					}
				}*/
				if ($bpxl_travelista_options['bpxl_single_layout'] == 'flayout' || $bpxl_sidebar_position == 'none') {
					if ($bpxl_sidebar_position == '' || $bpxl_sidebar_position == 'default' || $bpxl_sidebar_position == 'none') {
						echo '';
					} else {
						get_sidebar();
					}
				} else {
					get_sidebar();
				}
				?>
			</div>
			<!--.main-content-->
			<?php get_footer(); ?>