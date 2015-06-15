<?php
/**
 * functions.php
 *
 * The theme's functions and definitions.
 */

/*------------------------------------*\
    Load jQuery
\*------------------------------------*/

if (!is_admin()) add_action("wp_enqueue_scripts", "my_jquery_enqueue", 11);
function my_jquery_enqueue() {
    wp_deregister_script('jquery');
    wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js", false, null);
    wp_enqueue_script('jquery');
}

/*------------------------------------*\
    Live Reload
\*------------------------------------*/

if (!is_admin()) add_action("init", "live_reload_wp", 11);
function live_reload_wp() {
    if (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1'))) {
        wp_register_script('livereload', 'http://localhost:35729/livereload.js?snipver=1', null, false, true);
        wp_enqueue_script('livereload');
    }
}

/*------------------------------------*\
    Define Constants
\*------------------------------------*/

define( 'THEMEROOT', get_stylesheet_directory_uri() );
define( 'IMAGES', THEMEROOT . '/images' );
define( 'SCRIPTS', THEMEROOT . '/js' );
define( 'FRAMEWORK', get_template_directory() . '/framework' );

/*------------------------------------*\
    Load Framework
\*------------------------------------*/

require_once( FRAMEWORK . '/init.php' );
require_once( FRAMEWORK . '/widgets/schema-address-widget.php' );
require_once( 'functions-cmb.php' ); // Load Custom Meta Boxes.


if ( ! function_exists( 'theme_setup' ) ) {
    function theme_setup() {

        $lang_dir = THEMEROOT . '/languages';
        load_theme_textdomain( 'grunt-theme', $lang_dir );
        /*------------------------------------*\
            Custom header
        \*------------------------------------*/

        add_theme_support( 'custom-header' );

        $defaults = array(
            'default-image'          => '',
            'random-default'         => false,
            'width'                  => 0,
            'height'                 => 0,
            'flex-height'            => false,
            'flex-width'             => false,
            'default-text-color'     => '',
            'header-text'            => true,
            'uploads'                => true,
            'wp-head-callback'       => '',
            'admin-head-callback'    => '',
            'admin-preview-callback' => '',
        );
        add_theme_support( 'custom-header', $defaults );
        /*------------------------------------*\
            Thumbnails
        \*------------------------------------*/

        add_theme_support( 'post-thumbnails', array( 'post', 'page', 'services' ) );

        if ( function_exists( 'add_theme_support' ) ) {
            add_theme_support( 'post-thumbnails' );
            set_post_thumbnail_size( 150, 150, true ); // default Post Thumbnail dimensions (cropped)
            // additional image sizes
        }
        add_theme_support( 'automatic-feed-links' );

        /*------------------------------------*\
            MENUS
        \*------------------------------------*/

        register_nav_menus(
            array(
                'main-menu' => __( 'Main Menu', 'alpha' ),
                'footer-menu' => __( 'Footer Menu', 'alpha' )
            )
        );
    }

    add_action( 'after_setup_theme', 'theme_setup' );
}

/*------------------------------------*\
    Add Woocommerce theme support
\*------------------------------------*/
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}

/*------------------------------------*\
    Pagination
\*------------------------------------*/

function pagination($pages = '', $range = 4)
{
    $showitems = ($range * 2)+1;

    global $paged;
    if(empty($paged)) $paged = 1;

    if($pages == '')
    {
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if(!$pages)
        {
            $pages = 1;
        }
    }

    if(1 != $pages)
    {
        echo "<div class=\"pagination\"><span>Page ".$paged." of ".$pages."</span>";
        if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; First</a>";
        if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Previous</a>";

        for ($i=1; $i <= $pages; $i++)
        {
            if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
            {
                echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
            }
        }

        if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">Next &rsaquo;</a>";
        if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>Last &raquo;</a>";
        echo "</div>\n";
    }
}

/*------------------------------------*\
    Excerpt / Content Limits
\*------------------------------------*/

function excerpt($limit) {
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    if (count($excerpt)>=$limit) {
        array_pop($excerpt);
        $excerpt = implode(" ",$excerpt).'...';
    } else {
        $excerpt = implode(" ",$excerpt);
    }
    $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
    return $excerpt;
}

function content($limit) {
    $content = explode(' ', get_the_content(), $limit);
    if (count($content)>=$limit) {
        array_pop($content);
        $content = implode(" ",$content).'...';
    } else {
        $content = implode(" ",$content);
    }
    $content = preg_replace('/[.+]/','', $content);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    return $content;
}

