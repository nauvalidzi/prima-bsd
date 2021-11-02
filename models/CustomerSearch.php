<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class CustomerSearch extends Customer
{
    use MessagesTrait;

    // Page ID
    public $PageID = "search";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'customer';

    // Page object name
    public $PageObjName = "CustomerSearch";

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

        // Table object (customer)
        if (!isset($GLOBALS["customer"]) || get_class($GLOBALS["customer"]) == PROJECT_NAMESPACE . "customer") {
            $GLOBALS["customer"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'customer');
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
                $doc = new $class(Container("customer"));
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

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "CustomerView") {
                        $row["view"] = "1";
                    }
                } else { // List page should not be shown as modal => error
                    $row["error"] = $this->getFailureMessage();
                    $this->clearFailureMessage();
                }
                WriteJson($row);
            } else {
                SaveDebugMessage();
                Redirect(GetUrl($url));
            }
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

    // Lookup data
    public function lookup()
    {
        global $Language, $Security;

        // Get lookup object
        $fieldName = Post("field");
        $lookup = $this->Fields[$fieldName]->Lookup;

        // Get lookup parameters
        $lookupType = Post("ajax", "unknown");
        $pageSize = -1;
        $offset = -1;
        $searchValue = "";
        if (SameText($lookupType, "modal")) {
            $searchValue = Post("sv", "");
            $pageSize = Post("recperpage", 10);
            $offset = Post("start", 0);
        } elseif (SameText($lookupType, "autosuggest")) {
            $searchValue = Param("q", "");
            $pageSize = Param("n", -1);
            $pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
            if ($pageSize <= 0) {
                $pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
            }
            $start = Param("start", -1);
            $start = is_numeric($start) ? (int)$start : -1;
            $page = Param("page", -1);
            $page = is_numeric($page) ? (int)$page : -1;
            $offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
        }
        $userSelect = Decrypt(Post("s", ""));
        $userFilter = Decrypt(Post("f", ""));
        $userOrderBy = Decrypt(Post("o", ""));
        $keys = Post("keys");
        $lookup->LookupType = $lookupType; // Lookup type
        if ($keys !== null) { // Selected records from modal
            if (is_array($keys)) {
                $keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
            }
            $lookup->FilterFields = []; // Skip parent fields if any
            $lookup->FilterValues[] = $keys; // Lookup values
            $pageSize = -1; // Show all records
        } else { // Lookup values
            $lookup->FilterValues[] = Post("v0", Post("lookupValue", ""));
        }
        $cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
        for ($i = 1; $i <= $cnt; $i++) {
            $lookup->FilterValues[] = Post("v" . $i, "");
        }
        $lookup->SearchValue = $searchValue;
        $lookup->PageSize = $pageSize;
        $lookup->Offset = $offset;
        if ($userSelect != "") {
            $lookup->UserSelect = $userSelect;
        }
        if ($userFilter != "") {
            $lookup->UserFilter = $userFilter;
        }
        if ($userOrderBy != "") {
            $lookup->UserOrderBy = $userOrderBy;
        }
        $lookup->toJson($this); // Use settings from current page
    }
    public $FormClassName = "ew-horizontal ew-form ew-search-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
            $SkipHeaderFooter;

        // Is modal
        $this->IsModal = Param("modal") == "1";

        // Create form object
        $CurrentForm = new HttpForm();
        $this->CurrentAction = Param("action"); // Set up current action
        $this->id->Visible = false;
        $this->kode->setVisibility();
        $this->idtipecustomer->setVisibility();
        $this->idpegawai->setVisibility();
        $this->nama->setVisibility();
        $this->kodenpd->setVisibility();
        $this->usaha->setVisibility();
        $this->jabatan->setVisibility();
        $this->ktp->setVisibility();
        $this->npwp->setVisibility();
        $this->idprov->setVisibility();
        $this->idkab->setVisibility();
        $this->idkec->setVisibility();
        $this->idkel->setVisibility();
        $this->kodepos->setVisibility();
        $this->alamat->setVisibility();
        $this->telpon->setVisibility();
        $this->hp->setVisibility();
        $this->_email->setVisibility();
        $this->website->setVisibility();
        $this->foto->setVisibility();
        $this->level_customer_id->Visible = false;
        $this->limit_kredit_order->setVisibility();
        $this->jatuh_tempo_invoice->setVisibility();
        $this->keterangan->setVisibility();
        $this->aktif->setVisibility();
        $this->created_at->setVisibility();
        $this->updated_at->setVisibility();
        $this->created_by->setVisibility();
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
        $this->setupLookupOptions($this->idtipecustomer);
        $this->setupLookupOptions($this->idpegawai);
        $this->setupLookupOptions($this->idprov);
        $this->setupLookupOptions($this->idkab);
        $this->setupLookupOptions($this->idkec);
        $this->setupLookupOptions($this->idkel);
        $this->setupLookupOptions($this->level_customer_id);
        $this->setupLookupOptions($this->jatuh_tempo_invoice);

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        if ($this->isPageRequest()) {
            // Get action
            $this->CurrentAction = Post("action");
            if ($this->isSearch()) {
                // Build search string for advanced search, remove blank field
                $this->loadSearchValues(); // Get search values
                if ($this->validateSearch()) {
                    $srchStr = $this->buildAdvancedSearch();
                } else {
                    $srchStr = "";
                }
                if ($srchStr != "") {
                    $srchStr = $this->getUrlParm($srchStr);
                    $srchStr = "CustomerList" . "?" . $srchStr;
                    $this->terminate($srchStr); // Go to list page
                    return;
                }
            }
        }

        // Restore search settings from Session
        if (!$this->hasInvalidFields()) {
            $this->loadAdvancedSearch();
        }

        // Render row for search
        $this->RowType = ROWTYPE_SEARCH;
        $this->resetAttributes();
        $this->renderRow();

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

    // Build advanced search
    protected function buildAdvancedSearch()
    {
        $srchUrl = "";
        $this->buildSearchUrl($srchUrl, $this->kode); // kode
        $this->buildSearchUrl($srchUrl, $this->idtipecustomer); // idtipecustomer
        $this->buildSearchUrl($srchUrl, $this->idpegawai); // idpegawai
        $this->buildSearchUrl($srchUrl, $this->nama); // nama
        $this->buildSearchUrl($srchUrl, $this->kodenpd); // kodenpd
        $this->buildSearchUrl($srchUrl, $this->usaha); // usaha
        $this->buildSearchUrl($srchUrl, $this->jabatan); // jabatan
        $this->buildSearchUrl($srchUrl, $this->idprov); // idprov
        $this->buildSearchUrl($srchUrl, $this->idkab); // idkab
        $this->buildSearchUrl($srchUrl, $this->idkec); // idkec
        $this->buildSearchUrl($srchUrl, $this->idkel); // idkel
        $this->buildSearchUrl($srchUrl, $this->kodepos); // kodepos
        $this->buildSearchUrl($srchUrl, $this->alamat); // alamat
        $this->buildSearchUrl($srchUrl, $this->telpon); // telpon
        $this->buildSearchUrl($srchUrl, $this->hp); // hp
        $this->buildSearchUrl($srchUrl, $this->_email); // email
        $this->buildSearchUrl($srchUrl, $this->website); // website
        $this->buildSearchUrl($srchUrl, $this->foto); // foto
        $this->buildSearchUrl($srchUrl, $this->limit_kredit_order); // limit_kredit_order
        $this->buildSearchUrl($srchUrl, $this->jatuh_tempo_invoice); // jatuh_tempo_invoice
        $this->buildSearchUrl($srchUrl, $this->keterangan); // keterangan
        $this->buildSearchUrl($srchUrl, $this->aktif); // aktif
        $this->buildSearchUrl($srchUrl, $this->created_at); // created_at
        $this->buildSearchUrl($srchUrl, $this->updated_at); // updated_at
        $this->buildSearchUrl($srchUrl, $this->created_by); // created_by
        if ($srchUrl != "") {
            $srchUrl .= "&";
        }
        $srchUrl .= "cmd=search";
        return $srchUrl;
    }

    // Build search URL
    protected function buildSearchUrl(&$url, &$fld, $oprOnly = false)
    {
        global $CurrentForm;
        $wrk = "";
        $fldParm = $fld->Param;
        $fldVal = $CurrentForm->getValue("x_$fldParm");
        $fldOpr = $CurrentForm->getValue("z_$fldParm");
        $fldCond = $CurrentForm->getValue("v_$fldParm");
        $fldVal2 = $CurrentForm->getValue("y_$fldParm");
        $fldOpr2 = $CurrentForm->getValue("w_$fldParm");
        if (is_array($fldVal)) {
            $fldVal = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal);
        }
        if (is_array($fldVal2)) {
            $fldVal2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal2);
        }
        $fldOpr = strtoupper(trim($fldOpr));
        $fldDataType = ($fld->IsVirtual) ? DATATYPE_STRING : $fld->DataType;
        if ($fldOpr == "BETWEEN") {
            $isValidValue = ($fldDataType != DATATYPE_NUMBER) ||
                ($fldDataType == DATATYPE_NUMBER && $this->searchValueIsNumeric($fld, $fldVal) && $this->searchValueIsNumeric($fld, $fldVal2));
            if ($fldVal != "" && $fldVal2 != "" && $isValidValue) {
                $wrk = "x_" . $fldParm . "=" . urlencode($fldVal) .
                    "&y_" . $fldParm . "=" . urlencode($fldVal2) .
                    "&z_" . $fldParm . "=" . urlencode($fldOpr);
            }
        } else {
            $isValidValue = ($fldDataType != DATATYPE_NUMBER) ||
                ($fldDataType == DATATYPE_NUMBER && $this->searchValueIsNumeric($fld, $fldVal));
            if ($fldVal != "" && $isValidValue && IsValidOperator($fldOpr, $fldDataType)) {
                $wrk = "x_" . $fldParm . "=" . urlencode($fldVal) .
                    "&z_" . $fldParm . "=" . urlencode($fldOpr);
            } elseif ($fldOpr == "IS NULL" || $fldOpr == "IS NOT NULL" || ($fldOpr != "" && $oprOnly && IsValidOperator($fldOpr, $fldDataType))) {
                $wrk = "z_" . $fldParm . "=" . urlencode($fldOpr);
            }
            $isValidValue = ($fldDataType != DATATYPE_NUMBER) ||
                ($fldDataType == DATATYPE_NUMBER && $this->searchValueIsNumeric($fld, $fldVal2));
            if ($fldVal2 != "" && $isValidValue && IsValidOperator($fldOpr2, $fldDataType)) {
                if ($wrk != "") {
                    $wrk .= "&v_" . $fldParm . "=" . urlencode($fldCond) . "&";
                }
                $wrk .= "y_" . $fldParm . "=" . urlencode($fldVal2) .
                    "&w_" . $fldParm . "=" . urlencode($fldOpr2);
            } elseif ($fldOpr2 == "IS NULL" || $fldOpr2 == "IS NOT NULL" || ($fldOpr2 != "" && $oprOnly && IsValidOperator($fldOpr2, $fldDataType))) {
                if ($wrk != "") {
                    $wrk .= "&v_" . $fldParm . "=" . urlencode($fldCond) . "&";
                }
                $wrk .= "w_" . $fldParm . "=" . urlencode($fldOpr2);
            }
        }
        if ($wrk != "") {
            if ($url != "") {
                $url .= "&";
            }
            $url .= $wrk;
        }
    }

    // Check if search value is numeric
    protected function searchValueIsNumeric($fld, $value)
    {
        if (IsFloatFormat($fld->Type)) {
            $value = ConvertToFloatString($value);
        }
        return is_numeric($value);
    }

    // Load search values for validation
    protected function loadSearchValues()
    {
        // Load search values
        $hasValue = false;
        if ($this->kode->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->idtipecustomer->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->idpegawai->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->nama->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->kodenpd->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->usaha->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->jabatan->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->idprov->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->idkab->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->idkec->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->idkel->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->kodepos->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->alamat->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->telpon->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->hp->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->_email->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->website->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->foto->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->limit_kredit_order->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->jatuh_tempo_invoice->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->keterangan->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->aktif->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->created_at->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->updated_at->AdvancedSearch->post()) {
            $hasValue = true;
        }
        if ($this->created_by->AdvancedSearch->post()) {
            $hasValue = true;
        }
        return $hasValue;
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

        // kode

        // idtipecustomer

        // idpegawai

        // nama

        // kodenpd

        // usaha

        // jabatan

        // ktp

        // npwp

        // idprov

        // idkab

        // idkec

        // idkel

        // kodepos

        // alamat

        // telpon

        // hp

        // email

        // website

        // foto

        // level_customer_id

        // limit_kredit_order

        // jatuh_tempo_invoice

        // keterangan

        // aktif

        // created_at

        // updated_at

        // created_by
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // kode
            $this->kode->ViewValue = $this->kode->CurrentValue;
            $this->kode->ViewCustomAttributes = "";

            // idtipecustomer
            $curVal = trim(strval($this->idtipecustomer->CurrentValue));
            if ($curVal != "") {
                $this->idtipecustomer->ViewValue = $this->idtipecustomer->lookupCacheOption($curVal);
                if ($this->idtipecustomer->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->idtipecustomer->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idtipecustomer->Lookup->renderViewRow($rswrk[0]);
                        $this->idtipecustomer->ViewValue = $this->idtipecustomer->displayValue($arwrk);
                    } else {
                        $this->idtipecustomer->ViewValue = $this->idtipecustomer->CurrentValue;
                    }
                }
            } else {
                $this->idtipecustomer->ViewValue = null;
            }
            $this->idtipecustomer->ViewCustomAttributes = "";

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

            // nama
            $this->nama->ViewValue = $this->nama->CurrentValue;
            $this->nama->ViewCustomAttributes = "";

            // kodenpd
            $this->kodenpd->ViewValue = $this->kodenpd->CurrentValue;
            $this->kodenpd->ViewCustomAttributes = "";

            // usaha
            $this->usaha->ViewValue = $this->usaha->CurrentValue;
            $this->usaha->ViewCustomAttributes = "";

            // jabatan
            $this->jabatan->ViewValue = $this->jabatan->CurrentValue;
            $this->jabatan->ViewCustomAttributes = "";

            // ktp
            if (!EmptyValue($this->ktp->Upload->DbValue)) {
                $this->ktp->ViewValue = $this->id->CurrentValue;
                $this->ktp->IsBlobImage = IsImageFile(ContentExtension($this->ktp->Upload->DbValue));
                $this->ktp->Upload->FileName = $this->ktp->CurrentValue;
            } else {
                $this->ktp->ViewValue = "";
            }
            $this->ktp->ViewCustomAttributes = "";

            // npwp
            if (!EmptyValue($this->npwp->Upload->DbValue)) {
                $this->npwp->ViewValue = $this->id->CurrentValue;
                $this->npwp->IsBlobImage = IsImageFile(ContentExtension($this->npwp->Upload->DbValue));
                $this->npwp->Upload->FileName = $this->npwp->CurrentValue;
            } else {
                $this->npwp->ViewValue = "";
            }
            $this->npwp->ViewCustomAttributes = "";

            // idprov
            $curVal = trim(strval($this->idprov->CurrentValue));
            if ($curVal != "") {
                $this->idprov->ViewValue = $this->idprov->lookupCacheOption($curVal);
                if ($this->idprov->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->idprov->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idprov->Lookup->renderViewRow($rswrk[0]);
                        $this->idprov->ViewValue = $this->idprov->displayValue($arwrk);
                    } else {
                        $this->idprov->ViewValue = $this->idprov->CurrentValue;
                    }
                }
            } else {
                $this->idprov->ViewValue = null;
            }
            $this->idprov->ViewCustomAttributes = "";

            // idkab
            $curVal = trim(strval($this->idkab->CurrentValue));
            if ($curVal != "") {
                $this->idkab->ViewValue = $this->idkab->lookupCacheOption($curVal);
                if ($this->idkab->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->idkab->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idkab->Lookup->renderViewRow($rswrk[0]);
                        $this->idkab->ViewValue = $this->idkab->displayValue($arwrk);
                    } else {
                        $this->idkab->ViewValue = $this->idkab->CurrentValue;
                    }
                }
            } else {
                $this->idkab->ViewValue = null;
            }
            $this->idkab->ViewCustomAttributes = "";

            // idkec
            $curVal = trim(strval($this->idkec->CurrentValue));
            if ($curVal != "") {
                $this->idkec->ViewValue = $this->idkec->lookupCacheOption($curVal);
                if ($this->idkec->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->idkec->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idkec->Lookup->renderViewRow($rswrk[0]);
                        $this->idkec->ViewValue = $this->idkec->displayValue($arwrk);
                    } else {
                        $this->idkec->ViewValue = $this->idkec->CurrentValue;
                    }
                }
            } else {
                $this->idkec->ViewValue = null;
            }
            $this->idkec->ViewCustomAttributes = "";

            // idkel
            $curVal = trim(strval($this->idkel->CurrentValue));
            if ($curVal != "") {
                $this->idkel->ViewValue = $this->idkel->lookupCacheOption($curVal);
                if ($this->idkel->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->idkel->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idkel->Lookup->renderViewRow($rswrk[0]);
                        $this->idkel->ViewValue = $this->idkel->displayValue($arwrk);
                    } else {
                        $this->idkel->ViewValue = $this->idkel->CurrentValue;
                    }
                }
            } else {
                $this->idkel->ViewValue = null;
            }
            $this->idkel->ViewCustomAttributes = "";

            // kodepos
            $this->kodepos->ViewValue = $this->kodepos->CurrentValue;
            $this->kodepos->ViewCustomAttributes = "";

            // alamat
            $this->alamat->ViewValue = $this->alamat->CurrentValue;
            $this->alamat->ViewCustomAttributes = "";

            // telpon
            $this->telpon->ViewValue = $this->telpon->CurrentValue;
            $this->telpon->ViewCustomAttributes = "";

            // hp
            $this->hp->ViewValue = $this->hp->CurrentValue;
            $this->hp->ViewCustomAttributes = "";

            // email
            $this->_email->ViewValue = $this->_email->CurrentValue;
            $this->_email->ViewCustomAttributes = "";

            // website
            $this->website->ViewValue = $this->website->CurrentValue;
            $this->website->ViewCustomAttributes = "";

            // foto
            if (!EmptyValue($this->foto->Upload->DbValue)) {
                $this->foto->ImageAlt = $this->foto->alt();
                $this->foto->ViewValue = $this->foto->Upload->DbValue;
            } else {
                $this->foto->ViewValue = "";
            }
            $this->foto->ViewCustomAttributes = "";

            // limit_kredit_order
            $this->limit_kredit_order->ViewValue = $this->limit_kredit_order->CurrentValue;
            $this->limit_kredit_order->ViewValue = FormatCurrency($this->limit_kredit_order->ViewValue, 2, -2, -2, -2);
            $this->limit_kredit_order->ViewCustomAttributes = "";

            // jatuh_tempo_invoice
            $curVal = trim(strval($this->jatuh_tempo_invoice->CurrentValue));
            if ($curVal != "") {
                $this->jatuh_tempo_invoice->ViewValue = $this->jatuh_tempo_invoice->lookupCacheOption($curVal);
                if ($this->jatuh_tempo_invoice->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->jatuh_tempo_invoice->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->jatuh_tempo_invoice->Lookup->renderViewRow($rswrk[0]);
                        $this->jatuh_tempo_invoice->ViewValue = $this->jatuh_tempo_invoice->displayValue($arwrk);
                    } else {
                        $this->jatuh_tempo_invoice->ViewValue = $this->jatuh_tempo_invoice->CurrentValue;
                    }
                }
            } else {
                $this->jatuh_tempo_invoice->ViewValue = null;
            }
            $this->jatuh_tempo_invoice->ViewCustomAttributes = "";

            // keterangan
            $this->keterangan->ViewValue = $this->keterangan->CurrentValue;
            $this->keterangan->ViewCustomAttributes = "";

            // aktif
            if (strval($this->aktif->CurrentValue) != "") {
                $this->aktif->ViewValue = $this->aktif->optionCaption($this->aktif->CurrentValue);
            } else {
                $this->aktif->ViewValue = null;
            }
            $this->aktif->ViewCustomAttributes = "";

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
            $this->created_at->ViewCustomAttributes = "";

            // updated_at
            $this->updated_at->ViewValue = $this->updated_at->CurrentValue;
            $this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, 0);
            $this->updated_at->ViewCustomAttributes = "";

            // created_by
            $this->created_by->ViewValue = $this->created_by->CurrentValue;
            $this->created_by->ViewValue = FormatNumber($this->created_by->ViewValue, 0, -2, -2, -2);
            $this->created_by->ViewCustomAttributes = "";

            // kode
            $this->kode->LinkCustomAttributes = "";
            $this->kode->HrefValue = "";
            $this->kode->TooltipValue = "";

            // idtipecustomer
            $this->idtipecustomer->LinkCustomAttributes = "";
            $this->idtipecustomer->HrefValue = "";
            $this->idtipecustomer->TooltipValue = "";

            // idpegawai
            $this->idpegawai->LinkCustomAttributes = "";
            $this->idpegawai->HrefValue = "";
            $this->idpegawai->TooltipValue = "";

            // nama
            $this->nama->LinkCustomAttributes = "";
            $this->nama->HrefValue = "";
            $this->nama->TooltipValue = "";

            // kodenpd
            $this->kodenpd->LinkCustomAttributes = "";
            $this->kodenpd->HrefValue = "";
            $this->kodenpd->TooltipValue = "";

            // usaha
            $this->usaha->LinkCustomAttributes = "";
            $this->usaha->HrefValue = "";
            $this->usaha->TooltipValue = "";

            // jabatan
            $this->jabatan->LinkCustomAttributes = "";
            $this->jabatan->HrefValue = "";
            $this->jabatan->TooltipValue = "";

            // ktp
            $this->ktp->LinkCustomAttributes = "";
            if (!empty($this->ktp->Upload->DbValue)) {
                $this->ktp->HrefValue = GetFileUploadUrl($this->ktp, $this->id->CurrentValue);
                $this->ktp->LinkAttrs["target"] = "";
                if ($this->ktp->IsBlobImage && empty($this->ktp->LinkAttrs["target"])) {
                    $this->ktp->LinkAttrs["target"] = "_blank";
                }
                if ($this->isExport()) {
                    $this->ktp->HrefValue = FullUrl($this->ktp->HrefValue, "href");
                }
            } else {
                $this->ktp->HrefValue = "";
            }
            $this->ktp->ExportHrefValue = GetFileUploadUrl($this->ktp, $this->id->CurrentValue);
            $this->ktp->TooltipValue = "";

            // npwp
            $this->npwp->LinkCustomAttributes = "";
            if (!empty($this->npwp->Upload->DbValue)) {
                $this->npwp->HrefValue = GetFileUploadUrl($this->npwp, $this->id->CurrentValue);
                $this->npwp->LinkAttrs["target"] = "";
                if ($this->npwp->IsBlobImage && empty($this->npwp->LinkAttrs["target"])) {
                    $this->npwp->LinkAttrs["target"] = "_blank";
                }
                if ($this->isExport()) {
                    $this->npwp->HrefValue = FullUrl($this->npwp->HrefValue, "href");
                }
            } else {
                $this->npwp->HrefValue = "";
            }
            $this->npwp->ExportHrefValue = GetFileUploadUrl($this->npwp, $this->id->CurrentValue);
            $this->npwp->TooltipValue = "";

            // idprov
            $this->idprov->LinkCustomAttributes = "";
            $this->idprov->HrefValue = "";
            $this->idprov->TooltipValue = "";

            // idkab
            $this->idkab->LinkCustomAttributes = "";
            $this->idkab->HrefValue = "";
            $this->idkab->TooltipValue = "";

            // idkec
            $this->idkec->LinkCustomAttributes = "";
            $this->idkec->HrefValue = "";
            $this->idkec->TooltipValue = "";

            // idkel
            $this->idkel->LinkCustomAttributes = "";
            $this->idkel->HrefValue = "";
            $this->idkel->TooltipValue = "";

            // kodepos
            $this->kodepos->LinkCustomAttributes = "";
            $this->kodepos->HrefValue = "";
            $this->kodepos->TooltipValue = "";

            // alamat
            $this->alamat->LinkCustomAttributes = "";
            $this->alamat->HrefValue = "";
            $this->alamat->TooltipValue = "";

            // telpon
            $this->telpon->LinkCustomAttributes = "";
            $this->telpon->HrefValue = "";
            $this->telpon->TooltipValue = "";

            // hp
            $this->hp->LinkCustomAttributes = "";
            $this->hp->HrefValue = "";
            $this->hp->TooltipValue = "";

            // email
            $this->_email->LinkCustomAttributes = "";
            $this->_email->HrefValue = "";
            $this->_email->TooltipValue = "";

            // website
            $this->website->LinkCustomAttributes = "";
            $this->website->HrefValue = "";
            $this->website->TooltipValue = "";

            // foto
            $this->foto->LinkCustomAttributes = "";
            if (!EmptyValue($this->foto->Upload->DbValue)) {
                $this->foto->HrefValue = "%u"; // Add prefix/suffix
                $this->foto->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->foto->HrefValue = FullUrl($this->foto->HrefValue, "href");
                }
            } else {
                $this->foto->HrefValue = "";
            }
            $this->foto->ExportHrefValue = $this->foto->UploadPath . $this->foto->Upload->DbValue;
            $this->foto->TooltipValue = "";
            if ($this->foto->UseColorbox) {
                if (EmptyValue($this->foto->TooltipValue)) {
                    $this->foto->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
                }
                $this->foto->LinkAttrs["data-rel"] = "customer_x_foto";
                $this->foto->LinkAttrs->appendClass("ew-lightbox");
            }

            // limit_kredit_order
            $this->limit_kredit_order->LinkCustomAttributes = "";
            $this->limit_kredit_order->HrefValue = "";
            $this->limit_kredit_order->TooltipValue = "";

            // jatuh_tempo_invoice
            $this->jatuh_tempo_invoice->LinkCustomAttributes = "";
            $this->jatuh_tempo_invoice->HrefValue = "";
            $this->jatuh_tempo_invoice->TooltipValue = "";

            // keterangan
            $this->keterangan->LinkCustomAttributes = "";
            $this->keterangan->HrefValue = "";
            $this->keterangan->TooltipValue = "";

            // aktif
            $this->aktif->LinkCustomAttributes = "";
            $this->aktif->HrefValue = "";
            $this->aktif->TooltipValue = "";

            // created_at
            $this->created_at->LinkCustomAttributes = "";
            $this->created_at->HrefValue = "";
            $this->created_at->TooltipValue = "";

            // updated_at
            $this->updated_at->LinkCustomAttributes = "";
            $this->updated_at->HrefValue = "";
            $this->updated_at->TooltipValue = "";

            // created_by
            $this->created_by->LinkCustomAttributes = "";
            $this->created_by->HrefValue = "";
            $this->created_by->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_SEARCH) {
            // kode
            $this->kode->EditAttrs["class"] = "form-control";
            $this->kode->EditCustomAttributes = "";
            if (!$this->kode->Raw) {
                $this->kode->AdvancedSearch->SearchValue = HtmlDecode($this->kode->AdvancedSearch->SearchValue);
            }
            $this->kode->EditValue = HtmlEncode($this->kode->AdvancedSearch->SearchValue);
            $this->kode->PlaceHolder = RemoveHtml($this->kode->caption());

            // idtipecustomer
            $this->idtipecustomer->EditAttrs["class"] = "form-control";
            $this->idtipecustomer->EditCustomAttributes = "";
            $curVal = trim(strval($this->idtipecustomer->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->idtipecustomer->AdvancedSearch->ViewValue = $this->idtipecustomer->lookupCacheOption($curVal);
            } else {
                $this->idtipecustomer->AdvancedSearch->ViewValue = $this->idtipecustomer->Lookup !== null && is_array($this->idtipecustomer->Lookup->Options) ? $curVal : null;
            }
            if ($this->idtipecustomer->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->idtipecustomer->EditValue = array_values($this->idtipecustomer->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idtipecustomer->AdvancedSearch->SearchValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->idtipecustomer->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idtipecustomer->EditValue = $arwrk;
            }
            $this->idtipecustomer->PlaceHolder = RemoveHtml($this->idtipecustomer->caption());

            // idpegawai
            $this->idpegawai->EditAttrs["class"] = "form-control";
            $this->idpegawai->EditCustomAttributes = "";
            $curVal = trim(strval($this->idpegawai->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->idpegawai->AdvancedSearch->ViewValue = $this->idpegawai->lookupCacheOption($curVal);
            } else {
                $this->idpegawai->AdvancedSearch->ViewValue = $this->idpegawai->Lookup !== null && is_array($this->idpegawai->Lookup->Options) ? $curVal : null;
            }
            if ($this->idpegawai->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->idpegawai->EditValue = array_values($this->idpegawai->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idpegawai->AdvancedSearch->SearchValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->idpegawai->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idpegawai->EditValue = $arwrk;
            }
            $this->idpegawai->PlaceHolder = RemoveHtml($this->idpegawai->caption());

            // nama
            $this->nama->EditAttrs["class"] = "form-control";
            $this->nama->EditCustomAttributes = "";
            if (!$this->nama->Raw) {
                $this->nama->AdvancedSearch->SearchValue = HtmlDecode($this->nama->AdvancedSearch->SearchValue);
            }
            $this->nama->EditValue = HtmlEncode($this->nama->AdvancedSearch->SearchValue);
            $this->nama->PlaceHolder = RemoveHtml($this->nama->caption());

            // kodenpd
            $this->kodenpd->EditAttrs["class"] = "form-control";
            $this->kodenpd->EditCustomAttributes = "";
            if (!$this->kodenpd->Raw) {
                $this->kodenpd->AdvancedSearch->SearchValue = HtmlDecode($this->kodenpd->AdvancedSearch->SearchValue);
            }
            $this->kodenpd->EditValue = HtmlEncode($this->kodenpd->AdvancedSearch->SearchValue);
            $this->kodenpd->PlaceHolder = RemoveHtml($this->kodenpd->caption());

            // usaha
            $this->usaha->EditAttrs["class"] = "form-control";
            $this->usaha->EditCustomAttributes = "";
            if (!$this->usaha->Raw) {
                $this->usaha->AdvancedSearch->SearchValue = HtmlDecode($this->usaha->AdvancedSearch->SearchValue);
            }
            $this->usaha->EditValue = HtmlEncode($this->usaha->AdvancedSearch->SearchValue);
            $this->usaha->PlaceHolder = RemoveHtml($this->usaha->caption());

            // jabatan
            $this->jabatan->EditAttrs["class"] = "form-control";
            $this->jabatan->EditCustomAttributes = "";
            if (!$this->jabatan->Raw) {
                $this->jabatan->AdvancedSearch->SearchValue = HtmlDecode($this->jabatan->AdvancedSearch->SearchValue);
            }
            $this->jabatan->EditValue = HtmlEncode($this->jabatan->AdvancedSearch->SearchValue);
            $this->jabatan->PlaceHolder = RemoveHtml($this->jabatan->caption());

            // ktp
            $this->ktp->EditAttrs["class"] = "form-control";
            $this->ktp->EditCustomAttributes = "";
            if (!EmptyValue($this->ktp->Upload->DbValue)) {
                $this->ktp->EditValue = $this->id->CurrentValue;
                $this->ktp->IsBlobImage = IsImageFile(ContentExtension($this->ktp->Upload->DbValue));
                $this->ktp->Upload->FileName = $this->ktp->CurrentValue;
            } else {
                $this->ktp->EditValue = "";
            }
            if (!EmptyValue($this->ktp->CurrentValue)) {
                $this->ktp->Upload->FileName = $this->ktp->CurrentValue;
            }

            // npwp
            $this->npwp->EditAttrs["class"] = "form-control";
            $this->npwp->EditCustomAttributes = "";
            if (!EmptyValue($this->npwp->Upload->DbValue)) {
                $this->npwp->EditValue = $this->id->CurrentValue;
                $this->npwp->IsBlobImage = IsImageFile(ContentExtension($this->npwp->Upload->DbValue));
                $this->npwp->Upload->FileName = $this->npwp->CurrentValue;
            } else {
                $this->npwp->EditValue = "";
            }
            if (!EmptyValue($this->npwp->CurrentValue)) {
                $this->npwp->Upload->FileName = $this->npwp->CurrentValue;
            }

            // idprov
            $this->idprov->EditAttrs["class"] = "form-control";
            $this->idprov->EditCustomAttributes = "";
            $curVal = trim(strval($this->idprov->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->idprov->AdvancedSearch->ViewValue = $this->idprov->lookupCacheOption($curVal);
            } else {
                $this->idprov->AdvancedSearch->ViewValue = $this->idprov->Lookup !== null && is_array($this->idprov->Lookup->Options) ? $curVal : null;
            }
            if ($this->idprov->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->idprov->EditValue = array_values($this->idprov->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idprov->AdvancedSearch->SearchValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->idprov->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idprov->EditValue = $arwrk;
            }
            $this->idprov->PlaceHolder = RemoveHtml($this->idprov->caption());

            // idkab
            $this->idkab->EditAttrs["class"] = "form-control";
            $this->idkab->EditCustomAttributes = "";
            $curVal = trim(strval($this->idkab->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->idkab->AdvancedSearch->ViewValue = $this->idkab->lookupCacheOption($curVal);
            } else {
                $this->idkab->AdvancedSearch->ViewValue = $this->idkab->Lookup !== null && is_array($this->idkab->Lookup->Options) ? $curVal : null;
            }
            if ($this->idkab->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->idkab->EditValue = array_values($this->idkab->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idkab->AdvancedSearch->SearchValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->idkab->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idkab->EditValue = $arwrk;
            }
            $this->idkab->PlaceHolder = RemoveHtml($this->idkab->caption());

            // idkec
            $this->idkec->EditAttrs["class"] = "form-control";
            $this->idkec->EditCustomAttributes = "";
            $curVal = trim(strval($this->idkec->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->idkec->AdvancedSearch->ViewValue = $this->idkec->lookupCacheOption($curVal);
            } else {
                $this->idkec->AdvancedSearch->ViewValue = $this->idkec->Lookup !== null && is_array($this->idkec->Lookup->Options) ? $curVal : null;
            }
            if ($this->idkec->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->idkec->EditValue = array_values($this->idkec->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idkec->AdvancedSearch->SearchValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->idkec->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idkec->EditValue = $arwrk;
            }
            $this->idkec->PlaceHolder = RemoveHtml($this->idkec->caption());

            // idkel
            $this->idkel->EditAttrs["class"] = "form-control";
            $this->idkel->EditCustomAttributes = "";
            $curVal = trim(strval($this->idkel->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->idkel->AdvancedSearch->ViewValue = $this->idkel->lookupCacheOption($curVal);
            } else {
                $this->idkel->AdvancedSearch->ViewValue = $this->idkel->Lookup !== null && is_array($this->idkel->Lookup->Options) ? $curVal : null;
            }
            if ($this->idkel->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->idkel->EditValue = array_values($this->idkel->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idkel->AdvancedSearch->SearchValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->idkel->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idkel->EditValue = $arwrk;
            }
            $this->idkel->PlaceHolder = RemoveHtml($this->idkel->caption());

            // kodepos
            $this->kodepos->EditAttrs["class"] = "form-control";
            $this->kodepos->EditCustomAttributes = "";
            if (!$this->kodepos->Raw) {
                $this->kodepos->AdvancedSearch->SearchValue = HtmlDecode($this->kodepos->AdvancedSearch->SearchValue);
            }
            $this->kodepos->EditValue = HtmlEncode($this->kodepos->AdvancedSearch->SearchValue);
            $this->kodepos->PlaceHolder = RemoveHtml($this->kodepos->caption());

            // alamat
            $this->alamat->EditAttrs["class"] = "form-control";
            $this->alamat->EditCustomAttributes = "";
            if (!$this->alamat->Raw) {
                $this->alamat->AdvancedSearch->SearchValue = HtmlDecode($this->alamat->AdvancedSearch->SearchValue);
            }
            $this->alamat->EditValue = HtmlEncode($this->alamat->AdvancedSearch->SearchValue);
            $this->alamat->PlaceHolder = RemoveHtml($this->alamat->caption());

            // telpon
            $this->telpon->EditAttrs["class"] = "form-control";
            $this->telpon->EditCustomAttributes = "";
            if (!$this->telpon->Raw) {
                $this->telpon->AdvancedSearch->SearchValue = HtmlDecode($this->telpon->AdvancedSearch->SearchValue);
            }
            $this->telpon->EditValue = HtmlEncode($this->telpon->AdvancedSearch->SearchValue);
            $this->telpon->PlaceHolder = RemoveHtml($this->telpon->caption());

            // hp
            $this->hp->EditAttrs["class"] = "form-control";
            $this->hp->EditCustomAttributes = "";
            if (!$this->hp->Raw) {
                $this->hp->AdvancedSearch->SearchValue = HtmlDecode($this->hp->AdvancedSearch->SearchValue);
            }
            $this->hp->EditValue = HtmlEncode($this->hp->AdvancedSearch->SearchValue);
            $this->hp->PlaceHolder = RemoveHtml($this->hp->caption());

            // email
            $this->_email->EditAttrs["class"] = "form-control";
            $this->_email->EditCustomAttributes = "";
            if (!$this->_email->Raw) {
                $this->_email->AdvancedSearch->SearchValue = HtmlDecode($this->_email->AdvancedSearch->SearchValue);
            }
            $this->_email->EditValue = HtmlEncode($this->_email->AdvancedSearch->SearchValue);
            $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

            // website
            $this->website->EditAttrs["class"] = "form-control";
            $this->website->EditCustomAttributes = "";
            if (!$this->website->Raw) {
                $this->website->AdvancedSearch->SearchValue = HtmlDecode($this->website->AdvancedSearch->SearchValue);
            }
            $this->website->EditValue = HtmlEncode($this->website->AdvancedSearch->SearchValue);
            $this->website->PlaceHolder = RemoveHtml($this->website->caption());

            // foto
            $this->foto->EditAttrs["class"] = "form-control";
            $this->foto->EditCustomAttributes = "";
            if (!$this->foto->Raw) {
                $this->foto->AdvancedSearch->SearchValue = HtmlDecode($this->foto->AdvancedSearch->SearchValue);
            }
            $this->foto->EditValue = HtmlEncode($this->foto->AdvancedSearch->SearchValue);
            $this->foto->PlaceHolder = RemoveHtml($this->foto->caption());

            // limit_kredit_order
            $this->limit_kredit_order->EditAttrs["class"] = "form-control";
            $this->limit_kredit_order->EditCustomAttributes = "";
            $this->limit_kredit_order->EditValue = HtmlEncode($this->limit_kredit_order->AdvancedSearch->SearchValue);
            $this->limit_kredit_order->PlaceHolder = RemoveHtml($this->limit_kredit_order->caption());

            // jatuh_tempo_invoice
            $this->jatuh_tempo_invoice->EditAttrs["class"] = "form-control";
            $this->jatuh_tempo_invoice->EditCustomAttributes = "";
            $curVal = trim(strval($this->jatuh_tempo_invoice->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->jatuh_tempo_invoice->AdvancedSearch->ViewValue = $this->jatuh_tempo_invoice->lookupCacheOption($curVal);
            } else {
                $this->jatuh_tempo_invoice->AdvancedSearch->ViewValue = $this->jatuh_tempo_invoice->Lookup !== null && is_array($this->jatuh_tempo_invoice->Lookup->Options) ? $curVal : null;
            }
            if ($this->jatuh_tempo_invoice->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->jatuh_tempo_invoice->EditValue = array_values($this->jatuh_tempo_invoice->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->jatuh_tempo_invoice->AdvancedSearch->SearchValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->jatuh_tempo_invoice->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->jatuh_tempo_invoice->EditValue = $arwrk;
            }
            $this->jatuh_tempo_invoice->PlaceHolder = RemoveHtml($this->jatuh_tempo_invoice->caption());

            // keterangan
            $this->keterangan->EditAttrs["class"] = "form-control";
            $this->keterangan->EditCustomAttributes = "";
            $this->keterangan->EditValue = HtmlEncode($this->keterangan->AdvancedSearch->SearchValue);
            $this->keterangan->PlaceHolder = RemoveHtml($this->keterangan->caption());

            // aktif
            $this->aktif->EditCustomAttributes = "";
            $this->aktif->EditValue = $this->aktif->options(false);
            $this->aktif->PlaceHolder = RemoveHtml($this->aktif->caption());

            // created_at
            $this->created_at->EditAttrs["class"] = "form-control";
            $this->created_at->EditCustomAttributes = "";
            $this->created_at->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->created_at->AdvancedSearch->SearchValue, 0), 8));
            $this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());

            // updated_at
            $this->updated_at->EditAttrs["class"] = "form-control";
            $this->updated_at->EditCustomAttributes = "";
            $this->updated_at->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->updated_at->AdvancedSearch->SearchValue, 0), 8));
            $this->updated_at->PlaceHolder = RemoveHtml($this->updated_at->caption());

            // created_by
            $this->created_by->EditAttrs["class"] = "form-control";
            $this->created_by->EditCustomAttributes = "";
            $this->created_by->EditValue = HtmlEncode($this->created_by->AdvancedSearch->SearchValue);
            $this->created_by->PlaceHolder = RemoveHtml($this->created_by->caption());
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate search
    protected function validateSearch()
    {
        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        if (!CheckByRegEx($this->hp->AdvancedSearch->SearchValue, '^(62)8[1-9][0-9]{7,11}$')) {
            $this->hp->addErrorMessage($this->hp->getErrorMessage(false));
        }
        if (!CheckInteger($this->limit_kredit_order->AdvancedSearch->SearchValue)) {
            $this->limit_kredit_order->addErrorMessage($this->limit_kredit_order->getErrorMessage(false));
        }

        // Return validate result
        $validateSearch = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateSearch = $validateSearch && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateSearch;
    }

    // Load advanced search
    public function loadAdvancedSearch()
    {
        $this->kode->AdvancedSearch->load();
        $this->idtipecustomer->AdvancedSearch->load();
        $this->idpegawai->AdvancedSearch->load();
        $this->nama->AdvancedSearch->load();
        $this->kodenpd->AdvancedSearch->load();
        $this->usaha->AdvancedSearch->load();
        $this->jabatan->AdvancedSearch->load();
        $this->idprov->AdvancedSearch->load();
        $this->idkab->AdvancedSearch->load();
        $this->idkec->AdvancedSearch->load();
        $this->idkel->AdvancedSearch->load();
        $this->kodepos->AdvancedSearch->load();
        $this->alamat->AdvancedSearch->load();
        $this->telpon->AdvancedSearch->load();
        $this->hp->AdvancedSearch->load();
        $this->_email->AdvancedSearch->load();
        $this->website->AdvancedSearch->load();
        $this->foto->AdvancedSearch->load();
        $this->limit_kredit_order->AdvancedSearch->load();
        $this->jatuh_tempo_invoice->AdvancedSearch->load();
        $this->keterangan->AdvancedSearch->load();
        $this->aktif->AdvancedSearch->load();
        $this->created_at->AdvancedSearch->load();
        $this->updated_at->AdvancedSearch->load();
        $this->created_by->AdvancedSearch->load();
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("CustomerList"), "", $this->TableVar, true);
        $pageId = "search";
        $Breadcrumb->add("search", $pageId, $url);
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
                case "x_idtipecustomer":
                    break;
                case "x_idpegawai":
                    break;
                case "x_idprov":
                    break;
                case "x_idkab":
                    break;
                case "x_idkec":
                    break;
                case "x_idkel":
                    break;
                case "x_level_customer_id":
                    break;
                case "x_jatuh_tempo_invoice":
                    break;
                case "x_aktif":
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

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in CustomError
        return true;
    }
}
