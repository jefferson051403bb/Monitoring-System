<?php

require_once('db_connector.php');

$sql = "";
$admin_fname = "";
$admin_lname = "";
$admin_num = "";
$admin_email = "";
$pass = "";

$message = "";
$errorMessage = "";
$successMessage = "";

if(isset($_POST['operations'])) {
	echo "asd";

	$operation = $_POST["operation"];
	
    $admin_fname = $_POST["fname"];
    $admin_lname = $_POST["lname"];
    $admin_num = $_POST["number"];
    $admin_email = $_POST["email"];
    $pass = $_POST["password"];
    $role = $_POST["role"];
	$hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

	if($operation = "add"){
		$sqlAdminname = "SELECT * FROM admins where admin_fname = '$admin_fname' AND admin_lname = '$admin_lname' AND admin_email = '$admin_email'";

		$resultAdminName = $connection->query($sqlAdminname);

		
		if ($resultAdminName->num_rows == 0) {

			$sql = "INSERT INTO admins (admin_fname, admin_lname,admin_num, admin_email, admin_pass, admin_role) VALUES ('$admin_fname', '$admin_lname', '$admin_num', '$admin_email', '$pass', '$role')";

			$result = $connection->query($sql);


			if(!$result){
				$errorMessage = 'Invalid Query: ' .$connection->error;
			}else{
				$successMessage = "Successfully Register";
			}
			
		} else {
			$message = "Account is Already Exist";
		}
	}
		
    $admin_fname = "";
    $admin_lname = "";
    $admin_num = "";
    $admin_email = "";
    $pass = "";
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="gister.css">
	<title>Asset Tracking</title>

</head>
<body>



	<div class="loginContainer">

		<div class="login">
			<h1>Account Registration</h1>
		</div>
		
		<div class="signup">

			<div class="formcontainer">
				<h1 id="singup">SIGN <span style="color: blue;">UP</span></h1>
				<form class = "registerFormContainer">
					<div class = "fullname">
						<input type="text" name="fname" class = "inputFName" id = "inputFName" placeholder="Enter First Name" value = "<?php echo $admin_fname; ?>">
					</div> <br><br>
					<div class = "fullname">
						<input type="text" name="lname" class = "inputLName" id = "inputLName" placeholder="Enter Last Name" value = "<?php echo $admin_lname; ?>">
					</div> <br><br>
					<div class = "fullname">
						<input type="text" name="number" class = "inputNum" id = "numberInput" placeholder="Enter Phone Number" value = "<?php echo $admin_num; ?>">
					</div> <br><br>
					<div class="email">
						<input type="text" name="email" class = "inputEmail" id = "inputEmail" placeholder="Enter Email" value = "<?php echo $admin_email; ?>">
					</div><br><br>
					<div class="password">
						<input type="password" name="password" class = "password" id = "password" placeholder="Enter Password" value = "<?php echo $pass; ?>">
					</div><br><br>
					<div class="repassword">
						<input type="password" name="repassword" id = "repassword" class = "repassword" placeholder="Repeat Password" value = "<?php echo $pass; ?>">
					</div><br><br>
						<select name="" id="roleSelector">
							<option value="select">Select Role</option>
							<option value="Admin">Admin</option>
							<option value="Instructor">Instructor</option>
						</select>
				</form>

				<?php

                            if(!empty($successMessage)){
                            echo"

                                <div class = 'alert alert - warning alert-dismissible fade show ' role = 'alert'>

                                    <strong>$successMessage</strong>
                                    <button type = 'button' class = 'btn-close' data-bs-dismiss='alert' aria-label='Close'></button>

                                </div>

                            ";
                            }
                                

                            ?>

			<div class="button">
				
			<button id="button" onclick ="addAdmin()">Register</button>
			</div>
			</div>

			<div class = "secondColumn">
				
				<img src="Pictures/signBack.jpg" class="image"> <br>
				<div class="account"><a href="http://localhost/asset/AssetTracking/login.php" id="haveAccount">Already Have Account</a></div>
			</div>


		</div>


	</div>

	<script>

	inputFName.addEventListener('input', function(event) {
		inputFName.style.border = "none";
		inputFName.style.borderBottom = "1px solid black";
	});

	inputLName.addEventListener('input', function(event) {
		inputLName.style.border = "none";
		inputLName.style.borderBottom = "1px solid black";
	});

	numberInput.addEventListener('input', function(event) {
		numberInput.style.border = "none";
		numberInput.style.borderBottom = "1px solid black";
	});

	inputEmail.addEventListener('input', function(event) {
		inputEmail.style.border = "none";
		inputEmail.style.borderBottom = "1px solid black";
	});

	password.addEventListener('input', function(event) {
		password.style.border = "none";
		password.style.borderBottom = "1px solid black";
	});

	repassword.addEventListener('input', function(event) {
		repassword.style.border = "none";
		repassword.style.borderBottom = "1px solid black";
	});

	roleSelector.addEventListener('change', function(event) {
		roleSelector.style.border = "1px solid black";
	});

	function addAdmin(){

		let error = true

		let fname = document.getElementById("inputFName").value;
		let lname = document.getElementById("inputLName").value;
		let number = document.getElementById("numberInput").value;
		let email = document.getElementById("inputEmail").value;
		let confirmPassword = document.getElementById("repassword").value;
		let newPassword = document.getElementById("password").value;
		let role = document.getElementById("roleSelector").value;
		
		if(fname === ""){
			error = false;
			inputFName.style.border = "2px solid red";
		}

		if(lname === ""){
			error = false;
			inputLName.style.border = "2px solid red";
		}

		if(number === ""){
			error = false;
			numberInput.style.border = "2px solid red";
		}

		if(email === ""){
			error = false;
			inputEmail.style.border = "2px solid red"; 
		}

		if(confirmPassword === ""){
			error = false;
			repassword.style.border = "2px solid red"; 
		}

		if(newPassword === ""){
			error = false;
			password.style.border = "2px solid red"; 
		}

		if(role === "select"){
			error = false;
			roleSelector.style.border = "2px solid red"
		}

		if(error === true){
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send("operations=add"+"&fname="+fname+"&lname="+lname+"&number="+number+"&email="+email+"&password="+newPassword+"&role="+role);

			xhr.onreadystatechange = function() {
				if (xhr.readyState === XMLHttpRequest.DONE) {
					if (xhr.status === 200) {
						// console.log(xhr.responseText);
						// location.reload();
					} else {
						console.error('There was a problem with the request.');
					}
				}
			};
			inputFName.value = "";
			inputLName.value = "";
			numberInput.value = "";
			inputFName.value = "";
			inputEmail.value = "";
			repassword.value = "";
			password.value = "";
			roleSelector.value = "select";
		}
	}


	</script>
</body>
</html>