<main class="page-content">
    <?php __alerts() ?>
    <?php __product_all_list() ?>
</main>

<script>
    let products
    let pagination = $('ul.set-pagination')
    let page = 1

    fetchProduct()
    function fetchProduct(){
        fetch('/admin/product/all?fetch&page='+page)
        .then(res => res.json())
        .then(data => {
            products = data.product
            element(data.avg)
            $('div.product-list-grid').html('')
            products.forEach(productItem)
        })
    }

    function productItem(e){
        let star = ''
        for (let i = 0; i < 5; i++) {
            if(i+1 > e.review.rating ){
                star += '<i class="bi bi-star text-warning"></i>'
            }else{
                star += '<i class="bi bi-star-fill text-warning"></i>'
            }
        }
        $('div.product-list-grid').append(`
            <div class="col">
                <div class="card border shadow-none mb-0">
                    <div class="card-body text-center">
                        <img src="${e.product_image}" class="img-fluid mb-3" alt="" style="height:150px;object-fit:cover" />
                        <h6 class="product-title">${e.product_name}</h6>
                        <p class="product-price fs-5 mb-1"><span>${money.sign}${money.money(e.product_price)}</span></p>
                        <div class="rating mb-0">
                            ${star}
                        </div>
                        <small>${e.review.comment.length} Reviews</small>
                        <div class="
                            actions
                            d-flex
                            align-items-center
                            justify-content-center
                            gap-2
                            mt-3"
                        >
                        <a href="/admin/product/new?edit=${e.product_slug}&product=${e.product_id}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil-fill"></i> Edit</a>
                        <a href="/shop/gadgets/${e.product_slug}" class="btn btn-sm btn-outline-warning"><i class="bi bi-eye-fill"></i> View</a>
                        <a href="/admin/product/delete?id=${e.product_id}" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash-fill"></i> Delete</a>
                    </div>
                </div>
            </div>
        `)
    }

    $('[class="btn btn-dark btn-block mb-3 mb-lg-0"]').on('click', function(){
        $(this).attr('disabled', 'disabled').text('Importing...')
        $('[class="btn btn-dark btn-block mb-3 mb-lg-0"]').attr('disabled', 'disabled')

        $.ajax({
            url: $(this).data('href'),
            timeout: 120000,
            success: function(e){
                location.reload()
            },
            error: function(e, t){
                if(t == 'timeout'){
                    alert('Import timeout');
                }else{
                    alert('Try again.')
                }
                location.reload()
            }
        })
    })

    $('[id="product-search"]').on('input', function(){
        let input = $(this).val()
        console.log(input)

        let filtered = products.filter(f => {
            let regex = new RegExp(input, 'i')
            return f.product_name.match(regex)
        })
        // console.log(filtered)
        if(filtered.length > 0){
            $('div.product-list-grid').html('')
            filtered.forEach(productItem)
        }
    })
    $('[id="filter-category"]').on('change', function(){
        let input = $(this).val()
        console.log(input)

        let filtered = products.filter(f => f.product_category == input)
        console.log(filtered)
        if(filtered.length > 0){
            $('div.product-list-grid').html('')
            filtered.forEach(productItem)
        }
    })

    function init(g){
        if(g =='next'){
            page = page + 1;
        }else if(g == 'prev'){
            page = page - 1
        }
        else{
            page = +g
            console.log(g);
        }
        fetchProduct()
    };
    function element(totalPage){
        console.log(page)
        let liTag = '';
        let beforePg = page - 4;
        if(beforePg < 1) beforePg = 1;
        let afterPg = page + 4;
        if(afterPg > totalPage) afterPg = totalPage;

        if(page > 1){
            liTag += `<li class="page-item previous"><a class="page-link" onclick="init('prev')" href="#">Prev</a></li>`;
        }
        if(page > 2){
            liTag += `<li onclick="init(${1})" class="page-item"><a class="page-link" href="#">1</a></li>`;
            if(page > 3){
                liTag += '<li class="page-item"><span class="page-link">...</span></li>';
            }
        }

        for (let pglength = beforePg; pglength <= afterPg; pglength++) {
            // if(pglength < 1) liTag += ''
            liTag += `<li onclick="init(${pglength})" class="page-item ${page == pglength ? 'active' : ''}"><a class="page-link" href="#">${pglength}</a></li>`
        }
        
        if(page < totalPage - 1){
            if(page < totalPage - 5){
                liTag += '<li class="page-item"><span class="page-link">...</span></li>';
            }
            liTag += `<li onclick="init(${totalPage})"  class="page-item"><a class="page-link" href="#">${totalPage}</a></li>`;
        }

        if(page < totalPage){
            liTag += `<li onclick="init('next')" class="page-item next"><a class="page-link" href="#">Next</a></li>`;
        }
        
        pagination.html(liTag)
    } 
</script>