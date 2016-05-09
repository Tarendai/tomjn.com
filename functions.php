<?php
/**
 * tomjn functions and definitions
 *
 * @package tomjn
 * @since tomjn 1.0
 */

require_once( 'inc/attr.php' );
/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since tomjn 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

if ( ! function_exists( 'tomjnsetup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which runs
	 * before the init hook. The init hook is too late for some features, such as indicating
	 * support post thumbnails.
	 *
	 * @since tomjn 1.0
	 */
	function tomjnsetup() {

		$attr = editor_attr::instance();

		/**
		 * Custom template tags for this theme.
		 */
		require_once( get_template_directory() . '/inc/template-tags.php' );

		remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
		remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.
		remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // prev link
		remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link
		remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // Display relational links for the posts adjacent to the current post.
		remove_action( 'wp_head', 'wp_generator' ); // Display the XHTML generator that is generated on the wp_head hook, WP version

		/**
		 * Make theme available for translation
		 * Translations can be filed in the /languages/ directory
		 * If you're building a theme based on tomjn, use a find and replace
		 * to change 'tomjn' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'tomjn', get_template_directory() . '/languages' );

		/**
		 * Add default posts and comments RSS feed links to head
		 */
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Enable support for Post Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );
		
		add_image_size( 'project-main', 512, 512, true );

		/**
		 * This theme uses wp_nav_menu() in one location.
		 */
		register_nav_menus(
			array(
				'primary' => __( 'Primary Menu', 'tomjn' )
			)
		);

		/**
		 * Add support for the Aside Post Formats
		 */
		add_theme_support( 'post-formats', array( 'aside' ) );

		if ( function_exists( 'register_template' ) ) {
			register_template( 'panelcat', array( 'post_types' => array(), 'taxonomies' => array( 'category' ) ) );
			register_template( 'twin-column-pages', array( 'post_types' => array( 'page', 'post' ) ) );

			register_template_sidebar(
				'Top Sidebar',
				'panelcat',
				array(
					'description' => 'Just a test',
					'before_widget' => '<aside id="%1$s" class="widget %2$s">',
					'after_widget' => "</aside>\n",
					'before_title' => '<h3 class="widgettitle">',
					'after_title' => "</h3>\n"
				)
			);
			register_template_sidebar(
				'Top Sidebar',
				'twin-column-pages',
				array(
					'description' => 'Just a test',
					'before_widget' => '<aside id="%1$s" class="widget %2$s">',
					'after_widget' => "</aside>\n",
					'before_title' => '<h3 class="widgettitle">',
					'after_title' => "</h3>\n"
				)
			);
			register_template_sidebar(
				'Left Sidebar',
				'twin-column-pages',
				array(
					'description' => 'Just a test',
					'before_widget' => '<aside id="%1$s" class="widget %2$s">',
					'after_widget' => "</aside>\n",
					'before_title' => '<h3 class="widgettitle">',
					'after_title' => "</h3>\n"
				)
			);

			register_template_sidebar(
				'Right Sidebar',
				'twin-column-pages',
				array(
					'description' => 'This is another sidebar',
					'before_widget' => '<aside id="%1$s" class="widget %2$s">',
					'after_widget' => "</aside>\n",
					'before_title' => '<h3 class="widgettitle">',
					'after_title' => "</h3>\n"
				)
			);
		}
	}
}
add_action( 'after_setup_theme', 'tomjnsetup' );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since tomjn 1.0
 */
function tomjnwidgets_init() {
	register_sidebar(
		array(
			'name' => __( 'Sidebar', 'tomjn' ),
			'id' => 'sidebar-1',
			'before_widget' => '<aside id="%1$s" class="grid__item  one-whole  lap-one-half  desk-one-third widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h1 class="widget-title">',
			'after_title' => '</h1>',
		)
	);
	
	register_sidebar(
		array(
			'name' => __( 'Top Home', 'tomjn' ),
			'description' => __( 'A full width area at the top of the homepage', 'tomjn' ),
			'id' => 'sidebar-home-top',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h1 class="widget-title">',
			'after_title' => '</h1>',
		)
	);
	
	register_sidebar(
		array(
			'name' => __( 'Left Home', 'tomjn' ),
			'description' => __( 'A half width area on the left of the homepage, appears above the right hand on mobiles', 'tomjn' ),
			'id' => 'sidebar-home-left',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h1 class="widget-title">',
			'after_title' => '</h1>',
		)
	);
	
	register_sidebar(
		array(
			'name' => __( 'Right Home', 'tomjn' ),
			'description' => __( 'A half width area on the right of the homepage, appears below the left hand on mobiles', 'tomjn' ),
			'id' => 'sidebar-home-right',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h1 class="widget-title">',
			'after_title' => '</h1>',
		)
	);
}
add_action( 'widgets_init', 'tomjnwidgets_init' );

/**
 * Enqueue scripts and styles
 */
