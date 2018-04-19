<div class="content">
	<h1 class="text-center">Категории</h1>
	<div class="row" style="margin-left: 0%;">
		<?php foreach($data as $one) : ?>
			<div class="col-md-4 col-sm-10 col-sm-offset-1 col-md-offset-0 col-lg-offset-0 col-xs-offset-0 col-xs-12">
				<?php include 'parts/card.php' ?>
			</div>
		<?php endforeach; ?>
	</div>
</div>
