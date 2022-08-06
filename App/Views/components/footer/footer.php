<?php

use App\Models\Product;
use App\Models\Shop;

function __footer($template = false)
{
	extract($GLOBALS['site']);
	$footer_widget = $GLOBALS['footer_widget'];
?>
	<!-- < ?php if (!$template) : ?> -->
	<!-- < ?php else : ?> -->
		<footer>
			<div class="ui-footer-container">
				<?php __ui_footer_widget_1() ?>
				<?php __ui_footer_widget_2() ?>
				<?php __ui_footer_widget_3() ?>
				<?php __ui_footer_widget_4() ?>
			</div>

			<div class="ui-footer-bottom">
				copyright &copy; <?= date('Y') ?> Manilashaker
			</div>
		</footer>
	<!-- < ? php endif; ?> -->

<?php
}

function __footer_old()
{
	$footer_widget  = [];
	?>

<footer id="colophon" class="site-footer">
			<div class="footer-widgets">
				<div class="container">
					<div class="row">
						<?php foreach ($footer_widget as $key => $value) : ?>
							<div class="col-lg-4 col-md-4 col-xs-12">
								<aside class="widget clearfix">
									<div class="body">
										<h4 class="widget-title"><?= str_replace('-', ' ', $key) ?></h4>
										<ul class="product_list_widget">
											<?php foreach ($value as $val) : ?>
												<li>
													<a href="/<?= $val->product_category ?>/<?= $val->product_slug ?>" title="<?= $val->product_name ?>">
														<img class="wp-post-image" data-echo="<?= $val->product_image ?>" src="/Public/assets/images/blank.gif" alt="">
														<span class="product-title"><?= $val->product_name ?></span>
													</a>
													<?php
													$rev = Shop::getReviews($val->product_id);
													?>
													<div class="star-rating" title="Rated 5 out of 5"><span style="width:<?= $rev['rating'] * 20 ?>%"><strong class="rating">5</strong> out of 5</span></div> <span class="electro-price"><ins><span class="amount"><?= SIGN . number_format($val->product_price, 2) ?></span></ins></span>
												</li>
											<?php endforeach; ?>
										</ul>
									</div>
								</aside>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>

			<div class="footer-newsletter">
				<div class="container">
					<div class="row">
						<div class="col-xs-12 col-sm-7">
							<h5 class="newsletter-title">Sign up to Newsletter</h5>
							<span class="newsletter-marketing-text">...and receive <strong>insider news about manilashaker</strong></span>
						</div>
						<div class="col-xs-12 col-sm-5">
							<form>
								<div class="input-group">
									<input type="text" class="form-control" placeholder="Enter your email address">
									<span class="input-group-btn">
										<button class="btn btn-secondary" style="background-color: #04515b;" type="button">Sign Up</button>
									</span>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

			<div class="footer-bottom-widgets">
				<div class="container">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-5 col-md-push-7">
							<div class="columns">
								<aside id="nav_menu-2" class="widget clearfix widget_nav_menu">
									<div class="body">
										<h4 class="widget-title">Find It Fast</h4>
										<div class="menu-footer-menu-1-container">
											<ul id="menu-footer-menu-1" class="menu">
												<?php if (count(Product::categories()) > 0) : $i = 0; ?>
													<?php foreach (Product::categories() as $cat) : if ($i > 5) continue; ?>
														<li class="menu-item"><a href="/shop/product?category=<?= $cat->category_slug ?>"><?= $cat->category_name ?></a></li>
													<?php $i++;
													endforeach; ?>
												<?php endif; ?>
											</ul>
										</div>
									</div>
								</aside>
							</div><!-- /.columns -->

							<!-- <div class="columns">
						<aside id="nav_menu-3" class="widget clearfix widget_nav_menu">
							<div class="body">
								<h4 class="widget-title">&nbsp;</h4>
								<div class="menu-footer-menu-2-container">
									<ul id="menu-footer-menu-2" class="menu">
										<li class="menu-item"><a href="">Printers &#038; Ink</a></li>
										<li class="menu-item "><a href="">Software</a></li>
										<li  class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-2742"><a href="">Office Supplies</a></li>
										<li  class="menu-item "><a href="">Computer Components</a></li>
									</ul>
								</div>
							</div>
						</aside>
					</div> -->
							<!-- /.columns -->

							<div class="columns">
								<aside id="nav_menu-4" class="widget clearfix widget_nav_menu">
									<div class="body">
										<h4 class="widget-title">Quick Menu</h4>
										<div class="menu-footer-menu-3-container">
											<ul id="menu-footer-menu-3" class="menu">
												<li class="menu-item"><a href="">News</a></li>
												<li class="menu-item"><a href="">Compare</a></li>
												<li class="menu-item"><a href="">Gadgets</a></li>
											</ul>
										</div>
									</div>
								</aside>
							</div><!-- /.columns -->

						</div>
						<!-- /.col -->

						<div class="footer-contact col-xs-12 col-sm-12 col-md-7 col-md-pull-5">
							<div class="footer-logo">
								<a href="/" class="header-logo-link">
									<img style="width:200px" src="<?=
																	$__site ?? $__site->site_logo !== '' ||  $__site->site_logo !== NULL
																		? $__site->site_logo :  '/Public//Public/assets/images/fav-icon.png'
																	?>" alt="" srcset="">
								</a>
							</div>
							<div class="footer-call-us">
								<div class="media">
									<span class="media-left call-us-icon media-middle"><i class="ec ec-support"></i></span>
									<div class="media-body">
										<span class="call-us-text">Got Questions ? Call us 24/7!</span>
										<span class="call-us-number">
											<?=
											$__info ?? $__info->phone1 !== '' ||  $__info->phone1 !== NULL
												? $__info->phone1 :  'Phone';
											$__info ?? $__info->phone2 !== '' ||  $__info->phone2 !== NULL
												? $__info->phone2 :  'Phone'
											?>
										</span>
									</div>
								</div>
							</div><!-- /.footer-call-us -->


							<!-- <div class="footer-address">
						<strong class="footer-address-title">Contact Info</strong>
						<address>
							< ?=
								$__info ?? $__info->address !== '' ||  $__info->address !== NULL 
								? $__info->address :  'Address'
							?>
						</address>
					</div> -->
							<!-- /.footer-address -->

							<div class="footer-social-icons">
								<ul class="social-icons list-unstyled">
									<li><a class="fa fa-facebook" href="https://www.facebook.com/ManilaShaker/"></a></li>
									<li><a class="fa fa-twitter" href="https://twitter.com/ManilaShaker"></a></li>
									<li><a class="fa fa-instagram" href="https://www.instagram.com/manilashaker/"></a></li>
									<li><a class="fa fa-youtube" href="https://www.youtube.com/channel/UCQR9iULKOpbCX9UUNsPnASg"></a></li>
								</ul>
							</div>
						</div>

					</div>
				</div>
			</div>

			<div class="copyright-bar">
				<div class="container">
					<div class="pull-left flip copyright">&copy; <a href="/">Manilashaker</a> - All Rights Reserved</div>
				</div><!-- /.container -->
			</div><!-- /.copyright-bar -->
		</footer><!-- #colophon -->
	<?php
}
