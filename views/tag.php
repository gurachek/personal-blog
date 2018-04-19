<div class="content">
	<h1 class="text-left" style="margin-left: 5%; font-size: 35px; color: #444;">#<?= $tag['name'] ?></h1>

	<br>

	<?php foreach ($posts as $post) : ?>
		<?php include 'parts/post.php'; ?>
	<?php endforeach; ?>
</div>