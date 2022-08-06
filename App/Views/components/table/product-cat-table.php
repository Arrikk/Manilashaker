<?php

use App\Models\Product;

function __product_category_table()
{
?>
  <div class="col-12 col-lg-8 d-flex">
    <div class="card border shadow-none w-100">
      <div class="card-body">
        <form action="" method="POST" id="alter-form">
        <div class="table-responsive" style="
    height: 500px;
    overflow-y: scroll;
">
          <table class="table align-middle">
            <thead class="table-light">
              <tr>
                <th><input class="form-check-input" type="checkbox"></th>
                <th>Name</th>
                <th>Parent</th>
                <th class="text-center">Description</th>
                <th>Slug</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="product-category-table">
              <?php $categories = Product::productCategory();
              if (count($categories) > 0) : ?>
                <?php foreach ($categories as $cat) : ?>
                  <tr>
                    <td><input class="form-check-input" id="multiselect" name="multiselect[]" value="<?= $cat->category_id ?>" type="checkbox"></td>
                    <td><?= $cat->category_name ?? '__' ?></td>
                    <td class="text-center"><?= Product::categories($cat->category_parent, 'category_name') ?></td>
                    <td class="text-center"><?php if(isset($cat->category_desc) && $cat->category_desc  !== '') echo $cat->category_desc; else echo '__'; ?></td>
                    <td>/<?= $cat->category_slug ?? '__' ?></td>
                    <td>
                      <div class="d-flex align-items-center gap-3 fs-6">
                        <a href="/shop/product/<?= $cat->category_slug ?>" target="_blank" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
                        <a href="/admin/product/categories?edit=<?= $cat->category_id ?>" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill"></i></a>
                        <!-- <a href="/admin/product/categories?slug=<?= $cat->category_slug ?>&id=<?= $cat->category_id ?>" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a> -->
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
                <?php else: ?>
                  <td colspan="5">No category was found</td>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
        <!-- <nav class="float-end mt-0" aria-label="Page navigation">
          <ul class="pagination">
            <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">Next</a></li>
          </ul>
        </nav> -->
        <div class="row col-8">
          <div class="col-5">
            <select name="parentCategory" class="form-control" id="">
              <option value="">Select</option>
              <?php
                foreach (Product::categories()  as $key):
                  echo '<option value="'.$key->category_id.'">'.$key->category_name.'</option>';
                endforeach;
              ?>
            </select>
          </div>
          <div class="col-3">

            <button class="btn btn-primary" id="move-items">Move</button>
          </div>
        </div>
      </form>
      </div>
    </div>
  </div>
<?php
}
function __product_description_table()
{
?>
  <div class="col-12 col-lg-4 d-flex">
    <div class="card border shadow-none w-100">
      <div class="card-body">
        <form action="" method="POST" id="alter-form">
        <div class="table-responsive" style="
    height: 500px;
    overflow-y: scroll;
">
          <table class="table align-middle">
            <thead class="table-light">
              <tr>
                <th><input class="form-check-input" type="checkbox"></th>
                <th>Name</th>
                <th>Slug</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="product-category-table">
              <?php $categories = Product::categories();
              if (count($categories) > 0) : ?>
                <?php foreach ($categories as $cat) : ?>
                  <tr>
                    <td><input class="form-check-input" id="multiselect" name="multiselect[]" value="<?= $cat->category_id ?>" type="checkbox"></td>
                    <td><?= $cat->category_name ?? '__' ?></td>

                    <td>/<?= $cat->category_slug ?? '__' ?></td>

                    <td>
                      <div class="d-flex align-items-center gap-3 fs-6">
                        <a href="/admin/compare/description?edit=<?= $cat->category_id ?>" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill"></i>
                      </a>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
                <?php else: ?>
                  <td colspan="5">No category was found</td>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
        <!-- <nav class="float-end mt-0" aria-label="Page navigation">
          <ul class="pagination">
            <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">Next</a></li>
          </ul>
        </nav> -->
      </form>
      </div>
    </div>
  </div>
<?php
}
