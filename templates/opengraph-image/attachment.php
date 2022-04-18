<?php
    //setting content type as png
    header ('Content-Type: image/png');
    //create image object
    $img = imagecreatetruecolor(1200, 600)
          or die('Cannot Initialize new GD image stream');

    //Colors
    $background_color = imagecolorallocate($img, 255, 255, 255);
    $color_primary = imagecolorallocate($img, 50, 50, 50);
    $color_secondary = imagecolorallocate($img, 100, 100, 100);
    $post_id = get_query_var('ashad-thumbnail');

    //setting background color
    imagefill($img, 0, 0, $background_color);

    //getting author name using author_id
    $author_id = get_post_field ('post_author', $post_id);
    $display_name = get_the_author_meta( 'display_name' , $author_id );

    // $text = "Post Id: " . get_query_var( 'ashad-thumbnail' ) . get_comments_number($post_id);
    // imagestring($img, 5, 10, 10, $text, $color_primary);

    //loading ttf fonts
    $fontSemiBold = get_stylesheet_directory() . '/assets/fonts/TitilliumWeb-SemiBold.ttf';
    $fontRegular = get_stylesheet_directory() . '/assets/fonts/TitilliumWeb-Regular.ttf';

    //creating icon image objects
    $icon_calendar = imagecreatefrompng(get_stylesheet_directory() . '/assets/img/icon_calendar.png');
    $icon_comments = imagecreatefrompng(get_stylesheet_directory() . '/assets/img/icon_comment.png');

    //creating site icon(favicon) image object
    $site_icon = imagecreatefrompng(get_site_icon_url(200));
    //getting title
    $title = get_the_title(get_query_var( 'ashad-thumbnail' )) ? get_the_title($post_id) : 'Error';
    
    if(strlen($title) > 21) {
        $titleArray = explode("\n", wordwrap( $title, 26));
        $titleL1 = $titleArray[0];
        if($titleArray[1]) {
            if($titleArray[2]) {
                $titleL2 = $titleArray[1] . '...';
            } else {
                $titleL2 = $titleArray[1];
            }
        } else {
            $titleL2 = flase;
        }
    } else {
        $titleL1 = $title;
    }

    $fsize = 48;
    //showing title line 1 and 2
    imagettftext($img, $fsize, 0, 80, 140, $color_primary, $fontSemiBold, $titleL1);
    if($titleL2) {
        imagettftext($img, $fsize, 0, 80, 210, $color_primary, $fontSemiBold, $titleL2);
    }

    //showing author name
    if($display_name) {
        imagettftext($img, 26, 0, 80, 295, $color_secondary, $fontRegular, 'By ' . $display_name);
    }
    
    //showing site_icon
    imagecopyresized($img, $site_icon, 922, 80, 0, 0, 200, 200, 200, 200);

    //showing date icon and date
    imagecopy($img, $icon_calendar, 80, 450, 0, 0, 32, 32);
    imagettftext($img, 26, 0, 130, 478, $color_primary, $fontRegular, get_the_date('F j, Y', $post_id));
    
    //showing a circle and post type label
    imagearc($img, 550, 465, 32, 32, 0, 360, $color_primary);
    imagettftext($img, 26, 0, 580, 478, $color_primary, $fontRegular, get_post_type_object(get_post_type($post_id))->labels->singular_name);

    //showing comments icon and count
    imagecopy($img, $icon_comments, 900, 450, 0, 0, 32, 32);
    imagettftext($img, 26, 0, 950, 478, $color_primary, $fontRegular, get_comments_number($post_id));

    imagepng($img);
    imagedestroy($img);
?>