<div class="content">

	<?php if (!@$data): ?>

		<h1 style="margin-top: 80px; color: #444;">В блоге все еще нет постов.</h1>

	<?php else: ?>

		<?php foreach($data as $post) : ?>

			<?php if (!$post['active']) continue; ?>

			<?php include 'parts/post.php' ?>

		<?php endforeach; ?>
	
	<?php endif; ?>

</div>
