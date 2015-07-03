<?php
	/**
	 * Child theme based on FrozenBones.
	 * 
	 * @author PxO Ink (http://pxoink.net)
	 * @uses Eddie Machado's bones
	 * @package bones
	 */

	//Declare definitions.
	define('CHILD_DIR', get_stylesheet_directory());
	define('PUBLIC_DIR', dirname(get_bloginfo('stylesheet_url')));
	
	//Initialize Frozen _frozen
	add_action('after_setup_theme', '_frozen_child', 16);
	
	//If the function exists.
	if (!function_exists('_frozen_child_queue')) {
		/**
		 * Queue styles and scripts.
		 */
		function	_frozen_child_queue() {
			//Declare variables.
			$styleDir	=	PUBLIC_DIR . "/css";
			$scriptDir	=	PUBLIC_DIR . "/js";
			
			//If this isn't the admin panel.
			if (!is_admin()) {
				//Get all CSS files.
				$css	=	preg_grep('/login\.css/', glob(sprintf("%s/css/*.{css}", CHILD_DIR), GLOB_BRACE), PREG_GREP_INVERT);
			
				//For each CSS file.
				foreach($css as $file) {
					//Get the filename.
					$fileName	=	preg_replace('/[^a-z0-9]+/', '-', strtolower($file));
					
					//Register the stylesheet.
					wp_register_style($fileName, "$styleDir/" . basename($file), array(), null, 'all');
					
					//Queue the stylesheet.
					wp_enqueue_style($fileName);
				}
			
				//Queue jQuery.
				wp_enqueue_script('jquery');
			
				//Get all JS files.
				$js		=	glob(sprintf("%s/js/*.{js}", CHILD_DIR), GLOB_BRACE);
			
				//For each JS file.
				foreach($js as $file) {
					//Get the filename.
					$fileName	=	preg_replace('/[^a-z0-9]+/', '-', strtolower($file));
					
					//Register scripts.
					wp_register_script($fileName, "$scriptDir/" . basename($file), array('jquery'), null, true);
					
					//Queue custom JS.
					wp_enqueue_script($fileName);
				}
			
			}
		}
	}
	
	//If the function exists.
	if (!function_exists('_frozen_child')) {
		/**
		 * FrozenBones initialization.
		 */
		function	_frozen_child() {
			//Queue styles and scripts.
			add_action('wp_enqueue_scripts', '_frozen_child_queue', 999);
		}
	}
	/**
	 * A foundation-based walker for navigation dropdown menues.
	 * 
	 * @author PxO Ink
	 * @package bones
	 * @since 4.2.2
	 */
	class Foundation_Walker extends Walker_Nav_Menu {
		/**
		 * Adjust the function for the walker dropdown to support foundation. 
		 * 
		 * @param unknown $output
		 * @param unknown $depth
		 */
		public function start_lvl(&$output, $depth ,$args = array()) {
			$indent = str_repeat("\t", $depth);
			$output .= "\n$indent<ul class=\"dropdown\">\n";
		}
		
		/**
		 * Adjust the function for the walker dropdown to support foundation. 
		 * 
		 * @since 4.2.2
		 * @param unknown $output
		 * @param object $item
		 * @param number $depth
		 * @param array $args
		 * @param unknown $id
		 */
		public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
			//Check the indent. 
			$indent = (!$depth) ? '' : str_repeat( "\t", $depth );
			
			//Check for classes.
			$classes	=	(!empty($item->classes)) ? (array) $item -> classes : array();
			
			//Add a class.
			$classes[]	=	'menu-item-' . $item -> ID;
			
			//If there are children.
			if ($args -> walker -> has_children) { 
				//Add a class.
				$classes[] = 'has-dropdown';
			}
		
			/**
			 * Filter the CSS class(es) applied to a menu item's list item element.
			 */
			$class_names	=	join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
			$class_names	=	(!$class_names) ? '' : ' class="' . esc_attr( $class_names ) . '"';
		
			/**
			 * Filter the ID applied to a menu item's list item element.
			 */
			$id	=	apply_filters('nav_menu_item_id', 'menu-item-'. $item -> ID, $item, $args, $depth);
			$id	=	(!$id) ? '' : ' id="' . esc_attr( $id ) . '"';
			
			//Set the attributes as an array.
			$atts	=	array();
			
			//Start the output.
			$output	.=	$indent . '<li' . $id . $class_names .'>';
			
			//Set the attributes.
			$atts['target']	=	(!empty($item->target))	? $item -> target	:	'';
			$atts['rel']	=	(!empty($item->xfn))		? $item -> xfn	:	'';
			$atts['href']	=	(!empty($item->url))		? $item -> url	:	'';
			
			//Based on the title information.
			if (!strcasecmp($item -> attr_title, 'label')) {
				//Set the atts.
				$atts['title']	=	'';
			}
		
			/**
			 * Filter the HTML attributes applied to a menu item's anchor element.
			 */
			$atts	=	apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
			
			//Attributes.
			$attributes	=	'';
			
			//For each attribute. 
			foreach ($atts as $attr => $value) {
				//If there's a value. 
				if (!empty($value)) {
					//Set the value.
					$value	=	('href' === $attr) ? esc_url($value) : esc_attr($value);
					$attributes	.=	' ' . $attr . '="' . $value . '"';
				}
			}
			
			//Based on the title information.
			if (strtolower($item -> attr_title) !== 'label') {
				//Build a normal anchor. 
				$item_output = $args -> before;
				$item_output .= '<a'. $attributes .'>';
				/** This filter is documented in wp-includes/post-template.php */
				$item_output .= $args -> link_before . apply_filters('the_title', $item -> title, $item -> ID) . $args -> link_after;
				$item_output .= '</a>';
				$item_output .= $args -> after;
			} else {
				//Build a label anchor.
				$item_output = $args -> before;
				$item_output .= '<label>';
				/** This filter is documented in wp-includes/post-template.php */
				$item_output .= $args -> link_before . apply_filters('the_title', $item -> title, $item -> ID) . $args -> link_after;
				$item_output .= '</label>';
				$item_output .= $args -> after;
			}
		
			/**
			 * Filter a menu item's starting output.
			 *
			 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
			 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
			 * no filter for modifying the opening and closing `<li>` for a menu item.
			 */
			$output	.=	apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
		}
	}
	
	/**
	 * Header navigation.
	 */
	function	headerNavigation() {
		//Output navigation.
		wp_nav_menu(array(
		'container' => false,
		'menu' => __('Header Navigation', 'bonestheme'),
		'menu_class' => 'nav-header right',
		'theme_location' => 'sub-nav',
		'before' => '',
		'after' => '',
		'link_before' => '',
		'link_after' => '',
		'items_wrap' => '<nav class="%1$s" role="navigation">
					<ul class="title-area">
						<li class="name"></li>
						<li class="toggle-topbar menu-icon">
							<a href="javascript:void(0)">
								<span>Tools</span>
							</a>
						</li>
					</ul>
					<section class="top-bar-section row">
						<ul class="%2$s">
							%3$s
						</ul>
					</section>
				</nav>',
		'depth' => 0, 
		'walker' => new Foundation_Walker(), 
		'fallback_cb' => '_frozen_wasteland'));
	}
	
	/**
	 * Main navigation.
	 */
	function	mainNavigation() {
		//Get the search value.
		$s	=	(!isset($_GET['s'])) ? null : $_GET['s'];
		
		//Output navigation.
		wp_nav_menu(array(
		'container' => false,
		'menu' => __('Main Navigation', 'bonestheme'),
		'menu_class' => 'left',
		'theme_location' => 'main-nav',
		'before' => '',
		'after' => '',
		'link_before' => '',
		'link_after' => '',
		'items_wrap' => '<nav class="%1$s top-bar" data-topbar role="navigation">
							<ul class="title-area">
								<li class="name"></li>
								<li class="toggle-topbar menu-icon">
									<a href="javascript:void(0)">
										<span>Menu</span>
									</a>
								</li>
							</ul>
							<section class="top-bar-section row">
								<ul class="%2$s column medium-8 small-12">
									%3$s
								</ul>
								<ul class="right column medium-4 small-12">
									<li class="has-form">
										<form role="search" method="get" action="' . home_url('/') . '" class="search row">
											<div class="nod">
												<label for="s">
													<span class="nod">Search</span>
												</label>
											</div>
											<div class="column small-8">
												<input id="s" name="s" type="text" value="' . $s . '" 
														placeholder="Search&hellip;" />
											</div>
											<div class="column small-4">
												<button type="submit" class="button">
													<span class="i-search"></span>
													<span class="nod">Go</span>
												</button>
											</div>
										</form>
									</li>
								</ul>
							</section>
						</nav>', 
		'depth' => 0, 
		'walker' => new Foundation_Walker(),
		'fallback_cb' => '_frozen_wasteland'));
	}
?>