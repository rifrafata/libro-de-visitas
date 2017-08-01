
<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html>
<body>

<h1>Log Out</h1>

<form method="post">
	<input type="button" name="bnt_logout" value="Log out">
</form>


<?php
if(isset($_POST))
		// remove all session variables
	session_unset(); 

	// destroy the session 
	session_destroy(); 
	 header("Location: login.php")
?>

</body>
</html>