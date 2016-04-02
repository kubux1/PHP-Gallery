<?php
      include_once 'layout/header.php';
      require_once 'functions.php';
      $db = get_db();
  session_start();

if (isset($_POST["forget"])) {
            foreach ($_POST['forgot'] as $imginfo) {
                unset($_SESSION['photo_select_' . $imginfo]);
            }
           echo "Zapomniano wybrane elementy.";
    }
       ?>
<!DOCTYPE html>
<html>
<head>
    <title>Gallery Remembered PHP</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="css/gallery.css" />
</head>
<body>
<div class="container">
        <?php 
            $imginfos= $db->gallery->find();
            foreach($imginfos as $imginfo):
            $selected = isset($_SESSION['photo_select_' . $imginfo['_id']]);
            if ($selected):  ?>
        <div class="gallery cf">                   
             <div class="gallery-item">
                Tytuł: <?php  echo $imginfo['tytul']?>
          <br />Autor: <?php  echo $imginfo['autor']; ?>                                                                   
                <a href="images/watermarks/<?php echo $imginfo['path'];?>"><img src="images/Thumbs/<?php echo $imginfo['path'];?>" /></a>               
                <form action="remembered_gallery.php" method="post" enctype="multipart/form-data" class="textfile">
              Zapomnij:   <?php echo '<input type="checkbox" name="forgot[]" value="' . $imginfo['_id'] . '"  >'?>
            </div>
          <?php //$db->gallery->remove($imginfo)?> 
           
        
        <?php endif; ?>  
        <?php endforeach; ?>
</div>
           <input type='submit' name='forget' value='Zapomnij' />
           </form>
</body>
</html>
