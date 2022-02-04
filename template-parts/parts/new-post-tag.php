<?php
    $Date = get_the_date('Y-m-d'); #Your Own Date
    $FirstDay = date("Y-m-d", strtotime('sunday last week'));  
    $LastDay = date("Y-m-d", strtotime('sunday this week'));  
    if($Date > $FirstDay && $Date < $LastDay) {
?>
    <div class="new-post-tag">New Post</div> 
<?php } ?>