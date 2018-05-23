<?php

    ob_start();
    include('login.php');
    ob_end_clean();
if($_FILES["upload_file"]["name"]!='')
{


	$path = 'user_data/'.$_SESSION["user_mail"].'/'.$_POST["hidden_folder_name"] . '/' .basename($_FILES["upload_file"]["name"]);
	if(move_uploaded_file($_FILES["upload_file"]["tmp_name"],$path))
	{
		echo 'File Uploaded';
	}
	else{
		echo 'There is some error';
}
	

}
else 
{
	echo 'Please Select File';
}
	

?>