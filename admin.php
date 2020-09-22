<?php
	date_default_timezone_set('Asia/Tokyo');
	$week = array( "日", "月", "火", "水", "木", "金", "土", "日", "月", "火", "水", "木", "金", "土"  );
	$week_0 = $week[date("w")];
	$week_1 = $week[date("w")+1];
	$week_2 = $week[date("w")+2];
	$week_3 = $week[date("w")+3];
	$week_4 = $week[date("w")+4];
	$week_5 = $week[date("w")+5];
	$week_6 = $week[date("w")+6];
	$week_7 = $week[date("w")+7];

	$date_0 = date('d');
	$date_1 = date('d', strtotime('+1 day'));
	$date_2 = date('d', strtotime('+2 day'));
	$date_3 = date('d', strtotime('+3 day'));
	$date_4 = date('d', strtotime('+4 day'));
	$date_5 = date('d', strtotime('+5 day'));
	$date_6 = date('d', strtotime('+6 day'));
	$date_7 = date('d', strtotime('+7 day'));

	$ymd_0 = date('Y/m/d');
	$ymd_1 = date('Y/m/d', strtotime('+1 day'));
	$ymd_2 = date('Y/m/d', strtotime('+2 day'));
	$ymd_3 = date('Y/m/d', strtotime('+3 day'));
	$ymd_4 = date('Y/m/d', strtotime('+4 day'));
	$ymd_5 = date('Y/m/d', strtotime('+5 day'));
	$ymd_6 = date('Y/m/d', strtotime('+6 day'));
	$ymd_7 = date('Y/m/d', strtotime('+7 day'));

	require('dbconnect.php');

	if($_POST["id"] != "" || $_POST["name"] != ""){ //IDおよびユーザー名の入力有無を確認
		$users = $dbh->query("SELECT * FROM members WHERE members.id='".$_POST["id"]."' OR members.name = '".$_POST["name"]."'"); //SQL文を実行して、結果を$stmtに代入する。
		$stmt = $dbh->query("SELECT masters.*, members.* FROM masters INNER JOIN members ON members.id=masters.member_id WHERE members.id='".$_POST["id"]."' OR members.name = '".$_POST["name"]."' ORDER BY masters.day DESC, masters.time1 DESC"); //SQL文を実行して、結果を$stmtに代入する。
	}

?>
<html>
    <head>
        <title>管理画面</title>
    </head>
    <body>
        <form action="" method="post">
            ID:<input type="text" name="id" value="<?php echo $_POST['id']?>">
            <?php
                if(preg_match("/[^0-9]/", $_POST['id'])){
                   echo " IDは半角数字で入力をお願いします。";
                }
            ?>
            <br>
            名前:<input type="text" name="name" value="<?php echo $_POST['name']?>"><br>
            <input type="submit">
						</form>
            <table>
            <tr>
							<th>ID</th>
							<th>名前</th>
						</tr>
							<?php foreach ($users as $user): ?>
								<tr>
									<td><?php echo $user['id']?></td>
									<td><?php echo $user['name']?></td>
								</tr>
							<?php break; ?>
							<?php endforeach; ?>
						<tr>
							<th>日にち</th>
							<th>時間</th>
							<th>医師</th>
						</tr>
						
            <!-- ここでPHPのforeachを使って結果をループさせる -->
            <?php foreach ($stmt as $row): ?>
              <tr>
								<td><?php echo $row['day']?></td>
								<td><?php echo $row['time1']?></td>
								<td><?php echo $row['doctor']?></td>
								<td><a href="view_delete.php?id=<?php print(htmlspecialchars($row['0'])); ?>">削除</a></td>
							</tr>
            <?php endforeach; ?>
        </table>
    </body>
</html>

<?php
	if($_POST['member_id'] !== '') {
		$message = $dbh->prepare('INSERT INTO masters SET member_id=?, day=?, time1=?, doctor=?, created=NOW()');
					$message->execute(array(
						$_POST['member_id'],
						$_POST['day'],
						$_POST['time1'],
						$_POST['doctor'],
					));
	} else {
		echo 'IDか名前を入力してください。';
	}
