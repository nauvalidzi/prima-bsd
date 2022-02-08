<?php

namespace PHPMaker2021\production2;

// Table
$suratjalan_detail = Container("suratjalan_detail");
?>
<?php if ($suratjalan_detail->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_suratjalan_detailmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($suratjalan_detail->idinvoice->Visible) { // idinvoice ?>
        <tr id="r_idinvoice">
            <td class="<?= $suratjalan_detail->TableLeftColumnClass ?>"><?= $suratjalan_detail->idinvoice->caption() ?></td>
            <td <?= $suratjalan_detail->idinvoice->cellAttributes() ?>>
<span id="el_suratjalan_detail_idinvoice">
<span<?= $suratjalan_detail->idinvoice->viewAttributes() ?>>
<?= $suratjalan_detail->idinvoice->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($suratjalan_detail->keterangan->Visible) { // keterangan ?>
        <tr id="r_keterangan">
            <td class="<?= $suratjalan_detail->TableLeftColumnClass ?>"><?= $suratjalan_detail->keterangan->caption() ?></td>
            <td <?= $suratjalan_detail->keterangan->cellAttributes() ?>>
<span id="el_suratjalan_detail_keterangan">
<span<?= $suratjalan_detail->keterangan->viewAttributes() ?>>
<?= $suratjalan_detail->keterangan->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
