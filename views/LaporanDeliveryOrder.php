<?php

namespace PHPMaker2021\distributor;

// Page object
$LaporanDeliveryOrder = &$Page;
?>
<?php
	$status_selected = "all";
	$status = null;

	if(isset($_POST['srhDate'])){
		$dateFrom = !empty($_POST['dateFrom']) ? $_POST['dateFrom'] : date('Y-m-01');
		$dateTo = !empty($_POST['dateTo']) ? $_POST['dateTo'] : date('Y-m-t');
		
		if ($_POST['status'] == 'lunas') {
			$status = " AND jumlahkirim = sisa";
			$status_selected = "lunas";
		}

		if ($_POST['status'] == 'sisa') {
			$status = " AND jumlahkirim != sisa";
			$status_selected = "sisa";
		}

		$query = "SELECT deliveryorder.id as do_id, deliveryorder.kode as kode_do, deliveryorder.tanggal, 
					GROUP_CONCAT(DISTINCT deliveryorder_detail.kode_po) AS kode_po,
					SUM(`deliveryorder_detail`.`jumlahkirim`) AS jumlah_kirim,
					SUM(`deliveryorder_detail`.`sisa`) AS jumlah_sisa
				  FROM `deliveryorder`
				  JOIN (
				  	SELECT kode AS kode_po, deliveryorder_detail.readonly,
				  		deliveryorder_detail.jumlahkirim, deliveryorder_detail.sisa,
						deliveryorder_detail.iddeliveryorder
					FROM `order`
					JOIN deliveryorder_detail ON deliveryorder_detail.idorder = `order`.id
				  ) deliveryorder_detail ON deliveryorder_detail.iddeliveryorder = deliveryorder.id
				  WHERE deliveryorder.tanggal BETWEEN '{$dateFrom}' AND '{$dateTo}' {$status}
				  GROUP BY deliveryorder.id
				  ORDER BY deliveryorder.tanggal ASC";

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
						<label class="d-block">Status D.O:</label>
						<select name="status" class="form-control">
							<option value="all" <?php echo ($status_selected == "all") ? "selected":""; ?>>-- All --</option>
							<option value="lunas" <?php echo ($status_selected == "lunas") ? "selected":""; ?>>Lunas</option>
							<option value="sisa" <?php echo ($status_selected == "sisa") ? "selected":""; ?>>Sisa</option>
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
		        <th>No</th>
		        <th>Tanggal</th>
		        <th>Kode D.O</th>
		        <th>Kode P.O.</th>
		        <th class="text-center">Jumlah Kirim</th>
			    <?php if ($_POST['status'] == "all" || $_POST['status'] == "sisa") : ?>
		        <th class="text-center">Sisa</th>
			    <?php endif; ?>
		        <?php if ($_POST['status'] == "all") : ?>
		        <th>Status</th>
			    <?php endif; ?>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php if (!empty($result)): ?>
			  	<?php $ext = ['total_kirim' => 0, 'total_sisa' => 0, 'total_po' => 0]; $i = 1; ?>
			    <?php foreach($result as $row) : ?>
			    <?php $status = $row['jumlah_kirim'] == $row['jumlah_sisa'] ? 'Lunas' : 'Sisa'; ?>
			    <?php $sisa = $row['jumlah_sisa'] - $row['jumlah_kirim']; ?>
			    <tr>
			      <td><?php echo $i?></td>
			      <td><?php echo tgl_indo($row['tanggal']) ?></td>
			      <td><a href="DeliveryorderDetailList?showmaster=deliveryorder&fk_id=<?php echo $row['do_id'] ?>" target="_blank"><?php echo $row['kode_do'] ?></a></td>
			      <td><?php echo $row['kode_po'] ?></td>
			      <td class="text-center"><?php echo $row['jumlah_kirim'] ?></td>
			      <?php if ($_POST['status'] == "all" || $_POST['status'] == "sisa") : ?>
			      <td class="text-center"><?php echo $sisa ?></td>
				  <?php endif; ?>
			      <?php if ($_POST['status'] == "all") : ?>
			      <td><?php echo $status ?></td>
				  <?php endif; ?>
			    </tr>
			    <?php 
			    	$ext['total_kirim'] += $row['jumlah_kirim'];
			    	$ext['total_sisa'] += $sisa;
			    	$ext['total_po'] += count(explode(',', $row['kode_po']));
			     ?>
			    <?php $i++; endforeach;?>
	    	<?php else: ?>
	    		<tr>
	    			<td colspan="8" class="text-center">Tidak ada data.</td>
	    		</tr>
	    	<?php endif; ?>
		  </tbody>
		  <?php if (!empty($result)): ?>
		  <tfoot>
		  	<th class="text-right" colspan="3">Grand Total :</th>
		  	<th><?php echo $ext['total_po'] ?></th>
		  	<th class="text-center"><?php echo number_format($ext['total_kirim'], 0, ",", ".") ?></th>
			<?php if ($_POST['status'] == "all" || $_POST['status'] == "sisa") : ?>
		  	<th class="text-center"><?php echo number_format($ext['total_sisa'], 0, ",", ".") ?></th>
		  	<?php endif; ?>
		  </tfoot>
		  <?php endif; ?>
		</table>
		<?php endif; ?>
	</div>
</div>

<?= GetDebugMessage() ?>
