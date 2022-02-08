<?php

namespace PHPMaker2021\production2;

// Page object
$AlamatCustomerView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var falamat_customerview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    falamat_customerview = currentForm = new ew.Form("falamat_customerview", "view");
    loadjs.done("falamat_customerview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.alamat_customer) ew.vars.tables.alamat_customer = <?= JsonEncode(GetClientVar("tables", "alamat_customer")) ?>;
</script>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="falamat_customerview" id="falamat_customerview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="alamat_customer">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->alias->Visible) { // alias ?>
    <tr id="r_alias">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_alamat_customer_alias"><?= $Page->alias->caption() ?></span></td>
        <td data-name="alias" <?= $Page->alias->cellAttributes() ?>>
<span id="el_alamat_customer_alias">
<span<?= $Page->alias->viewAttributes() ?>>
<?= $Page->alias->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->penerima->Visible) { // penerima ?>
    <tr id="r_penerima">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_alamat_customer_penerima"><?= $Page->penerima->caption() ?></span></td>
        <td data-name="penerima" <?= $Page->penerima->cellAttributes() ?>>
<span id="el_alamat_customer_penerima">
<span<?= $Page->penerima->viewAttributes() ?>>
<?= $Page->penerima->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->telepon->Visible) { // telepon ?>
    <tr id="r_telepon">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_alamat_customer_telepon"><?= $Page->telepon->caption() ?></span></td>
        <td data-name="telepon" <?= $Page->telepon->cellAttributes() ?>>
<span id="el_alamat_customer_telepon">
<span<?= $Page->telepon->viewAttributes() ?>>
<?= $Page->telepon->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
    <tr id="r_alamat">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_alamat_customer_alamat"><?= $Page->alamat->caption() ?></span></td>
        <td data-name="alamat" <?= $Page->alamat->cellAttributes() ?>>
<span id="el_alamat_customer_alamat">
<span<?= $Page->alamat->viewAttributes() ?>>
<?= $Page->alamat->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idprovinsi->Visible) { // idprovinsi ?>
    <tr id="r_idprovinsi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_alamat_customer_idprovinsi"><?= $Page->idprovinsi->caption() ?></span></td>
        <td data-name="idprovinsi" <?= $Page->idprovinsi->cellAttributes() ?>>
<span id="el_alamat_customer_idprovinsi">
<span<?= $Page->idprovinsi->viewAttributes() ?>>
<?= $Page->idprovinsi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idkabupaten->Visible) { // idkabupaten ?>
    <tr id="r_idkabupaten">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_alamat_customer_idkabupaten"><?= $Page->idkabupaten->caption() ?></span></td>
        <td data-name="idkabupaten" <?= $Page->idkabupaten->cellAttributes() ?>>
<span id="el_alamat_customer_idkabupaten">
<span<?= $Page->idkabupaten->viewAttributes() ?>>
<?= $Page->idkabupaten->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idkecamatan->Visible) { // idkecamatan ?>
    <tr id="r_idkecamatan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_alamat_customer_idkecamatan"><?= $Page->idkecamatan->caption() ?></span></td>
        <td data-name="idkecamatan" <?= $Page->idkecamatan->cellAttributes() ?>>
<span id="el_alamat_customer_idkecamatan">
<span<?= $Page->idkecamatan->viewAttributes() ?>>
<?= $Page->idkecamatan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idkelurahan->Visible) { // idkelurahan ?>
    <tr id="r_idkelurahan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_alamat_customer_idkelurahan"><?= $Page->idkelurahan->caption() ?></span></td>
        <td data-name="idkelurahan" <?= $Page->idkelurahan->cellAttributes() ?>>
<span id="el_alamat_customer_idkelurahan">
<span<?= $Page->idkelurahan->viewAttributes() ?>>
<?= $Page->idkelurahan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
