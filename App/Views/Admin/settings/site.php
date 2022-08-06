<?php

use App\Model\ProductCategory;
use App\Models\Blog;

$cat = Blog::categories();
$pcat = ProductCategory::categories();
?>
<main class="page-content">

    <div class="row">
        <form action="" method="post" class="site-settings">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <div class="ms-auto">
                                <button type="submit" id="save-site" class="btn btn-primary save-site">Save</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-3 mx-auto">

                                <div class="col-12 col-lg-6">
                                    <div class="card shadow-none bg-light border">
                                        <div class="card-body">
                                            <div class="row g-3 ">
                                                <div class="col-12">
                                                    <label class="form-label" for="">Quick Link</label>
                                                    <select name="category" id="" class="form-control">
                                                        <?php foreach ($cat as $cat) : ?>
                                                            <option value="<?= $cat->category_id ?>"><?= $cat->category_name ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label" for="">Limit Post</label>
                                                    <select name="limit" class="form-control" id="">
                                                        <option value="5">5</option>
                                                        <option value="10">10</option>
                                                        <option value="15">15</option>
                                                        <option value="20">20</option>
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="row g-3 ">
                                                <div class="col-12">
                                                    <label class="form-label" for="">Ads (728×90)</label>
                                                    <textarea name="rlg" id="" placeholder="728×90" cols="30" rows="10" class="form-control"></textarea>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label" for="">Ads (468×60)</label>
                                                    <textarea name="rsm" id="" placeholder="468×60" class="form-control" cols="30" rows="10"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="card shadow-none bg-light border">
                                        <div class="card-body">
                                            <div class="row g-3 ">
                                                <div class="col-12">
                                                    <label class="form-label" for="">Gadgets widget</label>
                                                    <select name="gadgetSide" id="" class="form-control">
                                                        <?php foreach ($pcat as $cat) : ?>
                                                            <option value="<?= $cat->category_slug ?>"><?= $cat->category_name ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label" for="">Footer Gadget</label>
                                                    <select name="gadgetFoot" id="" class="form-control">
                                                        <?php foreach ($pcat as $cat) : ?>
                                                            <option value="<?= $cat->category_slug ?>"><?= $cat->category_name ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label" for="">Ads (300x250)</label>
                                                    <textarea name="ss" id="" placeholder="300x250" class="form-control" cols="30" rows="10"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!--end row-->
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--end row-->
</main>