?>


<table>
	<tr>
    <th><?php echo date('Y'); ?>年</th>
    <th><?php echo $week_0 ?></th>
    <th><?php echo $week_1 ?></th>
    <th><?php echo $week_2 ?></th>
    <th><?php echo $week_3 ?></th>
    <th><?php echo $week_4 ?></th>
    <th><?php echo $week_5 ?></th>
    <th><?php echo $week_6 ?></th>
    <th><?php echo $week_7 ?></th>
  </tr>
  <tr>
		<th><?php echo date('m'); ?>月</th>
		<th><?php echo $date_0 ?></th>
		<th><?php echo $date_1 ?></th>
		<th><?php echo $date_2 ?></th>
		<th><?php echo $date_3 ?></th>
		<th><?php echo $date_4 ?></th>
		<th><?php echo $date_5 ?></th>
		<th><?php echo $date_6 ?></th>
		<th><?php echo $date_7 ?></th>
  </tr>
  <tr>
		<th>09:00〜</th>
		<?php if ($week_0 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '09:00~09:30' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '09:00~09:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_0 == "月" OR $week_0 == "火" OR $week_0 == "水" OR $week_0 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '09:00~09:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_1 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '09:00~09:30' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '09:00~09:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_1 == "月" OR $week_1 == "火" OR $week_1 == "水" OR $week_1 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '09:00~09:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_2 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '09:00~09:30' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '09:00~09:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_2 == "月" OR $week_2 == "火" OR $week_2 == "水" OR $week_2 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '09:00~09:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_3 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '09:00~09:30' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '09:00~09:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_3 == "月" OR $week_3 == "火" OR $week_3 == "水" OR $week_3 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '09:00~09:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_4 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '09:00~09:30' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '09:00~09:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_4 == "月" OR $week_4 == "火" OR $week_4 == "水" OR $week_4 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '09:00~09:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_5 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_5' AND time1 = '09:00~09:30' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '09:00~09:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_5 == "月" OR $week_5 == "火" OR $week_5 == "水" OR $week_5 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_5' AND time1 = '09:00~09:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_6 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '09:00~09:30' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '09:00~09:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
				<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_6 == "月" OR $week_6 == "火" OR $week_6 == "水" OR $week_6 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '09:00~09:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_7 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '09:00~09:30' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '09:00~09:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_7 == "月" OR $week_7 == "火" OR $week_7 == "水" OR $week_7 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '09:00~09:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '09:00~09:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
	</tr>

	
  <tr>
		<th>09:30〜</th>
		<?php if ($week_0 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '09:30~10:00' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '09:30~10:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_0 == "月" OR $week_0 == "火" OR $week_0 == "水" OR $week_0 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '09:30~10:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_1 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '09:30~10:00' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '09:30~10:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_1 == "月" OR $week_1 == "火" OR $week_1 == "水" OR $week_1 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '09:30~10:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_2 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '09:30~10:00' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '09:30~10:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_2 == "月" OR $week_2 == "火" OR $week_2 == "水" OR $week_2 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '09:30~10:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_3 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '09:30~10:00' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '09:30~10:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_3 == "月" OR $week_3 == "火" OR $week_3 == "水" OR $week_3 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '09:30~10:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_4 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '09:30~10:00' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '09:30~10:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_4 == "月" OR $week_4 == "火" OR $week_4 == "水" OR $week_4 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '09:30~10:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_5 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_5' AND time1 = '09:30~10:00' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '09:30~10:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_5 == "月" OR $week_5 == "火" OR $week_5 == "水" OR $week_5 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_5' AND time1 = '09:30~10:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_6 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '09:30~10:00' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '09:30~10:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
				<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_6 == "月" OR $week_6 == "火" OR $week_6 == "水" OR $week_6 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '09:30~10:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_7 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '09:30~10:00' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '09:30~10:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_7 == "月" OR $week_7 == "火" OR $week_7 == "水" OR $week_7 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '09:30~10:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '09:30~10:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
	</tr>

	
  <tr>
		<th>10:00〜</th>
		<?php if ($week_0 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '10:00~10:30' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '10:00~10:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_0 == "月" OR $week_0 == "火" OR $week_0 == "水" OR $week_0 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '10:00~10:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_1 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '10:00~10:30' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '10:00~10:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_1 == "月" OR $week_1 == "火" OR $week_1 == "水" OR $week_1 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '10:00~10:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_2 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '10:00~10:30' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '10:00~10:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_2 == "月" OR $week_2 == "火" OR $week_2 == "水" OR $week_2 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '10:00~10:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_3 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '10:00~10:30' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '10:00~10:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_3 == "月" OR $week_3 == "火" OR $week_3 == "水" OR $week_3 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '10:00~10:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_4 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '10:00~10:30' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '10:00~10:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_4 == "月" OR $week_4 == "火" OR $week_4 == "水" OR $week_4 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '10:00~10:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_5 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_5' AND time1 = '10:00~10:30' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '10:00~10:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_5 == "月" OR $week_5 == "火" OR $week_5 == "水" OR $week_5 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_5' AND time1 = '10:00~10:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_6 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '10:00~10:30' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '10:00~10:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
				<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_6 == "月" OR $week_6 == "火" OR $week_6 == "水" OR $week_6 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '10:00~10:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_7 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '10:00~10:30' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '10:00~10:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_7 == "月" OR $week_7 == "火" OR $week_7 == "水" OR $week_7 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '10:00~10:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '10:00~10:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
	</tr>

	
  <tr>
		<th>10:30〜</th>
		<?php if ($week_0 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '10:30~11:00' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '10:30~11:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_0 == "月" OR $week_0 == "火" OR $week_0 == "水" OR $week_0 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '10:30~11:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_1 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '10:30~11:00' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '10:30~11:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_1 == "月" OR $week_1 == "火" OR $week_1 == "水" OR $week_1 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '10:30~11:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_2 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '10:30~11:00' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '10:30~11:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_2 == "月" OR $week_2 == "火" OR $week_2 == "水" OR $week_2 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '10:30~11:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_3 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '10:30~11:00' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '10:30~11:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_3 == "月" OR $week_3 == "火" OR $week_3 == "水" OR $week_3 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '10:30~11:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_4 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '10:30~11:00' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '10:30~11:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_4 == "月" OR $week_4 == "火" OR $week_4 == "水" OR $week_4 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '10:30~11:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_5 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_5' AND time1 = '10:30~11:00' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '10:30~11:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_5 == "月" OR $week_5 == "火" OR $week_5 == "水" OR $week_5 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_5' AND time1 = '10:30~11:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_6 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '10:30~11:00' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '10:30~11:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
				<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_6 == "月" OR $week_6 == "火" OR $week_6 == "水" OR $week_6 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '10:30~11:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_7 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '10:30~11:00' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '10:30~11:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_7 == "月" OR $week_7 == "火" OR $week_7 == "水" OR $week_7 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '10:30~11:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '10:30~11:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
	</tr>

	
  <tr>
		<th>11:00〜</th>
		<?php if ($week_0 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '11:00~11:30' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '11:00~11:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_0 == "月" OR $week_0 == "火" OR $week_0 == "水" OR $week_0 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '11:00~11:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_1 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '11:00~11:30' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '11:00~11:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_1 == "月" OR $week_1 == "火" OR $week_1 == "水" OR $week_1 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '11:00~11:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_2 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '11:00~11:30' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '11:00~11:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_2 == "月" OR $week_2 == "火" OR $week_2 == "水" OR $week_2 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '11:00~11:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_3 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '11:00~11:30' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '11:00~11:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_3 == "月" OR $week_3 == "火" OR $week_3 == "水" OR $week_3 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '11:00~11:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_4 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '11:00~11:30' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '11:00~11:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_4 == "月" OR $week_4 == "火" OR $week_4 == "水" OR $week_4 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '11:00~11:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_5 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_5' AND time1 = '11:00~11:30' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '11:00~11:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_5 == "月" OR $week_5 == "火" OR $week_5 == "水" OR $week_5 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_5' AND time1 = '11:00~11:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_6 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '11:00~11:30' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '11:00~11:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
				<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_6 == "月" OR $week_6 == "火" OR $week_6 == "水" OR $week_6 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '11:00~11:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_7 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '11:00~11:30' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '11:00~11:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_7 == "月" OR $week_7 == "火" OR $week_7 == "水" OR $week_7 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '11:00~11:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '11:00~11:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
	</tr>

	
  <tr>
		<th>11:30〜</th>
		<?php if ($week_0 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '11:30~12:00' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '11:30~12:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_0 == "月" OR $week_0 == "火" OR $week_0 == "水" OR $week_0 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '11:30~12:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_1 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '11:30~12:00' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '11:30~12:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_1 == "月" OR $week_1 == "火" OR $week_1 == "水" OR $week_1 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '11:30~12:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_2 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '11:30~12:00' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '11:30~12:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_2 == "月" OR $week_2 == "火" OR $week_2 == "水" OR $week_2 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '11:30~12:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_3 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '11:30~12:00' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '11:30~12:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_3 == "月" OR $week_3 == "火" OR $week_3 == "水" OR $week_3 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '11:30~12:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_4 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '11:30~12:00' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '11:30~12:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_4 == "月" OR $week_4 == "火" OR $week_4 == "水" OR $week_4 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '11:30~12:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_5 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_5' AND time1 = '11:30~12:00' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '11:30~12:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_5 == "月" OR $week_5 == "火" OR $week_5 == "水" OR $week_5 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_5' AND time1 = '11:30~12:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_6 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '11:30~12:00' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '11:30~12:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
				<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_6 == "月" OR $week_6 == "火" OR $week_6 == "水" OR $week_6 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '11:30~12:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_7 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '11:30~12:00' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '11:30~12:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_7 == "月" OR $week_7 == "火" OR $week_7 == "水" OR $week_7 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '11:30~12:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '11:30~12:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
	</tr>

	
  <tr>
		<th>12:00〜</th>
		<?php if ($week_0 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '12:00~12:30' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '12:00~12:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_0 == "月" OR $week_0 == "火" OR $week_0 == "水" OR $week_0 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '12:00~12:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_1 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '12:00~12:30' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '12:00~12:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_1 == "月" OR $week_1 == "火" OR $week_1 == "水" OR $week_1 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '12:00~12:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_2 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '12:00~12:30' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '12:00~12:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_2 == "月" OR $week_2 == "火" OR $week_2 == "水" OR $week_2 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '12:00~12:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_3 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '12:00~12:30' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '12:00~12:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_3 == "月" OR $week_3 == "火" OR $week_3 == "水" OR $week_3 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '12:00~12:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_4 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '12:00~12:30' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '12:00~12:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_4 == "月" OR $week_4 == "火" OR $week_4 == "水" OR $week_4 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '12:00~12:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_5 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_5' AND time1 = '12:00~12:30' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '12:00~12:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_5 == "月" OR $week_5 == "火" OR $week_5 == "水" OR $week_5 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_5' AND time1 = '12:00~12:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_6 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '12:00~12:30' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '12:00~12:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
				<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_6 == "月" OR $week_6 == "火" OR $week_6 == "水" OR $week_6 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '12:00~12:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
			
		<?php if ($week_7 == "金") :?>
			<?php
				$sql_1 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '12:00~12:30' AND doctor = 'A医師'";
				$stmt_1 = $dbh->query($sql_1);
				$stmt_1->execute();
				$count_1 = $stmt_1->rowCount();
			?>
			<?php if ($count_1 >= 7): ?>
				<th>A医師
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php else: ?>
				<th>
					<form action="" method="post">
					<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '12:00~12:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				B医師
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="B医師" class="submit">
					</form>
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'B医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_7 == "月" OR $week_7 == "火" OR $week_7 == "水" OR $week_7 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '12:00~12:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '12:00~12:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
	</tr>

	
  <tr>
		<th>12:30〜</th>
		<?php for ($i=0; $i<8; $i++): ?>
			<th>休</th>
		<?php endfor; ?>
  </tr>


	<tr>
			<th>14:00〜</th>
		<?php if ($week_0 == "月" OR $week_0 == "火" OR $week_0 == "木" OR $week_0 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '14:00~14:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
				<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '14:00~14:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:00~14:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '14:00~14:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_0 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '14:00~14:30' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '14:00~14:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:00~14:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '14:00~14:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_1 == "月" OR $week_1 == "火" OR $week_1 == "木" OR $week_1 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '14:00~14:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '14:00~14:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:00~14:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '14:00~14:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_1 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '14:00~14:30' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '14:00~14:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:00~14:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '14:00~14:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_2 == "月" OR $week_2 == "火" OR $week_2 == "木" OR $week_2 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '14:00~14:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '14:00~14:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:00~14:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '14:00~14:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_0 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '14:00~14:30' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '14:00~14:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:00~14:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '14:00~14:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_3 == "月" OR $week_3 == "火" OR $week_3 == "木" OR $week_3 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '14:00~14:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '14:00~14:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:00~14:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '14:00~14:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_3 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '14:00~14:30' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '14:00~14:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:00~14:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '14:00~14:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_4 == "月" OR $week_4 == "火" OR $week_4 == "木" OR $week_4 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '14:00~14:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '14:00~14:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:00~14:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1400_0_0" value="A医師" class="submit">
					</form>
					<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '14:00~14:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_4 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '14:00~14:30' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '14:00~14:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:00~14:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '14:00~14:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_5 == "月" OR $week_5 == "火" OR $week_5 == "木" OR $week_5 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_5' AND time1 = '14:00~14:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '14:00~14:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:00~14:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '14:00~14:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_5 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_5' AND time1 = '14:00~14:30' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '14:00~14:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:00~14:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '14:00~14:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_6 == "月" OR $week_6 == "火" OR $week_6 == "木" OR $week_6 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '14:00~14:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '14:00~14:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:00~14:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '14:00~14:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_6 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '14:00~14:30' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '14:00~14:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:00~14:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '14:00~14:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_7 == "月" OR $week_7 == "火" OR $week_7 == "木" OR $week_7 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '14:00~14:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '14:00~14:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:00~14:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '14:00~14:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_7 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '14:00~14:30' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '14:00~14:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:00~14:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '14:00~14:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
	</tr>


	<tr>
			<th>14:30〜</th>
		<?php if ($week_0 == "月" OR $week_0 == "火" OR $week_0 == "木" OR $week_0 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '14:30~15:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
				<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '14:30~15:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:30~15:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '14:30~15:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_0 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '14:30~15:00' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '14:30~15:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:30~15:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '14:30~15:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_1 == "月" OR $week_1 == "火" OR $week_1 == "木" OR $week_1 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '14:30~15:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '14:30~15:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:30~15:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '14:30~15:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_1 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '14:30~15:00' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '14:30~15:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:30~15:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '14:30~15:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_2 == "月" OR $week_2 == "火" OR $week_2 == "木" OR $week_2 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '14:30~15:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '14:30~15:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:30~15:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '14:30~15:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_0 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '14:30~15:00' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '14:30~15:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:30~15:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '14:30~15:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_3 == "月" OR $week_3 == "火" OR $week_3 == "木" OR $week_3 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '14:30~15:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '14:30~15:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:30~15:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '14:30~15:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_3 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '14:30~15:00' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '14:30~15:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:30~15:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '14:30~15:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_4 == "月" OR $week_4 == "火" OR $week_4 == "木" OR $week_4 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '14:30~15:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '14:30~15:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:30~15:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1400_0_0" value="A医師" class="submit">
					</form>
					<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '14:30~15:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_4 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '14:30~15:00' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '14:30~15:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:30~15:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '14:30~15:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_5 == "月" OR $week_5 == "火" OR $week_5 == "木" OR $week_5 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_5' AND time1 = '14:30~15:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '14:30~15:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:30~15:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '14:30~15:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_5 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_5' AND time1 = '14:30~15:00' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '14:30~15:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:30~15:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '14:30~15:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_6 == "月" OR $week_6 == "火" OR $week_6 == "木" OR $week_6 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '14:30~15:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '14:30~15:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:30~15:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '14:30~15:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_6 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '14:30~15:00' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '14:30~15:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:30~15:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '14:30~15:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_7 == "月" OR $week_7 == "火" OR $week_7 == "木" OR $week_7 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '14:30~15:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '14:30~15:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:30~15:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '14:30~15:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_7 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '14:30~15:00' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '14:30~15:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:30~15:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '14:30~15:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
	</tr>


	<tr>
			<th>15:00〜</th>
		<?php if ($week_0 == "月" OR $week_0 == "火" OR $week_0 == "木" OR $week_0 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '15:00~15:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
				<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '15:00~15:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:00~15:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '15:00~15:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_0 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '15:00~15:30' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '15:00~15:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:00~15:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '15:00~15:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_1 == "月" OR $week_1 == "火" OR $week_1 == "木" OR $week_1 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '15:00~15:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '15:00~15:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:00~15:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '15:00~15:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_1 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '15:00~15:30' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '15:00~15:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:00~15:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '15:00~15:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_2 == "月" OR $week_2 == "火" OR $week_2 == "木" OR $week_2 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '15:00~15:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '15:00~15:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:00~15:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '15:00~15:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_0 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '15:00~15:30' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '15:00~15:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:00~15:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '15:00~15:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_3 == "月" OR $week_3 == "火" OR $week_3 == "木" OR $week_3 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '15:00~15:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '15:00~15:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:00~15:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '15:00~15:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_3 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '15:00~15:30' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '15:00~15:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:00~15:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '15:00~15:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_4 == "月" OR $week_4 == "火" OR $week_4 == "木" OR $week_4 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '15:00~15:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '15:00~15:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:00~15:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1400_0_0" value="A医師" class="submit">
					</form>
					<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '15:00~15:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_4 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '15:00~15:30' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '15:00~15:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:00~15:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '15:00~15:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_5 == "月" OR $week_5 == "火" OR $week_5 == "木" OR $week_5 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_5' AND time1 = '15:00~15:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '15:00~15:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:00~15:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '15:00~15:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_5 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_5' AND time1 = '15:00~15:30' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '15:00~15:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:00~15:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '15:00~15:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_6 == "月" OR $week_6 == "火" OR $week_6 == "木" OR $week_6 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '15:00~15:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '15:00~15:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:00~15:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '15:00~15:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_6 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '15:00~15:30' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '15:00~15:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:00~15:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '15:00~15:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_7 == "月" OR $week_7 == "火" OR $week_7 == "木" OR $week_7 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '15:00~15:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '15:00~15:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:00~15:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '15:00~15:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_7 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '15:00~15:30' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '15:00~15:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:00~15:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '15:00~15:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
	</tr>


	<tr>
			<th>15:30〜</th>
		<?php if ($week_0 == "月" OR $week_0 == "火" OR $week_0 == "木" OR $week_0 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '15:30~16:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
				<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '15:30~16:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:30~16:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '15:30~16:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_0 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '15:30~16:00' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '15:30~16:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:30~16:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '15:30~16:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_1 == "月" OR $week_1 == "火" OR $week_1 == "木" OR $week_1 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '15:30~16:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '15:30~16:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:30~16:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '15:30~16:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_1 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '15:30~16:00' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '15:30~16:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:30~16:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '15:30~16:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_2 == "月" OR $week_2 == "火" OR $week_2 == "木" OR $week_2 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '15:30~16:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '15:30~16:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:30~16:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '15:30~16:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_0 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '15:30~16:00' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '15:30~16:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:30~16:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '15:30~16:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_3 == "月" OR $week_3 == "火" OR $week_3 == "木" OR $week_3 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '15:30~16:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '15:30~16:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:30~16:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '15:30~16:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_3 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '15:30~16:00' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '15:30~16:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:30~16:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '15:30~16:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_4 == "月" OR $week_4 == "火" OR $week_4 == "木" OR $week_4 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '15:30~16:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '15:30~16:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:30~16:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1400_0_0" value="A医師" class="submit">
					</form>
					<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '15:30~16:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_4 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '15:30~16:00' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '15:30~16:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:30~16:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '15:30~16:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_5 == "月" OR $week_5 == "火" OR $week_5 == "木" OR $week_5 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_5' AND time1 = '15:30~16:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '15:30~16:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:30~16:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '15:30~16:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_5 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_5' AND time1 = '15:30~16:00' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '15:30~16:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:30~16:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '15:30~16:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_6 == "月" OR $week_6 == "火" OR $week_6 == "木" OR $week_6 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '15:30~16:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '15:30~16:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:30~16:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '15:30~16:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_6 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '15:30~16:00' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '15:30~16:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:30~16:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '15:30~16:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_7 == "月" OR $week_7 == "火" OR $week_7 == "木" OR $week_7 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '15:30~16:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '15:30~16:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:30~16:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '15:30~16:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_7 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '15:30~16:00' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '15:30~16:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:30~16:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '15:30~16:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
	</tr>


	<tr>
			<th>16:00〜</th>
		<?php if ($week_0 == "月" OR $week_0 == "火" OR $week_0 == "木" OR $week_0 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '16:00~16:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
				<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '16:00~16:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:00~16:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '16:00~16:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_0 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '16:00~16:30' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '16:00~16:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:00~16:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '16:00~16:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_1 == "月" OR $week_1 == "火" OR $week_1 == "木" OR $week_1 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '16:00~16:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '16:00~16:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:00~16:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '16:00~16:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_1 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '16:00~16:30' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '16:00~16:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:00~16:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '16:00~16:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_2 == "月" OR $week_2 == "火" OR $week_2 == "木" OR $week_2 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '16:00~16:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '16:00~16:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:00~16:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '16:00~16:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_0 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '16:00~16:30' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '16:00~16:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:00~16:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '16:00~16:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_3 == "月" OR $week_3 == "火" OR $week_3 == "木" OR $week_3 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '16:00~16:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '16:00~16:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:00~16:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '16:00~16:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_3 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '16:00~16:30' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '16:00~16:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:00~16:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '16:00~16:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_4 == "月" OR $week_4 == "火" OR $week_4 == "木" OR $week_4 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '16:00~16:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '16:00~16:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:00~16:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1400_0_0" value="A医師" class="submit">
					</form>
					<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '16:00~16:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_4 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '16:00~16:30' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '16:00~16:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:00~16:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '16:00~16:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_5 == "月" OR $week_5 == "火" OR $week_5 == "木" OR $week_5 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_5' AND time1 = '16:00~16:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '16:00~16:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:00~16:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '16:00~16:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_5 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_5' AND time1 = '16:00~16:30' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '16:00~16:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:00~16:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '16:00~16:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_6 == "月" OR $week_6 == "火" OR $week_6 == "木" OR $week_6 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '16:00~16:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '16:00~16:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:00~16:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '16:00~16:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_6 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '16:00~16:30' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '16:00~16:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:00~16:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '16:00~16:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_7 == "月" OR $week_7 == "火" OR $week_7 == "木" OR $week_7 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '16:00~16:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '16:00~16:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:00~16:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '16:00~16:30' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_7 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '16:00~16:30' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '16:00~16:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:00~16:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '16:00~16:30' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
	</tr>


	<tr>
			<th>16:30〜</th>
		<?php if ($week_0 == "月" OR $week_0 == "火" OR $week_0 == "木" OR $week_0 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '16:30~17:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
				<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '16:30~17:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:30~17:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '16:30~17:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_0 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '16:30~17:00' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '16:30~17:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:30~17:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_0 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_0 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '16:30~17:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_1 == "月" OR $week_1 == "火" OR $week_1 == "木" OR $week_1 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '16:30~17:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '16:30~17:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:30~17:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '16:30~17:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_1 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '16:30~17:00' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '16:30~17:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:30~17:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_1 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_1 as $post): ?>
						<?php if ($post['day'] == $ymd_1 && $post['time1'] == '16:30~17:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_2 == "月" OR $week_2 == "火" OR $week_2 == "木" OR $week_2 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '16:30~17:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '16:30~17:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:30~17:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '16:30~17:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_0 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '16:30~17:00' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '16:30~17:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:30~17:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_2 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_2 as $post): ?>
						<?php if ($post['day'] == $ymd_2 && $post['time1'] == '16:30~17:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_3 == "月" OR $week_3 == "火" OR $week_3 == "木" OR $week_3 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '16:30~17:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '16:30~17:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:30~17:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_3 && $post['time1'] == '16:30~17:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_3 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '16:30~17:00' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '16:30~17:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:30~17:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_3 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_3 as $post): ?>
						<?php if ($post['day'] == $ymd_0 && $post['time1'] == '16:30~17:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_4 == "月" OR $week_4 == "火" OR $week_4 == "木" OR $week_4 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '16:30~17:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '16:30~17:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:30~17:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1400_0_0" value="A医師" class="submit">
					</form>
					<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '16:30~17:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_4 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '16:30~17:00' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '16:30~17:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:30~17:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_4 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_4 as $post): ?>
						<?php if ($post['day'] == $ymd_4 && $post['time1'] == '16:30~17:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_5 == "月" OR $week_5 == "火" OR $week_5 == "木" OR $week_5 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_5' AND time1 = '16:30~17:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '16:30~17:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:30~17:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '16:30~17:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_5 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_5' AND time1 = '16:30~17:00' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '16:30~17:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:30~17:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_5 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_5 as $post): ?>
						<?php if ($post['day'] == $ymd_5 && $post['time1'] == '16:30~17:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_6 == "月" OR $week_6 == "火" OR $week_6 == "木" OR $week_6 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '16:30~17:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '16:30~17:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:30~17:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '16:30~17:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_6 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '16:30~17:00' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '16:30~17:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:30~17:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_6 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_6 as $post): ?>
						<?php if ($post['day'] == $ymd_6 && $post['time1'] == '16:30~17:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>

		<?php if ($week_7 == "月" OR $week_7 == "火" OR $week_7 == "木" OR $week_7 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '16:30~17:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>A医師
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '16:30~17:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:30~17:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="A医師" class="submit">
					</form>
					<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '16:30~17:00' && $post['doctor'] == 'A医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php elseif ($week_7 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '16:30~17:00' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>C医師
				<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '16:30~17:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="member_id" value="<?php print(htmlspecialchars($user['id'])); ?>"/>
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:30~17:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" value="C医師" class="submit">
					</form>
					<?php $posts_7 = $dbh->query('SELECT members.name, masters.* FROM members, masters WHERE members.id=masters.member_id'); ?>
					<?php foreach ($posts_7 as $post): ?>
						<?php if ($post['day'] == $ymd_7 && $post['time1'] == '16:30~17:00' && $post['doctor'] == 'C医師'): ?>
							<p>
								<a href="view.php?id=<?php print(htmlspecialchars($post['id'])); ?>">
									<?php print(htmlspecialchars(($post['name']), ENT_QUOTES)); ?>
								</a>
							</p>
						<?php endif; ?>
					<?php endforeach; ?>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
	</tr>


	<tr>
		<th>17:00〜</th>
		<?php for ($i=0; $i<8; $i++): ?>
			<th>休</th>
		<?php endfor; ?>
  </tr>
</table>