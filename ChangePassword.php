<!-- Change password -->
<?
$title = "Change Password";
include_once("Header.php");

// Check if user is logged in already
// If so, send to main page
if($_SESSION['key'] == 0)
{
	header("location: http://nickjwebsite.com/");
}

// Error handling
$errors = "";
$complete = "Password change successful!<br>";

if(isset($_POST['submit']))
{
	switch ($_SESSION['seclvl'])
	{
		// ----------------------------------------------------------- LOW LEVEL SECURITY -----------------------------------------------------------
		case 1:
			// Current password errors
			if(strlen(trim($_POST['password'])) == 0 || strlen(trim($_POST['confirmPassword'])) == 0)
			{
				$errors .= "One or both of the current password fields was left empty.<br>";
			}

			if($_POST['password'] != $_POST['confirmPassword'])
			{
				$errors .= "The current password fields do not match.<br>";
			}

			if(strlen(trim($_POST['newPassword'])) == 0)
			{
				$errors .= "The new password field was left empty.<br>";
			}
			if($_POST['password'] != $_SESSION['password'])
			{
				$errors .= "The password you entered for this account was incorrect.<br>";
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
				// Update account password or supply error message
				try
				{
					$newPassword = $_POST['newPassword'];
					$username = $_SESSION['user'];
					$oldPassword = $_POST['password'];
					
					$update = $db->exec("UPDATE users SET `password`='" . $newPassword . "' WHERE username='" . $username . "' AND password='" . $oldPassword . "';");
					if(!$update){
						echo "<div class='error'>";
						print_r($db->errorInfo());
						echo "</div><br>";
					}
					else{
						$_SESSION['password'] = $_POST['newPassword'];

						echo "<div class='noError'>";
						echo $complete;
						echo "</div><br>";

						header("location: http://nickjwebsite.com/Account.php");
					}
				}
				catch(PDOException $e)
				{
					echo "<div class='error'>";
					echo "Something went wrong while trying to update your password.";
					echo "</div><br>";

					echo $sql . "<br>" . $e->getMessage();
				}
			}
			break;
		
		// ----------------------------------------------------------- MEDIUM LEVEL SECURITY -----------------------------------------------------------
		case 2:
			// Current password errors
			if(strlen(trim($_POST['password'])) == 0 || strlen(trim($_POST['confirmPassword'])) == 0)
			{
				$errors .= "One or both of the current password fields was left empty.<br>";
			}

			if($_POST['password'] != $_POST['confirmPassword'])
			{
				$errors .= "The current password fields do not match.<br>";
			}

			if(strlen(trim($_POST['newPassword'])) == 0)
			{
				$errors .= "The new password field was left empty.<br>";
			}
			if($_POST['password'] != $_SESSION['password'])
			{
				$errors .= "The password you entered for this account was incorrect.<br>";
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
				// Update account password or supply error message
				try
				{
					$newPassword = $_POST['newPassword'];
					$username = $_SESSION['user'];
					$oldPassword = $_POST['password'];
					
					// MEDIUM LEVEL SECURITY ADDITION vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv
					// Search input for SQL keywords
					if(stripos($newPassword, 'select') || stripos($newPassword, 'union') || stripos($newPassword, 'drop table') || stripos($newPassword, 'join') || stripos($newPassword, 'update') || stripos($newPassword, 'from') || stripos($newPassword, 'where'))
					{
						echo "<div class='error'>";
						echo "SQL injection attack detected.";
						echo "</div>";
						break;
					}
					if(stripos($oldPassword, 'select') || stripos($oldPassword, 'union') || stripos($oldPassword, 'drop table') || stripos($oldPassword, 'join') || stripos($oldPassword, 'update') || stripos($oldPassword, 'from') || stripos($oldPassword, 'where'))
					{
						echo "<div class='error'>";
						echo "SQL injection attack detected.";
						echo "</div>";
						break;
					}
					// MEDIUM LEVEL SECURITY ADDITION ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
					
					$update = $db->exec("UPDATE users SET `password`='" . $newPassword . "' WHERE username='" . $username . "' AND password='" . $oldPassword . "';");
					if(!$update){
						echo "<div class='error'>";
						print_r($db->errorInfo());
						echo "</div><br>";
					}
					else{
						$_SESSION['password'] = $_POST['newPassword'];

						echo "<div class='noError'>";
						echo $complete;
						echo "</div><br>";

						header("location: http://nickjwebsite.com/Account.php");
					}
				}
				catch(PDOException $e)
				{
					echo "<div class='error'>";
					echo "Something went wrong while trying to update your password.";
					echo "</div><br>";

					echo $sql . "<br>" . $e->getMessage();
				}
			}
			break;
		
		// ----------------------------------------------------------- HIGH LEVEL SECURITY -----------------------------------------------------------
		case 3:
			// Current password errors
			if(strlen(trim($_POST['password'])) == 0 || strlen(trim($_POST['confirmPassword'])) == 0)
			{
				$errors .= "One or both of the current password fields was left empty.<br>";
			}

			if($_POST['password'] != $_POST['confirmPassword'])
			{
				$errors .= "The current password fields do not match.<br>";
			}

			if(strlen(trim($_POST['newPassword'])) == 0)
			{
				$errors .= "The new password field was left empty.<br>";
			}
			if($_POST['password'] != $_SESSION['password'])
			{
				$errors .= "The password you entered for this account was incorrect.<br>";
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
				// Update account password or supply error message
				try
				{
					$newPassword = $_POST['newPassword'];
					$username = $_SESSION['user'];
					$oldPassword = $_POST['password'];
					
					// HIGH LEVEL SECURITY ADDITION vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv
					// Filter user input
					$filteredNewPass = $newPassword;
					$filteredNewPass = filter_var($filteredNewPass, FILTER_SANITIZE_STRING);
					
					$filteredOldPass = $oldPassword;
					$filteredOldPass = filter_var($filteredOldPass, FILTER_SANITIZE_STRING);
					// HIGH LEVEL SECURITY ADDITION ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
					
					$update = $db->exec("UPDATE users SET `password`='" . $filteredNewPass . "' WHERE username='" . $username . "' AND password='" . $filteredOldPass . "';");
					if(!$update){
						echo "<div class='error'>";
						print_r($db->errorInfo());
						echo "</div><br>";
					}
					else{
						$_SESSION['password'] = $_POST['newPassword'];

						echo "<div class='noError'>";
						echo $complete;
						echo "</div><br>";

						header("location: http://nickjwebsite.com/Account.php");
					}
				}
				catch(PDOException $e)
				{
					echo "<div class='error'>";
					echo "Something went wrong while trying to update your password.";
					echo "</div><br>";

					echo $sql . "<br>" . $e->getMessage();
				}
			}
			break;
	}
}
?>
<!-- Navbar -->
<div class="navbar">
	<div class="pageTitle"><? echo $title . " - Security Level: " . $_SESSION['seclvl'] ?></div>
	<br>
	<a href="http://nickjwebsite.com/Products.php">Products</a>
	<a href="http://nickjwebsite.com/SetSec.php">Set Security Level</a>
	<a class="logoutButton" href="http://www.nickjwebsite.com/Logout.php">Logout</a>
</div>

<!-- Change Password Form -->
<div class="accountInfoContainer">
	<form method="post">
		<div>Change Password</div>
		<br>
		<label for="password">Current password: </label>
		<input type="text" name="password" autocomplete="off">
		<br><br><br>
		<label for="confirmPassword">Confirm current password: </label>
		<input type="text" name="confirmPassword" autocomplete="off">
		<br><br><br>
		<label for="newPassword">New password: </label>
		<input type="text" name="newPassword" autocomplete="off">
		<br><br><br>
		<input type="submit" name="submit" value="Change password">
	</form>
	<br><br><br>
	<a href="http://nickjwebsite.com/Account.php">Cancel</a>
</div>
</body>
</html>