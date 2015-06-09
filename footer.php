<?php
/**
 * footer.php
 *
 * The template for displaying the footer.
 */
?>
<footer>
    <div class="container">
        <p>&copy; <?php echo date( 'Y' ); ?>
            <a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a>
            <?php _e( 'All rights reserved.', 'alpha' ); ?>
        </p>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>