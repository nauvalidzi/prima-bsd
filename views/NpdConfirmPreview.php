<?php

namespace PHPMaker2021\production2;

// Page object
$NpdConfirmPreview = &$Page;
?>
<script>
if (!ew.vars.tables.npd_confirm) ew.vars.tables.npd_confirm = <?= JsonEncode(GetClientVar("tables", "npd_confirm")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid npd_confirm"><!-- .card -->
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
<?php if ($Page->tglkonfirmasi->Visible) { // tglkonfirmasi ?>
    <?php if ($Page->SortUrl($Page->tglkonfirmasi) == "") { ?>
        <th class="<?= $Page->tglkonfirmasi->headerCellClass() ?>"><?= $Page->tglkonfirmasi->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->tglkonfirmasi->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->tglkonfirmasi->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->tglkonfirmasi->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->tglkonfirmasi->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->tglkonfirmasi->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->tglkonfirmasi->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->namapemesan->Visible) { // namapemesan ?>
    <?php if ($Page->SortUrl($Page->namapemesan) == "") { ?>
        <th class="<?= $Page->namapemesan->headerCellClass() ?>"><?= $Page->namapemesan->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->namapemesan->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->namapemesan->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->namapemesan->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->namapemesan->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->namapemesan->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->namapemesan->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->personincharge->Visible) { // personincharge ?>
    <?php if ($Page->SortUrl($Page->personincharge) == "") { ?>
        <th class="<?= $Page->personincharge->headerCellClass() ?>"><?= $Page->personincharge->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->personincharge->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->personincharge->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->personincharge->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->personincharge->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->personincharge->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->personincharge->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->notelp->Visible) { // notelp ?>
    <?php if ($Page->SortUrl($Page->notelp) == "") { ?>
        <th class="<?= $Page->notelp->headerCellClass() ?>"><?= $Page->notelp->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->notelp->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->notelp->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->notelp->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->notelp->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->notelp->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->notelp->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->tglkonfirmasi->Visible) { // tglkonfirmasi ?>
        <!-- tglkonfirmasi -->
        <td<?= $Page->tglkonfirmasi->cellAttributes() ?>>
<span<?= $Page->tglkonfirmasi->viewAttributes() ?>>
<?= $Page->tglkonfirmasi->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->idnpd_sample->Visible) { // idnpd_sample ?>
        <!-- idnpd_sample -->
        <td<?= $Page->idnpd_sample->cellAttributes() ?>>
<span<?= $Page->idnpd_sample->viewAttributes() ?>>
<?= $Page->idnpd_sample->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->namapemesan->Visible) { // namapemesan ?>
        <!-- namapemesan -->
        <td<?= $Page->namapemesan->cellAttributes() ?>>
<span<?= $Page->namapemesan->viewAttributes() ?>>
<?= $Page->namapemesan->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->personincharge->Visible) { // personincharge ?>
        <!-- personincharge -->
        <td<?= $Page->personincharge->cellAttributes() ?>>
<span<?= $Page->personincharge->viewAttributes() ?>>
<?= $Page->personincharge->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->notelp->Visible) { // notelp ?>
        <!-- notelp -->
        <td<?= $Page->notelp->cellAttributes() ?>>
<span<?= $Page->notelp->viewAttributes() ?>>
<?= $Page->notelp->getViewValue() ?></span>
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
