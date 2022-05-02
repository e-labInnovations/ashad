<section class="comments" id="comments">
    <h3>Comments</h3>
    <?php
        if ( post_password_required() ) {
            return;
        }

        if(have_comments()) {
            the_comments_navigation(); ?>

            <ol class="comment-list">
                <?php wp_list_comments(); ?>
            </ol><!-- .comment-list -->

        <?php
            the_comments_navigation();

            // If comments are closed and there are comments, let's leave a little note, shall we?
            if ( ! comments_open() ) {
                ?>
                <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'ashad' ); ?></p>
                <?php
            }
        } else {
            echo "Leave a Comment";
        }

        $comments_args = array(
            //Cancel Reply Text
            'cancel_reply_link' => __('<br /> Cancel reply', 'ashad'),
        );
        comment_form( $comments_args);
    ?>
</section>