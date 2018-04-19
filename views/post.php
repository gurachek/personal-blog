<?php if (!$data): ?>

<br>
<br>
<br>
<h1 style="color: #444;">Такого поста не существует.</h1>

<?php else: ?>

<div class="post-one">
	
	<div class="stats">
		<div class="date">
			<span class="glyphicon glyphicon-calendar"></span> 
		
			<?= $data['created'] ?>
		</div>
		<div class="category">
			<div class="category-icon"></div>
			<a href="<?= $c->url ?>category/<?= $data['category']['id'] ?>">
				<?= $data['category']['name'] ?>
			</a>
		</div>
		<div class="author">
			<div style="
				background: url(/web/images/users/<?= $data['user']['image'] ?>) no-repeat; 
				background-position: center center;
				background-size: cover;
				margin-bottom: -8px;
				width: 30px;
				height: 30px;
				border-radius: 100px;
			"></div>
			<a href="<?= $c->url ?>user/<?= $data['user']['id'] ?>">
				<?= $data['user']['name'] ?>
			</a>
		</div>
	</div>

	<h1 class="text-left"><?= $data['title'] ?></h1>
	
	<p>
		<?= $data['preview'] ?>
	</p>

	<?php if ($data['image']) : ?>

		<div class="image">
			<img src="/web/images/posts/<?= $data['image'] ?>">
		</div>
		
	<?php endif; ?>

	<p class="post-text">
		<?= $data['text'] ?>
	</p>
</div>

<?php endif; ?>