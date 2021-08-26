<?php

namespace PHPMaker2021\distributor;

// Table
$po_limit_approval = Container("po_limit_approval");
?>
<?php if ($po_limit_approval->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_po_limit_approvalmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($po_limit_approval->idpegawai->Visible) { // idpegawai ?>
        <tr id="r_idpegawai">
            <td class="<?= $po_limit_approval->TableLeftColumnClass ?>"><?= $po_limit_approval->idpegawai->caption() ?></td>
            <td <?= $po_limit_approval->idpegawai->cellAttributes() ?>>
<span id="el_po_limit_approval_idpegawai">
<span<?= $po_limit_approval->idpegawai->viewAttributes() ?>>
<?= $po_limit_approval->idpegawai->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($po_limit_approval->idcustomer->Visible) { // idcustomer ?>
        <tr id="r_idcustomer">
            <td class="<?= $po_limit_approval->TableLeftColumnClass ?>"><?= $po_limit_approval->idcustomer->caption() ?></td>
            <td <?= $po_limit_approval->idcustomer->cellAttributes() ?>>
<span id="el_po_limit_approval_idcustomer">
<span<?= $po_limit_approval->idcustomer->viewAttributes() ?>>
<?= $po_limit_approval->idcustomer->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($po_limit_approval->limit_kredit->Visible) { // limit_kredit ?>
        <tr id="r_limit_kredit">
            <td class="<?= $po_limit_approval->TableLeftColumnClass ?>"><?= $po_limit_approval->limit_kredit->caption() ?></td>
            <td <?= $po_limit_approval->limit_kredit->cellAttributes() ?>>
<span id="el_po_limit_approval_limit_kredit">
<span<?= $po_limit_approval->limit_kredit->viewAttributes() ?>>
<?= $po_limit_approval->limit_kredit->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($po_limit_approval->limit_po_aktif->Visible) { // limit_po_aktif ?>
        <tr id="r_limit_po_aktif">
            <td class="<?= $po_limit_approval->TableLeftColumnClass ?>"><?= $po_limit_approval->limit_po_aktif->caption() ?></td>
            <td <?= $po_limit_approval->limit_po_aktif->cellAttributes() ?>>
<span id="el_po_limit_approval_limit_po_aktif">
<span<?= $po_limit_approval->limit_po_aktif->viewAttributes() ?>>
<?= $po_limit_approval->limit_po_aktif->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($po_limit_approval->created_at->Visible) { // created_at ?>
        <tr id="r_created_at">
            <td class="<?= $po_limit_approval->TableLeftColumnClass ?>"><?= $po_limit_approval->created_at->caption() ?></td>
            <td <?= $po_limit_approval->created_at->cellAttributes() ?>>
<span id="el_po_limit_approval_created_at">
<span<?= $po_limit_approval->created_at->viewAttributes() ?>>
<?= $po_limit_approval->created_at->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($po_limit_approval->sisalimitkredit->Visible) { // sisalimitkredit ?>
        <tr id="r_sisalimitkredit">
            <td class="<?= $po_limit_approval->TableLeftColumnClass ?>"><?= $po_limit_approval->sisalimitkredit->caption() ?></td>
            <td <?= $po_limit_approval->sisalimitkredit->cellAttributes() ?>>
<span id="el_po_limit_approval_sisalimitkredit">
<span<?= $po_limit_approval->sisalimitkredit->viewAttributes() ?>>
<?= $po_limit_approval->sisalimitkredit->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($po_limit_approval->sisapoaktif->Visible) { // sisapoaktif ?>
        <tr id="r_sisapoaktif">
            <td class="<?= $po_limit_approval->TableLeftColumnClass ?>"><?= $po_limit_approval->sisapoaktif->caption() ?></td>
            <td <?= $po_limit_approval->sisapoaktif->cellAttributes() ?>>
<span id="el_po_limit_approval_sisapoaktif">
<span<?= $po_limit_approval->sisapoaktif->viewAttributes() ?>>
<?= $po_limit_approval->sisapoaktif->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
