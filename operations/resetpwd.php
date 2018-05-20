<?php
if(isset($_POST["action"])){
	if($_POST["action"] == "reset"){
		
		if(($_POST["gmail"] || $_POST["user_name"] ||$_POST["password"] || $_POST["npassword"])!=''){
		if($_POST["password"] == $_POST["npassword"]){
			
			$file=fopen('user_data/'.$_POST["gmail"].'/'.$_POST["user_name"].'.txt','w');
			$pwd=password_hash($_POST["password"],PASSWORD_DEFAULT);
			if(fwrite($file,$pwd)){
				echo 'password reset successful';
			}
		
		else{
			echo 'password not matching';
		}
		}
	}
	else{
		echo 'Please enter all the data!!';
	}
	
}
}