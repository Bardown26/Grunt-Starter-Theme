<!DOCTYPE html>
<!--[if IE 8]> <html <?php language_attributes(); ?> class="ie8"> <![endif]-->
<!--[if !IE]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <title><?php wp_title( '|', true, 'right' ); ?><?php bloginfo( 'name' ); ?></title>
    <meta name="description" content="<?php the_excerpt();?>">
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <!-- Favicon and Apple Icons -->
    <?php echo add_favicons();?>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header>
    <div class="container">
        <div class="col site-logo">
            <?php if (get_header_image() != '') {?>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                    <img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" />
                </a>
            <?php } else { ?>
                <div id="logo">
                    <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo get_bloginfo('name');?></a></h1>
                </div>
                <span><?php echo get_bloginfo ( 'description' );  ?></span>
            <?php } ?>
        </div>
        <div class="col span8-12">
            <nav class="main-nav" id="primary_nav_wrap">
                <?php wp_nav_menu( array( 'theme_location' => 'main-menu', 'container' => 'false', 'menu_id' => 'nav', 'menu_class' => 'menu','link_before' => '<span>', 'link_after' => '</span>') ); ?>
            </nav>
        </div>
    </div>
    <div class="mobile">
        <div id="dl-menu" class="dl-menuwrapper">
            <button class="dl-trigger"><i class="fa fa-bars"></i></button>
            <?php wp_nav_menu( array( 'theme_location' => 'main-menu', 'container' => false, 'menu_class' => 'dl-menu','walker' => new My_Walker_Nav_Menu() ) ); ?>
        </div>
    </div>
</header>