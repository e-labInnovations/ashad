<?php
// add the ajax fetch js
add_action( 'wp_footer', 'ajax_fetch' );
function ajax_fetch() {
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<?php
}

// the ajax function
function data_fetch(){
    $the_query = new WP_Query( array( 'posts_per_page' => -1, 's' => esc_attr( $_POST['keyword'] ), 'post_type' => 'post' ) );
    if( $the_query->have_posts() ) :
        while( $the_query->have_posts() ): $the_query->the_post(); ?>
            <li>
                <article>
                    <a href="<?php echo esc_url( post_permalink() ); ?>">
                        <span class="entry-category"><?php $category = get_the_category(); echo $category? $category[0]->cat_name : ''; ?></span> 
                        <?php the_title();?>
                        <span class="entry-date">
                            <time datetime="<?php the_date();?>"><?php the_date();?></time>
                        </span>
                    </a>
                </article>
            </li>

        <?php endwhile;
        wp_reset_postdata();  
    endif;

    die();
}
add_action('wp_ajax_data_fetch' , 'data_fetch');
add_action('wp_ajax_nopriv_data_fetch','data_fetch');