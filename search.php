<?php get_header(); ?>
<?php
	//Declare global variables. 
	global $wp_query;
	
	//Declare variables. 
	$total	=	$wp_query -> found_posts;
	$total	=	($total !== 1) ? __("$total results found", 'bones-theme') : __("$total result found", 'bones-theme');
	$header	=	(!isset($_GET['s'])) ? "$total." : "$total " . __(sprintf("searching for <em>%s</em>.", 
			stripslashes($_GET['s'])), 'bones-theme');
?>
			<section class="page row">
				<section class="column large-8 medium-7 small-12">	
					<header>
						<h1><?php print($header); ?></h1>
					</header>
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						<article id="post-<?php the_ID(); ?>" role="article" class="content">
							<header>
								<h3>
									<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
										<?php the_title(); ?>
									</a>
								</h3>
								<p class="card">
									<?php 
										printf(_('Posted <time datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span>.'), 
										get_the_time('Y-m-j'), 
										get_the_time(get_option('date_format')), 
										_frozen_get_the_author_posts_link());
									?>
								</p>
							</header>
							<section class="content">
								<?php the_excerpt(); ?>
							</section>
							<?php if (strlen(get_the_category_list()) > 1 || has_tag()) { ?>
								<footer>
									<section>
										<?php if (strlen(get_the_category_list()) > 1) { ?>
											<p class="cats"><?php printf(__('Filed under %s.'), get_the_category_list(', ')); ?></p>
										<?php } ?>
										<?php if (has_tag()) { ?>
											<p class="tags">
												<?php 
													the_tags(sprintf('<span class="tags-title">%s</span> ', __( 'Tags:', 'bonestheme' )), 
													', ', ''); 
												?>
											</p>
										<?php } ?>
									</section>
								</footer>
							<?php } ?>
						</article>
					<?php endwhile; else : ?>
						<section class="no-search-results">
							<?php _frozen_not_found('Sorry, no search results were found.'); ?>
						</section>
					<?php endif; ?>
					<?php _frozen_page_navi(); ?>
				</section>
				<footer>
					<?php get_sidebar(); ?>
				</footer>
			</section>
<?php get_footer(); ?>