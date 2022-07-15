<!DOCTYPE html>
<?php global $bpxl_travelista_options; ?>
<html <?php language_attributes(); ?>>
<head itemscope itemtype="http://schema.org/WebSite">
	<meta charset="<?php bloginfo('charset'); ?>">
    <meta itemprop="url" content="<?php echo esc_url( home_url( '/' ) ); ?>"/>
    <meta itemprop="name" content="<?php bloginfo( 'name' ); ?>"/>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<meta name="viewport" content="width=device-width" />
	<?php wp_head(); ?>
</head>

<?php if($bpxl_travelista_options['bpxl_layout_type'] == '1') { $layout_class = ' full-layout'; } else { $layout_class = ' boxed-layout'; } ?>
<body id="blog" <?php body_class('main'); ?> itemscope itemtype="http://schema.org/WebPage">
	<div id="st-container" class="st-container">
		<nav class="st-menu">
			<div class="off-canvas-search">
				<div class="off-search">
                    <?php get_search_form(); ?>
                </div>
			</div><!--.off-canvas-search-->
			<?php
                if ( has_nav_menu( 'mobile-menu' ) ) {
                    wp_nav_menu( array(
                        'theme_location'    => 'mobile-menu',
                        'menu_class'        => 'menu',
                        'container'         => '',
                        'walker'            => new bpxl_nav_walker_mobile
                    ) );
                } else {
                    if ( has_nav_menu( 'main-menu' ) ) {
                        wp_nav_menu( array(
                            'theme_location'    => 'main-menu',
                            'menu_class'        => 'menu',
                            'container'         => '',
                            'walker'            => new bpxl_nav_walker_mobile
                        ) );
                    }

                    if ( has_nav_menu( 'secondary-menu' ) ) {
                        wp_nav_menu( array( 
                            'theme_location'    => 'secondary-menu',
                            'menu_class'        => 'menu',
                            'container'         => '', 'walker' => new bpxl_nav_walker_mobile
                        ) );
                    }
                }
            ?>
		</nav>
		<div class="main-container<?php echo esc_attr( $layout_class ); ?>">
			<div class="menu-pusher">
				<!-- START HEADER -->
				<?php 
					if ( !empty($bpxl_travelista_options['bpxl_header_style']) )  {
						$bpxl_header_style = $bpxl_travelista_options['bpxl_header_style'];
					} else {
						$bpxl_header_style = '1';
					}
					get_template_part('template-parts/header-'.$bpxl_header_style );
				?>
				<!-- END HEADER -->

				<?php
				// Live and Let's Fly Above Content
				if ( ! is_category() && ! is_archive() && ! is_search() && ! is_author() ) :
				do_action( 'liveandletsfly_above_content' );
				endif;
				?>