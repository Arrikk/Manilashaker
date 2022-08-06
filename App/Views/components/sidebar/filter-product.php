<?php
function __sidebar_filter_product()
{
    extract($GLOBALS['products']);
?>
    <style>
        .widget.woocommerce>ul::-webkit-scrollbar {
            width: 5px;
            background-color: #ddd;
        }

        .widget.woocommerce>ul::-webkit-scrollbar-thumb {
            background: #bbb;
        }

        .widget.woocommerce>ul::-webkit-scrollbar-button {
            background: #ddd;
        }

        .filter-brand {
            margin: 10px;
            display: inline-block;
        }

        .widget.woocommerce>ul {
            max-height: 300px !important;
            overflow: hidden;
            overflow-y: scroll;
        }
    </style>
    <aside class="widget widget_electro_products_filter">
        <h3 class="widget-title">Filters</h3>
        <aside class="widget woocommerce widget_layered_nav" ;">
            <h3 class="widget-title">Brands</h3>
            <ul>
                <?php foreach ($__category_f as $cat) : ?>
                    <li>
                        <input data-category="<?= $cat->category_slug ?>" <?php if ($cat->category_slug == $__slug_f) echo 'checked' ?> type="checkbox" name="" id="filter_brand">
                        <span class="filter-brand" data-target="<?= $cat->category_slug ?>">
                            <?php
                            // if($__slug_f) echo explode(' ', $cat->category_name)[0] .' '. ucfirst($__slug_f);
                            echo $cat->category_name;
                            ?>
                        </span><span class="count"></span>
                    </li>
                <?php endforeach; ?>
            </ul>
            <!-- <p class="maxlist-more"><a href="#">more</a></p> -->
        </aside>

        <?php foreach ($__filter_list as $key => $value) : ?>
            <aside class="widget woocommerce widget_layered_nav">
                <?php $keyID =  ucfirst(str_replace('_', ' ', $key)) ?>
                <!-- < ?php $value = array_values($value) ?> -->
                <?php $filters = ['ram', 'battery', 'display'] ?>
                <h3 class="widget-title"><?= $keyID ?></h3>
                <ul>
                    <?php if (in_array(strtolower($keyID), $filters)) : $items = $__filter_ranges[strtolower($keyID)]  ?>
                        <!-- < ?php rsort($value); -->
                        <!-- echo json_encode($value) ?> -->
                        <?php foreach ($items[0] as $item) : ?>
                            <li>
                                <?php
                                $checked = '';
                                if (isset($_GET['from']) && isset($_GET['to'])) {
                                    if ($_GET['from'] == $item['l'] && $_GET['to'] == $item['r']) {
                                        $checked = 'checked';
                                    }
                                }
                                ?>
                                <a href="?key=<?= $key ?>&from=<?= $item['l'] . '_' . $items[1] ?>&to=<?= $item['r'] . '_' . $items[1] ?>">
                                    <span class="filter-brand" data-target="">
                                        <?= $item['l'] .' - ' . $item['r'] . ' ' . $items[1] ?>
                                    </span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <?php rsort($value);
                        foreach ($value as $item) : ?>
                            <li>
                                <a href="?key=<?= $key ?>&value=<?= str_replace(' ', '_', $item) ?>">
                                    <span class="filter-brand" data-target="">
                                        <?= $item ?>
                                    </span><span class="count"></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            </aside>
        <?php endforeach; ?>


        <aside class="widget woocommerce widget_layered_nav">
            <h3 class="widget-title">Price Range</h3>
            <ul>

                <?php foreach ($__prices_f as $price) : ?>
                    <li>
                        <?php
                        $checked = '';
                        if (isset($_GET['from']) && isset($_GET['to'])) {
                            if ($_GET['from'] == $price['l'] && $_GET['to'] == $price['r']) {
                                $checked = 'checked';
                            }
                        }
                        ?>
                        <input <?= $checked ?> type="checkbox" name="" id="price_range" data-left="<?= $price['l'] ?>" data-right="<?= $price['r'] ?>">
                        <span class="filter-brand" data-target="<?= '' ?>">
                            <?= SIGN . number_format($price['l'], 2) . ' - ' . SIGN . number_format($price['r'], 2) ?>
                        </span><span class="count"></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </aside>
        <aside class="widget woocommerce widget_layered_nav">
            <h3 class="widget-title">In stock</h3>
            <ul>
                <li><a href="javascript:;" class="filter-brand" data-target="1">Yes</a></li>
                <li><a href="javascript:;" class="filter-brand" data-target="0">No</a></li>
            </ul>
        </aside>
        <aside class="widget woocommerce widget_layered_nav">
            <h3 class="widget-title">Featured</h3>
            <ul>
                <li><a href="javascript:;" class="filter-brand" data-target="on">Yes</a></li>
                <li><a href="javascript:;" class="filter-brand" data-target="off">No</a></li>
            </ul>
        </aside>
        <!-- <aside class="widget woocommerce widget_price_filter">
            <h3 class="widget-title">Price</h3>
            <form action="#">
                <div class="price_slider_wrapper">
                    <div class="price_slider ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                        <div class="ui-slider-range ui-widget-header ui-corner-all" style="left: 0%; width: 100%;"></div>
                        <span tabindex="0" class="ui-slider-handle ui-state-default ui-corner-all" style="left: 0%;"></span>
                        <span tabindex="0" class="ui-slider-handle ui-state-default ui-corner-all" style="left: 100%;"></span>
                    </div>
                    <div class="price_slider_amount">
                        <a href="#" class="button">Filter</a>
                        <div class="price_label">Price: <span class="from">$428</span> — <span class="to">$3485</span></div>
                        <div class="clear"></div>
                    </div>
                </div>
            </form>
        </aside> -->
    </aside>
<?php
}
