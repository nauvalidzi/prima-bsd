<?php

namespace PHPMaker2021\distributor;

// Page object
$AlamatCustomerDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var falamat_customerdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    falamat_customerdelete = currentForm = new ew.Form("falamat_customerdelete", "delete");
    loadjs.done("falamat_customerdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.alamat_customer) ew.vars.tables.alamat_customer = <?= JsonEncode(GetClientVar("tables", "alamat_customer")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="falamat_customerdelete" id="falamat_customerdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="alamat_customer">
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
<?php if ($Page->alias->Visible) { // alias ?>
        <th class="<?= $Page->alias->headerCellClass() ?>"><span id="elh_alamat_customer_alias" class="alamat_customer_alias"><?= $Page->alias->caption() ?></span></th>
<?php } ?>
<?php if ($Page->penerima->Visible) { // penerima ?>
        <th class="<?= $Page->penerima->headerCellClass() ?>"><span id="elh_alamat_customer_penerima" class="alamat_customer_penerima"><?= $Page->penerima->caption() ?></span></th>
<?php } ?>
<?php if ($Page->telepon->Visible) { // telepon ?>
        <th class="<?= $Page->telepon->headerCellClass() ?>"><span id="elh_alamat_customer_telepon" class="alamat_customer_telepon"><?= $Page->telepon->caption() ?></span></th>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
        <th class="<?= $Page->alamat->headerCellClass() ?>"><span id="elh_alamat_customer_alamat" class="alamat_customer_alamat"><?= $Page->alamat->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idprovinsi->Visible) { // idprovinsi ?>
        <th class="<?= $Page->idprovinsi->headerCellClass() ?>"><span id="elh_alamat_customer_idprovinsi" class="alamat_customer_idprovinsi"><?= $Page->idprovinsi->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idkabupaten->Visible) { // idkabupaten ?>
        <th class="<?= $Page->idkabupaten->headerCellClass() ?>"><span id="elh_alamat_customer_idkabupaten" class="alamat_customer_idkabupaten"><?= $Page->idkabupaten->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idkecamatan->Visible) { // idkecamatan ?>
        <th class="<?= $Page->idkecamatan->headerCellClass() ?>"><span id="elh_alamat_customer_idkecamatan" class="alamat_customer_idkecamatan"><?= $Page->idkecamatan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idkelurahan->Visible) { // idkelurahan ?>
        <th class="<?= $Page->idkelurahan->headerCellClass() ?>"><span id="elh_alamat_customer_idkelurahan" class="alamat_customer_idkelurahan"><?= $Page->idkelurahan->caption() ?></span></th>
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
<?php if ($Page->alias->Visible) { // alias ?>
        <td <?= $Page->alias->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_alamat_customer_alias" class="alamat_customer_alias">
<span<?= $Page->alias->viewAttributes() ?>>
<?= $Page->alias->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->penerima->Visible) { // penerima ?>
        <td <?= $Page->penerima->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_alamat_customer_penerima" class="alamat_customer_penerima">
<span<?= $Page->penerima->viewAttributes() ?>>
<?= $Page->penerima->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->telepon->Visible) { // telepon ?>
        <td <?= $Page->telepon->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_alamat_customer_telepon" class="alamat_customer_telepon">
<span<?= $Page->telepon->viewAttributes() ?>>
<?= $Page->telepon->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
        <td <?= $Page->alamat->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_alamat_customer_alamat" class="alamat_customer_alamat">
<span<?= $Page->alamat->viewAttributes() ?>>
<?= $Page->alamat->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idprovinsi->Visible) { // idprovinsi ?>
        <td <?= $Page->idprovinsi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_alamat_customer_idprovinsi" class="alamat_customer_idprovinsi">
<span<?= $Page->idprovinsi->viewAttributes() ?>>
<?= $Page->idprovinsi->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idkabupaten->Visible) { // idkabupaten ?>
        <td <?= $Page->idkabupaten->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_alamat_customer_idkabupaten" class="alamat_customer_idkabupaten">
<span<?= $Page->idkabupaten->viewAttributes() ?>>
<?= $Page->idkabupaten->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idkecamatan->Visible) { // idkecamatan ?>
        <td <?= $Page->idkecamatan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_alamat_customer_idkecamatan" class="alamat_customer_idkecamatan">
<span<?= $Page->idkecamatan->viewAttributes() ?>>
<?= $Page->idkecamatan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idkelurahan->Visible) { // idkelurahan ?>
        <td <?= $Page->idkelurahan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_alamat_customer_idkelurahan" class="alamat_customer_idkelurahan">
<span<?= $Page->idkelurahan->viewAttributes() ?>>
<?= $Page->idkelurahan->getViewValue() ?></span>
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
