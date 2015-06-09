<?php
/**
 * index.php
 *
 * Blog Page.
 */
?>

<?php get_header(); ?>
    <div class="container">
        <div id="container">
            <?php if ( have_posts() ) : while( have_posts() ) : the_post(); ?>
                <?php get_template_part( 'content', get_post_format() ); ?>
            <?php endwhile; ?>
        </div>
        <?php /* Display navigation to next/previous pages when applicable */ ?>

        <?php if (  $wp_query->max_num_pages > 1 ) : ?>

            <nav id="nav-below">
                <?php if (function_exists("pagination")) {
                    pagination($additional_loop->max_num_pages);
                } ?>
            </nav><!-- #nav-below -->

        <?php endif; ?>


        <?php else : ?>
            <?php get_template_part( 'content', 'none' ); ?>
        <?php endif; ?>
    </div>


<?php get_footer(); ?>