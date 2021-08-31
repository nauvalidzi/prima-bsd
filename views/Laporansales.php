<?php

namespace PHPMaker2021\distributor;

// Page object
$Laporansales = &$Page;
?>
<?php
	$listmarketing = ExecuteQuery("SELECT id, kode, nama FROM pegawai ORDER BY id ASC")->fetchAll();

	if(isset($_POST['srhDate'])){
		$dateFrom = !empty($_POST['dateFrom']) ? $_POST['dateFrom'] : date('Y-m-01');
		$dateTo = !empty($_POST['dateTo']) ? $_POST['dateTo'] : date('Y-m-t');

		if ($_POST['marketing'] == "all") {
			$query = "SELECT p.id, p.nama AS namapegawai, IFNULL(vlo.totalcustomer,0) AS totalcustomer, IFNULL(vlo.totalorder,0) AS totalorder, 
							IFNULL(vlo.totalproduct,0) AS totalproduct,  IFNULL(vlo.totalbarang,0) AS totalbarang, IFNULL(vlo.totaltagihan,0) AS totaltagihan 
						FROM pegawai p 
						LEFT JOIN (
							SELECT o.idpegawai, COUNT(o.idcustomer) AS totalcustomer, COUNT(o.id) AS totalorder, SUM(od.totalpod) AS totalproduct, 
								SUM(od.totalbarang) AS totalbarang, SUM(od.totaltagihan) AS totaltagihan
							FROM `order` o
							JOIN (
								SELECT o.id, COUNT(od.id) AS totalpod, SUM(od.jumlah) AS totalbarang, SUM(od.total) AS totaltagihan, o.tanggal
								FROM order_detail od, `order` o
								WHERE od.idorder = o.id  AND o.tanggal BETWEEN '{$dateFrom}' AND '{$dateTo}'
								GROUP BY o.id
							) od ON od.id = o.id
							GROUP BY o.idpegawai
						) vlo ON p.id = vlo.idpegawai";
		} else {
			$query = "SELECT o.tanggal, o.kode, c.nama customer, SUM(od.total) total, p.nama pegawai
						FROM `order` o, order_detail od, customer c, pegawai p
						WHERE o.id = od.idorder AND c.id = o.idcustomer AND p.id = c.idpegawai AND o.tanggal BETWEEN '{$dateFrom}' AND '{$dateTo}' AND p.id = ".$_POST['marketing']."
						GROUP BY od.idorder";
			//$mr_selected = ExecuteRows("SELECT nama FROM pegawai WHERE id = $_POST['marketing']");
			$marketing = ExecuteRow("SELECT kode, nama FROM pegawai WHERE id = {$_POST['marketing']}");
		}

		$result = ExecuteQuery($query)->fetchAll();
	}
 ?>
