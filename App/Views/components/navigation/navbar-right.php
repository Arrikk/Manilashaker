<?php
function __navbar__right()
{
?>
    <ul class="navbar-mini-cart navbar-nav animate-dropdown nav pull-right flip">
        <li class="nav-item dropdown">
            <a href="#" class="nav-link" data-toggle="dropdown" aria-expanded="">
                <i class="ec ec-shopping-bag"></i>
                <span class="cart-items-count count cart-item-count">0</span>
                <span class="cart-items-total-price total-price"><span class="amount">$0</span></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-mini-cart">
                <li>
                    <div class="widget_shopping_cart_content">

                        <ul class="cart_list product_list_widget ">


                        </ul><!-- end product list -->


                        <p class="total"><strong>Subtotal:</strong> <span class="amount total-amount">0</span></p>


                        <p class="buttons">
                            <a class="button wc-forward" href="/shop/cart">View Cart</a>
                            <a class="button checkout wc-forward" href="/shop/checkout">Checkout</a>
                        </p>


                    </div>
                </li>
            </ul>
        </li>
    </ul>

    <ul class="navbar-wishlist nav navbar-nav pull-right flip">
        <li class="nav-item">
            <a href="#" class="nav-link"><i class="ec ec-favorites"></i></a>
        </li>
    </ul>
    <ul class="navbar-compare nav navbar-nav pull-right flip">
        <li class="nav-item">
            <a href="/shop/compare" class="nav-link"><i class="ec ec-compare"></i></a>
        </li>
    </ul>

    <script>
        // let links = document.querySelector('a.nav-link')
        // links.addEventListener('click', function(){
        //     document.querySelector('li.nav-item.dropdown').classList.toggle('open')
        // })
    </script>
<?php
}
