<?php require_once(CHILD_DIR . '/head.php'); ?>
	<body <?php body_class(); ?>>
		<section class="container">
			<header class="contain-to-grid">
				<div class="top-bar">
					<div class="row">
						<div class="title-area site-information small-6 medium-4 large-2 column">
							<a href="<?php print(home_url()); ?>">
								<span class="website"><?php bloginfo('name'); ?></span>
								<img src="<?php bloginfo('template_directory'); ?>/images/logo.png" alt="<?php bloginfo('name'); ?>" />
							</a>
						</div>
						<div class="pre-nav small-6 medium-8 large-10 column">
							<?php headerNavigation(); ?>
						</div>
					</div>
				</div>
				<div class="hero">
					<div class="row">
						<span class="description"><?php bloginfo('description'); ?></span>
					</div>			
				</div>
				<?php mainNavigation(); ?>
			</header>
			