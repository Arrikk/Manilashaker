<style>
    .table-compare tbody tr td {
        vertical-align: unset !important;
    }
    .compare-text{
        margin-bottom: 20px;
    }
    .compare-text p{
        flex: 4;
    }
    .compare-text div{
        flex: 2;
    }
    @media only screen and (max-width: 500px){
        .compare-text{font-size: 18px; text-align: justify;}
    }
</style>
<div tabindex="-1" class="site-content" id="content">
    <div class="container no-flex">
        <nav class="woocommerce-breadcrumb"><a href="/">Home</a><span class="delimiter"><i class="fa fa-angle-right"></i></span>Compare
            <?php
            if (isset($param))
                echo '<span class="delimiter"><i class="fa fa-angle-right"></i></span>' . $param . '';
            ?>
        </nav>
        <section class="brands-carousel mt-50" style="margin-top: 50px;">
            <div class="content-area" style="margin-top: 50px;">
                <h3 style="margin: 20px 0;">Compare</h3>
                <div class="row">
                    <form id="compare-gadget-form" method="POST">
                        <?php if (isset($gadget)) : ?>
                            <?php if (count($gadget) > 0) : ?>
                                <?php foreach ($gadget as $gadget => $val) : ?>
                                    <td>
                                        <div class="col-md-3">
                                            <img style="width: 100%; height: 100px;object-fit: contain;" id="<?= $gadget ?>" src="https://www.freeiconspng.com/thumbs/add-icon-png/add-icon--line-iconset--iconsmind-29.png" alt="">
                                            <select name="compare_<?= $gadget ?>" class="form-control" id="product-compare-select">
                                                <option value="">Select</option>
                                                <?php foreach ($val as $val) : ?>
                                                    <option data-id="<?= $gadget ?>" data-image="<?= $val->product_image ?>" value="<?= $val->product_slug ?>">
                                                        <?= $val->product_name ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </td>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <input type="submit" value="Compare" class="btn btn-primary">
                            <input type="hidden" name="compare_category" value="<?= $param ?? '' ?>">
                        <?php endif; ?>
                    </form>
                    <!-- <td>
                        <div class="col-md-3">
                            <img src="/Public/assets/images/onsale-product.jpg" alt="">
                            <select name="" class="form-control" id="">
                                <option value="">Name</option>
                                <option value="">Name</option>
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="col-md-3">
                            <img src="/Public/assets/images/onsale-product.jpg" alt="">
                            <select name="" class="form-control" id="">
                                <option value="">Name</option>
                                <option value="">Name</option>
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="col-md-3">
                            <img src="/Public/assets/images/onsale-product.jpg" alt="">
                            <select name="" class="form-control" id="">
                                <option value="">Name</option>
                                <option value="">Name</option>
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="col-md-3">
                            <img src="/Public/assets/images/onsale-product.jpg" alt="">
                            <select name="" class="form-control" id="">
                                <option value="">Name</option>
                                <option value="">Name</option>
                            </select>
                        </div>
                    </td> -->
                </div>
            </div>
        </section>
        <div class="content-area compare-table" style="display: none;" id="primary">
            <main class="site-main" id="main">
                <article class="post-2917 page type-page status-publish hentry" id="post-2917">
                    <div itemprop="mainContentOfPage" class="entry-content">
                        <div class="table-responsive">
                            <table class="table table-compare compare-list">
                                <tbody>
                                    <tr class="_product-remove">
                                        <td>Clear</td>
                                    </tr>
                                    <tr class="_product-product">
                                        <td>Product</td>
                                    </tr>
                                    <tr class="_product-price">
                                        <td>Price</td>
                                    </tr>
                                    <tr class="_product-availability">
                                        <td>Availability</td>
                                    </tr>
                                    <tr class="_product_specifications"></tr>

                                    <?php
                                    $specification = $formatted ?? [];
                                    
                                    function run($iterator, $item){
                                        if ($iterator <= 0) return $item;
                                        if (!array_key_exists($iterator, $item))
                                            $item[$iterator] = '__';
                                        ksort($item);
                                        return run($iterator  - 1, $item); 
                                    }

                                    foreach ($formatted as $key => $value) :
                                        echo '<tr><th colspan="5">' . strtoupper(str_replace('_', ' ',$key)) . '</th></tr>';

                                        foreach ($value as $key => $values) :
                                            echo '<tr>
                                            <td>' . ucfirst(str_replace('_', ' ', $key)) . '</td>';

                                            $values = run($max, $values);
                                            foreach ($values as $key => $text) :
                                                echo '<td>' . ($text) . '</td>';
                                            endforeach;
                                            echo '</tr>';
                                        endforeach;
                                    endforeach;
                                    ?>
                                    <tr class="_product-summary">
                                        <td>Summary</td>
                                    </tr>
                                    <tr style="border:0">
                                        <td style="border:0"></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div><!-- /.table-responsive -->
                    </div><!-- .entry-content -->
                </article><!-- #post-## -->
            </main><!-- #main -->
        </div><!-- #primary -->
        <div class="compare-text">
            <?= html_entity_decode($__description) ?>
            <div>

            </div>
        </div>
        <div class="accessories" id="recent-accessories" style="display: none;">
            <h2>Recent Compare</h2>

            <div class="electro-wc-message"></div>
            <div class="row">
                <div class="col-xs-12 col-sm-9 col-left">
                    <ul class="products columns-3" id="recent-compare">

                    </ul><!-- /.products -->
                </div><!-- /.col -->

                <div class="col-xs-12 col-sm-3 col-right">
                    <div class="accessories-add-all-to-cart">
                        <button type="button" class="button btn btn-primary recent-btn">Compare</button>
                        <input type="hidden" id="recent_type" value="recent">
                        <input type="hidden" id="recent_cat">
                    </div><!-- /.accessories-add-all-to-cart -->
                </div><!-- /.col -->
            </div><!-- /.row -->

        </div>
        <div class="accessories" id="popular-accessories" style="display: none;">
            <h2>Popular Compare</h2>

            <div class="electro-wc-message"></div>
            <div class="row">
                <div class="col-xs-12 col-sm-9 col-left">
                    <ul class="products columns-3" id="popular-compare">

                    </ul><!-- /.products -->
                </div><!-- /.col -->

                <div class="col-xs-12 col-sm-3 col-right">
                    <div class="accessories-add-all-to-cart">
                        <button type="button" class="button btn btn-primary popular-btn">Compare</button>
                        <input type="hidden" id="popular_type" value="popular">
                        <input type="hidden" id="popular_cat">
                    </div><!-- /.accessories-add-all-to-cart -->
                </div><!-- /.col -->
            </div><!-- /.row -->

        </div>
    </div><!-- .col-full -->