<style>
.text-justify{
	text-align: justify;
	text-justify: inter-word;
}
</style>
<div class="container">
 	<div class="row">
        <form action="<?php echo CurrentPage()->PageObjName ?>" method="post">
			<?php if (Config("CHECK_TOKEN")) : ?>
	            <input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
	            <input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
            <?php endif; ?>

			<div class="col-md-12">
				<ul class="list-unstyled">
					<li class="d-inline-block">
						<label class="d-block">M.R.:</label>
						<select name="marketing" class="form-control">
							<option selected value="all">-- All --</option>
							<?php foreach ($listmarketing as $mr) {
								$selected = ($_POST['marketing'] != "all") ? ($_POST['marketing'] == $mr['id']) ? "selected" : "" : "";
								echo "<option value=".$mr['id']." {$selected}>".$mr['kode'] . " - " . $mr['nama']."</option>";
							}?>
						</select>
					</li>
					<li class="d-inline-block">
						<label class="d-block">Date Range</label>
						<input type="date" class="form-control input-md" name="dateFrom">
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
		<table class="table ew-table table-bordered" class="printTable">
		<?php if ($_POST['marketing'] == "all"): ?>
			<thead>
				<tr>
					<th colspan="6" class="text-center">
						<h4 class="my-2">Laporan Sales</h4>
						<p class="mt-3">Marketing: All<br />Periode: <?php echo tgl_indo($dateFrom) . ' - '. tgl_indo($dateTo) ?></p>
					</th>
				</tr>
				<tr class="ew-table-header">
					<th class="text-center">Marketing</th>
					<th class="text-center">Total Customer</th>
					<th class="text-center">Total Order</th>
					<th class="text-center">Total Barang</th>
					<th class="text-center" colspan="2">Total</th>
				</tr>
			</thead>
			<tbody>
				<?php if (!empty($result)): ?>
					<?php $total = ['order' => 0, 'barang' => 0, 'jumlah' => 0, 'customer' => 0]; ?>
					<?php foreach ($result as $data): ?>
					<tr>
						<td><?= $data['namapegawai'] ?></td>
						<td class="text-center"><?= $data['totalcustomer'] ?></td>
						<td class="text-center"><?= $data['totalorder'] ?></td>
						<td class="text-center"><?= $data['totalbarang'] ?></td>
						<td>Rp. <span class="float-right"><?php echo number_format($data['totaltagihan']) ?></span></td>
					</tr>
					<?php
						$total['customer'] += $data['totalcustomer'];
						$total['order'] += $data['totalorder'];
						$total['barang'] += $data['totalbarang'];
						$total['jumlah'] += $data['totaltagihan'];
					?>
					<?php endforeach; ?>
				<?php else: ?>
					<tr>
						<td colspan="6" align="center">Tidak ada data.</td>
					</tr>
				<?php endif; ?>
			</tbody>
			<?php if (!empty($result)):  ?>
			<tfoot>
				<tr class="ew-table-footer">
					<td class="text-right"><b>Grand Total :</b></td>
					<td class="text-center"><b><?= $total['customer'] ?></b></td>
					<td class="text-center"><b><?= $total['order'] ?></b></td>
					<td class="text-center"><b><?= $total['barang'] ?></b></td>
					<td><strong>Rp. <span class="float-right"><?php echo number_format($total['jumlah']) ?></strong></td>
				</tr>
			</tfoot>
			<?php endif; ?>
		<?php else: ?>
			<thead>
				<tr>
					<th colspan="6" class="text-center">
						<h4 class="my-2">Laporan Sales</h4>
						<p class="mt-3">Marketing: <?php echo $marketing['kode'] . ' - ' .$marketing['nama'] ?><br />Periode: <?php echo tgl_indo($dateFrom) . ' - '. tgl_indo($dateTo) ?></p>
					</th>
				</tr>
				<tr class="ew-table-header">
					<th class="text-center">No.</th>
					<th class="text-center">Tanggal</th>
					<th class="text-center">Kode Order</th>
					<th class="text-center">Customer</th>
					<th class="text-center">Total</th>
				</tr>
			</thead>
			<tbody>
				<?php $total = 0; ?>
				<?php if (!empty($result)): ?>
					<?php $i = 0; ?>
					<?php foreach ($result as $data): ?>
					<tr>
						<td class="text-center"><?= ++$i ?></td>
						<td><?= tgl_indo($data['tanggal']) ?></td>
						<td><?= $data['kode'] ?></td>
						<td><?= $data['customer'] ?></td>
						<td>Rp <span class="float-right"><?php echo number_format($data['total']) ?></span></td>
					</tr>
					<?php $total += $data['total']; ?>
					<?php endforeach; ?>
				<?php else: ?>
					<tr>
						<td colspan="6" align="center">Tidak ada data.</td>
					</tr>
				<?php endif; ?>
			</tbody>
			<?php if (!empty($result) && $total > 0):  ?>
			<tfoot>
				<tr>
					<td colspan="4" class="text-right"><strong>Grand Total :</strong></td>
					<td><strong>Rp. <span class="float-right"><?php echo number_format($total) ?></span></strong></td>
				</tr>
			</tfoot>
			<?php endif; ?>
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
				filename = filename ? filename + '.xls' : 'Laporan Sales '+ d.toDateString() +'.xls';

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
