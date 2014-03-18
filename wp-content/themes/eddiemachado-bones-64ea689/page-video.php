<?php
/*
Template Name: Video Page
*/
?>

<?php get_header(); ?>

<div id="content">

	<div id="inner-content" class="wrap clearfix">

		<div id="main" class="eightcol first clearfix" role="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

				<header class="article-header">

				<!--	<h1 class="page-title"><?php the_title(); ?></h1> -->
					<p class="byline vcard"><?php
					printf( __( 'Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span>.', 'bonestheme' ), get_the_time( 'Y-m-j' ), get_the_time( __( 'F jS, Y', 'bonestheme' ) ), bones_get_the_author_posts_link() );
					?></p>


				</header>

				<section class="entry-content clearfix" itemprop="articleBody">
					<?php the_content(); ?>

					<!-- TO GET DIFFERENT POSTS, CHANGE SECOND ARGUEMNT -->
					<!-- TO DO ~~~ REPLACE WITH VAR PULLING ALL POSTS WITH THAT CPT ~~~ -->

					<?php $type = 'videos';

					$args=array(
						'post_type' => $type,
						'post_status' => 'publish',
						'posts_per_page' => -1
						);

					$videos = get_posts($args);

					if(count($videos)) {
						foreach($videos as $video) {
							$video_info = get_fields($video->ID);

							//checks for http:// and watch? in video URL
							$video_url = $video_info['video_area'];
							$video_url_fixed = str_replace("http://", "", $video_url);
							$video_url_fixed = str_replace("/watch?v=", "/embed/", $video_url_fixed);
							?>

							<?php echo $video_info['title']; ?>
							<br />
							<?php echo $video_info['sub_title']; ?>
							<br />
							<?php echo $video_info['content']; ?>
							<br />
							<iframe width="420" height="315" src="//<?php echo $video_url_fixed ?>" frameborder="0" allowfullscreen></iframe>
							<hr />
							<?php }
						} ?>

					</section>
					<footer class="article-footer">
						<p class="clearfix"><?php the_tags( '<span class="tags">' . __( 'Tags:', 'bonestheme' ) . '</span> ', ', ', '' ); ?></p>

					</footer>
				</article>

			<?php endwhile; else : ?>

			<article id="post-not-found" class="hentry clearfix">
				<header class="article-header">
					<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
				</header>
				<section class="entry-content">
					<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
				</section>
				<footer class="article-footer">
					<p><?php _e( 'This is the error message in the page-custom.php template.', 'bonestheme' ); ?></p>
				</footer>
			</article>

		<?php endif; ?>

	</div>

	<?php // get_sidebar(); ?>

</div>

</div>

<?php get_footer(); ?>
