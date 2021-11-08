<?php

namespace PHPMaker2021\distributor;

// Page object
$PenagihanCustomer = &$Page;
?>
<?php
	$jatuhtempo = date('Y-m-d');
	if(isset($_GET['jatuhtempo'])) {
		$jatuhtempo = date('Y-m-d', strtotime($_GET['jatuhtempo']));

		switch (strtoupper($_GET['umur']) ?? '') {
			case 'H-2':
				$umur = "HAVING umur_faktur < -1 AND umur_faktur > -3"; // H-2
				break;
			case 'H+1':
				$umur = "HAVING umur_faktur < 2 AND umur_faktur > 0"; // H+1
				break;
			case 'H+7':
				$umur = "HAVING umur_faktur < 8 AND umur_faktur > 5"; // H+7
				break;
			case 'H+14':
				$umur = "HAVING umur_faktur < 15 AND umur_faktur > 13"; // H+14
				break;
			case 'H+21':
				$umur = "HAVING umur_faktur < 22 AND umur_faktur > 20"; // H+21
				break;
			case 'H+28':
				$umur = "HAVING umur_faktur < 29 AND umur_faktur > 27"; // H+28
				break;
			case 'H+30':
				$umur = "HAVING umur_faktur < 31 AND umur_faktur > 29"; // H+30
				break;
            default:
            	$umur = null;
            	break;
        }
		
		$query = "SELECT o.id AS idorder, DATE_FORMAT(o.tanggal, '%Y-%m-%d') AS tgl_order,
					o.kode AS kode_order,
					c.nama AS nama_customer,
					c.hp AS nomor_handphone, SUM(od.total) AS nilai_po, 
					i.kode AS kode_faktur, 
					DATE_FORMAT(i.tglinvoice, '%Y-%m-%d') AS tgl_faktur, 
					DATE_FORMAT(i.tglinvoice + INTERVAL `t`.`value` DAY, '%Y-%m-%d') AS jatuhtempo, 
					TIMESTAMPDIFF(DAY, i.tglinvoice + INTERVAL `t`.`value` DAY, '{$jatuhtempo}') as umur_faktur,
					`t`.`value` AS term_payment, 
					SUM(i.totaltagihan) AS nilai_faktur, 
					SUM(i.sisabayar) AS piutang, 
					IFNULL(DATE_FORMAT(MAX(b.created_at), '%Y-%m-%d %H:%i:%s'),'') AS tgl_penagihan
				FROM `order` o
				JOIN order_detail od ON od.idorder = o.id
				JOIN customer c ON c.id = o.idcustomer
				LEFT JOIN invoice i ON i.idorder = o.id
				LEFT JOIN bot_history b ON i.kode = b.prop_code
				LEFT JOIN termpayment t ON i.idtermpayment = t.id
				WHERE i.sisabayar > 0 
				GROUP BY o.id, c.id, i.id
				{$umur}
				ORDER BY jatuhtempo ASC";
// print_r($query); die;
		$result = ExecuteQuery($query)->fetchAll();
	}
