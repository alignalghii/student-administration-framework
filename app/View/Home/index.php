<?php
$title = 'Home';
ob_start();
?>
		<h1>Student Administration Framework</h1>
		<h2>Students</h2>
		<p><?php echo $countStudents; ?> registered</p>
		<form method="POST" action="/student/search">
			Search for name
			<input type="text" name="search_student_by_name"/>
			<p>Filters for study groups</p>
			<ul>
<?php foreach ($studyGroups as $studyGroup): ?>
				<li>
					<input type="checkbox" name="search_student_by_group[<?php echo $studyGroup['id']; ?>]"<?php if ($isGetMethod): ?>checked<?php endif; ?>/>
					<a href="/study_group/<?php echo $studyGroup['id']; ?>"><?php echo $studyGroup['name']; ?></a>
				</li>
<?php endforeach; ?>
			</ul>
			<input type="submit" value="Student search"/>
		</form>
		<?php echo $countStudents; ?> students
		<a href="/student/new">New</a>
		<form method="POST" action="student/delete">
			<table>
<?php foreach ($students as $student): ?>
				<tr>
					<td><input type="checkbox" name="delete_student[<?php echo $student['id']; ?>]"/></td>
					<td><a href="/student/<?php echo $student['id']; ?>"><?php echo $student['name']; ?></a></td>
					<td><?php echo $student['sex']; ?></td>
					<td><?php echo $student['place_and_date_of_birth']; ?></td>
					<td><?php echo $student['groups']; ?></td>
				</tr>
<?php endforeach; ?>
			</table>
			<input type="submit" value="Delete selected students"/>
		</form>
		<h2>Study groups</h2>
		<p><?php echo $countStudyGroups; ?> study groups with <?php echo $countActiveStudents; ?> students</p>
		<h2>Simple CRUD access</h2>
		<ul>
			<li><a href="/student">Student</a></li>
			<li><a href="/study_group">Study group</a></li>
			<li><a href="/student_study_group_membership">Membership between students and study groups</a></li>
		</ul>
<?php
$content = ob_get_clean();
require 'app/View/base.php';
