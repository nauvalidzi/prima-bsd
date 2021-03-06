<?php

namespace PHPMaker2021\production2;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class NpdHargaDelete extends NpdHarga
{
    use MessagesTrait;

    // Page ID
    public $PageID = "delete";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'npd_harga';

    // Page object name
    public $PageObjName = "NpdHargaDelete";

    // Rendering View
    public $RenderingView = false;

    // Page headings
    public $Heading = "";
    public $Subheading = "";
    public $PageHeader;
    public $PageFooter;

    // Page terminated
    private $terminated = false;

    // Page heading
    public function pageHeading()
    {
        global $Language;
        if ($this->Heading != "") {
            return $this->Heading;
        }
        if (method_exists($this, "tableCaption")) {
            return $this->tableCaption();
        }
        return "";
    }

    // Page subheading
    public function pageSubheading()
    {
        global $Language;
        if ($this->Subheading != "") {
            return $this->Subheading;
        }
        if ($this->TableName) {
            return $Language->phrase($this->PageID);
        }
        return "";
    }

    // Page name
    public function pageName()
    {
        return CurrentPageName();
    }

    // Page URL
    public function pageUrl()
    {
        $url = ScriptName() . "?";
        if ($this->UseTokenInUrl) {
            $url .= "t=" . $this->TableVar . "&"; // Add page token
        }
        return $url;
    }

    // Show Page Header
    public function showPageHeader()
    {
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        if ($header != "") { // Header exists, display
            echo '<p id="ew-page-header">' . $header . '</p>';
        }
    }

    // Show Page Footer
    public function showPageFooter()
    {
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        if ($footer != "") { // Footer exists, display
            echo '<p id="ew-page-footer">' . $footer . '</p>';
        }
    }

    // Validate page request
    protected function isPageRequest()
    {
        global $CurrentForm;
        if ($this->UseTokenInUrl) {
            if ($CurrentForm) {
                return ($this->TableVar == $CurrentForm->getValue("t"));
            }
            if (Get("t") !== null) {
                return ($this->TableVar == Get("t"));
            }
        }
        return true;
    }

    // Constructor
    public function __construct()
    {
        global $Language, $DashboardReport, $DebugTimer;
        global $UserTable;

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Parent constuctor
        parent::__construct();

        // Table object (npd_harga)
        if (!isset($GLOBALS["npd_harga"]) || get_class($GLOBALS["npd_harga"]) == PROJECT_NAMESPACE . "npd_harga") {
            $GLOBALS["npd_harga"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'npd_harga');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();

        // User table object
        $UserTable = Container("usertable");
    }

    // Get content from stream
    public function getContents($stream = null): string
    {
        global $Response;
        return is_object($Response) ? $Response->getBody() : ob_get_clean();
    }

    // Is lookup
    public function isLookup()
    {
        return SameText(Route(0), Config("API_LOOKUP_ACTION"));
    }

    // Is AutoFill
    public function isAutoFill()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autofill");
    }

