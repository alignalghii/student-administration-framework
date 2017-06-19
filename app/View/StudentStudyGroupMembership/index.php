<?php
$title = 'List of all memberships between students and study groups';
ob_start();
?>
		<p><a href="/">Back to home</a></p>
		<h1>List of all memberships between students and study groups</h1>
		<a href="/student_study_group_membership/new">Add new membership between students and study groups</a>
		<ul>
<?php foreach ($studentStudyGroupMemberships as $studentStudyGroupMembership): ?>
			<li>Membership #<a href="<?php echo '/student_study_group_membership/'.$studentStudyGroupMembership['id'] ?>"><?php echo $studentStudyGroupMembership['id']; ?></a> between student #<a href="/student/<?php echo $studentStudyGroupMembership['student_id']; ?>"><?php echo $studentStudyGroupMembership['student_id']; ?></a> and study group #<a href="/study_group/<?php echo $studentStudyGroupMembership['study_group_id']; ?>"><?php echo $studentStudyGroupMembership['study_group_id']; ?></a></li>
<?php endforeach; ?>
		</ul>
<?php
$content = ob_get_clean();
require '../app/View/base.php';
