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
<body style="background: #a7adba !important;">

<div class="user-page">
	
	<div class="top">
		<div class="info">
			<div class="image" style="
				background: url(http://vie.blog/web/images/users/<?= $data['image'] ?>) no-repeat center;
				background-size: cover;
				width: 150px;
				height: 150px;
				border-radius: 200px;
				/*margin-top: 10px;*/
				margin: 0 auto;
				margin-top: 20px;
			"></div>
			<div class="name">
				<h3 class="text-center">
					@<?= $data['name'] ?>
				</h3>
			</div>
			<div class="about">
				<p>
					<?= $data['about'] ?>
				</p>
			</div>
		</div>
	</div>

	<div class="bottom">
		<div class="hr"></div>
		<div class="posts">
	
			<?php if (!$posts) : ?>

				<h3 class="text-center" style="margin-top: 100px; color: white;">No posts yet.</h3>

			<?php endif; ?>

			<?php foreach ($posts as $post): ?>

				<div class="one">
					<a class="title" href="<?= $c->url ?>post/<?= $post['id'] ?>"><?= $post['title'] ?></a>
				</div>

			<?php endforeach; ?>

		</div>
	</div>

	<div class="footer"></div>

</div>

</body>
</html>