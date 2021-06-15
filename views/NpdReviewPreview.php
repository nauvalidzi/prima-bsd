<?php

namespace PHPMaker2021\distributor;

// Page object
$NpdReviewPreview = &$Page;
?>
<script>
if (!ew.vars.tables.npd_review) ew.vars.tables.npd_review = <?= JsonEncode(GetClientVar("tables", "npd_review")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid npd_review"><!-- .card -->
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
<?php if ($Page->idnpd->Visible) { // idnpd ?>
    <?php if ($Page->SortUrl($Page->idnpd) == "") { ?>
        <th class="<?= $Page->idnpd->headerCellClass() ?>"><?= $Page->idnpd->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->idnpd->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->idnpd->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->idnpd->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->idnpd->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->idnpd->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->idnpd->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->idnpd_sample->Visible) { // idnpd_sample ?>
    <?php if ($Page->SortUrl($Page->idnpd_sample) == "") { ?>
        <th class="<?= $Page->idnpd_sample->headerCellClass() ?>"><?= $Page->idnpd_sample->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->idnpd_sample->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->idnpd_sample->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->idnpd_sample->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->idnpd_sample->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->idnpd_sample->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->idnpd_sample->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->tglreview->Visible) { // tglreview ?>
    <?php if ($Page->SortUrl($Page->tglreview) == "") { ?>
        <th class="<?= $Page->tglreview->headerCellClass() ?>"><?= $Page->tglreview->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->tglreview->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->tglreview->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->tglreview->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->tglreview->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->tglreview->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->tglreview->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->tglsubmit->Visible) { // tglsubmit ?>
    <?php if ($Page->SortUrl($Page->tglsubmit) == "") { ?>
        <th class="<?= $Page->tglsubmit->headerCellClass() ?>"><?= $Page->tglsubmit->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->tglsubmit->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->tglsubmit->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->tglsubmit->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->tglsubmit->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->tglsubmit->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->tglsubmit->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <?php if ($Page->SortUrl($Page->status) == "") { ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><?= $Page->status->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->status->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->status->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->status->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->status->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->status->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->idnpd->Visible) { // idnpd ?>
        <!-- idnpd -->
        <td<?= $Page->idnpd->cellAttributes() ?>>
<span<?= $Page->idnpd->viewAttributes() ?>>
<?= $Page->idnpd->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->idnpd_sample->Visible) { // idnpd_sample ?>
        <!-- idnpd_sample -->
        <td<?= $Page->idnpd_sample->cellAttributes() ?>>
<span<?= $Page->idnpd_sample->viewAttributes() ?>>
<?= $Page->idnpd_sample->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->tglreview->Visible) { // tglreview ?>
        <!-- tglreview -->
        <td<?= $Page->tglreview->cellAttributes() ?>>
<span<?= $Page->tglreview->viewAttributes() ?>>
<?= $Page->tglreview->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->tglsubmit->Visible) { // tglsubmit ?>
        <!-- tglsubmit -->
        <td<?= $Page->tglsubmit->cellAttributes() ?>>
<span<?= $Page->tglsubmit->viewAttributes() ?>>
<?= $Page->tglsubmit->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <!-- status -->
        <td<?= $Page->status->cellAttributes() ?>>
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
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
