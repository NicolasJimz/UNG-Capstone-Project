<!-- Account Registration Page -->
<?
$title = "Register An Account";
include_once("Header.php");

// Check if user is logged in already
// If so, send to home page
if($_SESSION['key'] == 1)
{
	header("location: http://nickjwebsite.com/Products.php");
}

// Error handling
$errors = "";
$complete = "Registration successful!<br>";

if(isset($_POST['submit']))
{
	switch ($_SESSION['seclvl'])
	{
		// ----------------------------------------------------------- LOW LEVEL SECURITY -----------------------------------------------------------
		case 1:
			// Username errors
			if(strlen(trim($_POST['username'])) == 0)
			{
				$errors .= "You did not enter a username.<br>";
			}

			//Password errors
			if(strlen(trim($_POST['password'])) == 0 || strlen(trim($_POST['password'])) > 20)
			{
				if(strlen(trim($_POST['password'])) == 0){
					$errors .= "You did not enter a password in at least one of the password fields.<br>";
				}
				else{
					$errors .= "Password can be no longer than 20 characters.<br>";
				}
			}
			else
			{
				if($_POST['password'] != $_POST['confirmPassword'])
				{
					$errors .= "The passwords entered do not match.<br>";
				}
			}

			// Check for errors then try insert
			if(strlen($errors) > 0)
			{
				echo "<div class='error'>";
				echo $errors;
				echo "</div>";
			}
			else
			{
				//Insert submission into database and display submission complete message or error message
				try
				{
					$user_id = 0;
					$username = $_POST['username'];
					$password = $_POST['password'];
					$authority = 1;
					
					/*$insert = $db->prepare("INSERT INTO users(user_id, username, password, authority);*/
					$insert = $db->exec("INSERT INTO users VALUES(".$user_id.", '".$username."', '".$password."', ".$authority.");");

					if(!$insert){
						echo "<div class='error'>";
						print_r($db->errorInfo());
						echo "</div><br>";
					}
					else{
						echo "<div class='noError'>";
						echo $complete;
						echo "</div><br>";

						header("location: http://nickjwebsite.com/");
					}
				}
				catch(PDOException $e)
				{
					echo "<div class='error'>";
					echo "Something went wrong while trying to register your account.";
					echo "</div><br>";
				}
			}
			break;
		
		// ----------------------------------------------------------- MEDIUM LEVEL SECURITY -----------------------------------------------------------
		case 2:
			// Username errors
			if(strlen(trim($_POST['username'])) == 0)
			{
				$errors .= "You did not enter a username.<br>";
			}

			//Password errors
			if(strlen(trim($_POST['password'])) == 0 || strlen(trim($_POST['password'])) > 20)
			{
				if(strlen(trim($_POST['password'])) == 0){
					$errors .= "You did not enter a password in at least one of the password fields.<br>";
				}
				else{
					$errors .= "Password can be no longer than 20 characters.<br>";
				}
			}
			else
			{
				if($_POST['password'] != $_POST['confirmPassword'])
				{
					$errors .= "The passwords entered do not match.<br>";
				}
			}

			// Check for errors then try insert
			if(strlen($errors) > 0)
			{
				echo "<div class='error'>";
				echo $errors;
				echo "</div>";
			}
			else
			{
				//Insert submission into database and display submission complete message or error message
				try
				{
					$user_id = 0;
					$username = $_POST['username'];
					$password = $_POST['password'];
					$authority = 1;
					
					// MEDIUM LEVEL SECURITY ADDITION vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv
					// Search input for SQL keywords
					if(stripos($username, 'select') || stripos($username, 'union') || stripos($username, 'drop table') || stripos($username, 'join') || stripos($username, 'update') || stripos($username, 'from') || stripos($username, 'where'))
					{
						echo "<div class='error'>";
						echo "SQL injection attack detected.";
						echo "</div>";
						break;
					}

					if(stripos($password, 'select') || stripos($password, 'union') || stripos($password, 'drop table') || stripos($password, 'join') || stripos($password, 'update') || stripos($password, 'from') || stripos($password, 'where'))
					{
						echo "<div class='error'>";
						echo "SQL injection attack detected.";
						echo "</div>";
						break;
					}
					// MEDIUM LEVEL SECURITY ADDITION ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
					
					/*$insert = $db->prepare("INSERT INTO users(user_id, username, password, authority);*/
					//$insert = $db->exec("INSERT INTO users VALUES(".$user_id.", '".$username."', '".$password."', ".$authority.");");
					$insert = $db->prepare("INSERT INTO users(user_id, username, password, authority) VALUES(?, ?, ?, ?);");
					$insert->bindParam(1, $user_id);
					$insert->bindParam(2, $username);
					$insert->bindParam(3, $password);
					$insert->bindParam(4, $authority);
					$insert->execute();

					if(!$insert){
						echo "<div class='error'>";
						print_r($db->errorInfo());
						echo "</div><br>";
					}
					else{
						echo "<div class='noError'>";
						echo $complete;
						echo "</div><br>";

						header("location: http://nickjwebsite.com/");
					}
				}
				catch(PDOException $e)
				{
					echo "<div class='error'>";
					echo "Something went wrong while trying to register your account.";
					echo "</div><br>";
				}
			}
			break;
		
		// ----------------------------------------------------------- HIGH LEVEL SECURITY -----------------------------------------------------------
		case 3:
			// Username errors
			if(strlen(trim($_POST['username'])) == 0)
			{
				$errors .= "You did not enter a username.<br>";
			}

			//Password errors
			if(strlen(trim($_POST['password'])) == 0 || strlen(trim($_POST['password'])) > 20)
			{
				if(strlen(trim($_POST['password'])) == 0){
					$errors .= "You did not enter a password in at least one of the password fields.<br>";
				}
				else{
					$errors .= "Password can be no longer than 20 characters.<br>";
				}
			}
			else
			{
				if($_POST['password'] != $_POST['confirmPassword'])
				{
					$errors .= "The passwords entered do not match.<br>";
				}
			}

			// Check for errors then try insert
			if(strlen($errors) > 0)
			{
				echo "<div class='error'>";
				echo $errors;
				echo "</div>";
			}
			else
			{
				//Insert submission into database and display submission complete message or error message
				try
				{
					$user_id = 0;
					$username = $_POST['username'];
					$password = $_POST['password'];
					$authority = 1;
					
					// HIGH LEVEL SECURITY ADDITION vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv
					// Filter user input
					$filteredUsername = filter_var($username, FILTER_SANITIZE_STRING);
					$filteredPassword = filter_var($password, FILTER_SANITIZE_STRING);
					// HIGH LEVEL SECURITY ADDITION ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
					
					/*$insert = $db->prepare("INSERT INTO users(user_id, username, password, authority);*/
					$insert = $db->exec("INSERT INTO users VALUES(".$user_id.", '".$filteredUsername."', '".$filteredPassword."', ".$authority.");");

					if(!$insert){
						echo "<div class='error'>";
						print_r($db->errorInfo());
						echo "</div><br>";
					}
					else{
						echo "<div class='noError'>";
						echo $complete;
						echo "</div><br>";

						header("location: http://nickjwebsite.com/");
					}
				}
				catch(PDOException $e)
				{
					echo "<div class='error'>";
					echo "Something went wrong while trying to register your account.";
					echo "</div><br>";
				}
			}
			break;
	}
}
?>

<!-- Registration form -->
<div class="loginForm">
	<div>Register - Security Level: <? echo $_SESSION['seclvl'] ?></div>
	<br>
	<form method="post">
		<label for="username">Username: </label>
		<input type="text" name="username" autocomplete="off">
		<br><br>
		<label for="password">Password: </label>
		<input type="text" name="password" autocomplete="off">
		<br><br>
		<label for="confirmPassword">Confirm password: </label>
		<input type="text" name="confirmPassword" autocomplete="off">
		<input type="submit" name="submit" value="Register">
	</form>
</div>
<div class="register">
	<br><br>
	<div class="registerButton">
		<a href="http://nickjwebsite.com">Login</a>
	</div>
</div>
</body>
</html>