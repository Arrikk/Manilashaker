<?php
function __product_add_script()
{
?>

    <script>
        let newGroup = (item, id = '') => {
            $(item).after(`
                <div class="row col-12 mt-4 append-group${id}" id="group-${id}">
                    <input class="form-control form-title" placeholder="Title" type="text" value="" name="" />
                    <a href="javascript:;" class="openGroupModal"><i class="bi bi-arrow-up-right-square"></i></a>
                    <div class="row col-12 col-lg-9 mt-3">
                        <div class="col-12 col-lg-3 mt-3">
                            <a class="btn btn-primary add-group">+Group</a>
                        </div>
                        <div class="col-12 col-lg-3 mt-3">
                            <a class="btn btn-warning add-item" id="btn-${id}">+item</a>
                        </div>
                        <div class="col-12 col-lg-3 mt-3">
                            <a class="btn btn-danger remove-item" id="${id}">xGroup</a>
                        </div>
                    </div>
                </div>
            `)
        }

        let newItem = (item, id) => {
            $(item).before(`
                <div class="col-12 col-lg-4 mt-3">
                    <input id="key-${id}" class="mb-2 form-control form-key-title" placeholder="key" type="text" value="" name="" />
                    <a href="javascript:;" class="openKeyModal"><i class="bi bi-arrow-up-right-square"></i></a>
                    <input class="form-control form-val-title" placeholder="value" type="text" value="" name="" />
                </div>
            `)
        }

        let count = 0;

        $(document).on('click', '.add-group', function() {
            let parent = $(this).parent().parent()
            count = count + 1
            newGroup(parent, count)
        })
        $(document).on('click', '.add-item', function() {
            let parent = $(this).parent().parent()
            count = count + 1
            newItem(parent, count)
        })
        $(document).on('input', '.form-title', function() {
            let name = $(this).val()
            name = name.replace(/\s+/g, '_').toLowerCase()
            $(this).attr('name', `product_specification[${name}][]`)
            let children = $(this).parent().find('input:not(.form-title)')

            children.each((i, child) => {
                let newName = $(child).attr('name').replace(/^(.*)\[(.*)\]/, `[$2]`)
                $(child).attr('name', `product_specification[${name}]${newName}`)
            })
        })

        $(document).on('input', '.form-key-title', function() {
            let name = $(this).val().toLowerCase()
            let parentName = $(this).parent()
                .parent().parent()
                .find('.form-title').attr('name').slice(0, -2)
            $(this).attr('name', `${parentName}[${name}]`)

            let child = $(this).parent().find('input.form-val-title')
            console.log(child)
            $(child).attr('name', `${parentName}[${name}]val`)
        })

        $(document).on('input', '.form-val-title', function() {
            // let name = $(this).val()
            let parentName = $(this).parent()
                .find('.form-key-title').attr('name')
            $(this).attr('name', `${parentName}val`)
        })

        $(document).on('click', '.remove-item', function() {
            let id = $(this).attr('id')
            $('#group-' + id).remove()
        })

        function formatName(name) {
            return name.replace(/\s+/g, '_').toLowerCase()
        }

        let theirParent;

        $(document).on('click', '.openGroupModal', function() {
            $('#groupModal').modal('show')
            theirParent = $(this).parent()
        })
        $(document).on('click', '.openKeyModal', function() {
            $('#keyModal').modal('show')
            theirParent = $(this).parent()
        })

        $('#groupTitleSelect').on('change', function() {
            let keyTitle = $('#keyTitleModal')
            let item = $(this).val()
            let cat = $('#__product_category').val()

            let form = $(theirParent).find('input.form-title')
            $('#groupModal').modal('hide')

            form.val(item)
            let name = item.replace(/\s+/g, '_').toLowerCase()
            $(form).attr('name', `product_specification[${name}][]`)
            let children = $(form).parent().find('input:not(.form-title)')

            children.each((i, child) => {
                let newName = $(child).attr('name').replace(/^(.*)\[(.*)\]/, `[$2]`)
                $(child).attr('name', `product_specification[${name}]${newName}`)
            })

            fetch(`/admin/setval/key?category=${cat}&group=${item}`)
                .then(res => res.json())
                .then(data => {
                    keyTitle.html('')
                    data.forEach(title => {
                       title == 0 ? keyTitle.append(`<option value="">Select</option>`): keyTitle.append(`<option value="${title}" id="${title}">${title}</option>`)
                    });
                    console.log(data, keyTitle)
                })
        })

        $('#keyTitleModal').on('change', function() {
            let name = $(this).val()

            let form = $(theirParent).find('input.form-key-title')
            $('#keyModal').modal('hide')

            form.val(name)

            let parentName = $(theirParent)
                .parent().parent()
                .find('.form-title').attr('name').slice(0, -2)
            $(form).attr('name', `${parentName}[${name}]`)


            let child = $(form).parent().find('input.form-val-title')
            $(child).attr('name', `${parentName}[${name}]val`)
        })
    </script>

<?php
}
