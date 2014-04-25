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

		<div class="headerimg"><img src="<?php echo the_field('header_image', $post->ID) ?>" alt="" width="" height="" /></div>
		<?php
		include('main-cta.php');

		?>

		<div id="main" class="eightcol first clearfix" role="main">

			<div class="getheader">
				<a href="<?php the_permalink(); ?>/get-informed">
					<div id="getinformed">
						<h1>Get Informed</h1>
					</div>
				</a>
				<a href="<?php the_permalink(); ?>/get-involved">
					<div id="getinvolved">
						<h1>Get Involved</h1>
					</div>
				</a>
				<a href="<?php the_permalink(); ?>/get-help">
					<div id="gethelp">
						<h1>Get Help</h1>
					</div>
				</a>
			</div>
=======
>>>>>>> patrick

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