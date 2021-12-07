<?php

namespace PHPMaker2021\distributor;

// Page object
$ProductView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fproductview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fproductview = currentForm = new ew.Form("fproductview", "view");
    loadjs.done("fproductview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.product) ew.vars.tables.product = <?= JsonEncode(GetClientVar("tables", "product")) ?>;
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
<form name="fproductview" id="fproductview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="product">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->idbrand->Visible) { // idbrand ?>
    <tr id="r_idbrand">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_product_idbrand"><?= $Page->idbrand->caption() ?></span></td>
        <td data-name="idbrand" <?= $Page->idbrand->cellAttributes() ?>>
<span id="el_product_idbrand">
<span<?= $Page->idbrand->viewAttributes() ?>>
<?= $Page->idbrand->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kode->Visible) { // kode ?>
    <tr id="r_kode">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_product_kode"><?= $Page->kode->caption() ?></span></td>
        <td data-name="kode" <?= $Page->kode->cellAttributes() ?>>
<span id="el_product_kode">
<span<?= $Page->kode->viewAttributes() ?>>
<?= $Page->kode->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <tr id="r_nama">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_product_nama"><?= $Page->nama->caption() ?></span></td>
        <td data-name="nama" <?= $Page->nama->cellAttributes() ?>>
<span id="el_product_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idkategoribarang->Visible) { // idkategoribarang ?>
    <tr id="r_idkategoribarang">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_product_idkategoribarang"><?= $Page->idkategoribarang->caption() ?></span></td>
        <td data-name="idkategoribarang" <?= $Page->idkategoribarang->cellAttributes() ?>>
<span id="el_product_idkategoribarang">
<span<?= $Page->idkategoribarang->viewAttributes() ?>>
<?= $Page->idkategoribarang->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idjenisbarang->Visible) { // idjenisbarang ?>
    <tr id="r_idjenisbarang">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_product_idjenisbarang"><?= $Page->idjenisbarang->caption() ?></span></td>
        <td data-name="idjenisbarang" <?= $Page->idjenisbarang->cellAttributes() ?>>
<span id="el_product_idjenisbarang">
<span<?= $Page->idjenisbarang->viewAttributes() ?>>
<?= $Page->idjenisbarang->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idkualitasbarang->Visible) { // idkualitasbarang ?>
    <tr id="r_idkualitasbarang">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_product_idkualitasbarang"><?= $Page->idkualitasbarang->caption() ?></span></td>
        <td data-name="idkualitasbarang" <?= $Page->idkualitasbarang->cellAttributes() ?>>
<span id="el_product_idkualitasbarang">
<span<?= $Page->idkualitasbarang->viewAttributes() ?>>
<?= $Page->idkualitasbarang->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idproduct_acuan->Visible) { // idproduct_acuan ?>
    <tr id="r_idproduct_acuan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_product_idproduct_acuan"><?= $Page->idproduct_acuan->caption() ?></span></td>
        <td data-name="idproduct_acuan" <?= $Page->idproduct_acuan->cellAttributes() ?>>
<span id="el_product_idproduct_acuan">
<span<?= $Page->idproduct_acuan->viewAttributes() ?>>
<?= $Page->idproduct_acuan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ukuran->Visible) { // ukuran ?>
    <tr id="r_ukuran">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_product_ukuran"><?= $Page->ukuran->caption() ?></span></td>
        <td data-name="ukuran" <?= $Page->ukuran->cellAttributes() ?>>
<span id="el_product_ukuran">
<span<?= $Page->ukuran->viewAttributes() ?>>
<?= $Page->ukuran->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kemasanbarang->Visible) { // kemasanbarang ?>
    <tr id="r_kemasanbarang">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_product_kemasanbarang"><?= $Page->kemasanbarang->caption() ?></span></td>
        <td data-name="kemasanbarang" <?= $Page->kemasanbarang->cellAttributes() ?>>
<span id="el_product_kemasanbarang">
<span<?= $Page->kemasanbarang->viewAttributes() ?>>
<?= $Page->kemasanbarang->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->harga->Visible) { // harga ?>
    <tr id="r_harga">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_product_harga"><?= $Page->harga->caption() ?></span></td>
        <td data-name="harga" <?= $Page->harga->cellAttributes() ?>>
<span id="el_product_harga">
<span<?= $Page->harga->viewAttributes() ?>>
<?= $Page->harga->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bahan->Visible) { // bahan ?>
    <tr id="r_bahan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_product_bahan"><?= $Page->bahan->caption() ?></span></td>
        <td data-name="bahan" <?= $Page->bahan->cellAttributes() ?>>
<span id="el_product_bahan">
<span<?= $Page->bahan->viewAttributes() ?>>
<?= $Page->bahan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->warna->Visible) { // warna ?>
    <tr id="r_warna">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_product_warna"><?= $Page->warna->caption() ?></span></td>
        <td data-name="warna" <?= $Page->warna->cellAttributes() ?>>
<span id="el_product_warna">
<span<?= $Page->warna->viewAttributes() ?>>
<?= $Page->warna->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->parfum->Visible) { // parfum ?>
    <tr id="r_parfum">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_product_parfum"><?= $Page->parfum->caption() ?></span></td>
        <td data-name="parfum" <?= $Page->parfum->cellAttributes() ?>>
<span id="el_product_parfum">
<span<?= $Page->parfum->viewAttributes() ?>>
<?= $Page->parfum->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->label->Visible) { // label ?>
    <tr id="r_label">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_product_label"><?= $Page->label->caption() ?></span></td>
        <td data-name="label" <?= $Page->label->cellAttributes() ?>>
<span id="el_product_label">
<span<?= $Page->label->viewAttributes() ?>>
<?= $Page->label->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
    <tr id="r_foto">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_product_foto"><?= $Page->foto->caption() ?></span></td>
        <td data-name="foto" <?= $Page->foto->cellAttributes() ?>>
<span id="el_product_foto">
<span<?= $Page->foto->viewAttributes() ?>>
<?= GetFileViewTag($Page->foto, $Page->foto->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tambahan->Visible) { // tambahan ?>
    <tr id="r_tambahan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_product_tambahan"><?= $Page->tambahan->caption() ?></span></td>
        <td data-name="tambahan" <?= $Page->tambahan->cellAttributes() ?>>
<span id="el_product_tambahan">
<span<?= $Page->tambahan->viewAttributes() ?>>
<?= $Page->tambahan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ijinbpom->Visible) { // ijinbpom ?>
    <tr id="r_ijinbpom">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_product_ijinbpom"><?= $Page->ijinbpom->caption() ?></span></td>
        <td data-name="ijinbpom" <?= $Page->ijinbpom->cellAttributes() ?>>
<span id="el_product_ijinbpom">
<span<?= $Page->ijinbpom->viewAttributes() ?>>
<?= $Page->ijinbpom->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aktif->Visible) { // aktif ?>
    <tr id="r_aktif">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_product_aktif"><?= $Page->aktif->caption() ?></span></td>
        <td data-name="aktif" <?= $Page->aktif->cellAttributes() ?>>
<span id="el_product_aktif">
<span<?= $Page->aktif->viewAttributes() ?>>
<?= $Page->aktif->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <tr id="r_updated_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_product_updated_at"><?= $Page->updated_at->caption() ?></span></td>
        <td data-name="updated_at" <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_product_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
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
