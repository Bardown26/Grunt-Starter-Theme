<?php
/**
 * index.php
 *
 * Blog Page.
 */
?>

<?php get_header(); ?>
    <div class="container">
        <div class="section">
            <div class="col span8-12">
                <?php if ( have_posts() ) : while( have_posts() ) : the_post(); ?>
                    <a href="<?php the_permalink();?>"><?php the_title();?></a>
                    <?php the_content();?>

                <?php endwhile; ?>

                    <?php /* Display navigation to next/previous pages when applicable */ ?>

                    <?php if (  $wp_query->max_num_pages > 1 ) : ?>

                        <nav id="nav-below">
                            <?php if (function_exists("pagination")) {
                                pagination();
                            } ?>
                        </nav><!-- #nav-below -->

                    <?php endif; ?>


                <?php else : ?>
                    <?php get_template_part( 'content', 'none' ); ?>
                <?php endif; ?>

            </div>

            <div class="col span4-12">
                <?php get_search_form(); ?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>