function title($limit) {
    $title = explode(' ', get_the_title(), $limit);
    if (count($title)>=$limit) {
        array_pop($title);
        $title = implode(" ",$title).'...';
    } else {
        $title = implode(" ",$title);
    }
    $title = preg_replace('/[.+]/','', $title);
    $title = apply_filters('the_title', $title);
    $title = str_replace(']]>', ']]&gt;', $title);
    return $title;
}

/*------------------------------------*\
    Widgets
\*------------------------------------*/

if ( ! function_exists( 'alpha_widget_init' ) ) {
    function alpha_widget_init() {
        if ( function_exists( 'register_sidebar' ) ) {

            register_sidebar(
                array(
                    'name' => __( 'Main Widget Area', 'alpha' ),
                    'id' => 'sidebar-1',
                    'description' => __( 'Appears on posts and pages.', 'alpha' ),
                    'before_widget' => '<div id="%1$s" class="widget %2$s">',
                    'after_widget' => '</div> <!-- end widget -->',
                    'before_title' => '<h5 class="widget-title">',
                    'after_title' => '</h5>',
                )
            );

        }
    }

    add_action( 'widgets_init', 'alpha_widget_init' );
}

/*------------------------------------*\
    Production Style / Script files
\*------------------------------------*/

function tresnicjs (){
    wp_enqueue_script( 'site', SCRIPTS . '/scripts.min.js', array('jquery'), 1.2, false);
}

add_action( 'wp_enqueue_scripts', 'tresnicjs' );


if ( ! function_exists( 'Wps_load_styles' ) ) {
    function Wps_load_styles() {
        wp_register_style('googleFonts', 'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,300,600,700');
        wp_enqueue_style( 'googleFonts');
        wp_enqueue_style( 'style-css', get_stylesheet_directory_uri() . '/style.css' , false, filemtime( get_stylesheet_directory() . '/style.css' ), 'all' );
    }

    add_action( 'wp_enqueue_scripts', 'Wps_load_styles' );
}



/*------------------------------------*\
    Custom Post Types
\*------------------------------------*/

// Creates Testimonials Custom Post Type
function sample_init() {
    $args = array(
        'label' => 'Sample CPT',
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'page',
        'hierarchical' => false,
        'rewrite' => array('slug'=>'sample'),
        'query_var' => true,
        'menu_icon' => 'dashicons-video-alt',
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail',
            'page-attributes',)
    );
    register_post_type( 'sample', $args );
}
add_action( 'init', 'sample_init' );


// hook into the init action and call testimonials_taxonomies when it fires
add_action( 'init', 'sample_taxonomies', 0 );

// create two taxonomies, genres and writers for the post type "book"
function sample_taxonomies() {


    // Add new taxonomy, NOT hierarchical (like tags)
    $labels = array(
        'name'                       => _x( 'Sample Tags', 'taxonomy general name' ),
        'singular_name'              => _x( 'Sample Tag', 'taxonomy singular name' ),
        'search_items'               => __( 'Search Tags' ),
        'popular_items'              => __( 'Popular Tags' ),
        'all_items'                  => __( 'All Tags' ),
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => __( 'Edit Tag' ),
        'update_item'                => __( 'Update Tag' ),
        'add_new_item'               => __( 'Add New Tag' ),
        'new_item_name'              => __( 'New Tag Name' ),
        'separate_items_with_commas' => __( 'Separate Tags with commas' ),
        'add_or_remove_items'        => __( 'Add or remove tag' ),
        'choose_from_most_used'      => __( 'Choose from the most used tag' ),
        'not_found'                  => __( 'No tag found.' ),
        'menu_name'                  => __( 'Sample Tags' ),
    );

    $args = array(
        'hierarchical'          => true,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'sample_tag' ),
    );

    register_taxonomy( 'sample_tag', 'sample', $args );
}

