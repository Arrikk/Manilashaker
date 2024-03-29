<main class="page-content">
    <!-- < ?php __breadcrum_admin() ?> -->
    <?php __alerts() ?>
    <?php __post_table() ?>

    <script>
        let posts;
        blogPosts()

        function blogPosts() {
            fetch(location.pathname+'?post')
                .then(res => res.json())
                .then(data => {
                    posts = data
                    $('tbody#all-post-table').html('')
                    if(posts.length > 0){
                        
                        posts.forEach(postItem)
                    }else{
                        
                        $('tbody#all-post-table').html('<tr><td colspan="9">Nothing Here</td></tr>')
                    }
                })
        }

        function postItem(e, i) {
            $('tbody#all-post-table').append(`
            <tr>
                <td>
                    <div class="d-flex align-items-center gap-3 fs-6">
                    <a href="#" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
                    <a href="/admin/post/new?edit=${e.post_id}" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill"></i></a>
                    <a href="?trash=${e.post_id}" class="text-danger post-deletes" data-bs-toggle="tooltip" data-bs-placement="bottom" data-delete-post="${e.post_id}" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>
                    </div>
                </td>
                <td width="10px">
                    ${e.post_title}
                </td>
                <td>${e.category ? e.category : '__'}</td>
                <td>${e.slug ? e.slug : '__'}</td>
                <td>
                    <div class="d-flex align-items-center gap-3">
                        <div class="product-box border">
                            <img src="${e.post_image}" alt="" style="object-fit:cover">
                        </div>
                    </div>
                </td>
                <td>Author</td>
                <td>
                <i class="bi bi-eye"></i>${e.views ?? 0}
                </td>
                <td>${e.date}</td>
                <td class="text-center"><i class="bi bi-chat-left-text"></i>${e.comments ?? 0}</td>
            </tr>
            `)
            $('.post-delete').on('click', function() {
                let id = $(this).data('delete-post')
                // if(window.confirm('Are you sure you want to delete ?')){
                posts = posts.filter(p => p.post_id != id)

                $('tbody#all-post-table').html('')
                posts.forEach(postItem)

                fetch('/admin/post/all?del=' + id).then(res => res.json()).then(data => {
                    console.log(data)
                })
                // }
            })
        }
    </script>
</main>