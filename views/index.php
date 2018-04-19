<div class="content">
	<?php foreach($data as $post) : ?>

		<?php if (!$post['active']) continue; ?>

		<?php include 'parts/post.php' ?>

	<?php endforeach; ?>
</div>
