<?php
function __shop_single_spec($spec){
	$specification = json_decode($spec->product_specification);
	if(!$specification == '' && !$specification == null || is_countable($specification)){
		foreach ($specification as $key => $value) {
			echo '<table>
			<th><h2>'. ucwords(str_replace('_', ' ', $key)) .'</h2></th>
			<tbody>';
			foreach ($value as $key => $value):
				if($key == '0') continue;
				?>
						<tr>
							<th><?= ucwords($key) ?></th>
							<td><?= $value ?></td>
						</tr>
						<?php
			endforeach;
			echo '</tbody></table>';
		}
	}

}