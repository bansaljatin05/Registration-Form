<!DOCTYPE HTML>
<html> 
	<head>
		<script> 
        
            function checkPassword(form) { 
                password1 = form.psw.value; 
                password2 = form.cpsw.value; 
  
                if (password1 == '') 
                    alert ("Please enter Password"); 
                
                else if (password2 == '') 
                    alert ("Please Confirm your password"); 
                                         
                else if (password1 != password2 || password1.length != password2.length) { 
                    alert ("\nPassword did not match: Please try again...") 
                    return false; 
                }

            } 
        </script> 
        
	<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
	
	.error {color: #FF0000;}

	body {
		font-family: Arial, Helvetica, sans-serif;
		background-color: black;
	}

	* {
		box-sizing: border-box;
	}

	.container {
		padding: 50px;
		margin: 20px 200px 20px 200px;
		background-color: white;
	}

	input {
		width: 100%;
		padding: 15px;
		margin: 5px 0 22px 0;
		display: inline-block;
		border: none;
		background: #f1f1f1;
	}

	input:focus {

		background-color: #ddd;
		outline: none;
	}

	hr {
		border: 1px solid #f1f1f1;
		margin-bottom: 25px;
	}
	.registerBtn{
		background-color: green;
		color: white;
		padding: 16px 20px;
		margin: 8px 0;
		border: none;
		cursor: pointer;
		width: 100%;
		opacity: 0.9;
	}
	.registerBtn:hover {
		opacity: 1;
	}

	a {
		color: dodgerblue;
	}
	.signin {
		background-color: #f1f1f1;
		width:100%;
		text-align: center;
	}
</style>
</head>
<body>
	
	<?php
    $mysqli = new mysqli("localhost", "root", "", "users");

	$nameerr = $emailerr = $mobileerr = $ageerr = " ";
	$name = $email = $mobile = $age = " ";

	if($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $Name = $mysqli->real_escape_string($_POST["name"]);
        $Email = $mysqli->real_escape_string($_POST["email"]);
        $Mobile = $mysqli->real_escape_string($_POST["ph"]);
        $Age = $mysqli->real_escape_string($_POST["age"]);
        $Password = md5($_POST["psw"]);
        
        $sql = "INSERT INTO accounts (Name, Mobile, Age, Email, Password) " 
            . "VALUES ('$Name', '$Mobile', '$Age', '$Email', '$Password')";
        
        $result = mysqli_query($mysqli,$sql);
        

		if(empty($_POST["name"])) {
			$nameerr = "Name is required"; 
		} else {
			$name = test_input($_POST["name"]);

			if(!preg_match("/^[a-z A-Z]*$/", $name)) {
				$nameerr = "Only letters and white space allowed";
			}
		}


		if(empty($_POST["email"])) {
			$emailerr = "Email is required"; 
		} else {
			$email = test_input($_POST["email"]);

			if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$nameerr = "Invalid email Format";
			}
		}

		if(empty($_POST["ph"])) {
			$mobileerr = "Number is required"; 
		} else {
			$mobile = test_input($_POST["ph"]);
		}

		if(empty($_POST["age"])) {
			$ageerr = "Age is required"; 
		} else {
			$age = test_input($_POST["age"]);
		}
        
        if(!$result) {
            $emailerr = "Email already in use";
        }
	}

	function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			return $data;
		}

	?>


<form onSubmit = "return checkPassword(this)"; method = "POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<div class="container">
		<h1>Register</h1>
		<p>Please fill in this form to create an acccount.</p>
		<hr>

		<label for="name"><b>Name</b><span class="error"> * <?php echo $nameerr;?></span></label>
		<input type="text" name="name" placeholder="Enter your Name" required value="<?php echo $name;?>"> 

		<label for="ph"><b>Mobile</b><span class="error"> *<?php echo $mobileerr;?></span></label>
		<input type="tel" name="ph" placeholder="Enter Your Ph no." value="<?php echo $mobile;?>">
		
		
		<label for="age"><b>Age</b><span class="error">*<?php echo $ageerr;?></span></label>
		<input type="number" name="age" placeholder="Enter Your Age" value="<?php echo $age;?>">

		<label for="email"><b>Email</b> <span class="error">* <?php echo $emailerr;?></span></label>
		<input type="text" name="email" placeholder="Enter Email" required value="<?php echo $email;?>">

		<label for="psw"><b>Password</b></label>
		<input type="password" name="psw" placeholder="Enter Password" required>

		<label for="cpsw"><b>Confirm Password</b></label>
		<input type="password" name="cpsw" placeholder="Confirm Your Password" required>

		<hr>
		<p>By creating account you agree to our <a href="#">Terms & Conditions</a>.</p>

		<button type="submit" class="registerBtn">Register</button>

		<p style="background-color: #f1f1f1; padding:10px">Already have an account? <a href="#">Sign in</a>.</p>
	</div>
	
</form>

</body>
