<?php # Script 9.6 - view_users.php #2
// This script retrieves all the records from the users table.

$page_title = 'Registrations';
include('includes/header.html');

// Page header:
echo '<h1>Product Registrations for Customer</h1>';

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

require('mysqli_connect.php'); // Connect to the db.

$messages = 'dang';
// Make the query:
//$q = "SELECT username AS name, user_id from users";
$q = "Select customers.customerID AS id, CONCAT(customers.firstName, ' ', customers.lastName) AS cname, registrations.productCode as code, products.name as name FROM customers INNER JOIN registrations on customers.customerID = registrations.customerID INNER JOIN products on registrations.productCode = products.productCode WHERE customers.customerID = $id";
//$q = "SELECT CONCAT(users.last_name, ', ', users.first_name) AS name, messages.body as message FROM users INNER JOIN messages ON messages.user_id = users.user_id WHERE messages.user_id = 1";
$r = @mysqli_query($dbc, $q); // Run the query.

// Count the number of returned rows:
$num = mysqli_num_rows($r);

if ($num > 0) { // If it ran OK, display the records.

	// Print how many users there are:
	echo "<p>There are currently $num registrations for the following customer.</p>\n";

	// Table header.
	echo '<table width="100%">
	<thead>
	<tr>
		<th align="left">Product Code</th>
		<th align="left">Product Name</th>
		<th align="left">Customer Name</th>
	</tr>
	</thead>
	<tbody>
';

	// Fetch and print all the records:
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		echo '<tr><td align="left">' . $row['code'] . '</td><td align="left">' . $row['name'] .'</td><td align="left">' . $row['cname'] . '</td></tr>';
	}

	echo '</tbody></table>'; // Close the table.

	mysqli_free_result ($r); // Free up the resources.

} else { // If no records were returned.

	echo '<p class="error">This user has no products.</p>';

}

mysqli_close($dbc); // Close the database connection.

include('includes/footer.html');
?>