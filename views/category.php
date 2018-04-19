<div class="content">
	<div class="post-one category-block">
		
		<div class="row">
			<div class="col-md-2 col-sm-3 col-xs-3">
				<img class="image" src="http://icons.veryicon.com/png/System/Kameleon/Programming.png" />
			</div>
			<div class="col-md-10 col-sm-9 col-xs-9">
				<h3><?= $data['name'] ?></h3>
				<p>
					<?= $data['about'] ?>
				</p>
			</div>
		</div>

	</div>

	<?php if ($posts): ?>

	<?php foreach($posts as $post) : ?>

		<?php if (!$post['active']) continue; ?>

			<?php include 'parts/post.php' ?>

		<?php endforeach; ?>

	<?php else: ?>

		<h3 class="text-center" style="margin-top: 50px;">В этой категории пока нет постов :3</h3>

	<?php endif; ?>

</div>