<!DOCTYPE html>
<html>
<head>
	<?php 
		if (@$title) $title .= ' | G.'; else $title = "G."; 
	?>
	<title><?= $title ?></title>
	<link rel="stylesheet" type="text/css" href="http://vie.blog/web/css/main.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-4 col-sm-0" style="padding: 0">
			<div class="left">
			<h1>
				<span style="color: white; background: #d75469; padding: 5px 10px;">Valera </span>
				<span style="color: white; background: #78a9d6; padding-left: 5px;">Gurachek</span>
			</h1>
			<div class="photo"></div>
			<p style="margin: 40px 30px;">Веду блог от нечего делать. Занимаюсь проектом <a href="http://theviebook.com/" target="_blank" style="text-decoration: underline;">theviebook.com</a></p>
			<div class="social-buttons">
				<img src="/web/images/vk-icon.png" width="40">
				<img src="/web/images/tw-icon.svg" width="40">
				<img src="/web/images/gp-icon.png" width="45">
				<img src="/web/images/fb-icon.svg" width="40">
			</div>
			</div>
		</div>
		<div class="col-md-8 col-sm-10 col-xs-12 right" style="padding-left: 0">

			<div class="topics" style="display: none;">
				Популярные теги: 
				<span class="item">новости</span>
				<span class="item">вайбук</span>
				<span class="item">мнение</span>
				<span class="item">искусственный интеллект</span>
				<span class="item">образование</span>
				<span class="item">бизнес</span>
			</div>

			<div class="menu">
				<ul>
					<li><a href="/">Главная</a></li>
					<li><a href="/about">О блоге</a></li>
					<li><a href="/categories">Категории</a></li>
					
					<?php if (!@$_COOKIE['auth']): ?>
					
						<li><a href="/signin">Вход</a></li>
						<li><a href="/signup">Регистрация</a></li>
					
					<?php else: ?>

						<li><div style="background: url(/web/images/users/<?= $c->user['image'] ?>) no-repeat; width: 30px; height: 30px; margin-bottom: -10px; margin-right: -20px; border-radius: 100px; background-size: cover; background-position: center center;"></div></li>
						<li>
							<a href="/me"><?= $c->user['name'] ?></a>
							<a class="logout" title="Выйти из аккаунта" style="color: gray; font-size: 13px; margin-left: 4px; cursor: pointer;"><span class="glyphicon glyphicon-log-out"></span></a>
						</li>

						

					<?php endif; ?>
					
					<li class="search">
					<input type="search" name="search" placeholder="Search here.."> 
					<span class="glyphicon glyphicon-search"></span>
					</li>
				</ul>
			</div>

			<div class="post welcome-mobile" style="margin-top: 20px; min-height: 150px">
				<div class="row" style="margin-top: 10px;">
					<div class="col-sm-3">
						<div class="photo-small"></div>
					</div>
					<div class="col-sm-9">
						<h3>
							<span style="color: white; background: #d75469; padding: 5px 10px;">Valera </span>
							<span style="color: white; background: #78a9d6; padding-left: 5px;">Gurachek</span>
						</h3>
						<div class="text">
							<p style="margin: 15px 0px;">Веду блог от нечего делать. Занимаюсь проектом <a href="http://theviebook.com/" target="_blank" style="text-decoration: underline;">theviebook.com</a></p>
						</div>
					</div>
				</div>
			</div>
			
			<?php include __DIR__ . '/../' . $content . '.php'; ?>

		</div>
	</div>
</div>

<form name="submit-logout" method="post" action="<?= $c->url ?>logout">
	<input type="hidden" name="logout" value="logout" />
</form>

<script type="text/javascript">
	jQuery('.logout').click(function () {
		var sure = confirm("Вы уверены, что хотите выйти из своего аккаунта?");
			
		if (sure)
			document.forms["submit-logout"].submit();
	});
</script>

</body>
</html>
