<?php

namespace PHPMaker2021\production2;

// Page object
$StockOrderDetailPreview = &$Page;
?>
<script>
if (!ew.vars.tables.stock_order_detail) ew.vars.tables.stock_order_detail = <?= JsonEncode(GetClientVar("tables", "stock_order_detail")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid stock_order_detail"><!-- .card -->
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
<?php if ($Page->idbrand->Visible) { // idbrand ?>
    <?php if ($Page->SortUrl($Page->idbrand) == "") { ?>
        <th class="<?= $Page->idbrand->headerCellClass() ?>"><?= $Page->idbrand->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->idbrand->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->idbrand->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->idbrand->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->idbrand->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->idbrand->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->idbrand->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->idproduct->Visible) { // idproduct ?>
    <?php if ($Page->SortUrl($Page->idproduct) == "") { ?>
        <th class="<?= $Page->idproduct->headerCellClass() ?>"><?= $Page->idproduct->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->idproduct->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->idproduct->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->idproduct->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->idproduct->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->idproduct->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->idproduct->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->stok_akhir->Visible) { // stok_akhir ?>
    <?php if ($Page->SortUrl($Page->stok_akhir) == "") { ?>
        <th class="<?= $Page->stok_akhir->headerCellClass() ?>"><?= $Page->stok_akhir->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->stok_akhir->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->stok_akhir->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->stok_akhir->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->stok_akhir->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->stok_akhir->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->stok_akhir->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->sisa->Visible) { // sisa ?>
    <?php if ($Page->SortUrl($Page->sisa) == "") { ?>
        <th class="<?= $Page->sisa->headerCellClass() ?>"><?= $Page->sisa->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->sisa->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->sisa->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->sisa->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->sisa->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->sisa->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->sisa->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->jumlah->Visible) { // jumlah ?>
    <?php if ($Page->SortUrl($Page->jumlah) == "") { ?>
        <th class="<?= $Page->jumlah->headerCellClass() ?>"><?= $Page->jumlah->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->jumlah->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->jumlah->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->jumlah->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->jumlah->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->jumlah->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->jumlah->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <?php if ($Page->SortUrl($Page->keterangan) == "") { ?>
        <th class="<?= $Page->keterangan->headerCellClass() ?>"><?= $Page->keterangan->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->keterangan->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->keterangan->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->keterangan->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->keterangan->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->keterangan->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->keterangan->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->idbrand->Visible) { // idbrand ?>
        <!-- idbrand -->
        <td<?= $Page->idbrand->cellAttributes() ?>>
<span<?= $Page->idbrand->viewAttributes() ?>>
<?= $Page->idbrand->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->idproduct->Visible) { // idproduct ?>
        <!-- idproduct -->
        <td<?= $Page->idproduct->cellAttributes() ?>>
<span<?= $Page->idproduct->viewAttributes() ?>>
<?= $Page->idproduct->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->stok_akhir->Visible) { // stok_akhir ?>
        <!-- stok_akhir -->
        <td<?= $Page->stok_akhir->cellAttributes() ?>>
<span<?= $Page->stok_akhir->viewAttributes() ?>>
<?= $Page->stok_akhir->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->sisa->Visible) { // sisa ?>
        <!-- sisa -->
        <td<?= $Page->sisa->cellAttributes() ?>>
<span<?= $Page->sisa->viewAttributes() ?>>
<?= $Page->sisa->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->jumlah->Visible) { // jumlah ?>
        <!-- jumlah -->
        <td<?= $Page->jumlah->cellAttributes() ?>>
<span<?= $Page->jumlah->viewAttributes() ?>>
<?= $Page->jumlah->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
        <!-- keterangan -->
        <td<?= $Page->keterangan->cellAttributes() ?>>
<span<?= $Page->keterangan->viewAttributes() ?>>
<?= $Page->keterangan->getViewValue() ?></span>
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
