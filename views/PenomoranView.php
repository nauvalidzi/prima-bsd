<?php

namespace PHPMaker2021\distributor;

// Page object
$PenomoranView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fpenomoranview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fpenomoranview = currentForm = new ew.Form("fpenomoranview", "view");
    loadjs.done("fpenomoranview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.penomoran) ew.vars.tables.penomoran = <?= JsonEncode(GetClientVar("tables", "penomoran")) ?>;
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
<form name="fpenomoranview" id="fpenomoranview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="penomoran">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->_menu->Visible) { // menu ?>
    <tr id="r__menu">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_penomoran__menu"><?= $Page->_menu->caption() ?></span></td>
        <td data-name="_menu" <?= $Page->_menu->cellAttributes() ?>>
<span id="el_penomoran__menu">
<span<?= $Page->_menu->viewAttributes() ?>>
<?= $Page->_menu->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jumlah_digit->Visible) { // jumlah_digit ?>
    <tr id="r_jumlah_digit">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_penomoran_jumlah_digit"><?= $Page->jumlah_digit->caption() ?></span></td>
        <td data-name="jumlah_digit" <?= $Page->jumlah_digit->cellAttributes() ?>>
<span id="el_penomoran_jumlah_digit">
<span<?= $Page->jumlah_digit->viewAttributes() ?>>
<?= $Page->jumlah_digit->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->format->Visible) { // format ?>
    <tr id="r_format">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_penomoran_format"><?= $Page->format->caption() ?></span></td>
        <td data-name="format" <?= $Page->format->cellAttributes() ?>>
<span id="el_penomoran_format">
<span<?= $Page->format->viewAttributes() ?>>
<?= $Page->format->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->display->Visible) { // display ?>
    <tr id="r_display">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_penomoran_display"><?= $Page->display->caption() ?></span></td>
        <td data-name="display" <?= $Page->display->cellAttributes() ?>>
<span id="el_penomoran_display">
<span<?= $Page->display->viewAttributes() ?>>
<?= $Page->display->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <tr id="r_updated_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_penomoran_updated_at"><?= $Page->updated_at->caption() ?></span></td>
        <td data-name="updated_at" <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_penomoran_updated_at">
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
