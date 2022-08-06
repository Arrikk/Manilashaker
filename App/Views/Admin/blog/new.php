<main class="page-content">
    <?php
        if($__is_edit){
            $GLOBALS['post_edit'] = \App\Models\Blog::singleBlogPost($__is_edit);
        }
    ?>
    <!-- < ?php __breadcrum_admin() ?> -->
    <form id="__post_form" method="POST">
        <?php __alerts() ?>
        <?php __new_post() ?>
    </form>
</main>

<script>
    let interval = 10000
    // autoSave()
    function autoSave(){
        setInterval(() => {
            let btn = $('#__new_post')
            let editId = $('#__edit_id')
            let type = $('#hidden_type')
            console.log(editId.val() +' : ' +type.val())
            let form = $('form#__post_form')
            btn.attr('disabled', 'disabled').html('Auto saving <div class="spinner-border text-white loader-sm align-self-center"></div>')
            $.ajax({
                url: '/admin/post/auto',
                method: 'POST',
                data: form.serialize(),
                success: function(e){
                    if(editId.val() == 'draft'){
                        editId.val(e.editId)
                    }
                    btn.attr('disabled', false).text('save')
                    // status.val(e.status)
                    if(type.val() == 'save'){
                        type.val(e.type)
                    }
                }
            })
        }, interval);

    }

    $(document).on('input', '.__permalink_edit', function(){
        let text = $(this).val()
        text = text.replace(/\s+/g, '-')
        $('.__permalink_view').text(text)
    })

    $(document).on("click", '._add_category_toggle', function(){
        $(this).html('<u>-Remove new category</u>')
        $(this).removeClass('_add_category_toggle').addClass('_remove_category_toggle')
        $(this).parent().after('<span class="category_new_toggle"><input type="text" name="__new_category" placeholder="Category" class="form-control"><br></span>')
    })
    $(document).on("click", '._remove_category_toggle', function(){
        $(this).html('<u>+Add new category</u>')
        $(this).removeClass('_remove_category_toggle').addClass('_add_category_toggle')
        $('[class="category_new_toggle"]').remove()
    })
    
</script>