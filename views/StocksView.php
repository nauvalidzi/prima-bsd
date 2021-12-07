<?php

namespace PHPMaker2021\distributor;

// Page object
$StocksView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fstocksview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fstocksview = currentForm = new ew.Form("fstocksview", "view");
    loadjs.done("fstocksview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.stocks) ew.vars.tables.stocks = <?= JsonEncode(GetClientVar("tables", "stocks")) ?>;
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
<form name="fstocksview" id="fstocksview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="stocks">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->prop_id->Visible) { // prop_id ?>
    <tr id="r_prop_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_stocks_prop_id"><?= $Page->prop_id->caption() ?></span></td>
        <td data-name="prop_id" <?= $Page->prop_id->cellAttributes() ?>>
<span id="el_stocks_prop_id">
<span<?= $Page->prop_id->viewAttributes() ?>>
<?= $Page->prop_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->prop_code->Visible) { // prop_code ?>
    <tr id="r_prop_code">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_stocks_prop_code"><?= $Page->prop_code->caption() ?></span></td>
        <td data-name="prop_code" <?= $Page->prop_code->cellAttributes() ?>>
<span id="el_stocks_prop_code">
<span<?= $Page->prop_code->viewAttributes() ?>>
<?= $Page->prop_code->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idproduct->Visible) { // idproduct ?>
    <tr id="r_idproduct">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_stocks_idproduct"><?= $Page->idproduct->caption() ?></span></td>
        <td data-name="idproduct" <?= $Page->idproduct->cellAttributes() ?>>
<span id="el_stocks_idproduct">
<span<?= $Page->idproduct->viewAttributes() ?>>
<?= $Page->idproduct->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->stok_masuk->Visible) { // stok_masuk ?>
    <tr id="r_stok_masuk">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_stocks_stok_masuk"><?= $Page->stok_masuk->caption() ?></span></td>
        <td data-name="stok_masuk" <?= $Page->stok_masuk->cellAttributes() ?>>
<span id="el_stocks_stok_masuk">
<span<?= $Page->stok_masuk->viewAttributes() ?>>
<?= $Page->stok_masuk->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->stok_keluar->Visible) { // stok_keluar ?>
    <tr id="r_stok_keluar">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_stocks_stok_keluar"><?= $Page->stok_keluar->caption() ?></span></td>
        <td data-name="stok_keluar" <?= $Page->stok_keluar->cellAttributes() ?>>
<span id="el_stocks_stok_keluar">
<span<?= $Page->stok_keluar->viewAttributes() ?>>
<?= $Page->stok_keluar->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->stok_akhir->Visible) { // stok_akhir ?>
    <tr id="r_stok_akhir">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_stocks_stok_akhir"><?= $Page->stok_akhir->caption() ?></span></td>
        <td data-name="stok_akhir" <?= $Page->stok_akhir->cellAttributes() ?>>
<span id="el_stocks_stok_akhir">
<span<?= $Page->stok_akhir->viewAttributes() ?>>
<?= $Page->stok_akhir->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aktif->Visible) { // aktif ?>
    <tr id="r_aktif">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_stocks_aktif"><?= $Page->aktif->caption() ?></span></td>
        <td data-name="aktif" <?= $Page->aktif->cellAttributes() ?>>
<span id="el_stocks_aktif">
<span<?= $Page->aktif->viewAttributes() ?>>
<?= $Page->aktif->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <tr id="r_keterangan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_stocks_keterangan"><?= $Page->keterangan->caption() ?></span></td>
        <td data-name="keterangan" <?= $Page->keterangan->cellAttributes() ?>>
<span id="el_stocks_keterangan">
<span<?= $Page->keterangan->viewAttributes() ?>>
<?= $Page->keterangan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <tr id="r_created_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_stocks_created_at"><?= $Page->created_at->caption() ?></span></td>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<span id="el_stocks_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
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
