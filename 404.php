<?php
/**
 * 404.php
 *
 * The template for displaying 404 pages (Not Found).
 */
?>
<?php get_header(); ?>
    <div class="container not-found">
        <h1>Error 404 - Nothing Found</h1>

        <p>It looks like nothing was found here. Maybe try a search?</p>

        <?php get_search_form(); ?>
        <br />
    </div>
<?php get_footer(); ?>