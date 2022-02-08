<?php

namespace PHPMaker2021\production2;

// Page object
$BrandcustomerEdit2 = &$Page;
?>
<?php
	$getbrand = $_GET['brand'];
	$getcustomer = $_GET['customer'];

	if (empty($getbrand) && empty($getcustomer) ) {
		die('<script>window.location = \'error\';</script>');
	}

	$check = ExecuteRow("SELECT COUNT(*) as exist FROM brand_customer WHERE idbrand = {$getbrand} AND idcustomer = {$getcustomer}")['exist'];

	if ($check < 1) {
		die('<script>window.location = \'error\';</script>');
	}

	$listbrand = ExecuteQuery("SELECT id, kode, title FROM brand WHERE id > 1 ORDER BY id ASC")->fetchAll(); 
	$listcustomer = ExecuteQuery("SELECT id, kode, nama FROM customer WHERE id > 0 ORDER BY id ASC")->fetchAll(); 
?>
<form action="api/brandcustomer-edit" class="form-horizontal" method="post" id="form">
    <?php if (Config("CHECK_TOKEN")) : ?>
        <input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
        <input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
    <?php endif; ?>
    <input type="hidden" name="old_idbrand" value="<?php echo $getbrand ?>">
    <input type="hidden" name="old_idcustomer" value="<?php echo $getcustomer ?>">
    <input type="hidden" name="redirect" value="<?php echo ($_SERVER['HTTP_REFERER']) ?$_SERVER['HTTP_REFERER'] : 'BrandList' ?>">
	<div class="form-group row">
		<label class="col-sm-2 col-form-label">Brand<i class="fas fa-asterisk ew-required"></i></label>
		<div class="col-sm-8">
			<select name="idbrand" class="form-control select2-brand" style="width: 355px">
				<?php foreach ($listbrand as $row) : ?>
				<option value="<?php echo $row['id'] ?>" <?php echo ($getbrand && $getbrand == $row['id']) ? 'selected' : ''; ?>><?php echo $row['kode'] . ', ' . $row['title'] ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label">Customer<i class="fas fa-asterisk ew-required"></i></label>
		<div class="col-sm-10">
			<select name="idcustomer" class="form-control select2-customer" style="width: 355px">
				<?php foreach ($listcustomer as $row) : ?>
				<option value="<?php echo $row['id'] ?>" <?php echo ($getcustomer && $getcustomer == $row['id']) ? 'selected' : ''; ?>><?php echo $row['kode'] . ', ' . $row['nama'] ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-sm-10 offset-sm-2">
			<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit">Save</button>
			<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $_SERVER['HTTP_REFERER'] ?>">Cancel</button>
	    </div>
	</div>
</form>
<script src="jquery/jquery-3.6.0.min.js"></script>
<script src="plugins/select2/js/select2.full.min.js"></script>
<script>
$('.container-fluid h1').html(`Brand Customer <small class="text-muted">Edit</small>`);

$('#btn-cancel').click(function () {
	window.location.href = $(this).attr('data-href');
});

$("#form").on("submit", function (e) {
	e.preventDefault();

    const form = $(this);

    $.ajax({
        url: form.attr("action"),
        method: form.attr("method"),
        data: new FormData(this),
        processData: false,
        dataType: "json",
        contentType: false,
        success: function (data) {
        console.log(data);
            if (data.success !== true) {
            	// console.log('fdsa');
            	$(document).Toasts('create', {
	 				class: 'ew-toast bg-danger',
	 				title: 'Error',
	 				delay: 7500,
	 				autohide: true,
	 				body: data.message,
	 			});
            } else {
            	window.location.href = decodeURIComponent(data.redirect);
            }
        },
    });
});
</script>

<?= GetDebugMessage() ?>
