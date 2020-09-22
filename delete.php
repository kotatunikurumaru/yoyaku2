<?php
session_start();
require('dbconnect.php');

if (isset($_SESSION['id'])) {
  $id = $_REQUEST['id'];

  $messages = $dbh->prepare('SELECT * FROM masters WHERE id=?');
  $messages->execute(array($id));
  $message = $messages->fetch();
  
  if ($message['member_id'] == $_SESSION['id']) {
    $member_id = $message['member_id'];
    $posts = $dbh->prepare('SELECT * FROM members WHERE id=?');
    $posts->execute(array($member_id));
    $post = $posts->fetch();

    // 変数とタイムゾーンを初期化
    $header = null;
    $auto_reply_subject = null;
    $auto_reply_text = null;
    date_default_timezone_set('Asia/Tokyo');

    $header = "MIME-Version: 1.0\n";
    $header .= "From: 鈴木匠 <takumi.suzuki0411@gmail.com>\n";
    $header .= "Reply-To: 鈴木匠 <takumi.suzuki0411@gmail.com>\n";

    // 件名を設定
    $auto_reply_subject = 'ご予約のキャンセルを承りました。';

    // 本文を設定
    $auto_reply_text = "氏名:" . $post['name'] . "様\n";
    $auto_reply_text .= "お世話になっております。\nご予約のキャンセルにつきましてご連絡いただき、ありがとうございます。\n以下のご予約について、キャンセルを承りました。\n\n";
    $auto_reply_text .= "日にち:" . $message['day'] . "\n";
    $auto_reply_text .= "時間:" . $message['time1'] . "\n";
    $auto_reply_text .= "医師:" . $message['doctor'] . "\n\n";
    $auto_reply_text .= "Aクリニック\n";
    $auto_reply_text .= "住所:東京都港区１−１−１\n";
    $auto_reply_text .= "電話番号:012-3456-7890\n\n";
    $auto_reply_text .= "またのご利用、お待ち申し上げます。";
    mb_send_mail( $post['email'], $auto_reply_subject, $auto_reply_text, $header);
    $del = $dbh->prepare('DELETE FROM masters WHERE id=?');
    $del->execute(array($id));
  }
}

header('Location: reservation.php');
exit();
?>