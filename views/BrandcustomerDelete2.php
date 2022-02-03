<?php

namespace PHPMaker2021\distributor;

// Page object
$BrandcustomerDelete2 = &$Page;
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

	$brand = ExecuteRow("SELECT id, kode, title FROM brand WHERE id = {$getbrand}");
	$customer = ExecuteRow("SELECT id, kode, nama FROM customer WHERE id = {$getcustomer}");
	$referer = $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : 'BrandList';
?>
<form class="form-inline ew-form ew-delete-form" action="api/brandcustomer-delete" method="post" id="form">
	<?php if (Config("CHECK_TOKEN")) : ?>
        <input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>">
        <input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>">
    <?php endif; ?>
    <input type="hidden" name="brand" value="<?php echo $getbrand ?>">
    <input type="hidden" name="customer" value="<?php echo $getcustomer ?>">
    <input type="hidden" name="redirect" value="<?php echo ($_SERVER['HTTP_REFERER']) ?$_SERVER['HTTP_REFERER'] : 'BrandList' ?>">
	<div class="card ew-card ew-grid">
		<div class="table-responsive card-body ew-grid-middle-panel">
			<table class="table ew-table ew-preview-table">
			    <thead>
			        <tr class="ew-table-header">
			            <th class="ew-table-header-cell">
			            	<div class="ew-pointer" data-sort="idbrand" data-sort-type="1" data-sort-order="ASC">
			            		<div class="ew-table-header-btn">
			            			<span class="ew-table-header-caption">Brand</span><span class="ew-table-header-sort"></span>
			            		</div>
			            	</div>
			            </th>
			            <th class="ew-table-header-cell">
			            	<div class="ew-pointer" data-sort="idcustomer" data-sort-type="1" data-sort-order="ASC">
			            		<div class="ew-table-header-btn">
			            			<span class="ew-table-header-caption">Customer</span>
			            			<span class="ew-table-header-sort"></span>
			            		</div>
			            	</div>
			            </th>
			        </tr>
			    </thead>
			    <tbody>
			    <tr class="ew-table-row">
			        <td class="ew-table-last-row">
			        	<span><?php echo $brand['kode'] . ', ' . $brand['title'] ?></span>
			        </td>
			        <td class="ew-table-last-row">
			        	<span><?php echo $customer['kode'] . ', ' . $customer['nama'] ?></span>
			        </td>
				</tr>
			    </tbody>
			</table>
		</div>
	</div>
	<div>
		<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit">Delete</button>
		<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $_SERVER['HTTP_REFERER'] ?>">Cancel</button>
	</div>
</form>
<script src="jquery/jquery-3.6.0.min.js"></script>
<script src="plugins/select2/js/select2.full.min.js"></script>
<script>
$('.container-fluid h1').html(`Brand Customer <small class="text-muted">Delete</small>`);

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
