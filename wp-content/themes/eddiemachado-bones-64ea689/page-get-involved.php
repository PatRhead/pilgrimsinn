<?php
/*
Template Name: Get Involved
*/
?>

<?php get_header();
 ?>

<div id="content">

	<div id="inner-content-secondary" class="wrap clearfix">
		<div class="headerimg"><img src="<?php echo the_field('header_image', $post->ID) ?>" alt="" width="" height="" /></div>
		<?php
		include('main-cta.php');

		?>
		<div class="threecol">
			<div id="menu">

				<ul>
					<li class="sub-menu-title">
						<?php the_field('menu_title', $post->ID) ?>
					</li>
					<?php
					if( have_rows('page_area') ):
						$x = 0;
					while ( have_rows('page_area') ) : the_row();
					$x++;
					?>
					<li id="sub-menu-<?php echo $x ?>" class="sub-menu-item <?php if($x == 1) {echo "active";} else {echo "inactive";} ?>">
						<?php the_sub_field('menu_title');  ?>
					</li>

					<?php
					endwhile;
					else :
						endif;
					?>
				</ul>
			</div>
		</div>
		<div class="ninecol">
			<?php

			if( have_rows('page_area') ):
				$x = 0;
			while ( have_rows('page_area') ) : the_row();
			$x++;
			?>
			<div id="sub-content-<?php echo $x ?>" class="sub-content-item <?php if($x == 1) {echo "content-visible";} else {echo "content-hidden";} ?>">
				<?php the_sub_field('content'); ?>
			</div>
			<?php
			endwhile;
			else :
				endif;
			?>
		</div>
	</div>

</div>

<?php get_footer(); ?>