<?php
ob_start();
?>
		<p><a href="/student_study_group_membership">Back to list between students and study groups</a></p>
		<h1><?php echo $title; ?></h1>
		<form method="POST" action="<?php echo $action; ?>">
			<?php if (!$isNew): ?><input type="hidden" name="id" value="<?php echo $id; ?>"/><?php endif; ?>
			Identity of student belonging to the membership
			<input type="text"       name="student_id"      value="<?php echo $studentStudyGroupMembership['student_id']; ?>"/>
			<?php echo $validationErrors['student_id'] ?? ''; ?>
			<br/>
			Identity of study group belonging to the membership
			<input type="text"       name="study_group_id"  value="<?php echo $studentStudyGroupMembership['study_group_id']; ?>"/>
			<?php echo $validationErrors['study_group_id'] ?? ''; ?>
			<br/>
			<input type="submit"     name="submit"          value="Submit"/>
			<a href="<?php echo $action; ?>">Reset changes</a>
		</form>
		<?php if (!$isNew): ?><form method="POST" action="/student_study_group_membership/<?php echo $id; ?>/delete"><input type="submit" value="Delete"/></form><?php endif; ?>
<?php
$content = ob_get_clean();
require 'app/View/base.php';
