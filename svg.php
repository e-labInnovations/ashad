<?php
    header( 'Content-Type: image/svg+xml' );
?>
<svg xmlns="http://www.w3.org/2000/svg" height="90" width="200">
    <text x="10" y="20" style="fill:red;">
        Hello
        <tspan x="10" y="45"><?php echo get_query_var('customsvg'); ?></tspan>
    </text>
</svg>