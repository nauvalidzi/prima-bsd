<?php

namespace PHPMaker2021\distributor;

// Page object
$DeliveryorderDetailPreview = &$Page;
?>
<script>
if (!ew.vars.tables.deliveryorder_detail) ew.vars.tables.deliveryorder_detail = <?= JsonEncode(GetClientVar("tables", "deliveryorder_detail")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid deliveryorder_detail"><!-- .card -->
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
<?php if ($Page->idorder_detail->Visible) { // idorder_detail ?>
    <?php if ($Page->SortUrl($Page->idorder_detail) == "") { ?>
        <th class="<?= $Page->idorder_detail->headerCellClass() ?>"><?= $Page->idorder_detail->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->idorder_detail->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->idorder_detail->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->idorder_detail->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->idorder_detail->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->idorder_detail->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->idorder_detail->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->idorder_detail->Visible) { // idorder_detail ?>
        <!-- idorder_detail -->
        <td<?= $Page->idorder_detail->cellAttributes() ?>>
<span<?= $Page->idorder_detail->viewAttributes() ?>>
<?= $Page->idorder_detail->getViewValue() ?></span>
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
