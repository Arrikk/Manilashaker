		
<div id="content" class="site-content" tabindex="-1">
	<div class="container">

		<nav class="woocommerce-breadcrumb">
			<!-- <a href="/">Home</a> -->
			<!-- <span class="delimiter"><i class="fa fa-angle-right"></i></span>
			<a href="index.php?page=product-category">Accessories</a>
			<span class="delimiter"><i class="fa fa-angle-right"></i></span>
			<a href="index.php?page=product-category">Headphones</a>
			<span class="delimiter"><i class="fa fa-angle-right"></i>
			</span>Ultra Wireless S50 Headphones S50 with Bluetooth -->
		</nav><!-- /.woocommerce-breadcrumb -->

		<div id="primary" class="content-area">
			<main id="main" class="site-main">		

				<div class="product">

					<div class="single-product-wrapper">
						<div class="product-images-wrapper">
							<span class="onsale">Sale!</span>
							 <!-- < ?php require_once 'inc/blocks/single-product/images-block.php'; ?> -->
							 <?php __shop_single_img($__product) ?>
						</div><!-- /.product-images-wrapper -->

						<?php __shop_single_summary($__product, $__reviews) ?>

					</div><!-- /.single-product-wrapper -->


					<div class="woocommerce-tabs wc-tabs-wrapper">
						<ul class="nav nav-tabs electro-nav-tabs tabs wc-tabs" role="tablist">
							<li class="nav-item description_tab">
								<a href="#tab-description" class="active" data-toggle="tab">Description</a>
							</li>
						</ul>

						<div class="tab-content">

							<div class="tab-pane active in panel entry-content wc-tab" id="tab-description">
								<?php __shop_single_desc($__product->product_description) ?>
							</div>   
						</div>
					</div><!-- /.woocommerce-tabs -->
					<div class="woocommerce-tabs wc-tabs-wrapper">
						<ul class="nav nav-tabs electro-nav-tabs tabs wc-tabs" role="tablist">
							<li class="nav-item specification_tab">
								<a href="#tab-specification" class="active" data-toggle="tab">Specification</a>
							</li>
						</ul>
						<div>
							<div class="tab-pane active in panel entry-content wc-tab" id="tab-specification">
								<?php __shop_single_spec($__product) ?>
							</div><!-- /.panel -->
						</div>
					</div><!-- /.woocommerce-tabs -->
					<div class="woocommerce-tabs wc-tabs-wrapper" id="rt-tab">
						<ul class="nav nav-tabs electro-nav-tabs tabs wc-tabs" role="tablist">
							<li class="nav-item reviews_tab">
								<a href="#tab-reviews" class="active" data-toggle="tab">Reviews</a>
							</li>
						</ul>

						<div class="tab-content">
							<div class="tab-pane active in panel entry-content wc-tab" id="tab-reviews">
								<?php __shop_review_panel($__product->product_id, $__reviews) ?>
							</div><!-- /.panel -->     
						</div>
					</div><!-- /.woocommerce-tabs -->
				</div><!-- /.product -->

			</main><!-- /.site-main -->
		</div><!-- /.content-area -->
        <div id="sidebar" class="sidebar" role="complementary" style="margin-top: 45px;">
                    <?php __sidebar_latest_product() ?>
                    <?php __sidebar_shop_extra() ?>
                    <?php __sidebar_widget_ads() ?>
                    <?php __blog_recent_widget() ?>
                </div>
	</div><!-- /.container -->
</div><!-- /.site-content -->
<script>
    let product = '<?php echo json_encode($__product) ?>'
</script>


