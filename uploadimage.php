<?php
// php update data in mysql database using PDO
session_start();
$host = "localhost";
$username = "root";
$password = "123456";
$database = "camagru";
$message = "";


    try{
        $connect = new PDO("mysql:host=$host; dbname=$database", $username, $password);
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $exc) {
        echo $exc->getMessage();
        exit();
    }
if(isset($_POST['btn-add']))
    {
        $email = $_SESSION['email'];
        $name = $_POST['username'];
        $images = $_FILES['profile']['name']; //gets image name
        $image_text = $_POST['image_text'];  //gets text from user input
        $tmp_dir = $_FILES['profile']['tmp_name'];
        $imageSize = $_FILES['profile']['size'];
       
        $upload_dir = 'uploads/'; //img file directory
        $imgExt = strtolower(pathinfo($images,PATHINFO_EXTENSION));
        $valid_extensions = array("jpeg", "jpg", "png", "gif", "pdf"); //list of valid image types that can be uploaded
        $picProfile = rand(1000, 1000000).".".$imgExt; //creates random name for image
        
        move_uploaded_file($tmp_dir, $upload_dir.$picProfile); //moves file from current directory to upload directory
        // print_r($_FILES);
    //    echo $images;
        $file = file_get_contents($upload_dir.$picProfile,true );
        // print_r($file);
        $enc = base64_encode($file);
        // echo $image_text;
        // die();
        $stmt = $connect->prepare("INSERT INTO images(username, picProfile, image_text) VALUES (:uname, :upic, :utxt)");
        $stmt->bindParam(':uname', $name);
        $stmt->bindParam(':upic', $enc);
        $stmt->bindParam(':utxt', $image_text);
        if($stmt->execute())
        {
            ?>
                <script>
                alert("IMAGE WAS SUCCESSFULLY UPLOADED");
                window.location.href=('camera.php');
                 </script>
            <?php
                $str = "You have recently uploaded an image. Other users will be able to view this image. ";
                mail($email, "Recent Image", $str);
        }
        else{
            ?>
            <script>
                alert("Error");
               window.location.href=('camera.php');
            </script>
            <?php
        }
 
    }  

?>


<!DOCTYPE html>
<html>
    <head>
        <title>UPLOAD IMAGES</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/login.css">
    </head>
    <body>
<div id="content">
  <form method="POST" action="uploadimage.php" enctype="multipart/form-data">
    <input type="hidden" name="size" value="1000000">
    <div>
    <h3>Upload an image?</h3>
      <input class="input" placeholder="Enter username" type="text" name="username" required><br><br>
      <input type="file" name="profile" required="" accept="*/image"><br><br>
    </div>
    <div>
      <textarea 
        id="text" 
        cols="40" 
        rows="4" 
        name="image_text" 
        class="input"
        placeholder="Say something about this image..."></textarea>
    </div>
    <div>
        <button class="submit" type="submit" name="btn-add">Add new</button>
    </div>
  </form>
</div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</body>
</html>