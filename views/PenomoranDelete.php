<?php

namespace PHPMaker2021\distributor;

// Page object
$PenomoranDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fpenomorandelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fpenomorandelete = currentForm = new ew.Form("fpenomorandelete", "delete");
    loadjs.done("fpenomorandelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.penomoran) ew.vars.tables.penomoran = <?= JsonEncode(GetClientVar("tables", "penomoran")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fpenomorandelete" id="fpenomorandelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="penomoran">
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
<?php if ($Page->_menu->Visible) { // menu ?>
        <th class="<?= $Page->_menu->headerCellClass() ?>"><span id="elh_penomoran__menu" class="penomoran__menu"><?= $Page->_menu->caption() ?></span></th>
<?php } ?>
<?php if ($Page->jumlah_digit->Visible) { // jumlah_digit ?>
        <th class="<?= $Page->jumlah_digit->headerCellClass() ?>"><span id="elh_penomoran_jumlah_digit" class="penomoran_jumlah_digit"><?= $Page->jumlah_digit->caption() ?></span></th>
<?php } ?>
<?php if ($Page->format->Visible) { // format ?>
        <th class="<?= $Page->format->headerCellClass() ?>"><span id="elh_penomoran_format" class="penomoran_format"><?= $Page->format->caption() ?></span></th>
<?php } ?>
<?php if ($Page->display->Visible) { // display ?>
        <th class="<?= $Page->display->headerCellClass() ?>"><span id="elh_penomoran_display" class="penomoran_display"><?= $Page->display->caption() ?></span></th>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <th class="<?= $Page->updated_at->headerCellClass() ?>"><span id="elh_penomoran_updated_at" class="penomoran_updated_at"><?= $Page->updated_at->caption() ?></span></th>
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
<?php if ($Page->_menu->Visible) { // menu ?>
        <td <?= $Page->_menu->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penomoran__menu" class="penomoran__menu">
<span<?= $Page->_menu->viewAttributes() ?>>
<?= $Page->_menu->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->jumlah_digit->Visible) { // jumlah_digit ?>
        <td <?= $Page->jumlah_digit->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penomoran_jumlah_digit" class="penomoran_jumlah_digit">
<span<?= $Page->jumlah_digit->viewAttributes() ?>>
<?= $Page->jumlah_digit->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->format->Visible) { // format ?>
        <td <?= $Page->format->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penomoran_format" class="penomoran_format">
<span<?= $Page->format->viewAttributes() ?>>
<?= $Page->format->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->display->Visible) { // display ?>
        <td <?= $Page->display->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penomoran_display" class="penomoran_display">
<span<?= $Page->display->viewAttributes() ?>>
<?= $Page->display->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <td <?= $Page->updated_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penomoran_updated_at" class="penomoran_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
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
