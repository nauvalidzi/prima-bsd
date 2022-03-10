<?php

namespace PHPMaker2021\production2;

// Table
$npd_serahterima = Container("npd_serahterima");
?>
<?php if ($npd_serahterima->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_npd_serahterimamaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($npd_serahterima->idcustomer->Visible) { // idcustomer ?>
        <tr id="r_idcustomer">
            <td class="<?= $npd_serahterima->TableLeftColumnClass ?>"><?= $npd_serahterima->idcustomer->caption() ?></td>
            <td <?= $npd_serahterima->idcustomer->cellAttributes() ?>>
<span id="el_npd_serahterima_idcustomer">
<span<?= $npd_serahterima->idcustomer->viewAttributes() ?>>
<?= $npd_serahterima->idcustomer->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($npd_serahterima->tgl_request->Visible) { // tgl_request ?>
        <tr id="r_tgl_request">
            <td class="<?= $npd_serahterima->TableLeftColumnClass ?>"><?= $npd_serahterima->tgl_request->caption() ?></td>
            <td <?= $npd_serahterima->tgl_request->cellAttributes() ?>>
<span id="el_npd_serahterima_tgl_request">
<span<?= $npd_serahterima->tgl_request->viewAttributes() ?>>
<?= $npd_serahterima->tgl_request->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($npd_serahterima->tgl_serahterima->Visible) { // tgl_serahterima ?>
        <tr id="r_tgl_serahterima">
            <td class="<?= $npd_serahterima->TableLeftColumnClass ?>"><?= $npd_serahterima->tgl_serahterima->caption() ?></td>
            <td <?= $npd_serahterima->tgl_serahterima->cellAttributes() ?>>
<span id="el_npd_serahterima_tgl_serahterima">
<span<?= $npd_serahterima->tgl_serahterima->viewAttributes() ?>>
<?= $npd_serahterima->tgl_serahterima->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($npd_serahterima->submitted_by->Visible) { // submitted_by ?>
        <tr id="r_submitted_by">
            <td class="<?= $npd_serahterima->TableLeftColumnClass ?>"><?= $npd_serahterima->submitted_by->caption() ?></td>
            <td <?= $npd_serahterima->submitted_by->cellAttributes() ?>>
<span id="el_npd_serahterima_submitted_by">
<span<?= $npd_serahterima->submitted_by->viewAttributes() ?>>
<?= $npd_serahterima->submitted_by->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($npd_serahterima->receipt_by->Visible) { // receipt_by ?>
        <tr id="r_receipt_by">
            <td class="<?= $npd_serahterima->TableLeftColumnClass ?>"><?= $npd_serahterima->receipt_by->caption() ?></td>
            <td <?= $npd_serahterima->receipt_by->cellAttributes() ?>>
<span id="el_npd_serahterima_receipt_by">
<span<?= $npd_serahterima->receipt_by->viewAttributes() ?>>
<?= $npd_serahterima->receipt_by->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
