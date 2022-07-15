<?php
/**
 * The template for displaying Author archive pages
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
<?php if(get_the_author_meta('author-attachment-url')) {
	$bpxl_author_bg = get_the_author_meta("author-attachment-url");
} ?>
	<div class="archive-cover-box" <?php if (!empty($bpxl_author_bg)) { ?>style="background:url('<?php echo esc_url( $bpxl_author_bg ); ?>') no-repeat fixed 0 0 / cover" <?php } ?>>
		<div class="author-box author-desc-box">
			<div class="author-box-content">
				<div class="author-avtar">
					<?php if(function_exists('get_avatar')) { echo get_avatar( get_the_author_meta('email'), '90' );  } ?>
				</div>
                <div class="author-page-info archive-cover-content">
                    <div class="author-head">
                        <h5><?php esc_attr( the_author_meta('display_name') ); ?></h5>
                    </div>
                    <p class="uppercase"><?php the_author_posts(); echo ' '; esc_html_e('Articles','travelista'); ?></p>
                    <?php if(get_the_author_meta('author-loc')) { ?>
                        <div class="author-location">
                            <span class="author-loc">
                                <?php echo esc_attr( get_the_author_meta("author-loc") ); ?>
                            </span>
                        </div>
                    <?php } ?>
                    <?php if(get_the_author_meta('description')) { ?>
                        <div class="author-desc"><?php esc_attr( the_author_meta('description') ); ?></div>
                    <?php } ?>
                    <div class="author-social">
						<?php
							$social_icons = array();

							$facebook = get_the_author_meta( 'facebook' );
							$twitter = get_the_author_meta( 'twitter' );
							$googleplus = get_the_author_meta( 'googleplus' );
							$linkedin = get_the_author_meta( 'linkedin' );
							$pinterest = get_the_author_meta( 'pinterest' );
							$dribbble = get_the_author_meta( 'dribbble' );

							( $facebook ) ? $social_icons['facebook'] = esc_html__('Facebook', 'travelista') : '';
							( $twitter ) ? $social_icons['twitter'] = esc_html__('Twitter', 'travelista') : '';
							( $googleplus ) ? $social_icons['google-plus'] = esc_html__('Google+', 'travelista') : '';
							( $linkedin ) ? $social_icons['linkedin'] = esc_html__('Linkedin', 'travelista') : '';
							( $pinterest ) ? $social_icons['pinterest'] = esc_html__('Pinterest', 'travelista') : '';
							( $dribbble ) ? $social_icons['dribbble'] = esc_html__('Dribbble', 'travelista') : '';

							foreach ( $social_icons as $icon_id => $icon_title ) {
								$link = get_the_author_meta( $icon_id );
								if ( !empty( $link ) ) {
									echo '<span class="author-' . esc_attr( $icon_id ) . '">';
										echo '<a href="' . esc_url( $link ) . '">';
											echo '<span class="fa fa-' . esc_attr( $icon_id ) . '" aria-hidden="true"></span>';
											echo '<span class="screen-reader-text">' . esc_html( 'Follow us on','travelista' ) . ' ' . esc_attr( $icon_title ) . '</span>';
										echo '</a>';
									echo '</span>';
								}
							}
						?>
                    </div>
                </div>
			</div>
		</div>
	</div><!--.author-desc-box-->

	<?php
	// Live and Let's Fly Above Content
	do_action( 'liveandletsfly_above_content' );
	?>

	<div id="page">
		<div class="main-content <?php bpxl_layout_class(); ?>">
            <?php
                // Include secondary sidebar
                if($bpxl_travelista_options['bpxl_archive_layout'] == 'scblayout') {
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
                            if ( $liveandletsfly_count == 3 ) {
                                ?>
                                <article class="post post-ad">
                                    <?php boardingpack_ad_manager( 'sidebar_top' ); ?>
                                </article>
                                <?php
                            } else if ( $liveandletsfly_count == 6 ) {
                                ?>
                                <article class="post post-ad">
                                    <?php boardingpack_ad_manager( 'sidebar_middle' ); ?>
                                </article>
                                <?php
                            } else if ( $liveandletsfly_count == 9 ) {
                                ?>
                                <article class="post post-ad">
                                    <?php boardingpack_ad_manager( 'sidebar_bottom' ); ?>
                                </article>
                                <?php
                            }

                            /*
                             * Include the post format-specific template for the content. If you want to
                             * use this in a child theme, then include a file called called content-___.php
                             * (where ___ is the post format) and that will be used instead.
                             */

                            get_template_part( 'template-parts/post-formats/content', get_post_format() );

                            // Live and Let's Fly Counter
                            $liveandletsfly_count++;

                            endwhile;

                            else:
                                // If no content, include the "No posts found" template.
                                get_template_part( 'template-parts/post-formats/content', 'none' );

                            endif;
                        ?>
					</div><!--.content-->
				</div><!--.site-main-->
                <?php 
                    // Previous/next page navigation.
                    bpxl_paging_nav();
                ?>
            </div><!--content-area-->
            <?php
                $bpxl_layout_array = array(
                    'clayout',
                    'glayout',
                    'flayout'
                );
                if(!in_array($bpxl_travelista_options['bpxl_archive_layout'],$bpxl_layout_array)) { get_sidebar(); }
            ?>
		</div><!--.main-content-->
<?php get_footer(); ?>