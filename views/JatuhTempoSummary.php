<?php

namespace PHPMaker2021\distributor;

// Page object
$JatuhTempoSummary = &$Page;
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
var currentForm, currentPageID;
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<a id="top"></a>
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
<!-- Content Container -->
<div id="ew-report" class="ew-report container-fluid">
<?php } ?>
<div class="btn-toolbar ew-toolbar">
<?php
if (!$Page->DrillDownInPanel) {
    $Page->ExportOptions->render("body");
    $Page->SearchOptions->render("body");
    $Page->FilterOptions->render("body");
}
?>
</div>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
<div class="row">
<?php } ?>
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
<!-- Center Container -->
<div id="ew-center" class="<?= $Page->CenterContentClass ?>">
<?php } ?>
<!-- Summary report (begin) -->
<div id="report_summary">
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<?php } ?>
<?php
while ($Page->GroupCount <= count($Page->GroupRecords) && $Page->GroupCount <= $Page->DisplayGroups) {
?>
<?php
    // Show header
    if ($Page->ShowHeader) {
?>
<?php if ($Page->GroupCount > 1) { ?>
</tbody>
</table>
</div>
<!-- /.ew-grid-middle-panel -->
<!-- Report grid (end) -->
<?php if (!$Page->isExport() && !($Page->DrillDown && $Page->TotalGroups > 0)) { ?>
<!-- Bottom pager -->
<div class="card-footer ew-grid-lower-panel">
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<!-- /.ew-grid -->
<?= $Page->PageBreakContent ?>
<?php } ?>
<div class="<?php if (!$Page->isExport("word") && !$Page->isExport("excel")) { ?>card ew-card <?php } ?>ew-grid"<?= $Page->ReportTableStyle ?>>
<!-- Report grid (begin) -->
<div id="gmp_Jatuh_Tempo" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="<?= $Page->ReportTableClass ?>">
<thead>
	<!-- Table header -->
    <tr class="ew-table-header">
<?php if ($Page->idpegawai->Visible) { ?>
    <?php if ($Page->idpegawai->ShowGroupHeaderAsRow) { ?>
    <th data-name="idpegawai">&nbsp;</th>
    <?php } else { ?>
    <th data-name="idpegawai" class="<?= $Page->idpegawai->headerCellClass() ?>"><div class="Jatuh_Tempo_idpegawai"><?= $Page->renderSort($Page->idpegawai) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { ?>
    <?php if ($Page->idcustomer->ShowGroupHeaderAsRow) { ?>
    <th data-name="idcustomer">&nbsp;</th>
    <?php } else { ?>
    <th data-name="idcustomer" class="<?= $Page->idcustomer->headerCellClass() ?>"><div class="Jatuh_Tempo_idcustomer"><?= $Page->renderSort($Page->idcustomer) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->idinvoice->Visible) { ?>
    <th data-name="idinvoice" class="<?= $Page->idinvoice->headerCellClass() ?>"><div class="Jatuh_Tempo_idinvoice"><?= $Page->renderSort($Page->idinvoice) ?></div></th>
<?php } ?>
<?php if ($Page->sisabayar->Visible) { ?>
    <th data-name="sisabayar" class="<?= $Page->sisabayar->headerCellClass() ?>"><div class="Jatuh_Tempo_sisabayar"><?= $Page->renderSort($Page->sisabayar) ?></div></th>
<?php } ?>
<?php if ($Page->jatuhtempo->Visible) { ?>
    <th data-name="jatuhtempo" class="<?= $Page->jatuhtempo->headerCellClass() ?>"><div class="Jatuh_Tempo_jatuhtempo"><?= $Page->renderSort($Page->jatuhtempo) ?></div></th>
<?php } ?>
<?php if ($Page->kodeinvoice->Visible) { ?>
    <th data-name="kodeinvoice" class="<?= $Page->kodeinvoice->headerCellClass() ?>"><div class="Jatuh_Tempo_kodeinvoice"><?= $Page->renderSort($Page->kodeinvoice) ?></div></th>
<?php } ?>
    </tr>
</thead>
<tbody>
<?php
        if ($Page->TotalGroups == 0) {
            break; // Show header only
        }
        $Page->ShowHeader = false;
    } // End show header
?>
<?php

    // Build detail SQL
    $where = DetailFilterSql($Page->idpegawai, $Page->getSqlFirstGroupField(), $Page->idpegawai->groupValue(), $Page->Dbid);
    if ($Page->PageFirstGroupFilter != "") {
        $Page->PageFirstGroupFilter .= " OR ";
    }
    $Page->PageFirstGroupFilter .= $where;
    if ($Page->Filter != "") {
        $where = "($Page->Filter) AND ($where)";
    }
    $sql = $Page->buildReportSql($Page->getSqlSelect(), $Page->getSqlFrom(), $Page->getSqlWhere(), $Page->getSqlGroupBy(), $Page->getSqlHaving(), $Page->getSqlOrderBy(), $where, $Page->Sort);
    $rs = $sql->execute();
    $Page->DetailRecords = $rs ? $rs->fetchAll() : [];
    $Page->DetailRecordCount = count($Page->DetailRecords);

    // Load detail records
    $Page->idpegawai->Records = &$Page->DetailRecords;
    $Page->idpegawai->LevelBreak = true; // Set field level break
    $Page->GroupCounter[1] = $Page->GroupCount;
    $Page->idpegawai->getCnt($Page->idpegawai->Records); // Get record count
    ?>
<?php if ($Page->idpegawai->Visible && $Page->idpegawai->ShowGroupHeaderAsRow) { ?>
<?php
        // Render header row
        $Page->resetAttributes();
        $Page->RowType = ROWTYPE_TOTAL;
        $Page->RowTotalType = ROWTOTAL_GROUP;
        $Page->RowTotalSubType = ROWTOTAL_HEADER;
        $Page->RowGroupLevel = 1;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->idpegawai->Visible) { ?>
        <td data-field="idpegawai"<?= $Page->idpegawai->cellAttributes(); ?>><span class="ew-group-toggle icon-collapse"></span></td>
<?php } ?>
        <td data-field="idpegawai" colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount - 1) ?>"<?= $Page->idpegawai->cellAttributes() ?>>
        <span class="ew-summary-caption d-inline-block Jatuh_Tempo_idpegawai"><?= $Page->renderSort($Page->idpegawai) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->idpegawai->viewAttributes() ?>><?= $Page->idpegawai->GroupViewValue ?></span>
        <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><?= $Language->phrase("AggregateEqual") ?><span class="ew-aggregate-value"><?= FormatNumber($Page->idpegawai->Count, 0); ?></span>)</span>
        </td>
    </tr>
<?php } ?>
    <?php
    $Page->idcustomer->getDistinctValues($Page->idpegawai->Records);
    $Page->setGroupCount(count($Page->idcustomer->DistinctValues), $Page->GroupCounter[1]);
    $Page->GroupCounter[2] = 0; // Init group count index
    foreach ($Page->idcustomer->DistinctValues as $idcustomer) { // Load records for this distinct value
    $Page->idcustomer->setGroupValue($idcustomer); // Set group value
    $Page->idcustomer->getDistinctRecords($Page->idpegawai->Records, $Page->idcustomer->groupValue());
    $Page->idcustomer->LevelBreak = true; // Set field level break
    $Page->GroupCounter[2]++;
    $Page->idcustomer->getCnt($Page->idcustomer->Records); // Get record count
    $Page->setGroupCount($Page->idcustomer->Count, $Page->GroupCounter[1], $Page->GroupCounter[2]);
    ?>
<?php if ($Page->idcustomer->Visible && $Page->idcustomer->ShowGroupHeaderAsRow) { ?>
<?php
        // Render header row
        $Page->idcustomer->setDbValue($idcustomer); // Set current value for idcustomer
        $Page->resetAttributes();
        $Page->RowType = ROWTYPE_TOTAL;
        $Page->RowTotalType = ROWTOTAL_GROUP;
        $Page->RowTotalSubType = ROWTOTAL_HEADER;
        $Page->RowGroupLevel = 2;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->idpegawai->Visible) { ?>
        <td data-field="idpegawai"<?= $Page->idpegawai->cellAttributes(); ?>></td>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { ?>
        <td data-field="idcustomer"<?= $Page->idcustomer->cellAttributes(); ?>><span class="ew-group-toggle icon-collapse"></span></td>
<?php } ?>
        <td data-field="idcustomer" colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount - 2) ?>"<?= $Page->idcustomer->cellAttributes() ?>>
        <span class="ew-summary-caption d-inline-block Jatuh_Tempo_idcustomer"><?= $Page->renderSort($Page->idcustomer) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->idcustomer->viewAttributes() ?>><?= $Page->idcustomer->GroupViewValue ?></span>
        <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><?= $Language->phrase("AggregateEqual") ?><span class="ew-aggregate-value"><?= FormatNumber($Page->idcustomer->Count, 0); ?></span>)</span>
        </td>
    </tr>
<?php } ?>
    <?php
    $Page->RecordCount = 0; // Reset record count
    foreach ($Page->idcustomer->Records as $record) {
        $Page->RecordCount++;
        $Page->RecordIndex++;
        $Page->loadRowValues($record);
?>
<?php
        // Render detail row
        $Page->resetAttributes();
        $Page->RowType = ROWTYPE_DETAIL;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->idpegawai->Visible) { ?>
    <?php if ($Page->idpegawai->ShowGroupHeaderAsRow) { ?>
        <td data-field="idpegawai"<?= $Page->idpegawai->cellAttributes(); ?>>&nbsp;</td>
    <?php } else { ?>
        <td data-field="idpegawai"<?= $Page->idpegawai->cellAttributes(); ?>><span<?= $Page->idpegawai->viewAttributes() ?>><?= $Page->idpegawai->GroupViewValue ?></span></td>
    <?php } ?>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { ?>
    <?php if ($Page->idcustomer->ShowGroupHeaderAsRow) { ?>
        <td data-field="idcustomer"<?= $Page->idcustomer->cellAttributes(); ?>>&nbsp;</td>
    <?php } else { ?>
        <td data-field="idcustomer"<?= $Page->idcustomer->cellAttributes(); ?>><span<?= $Page->idcustomer->viewAttributes() ?>><?= $Page->idcustomer->GroupViewValue ?></span></td>
    <?php } ?>
<?php } ?>
<?php if ($Page->idinvoice->Visible) { ?>
        <td data-field="idinvoice"<?= $Page->idinvoice->cellAttributes() ?>>
<span<?= $Page->idinvoice->viewAttributes() ?>>
<?= $Page->idinvoice->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->sisabayar->Visible) { ?>
        <td data-field="sisabayar"<?= $Page->sisabayar->cellAttributes() ?>>
<span<?= $Page->sisabayar->viewAttributes() ?>>
<?= $Page->sisabayar->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->jatuhtempo->Visible) { ?>
        <td data-field="jatuhtempo"<?= $Page->jatuhtempo->cellAttributes() ?>>
<span<?= $Page->jatuhtempo->viewAttributes() ?>>
<?= $Page->jatuhtempo->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->kodeinvoice->Visible) { ?>
        <td data-field="kodeinvoice"<?= $Page->kodeinvoice->cellAttributes() ?>>
<span<?= $Page->kodeinvoice->viewAttributes() ?>>
<?= $Page->kodeinvoice->getViewValue() ?></span>
</td>
<?php } ?>
    </tr>
<?php
    }
?>
<?php if ($Page->TotalGroups > 0) { ?>
<?php
    $Page->sisabayar->getSum($Page->idcustomer->Records); // Get Sum
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_TOTAL;
    $Page->RowTotalType = ROWTOTAL_GROUP;
    $Page->RowTotalSubType = ROWTOTAL_FOOTER;
    $Page->RowGroupLevel = 2;
    $Page->renderRow();
?>
<?php if ($Page->idcustomer->ShowCompactSummaryFooter) { ?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->idpegawai->Visible) { ?>
        <td data-field="idpegawai"<?= $Page->idpegawai->cellAttributes() ?>>
    <?php if ($Page->idpegawai->ShowGroupHeaderAsRow) { ?>
        &nbsp;
    <?php } elseif ($Page->RowGroupLevel != 1) { ?>
        &nbsp;
    <?php } else { ?>
        <span class="ew-summary-count"><span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><?= $Language->phrase("AggregateEqual") ?><span class="ew-aggregate-value"><?= FormatNumber($Page->idpegawai->Count, 0); ?></span></span>
    <?php } ?>
        </td>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { ?>
        <td data-field="idcustomer"<?= $Page->idcustomer->cellAttributes() ?>>
    <?php if ($Page->idcustomer->ShowGroupHeaderAsRow) { ?>
        &nbsp;
    <?php } elseif ($Page->RowGroupLevel != 2) { ?>
        &nbsp;
    <?php } else { ?>
        <span class="ew-summary-count"><span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><?= $Language->phrase("AggregateEqual") ?><span class="ew-aggregate-value"><?= FormatNumber($Page->idcustomer->Count, 0); ?></span></span>
    <?php } ?>
        </td>
<?php } ?>
<?php if ($Page->idinvoice->Visible) { ?>
        <td data-field="idinvoice"<?= $Page->idcustomer->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->sisabayar->Visible) { ?>
        <td data-field="sisabayar"<?= $Page->idcustomer->cellAttributes() ?>><span class="ew-aggregate-caption"><?= $Language->phrase("RptSum") ?></span><?= $Language->phrase("AggregateEqual") ?><span class="ew-aggregate-value"><span<?= $Page->sisabayar->viewAttributes() ?>><?= $Page->sisabayar->SumViewValue ?></span></span></td>
<?php } ?>
<?php if ($Page->jatuhtempo->Visible) { ?>
        <td data-field="jatuhtempo"<?= $Page->idcustomer->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->kodeinvoice->Visible) { ?>
        <td data-field="kodeinvoice"<?= $Page->idcustomer->cellAttributes() ?>></td>
<?php } ?>
    </tr>
<?php } else { ?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->idpegawai->Visible) { ?>
        <td data-field="idpegawai"<?= $Page->idpegawai->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->SubGroupColumnCount + $Page->DetailColumnCount > 0) { ?>
        <td colspan="<?= ($Page->SubGroupColumnCount + $Page->DetailColumnCount) ?>"<?= $Page->idcustomer->cellAttributes() ?>><?= str_replace(["%v", "%c"], [$Page->idcustomer->GroupViewValue, $Page->idcustomer->caption()], $Language->phrase("RptSumHead")) ?> <span class="ew-dir-ltr">(<?= FormatNumber($Page->idcustomer->Count, 0); ?><?= $Language->phrase("RptDtlRec") ?>)</span></td>
<?php } ?>
    </tr>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->idpegawai->Visible) { ?>
        <td data-field="idpegawai"<?= $Page->idpegawai->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->GroupColumnCount > 0) { ?>
        <td colspan="<?= ($Page->GroupColumnCount - 1) ?>"<?= $Page->idcustomer->cellAttributes() ?>><?= $Language->phrase("RptSum") ?></td>
<?php } ?>
<?php if ($Page->idinvoice->Visible) { ?>
        <td data-field="idinvoice"<?= $Page->idcustomer->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->sisabayar->Visible) { ?>
        <td data-field="sisabayar"<?= $Page->sisabayar->cellAttributes() ?>>
<span<?= $Page->sisabayar->viewAttributes() ?>>
<?= $Page->sisabayar->SumViewValue ?></span>
</td>
<?php } ?>
<?php if ($Page->jatuhtempo->Visible) { ?>
        <td data-field="jatuhtempo"<?= $Page->idcustomer->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->kodeinvoice->Visible) { ?>
        <td data-field="kodeinvoice"<?= $Page->idcustomer->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
    </tr>
<?php } ?>
<?php } ?>
<?php
    } // End group level 1
