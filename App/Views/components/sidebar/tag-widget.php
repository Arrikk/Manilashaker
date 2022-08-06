<?php
function __blog_tag_widget(){
    $tag = $GLOBALS["blog"]['__post_tags'];
    ?>
        <aside id="tag_cloud-2" class="widget widget_tag_cloud"><h3 class="widget-title">Tags Clouds</h3>
            <div class="tagcloud">
                <?php if(isset($tag) && count($tag) > 0):  ?>
                    <?php foreach ($tag as $tag): ?>
                        <a href="/news/tag/<?= $tag->slug ?>" ><?= $tag->name ?></a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <a href='#' class='' title='' style='font-size: 22pt;'>No Tag</a>
                <?php endif; ?>
            </div>
        </aside>

    <?php
}