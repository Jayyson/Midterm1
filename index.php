<?php # Script 3.7 - index.php #2

// This function outputs theoretical HTML
// for adding ads to a Web page.
function create_ad() {
  echo '<div class="alert alert-info" role="alert"><p>Midterm Exam Justin Carr.  All Pages working except update functionality for technicians on technicians update page.</p></div>';
} // End of the function definition.

$page_title = 'Welcome to this Site!';
include('includes/header.html');

// Call the function:
create_ad();
?>

<div class="page-header"><h1>Content Header</h1></div>
<p>I think I did good.  I accidentally deleted most of my work in the middle of this exam</p>


<?php
// Call the function again:
create_ad();

include('includes/footer.html');
?>