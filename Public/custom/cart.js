let cart = JSON.parse(localStorage.getItem("cart"))
? JSON.parse(localStorage.getItem("cart"))
: [];
getCart();

function format(money){
  return(parseInt(money)).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')
}

// localStorage.removeItem('cart')
function addToCart(id) {
  let gadget = gadgets.find((g) => g.product_slug == id);
  let data = {
    price: gadget.product_price,
    name: gadget.product_name,
    image: gadget.product_image,
    slug: gadget.product_slug,
    gd: gadget.product_id,
    quantity: 1,
  };
  cart.push(data);
  localStorage.setItem("cart", JSON.stringify(cart));
  getCart();
}

function getCart() {
  cart = JSON.parse(localStorage.getItem("cart"))
    ? JSON.parse(localStorage.getItem("cart"))
    : [];

    if(location.pathname == "/shop/checkout"){
      if(location.search == ''){
        if(!cart.length > 0){
          window.location = '/shop/product'
  
        }
      }
    }

  // console.log(cart)

  if (cart.length > 0) {
    let totalPrice = cart
      .map((c) => +c.price * +c.quantity)
      .reduce((a, b) => a + b);
    document.querySelector(".cart-item-count").textContent = cart.length;
    document.querySelector(".cart-items-total-price").textContent =
      "$" + totalPrice;
    document.querySelector(".amount.total-amount").textContent =
      "$" + totalPrice;

    $("ul.cart_list.product_list_widget").html("");
    cart.forEach((i) => {
      $("ul.cart_list.product_list_widget").append(`
					<li class="mini_cart_item">
						<a title="Remove this item" class="remove" href="#">×</a>
						<a href="/shop/gadgets?item=${i.slug}">
							<img class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image" src="${i.image}" alt="">${i.name}&nbsp;
						</a>
	
						<span class="quantity">${i.quantity} x <span class="amount">${i.price}</span></span>
					</li>
				`);
    });
  } else {
    $("ul.cart_list.product_list_widget").html(`
				Cart is empty
				</li>
			`);
  }
}
if(cart.length > 0){
    cart.forEach(checkoutItem)
    let tt = cart.map(c => +c.price * +c.quantity).reduce((a,b) => a+b)
    $('.checkout-sb-total').text('$'+format(+tt))
}

function checkoutItem(e) {
  $("tbody.checkout-item-list").append(`
    <tr class="cart_item">
        <td class="product-name">
            ${e.name}&nbsp;
            <strong class="product-quantity">× ${e.quantity}</strong>
            <input type="hidden" name="checkout[${e.gd}]quantity[]" value="${e.quantity}" />
        </td>
        <td class="product-total">
            <span class="amount">$${format(+e.quantity * +e.price)}</span>
        </td>
    </tr>
    `);
}

$(document).on('submit', 'form#checkout-order', function(e){
    e.preventDefault();
    let btn = $('[class="button alt btn-checkout"]')
    // let data = 
    $.ajax({
        url: '/shop/checkout',
        method: 'POST',
        data: new FormData(this),
        processData: false,
        contentType: false,
        beforeSend: function(){
            btn.attr('disabled', 'disabled').val('Please wait')
        },
        success: function(e){
            btn.attr('disabled', false).val('Place order')
            console.log(e);
            localStorage.removeItem('cart')
            window.location = '/shop/checkout?success'
        },
        error: function(e, t){
            btn.attr('disabled', false).val('Place order')
        }
    })
    
  })

  $('[name="star"]').on('change', function(){
    $('[name="star"]').not(this).prop('checked', false)
  })

  $(document).on('submit', '#_rating_form', function(e){
    e.preventDefault();

    let btn = $('[id="submit"]')

    let comment = $('[id="comment"]').val()
    if(comment == ''){
      $('.comment-alert').html('Enter a message').fadeIn()
    }else{

      $.ajax({
        url: '/shop/product-rating',
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        beforeSend: function(){
          btn.attr('disabled', 'disabled')
        },
        success: function(e){
          console.log(e);
          btn.attr('disabled', false)
          location.reload()
        },
        error: function(e){
          btn.attr('disabled', false)
          if(e.status == 400){
            $('.comment-alert').text(e.responseJSON).fadeIn()
          }
          if(e.status == 401){
            $('.comment-alert').text(e.responseJSON).fadeIn()
            window.location = '/login'
          }
          console.log(e);
        }
      })
    }

  })
  // console.log(JSON.parse(product))
