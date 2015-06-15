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
            <div class="main-content col span8-12">
                <?php if ( have_posts() ) : while( have_posts() ) : the_post(); ?>
                    <?php if ( has_post_thumbnail() ) {
                        the_post_thumbnail('blog');
                    }
                    else {
                        echo '<img style="display:none;" src="' . get_bloginfo( 'stylesheet_directory' ) . '/images/thumbnail-default.jpg" />';
                    }
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                        <a href="<?php the_permalink();?>"><h2><?php the_title();?></h2></a>
                        <div class="meta">
                            Written by <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a> | <?php the_date();?> | <?php the_category( ', ');?>
                        </div>
                        <?php the_excerpt();?>
                        <p class="more"><a class="orange-btn" href="<?php the_permalink();?>">Read More</a></p>

                    </article>
                <?php endwhile; ?>

                    <?php /* Display navigation to next/previous pages when applicable */ ?>

                    <?php if (  $wp_query->max_num_pages > 1 ) : ?>

                        <nav id="nav-below">
                            <?php if (function_exists("pagination")) {
                                pagination();
                            } ?>
                        </nav><!-- #nav-below -->
                        <?php comments_template(); ?>
                    <?php endif; ?>


                <?php else : ?>
                    <?php get_template_part( 'content', 'none' ); ?>
                <?php endif; ?>
            </div>
            <div class="sidebar col span4-12">
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>