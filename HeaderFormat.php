<?
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><? echo $title; ?></title>
	<link href="http://www.nickjwebsite.com/LoginStyleSheet.css" rel="stylesheet" type="text/css">
	<link href="http://www.nickjwebsite.com/AccountStyleSheet.css" rel="stylesheet" type="text/css">
	<link href="http://www.nickjwebsite.com/ProductsStyleSheet.css" rel="stylesheet" type="text/css">
	
</head>
<body>
	<!-- Connect to db -->
	<? 
	$host = "";
	$database = "";
	$username = "";
	$password = "";
	try{
		$db = new PDO("mysql:host=$host; dbname=$database;", $username, $password);
	}
	catch(Exception $e){
		echo("<div>Something went wrong while trying to connect to database.</div><br>");
	}
	?>