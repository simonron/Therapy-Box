   <div id="box">
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
          echo "<h1>".$count."</h1>";
          echo "</div>";
            }
          }
        }
      }
      closedir($handle);
      ?>
  </div>