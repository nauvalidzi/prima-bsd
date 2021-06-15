<?php

namespace PHPMaker2021\distributor;

// Page object
$VBonuscustomerDetailPreview = &$Page;
?>
<script>
if (!ew.vars.tables.v_bonuscustomer_detail) ew.vars.tables.v_bonuscustomer_detail = <?= JsonEncode(GetClientVar("tables", "v_bonuscustomer_detail")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid v_bonuscustomer_detail"><!-- .card -->
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel ew-preview-middle-panel"><!-- .table-responsive -->
<table class="table ew-table ew-preview-table"><!-- .table -->
    <thead><!-- Table header -->
        <tr class="ew-table-header">
<?php
// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
    <?php if ($Page->SortUrl($Page->idcustomer) == "") { ?>
        <th class="<?= $Page->idcustomer->headerCellClass() ?>"><?= $Page->idcustomer->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->idcustomer->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->idcustomer->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->idcustomer->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->idcustomer->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->idcustomer->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->idcustomer->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->idinvoice->Visible) { // idinvoice ?>
    <?php if ($Page->SortUrl($Page->idinvoice) == "") { ?>
        <th class="<?= $Page->idinvoice->headerCellClass() ?>"><?= $Page->idinvoice->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->idinvoice->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->idinvoice->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->idinvoice->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->idinvoice->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->idinvoice->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->idinvoice->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->blackbonus->Visible) { // blackbonus ?>
    <?php if ($Page->SortUrl($Page->blackbonus) == "") { ?>
        <th class="<?= $Page->blackbonus->headerCellClass() ?>"><?= $Page->blackbonus->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->blackbonus->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->blackbonus->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->blackbonus->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->blackbonus->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->blackbonus->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->blackbonus->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
        </tr>
    </thead>
    <tbody><!-- Table body -->
<?php
$Page->RecCount = 0;
$Page->RowCount = 0;
while ($Page->Recordset && !$Page->Recordset->EOF) {
    // Init row class and style
    $Page->RecCount++;
    $Page->RowCount++;
    $Page->CssStyle = "";
    $Page->loadListRowValues($Page->Recordset);

    // Render row
    $Page->RowType = ROWTYPE_PREVIEW; // Preview record
    $Page->resetAttributes();
    $Page->renderListRow();

    // Render list options
    $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <!-- idcustomer -->
        <td<?= $Page->idcustomer->cellAttributes() ?>>
<span<?= $Page->idcustomer->viewAttributes() ?>>
<?= $Page->idcustomer->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->idinvoice->Visible) { // idinvoice ?>
        <!-- idinvoice -->
        <td<?= $Page->idinvoice->cellAttributes() ?>>
<span<?= $Page->idinvoice->viewAttributes() ?>>
<?= $Page->idinvoice->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->blackbonus->Visible) { // blackbonus ?>
        <!-- blackbonus -->
        <td<?= $Page->blackbonus->cellAttributes() ?>>
<span<?= $Page->blackbonus->viewAttributes() ?>>
<?= $Page->blackbonus->getViewValue() ?></span>
</td>
<?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    $Page->Recordset->moveNext();
} // while
?>
    </tbody>
</table><!-- /.table -->
</div><!-- /.table-responsive -->
<div class="card-footer ew-grid-lower-panel ew-preview-lower-panel"><!-- .card-footer -->
<?= $Page->Pager->render() ?>
<?php } else { // No record ?>
<div class="card no-border">
<div class="ew-detail-count"><?= $Language->phrase("NoRecord") ?></div>
<?php } ?>
<div class="ew-preview-other-options">
<?php
    foreach ($Page->OtherOptions as $option)
        $option->render("body");
?>
</div>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="clearfix"></div>
</div><!-- /.card-footer -->
<?php } ?>
</div><!-- /.card -->
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
