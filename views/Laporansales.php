<?php

namespace PHPMaker2021\distributor;

// Page object
$Laporansales = &$Page;
?>
<?php

$querypegawai = "SELECT id, kode, nama FROM pegawai";
$listpegawai = ExecuteQuery($querypegawai)->fetchAll();

$awal = isset($_POST['tglstart']) ? $_POST['tglstart'] : null;
$akhir = isset($_POST['tglend']) ? $_POST['tglend'] : null;
$idpegawai = isset($_POST['idpegawai']) ? $_POST['idpegawai'] : null;

$eAwal = !empty($awal) ? explode("-", $awal) : null;
$eAkhir = !empty($akhir) ? explode("-", $akhir) : null;

$query = "";

// if (false) {
if (!empty($idpegawai)) {
	$query = "SELECT o.tanggal, o.kode, c.nama customer, SUM(od.total) total, p.nama pegawai
	FROM `order` o, order_detail od, customer c, pegawai p
	WHERE o.id = od.idorder AND c.id = o.idcustomer AND p.id = c.idpegawai". (!empty($eAwal) ? " AND o.tanggal >= '".$eAwal[2]."-".$eAwal[1]."-".$eAwal[0]."'" : "") ."". (!empty($eAkhir) ? " AND o.tanggal < '".$eAkhir[2]."-".$eAkhir[1]."-".$eAkhir[0]."'" : "") ."
	AND p.id = ".$idpegawai."
	GROUP BY od.idorder";
} else {
	$query = "SELECT p.id, p.nama namapegawai, IFNULL(vlo.totalorder,0) totalorder, IFNULL(vlo.totalproduct,0) totalproduct, IFNULL(vlo.totalbarang,0) totalbarang, IFNULL(vlo.totaltagihan,0) totaltagihan FROM pegawai p LEFT JOIN
	(
		SELECT o.idpegawai, COUNT(o.id) totalorder, SUM(od.totalpod) totalproduct, SUM(od.totalbarang) totalbarang, SUM(od.totaltagihan) totaltagihan
		FROM `order` o, (
			SELECT o.id, COUNT(od.id) totalpod, SUM(od.jumlah) totalbarang, SUM(od.total) totaltagihan, o.tanggal
			FROM order_detail od, `order` o
			WHERE od.idorder = o.id". (!empty($eAwal) ? " AND o.tanggal >= '".$eAwal[2]."-".$eAwal[1]."-".$eAwal[0]."'" : "") ."". (!empty($eAkhir) ? " AND o.tanggal < '".$eAkhir[2]."-".$eAkhir[1]."-".$eAkhir[0]."'" : "") ."
			GROUP BY o.id
		) od
		WHERE od.id = o.id
		GROUP BY o.idpegawai
	) vlo
	ON p.id = vlo.idpegawai";
}

$datas = ExecuteQuery($query)->fetchAll();
?>


