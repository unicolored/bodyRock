<form method="post">

<input type="text" name="url" value="" style="width: 300px">

<input type="submit" value="Get Video Link">

</form>

Script by <a href="http://www.ngcoders.com">NGCoders</a>

<br />
<hr>
<br />


<?php

if(isset($_POST['url']))
{
  include('curl.php');
  include('youtube.php');
  
  $tube = new youtube();
    
  $links = $tube->get($_POST['url']);
   
  if($links) { ?>
    
    <b>Download Links  ( Same IP Downloading only )</b> :
    <pre>
    <?php
        print_r($links);
    ?>
    </pre>
  
  <?php } else {

      echo $tube->error;

  }
  


}

?>
