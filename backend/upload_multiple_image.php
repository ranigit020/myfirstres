<?php 
include "config.php";
if(isset($_FILES['files']["type"]))
{
	if(count($_FILES['files']['name']) > 0)
  {
  	$count = 0;
  	 foreach($_FILES['files']['tmp_name'] as $key => $tmp_name )
  	 {
	    $file_name = $_FILES['files']['name'][$key];
		$file_size =$_FILES['files']['size'][$key];
		$file_tmp =$_FILES['files']['tmp_name'][$key];
		$file_type=$_FILES['files']['type'][$key];	
		$validextensions = array("jpeg","jpg","png","doc","docx","zip");
		$created_date = date("Y-m-d H:i:s");
		$dirPath = "";   
		$temporary = explode(".", $file_name );
		$file_extension = strtolower(end($temporary));
    	if (in_array($file_extension, $validextensions))
    	{
			if ($_FILES["files"]["error"][$key] > 0)
			{
				echo "Return Code: ".$_FILES["files"]["error"][$key] . "<br/><br/>";
			}
			else
			{ 
				 if(($file_extension =="doc")||($file_extension =="docx")
				     {
                        $dirPath = 'uploaded_files/doc/';
                        
				     }
				 else if($file_extension =="zip"){
                        $dirPath = 'uploaded_files/zip/';
				 	 }
				 else{
				 	   $dirPath = 'uploaded_files/images/';
				 	   $redirPath = 'uploaded_files/resize_images/';
				 	   $sourceProperties = getimagesize($file_tmp);
				 	   $newFileName = $temporary[0];
				 	   $imageType = $sourceProperties[2];
				 	   if(!is_dir($redirPath)) {
			            mkdir($redirPath, 0777,true);
			            }
				 	   switch ($imageType) {


			            case IMAGETYPE_PNG:
			                $imageSrc = imagecreatefrompng($file_tmp); 
			                $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1]);
			                imagepng($tmp,$redirPath. $newFileName. "_thump.". $file_extension);
			                break;           

			            case IMAGETYPE_JPEG:
			                $imageSrc = imagecreatefromjpeg($file_tmp); 
			                $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1]);
			                imagejpeg($tmp,$redirPath. $newFileName. "_thump.". $file_extension);
			                break;
			            
			            case IMAGETYPE_GIF:
			                $imageSrc = imagecreatefromgif($file_tmp); 
			                $tmp = imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1]);
			                imagegif($tmp,$redirPath. $newFileName. "_thump.". $file_extension);
			                break;

			            default:
			                echo "Invalid Image type.";
			                exit;
			                break;
			        }
			       
                 }
			        if(!is_dir($dirPath)) {
				    mkdir($dirPath, 0777,true);
				     }
				    $targetPath = $dirPath.$file_name;
					if (file_exists($targetPath)) {
					echo $_FILES["files"]["name"][$key]. " <span id='invalid'><b>already exists.</b></span></br>";
					 }
					else
					 {
					$sourcePath = $_FILES['files']['tmp_name'][$key]; // Storing source path of the file in a variable
					 // Target path where file is to be stored
					 if(move_uploaded_file($sourcePath,$targetPath)){ // Moving Uploaded file
					 	$count++;
					 
			      }
			   }
		    }
		}
		else
		{
		echo $_FILES["files"]["name"][$key]."<span id='invalid'>***Invalid File Type***<span>";
		}
	  }// end of foreach
	   if($count>0){
          echo "<span id='success'>".$count.": File Uploaded Successfully..!!</span><br/>";
	   }
	 }
else{
	      echo "<span id='invalid'>Please Select file<span>";
	}
}

function imageResize($imageSrc,$imageWidth,$imageHeight) {
    $newImageWidth =50;
    $newImageHeight =50;
    $newImageLayer=imagecreatetruecolor($newImageWidth,$newImageHeight);
    imagecopyresampled($newImageLayer,$imageSrc,0,0,0,0,$newImageWidth,$newImageHeight,$imageWidth,$imageHeight);
    return $newImageLayer;
}
?>