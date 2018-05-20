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
<h2 align="center">Reset Your Password!</a></h2>
<br /><br />
<center>
  <button type="button" name="forgot" id="forgot" class="btn btn-primary">Password reset</button>
  </center>

</div>
</body>
</html>
<div id="forgotModal" class="modal fade" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title"><span id="change_title">reset your password </span></h4>
</div>
<div class="modal-body">
<p>Enter User Name
<input type="text" name="user_name" id="user_name" class="form-control" /></p>
<p>Enter G-mail
<input type="text" name="gmail" id="gmail" class="form-control" /></p>
<p>Enter New Password
<input type="password" name="password" id="password" class="form-control" /></p>
<p>Confirm Password
<input type="password" name="npassword" id="npassword" class="form-control" /></p>
<br />
<input type="hidden" name="action" id="action"/>
<input type="button" name="reset" id="reset" class="btn btn-primary" value="Reset" />
<a href="index.php"><input type="button" name="back" id="back" class="btn btn-warning" value="login now" ></a>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>


<script>
$(document).ready(function(){
	
	$(document).on('click', '#forgot', function(){
		$('#user_name').val('');
		$('#gmail').val('');
		$('#password').val('');
		$('#npassword').val('');
		$('#action').val('reset');
		$('#forgotModal').modal('show');
		
	});
	$(document).on('click','#reset', function(){
		var user_name = $('#user_name').val();
		var gmail = $('#gmail').val();
		var password = $('#password').val();
		var npassword = $('#npassword').val();
		var action = $('#action').val();
		$.ajax({
			url:"resetpwd.php",
			method:"POST",
			data:{user_name:user_name, gmail:gmail, password:password, npassword:npassword, action:action},
			success:function(data){
				alert(data);
			}
			
		})
		
	});
		
	
});
</script>