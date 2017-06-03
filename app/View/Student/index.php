<?php
$title = 'List of all students';
ob_start();
?>
		<h1>List of all students</h1>
		<p>Listing here...</p>
<?php
$content = ob_get_clean();
require 'app/View/base.php';
