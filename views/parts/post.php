<div class="post">
			<div class="title">
				<h1 class="text-left">
					<?= $post['title'] ?>
					
					<?php if ($post['user']['id'] == $c->userObj->getUserIdByAuth(@$_COOKIE['auth'])): ?>

					<a href="" title="Edit"><span class="glyphicon glyphicon-edit" style="font-size: 16px; color: gray"></span></a>

					<?php endif; ?>

				</h1>
			</div>
			<div class="stats">
				<div class="date">
					<span class="glyphicon glyphicon-calendar"></span>
					<?= $post['created'] ?>
				</div>
				<div class="category">
					<div class="category-icon"></div>
					<a href="<?= $c->url ?>category/<?= $post['category']['id'] ?>">
						<?= $post['category']['name'] ?>
					</a>
				</div>
				<div class="author">
					<div style="
						background: url(/web/images/users/<?= $post['user']['image'] ?>) no-repeat; 
						background-position: center center;
						background-size: cover;
						margin-bottom: -8px;
						width: 30px;
						height: 30px;
						border-radius: 100px;
					"></div>
					<a href="<?= $c->url ?>user/<?= $post['user']['id'] ?>">
						<?= $post['user']['name'] ?>
					</a>
				</div>
			</div>
			<div class="preview"><?= $post['preview'] ?></div>

			<div class="row" style="margin-top: 15px;">
				<div class="col-md-8 col-sm-7 col-xs-6">
					<?php foreach($post['tags'] as $tags) : ?>
						<?php $tag = $tags['tag']['name']; ?>

						<a href="/tag/<?= $tags['tag']['id'] ?>" class="tag">#<?= $tag ?></a>


					<?php endforeach; ?>
				</div>
				<div class="col-md-4 col-sm-5 col-xs-6">
					<div class="read"><a href="/post/<?= $post['id'] ?>">Читать дальше
					 <span class="glyphicon glyphicon-menu-right"></span></a></div>
				</div>
			</div>
		</div>