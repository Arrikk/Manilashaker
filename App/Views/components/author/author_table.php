<?php

use App\Models\Admin;

function __author_members_table()
{
?>
    <div class="col-12 col-lg-8 d-flex">
        <div class="card border shadow-none w-100">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th><input class="form-check-input" type="checkbox"></th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th class="text-center">Description</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="product-category-table">
                            
                            <?php $authors = Admin::authors();
                            if (count($authors) > 0) : ?>
                                <?php foreach ($authors as $author) : ?>
                                    <tr <?= $author->type == Admin::DEFAULT ? 'style="background:#ededed"' : '' ?>>
                                        <td><input class="form-check-input" checked disabled type="checkbox"></td>
                                        <td><?= $author->firstName ?? '__' ?></td>
                                        <td><?= $author->email ?></td>
                                        <td>
                                            <?php 
                                                switch ($author->type) {
                                                    case Admin::DEFAULT:
                                                        echo 'Default';
                                                        break;
                                                    case Admin::MASTER:
                                                        echo 'Master';
                                                        break;
                                                    case Admin::WRITER:
                                                        echo 'Writer';
                                                        break;
                                                    default:
                                                }
                                            ?>
                                        </td>
                                        <td><?php if ($author->profile == '') echo html_entity_decode($author->profile);
                                            else echo '__'; ?></td>
                                            <td><?= date('d M Y', strtotime($author->createdAt)) ?></td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center gap-3 fs-6">
                                                <?php if ($author->type == Admin::DEFAULT) : ?>
                                                    <a href="/author/post/<?= $author->username ?>/posts" target="_blank" class="text-success" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
                                                <?php else : ?>
                                                    <a href="/author/post/<?= $author->username ?>" target="_blank" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
                                                    <a href="/admin/members/<?= $author->user_id ?>/author" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill"></i></a>
                                                    <a href="/admin/members/author?d=<?= $author->user_id ?>" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <td colspan="5">No Author was found</td>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <nav class="float-end mt-0" aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
<?php
}
