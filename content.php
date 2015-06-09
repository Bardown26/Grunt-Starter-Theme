<?php
/**
 * content.php
 *
 * The default template for displaying content.
 */
?>


<article id="post-<?php the_ID(); ?>" <?php post_class('post-padding'); ?>>
    <div class="blog-head"> <?php
        if ( is_single() ) : ?>
            <h2 style="margin:10px 0px;"><?php the_title(); ?></h2>
        <?php else : ?>
            <h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
        <?php endif; ?>
    </div> <!-- end entry-header -->

    <div class="entry-content">
        <p><?php the_content();?></p>
        <h3><a href="<?php the_permalink();?>" class="read-more">Full Details ></a></h3>
    </div>


    <?php
    // If we have a single page and the author bio exists, display it
    if ( is_single() && get_the_author_meta( 'description' ) ) {
        echo '<h2>' . __( 'Written by ', 'alpha' ) . get_the_author() . '</h2>';
        echo '<p>' . the_author_meta( 'description' ) . '</p>';
    }
    ?>
    </footer> <!-- end entry-footer -->
</article>