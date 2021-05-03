<!-- Login Page -->
<? $title = "Set Security Level";
include "Header.php";

// Set security level on submit
$errors = "";
if(isset($_POST['submit']))
{	
	// Just in case user changes values with inspect
	if($_POST['seclvl'] < 1 || $_POST['seclvl'] > 3)
	{
		$errors .= "Inspect this :p<br>";
	}
	
	// Check for errors and post feedback message.
	if(strlen($errors) > 0)
	{
		echo "<div class='error'>";
		echo $errors;
		echo "</div>";
	}
	// Set security level
	else
	{
		$_SESSION['seclvl'] = $_POST['seclvl'];
		
		switch ($_SESSION['seclvl']) 
		{
			case 1:
				$complete = "Security level set to low!<br>";
				break;
			case 2:
				$complete = "Security level set to medium!<br>";
				break;
			case 3:
				$complete = "Security level set to high!<br>";
				break;
		}
		
		echo "<div class='noError'>";
		echo $complete;
		echo "</div>";
		
		// Find out if user came from login or within web app then return
		if ($_SESSION['key'] == 1){
			header("location: http://nickjwebsite.com/Products.php");
		}
		else{
			header("location: http://nickjwebsite.com");
		}
	}
}

?>
<!-- Navbar -->
<div class="navbar">
	<div class="pageTitle"><? echo $title ?></div>
</div>
<br><br>

<!-- Set Security Form -->
<div class="loginForm">
	<br><br>
	<form method="post">
		<div>Set Security Level</div>
		<br>
		<label for="seclvl">Select Security Level: </label>
		<select name="seclvl" id="seclvl">
		  <option value=1>Low</option>
		  <option value=2>Medium</option>
		  <option value=3>High</option>
		</select>
		<input type="submit" name="submit" value="Set">
	</form>
</div>
</body>
</html>