<?php

namespace PHPMaker2021\production2;

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
<?php if ($Page->kode_sip->Visible) { // kode_sip ?>
    <tr id="r_kode_sip">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_brand_kode_sip"><?= $Page->kode_sip->caption() ?></span></td>
        <td data-name="kode_sip" <?= $Page->kode_sip->cellAttributes() ?>>
<span id="el_brand_kode_sip">
<span<?= $Page->kode_sip->viewAttributes() ?>>
<?= $Page->kode_sip->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aktif->Visible) { // aktif ?>
    <tr id="r_aktif">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_brand_aktif"><?= $Page->aktif->caption() ?></span></td>
        <td data-name="aktif" <?= $Page->aktif->cellAttributes() ?>>
<span id="el_brand_aktif">
<span<?= $Page->aktif->viewAttributes() ?>>
<?= $Page->aktif->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <tr id="r_updated_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_brand_updated_at"><?= $Page->updated_at->caption() ?></span></td>
        <td data-name="updated_at" <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_brand_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<?php
    $Page->DetailPages->ValidKeys = explode(",", $Page->getCurrentDetailTable());
    $firstActiveDetailTable = $Page->DetailPages->activePageIndex();
?>
<div class="ew-detail-pages"><!-- detail-pages -->
<div class="accordion ew-accordion" id="Page_details"><!-- accordion -->
<?php
    if (in_array("product", explode(",", $Page->getCurrentDetailTable())) && $product->DetailView) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "product") {
            $firstActiveDetailTable = "product";
        }
?>
    <div class="card ew-accordion-card <?= $Page->DetailPages->pageStyle("product") ?>">
        <div class="card-header">
            <h4 class="card-title">
                <a data-toggle="collapse" role="button" class="collapsed" aria-expanded="<?= JsonEncode($Page->DetailPages->isActive("product")) ?>" data-parent="#Page_details" href="#tab_product"><?= $Language->tablePhrase("product", "TblCaption") ?>&nbsp;<?= str_replace("%c", Container("product")->Count, $Language->phrase("DetailCount")) ?></a>
            </h4>
        </div>
        <div class="collapse <?= $Page->DetailPages->pageStyle("product") ?>" id="tab_product"><!-- page* -->
            <div class="card-body"><!-- .card-body -->
<?php include_once "ProductGrid.php" ?>
            </div><!-- /.card-body -->
        </div><!-- /page* -->
    </div>
<?php } ?>
<?php
    if (in_array("brand_customer", explode(",", $Page->getCurrentDetailTable())) && $brand_customer->DetailView) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "brand_customer") {
            $firstActiveDetailTable = "brand_customer";
        }
?>
    <div class="card ew-accordion-card <?= $Page->DetailPages->pageStyle("brand_customer") ?>">
        <div class="card-header">
            <h4 class="card-title">
                <a data-toggle="collapse" role="button" class="collapsed" aria-expanded="<?= JsonEncode($Page->DetailPages->isActive("brand_customer")) ?>" data-parent="#Page_details" href="#tab_brand_customer"><?= $Language->tablePhrase("brand_customer", "TblCaption") ?>&nbsp;<?= str_replace("%c", Container("brand_customer")->Count, $Language->phrase("DetailCount")) ?></a>
            </h4>
        </div>
        <div class="collapse <?= $Page->DetailPages->pageStyle("brand_customer") ?>" id="tab_brand_customer"><!-- page* -->
            <div class="card-body"><!-- .card-body -->
<?php include_once "BrandCustomerGrid.php" ?>
            </div><!-- /.card-body -->
        </div><!-- /page* -->
    </div>
<?php } ?>
</div><!-- /accordion -->
</div><!-- /detail-pages -->
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
