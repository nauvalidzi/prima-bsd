<?php

namespace PHPMaker2021\distributor;

// Page object
$LaporanInvoice = &$Page;
?>
<?php 
	$listpayment = ExecuteQuery("SELECT * FROM tipepayment ORDER BY id ASC")->fetchAll();

	$dateFrom = date('Y-m-01');
	$dateTo = date('Y-m-t');

	if (isset($_GET['option'], $_GET['status'], $_GET['dateFrom'], $_GET['dateTo'])) {
		$dateFrom = date('Y-m-d', strtotime($_GET['dateFrom']));
		$dateTo = date('Y-m-d', strtotime($_GET['dateTo']));

		$status = null;
		if ($_GET['status'] == 'lunas') {
			$status = " AND i.sisabayar < 1";
		}

		if ($_GET['status'] == 'belum-lunas') {
			$status = " AND i.sisabayar > 0";
		}

		$tipepayment = null;
		if ($_GET['option'] != "all") {
			$payment_id = ExecuteRow("SELECT id FROM tipepayment WHERE payment like '{$_GET['option']}'")['id'];
			$tipepayment = " AND i.idtipepayment = {$payment_id}";
		}

		$query = "SELECT i.tglinvoice, i.kode AS kode_invoice, o.kode AS kode_po, 
					c.nama as nama_customer, i.totaltagihan, sisabayar as piutang, 
					t.payment, IFNULL(SUM(p.jumlahbayar),0) AS totalbayar
				  FROM invoice i
				  JOIN customer c ON c.id = i.idcustomer
				  JOIN `order` o ON o.id = i.idorder
				  JOIN tipepayment t ON t.id = i.idtipepayment
				  LEFT JOIN pembayaran p ON p.idinvoice = i.id
				  WHERE i.tglinvoice BETWEEN '{$dateFrom}' AND '{$dateTo}' {$tipepayment} {$status}
				  GROUP BY i.id
				  ORDER BY i.id ASC";

		$result = ExecuteQuery($query)->fetchAll();
	}
?>
<style>
	.col-flex {
		width: 150px;
		min-width: 150px;
		max-width: 150px;
	}
	.col-description {
		width: 250px;
		min-width: 250px;
		max-width: 250px;
	}
	.col-currency {
		width: 175px;
		min-width: 175px;
		max-width: 175px;
	}
