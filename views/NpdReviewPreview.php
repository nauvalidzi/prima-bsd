<?php

namespace PHPMaker2021\production2;

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
<?php if ($Page->tanggal_review->Visible) { // tanggal_review ?>
    <?php if ($Page->SortUrl($Page->tanggal_review) == "") { ?>
        <th class="<?= $Page->tanggal_review->headerCellClass() ?>"><?= $Page->tanggal_review->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->tanggal_review->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->tanggal_review->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->tanggal_review->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->tanggal_review->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->tanggal_review->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->tanggal_review->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->tanggal_submit->Visible) { // tanggal_submit ?>
    <?php if ($Page->SortUrl($Page->tanggal_submit) == "") { ?>
        <th class="<?= $Page->tanggal_submit->headerCellClass() ?>"><?= $Page->tanggal_submit->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->tanggal_submit->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->tanggal_submit->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->tanggal_submit->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->tanggal_submit->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->tanggal_submit->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->tanggal_submit->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->ukuran->Visible) { // ukuran ?>
    <?php if ($Page->SortUrl($Page->ukuran) == "") { ?>
        <th class="<?= $Page->ukuran->headerCellClass() ?>"><?= $Page->ukuran->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->ukuran->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->ukuran->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->ukuran->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->ukuran->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->ukuran->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->ukuran->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->review_by->Visible) { // review_by ?>
    <?php if ($Page->SortUrl($Page->review_by) == "") { ?>
        <th class="<?= $Page->review_by->headerCellClass() ?>"><?= $Page->review_by->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->review_by->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->review_by->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->review_by->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->review_by->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->review_by->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->review_by->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->tanggal_review->Visible) { // tanggal_review ?>
        <!-- tanggal_review -->
        <td<?= $Page->tanggal_review->cellAttributes() ?>>
<span<?= $Page->tanggal_review->viewAttributes() ?>>
<?= $Page->tanggal_review->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->tanggal_submit->Visible) { // tanggal_submit ?>
        <!-- tanggal_submit -->
        <td<?= $Page->tanggal_submit->cellAttributes() ?>>
<span<?= $Page->tanggal_submit->viewAttributes() ?>>
<?= $Page->tanggal_submit->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->ukuran->Visible) { // ukuran ?>
        <!-- ukuran -->
        <td<?= $Page->ukuran->cellAttributes() ?>>
<span<?= $Page->ukuran->viewAttributes() ?>>
<?= $Page->ukuran->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <!-- status -->
        <td<?= $Page->status->cellAttributes() ?>>
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->review_by->Visible) { // review_by ?>
        <!-- review_by -->
        <td<?= $Page->review_by->cellAttributes() ?>>
<span<?= $Page->review_by->viewAttributes() ?>>
<?= $Page->review_by->getViewValue() ?></span>
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
