<?php
/*
Template Name: Photo Gallery
*/
?>

<?php get_header();
echo "<style>.getheader {margin-top:-146px;}</style>" ?>

<div id="content">

	<div id="inner-content-secondary" class="wrap clearfix">
		<div class="headerimg"><img src="http://spring2014.hiveu.me/pi/patrick/wp-content/uploads/2014/04/A.jpg" alt="test_header" width="" height="" /></div>
		<?php
		include('main-cta.php');
	
		?>
		<div class="threecol">
			<div id="menu">

				<ul>
					<li class="sub-menu-title">
						<?php the_field('gallery_menu_name', $post->ID) ?>
					</li>
					<?php
					if( have_rows('gallery_list') ):
						$x = 0;
					while ( have_rows('gallery_list') ) : the_row();
					$x++;
					?>
					<li id="sub-menu-<?php echo $x ?>" class="sub-menu-item <?php if($x == 1) {echo "active";} else {echo "inactive";} ?>">
						<?php the_sub_field('gallery_title');  ?>
					</li>

					<?php
					endwhile;
					else :
						endif;
					?>
				</ul>
			</div>
		</div>


		<div class="ninecol photo">
			<?php

			if( have_rows('gallery_list') ):
				$x = 0;
			while ( have_rows('gallery_list') ) : the_row();
			$x++;
			?>
			<div id="sub-content-<?php echo $x ?>" class="sub-content-item <?php if($x == 1) {echo "content-visible";} else {echo "content-hidden";} ?>">
				<?php
				the_sub_field('photo_gallery');
				?>
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