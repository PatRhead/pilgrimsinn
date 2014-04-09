<?php
/*
Template Name: Get Involved
*/
?>

<?php get_header();
echo "<style>.getheader {margin-top:-146px;} #informed {background-color: #9DB363;}

</style>" 

?>

<div id="content">

	<div id="inner-content-secondary" class="wrap clearfix">
		<div class="headerimg"><img src="http://spring2014.hiveu.me/pi/patrick/wp-content/uploads/2014/04/IMG_1524-1196x755.jpg" alt="test_header" width="" height="" /></div>
		<?php
		include('main-cta.php');
	
		?>
		<!--
		<div id="main" class="eightcol first clearfix" role="main">

			<?php the_field('get_involved_title', $post->ID); ?>
			<br />
			<?php the_field('get_involved_sub_title', $post->ID); ?>
			<br />
			<?php the_field('get_involved_contnet', $post->ID); ?>

		</div>-->
		<div class="threecol">
		<div id="menu">

			<ul>
				<li class="sub-menu-title">
					<?php the_field('menu_title', $post->ID) ?>
				</li>
				<?php
				// What I have to do now is add the fucntionalty to remove the content-hidden class on the content when the user clicks that menu item
				// So it will check for the menu_title in the contnet, and if it matched then add the show class, THEN remove the hidden class.
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