<?php

namespace PHPMaker2021\distributor;

// Page object
$InvoicePreview = &$Page;
?>
<script>
if (!ew.vars.tables.invoice) ew.vars.tables.invoice = <?= JsonEncode(GetClientVar("tables", "invoice")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid invoice"><!-- .card -->
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
<?php if ($Page->kode->Visible) { // kode ?>
    <?php if ($Page->SortUrl($Page->kode) == "") { ?>
        <th class="<?= $Page->kode->headerCellClass() ?>"><?= $Page->kode->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->kode->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->kode->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->kode->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->kode->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->kode->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->kode->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->tglinvoice->Visible) { // tglinvoice ?>
    <?php if ($Page->SortUrl($Page->tglinvoice) == "") { ?>
        <th class="<?= $Page->tglinvoice->headerCellClass() ?>"><?= $Page->tglinvoice->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->tglinvoice->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->tglinvoice->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->tglinvoice->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->tglinvoice->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->tglinvoice->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->tglinvoice->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->idorder->Visible) { // idorder ?>
    <?php if ($Page->SortUrl($Page->idorder) == "") { ?>
        <th class="<?= $Page->idorder->headerCellClass() ?>"><?= $Page->idorder->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->idorder->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->idorder->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->idorder->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->idorder->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->idorder->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->idorder->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->totaltagihan->Visible) { // totaltagihan ?>
    <?php if ($Page->SortUrl($Page->totaltagihan) == "") { ?>
        <th class="<?= $Page->totaltagihan->headerCellClass() ?>"><?= $Page->totaltagihan->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->totaltagihan->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->totaltagihan->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->totaltagihan->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->totaltagihan->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->totaltagihan->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->totaltagihan->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->sisabayar->Visible) { // sisabayar ?>
    <?php if ($Page->SortUrl($Page->sisabayar) == "") { ?>
        <th class="<?= $Page->sisabayar->headerCellClass() ?>"><?= $Page->sisabayar->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->sisabayar->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->sisabayar->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->sisabayar->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->sisabayar->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->sisabayar->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->sisabayar->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->kode->Visible) { // kode ?>
        <!-- kode -->
        <td<?= $Page->kode->cellAttributes() ?>>
<span<?= $Page->kode->viewAttributes() ?>>
<?= $Page->kode->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->tglinvoice->Visible) { // tglinvoice ?>
        <!-- tglinvoice -->
        <td<?= $Page->tglinvoice->cellAttributes() ?>>
<span<?= $Page->tglinvoice->viewAttributes() ?>>
<?= $Page->tglinvoice->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { // idcustomer ?>
        <!-- idcustomer -->
        <td<?= $Page->idcustomer->cellAttributes() ?>>
<span<?= $Page->idcustomer->viewAttributes() ?>>
<?= $Page->idcustomer->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->idorder->Visible) { // idorder ?>
        <!-- idorder -->
        <td<?= $Page->idorder->cellAttributes() ?>>
<span<?= $Page->idorder->viewAttributes() ?>>
<?php if (!EmptyString($Page->idorder->getViewValue()) && $Page->idorder->linkAttributes() != "") { ?>
<a<?= $Page->idorder->linkAttributes() ?>><?= $Page->idorder->getViewValue() ?></a>
<?php } else { ?>
<?= $Page->idorder->getViewValue() ?>
<?php } ?>
</span>
</td>
<?php } ?>
<?php if ($Page->totaltagihan->Visible) { // totaltagihan ?>
        <!-- totaltagihan -->
        <td<?= $Page->totaltagihan->cellAttributes() ?>>
<span<?= $Page->totaltagihan->viewAttributes() ?>>
<?= $Page->totaltagihan->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->sisabayar->Visible) { // sisabayar ?>
        <!-- sisabayar -->
        <td<?= $Page->sisabayar->cellAttributes() ?>>
<span<?= $Page->sisabayar->viewAttributes() ?>>
<?= $Page->sisabayar->getViewValue() ?></span>
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
