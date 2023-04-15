<?php 
// Admin login functionality
if(isset($_POST['email'])){
	require('./db/db.php');
	$res=mysqli_query($db,"SELECT * FROM `users` WHERE email='$_POST[email]' && password='$_POST[password]' && type = '1';");
	$count=mysqli_num_rows($res);
	if($count){
		session_start();
		$_SESSION['login_admin'] = $_POST['email'];
		$message['status'] = 1;
		$message['message'] = "You Logged In Successfully!";
		echo json_encode($message);
		exit();
	}
	else{
		$message['status'] = 0;
		$message['message'] = "Email Or Password Does Not Match!!";
		echo json_encode($message);
		exit();
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Ayurveda | Admin Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
	<style>
		.password-eye{
            float: right;
            margin-right: 8px;
            margin-top: -35px;
            position: relative;
            /* z-index: 2; */
        }
	</style>
</head>
<body>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form id="admin_login_form" class="login100-form validate-form">
					<span class="login100-form-title">Ayurveda Admin Login</span>
					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" id="email" type="text" name="email" placeholder="Email">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" id="password" type="password" name="pass" placeholder="Password">
						<img toggle="#password" src="./assets/img/eye-open.png" alt="" class="password-eye" style="width:25px;cursor:pointer;">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button id="admin_login" class="login100-form-btn">
							Login
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
<script>
	$(document).ready(function() {
        // password eye toggle 
        $(".password-eye").click(function () {
            let src = this.getAttribute("src");
            if(src == "./assets/img/eye-open.png"){
                this.setAttribute("src","./assets/img/eye-close.png")
            }
            else{
                this.setAttribute("src","./assets/img/eye-open.png")
            }
            let input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    });

	let admin_login_btn = document.getElementById("admin_login")
	admin_login_btn.addEventListener("click",async function(e){
		e.preventDefault();

		let formData = new FormData(admin_login_form);
		if(email.value == ""){
			swal("Warning!","Please Enter Email!","warning")
			email.focus();
		}
		else if(password.value == ""){
			swal("Warning!","Please Enter Password!","warning")
			password.focus();
		}
		else{
			formData.append('email',email.value)
			formData.append('password',password.value)
			let fetch_res = await fetch("login.php",{
				method:"POST",
				body:formData
			})
			let json_res = await fetch_res.json();
			if(json_res.status){
				swal("Success!",json_res.message,"success").
				then(()=>{
					window.location.href = "./index.php";
				})
				document.getElementById("contactForm").reset();
			}
			else{
				swal("Error!",json_res.message,"error")
			}
		}
	})
</script>
</html>