<?php

/**
 * followingPage.php
 * Sojung Lee & Catherine Matulis
 * May 2014
 * CS304
 *
 * Calls the function to print the page showing the users that the currently logged-in
 * user is following
*/

require_once("MDB2.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once("/students/cmatulis/public_html/project/blog-functions.php");
require_once("/students/cmatulis/public_html/cs304/cmatulis-dsn.inc");

$dbh = db_connect($cmatulis_dsn);

session_start();

// if a user is not currently logged in, redirect to the login page
if(!isset($_SESSION['user'])) {
    header('Location: blog-login.php');
}

// get the currently logged-in user
$user = $_SESSION['user']; 

// print the page showing the blogs that the current user is following
printFollowingPage($dbh, $user);

?>

</body>
</html>