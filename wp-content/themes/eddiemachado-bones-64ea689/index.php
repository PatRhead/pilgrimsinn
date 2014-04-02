<?php get_header(); ?>


<div id="content">

	<div id="inner-content" class="wrap clearfix">

		<div id="main" class="twelvecol first clearfix" role="main">

			<?php echo do_shortcode("[metaslider id=84]"); ?>

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
					$video_url_fixed = str_replace("https://", "", $video_url);
					$video_url_fixed = str_replace("http://", "", $video_url);
					$video_url_fixed = str_replace("/watch?v=", "/embed/", $video_url_fixed);
					?>

					<h1><?php echo $video_info['title']; ?></h1>
					<br />
					<h3><?php echo $video_info['sub_title']; ?></h3>
					<br />
					<?php echo $video_info['content']; ?>
					<br />
					<iframe width="420" height="315" src="//<?php echo $video_url_fixed ?>" frameborder="0" allowfullscreen></iframe>
					<hr />
					<?php }
				} ?>


				<?php $type = 'resources';

				$args=array(
					'post_type' => $type,
					'post_status' => 'publish',
					'posts_per_page' => -1
					);

				$resources = get_posts($args);

				if(count($resources)) {
					foreach($resources as $resource) {
						$resource_info = get_fields($resource->ID);

						?>
						<img src="<?php echo $resource_info['picture']; ?>"></img>
						<?php echo $resource_info['title']; ?>
						<br />
						<?php echo $resource_info['sub_title']; ?>
						<br />
						<?php echo $resource_info['content']; ?>
						<br />

						<?php }
					} ?>

					<?php
					$shortcode = '';
					echo do_shortcode('[add_eventon show_et_ft_img="no" hide_past="no" ft_event_priority="yes" event_count="3" month_incre="+1" fixed_month="3" fixed_year="2014"  etc_override="yes"]'); ?>


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