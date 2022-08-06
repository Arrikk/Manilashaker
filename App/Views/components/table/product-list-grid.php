<?php

use App\Models\Product;

function __product_list_table()
{
?>
    <div class="card">
        <div class="card-header py-3">
            <div class="row g-3 align-items-center">
                <div class="col-lg-3 col-md-6 me-auto">
                    <div class="ms-auto position-relative">
                        <div class="position-absolute top-50 translate-middle-y search-icon px-3">
                            <i class="bi bi-search"></i>
                        </div>
                        <input class="form-control ps-5" id="product-search" type="text" placeholder="search produts" />
                    </div>
                </div>
                <div class="col-lg-2 col-6 col-md-3">
                    <!-- <select class="form-select" id="filter-category">
                        <option>All category</option>
                        < ?php foreach (Product::categories() as $key): ?>
                            <option value="< ?= $key->category_slug ?>" >< ?= $key->category_name ?></option>
                        < ?php endforeach; ?>
                    </select> -->
                </div>
                <div class="col-lg-2 col-6 col-md-3">
                    <!-- <select class="form-select"> -->
                        <!-- <option>Latest added</option>
                        <option>Cheap first</option>
                        <option>Most viewed</option> -->
                    <!-- </select> -->
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="product-grid">
                <div class="row row-cols-1 row-cols-lg-4 row-cols-xl-4 row-cols-xxl-5 g-3 product-list-grid">
                    <div class="spinner-border text-info loader-sm align-self-center"></div>
                </div>
                <!--end row-->
            </div>
            <nav class="float-end mt-4" aria-label="Page navigation">
                <ul class="pagination set-pagination">
                    <!-- <li class="page-item disabled">
                        <a class="page-link" href="#">Previous</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">Next</a></li> -->
                </ul>
            </nav>
        </div>
    </div>

<?php
}
