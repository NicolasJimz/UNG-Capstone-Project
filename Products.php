<!-- Products page -->
<?
$title = "Products";
include_once("Header.php");

// Check if user is logged in already
// If so, send to main page
if($_SESSION['key'] == 0)
{
	header("location: http://nickjwebsite.com/");
}

// Handle post requests
if(isset($_POST['submit']))
{
	switch ($_SESSION['seclvl'])
	{
		// ----------------------------------------------------------- LOW LEVEL SECURITY -----------------------------------------------------------
		case 1:
			if(strlen(trim($_POST['search'])) == 0)
			{
				//Set session search value to nothing and refresh
				$_SESSION['productSearch'] = "";
				header("location: http://nickjwebsite.com/Products.php");
			}
			else
			{
				//Set session search value and refresh page
				$_SESSION['productSearch'] = $_POST['search'];
				header("location: http://nickjwebsite.com/Products.php");
			}
			break;
		
		// ----------------------------------------------------------- MEDIUM LEVEL SECURITY -----------------------------------------------------------
		case 2:
			if(strlen(trim($_POST['search'])) == 0)
			{
				//Set session search value to nothing and refresh
				$_SESSION['productSearch'] = "";
				header("location: http://nickjwebsite.com/Products.php");
			}
			else
			{
				// MEDIUM LEVEL SECURITY ADDITION vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv
				// Search input for SQL key words
				$productSearch = $_POST['search'];
				if(stripos($productSearch, 'select') || stripos($productSearch, 'union') || stripos($productSearch, 'drop table') || stripos($productSearch, 'join') || stripos($productSearch, 'update') || stripos($productSearch, 'from') || stripos($productSearch, 'where'))
					{
						echo "<div class='error'>";
						echo "SQL injection attack detected.";
						echo "</div>";
						break;
					}
				// MEDIUM LEVEL SECURITY ADDITION ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
				
				//Set session search value and refresh page
				$_SESSION['productSearch'] = $productSearch;
				header("location: http://nickjwebsite.com/Products.php");
			}
			break;
		
		// ----------------------------------------------------------- HIGH LEVEL SECURITY -----------------------------------------------------------
		case 3:
			if(strlen(trim($_POST['search'])) == 0)
			{
				//Set session search value to nothing and refresh
				$_SESSION['productSearch'] = "";
				header("location: http://nickjwebsite.com/Products.php");
			}
			else
			{
				// HIGH LEVEL SECURITY ADDITION vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv
				// Filter user input
				$filteredSearch = $_POST['search'];
				$filteredSearch = filter_var($filteredSearch, FILTER_SANITIZE_STRING);
				// HIGH LEVEL SECURITY ADDITION ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
				
				//Set session search value and refresh page
				$_SESSION['productSearch'] = $filteredSearch;
				header("location: http://nickjwebsite.com/Products.php");
			}
			break;
	}
}
?>
<!-- Navbar -->
<div class="navbar">
	<div class="pageTitle"><? echo $title . " - Security Level: " . $_SESSION['seclvl'] ?></div>
	<br>
	<a href="http://nickjwebsite.com/Account.php">Account</a>
	<a href="http://nickjwebsite.com/SetSec.php">Set Security Level</a>
	<a class="logoutButton" href="http://www.nickjwebsite.com/Logout.php">Logout</a>
</div>
		
<div class="productsContainer">
	<br>
	<form method="post">
		<label for="search">Search products: </label>
		<input type="text" name="search" autocomplete="off"><br><br>
		<input type="submit" name="submit" value="Search">
	</form>
	<br>
	<!-- <form method="post">
		<input type="submit" name="reset" value="Reset">
	</form>
	<br><br> -->
	<?
		if(strlen(trim($_SESSION['productSearch'])) == 0)
		{
			$query = $db->query("SELECT * FROM products;");

			while($row = $query->fetch(PDO::FETCH_ASSOC))
			{
				$name = $row['name'];
				$price = $row['price'];
				$description = $row['description'];

				echo "<div>Item: " . $name . "</div><br>";
				echo "<div>Price: $" . $price . "</div><br>";
				echo "<div>Description: " . $description . "</div><br><br>";
				echo "<div>-----------------------------------------------------------------</div><br><br>";
			}
		}
		else
		{
			$query = $db->query("SELECT * FROM products WHERE name LIKE '%" . $_SESSION['productSearch'] . "%';");
			if(!$query){
						echo "<div class='error'>";
						print_r($db->errorInfo());
						echo "</div><br>";
					}
			else{
				while($row = $query->fetch(PDO::FETCH_ASSOC))
				{
					$name = $row['name'];
					$price = $row['price'];
					$description = $row['description'];

					echo "<div>Item: " . $name . "</div><br>";
					echo "<div>Price: $" . $price . "</div><br>";
					echo "<div>Description: " . $description . "</div><br><br>";
					echo "<div>-----------------------------------------------------------------</div><br><br>";
					$_SESSION['search'] = "";
				}
			}
		}
	?>
</div>
</body>
</html>