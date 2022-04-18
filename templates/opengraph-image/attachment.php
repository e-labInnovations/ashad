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
    $icon_file = imagecreatefrompng(get_stylesheet_directory() . '/assets/img/icon_file.png');
    $icon_size = imagecreatefrompng(get_stylesheet_directory() . '/assets/img/icon_size.png');

    //creating site icon(favicon) image object
    $site_icon = imagecreatefrompng(get_site_icon_url(200));
    //getting file extension
    $file_extension = strtoupper(wp_check_filetype(get_attached_file($post_id))['ext']);
    //getting file size
    $file_size = size_format(filesize(get_attached_file($post_id)));

    $file_icon = wp_get_attachment_image_src($post_id, 's512', true)[0];
    $file_512 = wp_get_attachment_image_src($post_id, 's512', true)[1] == 512?true:false;
    $file_ext = wp_check_filetype($file_icon)['ext'];

    if(!$file_512) {
        if(str_contains($file_icon, 'wp-includes/images/media/archive.png')){
            $file_icon = get_template_directory_uri() . '/assets/img/file/archive.png';
        } else if(str_contains($file_icon, 'wp-includes/images/media/audio.png')){
            $file_icon = get_template_directory_uri() . '/assets/img/file/audio.png';
        } else if(str_contains($file_icon, 'wp-includes/images/media/code.png')){
            $file_icon = get_template_directory_uri() . '/assets/img/file/code.png';
        } else if(str_contains($file_icon, 'wp-includes/images/media/default.png')){
            $file_icon = get_template_directory_uri() . '/assets/img/file/default.png';
        } else if(str_contains($file_icon, 'wp-includes/images/media/document.png')){
            $file_icon = get_template_directory_uri() . '/assets/img/file/document.png';
        } else if(str_contains($file_icon, 'wp-includes/images/media/interactive.png')){
            $file_icon = get_template_directory_uri() . '/assets/img/file/interactive.png';
        } else if(str_contains($file_icon, 'wp-includes/images/media/spreadsheet.png')){
            $file_icon = get_template_directory_uri() . '/assets/img/file/spreadsheet.png';
        } else if(str_contains($file_icon, 'wp-includes/images/media/text.png')){
            $file_icon = get_template_directory_uri() . '/assets/img/file/text.png';
        } else if(str_contains($file_icon, 'wp-includes/images/media/video.png')){
            $file_icon = get_template_directory_uri() . '/assets/img/file/video.png';
        }
    }

    if($file_ext == "jpg" || $file_ext == "jpeg") {
        $file_icon_image = imagecreatefromjpeg($file_icon);
    } else if($file_ext == "png") {
        $file_icon_image = imagecreatefrompng($file_icon);
    } else {
        $file_icon_image = imagecreatefrompng(get_template_directory_uri() . '/assets/img/file/deafult.png');
    }

    //getting title
    $title = get_the_title($post_id) ? get_the_title($post_id) : 'Error';
    
    if(strlen($title) > 14) {
        $titleArray = explode("\n", wordwrap( $title, 14));
        $titleL1 = $titleArray[0];
        if($titleArray[1]) {
            if($titleArray[2]) {
                $titleL2 = $titleArray[1] . '...';
            } else {
                $titleL2 = $titleArray[1];
            }
        } else {
            $titleL2 = false;
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
    
    //showing attachment thumbnail image
    imagecopy($img, $file_icon_image, 644, 44, 0, 0, 512, 512);
    
    //showing file icon file type
    imagecopy($img, $icon_file, 80, 380, 0, 0, 32, 32);
    imagettftext($img, 26, 0, 130, 408, $color_primary, $fontRegular, $file_extension);

    //showing size icon file size
    imagecopy($img, $icon_size, 250, 380, 0, 0, 32, 32);
    imagettftext($img, 26, 0, 300, 408, $color_primary, $fontRegular, $file_size);

    //showing date icon and date
    imagecopy($img, $icon_calendar, 80, 450, 0, 0, 32, 32);
    imagettftext($img, 26, 0, 130, 478, $color_primary, $fontRegular, get_the_date('F j, Y', $post_id));

    imagepng($img);
    imagedestroy($img);
?>