<?php

namespace PHPMaker2021\distributor;

// Page object
$BrandView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fbrandview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fbrandview = currentForm = new ew.Form("fbrandview", "view");
    loadjs.done("fbrandview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.brand) ew.vars.tables.brand = <?= JsonEncode(GetClientVar("tables", "brand")) ?>;
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
<form name="fbrandview" id="fbrandview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="brand">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
    <tr id="r_idcustomer">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_brand_idcustomer"><?= $Page->idcustomer->caption() ?></span></td>
        <td data-name="idcustomer" <?= $Page->idcustomer->cellAttributes() ?>>
<span id="el_brand_idcustomer">
<span<?= $Page->idcustomer->viewAttributes() ?>>
<?= $Page->idcustomer->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->title->Visible) { // title ?>
    <tr id="r_title">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_brand_title"><?= $Page->title->caption() ?></span></td>
        <td data-name="title" <?= $Page->title->cellAttributes() ?>>
<span id="el_brand_title">
<span<?= $Page->title->viewAttributes() ?>>
<?= $Page->title->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kode->Visible) { // kode ?>
    <tr id="r_kode">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_brand_kode"><?= $Page->kode->caption() ?></span></td>
        <td data-name="kode" <?= $Page->kode->cellAttributes() ?>>
<span id="el_brand_kode">
<span<?= $Page->kode->viewAttributes() ?>>
<?= $Page->kode->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->logo->Visible) { // logo ?>
    <tr id="r_logo">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_brand_logo"><?= $Page->logo->caption() ?></span></td>
        <td data-name="logo" <?= $Page->logo->cellAttributes() ?>>
<span id="el_brand_logo">
<span>
<?= GetFileViewTag($Page->logo, $Page->logo->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->titipmerk->Visible) { // titipmerk ?>
    <tr id="r_titipmerk">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_brand_titipmerk"><?= $Page->titipmerk->caption() ?></span></td>
        <td data-name="titipmerk" <?= $Page->titipmerk->cellAttributes() ?>>
<span id="el_brand_titipmerk">
<span<?= $Page->titipmerk->viewAttributes() ?>>
<?= $Page->titipmerk->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ijinhaki->Visible) { // ijinhaki ?>
    <tr id="r_ijinhaki">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_brand_ijinhaki"><?= $Page->ijinhaki->caption() ?></span></td>
        <td data-name="ijinhaki" <?= $Page->ijinhaki->cellAttributes() ?>>
<span id="el_brand_ijinhaki">
<span<?= $Page->ijinhaki->viewAttributes() ?>>
<?= $Page->ijinhaki->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ijinbpom->Visible) { // ijinbpom ?>
    <tr id="r_ijinbpom">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_brand_ijinbpom"><?= $Page->ijinbpom->caption() ?></span></td>
        <td data-name="ijinbpom" <?= $Page->ijinbpom->cellAttributes() ?>>
<span id="el_brand_ijinbpom">
<span<?= $Page->ijinbpom->viewAttributes() ?>>
<?= $Page->ijinbpom->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aktaperusahaan->Visible) { // aktaperusahaan ?>
    <tr id="r_aktaperusahaan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_brand_aktaperusahaan"><?= $Page->aktaperusahaan->caption() ?></span></td>
        <td data-name="aktaperusahaan" <?= $Page->aktaperusahaan->cellAttributes() ?>>
<span id="el_brand_aktaperusahaan">
<span>
<?= GetFileViewTag($Page->aktaperusahaan, $Page->aktaperusahaan->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("product", explode(",", $Page->getCurrentDetailTable())) && $product->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("product", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ProductGrid.php" ?>
<?php } ?>
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
