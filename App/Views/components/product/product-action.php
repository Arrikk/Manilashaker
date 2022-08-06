<?php
function __product_button_actions()
{
?>
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-lg-3 col-xl-2">
                    <a href="/admin/product/new" class="btn btn-primary mb-3 mb-lg-0"><i class="bi bi-plus-square-fill"></i>Add Product</a>
                </div>
                <div class="col-lg-9 col-xl-10">
                    <form class="float-lg-end">
                        <div class="row row-cols-lg-auto g-2">
                            <div class="col-12">
                                <!-- <a href="javascript:;" data-bs-toggle="modal" data-bs-toggle="modal" data-bs-target="#exampleSmallModal" class="btn btn-light mb-3 mb-lg-0"><i class="bi bi-download"></i>Import</a> -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleSmallModal" tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Gadget Importer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                    <div class="row row-cols-1 row-cols-lg-4 row-cols-xl-4 row-cols-xxl-5 g-3">
                        <div class="col-6">
                            <a href="javascript:;" data-href="/import/phones" class="btn btn-dark btn-block mb-3 mb-lg-0"><i class="bi bi-download"></i>Phones</a>
                        </div>
                        <div class="col-md-12">
                            <a href="javascript:;" data-href="/import/television" class="btn btn-dark btn-block mb-3 mb-lg-0"><i class="bi bi-download"></i>Television</a>
                        </div>
                        <div class="col-12">
                            <a href="javascript:;" data-href="/import/tablet" class="btn btn-dark btn-block mb-3 mb-lg-0"><i class="bi bi-download"></i>Tablets</a>
                        </div>
                        <div class="col-12">
                            <a href="javascript:;" data-href="/import/laptop" class="btn btn-dark btn-block mb-3 mb-lg-0"><i class="bi bi-download"></i>Laptops</a>
                        </div>
                        <div class="col-12">
                            <a href="javascript:;" data-href="/import/washingmachine" class="btn btn-dark btn-block mb-3 mb-lg-0"><i class="bi bi-download"></i>Washing machine</a>
                        </div>
                        <div class="col-12">
                            <a href="javascript:;" data-href="/import/fitnessband" class="btn btn-dark btn-block mb-3 mb-lg-0"><i class="bi bi-download"></i>Fitness Band</a>
                        </div>
                        <div class="col-12">
                            <a href="javascript:;" data-href="/import/aitcondition" class="btn btn-dark btn-block mb-3 mb-lg-0"><i class="bi bi-download"></i>Air Condition</a>
                        </div>
                        <div class="col-12">
                            <a href="javascript:;" data-href="/import/smartwatch" class="btn btn-dark btn-block mb-3 mb-lg-0"><i class="bi bi-download"></i>Smart watch</a>
                        </div>
                        <div class="col-12">
                            <a href="javascript:;" data-href="/import/powerbank" class="btn btn-dark btn-block mb-3 mb-lg-0"><i class="bi bi-download"></i>Power Bank</a>
                        </div>
                        <div class="col-12">
                            <a href="javascript:;" data-href="/import/refrigerator" class="btn btn-dark btn-block mb-3 mb-lg-0"><i class="bi bi-download"></i>Refrigerator</a>
                        </div>
                        <div class="col-12">
                            <a href="javascript:;" data-href="/import/camera" class="btn btn-dark btn-block mb-3 mb-lg-0"><i class="bi bi-download"></i>Cameras</a>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
<?php
}
