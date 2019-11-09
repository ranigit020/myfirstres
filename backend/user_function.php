<?php
include "config.php";
if(isset($_POST['insertuser'])){
  $name=$_POST['name'];
  $u_id=$_POST['u_id'];
  $email=trim($_POST['email']);
  $mobile=$_POST['phonenumber'];
  $address=$_POST['address'];
  $age=$_POST['age'];
  $created_date = date("Y-m-d H:i:s");      
  $last_updated = date("Y-m-d H:i:s");
  $user_id =0;
  $up_count =0;
  $check_user ="SELECT email_id FROM `user`where email_id ='$email'and  user_id not in ('$u_id')";
  $result =mysqli_query($con,$check_user);
  $count = mysqli_num_rows($result);
  if($count>0){
    echo "User with this email already exist";
  } 
  else{
    if($u_id>0){
      $user_status=$_POST['user_status'];
      $update_user ="UPDATE `user` SET `username`='$name',`email_id`='$email',`last_updated`='$last_updated',`status`='$user_status' where user_id= '$u_id'";
      $upuser_result =mysqli_query($con,$update_user);
    }
    $file_name ="";
    $file_path = "";
    if(!empty($_FILES["file"]["type"]))
    {
      $validextensions = array("jpeg", "jpg", "png");
      $temporary = explode(".", $_FILES["file"]["name"]);
      $file_extension = end($temporary);
      if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")
      ) && ($_FILES["file"]["size"] < 100000)//Approx. 100kb files can be uploaded.
        && in_array($file_extension, $validextensions)) {
        if ($_FILES["file"]["error"] > 0)
        {
          echo "Profile image error: " . $_FILES["file"]["error"];
        }
        else
        {
          if($u_id>0){
           $user_id = $u_id;
         }else{
           $insersc ="INSERT INTO `user`(`username`, `email_id`, `status`, `created_date`, `last_updated`) VALUES ('$name','$email','1','$created_date','$last_updated')";
           $user_result =mysqli_query($con,$insersc);
           $user_id = mysqli_insert_id($con);
         }
         if($user_id>0){
          $dirPath = 'user_profile/'.$user_id.'/';
          $targetPath = $dirPath.$_FILES["file"]["name"];
          if(!is_dir($dirPath)) {
            mkdir($dirPath,0777,true);
          }
            $sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
         // Target path where file is to be stored
           if(move_uploaded_file($sourcePath,$targetPath)){ // Moving Uploaded file
             $file_path = 'backend/'.$targetPath;
             $file_name = $_FILES["file"]["name"];
           } 
           if($u_id>0){
            $up_count++;
            $update_ud ="UPDATE `user_detail` SET `address`='$address',`age`='$age',`mobile`='$mobile',`profile_image`='$file_name',`profile_path`='$file_path',`last_updated`='$last_updated' where user_id= '$u_id'";
            $up_ud_result =mysqli_query($con,$update_ud);
            echo "User Updated Successfully";
          }else{
            $user_detail ="INSERT INTO `user_detail`( `user_id`, `address`, `age`, `mobile`, `profile_image`, `profile_path`, `created_date`, `last_updated`) VALUES ('$user_id','$address','$age','$mobile','$file_name','$file_path','$created_date','$last_updated')";
            $user_d_result =mysqli_query($con,$user_detail);
            echo "User Added Successfully";
          }
         } //user insert 
       }//end of else 
     }
     else
     {
      echo "Invalid file Size or Type";
    }
  }
  if($u_id>0 && $up_count==0){
   $update_ud ="UPDATE `user_detail` SET `address`='$address',`age`='$age',`mobile`='$mobile',`last_updated`='$last_updated' where user_id= '$u_id'";
   $up_ud_result =mysqli_query($con,$update_ud);
   echo "User Updated Successfully";
 }
}

}
if(isset($_POST['fetch_detail'])){
  $response =array();
  $getuser ="select u.username,u.email_id,u.status,ud.profile_path,u.created_date,u.user_id,ud.address,ud.mobile from user u , user_detail ud where u.user_id = ud.user_id order by u.user_id desc";
  $result =mysqli_query($con,$getuser);
  while ($data= mysqli_fetch_object($result)) {
    $response[]=$data;
  }
  echo json_encode($response);
  
}
if(isset($_POST['fetch_user'])){
  $u_id=$_POST['u_id'];
  $response =array();
  $get_sc ="select u.username,u.email_id,u.status,u.created_date,u.user_id,ud.address,ud.mobile ,ud.profile_path ,ud.age  from user u , user_detail ud where u.user_id = ud.user_id and u.user_id ='$u_id'";
  $result =mysqli_query($con,$get_sc);
  while ($data= mysqli_fetch_object($result)) {
    $response[]=$data;
  }
  echo json_encode($response);
}
if(isset($_POST['delete_user'])){
  $u_id=$_POST['u_id'];
  $del_user ="delete from user where user_id ='$u_id'";
  $result =mysqli_query($con,$del_user);
  if($result){
    $del_ud ="delete from user_detail where user_id ='$u_id'";
    $ud_result =mysqli_query($con,$del_ud);
    echo "User Deleted Successfully";
    
  }else{
    echo "error";
  }
}
?> 