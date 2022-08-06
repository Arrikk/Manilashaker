<?php
function __category_table()
{
    $categories = $GLOBALS['blog']['__blog_category'];
?>
    <div class="col-lg-8">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Slug</th>
                        <th>Date</th>
                        <th>Author</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="all-post-table">
                    <?php if (count($categories) > 0) : ?>
                        <?php foreach ($categories as $cat) : ?>
                            <tr>
                                <td>#<?= $cat->category_id ?? '' ?></td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="product-info">
                                            <h6 class="product-name mb-1"><?= $cat->category_name ?? '' ?></h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center"><?= $cat->category_description == '' ? '__' : $cat->category_description ?? '__' ?></td>
                                <td> <?= '/' . $cat->slug ?? '__' ?></td>
                                <td><?= $cat->createdAt ?? '' ?></td>
                                <td>Admin</td>
                                <td class="text-center ">
                                    <!-- <div class="d-flex align-items-center"> -->
                                    <a href="/admin/post/categories?edit=<?= $cat->category_id ?>" class="text-warning edit-category" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-edit-cat="<?= $cat->category_id ?>" data-bs-original-title="Delete" aria-label="Edit"><i class="bi bi-pencil-fill"></i></a>
                                    <a href="/admin/post/categories?trash=<?= $cat->category_id ?>" class="text-danger detele-category" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-delete-cat="<?= $cat->category_id ?>" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>
                                    <!-- </div> -->
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="7">No Category was found</td>
                        </tr>
                    <?php endif; ?>

                </tbody>
            </table>
        </div>
        <div class="mt-2">
            <nav aria-label="Page navigation example text-right">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link prev dd-none" href="javascript:;" aria-label="Previous" data-rem="2"> <span aria-hidden="true">«</span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link prev dd-none" href="javascript:;" aria-label="Previous" data-rem="1"> <span aria-hidden="true">
                        < </a>
                    </li>
                    <li class="page-item"><a class="page-link c-p" href="javascript:;">1</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="javascript:;">of</a>
                    </li> 
                    <li class="page-item"><a class="page-link t-p" href="javascript:;">1</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link next dd-none" href="javascript:;" aria-label="Next" data-add="1"> <span aria-hidden="true">></span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link next dd-none" href="javascript:;" aria-label="Next" data-add="2"> <span aria-hidden="true">»</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
<?php
}