<html>
	<head>
		<script>
			loadjs.ready("head", function () {
				loadjs.done("flaporansales");
				ew.removeSpinner();
			});
		</script>
	</head>
	
	<body>
        <h4><?= (!empty($awal) ? "Mulai ".$awal." " : "") ?><?= (!empty($akhir) ? "Sampai ".$akhir : "") ?></h4><br>
        <form name="flaporansales" id="flaporansales" class="ew-form ew-add-form ew-horizontal" action="/bsd/laporansales" method="post">
            <?php if (Config("CHECK_TOKEN")) { ?>
            <input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
            <input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
            <?php } ?>

			<div id="r_idpegawai" class="form-group">
				<select id="idpegawai" name="idpegawai" class="form-control">
					<option value="">Global</option>
					<?php
					foreach ($listpegawai as $pegawai) {
					?>
					<option value="<?= $pegawai['id'] ?>" <?= $pegawai['id'] == $idpegawai ? "selected" : "" ?>><?= $pegawai['kode'] ?>, <?= $pegawai['nama'] ?></option>
					<?php
					}
					?>
				</select>
			</div>

            <div id="r_tglstart" class="form-group">
				<input type="text" data-table="invoice" data-field="tglstart" name="tglstart" id="tglstart" placeholder="Tanggal Awal" value="<?= $awal ?>" class="form-control" aria-describedby="tglstart_help">
				<div class="invalid-feedback">Incorrect date (dd-mm-yyyy) - Tanggal Invoice<br>Please enter required field - Tanggal Invoice</div>
				<script>
					loadjs.ready(["flaporansales", "datetimepicker"], function() {
						ew.createDateTimePicker("flaporansales", "tglstart", {"ignoreReadonly":true,"useCurrent":false,"format":0});
					});
				</script>
            </div>
            <div id="r_tglend" class="form-group">
				<input type="text" data-table="invoice" data-field="tglend" name="tglend" id="tglend" placeholder="Tanggal Akhir" value="<?= $akhir ?>" class="form-control" aria-describedby="tglend_help">
				<div class="invalid-feedback">Incorrect date (dd-mm-yyyy) - Tanggal Invoice<br>Please enter required field - Tanggal Invoice</div>
				<script>
					loadjs.ready(["flaporansales", "datetimepicker"], function() {
						ew.createDateTimePicker("flaporansales", "tglend", {"ignoreReadonly":true,"useCurrent":false,"format":0});
					});
				</script>
			</div>
			<div class="form-group">
				<button class="btn btn-primary ew-btn" type="submit">Submit</button>
				<button class="btn btn-default ew-btn" type="reset">Reset</button>
			</div>
        </form>
		
		<br>
		<br>

		<table class="table table-sm table-bordered ew-table">
			<?php
			if (empty($idpegawai)) {
			?>
			<thead>
				<tr class="ew-table-header">
					<th class="text-center">Marketing</th>
					<th class="text-center">Total Order</th>
					<th class="text-center">Total Barang</th>
					<th class="text-center" colspan="2">Jumlah</th>
				</tr>
			</thead>

			<tbody>
				<?php
				if (!empty($datas)) {
					$total = [
						'order' => 0,
						'barang' => 0,
						'jumlah' => 0,
					];
					foreach ($datas as $data) {
				?>
				<tr>
					<td><?= $data['namapegawai'] ?></td>
					<td class="text-right"><?= $data['totalorder'] ?></td>
					<td class="text-right"><?= $data['totalbarang'] ?></td>
					<td class="text-right border-right-0">Rp.</td>
					<td class="text-right border-left-0"><?= number_format($data['totaltagihan']) ?></td>
				</tr>
				<?php
						$total['order'] += $data['totalorder'];
						$total['barang'] += $data['totalbarang'];
						$total['jumlah'] += $data['totaltagihan'];
					}
				?>
			</tbody>
			<tfoot>
				<tr class="ew-table-footer">
					<td class="text-right"><b>Total</b></td>
					<td class="text-right"><b><?= $total['order'] ?></b></td>
					<td class="text-right"><b><?= $total['barang'] ?></b></td>
					<td class="text-right border-right-0"><b>Rp.</b></td>
					<td class="text-right border-left-0"><b><?= number_format($total['jumlah']) ?></b></td>
				</tr>
			</tfoot>
				<?php
				} else {
				?>
				<tr>
					<td colspan=5>Tidak ada data.</td>
				</tr>
			</tbody>
				<?php
				}
			} else {
				?>
			<thead>
				<tr class="ew-table-header">
					<th class="text-center">No.</th>
					<th class="text-center">Tanggal</th>
					<th class="text-center">Kode Order</th>
					<th class="text-center">Customer</th>
					<th class="text-center" colspan="2">Nominal</th>
					<th class="text-center">Marketing</th>
				</tr>
			</thead>

			<tbody>
				<?php
				if (!empty($datas)) {
					$total = 0;
					$pegawai = "";
					$i = 0;
					foreach ($datas as $data) {
				?>
				<tr>
				<td class="text-right"><?= ++$i ?></td>
				<td><?= date('d-m-Y', strtotime($data['tanggal'])) ?></td>
				<td><?= $data['kode'] ?></td>
				<td><?= $data['customer'] ?></td>
				<td class="text-right border-right-0">Rp.</td>
				<td class="text-right border-left-0"><?= number_format($data['total']) ?></td>
				<td><?= $data['pegawai'] ?></td>
				</tr>
				<?php
						$total += $data['total'];
						$pegawai = $data['pegawai'];
					}
				?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="4" class="text-right"><b>Total:</b></td>
					<td class="text-right border-right-0"><b>Rp.</b></td>
					<td class="text-right border-left-0"><b><?= number_format($total) ?></b></td>
					<td><b><?= $pegawai ?></b></td>
				</tr>
			</tfoot>
				<?php
				} else {
				?>
				<tr>
					<td colspan=5>Tidak ada data.</td>
				</tr>
			</tbody>
				<?php
				}
			}
			?>
		</table>
	</body>
</html>


<?= GetDebugMessage() ?>
