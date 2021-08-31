<?php

namespace PHPMaker2021\distributor;

// Page object
$LaporanPurchaseOrder = &$Page;
?>
<?php
	$status_selected = "all";
	$status = null;

	$marketing = "all";
	$listmarketing = ExecuteQuery("SELECT id, kode, nama FROM pegawai ORDER BY id ASC")->fetchAll();

	if(isset($_POST['srhDate'])){
		$dateFrom = !empty($_POST['dateFrom']) ? $_POST['dateFrom'] : date('Y-m-01');
		$dateTo = !empty($_POST['dateTo']) ? $_POST['dateTo'] : date('Y-m-t');
		$marketing = ($_POST['marketing'] != "all") ? " AND `order`.`idpegawai` = ".$_POST['marketing'] : "";

		if ($_POST['status'] == 'processed') {
			$status = " AND `order`.`readonly` = 1";
			$status_selected = "processed";
		}

		if ($_POST['status'] == 'unprocess') {
			$status = " AND `order`.`readonly` = 0";
			$status_selected = "unprocess";
		}

		$query = "SELECT `order`.`id` as order_id, `order`.`kode`, `order`.`tanggal`, `customer`.`nama` as nama_customer, 
					`pegawai`.`nama` as nama_pegawai, SUM(`order_detail`.`jumlah`) AS total_barang, 
					SUM(`order_detail`.`total`) AS total_harga, COUNT(`order_detail`.`idproduct`) AS jenis_barang
				  FROM `order` 
				  JOIN customer ON `customer`.`id` = `order`.`idcustomer`
				  JOIN pegawai ON `pegawai`.`id` = `order`.`idpegawai`
				  JOIN order_detail ON `order`.`id` = `order_detail`.`idorder`
				  WHERE tanggal BETWEEN '{$dateFrom}' AND '{$dateTo}' {$status} {$marketing}
				  GROUP BY `order`.`id`
				  ORDER BY `order`.`tanggal` ASC";

		$result = ExecuteQuery($query)->fetchAll();
	}
?>
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
						<label class="d-block">M.R.:</label>
						<select name="marketing" class="form-control">
							<option value="all" <?php echo $marketing == "all" ? "selected" : "" ?>>-- All --</option>
							<?php foreach ($listmarketing as $mr) {
								$selected = ($_POST['marketing'] != "all") ? ($_POST['marketing'] == $mr['id']) ? "selected" : "" : "";
								echo "<option value=".$mr['id']." {$selected}>".$mr['kode'] . " - " . $mr['nama']."</option>";
							}?>
						</select>
					</li>
					<li class="d-inline-block">
						<label class="d-block">Status P.O:</label>
						<select name="status" class="form-control">
							<option selected value="all" <?php echo ($status_selected == "all") ? "selected":""; ?>>-- All --</option>
							<option value="processed" <?php echo ($status_selected == "processed") ? "selected":""; ?>>Telah Diproses</option>
							<option value="unprocess" <?php echo ($status_selected == "unprocess") ? "selected":""; ?>>Belum Diproses</option>
						</select>
					</li>
					<li class="d-inline-block">
						<label class="d-block">Date Range</label>
						<input type="date" class="form-control input-md" name="dateFrom" value="<?php echo (!empty($dateFrom)) ? $dateFrom : date('d/m/Y') ?>">
					</li>
					to
					<li class="d-inline-block">
						<input type="date" class="form-control input-md" name="dateTo">
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
				<th colspan="10" class="text-center">
					<h4 class="my-2">Laporan Purchase Order</h4>
					<p class="mt-3">Periode:<br /><?php echo tgl_indo($dateFrom) . ' - ' . tgl_indo($dateTo) ?></p>
				</th>
			</tr>
		    <tr>
		        <th>No</th>
		        <th>Kode</th>
		        <th>Tanggal</th>
		        <th>Customer</th>
		        <th class="text-center">Jenis Barang</th>
		        <th class="text-center">Jumlah Barang</th>
		        <th class="text-center">Total Harga</th>
		        <?php if ($_POST['marketing'] == "all") : ?>
		        <th>Pegawai</th>
			    <?php endif; ?>
		    </tr>
		  </thead>
		  <tbody>
	    	<?php if (!empty($result)): ?>
			    <?php $i = 1; $ext = ['total_barang' => 0, 'total_harga' => 0] ?>
			    <?php foreach($result as $row): ?>
			    <tr>
			      <td><?php echo $i ?></td>
			      <td><a href="<?php echo base_url() ?>OrderDetailList?showmaster=order&fk_id=<?php echo $row['order_id'] ?>" target="_blank"><?php echo $row['kode'] ?></a></td>
			      <td><?php echo tgl_indo($row['tanggal']) ?></td>
			      <td><?php echo $row['nama_customer'] ?></td>
			      <td class="text-center"><?php echo $row['jenis_barang'] ?></td>
			      <td class="text-center"><?php echo $row['total_barang'] ?></td>
			      <td>Rp. <span class="float-right"><?php echo number_format($row['total_harga'], 2, ",", ".") ?></span></td>
			      <?php if ($_POST['marketing'] == "all") : ?>
			      <td><?php echo $row['nama_pegawai'] ?></td>
				  <?php endif; ?>
			    </tr>
			    <?php 
			    	$ext['total_barang'] += $row['total_barang'];
			    	$ext['total_harga'] += $row['total_harga'];
			    ?>
			    <?php $i++; endforeach; ?>
	    	<?php else: ?>
	    		<tr>
	    			<td colspan="8" class="text-center">Tidak ada data.</td>
	    		</tr>
	    	<?php endif; ?>
		  </tbody>
		  <?php if (!empty($result)): ?>
		  <tfoot>
		  	<tr>
		  		<th colspan="5" class="text-right">Grand Total :</th>
		  		<th class="text-center"><?php echo number_format($ext['total_barang'], 0, ",", ".") ?></th>
		  		<th>Rp. <span class="float-right"><?php echo number_format($ext['total_harga'], 2, ",", ".") ?></span></th>
		  	</tr>
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
				filename = filename ? filename + '.xls' : 'Laporan Purchase Order '+ d.toDateString() +'.xls';

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
