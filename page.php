<?php
/**
 * page.php
 *
 * The template for displaying all pages.
 */
?>

<?php get_header(); ?>
    <div class="container">
        <div class="col span8-12">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <div class="title">
                    <h2><?php the_title(); ?></h2>
                </div>
                <?php the_content(); ?>

            <?php endwhile; else : ?>
            <?php endif; ?>
        </div>
        <div class="col span4-12">
            <?php get_search_form(); ?>
            <?php get_sidebar(); ?>
        </div>
    </div>

<?php get_footer(); ?>