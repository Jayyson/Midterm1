<?php # Script 9.6 - view_users.php #2
// This script retrieves all the records from the users table.

$page_title = 'All incidents';
include('includes/header.html');

// Page header:
echo '<h1>All Incidents</h1>';



require('mysqli_connect.php'); // Connect to the db.

$messages = 'dang';
// Make the query:
//$q = "SELECT username AS name, user_id from users";
$q = "Select incidentID as id, title as title, productCode as code, dateOpened as date, incidentID, CONCAT(technicians.firstName, ' ', technicians.lastName) AS name from incidents INNER JOIN technicians on incidents.techID = technicians.techID";
//$q = "SELECT CONCAT(users.last_name, ', ', users.first_name) AS name, messages.body as message FROM users INNER JOIN messages ON messages.user_id = users.user_id WHERE messages.user_id = 1";
$r = @mysqli_query($dbc, $q); // Run the query.

// Count the number of returned rows:
$num = mysqli_num_rows($r);

if ($num > 0) { // If it ran OK, display the records.

	// Print how many users there are:
	echo "<p>There are currently $num incidents in total.</p>\n";

	// Table header.
	echo '<table width="100%">
	<thead>
	<tr>
		<th align="left">Tech Name</th>
		<th align="left">Incident ID</th>
		<th align="left">Title</th>
		<th align="left">Product Code</th>
		<th align="left">Date Opened</th>
	</tr>
	</thead>
	<tbody>
';

	// Fetch and print all the records:
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		echo '<tr><td align="left">' . $row['name'] . '</td><td align="left">' . $row['incidentID'] .'</td><td align="left">' . $row['title'] .'</td><td align="left">' . $row['code'] .'</td><td align="left">' . $row['date'] . '</td></tr>';
	}

	echo '</tbody></table>'; // Close the table.

	mysqli_free_result ($r); // Free up the resources.

} else { // If no records were returned.

	echo '<p class="error">This user has no posts.</p>';

}

mysqli_close($dbc); // Close the database connection.

include('includes/footer.html');
?>