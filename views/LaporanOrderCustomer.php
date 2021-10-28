<?php

namespace PHPMaker2021\distributor;

// Page object
$LaporanOrderCustomer = &$Page;
?>
<?php
	$dateFrom = date('Y-m-01');
	$dateTo = date('Y-m-t');
	$listmarketing = ExecuteQuery("SELECT id, kode, nama FROM pegawai ORDER BY id ASC")->fetchAll();

	if(isset($_POST['srhDate'])) {
		$dateFrom = date('Y-m-d', strtotime($_POST['dateFrom']));
		$dateTo = date('Y-m-d', strtotime($_POST['dateTo']));

		$marketing = null;
		if ($_POST['marketing'] != "all") {
			$marketing = " AND o.idpegawai = {$_POST['marketing']}";
		}
		
		$query = "SELECT c.kode AS kode_customer, c.nama AS nama_customer, o.kode AS kode_po, 
					DATE_FORMAT(o.tanggal, '%Y-%m-%d') AS tgl_po, 
					p.kode AS kode_produk, p.nama AS nama_produk, b.title AS brand,
					od.jumlah AS jumlah_po, p.kemasanbarang AS kemasan, od.harga AS harga_satuan,
					i.kode as no_faktur, od.total AS nilai_po, i.diskonpayment AS diskon, 
					i.totaltagihan AS nilai_faktur, pg.nama AS marketing,
					DATE_FORMAT(i.due_date, '%Y-%m-%d') AS due_date
				  FROM `order` o
				  JOIN customer c ON c.id = o.idcustomer
				  JOIN order_detail od ON od.idorder = o.id
				  JOIN product p ON p.id = od.idproduct
				  JOIN pegawai pg ON pg.id = o.idpegawai
				  LEFT JOIN brand b ON b.id = p.idbrand
				  LEFT JOIN (
					SELECT i.idorder, i.tglinvoice, i.kode, id.diskonpayment, id.totaltagihan, 
							id.idorder_detail, (i.tglinvoice + INTERVAL t.`value` DAY) AS due_date
					FROM invoice i
					JOIN termpayment t ON t.id = i.idtermpayment
					JOIN invoice_detail id ON i.id = id.idinvoice
				  ) i ON i.idorder = o.id AND i.idorder_detail = od.id
				  WHERE o.tanggal BETWEEN '{$dateFrom}' AND '{$dateTo}' {$marketing}
				  ORDER BY o.kode, o.tanggal ASC";

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
				<th colspan="17" class="text-center">
					<h4 class="my-2">Laporan Order Customer</h4>
					<p class="mt-3">Periode: <?php echo ($dateFrom == $dateTo) ? tgl_indo($dateFrom) : tgl_indo($dateFrom) . ' - ' . tgl_indo($dateTo) ?></p>
				</th>
			</tr>
		    <tr>
		        <th class="text-center">No</th>
		        <th class="text-center col-flex">Kode Customer</th>
		        <th class="text-center col-description">Nama Customer</th>
		        <th class="text-center col-flex">Tgl P.O.</th>
		        <th class="text-center col-flex">Kode P.O.</th>
		        <th class="text-center col-flex">Kode Produk</th>
		        <th class="text-center col-description">Nama Produk</th>
		        <th class="text-center col-flex">Brand</th>
		        <th class="text-center col-flex">Jumlah P.O.</th>
		        <th class="text-center col-flex">Kemasan</th>
		        <th class="text-center col-flex">Harga Satuan</th>
		        <th class="text-center col-flex">No. Faktur</th>
		        <th class="text-center col-flex">Nilai P.O.</th>
		        <th class="text-center col-flex">Diskon &#37;</th>
		        <th class="text-center col-flex">Nilai Faktur</th>
		        <th class="text-center col-flex">Marketing</th>
		        <th class="text-center col-flex">Due Date</th>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php if (!empty($result)): ?>
			  	<?php $i = 0; $kode_po = ""; ?>
			    <?php foreach($result as $row): ?>
			    <?php if ($kode_po != $row['kode_po']) $i++; ?>
			    <tr>
			      <td class="text-center"><?php echo $i; ?></td>
			      <td><?php echo $row['kode_customer'] ?></td>
			      <td><?php echo $row['nama_customer'] ?></td>
			      <td class="text-center"><?php echo tgl_indo($row['tgl_po']) ?></td>
			      <td><?php echo $row['kode_po'] ?></td>
			      <td><?php echo $row['kode_produk'] ?></td>
			      <td><?php echo $row['nama_produk'] ?></td>
			      <td><?php echo $row['brand'] ?></td>
			      <td class="text-center"><?php echo $row['jumlah_po'] ?></td>
			      <td><?php echo $row['kemasan'] ?></td>
			      <td>Rp. <span class="float-right"><?php echo number_format($row['harga_satuan'], 2, ",", ".") ?></span></td>
			      <td><?php echo ($row['no_faktur'] != null) ? $row['no_faktur'] : '-' ?></td>
			      <td>Rp. <span class="float-right"><?php echo number_format($row['nilai_po'], 2, ",", ".") ?></span></td>
			      <td class="text-center"><?php echo ($row['diskon'] != null) ? $row['diskon'] . '&#37;' : '-' ?></td>
			      <td><?php echo ($row['nilai_faktur'] != null) ? "Rp. <span class=\"float-right\">".number_format($row['nilai_faktur'], 2, ',', '.')."</span>" : "-" ?></td>
			      <td class="text-center"><?php echo $row['marketing'] ?></td>
			      <td class="text-center"><?php echo ($row['due_date'] != null) ? tgl_indo($row['due_date']) : '-' ?></td>
			    </tr>
			    <?php $kode_po = $row['kode_po']; ?>
				<?php endforeach; ?>
	    	<?php else: ?>
	    		<tr>
	    			<td colspan="8" class="text-center">Tidak ada data.</td>
	    		</tr>
	    	<?php endif; ?>
		  </tbody>
		</table>
		<script>
			function exportTableToExcel(tableID, filename = '') {
				var downloadLink;
				var dataType = 'data:application/vnd.ms-excel';
				var tableSelect = document.getElementById(tableID);
				var tableHTML = encodeURIComponent(tableSelect.outerHTML);
				var d = new Date();

				// Specify file name
				filename = filename ? filename + '.xls' : 'Laporan Order Customer <?php echo ($dateFrom == $dateTo) ? date('d-m-Y', strtotime($dateFrom)) : date('d-m-Y', strtotime($dateFrom)) . ' - ' . date('d-m-Y', strtotime($dateTo)) ?>.xls';

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