/*------------------------------------*\
    Favicons Galore! //cleaning up the header.php file
\*------------------------------------*/
function add_favicons ()
{
    echo
        '<link rel="apple-touch-icon-precomposed" sizes="57x57" href="' . get_bloginfo('template_directory') . '/favicon/apple-touch-icon-57x57.png" />',
    '<link rel="apple-touch-icon-precomposed" sizes="114x114" href="' . get_bloginfo('template_directory') . '/favicon/apple-touch-icon-114x114.png" />',
    '<link rel="apple-touch-icon-precomposed" sizes="72x72" href="' . get_bloginfo('template_directory') . '/favicon/apple-touch-icon-72x72.png" />',
    '<link rel="apple-touch-icon-precomposed" sizes="144x144" href="' . get_bloginfo('template_directory') . '/favicon/apple-touch-icon-144x144.png" />',
    '<link rel="apple-touch-icon-precomposed" sizes="60x60" href="' . get_bloginfo('template_directory') . '/favicon/applefavicon/-touch-icon-60x60.png" />',
    '<link rel="apple-touch-icon-precomposed" sizes="120x120" href="' . get_bloginfo('template_directory') . '/favicon/apple-touch-icon-120x120.png" />',
    '<link rel="apple-touch-icon-precomposed" sizes="76x76" href="' . get_bloginfo('template_directory') . '/favicon/apple-touch-icon-76x76.png" />',
    '<link rel="apple-touch-icon-precomposed" sizes="152x152" href="' . get_bloginfo('template_directory') . '/favicon/apple-touch-icon-152x152.png" />',
    '<link rel="icon" type="image/png" href="' . get_bloginfo('template_directory') . '/favicon/favicon-196x196.png" sizes="196x196" />',
    '<link rel="icon" type="image/png" href="' . get_bloginfo('template_directory') . '/favicon/favicon-96x96.png" sizes="96x96" />',
    '<link rel="icon" type="image/png" href="' . get_bloginfo('template_directory') . '/favicon/favicon-32x32.png" sizes="32x32" />',
    '<link rel="icon" type="image/png" href="' . get_bloginfo('template_directory') . '/favicon/favicon-16x16.png" sizes="16x16" />',
    '<link rel="icon" type="image/png" href="' . get_bloginfo('template_directory') . '/favicon/favicon-128.png" sizes="128x128" />',
    '<meta name="application-name" content="&nbsp;"/>',
    '<meta name="msapplication-TileColor" content="#FFFFFF" />',
    '<meta name="msapplication-TileImage" content="' . get_bloginfo('template_directory') . '/favicon/mstile-144x144.png" />',
    '<meta name="msapplication-square70x70logo" content="' . get_bloginfo('template_directory') . '/favicon/mstile-70x70.png" />',
    '<meta name="msapplication-square150x150logo" content="' . get_bloginfo('template_directory') . '/favicon/mstile-150x150.png" />',
    '<meta name="msapplication-wide310x150logo" content="' . get_bloginfo('template_directory') . '/favicon/mstile-310x150.png" />',
    '<meta name="msapplication-square310x310logo" content="' . get_bloginfo('template_directory') . '/favicon/mstile-310x310.png" />';
}


/*------------------------------------*\
    Breadcrumbs
\*------------------------------------*/

