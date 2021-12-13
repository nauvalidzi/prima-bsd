<?php

namespace PHPMaker2021\distributor;

// Page object
$NpdSerahterimaView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fnpd_serahterimaview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fnpd_serahterimaview = currentForm = new ew.Form("fnpd_serahterimaview", "view");
    loadjs.done("fnpd_serahterimaview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.npd_serahterima) ew.vars.tables.npd_serahterima = <?= JsonEncode(GetClientVar("tables", "npd_serahterima")) ?>;
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
<form name="fnpd_serahterimaview" id="fnpd_serahterimaview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_serahterima">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
    <tr id="r_idpegawai">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_serahterima_idpegawai"><?= $Page->idpegawai->caption() ?></span></td>
        <td data-name="idpegawai" <?= $Page->idpegawai->cellAttributes() ?>>
<span id="el_npd_serahterima_idpegawai">
<span<?= $Page->idpegawai->viewAttributes() ?>>
<?= $Page->idpegawai->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
    <tr id="r_idcustomer">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_serahterima_idcustomer"><?= $Page->idcustomer->caption() ?></span></td>
        <td data-name="idcustomer" <?= $Page->idcustomer->cellAttributes() ?>>
<span id="el_npd_serahterima_idcustomer">
<span<?= $Page->idcustomer->viewAttributes() ?>>
<?= $Page->idcustomer->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tanggal_request->Visible) { // tanggal_request ?>
    <tr id="r_tanggal_request">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_serahterima_tanggal_request"><?= $Page->tanggal_request->caption() ?></span></td>
        <td data-name="tanggal_request" <?= $Page->tanggal_request->cellAttributes() ?>>
<span id="el_npd_serahterima_tanggal_request">
<span<?= $Page->tanggal_request->viewAttributes() ?>>
<?= $Page->tanggal_request->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tanggal_serahterima->Visible) { // tanggal_serahterima ?>
    <tr id="r_tanggal_serahterima">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_serahterima_tanggal_serahterima"><?= $Page->tanggal_serahterima->caption() ?></span></td>
        <td data-name="tanggal_serahterima" <?= $Page->tanggal_serahterima->cellAttributes() ?>>
<span id="el_npd_serahterima_tanggal_serahterima">
<span<?= $Page->tanggal_serahterima->viewAttributes() ?>>
<?= $Page->tanggal_serahterima->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jenis_produk->Visible) { // jenis_produk ?>
    <tr id="r_jenis_produk">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_serahterima_jenis_produk"><?= $Page->jenis_produk->caption() ?></span></td>
        <td data-name="jenis_produk" <?= $Page->jenis_produk->cellAttributes() ?>>
<span id="el_npd_serahterima_jenis_produk">
<span<?= $Page->jenis_produk->viewAttributes() ?>>
<?= $Page->jenis_produk->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->readonly->Visible) { // readonly ?>
    <tr id="r_readonly">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_serahterima_readonly"><?= $Page->readonly->caption() ?></span></td>
        <td data-name="readonly" <?= $Page->readonly->cellAttributes() ?>>
<span id="el_npd_serahterima_readonly">
<span<?= $Page->readonly->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_readonly_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->readonly->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->readonly->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_readonly_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <tr id="r_created_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_npd_serahterima_created_at"><?= $Page->created_at->caption() ?></span></td>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<span id="el_npd_serahterima_created_at">
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
