<?php

namespace PHPMaker2021\distributor;

// Page object
$LaporanInvoice = &$Page;
?>
<?php 
	$status_selected = "all";
	$status = null;

	$payment = "all";
	$listpayment = ExecuteQuery("SELECT * FROM tipepayment ORDER BY id ASC")->fetchAll();

	$dateFrom = date('Y-m-01');
	$dateTo = date('Y-m-t');

	if(isset($_POST['srhDate'])){
		$dateFrom = date('Y-m-d', strtotime($_POST['dateFrom']));
		$dateTo = date('Y-m-d', strtotime($_POST['dateTo']));

		if ($_POST['status'] == 'lunas') {
			$status = " AND invoice.sisabayar < 1";
			$status_selected = "lunas";
		}

		if ($_POST['status'] == 'belumlunas') {
			$status = " AND invoice.sisabayar > 0";
			$status_selected = "belumlunas";
		}

		$tipepayment = null;
		if ($_POST['payment'] != "all") {
			$tipepayment = " AND idtipepayment = ".$_POST['payment'];
			$payment_selected = ExecuteRow("SELECT payment FROM tipepayment WHERE id = {$_POST['payment']}");
		}

		$query = "SELECT tglinvoice, invoice.kode AS kode_invoice, `order`.kode AS kode_po, 
					customer.nama as nama_customer, totaltagihan, sisabayar, invoice.aktif, tipepayment.payment
				  FROM invoice
				  JOIN customer ON customer.id = invoice.idcustomer
				  JOIN `order` ON `order`.id = invoice.idorder
				  JOIN tipepayment ON tipepayment.id = invoice.idtipepayment
				  WHERE tglinvoice BETWEEN '{$dateFrom}' AND '{$dateTo}' {$tipepayment} {$status}
				  ORDER BY invoice.id ASC";

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
						<label class="d-block">Pembayaran:</label>
						<select name="payment" class="form-control">
							<option value="all" <?php echo $payment == "all" ? "selected" : "" ?>>-- All --</option>
							<?php foreach ($listpayment as $r) {
								$selected = ($_POST['payment'] != "all") ? ($_POST['payment'] == $r['id']) ? "selected" : "" : "";
								echo "<option value=".$r['id']." {$selected}>".$r['payment']."</option>";
							}?>
						</select>
					</li>
					<li class="d-inline-block">
						<label class="d-block">Status Invoice:</label>
						<select name="status" class="form-control">
							<option selected value="all" <?php echo ($status_selected == "all") ? "selected":""; ?>>-- All --</option>
							<option value="lunas" <?php echo ($status_selected == "lunas") ? "selected":""; ?>>Lunas</option>
							<option value="belumlunas" <?php echo ($status_selected == "belumlunas") ? "selected":""; ?>>Belum Lunas</option>
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
					<th colspan="10" class="text-center">
						<h4 class="my-2">Laporan Invoice</h4>
						<p class="mt-3">Pembayaran: <?php echo ($_POST['payment'] == "all") ? "All" : $payment_selected['payment']; ?><br />Status Invoice: <?php echo ucwords($status_selected) ?><br />Periode: <?php echo tgl_indo($dateFrom) . ' - ' . tgl_indo($dateTo) ?></p>
					</th>
				</tr>
	    		<tr>
	    			<th class="text-center">No.</th>
		    		<th class="text-center">Tgl Invoice</th>
		    		<th class="text-center">Kode Invoice</th>
		    		<th class="text-center">Kode P.O.</th>
		    		<th class="text-center">Total Tagihan</th>
		    		<th class="text-center">Sisa Bayar</th>
		    		<?php if ($_POST['payment'] == "all"): ?>
		    		<th class="text-center">Pembayaran</th>
			    	<?php endif; ?>
		    		<?php if ($status_selected == "all"): ?>
		    		<th class="text-center">Status</th>
			    	<?php endif; ?>
	    		</tr>
	    	</thead>
	    	<tbody>
    		<?php if (!empty($result)): ?>
    			<?php $i = 1; $ext = ['totaltagihan' => 0, 'sisabayar' => 0]; ?>
	    		<?php foreach($result as $row): ?>
	    		<tr>
	    			<td class="text-center"><?php echo $i; ?></td>
		    		<td><?php echo tgl_indo($row['tglinvoice']) ?></td>
		    		<td><?php echo $row['kode_invoice'] ?></td>
		    		<td><?php echo $row['kode_po'] . ', ' . $row['nama_customer'] ?></td>
		    		<td>Rp. <span class="float-right"><?php echo number_format($row['totaltagihan'], 2, ",", ".") ?></span></td>
		    		<td>Rp. <span class="float-right"><?php echo number_format($row['sisabayar'], 2, ",", ".") ?></span></td>
		    		<?php if ($_POST['payment'] == "all"): ?>
		    		<td class="text-center"><?php echo $row['payment'] ?></td>
			    	<?php endif; ?>
		    		<?php if ($status_selected == "all"): ?>
		    		<td class="text-center"><?php echo $row['sisabayar'] < 1 ? 'Lunas' : 'Belum Lunas';  ?></td>
			    	<?php endif; ?>
	    		</tr>
	    		<?php 
	    			$ext['totaltagihan'] += $row['totaltagihan'];
	    			$ext['sisabayar'] += $row['sisabayar'];
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
	    			<th colspan="4" class="text-right">Grand Total :</th>
	    			<th>Rp. <span class="float-right"><?php echo number_format($ext['totaltagihan'], 2, ",", ".") ?></span></th>
	    			<th>Rp. <span class="float-right"><?php echo number_format($ext['sisabayar'], 2, ",", ".") ?></span></th>
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
