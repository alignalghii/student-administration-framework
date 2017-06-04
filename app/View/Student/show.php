<?php
$title = "Student #$id";
ob_start();
?>
		<p><a href="/student">Back to student list</a></p>
		<h1>Student #<?php echo $id; ?></h1>
		<form method="POST" action="/student/<?php echo $id; ?>">
			<input type="hidden" name="id" value="<?php echo $id; ?>"/>
			Name <input type="text" name="name" value="<?php echo $student['name']; ?>"/>
			<?php echo $validationErrors['name'] ?? ''; ?>
			<br/>
			Male <input type="checkbox" name="is_male"<?php if ($student['is_male']): ?>checked<?php endif; ?>/>
			<br/>
			Place of birth <input type="text" name="place_of_birth" value="<?php echo $student['place_of_birth']; ?>"/>
			<br/>
			Date of birth <input type="text" name="date_of_birth" value="<?php echo $student['date_of_birth']; ?>"/>
			<?php echo $validationErrors['date_of_birth'] ?? ''; ?>
			<br/>
			Email <input type="text" name="email" value="<?php echo $student['email']; ?>"/>
			<?php echo $validationErrors['email'] ?? ''; ?>
			<br/>
			<input type="submit" name="submit" value="Submit"/>
			<a href="/student/<?php echo $id; ?>">Reset changes</a>
		</form>
<?php
$content = ob_get_clean();
require 'app/View/base.php';
