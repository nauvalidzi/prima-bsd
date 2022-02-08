<?php

namespace PHPMaker2021\production2;

// Page object
$IjinbpomView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fijinbpomview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fijinbpomview = currentForm = new ew.Form("fijinbpomview", "view");
    loadjs.done("fijinbpomview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.ijinbpom) ew.vars.tables.ijinbpom = <?= JsonEncode(GetClientVar("tables", "ijinbpom")) ?>;
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
<form name="fijinbpomview" id="fijinbpomview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="ijinbpom">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->tglterima->Visible) { // tglterima ?>
    <tr id="r_tglterima">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinbpom_tglterima"><?= $Page->tglterima->caption() ?></span></td>
        <td data-name="tglterima" <?= $Page->tglterima->cellAttributes() ?>>
<span id="el_ijinbpom_tglterima">
<span<?= $Page->tglterima->viewAttributes() ?>>
<?= $Page->tglterima->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tglsubmit->Visible) { // tglsubmit ?>
    <tr id="r_tglsubmit">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinbpom_tglsubmit"><?= $Page->tglsubmit->caption() ?></span></td>
        <td data-name="tglsubmit" <?= $Page->tglsubmit->cellAttributes() ?>>
<span id="el_ijinbpom_tglsubmit">
<span<?= $Page->tglsubmit->viewAttributes() ?>>
<?= $Page->tglsubmit->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
    <tr id="r_idpegawai">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinbpom_idpegawai"><?= $Page->idpegawai->caption() ?></span></td>
        <td data-name="idpegawai" <?= $Page->idpegawai->cellAttributes() ?>>
<span id="el_ijinbpom_idpegawai">
<span<?= $Page->idpegawai->viewAttributes() ?>>
<?= $Page->idpegawai->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
    <tr id="r_idcustomer">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinbpom_idcustomer"><?= $Page->idcustomer->caption() ?></span></td>
        <td data-name="idcustomer" <?= $Page->idcustomer->cellAttributes() ?>>
<span id="el_ijinbpom_idcustomer">
<span<?= $Page->idcustomer->viewAttributes() ?>>
<?= $Page->idcustomer->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idbrand->Visible) { // idbrand ?>
    <tr id="r_idbrand">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinbpom_idbrand"><?= $Page->idbrand->caption() ?></span></td>
        <td data-name="idbrand" <?= $Page->idbrand->cellAttributes() ?>>
<span id="el_ijinbpom_idbrand">
<span<?= $Page->idbrand->viewAttributes() ?>>
<?= $Page->idbrand->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kontrakkerjasama->Visible) { // kontrakkerjasama ?>
    <tr id="r_kontrakkerjasama">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinbpom_kontrakkerjasama"><?= $Page->kontrakkerjasama->caption() ?></span></td>
        <td data-name="kontrakkerjasama" <?= $Page->kontrakkerjasama->cellAttributes() ?>>
<span id="el_ijinbpom_kontrakkerjasama">
<span<?= $Page->kontrakkerjasama->viewAttributes() ?>>
<?= GetFileViewTag($Page->kontrakkerjasama, $Page->kontrakkerjasama->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->suratkuasa->Visible) { // suratkuasa ?>
    <tr id="r_suratkuasa">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinbpom_suratkuasa"><?= $Page->suratkuasa->caption() ?></span></td>
        <td data-name="suratkuasa" <?= $Page->suratkuasa->cellAttributes() ?>>
<span id="el_ijinbpom_suratkuasa">
<span<?= $Page->suratkuasa->viewAttributes() ?>>
<?= GetFileViewTag($Page->suratkuasa, $Page->suratkuasa->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->suratpembagian->Visible) { // suratpembagian ?>
    <tr id="r_suratpembagian">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinbpom_suratpembagian"><?= $Page->suratpembagian->caption() ?></span></td>
        <td data-name="suratpembagian" <?= $Page->suratpembagian->cellAttributes() ?>>
<span id="el_ijinbpom_suratpembagian">
<span<?= $Page->suratpembagian->viewAttributes() ?>>
<?= GetFileViewTag($Page->suratpembagian, $Page->suratpembagian->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <tr id="r_status">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinbpom_status"><?= $Page->status->caption() ?></span></td>
        <td data-name="status" <?= $Page->status->cellAttributes() ?>>
<span id="el_ijinbpom_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->selesai->Visible) { // selesai ?>
    <tr id="r_selesai">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_ijinbpom_selesai"><?= $Page->selesai->caption() ?></span></td>
        <td data-name="selesai" <?= $Page->selesai->cellAttributes() ?>>
<span id="el_ijinbpom_selesai">
<span<?= $Page->selesai->viewAttributes() ?>>
<?= $Page->selesai->getViewValue() ?></span>
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
<div class="ew-nav-tabs" id="Page_details"><!-- tabs -->
    <ul class="<?= $Page->DetailPages->navStyle() ?>"><!-- .nav -->
<?php
    if (in_array("ijinbpom_detail", explode(",", $Page->getCurrentDetailTable())) && $ijinbpom_detail->DetailView) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "ijinbpom_detail") {
            $firstActiveDetailTable = "ijinbpom_detail";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("ijinbpom_detail") ?>" href="#tab_ijinbpom_detail" data-toggle="tab"><?= $Language->tablePhrase("ijinbpom_detail", "TblCaption") ?>&nbsp;<?= str_replace("%c", Container("ijinbpom_detail")->Count, $Language->phrase("DetailCount")) ?></a></li>
<?php
    }
?>
<?php
    if (in_array("ijinbpom_status", explode(",", $Page->getCurrentDetailTable())) && $ijinbpom_status->DetailView) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "ijinbpom_status") {
            $firstActiveDetailTable = "ijinbpom_status";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("ijinbpom_status") ?>" href="#tab_ijinbpom_status" data-toggle="tab"><?= $Language->tablePhrase("ijinbpom_status", "TblCaption") ?>&nbsp;<?= str_replace("%c", Container("ijinbpom_status")->Count, $Language->phrase("DetailCount")) ?></a></li>
<?php
    }
?>
    </ul><!-- /.nav -->
    <div class="tab-content"><!-- .tab-content -->
<?php
    if (in_array("ijinbpom_detail", explode(",", $Page->getCurrentDetailTable())) && $ijinbpom_detail->DetailView) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "ijinbpom_detail") {
            $firstActiveDetailTable = "ijinbpom_detail";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("ijinbpom_detail") ?>" id="tab_ijinbpom_detail"><!-- page* -->
<?php include_once "IjinbpomDetailGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("ijinbpom_status", explode(",", $Page->getCurrentDetailTable())) && $ijinbpom_status->DetailView) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "ijinbpom_status") {
            $firstActiveDetailTable = "ijinbpom_status";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("ijinbpom_status") ?>" id="tab_ijinbpom_status"><!-- page* -->
<?php include_once "IjinbpomStatusGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
    </div><!-- /.tab-content -->
</div><!-- /tabs -->
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
