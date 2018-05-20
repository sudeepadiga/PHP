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
<h2 align="center">WELCOME!</a></h2>
<br /><br />
<div align="right">
  <button type="button" name="login" id="login" class="btn btn-primary">Login</button>
  <button type="button" name="sign_up" id="sign_up" class="btn btn-warning">Sign Up</button>

<br /><br />
</div>

</div>
</body>
</html>
<div id="signupModal" class="modal fade" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title"><span id="change_title">Sign Up </span></h4>
</div>
<div class="modal-body">
<p>Enter User Name
<input type="text" name="user_name" id="user_name" class="form-control" /></p>
<p>Enter G-mail
<input type="text" name="gmail" id="gmail" class="form-control" /></p>
<p>Enter Password
<input type="password" name="password" id="password" class="form-control" /></p>
<br />
<input type="hidden" name="action" id="action"/>
<input type="hidden" name="old_name" id="old_name" />
<input type="button" name="signup_button" id="signup_button" class="btn btn-warning" value="Sign Up" />
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>


<div id="loginModal" class="modal fade" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title"><span id="change_title">Login</span></h4>
</div>
<div class="modal-body">
<p>Enter User Name
<input type="text" name="username" id="username" class="form-control" /></p>
<p>Enter G-mail
<input type="text" name="mail" id="mail" class="form-control" /></p>
<p>Enter Password
<input type="password" name="pwd" id="pwd" class="form-control" /></p>
<br />
<input type="hidden" name="action" id="action"/>
<input type="button" name="login_button" id="login_button" class="btn btn-info" value="login" />
</div>
<br /><br />
<a href="fpassword.php">Forgot Password?</a>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>

<?php   
	ob_start();
    include('folders.php');
    ob_end_clean();
?>





<script>
$(document).ready(function(){

	$(document).on('click','#sign_up', function(){
		$('#user_name').val('');
		$('#gmail').val('');
		$('#password').val('');
		$('#action').val('signup');
		$('#signupModal').modal('show');
	});
	
	$(document).on('click', '#signup_button' ,function(){
		var user_name = $('#user_name').val();
		var gmail = $('#gmail').val();
		var password = $('#password').val();
		var action = $('#action').val();
		$.ajax({
			url:"login.php",
			method:"POST",
			data:{user_name:user_name, gmail:gmail, password:password, action:action},
			success:function(data){
				alert(data);
				$('#signupModal').modal('hide');
			}
		})
			
});

$(document).on('click','#login', function(){
		$('#username').val('')
		$('#mail').val('');
		$('#pwd').val('');
		$('#action').val('login');
		$('#loginModal').modal('show');
	});
	
		$(document).on('click', '#login_button' ,function(){
		var username = $('#username').val();
		var mail = $('#mail').val();
		var pwd = $('#pwd').val();
		var action = $('#action').val();
		$.ajax({
			url:"login.php",
			method:"POST",
			data:{username:username, mail:mail, pwd:pwd, action:action},
			success:function(data){
				alert(data);
				$('#loginModal').modal('hide');
				if(data =='login successful'){
				window.location="folders.php";
				}
				
				
			}
		})
			
});





	

	
	
	
});
</script>



		
		