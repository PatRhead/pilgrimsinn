<?php
/*
Template Name: Resources
*/
?>

<?php get_header(); ?>

<div id="content">

	<div id="inner-content" class="wrap clearfix">

		<div id="main" class="twelvecol first clearfix" role="main">
			<?php $type = 'resources';

			$args=array(
				'post_type' => $type,
				'post_status' => 'publish',
				'posts_per_page' => -1
				);

			$videos = get_posts($args);

			if(count($resources)) {
				foreach($resources as $resource) {
					$resouce_info = get_fields($resource->ID);
					echo ($resouce_info);
					?>

					<?php echo $resouce_info['name']; ?>
					<br />
					<?php echo $resouce_info['contact_person']; ?>
					<br />
					<p><?php echo $resouce_info['address']; ?></p>
					<br />
					<?php echo $resouce_info['phone_number']; ?>
					<br />
					<?php echo $resouce_info['email']; ?>
					<br />
					<?php }
				} ?>
			</div>

		</div>

	</div>

	<?php get_footer(); ?>