<?php
session_start();
require('dbconnect.php');

if (empty($_REQUEST['id'])) {
	header('Location: reservation.php');
	exit();
}

$posts = $dbh->prepare('SELECT m.name, p.* FROM members m, masters p WHERE m.id=p.member_id AND p.id=?');
$posts->execute(array($_REQUEST['id']));
?>

<?php if ($post = $posts->fetch()): ?>
	<p>
		<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>様 
		<?php print(htmlspecialchars(($post['day']), ENT_QUOTES)); ?> 
		<?php print(htmlspecialchars(($post['time1']), ENT_QUOTES)); ?> 
		<a href="view_delete.php?id=<?php print(htmlspecialchars($post['id'])); ?>">削除</a>
	</p>
<?php else: ?>
<?php endif; ?>