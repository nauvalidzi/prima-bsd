<?php

namespace PHPMaker2021\distributor;

// Page object
$LaporanPembayaran = &$Page;
?>
<?php
	if(isset($_POST['srhDate'])) {
		$dateFrom = !empty($_POST['dateFrom']) ? $_POST['dateFrom'] : date('Y-m-01');
		$dateTo = !empty($_POST['dateTo']) ? $_POST['dateTo'] : date('Y-m-t');
		
		$query = "SELECT pembayaran.id, pembayaran.tanggal AS tgl_bayar, pembayaran.kode AS kode_bayar, 
					invoice.kode AS kode_invoice, customer.nama AS nama_customer, 
					pembayaran.totaltagihan, pembayaran.sisatagihan, pembayaran.jumlahbayar
				  FROM pembayaran
				  JOIN invoice ON pembayaran.idinvoice = invoice.id
				  JOIN customer ON customer.id = pembayaran.idcustomer
				  WHERE pembayaran.tanggal BETWEEN '{$dateFrom}' AND '{$dateTo}'
				  ORDER BY pembayaran.id ASC";

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
				</ul>
			</div>
		</form>
	</div>
	<div class="row">
	    <?php if(isset($_POST['srhDate'])) : ?>
	    <table class="table ew-table table-bordered">
		  <thead>
		    <tr>
		        <th class="text-center">No</th>
		        <th>Tgl. Bayar</th>
		        <th>Kode Bayar</th>
		        <th>Kode Invoice</th>
		        <th>Customer</th>
		        <th class="text-center">Total Tagihan</th>
		        <th class="text-center">Sisa Tagihan</th>
		        <th class="text-center">Jumlah Bayar</th>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php if (!empty($result)): ?>
			  	<?php $i = 1; $ext = ['totaltagihan' => 0, 'sisatagihan' => 0, 'jumlahbayar' => 0]; ?>
			    <?php foreach($result as $row): ?>
			    <tr>
			      <td class="text-center"><?php echo $i?></td>
			      <td><?php echo tgl_indo($row['tgl_bayar']) ?></td>
			      <td><?php echo $row['kode_bayar'] ?></td>
			      <td><?php echo $row['kode_invoice'] ?></td>
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
	    			<td colspan="8" class="text-center">Tidak ada data.</td>
	    		</tr>
	    	<?php endif; ?>
		  </tbody>
	  	  <?php if (!empty($result)): ?>
		  <tfoot>
		  	<tr>
		  		<th colspan="5" class="text-right">Grand Total :</th>
		  		<th>Rp. <span class="float-right"><?php echo number_format($ext['totaltagihan'], 2, ",", ".") ?></span></th>
		  		<th>Rp. <span class="float-right"><?php echo number_format($ext['sisatagihan'], 2, ",", ".") ?></span></th>
		  		<th>Rp. <span class="float-right"><?php echo number_format($ext['jumlahbayar'], 2, ",", ".") ?></span></th>
		  	</tr>
		  </tfoot>
		  <?php endif; ?>
		</table>
		<?php endif; ?>
	</div>
</div>

<?= GetDebugMessage() ?>
