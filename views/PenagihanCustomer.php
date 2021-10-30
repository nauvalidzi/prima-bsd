<?php

namespace PHPMaker2021\distributor;

// Page object
$PenagihanCustomer = &$Page;
?>
<?php
	$jatuhtempo = date('Y-m-d');
	if(isset($_GET['jatuhtempo'])) {
		$jatuhtempo = date('Y-m-d', strtotime($_GET['jatuhtempo']));
		
		$query = "SELECT o.id as idorder,
					date_format(o.tanggal, '%Y-%m-%d') AS tgl_order,
					o.kode AS kode_order,
					c.nama AS nama_customer,
					c.hp AS nomor_handphone,
					SUM(od.total) AS nilai_po,
					MIN(DATE_FORMAT(i.tglinvoice, '%Y-%m-%d')) AS tgl_faktur, 
					CASE
						WHEN SUM(i.totaltagihan) IS NULL THEN SUM(od.total) 
						ELSE SUM(i.totaltagihan)
					END AS nilai_faktur, 
					CASE 
						WHEN SUM(i.sisabayar) IS NULL THEN SUM(od.total) 
						ELSE SUM(i.sisabayar) 
					END AS piutang,
					TIMESTAMPDIFF(DAY, MIN(i.tglinvoice), NOW()) as umur_faktur,
					IFNULL(DATE_FORMAT(MAX(pn.tgl_antrian), '%Y-%m-%d %H:%i:%s'),'') as tgl_penagihan
				  FROM `order` o
				  JOIN order_detail od ON od.idorder = o.id
				  JOIN customer c ON c.id = o.idcustomer
				  LEFT JOIN invoice i ON i.idorder = o.id
				  LEFT JOIN penagihan pn on o.id = pn.idorder
				  WHERE i.tglinvoice <= '{$jatuhtempo}'
				  GROUP BY o.id, c.id";

		$result = ExecuteQuery($query)->fetchAll();
	}
?>
<div class="container">
 	<div class="row">
		<form action="<?php echo CurrentPage()->PageObjName ?>">
			
			<div class="col-md-12">
				<ul class="list-unstyled">
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
					<h4 class="my-2">Penagihan Customer</h4>
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
		        <th class="text-center">Tgl Penagihan</th>
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
