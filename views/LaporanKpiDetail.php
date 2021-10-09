<?php

namespace PHPMaker2021\distributor;

// Page object
$LaporanKpiDetail = &$Page;
?>
<?php
    $id = !empty(Get('mr')) ? Get("mr") : die ;

    $mr = ExecuteRow("SELECT kode, nama FROM pegawai WHERE id = {$id}");

    $query = "SELECT GROUP_CONCAT(DISTINCT o.id) AS idorder,
				GROUP_CONCAT(DISTINCT o.kode) AS kodepo, 
				IFNULL(GROUP_CONCAT(DISTINCT d.kode),'-') AS kodedo,
				c.nama AS customers,
				b.title AS brands,
				p.id AS idproduk, 
				p.nama AS namaproduk,
				SUM(od.jumlah) AS jumlahorder, 
				SUM(od.bonus) AS bonus, 
				SUM(od.sisa) as sisa, 
				SUM(od.total) AS totaltagihan,
				SUM(i.sisabayar) AS sisabayar				
			  FROM product p
			  JOIN order_detail od ON p.id = od.idproduct
			  JOIN `order` o ON o.id = od.idorder
			  JOIN customer c ON c.id = o.idcustomer
			  JOIN brand b ON p.idbrand = b.id
			  LEFT JOIN invoice i ON i.idorder = o.id
			  LEFT JOIN deliveryorder_detail dt ON dt.idorder = o.id
			  LEFT JOIN deliveryorder d ON d.id = dt.iddeliveryorder
			  WHERE o.idpegawai = {$id}
			  GROUP BY od.idproduct, b.id, c.id";

    $results = ExecuteQuery($query)->fetchAll();
?>
<style>
	.col-flex {
		width: 175px;
		min-width: 175px;
		max-width: 175px;
	}
	.col-description {
		width: 300px;
		min-width: 300px;
		max-width: 300px;
	}
</style>
<div class="container">
	<table class="table table-bordered">
		<thead>
			<tr>
				<th colspan="10">Marketing: <?php echo $mr['kode'] . ' - ' . $mr['nama'] ?></th>
			</tr>
			<tr>
				<th class="col-flex">Kode P.O.</th>
				<th class="col-flex">Kode D.O.</th>
				<th class="col-flex">Brand</th>
				<th class="col-description">Produk</th>
				<th class="col-flex">Jumlah Order</th>
				<th class="col-flex">Bonus</th>
				<th class="col-flex">Sisa</th>
				<th class="col-flex">Total Tagihan</th>
				<th class="col-flex">Sisa Bayar</th>
			</tr>
		</thead>
		<tbody>
		<?php if (count($results) > 0): ?>
			<?php $total = ['tagihan' => 0, 'sisabayar' => 0]; ?>
			<?php foreach ($results as $row) : ?>
			<?php $sisabayar = ($row['sisabayar'] == null) ? $row['totaltagihan'] : $row['sisabayar'] ?>
			<tr>
				<td><?php echo $row['kodepo'] ?></td>
				<td><?php echo $row['kodedo'] ?></td>
				<td><?php echo $row['brands'] ?></td>
				<td><?php echo $row['namaproduk'] ?></td>
				<td><?php echo $row['jumlahorder'] ?></td>
				<td><?php echo $row['bonus'] ?></td>
				<td><?php echo $row['sisa'] ?></td>
				<td><?php echo rupiah($row['totaltagihan']) ?></td>
				<td><?php echo rupiah($sisabayar) ?></td>
			</tr>
			<?php $total['tagihan'] += $row['totaltagihan']; $total['sisabayar'] += $sisabayar; ?>
			<?php endforeach; ?>
		<?php endif; ?>
		</tbody>
		<?php if (count($results) > 0): ?>
		<tfoot>
			<tr>
				<th colspan="7" class="text-right">Grand Total :</th>
				<th><?php echo rupiah($total['tagihan']); ?></th>
				<th><?php echo rupiah($total['sisabayar']); ?></th>
			</tr>
		</tfoot>
		<?php endif; ?>
	</table>
</div>

<?= GetDebugMessage() ?>
