<?php
/* Functions and stuff for SPLOTpoint theme
   
   a friendly little child of Intergalactic
   
   mods by and blame go to http://cog.dog
*/


// ----- HALLO NEW THEME --------------------------------------------------------------

// run when this theme is activated
add_action('after_switch_theme', 'splotpoint_setup');

function splotpoint_setup () {
  
	// create special pages if they do not exist
	// backdate creation date 2 days just to make sure they do not end up future dated
	// which causes all kinds of disturbances in the force

  if (! get_page_by_path( 'all' ) ) {
  
  	// create the All Slides  page if it does not exist
  	$page_data = array(
  		'post_title' 	=> 'All The Slides',
  		'post_content'	=> '',
  		'post_name'		=> 'all',
  		'post_status'	=> 'publish',
  		'post_type'		=> 'page',
  		'post_author' 	=> 1,
  		'post_date' 	=> date('Y-m-d H:i:s', time() - 172800),
  		'page_template'	=> 'page-all.php',
  	);
  	
  	wp_insert_post( $page_data );
  
  }
}



// ----- SLIDES ARE THE NEW POSTS ----------------------------------------------------

// change name of "posts" to "slides" in the da shboard
add_action( 'admin_menu', 'splotpoint_change_post_label' );
add_action( 'init', 'splotpoint_change_post_object' );

function splotpoint_change_post_label() {
    global $menu;
    global $submenu;
    
    $daily_blank_thing = 'Slide';
    
    $menu[5][0] = $daily_blank_thing . 's';
    $submenu['edit.php'][5][0] = 'All ' . $daily_blank_thing . 's';
    $submenu['edit.php'][10][0] = 'Add ' . $daily_blank_thing;
    $submenu['edit.php'][15][0] = $daily_blank_thing .' Categories';
    $submenu['edit.php'][16][0] = $daily_blank_thing .' Tags';
    echo '';
}

function splotpoint_change_post_object() {

    $daily_blank_thing = 'Slide';

    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name =  $daily_blank_thing;
    $labels->singular_name =  $daily_blank_thing;
    $labels->add_new = 'Add ' . $daily_blank_thing;
    $labels->add_new_item = 'Add ' . $daily_blank_thing;
    $labels->edit_item = 'Edit ' . $daily_blank_thing;
    $labels->new_item =  $daily_blank_thing;
    $labels->view_item = 'View ' . $daily_blank_thing;
    $labels->search_items = 'Search ' . $daily_blank_thing;
    $labels->not_found = 'No ' . $daily_blank_thing . ' found';
    $labels->not_found_in_trash = 'No ' .  $daily_blank_thing . ' found in Trash';
    $labels->all_items = 'All ' . $daily_blank_thing;
    $labels->menu_name =  $daily_blank_thing;
    $labels->name_admin_bar =  $daily_blank_thing;
}

add_action('manage_posts_custom_column',  'splotpoint_columns_show_columns');

function splotpoint_columns_show_columns($name) {
    global $post;

    switch ($name) {
        case 'order':
            $views = $post->menu_order;
            echo $views;
            break;
    }
}



// ----- ORDERS TAKEN HERE ----------------------------------------------------

// add menu order to posts so we can order them up
function splotpoint_posts_order() {
    add_post_type_support( 'post', 'page-attributes' );
}

add_action( 'admin_init', 'splotpoint_posts_order' );



/* set previous / next post links to use menu order
    h/t https://1fix.io/blog/2014/09/09/get-right-previous_post_link-when-order-posts-by-menu_order/
*/

function my_previous_post_where() {

	global $post, $wpdb;

	return $wpdb->prepare( "WHERE p.menu_order < %s AND p.post_type = %s AND p.post_status = 'publish'", $post->menu_order, $post->post_type);
}
add_filter( 'get_previous_post_where', 'my_previous_post_where' );

function my_next_post_where() {

	global $post, $wpdb;

	return $wpdb->prepare( "WHERE p.menu_order > %s AND p.post_type = %s AND p.post_status = 'publish'", $post->menu_order, $post->post_type);
}
add_filter( 'get_next_post_where', 'my_next_post_where' );

