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
    $icon_code = imagecreatefrompng(get_stylesheet_directory() . '/assets/img/icon_code.png');

    //creating site icon(favicon) image object
    $site_icon = imagecreatefrompng(get_site_icon_url(150));
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

    $code_languages = get_the_terms($post_id, 'code_languages');
            
    if ($code_languages) {
        $language_id = $code_languages[0]->term_id;
        $language_name = wordwrap($code_languages[0]->name, 18);
        $language_image_id = get_term_meta( $language_id, 'code_languages-image-id', true );
        $language_image_url = wp_get_attachment_image_url( $language_image_id, 'language-thumb' );
        if ($language_image_url == '') {
            $language_image_url = get_default_ashad_language_thumbnail();
        }
    } else {
        $language_name = "Unspecified";
        $language_image_url = get_default_ashad_language_thumbnail();
    }
    function endsWith($string, $endString) {
        $len = strlen($endString);
        if ($len == 0) {
            return true;
        }
        return (substr($string, -$len) === $endString);
    }
    if(endsWith($language_image_url, "jpg") || endsWith($language_image_url, "jpeg")) {
        $language_image = imagecreatefromjpeg($language_image_url);
    } else if(endsWith($language_image_url, "png")) {
        $language_image = imagecreatefrompng($language_image_url);
    } else {
        $language_image = imagecreatefrompng(get_default_ashad_language_thumbnail());
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
    imagecopyresized($img, $language_image, 922, 80, 0, 0, 200, 200, 200, 200);

    //showing date icon and date
    imagecopy($img, $icon_calendar, 80, 450, 0, 0, 32, 32);
    imagettftext($img, 26, 0, 130, 478, $color_primary, $fontRegular, get_the_date('F j, Y', $post_id));
    
    //showing code icon language name
    imagecopy($img, $icon_code, 490, 450, 0, 0, 32, 32);
    imagettftext($img, 26, 0, 540, 478, $color_primary, $fontRegular, $language_name);

    //showing comments icon and count
    imagecopy($img, $icon_comments, 870, 450, 0, 0, 32, 32);
    imagettftext($img, 26, 0, 920, 478, $color_primary, $fontRegular, get_comments_number($post_id));

    //showing site icon
    imagecopyresized($img, $site_icon, 1070, 434, 0, 0, 64, 64, 150, 150);

    imagepng($img);
    imagedestroy($img);
?>