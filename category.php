<?php
/**
 * category.php
 *
 * The template for displaying category pages.
 */
?>

<?php get_header(); ?>
    <div class="container">
        <?php if (function_exists('the_breadcrumbs')) the_breadcrumbs(); ?>
        <div class="section">
            <div class="main-content col span8-12">
                <?php if ( have_posts() ) : ?>
                    <?php printf( __( 'Category Archives for %s', 'alpha' ), single_cat_title( '', false ) ); ?>
                    <?php
                    // Show an optional category description.
                    if ( category_description() ) {
                        echo '<p>' . category_description() . '</p>';
                    }
                    ?>

                    <?php while( have_posts() ) : the_post(); ?>

                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <a href="<?php the_permalink();?>"><h2><?php the_title();?></h2></a>
                            <div class="meta">
                                Written by <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a> | <?php the_date();?> | <?php the_category( ', ');?>
                            </div>
                            <?php the_excerpt();?>
                            <p class="more"><a class="orange-btn" href="<?php get_permalink($post->ID);?>">Read More</a></p>

                        </article>
                    <?php endwhile; ?>

                    <?php comments_template(); ?>
                    <nav id="nav-below">
                        <?php if (function_exists("pagination")) {
                            pagination();
                        } ?>
                    </nav><!-- #nav-below -->
                <?php else : ?>
                    <?php get_template_part( 'content', 'none' ); ?>
                <?php endif; ?>
            </div> <!-- end main-content -->
            <div class="sidebar col span4-12">
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>