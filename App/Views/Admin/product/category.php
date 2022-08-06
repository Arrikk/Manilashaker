<main class="page-content">
    <?php __alerts() ?>
    <?php __product_category_new() ?>
</main>
<script>
    $(document).on('submit', '#alter-form', function(e) {
        e.preventDefault();
        let data = $(this).serialize()

        $.ajax({
            url: '/admin/product/multiple',
            method: 'POST',
            data: data,
            success: function(){
                location.reload()
            }
        })
    })
    let productCategory
    // getProductCategory()
    function getProductCategory(){
        fetch('/admin/product/categories?fetch')
        .then(res => res.json())
        .then(data => {
            productCategory = data;
            productCategory.forEach(categoryItem)
        })
    }
    function categoryItem(e){
        $('[id="product-category-table"]').append(`
            
        <tr>
            <td><input class="form-check-input" type="checkbox"></td>
            <td>#${e.category_id}</td>
            <td>${e.category_name}</td>
            <td class="text-center">${e.category_desc ? e.category_desc : '__'}</td>
            <td>${e.category_slug}</td></td>
            <td>
            <div class="d-flex align-items-center gap-3 fs-6">
                <a href="/shop/product?category=${e.category_slug}" target="_blank" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
                <!-- <a href="" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill"></i></a> -->
                <a href="/admin/product/categories?slug=${e.category_slug}&id=${e.category_id}" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>
            </div>
            </td>
        </tr>
        `)
    }

</script>