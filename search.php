<?php
/**
 * search.php
 *
 * The template for displaying search results.
 */
?>

<?php get_header(); ?>
    <div class="container">
        <?php if ( have_posts() ) : ?>
            <div style="float:right;"><?php get_search_form(); ?></div>
            <div class="title">
                <h1><?php
                    printf( __( 'Search Results for "%s"', 'alpha' ), get_search_query() );
                    ?>
                </h1>
            </div>

            <?php while( have_posts() ) : the_post(); ?>

                <?php get_template_part( 'content', get_post_format() ); ?>
            <?php endwhile; ?>

            <nav id="nav-below">
                <?php if (function_exists("pagination")) {
                    pagination($additional_loop->max_num_pages);
                } ?>
            </nav><!-- #nav-below -->
        <?php else : ?>
            <div style="float:right;"><?php get_search_form(); ?></div>
            <div class="title">
                <h1><?php
                    printf( __( 'Search Results for "%s"', 'alpha' ), get_search_query() );
                    ?>
                </h1>
            </div>
            <p>
                <?php
                printf( __( 'No search results for "%s", please try again.', 'alpha' ), get_search_query() );
                ?>
            </p>
        <?php endif; ?>
    </div>

<?php get_footer(); ?>