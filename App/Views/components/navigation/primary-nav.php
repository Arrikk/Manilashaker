<?php

use App\Models\Blog;
use App\Models\Product;

function __primary_nav()
{
	$blog_cat = $GLOBALS['blog']['__blog_category'];
?>

	<div class="primary-nav animate-dropdown">
		<div class="clearfix">
			<button class="navbar-toggler hidden-sm-up pull-right flip" type="button" data-toggle="collapse" data-target="#default-header">
				&#9776;
			</button>
		</div>

		<div class="collapse navbar-toggleable-xs" id="default-header">
			<nav>
				<ul id="menu-main-menu" class="nav nav-inline yamm">
					<li class="menu-item menu-item-has-children animate-dropdown dropdown"><a title="Home" href="/" data-toggle="dropdown" class="main" aria-haspopup="true" aria-expanded="false">Home</a>
						<ul role="menu" class=" dropdown-menu">
							<li class="menu-item animate-dropdown"><a title="Compare" href="/">All News</a></li>
							<?php
							if (count($blog_cat) > 0) {
								foreach ($blog_cat as $key => $value) {
									echo '<li class="menu-item animate-dropdown"><a title="' . $value->category_name . '" href="/category/'. $value->slug .'">' . $value->category_name . '</a></li>';
								}
							}
							?>
						</ul>
					</li>
					<!-- <li class="menu-item animate-dropdown"><a title="Compare" href="/compare/gadget/phones">Compare</a></li> -->
					<li class="menu-item menu-item-has-children animate-dropdown dropdown"><a title="Compare" href="/compare/phones/" data-toggle="dropdown" class=" main" aria-haspopup="true" aria-expanded="false">Compare</a>
						<ul role="menu" class="dropdown-menu">
							<li class="menu-item animate-dropdown"><a title="Compare" href="/compare/phones/">Compare</a></li>
							<?php foreach (Product::categories() as $key => $value) : ?>
								<li class="menu-item menu-item-has-children animate-dropdown dropdown"><a title="Compare <?= $value->category_name ?>" href="/compare/<?= $value->category_slug ?>/" class="">Compare <?= $value->category_name ?></a>
									<ul role="menu" class=" dropdown-menu">
										<?php foreach (Product::childCategory($value->category_id) as $key => $value) : ?>
											<li class="menu-item animate-dropdown"><a title="Compare <?= $value->category_name ?>" href="/compare/<?= $value->category_slug ?>/">Compare <?= $value->category_name ?></a></li>
										<?php endforeach; ?>
									</ul>
								</li>
							<?php endforeach; ?>
						</ul>
					</li>
					<li class="menu-item menu-item-has-children animate-dropdown dropdown"><a title="Gadgets" href="/mobile-phones/" data-toggle="dropdown" class=" main" aria-haspopup="true" aria-expanded="false">Gadgets</a>
						<ul role="menu" class="dropdown-menu">
							<li class="menu-item animate-dropdown"><a title="Gadgets" href="/mobile-phones/">All Gadgets</a></li>
							<?php foreach (Product::categories() as $key => $value) : ?>
								<li class="menu-item menu-item-has-children animate-dropdown dropdown"><a title="<?= $value->category_name ?>" href="/<?= $value->category_slug == 'phones' ? 'mobile-phones' : $value->category_slug ?>/" data-toggle="dropdown" class="dropdown-toggle href-link" aria-haspopup="true" aria-expanded="false"><?= $value->category_name ?></a>
									<ul role="menu" class=" dropdown-menu">
										<?php foreach (Product::childCategory($value->category_id) as $key => $value) : ?>
											<li class="menu-item animate-dropdown"><a title="<?= $value->category_name ?>" href="/gadgets/<?= $value->category_slug ?>"><?= $value->category_name ?></a></li>
										<?php endforeach; ?>
									</ul>
								</li>	
							<?php endforeach; ?>
						</ul>
					</li>
					<li class="menu-item animate-dropdown"><a title="Videos" href="/category/tech">Tech</a></li>
					<li class="menu-item animate-dropdown"><a title="Videos" href="/category/reviews">Review</a></li>
					<li class="menu-item animate-dropdown"><a title="More" href="/category/automotive">Automotive</a></li>
					<li class="menu-item animate-dropdown"><a title="More" href="/category/guides">Guides</a></li>
					<!-- <li class="menu-item animate-dropdown ui-override-search">
						<i class="bi bi-search"></i>
					</li> -->
				</ul>
			</nav>
		</div>
	</div>
	<!-- Previous nav class removed  -->
	<!-- dropdown-toggle -->

<?php
}

function __primary_nav_cat()
{

	$icons = [
		'phones' => 'bi bi-phone',
		'laptops' => 'bi bi-laptop',
		'television' => 'fa fa-television',
		'tablet' => 'bi bi-tablet',
		'cameras' => 'bi bi-camera',
		'fitnessband' => 'fa fa-square-o',
		'airconditioner' => 'fa fa-mixcloud',
		'refrigerator' => 'fa fa-server',
		'smartwatch' => 'bi bi-smartwatch',
		'powerbank' => 'fa fa-battery-empty',
		'washing-machine' => 'bi bi-badge-wc',
		'' => ''
	];
?>
	<nav class="ui-override-navbar navbar navbar-primary navbar-full yamm">
		<div class="container">
			<div class="clearfix">
				<button class="navbar-toggler hidden-sm-up pull-right flip" type="button" data-toggle="collapse" data-target="#header-v3">
					☰
				</button>
			</div>

			<div class="collapse navbar-toggleable-xs" id="header-v3">
				<ul class="nav navbar-nav ui-override-nav">
					<?php
					foreach (Product::categories() as $key => $value) {
						$link = '/' . $value->category_slug.'/';
						if($link == '/phones/') $link = '/mobile-phones/';
						$links = explode('/', $_SERVER['REQUEST_URI']);
						if (in_array('compare', $links))
							$link = '/compare/' . $value->category_slug .'/';

						echo '<li style="text-align:center" class="ui-override-li menu-item
									animate-dropdown"><a class="ui ui-override-nav-a" style="font-size:smaller" title="' . $value->category_name . '" href="' . $link . '"><i style="display:block;font-size:24px;margin-bottom:10px" class="' . $icons[array_key_exists($value->category_slug, $icons) ? $value->category_slug : ''] . '" href="#"></i>' . $value->category_name . '</a></li>';
					}

					?>
				</ul>
			</div><!-- /.collpase -->
		</div><!-- /.-container -->
	</nav>
<?php
}
