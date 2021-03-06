# 予約システム
診療所の予約システムを作りました。

## 概要
患者様が会員登録して、診察の予約をとるというシステムです。
土日が休診日で医師の勤務曜日は決まってるので、
自動的に当日から１週間後までの予約を取れるようにカレンダーを作りました。
また、当日の診察時間を過ぎたり、各医師の予約枠の上限に達すると
予約はできないようにしてます。
患者様の現在の予約状況が画面上部で確認でき、
予約を削除することも可能です。

## デモ
https://yoyaku2.herokuapp.com/<br>
テストユーザー名　テスト<br>
メールアドレス　test@test<br>
パスワード　test<br>

画像

<img src="https://user-images.githubusercontent.com/61407102/93898075-c9402000-fd2d-11ea-8391-cd84bb7ae7d2.gif" width="320px">

動画
https://gyazo.com/cfac82463b061172c390492cdd67105d

## 制作背景、意図
勤務先の診療所で予約システムがなかったため、自分自身の勉強もかねて作成しました。

## 使用技術
PHP、MAMP、phpmyadmin、Heroku

## 工夫した点
予約をとるまでのステップをなるべく少なくして、
画面を見やすくすることでユーザービリティを高めました。

## 課題や今後実装したい機能
職員用の管理画面がローカル環境で確認できてるので、本番実装でも実装できるように修正したいです。

## DB設計

### mastersテーブル
|Column|Type|Options|
|------|----|-------|
|id|int(11)|null: false|
|member_id|int(11)|null: false, auto_increment|
|day|varchar(255)|null: false|
|time1|varchar(41)|null: false|
|doctor|varchar(41)|null: false|
|created|datetime|null: false|
|modified|timestamp|null: false|

#### Association
- belongs_to :member

### membersテーブル
|Column|Type|Options|
|------|----|-------|
|id|int(11)|null: false, auto_increment|
|name|varchar(255)|null: false|
|email|varchar(255)|null: false|
|password|varchar(100)|null: false|
|created|datetime|null: false|
|modified|timestamp|null: false|

#### Association
- has_many :master
