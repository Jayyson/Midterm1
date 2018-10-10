<?php # Script 9.5 - register.php #2
// This script performs an INSERT query to add a record to the users table.

$page_title = 'Update';
include('includes/header.html');
echo '<h1>Update Information</h1>';
echo "<pre>";
print_r($_GET['id']);
echo "</pre>";

// Check for a valid user ID, through GET or POST:
//Taken from Lab5 edit_user.php
if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { // From view_users.php
	$id = $_GET['id'];
} elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) { // Form submission.
	$id = $_POST['id'];
} else { // No valid ID, kill the script.
	echo '<p class="error">This page has been accessed in error.</p>';
	include('includes/footer.html');
	exit();
}

// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	require('mysqli_connect.php'); // Connect to the db.

	$errors = []; // Initialize an error array.

	// Check for a first name:
	if (empty($_POST['first_name'])) {
		$errors[] = 'You forgot to enter your first name.';
	} else {
		$fn = mysqli_real_escape_string($dbc, trim($_POST['first_name']));
	}

	// Check for a last name:
	if (empty($_POST['last_name'])) {
		$errors[] = 'You forgot to enter your last name.';
	} else {
		$ln = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
	}

	// Check for an email address:
	if (empty($_POST['email'])) {
		$errors[] = 'You forgot to enter your email address.';
	} else {
		$e = mysqli_real_escape_string($dbc, trim($_POST['email']));
	}

	// Check for a password and match against the confirmed password:
	if (empty($_POST['phone'])) {
		$errors[] = 'You forgot to enter a phone number.';
	} else {
		$p = mysqli_real_escape_string($dbc, trim($_POST['phone']));
	}

	if (empty($errors)) { // If everything's OK.

		// Update the user in the database...

		// Make the query:
		$q = "Update technicians set firstName = $fn, lastName = $ln, email = $e, phone = $p where techId = $id"; 
		//(first_name, last_name, email, pass, registration_date) VALUES ('$fn', '$ln', '$e', SHA2('$p', 512), NOW() )";
		$r = @mysqli_query($dbc, $q); // Run the query.
		if ($r) { // If it ran OK.

			// Print a message:
			echo '<h1>Thank you!</h1>
		<p>You are now updated</p><p><br></p>';

		} else { // If it did not run OK.

			// Public message:
			echo '<h1>System Error</h1>
			<p class="error">You could not be updated.</p>';

			// Debugging message:
			echo '<p>' . mysqli_error($dbc) . '<br><br>Query: ' . $q . '</p>';

		} // End of if ($r) IF.

		mysqli_close($dbc); // Close the database connection.

		// Include the footer and quit the script:
		include('includes/footer.html');
		exit();

	} else { // Report the errors.

		echo '<h1>Error!</h1>
		<p class="error">The following error(s) occurred:<br>';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br>\n";
		}
		echo '</p><p>Please try again.</p><p><br></p>';

	} // End of if (empty($errors)) IF.

	mysqli_close($dbc); // Close the database connection.

} // End of the main Submit conditional.
?>


}
<form action="update.php" method="post">
	<p>First Name: <input type="text" name="first_name" size="15" maxlength="20" value="<?php if (isset($_POST['firstName'])) echo $_POST['firstName']; ?>"></p>
	<p>Last Name: <input type="text" name="last_name" size="15" maxlength="40" value="<?php if (isset($_POST['lastName'])) echo $_POST['lastName']; ?>"></p>
	<p>Email Address: <input type="email" name="email" size="20" maxlength="60" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" > </p>
	<p>Password: <input type="password" name="phone" size="10" maxlength="20" value="<?php if (isset($_POST['phone'])) echo $_POST['phone']; ?>" ></p>
	<p><input type="submit" name="submit" value="Update"></p>
</form>
<?php include('includes/footer.html'); ?>