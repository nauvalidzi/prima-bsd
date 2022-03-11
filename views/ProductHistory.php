<?php

namespace PHPMaker2021\production2;

// Page object
$ProductHistory = &$Page;
?>
<?php 
	$idproduct = !empty(Get('product')) ? Get("product") : die ; 

	$product = ExecuteRow("SELECT p.kode, p.nama FROM product p WHERE id = {$idproduct}");

	$history = ExecuteQuery("SELECT prop_id, prop_code, stok_masuk, stok_keluar, stok_akhir FROM stocks WHERE aktif = 1 AND idproduct = {$idproduct} ORDER BY id ASC")->fetchAll();

	$laststok = ExecuteRow("SELECT stok_akhir FROM stocks WHERE idproduct = {$idproduct} AND id IN (SELECT MAX(id) FROM stocks GROUP BY idproduct)")['stok_akhir'];
?>

<div class="row">
	<div class="col-12 table-responsive">
		<table class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th colspan="7"><h5><?php echo $product['kode'] . ', '.$product['nama'] ?></h5></th>
				</tr>
				<tr>
					<th class="text-center">No.</th>
					<th class="text-center">Jenis</th>
					<th class="text-center">Stok Masuk</th>
					<th class="text-center">Stok Keluar</th>
					<th class="text-center">Stok Akhir</th>
					<th>Keterangan</th>
				</tr>
			</thead>
			<tbody>
				<?php if (count($history) > 0) : ?>
					<?php $no=0; foreach ($history as $row) : ?>
					<tr>
						<td class="text-center"><?php echo $no+1; ?></td>
						<td class="text-center"><?php echo $row['stok_masuk'] > 0 ? 'Debet' : 'Kredit'; ?></td>
						<td class="text-center"><?php echo $row['stok_masuk'] ?></td>
						<td class="text-center"><?php echo $row['stok_keluar'] ?></td>
						<td class="text-center"><?php echo $row['stok_akhir'] ?></td>
						<td><?php echo ucwords(str_replace('-', ' ', $row['prop_code'])) ?></td>
					</tr>
					<?php $no++; endforeach ?>
				<?php else: ?>
				<tr>
					<td class="text-center" colspan="7">Tidak ada data.</td>
				</tr>
				<?php endif; ?>
			</tbody>
			<?php if (count($history) > 0) : ?>
			<tfoot>
				<tr>
					<th class="text-right" colspan="4">Stok Akhir :</th>
					<th class="text-center"><?php echo $laststok ?></th>
					<th></th>
				</tr>
			</tfoot>
			<?php endif; ?>
		</table>
	</div>
</div>

<?= GetDebugMessage() ?>
