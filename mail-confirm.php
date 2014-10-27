<?php
if ($_SERVER["SERVER_NAME"] == "okina.herokuapp.com") {
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: http://www.seimei.asia" . $_SERVER[REQUEST_URI]);
} else {
	header('Content-type: text/html; charset=utf-8;');
}

date_default_timezone_set('Asia/Tokyo');

require 'vendor/autoload.php';
require 'php/snipets.php';

$authcode = rand(10000, 99999);
seimeiWebHeader();
?>
<body>
	<div data-role="page" id="top">
		<div data-role="header">
			<h1>暮らしの姓名判断 <span class="ui-mini"><a href="#mit-lisense">Copyright &copy; 2014 だいぶつ</a></span></h1>
			<a href="/#top" data-icon="home" data-ajax="false">ホーム</a>
			<a href="" data-icon="mail" class="ui-disabled">問い合わせ</a>
		</div>
		<div data-role='content'>
			<h2>お問い合わせフォーム(確認)</h2>
			<p>なりすましを防ぐため、認証コードの入力をお願いします。認証コードはメールで送信されます。</p>
			<div data-role="fieldcontain">
				<form action="mail.php" data-ajax="false" method="POST">
					<label for="email">メールアドレス</label>
					<input type="text" name="email" value="<?php echo $_POST['email'];?>" readonly="readonly">
					<label for="subject">タイトル</label>
					<input type="text" name="subject" value="<?php echo $_POST['subject'];?>">
					<label for="query-content">お問い合わせ内容</label>
					<textarea name="query-content" id="query-content"><?php echo $_POST['query-content'];?></textarea>
					<label for="query-content">認証コード</label>
					<input type="text" name="authcode">
					<input type="hidden" name="authcode-hash" value="<?php echo hash("haval160,4", $authcode);?>">
					<input type="submit" value="投稿">
				</form>
			</div>
		</div>
		<div data-role='footer' data-position='fixed'>
			<?php googleAdsense() ?>
		</div>
	</div>
</body>

</html>
<?php
$sendgrid = new SendGrid(getenv('SENDGRID_USERNAME'), getenv('SENDGRID_PASSWORD'));
$message = new SendGrid\Email();
$message->
	addTo($_POST['email'])->
	setFrom('info@seimei.asia')->
	setSubject('[暮らしの姓名判断]認証コード')->
	setText('下記の認証コードをWeb画面に入力してください。' . PHP_EOL . PHP_EOL . 
			'　認証コード: ' . $authcode . PHP_EOL . PHP_EOL . 
			'このメールアドレスは送信専用です。このメールに返信しても届きませんのでご注意ください。' . PHP_EOL . PHP_EOL .
			'--' . PHP_EOL .
			'暮らしの姓名判断' . PHP_EOL .
			'http://www.seimei.asia/'
	);
$response = $sendgrid->send($message);
?>