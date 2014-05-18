<?php

/**
 * toBlog.php
 * Sojung Lee & Catherine Matulis
 * May 2014
 * CS304
 *
 * Redirects to other users' blogs, and allows for interactions with other blogs,
 * including following, unfollowing, liking, and commenting. 
*/

require_once("MDB2.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once("/students/cmatulis/public_html/project/blog-functions.php");
require_once("/students/cmatulis/public_html/cs304/cmatulis-dsn.inc");

$dbh = db_connect($cmatulis_dsn);
$thecookie = $_COOKIE['304bloguserphp'];

// if no one is logged in, redirect to login page
if(!isset($_COOKIE['304bloguserphp'])) {
    header('Location: blog-ex-login-user.php');
}

// if someone has clicked the unfollow button
if (isSet($_POST['unfollowfollowing'])){
	$user1 = $_POST['unfollowfollowing'];
	$user2 = $_POST['unfollowfollower'];

	// update the database
	$delete = "delete from follows where (user, following) = (?, ?)";
  	$rows = prepared_statement($dbh, $delete, array($user2, $user1));
	showBlog($dbh, $user1, $user2);
}

// if someone has clicked the follow button
else if (isSet($_POST['followfollowing'])){
	$user1 = $_POST['followfollowing']; // the user who is now being followed
	$user2 = $_POST['followfollower']; // the user who is now following user1

	// update the database
	$insert = "insert into follows(user, following) values(?, ?)";
  	$rows = prepared_statement($dbh, $insert, array($user2, $user1));
	showBlog($dbh, $user1, $user2);
}

// if someone has liked a post
else if (isSet($_GET['entry_id'])){
	$entry_id = $_GET['entry_id']; //id of the entry that was liked
	$liking_user = $thecookie;		// the user who liked the post
	$posting_user = $_GET['posting_user']; // the author of the post
	
	// do not allow a user to like their own post
	if (strcmp($liking_user, $posting_user)){
		$preparedquery4 = "select * from likes where entry_id = ? and liking_user = ?";
		$resultset4 = prepared_query($dbh, $preparedquery4, array($entry_id, $liking_user));
		$resultset4check = $resultset4 -> numRows();

	// only allow a post to be liked once by each user
		if ($resultset4check == 0){
			$insert = "insert into likes(entry_id, liking_user) values(?,?)";
			$rows = prepared_statement($dbh, $insert, array($entry_id, $liking_user));
		}
	}
	header("Location: toBlog.php?user=$posting_user");
}

// if a user is inserting a comment into a blog
else if (isSet($_POST['blogComment'])){
	$insert = "insert into comments(entry_id, commenting_user, comment_text) values(?, ?, ?)";
	$rows = prepared_statement($dbh, $insert, array($_POST['entryId'], $thecookie, $_POST['blogComment']));
	
	// determine the format of the page to be displayed depending if the user has liked their own post or has liked another user's post
	$result = ($_POST['postAuthor'] == $thecookie);
	if ($result == 1){
  		printBlog($dbh, $thecookie);
	}
	else{
		showBlog($dbh, $_POST['postAuthor'], $thecookie);
	}

}

// otherwise display the blog requested
else{
	$user = $_GET['user'];
	$result = ($user == $thecookie);
	if ($result == 1){
  		printBlog($dbh, $user);
	}
	else{
		showBlog($dbh, $user, $thecookie);
	}
}

?>

</body>
</html>