?>
<?php if ($Page->TotalGroups > 0) { ?>
<?php
    $Page->sisabayar->getSum($Page->idpegawai->Records); // Get Sum
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_TOTAL;
    $Page->RowTotalType = ROWTOTAL_GROUP;
    $Page->RowTotalSubType = ROWTOTAL_FOOTER;
    $Page->RowGroupLevel = 1;
    $Page->renderRow();
?>
<?php if ($Page->idpegawai->ShowCompactSummaryFooter) { ?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->idpegawai->Visible) { ?>
        <td data-field="idpegawai"<?= $Page->idpegawai->cellAttributes() ?>>
    <?php if ($Page->idpegawai->ShowGroupHeaderAsRow) { ?>
        &nbsp;
    <?php } elseif ($Page->RowGroupLevel != 1) { ?>
        &nbsp;
    <?php } else { ?>
        <span class="ew-summary-count"><span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><?= $Language->phrase("AggregateEqual") ?><span class="ew-aggregate-value"><?= FormatNumber($Page->idpegawai->Count, 0); ?></span></span>
    <?php } ?>
        </td>
<?php } ?>
<?php if ($Page->idcustomer->Visible) { ?>
        <td data-field="idcustomer"<?= $Page->idpegawai->cellAttributes() ?>>
    <?php if ($Page->idcustomer->ShowGroupHeaderAsRow) { ?>
        &nbsp;
    <?php } elseif ($Page->RowGroupLevel != 2) { ?>
        &nbsp;
    <?php } else { ?>
        <span class="ew-summary-count"><span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><?= $Language->phrase("AggregateEqual") ?><span class="ew-aggregate-value"><?= FormatNumber($Page->idcustomer->Count, 0); ?></span></span>
    <?php } ?>
        </td>
<?php } ?>
<?php if ($Page->idinvoice->Visible) { ?>
        <td data-field="idinvoice"<?= $Page->idpegawai->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->sisabayar->Visible) { ?>
        <td data-field="sisabayar"<?= $Page->idpegawai->cellAttributes() ?>><span class="ew-aggregate-caption"><?= $Language->phrase("RptSum") ?></span><?= $Language->phrase("AggregateEqual") ?><span class="ew-aggregate-value"><span<?= $Page->sisabayar->viewAttributes() ?>><?= $Page->sisabayar->SumViewValue ?></span></span></td>
<?php } ?>
<?php if ($Page->jatuhtempo->Visible) { ?>
        <td data-field="jatuhtempo"<?= $Page->idpegawai->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->kodeinvoice->Visible) { ?>
        <td data-field="kodeinvoice"<?= $Page->idpegawai->cellAttributes() ?>></td>
<?php } ?>
    </tr>
<?php } else { ?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->GroupColumnCount + $Page->DetailColumnCount > 0) { ?>
        <td colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount) ?>"<?= $Page->idpegawai->cellAttributes() ?>><?= str_replace(["%v", "%c"], [$Page->idpegawai->GroupViewValue, $Page->idpegawai->caption()], $Language->phrase("RptSumHead")) ?> <span class="ew-dir-ltr">(<?= FormatNumber($Page->idpegawai->Count, 0); ?><?= $Language->phrase("RptDtlRec") ?>)</span></td>
