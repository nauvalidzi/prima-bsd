<?php

namespace PHPMaker2021\production2;

// Page object
$NpdResume = &$Page;
?>
<?php 
	$json = curl_get_auth(url_integrasi() . "?action=list&object=v_pd_rpt_pengembangan", url_integrasi_auth('bsd2', 'bsdabc'));
    $raw_data = json_decode($json, true);

    if ($raw_data['success'] <> true) die;
?>
<?php 
	// Make the JSON an array, so count() and array_slice() work
	$data = $raw_data['v_pd_rpt_pengembangan'];

	$page = ! empty( $_GET['page'] ) ? (int) $_GET['page'] : 1;
	$total = count($data); //total items in array    
	// $limit = 10; //per page
	// Set limit to 3 for testing:
	$limit = 10;
	$totalPages = ceil( $total/ $limit ); //calculate total pages
	$page = max($page, 1); //get 1 page when $_GET['page'] <= 0
	$page = min($page, $totalPages); //get last page when $_GET['page'] > $totalPages
	// Uncomment this for testing
	// $page = 2;
	$offset = ($page - 1) * $limit;
	if( $offset < 0 ) $offset = 0;

	$yourDataArray = array_slice( $data, $offset, $limit );
 ?>
<div class="row table-responsive">
	<table class="table ew-table table-bordered table-striped" style="min-width: max-content;">
		<thead>
			<tr>
				<th class="text-center align-middle">Sifat Order</th>
				<th class="text-center align-middle">Tgl Order</th>
				<th class="text-center align-middle">Customer</th>
				<th class="text-center align-middle">Nomor</th>
				<th class="text-center align-middle">Kategori</th>
				<th class="text-center align-middle">Jenis</th>
				<th class="text-center">Jumlah<br>Sample</th>
				<th class="text-center">Sampel<br>Terkirim</th>
				<th class="text-center align-middle">Status</th>
			</tr>
		</thead>
		<tbody>
		<?php if (count($yourDataArray) > 0): ?>
			<?php $i=0; foreach($yourDataArray as $row) : ?>
			<tr>
				<td><?php echo ucwords($row['statusproduk']) ?></td>
				<td class="text-center"><?php echo date('d/m/Y', strtotime($row['tgl_order'])) ?></td>
				<td><?php echo $row['kd_customer'] ?></td>
				<td><?php echo $row['no_sp'] ?></td>
				<td><?php echo $row['kategoriproduk'] ?></td>
				<td><?php echo $row['jenisproduk'] ?></td>
				<td class="text-center"><?php echo $row['jml_sampel'] ?></td>
				<td class="text-center"><?php echo $row['sampel_terkirim'] ?></td>
				<td class="text-center"><?php echo $row['status_data'] ?></td>
			</tr>
			<?php $i++; endforeach; ?>
		<?php else: ?>
			<tr>
				<td class="text-center" colspan="10">Tidak ada data.</td>
			</tr>
		<?php endif; ?>
		</tbody>
		<tfoot>
			<tr>
				<th colspan="10">
					<ul class="pagination float-left">
					<?php 
					$link = CurrentPage()->PageObjName ."?page=%d";
					if ($totalPages > 1) {
						if ($page > 2 ) { 
							echo sprintf("<li class=\"page-item\"><a href=\"{$link}\" class=\"page-link\">First</a></li>", 1); 
						}

						if ($page > 1 ) { 
							echo sprintf("<li class=\"page-item\"><a href=\"{$link}\" class=\"page-link\">Previous</a></li>", $page - 1); 
						}

						for ($x = 1; $x <= $totalPages; $x++) {
							if ($page == $x) {
								echo "<li class=\"page-item disabled\"><a href=\"#\" class=\"page-link\">{$x}</a></li>";
							} else {
								echo sprintf("<li class=\"page-item\"><a href=\"{$link}\" class=\"page-link\">{$x}</a></li>", $x) ;
							}
						}

						if ($page < $totalPages) { 
							echo sprintf("<li class=\"page-item\"><a href=\"{$link}\" class=\"page-link\">Next</a></li>", $page + 1); 
						}

						if (($totalPages - $page) > 1) { 
							echo sprintf("<li class=\"page-item\"><a href=\"{$link}\" class=\"page-link\">Last</a></li>", $totalPages);
						}
					}                   
					?>
					</ul>
					<div class="float-left mt-2 ml-3">
						<?php echo "<span>Records ".(($i>0)?$offset+1:0)." to ".($offset+$i)." of {$total}</span>"; ?>
					</div>
				</th>
			</tr>
		</tfoot>
	</table>
</div>

<?= GetDebugMessage() ?>
