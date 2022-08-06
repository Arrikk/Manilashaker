<?php

use App\Models\Blog;

function __post_table()
{
  extract($GLOBALS['blog']['__post_top_count']);
?>
<style>
  .dd-none{
    display: none;
  }
</style>
  <div class="card radius-10">
    <div class="card-header py-3">
      <div class="row align-items-center m-0">
        <div class="col-md-6 col-12 me-auto mb-md-0 mb-3">
          <div>
            <strong>All<span class="text-dark">(<?= $__all ?? 0 ?>)</span></strong> |
            <a href="/admin/post/all">Published <span class="text-dark">(<?= $__published ?? 0 ?>)</span></a> |
            <a href="/admin/post/draft">Draft <span class="text-dark">(<?= $__draft ?? 0 ?>)</span></a> |
            <a href="/admin/post/trash">Trash <span class="text-dark">(<?= $__trash ?? 0 ?>)</span></a> |
          </div>
        </div>
        <div class="col-md-8 col-6">
        </div>
        <div class="col-md-2 col-6">
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsivee">
        <table class="table align-middle mb-0">
          <thead class="table-light">
            <tr>
              <td>
              </td>
              <th>Actions</th>
              <th>Title</th>
              <th>Category</th>
              <th>Tags</th>
              <th>Featured Image</th>
              <th>Author</th>
              <th>Views</th>
              <th>Date</th>
              <th>Comments</th>
            </tr>
          </thead>
          <tbody id="all-post-table">
            <tr>
              <td colspan="9">Please wait</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="card-header py-3">
      <div class="row align-items-center m-0">
        <div class="col-md-2 col-12 me-auto mb-md-0 mb-3">
          <select name="" id="bulk_action" class="form-select">
            <option value="">Bulk Action</option>
            <option value="<?= Blog::DRAFT ?>">Draft</option>
            <option value="<?= Blog::PUBLISHED ?>">Publish</option>
            <option value="<?= Blog::TRASH ?>">Trash</option>
            <option value="<?= Blog::DELETE ?>">Permanently Delete</option>
          </select>
        </div>
        <div class="col-md-2 col-6">
          <button id="save-action" class="btn btn-primary">save</button>
        </div>
        <div class="col-md-4 col-6">
          <div>
            <strong>All<span class="text-dark">(<?= $__all ?? 0 ?>)</span></strong> |
            <a href="/admin/post/all">Published <span class="text-dark">(<?= $__published ?? 0 ?>)</span></a> |
            <a href="/admin/post/draft">Draft <span class="text-dark">(<?= $__draft ?? 0 ?>)</span></a> |
            <a href="/admin/post/trash">Trash <span class="text-dark">(<?= $__trash ?? 0 ?>)</span></a> |
          </div>
        </div>
        <div class="col-md-4 col-6">
        <nav aria-label="Page navigation example text-right">
                      <ul class="pagination">
                        <li class="page-item">
                          <a class="page-link prev dd-none" href="javascript:;" aria-label="Previous" data-rem="2">	<span aria-hidden="true">«</span>
                          </a>
                        </li>
                        <li class="page-item">
                          <a class="page-link prev dd-none" href="javascript:;" aria-label="Previous" data-rem="1">	<span aria-hidden="true"><</span>
                          </a>
                        </li>
                        <li class="page-item"><a class="page-link c-p" href="javascript:;">1</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="javascript:;">of</a>
                        </li>
                        <li class="page-item"><a class="page-link t-p" href="javascript:;">1</a>
                        </li>
                        <li class="page-item">
                          <a class="page-link next dd-none" href="javascript:;" aria-label="Next" data-add="1">	<span aria-hidden="true">></span>
                          </a>
                        </li>
                        <li class="page-item">
                          <a class="page-link next dd-none" href="javascript:;" aria-label="Next" data-add="2">	<span aria-hidden="true" >»</span>
                          </a>
                        </li>
                      </ul>
                    </nav>
        </div>
      </div>
    </div>
  </div>
<?php
}
