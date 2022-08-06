<main class="page-content">
    <?php __alerts();
    __group_modal();
    __key_modal();
    ?>
    <form method="post" id="<?= isset($__is_edit) ? 'edit-product' : 'save-product' ?>">
        <input type="hidden" name="action_type" value="<?= isset($__is_edit) ? 'editing' : 'save' ?>">
        <input type="hidden" name="product_update" value="<?= isset($__product) ? $__product->product_id : '' ?>">
        <?php __product_add_new($__product ?? null, $__is_edit ?? false) ?>
    </form>
</main>

<script>
    let groupTitle = $('#groupTitleSelect')
    let childCat = $('#__product_category_child')
    // let keyTitle = $('#keyModal')

    $(document).on('submit', 'form#edit-form', function(e) {
        e.preventDefault();
        $(this).find('button').attr('disabled', 'disabled').text('Please Wait')
    })

    $(document).on('change', '#__product_category', function() {
        let value = $(this).val();
        fetch('/admin/setval/title?category=' + value)
            .then(res => res.json())
            .then(data => {
                groupTitle.html('<option value="">Select</option>')
                childCat.html('<option value="">Select</option>')

                data.group.forEach(title => {
                    groupTitle.append(`<option value="${title}" id="${title}">${title}</option>`)
                });

                data.child.forEach(child => {
                    childCat.append(`<option value="${child.category_slug.toLowerCase()}" id="${child.category_id}">${child.category_name}</option>`)
                });

                console.log(data, groupTitle)
            })
        // console.log($(this).val())
    })

    // $(document).on('change', '#groupTitleSelect', function() {
    //     let group = $(this).val();
    //     let cat = $('#__product_category')
    //     fetch(`/admin/setval/key?category=${cat}&group=${group}`)
    //         .then(res => res.json())
    //         .then(data => {
    //             keyTitle.html('')
    //             data.forEach(title => {
    //                 keyTitle.append(`<option name="${title.toLowerCase()}" id="${title}">${title}</option>`)
    //             });
    //             console.log(data, keyTitle)
    //         })
    //     // console.log($(this).val())
    // })
</script>
<script src="/Public/sc.js"></script>