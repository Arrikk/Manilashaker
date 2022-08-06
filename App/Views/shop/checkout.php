<div id="content" class="site-content" tabindex="-1">
    <div class="container">

        <nav class="woocommerce-breadcrumb"><a href="/shop/product">Home</a><span class="delimiter"><i class="fa fa-angle-right"></i></span>Checkout</nav>

        <div id="primary" class="content-area">
            <main id="main" class="site-main">
                <article class="page type-page status-publish hentry">
                    <header class="entry-header">
                        <h1 itemprop="name" class="entry-title">Checkout</h1>
                    </header><!-- .entry-header -->
                    <form action="" method="post" id="checkout-order">
                        <?php __shop_checkout_billing($__billing ?? []) ?>
                    </form>
                </article>
            </main><!-- #main -->
        </div><!-- #primary -->
    </div><!-- .container -->
</div><!-- #content -->

