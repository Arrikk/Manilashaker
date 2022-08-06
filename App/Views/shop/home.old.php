<div id="content" class="site-content" tabindex="-1">
	<div class="container">

		<div id="primary" class="content-area" style="margin-top:<?php if (isset($__category)) echo '50px;';
																	else echo '0;'; ?>">
			<!-- <main id="main" class="site-main"> -->
			<!-- < ?php require_once 'inc/blocks/homepage/home-v2-slider.php'; ?> -->
			<!-- < ?php __shop_carousel_tab() ?> -->
			<main id="main" class="site-main">
				<?php if (!isset($__category)) : ?>
					<?php __home_slider() ?>
					<!-- < ?php __shop_ads_block() ?> -->
				<?php endif; ?>
				<?php __shop_home_banner() ?>
				<header class="page-header">
					<!-- <h1 class="page-title">< ?= $__slug ?? "" ?></h1> -->
				</header>
				<?php __shop_all_product() ?>
				<div class="shop-control-bar-bottom">
					<p class="woocommerce-result-count wooc-loader" style="display:none">Loading...</p>
					<!-- <nav class="woocommerce-pagination">
						<ul class="page-numbers">
							<li><span class="page-numbers"></span></li>
							<li><a href="javascript:;" class="page-numbers current load-more-gadget">Show More</a></li>
						</ul>
					</nav> -->
				</div>
				<?php __shop_deals() ?>
				<!-- </main> -->
			</main><!-- #main -->
		</div><!-- #primary -->
		<div id="sidebar" class="sidebar" role="complementary" style="margin-top: <?php if (isset($__category)) echo '50px;'; else echo '520px;'; ?>">
			<div class="home-v1-deals-and-tabs deals-and-tabs row animate-in-view fadeIn animated" data-animation="fadeIn">

				<!-- < ?php __sidebar_menu_category() ?> -->
				<?php __sidebar_filter_product() ?>
				<?php __sidebar_latest_product() ?>
				<!-- < ?php __sidebar_shop_latest_cat() ?> -->
				<?php __sidebar_widget_ads() ?>
				<!-- < ?php __sidebar_shop_extra() ?> -->
				<?php __blog_recent_widget() ?>
			</div>
		</div>


		</div><!-- .container -->
	</div><!-- #content -->

	<script>
		let gadgets
		let filtered = []
		let cart
		let page = 0;
		// getCart()

		// localStorage.removeItem('cart')
		function addToCart(id) {
			let gadget = gadgets.find(g => g.product_slug == id);
			let data = {
				price: gadget.product_price,
				name: gadget.product_name,
				image: gadget.product_image,
				slug: gadget.product_slug,
				gd: gadget.product_id,
				quantity: 1
			}

			cart.push(data)

			localStorage.setItem('cart', JSON.stringify(cart))
			getCart()
		}

		function getCart() {
			cart = JSON.parse(localStorage.getItem('cart')) ? JSON.parse(localStorage.getItem('cart')) : []


			// console.log(cart)

			if (cart.length > 0) {
				let totalPrice = cart.map(c => +c.price * +c.quantity).reduce((a, b) => a + b)
				document.querySelector('.cart-item-count').textContent = cart.length
				document.querySelector('.cart-items-total-price').textContent = '$' + totalPrice
				document.querySelector('.amount.total-amount').textContent = '$' + totalPrice

				$('ul.cart_list.product_list_widget').html('')
				cart.forEach(i => {
					$('ul.cart_list.product_list_widget').append(`
					<li class="mini_cart_item">
						<a title="Remove this item" class="remove" href="#">×</a>
						<a href="/gadgets/gadgets?item=${i.slug}">
							<img class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image" src="${i.image}" alt="">${i.name}&nbsp;
						</a>
	
						<span class="quantity">${i.quantity} x <span class="amount">${i.price}</span></span>
					</li>
				`)
				})
			} else {
				$('ul.cart_list.product_list_widget').html(`
				Cart is empty
				</li>
			`)
			}
		}
		getGadgets()

		function getGadgets() {

			let link = location.pathname
			let split = link.split('/')
			console.log(split)

			let loclink = '/fetch/fetch_all_product/' + location.search
			// position = split[split.length - 1]
			if (split.length > 2 ) {
				loclink = '/fetch/' + split[split.length - 1] + '/' + location.search
				console.log(split[split.length -1] == '')
				if(split[split.length -1] == '') loclink = '/fetch/'+split[split.length - 2]+'/'+location.search
			}

			fetch(loclink)
				.then(res => res.json())
				.then(data => {
					gadgets = data
					gadgets.forEach(gadgetsItem)
				})
		}


		function gadgetsItem(e) {
			let obj = e.product_specification,
			objectLength = Object.keys(obj).length
			let keys = false, it1, it2
			// console.log({length: Object.keys(obj).length, obj, id:e.product_id})

			if (objectLength > 0) {
			 keys = Object.keys(obj);
				let item = obj[keys[2]];
				keys = Object.keys(item);
				 it1 = item[keys[1]];
				 it2 = item[keys[2]];

			}
				let category_name = e.category_name.replace(/\s/g, '-')
				$('ul.gadgets-display').append(`
							<li class="product list-view">
								<div class="media">
									<div class="media-left">
										<a href="/${category_name}/${e.product_slug}">
											<img style="width:200px;height:200px;object-fit:contain" class="wp-post-image" data-echo="${e.product_image}" src="/Public/assets/images/default.jpg" alt="">
										</a>
									</div>
									<div class="media-body media-middle">
										<div class="row">
											<div class="col-xs-12">
												<span class="loop-product-categories"><a rel="tag" href="/${category_name}/${e.product_slug}">${category_name}</a></span><a href="/${category_name}/${e.product_slug}"><h3>${e.product_name}</h3>
													<div class="product-rating">
														<div title="Rated ${e.rating['rating']} out of 5" class="star-rating"><span style="width:${Math.ceil(e.rating['rating'] * 20)}%"><strong class="rating"> ${e.rating['rating']}</strong> out of 5</span></div> ( ${e.rating['comment'].length} reviews)
													</div>
													<div class="product-short-description">
														<ul style="padding-left: 18px;">
															<li>Rated ${e.rating['rating']} out of 5</li>
															<li>${keys ? keys[1] : ''}: ${it1 ?? ''}</li>
															<li>${keys ? keys[2] : ''}: ${it2 ?? ''}</li>
															<li>Android 4.4 KitKat OS</li>
															<li>1.4 GHz Quad Core™ Processor</li>
															<li>20 MP front Camera</li>
														</ul>
														<ul style="padding-left: 18px;">
																				</ul>
													</div>
												</a>
											</div>
											<div class="col-xs-12">

																		<div class="availability in-stock">Critic Review: <span> ${e.rating['comment'].length}</span></div>	

																		<span class="price"><span class="electro-price"><span class="amount">${money.sign}${money.money(e.product_price)}</span></span></span>
																		<a class="button product_type_simple add_to_cart_button ajax_add_to_cart" data-product_sku="" data-product_id="" data-quantity="1" href="/${category_name}/${e.product_slug}" rel="nofollow">Add to cart</a>
																		<div class="hover-area">
																			<div class="action-buttons">
																				<div class="clear"></div>
																				<a data-product_id="2706" class="add-to-compare-link" href="#">Compare</a>
																			</div>
																		</div>
																	</div>
											
										</div>
									</div>
								</div>
							</li>
						`)

		}
		$(document).on('click', '.load-more-gadget', function() {
			page++;
			console.log(page)
			$('.wooc-loader').fadeIn()
			fetch('/gadgets/gadgets?all&page=' + page)
				.then(res => res.json())
				.then(data => {
					gadgets = data
					gadgets.forEach(gadgetsItem)
					$('.wooc-loader').fadeOut()
				})
		})
		$(document).on('click', '.add-to-compare-link', function() {
			let id = $(this).attr('id');
			let compared = JSON.parse(localStorage.getItem('compare')) ? JSON.parse(localStorage.getItem('compare')) : []
			// compared.find(c => c == id)
			if (compared.length > 4) {
				alert('Compared list is filled up.')
			} else {

				compared.push(id)
				localStorage.setItem('compare', JSON.stringify(compared))
				alert('Product added to compare')
			}
		})
		$(document).on('click', '.filter-brand', function() {
			let target = $(this).data('target')
			fetch('/gadgets/filter?filter=' + target).then(res => res.json())
				.then(data => {
					filtered = [...filtered, ...data].reverse()
					if (filtered.length > 0) {
						console.log(filtered)
						$('ul.gadgets-display').html('')
						filtered.forEach(gadgetsItem)
					}
				})
		})
	</script>