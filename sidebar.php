				<aside role="complementary" class="column large-4 medium-5 small-12">
					<?php if (is_active_sidebar('sidebar_default')): ?>
						<?php dynamic_sidebar('sidebar_default'); ?>
					<?php else : ?>
						<h4>Pages: </h4>
						<?php _frozen_navigation(); ?>
					<?php endif; ?>
				</aside>