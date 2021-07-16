<?php

namespace PHPMaker2021\distributor;

// Page object
$LaporanPurchaseOrder = &$Page;
?>
<?php
	if(isset($_POST['srhDate'])){
		$dateFrom = !empty($_POST['dateFrom']) ? $_POST['dateFrom'] : date('Y-m-01');
		$dateTo = !empty($_POST['dateTo']) ? $_POST['dateTo'] : date('Y-m-t');
		$status = ($_POST['status'] == 'processed') ? " AND `order`.`readonly` = 1" : " AND `order`.`readonly` = 0";

		$query = "SELECT `order`.`kode`, `order`.`tanggal`, `customer`.`nama` as nama_customer, `pegawai`.`nama` as nama_pegawai,
					SUM(`order_detail`.`jumlah`) AS jumlah_po
				  FROM `order` 
				  JOIN customer ON `customer`.`id` = `order`.`idcustomer`
				  JOIN pegawai ON `pegawai`.`id` = `order`.`idpegawai`
				  JOIN order_detail ON `order`.`id` = `order_detail`.`idorder`
				  WHERE tanggal BETWEEN '{$dateFrom}' AND '{$dateTo}' {$status}
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
						<label class="d-block">Status P.O:</label>
						<select name="status" class="form-control">
							<option value="unprocess">Belum Diproses</option>
							<option value="processed">Telah Diproses</option>
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
	    <table class="table">
		  <thead>
		    <tr>
		        <th>No</th>
		        <th>Kode</th>
		        <th>Tanggal</th>
		        <th>Customer</th>
		        <th>Jumlah P.O.</th>
		        <th>Pegawai</th>
		    </tr>
		  </thead>
		  <tbody>
		    <?php  
		    $i = 1;
		    foreach($result as $row) :
		    ?>
		    <tr>
		      <td><?php echo $i?></td>
		      <td><?php echo $row['kode'] ?></td>
		      <td><?php echo tgl_indo($row['tanggal']) ?></td>
		      <td><?php echo $row['nama_customer'] ?></td>
		      <td><?php echo $row['jumlah_po'] ?></td>
		      <td><?php echo $row['nama_pegawai'] ?></td>
		    </tr>
		    <?php 
		    $i++;
		    endforeach;
		    ?>
		  </tbody>
		</table>
		<?php endif; ?>
	</div>
</div>

<?= GetDebugMessage() ?>
