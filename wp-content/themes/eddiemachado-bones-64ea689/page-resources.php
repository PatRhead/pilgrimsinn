
<?php
/*
Template Name: Resources Page
*/
?>

<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">

						<div id="main" class="eightcol first clearfix" role="main">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

								<header class="article-header">

									<h1 class="page-title"><?php the_title(); ?></h1>
									<p class="byline vcard"><?php
										printf( __( 'Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span>.', 'bonestheme' ), get_the_time( 'Y-m-j' ), get_the_time( __( 'F jS, Y', 'bonestheme' ) ), bones_get_the_author_posts_link() );
									?></p>


								</header>

								<section class="entry-content clearfix" itemprop="articleBody">
									<?php the_content(); ?>

									<!-- TO GET DIFFERENT POSTS, CHANGE SECOND ARGUEMNT -->
									<!-- TO DO ~~~ REPLACE WITH VAR PULLING ALL POSTS WITH THAT CPT ~~~ -->

									<p><?php the_field('name', 43); ?></p>
									<p><?php the_field('address', 43); ?></p>
									<?php $image = wp_get_attachment_image_src(get_field('picture', 43), 'full'); ?>
									<img src="<?php echo $image[0]; ?>" alt="<?php echo get_the_title(get_field('picture', 43)) ?>" />

									<!-- PRINTS THE URL FOR EVERY CUSTOM POST TYPE WITH NAME RESOURCE -->

									<?php
										$type = 'resources';
										$args=array(
										  'post_type' => $type,
										  'post_status' => 'publish',
										  'posts_per_page' => -1,
										  'caller_get_posts'=> 1);
										$my_query = new WP_Query($args);
										if( $my_query->have_posts() ) {
										  while ($my_query->have_posts()) : $my_query->the_post(); ?>
										    <p><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></p>
										    <?php
										  endwhile;
										}
										wp_reset_query();  // Restore global post data stomped by the_post().
									?>

								</section>
								<footer class="article-footer">
									<p class="clearfix"><?php the_tags( '<span class="tags">' . __( 'Tags:', 'bonestheme' ) . '</span> ', ', ', '' ); ?></p>

								</footer>

								<?php comments_template(); ?>

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

						<?php get_sidebar(); ?>

				</div>

			</div>

<?php get_footer(); ?>