function tomjnscripts() {
	wp_enqueue_style( 'lessstyle', get_template_directory_uri().'/style.less',array(), '7' );
	wp_enqueue_style( 'style', get_stylesheet_uri(), array(), '3' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'tomjnscripts' );

function filter_ptags_on_images( $content ) {
	$content = preg_replace( '/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content );
	// and iframe tags too
	$content = preg_replace( '/<p>\s*(<a .*>)?\s*(<iframe .*><\/iframe>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content );
	return $content;
}
add_filter( 'the_content', 'filter_ptags_on_images' );


add_action( 'admin_head-upload.php', 'wpse_59182_bigger_media_thumbs' );
function wpse_59182_bigger_media_thumbs() {
	?>
	<script type="text/javascript">
		jQuery(document).ready( function($) {
			$('img').each(function(){
				$(this).removeAttr('width').css('max-width','100%');
				$(this).removeAttr('height').css('max-height','100%');
			});
			$('.column-icon').css('width', '130px');
		});
	</script>
	<?php
}

if ( !function_exists( 'tomjn_typekit_code' ) ) {
	function tomjn_typekit_code() {
		?>
		<script src="//use.typekit.net/wtc2mfi.js"></script>
		<script >try{Typekit.load();}catch(e){}</script>
		<?php
	}
}
add_action( 'wp_head', 'tomjn_typekit_code' );

add_filter( 'mce_external_plugins', 'tomjn_mce_external_plugins' );
function tomjn_mce_external_plugins( $plugin_array ) {
	$plugin_array['typekit'] = get_template_directory_uri().'/typekit.tinymce.js';
	return $plugin_array;
}

add_editor_style( 'editor-style.less' );

// pass variables into all .less files
add_filter( 'less_vars', 'tomjn_less_vars', 10, 2 );
if ( !function_exists( 'tomjn_less_vars' ) ) {
	function tomjn_less_vars( $vars, $handle ) {
		// $handle is a reference to the handle used with wp_enqueue_style()
		$vars[ 'typekitfontstack' ] = '"quatro-slab", "Roboto Slab", "Crete Round", "Palatino Linotype", "Book Antiqua", Palatino, serif';
		return $vars;
	}
}

function add_favicon(){
	?><link rel="shortcut icon" type="image/png" href="<?php echo esc_url( home_url() ); ?>/favicon.png" /><?php
}
add_action( 'wp_head', 'add_favicon' );
add_action( 'admin_head', 'add_favicon' );


// Add Slideshare oEmbed
function add_oembed_slideshare(){
	wp_oembed_add_provider( 'http://www.slideshare.net/*', 'http://api.embed.ly/v1/api/oembed' );
}
add_action( 'init', 'add_oembed_slideshare' );

// Create a new filtering function that will add our where clause to the query
function password_post_filter( $where = '' ) {
	// Make sure this only applies to loops / feeds on the frontend
	if ( !is_single() && !is_page() && !is_admin() ) {
		// exclude password protected
		$where .= " AND post_password = ''";
	}
	return $where;
}
add_filter( 'posts_where', 'password_post_filter' );

if ( ! function_exists( 'shortcode_exists' ) ) {
	/**
	 * Check if a shortcode is registered in WordPress.
	 *
	 * Examples: shortcode_exists( 'caption' ) - will return true.
	 *           shortcode_exists( 'blah' )    - will return false.
	 */
	function shortcode_exists( $shortcode = false ) {
		global $shortcode_tags;

		if ( ! $shortcode )
			return false;

		if ( array_key_exists( $shortcode, $shortcode_tags ) )
			return true;

		return false;
	}
}

if ( function_exists( 'add_taxonomy_templating_support' ) ) {
	add_taxonomy_templating_support( 'category' );
}

function title_format() {
	return '%s';
}
add_filter( 'private_title_format', 'title_format' );
add_filter( 'protected_title_format', 'title_format' );

add_action( 'wp_enqueue_scripts', 'jk_load_dashicons' );
function jk_load_dashicons() {
	wp_enqueue_style( 'dashicons' );
}


add_filter( 'wp_title', 'tomjn_hack_wp_title_for_home' );
function tomjn_hack_wp_title_for_home( $title ) {
	if( empty( $title ) && ( is_home() || is_front_page() ) ) {
		return  get_bloginfo( 'name' );
	}
	return $title;
}


add_action( 'tomjn_footer_notes', 'tomjn_footer_notes' );
function tomjn_footer_notes() {
	?>
	<p>Content licensed as <a href="http://creativecommons.org/licenses/by-sa/3.0/" rel="license">cc-by-sa-3</a> with attribution required, <a href="https://twitter.com/tarendai" rel="me">twitter</a></p>
	<?php
}

function _tomjn_home_cancel_query( $query, \WP_Query $q ) {
    if ( !$q->is_admin() && !$q->is_feed() && $q->is_home() && $q->is_main_query() ) {
        $query = false;
	$q->set( 'fields', 'ids' );
    }
    return $query;
}
add_filter( 'posts_request', '_tomjn_home_cancel_query', 100, 2 );

function tomjn_get_the_term_list( $id, $taxonomy, $before, $sep, $after ) {
	$result = get_transient();
	if ( !$result ) {
		$result = get_the_term_list( $id, $taxonomy, $before, $sep, $after );
		if ( $result ) {
			set_transient( 'tomjn_get_the_term_list_'.$id.'_'.$taxonomy , $result, 60 * 60 * 24 );
		}
	}
	return $result;
}
