<?php //echo get_query_var( 'ashad-thumbnail' ); ?>

<?php
    header ('Content-Type: image/png');
    $img = wp_imagecreatetruecolor(500, 300)
          or die('Cannot Initialize new GD image stream');
    $text_color = imagecolorallocate($img, 233, 14, 91);
    imagestring($img, 1, 5, 5,  'A Simple Text String', $text_color);
    imagepng($img);
    imagedestroy($img);
?>