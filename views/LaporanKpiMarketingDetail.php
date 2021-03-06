<?php

namespace PHPMaker2021\production2;

// Page object
$LaporanKpiMarketingDetail = &$Page;
?>
<?php
    $id = !empty(Get('mr')) ? Get("mr") : die ;

    $month = !empty(Get('month')) ? Get('month') : date('Y-m');

    $dateFrom = date('Y-m-01', strtotime($month));
    $dateTo = date('Y-m-t', strtotime($month));

    $mr = ExecuteRow("SELECT kode, nama FROM pegawai WHERE id = {$id}");

    $query = "SELECT o.id as idorder,
				o.kode AS kode_po, 
				c.kode AS kode_pelanggan,
				c.nama AS nama_pelanggan,
				SUM(od.jumlah) AS jumlahorder, 
				SUM(od.bonus) AS bonus, 
				SUM(od.sisa) as sisa, 
				SUM(od.total) AS totaltagihan,
				IFNULL(SUM(p.jumlahbayar),0) AS jumlahbayar,
				IFNULL(SUM(i.sisabayar),0) AS sisabayar
				FROM `order` o
				JOIN order_detail od ON o.id = od.idorder
				JOIN customer c ON c.id = o.idcustomer
				LEFT JOIN invoice i ON i.idorder = o.id
				LEFT JOIN pembayaran p ON p.idinvoice = i.id
				WHERE o.idpegawai = {$id} AND o.tanggal BETWEEN '{$dateFrom}' AND '{$dateTo}'
				GROUP BY o.id";

    $results = ExecuteQuery($query)->fetchAll();
?>
<style>
	.col-1 {
		width: 100px;
		min-width: 100px;
		max-width: 100px;
	}
	.col-2 {
		width: 200px;
		min-width: 200px;
		max-width: 200px;
	}
</style>
<div class="container">
	<li class="d-inline-block mb-2">
		<button type="button" class="btn btn-info btn-md p-2" onclick="exportTableToExcel('printTable')"><i class="mr-2 far fa-file-excel"></i>Export to Excel</button>
	</li>
	<table class="table table-bordered" id="printTable">
		<thead>
			<tr>
				<th colspan="10" class="text-center">
					<h4 class="my-2">Laporan KPI Detail Marketing (<?php echo $mr['kode'] . ' - ' . $mr['nama'] ?>)</h4>
					<p class="mt-3">Periode: <?php echo tgl_indo($month, 'month-year') ?></p>
				</th>
			</tr>
			<tr>
				<th width="3%" class="text-center">No.</th>
				<th class="text-center col-1">Kode P.O.</th>
				<th class="text-center col-1">Kode Pelanggan</th>
				<th class="text-center col-2">Nama Pelanggan</th>
				<th class="text-center col-1">Jumlah Order</th>
				<th class="text-center col-1">Bonus</th>
				<th class="text-center col-1">Sisa</th>
				<th class="text-center col-2">Total Tagihan</th>
				<th class="text-center col-2">Jumlah Bayar</th>
				<th class="text-center col-2">Sisa Bayar</th>
			</tr>
		</thead>
		<tbody>
		<?php if (count($results) > 0): ?>
			<?php 
				$i=0;
				$total = ['jumlahorder' => 0, 'bonus' => 0, 'sisa' => 0, 'totaltagihan' => 0, 'jumlahbayar' => 0, 'sisabayar' => 0]; 
			?>
			<?php foreach ($results as $row) : ?>
			<tr>
				<td class="text-center"><?php echo $i+1; ?></td>
				<td><?php echo $row['kode_po'] ?></td>
				<td><?php echo $row['kode_pelanggan'] ?></td>
				<td><?php echo $row['nama_pelanggan'] ?></td>
				<td class="text-center"><?php echo $row['jumlahorder'] ?></td>
				<td class="text-center"><?php echo $row['bonus'] ?></td>
				<td class="text-center"><?php echo $row['sisa'] ?></td>
				<td>Rp. <span class="float-right"><?php echo rupiah($row['totaltagihan']) ?></span></td>
				<td>Rp. <span class="float-right"><?php echo rupiah($row['jumlahbayar']) ?></span></td>
				<td>Rp. <span class="float-right"><?php echo rupiah($row['sisabayar']) ?></span></td>
			</tr>
			<?php 
				$total['jumlahorder'] += $row['jumlahorder']; 
				$total['bonus'] += $row['bonus']; 
				$total['sisa'] += $row['sisa']; 
				$total['totaltagihan'] += $row['totaltagihan']; 
				$total['jumlahbayar'] += $row['jumlahbayar'];
				$total['sisabayar'] += $row['sisabayar']; 
			?>
			<?php $i++; endforeach; ?>
		<?php endif; ?>
		</tbody>
		<?php if (count($results) > 0): ?>
		<tfoot>
			<tr>
				<th colspan="4" class="text-right">Grand Total :</th>
				<th class="text-center"><?php echo rupiah($total['jumlahorder'], 'without-decimal'); ?></th>
				<th class="text-center"><?php echo rupiah($total['bonus'], 'without-decimal'); ?></th>
				<th class="text-center"><?php echo rupiah($total['sisa'], 'without-decimal'); ?></th>
				<th>Rp. <span class="float-right"><?php echo rupiah($total['totaltagihan']); ?></span></th>
				<th>Rp. <span class="float-right"><?php echo rupiah($total['jumlahbayar']); ?></span></th>
				<th>Rp. <span class="float-right"><?php echo rupiah($total['sisabayar']); ?></span></th>
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
			filename = filename ? filename + '.xls' : 'Laporan KPI Marketing Detail (<?php echo $mr['kode'] . ' - ' . $mr['nama'] ?>) '+ d.toDateString() +'.xls';

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

<?= GetDebugMessage() ?>
