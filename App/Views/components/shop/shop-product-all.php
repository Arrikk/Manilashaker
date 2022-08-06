<?php
function __shop_all_product()
{
?>
<style>
    .main-filter-content{
        margin-bottom: 25px;
        display: flex;
    }
    .list-title{
        font-size: 15px;
        margin-right: 20px;
    }
    .filter-item{
        display: flex;
        margin: 0;
        padding: 0;
        list-style-type: none;
        border-bottom: 3px solid #e8e8e8
    }
    .filter-items{
        margin-right: 20px;
        font-size: 15px;
        padding-bottom: 5px;
        position: relative;
    }
    .filter-items.current{
        color:#a3d133
    }
    .filter-items.current::after{
        background: #a3d133;
        content: '';
        display: block;
        height: 2px;
        width: 100%;
        position: absolute;
        bottom: -3px;
    }
    .filter-link{
        color: inherit;
        text-decoration: none;
    }
    .filter-select:focus{
        outline: none;
    }
    .filter-select{
        border: none;
    }
    @media (max-width: 400px) {
        .main-filter-content{display: none;}
    }
</style>
    <div class="tab-content">
        <?php
            __home_filter_block();
        ?>
        <div role="tabpanel" class="tab-pane active" id="grid" aria-expanded="true">
            <ul class="products columns-3 gadgets-display">
            </ul>
        </div>
    </div>
<?php
}
