<?php get_header(); ?>
			<section class="page row">
				<section class="column large-8 medium-7 small-12">
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						<header>
							<?php _frozen_breadcrumbs(); ?>
						</header>
						<section id="page-<?php the_ID(); ?>" class="content">
							<header>
								<h1><?php _e('404: Not Found', 'bonestheme'); ?></h1>
							</header>
							<section class="content">
								<p><?php _e('This post does not exist. Please try the following: ', 'bonestheme'); ?></p>
								<ul>
									<li><?php _e('Double check the address for syntax errors.', 'bonestheme'); ?></li>
									<li><?php _e('Ensure that your cache is refreshed.', 'bonestheme'); ?></li>
									<li><?php _e('Use the search form below:', 'bonestheme'); ?></li>
								</ul>
								<?php get_search_form(); ?>
							</section>
							<footer>
								<p><?php _e('Still can\'t find what you\'re looking for? Return to the', 'bonestheme'); ?> <a href="<?php print(home_url()); ?>"><?php _e('homepage', 'bonestheme'); ?></a>.
							</footer>
						</section>
					<?php endwhile; else : ?>
						<section id="page-not-found">
							<?php _frozen_not_found(); ?>
						</section>
					<?php endif; ?>
					<footer>
						<?php _frozen_page_navi(); ?>
					</footer>
				</section>
				<?php get_sidebar(); ?>
			</section>
<?php get_footer(); ?>