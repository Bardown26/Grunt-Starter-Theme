<?php
/**
 * Created by PhpStorm.
 * User: andrewatieh
 * Date: 1/29/15
 * Time: 10:17 AM
 */
?>

<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div>
        <label class="screen-reader-text" for="s"><?php _x( 'Search for:', 'label' ); ?></label>
        <input type="text" placeholder="Search..." value="<?php echo get_search_query(); ?>" name="s" id="s" />
    </div>
</form>