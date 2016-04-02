
<?php
    session_start();

include_once 'layout/header.php';
require_once 'functions.php';
$db = get_db();

      
       
       if(isset($_POST["register"])) {
           $registerOk=1;
           $login = $_POST['login'];
           $email = $_POST['email'];
           $password = $_POST['password'];
           $password2 = $_POST['password2'];
           if (empty($login) || empty ($email) || empty($password) || empty($password2)) {
               echo"Wszystkie pola są wymagane.";
               $registerOk=0;
           } else {
               if (strlen($login) < 3){
                   echo"Nazwa użytkownika musi składać się z co najmniej 3 znaków.";
                   $registerOk=0;
               }
               if (strpos($email, '@') === false){
                   echo"Niepoprawny adres e-mail.";
                   $registerOk=0;
               }
               if ($password !== $password2){
                   echo"Wpisane hasła są różne.";
                   $registerOk=0;
               }
               if (strlen($password) < 3){
                   echo "Hasło musi składać się z co najmniej 3 znaków.";
                   $registerOk=0;
               }
           }
           if($registerOk==1){
               $user=$db->users->findOne(array('login' => (string)$login));
               if($user===null){
                   $user=[
                       'login'=>(string)$login,
                       'password'=>md5((string)$password),
                       'email'=>(string)$email
                       ];
                   $db->users->insert($user);
                   echo"Rejestracja przebiegła pomyślnie!";
                   $registerOk=2;
               }
               else{
                   echo"Istnieje już użytkownik o nazwie \"".$login."\"";
               }
           }
       }

       if(isset($_POST["log"])) {
              $login = $_POST['login'];
              $password = $_POST['password'];
              if (!empty($login) && !empty($password)) {
                  $user=$db->users->findOne(array('login' => (string)$login, 'password' => md5((string)$password)));
                  if($user!==null){
                      echo"Logowanie przebiegło pomyślnie!";
                      $_SESSION['login_user'] = $login;
                      $registerOk=3;

                  }
                  else {
                      echo "Niepoprawny login lub hasło!";
                  }
              }
       }
       if(isset($_POST["wyloguj"])) {
           if (isset($_SESSION['login_user'])) {
               unset($_SESSION['login_user']);
               echo "Wylogowano poprawnie!";
               $registerOk=1;
           }
       }
      
       if (isset($_POST["remember"])) {
           foreach($db->gallery->find() as $imginfo ) {
               unset($_SESSION['photo_select_' . $imginfo['_id']]);
           }

           foreach ($_POST['remembered'] as $imginfo) {
               $_SESSION['photo_select_' . $imginfo] = 1;
           }
               echo"Zapamiętano wybrane elementy.<br/>";
           
       }
  
       
?>
<?php
$target_dir = "images/";
$target_file = $_SERVER["DOCUMENT_ROOT"] . '/' . $target_dir  . basename($_FILES["fileToUpload"]["name"]);
$target_water = $_SERVER["DOCUMENT_ROOT"] . '/' . $target_dir  . 'watermarks/'.basename($_FILES["fileToUpload"]["name"]);
define('FONT_ROOT',dirname(__DIR__).'/web/arial.ttf');
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["upload"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "Plik jest obrazem - " . $check["mime"] . ".</br>";
        $uploadOk = 1;
    } else {
        echo "Plik nie jest obrazem.</br>";
        $uploadOk = 0;
    }
}
$tytul = $_POST['tytul'];
$autor = $_POST['autor'];
$id = $_POST['id'];
$text = $_POST['watermark'];
$image=basename($_FILES["fileToUpload"]["name"]);

        if(empty($text)){
          echo"Proszę podać znak wodny.</br>";
          $uploadOk = 0;
      }
        if(empty($tytul)){
            echo"Proszę podać tytuł obrazka.</br>";
            $uploadOk = 0;
        }
        if(empty($autor)){
            echo"Proszę podać Autora.</br>";
            $uploadOk = 0;
        }
  
        
// Check if file already exists
if (file_exists($target_file)) {
    echo "Podane zdjęcie już istnieje.</br>";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 1000000) {
    echo "Przepraszamy, podane zdjęcie przekracza rozmiar 1MB.</br>";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png") {
    echo "Przepraszamy, dostępne są tylko formaty JPG & PNG.</br>";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Przepraszamy, obraz nie został wgrany.</br>";
    // if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "Obraz ". basename( $_FILES["fileToUpload"]["name"]). " został wgrany pomyślnie.</br>";
    function watermark($src, $dest, $text, $size = 15, $font)
    {
        $img = null;
        $name = substr($src, 0, strlen($src) - 3);
        $ext = substr($src, strlen($src) - 3);
        if (!in_array($ext, array('jpg','png'))) {
            return false;
        }
        switch ($ext) {
            case 'jpg':
                $img = imagecreatefromjpeg($src);
                break;
            case 'png':
                $img = imagecreatefrompng($src);
                break;
        }
        if (!$img) {
            return null;
        }

        $sW = imagesx($img);
        $sH = imagesy($img);

        $arr = imagettfbbox($size, 0, $font, $text);
        $width = abs($arr[2] - $arr[0]) + 5; // lower right X - lower left X
        $height = abs($arr[1] - $arr[7]) + 1;// lower left Y - upper left Y

        $color = imagecolorallocate($img, 255, 255, 255); // while

        $posX = $sW - $width;
        $posY = $sH - $height;
        imagettftext($img, $size, 0, $posX, $posY - 5, $color, $font, $text);

        switch ($ext) {
            case 'png':
                imagepng($img, $dest);
                break;
            case 'jpg':
                imagejpeg($img, $dest);
                break;
        }
        imagedestroy($img);
        return true;
    }
    watermark($target_file,$target_water, $_POST["watermark"], 14, FONT_ROOT);
    } else {
        echo "Przepraszamy, wystąpił błąd podczas wgrywania obrazu.</br>";
    }
    $imginfo=[
         'path' =>(string)basename($_FILES["fileToUpload"]["name"]),
         'tytul'=>(string)$tytul,
         'autor'=>(string)$autor,
         'login' => (isset($_SESSION['login_user']) ? (string)$_SESSION['login_user'] : null),
              ];
    $db->gallery->insert($imginfo);
    
}