function the_breadcrumbs(){
    /* === OPTIONS === */
    $text['home']     = 'Home'; // text for the 'Home' link
    $text['category'] = 'Archive by Category "%s"'; // text for a category page
    $text['tax'] 	  = 'Archive for "%s"'; // text for a taxonomy page
    $text['search']   = 'Search Results for "%s" Query'; // text for a search results page
    $text['tag']      = 'Posts Tagged "%s"'; // text for a tag page
    $text['author']   = 'Articles Posted by %s'; // text for an author page
    $text['404']      = 'Error 404'; // text for the 404 page

    $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
    $showOnHome  = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
    $delimiter   = ' &raquo; '; // delimiter between crumbs
    $before      = '<span class="current">'; // tag before the current crumb
    $after       = '</span>'; // tag after the current crumb
    /* === END OF OPTIONS === */

    global $post;
    $homeLink = get_bloginfo('url') . '/';
    $linkBefore = '<span typeof="v:Breadcrumb">';
    $linkAfter = '</span>';
    $linkAttr = ' rel="v:url" property="v:title"';
    $link = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;

    if (is_home() || is_front_page()) {

        if ($showOnHome == 1) echo '<div id="crumbs"><a href="' . $homeLink . '">' . $text['home'] . '</a></div>';

    } else {

        echo '<div id="crumbs" xmlns:v="http://rdf.data-vocabulary.org/#">' . sprintf($link, $homeLink, $text['home']) . $delimiter;


        if ( is_category() ) {
            $thisCat = get_category(get_query_var('cat'), false);
            if ($thisCat->parent != 0) {
                $cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
                $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                echo $cats;
            }
            echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;

        } elseif( is_tax() ){
            $thisCat = get_category(get_query_var('cat'), false);
            if ($thisCat->parent != 0) {
                $cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
                $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                echo $cats;
            }
            echo $before . sprintf($text['tax'], single_cat_title('', false)) . $after;

        }elseif ( is_search() ) {
            echo $before . sprintf($text['search'], get_search_query()) . $after;

        } elseif ( is_day() ) {
            echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
            echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
            echo $before . get_the_time('d') . $after;

        } elseif ( is_month() ) {
            echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
            echo $before . get_the_time('F') . $after;

        } elseif ( is_year() ) {
            echo $before . get_the_time('Y') . $after;

        } elseif ( is_single() && !is_attachment() ) {
            if ( get_post_type() != 'post' ) {
                $post_type = get_post_type_object(get_post_type());
                $slug = $post_type->rewrite;
                printf($link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
                if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
            } else {
                $cat = get_the_category(); $cat = $cat[0];
                $cats = get_category_parents($cat, TRUE, $delimiter);
                if ($showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
                $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                echo $cats;
                if ($showCurrent == 1) echo $before . get_the_title() . $after;
            }

        } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
            $post_type = get_post_type_object(get_post_type());
            echo $before . $post_type->labels->singular_name . $after;

        } elseif ( is_attachment() ) {
            $parent = get_post($post->post_parent);
            $cat = get_the_category($parent->ID); $cat = $cat[0];
            $cats = get_category_parents($cat, TRUE, $delimiter);
            $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
            $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
            echo $cats;
            printf($link, get_permalink($parent), $parent->post_title);
            if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;

        } elseif ( is_page() && !$post->post_parent ) {
            if ($showCurrent == 1) echo $before . get_the_title() . $after;

        } elseif ( is_page() && $post->post_parent ) {
            $parent_id  = $post->post_parent;
            $breadcrumbs = array();
            while ($parent_id) {
                $page = get_page($parent_id);
                $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
                $parent_id  = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            for ($i = 0; $i < count($breadcrumbs); $i++) {
                echo $breadcrumbs[$i];
                if ($i != count($breadcrumbs)-1) echo $delimiter;
            }
            if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;

        } elseif ( is_tag() ) {
            echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;

        } elseif ( is_author() ) {
            global $author;
            $userdata = get_userdata($author);
            echo $before . sprintf($text['author'], $userdata->display_name) . $after;

        } elseif ( is_404() ) {
            echo $before . $text['404'] . $after;
        }

        if ( get_query_var('paged') ) {
            if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
            echo __('Page') . ' ' . get_query_var('paged');
            if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
        }

        echo '</div>';

    }
}

/*------------------------------------*\
    Mobile Menu Walker
\*------------------------------------*/

class My_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"dl-submenu\">\n";
    }
}

/*------------------------------------*\
    TinyMCE4 Custom Colors (under construction)
\*------------------------------------*/
function my_mce4_options($init) {
    $default_colours = '"000000", "Black",
                      "993300", "Burnt orange",
                      "333300", "Dark olive",
                      "003300", "Dark green",
                      "003366", "Dark azure",
                      "000080", "Navy Blue",
                      "333399", "Indigo",
                      "333333", "Very dark gray",
                      "800000", "Maroon",
                      "FF6600", "Orange",
                      "808000", "Olive",
                      "008000", "Green",
                      "008080", "Teal",
                      "0000FF", "Blue",
                      "666699", "Grayish blue",
                      "808080", "Gray",
                      "FF0000", "Red",
                      "FF9900", "Amber",
                      "99CC00", "Yellow green",
                      "339966", "Sea green",
                      "33CCCC", "Turquoise",
                      "3366FF", "Royal blue",
                      "800080", "Purple",
                      "999999", "Medium gray",
                      "FF00FF", "Magenta",
                      "FFCC00", "Gold",
                      "FFFF00", "Yellow",
                      "00FF00", "Lime",
                      "00FFFF", "Aqua",
                      "00CCFF", "Sky blue",
                      "993366", "Red violet",
                      "FFFFFF", "White",
                      "FF99CC", "Pink",
                      "FFCC99", "Peach",
                      "FFFF99", "Light yellow",
                      "CCFFCC", "Pale green",
                      "CCFFFF", "Pale cyan",
                      "99CCFF", "Light sky blue",
                      "CC99FF", "Plum"';

    $custom_colours ='"ED1C24", "Color 3 Name",
                      "7cdbc2", "Primary Color",
                      "636363", "Secondary Color"';

    // build colour grid default+custom colors
    $init['textcolor_map'] = '['.$default_colours.','.$custom_colours.']';

    // enable 6th row for custom colours in grid
    $init['textcolor_rows'] = 8;

    return $init;
}
add_filter('tiny_mce_before_init', 'my_mce4_options');
