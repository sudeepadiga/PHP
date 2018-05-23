<!DOCTYPE html>
<html>
<head>
<title>list folder from directory</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<br /><br />
<div class="container">
<h1 align="center"><p style="color:blue">Manage your Folders</p></a></h1>
<br /><br />
<?php
    ob_start();
    include('login.php');
    ob_end_clean();
	
	
		$today = getdate();
	$hrs = $today['hours']+4;
	if($hrs<12){
echo '<center><h3>Hi '.$_SESSION["user_nm"].',</h3><img src = "images/morning.gif"></center><br><br><br>';
	}
	else if($hrs<15){
echo '<center><h3>Hi '.$_SESSION["user_nm"].',</h3><img src = "images/afternoon.gif"></center><br><br><br>';
	}
else{
echo '<center><h3>Hi '.$_SESSION["user_nm"].',</h3><img src = "images/evening.gif"></center><br><br><br>';
}
	?>
<div align="left">
 <a href="index.php"><button type="button" name="logout" id="logout" class="btn btn-danger">logout</button></a>
</div>
<div align="right">
  <button type="button" name="create_folder" id="create_folder" class="btn btn-success">Create folder to store images</button>
<br /><br />
</div>
<div id="folder_table" class="table-responsive">
</div>
</div>
</body>
</html>
<div id="folderModal" class="modal fade" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title"><span id="change_title">Create Folder</span></h4>
</div>
<div class="modal-body">
<p>Enter Folder Name
<input type="text" name="folder_name" id="folder_name" class="form-control" /></p>
<br />
<input type="hidden" name="action" id="action"/>
<input type="hidden" name="old_name" id="old_name" />
<input type="button" name="folder_button" id="folder_button" class="btn btn-info" value="Create" />
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>


<div id="uploadModal" class="modal fade" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title"><span id="change_title">
Upload File</span></h4>
</div>
<div class="modal-body">
 <form method="post" id="upload_form" enctype='multipart/form-data'>
 <p>Select Image
 <input type="file" name="upload_file" /></p>
 <br />
 <input type="hidden" name="hidden_folder_name" id="hidden_folder_name"/>
 <input type="submit" name="upload_button" class="btn btn-info" value="Upload" />
 </form>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>


<div id="filelistModal" class="modal fade" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title"><span id="change_title">
File List</span></h4>
</div>
<div class="modal-body" id="file_list">
 
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>



<div id="textModal" class="modal fade" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title"><span id="change_title">
Create Text Files</span></h4>
</div>
<div class="modal-body">
text file name:<input type="text" name="title" id="title" class="form-control" placeholder="eg: filename"/>
text or article:<textarea name="txt" id="txt" class="form-control" placeholder="Text to be stored in this file"></textarea>
<input type="hidden" name="action" id="action"/>
<input type="hidden" name="old_name" id="old_name" />

<br />
<center>
<input type="button" name="create_txt" id="create_txt" value="Create" class="btn btn-primary"/>
</center>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>



<div id="srchModal" class="modal fade" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title"><span id="change_title">
Search text files</span></h4>
</div>
<div class="modal-body">
text file name:<input type="text" name="fname" id="fname" class="form-control" placeholder="eg: filename.txt"/>
<input type="hidden" name="action" id="action"/>
<input type="hidden" name="old_name" id="old_name" />

<br />
<center>
<input type="button" name="srch" id="srch" value="Search" class="btn btn-primary"/>
</center>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>






