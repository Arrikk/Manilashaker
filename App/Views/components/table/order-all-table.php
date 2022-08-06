<?php

use App\Models\Product;

function __order_all_table($order = [])
{
    // var_dump($order);
    // 0 = Received
    // 1 =
    // 2 = 
?>

    <div class="col-12 col-lg-9 d-flex">
        <div class="card w-100">
            <div class="card-header py-3">
                <div class="row g-3">
                    <div class="col-lg-4 col-md-6 me-auto">
                        <div class="ms-auto position-relative">
                            <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-search"></i></div>
                            <input class="form-control ps-5" type="text" placeholder="search produts">
                        </div>
                    </div>
                    <div class="col-lg-2 col-6 col-md-3">
                        <select class="form-select">
                            <option>Status</option>
                            <option>Active</option>
                            <option>Disabled</option>
                            <option>Pending</option>
                            <option>Show All</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-6 col-md-3">
                        <select class="form-select">
                            <option>Show 10</option>
                            <option>Show 30</option>
                            <option>Show 50</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Customer name</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($order) > 0) :?>
                                <?php foreach($order as $order): ?>
                                    <?php $status = Product::orderStatus($order->id);  ?>
                                    <tr>
                                        <td>#<?= $order->id ?></td>
                                        <td><?= $order->lname ?? '__' ?> <?= $order->fname ?? '__' ?></td>
                                        <td>$<?= number_format($order->total, 2) ?? 0 ?></td>
                                        <td>
                                            <span class="badge rounded-pill alert-<?php
                                                switch ($status) {
                                                    case 'Delivered':
                                                        echo 'success';
                                                        break;
                                                    case 'Not Paid':
                                                        echo 'warning';
                                                        break;
                                                    case 'Shippped':
                                                        echo 'primary';
                                                        break;
                                                    default:
                                                        echo 'danger';
                                                }
                                                ?>">
                                                <?= $status; ?>
                                            </span>
                                        </td>
                                        <td><?= date('Y-M-D h:i:s a', strtotime($order->date)) ?></td>
                                        <td>
                                            <div class="d-flex align-items-center gap-3 fs-6">
                                                <a href="/admin/product/orders?details=<?= $order->id ?? '' ?>" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="View detail" aria-label="Views"><i class="bi bi-eye-fill"></i></a>
                                                <!-- <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill"></i></a> -->
                                                <a href="javascript:;" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                            <?php endif;?>
                        </tbody>
                    </table>
                </div>
                <nav class="float-end" aria-label="Page navigation">
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