function my_previous_post_sort() {

	return "ORDER BY p.menu_order desc LIMIT 1";
}
add_filter( 'get_previous_post_sort', 'my_previous_post_sort' );

function my_next_post_sort() {

	return "ORDER BY p.menu_order asc LIMIT 1";
}
add_filter( 'get_next_post_sort', 'my_next_post_sort' );



/* Sort posts in posts view by menu_order in ascending or descending order. */

// h/t http://wordpress.stackexchange.com/questions/66455/how-to-change-order-of-posts-in-admin
function custom_post_order($query){
    /* 
        Set post types.
        _builtin => true returns WordPress default post types. 
        _builtin => false returns custom registered post types. 
    */
    $post_types = get_post_types(array('_builtin' => true), 'names');
    /* The current post type. */
    $post_type = $query->get('post_type');
    /* Check post types. */
    if(in_array($post_type, $post_types)){
        /* Post Column: e.g. title */
        if($query->get('orderby') == ''){
            $query->set('orderby', 'menu_order');
        }
        /* Post Order: ASC / DESC */
        if($query->get('order') == ''){
            $query->set('order', 'ASC');
        }
    }
}

if(is_admin()){
    add_action('pre_get_posts', 'custom_post_order');
}


// organize the admin view; removed date / category, insert slide order columns
// h/t http://stackoverflow.com/questions/27602116/how-to-add-order-column-in-page-admin-wordpress


add_filter('manage_posts_columns', 'splotpoint_columns');

function splotpoint_columns($columns) {

	$splotpoint_columns = array(); 

	foreach( $columns as $key => $value) { 
		
		if ( $key != 'date' and $key != 'categories' ) $splotpoint_columns[$key] = $value; 
		if ( $key== 'title' ) { 
			$splotpoint_columns['order'] = ' Slide Order';
		} 
	}
	
    return $splotpoint_columns;
}

// ----- NAVIGATING THE WATERS ----------------------------------------------------

// set up next/previous navigation buttons to be simpler than parent them
if ( ! function_exists( 'splotpoint_post_nav' ) ) :

	function splotpoint_post_nav() {
		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous ) {
			return;
		}
		?>
		<nav class="navigation post-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Slide navigation', 'intergalactic' ); ?></h1>
			<div class="nav-links">
				<?php
					previous_post_link( '<div class="nav-previous">%link</div>', _x( '<span class="meta-nav">&larr;</span>', 'Previous post link', 'intergalactic' ) );
					next_post_link(     '<div class="nav-next">%link</div>',     _x( '<span class="meta-nav">&rarr;</span>', 'Next post link',     'intergalactic' ) );
				?>
			</div><!-- .nav-links -->
		</nav><!-- .navigation -->
		<?php
	}
endif;


// ----- I MET A METABOX   ----------------------------------------------------


// change title of the post order metabox
add_action('add_meta_boxes', 'splotpoint_change_meta_box_titles', 999);

function splotpoint_change_meta_box_titles() {
    global $wp_meta_boxes; // array of defined meta boxes
    // cycle through the array, change the titles you want

    $wp_meta_boxes['post']['side']['core']['pageparentdiv']['title']= 'Slide Attributes';
}


// ----- CUSTOM JOBS DONE HERE   ----------------------------------------------

//  Customizer settings to allow editing of a front quote, customizing the footer

add_action( 'customize_register', 'splotpoint_register_theme_customizer' );

// register custom customizer stuff

