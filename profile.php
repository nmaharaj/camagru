<html>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PROFILE</title>
    <link rel="stylesheet" type="text/css" href="./css/index.css">
    </head>
    <body>
      <h1>CAMAGRU</h1>
      <div class="box2">
            <a href="camera.php"><input class="camerabutton" type="button" value="camera"></a>
            <input class="profilebutton" type="button" onclick="alert('Go to profile')" value="profile">
            <a href="gallery.php"><input class="gallerybutton" type="button" value="gallery"></a>
            <a href="settings.phtml"><input type="submit" value="settings"></a>
            <a href="logout.php"><input class="logoutbutton" type="button" value="logout"></a>
      </div>
    </body>
</html>

<?php
include 'head.php';
session_start();
$host = "localhost";
$username = "root";
$password = "123456";
$database = "camagru";
$message = "";


try
{
    $connect = new PDO("mysql:host=$host; dbname=$database", $username, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $error)
{
      $message = $error->getMessage();
}

$username = $_SESSION['username'];
// $username = "nishka";
    $display = "SELECT * FROM `images` WHERE username = '".$username."'";
    $do = $connect->query($display);

   

    while($pics = $do->fetch())
    {
        $pic = $pics['picProfile'];
      echo "<img src='data:image/png;base64,$pic'>";
        // echo $pics['username']."  said  ";
    //   echo $pics['image_text'];
    echo "<h5>". $pics['username']."  said  " . $pics['image_text'] ."</h5>";


      echo "<script>
 window.location.Gallery;
 </script>";
    }

?>