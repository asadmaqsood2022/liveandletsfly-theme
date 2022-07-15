<?php
get_header();
?>
<!----- Single Page Sec Start ------>
<div class="single-meal">
	<div class="single-header">
		<div class="single-logo">
			<?php
			$post = get_queried_object();
			$terms = get_the_terms($post, 'airlines');
			if ($terms && !is_wp_error($terms)) {
				foreach ($terms as $term) {
					$code_term_id = get_term_meta($term->term_id, 'airlines-image-id', true);
					echo wp_get_attachment_image($code_term_id, 'full');
				}
			}
			?>
		</div>
		<div class="single-title">
			<?php
			foreach (get_the_terms($post->ID, 'airlines') as $cat) {
				$airline_name = $cat->name;
			}
			?>
			<h1><?php echo $airline_name; ?></h1>
		</div>
	</div>

	<div class="single-content">
		<div class="single-meal-image">
			<?php echo get_the_post_thumbnail(get_the_ID(), 'full'); ?>
		</div>
		<div class="single-meal-detail">
			<?php if (get_post_meta($post->ID, 'route', true)) { ?>
				<p><strong>Route:</strong> <?php echo get_post_meta($post->ID, 'route', true); ?></p>
			<?php } ?>
			<?php if (get_post_meta($post->ID, 'meal_date', true)) { ?>
				<p><strong>Date:</strong> <?php echo get_post_meta($post->ID, 'meal_date', true); ?></p>
			<?php } ?>
			<?php if (get_post_meta($post->ID, 'cabin', true)) { ?>
				<p><strong>Cabin:</strong> <?php echo get_post_meta($post->ID, 'cabin', true); ?></p>
			<?php } ?>
			<?php if (get_post_meta($post->ID, 'aircraft', true)) { ?>
				<p><strong>Aircraft:</strong> <?php echo get_post_meta($post->ID, 'aircraft', true); ?></p>
			<?php } ?>
			<?php if (get_post_meta($post->ID, 'meal', true)) { ?>
				<p><strong>Meal:</strong> <?php echo get_post_meta($post->ID, 'meal', true); ?></p>
			<?php } ?>
			<?php if (get_post_meta($post->ID, 'comments', true)) { ?>
				<p><strong>Comments:</strong> <?php echo get_post_meta($post->ID, 'comments', true); ?></p>
			<?php } ?>
		</div>
	</div>

</div>

<?php get_footer(); ?>