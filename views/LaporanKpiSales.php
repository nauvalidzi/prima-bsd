<?php

namespace PHPMaker2021\distributor;

// Page object
$LaporanKpiSales = &$Page;
?>
<?php
	$dateFrom = date('Y-m-01');
	$dateTo = date('Y-m-t');

	if(isset($_POST['srhDate'])){
		$dateFrom = date('Y-m-d', strtotime($_POST['dateFrom']));
		$dateTo = date('Y-m-d', strtotime($_POST['dateTo']));

		$query = "SELECT c.kode AS kode_customer, c.nama AS nama_customer,
					pg.nama AS nama_pegawai,
					GROUP_CONCAT(DISTINCT o.kode) AS kode_po, 
					IFNULL(GROUP_CONCAT(DISTINCT d.kode),'-') AS kode_do,
					b.title AS brands,
					p.id AS idproduk,
					p.nama AS nama_produk, 
					SUM(od.jumlah) AS jumlahorder, 
					SUM(od.bonus) AS bonus, 
					SUM(od.sisa) AS sisa, 
					SUM(od.total) AS totaltagihan,
					 SUM(i.sisabayar) AS sisabayar
				  FROM product p
				  JOIN order_detail od ON p.id = od.idproduct
				  JOIN `order` o ON o.id = od.idorder
				  JOIN pegawai pg ON pg.id = o.idpegawai
				  JOIN customer c ON c.id = o.idcustomer
				  JOIN brand b ON p.idbrand = b.id
				  LEFT JOIN invoice i ON i.idorder = o.id
				  LEFT JOIN deliveryorder_detail dt ON dt.idorder = o.id
				  LEFT JOIN deliveryorder d ON d.id = dt.iddeliveryorder
				  WHERE o.tanggal BETWEEN  '{$dateFrom}' AND '{$dateTo}'
				  GROUP BY od.idproduct, b.id, c.id, pg.id";

		$results = ExecuteQuery($query)->fetchAll();
	}
?>
<style>
	.col-flex {
		width: 175px;
		min-width: 175px;
		max-width: 175px;
	}
	.col-description {
		width: 225px;
		min-width: 225px;
		max-width: 225px;
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
    <?php if(isset($_POST['srhDate'])) : ?>
	<div id="printTable">
	    <table class="table table-bordered">
	    	<thead>
				<tr>
					<th colspan="13" class="text-center" width="100%">
						<h4 class="my-2">Laporan KPI Sales</h4>
						<p class="mt-3">Periode: <?php echo tgl_indo($dateFrom) . ' - ' . tgl_indo($dateTo) ?></p>
					</th>
				</tr>
	    		<tr>
	    			<th class="text-center" width="3%">No. </th>
	    			<th class="text-center col-flex">Kode Pelanggan</th>
					<th class="text-center col-flex">Kode Pelanggan</th>
					<th class="text-center col-flex">Nama Pegawai</th>
					<th class="text-center col-description">No. PO</th>
					<th class="text-center col-description">No. Delivery</th>
					<th class="text-center col-flex">Brand</th>
					<th class="text-center col-description	">Produk</th>
					<th class="text-center col-flex">Jumlah</th>
					<th class="text-center col-flex">Bonus</th>
					<th class="text-center col-flex">Jumlah Sisa Kirim</th>
					<th class="text-center col-flex">Total Tagihan</th>
					<th class="text-center col-flex">Sisa Bayar</th>
	    		</tr>
	    	</thead>
	    	<tbody>
    		<?php if (!empty($results)): ?>
    			<?php $i = 1; ?>
	    		<?php foreach($results as $row): ?>
    			<?php $sisabayar = ($row['sisabayar'] == null) ? $row['totaltagihan'] : $row['sisabayar'] ?>
	    		<tr>
	    			<td class="text-center"><?php echo $i; ?></td>
		    		<td><?php echo $row['kode_customer'] ?></td>
		    		<td><?php echo $row['nama_customer'] ?></td>
		    		<td><?php echo $row['nama_pegawai'] ?></td>
		    		<td><?php echo $row['kode_po'] ?></td>
		    		<td><?php echo $row['kode_do'] ?></td>
		    		<td><?php echo $row['brands'] ?></td>
		    		<td><?php echo $row['nama_produk'] ?></td>
		    		<td class="text-center"><?php echo $row['jumlahorder'] ?></td>
		    		<td class="text-center"><?php echo $row['bonus'] ?></td>
		    		<td class="text-center"><?php echo $row['sisa'] ?></td>
					<td>Rp. <span class="float-right"><?php echo rupiah($row['totaltagihan']) ?></span></td>
					<td>Rp. <span class="float-right"><?php echo rupiah($sisabayar) ?></span></td>
	    		</tr>
		    	<?php $i++; endforeach; ?>
	    	<?php else: ?>
	    		<tr>
	    			<td colspan="13" class="text-center">Tidak ada data.</td>
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
				filename = filename ? filename + '.xls' : 'Laporan KPI Sales '+ d.toDateString() +'.xls';

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
	</div>
	<?php endif; ?>
</div>

<?= GetDebugMessage() ?>
