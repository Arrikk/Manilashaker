<?php
function __sidebar_widget_ads($image = '/Public/assets/images/bg/07.jpg')
{
?>
    <aside class="widget widget_text">
        <div class="textwidget">
            <a href="#">
                <img src="/Public/assets/images/blank.gif" data-echo="<?= $image ?? '' ?>" alt="Banner">
            </a>
        </div>
    </aside>
<?php
}
