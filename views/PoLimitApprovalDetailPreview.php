<?php

namespace PHPMaker2021\production2;

// Page object
$PoLimitApprovalDetailPreview = &$Page;
?>
<script>
if (!ew.vars.tables.po_limit_approval_detail) ew.vars.tables.po_limit_approval_detail = <?= JsonEncode(GetClientVar("tables", "po_limit_approval_detail")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid po_limit_approval_detail"><!-- .card -->
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
<?php if ($Page->idorder->Visible) { // idorder ?>
    <?php if ($Page->SortUrl($Page->idorder) == "") { ?>
        <th class="<?= $Page->idorder->headerCellClass() ?>"><?= $Page->idorder->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->idorder->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->idorder->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->idorder->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->idorder->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->idorder->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->idorder->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->kredit_terpakai->Visible) { // kredit_terpakai ?>
    <?php if ($Page->SortUrl($Page->kredit_terpakai) == "") { ?>
        <th class="<?= $Page->kredit_terpakai->headerCellClass() ?>"><?= $Page->kredit_terpakai->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->kredit_terpakai->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->kredit_terpakai->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->kredit_terpakai->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->kredit_terpakai->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->kredit_terpakai->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->kredit_terpakai->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <?php if ($Page->SortUrl($Page->created_at) == "") { ?>
        <th class="<?= $Page->created_at->headerCellClass() ?>"><?= $Page->created_at->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->created_at->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->created_at->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->created_at->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->created_at->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->created_at->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->created_at->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->idorder->Visible) { // idorder ?>
        <!-- idorder -->
        <td<?= $Page->idorder->cellAttributes() ?>>
<span<?= $Page->idorder->viewAttributes() ?>>
<?= $Page->idorder->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->kredit_terpakai->Visible) { // kredit_terpakai ?>
        <!-- kredit_terpakai -->
        <td<?= $Page->kredit_terpakai->cellAttributes() ?>>
<span<?= $Page->kredit_terpakai->viewAttributes() ?>>
<?= $Page->kredit_terpakai->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <!-- created_at -->
        <td<?= $Page->created_at->cellAttributes() ?>>
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
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
