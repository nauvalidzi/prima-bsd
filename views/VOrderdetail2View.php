<?php

namespace PHPMaker2021\distributor;

// Page object
$VOrderdetail2View = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fv_orderdetail2view;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fv_orderdetail2view = currentForm = new ew.Form("fv_orderdetail2view", "view");
    loadjs.done("fv_orderdetail2view");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.v_orderdetail2) ew.vars.tables.v_orderdetail2 = <?= JsonEncode(GetClientVar("tables", "v_orderdetail2")) ?>;
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
<form name="fv_orderdetail2view" id="fv_orderdetail2view" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="v_orderdetail2">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_v_orderdetail2_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_v_orderdetail2_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <tr id="r_nama">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_v_orderdetail2_nama"><?= $Page->nama->caption() ?></span></td>
        <td data-name="nama" <?= $Page->nama->cellAttributes() ?>>
<span id="el_v_orderdetail2_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idorder->Visible) { // idorder ?>
    <tr id="r_idorder">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_v_orderdetail2_idorder"><?= $Page->idorder->caption() ?></span></td>
        <td data-name="idorder" <?= $Page->idorder->cellAttributes() ?>>
<span id="el_v_orderdetail2_idorder">
<span<?= $Page->idorder->viewAttributes() ?>>
<?= $Page->idorder->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sisa->Visible) { // sisa ?>
    <tr id="r_sisa">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_v_orderdetail2_sisa"><?= $Page->sisa->caption() ?></span></td>
        <td data-name="sisa" <?= $Page->sisa->cellAttributes() ?>>
<span id="el_v_orderdetail2_sisa">
<span<?= $Page->sisa->viewAttributes() ?>>
<?= $Page->sisa->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aktif->Visible) { // aktif ?>
    <tr id="r_aktif">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_v_orderdetail2_aktif"><?= $Page->aktif->caption() ?></span></td>
        <td data-name="aktif" <?= $Page->aktif->cellAttributes() ?>>
<span id="el_v_orderdetail2_aktif">
<span<?= $Page->aktif->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_aktif_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->aktif->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->aktif->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_aktif_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->harga->Visible) { // harga ?>
    <tr id="r_harga">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_v_orderdetail2_harga"><?= $Page->harga->caption() ?></span></td>
        <td data-name="harga" <?= $Page->harga->cellAttributes() ?>>
<span id="el_v_orderdetail2_harga">
<span<?= $Page->harga->viewAttributes() ?>>
<?= $Page->harga->getViewValue() ?></span>
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
