<?php

namespace PHPMaker2021\distributor;

// Page object
$LaporanPembayaran = &$Page;
?>
<?php
	$dateFrom = date('Y-m-01');
	$dateTo = date('Y-m-t');

	if(isset($_POST['srhDate'])) {
		$dateFrom = date('Y-m-d', strtotime($_POST['dateFrom']));
		$dateTo = date('Y-m-d', strtotime($_POST['dateTo']));
		
		$query = "SELECT p.id, p.tanggal AS tgl_bayar, p.kode AS kode_bayar, 
					i.kode AS kode_invoice, o.kode AS kode_order, c.nama AS nama_customer, 
					p.totaltagihan, p.sisatagihan, p.jumlahbayar
				  FROM pembayaran p
				  JOIN invoice i ON p.idinvoice = i.id
				  JOIN customer c ON c.id = p.idcustomer
				  JOIN `order` o ON o.id = i.idorder
				  WHERE p.tanggal BETWEEN '{$dateFrom}' AND '{$dateTo}'
				  ORDER BY p.id ASC";

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
					<h4 class="my-2">Laporan Pembayaran</h4>
					<p class="mt-3">Periode: <?php echo tgl_indo($dateFrom) . ' - ' . tgl_indo($dateTo) ?></p>
				</th>
			</tr>
		    <tr>
		        <th class="text-center">No</th>
		        <th class="text-center col-flex">Tgl. Bayar</th>
		        <th class="text-center col-flex">Kode Bayar</th>
		        <th class="text-center col-flex">Kode Invoice</th>
		        <th class="text-center col-flex">Kode Order</th>
		        <th class="text-center col-description">Nama Pelanggan</th>
		        <th class="text-center col-description">Total Tagihan</th>
		        <th class="text-center col-description">Sisa Tagihan</th>
		        <th class="text-center col-description">Jumlah Bayar</th>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php if (!empty($result)): ?>
			  	<?php $i = 1; $ext = ['totaltagihan' => 0, 'sisatagihan' => 0, 'jumlahbayar' => 0]; ?>
			    <?php foreach($result as $row): ?>
			    <tr>
			      <td class="text-center"><?php echo $i?></td>
			      <td class="text-center"><?php echo tgl_indo($row['tgl_bayar']) ?></td>
			      <td class="text-center"><?php echo $row['kode_bayar'] ?></td>
			      <td class="text-center"><?php echo $row['kode_invoice'] ?></td>
			      <td class="text-center"><?php echo $row['kode_order'] ?></td>
			      <td><?php echo $row['nama_customer'] ?></td>
			      <td>Rp. <span class="float-right"><?php echo number_format($row['totaltagihan'], 2, ",", ".") ?></span></td>
			      <td>Rp. <span class="float-right"><?php echo number_format($row['sisatagihan'], 2, ",", ".") ?></span></td>
			      <td>Rp. <span class="float-right"><?php echo number_format($row['jumlahbayar'], 2, ",", ".") ?></span></td>
			    </tr>
			    <?php
			    	$ext['totaltagihan'] += $row['totaltagihan'];
					$ext['sisatagihan'] += $row['sisatagihan'];
					$ext['jumlahbayar'] += $row['jumlahbayar'];
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
		  		<th colspan="6" class="text-right">Grand Total :</th>
		  		<th>Rp. <span class="float-right"><?php echo number_format($ext['totaltagihan'], 2, ",", ".") ?></span></th>
		  		<th>Rp. <span class="float-right"><?php echo number_format($ext['sisatagihan'], 2, ",", ".") ?></span></th>
		  		<th>Rp. <span class="float-right"><?php echo number_format($ext['jumlahbayar'], 2, ",", ".") ?></span></th>
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
				filename = filename ? filename + '.xls' : 'Laporan Pembayaran '+ d.toDateString() +'.xls';

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