    // Is AutoSuggest
    public function isAutoSuggest()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autosuggest");
    }

    // Is modal lookup
    public function isModalLookup()
    {
        return $this->isLookup() && SameText(Post("ajax"), "modal");
    }

    // Is terminated
    public function isTerminated()
    {
        return $this->terminated;
    }

    /**
     * Terminate page
     *
     * @param string $url URL for direction
     * @return void
     */
    public function terminate($url = "")
    {
        if ($this->terminated) {
            return;
        }
        global $ExportFileName, $TempImages, $DashboardReport, $Response;

        // Page is terminated
        $this->terminated = true;

         // Page Unload event
        if (method_exists($this, "pageUnload")) {
            $this->pageUnload();
        }

        // Global Page Unloaded event (in userfn*.php)
        Page_Unloaded();

        // Export
        if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
            $content = $this->getContents();
            if ($ExportFileName == "") {
                $ExportFileName = $this->TableVar;
            }
            $class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
            if (class_exists($class)) {
                $doc = new $class(Container("npd_harga"));
                $doc->Text = @$content;
                if ($this->isExport("email")) {
                    echo $this->exportEmail($doc->Text);
                } else {
                    $doc->export();
                }
                DeleteTempImages(); // Delete temp images
                return;
            }
        }
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection
        CloseConnections();

        // Return for API
        if (IsApi()) {
            $res = $url === true;
            if (!$res) { // Show error
                WriteJson(array_merge(["success" => false], $this->getMessages()));
            }
            return;
        } else { // Check if response is JSON
            if (StartsString("application/json", $Response->getHeaderLine("Content-type")) && $Response->getBody()->getSize()) { // With JSON response
                $this->clearMessages();
                return;
            }
        }

        // Go to URL if specified
        if ($url != "") {
            if (!Config("DEBUG") && ob_get_length()) {
                ob_end_clean();
            }
            SaveDebugMessage();
            Redirect(GetUrl($url));
        }
        return; // Return to controller
    }

    // Get records from recordset
    protected function getRecordsFromRecordset($rs, $current = false)
    {
        $rows = [];
        if (is_object($rs)) { // Recordset
            while ($rs && !$rs->EOF) {
                $this->loadRowValues($rs); // Set up DbValue/CurrentValue
                $row = $this->getRecordFromArray($rs->fields);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
                $rs->moveNext();
            }
        } elseif (is_array($rs)) {
            foreach ($rs as $ar) {
                $row = $this->getRecordFromArray($ar);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        }
        return $rows;
    }

    // Get record from array
    protected function getRecordFromArray($ar)
    {
        $row = [];
        if (is_array($ar)) {
            foreach ($ar as $fldname => $val) {
                if (array_key_exists($fldname, $this->Fields) && ($this->Fields[$fldname]->Visible || $this->Fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
                    $fld = &$this->Fields[$fldname];
                    if ($fld->HtmlTag == "FILE") { // Upload field
                        if (EmptyValue($val)) {
                            $row[$fldname] = null;
                        } else {
                            if ($fld->DataType == DATATYPE_BLOB) {
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))));
                                $row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
                            } elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $val)));
                                $row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
                            } else { // Multiple files
                                $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                                $ar = [];
                                foreach ($files as $file) {
                                    $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                        "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                                    if (!EmptyValue($file)) {
                                        $ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
                                    }
                                }
                                $row[$fldname] = $ar;
                            }
                        }
                    } else {
                        $row[$fldname] = $val;
                    }
                }
            }
        }
        return $row;
    }

    // Get record key value from array
    protected function getRecordKeyValue($ar)
    {
        $key = "";
        if (is_array($ar)) {
            $key .= @$ar['id'];
        }
        return $key;
    }

    /**
     * Hide fields for add/edit
     *
     * @return void
     */
    protected function hideFieldsForAddEdit()
    {
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->id->Visible = false;
        }
    }
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $TotalRecords = 0;
    public $RecordCount;
    public $RecKeys = [];
    public $StartRowCount = 1;
    public $RowCount = 0;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm;
        $this->CurrentAction = Param("action"); // Set up current action
        $this->id->Visible = false;
        $this->idnpd->setVisibility();
        $this->tglpengajuan->setVisibility();
        $this->idnpd_sample->setVisibility();
        $this->nama->setVisibility();
        $this->bentuk->Visible = false;
        $this->viskositas->Visible = false;
        $this->warna->setVisibility();
        $this->bauparfum->setVisibility();
        $this->aplikasisediaan->Visible = false;
        $this->volume->Visible = false;
        $this->bahanaktif->Visible = false;
        $this->volumewadah->Visible = false;
        $this->bahanwadah->Visible = false;
        $this->warnawadah->Visible = false;
        $this->bentukwadah->Visible = false;
        $this->jenistutup->Visible = false;
        $this->bahantutup->Visible = false;
        $this->warnatutup->Visible = false;
        $this->bentuktutup->Visible = false;
        $this->segel->Visible = false;
        $this->catatanprimer->Visible = false;
        $this->packingproduk->Visible = false;
        $this->keteranganpacking->Visible = false;
        $this->beltkarton->Visible = false;
        $this->keteranganbelt->Visible = false;
        $this->kartonluar->Visible = false;
        $this->bariskarton->Visible = false;
        $this->kolomkarton->Visible = false;
        $this->stackkarton->Visible = false;
        $this->isikarton->Visible = false;
        $this->jenislabel->Visible = false;
        $this->keteranganjenislabel->Visible = false;
        $this->kualitaslabel->Visible = false;
        $this->jumlahwarnalabel->Visible = false;
        $this->metaliklabel->Visible = false;
        $this->etiketlabel->Visible = false;
        $this->keteranganlabel->Visible = false;
        $this->kategoridelivery->Visible = false;
        $this->alamatpengiriman->Visible = false;
        $this->orderperdana->Visible = false;
        $this->orderkontrak->Visible = false;
        $this->hargaperpcs->Visible = false;
        $this->hargaperkarton->Visible = false;
        $this->lampiran->Visible = false;
        $this->prepared_by->Visible = false;
        $this->checked_by->Visible = false;
        $this->approved_by->Visible = false;
        $this->approved_date->Visible = false;
        $this->disetujui->Visible = false;
        $this->created_at->Visible = false;
        $this->readonly->Visible = false;
        $this->updated_at->Visible = false;
        $this->hideFieldsForAddEdit();

        // Do not use lookup cache
        $this->setUseLookupCache(false);

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->idnpd);
        $this->setupLookupOptions($this->idnpd_sample);
        $this->setupLookupOptions($this->viskositas);
        $this->setupLookupOptions($this->warna);
        $this->setupLookupOptions($this->aplikasisediaan);
        $this->setupLookupOptions($this->jenislabel);
        $this->setupLookupOptions($this->kualitaslabel);
        $this->setupLookupOptions($this->kategoridelivery);

        // Set up master/detail parameters
        $this->setupMasterParms();

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Load key parameters
        $this->RecKeys = $this->getRecordKeys(); // Load record keys
        $filter = $this->getFilterFromRecordKeys();
        if ($filter == "") {
            $this->terminate("NpdHargaList"); // Prevent SQL injection, return to list
            return;
        }

        // Set up filter (WHERE Clause)
        $this->CurrentFilter = $filter;

        // Get action
        if (IsApi()) {
            $this->CurrentAction = "delete"; // Delete record directly
        } elseif (Post("action") !== null) {
            $this->CurrentAction = Post("action");
        } elseif (Get("action") == "1") {
            $this->CurrentAction = "delete"; // Delete record directly
        } else {
            $this->CurrentAction = "show"; // Display record
        }
        if ($this->isDelete()) {
            $this->SendEmail = true; // Send email on delete success
            if ($this->deleteRows()) { // Delete rows
                if ($this->getSuccessMessage() == "") {
                    $this->setSuccessMessage($Language->phrase("DeleteSuccess")); // Set up success message
                }
                if (IsApi()) {
                    $this->terminate(true);
                    return;
                } else {
                    $this->terminate($this->getReturnUrl()); // Return to caller
                    return;
                }
            } else { // Delete failed
                if (IsApi()) {
                    $this->terminate();
                    return;
                }
                $this->CurrentAction = "show"; // Display record
            }
        }
        if ($this->isShow()) { // Load records for display
            if ($this->Recordset = $this->loadRecordset()) {
                $this->TotalRecords = $this->Recordset->recordCount(); // Get record count
            }
            if ($this->TotalRecords <= 0) { // No record found, exit
                if ($this->Recordset) {
                    $this->Recordset->close();
                }
                $this->terminate("NpdHargaList"); // Return to list
                return;
            }
        }

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Pass table and field properties to client side
            $this->toClientVar(["tableCaption"], ["caption", "Visible", "Required", "IsInvalid", "Raw"]);

            // Setup login status
            SetupLoginStatus();

            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            Page_Rendering();

            // Page Render event
            if (method_exists($this, "pageRender")) {
                $this->pageRender();
            }
        }
    }

    // Load recordset
    public function loadRecordset($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load recordset
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $stmt = $sql->execute();
        $rs = new Recordset($stmt, $sql);

        // Call Recordset Selected event
        $this->recordsetSelected($rs);
        return $rs;
    }

    /**
     * Load row based on key values
     *
     * @return void
     */
    public function loadRow()
    {
        global $Security, $Language;
        $filter = $this->getRecordFilter();

        // Call Row Selecting event
        $this->rowSelecting($filter);

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $res = false;
        $row = $conn->fetchAssoc($sql);
        if ($row) {
            $res = true;
            $this->loadRowValues($row); // Load row values
        }
        return $res;
    }

    /**
     * Load row values from recordset or record
     *
     * @param Recordset|array $rs Record
     * @return void
     */
    public function loadRowValues($rs = null)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            $row = $this->newRow();
        }

        // Call Row Selected event
        $this->rowSelected($row);
        if (!$rs) {
            return;
        }
        $this->id->setDbValue($row['id']);
        $this->idnpd->setDbValue($row['idnpd']);
        $this->tglpengajuan->setDbValue($row['tglpengajuan']);
        $this->idnpd_sample->setDbValue($row['idnpd_sample']);
        $this->nama->setDbValue($row['nama']);
        $this->bentuk->setDbValue($row['bentuk']);
        $this->viskositas->setDbValue($row['viskositas']);
        $this->warna->setDbValue($row['warna']);
        $this->bauparfum->setDbValue($row['bauparfum']);
        $this->aplikasisediaan->setDbValue($row['aplikasisediaan']);
        $this->volume->setDbValue($row['volume']);
        $this->bahanaktif->setDbValue($row['bahanaktif']);
        $this->volumewadah->setDbValue($row['volumewadah']);
        $this->bahanwadah->setDbValue($row['bahanwadah']);
        $this->warnawadah->setDbValue($row['warnawadah']);
        $this->bentukwadah->setDbValue($row['bentukwadah']);
        $this->jenistutup->setDbValue($row['jenistutup']);
        $this->bahantutup->setDbValue($row['bahantutup']);
        $this->warnatutup->setDbValue($row['warnatutup']);
        $this->bentuktutup->setDbValue($row['bentuktutup']);
        $this->segel->setDbValue($row['segel']);
        $this->catatanprimer->setDbValue($row['catatanprimer']);
        $this->packingproduk->setDbValue($row['packingproduk']);
        $this->keteranganpacking->setDbValue($row['keteranganpacking']);
        $this->beltkarton->setDbValue($row['beltkarton']);
        $this->keteranganbelt->setDbValue($row['keteranganbelt']);
        $this->kartonluar->setDbValue($row['kartonluar']);
        $this->bariskarton->setDbValue($row['bariskarton']);
        $this->kolomkarton->setDbValue($row['kolomkarton']);
        $this->stackkarton->setDbValue($row['stackkarton']);
        $this->isikarton->setDbValue($row['isikarton']);
        $this->jenislabel->setDbValue($row['jenislabel']);
        $this->keteranganjenislabel->setDbValue($row['keteranganjenislabel']);
        $this->kualitaslabel->setDbValue($row['kualitaslabel']);
        $this->jumlahwarnalabel->setDbValue($row['jumlahwarnalabel']);
        $this->metaliklabel->setDbValue($row['metaliklabel']);
        $this->etiketlabel->setDbValue($row['etiketlabel']);
        $this->keteranganlabel->setDbValue($row['keteranganlabel']);
        $this->kategoridelivery->setDbValue($row['kategoridelivery']);
        $this->alamatpengiriman->setDbValue($row['alamatpengiriman']);
        $this->orderperdana->setDbValue($row['orderperdana']);
        $this->orderkontrak->setDbValue($row['orderkontrak']);
        $this->hargaperpcs->setDbValue($row['hargaperpcs']);
        $this->hargaperkarton->setDbValue($row['hargaperkarton']);
        $this->lampiran->Upload->DbValue = $row['lampiran'];
        $this->lampiran->setDbValue($this->lampiran->Upload->DbValue);
        $this->prepared_by->setDbValue($row['prepared_by']);
        $this->checked_by->setDbValue($row['checked_by']);
        $this->approved_by->setDbValue($row['approved_by']);
        $this->approved_date->setDbValue($row['approved_date']);
        $this->disetujui->setDbValue($row['disetujui']);
        $this->created_at->setDbValue($row['created_at']);
        $this->readonly->setDbValue($row['readonly']);
        $this->updated_at->setDbValue($row['updated_at']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['idnpd'] = null;
        $row['tglpengajuan'] = null;
        $row['idnpd_sample'] = null;
        $row['nama'] = null;
        $row['bentuk'] = null;
        $row['viskositas'] = null;
        $row['warna'] = null;
        $row['bauparfum'] = null;
        $row['aplikasisediaan'] = null;
        $row['volume'] = null;
        $row['bahanaktif'] = null;
        $row['volumewadah'] = null;
        $row['bahanwadah'] = null;
        $row['warnawadah'] = null;
        $row['bentukwadah'] = null;
        $row['jenistutup'] = null;
        $row['bahantutup'] = null;
        $row['warnatutup'] = null;
        $row['bentuktutup'] = null;
        $row['segel'] = null;
        $row['catatanprimer'] = null;
        $row['packingproduk'] = null;
        $row['keteranganpacking'] = null;
        $row['beltkarton'] = null;
        $row['keteranganbelt'] = null;
        $row['kartonluar'] = null;
        $row['bariskarton'] = null;
        $row['kolomkarton'] = null;
        $row['stackkarton'] = null;
        $row['isikarton'] = null;
        $row['jenislabel'] = null;
        $row['keteranganjenislabel'] = null;
        $row['kualitaslabel'] = null;
        $row['jumlahwarnalabel'] = null;
        $row['metaliklabel'] = null;
        $row['etiketlabel'] = null;
        $row['keteranganlabel'] = null;
        $row['kategoridelivery'] = null;
        $row['alamatpengiriman'] = null;
        $row['orderperdana'] = null;
        $row['orderkontrak'] = null;
        $row['hargaperpcs'] = null;
        $row['hargaperkarton'] = null;
        $row['lampiran'] = null;
        $row['prepared_by'] = null;
        $row['checked_by'] = null;
        $row['approved_by'] = null;
        $row['approved_date'] = null;
        $row['disetujui'] = null;
        $row['created_at'] = null;
        $row['readonly'] = null;
        $row['updated_at'] = null;
        return $row;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id

        // idnpd

        // tglpengajuan

        // idnpd_sample

        // nama

        // bentuk

        // viskositas

        // warna

        // bauparfum

        // aplikasisediaan

        // volume

        // bahanaktif

        // volumewadah

        // bahanwadah

        // warnawadah

        // bentukwadah

        // jenistutup

        // bahantutup

        // warnatutup

        // bentuktutup

        // segel

        // catatanprimer

        // packingproduk

        // keteranganpacking

        // beltkarton

        // keteranganbelt

        // kartonluar

        // bariskarton

        // kolomkarton

        // stackkarton

        // isikarton

        // jenislabel

        // keteranganjenislabel

        // kualitaslabel

        // jumlahwarnalabel

        // metaliklabel

        // etiketlabel

        // keteranganlabel

        // kategoridelivery

        // alamatpengiriman

        // orderperdana

        // orderkontrak

        // hargaperpcs

        // hargaperkarton

        // lampiran

        // prepared_by

        // checked_by

        // approved_by

        // approved_date

        // disetujui

        // created_at

        // readonly

        // updated_at
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // idnpd
            $curVal = trim(strval($this->idnpd->CurrentValue));
            if ($curVal != "") {
                $this->idnpd->ViewValue = $this->idnpd->lookupCacheOption($curVal);
                if ($this->idnpd->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return "`id` IN (SELECT `idnpd` FROM `npd_confirmsample`)";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->idnpd->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idnpd->Lookup->renderViewRow($rswrk[0]);
                        $this->idnpd->ViewValue = $this->idnpd->displayValue($arwrk);
                    } else {
                        $this->idnpd->ViewValue = $this->idnpd->CurrentValue;
                    }
                }
            } else {
                $this->idnpd->ViewValue = null;
            }
            $this->idnpd->ViewCustomAttributes = "";

            // tglpengajuan
            $this->tglpengajuan->ViewValue = $this->tglpengajuan->CurrentValue;
            $this->tglpengajuan->ViewValue = FormatDateTime($this->tglpengajuan->ViewValue, 0);
            $this->tglpengajuan->ViewCustomAttributes = "";

            // idnpd_sample
            $curVal = trim(strval($this->idnpd_sample->CurrentValue));
            if ($curVal != "") {
                $this->idnpd_sample->ViewValue = $this->idnpd_sample->lookupCacheOption($curVal);
                if ($this->idnpd_sample->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return CurrentPageID() == "add" ? "id IN (SELECT idnpd_sample FROM npd_confirmsample WHERE readonly=0)" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->idnpd_sample->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idnpd_sample->Lookup->renderViewRow($rswrk[0]);
                        $this->idnpd_sample->ViewValue = $this->idnpd_sample->displayValue($arwrk);
                    } else {
                        $this->idnpd_sample->ViewValue = $this->idnpd_sample->CurrentValue;
                    }
                }
            } else {
                $this->idnpd_sample->ViewValue = null;
            }
            $this->idnpd_sample->ViewCustomAttributes = "";

            // nama
            $this->nama->ViewValue = $this->nama->CurrentValue;
            $this->nama->ViewCustomAttributes = "";

            // bentuk
            $this->bentuk->ViewValue = $this->bentuk->CurrentValue;
            $this->bentuk->ViewCustomAttributes = "";

            // viskositas
            $curVal = trim(strval($this->viskositas->CurrentValue));
            if ($curVal != "") {
                $this->viskositas->ViewValue = $this->viskositas->lookupCacheOption($curVal);
                if ($this->viskositas->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->viskositas->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->viskositas->Lookup->renderViewRow($rswrk[0]);
                        $this->viskositas->ViewValue = $this->viskositas->displayValue($arwrk);
                    } else {
                        $this->viskositas->ViewValue = $this->viskositas->CurrentValue;
                    }
                }
            } else {
                $this->viskositas->ViewValue = null;
            }
            $this->viskositas->ViewCustomAttributes = "";

            // warna
            $curVal = trim(strval($this->warna->CurrentValue));
            if ($curVal != "") {
                $this->warna->ViewValue = $this->warna->lookupCacheOption($curVal);
                if ($this->warna->ViewValue === null) { // Lookup from database
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->warna->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->warna->Lookup->renderViewRow($rswrk[0]);
                        $this->warna->ViewValue = $this->warna->displayValue($arwrk);
                    } else {
                        $this->warna->ViewValue = $this->warna->CurrentValue;
                    }
                }
            } else {
                $this->warna->ViewValue = null;
            }
            $this->warna->ViewCustomAttributes = "";

            // bauparfum
            $this->bauparfum->ViewValue = $this->bauparfum->CurrentValue;
            $this->bauparfum->ViewCustomAttributes = "";

            // aplikasisediaan
            $curVal = trim(strval($this->aplikasisediaan->CurrentValue));
            if ($curVal != "") {
                $this->aplikasisediaan->ViewValue = $this->aplikasisediaan->lookupCacheOption($curVal);
                if ($this->aplikasisediaan->ViewValue === null) { // Lookup from database
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->aplikasisediaan->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->aplikasisediaan->Lookup->renderViewRow($rswrk[0]);
                        $this->aplikasisediaan->ViewValue = $this->aplikasisediaan->displayValue($arwrk);
                    } else {
                        $this->aplikasisediaan->ViewValue = $this->aplikasisediaan->CurrentValue;
                    }
                }
            } else {
                $this->aplikasisediaan->ViewValue = null;
            }
            $this->aplikasisediaan->ViewCustomAttributes = "";

            // volume
            $this->volume->ViewValue = $this->volume->CurrentValue;
            $this->volume->ViewCustomAttributes = "";

            // volumewadah
            $this->volumewadah->ViewValue = $this->volumewadah->CurrentValue;
            $this->volumewadah->ViewCustomAttributes = "";

            // bahanwadah
            $this->bahanwadah->ViewValue = $this->bahanwadah->CurrentValue;
            $this->bahanwadah->ViewCustomAttributes = "";

            // warnawadah
            $this->warnawadah->ViewValue = $this->warnawadah->CurrentValue;
            $this->warnawadah->ViewCustomAttributes = "";

            // bentukwadah
            $this->bentukwadah->ViewValue = $this->bentukwadah->CurrentValue;
            $this->bentukwadah->ViewCustomAttributes = "";

            // jenistutup
            $this->jenistutup->ViewValue = $this->jenistutup->CurrentValue;
            $this->jenistutup->ViewCustomAttributes = "";

            // bahantutup
            $this->bahantutup->ViewValue = $this->bahantutup->CurrentValue;
            $this->bahantutup->ViewCustomAttributes = "";

            // warnatutup
            $this->warnatutup->ViewValue = $this->warnatutup->CurrentValue;
            $this->warnatutup->ViewCustomAttributes = "";

            // bentuktutup
            $this->bentuktutup->ViewValue = $this->bentuktutup->CurrentValue;
            $this->bentuktutup->ViewCustomAttributes = "";

            // segel
            if (strval($this->segel->CurrentValue) != "") {
                $this->segel->ViewValue = $this->segel->optionCaption($this->segel->CurrentValue);
            } else {
                $this->segel->ViewValue = null;
            }
            $this->segel->ViewCustomAttributes = "";

            // catatanprimer
            $this->catatanprimer->ViewValue = $this->catatanprimer->CurrentValue;
            $this->catatanprimer->ViewCustomAttributes = "";

            // packingproduk
            $this->packingproduk->ViewValue = $this->packingproduk->CurrentValue;
            $this->packingproduk->ViewCustomAttributes = "";

            // keteranganpacking
            $this->keteranganpacking->ViewValue = $this->keteranganpacking->CurrentValue;
            $this->keteranganpacking->ViewCustomAttributes = "";

            // beltkarton
            $this->beltkarton->ViewValue = $this->beltkarton->CurrentValue;
            $this->beltkarton->ViewCustomAttributes = "";

            // keteranganbelt
            $this->keteranganbelt->ViewValue = $this->keteranganbelt->CurrentValue;
            $this->keteranganbelt->ViewCustomAttributes = "";

            // kartonluar
            $this->kartonluar->ViewValue = $this->kartonluar->CurrentValue;
            $this->kartonluar->ViewCustomAttributes = "";

            // bariskarton
            $this->bariskarton->ViewValue = $this->bariskarton->CurrentValue;
            $this->bariskarton->ViewCustomAttributes = "";

            // kolomkarton
            $this->kolomkarton->ViewValue = $this->kolomkarton->CurrentValue;
            $this->kolomkarton->ViewCustomAttributes = "";

            // stackkarton
            $this->stackkarton->ViewValue = $this->stackkarton->CurrentValue;
            $this->stackkarton->ViewCustomAttributes = "";

            // isikarton
            $this->isikarton->ViewValue = $this->isikarton->CurrentValue;
            $this->isikarton->ViewCustomAttributes = "";

            // jenislabel
            $curVal = trim(strval($this->jenislabel->CurrentValue));
            if ($curVal != "") {
                $this->jenislabel->ViewValue = $this->jenislabel->lookupCacheOption($curVal);
                if ($this->jenislabel->ViewValue === null) { // Lookup from database
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->jenislabel->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->jenislabel->Lookup->renderViewRow($rswrk[0]);
                        $this->jenislabel->ViewValue = $this->jenislabel->displayValue($arwrk);
                    } else {
                        $this->jenislabel->ViewValue = $this->jenislabel->CurrentValue;
                    }
                }
            } else {
                $this->jenislabel->ViewValue = null;
            }
            $this->jenislabel->ViewCustomAttributes = "";

            // keteranganjenislabel
            $this->keteranganjenislabel->ViewValue = $this->keteranganjenislabel->CurrentValue;
            $this->keteranganjenislabel->ViewCustomAttributes = "";

            // kualitaslabel
            $curVal = trim(strval($this->kualitaslabel->CurrentValue));
            if ($curVal != "") {
                $this->kualitaslabel->ViewValue = $this->kualitaslabel->lookupCacheOption($curVal);
                if ($this->kualitaslabel->ViewValue === null) { // Lookup from database
                    $filterWrk = "`value`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->kualitaslabel->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->kualitaslabel->Lookup->renderViewRow($rswrk[0]);
                        $this->kualitaslabel->ViewValue = $this->kualitaslabel->displayValue($arwrk);
                    } else {
                        $this->kualitaslabel->ViewValue = $this->kualitaslabel->CurrentValue;
                    }
                }
            } else {
                $this->kualitaslabel->ViewValue = null;
            }
            $this->kualitaslabel->ViewCustomAttributes = "";

            // jumlahwarnalabel
            $this->jumlahwarnalabel->ViewValue = $this->jumlahwarnalabel->CurrentValue;
            $this->jumlahwarnalabel->ViewCustomAttributes = "";

            // metaliklabel
            $this->metaliklabel->ViewValue = $this->metaliklabel->CurrentValue;
            $this->metaliklabel->ViewCustomAttributes = "";

            // etiketlabel
            $this->etiketlabel->ViewValue = $this->etiketlabel->CurrentValue;
            $this->etiketlabel->ViewCustomAttributes = "";

            // keteranganlabel
            $this->keteranganlabel->ViewValue = $this->keteranganlabel->CurrentValue;
            $this->keteranganlabel->ViewCustomAttributes = "";

            // kategoridelivery
            $curVal = trim(strval($this->kategoridelivery->CurrentValue));
            if ($curVal != "") {
                $this->kategoridelivery->ViewValue = $this->kategoridelivery->lookupCacheOption($curVal);
                if ($this->kategoridelivery->ViewValue === null) { // Lookup from database
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`nama`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->kategoridelivery->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->kategoridelivery->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->kategoridelivery->Lookup->renderViewRow($row);
                            $this->kategoridelivery->ViewValue->add($this->kategoridelivery->displayValue($arwrk));
                        }
                    } else {
                        $this->kategoridelivery->ViewValue = $this->kategoridelivery->CurrentValue;
                    }
                }
            } else {
                $this->kategoridelivery->ViewValue = null;
            }
            $this->kategoridelivery->ViewCustomAttributes = "";

            // alamatpengiriman
            $this->alamatpengiriman->ViewValue = $this->alamatpengiriman->CurrentValue;
            $this->alamatpengiriman->ViewCustomAttributes = "";

            // orderperdana
            $this->orderperdana->ViewValue = $this->orderperdana->CurrentValue;
            $this->orderperdana->ViewValue = FormatNumber($this->orderperdana->ViewValue, 0, -2, -2, -2);
            $this->orderperdana->ViewCustomAttributes = "";

            // orderkontrak
            $this->orderkontrak->ViewValue = $this->orderkontrak->CurrentValue;
            $this->orderkontrak->ViewValue = FormatNumber($this->orderkontrak->ViewValue, 0, -2, -2, -2);
            $this->orderkontrak->ViewCustomAttributes = "";

            // hargaperpcs
            $this->hargaperpcs->ViewValue = $this->hargaperpcs->CurrentValue;
            $this->hargaperpcs->ViewValue = FormatCurrency($this->hargaperpcs->ViewValue, 2, -2, -2, -2);
            $this->hargaperpcs->ViewCustomAttributes = "";

            // hargaperkarton
            $this->hargaperkarton->ViewValue = $this->hargaperkarton->CurrentValue;
            $this->hargaperkarton->ViewValue = FormatNumber($this->hargaperkarton->ViewValue, 0, -2, -2, -2);
            $this->hargaperkarton->ViewCustomAttributes = "";

            // lampiran
            if (!EmptyValue($this->lampiran->Upload->DbValue)) {
                $this->lampiran->ViewValue = $this->lampiran->Upload->DbValue;
            } else {
                $this->lampiran->ViewValue = "";
            }
            $this->lampiran->ViewCustomAttributes = "";

            // prepared_by
            $this->prepared_by->ViewValue = $this->prepared_by->CurrentValue;
            $this->prepared_by->ViewValue = FormatNumber($this->prepared_by->ViewValue, 0, -2, -2, -2);
            $this->prepared_by->ViewCustomAttributes = "";

            // checked_by
            $this->checked_by->ViewValue = $this->checked_by->CurrentValue;
            $this->checked_by->ViewValue = FormatNumber($this->checked_by->ViewValue, 0, -2, -2, -2);
            $this->checked_by->ViewCustomAttributes = "";

            // approved_by
            $this->approved_by->ViewValue = $this->approved_by->CurrentValue;
            $this->approved_by->ViewValue = FormatNumber($this->approved_by->ViewValue, 0, -2, -2, -2);
            $this->approved_by->ViewCustomAttributes = "";

            // approved_date
            $this->approved_date->ViewValue = $this->approved_date->CurrentValue;
            $this->approved_date->ViewValue = FormatNumber($this->approved_date->ViewValue, 0, -2, -2, -2);
            $this->approved_date->ViewCustomAttributes = "";

            // disetujui
            if (strval($this->disetujui->CurrentValue) != "") {
                $this->disetujui->ViewValue = $this->disetujui->optionCaption($this->disetujui->CurrentValue);
            } else {
                $this->disetujui->ViewValue = null;
            }
            $this->disetujui->ViewCustomAttributes = "";

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
            $this->created_at->ViewCustomAttributes = "";

            // readonly
            if (ConvertToBool($this->readonly->CurrentValue)) {
                $this->readonly->ViewValue = $this->readonly->tagCaption(1) != "" ? $this->readonly->tagCaption(1) : "Yes";
            } else {
                $this->readonly->ViewValue = $this->readonly->tagCaption(2) != "" ? $this->readonly->tagCaption(2) : "No";
            }
            $this->readonly->ViewCustomAttributes = "";

            // updated_at
            $this->updated_at->ViewValue = $this->updated_at->CurrentValue;
            $this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, 0);
            $this->updated_at->ViewCustomAttributes = "";

            // idnpd
            $this->idnpd->LinkCustomAttributes = "";
            $this->idnpd->HrefValue = "";
            $this->idnpd->TooltipValue = "";

            // tglpengajuan
            $this->tglpengajuan->LinkCustomAttributes = "";
            $this->tglpengajuan->HrefValue = "";
            $this->tglpengajuan->TooltipValue = "";

            // idnpd_sample
            $this->idnpd_sample->LinkCustomAttributes = "";
            $this->idnpd_sample->HrefValue = "";
            $this->idnpd_sample->TooltipValue = "";

            // nama
            $this->nama->LinkCustomAttributes = "";
            $this->nama->HrefValue = "";
            $this->nama->TooltipValue = "";

            // warna
            $this->warna->LinkCustomAttributes = "";
            $this->warna->HrefValue = "";
            $this->warna->TooltipValue = "";

            // bauparfum
            $this->bauparfum->LinkCustomAttributes = "";
            $this->bauparfum->HrefValue = "";
            $this->bauparfum->TooltipValue = "";
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Delete records based on current filter
    protected function deleteRows()
    {
        global $Language, $Security;
        if (!$Security->canDelete()) {
            $this->setFailureMessage($Language->phrase("NoDeletePermission")); // No delete permission
            return false;
        }
        $deleteRows = true;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $rows = $conn->fetchAll($sql);
        if (count($rows) == 0) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
            return false;
        }
        $conn->beginTransaction();

        // Clone old rows
        $rsold = $rows;

        // Call row deleting event
        if ($deleteRows) {
            foreach ($rsold as $row) {
                $deleteRows = $this->rowDeleting($row);
                if (!$deleteRows) {
                    break;
                }
            }
        }
        if ($deleteRows) {
            $key = "";
            foreach ($rsold as $row) {
                $thisKey = "";
                if ($thisKey != "") {
                    $thisKey .= Config("COMPOSITE_KEY_SEPARATOR");
                }
                $thisKey .= $row['id'];
                if (Config("DELETE_UPLOADED_FILES")) { // Delete old files
                    $this->deleteUploadedFiles($row);
                }
                $deleteRows = $this->delete($row); // Delete
                if ($deleteRows === false) {
                    break;
                }
                if ($key != "") {
                    $key .= ", ";
                }
                $key .= $thisKey;
            }
        }
        if (!$deleteRows) {
            // Set up error message
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("DeleteCancelled"));
            }
        }
        if ($deleteRows) {
            $conn->commit(); // Commit the changes
        } else {
            $conn->rollback(); // Rollback changes
        }

        // Call Row Deleted event
        if ($deleteRows) {
            foreach ($rsold as $row) {
                $this->rowDeleted($row);
            }
        }

        // Write JSON for API request
        if (IsApi() && $deleteRows) {
            $row = $this->getRecordsFromRecordset($rsold);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $deleteRows;
    }

    // Set up master/detail based on QueryString
    protected function setupMasterParms()
    {
        $validMaster = false;
        // Get the keys for master table
        if (($master = Get(Config("TABLE_SHOW_MASTER"), Get(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                $validMaster = true;
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "npd") {
                $validMaster = true;
                $masterTbl = Container("npd");
                if (($parm = Get("fk_id", Get("idnpd"))) !== null) {
                    $masterTbl->id->setQueryStringValue($parm);
                    $this->idnpd->setQueryStringValue($masterTbl->id->QueryStringValue);
                    $this->idnpd->setSessionValue($this->idnpd->QueryStringValue);
                    if (!is_numeric($masterTbl->id->QueryStringValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
        } elseif (($master = Post(Config("TABLE_SHOW_MASTER"), Post(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                    $validMaster = true;
                    $this->DbMasterFilter = "";
                    $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "npd") {
                $validMaster = true;
                $masterTbl = Container("npd");
                if (($parm = Post("fk_id", Post("idnpd"))) !== null) {
                    $masterTbl->id->setFormValue($parm);
                    $this->idnpd->setFormValue($masterTbl->id->FormValue);
                    $this->idnpd->setSessionValue($this->idnpd->FormValue);
                    if (!is_numeric($masterTbl->id->FormValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
        }
        if ($validMaster) {
            // Save current master table
            $this->setCurrentMasterTable($masterTblVar);

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "npd") {
                if ($this->idnpd->CurrentValue == "") {
                    $this->idnpd->setSessionValue("");
                }
            }
        }
        $this->DbMasterFilter = $this->getMasterFilter(); // Get master filter
        $this->DbDetailFilter = $this->getDetailFilter(); // Get detail filter
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("NpdHargaList"), "", $this->TableVar, true);
        $pageId = "delete";
        $Breadcrumb->add("delete", $pageId, $url);
    }

    // Setup lookup options
    public function setupLookupOptions($fld)
    {
        if ($fld->Lookup !== null && $fld->Lookup->Options === null) {
            // Get default connection and filter
            $conn = $this->getConnection();
            $lookupFilter = "";

            // No need to check any more
            $fld->Lookup->Options = [];

            // Set up lookup SQL and connection
            switch ($fld->FieldVar) {
                case "x_idnpd":
                    $lookupFilter = function () {
                        return "`id` IN (SELECT `idnpd` FROM `npd_confirmsample`)";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_idnpd_sample":
                    $lookupFilter = function () {
                        return CurrentPageID() == "add" ? "id IN (SELECT idnpd_sample FROM npd_confirmsample WHERE readonly=0)" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_viskositas":
                    break;
                case "x_warna":
                    break;
                case "x_aplikasisediaan":
                    break;
                case "x_segel":
                    break;
                case "x_jenislabel":
                    break;
                case "x_kualitaslabel":
                    break;
                case "x_kategoridelivery":
                    break;
                case "x_disetujui":
                    break;
                case "x_readonly":
                    break;
                default:
                    $lookupFilter = "";
                    break;
            }

            // Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
            $sql = $fld->Lookup->getSql(false, "", $lookupFilter, $this);

            // Set up lookup cache
            if ($fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0) {
                $totalCnt = $this->getRecordCount($sql, $conn);
                if ($totalCnt > $fld->LookupCacheCount) { // Total count > cache count, do not cache
                    return;
                }
                $rows = $conn->executeQuery($sql)->fetchAll(\PDO::FETCH_BOTH);
                $ar = [];
                foreach ($rows as $row) {
                    $row = $fld->Lookup->renderViewRow($row);
                    $ar[strval($row[0])] = $row;
                }
                $fld->Lookup->Options = $ar;
            }
        }
    }

    // Page Load event
    public function pageLoad()
    {
        //Log("Page Load");
    }

    // Page Unload event
    public function pageUnload()
    {
        //Log("Page Unload");
    }

    // Page Redirecting event
    public function pageRedirecting(&$url)
    {
        // Example:
        //$url = "your URL";
    }

    // Message Showing event
    // $type = ''|'success'|'failure'|'warning'
    public function messageShowing(&$msg, $type)
    {
        if ($type == 'success') {
            //$msg = "your success message";
        } elseif ($type == 'failure') {
            //$msg = "your failure message";
        } elseif ($type == 'warning') {
            //$msg = "your warning message";
        } else {
            //$msg = "your message";
        }
    }

    // Page Render event
    public function pageRender()
    {
        //Log("Page Render");
    }

    // Page Data Rendering event
    public function pageDataRendering(&$header)
    {
        // Example:
        //$header = "your header";
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }
}
