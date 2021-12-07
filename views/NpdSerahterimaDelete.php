<?php

namespace PHPMaker2021\distributor;

// Page object
$NpdSerahterimaDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpd_serahterimadelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fnpd_serahterimadelete = currentForm = new ew.Form("fnpd_serahterimadelete", "delete");
    loadjs.done("fnpd_serahterimadelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.npd_serahterima) ew.vars.tables.npd_serahterima = <?= JsonEncode(GetClientVar("tables", "npd_serahterima")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fnpd_serahterimadelete" id="fnpd_serahterimadelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_serahterima">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->id->Visible) { // id ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_npd_serahterima_id" class="npd_serahterima_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
        <th class="<?= $Page->idpegawai->headerCellClass() ?>"><span id="elh_npd_serahterima_idpegawai" class="npd_serahterima_idpegawai"><?= $Page->idpegawai->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <th class="<?= $Page->idcustomer->headerCellClass() ?>"><span id="elh_npd_serahterima_idcustomer" class="npd_serahterima_idcustomer"><?= $Page->idcustomer->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tanggal_request->Visible) { // tanggal_request ?>
        <th class="<?= $Page->tanggal_request->headerCellClass() ?>"><span id="elh_npd_serahterima_tanggal_request" class="npd_serahterima_tanggal_request"><?= $Page->tanggal_request->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tanggal_serahterima->Visible) { // tanggal_serahterima ?>
        <th class="<?= $Page->tanggal_serahterima->headerCellClass() ?>"><span id="elh_npd_serahterima_tanggal_serahterima" class="npd_serahterima_tanggal_serahterima"><?= $Page->tanggal_serahterima->caption() ?></span></th>
<?php } ?>
<?php if ($Page->jenis_produk->Visible) { // jenis_produk ?>
        <th class="<?= $Page->jenis_produk->headerCellClass() ?>"><span id="elh_npd_serahterima_jenis_produk" class="npd_serahterima_jenis_produk"><?= $Page->jenis_produk->caption() ?></span></th>
<?php } ?>
<?php if ($Page->readonly->Visible) { // readonly ?>
        <th class="<?= $Page->readonly->headerCellClass() ?>"><span id="elh_npd_serahterima_readonly" class="npd_serahterima_readonly"><?= $Page->readonly->caption() ?></span></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th class="<?= $Page->created_at->headerCellClass() ?>"><span id="elh_npd_serahterima_created_at" class="npd_serahterima_created_at"><?= $Page->created_at->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->id->Visible) { // id ?>
        <td <?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_serahterima_id" class="npd_serahterima_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
        <td <?= $Page->idpegawai->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_serahterima_idpegawai" class="npd_serahterima_idpegawai">
<span<?= $Page->idpegawai->viewAttributes() ?>>
<?= $Page->idpegawai->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <td <?= $Page->idcustomer->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_serahterima_idcustomer" class="npd_serahterima_idcustomer">
<span<?= $Page->idcustomer->viewAttributes() ?>>
<?= $Page->idcustomer->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tanggal_request->Visible) { // tanggal_request ?>
        <td <?= $Page->tanggal_request->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_serahterima_tanggal_request" class="npd_serahterima_tanggal_request">
<span<?= $Page->tanggal_request->viewAttributes() ?>>
<?= $Page->tanggal_request->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tanggal_serahterima->Visible) { // tanggal_serahterima ?>
        <td <?= $Page->tanggal_serahterima->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_serahterima_tanggal_serahterima" class="npd_serahterima_tanggal_serahterima">
<span<?= $Page->tanggal_serahterima->viewAttributes() ?>>
<?= $Page->tanggal_serahterima->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->jenis_produk->Visible) { // jenis_produk ?>
        <td <?= $Page->jenis_produk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_serahterima_jenis_produk" class="npd_serahterima_jenis_produk">
<span<?= $Page->jenis_produk->viewAttributes() ?>>
<?= $Page->jenis_produk->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->readonly->Visible) { // readonly ?>
        <td <?= $Page->readonly->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_serahterima_readonly" class="npd_serahterima_readonly">
<span<?= $Page->readonly->viewAttributes() ?>>
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" id="x_readonly_<?= $Page->RowCount ?>" class="custom-control-input" value="<?= $Page->readonly->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->readonly->CurrentValue)) { ?> checked<?php } ?>>
    <label class="custom-control-label" for="x_readonly_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <td <?= $Page->created_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_npd_serahterima_created_at" class="npd_serahterima_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
