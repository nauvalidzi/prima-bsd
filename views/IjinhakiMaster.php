<?php

namespace PHPMaker2021\production2;

// Table
$ijinhaki = Container("ijinhaki");
?>
<?php if ($ijinhaki->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_ijinhakimaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($ijinhaki->idnpd->Visible) { // idnpd ?>
        <tr id="r_idnpd">
            <td class="<?= $ijinhaki->TableLeftColumnClass ?>"><?= $ijinhaki->idnpd->caption() ?></td>
            <td <?= $ijinhaki->idnpd->cellAttributes() ?>>
<span id="el_ijinhaki_idnpd">
<span<?= $ijinhaki->idnpd->viewAttributes() ?>>
<?= $ijinhaki->idnpd->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($ijinhaki->tglterima->Visible) { // tglterima ?>
        <tr id="r_tglterima">
            <td class="<?= $ijinhaki->TableLeftColumnClass ?>"><?= $ijinhaki->tglterima->caption() ?></td>
            <td <?= $ijinhaki->tglterima->cellAttributes() ?>>
<span id="el_ijinhaki_tglterima">
<span<?= $ijinhaki->tglterima->viewAttributes() ?>>
<?= $ijinhaki->tglterima->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($ijinhaki->tglsubmit->Visible) { // tglsubmit ?>
        <tr id="r_tglsubmit">
            <td class="<?= $ijinhaki->TableLeftColumnClass ?>"><?= $ijinhaki->tglsubmit->caption() ?></td>
            <td <?= $ijinhaki->tglsubmit->cellAttributes() ?>>
<span id="el_ijinhaki_tglsubmit">
<span<?= $ijinhaki->tglsubmit->viewAttributes() ?>>
<?= $ijinhaki->tglsubmit->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($ijinhaki->nama_brand->Visible) { // nama_brand ?>
        <tr id="r_nama_brand">
            <td class="<?= $ijinhaki->TableLeftColumnClass ?>"><?= $ijinhaki->nama_brand->caption() ?></td>
            <td <?= $ijinhaki->nama_brand->cellAttributes() ?>>
<span id="el_ijinhaki_nama_brand">
<span<?= $ijinhaki->nama_brand->viewAttributes() ?>>
<?= $ijinhaki->nama_brand->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($ijinhaki->label_brand->Visible) { // label_brand ?>
        <tr id="r_label_brand">
            <td class="<?= $ijinhaki->TableLeftColumnClass ?>"><?= $ijinhaki->label_brand->caption() ?></td>
            <td <?= $ijinhaki->label_brand->cellAttributes() ?>>
<span id="el_ijinhaki_label_brand">
<span<?= $ijinhaki->label_brand->viewAttributes() ?>>
<?= GetFileViewTag($ijinhaki->label_brand, $ijinhaki->label_brand->getViewValue(), false) ?>
</span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($ijinhaki->submitted_by->Visible) { // submitted_by ?>
        <tr id="r_submitted_by">
            <td class="<?= $ijinhaki->TableLeftColumnClass ?>"><?= $ijinhaki->submitted_by->caption() ?></td>
            <td <?= $ijinhaki->submitted_by->cellAttributes() ?>>
<span id="el_ijinhaki_submitted_by">
<span<?= $ijinhaki->submitted_by->viewAttributes() ?>>
<?= $ijinhaki->submitted_by->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($ijinhaki->status->Visible) { // status ?>
        <tr id="r_status">
            <td class="<?= $ijinhaki->TableLeftColumnClass ?>"><?= $ijinhaki->status->caption() ?></td>
            <td <?= $ijinhaki->status->cellAttributes() ?>>
<span id="el_ijinhaki_status">
<span<?= $ijinhaki->status->viewAttributes() ?>>
<?= $ijinhaki->status->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
