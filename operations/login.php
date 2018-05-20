<?php
session_start();
if(isset($_POST["action"]))
{
	if($_POST["action"] == "signup")
	{
		if($_POST["gmail"]!=='admin@gmail.com'&&$_POST["user_name"]!='admin'&&$_POST["password"]!=='admin'){
		if(($_POST["gmail"] || $_POST["user_name"] ||$_POST["password"])!=''){
		if(!file_exists($_POST["gmail"])){
			
		mkdir('user_data/'.$_POST["gmail"], 0777, true);
		$file = fopen('user_data/'.$_POST["gmail"].'/'.$_POST["user_name"].'.txt','w');
		$user_pwd = password_hash($_POST["password"],PASSWORD_DEFAULT);
		if(fwrite($file ,$user_pwd)){
			echo 'Sign Up Successful';
			}
		}
		else{
			echo 'User already exists! please enter different gmail';
		}
	}
	else{
		echo 'Please enter all the data!!';
	}
	}
	else{

		if(($_POST["gmail"] || $_POST["user_name"] ||$_POST["password"])!=''){
		if(!file_exists($_POST["gmail"])){
			
		mkdir('user_data/'.$_POST["gmail"], 0777, true);
		$file = fopen('user_data/'.$_POST["gmail"].'/'.$_POST["user_name"].'.txt','w');
		$user_pwd = password_hash($_POST["password"],PASSWORD_DEFAULT);
		if(fwrite($file ,$user_pwd)){
			echo 'Sign Up Successful';
			}
		}
		else{
			echo 'User already exists! please enter different gmail';
		}
	}
	else{
		echo 'Please enter all the data!!';
	}
	}
	}
	
	if($_POST["action"] == "login")
	{
		if($_POST["mail"]!=='admin@gmail.com'&&$_POST["username"]!='admin'&&$_POST["pwd"]!=='admin'){
		if(($_POST["mail"] || $_POST["username"] ||$_POST["pwd"])!=''){
		$_SESSION["user_pwd"] = $_POST["pwd"];
		$_SESSION["user_nm"] = $_POST["username"];
		$_SESSION["user_mail"] = $_POST["mail"]; 
		$file = fopen('user_data/'.$_SESSION["user_mail"].'/'.$_SESSION["user_nm"].'.txt','r');
		while(!feof($file)) {
			$line = fgets($file);
		}
		if(password_verify($_SESSION["user_pwd"],$line)){
			echo 'login successful';
			
		}
		else{
			echo 'wrong password or gmail!!';
		}
		
	
		}
		else{
		echo 'Please enter all the data!!';
	}
	}
	else{
		if(($_POST["mail"] || $_POST["username"] ||$_POST["pwd"])!=''){
		$_SESSION["user_pwd"] = $_POST["pwd"];
		$_SESSION["user_nm"] = $_POST["username"];
		$_SESSION["user_mail"] = $_POST["mail"]; 
		$file = fopen('user_data/'.$_SESSION["user_mail"].'/'.$_SESSION["user_nm"].'.txt','r');
		while(!feof($file)) {
			$line = fgets($file);
		}
		if(password_verify($_SESSION["user_pwd"],$line)){
			echo 'login successful';
			
		}
		else{
			echo 'wrong password or gmail!!';
		}
		
	
		}
		else{
		echo 'Please enter all the data!!';
	}
		
	}

	}
	
	
}


?>