<?php

namespace PHPMaker2021\production2;

// Page object
$AntrianBot = &$Page;
?>
<?php 
	$dateFrom = date('Y-m-01');
	$dateTo = date('Y-m-t');

	if (isset($_GET['status'], $_GET['dateFrom'], $_GET['dateTo'])) {
		switch ($_GET['status']) {
			case 'delivered':
		 		$status = '1';
		 		break;
			case 'canceled':
		 		$status = '-2';
		 		break;
			case 'queuing':
		 		$status = '0';
		 		break;
		 	
		 	default:
		 		$status = '-1'; // DEFAULT VALUE 'pending'.
		 		break;

		}

		// print_r($status);

		$query = "SELECT * FROM bot_history WHERE `status` = {$status}";

		$results = ExecuteQuery($query)->fetchAll();
	}
?>
<div class="container">
	<div class="row">
		<form method="get" action="<?php echo CurrentPage()->PageObjName ?>">
			<div class="col-md-12">
				<ul class="list-unstyled">
					<li class="d-inline-block">
						<label class="d-block">Status:</label>
						<select name="status" class="form-control" style="width: 10em;">
							<option value="pending" <?php echo isset($_GET['status']) && $_GET['status'] == 'pending' ? 'selected' : null ?>>Pending</option>
							<option value="queuing" <?php echo isset($_GET['status']) && $_GET['status'] == 'queuing' ? 'selected' : null ?>>Queueing</option>
							<option value="delivered" <?php echo isset($_GET['status']) && $_GET['status'] == 'delivered' ? 'selected' : null ?>>Delivered</option>
							<option value="canceled" <?php echo isset($_GET['status']) && $_GET['status'] == 'canceled' ? 'selected' : null ?>>Cancelled</option>
						</select>
					</li>
					<li class="d-inline-block">
						<label class="d-block">Date Range</label>
						<input type="date" class="form-control input-md" name="dateFrom" value="<?php echo date('Y-m-d', strtotime($dateFrom)) ?>">
					</li>
					to
					<li class="d-inline-block">
						<input type="date" class="form-control input-md" name="dateTo" value="<?php echo date('Y-m-d', strtotime($dateTo)) ?>">
					</li>
					<li class="d-inline-block">
						<button class="btn btn-primary btn-md p-2" type="submit">Search <i class="fa fa-search h-3"></i></button>
					</li>
					<?php if (isset($_GET['status'], $_GET['dateFrom'], $_GET['dateTo'])) : ?>
					<li class="d-inline-block">
						<button type="button" class="btn btn-success btn-md p-2 btn-confirm" data-status="send">Konfirmasi &amp; Kirim <i class="mr-2 fas fa-paper-plane"></i></button>
						<button type="button" class="btn btn-danger btn-md p-2 btn-confirm" data-status="cancel">Konfirmasi &amp; Cancel <i class="mr-2 fas fa-exclamation-circle"></i></button>
					</li>
					<?php endif; ?>
				</ul>
			</div>
		</form>
	</div>
	<?php if (isset($_GET['status'], $_GET['dateFrom'], $_GET['dateTo'])) : ?>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered">
				<tr><th colspan="10">Status: <?php echo ucwords($_GET['status']) ?></th></tr>
				<tr>
					<?php if (count($results) > 0): ?>
			    	<th class="text-center" width="5%"><input type="checkbox" id="check-all"></th>
				    <?php endif; ?>
					<th class="text-center" width="25%">Jenis</th>
					<th class="text-center" width="50%">Messages</th>
					<th class="text-center" width="5%">Status</th>
					<th class="text-center" width="15%">Created at</th>
				</tr>
			<?php if (count($results) > 0): ?>
				<?php foreach ($results as $row) : ?>
				<tr>
					<td class="text-center"><input type="checkbox" id="check-row" value="<?php echo $row['id'] ?>"></td>
					<td><?php echo $row['prop_code'] . ', ' . $row['prop_name'] ?></td>
					<td><strong>Phone:</strong> <?php echo $row['phone'] ?><br><strong>Messages:</strong> <?php echo nl2br($row['messages']) ?></td>
					<td class="text-center"><?php echo $row['status'] ?><br><?php echo ($row['status'] == '-2' && $row['canceled_at'] <> null) ? tgl_indo($row['canceled_at']) : '' ?></td>
					<td><?php echo nl2br($row['keterangan']) ?></td>
					<td class="text-center"><?php echo tgl_indo($row['created_at']) ?></td>
				</tr>
				<?php endforeach; ?>
			<?php else: ?>
				<tr><td colspan="10" class="text-center">Tidak ada data.</td></tr>
			<?php endif; ?>
			</table>
		</div>
	</div>
	<script src="jquery/jquery-3.6.0.min.js"></script>
	<script>
		$('.btn-confirm').on('click', function () {
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

		    let type = '';
		    let prompts = '';
		    let prompts_icon = '';
		    if ($(this).attr('data-status') == 'send') {
		    	type = 'send';
		    	prompts = 'Anda yakin akan mengirimkan data berikut?'
		    	prompts_icon = 'success';
		    } else {
		    	type = 'cancel';
		    	prompts = 'Anda yakin akan membatalkan pengiriman data berikut?'
		    	prompts_icon = 'danger';
		    }

			Swal.fire({
			  title: "Confirmation?",
			  text: prompts,
			  icon: 'question',
			  showCancelButton: true,
			  confirmButtonText: 'Yes, process it!',
			  cancelButtonColor: '#d33',
			}).then((result) => {
				if (result.isConfirmed) {
					$.get("api/confirmation-bot-queue?type="+type+"&items="+encodeURIComponent(items), function(res) {
				        if (res.status !== false) {
				            Swal.fire({
				                icon: 'success',
				                title: 'Success',
				                text: res.message,
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
				} else if (result.isDismissed) {
				    Swal.fire('Cancelled!', 'Confirmation has been cancelled.', 'error');
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

<?= GetDebugMessage() ?>
