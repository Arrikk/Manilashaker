<?php
function __tag_table()
{
    
    $tags =\App\Models\Blog::tags();
?>
    <div class="col-lg-8">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#ID</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="all-post-table">
                    <?php if (count($tags) > 0) : ?>
                        <?php foreach ($tags as $tag) : ?>
                            <tr>
                                <td>#<?= $tag->tag_id ?? '' ?></td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="product-info">
                                            <h6 class="product-name mb-1"><?= $tag->name ?? '' ?></h6>
                                        </div>
                                    </div>
                                </td>
                                <td> <?= '/' . $tag->slug ?? '__' ?></td>
                                <td><?= $tag->createdAt ?? '' ?></td>
                                <td class="text-left">
                                    <!-- <div class="d-flex align-items-center"> -->
                                    <a href="/admin/post/tag?edit=<?= $tag->slug ?>" class="text-warning edit-category" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-edit-cat="<?= $tag->slug ?>" data-bs-original-title="Edit" aria-label="Edit">Edit</a>

                                    <a href="/admin/post/tag?trash=<?= $tag->slug ?>" class="text-danger detele-category" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-delete-cat="<?= $tag->slug ?>" data-bs-original-title="Delete" aria-label="Delete">Delete</a>
                                    <!-- </div> -->
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">No Category was found</td>
                        </tr>
                    <?php endif; ?>

                </tbody>
            </table>
        </div>
    </div>
<?php
}
