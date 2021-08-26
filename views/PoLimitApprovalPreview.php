<?php

namespace PHPMaker2021\distributor;

// Page object
$PoLimitApprovalPreview = &$Page;
?>
<script>
if (!ew.vars.tables.po_limit_approval) ew.vars.tables.po_limit_approval = <?= JsonEncode(GetClientVar("tables", "po_limit_approval")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid po_limit_approval"><!-- .card -->
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
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
    <?php if ($Page->SortUrl($Page->idpegawai) == "") { ?>
        <th class="<?= $Page->idpegawai->headerCellClass() ?>"><?= $Page->idpegawai->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->idpegawai->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->idpegawai->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->idpegawai->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->idpegawai->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->idpegawai->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->idpegawai->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
    <?php if ($Page->SortUrl($Page->idcustomer) == "") { ?>
        <th class="<?= $Page->idcustomer->headerCellClass() ?>"><?= $Page->idcustomer->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->idcustomer->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->idcustomer->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->idcustomer->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->idcustomer->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->idcustomer->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->idcustomer->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->limit_kredit->Visible) { // limit_kredit ?>
    <?php if ($Page->SortUrl($Page->limit_kredit) == "") { ?>
        <th class="<?= $Page->limit_kredit->headerCellClass() ?>"><?= $Page->limit_kredit->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->limit_kredit->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->limit_kredit->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->limit_kredit->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->limit_kredit->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->limit_kredit->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->limit_kredit->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->limit_po_aktif->Visible) { // limit_po_aktif ?>
    <?php if ($Page->SortUrl($Page->limit_po_aktif) == "") { ?>
        <th class="<?= $Page->limit_po_aktif->headerCellClass() ?>"><?= $Page->limit_po_aktif->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->limit_po_aktif->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->limit_po_aktif->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->limit_po_aktif->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->limit_po_aktif->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->limit_po_aktif->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->limit_po_aktif->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->sisalimitkredit->Visible) { // sisalimitkredit ?>
    <?php if ($Page->SortUrl($Page->sisalimitkredit) == "") { ?>
        <th class="<?= $Page->sisalimitkredit->headerCellClass() ?>"><?= $Page->sisalimitkredit->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->sisalimitkredit->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->sisalimitkredit->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->sisalimitkredit->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->sisalimitkredit->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->sisalimitkredit->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->sisalimitkredit->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->sisapoaktif->Visible) { // sisapoaktif ?>
    <?php if ($Page->SortUrl($Page->sisapoaktif) == "") { ?>
        <th class="<?= $Page->sisapoaktif->headerCellClass() ?>"><?= $Page->sisapoaktif->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->sisapoaktif->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->sisapoaktif->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->sisapoaktif->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->sisapoaktif->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->sisapoaktif->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->sisapoaktif->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->idpegawai->Visible) { // idpegawai ?>
        <!-- idpegawai -->
        <td<?= $Page->idpegawai->cellAttributes() ?>>
<span<?= $Page->idpegawai->viewAttributes() ?>>
<?= $Page->idpegawai->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <!-- idcustomer -->
        <td<?= $Page->idcustomer->cellAttributes() ?>>
<span<?= $Page->idcustomer->viewAttributes() ?>>
<?= $Page->idcustomer->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->limit_kredit->Visible) { // limit_kredit ?>
        <!-- limit_kredit -->
        <td<?= $Page->limit_kredit->cellAttributes() ?>>
<span<?= $Page->limit_kredit->viewAttributes() ?>>
<?= $Page->limit_kredit->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->limit_po_aktif->Visible) { // limit_po_aktif ?>
        <!-- limit_po_aktif -->
        <td<?= $Page->limit_po_aktif->cellAttributes() ?>>
<span<?= $Page->limit_po_aktif->viewAttributes() ?>>
<?= $Page->limit_po_aktif->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <!-- created_at -->
        <td<?= $Page->created_at->cellAttributes() ?>>
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->sisalimitkredit->Visible) { // sisalimitkredit ?>
        <!-- sisalimitkredit -->
        <td<?= $Page->sisalimitkredit->cellAttributes() ?>>
<span<?= $Page->sisalimitkredit->viewAttributes() ?>>
<?= $Page->sisalimitkredit->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->sisapoaktif->Visible) { // sisapoaktif ?>
        <!-- sisapoaktif -->
        <td<?= $Page->sisapoaktif->cellAttributes() ?>>
<span<?= $Page->sisapoaktif->viewAttributes() ?>>
<?= $Page->sisapoaktif->getViewValue() ?></span>
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
