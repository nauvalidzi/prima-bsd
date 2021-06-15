<?php

namespace PHPMaker2021\distributor;

// Page object
$CustomerView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fcustomerview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fcustomerview = currentForm = new ew.Form("fcustomerview", "view");
    loadjs.done("fcustomerview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.customer) ew.vars.tables.customer = <?= JsonEncode(GetClientVar("tables", "customer")) ?>;
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
<form name="fcustomerview" id="fcustomerview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="customer">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->kode->Visible) { // kode ?>
    <tr id="r_kode">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customer_kode"><?= $Page->kode->caption() ?></span></td>
        <td data-name="kode" <?= $Page->kode->cellAttributes() ?>>
<span id="el_customer_kode">
<span<?= $Page->kode->viewAttributes() ?>>
<?= $Page->kode->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idtipecustomer->Visible) { // idtipecustomer ?>
    <tr id="r_idtipecustomer">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customer_idtipecustomer"><?= $Page->idtipecustomer->caption() ?></span></td>
        <td data-name="idtipecustomer" <?= $Page->idtipecustomer->cellAttributes() ?>>
<span id="el_customer_idtipecustomer">
<span<?= $Page->idtipecustomer->viewAttributes() ?>>
<?= $Page->idtipecustomer->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
    <tr id="r_idpegawai">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customer_idpegawai"><?= $Page->idpegawai->caption() ?></span></td>
        <td data-name="idpegawai" <?= $Page->idpegawai->cellAttributes() ?>>
<span id="el_customer_idpegawai">
<span<?= $Page->idpegawai->viewAttributes() ?>>
<?= $Page->idpegawai->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <tr id="r_nama">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customer_nama"><?= $Page->nama->caption() ?></span></td>
        <td data-name="nama" <?= $Page->nama->cellAttributes() ?>>
<span id="el_customer_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kodenpd->Visible) { // kodenpd ?>
    <tr id="r_kodenpd">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customer_kodenpd"><?= $Page->kodenpd->caption() ?></span></td>
        <td data-name="kodenpd" <?= $Page->kodenpd->cellAttributes() ?>>
<span id="el_customer_kodenpd">
<span<?= $Page->kodenpd->viewAttributes() ?>>
<?= $Page->kodenpd->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usaha->Visible) { // usaha ?>
    <tr id="r_usaha">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customer_usaha"><?= $Page->usaha->caption() ?></span></td>
        <td data-name="usaha" <?= $Page->usaha->cellAttributes() ?>>
<span id="el_customer_usaha">
<span<?= $Page->usaha->viewAttributes() ?>>
<?= $Page->usaha->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jabatan->Visible) { // jabatan ?>
    <tr id="r_jabatan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customer_jabatan"><?= $Page->jabatan->caption() ?></span></td>
        <td data-name="jabatan" <?= $Page->jabatan->cellAttributes() ?>>
<span id="el_customer_jabatan">
<span<?= $Page->jabatan->viewAttributes() ?>>
<?= $Page->jabatan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ktp->Visible) { // ktp ?>
    <tr id="r_ktp">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customer_ktp"><?= $Page->ktp->caption() ?></span></td>
        <td data-name="ktp" <?= $Page->ktp->cellAttributes() ?>>
<span id="el_customer_ktp">
<span<?= $Page->ktp->viewAttributes() ?>>
<?= GetFileViewTag($Page->ktp, $Page->ktp->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->npwp->Visible) { // npwp ?>
    <tr id="r_npwp">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customer_npwp"><?= $Page->npwp->caption() ?></span></td>
        <td data-name="npwp" <?= $Page->npwp->cellAttributes() ?>>
<span id="el_customer_npwp">
<span<?= $Page->npwp->viewAttributes() ?>>
<?= GetFileViewTag($Page->npwp, $Page->npwp->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idprov->Visible) { // idprov ?>
    <tr id="r_idprov">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customer_idprov"><?= $Page->idprov->caption() ?></span></td>
        <td data-name="idprov" <?= $Page->idprov->cellAttributes() ?>>
<span id="el_customer_idprov">
<span<?= $Page->idprov->viewAttributes() ?>>
<?= $Page->idprov->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idkab->Visible) { // idkab ?>
    <tr id="r_idkab">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customer_idkab"><?= $Page->idkab->caption() ?></span></td>
        <td data-name="idkab" <?= $Page->idkab->cellAttributes() ?>>
<span id="el_customer_idkab">
<span<?= $Page->idkab->viewAttributes() ?>>
<?= $Page->idkab->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idkec->Visible) { // idkec ?>
    <tr id="r_idkec">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customer_idkec"><?= $Page->idkec->caption() ?></span></td>
        <td data-name="idkec" <?= $Page->idkec->cellAttributes() ?>>
<span id="el_customer_idkec">
<span<?= $Page->idkec->viewAttributes() ?>>
<?= $Page->idkec->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idkel->Visible) { // idkel ?>
    <tr id="r_idkel">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customer_idkel"><?= $Page->idkel->caption() ?></span></td>
        <td data-name="idkel" <?= $Page->idkel->cellAttributes() ?>>
<span id="el_customer_idkel">
<span<?= $Page->idkel->viewAttributes() ?>>
<?= $Page->idkel->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kodepos->Visible) { // kodepos ?>
    <tr id="r_kodepos">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customer_kodepos"><?= $Page->kodepos->caption() ?></span></td>
        <td data-name="kodepos" <?= $Page->kodepos->cellAttributes() ?>>
<span id="el_customer_kodepos">
<span<?= $Page->kodepos->viewAttributes() ?>>
<?= $Page->kodepos->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
    <tr id="r_alamat">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customer_alamat"><?= $Page->alamat->caption() ?></span></td>
        <td data-name="alamat" <?= $Page->alamat->cellAttributes() ?>>
<span id="el_customer_alamat">
<span<?= $Page->alamat->viewAttributes() ?>>
<?= $Page->alamat->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->telpon->Visible) { // telpon ?>
    <tr id="r_telpon">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customer_telpon"><?= $Page->telpon->caption() ?></span></td>
        <td data-name="telpon" <?= $Page->telpon->cellAttributes() ?>>
<span id="el_customer_telpon">
<span<?= $Page->telpon->viewAttributes() ?>>
<?= $Page->telpon->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hp->Visible) { // hp ?>
    <tr id="r_hp">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customer_hp"><?= $Page->hp->caption() ?></span></td>
        <td data-name="hp" <?= $Page->hp->cellAttributes() ?>>
<span id="el_customer_hp">
<span<?= $Page->hp->viewAttributes() ?>>
<?= $Page->hp->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <tr id="r__email">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customer__email"><?= $Page->_email->caption() ?></span></td>
        <td data-name="_email" <?= $Page->_email->cellAttributes() ?>>
<span id="el_customer__email">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->website->Visible) { // website ?>
    <tr id="r_website">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customer_website"><?= $Page->website->caption() ?></span></td>
        <td data-name="website" <?= $Page->website->cellAttributes() ?>>
<span id="el_customer_website">
<span<?= $Page->website->viewAttributes() ?>>
<?= $Page->website->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
    <tr id="r_foto">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customer_foto"><?= $Page->foto->caption() ?></span></td>
        <td data-name="foto" <?= $Page->foto->cellAttributes() ?>>
<span id="el_customer_foto">
<span>
<?= GetFileViewTag($Page->foto, $Page->foto->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->budget_bonus_persen->Visible) { // budget_bonus_persen ?>
    <tr id="r_budget_bonus_persen">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customer_budget_bonus_persen"><?= $Page->budget_bonus_persen->caption() ?></span></td>
        <td data-name="budget_bonus_persen" <?= $Page->budget_bonus_persen->cellAttributes() ?>>
<span id="el_customer_budget_bonus_persen">
<span<?= $Page->budget_bonus_persen->viewAttributes() ?>>
<?= $Page->budget_bonus_persen->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hutang_max->Visible) { // hutang_max ?>
    <tr id="r_hutang_max">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customer_hutang_max"><?= $Page->hutang_max->caption() ?></span></td>
        <td data-name="hutang_max" <?= $Page->hutang_max->cellAttributes() ?>>
<span id="el_customer_hutang_max">
<span<?= $Page->hutang_max->viewAttributes() ?>>
<?= $Page->hutang_max->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <tr id="r_keterangan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customer_keterangan"><?= $Page->keterangan->caption() ?></span></td>
        <td data-name="keterangan" <?= $Page->keterangan->cellAttributes() ?>>
<span id="el_customer_keterangan">
<span<?= $Page->keterangan->viewAttributes() ?>>
<?= $Page->keterangan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aktif->Visible) { // aktif ?>
    <tr id="r_aktif">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_customer_aktif"><?= $Page->aktif->caption() ?></span></td>
        <td data-name="aktif" <?= $Page->aktif->cellAttributes() ?>>
<span id="el_customer_aktif">
<span<?= $Page->aktif->viewAttributes() ?>>
<?= $Page->aktif->getViewValue() ?></span>
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
    if (in_array("alamat_customer", explode(",", $Page->getCurrentDetailTable())) && $alamat_customer->DetailView) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "alamat_customer") {
            $firstActiveDetailTable = "alamat_customer";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("alamat_customer") ?>" href="#tab_alamat_customer" data-toggle="tab"><?= $Language->tablePhrase("alamat_customer", "TblCaption") ?>&nbsp;<?= str_replace("%c", Container("alamat_customer")->Count, $Language->phrase("DetailCount")) ?></a></li>
<?php
    }
?>
<?php
    if (in_array("brand", explode(",", $Page->getCurrentDetailTable())) && $brand->DetailView) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "brand") {
            $firstActiveDetailTable = "brand";
        }
?>
        <li class="nav-item"><a class="nav-link <?= $Page->DetailPages->pageStyle("brand") ?>" href="#tab_brand" data-toggle="tab"><?= $Language->tablePhrase("brand", "TblCaption") ?>&nbsp;<?= str_replace("%c", Container("brand")->Count, $Language->phrase("DetailCount")) ?></a></li>
<?php
    }
?>
    </ul><!-- /.nav -->
    <div class="tab-content"><!-- .tab-content -->
<?php
    if (in_array("alamat_customer", explode(",", $Page->getCurrentDetailTable())) && $alamat_customer->DetailView) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "alamat_customer") {
            $firstActiveDetailTable = "alamat_customer";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("alamat_customer") ?>" id="tab_alamat_customer"><!-- page* -->
<?php include_once "AlamatCustomerGrid.php" ?>
        </div><!-- /page* -->
<?php } ?>
<?php
    if (in_array("brand", explode(",", $Page->getCurrentDetailTable())) && $brand->DetailView) {
        if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "brand") {
            $firstActiveDetailTable = "brand";
        }
?>
        <div class="tab-pane <?= $Page->DetailPages->pageStyle("brand") ?>" id="tab_brand"><!-- page* -->
<?php include_once "BrandGrid.php" ?>
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
