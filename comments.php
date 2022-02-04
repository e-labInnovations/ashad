<section class="comments" id="comments">
    <h3>Comments</h3>
    <?php
        if ( post_password_required() ) {
            return;
        }

        if(have_comments()) {
    ?>
        

        <?php the_comments_navigation(); ?>

        <ol class="comment-list">
            <?php
            wp_list_comments();
            ?>
        </ol><!-- .comment-list -->

        <?php
        the_comments_navigation();

        // If comments are closed and there are comments, let's leave a little note, shall we?
        if ( ! comments_open() ) :
            ?>
            <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'ashad' ); ?></p>
            <?php
        endif;
    ?>
    <?php
        } else {
            echo "Leave a Comment";
        }
    ?>
    <?php comment_form(); ?>
</section>