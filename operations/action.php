<!DOCTYPE html>
<html>
<head>
<title>list folder from directory</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
</html>



<?php
    ob_start();
    include('login.php');
    ob_end_clean();
	
    
if($_SESSION["user_mail"]!=='admin@gmail.com'&&$_SESSION["user_nm"]!='admin'&&$_SESSION["user_pwd"]!=='admin'){
	
	
if(isset($_POST["action"]))
{
	if($_POST["action"]=="fetch")
	{
		$dir ='user_data'.'/'.$_SESSION["user_mail"];
        $folder = array();
        if(is_dir($dir)){
            $handle = opendir($dir);
            while(false !== ($file = readdir($handle))){
                if(is_dir($dir.'/'.$file) && is_readable($dir.'/'.$file)){
                        $folder[] = $file;
                }
            }
            closedir($handle);
        }else {
            echo "<p>There is an directory read issue</p>";
        }
		$output='
		<table class="table table-bordered table-striped">
		<tr>
		<th>Folder name</th>
		<th> Total File</th>
		<th> Update Folder Name</th>
		<th> Delete</th>
		<th> Upload</th>
		<th> View Uploaded Files</th>
		<th> Create Text File</th>
		<th> Search Text File</th>
		</tr>
		';
		if(count($folder)>0)
		{
			foreach($folder as $name)
			{
			if($name!=='.'&&$name!=='..'&&$name!==$_SESSION["user_nm"].'.txt'){
				if((count(scandir('user_data/'.$_SESSION["user_mail"].'/'.$name)))<=3){
					$cnt=count(scandir('user_data/'.$_SESSION["user_mail"].'/'.$name))-2;
				}
				if((count(scandir('user_data/'.$_SESSION["user_mail"].'/'.$name)))>3){
					$cnt=count(scandir('user_data/'.$_SESSION["user_mail"].'/'.$name))-3;
				}
				$output .='
				<tr>
				<td>'.$name.'</td>
				<td>'.$cnt.'</td>
				<td><button type="button" name="update" data-name="'.$name.'" class="update btn btn-warning btn-xs">Rename</button></td>
				
				<td><button type="button" name="delete" data-name="'.$name.'" class="delete btn btn-danger btn-xs">Delete</button></td>
				
				<td><button type="upload" name="upload" data-name="'.$name.'" class="upload btn btn-info btn-xs"> Upload Files</button></td>
				
				<td><button type="button" name="view_files" data-name="'.$name.'" class="view_files btn btn-default btn-xs"> View Files</button></td>
				
				<td><button type="button" name="text_file" data-name="'.$name.'" class="text_file btn btn-default btn-xs">Create File</button></td>
				
				
				<td><button type="button" name="srch_file" data-name="'.$name.'" class="srch_file btn btn-primary btn-xs">Search files</button></td>

				</tr>
				';
			}
			}
		}
		else{
			$output .='
			<tr>
			<td colspan="6">no folder found</td>
			</tr>
			';
		}
		$output .= '</table>';
		echo $output;
		echo '<br><br><br><br><br><br><br><br><br><br><br><br>';
		
	
	}
	if($_POST["action"] == "create")
	{
		if(!file_exists('user_data/'.$_SESSION["user_mail"].'/'.$_POST["folder_name"]))
		{
			mkdir('user_data/'.$_SESSION["user_mail"].'/'.$_POST["folder_name"], 0777, true);
			echo 'Folder Created';
		}
		else
		{
			echo 'Folder Already Created';
			
		}
	}
	if($_POST["action"] == "change")
	{
		if(!file_exists('user_data/'.$_SESSION["user_mail"].'/'.$_POST["folder_name"]))
		{
			rename('user_data/'.$_SESSION["user_mail"].'/'.$_POST["old_name"], 'user_data/'.$_SESSION["user_mail"].'/'.$_POST["folder_name"]);
			echo 'Folder Name Changed';
		}

	    else
	    {
		echo 'Folder Already Exists';
	    }
    }
	if($_POST["action"]=="fetch_files")
	{
		$file_data=scandir('user_data/'.$_SESSION["user_mail"].'/'.$_POST["folder_name"]);
		$output='
		<table class="table table-bordered table striped">
		<tr>
		<th>Files</th>
		<th>File Name</th>
		<th>Delete</th>
		<th>View Files</th>
		</tr>
		';
		foreach($file_data as $file)
		{
			if($file == '.' OR $file == '..' OR $file == 'index.txt')
			{
				continue;
			}
			
			else{
				$path = 'user_data/'.$_SESSION["user_mail"].'/'.$_POST["folder_name"] . '/' . $file;
				$output .='
				<tr>
				<td><img src="'.$path.'" 
				class="img-thumbnail" height="50"
				width="50" /></td>
				<td>'.$file.'</td>
				<td><button name="remove_file"
				class="remove_file btn btn-danger  btn-xs"
				id="'.$path.'"> Remove</button></td>
				<td><button class="btn btn-info btn-xs"><a href="'.$path.'">view</a></button></td>
				</tr>
				';
				
				
				
	}
	
}
$output .='</table>';
echo $output;
	}

	
	if($_POST["action"] == "remove_file")
	{
		if(file_exists($_POST["path"]))
		{
			unlink($_POST["path"]);
			echo 'File Deleted';
		}
	}
	if($_POST["action"] == "delete")
	{
		$files = scandir('user_data/'.$_SESSION["user_mail"].'/'.$_POST["folder_name"]);
		foreach($files as $file)
		{
			if($file === '.' || $file ==='..')
			{
				continue;
			}
			else
			{
				unlink('user_data/'.$_SESSION["user_mail"].'/'.$_POST["folder_name"] . '/' .$file);
			}
				
		}
		if(rmdir('user_data/'.$_SESSION["user_mail"].'/'.$_POST["folder_name"]))
		{
			echo 'Folder Deleted';
		}
	}
	if($_POST["action"] == "textfile")
	{
		$title=$_POST["title"];	
		$create = fopen('user_data/'.$_SESSION["user_mail"].'/'.$_POST["old_name"].'/'.$title.'.txt','a');
		$txt=$_POST["txt"];
		if(fwrite($create,$txt)){
        echo 'File Created';			
		}
		else{
			echo 'Empty File Created';
		}
	
}

if($_POST["action"] == "srch"){

$txtname = $_POST["fname"];
$stor=0;
for($i=0;$i<strlen($txtname);$i++){
		$stor=$stor+ord($txtname[$i])*ord($txtname[1])/ord($txtname[0]);
}
$dir = 'user_data/'.$_SESSION["user_mail"].'/'.$_POST["old_name"];
        $fileNames = array();
        if(is_dir($dir)){
            $handle = opendir($dir);
            while(false !== ($file = readdir($handle))){
                if(is_file($dir.'/'.$file) && is_readable($dir.'/'.$file)){
                        $fileNames[] = $file;
                }
            }
            closedir($handle);
        }else {
            echo "<p>There is an directory read issue</p>";
        }
		$indexval=array();

foreach($fileNames as $files){
	$store=0;
	for($i=0;$i<strlen($files);$i++){
		$store=$store+ord($files[$i])*ord($files[1])/ord($files[0]);
		}
		$indexval[]=$store;
	
}
$ind=$dir.'/'.'index.txt';
file_put_contents($ind, print_r($indexval, true));

sort($indexval);
function binarySearch(Array $arr, $x)
{
    if (count($arr) === 0) return false;
    $low = 0;
    $high = count($arr) - 1;
     
    while ($low <= $high) {
         

        $mid = floor(($low + $high) / 2);
 
        if($arr[$mid] == $x) {
            return true;
        }
 
        if ($x < $arr[$mid]) {
            $high = $mid -1;
        }
        else {
            $low = $mid + 1;
        }
    }
    return false;
}
$indexval;
$stor;
if(binarySearch($indexval, $stor) == true) {
	echo $txtname." Exists :) <br>";
	if(file_exists($dir.'/'.$txtname)){
$path=$dir.'/'.$txtname;
$contents=file_get_contents($path);
if(!$contents==''){
echo ' & File Content: <br><br>'   .$contents;
}
else{
	echo ' empty file';
}
}
else{}
}
else {
	echo $txtname." Doesnt Exist :(";
}



}
}
}
else{
	if(isset($_POST["action"]))
{
	if($_POST["action"]=="fetch")
	{
		$dir ='user_data';
        $folder = array();
        if(is_dir($dir)){
            $handle = opendir($dir);
            while(false !== ($file = readdir($handle))){
                if(is_dir($dir.'/'.$file) && is_readable($dir.'/'.$file)){
                        $folder[] = $file;
                }
            }
            closedir($handle);
        }else {
            echo "<p>There is an directory read issue</p>";
        }
		$output='
		<table class="table table-bordered table-striped">
		<tr>
		<th>Folder name</th>
		<th> Total File</th>
		<th> Update File Name</th>
		<th> Delete</th>
		<th> Upload</th>
		<th> View Uploaded Files</th>
		<th> Create Text File</th>
		<th> Search Text File</th>
		</tr>
		';
		if(count($folder)>0)
		{
			foreach($folder as $name)
			{
			if($name!=='.'&&$name!=='..'&&$name!==$_SESSION["user_nm"].'.txt'&&$name!=='admin@gmail.com'){
				$output .='
				<tr>
				<td>'.$name.'</td>
				<td>'.(count(scandir('user_data/'.$name))-2).'</td>
				<td><button type="button" name="update" data-name="'.$name.'" class="update btn btn-warning btn-xs">Rename</button></td>
				
				<td><button type="button" name="delete" data-name="'.$name.'" class="delete btn btn-danger btn-xs">Delete</button></td>
				
				<td><button type="upload" name="upload" data-name="'.$name.'" class="upload btn btn-info btn-xs"> Upload Images</button></td>
				
				<td><button type="button" name="view_files" data-name="'.$name.'" class="view_files btn btn-default btn-xs"> View Files</button></td>
				
				<td><button type="button" name="text_file" data-name="'.$name.'" class="text_file btn btn-default btn-xs">Create File</button></td>
				
				
				<td><button type="button" name="srch_file" data-name="'.$name.'" class="srch_file btn btn-primary btn-xs">Search files</button></td>
				</tr>
				';
			}
			}
		}
		else{
			$output .='
			<tr>
			<td colspan="6">no folder found</td>
			</tr>
			';
		}
		$output .= '</table>';
		echo $output;
		echo '<br><br><br><br><br><br><br><br><br><br><br><br>';
		
	
	}
	if($_POST["action"] == "create")
	{
		if(!file_exists('user_data/'.$_POST["folder_name"]))
		{
			mkdir('user_data/'.$_POST["folder_name"], 0777, true);
			echo 'Folder Created';
		}
		else
		{
			echo 'Folder Already Created';
			
		}
	}
	if($_POST["action"] == "change")
	{
		if(!file_exists('user_data/'.$_POST["folder_name"]))
		{
			rename('user_data/'.$_POST["old_name"], 'user_data/'.$_POST["folder_name"]);
			echo 'Folder Name Changed';
		}

	    else
	    {
		echo 'Folder Already Exists';
	    }
    }
	if($_POST["action"]=="fetch_files")
	{
		$file_data=scandir('user_data/'.$_POST["folder_name"]);
		$output='
		<table class="table table-bordered table striped">
		<tr>
		<th>Files</th>
		<th>File Name</th>
		<th>Delete</th>
		</tr>
		';
		foreach($file_data as $file)
		{
			if($file == '.' OR $file == '..' OR $file == 'index.txt')
			{
				continue;
			}
			else{
				$path = 'user_data/'.$_POST["folder_name"] . '/' . $file;
				$output .='
				<tr>
				<td><img src="'.$path.'" 
				class="img-thumbnail" height="50"
				width="50" /></td>
				<td>'.$file.'</td>
				<td><button name="remove_file"
				class="remove_file btn btn-danger  btn-xs"
				id="'.$path.'"> Remove</button></td>
				</tr>
				';
	}
}
$output .='</table>';
echo $output;
	}
	if($_POST["action"] == "remove_file")
	{
		if(file_exists($_POST["path"]))
		{
			unlink($_POST["path"]);
			echo 'File Deleted';
		}
	}
	if($_POST["action"] == "delete")
	{
		$files = scandir('user_data/'.$_POST["folder_name"]);
		foreach($files as $file)
		{
			if($file === '.' || $file ==='..')
			{
				continue;
			}
			else
			{
				unlink('user_data/'.$_POST["folder_name"] . '/' .$file);
			}
				
		}
		if(rmdir('user_data/'.$_POST["folder_name"]))
		{
			echo 'Folder Deleted';
		}
	}
	if($_POST["action"] == "textfile")
	{
		$title=$_POST["title"];	
		$create = fopen('user_data/'.$_POST["old_name"].'/'.$title.'.txt','a');
		$txt=$_POST["txt"];
		if(fwrite($create,$txt)){
        echo 'File Created';			
		}
		else{
			echo 'Empty File Created';
		}
	
}

if($_POST["action"] == "srch"){

$txtname = $_POST["fname"];
$stor=0;
for($i=0;$i<strlen($txtname);$i++){
		$stor=$stor+ord($txtname[$i])*ord($txtname[1])/ord($txtname[0]);
}
$dir = 'user_data/'.$_POST["old_name"];
        $fileNames = array();
        if(is_dir($dir)){
            $handle = opendir($dir);
            while(false !== ($file = readdir($handle))){
                if(is_file($dir.'/'.$file) && is_readable($dir.'/'.$file)){
                        $fileNames[] = $file;
                }
            }
            closedir($handle);
        }else {
            echo "<p>There is an directory read issue</p>";
        }
		$indexval=array();

foreach($fileNames as $files){
	$store=0;
	for($i=0;$i<strlen($files);$i++){
		$store=$store+ord($files[$i])*ord($files[1])/ord($files[0]);
		}
		$indexval[]=$store;
	
}
$ind=$dir.'/'.'index.txt';
file_put_contents($ind, print_r($indexval, true));

sort($indexval);
function binarySearch(Array $arr, $x)
{
    if (count($arr) === 0) return false;
    $low = 0;
    $high = count($arr) - 1;
     
    while ($low <= $high) {
         

        $mid = floor(($low + $high) / 2);
 
        if($arr[$mid] == $x) {
            return true;
        }
 
        if ($x < $arr[$mid]) {
            $high = $mid -1;
        }
        else {
            $low = $mid + 1;
        }
    }
    return false;
}
$indexval;
$stor;
if(binarySearch($indexval, $stor) == true) {
	echo $txtname." Exists :) <br>";
	if(file_exists($dir.'/'.$txtname)){
$path=$dir.'/'.$txtname;
$contents=file_get_contents($path);
if(!$contents==''){
echo ' & File Content: <br><br>'    .$contents;
}
else{
	echo ' empty file!';
}
}
else{}
}
else {
	echo $txtname." Doesnt Exist :(";
}



}
}
	
	
}

?>
	
		