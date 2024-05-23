	<?php

	$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
	$this->params['baseurl'] = $webasset->baseUrl;
	?>
	<!-- main-header -->
	<header class="header_wrapper navigation_hide">
		<div class="container">
			<div class="col-12 text-center pt-3">
				<a href="index.html">
					<img src="<?= $this->params['baseurl'] ?>/img/logo.png" alt="logo" width="180" class="logo">
				</a>
			</div>
		</div>
	</header>
	<!-- /main-header -->