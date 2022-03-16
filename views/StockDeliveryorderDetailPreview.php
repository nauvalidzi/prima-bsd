<?php

namespace PHPMaker2021\production2;

// Page object
$StockDeliveryorderDetailPreview = &$Page;
?>
<script>
if (!ew.vars.tables.stock_deliveryorder_detail) ew.vars.tables.stock_deliveryorder_detail = <?= JsonEncode(GetClientVar("tables", "stock_deliveryorder_detail")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid stock_deliveryorder_detail"><!-- .card -->
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
<?php if ($Page->idstockorder->Visible) { // idstockorder ?>
    <?php if ($Page->SortUrl($Page->idstockorder) == "") { ?>
        <th class="<?= $Page->idstockorder->headerCellClass() ?>"><?= $Page->idstockorder->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->idstockorder->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->idstockorder->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->idstockorder->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->idstockorder->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->idstockorder->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->idstockorder->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->idstockorder_detail->Visible) { // idstockorder_detail ?>
    <?php if ($Page->SortUrl($Page->idstockorder_detail) == "") { ?>
        <th class="<?= $Page->idstockorder_detail->headerCellClass() ?>"><?= $Page->idstockorder_detail->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->idstockorder_detail->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->idstockorder_detail->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->idstockorder_detail->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->idstockorder_detail->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->idstockorder_detail->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->idstockorder_detail->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->totalorder->Visible) { // totalorder ?>
    <?php if ($Page->SortUrl($Page->totalorder) == "") { ?>
        <th class="<?= $Page->totalorder->headerCellClass() ?>"><?= $Page->totalorder->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->totalorder->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->totalorder->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->totalorder->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->totalorder->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->totalorder->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->totalorder->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->jumlahkirim->Visible) { // jumlahkirim ?>
    <?php if ($Page->SortUrl($Page->jumlahkirim) == "") { ?>
        <th class="<?= $Page->jumlahkirim->headerCellClass() ?>"><?= $Page->jumlahkirim->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->jumlahkirim->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->jumlahkirim->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->jumlahkirim->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->jumlahkirim->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->jumlahkirim->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->jumlahkirim->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->idstockorder->Visible) { // idstockorder ?>
        <!-- idstockorder -->
        <td<?= $Page->idstockorder->cellAttributes() ?>>
<span<?= $Page->idstockorder->viewAttributes() ?>>
<?= $Page->idstockorder->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->idstockorder_detail->Visible) { // idstockorder_detail ?>
        <!-- idstockorder_detail -->
        <td<?= $Page->idstockorder_detail->cellAttributes() ?>>
<span<?= $Page->idstockorder_detail->viewAttributes() ?>>
<?= $Page->idstockorder_detail->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->totalorder->Visible) { // totalorder ?>
        <!-- totalorder -->
        <td<?= $Page->totalorder->cellAttributes() ?>>
<span<?= $Page->totalorder->viewAttributes() ?>>
<?= $Page->totalorder->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->sisa->Visible) { // sisa ?>
        <!-- sisa -->
        <td<?= $Page->sisa->cellAttributes() ?>>
<span<?= $Page->sisa->viewAttributes() ?>>
<?= $Page->sisa->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->jumlahkirim->Visible) { // jumlahkirim ?>
        <!-- jumlahkirim -->
        <td<?= $Page->jumlahkirim->cellAttributes() ?>>
<span<?= $Page->jumlahkirim->viewAttributes() ?>>
<?= $Page->jumlahkirim->getViewValue() ?></span>
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
