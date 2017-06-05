<?php
ob_start();
?>
		<p><a href="/student">Back to student list</a></p>
		<h1><?php echo $title; ?></h1>
		<form method="POST" action="<?php echo $action; ?>">
			<?php if (!$isNew): ?><input type="hidden" name="id" value="<?php echo $id; ?>"/><?php endif; ?>
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
			<a href="<?php echo $action; ?>">Reset changes</a>
		</form>
<?php
$content = ob_get_clean();
require 'app/View/base.php';