?>
<div class="container">
 	<div class="row">
		<form action="<?php echo CurrentPage()->PageObjName ?>" enctype="application/x-www-form-urlencoded">
			
			<div class="col-md-12">
				<ul class="list-unstyled">
					<li class="d-inline-block">
						<label class="d-block">Umur Faktur</label>
						<select name="umur" class="form-control" style="width: 10em;">
							<option value="all">-- All --</option>
							<option value="h-2" <?php echo isset($_GET['umur']) == 'h-2' ? 'selected' : null ?>>H-2</option>
							<option value="h+1" <?php echo isset($_GET['umur']) == 'h+1' ? 'selected' : null ?>>H+1</option>
							<option value="h+72" <?php echo isset($_GET['umur']) == 'h+72' ? 'selected' : null ?>>H+7</option>
							<option value="h+14" <?php echo isset($_GET['umur']) == 'h+14' ? 'selected' : null ?>>H+14</option>
							<option value="h+21" <?php echo isset($_GET['umur']) == 'h+21' ? 'selected' : null ?>>H+21</option>
							<option value="H+28" <?php echo isset($_GET['umur']) == 'H+28' ? 'selected' : null ?>>H+28</option>
							<option value="h+30" <?php echo isset($_GET['umur']) == 'h+30' ? 'selected' : null ?>>H+30</option>
						</select>
					</li>
					<li class="d-inline-block">
						<label class="d-block">Tgl Jatuh Tempo</label>
						<input type="date" class="form-control input-md" name="jatuhtempo" value="<?php echo $jatuhtempo ?>">
					</li>
					<li class="d-inline-block">
						<button class="btn btn-primary btn-md p-2" type="submit">Search <i class="fa fa-search h-3"></i></button>
					</li>
					<?php if(isset($_GET['jatuhtempo'])) : ?>
					<li class="d-inline-block">
						<button type="button" class="btn btn-warning btn-md p-2 send-blast">Masukkan ke Antrian WA Blast</button>
					</li>
					<?php endif; ?>
				</ul>
			</div>
		</form>
	</div>
	<div class="row">
	    <?php if(isset($_GET['jatuhtempo'])) : ?>
	    <table class="table ew-table table-bordered" style="width: 100em; min-width: 100em; max-width: 100em;">
		  <thead>
			<tr>
				<th colspan="11" class="text-center">
					<h4 class="my-2">Penagihan Customer <?php echo $umur ?></h4>
					<p class="mt-3">Tanggal Jatuh Tempo: <?php echo date('d/m/Y', strtotime($jatuhtempo)) ?> </p>
				</th>
			</tr>
		    <tr>
		    	<th class="text-center"><input type="checkbox" id="check-all"></th>
		        <th class="text-center">Tgl. Order</th>
		        <th class="text-center">Kode Order</th>
		        <th class="text-center">Nama Pelanggan</th>
		        <th class="text-center">No. Handphone</th>
		        <th class="text-center">Nilai P.O.</th>
		        <th class="text-center">Tgl Faktur</th>
		        <th class="text-center">Nilai Faktur</th>
		        <th class="text-center">Piutang</th>
		        <th class="text-center">Umur Faktur</th>
		        <th class="text-center">Tgl Antrian Penagihan</th>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php if (!empty($result)): ?>
			    <?php foreach($result as $row): ?>
			    <tr>
			      <td class="text-center"><input type="checkbox" id="check-row" value="<?php echo $row['idorder'] ?>"></td>
			      <td class="text-center"><?php echo tgl_indo($row['tgl_order']) ?></td>
			      <td class="text-center"><?php echo $row['kode_order'] ?></td>
			      <td><?php echo $row['nama_customer'] ?></td>
			      <td class="text-center"><?php echo $row['nomor_handphone'] ?></td>
			      <td>Rp. <span class="float-right"><?php echo number_format($row['nilai_po'], 2, ",", ".") ?></span></td>
			      <td class="text-center"><?php echo tgl_indo($row['tgl_faktur']) ?></td>
			      <td>Rp. <span class="float-right"><?php echo number_format($row['nilai_faktur'], 2, ",", ".") ?></span></td>
			      <td>Rp. <span class="float-right"><?php echo number_format($row['piutang'], 2, ",", ".") ?></span></td>
			      <td class="text-center"><?php echo $row['umur_faktur'] ?> Hari</td>
			      <td class="text-center"><?php echo !empty($row['tgl_penagihan']) ? tgl_indo($row['tgl_penagihan'], 'datetime'): '-'; ?></td>
			    </tr>
				<?php endforeach; ?>
	    	<?php else: ?>
	    		<tr>
	    			<td colspan="11" class="text-center">Tidak ada data.</td>
	    		</tr>
	    	<?php endif; ?>
		  </tbody>
		</table>
		<script src="jquery/jquery-3.6.0.min.js"></script>
		<script>
			$('.send-blast').on('click', function () {
			    var items=[];
			    $("input#check-row:checked:checked").each(function (index,item) {
			        items[index] = item.value;
			    });
			    if (items.length < 1) {
			        Swal.fire({
			            icon: 'error',
			            title: 'Oops...',
			            text: 'Pilih data terlebih dahulu!',
			        });
			        return false;
			    }

			    $.get("api/goto-reminder?items="+encodeURIComponent(items), function(res) {
			        if (res.status !== false) {
			            Swal.fire({
			                icon: 'success',
			                title: 'Success',
			                text: 'Data berhasil diproses!',
			            }).then(function() { 
			               location.reload();
			            });
			        } else {
			        	Swal.fire({
			                icon: 'error',
			                title: 'Oops...',
			                text: 'Something went wrong!',
			            }).then(function() { 
			               location.reload();
			            });
			        }
			    });
			});

			$(document).on('click','input#check-all',function () {
			    var checked = this.checked;

			    $("input#check-row").each(function (index,item) {
			        item.checked = checked;
			    });
			});

			$(document).on('click', '#check-row', function(){
			    var checked = this.value;
			    checkSelected();
			});

			function checkSelected() {
			    var all = $("input#check-all")[0];
			    var total = $("input#check-row").length;
			    var len = $("input#check-row:checked:checked").length;
			    all.checked = len===total;
			}
		</script>
		<?php endif; ?>
	</div>
</div>

<?= GetDebugMessage() ?>
