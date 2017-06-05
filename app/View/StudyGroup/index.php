<?php
$title = 'List of all study groups';
ob_start();
?>
		<p><a href="/">Back to home</a></p>
		<h1>List of all study groups</h1>
		<a href="/study_group/new">Add new study group</a>
		<ul>
<?php foreach ($studyGroups as $studyGroup): ?>
			<li><a href="<?php echo '/study_group/'.$studyGroup['id'] ?>"><?php echo $studyGroup['name']; ?></a></li>
<?php endforeach; ?>
		</ul>
<?php
$content = ob_get_clean();
require 'app/View/base.php';
