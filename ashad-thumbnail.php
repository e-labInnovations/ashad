<?php
    header ('Content-Type: image/png');
    $img = wp_imagecreatetruecolor(1200, 600)
          or die('Cannot Initialize new GD image stream');
    $background_color = imagecolorallocate($img, 255, 255, 255);
    $text_color = imagecolorallocate($img, 233, 14, 91);
    $text = "Post Id: " . get_query_var( 'ashad-thumbnail' );
    imagestring($img, 5, 10, 10, $text, $text_color);
    imagepng($img);
    imagedestroy($img);
?>