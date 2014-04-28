<?php
/*
Template Name: News & Updates
*/
?>

<?php get_header(); ?>

<div id="content">

	<div id="inner-content" class="wrap clearfix">

		<div id="main" class="twelvecol first clearfix" role="main">
			<?php $type = 'updates';

			$args=array(
				'post_type' => $type,
				'post_status' => 'publish',
				'posts_per_page' => -1,
				'meta_key'		=> 'event_date',
				'orderby'		=> 'meta_value_num',
				'order'			=> 'DESC'
				);

			$updates = get_posts($args);

			if(count($updates)) {
				foreach($updates as $update) {
					$update_info = get_fields($update->ID);
					?>
					<a target="_blank" href="<?php echo $update_info['link']; ?>"><?php echo $update_info['title']; ?></a>
					<?php }
				} ?>
			</div>

		</div>

	</div>

	<?php get_footer(); ?>