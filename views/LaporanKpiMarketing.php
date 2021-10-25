<?php

namespace PHPMaker2021\distributor;

// Page object
$LaporanKpiMarketing = &$Page;
?>
<?php
	$dateFrom = date('Y-m-01', strtotime("-1 month"));
	$dateTo = date('Y-m-t', strtotime("+1 month"));

	if(isset($_POST['srhDate'])){
		$dateFrom = date('Y-m-01', strtotime($_POST['dateFrom']));
		$dateTo = date('Y-m-t', strtotime($_POST['dateTo']));

		$tgl = strtotime($dateFrom);
		$period = [];

		while($tgl <= strtotime($dateTo))
		{
			$period[] = date('M y', $tgl);
			$tgl = strtotime("+1 month", $tgl);
		}

		$query = "SELECT date_format(po.tanggal, '%b %y') as tanggal, p.id as idpegawai, p.nama AS namapegawai, 
					SUM(IFNULL(po.totalpenjualan,0)) AS totalpenjualan, IFNULL(kpi_marketing.target,0) AS target
				  FROM pegawai p
				  LEFT JOIN (
				  	SELECT idpegawai, SUM(order_detail.total) AS totalpenjualan, `order`.tanggal
					FROM `order`
					JOIN order_detail ON order_detail.idorder = `order`.id
					WHERE `order`.tanggal BETWEEN '{$dateFrom}' AND '{$dateTo}'
					GROUP BY `order`.id
				  ) po ON p.id = po.idpegawai
				  LEFT JOIN kpi_marketing ON kpi_marketing.idpegawai = p.id AND kpi_marketing.bulan = '{$dateFrom}'
				  GROUP BY p.id, kpi_marketing.target, DATE_FORMAT(po.tanggal, '%b %y')";

		$result = ExecuteQuery($query)->fetchAll();

		$data = [];

		foreach($result as $row) {
			$data[$row['idpegawai']]['idpegawai'] = $row['idpegawai'];
			$data[$row['idpegawai']]['namapegawai'] = $row['namapegawai'];
			$data[$row['idpegawai']]['order'][$row['tanggal']] = $row['totalpenjualan'];
			$data[$row['idpegawai']]['kpi_marketing'][$row['tanggal']] = $row['target'];
		}
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
						<input type="month" class="form-control input-md" name="dateFrom" value="<?php echo date('Y-m', strtotime($dateFrom)) ?>">
					</li>
					to
					<li class="d-inline-block">
						<input type="month" class="form-control input-md" name="dateTo" value="<?php echo date('Y-m', strtotime($dateTo)) ?>">
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
	
	    <table class="table table-bordered">
	    	<thead>
				<tr>
					<th colspan="<?php echo count($period) + 5 ?>" class="text-center" width="100%">
						<h4 class="my-2">Laporan KPI Marketing</h4>
						<p class="mt-3">Periode: <?php echo tgl_indo($dateFrom, 'month-year') . ' - ' . tgl_indo($dateTo, 'month-year') ?></p>
					</th>
				</tr>
	    		<tr>
	    			<th width="5%" class="text-center">No.</th>
		    		<th class="col-description" colspan="2">Marketing</th>
		    		<?php foreach($period as $date): ?>
						<th class="col-flex text-center"><?php echo date("M' y", strtotime($date)) ?></th>
					<?php endforeach; ?>
		    		<th class="col-flex text-center">Total</th>
		    		<th class="col-flex text-center">AVG</th>
	    		</tr>
	    	</thead>
	    	<tbody>
    		<?php if (!empty($result)): ?>
    			<?php $i = 1; ?>
	    		<?php foreach($data as $key => $value): ?>
	    		<tr>
	    			<td class="text-center"><?php echo $i; ?></td>
		    		<td><?php echo $value['namapegawai'] ?></td>
		    		<td>Target<br>Aktual<br>&#37;</td>
		    		<?php $subtotal = ['target' => 0, 'aktual' => 0] ?>
		    		<?php foreach($period as $date) : ?>
		    			<td class="text-center">
		    				<?php 
		    					$aktual = isset($value['order'][$date]) ? $value['order'][$date] : 0 ;
								$target = isset($value['kpi_marketing'][$date]) ? $value['kpi_marketing'][$date] : 0 ;
		    				 ?>
		    				Rp. <?php echo rupiah($target) ?><br>
		    				<a href="LaporanKpiMarketingDetail?mr=<?php echo $value['idpegawai']?>&month=<?php echo date('Y-m', strtotime($date)) ?>">Rp. <?php echo rupiah($aktual) ?></a><br>
		    				<?php echo ($aktual > 0 && $target > 0) ? round(($aktual / $target) * 100 ) : 0; ?>&#37;
		    			</td>
		    			<?php $subtotal['target'] += $target; ?>
		    			<?php $subtotal['aktual'] += $aktual; ?>
		    		<?php endforeach ?>
		    		<td class="text-center">Rp. <?php echo rupiah($subtotal['target']) ?><br>Rp. <?php echo rupiah($subtotal['aktual']) ?></td>
		    		<td class="text-center">Rp .<?php echo rupiah(round($subtotal['target'] / count($period))) ?><br>Rp. <?php echo rupiah(round($subtotal['aktual'] / count($period))) ?></td>
	    		</tr>
		    	<?php $i++; endforeach; ?>
	    	<?php else: ?>
	    		<tr>
	    			<td colspan="<?php echo count($period) + 5 ?>" class="text-center">Tidak ada data.</td>
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
				filename = filename ? filename + '.xls' : 'Laporan KPI Marketing '+ d.toDateString() +'.xls';

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

<?= GetDebugMessage() ?>
