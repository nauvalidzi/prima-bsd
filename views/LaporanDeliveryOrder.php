<?php

namespace PHPMaker2021\production2;

// Page object
$LaporanDeliveryOrder = &$Page;
?>
<?php
	$status_selected = "all";
	$status = null;
	$dateFrom = date('Y-m-01');
	$dateTo = date('Y-m-t');

	if(isset($_POST['srhDate'])){
		$dateFrom = date('Y-m-d', strtotime($_POST['dateFrom']));
		$dateTo = date('Y-m-d', strtotime($_POST['dateTo']));
		
		if ($_POST['status'] == 'lunas') {
			$status = " AND od.isa < 1";
			$status_selected = "lunas";
		}

		if ($_POST['status'] == 'sisa') {
			$status = " AND od.sisa > 0";
			$status_selected = "sisa";
		}

		$query = "SELECT d.id AS do_id, d.kode AS kode_do, d.tanggal AS tgl_do,
					o.kode AS kode_order, b.title AS brand, p.kode AS kode_produk, 
					p.nama AS nama_produk, od.jumlah + od.bonus AS jumlahorder,
					od.sisa AS sisakirim, dd.jumlahkirim as jumlahkirim
				FROM deliveryorder d
				JOIN deliveryorder_detail dd ON dd.iddeliveryorder = d.id
				JOIN order_detail od ON od.id = dd.idorder_detail
				JOIN `order` o ON o.id = od.idorder
				JOIN product p ON od.idproduct = p.id
				JOIN brand b ON b.id = p.idbrand
				WHERE d.tanggal BETWEEN '{$dateFrom}' AND '{$dateTo}' {$status}
				ORDER BY d.kode, d.tanggal ASC";

		$result = ExecuteQuery($query)->fetchAll();
	}
?>
<style>
	.col-flex {
		width: 130px;
		min-width: 130px;
		max-width: 130px;
	}
	.col-description {
		width: 270px;
		min-width: 270px;
		max-width: 270px;
	}
