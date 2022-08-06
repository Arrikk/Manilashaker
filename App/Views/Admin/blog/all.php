<main class="page-content">
    <!-- < ?php __breadcrum_admin() ?> -->
    <?php __alerts() ?>
    <?php __post_table() ?>

    <script>
        let posts;
        let page = 1;
        let currentPage = $('a.c-p'),
            totalPage = $('a.t-p'),
            next = $('a.next'),
            back = $('a.prev');

        blogPosts()

        function changePage(page) {
            blogPosts(page)
        }

        function blogPosts(page) {
            fetch(location.pathname + '?post&page=' + page)
                .then(res => res.json())
                .then(data => {
                    posts = data.posts
                    $('tbody#all-post-table').html('')
                    if (posts.length > 0) {
                        totalPage.text(data.pages == 0 ? 1 : data.pages)
                        control(data.pages == 0 ? 1 : data.pages)
                        posts.forEach(postItem)
                    } else {

                        $('tbody#all-post-table').html('<tr><td colspan="9">Nothing Here</td></tr>')
                    }
                })
        }

        function postItem(e, i) {
            $('tbody#all-post-table').append(`
            <tr>
            <td><input type="checkbox" name="multiselect[]" id="_multiselect" data-id="${e.post_id}" /></td>
                <td>
                ${
                    location.pathname == window.url.trash_p ?
                    `<div class="d-flex align-items-center gap-3 fs-6">
                    <a href="${window.url.trash_p}?restore=${e.post_id}" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Restore" aria-label="Restore">restore</a>

                    <a href="javascript:;" class="text-danger post-delete" data-bs-toggle="tooltip" data-bs-placement="bottom" data-delete-post="${e.post_id}" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>
                    </div>` : `<div class="d-flex align-items-center gap-3 fs-6">
                    <a href="/news/${e.post_slug}" target="_blank" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views">view</a>
                    <a href="${window.url.new_p}?edit=${e.post_id}" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill"></i></a>
                    <a href="?trash=${e.post_id}" class="text-danger post-deletes" data-bs-toggle="tooltip" data-bs-placement="bottom" data-delete-post="${e.post_id}" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>
                    </div>`
                }
                    
                </td>
                <td style="max-width:400px">
                    ${e.post_title}
                </td>
                <td>${e.category ? e.category : '__'}</td>
                <td>${e.tag ? e.tag : '__'}</td>
                <td>
                    <div class="d-flex align-items-center gap-3">
                        <div class="product-box border">
                            <img src="${e.post_image}" alt="" style="object-fit:cover">
                        </div>
                    </div>
                </td>
                <td>${e.author ? e.author : '__'}</td>
                <td>
                <i class="bi bi-eye"></i>${e.views ?? 0}
                </td>
                <td>${e.date}</td>
                <td class="text-center"><i class="bi bi-chat-left-text"></i>${e.comments ?? 0}</td>
            </tr>
            `)

        }
        $(document).on('click', '.post-delete', function() {
            let id = $(this).data('delete-post')
            if (window.confirm('Are you sure you want to delete ?')) {
                posts = posts.filter(p => p.post_id != id)

                $('tbody#all-post-table').html('')
                posts.forEach(postItem)

                fetch('/admin/post/trash?delete=' + id).then(res => res.json()).then(data => {
                    // console.log(data)
                })
                location.reload()
            }
        })
        $(document).on('click', '#save-action', function() {
            let data = $('[name="multiselect[]"]:checked')
            let action = $('select#bulk_action').val()
            // let id = []
            data.each(e => {
                let dt = data[e]
                let id = $(dt).data('id')
                $.ajax({
                    url: '/admin/post/bulk',
                    method: 'POST',
                    data: {
                        id,
                        action
                    },
                    success: function(e) {
                        posts = posts.filter(p => p.post_id != id)
                        $('tbody#all-post-table').html('')
                        posts.forEach(postItem)
                    }
                })
            })
            // console.log(id)
        })


        $(next).on('click', function() {
            let page = +currentPage.text(),
                total = +totalPage.text(),
                jug = $(this).data('add')
                
            if (page > 0) jug == 1 ? page = page + 1 : page = page + 2
            if (page > total) page = total
            currentPage.text(page)
            changePage(page)
        })
        $(back).on('click', function() {
            let page = +currentPage.text(),
                rem = $(this).data('rem')
            rem && rem == 1 ? page = page - 1 : page = page - 2
            page < 1 ? page = 1 : page = page
            currentPage.text(page)
            changePage(page)
        })

        function control(total) {
            let page = +currentPage.text()
            if (page > 1) $(back).css({
                display: 'block'
            })
            if (total > 1) $(next).css({
                display: 'block'
            })
            if (total <= page) $(next).css({
                display: 'none'
            })
        }
        // Change Pages
    </script>
</main>