<?php } ?>
    </tr>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->GroupColumnCount > 0) { ?>
        <td colspan="<?= ($Page->GroupColumnCount - 0) ?>"<?= $Page->idpegawai->cellAttributes() ?>><?= $Language->phrase("RptSum") ?></td>
<?php } ?>
<?php if ($Page->idinvoice->Visible) { ?>
        <td data-field="idinvoice"<?= $Page->idpegawai->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->sisabayar->Visible) { ?>
        <td data-field="sisabayar"<?= $Page->sisabayar->cellAttributes() ?>>
<span<?= $Page->sisabayar->viewAttributes() ?>>
<?= $Page->sisabayar->SumViewValue ?></span>
</td>
<?php } ?>
<?php if ($Page->jatuhtempo->Visible) { ?>
        <td data-field="jatuhtempo"<?= $Page->idpegawai->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->kodeinvoice->Visible) { ?>
        <td data-field="kodeinvoice"<?= $Page->idpegawai->cellAttributes() ?>>&nbsp;</td>
<?php } ?>
    </tr>
<?php } ?>
<?php } ?>
<?php
?>
<?php

    // Next group
    $Page->loadGroupRowValues();

    // Show header if page break
    if ($Page->isExport()) {
        $Page->ShowHeader = ($Page->ExportPageBreakCount == 0) ? false : ($Page->GroupCount % $Page->ExportPageBreakCount == 0);
    }

    // Page_Breaking server event
    if ($Page->ShowHeader) {
        $Page->pageBreaking($Page->ShowHeader, $Page->PageBreakContent);
    }
    $Page->GroupCount++;
} // End while
?>
<?php if ($Page->TotalGroups > 0) { ?>
</tbody>
<tfoot>
</tfoot>
</table>
</div>
<!-- /.ew-grid-middle-panel -->
<!-- Report grid (end) -->
<?php if (!$Page->isExport() && !($Page->DrillDown && $Page->TotalGroups > 0)) { ?>
<!-- Bottom pager -->
<div class="card-footer ew-grid-lower-panel">
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<!-- /.ew-grid -->
<?php } ?>
</div>
<!-- /#report-summary -->
<!-- Summary report (end) -->
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
</div>
<!-- /#ew-center -->
<?php } ?>
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
</div>
<!-- /.row -->
<?php } ?>
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
</div>
<!-- /.ew-report -->
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
