<?php
$title = 'Greeting site';
ob_start();
?>
		<h1>Greeting site</h1>
		<p>Hello!</p>
		<ul>
			<li><a href="/student">Student</a></li>
			<li><a href="/study_group">Study group</a></li>
		</ul>
<?php
$content = ob_get_clean();
require 'app/View/base.php';
