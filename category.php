<?php
/**
 * category.php
 *
 * The template for displaying category pages.
 */
?>

<?php get_header(); ?>
    <div class="container">
        <div class="col span8-12">
            <?php if ( have_posts() ) : ?>

                <?php
                printf( __( 'Category Archives for %s', 'alpha' ), single_cat_title( '', false ) );
                ?>


                <?php
                // Show an optional category description.
                if ( category_description() ) {
                    echo '<p>' . category_description() . '</p>';
                }
                ?>

                <?php while( have_posts() ) : the_post(); ?>

                    <?php get_template_part( 'content', get_post_format() ); ?>

                <?php endwhile; ?>


                <nav id="nav-below">
                    <?php if (function_exists("pagination")) {
                        pagination($additional_loop->max_num_pages);
                    } ?>
                </nav><!-- #nav-below -->
            <?php else : ?>
                <?php get_template_part( 'content', 'none' ); ?>
            <?php endif; ?>
        </div> <!-- end main-content -->
        <div class="col span4-12">
            <?php get_sidebar(); ?>
        </div>
    </div>
<?php get_footer(); ?>