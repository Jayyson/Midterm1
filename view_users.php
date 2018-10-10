<?php # Script 9.6 - view_users.php #2
// This script retrieves all the records from the users table.

$page_title = 'Our Customers';
include('includes/header.html');

// Page header:
echo '<h1>User Posts</h1>';

require('mysqli_connect.php'); // Connect to the db.

$messages = 'dang';
// Make the query:
$q = "SELECT state AS state, CONCAT(firstName, ' ', lastName) AS name, email as mail, customerID from customers ORDER BY customerID ASC";
//$q = "SELECT CONCAT(users.last_name, ', ', users.first_name) AS name, messages.body as message FROM users INNER JOIN messages ON messages.user_id = users.user_id WHERE messages.user_id = 1";
$r = @mysqli_query($dbc, $q); // Run the query.

// Count the number of returned rows:
$num = mysqli_num_rows($r);

if ($num > 0) { // If it ran OK, display the records.

	// Print how many users there are:
	echo "<p>There are currently $num registered cust.</p>\n";

	// Table header.
	echo '<table width="90%">
	<thead>
	<tr>
		<th align="left">State</th>
		<th align="left">Name</th>
		<th align="left">Email</th>
		<th align="left">Customer Incidents</th>
		<th align="left">Customer Reports</th>
	</tr>
	</thead>
	<tbody>
';

	// Fetch and print all the records:
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		echo '<tr><td align="left">' . $row['state'] . '<td align="left">' . $row['name'] .'<td align="left">' . $row['mail'] .'</td><td align="left">' . '<a href="actual_incidents.php?id=' . $row['customerID'] . '">View Customer Incidents</a>'  .'</td><td align="left">' . '<a href="registration.php?id=' . $row['customerID'] . '">View Products by Customer</a>'  .'</td></tr>
		';
	}

	echo '</tbody></table>'; // Close the table.

	mysqli_free_result ($r); // Free up the resources.

} else { // If no records were returned.

	echo '<p class="error">This user has no posts.</p>';

}

mysqli_close($dbc); // Close the database connection.

include('includes/footer.html');
?>