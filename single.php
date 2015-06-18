<?php get_header(); ?>
<div class="container">
    <?php if (function_exists('the_breadcrumbs')) the_breadcrumbs(); ?>
    <div class="section">
        <div class="main-content col span8-12">

            <?php if ( have_posts() ) : while( have_posts() ) : the_post(); ?>
                <?php if ( has_post_thumbnail() ) {
                    echo '<div class="thumb">';
                    the_post_thumbnail('blog');
                    echo '</div>';
                } else { ?>

                <?php } ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h1><?php the_title();?></h1>
                    <div class="meta">
                        Written by <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a> | <?php the_time('F j, Y');?> | <?php the_category( ', ');?>
                    </div>
                    <?php the_content();?>
                    <?php the_tags();?>
                </article>
            <?php endwhile; ?>

                <?php /* Display navigation to next/previous pages when applicable */ ?>

                <?php if (  $wp_query->max_num_pages > 1 ) : ?>

                    <nav id="nav-below">
                        <?php if (function_exists("pagination")) {
                            pagination();
                        } ?>
                    </nav><!-- #nav-below -->

                <?php endif; ?>
                <?php comments_template(); ?>

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

