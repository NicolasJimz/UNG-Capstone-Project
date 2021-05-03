<!-- Logout Page -->
<?
$title = "Logout";
include_once("Header.php");

$_SESSION['key'] = 0;
$_SESSION['authority'] = 1;
$_SESSION['user'] = "";
$_SESSION['user_id'] = -1;
$_SESSION['password'] = "";
$_SESSION['productSearch'] = "";
$_SESSION['seclvl'] = 1;

//Remove data from session
$_SESSION = array();

//Delete session 
session_destroy();



//Redirect back to login
header("location: http://nickjwebsite.com/");
?>
<div>Logging you out</div>
</body>
</html>