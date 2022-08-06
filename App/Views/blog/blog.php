<div id="content" class="site-content" tabindex="-1">
	<div class="container">
		<nav class="woocommerce-breadcrumb"><a href="/">Home</a><span class="delimiter"><i class="fa fa-angle-right"></i></span>Blog<?php if (isset($__POST__->post_title)) echo '<span class="delimiter"><i class="fa fa-angle-right"></i></span>' . $__POST__->post_title; if (isset($__category_name)) echo '<span class="delimiter"><i class="fa fa-angle-right"></i></span>' . $__category_name;?></nav>

		<div id="primary" class="content-area">
			<main id="main" class="site-main">
				<!-- Main Blog Content -->
				<?php if ($__BLOG__  == 'MAIN' || $__BLOG__ == 'CATEGORY') : ?>
					<?php __blog_post($__BLOG__, $__cat_post ?? [], $__style ?? '') ?>
					<?php __blog_pagination($__BLOG__) ?>
				<?php endif; ?>

				<!-- Main Blog Content -->
				<!-- Single Blog Content -->
				<?php if ($__BLOG__  == 'SINGLE') : ?>
					<?php __blog_single_post(); ?>
					<!-- < ?php __blog_author_info(); ?> -->
					<!-- < ?php __blog_navigation(); ?> -->
					<?php __blog_comment(); ?>
				<?php endif; ?>
				<!-- Single Blog Content -->
			</main><!-- #main -->
		</div><!-- #primary -->

		<div id="sidebar" class="sidebar-blog" role="complementary">
			<?php __blog_category_widget(); ?>
			<?php __blog_tag_widget(); ?>
			<?php __blog_search_widget(); ?>
			<?php __blog_must_read(); ?>
			<?php __blog_recent_widget(); ?>
			<?php __blog_recent_widget('other'); ?>
		</div>
	</div><!-- .container -->
</div><!-- #content -->