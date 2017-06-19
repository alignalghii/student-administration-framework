<?php
ob_start();
?>
		<p><a href="/">Back home</a></p>
		<h1><?php echo $title; ?></h1>
		<form method="POST" action="<?php echo $action; ?>">
			<?php if (!$isNew): ?><input type="hidden" name="id" value="<?php echo $id; ?>"/><?php endif; ?>
			Name
			<input type="text"       name="name"      value="<?php echo $studyGroup['name']; ?>"/>
			<?php echo $validationErrors['name'] ?? ''; ?>
			<br/>
			Leader
			<input type="text"       name="leader"    value="<?php echo $studyGroup['leader']; ?>"/>
			<br/>
			Subject
			<input type="text"       name="subject"   value="<?php echo $studyGroup['subject']; ?>"/>
			<?php echo $validationErrors['subject'] ?? ''; ?>
			<br/>
			Created
			<input type="text"       name="created"   value="<?php echo $studyGroup['created']; ?>"/>
			<?php echo $validationErrors['created'] ?? ''; ?>
			<br/>
			<input type="submit"     name="submit"    value="Submit"/>
			<a href="<?php echo $action; ?>">Reset changes</a>
		</form>
		<?php if (!$isNew): ?><form method="POST" action="/study_group/<?php echo $id; ?>/delete"><input type="submit" value="Delete"/></form><?php endif; ?>
<?php
$content = ob_get_clean();
require '../app/View/base.php';
