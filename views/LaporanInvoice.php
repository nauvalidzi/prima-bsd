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

	if(isset($_POST['srhDate'])){
		$dateFrom = !empty($_POST['dateFrom']) ? $_POST['dateFrom'] : date('Y-m-01');
		$dateTo = !empty($_POST['dateTo']) ? $_POST['dateTo'] : date('Y-m-t');

		if ($_POST['status'] == 'paid') {
			$status = " AND invoice.aktif = 0";
			$status_selected = "paid";
		}

		if ($_POST['status'] == 'unpaid') {
			$status = " AND invoice.aktif = 1";
			$status_selected = "unpaid";
		}

		$tipepayment = ($_POST['payment'] != "all") ? " AND idtipepayment = ".$_POST['payment'] : "";

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
							<option value="paid" <?php echo ($status_selected == "paid") ? "selected":""; ?>>Lunas</option>
							<option value="unpaid" <?php echo ($status_selected == "unpaid") ? "selected":""; ?>>Belum Lunas</option>
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
				</ul>
			</div>
		</form>
	</div>
	<div class="row">
	    <?php if(isset($_POST['srhDate'])) : ?>
	    <table class="table ew-table table-bordered">
	    	<thead>
	    		<tr>
	    			<th>No.</th>
		    		<th>Tgl Invoice</th>
		    		<th>Kode</th>
		    		<th>Kode P.O.</th>
		    		<th class="text-center">Total Tagihan</th>
		    		<th class="text-center">Sisa Bayar</th>
		    		<?php if ($_POST['payment'] == "all"): ?>
		    		<th class="text-center">Pembayaran</th>
			    	<?php endif; ?>
		    		<?php if ($status_selected == "all"): ?>
		    		<th>Status</th>
			    	<?php endif; ?>
	    		</tr>
	    	</thead>
	    	<tbody>
    		<?php if (!empty($result)): ?>
    			<?php $i = 1; $ext = ['totaltagihan' => 0, 'sisabayar' => 0]; ?>
	    		<?php foreach($result as $row): ?>
	    		<?php $status = $row['aktif'] != 0 ? 'Lunas' : 'Belum Lunas'; ?>
	    		<tr>
	    			<td><?php echo $i; ?></td>
		    		<td><?php echo tgl_indo($row['tglinvoice']) ?></td>
		    		<td><?php echo $row['kode_invoice'] ?></td>
		    		<td><?php echo $row['kode_po'] . ', ' . $row['nama_customer'] ?></td>
		    		<td>Rp. <span class="float-right"><?php echo number_format($row['totaltagihan'], 2, ",", ".") ?></span></td>
		    		<td>Rp. <span class="float-right"><?php echo number_format($row['sisabayar'], 2, ",", ".") ?></span></td>
		    		<?php if ($_POST['payment'] == "all"): ?>
		    		<td class="text-center"><?php echo $row['payment'] ?></td>
			    	<?php endif; ?>
		    		<?php if ($status_selected == "all"): ?>
		    		<td><?php echo $status ?></td>
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
		<?php endif; ?>
	</div>
</div>

<?= GetDebugMessage() ?>