</style>
<div class="container">
 	<div class="row">
		<form method="post" action="<?php echo CurrentPage()->PageObjName ?>">
			<?php if (Config("CHECK_TOKEN")) : ?>
	            <input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
	            <input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
            <?php endif; ?>
			<div class="col-md-12">
				<ul class="list-unstyled">
					<li class="d-inline-block">
						<label class="d-block">Status D.O:</label>
						<select name="status" class="form-control">
							<option value="all" <?php echo ($status_selected == "all") ? "selected":""; ?>>-- All --</option>
							<option value="lunas" <?php echo ($status_selected == "lunas") ? "selected":""; ?>>Lunas</option>
							<option value="sisa" <?php echo ($status_selected == "sisa") ? "selected":""; ?>>Sisa</option>
						</select>
					</li>
					<li class="d-inline-block">
						<label class="d-block">Date Range</label>
						<input type="date" class="form-control input-md" name="dateFrom" value="<?php echo $dateFrom ?>">
					</li>
					to
					<li class="d-inline-block">
						<input type="date" class="form-control input-md" name="dateTo" value="<?php echo $dateTo ?>">
					</li>
					<li class="d-inline-block">
						<button class="btn btn-primary btn-md p-2" type="submit" name="srhDate">Search <i class="fa fa-search h-3"></i></button>
					</li>
					<?php if(isset($_POST['srhDate'])) : ?>
					<li class="d-inline-block">
						<button type="button" class="btn btn-info btn-md p-2" onclick="exportTableToExcel('printTable')"><i class="mr-2 far fa-file-excel"></i>Export to Excel</button>
					</li>
					<?php endif; ?>
				</ul>
			</div>
		</form>
	</div>
	<div class="row">
	    <?php if(isset($_POST['srhDate'])) : ?>
	    <table class="table ew-table table-bordered" id="printTable">
		  <thead>
			<tr>
				<th colspan="11" class="text-center">
					<h4 class="my-2">Laporan Delivery Order</h4>
					<p class="mt-3">Status D.O: <?php echo ucwords($status_selected) ?><br />Periode: <?php echo tgl_indo($dateFrom) . ' - ' . tgl_indo($dateTo) ?></p>
				</th>
			</tr>
		    <tr>
		        <th class="text-center">No</th>
		        <th class="text-center col-flex">Tanggal DO</th>
		        <th class="text-center col-flex">Kode D.O</th>
		        <th class="text-center col-flex">Kode Order</th>
		        <th class="text-center col-flex">Brand</th>
		        <th class="text-center col-flex">Kode Barang</th>
		        <th class="text-center col-description">Nama Barang</th>
		        <th class="text-center col-flex">Jumlah Order</th>
		        <th class="text-center col-flex">Jumlah Kirim</th>
			    <?php if ($_POST['status'] == "all" || $_POST['status'] == "sisa") : ?>
		        <th class="text-center col-flex">Sisa</th>
			    <?php endif; ?>
		        <?php if ($_POST['status'] == "all") : ?>
		        <th class="text-center col-flex">Status</th>
			    <?php endif; ?>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php if (!empty($result)): ?>
			  	<?php $ext = ['total_order' => 0, 'total_kirim' => 0, 'total_sisa' => 0]; $i = 0; $kode_do = ""; ?>
			    <?php foreach($result as $row) : ?>
			    <?php if ($kode_do != $row['kode_do']) $i++; ?>
			    <tr>
			      <td class="text-center"><?php echo $i?></td>
			      <td class="text-center"><?php echo tgl_indo($row['tgl_do']) ?></td>
			      <td class="text-center"><a href="<?php echo base_url() ?>DeliveryorderDetailList?showmaster=deliveryorder&fk_id=<?php echo $row['do_id'] ?>" target="_blank"><?php echo $row['kode_do'] ?></a></td>
			      <td class="text-center"><?php echo $row['kode_order'] ?></td>
			      <td class="text-center"><?php echo $row['brand'] ?></td>
			      <td class="text-center"><?php echo $row['kode_produk'] ?></td>
			      <td><?php echo $row['nama_produk'] ?></td>
			      <td class="text-center"><?php echo $row['jumlahorder'] ?></td>
			      <td class="text-center"><?php echo $row['jumlahkirim'] ?></td>
			      <?php if ($_POST['status'] == "all" || $_POST['status'] == "sisa") : ?>
			      <td class="text-center"><?php echo $row['sisakirim'] ?></td>
				  <?php endif; ?>
			      <?php if ($_POST['status'] == "all") : ?>
			      <td class="text-center"><?php echo $row['sisakirim'] < 1 ? 'Lengkap' : 'Belum Lengkap'; ?></td>
				  <?php endif; ?>
			    </tr>
			    <?php 
			    	$ext['total_order'] += $row['jumlahorder'];
			    	$ext['total_kirim'] += $row['jumlahkirim'];
			    	$ext['total_sisa'] += $row['sisakirim'];
			     ?>
			    <?php $kode_do = $row['kode_do']; ?>
			    <?php endforeach;?>
	    	<?php else: ?>
	    		<tr>
	    			<td colspan="11" class="text-center">Tidak ada data.</td>
	    		</tr>
	    	<?php endif; ?>
		  </tbody>
		  <?php if (!empty($result)): ?>
		  <tfoot>
		  	<th class="text-right" colspan="7">Grand Total :</th>
		  	<th class="text-center"><?php echo number_format($ext['total_order'], 0, ",", ".") ?></th>
		  	<th class="text-center"><?php echo number_format($ext['total_kirim'], 0, ",", ".") ?></th>
			<?php if ($_POST['status'] == "all" || $_POST['status'] == "sisa") : ?>
		  	<th class="text-center"><?php echo number_format($ext['total_sisa'], 0, ",", ".") ?></th>
		  	<?php endif; ?>
		  </tfoot>
		  <?php endif; ?>
		</table>
		<script>
			function exportTableToExcel(tableID, filename = '') {
				var downloadLink;
				var dataType = 'data:application/vnd.ms-excel';
				var tableSelect = document.getElementById(tableID);
				var tableHTML = encodeURIComponent(tableSelect.outerHTML);
				var d = new Date();

				// Specify file name
				filename = filename ? filename + '.xls' : 'Laporan Delivery Order '+ d.toDateString() +'.xls';

				// Create download link element
				downloadLink = document.createElement("a");

				document.body.appendChild(downloadLink);

				if (navigator.msSaveOrOpenBlob) {
					var blob = new Blob(['\ufeff', tableHTML], {
						type: dataType
					});
					navigator.msSaveOrOpenBlob(blob, filename);
				} else {
					// Create a link to the file
					downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

					// Setting the file name
					downloadLink.download = filename;

					//triggering the function
					downloadLink.click();
				}
			}
		</script>
		<?php endif; ?>
	</div>
</div>

<?= GetDebugMessage() ?>
