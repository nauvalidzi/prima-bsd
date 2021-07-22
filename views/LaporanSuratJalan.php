<?php

namespace PHPMaker2021\distributor;

// Page object
$LaporanSuratJalan = &$Page;
?>
<?php
	$kolom = "tglsurat";

	if(isset($_POST['srhDate'])) {
		$dateFrom = !empty($_POST['dateFrom']) ? $_POST['dateFrom'] : date('Y-m-01');
		$dateTo = !empty($_POST['dateTo']) ? $_POST['dateTo'] : date('Y-m-t');
		$kolom = ($_POST['kolom'] == 'tglsurat') ? "suratjalan.tglsurat" : "suratjalan.tglkirim";
		
		$query = "SELECT suratjalan.kode AS kode_suratjalan, suratjalan.tglsurat, suratjalan.tglkirim, 
					GROUP_CONCAT(DISTINCT invoice.kode) AS kode_invoice,
					GROUP_CONCAT(DISTINCT `order`.kode) AS kode_po
				  FROM suratjalan
				  JOIN alamat_customer ON alamat_customer.id = suratjalan.idalamat_customer
				  JOIN suratjalan_detail ON suratjalan_detail.idsuratjalan = suratjalan.id
				  JOIN invoice ON invoice.id = suratjalan_detail.idinvoice
				  JOIN `order` ON `order`.id = invoice.idorder
				  WHERE {$kolom} BETWEEN '{$dateFrom}' AND '{$dateTo}'
				  GROUP BY suratjalan.id
				  ORDER BY suratjalan.id ASC";

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
						<label class="d-block">Berdasarkan:</label>
						<select name="kolom" class="form-control">
							<option value="tglsurat" <?php echo ($kolom == "tglsurat") ? "selected":""; ?>>Tgl. Surat</option>
							<option value="tglkirim" <?php echo ($kolom == "tglkirim") ? "selected":""; ?>>Tgl. Kirim</option>
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
		        <th>Tgl. Surat</th>
		        <th>Tgl. Kirim</th>
		        <th>Kode Surat Jalan</th>
		        <th>Kode Invoice</th>
		        <th>Kode P.O.</th>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php if (!empty($result)): ?>
			  	<?php $i = 1; $ext = ['total_kirim' => 0, 'total_sisa' => 0, 'total_po' => 0]; ?>
			    <?php foreach($result as $row): ?>
			    <tr>
			      <td class="text-center"><?php echo $i?></td>
			      <td><?php echo tgl_indo($row['tglsurat']) ?></td>
			      <td><?php echo tgl_indo($row['tglkirim']) ?></td>
			      <td><?php echo $row['kode_suratjalan'] ?></td>
			      <td><?php echo $row['kode_invoice'] ?></td>
			      <td><?php echo $row['kode_po'] ?></td>
			    </tr>
				<?php endforeach; ?>
	    	<?php else: ?>
	    		<tr>
	    			<td colspan="8" class="text-center">Tidak ada data.</td>
	    		</tr>
	    	<?php endif; ?>
		  </tbody>
		</table>
		<?php endif; ?>
	</div>
</div>

<?= GetDebugMessage() ?>
