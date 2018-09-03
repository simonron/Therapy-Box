<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/script.js"></script>
<script type="text/javascript" src="js/photo_script.js"></script>
<link rel="stylesheet" href="css/style.css">

<? $dir="images/photos"; $handle=opendir($dir); ?>
<? $count =0;
while ($file = readdir($handle)) {
  if ($file<>".") {
    if ($file<>".."){
      if ($file<>".DS_Store"){
        $count+=1;
        $slide="$file";
        echo "<div class='slide container".$count."'>";
        echo  "<img src='images/photos/".$slide."'>";
        echo "</div>";
      }
    }
  }
}
closedir($handle);
?>