function splotpoint_register_theme_customizer( $wp_customize ) {

	// add the section to contain the settings
	$wp_customize->add_section( 'slide_buttons' , array(
		'title' =>  'SPLOTpoint Prettify',
	) );
	


	// add section for custom logo
	// ----- h/t https://kwight.ca/2012/12/02/adding-a-logo-uploader-to-your-wordpress-site-with-the-theme-customizer/

	// Add setting for footer
	$wp_customize->add_setting( 'site_title_background', array(
		 'default'           => __( '', 'intergalactic' ),
		 'type' => 'option', 
		  'capability' =>  'edit_theme_options'
	) );     

	
	// add controller for logo
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'slide_title_background', array(
		'label'    => __( 'Slide Title Background Image', 'intergalactic' ),
		'section'  => 'slide_buttons',
		'settings' => 'site_title_background',
) ) );


	// title  color 
	$btncolors[] = array(
		'slug'=>'site_title_color', 
		'default' => '#000',
		'label' => 'Title Text Color'
	);
 
 	// title  color 
	$btncolors[] = array(
		'slug'=>'site_description_color', 
		'default' => '#29215A',
		'label' => 'Title Tagline Color'
	);
	
	
	// button  color 
	$btncolors[] = array(
		'slug'=>'button_color', 
		'default' => '#fff',
		'label' => 'Button Color'
	);
 
	// icon color
	$btncolors[] = array(
		'slug'=>'icon_color', 
		'default' => '#000',
		'label' => 'Button Icon Color'
	);
	
	// add the settings and controls for each color
	foreach( $btncolors as $btncolor ) {
 
		// SETTINGS
		$wp_customize->add_setting(
			$btncolor['slug'], array(
				'default' => $btncolor['default'],
				'type' => 'option', 
				'capability' =>  'edit_theme_options'
			)
		);
		
		// CONTROLS
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$btncolor['slug'], 
				array('label' => $btncolor['label'], 
				'section' => 'slide_buttons',
				'settings' => $btncolor['slug'])
			)
		);

     } // foreach


	// Add setting for footer
	$wp_customize->add_setting( 'button_roundness', array(
		 'default'           => __( '0', 'intergalactic' ),
		 'type' => 'option', 
		  'capability' =>  'edit_theme_options'
	) );     
     
     $wp_customize->add_control( 'button_roundness', array(
		  'type' => 'range',
		  'section' => 'slide_buttons',
		  'label' => __( 'Button Corner Roundness' ),
		  'description' => __( 'From square to curved' ),
		  'input_attrs' => array(
			'min' => 0,
			'max' => 90,
			'step' => 5,
		  ),
		) );
 
 
 	// Add setting for footer
	$wp_customize->add_setting( 'footer_text_block', array(
		 'default'           => __( get_bloginfo( 'name' ) . ' : ' . get_bloginfo( 'description' ) , 'intergalactic' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	
	// Add control for footer
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'custom_footer_text',
		    array(
		        'label'    => __( 'Slide Show Title for Footer', 'intergalactic' ),
		        'section'  => 'slide_buttons',
		        'settings' => 'footer_text_block',
		        'type'     => 'text'
		    )
	    )
	);

    
  	// Sanitize text
	function sanitize_text( $text ) {
	    return sanitize_text_field( $text );
	}
    
}

function splotpoint_footer_text() {
	 if ( get_theme_mod( 'footer_text_block') != "" ) {
	 	echo get_theme_mod( 'footer_text_block');
	 }	else {
	 	echo get_bloginfo( 'name' ) . ' : ' . get_bloginfo( 'description' );
	 }
}


function splotpoint_backstretch() {
	// Add to footer the jquery command to backstretch the background image

	$site_title_background = get_option( 'site_title_background' );
	
	if ( is_page() or is_home() and $site_title_background ) {
		echo 
'<script>
	jQuery("#masthead").backstretch("' .$site_title_background . '");
</script>';
	}
}

function splotpoint_customize_prettify() {

	// site title color
	$site_title_color= get_option( 'site_title_color' );
	
	// site description color
	$site_description_color= get_option( 'site_description_color' );

	// button color
	$button_color = get_option( 'button_color' );
 
	// icon color
	$icon_color = get_option( 'icon_color' ); 
	
	// button roundness
	$button_roundness = get_option( 'button_roundness' ); 
	
	// styling! 
	?>
	<style>
	.site-title a {color:<?php echo $site_title_color; ?>;}
	.site-description {color:<?php echo $site_description_color; ?>;}
	.post-navigation .nav-previous a, .post-navigation .nav-next a, .start-slides a {
		background-color:<?php echo $button_color; ?>;
		border-radius: <?php echo $button_roundness; ?>px;
	}	
	.splotpoint-footer a:hover {color:<?php echo $button_color; ?>;}	
	span.meta-nav, .start-slides a {color:<?php echo $icon_color; ?>;}
	</style>
	 
	<?php
}
add_action( 'wp_head', 'splotpoint_customize_prettify' );