?>


   <?php
    define('ROOT',$target_file) ;
    define('THUMB_ROOT',dirname(__DIR__).'/web/images/Thumbs/'.basename($_FILES["fileToUpload"]["name"]) );
    function make_thumb($src, $dest, $desired_width,$FileType) {
        $imageFileType = pathinfo($src,PATHINFO_EXTENSION);
        if($imageFileType != "jpg"){
            $source_image = imagecreatefrompng($src);
        }
        else {
        $source_image = imagecreatefromjpeg($src);}
        $width = imagesx($source_image);
        $height = imagesy($source_image);
        $desired_height = floor(125);
        $virtual_image = imagecreatetruecolor($desired_width, $desired_height);
        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
        if($imageFileType != "jpg"){
            imagepng($virtual_image, $dest);}
        else {
        imagejpeg($virtual_image, $dest);}
    }
    make_thumb(ROOT,THUMB_ROOT,200,$imageFileType);
   
?>
   <div class="container">
        <div class="gallery cf">
            <?php $imginfos= $db->gallery->find();
                foreach($imginfos as $imginfo):?> 
           
    
            <?php $selected = isset($_SESSION['photo_select_' . $imginfo['_id']]);?>

            
                    <div class="gallery-item">
                    Tytuł: <?php  echo $imginfo['tytul']?>
              <br />Autor: <?php echo $imginfo['autor'];?>
                 <form action="gallery.php" method="post" enctype="multipart/form-data" class="textfile">

                            <a href="images/watermarks/<?php echo $imginfo['path'];?>"><img src="images/Thumbs/<?php echo $imginfo['path'];?>" /> </a>


                            Zapamiętaj: <?php echo (' <input type="checkbox" name="remembered[]" value="' . $imginfo['_id'] . '"' . ($selected ? ' checked="checked"' : '') . '/>') ?>

</div>
                <?php  //$db->gallery->remove($imginfo)?>
                <?php endforeach; ?>
</div>
       
           <input type="file" name="fileToUpload">
           <input type="submit" name="upload" value="Wyślij"><br />
           Proszę podać tytuł obrazka:<input type="text" name="tytul"><br />
           Proszę podać Autora:       <input type="text" name="autor"><br />
           Proszę podać znak wodny:   <input type="text" name="watermark">

           <input type="hidden" name="id" /><br />
           <input type='submit' name='remember' value='Zapamiętaj' />
       </form>
    </div>
      
    <form id='register' action='gallery.php' method='post' name="register"
        accept-charset='UTF-8'>
             <?php if(   !isset($_SESSION['login_user'])): ?>
        <fieldset>
            <legend>Rejesetracja</legend>
            <input type='hidden' name='submitted' id='submitted' value='1' />
            <label for='email'>Adres email: </label>
            <input type='text' name='email' id='email' />
            <label for='login'>Login</label>
            <input type='text' name='login' id='login'/>
            <label for='password'>Hasło:</label>
            <input type='password' name='password' id='password'/>
            <label for='password2'>Powtórz hasło:</label>
            <input type='password' name='password2' id='password2' />
            <input type='submit' name='register' value='Potwierdź' />
        </fieldset>
        <input type="hidden" name="register" value="register">
        </form>
    <?php endif; ?>
         <?php if(  !isset( $_SESSION['login_user'])): ?>
        <form id='login' action='gallery.php' method='post' name="log"
        accept-charset='UTF-8'>
        <fieldset>
            <legend>Logowanie</legend>
            <input type='hidden' name='submitted' id='submitted' value='1' />
            <label for='login'>Login</label>
            <input type='text' name='login' id='login'/>
            <label for='password'>Hasło:</label>
            <input type='password' name='password' id='password'/>
            <input type='submit' name='log' value='Potwierdź' />
        </fieldset>
        <input type="hidden" name="log" value="log">
        </form>
    <?php endif; ?>
     <?php if(   isset($_SESSION['login_user'] )): ?>
     <input type='submit' name='wyloguj' value='Wyloguj się ' />
        <?php endif; ?>
        </div>
    </body>
</html>
