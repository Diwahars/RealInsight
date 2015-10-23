<?php
if(!(empty($_SERVER['HTTP_X_REQUESTED_WITH'])) and strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
    header('Content-type: text/xml');
    echo "<users>";
    $type = "image";
    if(!(isset($_FILES[$type]["name"])) || $_FILES[$type]["name"] == '') {
        die("<error content='No data' /></users>");
    }

    session_start();
    function rmdir_recursive($dir) {
        foreach(scandir($dir) as $file) {
            if ('.' === $file || '..' === $file) continue;
            if (is_dir("$dir/$file")) rmdir_recursive("$dir/$file");
            else unlink("$dir/$file");
        }
    }
    if(!(isset($_SESSION['userid'])) ){
        die('<error content="User Invalid" /></users> ');
    }else{
        $USER = $_SESSION['userid'];
    }

    $check = getimagesize($_FILES[$type]["tmp_name"]);
    if($check == false) {
        echo "<error content='File is not an image.'/></users>";
        die();
    }
    $imagecount = 1;

    $path = dirname(dirname( __FILE__ ));
    $slash = '/'; //strpos( $path, $slash ) ? '' : $slash = '\\';
    define( 'BASE_DIR', $path . $slash . 'images' . $slash . 'user' . $slash );

    $target_dir = BASE_DIR . $USER . $slash ;
    rmdir_recursive($target_dir);
    if(!(file_exists(BASE_DIR))){
    	mkdir(BASE_DIR, '0755');
    }
    if(!(file_exists($target_dir))){
    	mkdir($target_dir, '0755');
    }

    $target_file = $target_dir . basename($_FILES[$type]["name"]);
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "JPG" && $imageFileType != "PNG" && $imageFileType != "JPEG" ) {
        echo "<error content='Sorry, only JPG, JPEG & PNG files are allowed.'/></users>";
        die();
    }
    $target_file = $target_dir . $USER . date('YmdHis') . ".jpg";

    $upload_file_path = $slash.'images'.$slash.'user'.$slash.$USER.$slash.$USER.date('YmdHis').".jpg";

    $image = imagecreatefromstring(file_get_contents($_FILES[$type]['tmp_name']));
    $exif = exif_read_data($_FILES[$type]['tmp_name']);
    if(!empty($exif['Orientation'])) {
        switch($exif['Orientation']) {
            case 8:
                $image = imagerotate($image,90,0);
                break;
            case 3:
                $image = imagerotate($image,180,0);
                break;
            case 6:
                $image = imagerotate($image,-90,0);
                break;
        }
    }
    imagejpeg($image, $_FILES[$type]['tmp_name'], 90);

    if (move_uploaded_file($_FILES[$type]["tmp_name"], $target_file)) {
        require('connectdb.php');
        $connection = mysqli_connect('localhost', $username, $password)
        or die('<error content="Can not connect to network"></error></users>');
        $db = mysqli_select_db($connection, $database)
        or die("<error content='Can not connect to network'></error></users>");
        $upload_file_path = str_replace('\\', '/', $upload_file_path);
        $query1 = "UPDATE `user`
            SET `profile`='".$upload_file_path."' 
            WHERE `userid`='".$USER."' ";
        $result1 = mysqli_query($connection, $query1)
        or die("<error content='Image upload successful. But can not modify current profile photo.'></error></users>");
        echo "<success content='".$upload_file_path."'></success></users>";
    }else{
    	echo "<error content='Can\'t upload file'/></users> ";
    }
}else{
    echo "You don\'t have permission for this data.";
}

?>