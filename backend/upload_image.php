<?php 
include "config.php";
if(isset($_FILES["file"]["type"]))
{
$validextensions = array("jpeg", "jpg", "png");
$created_date = date("Y-m-d H:i:s");    
$temporary = explode(".", $_FILES["file"]["name"]);
$file_extension = end($temporary);
$file_name = $_FILES["file"]["name"];
if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")
) && ($_FILES["file"]["size"] < 100000)//Approx. 100kb files can be uploaded.
&& in_array($file_extension, $validextensions)) {
	if ($_FILES["file"]["error"] > 0)
	{
	echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
	}
	else
	{
       $dirPath = 'upload/';
		if(!is_dir($dirPath)) {
	    mkdir($dirPath, 0700);
	     }
		 $targetPath = $dirPath.$file_name;
		 $file_path = 'backend/'.$targetPath;
		if (file_exists($targetPath)) {
		echo $_FILES["file"]["name"] . " <span id='invalid'><b>already exists.</b></span> ";
		}
		else
		{
		$sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
		 // Target path where file is to be stored
		 if(move_uploaded_file($sourcePath,$targetPath)){ // Moving Uploaded file
			 $insersc ="INSERT INTO `image_gallery`(`file_name`, `file_ext`, `file_path`, `created_date`)VALUES ('$file_name','$file_extension','$file_path','$created_date')";
			     $result =mysqli_query($con,$insersc);
		       if($result){
				echo "<span id='success'>Image Uploaded Successfully...!!</span><br/>";
				echo "<br/><b>File Name:</b> " . $file_name . "<br>";
				echo "<b>Type:</b> " . $_FILES["file"]["type"] . "<br>";
				echo "<b>Size:</b> " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
				echo "<b>Temp file:</b> " . $_FILES["file"]["tmp_name"] . "<br>";
				}
	      }
	   }
    }
}
else
{
echo "<span id='invalid'>***Invalid file Size or Type***<span>";
}
}
 if(isset($_POST['fetch_imagelist'])){
    $response =array();
    $get_img ="select * from image_gallery ";
    $result =mysqli_query($con,$get_img);
    while ($data= mysqli_fetch_object($result)) {
        $response[]=$data;
    }
    echo json_encode($response);
   }
?>