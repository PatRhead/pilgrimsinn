<?php get_header(); ?>


<div id="content">

	<div id="inner-content" class="wrap clearfix">

		<div id="main" class="twelvecol first clearfix" role="main">

			<?php echo do_shortcode("[metaslider id=84]"); a?>

			<section class="entry-content clearfix" itemprop="articleBody">
				<?php the_content(); ?>
				<!-- Place somewhere in the <body> of your page -->
			</section>

			<footer class="article-footer">
			</footer>


		</article>

	</div>

</div>

</div>

<?php get_footer(); ?>