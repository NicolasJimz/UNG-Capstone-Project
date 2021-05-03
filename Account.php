<!-- Account info page -->
<?
$title = "Account Info";
include_once("Header.php");

// Check if user is logged in already
// If so, send to main page
if($_SESSION['key'] == 0)
{
	header("location: http://nickjwebsite.com/");
}
?>
<!-- Navbar -->
<div class="navbar">
	<div class="pageTitle"><? echo $title . " - Security level: " . $_SESSION['seclvl'] ?></div>
	<br>
	<a href="http://nickjwebsite.com/Products.php">Products</a>
	<a href="http://nickjwebsite.com/SetSec.php">Set Security Level</a>
	<a class="logoutButton" href="http://www.nickjwebsite.com/Logout.php">Logout</a>
</div>

<!-- Account info section -->
<div class="accountInfoContainer">
	<div>Username: <? echo $_SESSION['user']?></div><br>
	<div>Password: <? echo $_SESSION['password']?> <a href="http://nickjwebsite.com/ChangePassword.php">Change Password</a> </div><br>
	<div>
		<!-- Retrieve currently registed card number and print last 4 digits -->
		<? 
		$query = $db->query("SELECT cardNumber FROM cards WHERE user_id=" . $_SESSION['user_id'] . " LIMIT 1");
		
		$cardNumber = "";
		
		while($row = $query->fetch(PDO::FETCH_ASSOC))
		{
			$cardNumber = $row['cardNumber'];

			$cardNumber = substr($cardNumber, 12, 4);

			echo "Currently registered card: ************" . $cardNumber . "<a href=\"http://nickjwebsite.com/UpdateCard.php\">Update card</a>";
		}
		
		if(strlen(trim($cardNumber)) == 0)
		{
			echo "There is currently no card registered with this account. <a href=\"http://nickjwebsite.com/RegisterCard.php\">Add card</a>";
		}
		?>
	</div>
</div>
</body>
</html>