<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class NpdDelete extends Npd
{
    use MessagesTrait;

    // Page ID
    public $PageID = "delete";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'npd';

    // Page object name
    public $PageObjName = "NpdDelete";

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

        // Table object (npd)
        if (!isset($GLOBALS["npd"]) || get_class($GLOBALS["npd"]) == PROJECT_NAMESPACE . "npd") {
            $GLOBALS["npd"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'npd');
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
                $doc = new $class(Container("npd"));
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
        $this->idpegawai->setVisibility();
        $this->idcustomer->setVisibility();
        $this->idbrand->setVisibility();
        $this->tanggal_order->setVisibility();
        $this->target_selesai->setVisibility();
        $this->sifatorder->setVisibility();
        $this->kodeorder->setVisibility();
        $this->nomororder->setVisibility();
        $this->idproduct_acuan->Visible = false;
        $this->kategoriproduk->Visible = false;
        $this->jenisproduk->Visible = false;
        $this->fungsiproduk->Visible = false;
        $this->kualitasproduk->Visible = false;
        $this->bahan_campaign->Visible = false;
        $this->ukuran_sediaan->Visible = false;
        $this->bentuk->Visible = false;
        $this->viskositas->Visible = false;
        $this->warna->Visible = false;
        $this->parfum->Visible = false;
        $this->aplikasi->Visible = false;
        $this->tambahan->Visible = false;
        $this->ukurankemasan->Visible = false;
        $this->kemasanbentuk->Visible = false;
        $this->kemasantutup->Visible = false;
        $this->kemasancatatan->Visible = false;
        $this->labelbahan->Visible = false;
        $this->labelkualitas->Visible = false;
        $this->labelposisi->Visible = false;
        $this->labelcatatan->Visible = false;
        $this->status->setVisibility();
        $this->readonly->Visible = false;
        $this->selesai->Visible = false;
        $this->created_at->Visible = false;
        $this->updated_at->setVisibility();
        $this->estetika->setVisibility();
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
        $this->setupLookupOptions($this->idpegawai);
        $this->setupLookupOptions($this->idcustomer);
        $this->setupLookupOptions($this->idbrand);
        $this->setupLookupOptions($this->idproduct_acuan);
        $this->setupLookupOptions($this->kategoriproduk);
        $this->setupLookupOptions($this->jenisproduk);
        $this->setupLookupOptions($this->bentuk);
        $this->setupLookupOptions($this->parfum);
        $this->setupLookupOptions($this->aplikasi);
        $this->setupLookupOptions($this->kemasanbentuk);
        $this->setupLookupOptions($this->kemasantutup);
        $this->setupLookupOptions($this->labelbahan);
        $this->setupLookupOptions($this->labelkualitas);
        $this->setupLookupOptions($this->labelposisi);

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Load key parameters
        $this->RecKeys = $this->getRecordKeys(); // Load record keys
        $filter = $this->getFilterFromRecordKeys();
        if ($filter == "") {
            $this->terminate("NpdList"); // Prevent SQL injection, return to list
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
                $this->terminate("NpdList"); // Return to list
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
        $this->idpegawai->setDbValue($row['idpegawai']);
        $this->idcustomer->setDbValue($row['idcustomer']);
        $this->idbrand->setDbValue($row['idbrand']);
        $this->tanggal_order->setDbValue($row['tanggal_order']);
        $this->target_selesai->setDbValue($row['target_selesai']);
        $this->sifatorder->setDbValue($row['sifatorder']);
        $this->kodeorder->setDbValue($row['kodeorder']);
        $this->nomororder->setDbValue($row['nomororder']);
        $this->idproduct_acuan->setDbValue($row['idproduct_acuan']);
        $this->kategoriproduk->setDbValue($row['kategoriproduk']);
        $this->jenisproduk->setDbValue($row['jenisproduk']);
        $this->fungsiproduk->setDbValue($row['fungsiproduk']);
        $this->kualitasproduk->setDbValue($row['kualitasproduk']);
        $this->bahan_campaign->setDbValue($row['bahan_campaign']);
        $this->ukuran_sediaan->setDbValue($row['ukuran_sediaan']);
        $this->bentuk->setDbValue($row['bentuk']);
        $this->viskositas->setDbValue($row['viskositas']);
        $this->warna->setDbValue($row['warna']);
        $this->parfum->setDbValue($row['parfum']);
        $this->aplikasi->setDbValue($row['aplikasi']);
        $this->tambahan->setDbValue($row['tambahan']);
        $this->ukurankemasan->setDbValue($row['ukurankemasan']);
        $this->kemasanbentuk->setDbValue($row['kemasanbentuk']);
        $this->kemasantutup->setDbValue($row['kemasantutup']);
        $this->kemasancatatan->setDbValue($row['kemasancatatan']);
        $this->labelbahan->setDbValue($row['labelbahan']);
        $this->labelkualitas->setDbValue($row['labelkualitas']);
        $this->labelposisi->setDbValue($row['labelposisi']);
        $this->labelcatatan->setDbValue($row['labelcatatan']);
        $this->status->setDbValue($row['status']);
        $this->readonly->setDbValue($row['readonly']);
        $this->selesai->setDbValue($row['selesai']);
        $this->created_at->setDbValue($row['created_at']);
        $this->updated_at->setDbValue($row['updated_at']);
        $this->estetika->setDbValue($row['estetika']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['idpegawai'] = null;
        $row['idcustomer'] = null;
        $row['idbrand'] = null;
        $row['tanggal_order'] = null;
        $row['target_selesai'] = null;
        $row['sifatorder'] = null;
        $row['kodeorder'] = null;
        $row['nomororder'] = null;
        $row['idproduct_acuan'] = null;
        $row['kategoriproduk'] = null;
        $row['jenisproduk'] = null;
        $row['fungsiproduk'] = null;
        $row['kualitasproduk'] = null;
        $row['bahan_campaign'] = null;
        $row['ukuran_sediaan'] = null;
        $row['bentuk'] = null;
        $row['viskositas'] = null;
        $row['warna'] = null;
        $row['parfum'] = null;
        $row['aplikasi'] = null;
        $row['tambahan'] = null;
        $row['ukurankemasan'] = null;
        $row['kemasanbentuk'] = null;
        $row['kemasantutup'] = null;
        $row['kemasancatatan'] = null;
        $row['labelbahan'] = null;
        $row['labelkualitas'] = null;
        $row['labelposisi'] = null;
        $row['labelcatatan'] = null;
        $row['status'] = null;
        $row['readonly'] = null;
        $row['selesai'] = null;
        $row['created_at'] = null;
        $row['updated_at'] = null;
        $row['estetika'] = null;
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

        // idpegawai

        // idcustomer

        // idbrand

        // tanggal_order

        // target_selesai

        // sifatorder

        // kodeorder

        // nomororder

        // idproduct_acuan
        $this->idproduct_acuan->CellCssStyle = "white-space: nowrap;";

        // kategoriproduk

        // jenisproduk

        // fungsiproduk

        // kualitasproduk

        // bahan_campaign

        // ukuran_sediaan

        // bentuk

        // viskositas

        // warna

        // parfum

        // aplikasi

        // tambahan

        // ukurankemasan

        // kemasanbentuk

        // kemasantutup

        // kemasancatatan

        // labelbahan

        // labelkualitas

        // labelposisi

        // labelcatatan

        // status

        // readonly

        // selesai

        // created_at

        // updated_at

        // estetika
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // idpegawai
            $curVal = trim(strval($this->idpegawai->CurrentValue));
            if ($curVal != "") {
                $this->idpegawai->ViewValue = $this->idpegawai->lookupCacheOption($curVal);
                if ($this->idpegawai->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->idpegawai->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idpegawai->Lookup->renderViewRow($rswrk[0]);
                        $this->idpegawai->ViewValue = $this->idpegawai->displayValue($arwrk);
                    } else {
                        $this->idpegawai->ViewValue = $this->idpegawai->CurrentValue;
                    }
                }
            } else {
                $this->idpegawai->ViewValue = null;
            }
            $this->idpegawai->ViewCustomAttributes = "";

            // idcustomer
            $curVal = trim(strval($this->idcustomer->CurrentValue));
            if ($curVal != "") {
                $this->idcustomer->ViewValue = $this->idcustomer->lookupCacheOption($curVal);
                if ($this->idcustomer->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->idcustomer->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idcustomer->Lookup->renderViewRow($rswrk[0]);
                        $this->idcustomer->ViewValue = $this->idcustomer->displayValue($arwrk);
                    } else {
                        $this->idcustomer->ViewValue = $this->idcustomer->CurrentValue;
                    }
                }
            } else {
                $this->idcustomer->ViewValue = null;
            }
            $this->idcustomer->ViewCustomAttributes = "";

            // idbrand
            $curVal = trim(strval($this->idbrand->CurrentValue));
            if ($curVal != "") {
                $this->idbrand->ViewValue = $this->idbrand->lookupCacheOption($curVal);
                if ($this->idbrand->ViewValue === null) { // Lookup from database
                    $filterWrk = "`idbrand`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->idbrand->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idbrand->Lookup->renderViewRow($rswrk[0]);
                        $this->idbrand->ViewValue = $this->idbrand->displayValue($arwrk);
                    } else {
                        $this->idbrand->ViewValue = $this->idbrand->CurrentValue;
                    }
                }
            } else {
                $this->idbrand->ViewValue = null;
            }
            $this->idbrand->ViewCustomAttributes = "";

            // tanggal_order
            $this->tanggal_order->ViewValue = $this->tanggal_order->CurrentValue;
            $this->tanggal_order->ViewValue = FormatDateTime($this->tanggal_order->ViewValue, 0);
            $this->tanggal_order->ViewCustomAttributes = "";

            // target_selesai
            $this->target_selesai->ViewValue = $this->target_selesai->CurrentValue;
            $this->target_selesai->ViewValue = FormatDateTime($this->target_selesai->ViewValue, 0);
            $this->target_selesai->ViewCustomAttributes = "";

            // sifatorder
            if (strval($this->sifatorder->CurrentValue) != "") {
                $this->sifatorder->ViewValue = $this->sifatorder->optionCaption($this->sifatorder->CurrentValue);
            } else {
                $this->sifatorder->ViewValue = null;
            }
            $this->sifatorder->ViewCustomAttributes = "";

            // kodeorder
            $this->kodeorder->ViewValue = $this->kodeorder->CurrentValue;
            $this->kodeorder->ViewCustomAttributes = "";

            // nomororder
            $this->nomororder->ViewValue = $this->nomororder->CurrentValue;
            $this->nomororder->ViewCustomAttributes = "";

            // kategoriproduk
            $curVal = trim(strval($this->kategoriproduk->CurrentValue));
            if ($curVal != "") {
                $this->kategoriproduk->ViewValue = $this->kategoriproduk->lookupCacheOption($curVal);
                if ($this->kategoriproduk->ViewValue === null) { // Lookup from database
                    $filterWrk = "`grup`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->kategoriproduk->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->kategoriproduk->Lookup->renderViewRow($rswrk[0]);
                        $this->kategoriproduk->ViewValue = $this->kategoriproduk->displayValue($arwrk);
                    } else {
                        $this->kategoriproduk->ViewValue = $this->kategoriproduk->CurrentValue;
                    }
                }
            } else {
                $this->kategoriproduk->ViewValue = null;
            }
            $this->kategoriproduk->ViewCustomAttributes = "";

            // jenisproduk
            $curVal = trim(strval($this->jenisproduk->CurrentValue));
            if ($curVal != "") {
                $this->jenisproduk->ViewValue = $this->jenisproduk->lookupCacheOption($curVal);
                if ($this->jenisproduk->ViewValue === null) { // Lookup from database
                    $filterWrk = "`kategori`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->jenisproduk->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->jenisproduk->Lookup->renderViewRow($rswrk[0]);
                        $this->jenisproduk->ViewValue = $this->jenisproduk->displayValue($arwrk);
                    } else {
                        $this->jenisproduk->ViewValue = $this->jenisproduk->CurrentValue;
                    }
                }
            } else {
                $this->jenisproduk->ViewValue = null;
            }
            $this->jenisproduk->ViewCustomAttributes = "";

            // fungsiproduk
            $this->fungsiproduk->ViewValue = $this->fungsiproduk->CurrentValue;
            $this->fungsiproduk->ViewCustomAttributes = "";

            // kualitasproduk
            $this->kualitasproduk->ViewValue = $this->kualitasproduk->CurrentValue;
            $this->kualitasproduk->ViewCustomAttributes = "";

            // bahan_campaign
            $this->bahan_campaign->ViewValue = $this->bahan_campaign->CurrentValue;
            $this->bahan_campaign->ViewCustomAttributes = "";

            // ukuran_sediaan
            $this->ukuran_sediaan->ViewValue = $this->ukuran_sediaan->CurrentValue;
            $this->ukuran_sediaan->ViewCustomAttributes = "";

            // bentuk
            $curVal = trim(strval($this->bentuk->CurrentValue));
            if ($curVal != "") {
                $this->bentuk->ViewValue = $this->bentuk->lookupCacheOption($curVal);
                if ($this->bentuk->ViewValue === null) { // Lookup from database
                    $filterWrk = "`sediaan`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->bentuk->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->bentuk->Lookup->renderViewRow($rswrk[0]);
                        $this->bentuk->ViewValue = $this->bentuk->displayValue($arwrk);
                    } else {
                        $this->bentuk->ViewValue = $this->bentuk->CurrentValue;
                    }
                }
            } else {
                $this->bentuk->ViewValue = null;
            }
            $this->bentuk->ViewCustomAttributes = "";

            // viskositas
            $this->viskositas->ViewValue = $this->viskositas->CurrentValue;
            $this->viskositas->ViewCustomAttributes = "";

            // warna
            $this->warna->ViewValue = $this->warna->CurrentValue;
            $this->warna->ViewCustomAttributes = "";

            // parfum
            $curVal = trim(strval($this->parfum->CurrentValue));
            if ($curVal != "") {
                $this->parfum->ViewValue = $this->parfum->lookupCacheOption($curVal);
                if ($this->parfum->ViewValue === null) { // Lookup from database
                    $filterWrk = "`fragrance`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->parfum->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->parfum->Lookup->renderViewRow($rswrk[0]);
                        $this->parfum->ViewValue = $this->parfum->displayValue($arwrk);
                    } else {
                        $this->parfum->ViewValue = $this->parfum->CurrentValue;
                    }
                }
            } else {
                $this->parfum->ViewValue = null;
            }
            $this->parfum->ViewCustomAttributes = "";

            // aplikasi
            $curVal = trim(strval($this->aplikasi->CurrentValue));
            if ($curVal != "") {
                $this->aplikasi->ViewValue = $this->aplikasi->lookupCacheOption($curVal);
                if ($this->aplikasi->ViewValue === null) { // Lookup from database
                    $filterWrk = "`aplikasi_sediaan`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->aplikasi->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->aplikasi->Lookup->renderViewRow($rswrk[0]);
                        $this->aplikasi->ViewValue = $this->aplikasi->displayValue($arwrk);
                    } else {
                        $this->aplikasi->ViewValue = $this->aplikasi->CurrentValue;
                    }
                }
            } else {
                $this->aplikasi->ViewValue = null;
            }
            $this->aplikasi->ViewCustomAttributes = "";

            // tambahan
            $this->tambahan->ViewValue = $this->tambahan->CurrentValue;
            $this->tambahan->ViewCustomAttributes = "";

            // ukurankemasan
            $this->ukurankemasan->ViewValue = $this->ukurankemasan->CurrentValue;
            $this->ukurankemasan->ViewCustomAttributes = "";

            // kemasanbentuk
            $curVal = trim(strval($this->kemasanbentuk->CurrentValue));
            if ($curVal != "") {
                $this->kemasanbentuk->ViewValue = $this->kemasanbentuk->lookupCacheOption($curVal);
                if ($this->kemasanbentuk->ViewValue === null) { // Lookup from database
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`nama`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->kemasanbentuk->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->kemasanbentuk->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->kemasanbentuk->Lookup->renderViewRow($row);
                            $this->kemasanbentuk->ViewValue->add($this->kemasanbentuk->displayValue($arwrk));
                        }
                    } else {
                        $this->kemasanbentuk->ViewValue = $this->kemasanbentuk->CurrentValue;
                    }
                }
            } else {
                $this->kemasanbentuk->ViewValue = null;
            }
            $this->kemasanbentuk->ViewCustomAttributes = "";

            // kemasantutup
            $curVal = trim(strval($this->kemasantutup->CurrentValue));
            if ($curVal != "") {
                $this->kemasantutup->ViewValue = $this->kemasantutup->lookupCacheOption($curVal);
                if ($this->kemasantutup->ViewValue === null) { // Lookup from database
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`nama`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->kemasantutup->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->kemasantutup->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->kemasantutup->Lookup->renderViewRow($row);
                            $this->kemasantutup->ViewValue->add($this->kemasantutup->displayValue($arwrk));
                        }
                    } else {
                        $this->kemasantutup->ViewValue = $this->kemasantutup->CurrentValue;
                    }
                }
            } else {
                $this->kemasantutup->ViewValue = null;
            }
            $this->kemasantutup->ViewCustomAttributes = "";

            // labelbahan
            $curVal = trim(strval($this->labelbahan->CurrentValue));
            if ($curVal != "") {
                $this->labelbahan->ViewValue = $this->labelbahan->lookupCacheOption($curVal);
                if ($this->labelbahan->ViewValue === null) { // Lookup from database
                    $filterWrk = "`nama`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->labelbahan->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->labelbahan->Lookup->renderViewRow($rswrk[0]);
                        $this->labelbahan->ViewValue = $this->labelbahan->displayValue($arwrk);
                    } else {
                        $this->labelbahan->ViewValue = $this->labelbahan->CurrentValue;
                    }
                }
            } else {
                $this->labelbahan->ViewValue = null;
            }
            $this->labelbahan->ViewCustomAttributes = "";

            // labelkualitas
            $curVal = trim(strval($this->labelkualitas->CurrentValue));
            if ($curVal != "") {
                $this->labelkualitas->ViewValue = $this->labelkualitas->lookupCacheOption($curVal);
                if ($this->labelkualitas->ViewValue === null) { // Lookup from database
                    $filterWrk = "`nama`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->labelkualitas->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->labelkualitas->Lookup->renderViewRow($rswrk[0]);
                        $this->labelkualitas->ViewValue = $this->labelkualitas->displayValue($arwrk);
                    } else {
                        $this->labelkualitas->ViewValue = $this->labelkualitas->CurrentValue;
                    }
                }
            } else {
                $this->labelkualitas->ViewValue = null;
            }
            $this->labelkualitas->ViewCustomAttributes = "";

            // labelposisi
            $curVal = trim(strval($this->labelposisi->CurrentValue));
            if ($curVal != "") {
                $this->labelposisi->ViewValue = $this->labelposisi->lookupCacheOption($curVal);
                if ($this->labelposisi->ViewValue === null) { // Lookup from database
                    $filterWrk = "`nama`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->labelposisi->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->labelposisi->Lookup->renderViewRow($rswrk[0]);
                        $this->labelposisi->ViewValue = $this->labelposisi->displayValue($arwrk);
                    } else {
                        $this->labelposisi->ViewValue = $this->labelposisi->CurrentValue;
                    }
                }
            } else {
                $this->labelposisi->ViewValue = null;
            }
            $this->labelposisi->ViewCustomAttributes = "";

            // status
            $this->status->ViewValue = $this->status->CurrentValue;
            $this->status->ViewCustomAttributes = "";

            // readonly
            if (strval($this->readonly->CurrentValue) != "") {
                $this->readonly->ViewValue = $this->readonly->optionCaption($this->readonly->CurrentValue);
            } else {
                $this->readonly->ViewValue = null;
            }
            $this->readonly->ViewCustomAttributes = "";

            // selesai
            if (strval($this->selesai->CurrentValue) != "") {
                $this->selesai->ViewValue = $this->selesai->optionCaption($this->selesai->CurrentValue);
            } else {
                $this->selesai->ViewValue = null;
            }
            $this->selesai->ViewCustomAttributes = "";

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 11);
            $this->created_at->ViewCustomAttributes = "";

            // updated_at
            $this->updated_at->ViewValue = $this->updated_at->CurrentValue;
            $this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, 17);
            $this->updated_at->ViewCustomAttributes = "";

            // estetika
            $this->estetika->ViewValue = $this->estetika->CurrentValue;
            $this->estetika->ViewCustomAttributes = "";

            // idpegawai
            $this->idpegawai->LinkCustomAttributes = "";
            $this->idpegawai->HrefValue = "";
            $this->idpegawai->TooltipValue = "";

            // idcustomer
            $this->idcustomer->LinkCustomAttributes = "";
            $this->idcustomer->HrefValue = "";
            $this->idcustomer->TooltipValue = "";

            // idbrand
            $this->idbrand->LinkCustomAttributes = "";
            $this->idbrand->HrefValue = "";
            $this->idbrand->TooltipValue = "";

            // tanggal_order
            $this->tanggal_order->LinkCustomAttributes = "";
            $this->tanggal_order->HrefValue = "";
            $this->tanggal_order->TooltipValue = "";

            // target_selesai
            $this->target_selesai->LinkCustomAttributes = "";
            $this->target_selesai->HrefValue = "";
            $this->target_selesai->TooltipValue = "";

            // sifatorder
            $this->sifatorder->LinkCustomAttributes = "";
            $this->sifatorder->HrefValue = "";
            $this->sifatorder->TooltipValue = "";

            // kodeorder
            $this->kodeorder->LinkCustomAttributes = "";
            $this->kodeorder->HrefValue = "";
            $this->kodeorder->TooltipValue = "";

            // nomororder
            $this->nomororder->LinkCustomAttributes = "";
            $this->nomororder->HrefValue = "";
            $this->nomororder->TooltipValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
            $this->status->TooltipValue = "";

            // updated_at
            $this->updated_at->LinkCustomAttributes = "";
            $this->updated_at->HrefValue = "";
            $this->updated_at->TooltipValue = "";

            // estetika
            $this->estetika->LinkCustomAttributes = "";
            $this->estetika->HrefValue = "";
            $this->estetika->TooltipValue = "";
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

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("NpdList"), "", $this->TableVar, true);
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
                case "x_idpegawai":
                    break;
                case "x_idcustomer":
                    break;
                case "x_idbrand":
                    break;
                case "x_sifatorder":
                    break;
                case "x_idproduct_acuan":
                    $lookupFilter = function () {
                        return (CurrentPageID() == "add" || CurrentPageID() == "edit") ? "idbrand = 1" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_kategoriproduk":
                    break;
                case "x_jenisproduk":
                    break;
                case "x_bentuk":
                    break;
                case "x_parfum":
                    break;
                case "x_aplikasi":
                    break;
                case "x_kemasanbentuk":
                    break;
                case "x_kemasantutup":
                    break;
                case "x_labelbahan":
                    break;
                case "x_labelkualitas":
                    break;
                case "x_labelposisi":
                    break;
                case "x_readonly":
                    break;
                case "x_selesai":
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
