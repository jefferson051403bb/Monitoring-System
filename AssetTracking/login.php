
<?php

	include_once "db_connector.php";

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$email = $_POST["email"];
		$pass = $_POST["password"];

		$sqlSupname = "SELECT * FROM admins WHERE admin_email = '$email'";

		$resultSupName = $connection->query($sqlSupname);

		if ($resultSupName) {
			$row = $resultSupName->fetch_assoc();
		
			if ($row) {
				
				$adminName = $row['admin_fname'];
				$adminEmail = $row['admin_email'];
				$adminRole = $row["admin_role"];

				if($adminRole == "Admin"){
					header("Location: http://localhost/asset/myDashboard/dashboard.php?admin=harfeil");	
				}else if($adminRole == "Instructor"){
					header("Location: http://localhost/asset/myDashboard/insideLaboratory.php?id=403&name=laboratory123&adminFname=Jefferson&adminLname=Ta%C3%B1a");	
				}
			} else {
				echo "No matching record found";
			}
			$resultSupName->free();
		}
	}

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="loginStyle.css">
	<title>Asset Tracking</title>

	
</head>
<body>

	<div class="loginContainer">

		<div class="loginMain">

			<div class="loginForm">
				<form action="" method = "post">
					<div class="login"><h1>LOGIN</h1></div>
					<div class="inputEmail"><input type="text" name="email" class = "inputEmail" id = "inputEmail" placeholder="Enter Email" required></div><br><br>
					<div class="password"><input type="password" name="password" class = "password" id = "password" placeholder="Enter Password" required></div><br><br>
					
					
					<div class="button">
						<button id = "loginBtn">LOGIN</button>
						<button id = "cancelBtn">CANCEL</button>
					</div>
				</form>
			</div>

		</div>
		

	</div>

	<script>
		function logIn(){
			let email = document.getElementById("inputEmail").value;
			console.log(email);
			let password = document.getElementById("password");
			var xhr = new XMLHttpRequest();

			xhr.open("POST", "", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send("operations=asd");

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
			
		}
	</script>

</body>
</html>