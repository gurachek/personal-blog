<!DOCTYPE html>
<html>
<head>
	<?php 
		if (@$title) $title .= ' | G.'; else $title = "G."; 
	?>
	<title><?= $title ?></title>
	<link rel="stylesheet" type="text/css" href="http://localhost:8000/web/css/main.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<script>
	jQuery(document).ready(function ($) {

		jQuery('.eye-open').click(function () {

			if (jQuery(this).hasClass('active')) {
				jQuery(this).removeClass('active');
				$('.user_password').get(0).type = 'password';
			} else {
				jQuery(this).addClass('active');
				$('.user_password').get(0).type = 'text';
				jQuery('.user_password').focus();
			}
		});

		// jQuery('.form').submit(function (e) {

		// 	var data = jQuery('.form').serializeArray();			

		// 	var name = data[0]['value'];
		// 	var email = data[1]['value'];
		// 	var password = data[2]['value'];
		// 	var about = data[3]['value'];

		// 	jQuery.ajax({
		// 		url: 'http://vie.blog/api/v1/user',
		// 		type: 'POST',
		// 		cache: false,
	 //            contentType: false,
	 //            processData: false
		// 		data: {
		// 			name: name, 
		// 			email: email,
		// 			about: about,
		// 			password: password,
		// 		},
		// 		success: function (data) {
		// 			if (data) {
		// 				jQuery('.success').fadeIn(2000);
		// 				jQuery('.success').fadeOut(2000);
		// 			}
		// 		},

		// 	});

		// 	e.preventDefault();

		// });

	});
</script>

<h1 class="text-center" style="margin: 35px 0; color: #444;">Регистрация</h1>

<div class="success">
	<span class="glyphicon glyphicon-ok"></span>
	Successfull
</div>

<div class="main">

	<form class="form" action="http://vie.blog/api/v1/user" enctype="multipart/form-data" method="POST">
		<input type="text" name="name" class="user_name" placeholder="Имя">
		<input type="email" name="email" class="user_email" placeholder="Почта">
		<input type="password" name="password" class="user_password" placeholder="Пароль">
		<div class="eye-open">
			<span class="glyphicon glyphicon-eye-open"></span>
		</div>
		<textarea name="about" class="user_about" placeholder="Кратко о себе"></textarea>
		<input type="file" name="image" class="user_image" accept="image/*">
		<input type="submit" name="submit" class="submit" value="Зарегистрироваться">
	</form>

</div>

<div class="return text-center" style="margin-top: 10px;">
	<a href="/">Return to the blog</a>
</div>

</body>
</html>