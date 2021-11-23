<?php

namespace PHPMaker2021\distributor;

// Page object
$BrandPreview = &$Page;
?>
<script>
if (!ew.vars.tables.brand) ew.vars.tables.brand = <?= JsonEncode(GetClientVar("tables", "brand")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid brand"><!-- .card -->
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
<?php if ($Page->kode->Visible) { // kode ?>
    <?php if ($Page->SortUrl($Page->kode) == "") { ?>
        <th class="<?= $Page->kode->headerCellClass() ?>"><?= $Page->kode->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->kode->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->kode->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->kode->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->kode->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->kode->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->kode->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->title->Visible) { // title ?>
    <?php if ($Page->SortUrl($Page->title) == "") { ?>
        <th class="<?= $Page->title->headerCellClass() ?>"><?= $Page->title->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->title->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->title->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->title->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->title->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->title->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->title->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->titipmerk->Visible) { // titipmerk ?>
    <?php if ($Page->SortUrl($Page->titipmerk) == "") { ?>
        <th class="<?= $Page->titipmerk->headerCellClass() ?>"><?= $Page->titipmerk->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->titipmerk->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->titipmerk->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->titipmerk->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->titipmerk->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->titipmerk->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->titipmerk->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->ijinhaki->Visible) { // ijinhaki ?>
    <?php if ($Page->SortUrl($Page->ijinhaki) == "") { ?>
        <th class="<?= $Page->ijinhaki->headerCellClass() ?>"><?= $Page->ijinhaki->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->ijinhaki->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->ijinhaki->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->ijinhaki->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->ijinhaki->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->ijinhaki->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->ijinhaki->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->ijinbpom->Visible) { // ijinbpom ?>
    <?php if ($Page->SortUrl($Page->ijinbpom) == "") { ?>
        <th class="<?= $Page->ijinbpom->headerCellClass() ?>"><?= $Page->ijinbpom->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->ijinbpom->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->ijinbpom->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->ijinbpom->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->ijinbpom->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->ijinbpom->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->ijinbpom->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->aktif->Visible) { // aktif ?>
    <?php if ($Page->SortUrl($Page->aktif) == "") { ?>
        <th class="<?= $Page->aktif->headerCellClass() ?>"><?= $Page->aktif->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->aktif->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->aktif->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->aktif->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->aktif->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->aktif->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->aktif->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->kode_sip->Visible) { // kode_sip ?>
    <?php if ($Page->SortUrl($Page->kode_sip) == "") { ?>
        <th class="<?= $Page->kode_sip->headerCellClass() ?>"><?= $Page->kode_sip->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->kode_sip->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->kode_sip->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->kode_sip->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->kode_sip->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->kode_sip->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->kode_sip->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->kode->Visible) { // kode ?>
        <!-- kode -->
        <td<?= $Page->kode->cellAttributes() ?>>
<span<?= $Page->kode->viewAttributes() ?>>
<?= $Page->kode->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->title->Visible) { // title ?>
        <!-- title -->
        <td<?= $Page->title->cellAttributes() ?>>
<span<?= $Page->title->viewAttributes() ?>>
<?= $Page->title->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->titipmerk->Visible) { // titipmerk ?>
        <!-- titipmerk -->
        <td<?= $Page->titipmerk->cellAttributes() ?>>
<span<?= $Page->titipmerk->viewAttributes() ?>>
<?= $Page->titipmerk->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->ijinhaki->Visible) { // ijinhaki ?>
        <!-- ijinhaki -->
        <td<?= $Page->ijinhaki->cellAttributes() ?>>
<span<?= $Page->ijinhaki->viewAttributes() ?>>
<?= $Page->ijinhaki->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->ijinbpom->Visible) { // ijinbpom ?>
        <!-- ijinbpom -->
        <td<?= $Page->ijinbpom->cellAttributes() ?>>
<span<?= $Page->ijinbpom->viewAttributes() ?>>
<?= $Page->ijinbpom->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->aktif->Visible) { // aktif ?>
        <!-- aktif -->
        <td<?= $Page->aktif->cellAttributes() ?>>
<span<?= $Page->aktif->viewAttributes() ?>>
<?= $Page->aktif->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->kode_sip->Visible) { // kode_sip ?>
        <!-- kode_sip -->
        <td<?= $Page->kode_sip->cellAttributes() ?>>
<span<?= $Page->kode_sip->viewAttributes() ?>>
<?= $Page->kode_sip->getViewValue() ?></span>
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
