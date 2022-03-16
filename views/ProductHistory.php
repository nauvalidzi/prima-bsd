<?php

namespace PHPMaker2021\production2;

// Page object
$ProductHistory = &$Page;
?>
<?php 
	$idproduct = !empty(Get('product')) ? Get("product") : die ; 

	$product = ExecuteRow("SELECT p.kode, p.nama FROM product p WHERE id = {$idproduct}");

	$laststok = ExecuteRow("SELECT stok_akhir FROM stocks WHERE idproduct = {$idproduct} AND id IN (SELECT MAX(id) FROM stocks GROUP BY idproduct)")['stok_akhir'];

	// PAGINATION
	$batas = 10;
	$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
	$halaman_awal = ($halaman>1) ? ($halaman * $batas) - $batas : 0;

	$previous = $halaman - 1;
	$next = $halaman + 1;

	// count data
	$result = ExecuteQuery("SELECT * FROM stocks WHERE aktif = 1 AND idproduct = {$idproduct}")->fetchAll();
    $jumlah_data = count($result);
    $total_halaman = ceil($jumlah_data/$batas);

	$history = ExecuteQuery("SELECT * FROM stocks WHERE aktif = 1 AND idproduct = {$idproduct} ORDER BY id ASC LIMIT {$halaman_awal}, {$batas}")->fetchAll();
	$nomor = $halaman_awal+1;
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
		<ul class="pagination justify-content-center">
			<?php 
				if ($total_halaman > 1) {
					if ($halaman > 2) {
						echo "<li class=\"page-item\"><a class=\"page-link\" href=\"?product={$idproduct}&halaman=1\">First</a></li>";
					}

					if ($halaman > 1) {
						echo "<li class=\"page-item\"><a class=\"page-link\" href=\"?product={$idproduct}&halaman={$previous}\">Previous</a></li>";
					}

					for ($x=1; $x<=$total_halaman; $x++) {
						if ($halaman == $x) {
							echo "<li class=\"page-item disabled\"><a href=\"#\" class=\"page-link\">{$x}</a></li>";
						} else {
							echo "<li class=\"page-item\"><a href=\"?product={$idproduct}&halaman={$x}\" class=\"page-link\">{$x}</a></li>";
						}
					}

					if ($halaman < $total_halaman) {
						echo "<li class=\"page-item\"><a class=\"page-link\" href=\"?product={$idproduct}&halaman={$next}\">Next</a></li>";
					}

					if (($total_halaman - $halaman) > 1) { 
						echo "<li class=\"page-item\"><a href=\"?product={$idproduct}&halaman={$total_halaman}\" class=\"page-link\">Last</a></li>";
					}
				}
			 ?>
		</ul>
	</div>
</div>

<?= GetDebugMessage() ?>
