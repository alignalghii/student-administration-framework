<?php
$title = "Student #$id";
ob_start();
?>
		<h1>Student #<?php echo $id; ?></h1>
		<p>Details...</p>
<?php
$content = ob_get_clean();
require 'app/View/base.php';
