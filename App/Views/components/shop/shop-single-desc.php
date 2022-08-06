<?php
function __shop_single_desc($desc)
{
?>
    <div class="electro-description product-desc">
        <?php
			$u = str_replace('amp;', '', $desc);
			echo html_entity_decode($u);
		?>
    </div><!-- /.electro-description -->

<?php
}
