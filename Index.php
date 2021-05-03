<!-- Login Page -->
<? $title = "Login";
include "Header.php";

// Send to products page if already logged in
if($_SESSION['key'] == 1)
{
	header("location: http://nickjwebsite.com/Products.php");
}
$_SESSION['key'] = 0;
$_SESSION['productSearch'] = "";

/* Session variables: key, authority, user, user_id, password, productSearch, seclvl
key: 0 = invalid session ----------- 1 = valid session
authority: 0 = admin ----------- 1 = user
user: username
productSearch used in product page
seclvl: 1=low --- 2=med --- 3=high
*/

// Login error handling
$errors = "";
$complete = "Login successful!<br>";
if(isset($_POST['submit']))
{	
	switch ($_SESSION['seclvl']) 
		{
		// ----------------------------------------------------------- LOW LEVEL SECURITY -----------------------------------------------------------
		case 1:
			// Username error
			if(strlen(trim($_POST['username'])) == 0)
			{
				$errors .= "You did not enter a username.<br>";
			}

			// Password error
			if(strlen(trim($_POST['password'])) == 0)
			{
				$errors .= "You did not enter a password.<br>";
			}

			//Check for errors and post feedback message.
			if(strlen($errors) > 0)
			{
				echo "<div class='error'>";
				echo $errors;
				echo "</div>";
			}

			// Compare user credentials with credentials logged in database then login if equal
			else
			{
				$loginUsername = $_POST['username'];
				$loginPassword =  $_POST['password'];

				// Run DB query and compare
				$query = $db->query("SELECT * FROM users WHERE username = '".$loginUsername."' AND password = '".$loginPassword."';");
				if(!$query){
						echo "<div class='error'>";
						print_r($db->errorInfo());
						echo "</div><br>";
					}
				else{
					while($row = $query->fetch(PDO::FETCH_ASSOC))
					{
						// If user exists set valid session (1) key and session user
						if($loginUsername == $row['username'])
						{
							$_SESSION['key'] = 1;
							$_SESSION['user'] = $loginUsername;
							$_SESSION['authority'] = $row['authority'];
							$_SESSION['user_id'] = $row['user_id'];
							$_SESSION['password'] = $row['password'];

							echo "<div class='noError'>";
							echo $complete;
							echo "</div>";

							// Redirect to home page
							header("location: http://nickjwebsite.com/Products.php");
						}
					}
				}
				
			}
			// Incorrect credentials
			if(strlen(trim($errors)) == 0 && $_SESSION['key'] == 0)
			{
				echo "<div class='error'>";
				echo "The username or password you entered was incorrect.<br>";
				echo "Please try again or register an account.";
				echo "</div>";
			}
			break;
			
		// ----------------------------------------------------------- MEDIUM LEVEL SECURITY -----------------------------------------------------------
		case 2:
			// Username error
			if(strlen(trim($_POST['username'])) == 0)
			{
				$errors .= "You did not enter a username.<br>";
			}

			// Password error
			if(strlen(trim($_POST['password'])) == 0)
			{
				$errors .= "You did not enter a password.<br>";
			}

			//Check for errors and post feedback message.
			if(strlen($errors) > 0)
			{
				echo "<div class='error'>";
				echo $errors;
				echo "</div>";
			}

			// Compare user credentials with credentials logged in database then login if equal
			else
			{
				// MEDIUM LEVEL SECURITY ADDITION vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv
				// Search input for SQL keywords
				$loginUsername = $_POST['username'];
				if(stripos($loginUsername, 'select') || stripos($loginUsername, 'union') || stripos($loginUsername, 'drop table') || stripos($loginUsername, 'join') || stripos($loginUsername, 'update') || stripos($loginUsername, 'from') || stripos($loginUsername, 'where'))
				{
					echo "<div class='error'>";
					echo "SQL injection attack detected.";
					echo "</div>";
					break;
				}
				
				$loginPassword =  $_POST['password'];
				if(stripos($loginPassword, 'select') || stripos($loginPassword, 'union') || stripos($loginPassword, 'drop table') || stripos($loginPassword, 'join') || stripos($loginPassword, 'update') || stripos($loginPassword, 'from') || stripos($loginPassword, 'where'))
				{
					echo "<div class='error'>";
					echo "SQL injection attack detected.";
					echo "</div>";
					break;
				}
				// MEDIUM LEVEL SECURITY ADDITION ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
				

				// Run DB query and compare
				//$query = $db->query("SELECT * FROM users WHERE username = '".$loginUsername."' AND password = '".$loginPassword."';");
				$query = $db->prepare("SELECT * FROM users WHERE username=? AND password=?;");
				$query->bindParam(1, $loginUsername);
				$query->bindParam(2, $loginPassword);
				$query->execute();
				
				if(!$query){
						echo "<div class='error'>";
						print_r($db->errorInfo());
						echo "</div><br>";
					}
				else{
					while($row = $query->fetch(PDO::FETCH_ASSOC))
					{
						// If user exists set valid session (1) key and session user
						if($loginUsername == $row['username'])
						{
							$_SESSION['key'] = 1;
							$_SESSION['user'] = $loginUsername;
							$_SESSION['authority'] = $row['authority'];
							$_SESSION['user_id'] = $row['user_id'];
							$_SESSION['password'] = $row['password'];

							echo "<div class='noError'>";
							echo $complete;
							echo "</div>";

							// Redirect to home page
							header("location: http://nickjwebsite.com/Products.php");
						}
					}
				}
			}
			// Incorrect credentials
			if(strlen(trim($errors)) == 0 && $_SESSION['key'] == 0)
			{
				echo "<div class='error'>";
				echo "The username or password you entered was incorrect.<br>";
				echo "Please try again or register an account.";
				echo "</div>";
			}
			break;
			
		// ----------------------------------------------------------- HIGH LEVEL SECURITY -----------------------------------------------------------
		case 3:
			// Username error
			if(strlen(trim($_POST['username'])) == 0)
			{
				$errors .= "You did not enter a username.<br>";
			}

			// Password error
			if(strlen(trim($_POST['password'])) == 0)
			{
				$errors .= "You did not enter a password.<br>";
			}

			//Check for errors and post feedback message.
			if(strlen($errors) > 0)
			{
				echo "<div class='error'>";
				echo $errors;
				echo "</div>";
			}

			// Compare user credentials with credentials logged in database then login if equal
			else
			{
				// HIGH LEVEL SECURITY ADDITION vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv
				// Filter user input
				$loginUsername = $_POST['username'];
				$filteredLoginUsername = filter_var($loginUsername, FILTER_SANITIZE_STRING);
				
				$loginPassword =  $_POST['password'];
				$filteredLoginPassword = filter_var($loginPassword, FILTER_SANITIZE_STRING);
				// HIGH LEVEL SECURITY ADDITION ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
				

				// Run DB query and compare
				$query = $db->query("SELECT * FROM users WHERE username = '".$filteredLoginUsername."' AND password = '".$filteredLoginPassword."';");
				if(!$query){
						echo "<div class='error'>";
						print_r($db->errorInfo());
						echo "</div><br>";
					}
				else{
					while($row = $query->fetch(PDO::FETCH_ASSOC))
					{
						// If user exists set valid session (1) key and session user
						if($loginUsername == $row['username'])
						{
							$_SESSION['key'] = 1;
							$_SESSION['user'] = $filteredLoginUsername;
							$_SESSION['authority'] = $row['authority'];
							$_SESSION['user_id'] = $row['user_id'];
							$_SESSION['password'] = $row['password'];

							echo "<div class='noError'>";
							echo $complete;
							echo "</div>";

							// Redirect to home page
							header("location: http://nickjwebsite.com/Products.php");
						}
					}
				}
			}
			// Incorrect credentials
			if(strlen(trim($errors)) == 0 && $_SESSION['key'] == 0)
			{
				echo "<div class='error'>";
				echo "The username or password you entered was incorrect.<br>";
				echo "Please try again or register an account.";
				echo "</div>";
			}
			break;
		
		default:
			echo "<div class=error>Set the security level</div>";
			break;
	}
	
}
?>
<!-- Login form -->
<div class="loginForm">
	<br><br>
	<form method="post">
		<div>Login - Security Level: <? echo $_SESSION['seclvl'] ?> </div>
		<br>
		<label for="username">Username: </label>
		<input type="text" name="username" autocomplete="off">
		<br><br><br>
		<label for="password">Password: </label>
		<input type="text" name="password" autocomplete="off">
		<br><br><br>
		<input type="submit" name="submit" value="login">
	</form>
</div>
<br><br>

<div class="register">
	<div>Or</div>
	<br><br>
	<div class="registerButton">
		<a href="http://nickjwebsite.com/Register.php">Create an Account</a>
	</div>
	<br><br>
	<div class="registerButton">
		<a class="pageTitle" href="http://nickjwebsite.com/SetSec.php">Set Security Level</a>
	</div>
</div>
<br>
<div class="error">Warning! Please read!</div>
<div class="error">This website is intentionally vulnerable, PLEASE do not enter any real information!</div>
</body>
</html>