<script>
$(document).ready(function(){
	load_folder_list();
	
	function load_folder_list()
	{
		
		var action="fetch";
		$.ajax({
			url:"action.php",
			method:"POST",
			data:{action:action},
			success:function(data)
			{
				$('#folder_table').html(data);
			}
		})
	}
	$(document).on('click', '#create_folder',function(){
		$('#action').val('create');
		$('#folder_name').val('');
		$('#folder_button').val('Create');
		$('#old_name').val('');
		$('#change_title').text('Create Folder');
		$('#folderModal').modal('show');
});

$(document).on('click', '#folder_button', function(){
	var folder_name = $('#folder_name').val();
	var action=$('#action').val();
	var old_name=$('#old_name').val();
	if(folder_name !='')  
	{
		$.ajax({
			url:"action.php",
			method:"POST",
		data:{folder_name:folder_name, old_name:old_name, action:action},
		success:function(data)
		{
			$('#folderModal').modal('hide');
			load_folder_list();
			alert(data);
		}
	});
	}
	else
	{
		alert("Enter folder name");
	}
});
$(document).on('click', '.update', function(){
	var folder_name = $(this).data("name");
	$('#old_name').val(folder_name);
	$('#folder_name').val(folder_name);
	$('#action').val("change");
	$('#folder_button').val("Update");
	$('#change_title').text("Change Folder Name");
	$('#folderModal').modal("show");
});
$(document).on('click', '.upload', function(){
	var folder_name = $(this).data("name");
	$('#hidden_folder_name').val(folder_name);
	$('#uploadModal').modal('show');
	
});
$('#upload_form').on('submit', function(){
	$.ajax({
		url:"upload.php",
		method:"POST",
		data:new FormData(this),
		contentType:false,
		cache:false,
		processData:false,
		success:function(data)
		{
			load_folder_list();
			alert(data);
		}
	})
});
$(document).on('click', '.view_files', function(){
	var folder_name = $(this).data("name");
	var action = "fetch_files";
	$.ajax({
		url:"action.php",
		method:"POST",
		data:{action:action, folder_name:folder_name},
		success:function(data){
			$('#file_list').html(data);
			$('#filelistModal').modal('show');
		}
	})
});

$(document).on('click', '.remove_file', function(){
	var path = $(this).attr("id");
	var action = "remove_file";
	if(confirm("are u sure u want to remove this file?"))
	{
		$.ajax({
			url:"action.php",
			method:"POST",
			data:{path:path, action:action},
			success:function(data)
			{
				alert(data);
				$('#filelistModal').modal('show');
				load_folder_list();
			}
		})
			
    }
	else{
		return false;
	}
});


$(document).on('click', '.delete', function(){
	var folder_name = $(this).data("name");
	var action = "delete";
	if(confirm("are u sure u wanna delete this folder?"))
		
		{
			$.ajax({
				url:"action.php",
				method:"POST",
				data:{folder_name:folder_name, action:action},
				success:function(data){
					load_folder_list();
					alert(data);
				}
			});
			
		}
});
$(document).on('click','.text_file' , function(){
	var folder_name = $(this).data("name");
	$('#action').val('textfile');
	$('#old_name').val(folder_name);
	$('#title').val('');
	$('#txt').val('');
	$('#change_title').text('Create text files');
	$('#textModal').modal('show');	
});
$(document).on('click','#create_txt', function(){
	var old_name = $('#old_name').val();
	var action = $('#action').val();
	var title = $('#title').val();
	var txt = $('#txt').val();
		$.ajax({
			url:"action.php",
			method:"POST",
			data:{old_name:old_name, action:action, title:title, txt:txt},
			success:function(data){
				alert(data);
				$('#textModal').modal('hide');	
				load_folder_list();
			}
			
		})
			
	});
	
	$(document).on('click', '.srch_file' ,function(){
		var folder_name = $(this).data("name");
		$('#old_name').val(folder_name);		
		$('#fname').val('');
		$('#action').val('srch');
		$('#srchModal').modal('show');
	});
	$(document).on('click','#srch', function(){
		
		var fname = $('#fname').val();
		var action = $('#action').val();
		var old_name = $('#old_name').val();
		$.ajax({
			
			url:"action.php",
			method:"POST",
			data:{fname:fname, action:action, old_name:old_name},
			success:function(data){
                var myWindow = window.open("", "MsgWindow", "width=800,height=600");
                myWindow.document.write("<h2>"+data.fontcolor("gray")+"</h2>")				
				$('#srchModal').modal('hide');
				load_folder_list();
			}
		})
	});

	

});

</script>

<?php
if(isset($_POST["logout"])){
session_destroy();

}
?>

