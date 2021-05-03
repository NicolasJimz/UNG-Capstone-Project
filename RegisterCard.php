<!-- Account Registration Page -->
<?
$title = "Register Card";
include_once("Header.php");

// Check if user is logged in already
// If so, send to main page
if($_SESSION['key'] == 0)
{
	header("location: http://nickjwebsite.com/");
}

// Error handling
$errors = "";
$complete = "Card registered!<br>";

if(isset($_POST['submit']))
{
	switch ($_SESSION['seclvl'])
	{
		// ----------------------------------------------------------- LOW LEVEL SECURITY -----------------------------------------------------------
		case 1:
			if(strlen(trim($_POST['cardNumber'])) != 16)
			{
				$errors .= "Card number must be 16 digits.<br>";
			}
			if(strlen(trim($_POST['expiration'])) != 5)
			{
				$errors .= "Expiration date must contain 4 digits split by a slash (/).<br>";
			}
			if(strlen(trim($_POST['ccv'])) != 3)
			{
				$errors .= "Security code must be 3 digits.<br>";
			}
			if(strlen(trim($_POST['zip'])) != 5)
			{
				$errors .= "Zip code must contain 5 digits.<br>";
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
					$card_id = 0;
					$user_id = $_SESSION['user_id'];
					$cardNumber = $_POST['cardNumber'];
					$expiration = $_POST['expiration'];
					$ccv = $_POST['ccv'];
					$zip = $_POST['zip'];
					
					$insert = $db->exec("INSERT INTO cards VALUES(" . $card_id . ", " . $user_id . ", " . $cardNumber . ", '" . $expiration . "', " . $ccv . ", " . $zip . ");");
					if(!$insert){
						echo "<div class='error'>";
						print_r($db->errorInfo());
						echo "</div><br>";
					}
					else{
						echo "<div class='noError'>";
						echo $complete;
						echo "</div><br>";

						header("location: http://nickjwebsite.com/Account.php");
					}
				}
				catch(PDOException $e)
				{
					echo "<div class='error'>";
					echo "Something went wrong while trying to register your account.";
					echo "</div><br>";

					echo $sql . "<br>" . $e->getMessage();
				}
			}
			break;
		
		// ----------------------------------------------------------- MEDIUM LEVEL SECURITY -----------------------------------------------------------
		case 2:
			if(strlen(trim($_POST['cardNumber'])) != 16)
			{
				$errors .= "Card number must be 16 digits.<br>";
			}
			if(strlen(trim($_POST['expiration'])) != 5)
			{
				$errors .= "Expiration date must contain 4 digits split by a slash (/).<br>";
			}
			if(strlen(trim($_POST['ccv'])) != 3)
			{
				$errors .= "Security code must be 3 digits.<br>";
			}
			if(strlen(trim($_POST['zip'])) != 5)
			{
				$errors .= "Zip code must contain 5 digits.<br>";
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
					$card_id = 0;
					$user_id = $_SESSION['user_id'];
					$cardNumber = $_POST['cardNumber'];
					$expiration = $_POST['expiration'];
					$ccv = $_POST['ccv'];
					$zip = $_POST['zip'];
					
					// MEDIUM LEVEL SECURITY ADDITION vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv
					// Search input for SQL keywords
					if(stripos($cardNumber, 'select') || stripos($cardNumber, 'union') || stripos($cardNumber, 'drop table') || stripos($cardNumber, 'join') || stripos($cardNumber, 'update') || stripos($cardNumber, 'from') || stripos($cardNumber, 'where'))
					{
						echo "<div class='error'>";
						echo "SQL injection attack detected.";
						echo "</div>";
						break;
					}
					if(stripos($expiration, 'select') || stripos($expiration, 'union') || stripos($expiration, 'drop table') || stripos($expiration, 'join') || stripos($expiration, 'update') || stripos($expiration, 'from') || stripos($expiration, 'where'))
					{
						echo "<div class='error'>";
						echo "SQL injection attack detected.";
						echo "</div>";
						break;
					}
					if(stripos($ccv, 'select') || stripos($ccv, 'union') || stripos($ccv, 'drop table') || stripos($ccv, 'join') || stripos($ccv, 'update') || stripos($ccv, 'from') || stripos($ccv, 'where'))
					{
						echo "<div class='error'>";
						echo "SQL injection attack detected.";
						echo "</div>";
						break;
					}
					if(stripos($zip, 'select') || stripos($zip, 'union') || stripos($zip, 'drop table') || stripos($zip, 'join') || stripos($zip, 'update') || stripos($zip, 'from') || stripos($zip, 'where'))
					{
						echo "<div class='error'>";
						echo "SQL injection attack detected.";
						echo "</div>";
						break;
					}
					// MEDIUM LEVEL SECURITY ADDITION ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
					
					$insert = $db->exec("INSERT INTO cards VALUES(" . $card_id . ", " . $user_id . ", " . $cardNumber . ", '" . $expiration . "', " . $ccv . ", " . $zip . ");");
					if(!$insert){
						echo "<div class='error'>";
						print_r($db->errorInfo());
						echo "</div><br>";
					}
					else{
						echo "<div class='noError'>";
						echo $complete;
						echo "</div><br>";

						header("location: http://nickjwebsite.com/Account.php");
					}
				}
				catch(PDOException $e)
				{
					echo "<div class='error'>";
					echo "Something went wrong while trying to register your account.";
					echo "</div><br>";

					echo $sql . "<br>" . $e->getMessage();
				}
			}
			break;
		
		// ----------------------------------------------------------- HIGH LEVEL SECURITY -----------------------------------------------------------
		case 3:
			/* Dev forgets to add input length check
			if(strlen(trim($_POST['cardNumber'])) != 16)
			{
				$errors .= "Card number must be 16 digits.<br>";
			}*/
			if(strlen(trim($_POST['expiration'])) != 5)
			{
				$errors .= "Expiration date must contain 4 digits split by a slash (/).<br>";
			}
			if(strlen(trim($_POST['ccv'])) != 3)
			{
				$errors .= "Security code must be 3 digits.<br>";
			}
			if(strlen(trim($_POST['zip'])) != 5)
			{
				$errors .= "Zip code must contain 5 digits.<br>";
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
					$card_id = 0;
					$user_id = $_SESSION['user_id'];
					$cardNumber = $_POST['cardNumber'];
					$expiration = $_POST['expiration'];
					$ccv = $_POST['ccv'];
					$zip = $_POST['zip'];
					
					// HIGH LEVEL SECURITY ADDITION vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv
					// Filter user input
					$filteredCardNumber = $cardNumber;
					$filteredCardNumber = filter_var($filteredCardNumber, FILTER_SANITIZE_STRING);
					
					$filteredExpiration = $expiration;
					$filteredExpiration = filter_var($filteredExpiration, FILTER_SANITIZE_STRING);
					
					$filteredCCV = $ccv;
					$filteredCCV = filter_var($filteredCCV, FILTER_SANITIZE_STRING);
					
					$filteredZip = $zip;
					$filteredZip = filter_var($filteredZip, FILTER_SANITIZE_STRING);
					// HIGH LEVEL SECURITY ADDITION ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
					
					                                                                                     // VVV Dev mistake, unfiltered card number
					$insert = $db->exec("INSERT INTO cards VALUES(" . $card_id . ", " . $user_id . ", " . $cardNumber . ", '" . $filteredExpiration . "', " . $filteredCCV . ", " . $filteredZip . ");");
					if(!$insert){
						echo "<div class='error'>";
						print_r($db->errorInfo());
						echo "</div><br>";
					}
					else{
						echo "<div class='noError'>";
						echo $complete;
						echo "</div><br>";

						header("location: http://nickjwebsite.com/Account.php");
					}
				}
				catch(PDOException $e)
				{
					echo "<div class='error'>";
					echo "Something went wrong while trying to register your account.";
					echo "</div><br>";

					echo $sql . "<br>" . $e->getMessage();
				}
			}
			break;
	}
}
$inputType = "text";
$inputTypeZip = "text";
switch($_SESSION['seclvl'])
{
	case 1:
		$inputType = "text";
		$inputTypeZip = "text";
		$inputTypeCardNumber = "text";
		break;
		
	case 2: 
		$inputType = "number";
		$inputTypeZip = "text";
		$inputTypeCardNumber = "number";
		break;
		
	case 3:
		$inputType = "number";
		$inputTypeZip = "number";
		$inputTypeCardNumber = "text";
		break;
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
		<div>Add Card</div>
		<br>
		<label for="cardNumber">Card Number: </label>
		<input type="<? echo $inputTypeCardNumber ?>" name="cardNumber" autocomplete="off">
		<br><br><br>
		<label for="expiration">Expiration date (mm/dd): </label>
		<input type="text" name="expiration" autocomplete="off">
		<br><br><br>
		<label for="ccv">Security code: </label>
		<input type="<? echo $inputType ?>" name="ccv" autocomplete="off">
		<br><br><br>
		<label for="zip">Zip code: </label>
		<input type="<? echo $inputTypeZip ?>" name="zip" autocomplete="off">
		<br><br><br>
		<input type="submit" name="submit" value="Add card">
	</form>
	<br><br><br>
	<a href="http://nickjwebsite.com/Account.php">Cancel</a>
</div>
</body>
</html>