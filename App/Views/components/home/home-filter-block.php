<?php
function __home_filter_block(){
    $sort = $_GET['sort'] ?? '';
    $current = ['p' => '', 'pr' => '', 'l' => '', 'r' => ''];

    if($sort == 'popular') $current['p'] = 'current';
    if($sort == 'price-asc') $current['pr'] = 'current';
    if($sort == 'price-desc') $current['pr'] = 'current';
    if($sort == 'latest') $current['l'] = 'current';
    if($sort == 'recent') $current['r'] = 'current';
    extract($current);
    ?>
        <div class="main-filter-content">
            <span class="list-title"><strong>Sort by</strong></span>
            <ul class="filter-item">
                <li class="filter-items <?= $p ?>"><a href="?sort=popular" class="filter-link">Popular</a></li>
                <li class="filter-items <?= $l ?>"><a href="?sort=latest" class="filter-link current">Latest</a></li>
                <li class="filter-items <?= $pr ?>">
                <select name="" id="" class="filter-select">
                    <option value="">Price</option>
                    <option value="" data-href="?sort=price-asc">ASC</option>
                    <option value="" data-href="?sort=price-desc">DESC</option>
                </select>
            </li>
                <li class="filter-items"><a href="#" class="filter-link">Rating</a></li>
                <li class="filter-items <?= $r ?>"><a href="#" class="filter-link">Recently reviewed</a></li>
            </ul>
        </div>
        <script>
            $(document).on('change', 'select.filter-select', function(){
               let curr = $(this).find(':selected').data('href');
               window.location.search = curr
            })
        </script>
    <?php
}