// enqueue the jQuery Backstretch plugin

function splotpoint_scripts() {

	// suit up the parent styles
    $parent_style = 'intergalactic-style'; 
    
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    
    // now the kids
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
	
	// custom jquery down in the footer you go
	wp_register_script( 'splotpoint-backstretch' , get_stylesheet_directory_uri() . '/js/jquery.backstretch.min.js', array( 'jquery' ));
	wp_enqueue_script( 'splotpoint-backstretch' );

	// custom splotpoint jquery
	wp_register_script( 'splotpoint' , get_stylesheet_directory_uri() . '/js/jquery.splotpoint.js', array( 'jquery' ));
	wp_enqueue_script( 'splotpoint' );

}

add_action( 'wp_enqueue_scripts', 'splotpoint_scripts' );


# -----------------------------------------------------------------
# shortcodes
# -----------------------------------------------------------------

// so they work in widgets
add_filter('widget_text', 'do_shortcode');

// generate a numbered list of slides
add_shortcode("startbutton", "splotpoint_startbutton");  

function splotpoint_startbutton( $atts ) {  
 	
 	// default is to list all slides, but they can be called to start at specified slide
 	//    and/or spescified number of slides
 	extract( shortcode_atts( array( "title" => "Start", "start" => 0), $atts ) );  

	// WP_Query arguments
	$args = array(
		'post_type'              => array( 'post' ),
		'post_status'            => array( 'publish' ),
		'posts_per_page'         => 1,
		'order'                  => 'ASC',
		'orderby'                => 'menu_order',
	);
	
	if ( $start > 0 ) $args['offset'] = $start - 1;

	// The Query
	$slide_query = new WP_Query( $args );
	
	// The Loop
	if ( $slide_query->have_posts() ) {
		$out = '<div class="start-slides">';
		while ( $slide_query->have_posts() ) {
			$slide_query->the_post();
			$out.= "\t" . '<a href="' . get_permalink() . '">'  . $title . "</a>\n";
		}
		$out.= '</div>';
		/* Restore original Post Data */
		wp_reset_postdata();
	} else {
		$out = '<p>No slides found.</p>';
	}
	
	return ( $out );
}

// generate a numbered list of slides
add_shortcode("slidelist", "splotpoint_slidelist");  

function splotpoint_slidelist( $atts ) {  
 	
 	// default is to list all slides, but they can be called to start at specified slide
 	//    and/or spescified number of slides
 	extract( shortcode_atts( array( "count" => -1, "offset" => 0 ), $atts ) );  

	// WP_Query arguments
	$args = array(
		'post_type'              => array( 'post' ),
		'post_status'            => array( 'publish' ),
		'posts_per_page'         => $count,
		'offset'                 => $offset,
		'order'                  => 'ASC',
		'orderby'                => 'menu_order',
	);

	// The Query
	$slide_query = new WP_Query( $args );
	
	// The Loop
	if ( $slide_query->have_posts() ) {
		$out = '<ol>';
		while ( $slide_query->have_posts() ) {
			$slide_query->the_post();
			$out.= "\t" . '<li><a href="' . get_permalink() . '">'  . get_the_title() . "</a></li>\n";
		}
		$out.= '</ol>';
		/* Restore original Post Data */
		wp_reset_postdata();
	} else {
		$out = '<p>No slides found.</p>';
	}
	
	return ( $out );
}

# -----------------------------------------------------------------
# login stuff
# -----------------------------------------------------------------

// Add custom logo to entry screen... because we can
// While we are at it, use CSS to hide the back to blog and retried password links
add_action( 'login_enqueue_scripts', 'my_login_logo' );

function my_login_logo() { ?>
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/site-login-logo.png);
            padding-bottom: 30px;
        }    
	#backtoblog {display:none;}
	#nav {display:none;}
    </style>
<?php }


// Make logo link points to blog, not Wordpress.org Change Dat
// -- h/t http://www.sitepoint.com/design-a-stylized-custom-wordpress-login-screen/

add_filter( 'login_headerurl', 'login_link' );

function login_link( $url ) {
	return get_bloginfo( 'url' );
}

?>