</style>
<div class="container">
	<div class="row">
		<form method="get" action="<?php echo CurrentPage()->PageObjName ?>">
			<div class="col-md-12">
				<ul class="list-unstyled">
					<li class="d-inline-block">
						<label class="d-block">Pembayaran:</label>
						<select name="option" class="form-control" style="width: 10em;">
							<option value="all" <?php echo (isset($_GET['option']) && $_GET['option'] == "all") || empty($_GET['option']) ? "selected" : "" ?>>-- All --</option>
							<?php foreach ($listpayment as $r) {
								$selected = isset($_GET['option']) && $_GET['option'] != "all" ? $_GET['option'] == strtolower($r['payment']) ? "selected" : "" : "";
								echo "<option value=".strtolower($r['payment'])." {$selected}>{$r['payment']}</option>";
							}?>
						</select>
					</li>
					<li class="d-inline-block">
						<label class="d-block">Status Invoice:</label>
						<select name="status" class="form-control" style="width: 10em;">
							<option selected value="all" <?php echo isset($_GET['status']) && $_GET['status'] == "all" ? "selected":""; ?>>-- All --</option>
							<option value="lunas" <?php echo isset($_GET['status']) && $_GET['status'] == "lunas" ? "selected":""; ?>>Lunas</option>
							<option value="belum-lunas" <?php echo isset($_GET['status']) && $_GET['status'] == "belum-lunas" ? "selected":""; ?>>Belum Lunas</option>
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
						<button class="btn btn-primary btn-md p-2" type="submit">Search <i class="fa fa-search h-3"></i></button>
					</li>
					<?php if (isset($_GET['option'], $_GET['status'], $_GET['dateFrom'], $_GET['dateTo'])) : ?>
					<li class="d-inline-block">
						<button type="button" class="btn btn-info btn-md p-2" onclick="exportTableToExcel('printTable')"><i class="mr-2 far fa-file-excel"></i>Export to Excel</button>
					</li>
					<?php endif; ?>
				</ul>
			</div>
		</form>
	</div>
	<div class="row">
	    <?php if (isset($_GET['option'], $_GET['status'], $_GET['dateFrom'], $_GET['dateTo'])) : ?>
	    <table class="table ew-table table-bordered" id="printTable">
	    	<thead>
				<tr>
					<th colspan="10" class="text-center">
						<h4 class="my-2">Laporan Invoice</h4>
						<p class="mt-3">Pembayaran: <?php echo ucwords($_GET['option']); ?><br />Status Invoice: <?php echo ucwords($_GET['status']) ?><br />Periode: <?php echo tgl_indo($dateFrom) . ' - ' . tgl_indo($dateTo) ?></p>
					</th>
				</tr>
	    		<tr>
	    			<th class="text-center">No.</th>
		    		<th class="text-center col-flex">Tgl Invoice</th>
		    		<th class="text-center col-flex">Kode Invoice</th>
		    		<th class="text-center col-flex">Kode Order</th>
		    		<th class="text-center col-description">Nama Pelanggan</th>
		    		<th class="text-center col-currency">Total Tagihan</th>
		    		<th class="text-center col-currency">Piutang</th>
		    		<th class="text-center col-currency">Total Bayar</th>
		    		<?php if ($_GET['option'] == "all"): ?>
		    		<th class="text-center col-flex">Pembayaran</th>
			    	<?php endif; ?>
		    		<?php if ($_GET['status'] == "all"): ?>
		    		<th class="text-center col-flex">Status</th>
			    	<?php endif; ?>
	    		</tr>
	    	</thead>
	    	<tbody>
    		<?php if (!empty($result)): ?>
    			<?php $i = 1; $ext = ['totaltagihan' => 0, 'piutang' => 0, 'totalbayar' => 0]; ?>
	    		<?php foreach($result as $row): ?>
	    		<tr>
	    			<td class="text-center"><?php echo $i; ?></td>
		    		<td class="text-center"><?php echo tgl_indo($row['tglinvoice']) ?></td>
		    		<td class="text-center"><?php echo $row['kode_invoice'] ?></td>
		    		<td class="text-center"><?php echo $row['kode_po'] ?></td>
		    		<td><?php echo $row['nama_customer'] ?></td>
		    		<td>Rp. <span class="float-right"><?php echo number_format($row['totaltagihan'], 2, ",", ".") ?></span></td>
		    		<td>Rp. <span class="float-right"><?php echo number_format($row['piutang'], 2, ",", ".") ?></span></td>
		    		<td>Rp. <span class="float-right"><?php echo number_format($row['totalbayar'], 2, ",", ".") ?></span></td>
		    		<?php if ($_GET['option'] == "all"): ?>
		    		<td class="text-center"><?php echo $row['payment'] ?></td>
			    	<?php endif; ?>
		    		<?php if ($_GET['status'] == "all"): ?>
		    		<td class="text-center"><?php echo $row['piutang'] < 1 ? 'Lunas' : 'Belum Lunas';  ?></td>
			    	<?php endif; ?>
	    		</tr>
	    		<?php 
	    			$ext['totaltagihan'] += $row['totaltagihan'];
	    			$ext['piutang'] += $row['piutang'];
	    			$ext['totalbayar'] += $row['totalbayar'];
	    		?>
		    	<?php $i++; endforeach; ?>
	    	<?php else: ?>
	    		<tr>
	    			<td colspan="10" class="text-center">Tidak ada data.</td>
	    		</tr>
	    	<?php endif; ?>
	    	</tbody>
    		<?php if (!empty($result)): ?>
	    	<tfoot>
	    		<tr>
	    			<th colspan="5" class="text-right">Grand Total :</th>
	    			<th>Rp. <span class="float-right"><?php echo number_format($ext['totaltagihan'], 2, ",", ".") ?></span></th>
	    			<th>Rp. <span class="float-right"><?php echo number_format($ext['piutang'], 2, ",", ".") ?></span></th>
	    			<th>Rp. <span class="float-right"><?php echo number_format($ext['totalbayar'], 2, ",", ".") ?></span></th>
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
				filename = filename ? filename + '.xls' : 'Laporan Invoice '+ d.toDateString() +'.xls';

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
