
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

	session_start();
	require('dbconnect.php');

	
	if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
		$_SESSION['time'] = time();
	
		$members = $dbh->prepare('SELECT * FROM members WHERE id=?');
		$members->execute(array($_SESSION['id']));
		$member = $members->fetch();
	} else {
		header('Location: index.php');
		exit();
	}
	
	if (!empty($_POST)) {
		if($_POST['day'] !== '') {
			$message = $dbh->prepare('INSERT INTO masters SET member_id=?, day=?, time1=?, doctor=?, created=NOW()');
			$message->execute(array(
				$member['id'],
				$_POST['day'],
				$_POST['time1'],
				$_POST['doctor'],
			));
		}
	}
	
	$posts = $dbh->query('SELECT m.name, p.* FROM members m, masters p WHERE m.id=p.member_id ORDER BY p.day DESC, p.time1 DESC');
	
	
	if(isset($_POST['regist_0900_0_0'])){
		// 変数とタイムゾーンを初期化
		$header = null;
		$auto_reply_subject = null;
		$auto_reply_text = null;
		date_default_timezone_set('Asia/Tokyo');

		$header = "MIME-Version: 1.0\n";
		$header .= "From: テスト <test@test>\n";
		$header .= "Reply-To: テスト <test@test>\n";

		// 件名を設定
		$auto_reply_subject = 'ご予約ありがとうございます。';

		// 本文を設定
		$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
		$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
		$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d'), ENT_QUOTES) . "\n";
		$auto_reply_text .= "時間:" . htmlspecialchars('09:00~09:30', ENT_QUOTES) . "\n";
		$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
		$auto_reply_text .= "Aクリニック\n";
		$auto_reply_text .= "住所:東京都港区１−１−１\n";
		$auto_reply_text .= "電話番号:012-3456-7890\n";
		$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
		mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
		header('Location: reservation.php');
		exit();
	}elseif(isset($_POST['regist_0900_0_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d'), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:00~09:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0900_0_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d'), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:00~09:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0900_1_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:00~09:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0900_1_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:00~09:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0900_1_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:00~09:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0900_2_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:00~09:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0900_2_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:00~09:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0900_2_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:00~09:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0900_3_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:00~09:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0900_3_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:00~09:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0900_3_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:00~09:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0900_4_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:00~09:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0900_4_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:00~09:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0900_4_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:00~09:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0900_5_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:00~09:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0900_5_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:00~09:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0900_5_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:00~09:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0900_6_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:00~09:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0900_6_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:00~09:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0900_6_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:00~09:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0900_7_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:00~09:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0900_7_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:00~09:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0900_7_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:00~09:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0930_0_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d'), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:30~10:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0930_0_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d'), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:30~10:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0930_0_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d'), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:30~10:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0930_1_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:30~10:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0930_1_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:30~10:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0930_1_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:30~10:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0930_2_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:30~10:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0930_2_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:30~10:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0930_2_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:30~10:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0930_3_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:30~10:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0930_3_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:30~10:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0930_3_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:30~10:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0930_4_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:30~10:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0930_4_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:30~10:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0930_4_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:30~10:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0930_5_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:30~10:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0930_5_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:30~10:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0930_5_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:30~10:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0930_6_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:30~10:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0930_6_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:30~10:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0930_6_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:30~10:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0930_7_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:30~10:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0930_7_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:30~10:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0930_7_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:30~10:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_0930_7_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('09:00~09:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1000_0_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d'), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:00~10:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1000_0_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d'), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:00~10:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1000_0_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d'), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:00~10:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1000_1_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:00~10:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1000_1_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:00~10:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1000_1_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:00~10:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1000_2_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:00~10:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1000_2_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:00~10:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1000_2_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:00~10:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1000_3_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:00~10:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1000_3_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:00~10:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1000_3_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:00~10:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1000_4_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:00~10:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1000_4_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:00~10:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1000_4_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:00~10:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1000_5_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:00~10:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1000_5_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:00~10:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1000_5_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:00~10:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1000_6_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:00~10:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1000_6_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:00~10:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1000_6_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:00~10:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1000_7_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:00~10:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1000_7_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:00~10:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1000_7_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:00~10:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1030_0_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d'), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:30~11:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1030_0_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d'), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:30~11:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1030_0_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d'), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:30~11:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1030_1_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:30~11:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1030_1_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:30~11:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1030_1_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:30~11:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1030_2_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:30~11:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1030_2_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:30~11:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1030_2_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:30~11:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1030_3_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:30~11:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1030_3_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:30~11:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1030_3_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:30~11:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1030_4_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:30~11:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1030_4_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:30~11:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1030_4_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:30~11:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1030_5_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:30~11:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1030_5_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:30~11:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1030_5_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:30~11:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1030_6_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:30~11:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1030_6_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:30~11:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1030_6_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:30~11:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1030_7_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:30~11:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1030_7_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:30~11:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1030_7_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('10:30~11:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1100_0_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d'), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:00~11:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1100_0_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d'), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:00~11:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1100_0_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d'), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:00~11:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1100_1_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:00~11:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1100_1_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:00~11:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1100_1_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:00~11:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1100_2_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:00~11:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1100_2_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:00~11:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1100_2_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:00~11:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1100_3_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:00~11:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1100_3_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:00~11:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1100_3_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:00~11:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1100_4_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:00~11:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1100_4_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:00~11:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1100_4_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:00~11:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1100_5_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:00~11:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1100_5_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:00~11:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1100_5_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:00~11:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1100_6_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:00~11:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1100_6_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:00~11:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1100_6_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:00~11:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1100_7_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:00~11:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1100_7_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:00~11:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1100_7_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:00~11:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1130_0_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d'), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:30~12:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1130_0_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d'), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:30~12:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1130_0_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d'), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:30~12:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1130_1_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:30~12:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1130_1_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:30~12:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1130_1_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:30~12:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1130_2_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:30~12:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1130_2_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:30~12:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1130_2_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:30~12:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1130_3_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:30~12:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1130_3_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:30~12:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1130_3_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:30~12:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1130_4_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:30~12:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1130_4_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:30~12:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1130_4_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:30~12:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1130_5_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:30~12:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1130_5_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:30~12:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1130_5_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:30~12:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1130_6_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:30~12:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1130_6_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:30~12:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1130_6_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:30~12:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1130_7_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:30~12:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1130_7_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:30~12:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1130_7_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('11:30~12:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1200_0_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d'), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('12:00~12:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1200_0_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d'), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('12:00~12:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1200_0_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d'), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('12:00~12:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1200_1_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('12:00~12:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1200_1_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('12:00~12:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1200_1_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('12:00~12:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1200_2_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('12:00~12:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1200_2_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('12:00~12:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1200_2_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('12:00~12:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1200_3_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('12:00~12:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1200_3_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('12:00~12:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1200_3_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('12:00~12:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1200_4_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('12:00~12:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1200_4_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('12:00~12:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1200_4_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('12:00~12:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1200_5_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('12:00~12:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1200_5_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('12:00~12:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1200_5_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('12:00~12:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1200_6_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('12:00~12:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1200_6_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('12:00~12:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1200_6_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('12:00~12:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1200_7_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('12:00~12:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1200_7_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('12:00~12:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1200_7_2'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('12:00~12:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1400_0_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d'), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('14:00~14:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1400_0_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d'), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('14:00~14:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1400_1_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('14:00~14:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1400_1_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('14:00~14:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1400_2_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('14:00~14:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1400_2_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('14:00~14:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1400_3_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('14:00~14:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1400_3_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('14:00~14:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1400_4_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('14:00~14:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1400_4_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('14:00~14:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1400_5_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('14:00~14:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1400_5_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('14:00~14:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1400_6_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('14:00~14:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1400_6_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('14:00~14:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1400_7_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('14:00~14:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1400_7_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('14:00~14:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1430_0_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d'), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('14:30~15:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1430_0_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d'), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('14:30~15:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1430_1_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('14:30~15:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1430_1_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('14:30~15:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1430_2_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('14:30~15:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1430_2_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('14:30~15:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1430_3_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('14:30~15:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1430_3_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('14:30~15:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1430_4_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('14:30~15:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1430_4_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('14:30~15:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('B医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1430_5_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('14:30~15:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1430_5_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('14:30~15:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1430_6_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('14:30~15:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1430_6_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('14:30~15:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1430_7_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('14:30~15:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1430_7_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('14:30~15:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1500_0_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d'), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('15:00~15:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1500_0_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d'), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('15:00~15:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1500_1_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('15:00~15:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1500_1_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('15:00~15:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1500_2_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('15:00~15:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1500_2_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('15:00~15:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1500_3_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('15:00~15:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1500_3_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('15:00~15:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1500_4_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('15:00~15:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1500_4_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('15:00~15:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1500_5_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('15:00~15:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1500_5_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('15:00~15:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1500_6_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('15:00~15:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1500_6_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('15:00~15:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1500_7_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('15:00~15:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1500_7_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('15:00~15:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1530_0_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d'), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('15:30~16:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1530_0_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d'), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('15:30~16:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1530_1_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('15:30~16:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1530_1_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('15:30~16:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1530_2_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('15:30~16:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1530_2_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('15:30~16:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1530_3_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('15:30~16:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1530_3_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('15:30~16:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1530_4_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('15:30~16:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1530_4_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('15:30~16:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1530_5_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('15:30~16:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1530_5_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('15:30~16:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1530_6_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('15:30~16:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1530_6_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('15:30~16:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1530_7_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('15:30~16:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1530_7_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('15:30~16:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1600_0_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d'), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('16:00~16:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1600_0_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d'), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('16:00~16:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1600_1_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('16:00~16:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1600_1_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('16:00~16:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1600_2_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('16:00~16:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1600_2_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('16:00~16:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1600_3_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('16:00~16:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1600_3_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('16:00~16:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1600_4_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('16:00~16:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1600_4_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('16:00~16:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1600_5_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('16:00~16:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1600_5_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('16:00~16:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1600_6_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('16:00~16:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1600_6_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('16:00~16:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1600_7_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('16:00~16:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1600_7_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('16:00~16:30', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1630_0_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d'), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('16:30~17:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1630_0_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d'), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('16:30~17:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1630_1_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('16:30~17:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1630_1_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('16:30~17:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1630_2_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('16:30~17:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1630_2_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('16:30~17:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1630_3_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('16:30~17:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1630_3_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('16:30~17:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1630_4_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('16:30~17:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1630_4_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('16:30~17:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1630_5_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('16:30~17:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1630_5_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('16:30~17:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1630_6_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('16:30~17:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1630_6_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('16:30~17:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1630_7_0'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('16:30~17:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('A医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}elseif(isset($_POST['regist_1630_7_1'])){
	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	$header = "MIME-Version: 1.0\n";
	$header .= "From: テスト <test@test>\n";
	$header .= "Reply-To: テスト <test@test>\n";

	// 件名を設定
	$auto_reply_subject = 'ご予約ありがとうございます。';

	// 本文を設定
	$auto_reply_text = "この度は、お予約頂き誠にありがとうございます。\n下記の時間帯でご予約を受け付けました。\n\n";
	$auto_reply_text .= "氏名:" . $member['name'] . "様\n";
	$auto_reply_text .= "日にち:" . htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES) . "\n";
	$auto_reply_text .= "時間:" . htmlspecialchars('16:30~17:00', ENT_QUOTES) . "\n";
	$auto_reply_text .= "医師:" . htmlspecialchars('C医師', ENT_QUOTES) . "\n\n";
	$auto_reply_text .= "Aクリニック\n";
	$auto_reply_text .= "住所:東京都港区１−１−１\n";
	$auto_reply_text .= "電話番号:012-3456-7890\n";
	$auto_reply_text .= "予約時間は診療内容により前後する場合がございます。\n予めご了承ください。";
	mb_send_mail( $member['email'], $auto_reply_subject, $auto_reply_text, $header);
	header('Location: reservation.php');
	exit();
	}
	?>
	
	<p><?php print(htmlspecialchars($member['name'], ENT_QUOTES)); ?>様  <a href="logout.php">ログアウト</a></p>
	<p>予約一覧</p>
	<?php foreach ($posts as $post): ?>
		<?php if ($_SESSION['id'] == $post['member_id']): ?>
			<p>
				<?php print(htmlspecialchars(($post['day']), ENT_QUOTES)); ?> 
				<?php print(htmlspecialchars(($post['time1']), ENT_QUOTES)); ?> 
				<?php print(htmlspecialchars(($post['doctor']), ENT_QUOTES)); ?>
				<?php endif; ?>
				<?php if ($_SESSION['id'] == $post['member_id']): ?>
					<a href="delete.php?id=<?php print(htmlspecialchars($post['id'])); ?>">削除</a>
				<?php endif; ?>
			</p>
	<?php endforeach; ?>
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
			<?php if ($count_1 >= 7 || '09:00' <= date('H:i')): ?>
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0900_0_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '09:00~09:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3 || '09:00' <= date('H:i')): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0900_0_1" value="B医師" class="submit">
					</form>
				</th>
			<?php endif; ?>
		<?php elseif ($week_0 == "月" OR $week_0 == "火" OR $week_0 == "水" OR $week_0 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '09:00~09:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5 || '09:00' <= date('H:i')): ?>
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0900_0_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0900_1_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '09:00~09:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0900_1_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0900_1_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0900_2_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '09:00~09:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0900_2_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0900_2_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0900_3_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '09:00~09:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0900_3_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0900_3_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0900_4_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '09:00~09:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0900_4_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0900_4_2" value="A医師" class="submit">
					</form>
				</th>
			<?php endif ?>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0900_5_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_5' AND time1 = '09:00~09:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0900_5_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0900_5_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0900_6_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '09:00~09:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0900_6_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0900_6_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0900_7_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '09:00~09:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0900_7_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0900_7_2" value="A医師" class="submit">
					</form>
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
			<?php if ($count_1 >= 7 || '09:30' <= date('H:i')): ?>
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0930_0_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '09:30~10:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3 || '09:30' <= date('H:i')): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0930_0_1" value="B医師" class="submit">
					</form>
				</th>
			<?php endif; ?>
		<?php elseif ($week_0 == "月" OR $week_0 == "火" OR $week_0 == "水" OR $week_0 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '09:30~10:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5 || '09:30' <= date('H:i')): ?>
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0930_0_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0930_1_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '09:30~10:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0930_1_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0930_1_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0930_2_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '09:30~10:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0930_2_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0930_2_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0930_3_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '09:30~10:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0930_3_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0930_3_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0930_4_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '09:30~10:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0930_4_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:00~09:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0930_4_2" value="A医師" class="submit">
					</form>
				</th>
			<?php endif ?>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0930_5_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_5' AND time1 = '09:30~10:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0930_5_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0930_5_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0930_6_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '09:30~10:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0930_6_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0930_6_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0930_7_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '09:30~10:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0930_7_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('09:30~10:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_0930_7_2" value="A医師" class="submit">
					</form>
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
			<?php if ($count_1 >= 7 || '10:00' <= date('H:i')): ?>
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1000_0_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '10:00~10:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3 || '10:00' <= date('H:i')): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1000_0_1" value="B医師" class="submit">
					</form>
				</th>
			<?php endif; ?>
		<?php elseif ($week_0 == "月" OR $week_0 == "火" OR $week_0 == "水" OR $week_0 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '10:00~10:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5 || '10:00' <= date('H:i')): ?>
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1000_0_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1000_1_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '10:00~10:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1000_1_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1000_1_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1000_2_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '10:00~10:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1000_2_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1000_2_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1000_3_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '10:00~10:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1000_3_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1000_3_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1000_4_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '10:00~10:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1000_4_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1000_4_2" value="A医師" class="submit">
					</form>
				</th>
			<?php endif ?>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1000_5_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_5' AND time1 = '10:00~10:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1000_5_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1000_5_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1000_6_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '10:00~10:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1000_6_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1000_6_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1000_7_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '10:00~10:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1000_7_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:00~10:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1000_7_2" value="A医師" class="submit">
					</form>
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
			<?php if ($count_1 >= 7 || '10:30' <= date('H:i')): ?>
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1030_0_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '10:30~11:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3  || '10:30' <= date('H:i')): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1030_0_1" value="B医師" class="submit">
					</form>
				</th>
			<?php endif; ?>
		<?php elseif ($week_0 == "月" OR $week_0 == "火" OR $week_0 == "水" OR $week_0 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '10:30~11:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5 || '10:30' <= date('H:i')): ?>
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1030_0_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1030_1_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '10:30~11:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1030_1_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1030_1_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1030_2_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '10:30~11:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1030_2_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1030_2_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1030_3_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '10:30~11:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1030_3_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1030_3_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1030_4_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '10:30~11:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1030_4_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1030_4_2" value="A医師" class="submit">
					</form>
				</th>
			<?php endif ?>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1030_5_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_5' AND time1 = '10:30~11:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1030_5_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1030_5_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1030_6_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '10:30~11:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1030_6_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1030_6_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1030_7_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '10:30~11:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1030_7_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('10:30~11:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1030_7_2" value="A医師" class="submit">
					</form>
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
			<?php if ($count_1 >= 7 || '11:00' <= date('H:i')): ?>
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1100_0_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '11:00~11:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3 || '11:00' <= date('H:i')): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1100_0_1" value="B医師" class="submit">
					</form>
				</th>
			<?php endif; ?>
		<?php elseif ($week_0 == "月" OR $week_0 == "火" OR $week_0 == "水" OR $week_0 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '11:00~11:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5 || '11:00' <= date('H:i')): ?>
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1100_0_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1100_1_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '11:00~11:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1100_1_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1100_1_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1100_2_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '11:00~11:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1100_2_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1100_2_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1100_3_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '11:00~11:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1100_3_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1100_3_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1100_4_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '11:00~11:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1100_4_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1100_4_2" value="A医師" class="submit">
					</form>
				</th>
			<?php endif ?>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1100_5_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_5' AND time1 = '11:00~11:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1100_5_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1100_5_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1100_6_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '11:00~11:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1100_6_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1100_6_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1100_7_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '11:00~11:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1100_7_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:00~11:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1100_7_2" value="A医師" class="submit">
					</form>
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
			<?php if ($count_1 >= 7 || '11:30' <= date('H:i')): ?>
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1130_0_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '11:30~12:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3 || '11:30' <= date('H:i')): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1130_0_1" value="B医師" class="submit">
					</form>
				</th>
			<?php endif; ?>
		<?php elseif ($week_0 == "月" OR $week_0 == "火" OR $week_0 == "水" OR $week_0 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '11:30~12:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5 || '11:30' <= date('H:i')): ?>
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1130_0_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1130_1_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '11:30~12:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1130_1_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1130_1_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1130_2_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '11:30~12:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1130_2_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1130_2_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1130_3_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '11:30~12:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1130_3_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1130_3_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1130_4_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '11:30~12:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1130_4_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1130_4_2" value="A医師" class="submit">
					</form>
				</th>
			<?php endif ?>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1130_5_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_5' AND time1 = '11:30~12:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1130_5_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1130_5_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1130_6_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '11:30~12:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1130_6_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1130_6_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1130_7_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '11:30~12:00' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1130_7_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('11:30~12:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1130_7_2" value="A医師" class="submit">
					</form>
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
			<?php if ($count_1 >= 7 || '12:00' <= date('H:i')): ?>
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1200_0_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '12:00~12:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3 || '12:00' <= date('H:i')): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1200_0_1" value="B医師" class="submit">
					</form>
				</th>
			<?php endif; ?>
		<?php elseif ($week_0 == "月" OR $week_0 == "火" OR $week_0 == "水" OR $week_0 == "木"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '12:00~12:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5 || '12:00' <= date('H:i')): ?>
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1200_0_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1200_1_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_1' AND time1 = '12:00~12:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1200_1_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1200_1_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1200_2_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '12:00~12:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1200_2_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1200_2_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1200_3_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_3' AND time1 = '12:00~12:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1200_3_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1200_3_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1200_4_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_4' AND time1 = '12:00~12:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1200_4_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1200_4_2" value="A医師" class="submit">
					</form>
				</th>
			<?php endif ?>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1200_5_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_5' AND time1 = '12:00~12:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1200_5_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1200_5_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1200_6_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_6' AND time1 = '12:00~12:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1200_6_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1200_6_2" value="A医師" class="submit">
					</form>
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
				<th>×
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1200_7_0" value="A医師" class="submit">
					</form>
			<?php endif; ?>
			<?php
				$sql_2 = "SELECT * FROM masters where day = '$ymd_7' AND time1 = '12:00~12:30' AND doctor = 'B医師'";
				$stmt_2 = $dbh->query($sql_2);
				$stmt_2->execute();
				$count_2 = $stmt_2->rowCount();
			?>
			<?php if ($count_2 >= 3): ?>
				×</th>
			<?php else: ?>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('B医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1200_7_1" value="B医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('12:00~12:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1200_7_2" value="A医師" class="submit">
					</form>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
	</tr>


  <tr>
		<th>12:30〜</th>
		<th>休</th>
		<th>休</th>
		<th>休</th>
		<th>休</th>
		<th>休</th>
		<th>休</th>
		<th>休</th>
		<th>休</th>
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
			<?php if ($count_0 >= 5 || '14:00' <= date('H:i')): ?>
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:00~14:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1400_0_0" value="A医師" class="submit">
					</form>
				</th>
			<?php endif; ?>
		<?php elseif ($week_0 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '14:00~14:30' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5 || '14:00' <= date('H:i')): ?>
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:00~14:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1400_0_1" value="C医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:00~14:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1400_1_0" value="A医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:00~14:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1400_1_1" value="C医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:00~14:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1400_2_0" value="A医師" class="submit">
					</form>
				</th>
			<?php endif; ?>
		<?php elseif ($week_2 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '14:00~14:30' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:00~14:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1400_2_1" value="C医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:00~14:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1400_3_0" value="A医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:00~14:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1400_3_1" value="C医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:00~14:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1400_4_0" value="A医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:00~14:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1400_4_1" value="C医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:00~14:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1400_5_0" value="A医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:00~14:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1400_5_1" value="C医師" class="submit">
					</form>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
	
		<?php if ($week_6 == "月" OR $week_6 == "火" OR $week_6 == "木" OR $week_6 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '14:00~14:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:00~14:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1400_6_0" value="A医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:00~14:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1400_6_1" value="C医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:00~14:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1400_7_0" value="A医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:00~14:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1400_7_1" value="C医師" class="submit">
					</form>
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
			<?php if ($count_0 >= 5 || '14:30' <= date('H:i')): ?>
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:30~15:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1430_0_0" value="A医師" class="submit">
					</form>
				</th>
			<?php endif; ?>
		<?php elseif ($week_0 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '14:30~15:00' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5 || '14:30' <= date('H:i')): ?>
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:30~15:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1430_0_1" value="C医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:30~15:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1430_1_0" value="A医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:30~15:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1430_1_1" value="C医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:30~15:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1430_2_0" value="A医師" class="submit">
					</form>
				</th>
			<?php endif; ?>
		<?php elseif ($week_2 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '14:30~15:00' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:30~15:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1430_2_1" value="C医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:30~15:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1430_3_0" value="A医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:30~15:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1430_3_1" value="C医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:30~15:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1430_4_0" value="A医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:30~15:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1430_4_1" value="C医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:30~15:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1430_5_0" value="A医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:30~15:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1430_5_1" value="C医師" class="submit">
					</form>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
	
		<?php if ($week_6 == "月" OR $week_6 == "火" OR $week_6 == "木" OR $week_6 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '14:30~15:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:30~15:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1430_6_0" value="A医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:30~15:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1430_6_1" value="C医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:30~15:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1430_7_0" value="A医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('14:30~15:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1430_7_1" value="C医師" class="submit">
					</form>
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
			<?php if ($count_0 >= 5 || '15:00' <= date('H:i')): ?>
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:00~15:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1500_0_0" value="A医師" class="submit">
					</form>
				</th>
			<?php endif; ?>
		<?php elseif ($week_0 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '15:00~15:30' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5 || '15:00' <= date('H:i')): ?>
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:00~15:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1500_0_1" value="C医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:00~15:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1500_1_0" value="A医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:00~15:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1500_1_1" value="C医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:00~15:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1500_2_0" value="A医師" class="submit">
					</form>
				</th>
			<?php endif; ?>
		<?php elseif ($week_2 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '15:00~15:30' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:00~15:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1500_2_1" value="C医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:00~15:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1500_3_0" value="A医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:00~15:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1500_3_1" value="C医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:00~15:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1500_4_0" value="A医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:00~15:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1500_4_1" value="C医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:00~15:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1500_5_0" value="A医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:00~15:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1500_5_1" value="C医師" class="submit">
					</form>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
	
		<?php if ($week_6 == "月" OR $week_6 == "火" OR $week_6 == "木" OR $week_6 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '15:00~15:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:00~15:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1500_6_0" value="A医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:00~15:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1500_6_1" value="C医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:00~15:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1500_7_0" value="A医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:00~15:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1500_7_1" value="C医師" class="submit">
					</form>
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
			<?php if ($count_0 >= 5 || '15:30' <= date('H:i')): ?>
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:30~16:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1530_0_0" value="A医師" class="submit">
					</form>
				</th>
			<?php endif; ?>
		<?php elseif ($week_0 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '15:30~16:00' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5 || '15:30' <= date('H:i')): ?>
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:30~16:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1530_0_1" value="C医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:30~16:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1530_1_0" value="A医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:30~16:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1530_1_1" value="C医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:30~16:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1530_2_0" value="A医師" class="submit">
					</form>
				</th>
			<?php endif; ?>
		<?php elseif ($week_2 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '15:30~16:00' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:30~16:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1530_2_1" value="C医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:30~16:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1530_3_0" value="A医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:30~16:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1530_3_1" value="C医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:30~16:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1530_4_0" value="A医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:30~16:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1530_4_1" value="C医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:30~16:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1530_5_0" value="A医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:30~16:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1530_5_1" value="C医師" class="submit">
					</form>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
	
		<?php if ($week_6 == "月" OR $week_6 == "火" OR $week_6 == "木" OR $week_6 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '15:30~16:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:30~16:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1530_6_0" value="A医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:30~16:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1530_6_1" value="C医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:30~16:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1530_7_0" value="A医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('15:30~16:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1530_7_1" value="C医師" class="submit">
					</form>
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
			<?php if ($count_0 >= 5 || '16:00' <= date('H:i')): ?>
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:00~16:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1600_0_0" value="A医師" class="submit">
					</form>
				</th>
			<?php endif; ?>
		<?php elseif ($week_0 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '16:00~16:30' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5 || '16:00' <= date('H:i')): ?>
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:00~16:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1600_0_1" value="C医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:00~16:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1600_1_0" value="A医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:00~16:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1600_1_1" value="C医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:00~16:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1600_2_0" value="A医師" class="submit">
					</form>
				</th>
			<?php endif; ?>
		<?php elseif ($week_2 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '16:00~16:30' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:00~16:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1600_2_1" value="C医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:00~16:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1600_3_0" value="A医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:00~16:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1600_3_1" value="C医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:00~16:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1600_4_0" value="A医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:00~16:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1600_4_1" value="C医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:00~16:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1600_5_0" value="A医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:00~16:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1600_5_1" value="C医師" class="submit">
					</form>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
	
		<?php if ($week_6 == "月" OR $week_6 == "火" OR $week_6 == "木" OR $week_6 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '16:00~16:30' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:00~16:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1600_6_0" value="A医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:00~16:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1600_6_1" value="C医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:00~16:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1600_7_0" value="A医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:00~16:30', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1600_7_1" value="C医師" class="submit">
					</form>
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
			<?php if ($count_0 >= 5 || '16:30' <= date('H:i')): ?>
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:30~17:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1630_0_0" value="A医師" class="submit">
					</form>
				</th>
			<?php endif; ?>
		<?php elseif ($week_0 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '16:30~17:00' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5 || '16:30' <= date('H:i')): ?>
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d'), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:30~17:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1630_0_1" value="C医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:30~17:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1630_1_0" value="A医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+1 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:30~17:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1630_1_1" value="C医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:30~17:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1630_2_0" value="A医師" class="submit">
					</form>
				</th>
			<?php endif; ?>
		<?php elseif ($week_2 == "水"): ?>
			<?php
				$sql_3 = "SELECT * FROM masters where day = '$ymd_2' AND time1 = '16:30~17:00' AND doctor = 'C医師'";
				$stmt_3 = $dbh->query($sql_3);
				$stmt_3->execute();
				$count_3 = $stmt_3->rowCount();
			?>
			<?php if ($count_3 >= 5): ?>
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+2 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:30~17:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1630_2_1" value="C医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:30~17:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1630_3_0" value="A医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+3 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:30~17:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1630_3_1" value="C医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:30~17:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1630_4_0" value="A医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+4 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:30~17:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1630_4_1" value="C医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:30~17:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1630_5_0" value="A医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+5 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:30~17:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1630_5_1" value="C医師" class="submit">
					</form>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
	
		<?php if ($week_6 == "月" OR $week_6 == "火" OR $week_6 == "木" OR $week_6 == "金"): ?>
			<?php
				$sql_0 = "SELECT * FROM masters where day = '$ymd_0' AND time1 = '16:30~17:00' AND doctor = 'A医師'";
				$stmt_0 = $dbh->query($sql_0);
				$stmt_0->execute();
				$count_0 = $stmt_0->rowCount();
			?>
			<?php if ($count_0 >= 5): ?>
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:30~17:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1630_6_0" value="A医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+6 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:30~17:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1630_6_1" value="C医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:30~17:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('A医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1630_7_0" value="A医師" class="submit">
					</form>
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
				<th>×</th>
			<?php else: ?>
				<th>
					<form action="" method="post">
						<input type="hidden" name="day" value="<?php print(htmlspecialchars(date('Y/m/d', strtotime('+7 day')), ENT_QUOTES)); ?>"/>
						<input type="hidden" name="time1" value="<?php print(htmlspecialchars('16:30~17:00', ENT_QUOTES)); ?>"/>
						<input type="hidden" name="doctor" value="<?php print(htmlspecialchars('C医師', ENT_QUOTES)); ?>"/>
						<input type="submit" name="regist_1630_7_1" value="C医師" class="submit">
					</form>
				</th>
			<?php endif; ?>
		<?php else: ?>
			<th>休</th>
		<?php endif; ?>
	</tr>
	

	<tr>
		<th>17:00〜</th>
		<th>休</th>
		<th>休</th>
		<th>休</th>
		<th>休</th>
		<th>休</th>
		<th>休</th>
		<th>休</th>
		<th>休</th>
  </tr>
</table>