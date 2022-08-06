<?php

use App\Models\Blog;

function __blog_pagination($type){
    $count = $GLOBALS['blog']['__total_posts'];
    $current = $GLOBALS['blog']['__current_page'];
    ?>
    <!-- <li><a class="prev page-numbers" href="#">Next&nbsp;<span class="meta-nav">&rarr;</span></a></li>
    <li><span class='page-numbers current'>1</span></li>
    <li><a class='page-numbers' href='#'>...</a></li>
    <li><a class='page-numbers' href='#'>20</a></li>
    <li><a class="next page-numbers" href="#">Next&nbsp;<span class="meta-nav">&rarr;</span></a></li> -->
    
        <nav class="navigation pagination">
            <h2 class="screen-reader-text">Posts navigation</h2>
            <div class="nav-links">
                <ul class='page-numbers'>
                    <input type="hidden" id="type" value="<?= $type ?>">
                    <input type="hidden" id="currentPage" value="<?= $current ?? 1?>">
                    <input type="hidden" id="totalPage" value="<?= round($count / Blog::POST_LIMIT) ?>">
                </ul>
            </div>
        </nav>
        
    <script>
        let page = 1;
        let totalPage = $('#totalPage').val()
        let currentPage = $('#currentPage')
        let pageNumbers = $('ul.page-numbers')
        let type = $('input#type').val()
        let Url = ''
        if(type == 'MAIN'){
            Url = '/page/'
        }else if(type == 'CATEGORY'){
            let currLoc = location.pathname
            currLoc = currLoc.split('/')
            Url = `/${currLoc[1]}/${currLoc[2]}/${currLoc[3]}/`
        }

        let listTag = ''

        let crtPage = currentPage.val();

        if(crtPage > page){
            crtPage--
            pageNumbers.append(`<li><a class="prev page-numbers" href="${Url}${crtPage}">Prev&nbsp;<span class="meta-nav">&rarr;</span></a></li>`)
        }

        if(crtPage > 2){
            if(page > 3){
                listTag +=`<li><a class='page-numbers' href='javasctipt:;'>...</a></li>`
            }
            listTag +=`<li><a class='page-numbers' href='${Url}1'>1</a></li>`
        }

        let pagePrevious = +crtPage - 2;
        if(pagePrevious < 1) pagePrevious = 1;
        let pageNext = +crtPage + 2;
        if(pageNext >= totalPage) pageNext = totalPage-1;

        // if(page > 0 && !pagePrevious < 0)

        for (let i = pagePrevious; i <= pageNext; i++) {
            listTag += `
            <li><a href="${Url}${i}" class='page-numbers ${i == crtPage ? 'current' : ''}'>${i}</a></li>
            `
        }

        if(crtPage < totalPage-1){
            if(page < totalPage - 3){
                listTag +=`<li><a class='page-numbers' href='javasctipt:;'>...</a></li>`
            }
            listTag +=`<li><a class='page-numbers' href='${Url}${totalPage}'>${totalPage}</a></li>`
        }

        if(crtPage < totalPage){
            crtPage++
            listTag +=`<li><a class="next page-numbers" href="${Url}${crtPage+=1}">Load More&nbsp;<span class="meta-nav">&rarr;</span></a></li>`
        }

        pageNumbers.html(listTag)

    </script>
    <?php


}