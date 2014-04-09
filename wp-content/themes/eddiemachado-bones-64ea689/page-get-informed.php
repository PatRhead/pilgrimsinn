<?php
/*
Template Name: Get Informed
*/
?>

<?php get_header(); ?>

<div id="content">

	<div id="inner-content" class="wrap clearfix">
		<?php
			// Gets the three main call to action buttons
		include('main-cta.php');
		?>
		<div id="main" class="twelvecol first clearfix" role="main">

			<?php the_field('get_involved_title', $post->ID); ?>
			<br />
			<?php the_field('get_involved_sub_title', $post->ID); ?>
			<br />
			<?php the_field('get_involved_contnet', $post->ID); ?>

		</div>

	</div>

</div>

<?php get_footer(); ?>