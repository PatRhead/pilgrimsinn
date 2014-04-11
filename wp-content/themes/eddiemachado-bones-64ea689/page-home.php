<?php
/*
Template Name: Home Page
*/
?>

<?php get_header(); ?>

<div id="content">

	<div id="inner-content" class="wrap clearfix">

		<div id="main" class="twelvecol first clearfix" role="main">

			<?php echo do_shortcode("[metaslider id=84]");
			include('main-cta.php');

			//checks for http:// and watch? in video URL
			$video_url = get_field('video_video_area', $post->ID);
			$video_url_fixed = str_replace("https://", "", $video_url);
			$video_url_fixed = str_replace("http://", "", $video_url);
			$video_url_fixed = str_replace("/watch?v=", "/embed/", $video_url_fixed);
			?>
			<div id="what-do-we-do">
				<h1 class="main-title"><?php the_field('video_title', $post->ID); ?></h1>
				<iframe class="youtube-vid" width="420" height="315" src="//<?php echo $video_url_fixed ?>" frameborder="0" allowfullscreen></iframe>
				<h3 class="main-sub-title"><?php the_field('video_sub_title', $post->ID); ?></h3>
				<div class="vid-content"><?php the_field('video_content', $post->ID); ?></div>
				<br /><br />
				<br />

			</div>


			<div class="get-involved">


				<div class="col-left">
					<img class="sub-img" src="<?php the_field('left_resource_picture', $post->ID); ?>"></img>
					<h1><?php the_field('left_resource_title', $post->ID); ?></h1>
					<h3><?php the_field('left_resource_sub_title', $post->ID); ?></h3>
					<?php the_field('left_resource_content', $post->ID); ?>
				</div>
				<div class="col-right">
					<img class="sub-img" src="<?php the_field('right_resource_picture', $post->ID); ?>"></img>
					<h1><?php the_field('right_resource_title', $post->ID); ?></h1>
					<h3><?php the_field('right_resource_sub_title', $post->ID); ?></h3>
					<?php the_field('right_resource_content', $post->ID); ?>
				</div>
			</div>
			<div class="info-content">
				<div class="col-left">
					<h1>News and Updates</h1>
					<ul>
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
								<a target="_blank" href="<?php echo $update_info['link']; ?>"><li><?php echo $update_info['title']; ?></li></a>
								<br />
								<?php }
							} ?>
							</ul>
							<a href="http://spring2014.hiveu.me/pi/patrick/news-updates/">View All</a>
							</div>
							<div class="col-right">
								<h1>Upcoming Events</h1>
								<?php
								$shortcode = '';
								echo do_shortcode('[add_eventon show_et_ft_img="no" hide_past="no" ft_event_priority="yes" event_count="3" etc_override="yes"]'); ?>

							</div>
						</div>
						<section class="entry-content clearfix" itemprop="articleBody">
							<?php // the_content(); ?>
							<!-- Place somewhere in the <body> of your page -->
						</section>

						<footer class="article-footer">
						</footer>


					</article>

				</div>

			</div>

		</div>

		<?php get_footer(); ?>