<?php

namespace PHPMaker2021\distributor;

// Page object
$PenagihanAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fpenagihanadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fpenagihanadd = currentForm = new ew.Form("fpenagihanadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "penagihan")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.penagihan)
        ew.vars.tables.penagihan = currentTable;
    fpenagihanadd.addFields([
        ["messages", [fields.messages.visible && fields.messages.required ? ew.Validators.required(fields.messages.caption) : null], fields.messages.isInvalid],
        ["tgl_order", [fields.tgl_order.visible && fields.tgl_order.required ? ew.Validators.required(fields.tgl_order.caption) : null, ew.Validators.datetime(0)], fields.tgl_order.isInvalid],
        ["kode_order", [fields.kode_order.visible && fields.kode_order.required ? ew.Validators.required(fields.kode_order.caption) : null], fields.kode_order.isInvalid],
        ["nama_customer", [fields.nama_customer.visible && fields.nama_customer.required ? ew.Validators.required(fields.nama_customer.caption) : null], fields.nama_customer.isInvalid],
        ["nomor_handphone", [fields.nomor_handphone.visible && fields.nomor_handphone.required ? ew.Validators.required(fields.nomor_handphone.caption) : null], fields.nomor_handphone.isInvalid],
        ["nilai_po", [fields.nilai_po.visible && fields.nilai_po.required ? ew.Validators.required(fields.nilai_po.caption) : null, ew.Validators.integer], fields.nilai_po.isInvalid],
        ["tgl_faktur", [fields.tgl_faktur.visible && fields.tgl_faktur.required ? ew.Validators.required(fields.tgl_faktur.caption) : null, ew.Validators.datetime(0)], fields.tgl_faktur.isInvalid],
        ["nilai_faktur", [fields.nilai_faktur.visible && fields.nilai_faktur.required ? ew.Validators.required(fields.nilai_faktur.caption) : null, ew.Validators.integer], fields.nilai_faktur.isInvalid],
        ["piutang", [fields.piutang.visible && fields.piutang.required ? ew.Validators.required(fields.piutang.caption) : null, ew.Validators.integer], fields.piutang.isInvalid],
        ["umur_faktur", [fields.umur_faktur.visible && fields.umur_faktur.required ? ew.Validators.required(fields.umur_faktur.caption) : null, ew.Validators.integer], fields.umur_faktur.isInvalid],
        ["tgl_antrian", [fields.tgl_antrian.visible && fields.tgl_antrian.required ? ew.Validators.required(fields.tgl_antrian.caption) : null, ew.Validators.datetime(0)], fields.tgl_antrian.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
        ["tgl_penagihan", [fields.tgl_penagihan.visible && fields.tgl_penagihan.required ? ew.Validators.required(fields.tgl_penagihan.caption) : null, ew.Validators.datetime(0)], fields.tgl_penagihan.isInvalid],
        ["tgl_return", [fields.tgl_return.visible && fields.tgl_return.required ? ew.Validators.required(fields.tgl_return.caption) : null, ew.Validators.datetime(0)], fields.tgl_return.isInvalid],
        ["tgl_cancel", [fields.tgl_cancel.visible && fields.tgl_cancel.required ? ew.Validators.required(fields.tgl_cancel.caption) : null, ew.Validators.datetime(0)], fields.tgl_cancel.isInvalid],
        ["messagets", [fields.messagets.visible && fields.messagets.required ? ew.Validators.required(fields.messagets.caption) : null], fields.messagets.isInvalid],
        ["statusts", [fields.statusts.visible && fields.statusts.required ? ew.Validators.required(fields.statusts.caption) : null, ew.Validators.integer], fields.statusts.isInvalid],
        ["statusbayar", [fields.statusbayar.visible && fields.statusbayar.required ? ew.Validators.required(fields.statusbayar.caption) : null], fields.statusbayar.isInvalid],
        ["nomorfaktur", [fields.nomorfaktur.visible && fields.nomorfaktur.required ? ew.Validators.required(fields.nomorfaktur.caption) : null], fields.nomorfaktur.isInvalid],
        ["pembayaran", [fields.pembayaran.visible && fields.pembayaran.required ? ew.Validators.required(fields.pembayaran.caption) : null, ew.Validators.integer], fields.pembayaran.isInvalid],
        ["keterangan", [fields.keterangan.visible && fields.keterangan.required ? ew.Validators.required(fields.keterangan.caption) : null], fields.keterangan.isInvalid],
        ["saldo", [fields.saldo.visible && fields.saldo.required ? ew.Validators.required(fields.saldo.caption) : null, ew.Validators.integer], fields.saldo.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fpenagihanadd,
            fobj = f.getForm(),
            $fobj = $(fobj),
            $k = $fobj.find("#" + f.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            f.setInvalid(rowIndex);
        }
    });

    // Validate form
    fpenagihanadd.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj);
        if ($fobj.find("#confirm").val() == "confirm")
            return true;
        var addcnt = 0,
            $k = $fobj.find("#" + this.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1, // Check rowcnt == 0 => Inline-Add
            gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            $fobj.data("rowindex", rowIndex);

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
        }

        // Process detail forms
        var dfs = $fobj.find("input[name='detailpage']").get();
        for (var i = 0; i < dfs.length; i++) {
            var df = dfs[i],
                val = df.value,
                frm = ew.forms.get(val);
            if (val && frm && !frm.validate())
                return false;
        }
        return true;
    }

    // Form_CustomValidate
    fpenagihanadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fpenagihanadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fpenagihanadd.lists.status = <?= $Page->status->toClientList($Page) ?>;
    loadjs.done("fpenagihanadd");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fpenagihanadd" id="fpenagihanadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="penagihan">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->messages->Visible) { // messages ?>
    <div id="r_messages" class="form-group row">
        <label id="elh_penagihan_messages" for="x_messages" class="<?= $Page->LeftColumnClass ?>"><?= $Page->messages->caption() ?><?= $Page->messages->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->messages->cellAttributes() ?>>
<span id="el_penagihan_messages">
<textarea data-table="penagihan" data-field="x_messages" name="x_messages" id="x_messages" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->messages->getPlaceHolder()) ?>"<?= $Page->messages->editAttributes() ?> aria-describedby="x_messages_help"><?= $Page->messages->EditValue ?></textarea>
<?= $Page->messages->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->messages->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tgl_order->Visible) { // tgl_order ?>
    <div id="r_tgl_order" class="form-group row">
        <label id="elh_penagihan_tgl_order" for="x_tgl_order" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tgl_order->caption() ?><?= $Page->tgl_order->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tgl_order->cellAttributes() ?>>
<span id="el_penagihan_tgl_order">
<input type="<?= $Page->tgl_order->getInputTextType() ?>" data-table="penagihan" data-field="x_tgl_order" name="x_tgl_order" id="x_tgl_order" placeholder="<?= HtmlEncode($Page->tgl_order->getPlaceHolder()) ?>" value="<?= $Page->tgl_order->EditValue ?>"<?= $Page->tgl_order->editAttributes() ?> aria-describedby="x_tgl_order_help">
<?= $Page->tgl_order->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tgl_order->getErrorMessage() ?></div>
<?php if (!$Page->tgl_order->ReadOnly && !$Page->tgl_order->Disabled && !isset($Page->tgl_order->EditAttrs["readonly"]) && !isset($Page->tgl_order->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpenagihanadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fpenagihanadd", "x_tgl_order", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kode_order->Visible) { // kode_order ?>
    <div id="r_kode_order" class="form-group row">
        <label id="elh_penagihan_kode_order" for="x_kode_order" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kode_order->caption() ?><?= $Page->kode_order->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kode_order->cellAttributes() ?>>
<span id="el_penagihan_kode_order">
<input type="<?= $Page->kode_order->getInputTextType() ?>" data-table="penagihan" data-field="x_kode_order" name="x_kode_order" id="x_kode_order" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->kode_order->getPlaceHolder()) ?>" value="<?= $Page->kode_order->EditValue ?>"<?= $Page->kode_order->editAttributes() ?> aria-describedby="x_kode_order_help">
<?= $Page->kode_order->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kode_order->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nama_customer->Visible) { // nama_customer ?>
    <div id="r_nama_customer" class="form-group row">
        <label id="elh_penagihan_nama_customer" for="x_nama_customer" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama_customer->caption() ?><?= $Page->nama_customer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama_customer->cellAttributes() ?>>
<span id="el_penagihan_nama_customer">
<input type="<?= $Page->nama_customer->getInputTextType() ?>" data-table="penagihan" data-field="x_nama_customer" name="x_nama_customer" id="x_nama_customer" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->nama_customer->getPlaceHolder()) ?>" value="<?= $Page->nama_customer->EditValue ?>"<?= $Page->nama_customer->editAttributes() ?> aria-describedby="x_nama_customer_help">
<?= $Page->nama_customer->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama_customer->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nomor_handphone->Visible) { // nomor_handphone ?>
    <div id="r_nomor_handphone" class="form-group row">
        <label id="elh_penagihan_nomor_handphone" for="x_nomor_handphone" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nomor_handphone->caption() ?><?= $Page->nomor_handphone->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nomor_handphone->cellAttributes() ?>>
<span id="el_penagihan_nomor_handphone">
<input type="<?= $Page->nomor_handphone->getInputTextType() ?>" data-table="penagihan" data-field="x_nomor_handphone" name="x_nomor_handphone" id="x_nomor_handphone" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->nomor_handphone->getPlaceHolder()) ?>" value="<?= $Page->nomor_handphone->EditValue ?>"<?= $Page->nomor_handphone->editAttributes() ?> aria-describedby="x_nomor_handphone_help">
<?= $Page->nomor_handphone->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nomor_handphone->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nilai_po->Visible) { // nilai_po ?>
    <div id="r_nilai_po" class="form-group row">
        <label id="elh_penagihan_nilai_po" for="x_nilai_po" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nilai_po->caption() ?><?= $Page->nilai_po->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nilai_po->cellAttributes() ?>>
<span id="el_penagihan_nilai_po">
<input type="<?= $Page->nilai_po->getInputTextType() ?>" data-table="penagihan" data-field="x_nilai_po" name="x_nilai_po" id="x_nilai_po" size="30" placeholder="<?= HtmlEncode($Page->nilai_po->getPlaceHolder()) ?>" value="<?= $Page->nilai_po->EditValue ?>"<?= $Page->nilai_po->editAttributes() ?> aria-describedby="x_nilai_po_help">
<?= $Page->nilai_po->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nilai_po->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tgl_faktur->Visible) { // tgl_faktur ?>
    <div id="r_tgl_faktur" class="form-group row">
        <label id="elh_penagihan_tgl_faktur" for="x_tgl_faktur" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tgl_faktur->caption() ?><?= $Page->tgl_faktur->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tgl_faktur->cellAttributes() ?>>
<span id="el_penagihan_tgl_faktur">
<input type="<?= $Page->tgl_faktur->getInputTextType() ?>" data-table="penagihan" data-field="x_tgl_faktur" name="x_tgl_faktur" id="x_tgl_faktur" placeholder="<?= HtmlEncode($Page->tgl_faktur->getPlaceHolder()) ?>" value="<?= $Page->tgl_faktur->EditValue ?>"<?= $Page->tgl_faktur->editAttributes() ?> aria-describedby="x_tgl_faktur_help">
<?= $Page->tgl_faktur->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tgl_faktur->getErrorMessage() ?></div>
<?php if (!$Page->tgl_faktur->ReadOnly && !$Page->tgl_faktur->Disabled && !isset($Page->tgl_faktur->EditAttrs["readonly"]) && !isset($Page->tgl_faktur->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpenagihanadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fpenagihanadd", "x_tgl_faktur", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nilai_faktur->Visible) { // nilai_faktur ?>
    <div id="r_nilai_faktur" class="form-group row">
        <label id="elh_penagihan_nilai_faktur" for="x_nilai_faktur" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nilai_faktur->caption() ?><?= $Page->nilai_faktur->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nilai_faktur->cellAttributes() ?>>
<span id="el_penagihan_nilai_faktur">
<input type="<?= $Page->nilai_faktur->getInputTextType() ?>" data-table="penagihan" data-field="x_nilai_faktur" name="x_nilai_faktur" id="x_nilai_faktur" size="30" placeholder="<?= HtmlEncode($Page->nilai_faktur->getPlaceHolder()) ?>" value="<?= $Page->nilai_faktur->EditValue ?>"<?= $Page->nilai_faktur->editAttributes() ?> aria-describedby="x_nilai_faktur_help">
<?= $Page->nilai_faktur->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nilai_faktur->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->piutang->Visible) { // piutang ?>
    <div id="r_piutang" class="form-group row">
        <label id="elh_penagihan_piutang" for="x_piutang" class="<?= $Page->LeftColumnClass ?>"><?= $Page->piutang->caption() ?><?= $Page->piutang->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->piutang->cellAttributes() ?>>
<span id="el_penagihan_piutang">
<input type="<?= $Page->piutang->getInputTextType() ?>" data-table="penagihan" data-field="x_piutang" name="x_piutang" id="x_piutang" size="30" placeholder="<?= HtmlEncode($Page->piutang->getPlaceHolder()) ?>" value="<?= $Page->piutang->EditValue ?>"<?= $Page->piutang->editAttributes() ?> aria-describedby="x_piutang_help">
<?= $Page->piutang->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->piutang->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->umur_faktur->Visible) { // umur_faktur ?>
    <div id="r_umur_faktur" class="form-group row">
        <label id="elh_penagihan_umur_faktur" for="x_umur_faktur" class="<?= $Page->LeftColumnClass ?>"><?= $Page->umur_faktur->caption() ?><?= $Page->umur_faktur->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->umur_faktur->cellAttributes() ?>>
<span id="el_penagihan_umur_faktur">
<input type="<?= $Page->umur_faktur->getInputTextType() ?>" data-table="penagihan" data-field="x_umur_faktur" name="x_umur_faktur" id="x_umur_faktur" size="30" placeholder="<?= HtmlEncode($Page->umur_faktur->getPlaceHolder()) ?>" value="<?= $Page->umur_faktur->EditValue ?>"<?= $Page->umur_faktur->editAttributes() ?> aria-describedby="x_umur_faktur_help">
<?= $Page->umur_faktur->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->umur_faktur->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tgl_antrian->Visible) { // tgl_antrian ?>
    <div id="r_tgl_antrian" class="form-group row">
        <label id="elh_penagihan_tgl_antrian" for="x_tgl_antrian" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tgl_antrian->caption() ?><?= $Page->tgl_antrian->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tgl_antrian->cellAttributes() ?>>
<span id="el_penagihan_tgl_antrian">
<input type="<?= $Page->tgl_antrian->getInputTextType() ?>" data-table="penagihan" data-field="x_tgl_antrian" name="x_tgl_antrian" id="x_tgl_antrian" placeholder="<?= HtmlEncode($Page->tgl_antrian->getPlaceHolder()) ?>" value="<?= $Page->tgl_antrian->EditValue ?>"<?= $Page->tgl_antrian->editAttributes() ?> aria-describedby="x_tgl_antrian_help">
<?= $Page->tgl_antrian->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tgl_antrian->getErrorMessage() ?></div>
<?php if (!$Page->tgl_antrian->ReadOnly && !$Page->tgl_antrian->Disabled && !isset($Page->tgl_antrian->EditAttrs["readonly"]) && !isset($Page->tgl_antrian->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpenagihanadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fpenagihanadd", "x_tgl_antrian", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status" class="form-group row">
        <label id="elh_penagihan_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->status->cellAttributes() ?>>
<span id="el_penagihan_status">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->status->isInvalidClass() ?>" data-table="penagihan" data-field="x_status" name="x_status[]" id="x_status_867798" value="1"<?= ConvertToBool($Page->status->CurrentValue) ? " checked" : "" ?><?= $Page->status->editAttributes() ?> aria-describedby="x_status_help">
    <label class="custom-control-label" for="x_status_867798"></label>
</div>
<?= $Page->status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tgl_penagihan->Visible) { // tgl_penagihan ?>
    <div id="r_tgl_penagihan" class="form-group row">
        <label id="elh_penagihan_tgl_penagihan" for="x_tgl_penagihan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tgl_penagihan->caption() ?><?= $Page->tgl_penagihan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tgl_penagihan->cellAttributes() ?>>
<span id="el_penagihan_tgl_penagihan">
<input type="<?= $Page->tgl_penagihan->getInputTextType() ?>" data-table="penagihan" data-field="x_tgl_penagihan" name="x_tgl_penagihan" id="x_tgl_penagihan" placeholder="<?= HtmlEncode($Page->tgl_penagihan->getPlaceHolder()) ?>" value="<?= $Page->tgl_penagihan->EditValue ?>"<?= $Page->tgl_penagihan->editAttributes() ?> aria-describedby="x_tgl_penagihan_help">
<?= $Page->tgl_penagihan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tgl_penagihan->getErrorMessage() ?></div>
<?php if (!$Page->tgl_penagihan->ReadOnly && !$Page->tgl_penagihan->Disabled && !isset($Page->tgl_penagihan->EditAttrs["readonly"]) && !isset($Page->tgl_penagihan->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpenagihanadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fpenagihanadd", "x_tgl_penagihan", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tgl_return->Visible) { // tgl_return ?>
    <div id="r_tgl_return" class="form-group row">
        <label id="elh_penagihan_tgl_return" for="x_tgl_return" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tgl_return->caption() ?><?= $Page->tgl_return->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tgl_return->cellAttributes() ?>>
<span id="el_penagihan_tgl_return">
<input type="<?= $Page->tgl_return->getInputTextType() ?>" data-table="penagihan" data-field="x_tgl_return" name="x_tgl_return" id="x_tgl_return" placeholder="<?= HtmlEncode($Page->tgl_return->getPlaceHolder()) ?>" value="<?= $Page->tgl_return->EditValue ?>"<?= $Page->tgl_return->editAttributes() ?> aria-describedby="x_tgl_return_help">
<?= $Page->tgl_return->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tgl_return->getErrorMessage() ?></div>
<?php if (!$Page->tgl_return->ReadOnly && !$Page->tgl_return->Disabled && !isset($Page->tgl_return->EditAttrs["readonly"]) && !isset($Page->tgl_return->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpenagihanadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fpenagihanadd", "x_tgl_return", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tgl_cancel->Visible) { // tgl_cancel ?>
    <div id="r_tgl_cancel" class="form-group row">
        <label id="elh_penagihan_tgl_cancel" for="x_tgl_cancel" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tgl_cancel->caption() ?><?= $Page->tgl_cancel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tgl_cancel->cellAttributes() ?>>
<span id="el_penagihan_tgl_cancel">
<input type="<?= $Page->tgl_cancel->getInputTextType() ?>" data-table="penagihan" data-field="x_tgl_cancel" name="x_tgl_cancel" id="x_tgl_cancel" placeholder="<?= HtmlEncode($Page->tgl_cancel->getPlaceHolder()) ?>" value="<?= $Page->tgl_cancel->EditValue ?>"<?= $Page->tgl_cancel->editAttributes() ?> aria-describedby="x_tgl_cancel_help">
<?= $Page->tgl_cancel->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tgl_cancel->getErrorMessage() ?></div>
<?php if (!$Page->tgl_cancel->ReadOnly && !$Page->tgl_cancel->Disabled && !isset($Page->tgl_cancel->EditAttrs["readonly"]) && !isset($Page->tgl_cancel->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpenagihanadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fpenagihanadd", "x_tgl_cancel", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->messagets->Visible) { // messagets ?>
    <div id="r_messagets" class="form-group row">
        <label id="elh_penagihan_messagets" for="x_messagets" class="<?= $Page->LeftColumnClass ?>"><?= $Page->messagets->caption() ?><?= $Page->messagets->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->messagets->cellAttributes() ?>>
<span id="el_penagihan_messagets">
<textarea data-table="penagihan" data-field="x_messagets" name="x_messagets" id="x_messagets" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->messagets->getPlaceHolder()) ?>"<?= $Page->messagets->editAttributes() ?> aria-describedby="x_messagets_help"><?= $Page->messagets->EditValue ?></textarea>
<?= $Page->messagets->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->messagets->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->statusts->Visible) { // statusts ?>
    <div id="r_statusts" class="form-group row">
        <label id="elh_penagihan_statusts" for="x_statusts" class="<?= $Page->LeftColumnClass ?>"><?= $Page->statusts->caption() ?><?= $Page->statusts->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->statusts->cellAttributes() ?>>
<span id="el_penagihan_statusts">
<input type="<?= $Page->statusts->getInputTextType() ?>" data-table="penagihan" data-field="x_statusts" name="x_statusts" id="x_statusts" size="30" placeholder="<?= HtmlEncode($Page->statusts->getPlaceHolder()) ?>" value="<?= $Page->statusts->EditValue ?>"<?= $Page->statusts->editAttributes() ?> aria-describedby="x_statusts_help">
<?= $Page->statusts->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->statusts->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->statusbayar->Visible) { // statusbayar ?>
    <div id="r_statusbayar" class="form-group row">
        <label id="elh_penagihan_statusbayar" for="x_statusbayar" class="<?= $Page->LeftColumnClass ?>"><?= $Page->statusbayar->caption() ?><?= $Page->statusbayar->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->statusbayar->cellAttributes() ?>>
<span id="el_penagihan_statusbayar">
<input type="<?= $Page->statusbayar->getInputTextType() ?>" data-table="penagihan" data-field="x_statusbayar" name="x_statusbayar" id="x_statusbayar" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->statusbayar->getPlaceHolder()) ?>" value="<?= $Page->statusbayar->EditValue ?>"<?= $Page->statusbayar->editAttributes() ?> aria-describedby="x_statusbayar_help">
<?= $Page->statusbayar->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->statusbayar->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nomorfaktur->Visible) { // nomorfaktur ?>
    <div id="r_nomorfaktur" class="form-group row">
        <label id="elh_penagihan_nomorfaktur" for="x_nomorfaktur" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nomorfaktur->caption() ?><?= $Page->nomorfaktur->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nomorfaktur->cellAttributes() ?>>
<span id="el_penagihan_nomorfaktur">
<input type="<?= $Page->nomorfaktur->getInputTextType() ?>" data-table="penagihan" data-field="x_nomorfaktur" name="x_nomorfaktur" id="x_nomorfaktur" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->nomorfaktur->getPlaceHolder()) ?>" value="<?= $Page->nomorfaktur->EditValue ?>"<?= $Page->nomorfaktur->editAttributes() ?> aria-describedby="x_nomorfaktur_help">
<?= $Page->nomorfaktur->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nomorfaktur->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pembayaran->Visible) { // pembayaran ?>
    <div id="r_pembayaran" class="form-group row">
        <label id="elh_penagihan_pembayaran" for="x_pembayaran" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pembayaran->caption() ?><?= $Page->pembayaran->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->pembayaran->cellAttributes() ?>>
<span id="el_penagihan_pembayaran">
<input type="<?= $Page->pembayaran->getInputTextType() ?>" data-table="penagihan" data-field="x_pembayaran" name="x_pembayaran" id="x_pembayaran" size="30" placeholder="<?= HtmlEncode($Page->pembayaran->getPlaceHolder()) ?>" value="<?= $Page->pembayaran->EditValue ?>"<?= $Page->pembayaran->editAttributes() ?> aria-describedby="x_pembayaran_help">
<?= $Page->pembayaran->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->pembayaran->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <div id="r_keterangan" class="form-group row">
        <label id="elh_penagihan_keterangan" for="x_keterangan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->keterangan->caption() ?><?= $Page->keterangan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->keterangan->cellAttributes() ?>>
<span id="el_penagihan_keterangan">
<input type="<?= $Page->keterangan->getInputTextType() ?>" data-table="penagihan" data-field="x_keterangan" name="x_keterangan" id="x_keterangan" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->keterangan->getPlaceHolder()) ?>" value="<?= $Page->keterangan->EditValue ?>"<?= $Page->keterangan->editAttributes() ?> aria-describedby="x_keterangan_help">
<?= $Page->keterangan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->keterangan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->saldo->Visible) { // saldo ?>
    <div id="r_saldo" class="form-group row">
        <label id="elh_penagihan_saldo" for="x_saldo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->saldo->caption() ?><?= $Page->saldo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->saldo->cellAttributes() ?>>
<span id="el_penagihan_saldo">
<input type="<?= $Page->saldo->getInputTextType() ?>" data-table="penagihan" data-field="x_saldo" name="x_saldo" id="x_saldo" size="30" placeholder="<?= HtmlEncode($Page->saldo->getPlaceHolder()) ?>" value="<?= $Page->saldo->EditValue ?>"<?= $Page->saldo->editAttributes() ?> aria-describedby="x_saldo_help">
<?= $Page->saldo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->saldo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("penagihan");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
