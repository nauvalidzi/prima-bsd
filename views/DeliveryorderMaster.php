<?php

namespace PHPMaker2021\production2;

// Table
$deliveryorder = Container("deliveryorder");
?>
<?php if ($deliveryorder->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_deliveryordermaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($deliveryorder->kode->Visible) { // kode ?>
        <tr id="r_kode">
            <td class="<?= $deliveryorder->TableLeftColumnClass ?>"><?= $deliveryorder->kode->caption() ?></td>
            <td <?= $deliveryorder->kode->cellAttributes() ?>>
<span id="el_deliveryorder_kode">
<span<?= $deliveryorder->kode->viewAttributes() ?>>
<?= $deliveryorder->kode->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($deliveryorder->tanggal->Visible) { // tanggal ?>
        <tr id="r_tanggal">
            <td class="<?= $deliveryorder->TableLeftColumnClass ?>"><?= $deliveryorder->tanggal->caption() ?></td>
            <td <?= $deliveryorder->tanggal->cellAttributes() ?>>
<span id="el_deliveryorder_tanggal">
<span<?= $deliveryorder->tanggal->viewAttributes() ?>>
<?= $deliveryorder->tanggal->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($deliveryorder->lampiran->Visible) { // lampiran ?>
        <tr id="r_lampiran">
            <td class="<?= $deliveryorder->TableLeftColumnClass ?>"><?= $deliveryorder->lampiran->caption() ?></td>
            <td <?= $deliveryorder->lampiran->cellAttributes() ?>>
<span id="el_deliveryorder_lampiran">
<span<?= $deliveryorder->lampiran->viewAttributes() ?>>
<?= GetFileViewTag($deliveryorder->lampiran, $deliveryorder->lampiran->getViewValue(), false) ?>
</span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
