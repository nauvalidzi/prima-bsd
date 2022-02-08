<?php

namespace PHPMaker2021\production2;

// Page object
$IjinbpomDetailPreview = &$Page;
?>
<script>
if (!ew.vars.tables.ijinbpom_detail) ew.vars.tables.ijinbpom_detail = <?= JsonEncode(GetClientVar("tables", "ijinbpom_detail")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid ijinbpom_detail"><!-- .card -->
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
<?php if ($Page->nama->Visible) { // nama ?>
    <?php if ($Page->SortUrl($Page->nama) == "") { ?>
        <th class="<?= $Page->nama->headerCellClass() ?>"><?= $Page->nama->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->nama->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->nama->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->nama->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->nama->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->nama->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->nama->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->namaalt->Visible) { // namaalt ?>
    <?php if ($Page->SortUrl($Page->namaalt) == "") { ?>
        <th class="<?= $Page->namaalt->headerCellClass() ?>"><?= $Page->namaalt->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->namaalt->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->namaalt->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->namaalt->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->namaalt->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->namaalt->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->namaalt->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->idproduct_acuan->Visible) { // idproduct_acuan ?>
    <?php if ($Page->SortUrl($Page->idproduct_acuan) == "") { ?>
        <th class="<?= $Page->idproduct_acuan->headerCellClass() ?>"><?= $Page->idproduct_acuan->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->idproduct_acuan->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->idproduct_acuan->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->idproduct_acuan->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->idproduct_acuan->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->idproduct_acuan->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->idproduct_acuan->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->kodesample->Visible) { // kodesample ?>
    <?php if ($Page->SortUrl($Page->kodesample) == "") { ?>
        <th class="<?= $Page->kodesample->headerCellClass() ?>"><?= $Page->kodesample->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->kodesample->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->kodesample->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->kodesample->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->kodesample->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->kodesample->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->kodesample->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->nama->Visible) { // nama ?>
        <!-- nama -->
        <td<?= $Page->nama->cellAttributes() ?>>
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->namaalt->Visible) { // namaalt ?>
        <!-- namaalt -->
        <td<?= $Page->namaalt->cellAttributes() ?>>
<span<?= $Page->namaalt->viewAttributes() ?>>
<?= $Page->namaalt->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->idproduct_acuan->Visible) { // idproduct_acuan ?>
        <!-- idproduct_acuan -->
        <td<?= $Page->idproduct_acuan->cellAttributes() ?>>
<span<?= $Page->idproduct_acuan->viewAttributes() ?>>
<?= $Page->idproduct_acuan->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->ukuran->Visible) { // ukuran ?>
        <!-- ukuran -->
        <td<?= $Page->ukuran->cellAttributes() ?>>
<span<?= $Page->ukuran->viewAttributes() ?>>
<?= $Page->ukuran->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->kodesample->Visible) { // kodesample ?>
        <!-- kodesample -->
        <td<?= $Page->kodesample->cellAttributes() ?>>
<span<?= $Page->kodesample->viewAttributes() ?>>
<?= $Page->kodesample->getViewValue() ?></span>
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
