<?php if(get_theme_mod('ashad_display_share', 1)): ?>
    <section class="share">
        <h3>Share</h3>
        <a aria-label="Share on Twitter" href="https://twitter.com/intent/tweet?text=&quot;<?php echo get_the_excerpt() ?>&quot;%20<?php the_permalink(); ?>%20via%20&#64;<?php echo get_theme_mod('ashad_twitter') ?>&hashtags=<?php
                $my_tags = get_the_tags();
                if ( $my_tags ) {
                    foreach ( $my_tags as $tag ) {
                        $tag_names[] = $tag->name;
                    }
                    echo implode( ', ', $tag_names );
                }
            ?>"
        onclick="window.open(this.href, 'twitter-share', 'width=550,height=235');return false;" title="Share on Twitter">
            <svg class="icon icon-twitter"><use xlink:href="#icon-twitter"></use></svg>
        </a>
        <a aria-label="Share on Facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?php esc_url(the_permalink()); ?>"
        onclick="window.open(this.href, 'facebook-share','width=580,height=296');return false;" title="Share on Facebook">
            <svg class="icon icon-facebook"><use xlink:href="#icon-facebook"></use></svg>
        </a>
    </section>
<?php endif; ?>