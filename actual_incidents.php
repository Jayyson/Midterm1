<?php # Script 9.6 - view_users.php #2
// This script retrieves all the records from the users table.

$page_title = 'Customer Incidents';
include('includes/header.html');

// Page header:
echo '<h1>User Incidents</h1>';

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
$q = "Select customers.customerID, incidents.incidentID AS lid2, incidents.title as title, incidents.productCode as code, incidents.techID as tid, CONCAT(technicians.firstName, ' ', technicians.lastName) AS tname FROM customers INNER JOIN incidents on customers.customerID = incidents.customerID INNER JOIN technicians on incidents.techID = technicians.techID WHERE customers.customerID = $id";
//$q = "SELECT CONCAT(users.last_name, ', ', users.first_name) AS name, messages.body as message FROM users INNER JOIN messages ON messages.user_id = users.user_id WHERE messages.user_id = 1";
$r = @mysqli_query($dbc, $q); // Run the query.

// Count the number of returned rows:
$num = mysqli_num_rows($r);

if ($num > 0) { // If it ran OK, display the records.

	// Print how many users there are:
	echo "<p>There are currently $num incidents for the following customer.</p>\n";

	// Table header.
	echo '<table width="100%">
	<thead>
	<tr>
		<th align="left">Incident ID</th>
		<th align="left">Title</th>
		<th align="left">Product Code</th>
		<th align="left">Tech Name</th>
	</tr>
	</tr>
	</thead>
	<tbody>
';

	// Fetch and print all the records:
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		echo '<tr><td align="left">' . $row['lid2'] . '</td><td align="left">' . $row['title'] .'</td><td align="left">' . $row['code'] . '</td><td align="left">' . $row['tname'] . '</td></tr>';
	}

	echo '</tbody></table>'; // Close the table.

	mysqli_free_result ($r); // Free up the resources.

} else { // If no records were returned.

	echo '<p class="error">This user has no incidents.</p>';

}

mysqli_close($dbc); // Close the database connection.

include('includes/footer.html');
?>