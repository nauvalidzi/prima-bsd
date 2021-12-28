<?php

namespace PHPMaker2021\distributor;

// Page object
$NpdTermsAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fnpd_termsadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fnpd_termsadd = currentForm = new ew.Form("fnpd_termsadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "npd_terms")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.npd_terms)
        ew.vars.tables.npd_terms = currentTable;
    fnpd_termsadd.addFields([
        ["idnpd", [fields.idnpd.visible && fields.idnpd.required ? ew.Validators.required(fields.idnpd.caption) : null, ew.Validators.integer], fields.idnpd.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
        ["tglsubmit", [fields.tglsubmit.visible && fields.tglsubmit.required ? ew.Validators.required(fields.tglsubmit.caption) : null, ew.Validators.datetime(0)], fields.tglsubmit.isInvalid],
        ["sifat_order", [fields.sifat_order.visible && fields.sifat_order.required ? ew.Validators.required(fields.sifat_order.caption) : null], fields.sifat_order.isInvalid],
        ["ukuran_utama", [fields.ukuran_utama.visible && fields.ukuran_utama.required ? ew.Validators.required(fields.ukuran_utama.caption) : null], fields.ukuran_utama.isInvalid],
        ["utama_harga_isi", [fields.utama_harga_isi.visible && fields.utama_harga_isi.required ? ew.Validators.required(fields.utama_harga_isi.caption) : null, ew.Validators.integer], fields.utama_harga_isi.isInvalid],
        ["utama_harga_isi_order", [fields.utama_harga_isi_order.visible && fields.utama_harga_isi_order.required ? ew.Validators.required(fields.utama_harga_isi_order.caption) : null, ew.Validators.integer], fields.utama_harga_isi_order.isInvalid],
        ["utama_harga_primer", [fields.utama_harga_primer.visible && fields.utama_harga_primer.required ? ew.Validators.required(fields.utama_harga_primer.caption) : null, ew.Validators.integer], fields.utama_harga_primer.isInvalid],
        ["utama_harga_primer_order", [fields.utama_harga_primer_order.visible && fields.utama_harga_primer_order.required ? ew.Validators.required(fields.utama_harga_primer_order.caption) : null, ew.Validators.integer], fields.utama_harga_primer_order.isInvalid],
        ["utama_harga_sekunder", [fields.utama_harga_sekunder.visible && fields.utama_harga_sekunder.required ? ew.Validators.required(fields.utama_harga_sekunder.caption) : null, ew.Validators.integer], fields.utama_harga_sekunder.isInvalid],
        ["utama_harga_sekunder_order", [fields.utama_harga_sekunder_order.visible && fields.utama_harga_sekunder_order.required ? ew.Validators.required(fields.utama_harga_sekunder_order.caption) : null, ew.Validators.integer], fields.utama_harga_sekunder_order.isInvalid],
        ["utama_harga_label", [fields.utama_harga_label.visible && fields.utama_harga_label.required ? ew.Validators.required(fields.utama_harga_label.caption) : null, ew.Validators.integer], fields.utama_harga_label.isInvalid],
        ["utama_harga_label_order", [fields.utama_harga_label_order.visible && fields.utama_harga_label_order.required ? ew.Validators.required(fields.utama_harga_label_order.caption) : null, ew.Validators.integer], fields.utama_harga_label_order.isInvalid],
        ["utama_harga_total", [fields.utama_harga_total.visible && fields.utama_harga_total.required ? ew.Validators.required(fields.utama_harga_total.caption) : null, ew.Validators.integer], fields.utama_harga_total.isInvalid],
        ["utama_harga_total_order", [fields.utama_harga_total_order.visible && fields.utama_harga_total_order.required ? ew.Validators.required(fields.utama_harga_total_order.caption) : null, ew.Validators.integer], fields.utama_harga_total_order.isInvalid],
        ["ukuran_lain", [fields.ukuran_lain.visible && fields.ukuran_lain.required ? ew.Validators.required(fields.ukuran_lain.caption) : null], fields.ukuran_lain.isInvalid],
        ["lain_harga_isi", [fields.lain_harga_isi.visible && fields.lain_harga_isi.required ? ew.Validators.required(fields.lain_harga_isi.caption) : null, ew.Validators.integer], fields.lain_harga_isi.isInvalid],
        ["lain_harga_isi_order", [fields.lain_harga_isi_order.visible && fields.lain_harga_isi_order.required ? ew.Validators.required(fields.lain_harga_isi_order.caption) : null, ew.Validators.integer], fields.lain_harga_isi_order.isInvalid],
        ["lain_harga_primer", [fields.lain_harga_primer.visible && fields.lain_harga_primer.required ? ew.Validators.required(fields.lain_harga_primer.caption) : null, ew.Validators.integer], fields.lain_harga_primer.isInvalid],
        ["lain_harga_primer_order", [fields.lain_harga_primer_order.visible && fields.lain_harga_primer_order.required ? ew.Validators.required(fields.lain_harga_primer_order.caption) : null, ew.Validators.integer], fields.lain_harga_primer_order.isInvalid],
        ["lain_harga_sekunder", [fields.lain_harga_sekunder.visible && fields.lain_harga_sekunder.required ? ew.Validators.required(fields.lain_harga_sekunder.caption) : null, ew.Validators.integer], fields.lain_harga_sekunder.isInvalid],
        ["lain_harga_sekunder_order", [fields.lain_harga_sekunder_order.visible && fields.lain_harga_sekunder_order.required ? ew.Validators.required(fields.lain_harga_sekunder_order.caption) : null, ew.Validators.integer], fields.lain_harga_sekunder_order.isInvalid],
        ["lain_harga_label", [fields.lain_harga_label.visible && fields.lain_harga_label.required ? ew.Validators.required(fields.lain_harga_label.caption) : null, ew.Validators.integer], fields.lain_harga_label.isInvalid],
        ["lain_harga_label_order", [fields.lain_harga_label_order.visible && fields.lain_harga_label_order.required ? ew.Validators.required(fields.lain_harga_label_order.caption) : null, ew.Validators.integer], fields.lain_harga_label_order.isInvalid],
        ["lain_harga_total", [fields.lain_harga_total.visible && fields.lain_harga_total.required ? ew.Validators.required(fields.lain_harga_total.caption) : null, ew.Validators.integer], fields.lain_harga_total.isInvalid],
        ["lain_harga_total_order", [fields.lain_harga_total_order.visible && fields.lain_harga_total_order.required ? ew.Validators.required(fields.lain_harga_total_order.caption) : null, ew.Validators.integer], fields.lain_harga_total_order.isInvalid],
        ["isi_bahan_aktif", [fields.isi_bahan_aktif.visible && fields.isi_bahan_aktif.required ? ew.Validators.required(fields.isi_bahan_aktif.caption) : null], fields.isi_bahan_aktif.isInvalid],
        ["isi_bahan_lain", [fields.isi_bahan_lain.visible && fields.isi_bahan_lain.required ? ew.Validators.required(fields.isi_bahan_lain.caption) : null], fields.isi_bahan_lain.isInvalid],
        ["isi_parfum", [fields.isi_parfum.visible && fields.isi_parfum.required ? ew.Validators.required(fields.isi_parfum.caption) : null], fields.isi_parfum.isInvalid],
        ["isi_estetika", [fields.isi_estetika.visible && fields.isi_estetika.required ? ew.Validators.required(fields.isi_estetika.caption) : null], fields.isi_estetika.isInvalid],
        ["kemasan_wadah", [fields.kemasan_wadah.visible && fields.kemasan_wadah.required ? ew.Validators.required(fields.kemasan_wadah.caption) : null, ew.Validators.integer], fields.kemasan_wadah.isInvalid],
        ["kemasan_tutup", [fields.kemasan_tutup.visible && fields.kemasan_tutup.required ? ew.Validators.required(fields.kemasan_tutup.caption) : null, ew.Validators.integer], fields.kemasan_tutup.isInvalid],
        ["kemasan_sekunder", [fields.kemasan_sekunder.visible && fields.kemasan_sekunder.required ? ew.Validators.required(fields.kemasan_sekunder.caption) : null], fields.kemasan_sekunder.isInvalid],
        ["label_desain", [fields.label_desain.visible && fields.label_desain.required ? ew.Validators.required(fields.label_desain.caption) : null], fields.label_desain.isInvalid],
        ["label_cetak", [fields.label_cetak.visible && fields.label_cetak.required ? ew.Validators.required(fields.label_cetak.caption) : null], fields.label_cetak.isInvalid],
        ["label_lainlain", [fields.label_lainlain.visible && fields.label_lainlain.required ? ew.Validators.required(fields.label_lainlain.caption) : null], fields.label_lainlain.isInvalid],
        ["delivery_pickup", [fields.delivery_pickup.visible && fields.delivery_pickup.required ? ew.Validators.required(fields.delivery_pickup.caption) : null], fields.delivery_pickup.isInvalid],
        ["delivery_singlepoint", [fields.delivery_singlepoint.visible && fields.delivery_singlepoint.required ? ew.Validators.required(fields.delivery_singlepoint.caption) : null], fields.delivery_singlepoint.isInvalid],
        ["delivery_multipoint", [fields.delivery_multipoint.visible && fields.delivery_multipoint.required ? ew.Validators.required(fields.delivery_multipoint.caption) : null], fields.delivery_multipoint.isInvalid],
        ["delivery_jumlahpoint", [fields.delivery_jumlahpoint.visible && fields.delivery_jumlahpoint.required ? ew.Validators.required(fields.delivery_jumlahpoint.caption) : null], fields.delivery_jumlahpoint.isInvalid],
        ["delivery_termslain", [fields.delivery_termslain.visible && fields.delivery_termslain.required ? ew.Validators.required(fields.delivery_termslain.caption) : null], fields.delivery_termslain.isInvalid],
        ["catatan_khusus", [fields.catatan_khusus.visible && fields.catatan_khusus.required ? ew.Validators.required(fields.catatan_khusus.caption) : null], fields.catatan_khusus.isInvalid],
        ["dibuatdi", [fields.dibuatdi.visible && fields.dibuatdi.required ? ew.Validators.required(fields.dibuatdi.caption) : null], fields.dibuatdi.isInvalid],
        ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(0)], fields.created_at.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fnpd_termsadd,
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
    fnpd_termsadd.validate = function () {
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
    fnpd_termsadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fnpd_termsadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fnpd_termsadd.lists.sifat_order = <?= $Page->sifat_order->toClientList($Page) ?>;
    loadjs.done("fnpd_termsadd");
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
<form name="fnpd_termsadd" id="fnpd_termsadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="npd_terms">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "npd") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="npd">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->idnpd->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->idnpd->Visible) { // idnpd ?>
    <div id="r_idnpd" class="form-group row">
        <label id="elh_npd_terms_idnpd" for="x_idnpd" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idnpd->caption() ?><?= $Page->idnpd->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idnpd->cellAttributes() ?>>
<?php if ($Page->idnpd->getSessionValue() != "") { ?>
<span id="el_npd_terms_idnpd">
<span<?= $Page->idnpd->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idnpd->getDisplayValue($Page->idnpd->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_idnpd" name="x_idnpd" value="<?= HtmlEncode($Page->idnpd->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_npd_terms_idnpd">
<input type="<?= $Page->idnpd->getInputTextType() ?>" data-table="npd_terms" data-field="x_idnpd" name="x_idnpd" id="x_idnpd" size="30" placeholder="<?= HtmlEncode($Page->idnpd->getPlaceHolder()) ?>" value="<?= $Page->idnpd->EditValue ?>"<?= $Page->idnpd->editAttributes() ?> aria-describedby="x_idnpd_help">
<?= $Page->idnpd->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->idnpd->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status" class="form-group row">
        <label id="elh_npd_terms_status" for="x_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->status->cellAttributes() ?>>
<span id="el_npd_terms_status">
<input type="<?= $Page->status->getInputTextType() ?>" data-table="npd_terms" data-field="x_status" name="x_status" id="x_status" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->status->getPlaceHolder()) ?>" value="<?= $Page->status->EditValue ?>"<?= $Page->status->editAttributes() ?> aria-describedby="x_status_help">
<?= $Page->status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tglsubmit->Visible) { // tglsubmit ?>
    <div id="r_tglsubmit" class="form-group row">
        <label id="elh_npd_terms_tglsubmit" for="x_tglsubmit" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tglsubmit->caption() ?><?= $Page->tglsubmit->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglsubmit->cellAttributes() ?>>
<span id="el_npd_terms_tglsubmit">
<input type="<?= $Page->tglsubmit->getInputTextType() ?>" data-table="npd_terms" data-field="x_tglsubmit" name="x_tglsubmit" id="x_tglsubmit" placeholder="<?= HtmlEncode($Page->tglsubmit->getPlaceHolder()) ?>" value="<?= $Page->tglsubmit->EditValue ?>"<?= $Page->tglsubmit->editAttributes() ?> aria-describedby="x_tglsubmit_help">
<?= $Page->tglsubmit->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglsubmit->getErrorMessage() ?></div>
<?php if (!$Page->tglsubmit->ReadOnly && !$Page->tglsubmit->Disabled && !isset($Page->tglsubmit->EditAttrs["readonly"]) && !isset($Page->tglsubmit->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_termsadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_termsadd", "x_tglsubmit", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sifat_order->Visible) { // sifat_order ?>
    <div id="r_sifat_order" class="form-group row">
        <label id="elh_npd_terms_sifat_order" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sifat_order->caption() ?><?= $Page->sifat_order->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->sifat_order->cellAttributes() ?>>
<span id="el_npd_terms_sifat_order">
<div class="custom-control custom-checkbox d-inline-block">
    <input type="checkbox" class="custom-control-input<?= $Page->sifat_order->isInvalidClass() ?>" data-table="npd_terms" data-field="x_sifat_order" name="x_sifat_order[]" id="x_sifat_order_278871" value="1"<?= ConvertToBool($Page->sifat_order->CurrentValue) ? " checked" : "" ?><?= $Page->sifat_order->editAttributes() ?> aria-describedby="x_sifat_order_help">
    <label class="custom-control-label" for="x_sifat_order_278871"></label>
</div>
<?= $Page->sifat_order->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sifat_order->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ukuran_utama->Visible) { // ukuran_utama ?>
    <div id="r_ukuran_utama" class="form-group row">
        <label id="elh_npd_terms_ukuran_utama" for="x_ukuran_utama" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ukuran_utama->caption() ?><?= $Page->ukuran_utama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ukuran_utama->cellAttributes() ?>>
<span id="el_npd_terms_ukuran_utama">
<input type="<?= $Page->ukuran_utama->getInputTextType() ?>" data-table="npd_terms" data-field="x_ukuran_utama" name="x_ukuran_utama" id="x_ukuran_utama" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ukuran_utama->getPlaceHolder()) ?>" value="<?= $Page->ukuran_utama->EditValue ?>"<?= $Page->ukuran_utama->editAttributes() ?> aria-describedby="x_ukuran_utama_help">
<?= $Page->ukuran_utama->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ukuran_utama->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->utama_harga_isi->Visible) { // utama_harga_isi ?>
    <div id="r_utama_harga_isi" class="form-group row">
        <label id="elh_npd_terms_utama_harga_isi" for="x_utama_harga_isi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->utama_harga_isi->caption() ?><?= $Page->utama_harga_isi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->utama_harga_isi->cellAttributes() ?>>
<span id="el_npd_terms_utama_harga_isi">
<input type="<?= $Page->utama_harga_isi->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_isi" name="x_utama_harga_isi" id="x_utama_harga_isi" size="30" placeholder="<?= HtmlEncode($Page->utama_harga_isi->getPlaceHolder()) ?>" value="<?= $Page->utama_harga_isi->EditValue ?>"<?= $Page->utama_harga_isi->editAttributes() ?> aria-describedby="x_utama_harga_isi_help">
<?= $Page->utama_harga_isi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->utama_harga_isi->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->utama_harga_isi_order->Visible) { // utama_harga_isi_order ?>
    <div id="r_utama_harga_isi_order" class="form-group row">
        <label id="elh_npd_terms_utama_harga_isi_order" for="x_utama_harga_isi_order" class="<?= $Page->LeftColumnClass ?>"><?= $Page->utama_harga_isi_order->caption() ?><?= $Page->utama_harga_isi_order->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->utama_harga_isi_order->cellAttributes() ?>>
<span id="el_npd_terms_utama_harga_isi_order">
<input type="<?= $Page->utama_harga_isi_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_isi_order" name="x_utama_harga_isi_order" id="x_utama_harga_isi_order" size="30" placeholder="<?= HtmlEncode($Page->utama_harga_isi_order->getPlaceHolder()) ?>" value="<?= $Page->utama_harga_isi_order->EditValue ?>"<?= $Page->utama_harga_isi_order->editAttributes() ?> aria-describedby="x_utama_harga_isi_order_help">
<?= $Page->utama_harga_isi_order->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->utama_harga_isi_order->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->utama_harga_primer->Visible) { // utama_harga_primer ?>
    <div id="r_utama_harga_primer" class="form-group row">
        <label id="elh_npd_terms_utama_harga_primer" for="x_utama_harga_primer" class="<?= $Page->LeftColumnClass ?>"><?= $Page->utama_harga_primer->caption() ?><?= $Page->utama_harga_primer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->utama_harga_primer->cellAttributes() ?>>
<span id="el_npd_terms_utama_harga_primer">
<input type="<?= $Page->utama_harga_primer->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_primer" name="x_utama_harga_primer" id="x_utama_harga_primer" size="30" placeholder="<?= HtmlEncode($Page->utama_harga_primer->getPlaceHolder()) ?>" value="<?= $Page->utama_harga_primer->EditValue ?>"<?= $Page->utama_harga_primer->editAttributes() ?> aria-describedby="x_utama_harga_primer_help">
<?= $Page->utama_harga_primer->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->utama_harga_primer->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->utama_harga_primer_order->Visible) { // utama_harga_primer_order ?>
    <div id="r_utama_harga_primer_order" class="form-group row">
        <label id="elh_npd_terms_utama_harga_primer_order" for="x_utama_harga_primer_order" class="<?= $Page->LeftColumnClass ?>"><?= $Page->utama_harga_primer_order->caption() ?><?= $Page->utama_harga_primer_order->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->utama_harga_primer_order->cellAttributes() ?>>
<span id="el_npd_terms_utama_harga_primer_order">
<input type="<?= $Page->utama_harga_primer_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_primer_order" name="x_utama_harga_primer_order" id="x_utama_harga_primer_order" size="30" placeholder="<?= HtmlEncode($Page->utama_harga_primer_order->getPlaceHolder()) ?>" value="<?= $Page->utama_harga_primer_order->EditValue ?>"<?= $Page->utama_harga_primer_order->editAttributes() ?> aria-describedby="x_utama_harga_primer_order_help">
<?= $Page->utama_harga_primer_order->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->utama_harga_primer_order->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->utama_harga_sekunder->Visible) { // utama_harga_sekunder ?>
    <div id="r_utama_harga_sekunder" class="form-group row">
        <label id="elh_npd_terms_utama_harga_sekunder" for="x_utama_harga_sekunder" class="<?= $Page->LeftColumnClass ?>"><?= $Page->utama_harga_sekunder->caption() ?><?= $Page->utama_harga_sekunder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->utama_harga_sekunder->cellAttributes() ?>>
<span id="el_npd_terms_utama_harga_sekunder">
<input type="<?= $Page->utama_harga_sekunder->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_sekunder" name="x_utama_harga_sekunder" id="x_utama_harga_sekunder" size="30" placeholder="<?= HtmlEncode($Page->utama_harga_sekunder->getPlaceHolder()) ?>" value="<?= $Page->utama_harga_sekunder->EditValue ?>"<?= $Page->utama_harga_sekunder->editAttributes() ?> aria-describedby="x_utama_harga_sekunder_help">
<?= $Page->utama_harga_sekunder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->utama_harga_sekunder->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->utama_harga_sekunder_order->Visible) { // utama_harga_sekunder_order ?>
    <div id="r_utama_harga_sekunder_order" class="form-group row">
        <label id="elh_npd_terms_utama_harga_sekunder_order" for="x_utama_harga_sekunder_order" class="<?= $Page->LeftColumnClass ?>"><?= $Page->utama_harga_sekunder_order->caption() ?><?= $Page->utama_harga_sekunder_order->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->utama_harga_sekunder_order->cellAttributes() ?>>
<span id="el_npd_terms_utama_harga_sekunder_order">
<input type="<?= $Page->utama_harga_sekunder_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_sekunder_order" name="x_utama_harga_sekunder_order" id="x_utama_harga_sekunder_order" size="30" placeholder="<?= HtmlEncode($Page->utama_harga_sekunder_order->getPlaceHolder()) ?>" value="<?= $Page->utama_harga_sekunder_order->EditValue ?>"<?= $Page->utama_harga_sekunder_order->editAttributes() ?> aria-describedby="x_utama_harga_sekunder_order_help">
<?= $Page->utama_harga_sekunder_order->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->utama_harga_sekunder_order->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->utama_harga_label->Visible) { // utama_harga_label ?>
    <div id="r_utama_harga_label" class="form-group row">
        <label id="elh_npd_terms_utama_harga_label" for="x_utama_harga_label" class="<?= $Page->LeftColumnClass ?>"><?= $Page->utama_harga_label->caption() ?><?= $Page->utama_harga_label->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->utama_harga_label->cellAttributes() ?>>
<span id="el_npd_terms_utama_harga_label">
<input type="<?= $Page->utama_harga_label->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_label" name="x_utama_harga_label" id="x_utama_harga_label" size="30" placeholder="<?= HtmlEncode($Page->utama_harga_label->getPlaceHolder()) ?>" value="<?= $Page->utama_harga_label->EditValue ?>"<?= $Page->utama_harga_label->editAttributes() ?> aria-describedby="x_utama_harga_label_help">
<?= $Page->utama_harga_label->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->utama_harga_label->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->utama_harga_label_order->Visible) { // utama_harga_label_order ?>
    <div id="r_utama_harga_label_order" class="form-group row">
        <label id="elh_npd_terms_utama_harga_label_order" for="x_utama_harga_label_order" class="<?= $Page->LeftColumnClass ?>"><?= $Page->utama_harga_label_order->caption() ?><?= $Page->utama_harga_label_order->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->utama_harga_label_order->cellAttributes() ?>>
<span id="el_npd_terms_utama_harga_label_order">
<input type="<?= $Page->utama_harga_label_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_label_order" name="x_utama_harga_label_order" id="x_utama_harga_label_order" size="30" placeholder="<?= HtmlEncode($Page->utama_harga_label_order->getPlaceHolder()) ?>" value="<?= $Page->utama_harga_label_order->EditValue ?>"<?= $Page->utama_harga_label_order->editAttributes() ?> aria-describedby="x_utama_harga_label_order_help">
<?= $Page->utama_harga_label_order->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->utama_harga_label_order->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->utama_harga_total->Visible) { // utama_harga_total ?>
    <div id="r_utama_harga_total" class="form-group row">
        <label id="elh_npd_terms_utama_harga_total" for="x_utama_harga_total" class="<?= $Page->LeftColumnClass ?>"><?= $Page->utama_harga_total->caption() ?><?= $Page->utama_harga_total->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->utama_harga_total->cellAttributes() ?>>
<span id="el_npd_terms_utama_harga_total">
<input type="<?= $Page->utama_harga_total->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_total" name="x_utama_harga_total" id="x_utama_harga_total" size="30" placeholder="<?= HtmlEncode($Page->utama_harga_total->getPlaceHolder()) ?>" value="<?= $Page->utama_harga_total->EditValue ?>"<?= $Page->utama_harga_total->editAttributes() ?> aria-describedby="x_utama_harga_total_help">
<?= $Page->utama_harga_total->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->utama_harga_total->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->utama_harga_total_order->Visible) { // utama_harga_total_order ?>
    <div id="r_utama_harga_total_order" class="form-group row">
        <label id="elh_npd_terms_utama_harga_total_order" for="x_utama_harga_total_order" class="<?= $Page->LeftColumnClass ?>"><?= $Page->utama_harga_total_order->caption() ?><?= $Page->utama_harga_total_order->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->utama_harga_total_order->cellAttributes() ?>>
<span id="el_npd_terms_utama_harga_total_order">
<input type="<?= $Page->utama_harga_total_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_utama_harga_total_order" name="x_utama_harga_total_order" id="x_utama_harga_total_order" size="30" placeholder="<?= HtmlEncode($Page->utama_harga_total_order->getPlaceHolder()) ?>" value="<?= $Page->utama_harga_total_order->EditValue ?>"<?= $Page->utama_harga_total_order->editAttributes() ?> aria-describedby="x_utama_harga_total_order_help">
<?= $Page->utama_harga_total_order->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->utama_harga_total_order->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ukuran_lain->Visible) { // ukuran_lain ?>
    <div id="r_ukuran_lain" class="form-group row">
        <label id="elh_npd_terms_ukuran_lain" for="x_ukuran_lain" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ukuran_lain->caption() ?><?= $Page->ukuran_lain->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ukuran_lain->cellAttributes() ?>>
<span id="el_npd_terms_ukuran_lain">
<input type="<?= $Page->ukuran_lain->getInputTextType() ?>" data-table="npd_terms" data-field="x_ukuran_lain" name="x_ukuran_lain" id="x_ukuran_lain" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->ukuran_lain->getPlaceHolder()) ?>" value="<?= $Page->ukuran_lain->EditValue ?>"<?= $Page->ukuran_lain->editAttributes() ?> aria-describedby="x_ukuran_lain_help">
<?= $Page->ukuran_lain->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ukuran_lain->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lain_harga_isi->Visible) { // lain_harga_isi ?>
    <div id="r_lain_harga_isi" class="form-group row">
        <label id="elh_npd_terms_lain_harga_isi" for="x_lain_harga_isi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lain_harga_isi->caption() ?><?= $Page->lain_harga_isi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lain_harga_isi->cellAttributes() ?>>
<span id="el_npd_terms_lain_harga_isi">
<input type="<?= $Page->lain_harga_isi->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_isi" name="x_lain_harga_isi" id="x_lain_harga_isi" size="30" placeholder="<?= HtmlEncode($Page->lain_harga_isi->getPlaceHolder()) ?>" value="<?= $Page->lain_harga_isi->EditValue ?>"<?= $Page->lain_harga_isi->editAttributes() ?> aria-describedby="x_lain_harga_isi_help">
<?= $Page->lain_harga_isi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lain_harga_isi->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lain_harga_isi_order->Visible) { // lain_harga_isi_order ?>
    <div id="r_lain_harga_isi_order" class="form-group row">
        <label id="elh_npd_terms_lain_harga_isi_order" for="x_lain_harga_isi_order" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lain_harga_isi_order->caption() ?><?= $Page->lain_harga_isi_order->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lain_harga_isi_order->cellAttributes() ?>>
<span id="el_npd_terms_lain_harga_isi_order">
<input type="<?= $Page->lain_harga_isi_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_isi_order" name="x_lain_harga_isi_order" id="x_lain_harga_isi_order" size="30" placeholder="<?= HtmlEncode($Page->lain_harga_isi_order->getPlaceHolder()) ?>" value="<?= $Page->lain_harga_isi_order->EditValue ?>"<?= $Page->lain_harga_isi_order->editAttributes() ?> aria-describedby="x_lain_harga_isi_order_help">
<?= $Page->lain_harga_isi_order->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lain_harga_isi_order->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lain_harga_primer->Visible) { // lain_harga_primer ?>
    <div id="r_lain_harga_primer" class="form-group row">
        <label id="elh_npd_terms_lain_harga_primer" for="x_lain_harga_primer" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lain_harga_primer->caption() ?><?= $Page->lain_harga_primer->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lain_harga_primer->cellAttributes() ?>>
<span id="el_npd_terms_lain_harga_primer">
<input type="<?= $Page->lain_harga_primer->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_primer" name="x_lain_harga_primer" id="x_lain_harga_primer" size="30" placeholder="<?= HtmlEncode($Page->lain_harga_primer->getPlaceHolder()) ?>" value="<?= $Page->lain_harga_primer->EditValue ?>"<?= $Page->lain_harga_primer->editAttributes() ?> aria-describedby="x_lain_harga_primer_help">
<?= $Page->lain_harga_primer->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lain_harga_primer->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lain_harga_primer_order->Visible) { // lain_harga_primer_order ?>
    <div id="r_lain_harga_primer_order" class="form-group row">
        <label id="elh_npd_terms_lain_harga_primer_order" for="x_lain_harga_primer_order" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lain_harga_primer_order->caption() ?><?= $Page->lain_harga_primer_order->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lain_harga_primer_order->cellAttributes() ?>>
<span id="el_npd_terms_lain_harga_primer_order">
<input type="<?= $Page->lain_harga_primer_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_primer_order" name="x_lain_harga_primer_order" id="x_lain_harga_primer_order" size="30" placeholder="<?= HtmlEncode($Page->lain_harga_primer_order->getPlaceHolder()) ?>" value="<?= $Page->lain_harga_primer_order->EditValue ?>"<?= $Page->lain_harga_primer_order->editAttributes() ?> aria-describedby="x_lain_harga_primer_order_help">
<?= $Page->lain_harga_primer_order->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lain_harga_primer_order->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lain_harga_sekunder->Visible) { // lain_harga_sekunder ?>
    <div id="r_lain_harga_sekunder" class="form-group row">
        <label id="elh_npd_terms_lain_harga_sekunder" for="x_lain_harga_sekunder" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lain_harga_sekunder->caption() ?><?= $Page->lain_harga_sekunder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lain_harga_sekunder->cellAttributes() ?>>
<span id="el_npd_terms_lain_harga_sekunder">
<input type="<?= $Page->lain_harga_sekunder->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_sekunder" name="x_lain_harga_sekunder" id="x_lain_harga_sekunder" size="30" placeholder="<?= HtmlEncode($Page->lain_harga_sekunder->getPlaceHolder()) ?>" value="<?= $Page->lain_harga_sekunder->EditValue ?>"<?= $Page->lain_harga_sekunder->editAttributes() ?> aria-describedby="x_lain_harga_sekunder_help">
<?= $Page->lain_harga_sekunder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lain_harga_sekunder->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lain_harga_sekunder_order->Visible) { // lain_harga_sekunder_order ?>
    <div id="r_lain_harga_sekunder_order" class="form-group row">
        <label id="elh_npd_terms_lain_harga_sekunder_order" for="x_lain_harga_sekunder_order" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lain_harga_sekunder_order->caption() ?><?= $Page->lain_harga_sekunder_order->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lain_harga_sekunder_order->cellAttributes() ?>>
<span id="el_npd_terms_lain_harga_sekunder_order">
<input type="<?= $Page->lain_harga_sekunder_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_sekunder_order" name="x_lain_harga_sekunder_order" id="x_lain_harga_sekunder_order" size="30" placeholder="<?= HtmlEncode($Page->lain_harga_sekunder_order->getPlaceHolder()) ?>" value="<?= $Page->lain_harga_sekunder_order->EditValue ?>"<?= $Page->lain_harga_sekunder_order->editAttributes() ?> aria-describedby="x_lain_harga_sekunder_order_help">
<?= $Page->lain_harga_sekunder_order->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lain_harga_sekunder_order->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lain_harga_label->Visible) { // lain_harga_label ?>
    <div id="r_lain_harga_label" class="form-group row">
        <label id="elh_npd_terms_lain_harga_label" for="x_lain_harga_label" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lain_harga_label->caption() ?><?= $Page->lain_harga_label->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lain_harga_label->cellAttributes() ?>>
<span id="el_npd_terms_lain_harga_label">
<input type="<?= $Page->lain_harga_label->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_label" name="x_lain_harga_label" id="x_lain_harga_label" size="30" placeholder="<?= HtmlEncode($Page->lain_harga_label->getPlaceHolder()) ?>" value="<?= $Page->lain_harga_label->EditValue ?>"<?= $Page->lain_harga_label->editAttributes() ?> aria-describedby="x_lain_harga_label_help">
<?= $Page->lain_harga_label->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lain_harga_label->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lain_harga_label_order->Visible) { // lain_harga_label_order ?>
    <div id="r_lain_harga_label_order" class="form-group row">
        <label id="elh_npd_terms_lain_harga_label_order" for="x_lain_harga_label_order" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lain_harga_label_order->caption() ?><?= $Page->lain_harga_label_order->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lain_harga_label_order->cellAttributes() ?>>
<span id="el_npd_terms_lain_harga_label_order">
<input type="<?= $Page->lain_harga_label_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_label_order" name="x_lain_harga_label_order" id="x_lain_harga_label_order" size="30" placeholder="<?= HtmlEncode($Page->lain_harga_label_order->getPlaceHolder()) ?>" value="<?= $Page->lain_harga_label_order->EditValue ?>"<?= $Page->lain_harga_label_order->editAttributes() ?> aria-describedby="x_lain_harga_label_order_help">
<?= $Page->lain_harga_label_order->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lain_harga_label_order->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lain_harga_total->Visible) { // lain_harga_total ?>
    <div id="r_lain_harga_total" class="form-group row">
        <label id="elh_npd_terms_lain_harga_total" for="x_lain_harga_total" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lain_harga_total->caption() ?><?= $Page->lain_harga_total->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lain_harga_total->cellAttributes() ?>>
<span id="el_npd_terms_lain_harga_total">
<input type="<?= $Page->lain_harga_total->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_total" name="x_lain_harga_total" id="x_lain_harga_total" size="30" placeholder="<?= HtmlEncode($Page->lain_harga_total->getPlaceHolder()) ?>" value="<?= $Page->lain_harga_total->EditValue ?>"<?= $Page->lain_harga_total->editAttributes() ?> aria-describedby="x_lain_harga_total_help">
<?= $Page->lain_harga_total->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lain_harga_total->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lain_harga_total_order->Visible) { // lain_harga_total_order ?>
    <div id="r_lain_harga_total_order" class="form-group row">
        <label id="elh_npd_terms_lain_harga_total_order" for="x_lain_harga_total_order" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lain_harga_total_order->caption() ?><?= $Page->lain_harga_total_order->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lain_harga_total_order->cellAttributes() ?>>
<span id="el_npd_terms_lain_harga_total_order">
<input type="<?= $Page->lain_harga_total_order->getInputTextType() ?>" data-table="npd_terms" data-field="x_lain_harga_total_order" name="x_lain_harga_total_order" id="x_lain_harga_total_order" size="30" placeholder="<?= HtmlEncode($Page->lain_harga_total_order->getPlaceHolder()) ?>" value="<?= $Page->lain_harga_total_order->EditValue ?>"<?= $Page->lain_harga_total_order->editAttributes() ?> aria-describedby="x_lain_harga_total_order_help">
<?= $Page->lain_harga_total_order->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lain_harga_total_order->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->isi_bahan_aktif->Visible) { // isi_bahan_aktif ?>
    <div id="r_isi_bahan_aktif" class="form-group row">
        <label id="elh_npd_terms_isi_bahan_aktif" for="x_isi_bahan_aktif" class="<?= $Page->LeftColumnClass ?>"><?= $Page->isi_bahan_aktif->caption() ?><?= $Page->isi_bahan_aktif->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->isi_bahan_aktif->cellAttributes() ?>>
<span id="el_npd_terms_isi_bahan_aktif">
<input type="<?= $Page->isi_bahan_aktif->getInputTextType() ?>" data-table="npd_terms" data-field="x_isi_bahan_aktif" name="x_isi_bahan_aktif" id="x_isi_bahan_aktif" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->isi_bahan_aktif->getPlaceHolder()) ?>" value="<?= $Page->isi_bahan_aktif->EditValue ?>"<?= $Page->isi_bahan_aktif->editAttributes() ?> aria-describedby="x_isi_bahan_aktif_help">
<?= $Page->isi_bahan_aktif->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->isi_bahan_aktif->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->isi_bahan_lain->Visible) { // isi_bahan_lain ?>
    <div id="r_isi_bahan_lain" class="form-group row">
        <label id="elh_npd_terms_isi_bahan_lain" for="x_isi_bahan_lain" class="<?= $Page->LeftColumnClass ?>"><?= $Page->isi_bahan_lain->caption() ?><?= $Page->isi_bahan_lain->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->isi_bahan_lain->cellAttributes() ?>>
<span id="el_npd_terms_isi_bahan_lain">
<input type="<?= $Page->isi_bahan_lain->getInputTextType() ?>" data-table="npd_terms" data-field="x_isi_bahan_lain" name="x_isi_bahan_lain" id="x_isi_bahan_lain" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->isi_bahan_lain->getPlaceHolder()) ?>" value="<?= $Page->isi_bahan_lain->EditValue ?>"<?= $Page->isi_bahan_lain->editAttributes() ?> aria-describedby="x_isi_bahan_lain_help">
<?= $Page->isi_bahan_lain->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->isi_bahan_lain->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->isi_parfum->Visible) { // isi_parfum ?>
    <div id="r_isi_parfum" class="form-group row">
        <label id="elh_npd_terms_isi_parfum" for="x_isi_parfum" class="<?= $Page->LeftColumnClass ?>"><?= $Page->isi_parfum->caption() ?><?= $Page->isi_parfum->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->isi_parfum->cellAttributes() ?>>
<span id="el_npd_terms_isi_parfum">
<input type="<?= $Page->isi_parfum->getInputTextType() ?>" data-table="npd_terms" data-field="x_isi_parfum" name="x_isi_parfum" id="x_isi_parfum" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->isi_parfum->getPlaceHolder()) ?>" value="<?= $Page->isi_parfum->EditValue ?>"<?= $Page->isi_parfum->editAttributes() ?> aria-describedby="x_isi_parfum_help">
<?= $Page->isi_parfum->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->isi_parfum->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->isi_estetika->Visible) { // isi_estetika ?>
    <div id="r_isi_estetika" class="form-group row">
        <label id="elh_npd_terms_isi_estetika" for="x_isi_estetika" class="<?= $Page->LeftColumnClass ?>"><?= $Page->isi_estetika->caption() ?><?= $Page->isi_estetika->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->isi_estetika->cellAttributes() ?>>
<span id="el_npd_terms_isi_estetika">
<input type="<?= $Page->isi_estetika->getInputTextType() ?>" data-table="npd_terms" data-field="x_isi_estetika" name="x_isi_estetika" id="x_isi_estetika" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->isi_estetika->getPlaceHolder()) ?>" value="<?= $Page->isi_estetika->EditValue ?>"<?= $Page->isi_estetika->editAttributes() ?> aria-describedby="x_isi_estetika_help">
<?= $Page->isi_estetika->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->isi_estetika->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kemasan_wadah->Visible) { // kemasan_wadah ?>
    <div id="r_kemasan_wadah" class="form-group row">
        <label id="elh_npd_terms_kemasan_wadah" for="x_kemasan_wadah" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kemasan_wadah->caption() ?><?= $Page->kemasan_wadah->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kemasan_wadah->cellAttributes() ?>>
<span id="el_npd_terms_kemasan_wadah">
<input type="<?= $Page->kemasan_wadah->getInputTextType() ?>" data-table="npd_terms" data-field="x_kemasan_wadah" name="x_kemasan_wadah" id="x_kemasan_wadah" size="30" placeholder="<?= HtmlEncode($Page->kemasan_wadah->getPlaceHolder()) ?>" value="<?= $Page->kemasan_wadah->EditValue ?>"<?= $Page->kemasan_wadah->editAttributes() ?> aria-describedby="x_kemasan_wadah_help">
<?= $Page->kemasan_wadah->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kemasan_wadah->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kemasan_tutup->Visible) { // kemasan_tutup ?>
    <div id="r_kemasan_tutup" class="form-group row">
        <label id="elh_npd_terms_kemasan_tutup" for="x_kemasan_tutup" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kemasan_tutup->caption() ?><?= $Page->kemasan_tutup->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kemasan_tutup->cellAttributes() ?>>
<span id="el_npd_terms_kemasan_tutup">
<input type="<?= $Page->kemasan_tutup->getInputTextType() ?>" data-table="npd_terms" data-field="x_kemasan_tutup" name="x_kemasan_tutup" id="x_kemasan_tutup" size="30" placeholder="<?= HtmlEncode($Page->kemasan_tutup->getPlaceHolder()) ?>" value="<?= $Page->kemasan_tutup->EditValue ?>"<?= $Page->kemasan_tutup->editAttributes() ?> aria-describedby="x_kemasan_tutup_help">
<?= $Page->kemasan_tutup->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kemasan_tutup->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kemasan_sekunder->Visible) { // kemasan_sekunder ?>
    <div id="r_kemasan_sekunder" class="form-group row">
        <label id="elh_npd_terms_kemasan_sekunder" for="x_kemasan_sekunder" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kemasan_sekunder->caption() ?><?= $Page->kemasan_sekunder->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kemasan_sekunder->cellAttributes() ?>>
<span id="el_npd_terms_kemasan_sekunder">
<input type="<?= $Page->kemasan_sekunder->getInputTextType() ?>" data-table="npd_terms" data-field="x_kemasan_sekunder" name="x_kemasan_sekunder" id="x_kemasan_sekunder" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->kemasan_sekunder->getPlaceHolder()) ?>" value="<?= $Page->kemasan_sekunder->EditValue ?>"<?= $Page->kemasan_sekunder->editAttributes() ?> aria-describedby="x_kemasan_sekunder_help">
<?= $Page->kemasan_sekunder->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kemasan_sekunder->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->label_desain->Visible) { // label_desain ?>
    <div id="r_label_desain" class="form-group row">
        <label id="elh_npd_terms_label_desain" for="x_label_desain" class="<?= $Page->LeftColumnClass ?>"><?= $Page->label_desain->caption() ?><?= $Page->label_desain->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->label_desain->cellAttributes() ?>>
<span id="el_npd_terms_label_desain">
<input type="<?= $Page->label_desain->getInputTextType() ?>" data-table="npd_terms" data-field="x_label_desain" name="x_label_desain" id="x_label_desain" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->label_desain->getPlaceHolder()) ?>" value="<?= $Page->label_desain->EditValue ?>"<?= $Page->label_desain->editAttributes() ?> aria-describedby="x_label_desain_help">
<?= $Page->label_desain->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->label_desain->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->label_cetak->Visible) { // label_cetak ?>
    <div id="r_label_cetak" class="form-group row">
        <label id="elh_npd_terms_label_cetak" for="x_label_cetak" class="<?= $Page->LeftColumnClass ?>"><?= $Page->label_cetak->caption() ?><?= $Page->label_cetak->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->label_cetak->cellAttributes() ?>>
<span id="el_npd_terms_label_cetak">
<input type="<?= $Page->label_cetak->getInputTextType() ?>" data-table="npd_terms" data-field="x_label_cetak" name="x_label_cetak" id="x_label_cetak" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->label_cetak->getPlaceHolder()) ?>" value="<?= $Page->label_cetak->EditValue ?>"<?= $Page->label_cetak->editAttributes() ?> aria-describedby="x_label_cetak_help">
<?= $Page->label_cetak->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->label_cetak->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->label_lainlain->Visible) { // label_lainlain ?>
    <div id="r_label_lainlain" class="form-group row">
        <label id="elh_npd_terms_label_lainlain" for="x_label_lainlain" class="<?= $Page->LeftColumnClass ?>"><?= $Page->label_lainlain->caption() ?><?= $Page->label_lainlain->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->label_lainlain->cellAttributes() ?>>
<span id="el_npd_terms_label_lainlain">
<input type="<?= $Page->label_lainlain->getInputTextType() ?>" data-table="npd_terms" data-field="x_label_lainlain" name="x_label_lainlain" id="x_label_lainlain" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->label_lainlain->getPlaceHolder()) ?>" value="<?= $Page->label_lainlain->EditValue ?>"<?= $Page->label_lainlain->editAttributes() ?> aria-describedby="x_label_lainlain_help">
<?= $Page->label_lainlain->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->label_lainlain->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->delivery_pickup->Visible) { // delivery_pickup ?>
    <div id="r_delivery_pickup" class="form-group row">
        <label id="elh_npd_terms_delivery_pickup" for="x_delivery_pickup" class="<?= $Page->LeftColumnClass ?>"><?= $Page->delivery_pickup->caption() ?><?= $Page->delivery_pickup->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->delivery_pickup->cellAttributes() ?>>
<span id="el_npd_terms_delivery_pickup">
<input type="<?= $Page->delivery_pickup->getInputTextType() ?>" data-table="npd_terms" data-field="x_delivery_pickup" name="x_delivery_pickup" id="x_delivery_pickup" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->delivery_pickup->getPlaceHolder()) ?>" value="<?= $Page->delivery_pickup->EditValue ?>"<?= $Page->delivery_pickup->editAttributes() ?> aria-describedby="x_delivery_pickup_help">
<?= $Page->delivery_pickup->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->delivery_pickup->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->delivery_singlepoint->Visible) { // delivery_singlepoint ?>
    <div id="r_delivery_singlepoint" class="form-group row">
        <label id="elh_npd_terms_delivery_singlepoint" for="x_delivery_singlepoint" class="<?= $Page->LeftColumnClass ?>"><?= $Page->delivery_singlepoint->caption() ?><?= $Page->delivery_singlepoint->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->delivery_singlepoint->cellAttributes() ?>>
<span id="el_npd_terms_delivery_singlepoint">
<input type="<?= $Page->delivery_singlepoint->getInputTextType() ?>" data-table="npd_terms" data-field="x_delivery_singlepoint" name="x_delivery_singlepoint" id="x_delivery_singlepoint" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->delivery_singlepoint->getPlaceHolder()) ?>" value="<?= $Page->delivery_singlepoint->EditValue ?>"<?= $Page->delivery_singlepoint->editAttributes() ?> aria-describedby="x_delivery_singlepoint_help">
<?= $Page->delivery_singlepoint->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->delivery_singlepoint->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->delivery_multipoint->Visible) { // delivery_multipoint ?>
    <div id="r_delivery_multipoint" class="form-group row">
        <label id="elh_npd_terms_delivery_multipoint" for="x_delivery_multipoint" class="<?= $Page->LeftColumnClass ?>"><?= $Page->delivery_multipoint->caption() ?><?= $Page->delivery_multipoint->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->delivery_multipoint->cellAttributes() ?>>
<span id="el_npd_terms_delivery_multipoint">
<input type="<?= $Page->delivery_multipoint->getInputTextType() ?>" data-table="npd_terms" data-field="x_delivery_multipoint" name="x_delivery_multipoint" id="x_delivery_multipoint" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->delivery_multipoint->getPlaceHolder()) ?>" value="<?= $Page->delivery_multipoint->EditValue ?>"<?= $Page->delivery_multipoint->editAttributes() ?> aria-describedby="x_delivery_multipoint_help">
<?= $Page->delivery_multipoint->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->delivery_multipoint->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->delivery_jumlahpoint->Visible) { // delivery_jumlahpoint ?>
    <div id="r_delivery_jumlahpoint" class="form-group row">
        <label id="elh_npd_terms_delivery_jumlahpoint" for="x_delivery_jumlahpoint" class="<?= $Page->LeftColumnClass ?>"><?= $Page->delivery_jumlahpoint->caption() ?><?= $Page->delivery_jumlahpoint->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->delivery_jumlahpoint->cellAttributes() ?>>
<span id="el_npd_terms_delivery_jumlahpoint">
<input type="<?= $Page->delivery_jumlahpoint->getInputTextType() ?>" data-table="npd_terms" data-field="x_delivery_jumlahpoint" name="x_delivery_jumlahpoint" id="x_delivery_jumlahpoint" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->delivery_jumlahpoint->getPlaceHolder()) ?>" value="<?= $Page->delivery_jumlahpoint->EditValue ?>"<?= $Page->delivery_jumlahpoint->editAttributes() ?> aria-describedby="x_delivery_jumlahpoint_help">
<?= $Page->delivery_jumlahpoint->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->delivery_jumlahpoint->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->delivery_termslain->Visible) { // delivery_termslain ?>
    <div id="r_delivery_termslain" class="form-group row">
        <label id="elh_npd_terms_delivery_termslain" for="x_delivery_termslain" class="<?= $Page->LeftColumnClass ?>"><?= $Page->delivery_termslain->caption() ?><?= $Page->delivery_termslain->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->delivery_termslain->cellAttributes() ?>>
<span id="el_npd_terms_delivery_termslain">
<input type="<?= $Page->delivery_termslain->getInputTextType() ?>" data-table="npd_terms" data-field="x_delivery_termslain" name="x_delivery_termslain" id="x_delivery_termslain" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->delivery_termslain->getPlaceHolder()) ?>" value="<?= $Page->delivery_termslain->EditValue ?>"<?= $Page->delivery_termslain->editAttributes() ?> aria-describedby="x_delivery_termslain_help">
<?= $Page->delivery_termslain->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->delivery_termslain->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->catatan_khusus->Visible) { // catatan_khusus ?>
    <div id="r_catatan_khusus" class="form-group row">
        <label id="elh_npd_terms_catatan_khusus" for="x_catatan_khusus" class="<?= $Page->LeftColumnClass ?>"><?= $Page->catatan_khusus->caption() ?><?= $Page->catatan_khusus->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->catatan_khusus->cellAttributes() ?>>
<span id="el_npd_terms_catatan_khusus">
<textarea data-table="npd_terms" data-field="x_catatan_khusus" name="x_catatan_khusus" id="x_catatan_khusus" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->catatan_khusus->getPlaceHolder()) ?>"<?= $Page->catatan_khusus->editAttributes() ?> aria-describedby="x_catatan_khusus_help"><?= $Page->catatan_khusus->EditValue ?></textarea>
<?= $Page->catatan_khusus->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->catatan_khusus->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dibuatdi->Visible) { // dibuatdi ?>
    <div id="r_dibuatdi" class="form-group row">
        <label id="elh_npd_terms_dibuatdi" for="x_dibuatdi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dibuatdi->caption() ?><?= $Page->dibuatdi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->dibuatdi->cellAttributes() ?>>
<span id="el_npd_terms_dibuatdi">
<input type="<?= $Page->dibuatdi->getInputTextType() ?>" data-table="npd_terms" data-field="x_dibuatdi" name="x_dibuatdi" id="x_dibuatdi" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->dibuatdi->getPlaceHolder()) ?>" value="<?= $Page->dibuatdi->EditValue ?>"<?= $Page->dibuatdi->editAttributes() ?> aria-describedby="x_dibuatdi_help">
<?= $Page->dibuatdi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dibuatdi->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <div id="r_created_at" class="form-group row">
        <label id="elh_npd_terms_created_at" for="x_created_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->created_at->caption() ?><?= $Page->created_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->created_at->cellAttributes() ?>>
<span id="el_npd_terms_created_at">
<input type="<?= $Page->created_at->getInputTextType() ?>" data-table="npd_terms" data-field="x_created_at" name="x_created_at" id="x_created_at" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" value="<?= $Page->created_at->EditValue ?>"<?= $Page->created_at->editAttributes() ?> aria-describedby="x_created_at_help">
<?= $Page->created_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fnpd_termsadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fnpd_termsadd", "x_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
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
    ew.addEventHandlers("npd_terms");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