</div>

<script>
    $('#compare-gadget-form').on('submit', function(e) {
        e.preventDefault()
        let btn = $('[value="Compare" ]')
        btn.attr('disabled', 'disabled').text('Comparing')
        $.ajax({
            url: '/compare/save-comparison/',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(e) {
                btn.attr('disabled', false).text('Compare')
                console.log(e)
                window.location = e
            }
        })
    })
    let search = location.pathname
    search = search.split('/')
    console.log(search)
    // let compare = JSON.parse(localStorage.getItem('compare')) ? JSON.parse(localStorage.getItem('compare')) : []
    getCompare()
    getCompared()

    let specification = null

    function getCompare() {
        $.ajax({
            url: '/compare/compare/' + search[3],
            success: function(e) {
                if (e.length > 0) {
                    // console.log(e)
                    specification = e.map(key => JSON.parse(key.product_specification));
                    // console.log(specification)
                    let keyStorage = []
                    for (let i = 0; i < specification.length; i++) {
                        const element = specification[i];
                        for (const key in element) {
                            let isKey = keyStorage.some(e => e == key)
                            if (!isKey)
                                keyStorage.push(key)
                        }
                    }
                    e.forEach(e => {

                        $('._product-product').append(`
                            <td>
                                <a class="product" href="/gadgets/gadgets?item=${e.product_slug}">
                                    <div class="product-image">
                                        <div class="">
                                        <img width="250" style="height:100px;width:100%;object-fit:cover" alt="1" class="wp-post-image" src="${e.product_image}">
                                    </div>
                                    </div>
                                    <div class="product-info">
                                        <h3 class="product-title">${e.product_name}</h3>
                                    </div>
                                </a><!-- /.product -->
                            </td>
                        `)
                        $('._product-price').append(`
                            <td>
                                <div class="product-price price"><span class="electro-price"><span class="amount">${money.sign}${money.money(e.product_price.slice(1))}</span></span></div>
                            </td>
                        `)
                        $('._product-summary').append(`
                            <td>${e.product_description ? e.product_description : '__'}</td>
                        `)
                        $('._product-availability').append(`
                            <td><span class="in-stock ${e.in_stock == 1 ? 'text-success' : 'text-danger'}">${e.in_stock == 1 ? 'In stock' : 'Out of stock'}</span></td>
                        `)
                        $('._product-remove').append(`
                            <td class="text-center">
                                <a href="javascript:;" title="Remove" data-category="${search[3]}" id="${e.product_slug}" class="remove-icon"><i class="fa fa-times"></i></a>
                            </td>
                        `)
                    });

                    $('.compare-table').fadeIn()
                }


            }
        })
    }

    function getCompared() {
        fetch('/compare/compared/')
            .then(res => res.json()).then(data => {
                // console.log(data._recent.slice(0, data._recent.length - 1))
                let recent = data._recent.length > 3 ? data._recent.slice(0, data._recent.length - 1) : data._recent
                if (recent.length > 0) {
                    $('#recent-accessories').fadeIn()
                    recent.forEach(recentItem)
                    $('#recent_cat').val(data.recent)
                }

                let popular = data._popular.length > 3 ? data._popular.slice(0, data._popular.length - 1) : data._popular
                if (popular.length > 0) {
                    $('#popular-accessories').fadeIn()
                    popular.forEach(popularItem)
                    $('#popular_cat').val(data.popular)
                }
            })
    }

    function recentItem(e) {
        $('ul#recent-compare').append(`
        <li class="product ">
            <div class="product-outer" style="height: 298px;">
                <div class="product-inner">
                    <span class="loop-product-categories"><a href="javascript:;" rel="tag">${e.product_category}</a></span>
                    <a href="/${e.product_category}/${e.product_slug}">
                        <h3>${e.product_name}</h3>
                        <div class="product-thumbnail">
                        
                            <img style="max-width:100px" src="${e.product_image}" alt="">

                        </div>
                    </a>
                </div><!-- /.product-inner -->
            </div><!-- /.product-outer -->
        </li>
        `)
    }

    function popularItem(e) {
        $('ul#popular-compare').append(`
        <li class="product ">
            <div class="product-outer" style="height: 298px;">
                <div class="product-inner">
                    <span class="loop-product-categories"><a href="javascript:;" rel="tag">${e.product_category}</a></span>
                    <a href="/${e.product_category}/${e.product_slug}">
                        <h3>${e.product_name}</h3>
                        <div class="product-thumbnail">
                        
                            <img style="max-width:100px" src="${e.product_image}" alt="">

                        </div>
                    </a>
                </div><!-- /.product-inner -->
            </div><!-- /.product-outer -->
        </li>
        `)
    }

    $(document).on('click', '.remove-icon', function() {
        let slug = $(this).attr('id');
        let cat = $(this).data('category');
        $.ajax({
            url: '/site/compare/remove',
            method: 'POST',
            data: {
                slug,
                cat
            },
            success: function(e) {
                location.reload()
            },
            error: function() {
                location.reload()
            }
        })
    })
    $(document).on('change', '#product-compare-select', function() {
        let img = $(this).find(':selected').data('image')
        let id = $(this).find(':selected').data('id')
        $('img#' + id).attr('src', img)
        // console.log(img)
    })

    $(document).on('click', '.popular-btn', function() {
        let compare_category = $('#popular_cat').val()
        let type = $('#popular_type').val()
        runCompare({
            compare_category,
            type
        })
    })
    $(document).on('click', '.recent-btn', function() {
        let compare_category = $('#recent_cat').val()
        let type = $('#recent_type').val()
        runCompare({
            compare_category,
            type
        })
    })

    function runCompare(data) {
        $.ajax({
            url: '/compare/compared/',
            method: 'POST',
            data: data,
            success: function(e) {
                window.location = e
            }
        })
    }
</script>


 <!-- <h2 class="sr-only">Brands Carousel</h2>
            <div class="container">
                <div id="" class="row">
                    < ?php

                    use App\Models\Product;

                    foreach (Product::categories() as $category) :
                    ?>
                        <div class="col-md-2">
                            <a href="/compare/gadget/< ?= $category->category_slug ?>">
                                <figure>
                                    <img style="width:100px;height:100px;object-fit:cover" src="/Public/assets/images/blank.gif" data-echo="< ?= $category->category_image ?>" class="img-responsive" alt="">
                                    <h6>< ?= $category->category_name ?></h6>
                                </figure>
                            </a>
                        </div>
                    < ?php endforeach; ?>
                </div>

            </div> -->