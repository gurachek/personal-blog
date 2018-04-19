<!DOCTYPE html>
<html>
<head>
	<?php 
		if (@$title) $title .= ' | G.'; else $title = "G."; 
	?>
	<title><?= $title ?></title>
	<link rel="stylesheet" type="text/css" href="http://vie.blog/web/css/main1.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
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

<div class="right">
	
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
			<li><a href="">Вход</a></li>
			<li><a href="/signup">Регистрация</a></li>
			<li class="search">
				<input type="search" name="search" placeholder="Search here.."> 
				<span class="glyphicon glyphicon-search"></span>
			</li>
		</ul>
	</div>

	<?php include __DIR__ . '/../' . $content . '.php'; ?>
</div>
<div class="footer"></div>
</body>
</html>
