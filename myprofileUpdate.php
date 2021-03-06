<?php

/**
 * myprofileUpdate.php
 * Sojung Lee & Catherine Matulis
 * May 2014
 * CS304
 *
 * Creates a page with a form that allows the user to update their profile
*/

require_once("MDB2.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once("/students/cmatulis/public_html/project/blog-functions.php");
require_once("/students/cmatulis/public_html/cs304/cmatulis-dsn.inc");

$dbh = db_connect($cmatulis_dsn);

session_start();

// if a user is not currently logged in, redirect to the home page
if(!isset($_SESSION['user'])) {
    header('Location: blog-login.php');
}

$user = $_SESSION['user'];
?> 

<!DOCTYPE html>
<html lang="en">

<?php
	printPageTop('profile');
?>

    	<div class="blog-masthead">
      		<div class="container">
        		<nav class="blog-nav">
          			<ul class="nav navbar-nav">
            				<li><a class="blog-nav-item" href="blog-ex-comment-user.php">Blog</a></li>
            				<li><a class="blog-nav-item" href = "postPage.php?type=">Post</a></li>
            				<li><a class="blog-nav-item" href="followersPage.php">Followers</a></li>
            				<li><a class="blog-nav-item" href="followingPage.php">Following</a></li>
            				<li><a class="blog-nav-item active" href ="#">Profile</a></li>
            				<li><a class="blog-nav-item" href = "toHomePage.php">Home</a></li>
            				<li><a class="blog-nav-item" href = "logoutPage.php">Logout</a></li>
          			</ul>
          			<form class="navbar-form navbar-right" role="search" action="searchResults.php">
            				<div class="form-group">
              				<input type="text" class="form-control" placeholder="Search" name="searchentry">
            				</div>
            				<button type="submit" class="btn btn-default">Submit</button>
          			</form>
        		</nav>
      		</div>
    	</div>

    	<div class="container">
      		<div class="blog-header">
        		<?php echo "<h1 class='blog-title'>$user's Profile</h1>";
           		?>

      		</div>
      		<br>

		<?php
			//Get the user's current profile and
			// print a form pre-filled with the current profile
 			$preparedquery = "SELECT * from profile where user = ?";
			$resultset = prepared_query($dbh, $preparedquery, $user);
			while ($row = $resultset -> fetchRow(MDB2_FETCHMODE_ASSOC)){
				$fullname = $row['fullname'];
				$birthdate = $row['birthdate'];
				$city = $row['city'];
				$state = $row['state'];
				$country = $row['country'];
				$interests = $row['interests'];
				$aboutme = $row['profile'];
			}
			print <<<EOT
				<form class="form-horizontal" method="post" enctype = "multipart/form-data" action = "myprofile.php">  
      					<div class="row">
      						<div class="col-md-3"><h4><strong>Full Name</strong></h4></div>
      	 						<input type='text' name = 'fullname' value = $fullname>
      						</div>  
      					<div class="row">
      						<div class="col-md-3"><h4><strong>Birthdate</strong></h4></div>
      							<input type='text' name = 'birthdate' value = $birthdate>
      						</div>
      					<div class="row">
      						<div class="col-md-3"><h4><strong>City</strong></h4></div>
      							<input type='text' name = 'city' value = $city>
      						</div>
      					<div class="row">
      						<div class="col-md-3"><h4><strong>State</strong></h4></div>
      							<input type='text' name = 'state' value = '$state'>
      						</div>
      					<div class="row">
      						<div class="col-md-3"><h4><strong>Country</strong></h4></div>
      							<input type='text' name = 'country' value = $country>
      						</div>
      					<div class="row">
      						<div class="col-md-3"><h4><strong>Interests</strong></h4></div>
      							<input type='text' name = 'interests' value = $interests>
      						</div>
					<div class="row">
      						<div class="col-md-3"><h4><strong>About Me</strong></h4></div>
      							<input type='text' name = 'aboutme' value = $aboutme>
      						</div> 
      					<div class="row">
      					<button type="submit" class="btn btn-primary">Save Changes</button>  
      				</div>  
			</form>
    </div> <!-- container -->

    <script src="http://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.2.0/respond.js"></script>

    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.0-rc2/js/bootstrap.min.js"></script>
EOT;
?>
</body>
</html>