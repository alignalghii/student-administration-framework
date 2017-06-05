<?php
$title = 'List of all students';
ob_start();
?>
		<p><a href="/">Back to home</a></p>
		<h1>List of all students</h1>
		<a href="/student/new">Add new student</a>
		<ul>
<?php foreach ($students as $student): ?>
			<li><a href="<?php echo '/student/'.$student['id'] ?>"><?php echo $student['name']; ?></a></li>
<?php endforeach; ?>
		</ul>
<?php
$content = ob_get_clean();
require 'app/View/base.php';
