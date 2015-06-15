<?php
/**
 * search.php
 *
 * The template for displaying search results.
 */
?>

<?php get_header(); ?>
    <div class="container">
        <div class="section">
            <div class="col span8-12">
        <?php if ( have_posts() ) : ?>
            <div class="title">
                <h1><?php
                    printf( __( 'Search Results for "%s"', 'alpha' ), get_search_query() );
                    ?>
                </h1>
            </div>

            <?php while( have_posts() ) : the_post(); ?>

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

            <nav id="nav-below">
                <?php if (function_exists("pagination")) {
                    pagination();
                } ?>
            </nav><!-- #nav-below -->
            </div>
            <div class="col span4-12">
                <?php get_search_form();?>
                <?php get_sidebar();?>
            </div>
        </div>
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