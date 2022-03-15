<?php

namespace PHPMaker2021\production2;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class NpdHargaAdd extends NpdHarga
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'npd_harga';

    // Page object name
    public $PageObjName = "NpdHargaAdd";

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

        // Custom template
        $this->UseCustomTemplate = true;

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
        if (Post("customexport") === null) {
             // Page Unload event
            if (method_exists($this, "pageUnload")) {
                $this->pageUnload();
            }

            // Global Page Unloaded event (in userfn*.php)
            Page_Unloaded();
        }

        // Export
        if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
            if (is_array(Session(SESSION_TEMP_IMAGES))) { // Restore temp images
                $TempImages = Session(SESSION_TEMP_IMAGES);
            }
            if (Post("data") !== null) {
                $content = Post("data");
            }
            $ExportFileName = Post("filename", "");
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
        if ($this->CustomExport) { // Save temp images array for custom export
            if (is_array($TempImages)) {
                $_SESSION[SESSION_TEMP_IMAGES] = $TempImages;
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
                    if ($pageName == "NpdHargaView") {
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
    public $FormClassName = "ew-horizontal ew-form ew-add-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $Priv = 0;
    public $OldRecordset;
    public $CopyRecord;

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
        $this->idnpd->setVisibility();
        $this->tglpengajuan->setVisibility();
        $this->idnpd_sample->setVisibility();
        $this->nama->setVisibility();
        $this->bentuk->setVisibility();
        $this->viskositas->setVisibility();
        $this->warna->setVisibility();
        $this->bauparfum->setVisibility();
        $this->aplikasisediaan->setVisibility();
        $this->volume->setVisibility();
        $this->bahanaktif->setVisibility();
        $this->volumewadah->setVisibility();
        $this->bahanwadah->setVisibility();
        $this->warnawadah->setVisibility();
        $this->bentukwadah->setVisibility();
        $this->jenistutup->setVisibility();
        $this->bahantutup->setVisibility();
        $this->warnatutup->setVisibility();
        $this->bentuktutup->setVisibility();
        $this->segel->setVisibility();
        $this->catatanprimer->setVisibility();
        $this->packingproduk->setVisibility();
        $this->keteranganpacking->setVisibility();
        $this->beltkarton->setVisibility();
        $this->keteranganbelt->setVisibility();
        $this->kartonluar->setVisibility();
        $this->bariskarton->setVisibility();
        $this->kolomkarton->setVisibility();
        $this->stackkarton->setVisibility();
        $this->isikarton->setVisibility();
        $this->jenislabel->setVisibility();
        $this->keteranganjenislabel->setVisibility();
        $this->kualitaslabel->setVisibility();
        $this->jumlahwarnalabel->setVisibility();
        $this->metaliklabel->setVisibility();
        $this->etiketlabel->setVisibility();
        $this->keteranganlabel->setVisibility();
        $this->kategoridelivery->setVisibility();
        $this->alamatpengiriman->setVisibility();
        $this->orderperdana->setVisibility();
        $this->orderkontrak->setVisibility();
        $this->hargaperpcs->setVisibility();
        $this->hargaperkarton->setVisibility();
        $this->lampiran->setVisibility();
        $this->prepared_by->setVisibility();
        $this->checked_by->setVisibility();
        $this->approved_by->setVisibility();
        $this->approved_date->Visible = false;
        $this->disetujui->setVisibility();
        $this->created_at->Visible = false;
        $this->readonly->Visible = false;
        $this->updated_at->setVisibility();
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

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-add-form ew-horizontal";
        $postBack = false;

        // Set up current action
        if (IsApi()) {
            $this->CurrentAction = "insert"; // Add record directly
            $postBack = true;
        } elseif (Post("action") !== null) {
            $this->CurrentAction = Post("action"); // Get form action
            $this->setKey(Post($this->OldKeyName));
            $postBack = true;
        } else {
            // Load key values from QueryString
            if (($keyValue = Get("id") ?? Route("id")) !== null) {
                $this->id->setQueryStringValue($keyValue);
            }
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $this->CopyRecord = !EmptyValue($this->OldKey);
            if ($this->CopyRecord) {
                $this->CurrentAction = "copy"; // Copy record
            } else {
                $this->CurrentAction = "show"; // Display blank record
            }
        }

        // Load old record / default values
        $loaded = $this->loadOldRecord();

        // Set up master/detail parameters
        // NOTE: must be after loadOldRecord to prevent master key values overwritten
        $this->setupMasterParms();

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues(); // Restore form values
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = "show"; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "copy": // Copy an existing record
                if (!$loaded) { // Record not loaded
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("NpdHargaList"); // No matching record, return to list
                    return;
                }
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($this->OldRecordset)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = $this->getReturnUrl();
                    if (GetPageName($returnUrl) == "NpdHargaList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "NpdHargaView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }
                    if (IsApi()) { // Return to caller
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl);
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Add failed, restore form values
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render row based on row type
        $this->RowType = ROWTYPE_ADD; // Render add type

        // Render row
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

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
        $this->lampiran->Upload->Index = $CurrentForm->Index;
        $this->lampiran->Upload->uploadFile();
        $this->lampiran->CurrentValue = $this->lampiran->Upload->FileName;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->id->CurrentValue = null;
        $this->id->OldValue = $this->id->CurrentValue;
        $this->idnpd->CurrentValue = null;
        $this->idnpd->OldValue = $this->idnpd->CurrentValue;
        $this->tglpengajuan->CurrentValue = CurrentDate();
        $this->idnpd_sample->CurrentValue = null;
        $this->idnpd_sample->OldValue = $this->idnpd_sample->CurrentValue;
        $this->nama->CurrentValue = null;
        $this->nama->OldValue = $this->nama->CurrentValue;
        $this->bentuk->CurrentValue = null;
        $this->bentuk->OldValue = $this->bentuk->CurrentValue;
        $this->viskositas->CurrentValue = null;
        $this->viskositas->OldValue = $this->viskositas->CurrentValue;
        $this->warna->CurrentValue = null;
        $this->warna->OldValue = $this->warna->CurrentValue;
        $this->bauparfum->CurrentValue = null;
        $this->bauparfum->OldValue = $this->bauparfum->CurrentValue;
        $this->aplikasisediaan->CurrentValue = null;
        $this->aplikasisediaan->OldValue = $this->aplikasisediaan->CurrentValue;
        $this->volume->CurrentValue = null;
        $this->volume->OldValue = $this->volume->CurrentValue;
        $this->bahanaktif->CurrentValue = null;
        $this->bahanaktif->OldValue = $this->bahanaktif->CurrentValue;
        $this->volumewadah->CurrentValue = null;
        $this->volumewadah->OldValue = $this->volumewadah->CurrentValue;
        $this->bahanwadah->CurrentValue = null;
        $this->bahanwadah->OldValue = $this->bahanwadah->CurrentValue;
        $this->warnawadah->CurrentValue = null;
        $this->warnawadah->OldValue = $this->warnawadah->CurrentValue;
        $this->bentukwadah->CurrentValue = null;
        $this->bentukwadah->OldValue = $this->bentukwadah->CurrentValue;
        $this->jenistutup->CurrentValue = null;
        $this->jenistutup->OldValue = $this->jenistutup->CurrentValue;
        $this->bahantutup->CurrentValue = null;
        $this->bahantutup->OldValue = $this->bahantutup->CurrentValue;
        $this->warnatutup->CurrentValue = null;
        $this->warnatutup->OldValue = $this->warnatutup->CurrentValue;
        $this->bentuktutup->CurrentValue = null;
        $this->bentuktutup->OldValue = $this->bentuktutup->CurrentValue;
        $this->segel->CurrentValue = 1;
        $this->catatanprimer->CurrentValue = null;
        $this->catatanprimer->OldValue = $this->catatanprimer->CurrentValue;
        $this->packingproduk->CurrentValue = null;
        $this->packingproduk->OldValue = $this->packingproduk->CurrentValue;
        $this->keteranganpacking->CurrentValue = null;
        $this->keteranganpacking->OldValue = $this->keteranganpacking->CurrentValue;
        $this->beltkarton->CurrentValue = null;
        $this->beltkarton->OldValue = $this->beltkarton->CurrentValue;
        $this->keteranganbelt->CurrentValue = null;
        $this->keteranganbelt->OldValue = $this->keteranganbelt->CurrentValue;
        $this->kartonluar->CurrentValue = null;
        $this->kartonluar->OldValue = $this->kartonluar->CurrentValue;
        $this->bariskarton->CurrentValue = null;
        $this->bariskarton->OldValue = $this->bariskarton->CurrentValue;
        $this->kolomkarton->CurrentValue = null;
        $this->kolomkarton->OldValue = $this->kolomkarton->CurrentValue;
        $this->stackkarton->CurrentValue = null;
        $this->stackkarton->OldValue = $this->stackkarton->CurrentValue;
        $this->isikarton->CurrentValue = null;
        $this->isikarton->OldValue = $this->isikarton->CurrentValue;
        $this->jenislabel->CurrentValue = null;
        $this->jenislabel->OldValue = $this->jenislabel->CurrentValue;
        $this->keteranganjenislabel->CurrentValue = null;
        $this->keteranganjenislabel->OldValue = $this->keteranganjenislabel->CurrentValue;
        $this->kualitaslabel->CurrentValue = null;
        $this->kualitaslabel->OldValue = $this->kualitaslabel->CurrentValue;
        $this->jumlahwarnalabel->CurrentValue = null;
        $this->jumlahwarnalabel->OldValue = $this->jumlahwarnalabel->CurrentValue;
        $this->metaliklabel->CurrentValue = null;
        $this->metaliklabel->OldValue = $this->metaliklabel->CurrentValue;
        $this->etiketlabel->CurrentValue = null;
        $this->etiketlabel->OldValue = $this->etiketlabel->CurrentValue;
        $this->keteranganlabel->CurrentValue = null;
        $this->keteranganlabel->OldValue = $this->keteranganlabel->CurrentValue;
        $this->kategoridelivery->CurrentValue = null;
        $this->kategoridelivery->OldValue = $this->kategoridelivery->CurrentValue;
        $this->alamatpengiriman->CurrentValue = null;
        $this->alamatpengiriman->OldValue = $this->alamatpengiriman->CurrentValue;
        $this->orderperdana->CurrentValue = null;
        $this->orderperdana->OldValue = $this->orderperdana->CurrentValue;
        $this->orderkontrak->CurrentValue = null;
        $this->orderkontrak->OldValue = $this->orderkontrak->CurrentValue;
        $this->hargaperpcs->CurrentValue = null;
        $this->hargaperpcs->OldValue = $this->hargaperpcs->CurrentValue;
        $this->hargaperkarton->CurrentValue = null;
        $this->hargaperkarton->OldValue = $this->hargaperkarton->CurrentValue;
        $this->lampiran->Upload->DbValue = null;
        $this->lampiran->OldValue = $this->lampiran->Upload->DbValue;
        $this->lampiran->CurrentValue = null; // Clear file related field
        $this->prepared_by->CurrentValue = null;
        $this->prepared_by->OldValue = $this->prepared_by->CurrentValue;
        $this->checked_by->CurrentValue = null;
        $this->checked_by->OldValue = $this->checked_by->CurrentValue;
        $this->approved_by->CurrentValue = null;
        $this->approved_by->OldValue = $this->approved_by->CurrentValue;
        $this->approved_date->CurrentValue = null;
        $this->approved_date->OldValue = $this->approved_date->CurrentValue;
        $this->disetujui->CurrentValue = 1;
        $this->created_at->CurrentValue = null;
        $this->created_at->OldValue = $this->created_at->CurrentValue;
        $this->readonly->CurrentValue = 0;
        $this->updated_at->CurrentValue = null;
        $this->updated_at->OldValue = $this->updated_at->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'idnpd' first before field var 'x_idnpd'
        $val = $CurrentForm->hasValue("idnpd") ? $CurrentForm->getValue("idnpd") : $CurrentForm->getValue("x_idnpd");
        if (!$this->idnpd->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idnpd->Visible = false; // Disable update for API request
            } else {
                $this->idnpd->setFormValue($val);
            }
        }

        // Check field name 'tglpengajuan' first before field var 'x_tglpengajuan'
        $val = $CurrentForm->hasValue("tglpengajuan") ? $CurrentForm->getValue("tglpengajuan") : $CurrentForm->getValue("x_tglpengajuan");
        if (!$this->tglpengajuan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tglpengajuan->Visible = false; // Disable update for API request
            } else {
                $this->tglpengajuan->setFormValue($val);
            }
            $this->tglpengajuan->CurrentValue = UnFormatDateTime($this->tglpengajuan->CurrentValue, 0);
        }

        // Check field name 'idnpd_sample' first before field var 'x_idnpd_sample'
        $val = $CurrentForm->hasValue("idnpd_sample") ? $CurrentForm->getValue("idnpd_sample") : $CurrentForm->getValue("x_idnpd_sample");
        if (!$this->idnpd_sample->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idnpd_sample->Visible = false; // Disable update for API request
            } else {
                $this->idnpd_sample->setFormValue($val);
            }
        }

        // Check field name 'nama' first before field var 'x_nama'
        $val = $CurrentForm->hasValue("nama") ? $CurrentForm->getValue("nama") : $CurrentForm->getValue("x_nama");
        if (!$this->nama->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nama->Visible = false; // Disable update for API request
            } else {
                $this->nama->setFormValue($val);
            }
        }

        // Check field name 'bentuk' first before field var 'x_bentuk'
        $val = $CurrentForm->hasValue("bentuk") ? $CurrentForm->getValue("bentuk") : $CurrentForm->getValue("x_bentuk");
        if (!$this->bentuk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bentuk->Visible = false; // Disable update for API request
            } else {
                $this->bentuk->setFormValue($val);
            }
        }

        // Check field name 'viskositas' first before field var 'x_viskositas'
        $val = $CurrentForm->hasValue("viskositas") ? $CurrentForm->getValue("viskositas") : $CurrentForm->getValue("x_viskositas");
        if (!$this->viskositas->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->viskositas->Visible = false; // Disable update for API request
            } else {
                $this->viskositas->setFormValue($val);
            }
        }

        // Check field name 'warna' first before field var 'x_warna'
        $val = $CurrentForm->hasValue("warna") ? $CurrentForm->getValue("warna") : $CurrentForm->getValue("x_warna");
        if (!$this->warna->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->warna->Visible = false; // Disable update for API request
            } else {
                $this->warna->setFormValue($val);
            }
        }

        // Check field name 'bauparfum' first before field var 'x_bauparfum'
        $val = $CurrentForm->hasValue("bauparfum") ? $CurrentForm->getValue("bauparfum") : $CurrentForm->getValue("x_bauparfum");
        if (!$this->bauparfum->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bauparfum->Visible = false; // Disable update for API request
            } else {
                $this->bauparfum->setFormValue($val);
            }
        }

        // Check field name 'aplikasisediaan' first before field var 'x_aplikasisediaan'
        $val = $CurrentForm->hasValue("aplikasisediaan") ? $CurrentForm->getValue("aplikasisediaan") : $CurrentForm->getValue("x_aplikasisediaan");
        if (!$this->aplikasisediaan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->aplikasisediaan->Visible = false; // Disable update for API request
            } else {
                $this->aplikasisediaan->setFormValue($val);
            }
        }

        // Check field name 'volume' first before field var 'x_volume'
        $val = $CurrentForm->hasValue("volume") ? $CurrentForm->getValue("volume") : $CurrentForm->getValue("x_volume");
        if (!$this->volume->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->volume->Visible = false; // Disable update for API request
            } else {
                $this->volume->setFormValue($val);
            }
        }

        // Check field name 'bahanaktif' first before field var 'x_bahanaktif'
        $val = $CurrentForm->hasValue("bahanaktif") ? $CurrentForm->getValue("bahanaktif") : $CurrentForm->getValue("x_bahanaktif");
        if (!$this->bahanaktif->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bahanaktif->Visible = false; // Disable update for API request
            } else {
                $this->bahanaktif->setFormValue($val);
            }
        }

        // Check field name 'volumewadah' first before field var 'x_volumewadah'
        $val = $CurrentForm->hasValue("volumewadah") ? $CurrentForm->getValue("volumewadah") : $CurrentForm->getValue("x_volumewadah");
        if (!$this->volumewadah->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->volumewadah->Visible = false; // Disable update for API request
            } else {
                $this->volumewadah->setFormValue($val);
            }
        }

        // Check field name 'bahanwadah' first before field var 'x_bahanwadah'
        $val = $CurrentForm->hasValue("bahanwadah") ? $CurrentForm->getValue("bahanwadah") : $CurrentForm->getValue("x_bahanwadah");
        if (!$this->bahanwadah->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bahanwadah->Visible = false; // Disable update for API request
            } else {
                $this->bahanwadah->setFormValue($val);
            }
        }

        // Check field name 'warnawadah' first before field var 'x_warnawadah'
        $val = $CurrentForm->hasValue("warnawadah") ? $CurrentForm->getValue("warnawadah") : $CurrentForm->getValue("x_warnawadah");
        if (!$this->warnawadah->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->warnawadah->Visible = false; // Disable update for API request
            } else {
                $this->warnawadah->setFormValue($val);
            }
        }

        // Check field name 'bentukwadah' first before field var 'x_bentukwadah'
        $val = $CurrentForm->hasValue("bentukwadah") ? $CurrentForm->getValue("bentukwadah") : $CurrentForm->getValue("x_bentukwadah");
        if (!$this->bentukwadah->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bentukwadah->Visible = false; // Disable update for API request
            } else {
                $this->bentukwadah->setFormValue($val);
            }
        }

        // Check field name 'jenistutup' first before field var 'x_jenistutup'
        $val = $CurrentForm->hasValue("jenistutup") ? $CurrentForm->getValue("jenistutup") : $CurrentForm->getValue("x_jenistutup");
        if (!$this->jenistutup->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jenistutup->Visible = false; // Disable update for API request
            } else {
                $this->jenistutup->setFormValue($val);
            }
        }

        // Check field name 'bahantutup' first before field var 'x_bahantutup'
        $val = $CurrentForm->hasValue("bahantutup") ? $CurrentForm->getValue("bahantutup") : $CurrentForm->getValue("x_bahantutup");
        if (!$this->bahantutup->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bahantutup->Visible = false; // Disable update for API request
            } else {
                $this->bahantutup->setFormValue($val);
            }
        }

        // Check field name 'warnatutup' first before field var 'x_warnatutup'
        $val = $CurrentForm->hasValue("warnatutup") ? $CurrentForm->getValue("warnatutup") : $CurrentForm->getValue("x_warnatutup");
        if (!$this->warnatutup->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->warnatutup->Visible = false; // Disable update for API request
            } else {
                $this->warnatutup->setFormValue($val);
            }
        }

        // Check field name 'bentuktutup' first before field var 'x_bentuktutup'
        $val = $CurrentForm->hasValue("bentuktutup") ? $CurrentForm->getValue("bentuktutup") : $CurrentForm->getValue("x_bentuktutup");
        if (!$this->bentuktutup->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bentuktutup->Visible = false; // Disable update for API request
            } else {
                $this->bentuktutup->setFormValue($val);
            }
        }

        // Check field name 'segel' first before field var 'x_segel'
        $val = $CurrentForm->hasValue("segel") ? $CurrentForm->getValue("segel") : $CurrentForm->getValue("x_segel");
        if (!$this->segel->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->segel->Visible = false; // Disable update for API request
            } else {
                $this->segel->setFormValue($val);
            }
        }

        // Check field name 'catatanprimer' first before field var 'x_catatanprimer'
        $val = $CurrentForm->hasValue("catatanprimer") ? $CurrentForm->getValue("catatanprimer") : $CurrentForm->getValue("x_catatanprimer");
        if (!$this->catatanprimer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->catatanprimer->Visible = false; // Disable update for API request
            } else {
                $this->catatanprimer->setFormValue($val);
            }
        }

        // Check field name 'packingproduk' first before field var 'x_packingproduk'
        $val = $CurrentForm->hasValue("packingproduk") ? $CurrentForm->getValue("packingproduk") : $CurrentForm->getValue("x_packingproduk");
        if (!$this->packingproduk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->packingproduk->Visible = false; // Disable update for API request
            } else {
                $this->packingproduk->setFormValue($val);
            }
        }

        // Check field name 'keteranganpacking' first before field var 'x_keteranganpacking'
        $val = $CurrentForm->hasValue("keteranganpacking") ? $CurrentForm->getValue("keteranganpacking") : $CurrentForm->getValue("x_keteranganpacking");
        if (!$this->keteranganpacking->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->keteranganpacking->Visible = false; // Disable update for API request
            } else {
                $this->keteranganpacking->setFormValue($val);
            }
        }

        // Check field name 'beltkarton' first before field var 'x_beltkarton'
        $val = $CurrentForm->hasValue("beltkarton") ? $CurrentForm->getValue("beltkarton") : $CurrentForm->getValue("x_beltkarton");
        if (!$this->beltkarton->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->beltkarton->Visible = false; // Disable update for API request
            } else {
                $this->beltkarton->setFormValue($val);
            }
        }

        // Check field name 'keteranganbelt' first before field var 'x_keteranganbelt'
        $val = $CurrentForm->hasValue("keteranganbelt") ? $CurrentForm->getValue("keteranganbelt") : $CurrentForm->getValue("x_keteranganbelt");
        if (!$this->keteranganbelt->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->keteranganbelt->Visible = false; // Disable update for API request
            } else {
                $this->keteranganbelt->setFormValue($val);
            }
        }

        // Check field name 'kartonluar' first before field var 'x_kartonluar'
        $val = $CurrentForm->hasValue("kartonluar") ? $CurrentForm->getValue("kartonluar") : $CurrentForm->getValue("x_kartonluar");
        if (!$this->kartonluar->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kartonluar->Visible = false; // Disable update for API request
            } else {
                $this->kartonluar->setFormValue($val);
            }
        }

        // Check field name 'bariskarton' first before field var 'x_bariskarton'
        $val = $CurrentForm->hasValue("bariskarton") ? $CurrentForm->getValue("bariskarton") : $CurrentForm->getValue("x_bariskarton");
        if (!$this->bariskarton->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bariskarton->Visible = false; // Disable update for API request
            } else {
                $this->bariskarton->setFormValue($val);
            }
        }

        // Check field name 'kolomkarton' first before field var 'x_kolomkarton'
        $val = $CurrentForm->hasValue("kolomkarton") ? $CurrentForm->getValue("kolomkarton") : $CurrentForm->getValue("x_kolomkarton");
        if (!$this->kolomkarton->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kolomkarton->Visible = false; // Disable update for API request
            } else {
                $this->kolomkarton->setFormValue($val);
            }
        }

        // Check field name 'stackkarton' first before field var 'x_stackkarton'
        $val = $CurrentForm->hasValue("stackkarton") ? $CurrentForm->getValue("stackkarton") : $CurrentForm->getValue("x_stackkarton");
        if (!$this->stackkarton->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->stackkarton->Visible = false; // Disable update for API request
            } else {
                $this->stackkarton->setFormValue($val);
            }
        }

        // Check field name 'isikarton' first before field var 'x_isikarton'
        $val = $CurrentForm->hasValue("isikarton") ? $CurrentForm->getValue("isikarton") : $CurrentForm->getValue("x_isikarton");
        if (!$this->isikarton->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->isikarton->Visible = false; // Disable update for API request
            } else {
                $this->isikarton->setFormValue($val);
            }
        }

        // Check field name 'jenislabel' first before field var 'x_jenislabel'
        $val = $CurrentForm->hasValue("jenislabel") ? $CurrentForm->getValue("jenislabel") : $CurrentForm->getValue("x_jenislabel");
        if (!$this->jenislabel->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jenislabel->Visible = false; // Disable update for API request
            } else {
                $this->jenislabel->setFormValue($val);
            }
        }

        // Check field name 'keteranganjenislabel' first before field var 'x_keteranganjenislabel'
        $val = $CurrentForm->hasValue("keteranganjenislabel") ? $CurrentForm->getValue("keteranganjenislabel") : $CurrentForm->getValue("x_keteranganjenislabel");
        if (!$this->keteranganjenislabel->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->keteranganjenislabel->Visible = false; // Disable update for API request
            } else {
                $this->keteranganjenislabel->setFormValue($val);
            }
        }

        // Check field name 'kualitaslabel' first before field var 'x_kualitaslabel'
        $val = $CurrentForm->hasValue("kualitaslabel") ? $CurrentForm->getValue("kualitaslabel") : $CurrentForm->getValue("x_kualitaslabel");
        if (!$this->kualitaslabel->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kualitaslabel->Visible = false; // Disable update for API request
            } else {
                $this->kualitaslabel->setFormValue($val);
            }
        }

        // Check field name 'jumlahwarnalabel' first before field var 'x_jumlahwarnalabel'
        $val = $CurrentForm->hasValue("jumlahwarnalabel") ? $CurrentForm->getValue("jumlahwarnalabel") : $CurrentForm->getValue("x_jumlahwarnalabel");
        if (!$this->jumlahwarnalabel->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jumlahwarnalabel->Visible = false; // Disable update for API request
            } else {
                $this->jumlahwarnalabel->setFormValue($val);
            }
        }

        // Check field name 'metaliklabel' first before field var 'x_metaliklabel'
        $val = $CurrentForm->hasValue("metaliklabel") ? $CurrentForm->getValue("metaliklabel") : $CurrentForm->getValue("x_metaliklabel");
        if (!$this->metaliklabel->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->metaliklabel->Visible = false; // Disable update for API request
            } else {
                $this->metaliklabel->setFormValue($val);
            }
        }

        // Check field name 'etiketlabel' first before field var 'x_etiketlabel'
        $val = $CurrentForm->hasValue("etiketlabel") ? $CurrentForm->getValue("etiketlabel") : $CurrentForm->getValue("x_etiketlabel");
        if (!$this->etiketlabel->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->etiketlabel->Visible = false; // Disable update for API request
            } else {
                $this->etiketlabel->setFormValue($val);
            }
        }

        // Check field name 'keteranganlabel' first before field var 'x_keteranganlabel'
        $val = $CurrentForm->hasValue("keteranganlabel") ? $CurrentForm->getValue("keteranganlabel") : $CurrentForm->getValue("x_keteranganlabel");
        if (!$this->keteranganlabel->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->keteranganlabel->Visible = false; // Disable update for API request
            } else {
                $this->keteranganlabel->setFormValue($val);
            }
        }

        // Check field name 'kategoridelivery' first before field var 'x_kategoridelivery'
        $val = $CurrentForm->hasValue("kategoridelivery") ? $CurrentForm->getValue("kategoridelivery") : $CurrentForm->getValue("x_kategoridelivery");
        if (!$this->kategoridelivery->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kategoridelivery->Visible = false; // Disable update for API request
            } else {
                $this->kategoridelivery->setFormValue($val);
            }
        }

        // Check field name 'alamatpengiriman' first before field var 'x_alamatpengiriman'
        $val = $CurrentForm->hasValue("alamatpengiriman") ? $CurrentForm->getValue("alamatpengiriman") : $CurrentForm->getValue("x_alamatpengiriman");
        if (!$this->alamatpengiriman->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->alamatpengiriman->Visible = false; // Disable update for API request
            } else {
                $this->alamatpengiriman->setFormValue($val);
            }
        }

        // Check field name 'orderperdana' first before field var 'x_orderperdana'
        $val = $CurrentForm->hasValue("orderperdana") ? $CurrentForm->getValue("orderperdana") : $CurrentForm->getValue("x_orderperdana");
        if (!$this->orderperdana->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->orderperdana->Visible = false; // Disable update for API request
            } else {
                $this->orderperdana->setFormValue($val);
            }
        }

        // Check field name 'orderkontrak' first before field var 'x_orderkontrak'
        $val = $CurrentForm->hasValue("orderkontrak") ? $CurrentForm->getValue("orderkontrak") : $CurrentForm->getValue("x_orderkontrak");
        if (!$this->orderkontrak->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->orderkontrak->Visible = false; // Disable update for API request
            } else {
                $this->orderkontrak->setFormValue($val);
            }
        }

        // Check field name 'hargaperpcs' first before field var 'x_hargaperpcs'
        $val = $CurrentForm->hasValue("hargaperpcs") ? $CurrentForm->getValue("hargaperpcs") : $CurrentForm->getValue("x_hargaperpcs");
        if (!$this->hargaperpcs->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hargaperpcs->Visible = false; // Disable update for API request
            } else {
                $this->hargaperpcs->setFormValue($val);
            }
        }

        // Check field name 'hargaperkarton' first before field var 'x_hargaperkarton'
        $val = $CurrentForm->hasValue("hargaperkarton") ? $CurrentForm->getValue("hargaperkarton") : $CurrentForm->getValue("x_hargaperkarton");
        if (!$this->hargaperkarton->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hargaperkarton->Visible = false; // Disable update for API request
            } else {
                $this->hargaperkarton->setFormValue($val);
            }
        }

        // Check field name 'prepared_by' first before field var 'x_prepared_by'
        $val = $CurrentForm->hasValue("prepared_by") ? $CurrentForm->getValue("prepared_by") : $CurrentForm->getValue("x_prepared_by");
        if (!$this->prepared_by->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->prepared_by->Visible = false; // Disable update for API request
            } else {
                $this->prepared_by->setFormValue($val);
            }
        }

        // Check field name 'checked_by' first before field var 'x_checked_by'
        $val = $CurrentForm->hasValue("checked_by") ? $CurrentForm->getValue("checked_by") : $CurrentForm->getValue("x_checked_by");
        if (!$this->checked_by->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->checked_by->Visible = false; // Disable update for API request
            } else {
                $this->checked_by->setFormValue($val);
            }
        }

        // Check field name 'approved_by' first before field var 'x_approved_by'
        $val = $CurrentForm->hasValue("approved_by") ? $CurrentForm->getValue("approved_by") : $CurrentForm->getValue("x_approved_by");
        if (!$this->approved_by->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->approved_by->Visible = false; // Disable update for API request
            } else {
                $this->approved_by->setFormValue($val);
            }
        }

        // Check field name 'disetujui' first before field var 'x_disetujui'
        $val = $CurrentForm->hasValue("disetujui") ? $CurrentForm->getValue("disetujui") : $CurrentForm->getValue("x_disetujui");
        if (!$this->disetujui->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->disetujui->Visible = false; // Disable update for API request
            } else {
                $this->disetujui->setFormValue($val);
            }
        }

        // Check field name 'updated_at' first before field var 'x_updated_at'
        $val = $CurrentForm->hasValue("updated_at") ? $CurrentForm->getValue("updated_at") : $CurrentForm->getValue("x_updated_at");
        if (!$this->updated_at->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->updated_at->Visible = false; // Disable update for API request
            } else {
                $this->updated_at->setFormValue($val);
            }
            $this->updated_at->CurrentValue = UnFormatDateTime($this->updated_at->CurrentValue, 0);
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->idnpd->CurrentValue = $this->idnpd->FormValue;
        $this->tglpengajuan->CurrentValue = $this->tglpengajuan->FormValue;
        $this->tglpengajuan->CurrentValue = UnFormatDateTime($this->tglpengajuan->CurrentValue, 0);
        $this->idnpd_sample->CurrentValue = $this->idnpd_sample->FormValue;
        $this->nama->CurrentValue = $this->nama->FormValue;
        $this->bentuk->CurrentValue = $this->bentuk->FormValue;
        $this->viskositas->CurrentValue = $this->viskositas->FormValue;
        $this->warna->CurrentValue = $this->warna->FormValue;
        $this->bauparfum->CurrentValue = $this->bauparfum->FormValue;
        $this->aplikasisediaan->CurrentValue = $this->aplikasisediaan->FormValue;
        $this->volume->CurrentValue = $this->volume->FormValue;
        $this->bahanaktif->CurrentValue = $this->bahanaktif->FormValue;
        $this->volumewadah->CurrentValue = $this->volumewadah->FormValue;
        $this->bahanwadah->CurrentValue = $this->bahanwadah->FormValue;
        $this->warnawadah->CurrentValue = $this->warnawadah->FormValue;
        $this->bentukwadah->CurrentValue = $this->bentukwadah->FormValue;
        $this->jenistutup->CurrentValue = $this->jenistutup->FormValue;
        $this->bahantutup->CurrentValue = $this->bahantutup->FormValue;
        $this->warnatutup->CurrentValue = $this->warnatutup->FormValue;
        $this->bentuktutup->CurrentValue = $this->bentuktutup->FormValue;
        $this->segel->CurrentValue = $this->segel->FormValue;
        $this->catatanprimer->CurrentValue = $this->catatanprimer->FormValue;
        $this->packingproduk->CurrentValue = $this->packingproduk->FormValue;
        $this->keteranganpacking->CurrentValue = $this->keteranganpacking->FormValue;
        $this->beltkarton->CurrentValue = $this->beltkarton->FormValue;
        $this->keteranganbelt->CurrentValue = $this->keteranganbelt->FormValue;
        $this->kartonluar->CurrentValue = $this->kartonluar->FormValue;
        $this->bariskarton->CurrentValue = $this->bariskarton->FormValue;
        $this->kolomkarton->CurrentValue = $this->kolomkarton->FormValue;
        $this->stackkarton->CurrentValue = $this->stackkarton->FormValue;
        $this->isikarton->CurrentValue = $this->isikarton->FormValue;
        $this->jenislabel->CurrentValue = $this->jenislabel->FormValue;
        $this->keteranganjenislabel->CurrentValue = $this->keteranganjenislabel->FormValue;
        $this->kualitaslabel->CurrentValue = $this->kualitaslabel->FormValue;
        $this->jumlahwarnalabel->CurrentValue = $this->jumlahwarnalabel->FormValue;
        $this->metaliklabel->CurrentValue = $this->metaliklabel->FormValue;
        $this->etiketlabel->CurrentValue = $this->etiketlabel->FormValue;
        $this->keteranganlabel->CurrentValue = $this->keteranganlabel->FormValue;
        $this->kategoridelivery->CurrentValue = $this->kategoridelivery->FormValue;
        $this->alamatpengiriman->CurrentValue = $this->alamatpengiriman->FormValue;
        $this->orderperdana->CurrentValue = $this->orderperdana->FormValue;
        $this->orderkontrak->CurrentValue = $this->orderkontrak->FormValue;
        $this->hargaperpcs->CurrentValue = $this->hargaperpcs->FormValue;
        $this->hargaperkarton->CurrentValue = $this->hargaperkarton->FormValue;
        $this->prepared_by->CurrentValue = $this->prepared_by->FormValue;
        $this->checked_by->CurrentValue = $this->checked_by->FormValue;
        $this->approved_by->CurrentValue = $this->approved_by->FormValue;
        $this->disetujui->CurrentValue = $this->disetujui->FormValue;
        $this->updated_at->CurrentValue = $this->updated_at->FormValue;
        $this->updated_at->CurrentValue = UnFormatDateTime($this->updated_at->CurrentValue, 0);
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
        $this->loadDefaultValues();
        $row = [];
        $row['id'] = $this->id->CurrentValue;
        $row['idnpd'] = $this->idnpd->CurrentValue;
        $row['tglpengajuan'] = $this->tglpengajuan->CurrentValue;
        $row['idnpd_sample'] = $this->idnpd_sample->CurrentValue;
        $row['nama'] = $this->nama->CurrentValue;
        $row['bentuk'] = $this->bentuk->CurrentValue;
        $row['viskositas'] = $this->viskositas->CurrentValue;
        $row['warna'] = $this->warna->CurrentValue;
        $row['bauparfum'] = $this->bauparfum->CurrentValue;
        $row['aplikasisediaan'] = $this->aplikasisediaan->CurrentValue;
        $row['volume'] = $this->volume->CurrentValue;
        $row['bahanaktif'] = $this->bahanaktif->CurrentValue;
        $row['volumewadah'] = $this->volumewadah->CurrentValue;
        $row['bahanwadah'] = $this->bahanwadah->CurrentValue;
        $row['warnawadah'] = $this->warnawadah->CurrentValue;
        $row['bentukwadah'] = $this->bentukwadah->CurrentValue;
        $row['jenistutup'] = $this->jenistutup->CurrentValue;
        $row['bahantutup'] = $this->bahantutup->CurrentValue;
        $row['warnatutup'] = $this->warnatutup->CurrentValue;
        $row['bentuktutup'] = $this->bentuktutup->CurrentValue;
        $row['segel'] = $this->segel->CurrentValue;
        $row['catatanprimer'] = $this->catatanprimer->CurrentValue;
        $row['packingproduk'] = $this->packingproduk->CurrentValue;
        $row['keteranganpacking'] = $this->keteranganpacking->CurrentValue;
        $row['beltkarton'] = $this->beltkarton->CurrentValue;
        $row['keteranganbelt'] = $this->keteranganbelt->CurrentValue;
        $row['kartonluar'] = $this->kartonluar->CurrentValue;
        $row['bariskarton'] = $this->bariskarton->CurrentValue;
        $row['kolomkarton'] = $this->kolomkarton->CurrentValue;
        $row['stackkarton'] = $this->stackkarton->CurrentValue;
        $row['isikarton'] = $this->isikarton->CurrentValue;
        $row['jenislabel'] = $this->jenislabel->CurrentValue;
        $row['keteranganjenislabel'] = $this->keteranganjenislabel->CurrentValue;
        $row['kualitaslabel'] = $this->kualitaslabel->CurrentValue;
        $row['jumlahwarnalabel'] = $this->jumlahwarnalabel->CurrentValue;
        $row['metaliklabel'] = $this->metaliklabel->CurrentValue;
        $row['etiketlabel'] = $this->etiketlabel->CurrentValue;
        $row['keteranganlabel'] = $this->keteranganlabel->CurrentValue;
        $row['kategoridelivery'] = $this->kategoridelivery->CurrentValue;
        $row['alamatpengiriman'] = $this->alamatpengiriman->CurrentValue;
        $row['orderperdana'] = $this->orderperdana->CurrentValue;
        $row['orderkontrak'] = $this->orderkontrak->CurrentValue;
        $row['hargaperpcs'] = $this->hargaperpcs->CurrentValue;
        $row['hargaperkarton'] = $this->hargaperkarton->CurrentValue;
        $row['lampiran'] = $this->lampiran->Upload->DbValue;
        $row['prepared_by'] = $this->prepared_by->CurrentValue;
        $row['checked_by'] = $this->checked_by->CurrentValue;
        $row['approved_by'] = $this->approved_by->CurrentValue;
        $row['approved_date'] = $this->approved_date->CurrentValue;
        $row['disetujui'] = $this->disetujui->CurrentValue;
        $row['created_at'] = $this->created_at->CurrentValue;
        $row['readonly'] = $this->readonly->CurrentValue;
        $row['updated_at'] = $this->updated_at->CurrentValue;
        return $row;
    }

    // Load old record
    protected function loadOldRecord()
    {
        // Load old record
        $this->OldRecordset = null;
        $validKey = $this->OldKey != "";
        if ($validKey) {
            $this->CurrentFilter = $this->getRecordFilter();
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $this->OldRecordset = LoadRecordset($sql, $conn);
        }
        $this->loadRowValues($this->OldRecordset); // Load row values
        return $validKey;
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

            // bahanaktif
            $this->bahanaktif->ViewValue = $this->bahanaktif->CurrentValue;
            $this->bahanaktif->ViewCustomAttributes = "";

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

            // bentuk
            $this->bentuk->LinkCustomAttributes = "";
            $this->bentuk->HrefValue = "";
            $this->bentuk->TooltipValue = "";

            // viskositas
            $this->viskositas->LinkCustomAttributes = "";
            $this->viskositas->HrefValue = "";
            $this->viskositas->TooltipValue = "";

            // warna
            $this->warna->LinkCustomAttributes = "";
            $this->warna->HrefValue = "";
            $this->warna->TooltipValue = "";

            // bauparfum
            $this->bauparfum->LinkCustomAttributes = "";
            $this->bauparfum->HrefValue = "";
            $this->bauparfum->TooltipValue = "";

            // aplikasisediaan
            $this->aplikasisediaan->LinkCustomAttributes = "";
            $this->aplikasisediaan->HrefValue = "";
            $this->aplikasisediaan->TooltipValue = "";

            // volume
            $this->volume->LinkCustomAttributes = "";
            $this->volume->HrefValue = "";
            $this->volume->TooltipValue = "";

            // bahanaktif
            $this->bahanaktif->LinkCustomAttributes = "";
            $this->bahanaktif->HrefValue = "";
            $this->bahanaktif->TooltipValue = "";

            // volumewadah
            $this->volumewadah->LinkCustomAttributes = "";
            $this->volumewadah->HrefValue = "";
            $this->volumewadah->TooltipValue = "";

            // bahanwadah
            $this->bahanwadah->LinkCustomAttributes = "";
            $this->bahanwadah->HrefValue = "";
            $this->bahanwadah->TooltipValue = "";

            // warnawadah
            $this->warnawadah->LinkCustomAttributes = "";
            $this->warnawadah->HrefValue = "";
            $this->warnawadah->TooltipValue = "";

            // bentukwadah
            $this->bentukwadah->LinkCustomAttributes = "";
            $this->bentukwadah->HrefValue = "";
            $this->bentukwadah->TooltipValue = "";

            // jenistutup
            $this->jenistutup->LinkCustomAttributes = "";
            $this->jenistutup->HrefValue = "";
            $this->jenistutup->TooltipValue = "";

            // bahantutup
            $this->bahantutup->LinkCustomAttributes = "";
            $this->bahantutup->HrefValue = "";
            $this->bahantutup->TooltipValue = "";

            // warnatutup
            $this->warnatutup->LinkCustomAttributes = "";
            $this->warnatutup->HrefValue = "";
            $this->warnatutup->TooltipValue = "";

            // bentuktutup
            $this->bentuktutup->LinkCustomAttributes = "";
            $this->bentuktutup->HrefValue = "";
            $this->bentuktutup->TooltipValue = "";

            // segel
            $this->segel->LinkCustomAttributes = "";
            $this->segel->HrefValue = "";
            $this->segel->TooltipValue = "";

            // catatanprimer
            $this->catatanprimer->LinkCustomAttributes = "";
            $this->catatanprimer->HrefValue = "";
            $this->catatanprimer->TooltipValue = "";

            // packingproduk
            $this->packingproduk->LinkCustomAttributes = "";
            $this->packingproduk->HrefValue = "";
            $this->packingproduk->TooltipValue = "";

            // keteranganpacking
            $this->keteranganpacking->LinkCustomAttributes = "";
            $this->keteranganpacking->HrefValue = "";
            $this->keteranganpacking->TooltipValue = "";

            // beltkarton
            $this->beltkarton->LinkCustomAttributes = "";
            $this->beltkarton->HrefValue = "";
            $this->beltkarton->TooltipValue = "";

            // keteranganbelt
            $this->keteranganbelt->LinkCustomAttributes = "";
            $this->keteranganbelt->HrefValue = "";
            $this->keteranganbelt->TooltipValue = "";

            // kartonluar
            $this->kartonluar->LinkCustomAttributes = "";
            $this->kartonluar->HrefValue = "";
            $this->kartonluar->TooltipValue = "";

            // bariskarton
            $this->bariskarton->LinkCustomAttributes = "";
            $this->bariskarton->HrefValue = "";
            $this->bariskarton->TooltipValue = "";

            // kolomkarton
            $this->kolomkarton->LinkCustomAttributes = "";
            $this->kolomkarton->HrefValue = "";
            $this->kolomkarton->TooltipValue = "";

            // stackkarton
            $this->stackkarton->LinkCustomAttributes = "";
            $this->stackkarton->HrefValue = "";
            $this->stackkarton->TooltipValue = "";

            // isikarton
            $this->isikarton->LinkCustomAttributes = "";
            $this->isikarton->HrefValue = "";
            $this->isikarton->TooltipValue = "";

            // jenislabel
            $this->jenislabel->LinkCustomAttributes = "";
            $this->jenislabel->HrefValue = "";
            $this->jenislabel->TooltipValue = "";

            // keteranganjenislabel
            $this->keteranganjenislabel->LinkCustomAttributes = "";
            $this->keteranganjenislabel->HrefValue = "";
            $this->keteranganjenislabel->TooltipValue = "";

            // kualitaslabel
            $this->kualitaslabel->LinkCustomAttributes = "";
            $this->kualitaslabel->HrefValue = "";
            $this->kualitaslabel->TooltipValue = "";

            // jumlahwarnalabel
            $this->jumlahwarnalabel->LinkCustomAttributes = "";
            $this->jumlahwarnalabel->HrefValue = "";
            $this->jumlahwarnalabel->TooltipValue = "";

            // metaliklabel
            $this->metaliklabel->LinkCustomAttributes = "";
            $this->metaliklabel->HrefValue = "";
            $this->metaliklabel->TooltipValue = "";

            // etiketlabel
            $this->etiketlabel->LinkCustomAttributes = "";
            $this->etiketlabel->HrefValue = "";
            $this->etiketlabel->TooltipValue = "";

            // keteranganlabel
            $this->keteranganlabel->LinkCustomAttributes = "";
            $this->keteranganlabel->HrefValue = "";
            $this->keteranganlabel->TooltipValue = "";

            // kategoridelivery
            $this->kategoridelivery->LinkCustomAttributes = "";
            $this->kategoridelivery->HrefValue = "";
            $this->kategoridelivery->TooltipValue = "";

            // alamatpengiriman
            $this->alamatpengiriman->LinkCustomAttributes = "";
            $this->alamatpengiriman->HrefValue = "";
            $this->alamatpengiriman->TooltipValue = "";

            // orderperdana
            $this->orderperdana->LinkCustomAttributes = "";
            $this->orderperdana->HrefValue = "";
            $this->orderperdana->TooltipValue = "";

            // orderkontrak
            $this->orderkontrak->LinkCustomAttributes = "";
            $this->orderkontrak->HrefValue = "";
            $this->orderkontrak->TooltipValue = "";

            // hargaperpcs
            $this->hargaperpcs->LinkCustomAttributes = "";
            $this->hargaperpcs->HrefValue = "";
            $this->hargaperpcs->TooltipValue = "";

            // hargaperkarton
            $this->hargaperkarton->LinkCustomAttributes = "";
            $this->hargaperkarton->HrefValue = "";
            $this->hargaperkarton->TooltipValue = "";

            // lampiran
            $this->lampiran->LinkCustomAttributes = "";
            $this->lampiran->HrefValue = "";
            $this->lampiran->ExportHrefValue = $this->lampiran->UploadPath . $this->lampiran->Upload->DbValue;
            $this->lampiran->TooltipValue = "";

            // prepared_by
            $this->prepared_by->LinkCustomAttributes = "";
            $this->prepared_by->HrefValue = "";
            $this->prepared_by->TooltipValue = "";

            // checked_by
            $this->checked_by->LinkCustomAttributes = "";
            $this->checked_by->HrefValue = "";
            $this->checked_by->TooltipValue = "";

            // approved_by
            $this->approved_by->LinkCustomAttributes = "";
            $this->approved_by->HrefValue = "";
            $this->approved_by->TooltipValue = "";

            // disetujui
            $this->disetujui->LinkCustomAttributes = "";
            $this->disetujui->HrefValue = "";
            $this->disetujui->TooltipValue = "";

            // updated_at
            $this->updated_at->LinkCustomAttributes = "";
            $this->updated_at->HrefValue = "";
            $this->updated_at->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // idnpd
            $this->idnpd->EditAttrs["class"] = "form-control";
            $this->idnpd->EditCustomAttributes = "";
            if ($this->idnpd->getSessionValue() != "") {
                $this->idnpd->CurrentValue = GetForeignKeyValue($this->idnpd->getSessionValue());
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
            } else {
                $curVal = trim(strval($this->idnpd->CurrentValue));
                if ($curVal != "") {
                    $this->idnpd->ViewValue = $this->idnpd->lookupCacheOption($curVal);
                } else {
                    $this->idnpd->ViewValue = $this->idnpd->Lookup !== null && is_array($this->idnpd->Lookup->Options) ? $curVal : null;
                }
                if ($this->idnpd->ViewValue !== null) { // Load from cache
                    $this->idnpd->EditValue = array_values($this->idnpd->Lookup->Options);
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "`id`" . SearchString("=", $this->idnpd->CurrentValue, DATATYPE_NUMBER, "");
                    }
                    $lookupFilter = function() {
                        return "`id` IN (SELECT `idnpd` FROM `npd_confirmsample`)";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->idnpd->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->idnpd->EditValue = $arwrk;
                }
                $this->idnpd->PlaceHolder = RemoveHtml($this->idnpd->caption());
            }

            // tglpengajuan
            $this->tglpengajuan->EditAttrs["class"] = "form-control";
            $this->tglpengajuan->EditCustomAttributes = "";
            $this->tglpengajuan->EditValue = HtmlEncode(FormatDateTime($this->tglpengajuan->CurrentValue, 8));
            $this->tglpengajuan->PlaceHolder = RemoveHtml($this->tglpengajuan->caption());

            // idnpd_sample
            $this->idnpd_sample->EditAttrs["class"] = "form-control";
            $this->idnpd_sample->EditCustomAttributes = "";
            $curVal = trim(strval($this->idnpd_sample->CurrentValue));
            if ($curVal != "") {
                $this->idnpd_sample->ViewValue = $this->idnpd_sample->lookupCacheOption($curVal);
            } else {
                $this->idnpd_sample->ViewValue = $this->idnpd_sample->Lookup !== null && is_array($this->idnpd_sample->Lookup->Options) ? $curVal : null;
            }
            if ($this->idnpd_sample->ViewValue !== null) { // Load from cache
                $this->idnpd_sample->EditValue = array_values($this->idnpd_sample->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idnpd_sample->CurrentValue, DATATYPE_NUMBER, "");
                }
                $lookupFilter = function() {
                    return CurrentPageID() == "add" ? "id IN (SELECT idnpd_sample FROM npd_confirmsample WHERE readonly=0)" : "";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->idnpd_sample->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idnpd_sample->EditValue = $arwrk;
            }
            $this->idnpd_sample->PlaceHolder = RemoveHtml($this->idnpd_sample->caption());

            // nama
            $this->nama->EditAttrs["class"] = "form-control";
            $this->nama->EditCustomAttributes = "";
            if (!$this->nama->Raw) {
                $this->nama->CurrentValue = HtmlDecode($this->nama->CurrentValue);
            }
            $this->nama->EditValue = HtmlEncode($this->nama->CurrentValue);
            $this->nama->PlaceHolder = RemoveHtml($this->nama->caption());

            // bentuk
            $this->bentuk->EditAttrs["class"] = "form-control";
            $this->bentuk->EditCustomAttributes = "";
            if (!$this->bentuk->Raw) {
                $this->bentuk->CurrentValue = HtmlDecode($this->bentuk->CurrentValue);
            }
            $this->bentuk->EditValue = HtmlEncode($this->bentuk->CurrentValue);
            $this->bentuk->PlaceHolder = RemoveHtml($this->bentuk->caption());

            // viskositas
            $this->viskositas->EditCustomAttributes = "";
            $curVal = trim(strval($this->viskositas->CurrentValue));
            if ($curVal != "") {
                $this->viskositas->ViewValue = $this->viskositas->lookupCacheOption($curVal);
            } else {
                $this->viskositas->ViewValue = $this->viskositas->Lookup !== null && is_array($this->viskositas->Lookup->Options) ? $curVal : null;
            }
            if ($this->viskositas->ViewValue !== null) { // Load from cache
                $this->viskositas->EditValue = array_values($this->viskositas->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->viskositas->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->viskositas->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->viskositas->EditValue = $arwrk;
            }
            $this->viskositas->PlaceHolder = RemoveHtml($this->viskositas->caption());

            // warna
            $this->warna->EditCustomAttributes = "";
            $curVal = trim(strval($this->warna->CurrentValue));
            if ($curVal != "") {
                $this->warna->ViewValue = $this->warna->lookupCacheOption($curVal);
            } else {
                $this->warna->ViewValue = $this->warna->Lookup !== null && is_array($this->warna->Lookup->Options) ? $curVal : null;
            }
            if ($this->warna->ViewValue !== null) { // Load from cache
                $this->warna->EditValue = array_values($this->warna->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`value`" . SearchString("=", $this->warna->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->warna->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->warna->EditValue = $arwrk;
            }
            $this->warna->PlaceHolder = RemoveHtml($this->warna->caption());

            // bauparfum
            $this->bauparfum->EditAttrs["class"] = "form-control";
            $this->bauparfum->EditCustomAttributes = "";
            if (!$this->bauparfum->Raw) {
                $this->bauparfum->CurrentValue = HtmlDecode($this->bauparfum->CurrentValue);
            }
            $this->bauparfum->EditValue = HtmlEncode($this->bauparfum->CurrentValue);
            $this->bauparfum->PlaceHolder = RemoveHtml($this->bauparfum->caption());

            // aplikasisediaan
            $this->aplikasisediaan->EditCustomAttributes = "";
            $curVal = trim(strval($this->aplikasisediaan->CurrentValue));
            if ($curVal != "") {
                $this->aplikasisediaan->ViewValue = $this->aplikasisediaan->lookupCacheOption($curVal);
            } else {
                $this->aplikasisediaan->ViewValue = $this->aplikasisediaan->Lookup !== null && is_array($this->aplikasisediaan->Lookup->Options) ? $curVal : null;
            }
            if ($this->aplikasisediaan->ViewValue !== null) { // Load from cache
                $this->aplikasisediaan->EditValue = array_values($this->aplikasisediaan->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`value`" . SearchString("=", $this->aplikasisediaan->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->aplikasisediaan->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->aplikasisediaan->EditValue = $arwrk;
            }
            $this->aplikasisediaan->PlaceHolder = RemoveHtml($this->aplikasisediaan->caption());

            // volume
            $this->volume->EditAttrs["class"] = "form-control";
            $this->volume->EditCustomAttributes = "";
            if (!$this->volume->Raw) {
                $this->volume->CurrentValue = HtmlDecode($this->volume->CurrentValue);
            }
            $this->volume->EditValue = HtmlEncode($this->volume->CurrentValue);
            $this->volume->PlaceHolder = RemoveHtml($this->volume->caption());

            // bahanaktif
            $this->bahanaktif->EditAttrs["class"] = "form-control";
            $this->bahanaktif->EditCustomAttributes = "";
            $this->bahanaktif->EditValue = HtmlEncode($this->bahanaktif->CurrentValue);
            $this->bahanaktif->PlaceHolder = RemoveHtml($this->bahanaktif->caption());

            // volumewadah
            $this->volumewadah->EditAttrs["class"] = "form-control";
            $this->volumewadah->EditCustomAttributes = "";
            if (!$this->volumewadah->Raw) {
                $this->volumewadah->CurrentValue = HtmlDecode($this->volumewadah->CurrentValue);
            }
            $this->volumewadah->EditValue = HtmlEncode($this->volumewadah->CurrentValue);
            $this->volumewadah->PlaceHolder = RemoveHtml($this->volumewadah->caption());

            // bahanwadah
            $this->bahanwadah->EditAttrs["class"] = "form-control";
            $this->bahanwadah->EditCustomAttributes = "";
            if (!$this->bahanwadah->Raw) {
                $this->bahanwadah->CurrentValue = HtmlDecode($this->bahanwadah->CurrentValue);
            }
            $this->bahanwadah->EditValue = HtmlEncode($this->bahanwadah->CurrentValue);
            $this->bahanwadah->PlaceHolder = RemoveHtml($this->bahanwadah->caption());

            // warnawadah
            $this->warnawadah->EditAttrs["class"] = "form-control";
            $this->warnawadah->EditCustomAttributes = "";
            if (!$this->warnawadah->Raw) {
                $this->warnawadah->CurrentValue = HtmlDecode($this->warnawadah->CurrentValue);
            }
            $this->warnawadah->EditValue = HtmlEncode($this->warnawadah->CurrentValue);
            $this->warnawadah->PlaceHolder = RemoveHtml($this->warnawadah->caption());

            // bentukwadah
            $this->bentukwadah->EditAttrs["class"] = "form-control";
            $this->bentukwadah->EditCustomAttributes = "";
            if (!$this->bentukwadah->Raw) {
                $this->bentukwadah->CurrentValue = HtmlDecode($this->bentukwadah->CurrentValue);
            }
            $this->bentukwadah->EditValue = HtmlEncode($this->bentukwadah->CurrentValue);
            $this->bentukwadah->PlaceHolder = RemoveHtml($this->bentukwadah->caption());

            // jenistutup
            $this->jenistutup->EditAttrs["class"] = "form-control";
            $this->jenistutup->EditCustomAttributes = "";
            if (!$this->jenistutup->Raw) {
                $this->jenistutup->CurrentValue = HtmlDecode($this->jenistutup->CurrentValue);
            }
            $this->jenistutup->EditValue = HtmlEncode($this->jenistutup->CurrentValue);
            $this->jenistutup->PlaceHolder = RemoveHtml($this->jenistutup->caption());

            // bahantutup
            $this->bahantutup->EditAttrs["class"] = "form-control";
            $this->bahantutup->EditCustomAttributes = "";
            if (!$this->bahantutup->Raw) {
                $this->bahantutup->CurrentValue = HtmlDecode($this->bahantutup->CurrentValue);
            }
            $this->bahantutup->EditValue = HtmlEncode($this->bahantutup->CurrentValue);
            $this->bahantutup->PlaceHolder = RemoveHtml($this->bahantutup->caption());

            // warnatutup
            $this->warnatutup->EditAttrs["class"] = "form-control";
            $this->warnatutup->EditCustomAttributes = "";
            if (!$this->warnatutup->Raw) {
                $this->warnatutup->CurrentValue = HtmlDecode($this->warnatutup->CurrentValue);
            }
            $this->warnatutup->EditValue = HtmlEncode($this->warnatutup->CurrentValue);
            $this->warnatutup->PlaceHolder = RemoveHtml($this->warnatutup->caption());

            // bentuktutup
            $this->bentuktutup->EditAttrs["class"] = "form-control";
            $this->bentuktutup->EditCustomAttributes = "";
            if (!$this->bentuktutup->Raw) {
                $this->bentuktutup->CurrentValue = HtmlDecode($this->bentuktutup->CurrentValue);
            }
            $this->bentuktutup->EditValue = HtmlEncode($this->bentuktutup->CurrentValue);
            $this->bentuktutup->PlaceHolder = RemoveHtml($this->bentuktutup->caption());

            // segel
            $this->segel->EditCustomAttributes = "";
            $this->segel->EditValue = $this->segel->options(false);
            $this->segel->PlaceHolder = RemoveHtml($this->segel->caption());

            // catatanprimer
            $this->catatanprimer->EditAttrs["class"] = "form-control";
            $this->catatanprimer->EditCustomAttributes = "";
            $this->catatanprimer->EditValue = HtmlEncode($this->catatanprimer->CurrentValue);
            $this->catatanprimer->PlaceHolder = RemoveHtml($this->catatanprimer->caption());

            // packingproduk
            $this->packingproduk->EditAttrs["class"] = "form-control";
            $this->packingproduk->EditCustomAttributes = "";
            if (!$this->packingproduk->Raw) {
                $this->packingproduk->CurrentValue = HtmlDecode($this->packingproduk->CurrentValue);
            }
            $this->packingproduk->EditValue = HtmlEncode($this->packingproduk->CurrentValue);
            $this->packingproduk->PlaceHolder = RemoveHtml($this->packingproduk->caption());

            // keteranganpacking
            $this->keteranganpacking->EditAttrs["class"] = "form-control";
            $this->keteranganpacking->EditCustomAttributes = "";
            $this->keteranganpacking->EditValue = HtmlEncode($this->keteranganpacking->CurrentValue);
            $this->keteranganpacking->PlaceHolder = RemoveHtml($this->keteranganpacking->caption());

            // beltkarton
            $this->beltkarton->EditAttrs["class"] = "form-control";
            $this->beltkarton->EditCustomAttributes = "";
            if (!$this->beltkarton->Raw) {
                $this->beltkarton->CurrentValue = HtmlDecode($this->beltkarton->CurrentValue);
            }
            $this->beltkarton->EditValue = HtmlEncode($this->beltkarton->CurrentValue);
            $this->beltkarton->PlaceHolder = RemoveHtml($this->beltkarton->caption());

            // keteranganbelt
            $this->keteranganbelt->EditAttrs["class"] = "form-control";
            $this->keteranganbelt->EditCustomAttributes = "";
            $this->keteranganbelt->EditValue = HtmlEncode($this->keteranganbelt->CurrentValue);
            $this->keteranganbelt->PlaceHolder = RemoveHtml($this->keteranganbelt->caption());

            // kartonluar
            $this->kartonluar->EditAttrs["class"] = "form-control";
            $this->kartonluar->EditCustomAttributes = "";
            if (!$this->kartonluar->Raw) {
                $this->kartonluar->CurrentValue = HtmlDecode($this->kartonluar->CurrentValue);
            }
            $this->kartonluar->EditValue = HtmlEncode($this->kartonluar->CurrentValue);
            $this->kartonluar->PlaceHolder = RemoveHtml($this->kartonluar->caption());

            // bariskarton
            $this->bariskarton->EditAttrs["class"] = "form-control";
            $this->bariskarton->EditCustomAttributes = "";
            if (!$this->bariskarton->Raw) {
                $this->bariskarton->CurrentValue = HtmlDecode($this->bariskarton->CurrentValue);
            }
            $this->bariskarton->EditValue = HtmlEncode($this->bariskarton->CurrentValue);
            $this->bariskarton->PlaceHolder = RemoveHtml($this->bariskarton->caption());

            // kolomkarton
            $this->kolomkarton->EditAttrs["class"] = "form-control";
            $this->kolomkarton->EditCustomAttributes = "";
            if (!$this->kolomkarton->Raw) {
                $this->kolomkarton->CurrentValue = HtmlDecode($this->kolomkarton->CurrentValue);
            }
            $this->kolomkarton->EditValue = HtmlEncode($this->kolomkarton->CurrentValue);
            $this->kolomkarton->PlaceHolder = RemoveHtml($this->kolomkarton->caption());

            // stackkarton
            $this->stackkarton->EditAttrs["class"] = "form-control";
            $this->stackkarton->EditCustomAttributes = "";
            if (!$this->stackkarton->Raw) {
                $this->stackkarton->CurrentValue = HtmlDecode($this->stackkarton->CurrentValue);
            }
            $this->stackkarton->EditValue = HtmlEncode($this->stackkarton->CurrentValue);
            $this->stackkarton->PlaceHolder = RemoveHtml($this->stackkarton->caption());

            // isikarton
            $this->isikarton->EditAttrs["class"] = "form-control";
            $this->isikarton->EditCustomAttributes = "";
            if (!$this->isikarton->Raw) {
                $this->isikarton->CurrentValue = HtmlDecode($this->isikarton->CurrentValue);
            }
            $this->isikarton->EditValue = HtmlEncode($this->isikarton->CurrentValue);
            $this->isikarton->PlaceHolder = RemoveHtml($this->isikarton->caption());

            // jenislabel
            $this->jenislabel->EditCustomAttributes = "";
            $curVal = trim(strval($this->jenislabel->CurrentValue));
            if ($curVal != "") {
                $this->jenislabel->ViewValue = $this->jenislabel->lookupCacheOption($curVal);
            } else {
                $this->jenislabel->ViewValue = $this->jenislabel->Lookup !== null && is_array($this->jenislabel->Lookup->Options) ? $curVal : null;
            }
            if ($this->jenislabel->ViewValue !== null) { // Load from cache
                $this->jenislabel->EditValue = array_values($this->jenislabel->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`value`" . SearchString("=", $this->jenislabel->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->jenislabel->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->jenislabel->EditValue = $arwrk;
            }
            $this->jenislabel->PlaceHolder = RemoveHtml($this->jenislabel->caption());

            // keteranganjenislabel
            $this->keteranganjenislabel->EditAttrs["class"] = "form-control";
            $this->keteranganjenislabel->EditCustomAttributes = "";
            $this->keteranganjenislabel->EditValue = HtmlEncode($this->keteranganjenislabel->CurrentValue);
            $this->keteranganjenislabel->PlaceHolder = RemoveHtml($this->keteranganjenislabel->caption());

            // kualitaslabel
            $this->kualitaslabel->EditCustomAttributes = "";
            $curVal = trim(strval($this->kualitaslabel->CurrentValue));
            if ($curVal != "") {
                $this->kualitaslabel->ViewValue = $this->kualitaslabel->lookupCacheOption($curVal);
            } else {
                $this->kualitaslabel->ViewValue = $this->kualitaslabel->Lookup !== null && is_array($this->kualitaslabel->Lookup->Options) ? $curVal : null;
            }
            if ($this->kualitaslabel->ViewValue !== null) { // Load from cache
                $this->kualitaslabel->EditValue = array_values($this->kualitaslabel->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`value`" . SearchString("=", $this->kualitaslabel->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->kualitaslabel->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->kualitaslabel->EditValue = $arwrk;
            }
            $this->kualitaslabel->PlaceHolder = RemoveHtml($this->kualitaslabel->caption());

            // jumlahwarnalabel
            $this->jumlahwarnalabel->EditAttrs["class"] = "form-control";
            $this->jumlahwarnalabel->EditCustomAttributes = "";
            if (!$this->jumlahwarnalabel->Raw) {
                $this->jumlahwarnalabel->CurrentValue = HtmlDecode($this->jumlahwarnalabel->CurrentValue);
            }
            $this->jumlahwarnalabel->EditValue = HtmlEncode($this->jumlahwarnalabel->CurrentValue);
            $this->jumlahwarnalabel->PlaceHolder = RemoveHtml($this->jumlahwarnalabel->caption());

            // metaliklabel
            $this->metaliklabel->EditAttrs["class"] = "form-control";
            $this->metaliklabel->EditCustomAttributes = "";
            if (!$this->metaliklabel->Raw) {
                $this->metaliklabel->CurrentValue = HtmlDecode($this->metaliklabel->CurrentValue);
            }
            $this->metaliklabel->EditValue = HtmlEncode($this->metaliklabel->CurrentValue);
            $this->metaliklabel->PlaceHolder = RemoveHtml($this->metaliklabel->caption());

            // etiketlabel
            $this->etiketlabel->EditAttrs["class"] = "form-control";
            $this->etiketlabel->EditCustomAttributes = "";
            if (!$this->etiketlabel->Raw) {
                $this->etiketlabel->CurrentValue = HtmlDecode($this->etiketlabel->CurrentValue);
            }
            $this->etiketlabel->EditValue = HtmlEncode($this->etiketlabel->CurrentValue);
            $this->etiketlabel->PlaceHolder = RemoveHtml($this->etiketlabel->caption());

            // keteranganlabel
            $this->keteranganlabel->EditAttrs["class"] = "form-control";
            $this->keteranganlabel->EditCustomAttributes = "";
            $this->keteranganlabel->EditValue = HtmlEncode($this->keteranganlabel->CurrentValue);
            $this->keteranganlabel->PlaceHolder = RemoveHtml($this->keteranganlabel->caption());

            // kategoridelivery
            $this->kategoridelivery->EditCustomAttributes = "";
            $curVal = trim(strval($this->kategoridelivery->CurrentValue));
            if ($curVal != "") {
                $this->kategoridelivery->ViewValue = $this->kategoridelivery->lookupCacheOption($curVal);
            } else {
                $this->kategoridelivery->ViewValue = $this->kategoridelivery->Lookup !== null && is_array($this->kategoridelivery->Lookup->Options) ? $curVal : null;
            }
            if ($this->kategoridelivery->ViewValue !== null) { // Load from cache
                $this->kategoridelivery->EditValue = array_values($this->kategoridelivery->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`nama`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                }
                $sqlWrk = $this->kategoridelivery->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->kategoridelivery->EditValue = $arwrk;
            }
            $this->kategoridelivery->PlaceHolder = RemoveHtml($this->kategoridelivery->caption());

            // alamatpengiriman
            $this->alamatpengiriman->EditAttrs["class"] = "form-control";
            $this->alamatpengiriman->EditCustomAttributes = "";
            if (!$this->alamatpengiriman->Raw) {
                $this->alamatpengiriman->CurrentValue = HtmlDecode($this->alamatpengiriman->CurrentValue);
            }
            $this->alamatpengiriman->EditValue = HtmlEncode($this->alamatpengiriman->CurrentValue);
            $this->alamatpengiriman->PlaceHolder = RemoveHtml($this->alamatpengiriman->caption());

            // orderperdana
            $this->orderperdana->EditAttrs["class"] = "form-control";
            $this->orderperdana->EditCustomAttributes = "";
            $this->orderperdana->EditValue = HtmlEncode($this->orderperdana->CurrentValue);
            $this->orderperdana->PlaceHolder = RemoveHtml($this->orderperdana->caption());

            // orderkontrak
            $this->orderkontrak->EditAttrs["class"] = "form-control";
            $this->orderkontrak->EditCustomAttributes = "";
            $this->orderkontrak->EditValue = HtmlEncode($this->orderkontrak->CurrentValue);
            $this->orderkontrak->PlaceHolder = RemoveHtml($this->orderkontrak->caption());

            // hargaperpcs
            $this->hargaperpcs->EditAttrs["class"] = "form-control";
            $this->hargaperpcs->EditCustomAttributes = "";
            $this->hargaperpcs->EditValue = HtmlEncode($this->hargaperpcs->CurrentValue);
            $this->hargaperpcs->PlaceHolder = RemoveHtml($this->hargaperpcs->caption());

            // hargaperkarton
            $this->hargaperkarton->EditAttrs["class"] = "form-control";
            $this->hargaperkarton->EditCustomAttributes = "";
            $this->hargaperkarton->EditValue = HtmlEncode($this->hargaperkarton->CurrentValue);
            $this->hargaperkarton->PlaceHolder = RemoveHtml($this->hargaperkarton->caption());

            // lampiran
            $this->lampiran->EditAttrs["class"] = "form-control";
            $this->lampiran->EditCustomAttributes = "";
            if (!EmptyValue($this->lampiran->Upload->DbValue)) {
                $this->lampiran->EditValue = $this->lampiran->Upload->DbValue;
            } else {
                $this->lampiran->EditValue = "";
            }
            if (!EmptyValue($this->lampiran->CurrentValue)) {
                $this->lampiran->Upload->FileName = $this->lampiran->CurrentValue;
            }
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->lampiran);
            }

            // prepared_by
            $this->prepared_by->EditAttrs["class"] = "form-control";
            $this->prepared_by->EditCustomAttributes = "";
            $this->prepared_by->EditValue = HtmlEncode($this->prepared_by->CurrentValue);
            $this->prepared_by->PlaceHolder = RemoveHtml($this->prepared_by->caption());

            // checked_by
            $this->checked_by->EditAttrs["class"] = "form-control";
            $this->checked_by->EditCustomAttributes = "";
            $this->checked_by->EditValue = HtmlEncode($this->checked_by->CurrentValue);
            $this->checked_by->PlaceHolder = RemoveHtml($this->checked_by->caption());

            // approved_by
            $this->approved_by->EditAttrs["class"] = "form-control";
            $this->approved_by->EditCustomAttributes = "";
            $this->approved_by->EditValue = HtmlEncode($this->approved_by->CurrentValue);
            $this->approved_by->PlaceHolder = RemoveHtml($this->approved_by->caption());

            // disetujui
            $this->disetujui->EditCustomAttributes = "";
            $this->disetujui->EditValue = $this->disetujui->options(false);
            $this->disetujui->PlaceHolder = RemoveHtml($this->disetujui->caption());

            // updated_at
            $this->updated_at->EditAttrs["class"] = "form-control";
            $this->updated_at->EditCustomAttributes = "";
            $this->updated_at->EditValue = HtmlEncode(FormatDateTime($this->updated_at->CurrentValue, 8));
            $this->updated_at->PlaceHolder = RemoveHtml($this->updated_at->caption());

            // Add refer script

            // idnpd
            $this->idnpd->LinkCustomAttributes = "";
            $this->idnpd->HrefValue = "";

            // tglpengajuan
            $this->tglpengajuan->LinkCustomAttributes = "";
            $this->tglpengajuan->HrefValue = "";

            // idnpd_sample
            $this->idnpd_sample->LinkCustomAttributes = "";
            $this->idnpd_sample->HrefValue = "";

            // nama
            $this->nama->LinkCustomAttributes = "";
            $this->nama->HrefValue = "";

            // bentuk
            $this->bentuk->LinkCustomAttributes = "";
            $this->bentuk->HrefValue = "";

            // viskositas
            $this->viskositas->LinkCustomAttributes = "";
            $this->viskositas->HrefValue = "";

            // warna
            $this->warna->LinkCustomAttributes = "";
            $this->warna->HrefValue = "";

            // bauparfum
            $this->bauparfum->LinkCustomAttributes = "";
            $this->bauparfum->HrefValue = "";

            // aplikasisediaan
            $this->aplikasisediaan->LinkCustomAttributes = "";
            $this->aplikasisediaan->HrefValue = "";

            // volume
            $this->volume->LinkCustomAttributes = "";
            $this->volume->HrefValue = "";

            // bahanaktif
            $this->bahanaktif->LinkCustomAttributes = "";
            $this->bahanaktif->HrefValue = "";

            // volumewadah
            $this->volumewadah->LinkCustomAttributes = "";
            $this->volumewadah->HrefValue = "";

            // bahanwadah
            $this->bahanwadah->LinkCustomAttributes = "";
            $this->bahanwadah->HrefValue = "";

            // warnawadah
            $this->warnawadah->LinkCustomAttributes = "";
            $this->warnawadah->HrefValue = "";

            // bentukwadah
            $this->bentukwadah->LinkCustomAttributes = "";
            $this->bentukwadah->HrefValue = "";

            // jenistutup
            $this->jenistutup->LinkCustomAttributes = "";
            $this->jenistutup->HrefValue = "";

            // bahantutup
            $this->bahantutup->LinkCustomAttributes = "";
            $this->bahantutup->HrefValue = "";

            // warnatutup
            $this->warnatutup->LinkCustomAttributes = "";
            $this->warnatutup->HrefValue = "";

            // bentuktutup
            $this->bentuktutup->LinkCustomAttributes = "";
            $this->bentuktutup->HrefValue = "";

            // segel
            $this->segel->LinkCustomAttributes = "";
            $this->segel->HrefValue = "";

            // catatanprimer
            $this->catatanprimer->LinkCustomAttributes = "";
            $this->catatanprimer->HrefValue = "";

            // packingproduk
            $this->packingproduk->LinkCustomAttributes = "";
            $this->packingproduk->HrefValue = "";

            // keteranganpacking
            $this->keteranganpacking->LinkCustomAttributes = "";
            $this->keteranganpacking->HrefValue = "";

            // beltkarton
            $this->beltkarton->LinkCustomAttributes = "";
            $this->beltkarton->HrefValue = "";

            // keteranganbelt
            $this->keteranganbelt->LinkCustomAttributes = "";
            $this->keteranganbelt->HrefValue = "";

            // kartonluar
            $this->kartonluar->LinkCustomAttributes = "";
            $this->kartonluar->HrefValue = "";

            // bariskarton
            $this->bariskarton->LinkCustomAttributes = "";
            $this->bariskarton->HrefValue = "";

            // kolomkarton
            $this->kolomkarton->LinkCustomAttributes = "";
            $this->kolomkarton->HrefValue = "";

            // stackkarton
            $this->stackkarton->LinkCustomAttributes = "";
            $this->stackkarton->HrefValue = "";

            // isikarton
            $this->isikarton->LinkCustomAttributes = "";
            $this->isikarton->HrefValue = "";

            // jenislabel
            $this->jenislabel->LinkCustomAttributes = "";
            $this->jenislabel->HrefValue = "";

            // keteranganjenislabel
            $this->keteranganjenislabel->LinkCustomAttributes = "";
            $this->keteranganjenislabel->HrefValue = "";

            // kualitaslabel
            $this->kualitaslabel->LinkCustomAttributes = "";
            $this->kualitaslabel->HrefValue = "";

            // jumlahwarnalabel
            $this->jumlahwarnalabel->LinkCustomAttributes = "";
            $this->jumlahwarnalabel->HrefValue = "";

            // metaliklabel
            $this->metaliklabel->LinkCustomAttributes = "";
            $this->metaliklabel->HrefValue = "";

            // etiketlabel
            $this->etiketlabel->LinkCustomAttributes = "";
            $this->etiketlabel->HrefValue = "";

            // keteranganlabel
            $this->keteranganlabel->LinkCustomAttributes = "";
            $this->keteranganlabel->HrefValue = "";

            // kategoridelivery
            $this->kategoridelivery->LinkCustomAttributes = "";
            $this->kategoridelivery->HrefValue = "";

            // alamatpengiriman
            $this->alamatpengiriman->LinkCustomAttributes = "";
            $this->alamatpengiriman->HrefValue = "";

            // orderperdana
            $this->orderperdana->LinkCustomAttributes = "";
            $this->orderperdana->HrefValue = "";

            // orderkontrak
            $this->orderkontrak->LinkCustomAttributes = "";
            $this->orderkontrak->HrefValue = "";

            // hargaperpcs
            $this->hargaperpcs->LinkCustomAttributes = "";
            $this->hargaperpcs->HrefValue = "";

            // hargaperkarton
            $this->hargaperkarton->LinkCustomAttributes = "";
            $this->hargaperkarton->HrefValue = "";

            // lampiran
            $this->lampiran->LinkCustomAttributes = "";
            $this->lampiran->HrefValue = "";
            $this->lampiran->ExportHrefValue = $this->lampiran->UploadPath . $this->lampiran->Upload->DbValue;

            // prepared_by
            $this->prepared_by->LinkCustomAttributes = "";
            $this->prepared_by->HrefValue = "";

            // checked_by
            $this->checked_by->LinkCustomAttributes = "";
            $this->checked_by->HrefValue = "";

            // approved_by
            $this->approved_by->LinkCustomAttributes = "";
            $this->approved_by->HrefValue = "";

            // disetujui
            $this->disetujui->LinkCustomAttributes = "";
            $this->disetujui->HrefValue = "";

            // updated_at
            $this->updated_at->LinkCustomAttributes = "";
            $this->updated_at->HrefValue = "";
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }

        // Save data for Custom Template
        if ($this->RowType == ROWTYPE_VIEW || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_ADD) {
            $this->Rows[] = $this->customTemplateFieldValues();
        }
    }

    // Validate form
    protected function validateForm()
    {
        global $Language;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        if ($this->idnpd->Required) {
            if (!$this->idnpd->IsDetailKey && EmptyValue($this->idnpd->FormValue)) {
                $this->idnpd->addErrorMessage(str_replace("%s", $this->idnpd->caption(), $this->idnpd->RequiredErrorMessage));
            }
        }
        if ($this->tglpengajuan->Required) {
            if (!$this->tglpengajuan->IsDetailKey && EmptyValue($this->tglpengajuan->FormValue)) {
                $this->tglpengajuan->addErrorMessage(str_replace("%s", $this->tglpengajuan->caption(), $this->tglpengajuan->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tglpengajuan->FormValue)) {
            $this->tglpengajuan->addErrorMessage($this->tglpengajuan->getErrorMessage(false));
        }
        if ($this->idnpd_sample->Required) {
            if (!$this->idnpd_sample->IsDetailKey && EmptyValue($this->idnpd_sample->FormValue)) {
                $this->idnpd_sample->addErrorMessage(str_replace("%s", $this->idnpd_sample->caption(), $this->idnpd_sample->RequiredErrorMessage));
            }
        }
        if ($this->nama->Required) {
            if (!$this->nama->IsDetailKey && EmptyValue($this->nama->FormValue)) {
                $this->nama->addErrorMessage(str_replace("%s", $this->nama->caption(), $this->nama->RequiredErrorMessage));
            }
        }
        if ($this->bentuk->Required) {
            if (!$this->bentuk->IsDetailKey && EmptyValue($this->bentuk->FormValue)) {
                $this->bentuk->addErrorMessage(str_replace("%s", $this->bentuk->caption(), $this->bentuk->RequiredErrorMessage));
            }
        }
        if ($this->viskositas->Required) {
            if ($this->viskositas->FormValue == "") {
                $this->viskositas->addErrorMessage(str_replace("%s", $this->viskositas->caption(), $this->viskositas->RequiredErrorMessage));
            }
        }
        if ($this->warna->Required) {
            if ($this->warna->FormValue == "") {
                $this->warna->addErrorMessage(str_replace("%s", $this->warna->caption(), $this->warna->RequiredErrorMessage));
            }
        }
        if ($this->bauparfum->Required) {
            if (!$this->bauparfum->IsDetailKey && EmptyValue($this->bauparfum->FormValue)) {
                $this->bauparfum->addErrorMessage(str_replace("%s", $this->bauparfum->caption(), $this->bauparfum->RequiredErrorMessage));
            }
        }
        if ($this->aplikasisediaan->Required) {
            if ($this->aplikasisediaan->FormValue == "") {
                $this->aplikasisediaan->addErrorMessage(str_replace("%s", $this->aplikasisediaan->caption(), $this->aplikasisediaan->RequiredErrorMessage));
            }
        }
        if ($this->volume->Required) {
            if (!$this->volume->IsDetailKey && EmptyValue($this->volume->FormValue)) {
                $this->volume->addErrorMessage(str_replace("%s", $this->volume->caption(), $this->volume->RequiredErrorMessage));
            }
        }
        if ($this->bahanaktif->Required) {
            if (!$this->bahanaktif->IsDetailKey && EmptyValue($this->bahanaktif->FormValue)) {
                $this->bahanaktif->addErrorMessage(str_replace("%s", $this->bahanaktif->caption(), $this->bahanaktif->RequiredErrorMessage));
            }
        }
        if ($this->volumewadah->Required) {
            if (!$this->volumewadah->IsDetailKey && EmptyValue($this->volumewadah->FormValue)) {
                $this->volumewadah->addErrorMessage(str_replace("%s", $this->volumewadah->caption(), $this->volumewadah->RequiredErrorMessage));
            }
        }
        if ($this->bahanwadah->Required) {
            if (!$this->bahanwadah->IsDetailKey && EmptyValue($this->bahanwadah->FormValue)) {
                $this->bahanwadah->addErrorMessage(str_replace("%s", $this->bahanwadah->caption(), $this->bahanwadah->RequiredErrorMessage));
            }
        }
        if ($this->warnawadah->Required) {
            if (!$this->warnawadah->IsDetailKey && EmptyValue($this->warnawadah->FormValue)) {
                $this->warnawadah->addErrorMessage(str_replace("%s", $this->warnawadah->caption(), $this->warnawadah->RequiredErrorMessage));
            }
        }
        if ($this->bentukwadah->Required) {
            if (!$this->bentukwadah->IsDetailKey && EmptyValue($this->bentukwadah->FormValue)) {
                $this->bentukwadah->addErrorMessage(str_replace("%s", $this->bentukwadah->caption(), $this->bentukwadah->RequiredErrorMessage));
            }
        }
        if ($this->jenistutup->Required) {
            if (!$this->jenistutup->IsDetailKey && EmptyValue($this->jenistutup->FormValue)) {
                $this->jenistutup->addErrorMessage(str_replace("%s", $this->jenistutup->caption(), $this->jenistutup->RequiredErrorMessage));
            }
        }
        if ($this->bahantutup->Required) {
            if (!$this->bahantutup->IsDetailKey && EmptyValue($this->bahantutup->FormValue)) {
                $this->bahantutup->addErrorMessage(str_replace("%s", $this->bahantutup->caption(), $this->bahantutup->RequiredErrorMessage));
            }
        }
        if ($this->warnatutup->Required) {
            if (!$this->warnatutup->IsDetailKey && EmptyValue($this->warnatutup->FormValue)) {
                $this->warnatutup->addErrorMessage(str_replace("%s", $this->warnatutup->caption(), $this->warnatutup->RequiredErrorMessage));
            }
        }
        if ($this->bentuktutup->Required) {
            if (!$this->bentuktutup->IsDetailKey && EmptyValue($this->bentuktutup->FormValue)) {
                $this->bentuktutup->addErrorMessage(str_replace("%s", $this->bentuktutup->caption(), $this->bentuktutup->RequiredErrorMessage));
            }
        }
        if ($this->segel->Required) {
            if ($this->segel->FormValue == "") {
                $this->segel->addErrorMessage(str_replace("%s", $this->segel->caption(), $this->segel->RequiredErrorMessage));
            }
        }
        if ($this->catatanprimer->Required) {
            if (!$this->catatanprimer->IsDetailKey && EmptyValue($this->catatanprimer->FormValue)) {
                $this->catatanprimer->addErrorMessage(str_replace("%s", $this->catatanprimer->caption(), $this->catatanprimer->RequiredErrorMessage));
            }
        }
        if ($this->packingproduk->Required) {
            if (!$this->packingproduk->IsDetailKey && EmptyValue($this->packingproduk->FormValue)) {
                $this->packingproduk->addErrorMessage(str_replace("%s", $this->packingproduk->caption(), $this->packingproduk->RequiredErrorMessage));
            }
        }
        if ($this->keteranganpacking->Required) {
            if (!$this->keteranganpacking->IsDetailKey && EmptyValue($this->keteranganpacking->FormValue)) {
                $this->keteranganpacking->addErrorMessage(str_replace("%s", $this->keteranganpacking->caption(), $this->keteranganpacking->RequiredErrorMessage));
            }
        }
        if ($this->beltkarton->Required) {
            if (!$this->beltkarton->IsDetailKey && EmptyValue($this->beltkarton->FormValue)) {
                $this->beltkarton->addErrorMessage(str_replace("%s", $this->beltkarton->caption(), $this->beltkarton->RequiredErrorMessage));
            }
        }
        if ($this->keteranganbelt->Required) {
            if (!$this->keteranganbelt->IsDetailKey && EmptyValue($this->keteranganbelt->FormValue)) {
                $this->keteranganbelt->addErrorMessage(str_replace("%s", $this->keteranganbelt->caption(), $this->keteranganbelt->RequiredErrorMessage));
            }
        }
        if ($this->kartonluar->Required) {
            if (!$this->kartonluar->IsDetailKey && EmptyValue($this->kartonluar->FormValue)) {
                $this->kartonluar->addErrorMessage(str_replace("%s", $this->kartonluar->caption(), $this->kartonluar->RequiredErrorMessage));
            }
        }
        if ($this->bariskarton->Required) {
            if (!$this->bariskarton->IsDetailKey && EmptyValue($this->bariskarton->FormValue)) {
                $this->bariskarton->addErrorMessage(str_replace("%s", $this->bariskarton->caption(), $this->bariskarton->RequiredErrorMessage));
            }
        }
        if ($this->kolomkarton->Required) {
            if (!$this->kolomkarton->IsDetailKey && EmptyValue($this->kolomkarton->FormValue)) {
                $this->kolomkarton->addErrorMessage(str_replace("%s", $this->kolomkarton->caption(), $this->kolomkarton->RequiredErrorMessage));
            }
        }
        if ($this->stackkarton->Required) {
            if (!$this->stackkarton->IsDetailKey && EmptyValue($this->stackkarton->FormValue)) {
                $this->stackkarton->addErrorMessage(str_replace("%s", $this->stackkarton->caption(), $this->stackkarton->RequiredErrorMessage));
            }
        }
        if ($this->isikarton->Required) {
            if (!$this->isikarton->IsDetailKey && EmptyValue($this->isikarton->FormValue)) {
                $this->isikarton->addErrorMessage(str_replace("%s", $this->isikarton->caption(), $this->isikarton->RequiredErrorMessage));
            }
        }
        if ($this->jenislabel->Required) {
            if ($this->jenislabel->FormValue == "") {
                $this->jenislabel->addErrorMessage(str_replace("%s", $this->jenislabel->caption(), $this->jenislabel->RequiredErrorMessage));
            }
        }
        if ($this->keteranganjenislabel->Required) {
            if (!$this->keteranganjenislabel->IsDetailKey && EmptyValue($this->keteranganjenislabel->FormValue)) {
                $this->keteranganjenislabel->addErrorMessage(str_replace("%s", $this->keteranganjenislabel->caption(), $this->keteranganjenislabel->RequiredErrorMessage));
            }
        }
        if ($this->kualitaslabel->Required) {
            if ($this->kualitaslabel->FormValue == "") {
                $this->kualitaslabel->addErrorMessage(str_replace("%s", $this->kualitaslabel->caption(), $this->kualitaslabel->RequiredErrorMessage));
            }
        }
        if ($this->jumlahwarnalabel->Required) {
            if (!$this->jumlahwarnalabel->IsDetailKey && EmptyValue($this->jumlahwarnalabel->FormValue)) {
                $this->jumlahwarnalabel->addErrorMessage(str_replace("%s", $this->jumlahwarnalabel->caption(), $this->jumlahwarnalabel->RequiredErrorMessage));
            }
        }
        if ($this->metaliklabel->Required) {
            if (!$this->metaliklabel->IsDetailKey && EmptyValue($this->metaliklabel->FormValue)) {
                $this->metaliklabel->addErrorMessage(str_replace("%s", $this->metaliklabel->caption(), $this->metaliklabel->RequiredErrorMessage));
            }
        }
        if ($this->etiketlabel->Required) {
            if (!$this->etiketlabel->IsDetailKey && EmptyValue($this->etiketlabel->FormValue)) {
                $this->etiketlabel->addErrorMessage(str_replace("%s", $this->etiketlabel->caption(), $this->etiketlabel->RequiredErrorMessage));
            }
        }
        if ($this->keteranganlabel->Required) {
            if (!$this->keteranganlabel->IsDetailKey && EmptyValue($this->keteranganlabel->FormValue)) {
                $this->keteranganlabel->addErrorMessage(str_replace("%s", $this->keteranganlabel->caption(), $this->keteranganlabel->RequiredErrorMessage));
            }
        }
        if ($this->kategoridelivery->Required) {
            if ($this->kategoridelivery->FormValue == "") {
                $this->kategoridelivery->addErrorMessage(str_replace("%s", $this->kategoridelivery->caption(), $this->kategoridelivery->RequiredErrorMessage));
            }
        }
        if ($this->alamatpengiriman->Required) {
            if (!$this->alamatpengiriman->IsDetailKey && EmptyValue($this->alamatpengiriman->FormValue)) {
                $this->alamatpengiriman->addErrorMessage(str_replace("%s", $this->alamatpengiriman->caption(), $this->alamatpengiriman->RequiredErrorMessage));
            }
        }
        if ($this->orderperdana->Required) {
            if (!$this->orderperdana->IsDetailKey && EmptyValue($this->orderperdana->FormValue)) {
                $this->orderperdana->addErrorMessage(str_replace("%s", $this->orderperdana->caption(), $this->orderperdana->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->orderperdana->FormValue)) {
            $this->orderperdana->addErrorMessage($this->orderperdana->getErrorMessage(false));
        }
        if ($this->orderkontrak->Required) {
            if (!$this->orderkontrak->IsDetailKey && EmptyValue($this->orderkontrak->FormValue)) {
                $this->orderkontrak->addErrorMessage(str_replace("%s", $this->orderkontrak->caption(), $this->orderkontrak->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->orderkontrak->FormValue)) {
            $this->orderkontrak->addErrorMessage($this->orderkontrak->getErrorMessage(false));
        }
        if ($this->hargaperpcs->Required) {
            if (!$this->hargaperpcs->IsDetailKey && EmptyValue($this->hargaperpcs->FormValue)) {
                $this->hargaperpcs->addErrorMessage(str_replace("%s", $this->hargaperpcs->caption(), $this->hargaperpcs->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->hargaperpcs->FormValue)) {
            $this->hargaperpcs->addErrorMessage($this->hargaperpcs->getErrorMessage(false));
        }
        if ($this->hargaperkarton->Required) {
            if (!$this->hargaperkarton->IsDetailKey && EmptyValue($this->hargaperkarton->FormValue)) {
                $this->hargaperkarton->addErrorMessage(str_replace("%s", $this->hargaperkarton->caption(), $this->hargaperkarton->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->hargaperkarton->FormValue)) {
            $this->hargaperkarton->addErrorMessage($this->hargaperkarton->getErrorMessage(false));
        }
        if ($this->lampiran->Required) {
            if ($this->lampiran->Upload->FileName == "" && !$this->lampiran->Upload->KeepFile) {
                $this->lampiran->addErrorMessage(str_replace("%s", $this->lampiran->caption(), $this->lampiran->RequiredErrorMessage));
            }
        }
        if ($this->prepared_by->Required) {
            if (!$this->prepared_by->IsDetailKey && EmptyValue($this->prepared_by->FormValue)) {
                $this->prepared_by->addErrorMessage(str_replace("%s", $this->prepared_by->caption(), $this->prepared_by->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->prepared_by->FormValue)) {
            $this->prepared_by->addErrorMessage($this->prepared_by->getErrorMessage(false));
        }
        if ($this->checked_by->Required) {
            if (!$this->checked_by->IsDetailKey && EmptyValue($this->checked_by->FormValue)) {
                $this->checked_by->addErrorMessage(str_replace("%s", $this->checked_by->caption(), $this->checked_by->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->checked_by->FormValue)) {
            $this->checked_by->addErrorMessage($this->checked_by->getErrorMessage(false));
        }
        if ($this->approved_by->Required) {
            if (!$this->approved_by->IsDetailKey && EmptyValue($this->approved_by->FormValue)) {
                $this->approved_by->addErrorMessage(str_replace("%s", $this->approved_by->caption(), $this->approved_by->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->approved_by->FormValue)) {
            $this->approved_by->addErrorMessage($this->approved_by->getErrorMessage(false));
        }
        if ($this->disetujui->Required) {
            if ($this->disetujui->FormValue == "") {
                $this->disetujui->addErrorMessage(str_replace("%s", $this->disetujui->caption(), $this->disetujui->RequiredErrorMessage));
            }
        }
        if ($this->updated_at->Required) {
            if (!$this->updated_at->IsDetailKey && EmptyValue($this->updated_at->FormValue)) {
                $this->updated_at->addErrorMessage(str_replace("%s", $this->updated_at->caption(), $this->updated_at->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->updated_at->FormValue)) {
            $this->updated_at->addErrorMessage($this->updated_at->getErrorMessage(false));
        }

        // Return validate result
        $validateForm = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateForm = $validateForm && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateForm;
    }

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Check referential integrity for master table 'npd_harga'
        $validMasterRecord = true;
        $masterFilter = $this->sqlMasterFilter_npd();
        if (strval($this->idnpd->CurrentValue) != "") {
            $masterFilter = str_replace("@id@", AdjustSql($this->idnpd->CurrentValue, "DB"), $masterFilter);
        } else {
            $validMasterRecord = false;
        }
        if ($validMasterRecord) {
            $rsmaster = Container("npd")->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "npd", $Language->phrase("RelatedRecordRequired"));
            $this->setFailureMessage($relatedRecordMsg);
            return false;
        }
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // idnpd
        $this->idnpd->setDbValueDef($rsnew, $this->idnpd->CurrentValue, 0, false);

        // tglpengajuan
        $this->tglpengajuan->setDbValueDef($rsnew, UnFormatDateTime($this->tglpengajuan->CurrentValue, 0), null, false);

        // idnpd_sample
        $this->idnpd_sample->setDbValueDef($rsnew, $this->idnpd_sample->CurrentValue, 0, false);

        // nama
        $this->nama->setDbValueDef($rsnew, $this->nama->CurrentValue, null, false);

        // bentuk
        $this->bentuk->setDbValueDef($rsnew, $this->bentuk->CurrentValue, null, false);

        // viskositas
        $this->viskositas->setDbValueDef($rsnew, $this->viskositas->CurrentValue, null, false);

        // warna
        $this->warna->setDbValueDef($rsnew, $this->warna->CurrentValue, null, false);

        // bauparfum
        $this->bauparfum->setDbValueDef($rsnew, $this->bauparfum->CurrentValue, null, false);

        // aplikasisediaan
        $this->aplikasisediaan->setDbValueDef($rsnew, $this->aplikasisediaan->CurrentValue, null, false);

        // volume
        $this->volume->setDbValueDef($rsnew, $this->volume->CurrentValue, null, false);

        // bahanaktif
        $this->bahanaktif->setDbValueDef($rsnew, $this->bahanaktif->CurrentValue, null, false);

        // volumewadah
        $this->volumewadah->setDbValueDef($rsnew, $this->volumewadah->CurrentValue, null, false);

        // bahanwadah
        $this->bahanwadah->setDbValueDef($rsnew, $this->bahanwadah->CurrentValue, null, false);

        // warnawadah
        $this->warnawadah->setDbValueDef($rsnew, $this->warnawadah->CurrentValue, null, false);

        // bentukwadah
        $this->bentukwadah->setDbValueDef($rsnew, $this->bentukwadah->CurrentValue, null, false);

        // jenistutup
        $this->jenistutup->setDbValueDef($rsnew, $this->jenistutup->CurrentValue, null, false);

        // bahantutup
        $this->bahantutup->setDbValueDef($rsnew, $this->bahantutup->CurrentValue, null, false);

        // warnatutup
        $this->warnatutup->setDbValueDef($rsnew, $this->warnatutup->CurrentValue, null, false);

        // bentuktutup
        $this->bentuktutup->setDbValueDef($rsnew, $this->bentuktutup->CurrentValue, null, false);

        // segel
        $this->segel->setDbValueDef($rsnew, $this->segel->CurrentValue, null, strval($this->segel->CurrentValue) == "");

        // catatanprimer
        $this->catatanprimer->setDbValueDef($rsnew, $this->catatanprimer->CurrentValue, null, false);

        // packingproduk
        $this->packingproduk->setDbValueDef($rsnew, $this->packingproduk->CurrentValue, null, false);

        // keteranganpacking
        $this->keteranganpacking->setDbValueDef($rsnew, $this->keteranganpacking->CurrentValue, null, false);

        // beltkarton
        $this->beltkarton->setDbValueDef($rsnew, $this->beltkarton->CurrentValue, null, false);

        // keteranganbelt
        $this->keteranganbelt->setDbValueDef($rsnew, $this->keteranganbelt->CurrentValue, null, false);

        // kartonluar
        $this->kartonluar->setDbValueDef($rsnew, $this->kartonluar->CurrentValue, null, false);

        // bariskarton
        $this->bariskarton->setDbValueDef($rsnew, $this->bariskarton->CurrentValue, null, false);

        // kolomkarton
        $this->kolomkarton->setDbValueDef($rsnew, $this->kolomkarton->CurrentValue, null, false);

        // stackkarton
        $this->stackkarton->setDbValueDef($rsnew, $this->stackkarton->CurrentValue, null, false);

        // isikarton
        $this->isikarton->setDbValueDef($rsnew, $this->isikarton->CurrentValue, null, false);

        // jenislabel
        $this->jenislabel->setDbValueDef($rsnew, $this->jenislabel->CurrentValue, null, false);

        // keteranganjenislabel
        $this->keteranganjenislabel->setDbValueDef($rsnew, $this->keteranganjenislabel->CurrentValue, null, false);

        // kualitaslabel
        $this->kualitaslabel->setDbValueDef($rsnew, $this->kualitaslabel->CurrentValue, null, false);

        // jumlahwarnalabel
        $this->jumlahwarnalabel->setDbValueDef($rsnew, $this->jumlahwarnalabel->CurrentValue, null, false);

        // metaliklabel
        $this->metaliklabel->setDbValueDef($rsnew, $this->metaliklabel->CurrentValue, null, false);

        // etiketlabel
        $this->etiketlabel->setDbValueDef($rsnew, $this->etiketlabel->CurrentValue, null, false);

        // keteranganlabel
        $this->keteranganlabel->setDbValueDef($rsnew, $this->keteranganlabel->CurrentValue, null, false);

        // kategoridelivery
        $this->kategoridelivery->setDbValueDef($rsnew, $this->kategoridelivery->CurrentValue, null, false);

        // alamatpengiriman
        $this->alamatpengiriman->setDbValueDef($rsnew, $this->alamatpengiriman->CurrentValue, null, false);

        // orderperdana
        $this->orderperdana->setDbValueDef($rsnew, $this->orderperdana->CurrentValue, null, false);

        // orderkontrak
        $this->orderkontrak->setDbValueDef($rsnew, $this->orderkontrak->CurrentValue, null, false);

        // hargaperpcs
        $this->hargaperpcs->setDbValueDef($rsnew, $this->hargaperpcs->CurrentValue, null, false);

        // hargaperkarton
        $this->hargaperkarton->setDbValueDef($rsnew, $this->hargaperkarton->CurrentValue, null, false);

        // lampiran
        if ($this->lampiran->Visible && !$this->lampiran->Upload->KeepFile) {
            $this->lampiran->Upload->DbValue = ""; // No need to delete old file
            if ($this->lampiran->Upload->FileName == "") {
                $rsnew['lampiran'] = null;
            } else {
                $rsnew['lampiran'] = $this->lampiran->Upload->FileName;
            }
        }

        // prepared_by
        $this->prepared_by->setDbValueDef($rsnew, $this->prepared_by->CurrentValue, null, false);

        // checked_by
        $this->checked_by->setDbValueDef($rsnew, $this->checked_by->CurrentValue, null, false);

        // approved_by
        $this->approved_by->setDbValueDef($rsnew, $this->approved_by->CurrentValue, null, false);

        // disetujui
        $this->disetujui->setDbValueDef($rsnew, $this->disetujui->CurrentValue, null, strval($this->disetujui->CurrentValue) == "");

        // updated_at
        $this->updated_at->setDbValueDef($rsnew, UnFormatDateTime($this->updated_at->CurrentValue, 0), CurrentDate(), false);
        if ($this->lampiran->Visible && !$this->lampiran->Upload->KeepFile) {
            $oldFiles = EmptyValue($this->lampiran->Upload->DbValue) ? [] : [$this->lampiran->htmlDecode($this->lampiran->Upload->DbValue)];
            if (!EmptyValue($this->lampiran->Upload->FileName)) {
                $newFiles = [$this->lampiran->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->lampiran, $this->lampiran->Upload->Index);
                        if (file_exists($tempPath . $file)) {
                            if (Config("DELETE_UPLOADED_FILES")) {
                                $oldFileFound = false;
                                $oldFileCount = count($oldFiles);
                                for ($j = 0; $j < $oldFileCount; $j++) {
                                    $oldFile = $oldFiles[$j];
                                    if ($oldFile == $file) { // Old file found, no need to delete anymore
                                        array_splice($oldFiles, $j, 1);
                                        $oldFileFound = true;
                                        break;
                                    }
                                }
                                if ($oldFileFound) { // No need to check if file exists further
                                    continue;
                                }
                            }
                            $file1 = UniqueFilename($this->lampiran->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->lampiran->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->lampiran->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->lampiran->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->lampiran->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->lampiran->setDbValueDef($rsnew, $this->lampiran->Upload->FileName, null, false);
            }
        }

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        $addRow = false;
        if ($insertRow) {
            try {
                $addRow = $this->insert($rsnew);
            } catch (\Exception $e) {
                $this->setFailureMessage($e->getMessage());
            }
            if ($addRow) {
                if ($this->lampiran->Visible && !$this->lampiran->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->lampiran->Upload->DbValue) ? [] : [$this->lampiran->htmlDecode($this->lampiran->Upload->DbValue)];
                    if (!EmptyValue($this->lampiran->Upload->FileName)) {
                        $newFiles = [$this->lampiran->Upload->FileName];
                        $newFiles2 = [$this->lampiran->htmlDecode($rsnew['lampiran'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->lampiran, $this->lampiran->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->lampiran->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
                                        $this->setFailureMessage($Language->phrase("UploadErrMsg7"));
                                        return false;
                                    }
                                }
                            }
                        }
                    } else {
                        $newFiles = [];
                    }
                    if (Config("DELETE_UPLOADED_FILES")) {
                        foreach ($oldFiles as $oldFile) {
                            if ($oldFile != "" && !in_array($oldFile, $newFiles)) {
                                @unlink($this->lampiran->oldPhysicalUploadPath() . $oldFile);
                            }
                        }
                    }
                }
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("InsertCancelled"));
            }
            $addRow = false;
        }
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($addRow) {
            // lampiran
            CleanUploadTempPath($this->lampiran, $this->lampiran->Upload->Index);
        }

        // Write JSON for API request
        if (IsApi() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $addRow;
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
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $Breadcrumb->add("add", $pageId, $url);
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

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in CustomError
        return true;
    }
}
