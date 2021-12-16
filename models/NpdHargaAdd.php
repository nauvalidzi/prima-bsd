<?php

namespace PHPMaker2021\distributor;

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
        $this->bentuk->setVisibility();
        $this->viskositasbarang->setVisibility();
        $this->idaplikasibarang->setVisibility();
        $this->ukuranwadah->setVisibility();
        $this->bahanwadah->setVisibility();
        $this->warnawadah->setVisibility();
        $this->bentukwadah->setVisibility();
        $this->jenistutup->setVisibility();
        $this->bahantutup->setVisibility();
        $this->warnatutup->setVisibility();
        $this->bentuktutup->setVisibility();
        $this->segel->setVisibility();
        $this->catatanprimer->setVisibility();
        $this->packingkarton->setVisibility();
        $this->keteranganpacking->setVisibility();
        $this->beltkarton->setVisibility();
        $this->keteranganbelt->setVisibility();
        $this->bariskarton->setVisibility();
        $this->kolomkarton->setVisibility();
        $this->stackkarton->setVisibility();
        $this->isikarton->setVisibility();
        $this->jenislabel->setVisibility();
        $this->keteranganjenislabel->setVisibility();
        $this->kualitaslabel->setVisibility();
        $this->jumlahwarnalabel->setVisibility();
        $this->etiketlabel->setVisibility();
        $this->keteranganetiket->setVisibility();
        $this->kategoridelivery->setVisibility();
        $this->alamatpengiriman->setVisibility();
        $this->orderperdana->setVisibility();
        $this->orderkontrak->setVisibility();
        $this->hargapcs->setVisibility();
        $this->lampiran->setVisibility();
        $this->disetujui->setVisibility();
        $this->created_at->Visible = false;
        $this->created_by->setVisibility();
        $this->readonly->Visible = false;
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
        $this->setupLookupOptions($this->idaplikasibarang);

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
        $this->tglpengajuan->CurrentValue = null;
        $this->tglpengajuan->OldValue = $this->tglpengajuan->CurrentValue;
        $this->idnpd_sample->CurrentValue = null;
        $this->idnpd_sample->OldValue = $this->idnpd_sample->CurrentValue;
        $this->bentuk->CurrentValue = null;
        $this->bentuk->OldValue = $this->bentuk->CurrentValue;
        $this->viskositasbarang->CurrentValue = null;
        $this->viskositasbarang->OldValue = $this->viskositasbarang->CurrentValue;
        $this->idaplikasibarang->CurrentValue = null;
        $this->idaplikasibarang->OldValue = $this->idaplikasibarang->CurrentValue;
        $this->ukuranwadah->CurrentValue = null;
        $this->ukuranwadah->OldValue = $this->ukuranwadah->CurrentValue;
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
        $this->packingkarton->CurrentValue = null;
        $this->packingkarton->OldValue = $this->packingkarton->CurrentValue;
        $this->keteranganpacking->CurrentValue = null;
        $this->keteranganpacking->OldValue = $this->keteranganpacking->CurrentValue;
        $this->beltkarton->CurrentValue = null;
        $this->beltkarton->OldValue = $this->beltkarton->CurrentValue;
        $this->keteranganbelt->CurrentValue = null;
        $this->keteranganbelt->OldValue = $this->keteranganbelt->CurrentValue;
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
        $this->etiketlabel->CurrentValue = null;
        $this->etiketlabel->OldValue = $this->etiketlabel->CurrentValue;
        $this->keteranganetiket->CurrentValue = null;
        $this->keteranganetiket->OldValue = $this->keteranganetiket->CurrentValue;
        $this->kategoridelivery->CurrentValue = null;
        $this->kategoridelivery->OldValue = $this->kategoridelivery->CurrentValue;
        $this->alamatpengiriman->CurrentValue = null;
        $this->alamatpengiriman->OldValue = $this->alamatpengiriman->CurrentValue;
        $this->orderperdana->CurrentValue = null;
        $this->orderperdana->OldValue = $this->orderperdana->CurrentValue;
        $this->orderkontrak->CurrentValue = null;
        $this->orderkontrak->OldValue = $this->orderkontrak->CurrentValue;
        $this->hargapcs->CurrentValue = null;
        $this->hargapcs->OldValue = $this->hargapcs->CurrentValue;
        $this->lampiran->Upload->DbValue = null;
        $this->lampiran->OldValue = $this->lampiran->Upload->DbValue;
        $this->lampiran->CurrentValue = null; // Clear file related field
        $this->disetujui->CurrentValue = 1;
        $this->created_at->CurrentValue = null;
        $this->created_at->OldValue = $this->created_at->CurrentValue;
        $this->created_by->CurrentValue = CurrentUserID();
        $this->readonly->CurrentValue = 0;
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

        // Check field name 'bentuk' first before field var 'x_bentuk'
        $val = $CurrentForm->hasValue("bentuk") ? $CurrentForm->getValue("bentuk") : $CurrentForm->getValue("x_bentuk");
        if (!$this->bentuk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bentuk->Visible = false; // Disable update for API request
            } else {
                $this->bentuk->setFormValue($val);
            }
        }

        // Check field name 'viskositasbarang' first before field var 'x_viskositasbarang'
        $val = $CurrentForm->hasValue("viskositasbarang") ? $CurrentForm->getValue("viskositasbarang") : $CurrentForm->getValue("x_viskositasbarang");
        if (!$this->viskositasbarang->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->viskositasbarang->Visible = false; // Disable update for API request
            } else {
                $this->viskositasbarang->setFormValue($val);
            }
        }

        // Check field name 'idaplikasibarang' first before field var 'x_idaplikasibarang'
        $val = $CurrentForm->hasValue("idaplikasibarang") ? $CurrentForm->getValue("idaplikasibarang") : $CurrentForm->getValue("x_idaplikasibarang");
        if (!$this->idaplikasibarang->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idaplikasibarang->Visible = false; // Disable update for API request
            } else {
                $this->idaplikasibarang->setFormValue($val);
            }
        }

        // Check field name 'ukuranwadah' first before field var 'x_ukuranwadah'
        $val = $CurrentForm->hasValue("ukuranwadah") ? $CurrentForm->getValue("ukuranwadah") : $CurrentForm->getValue("x_ukuranwadah");
        if (!$this->ukuranwadah->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ukuranwadah->Visible = false; // Disable update for API request
            } else {
                $this->ukuranwadah->setFormValue($val);
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

        // Check field name 'packingkarton' first before field var 'x_packingkarton'
        $val = $CurrentForm->hasValue("packingkarton") ? $CurrentForm->getValue("packingkarton") : $CurrentForm->getValue("x_packingkarton");
        if (!$this->packingkarton->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->packingkarton->Visible = false; // Disable update for API request
            } else {
                $this->packingkarton->setFormValue($val);
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

        // Check field name 'etiketlabel' first before field var 'x_etiketlabel'
        $val = $CurrentForm->hasValue("etiketlabel") ? $CurrentForm->getValue("etiketlabel") : $CurrentForm->getValue("x_etiketlabel");
        if (!$this->etiketlabel->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->etiketlabel->Visible = false; // Disable update for API request
            } else {
                $this->etiketlabel->setFormValue($val);
            }
        }

        // Check field name 'keteranganetiket' first before field var 'x_keteranganetiket'
        $val = $CurrentForm->hasValue("keteranganetiket") ? $CurrentForm->getValue("keteranganetiket") : $CurrentForm->getValue("x_keteranganetiket");
        if (!$this->keteranganetiket->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->keteranganetiket->Visible = false; // Disable update for API request
            } else {
                $this->keteranganetiket->setFormValue($val);
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

        // Check field name 'hargapcs' first before field var 'x_hargapcs'
        $val = $CurrentForm->hasValue("hargapcs") ? $CurrentForm->getValue("hargapcs") : $CurrentForm->getValue("x_hargapcs");
        if (!$this->hargapcs->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hargapcs->Visible = false; // Disable update for API request
            } else {
                $this->hargapcs->setFormValue($val);
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

        // Check field name 'created_by' first before field var 'x_created_by'
        $val = $CurrentForm->hasValue("created_by") ? $CurrentForm->getValue("created_by") : $CurrentForm->getValue("x_created_by");
        if (!$this->created_by->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->created_by->Visible = false; // Disable update for API request
            } else {
                $this->created_by->setFormValue($val);
            }
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
        $this->bentuk->CurrentValue = $this->bentuk->FormValue;
        $this->viskositasbarang->CurrentValue = $this->viskositasbarang->FormValue;
        $this->idaplikasibarang->CurrentValue = $this->idaplikasibarang->FormValue;
        $this->ukuranwadah->CurrentValue = $this->ukuranwadah->FormValue;
        $this->bahanwadah->CurrentValue = $this->bahanwadah->FormValue;
        $this->warnawadah->CurrentValue = $this->warnawadah->FormValue;
        $this->bentukwadah->CurrentValue = $this->bentukwadah->FormValue;
        $this->jenistutup->CurrentValue = $this->jenistutup->FormValue;
        $this->bahantutup->CurrentValue = $this->bahantutup->FormValue;
        $this->warnatutup->CurrentValue = $this->warnatutup->FormValue;
        $this->bentuktutup->CurrentValue = $this->bentuktutup->FormValue;
        $this->segel->CurrentValue = $this->segel->FormValue;
        $this->catatanprimer->CurrentValue = $this->catatanprimer->FormValue;
        $this->packingkarton->CurrentValue = $this->packingkarton->FormValue;
        $this->keteranganpacking->CurrentValue = $this->keteranganpacking->FormValue;
        $this->beltkarton->CurrentValue = $this->beltkarton->FormValue;
        $this->keteranganbelt->CurrentValue = $this->keteranganbelt->FormValue;
        $this->bariskarton->CurrentValue = $this->bariskarton->FormValue;
        $this->kolomkarton->CurrentValue = $this->kolomkarton->FormValue;
        $this->stackkarton->CurrentValue = $this->stackkarton->FormValue;
        $this->isikarton->CurrentValue = $this->isikarton->FormValue;
        $this->jenislabel->CurrentValue = $this->jenislabel->FormValue;
        $this->keteranganjenislabel->CurrentValue = $this->keteranganjenislabel->FormValue;
        $this->kualitaslabel->CurrentValue = $this->kualitaslabel->FormValue;
        $this->jumlahwarnalabel->CurrentValue = $this->jumlahwarnalabel->FormValue;
        $this->etiketlabel->CurrentValue = $this->etiketlabel->FormValue;
        $this->keteranganetiket->CurrentValue = $this->keteranganetiket->FormValue;
        $this->kategoridelivery->CurrentValue = $this->kategoridelivery->FormValue;
        $this->alamatpengiriman->CurrentValue = $this->alamatpengiriman->FormValue;
        $this->orderperdana->CurrentValue = $this->orderperdana->FormValue;
        $this->orderkontrak->CurrentValue = $this->orderkontrak->FormValue;
        $this->hargapcs->CurrentValue = $this->hargapcs->FormValue;
        $this->disetujui->CurrentValue = $this->disetujui->FormValue;
        $this->created_by->CurrentValue = $this->created_by->FormValue;
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

        // Check if valid User ID
        if ($res) {
            $res = $this->showOptionLink("add");
            if (!$res) {
                $userIdMsg = DeniedMessage();
                $this->setFailureMessage($userIdMsg);
            }
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
        $this->bentuk->setDbValue($row['bentuk']);
        $this->viskositasbarang->setDbValue($row['viskositasbarang']);
        $this->idaplikasibarang->setDbValue($row['idaplikasibarang']);
        $this->ukuranwadah->setDbValue($row['ukuranwadah']);
        $this->bahanwadah->setDbValue($row['bahanwadah']);
        $this->warnawadah->setDbValue($row['warnawadah']);
        $this->bentukwadah->setDbValue($row['bentukwadah']);
        $this->jenistutup->setDbValue($row['jenistutup']);
        $this->bahantutup->setDbValue($row['bahantutup']);
        $this->warnatutup->setDbValue($row['warnatutup']);
        $this->bentuktutup->setDbValue($row['bentuktutup']);
        $this->segel->setDbValue($row['segel']);
        $this->catatanprimer->setDbValue($row['catatanprimer']);
        $this->packingkarton->setDbValue($row['packingkarton']);
        $this->keteranganpacking->setDbValue($row['keteranganpacking']);
        $this->beltkarton->setDbValue($row['beltkarton']);
        $this->keteranganbelt->setDbValue($row['keteranganbelt']);
        $this->bariskarton->setDbValue($row['bariskarton']);
        $this->kolomkarton->setDbValue($row['kolomkarton']);
        $this->stackkarton->setDbValue($row['stackkarton']);
        $this->isikarton->setDbValue($row['isikarton']);
        $this->jenislabel->setDbValue($row['jenislabel']);
        $this->keteranganjenislabel->setDbValue($row['keteranganjenislabel']);
        $this->kualitaslabel->setDbValue($row['kualitaslabel']);
        $this->jumlahwarnalabel->setDbValue($row['jumlahwarnalabel']);
        $this->etiketlabel->setDbValue($row['etiketlabel']);
        $this->keteranganetiket->setDbValue($row['keteranganetiket']);
        $this->kategoridelivery->setDbValue($row['kategoridelivery']);
        $this->alamatpengiriman->setDbValue($row['alamatpengiriman']);
        $this->orderperdana->setDbValue($row['orderperdana']);
        $this->orderkontrak->setDbValue($row['orderkontrak']);
        $this->hargapcs->setDbValue($row['hargapcs']);
        $this->lampiran->Upload->DbValue = $row['lampiran'];
        $this->lampiran->setDbValue($this->lampiran->Upload->DbValue);
        $this->disetujui->setDbValue($row['disetujui']);
        $this->created_at->setDbValue($row['created_at']);
        $this->created_by->setDbValue($row['created_by']);
        $this->readonly->setDbValue($row['readonly']);
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
        $row['bentuk'] = $this->bentuk->CurrentValue;
        $row['viskositasbarang'] = $this->viskositasbarang->CurrentValue;
        $row['idaplikasibarang'] = $this->idaplikasibarang->CurrentValue;
        $row['ukuranwadah'] = $this->ukuranwadah->CurrentValue;
        $row['bahanwadah'] = $this->bahanwadah->CurrentValue;
        $row['warnawadah'] = $this->warnawadah->CurrentValue;
        $row['bentukwadah'] = $this->bentukwadah->CurrentValue;
        $row['jenistutup'] = $this->jenistutup->CurrentValue;
        $row['bahantutup'] = $this->bahantutup->CurrentValue;
        $row['warnatutup'] = $this->warnatutup->CurrentValue;
        $row['bentuktutup'] = $this->bentuktutup->CurrentValue;
        $row['segel'] = $this->segel->CurrentValue;
        $row['catatanprimer'] = $this->catatanprimer->CurrentValue;
        $row['packingkarton'] = $this->packingkarton->CurrentValue;
        $row['keteranganpacking'] = $this->keteranganpacking->CurrentValue;
        $row['beltkarton'] = $this->beltkarton->CurrentValue;
        $row['keteranganbelt'] = $this->keteranganbelt->CurrentValue;
        $row['bariskarton'] = $this->bariskarton->CurrentValue;
        $row['kolomkarton'] = $this->kolomkarton->CurrentValue;
        $row['stackkarton'] = $this->stackkarton->CurrentValue;
        $row['isikarton'] = $this->isikarton->CurrentValue;
        $row['jenislabel'] = $this->jenislabel->CurrentValue;
        $row['keteranganjenislabel'] = $this->keteranganjenislabel->CurrentValue;
        $row['kualitaslabel'] = $this->kualitaslabel->CurrentValue;
        $row['jumlahwarnalabel'] = $this->jumlahwarnalabel->CurrentValue;
        $row['etiketlabel'] = $this->etiketlabel->CurrentValue;
        $row['keteranganetiket'] = $this->keteranganetiket->CurrentValue;
        $row['kategoridelivery'] = $this->kategoridelivery->CurrentValue;
        $row['alamatpengiriman'] = $this->alamatpengiriman->CurrentValue;
        $row['orderperdana'] = $this->orderperdana->CurrentValue;
        $row['orderkontrak'] = $this->orderkontrak->CurrentValue;
        $row['hargapcs'] = $this->hargapcs->CurrentValue;
        $row['lampiran'] = $this->lampiran->Upload->DbValue;
        $row['disetujui'] = $this->disetujui->CurrentValue;
        $row['created_at'] = $this->created_at->CurrentValue;
        $row['created_by'] = $this->created_by->CurrentValue;
        $row['readonly'] = $this->readonly->CurrentValue;
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

        // bentuk

        // viskositasbarang

        // idaplikasibarang

        // ukuranwadah

        // bahanwadah

        // warnawadah

        // bentukwadah

        // jenistutup

        // bahantutup

        // warnatutup

        // bentuktutup

        // segel

        // catatanprimer

        // packingkarton

        // keteranganpacking

        // beltkarton

        // keteranganbelt

        // bariskarton

        // kolomkarton

        // stackkarton

        // isikarton

        // jenislabel

        // keteranganjenislabel

        // kualitaslabel

        // jumlahwarnalabel

        // etiketlabel

        // keteranganetiket

        // kategoridelivery

        // alamatpengiriman

        // orderperdana

        // orderkontrak

        // hargapcs

        // lampiran

        // disetujui

        // created_at

        // created_by

        // readonly
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
                        return "`id` IN (SELECT `idnpd` FROM `npd_confirm`)";
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
                        return CurrentPageID() == "add" ? "id IN (SELECT idnpd_sample FROM npd_confirm WHERE readonly=0)" : "";
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

            // bentuk
            $this->bentuk->ViewValue = $this->bentuk->CurrentValue;
            $this->bentuk->ViewCustomAttributes = "";

            // viskositasbarang
            $this->viskositasbarang->ViewValue = $this->viskositasbarang->CurrentValue;
            $this->viskositasbarang->ViewCustomAttributes = "";

            // idaplikasibarang
            $curVal = trim(strval($this->idaplikasibarang->CurrentValue));
            if ($curVal != "") {
                $this->idaplikasibarang->ViewValue = $this->idaplikasibarang->lookupCacheOption($curVal);
                if ($this->idaplikasibarang->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->idaplikasibarang->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idaplikasibarang->Lookup->renderViewRow($rswrk[0]);
                        $this->idaplikasibarang->ViewValue = $this->idaplikasibarang->displayValue($arwrk);
                    } else {
                        $this->idaplikasibarang->ViewValue = $this->idaplikasibarang->CurrentValue;
                    }
                }
            } else {
                $this->idaplikasibarang->ViewValue = null;
            }
            $this->idaplikasibarang->ViewCustomAttributes = "";

            // ukuranwadah
            $this->ukuranwadah->ViewValue = $this->ukuranwadah->CurrentValue;
            $this->ukuranwadah->ViewCustomAttributes = "";

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

            // packingkarton
            $this->packingkarton->ViewValue = $this->packingkarton->CurrentValue;
            $this->packingkarton->ViewCustomAttributes = "";

            // keteranganpacking
            $this->keteranganpacking->ViewValue = $this->keteranganpacking->CurrentValue;
            $this->keteranganpacking->ViewCustomAttributes = "";

            // beltkarton
            $this->beltkarton->ViewValue = $this->beltkarton->CurrentValue;
            $this->beltkarton->ViewCustomAttributes = "";

            // keteranganbelt
            $this->keteranganbelt->ViewValue = $this->keteranganbelt->CurrentValue;
            $this->keteranganbelt->ViewCustomAttributes = "";

            // bariskarton
            $this->bariskarton->ViewValue = $this->bariskarton->CurrentValue;
            $this->bariskarton->ViewValue = FormatNumber($this->bariskarton->ViewValue, 0, -2, -2, -2);
            $this->bariskarton->ViewCustomAttributes = "";

            // kolomkarton
            $this->kolomkarton->ViewValue = $this->kolomkarton->CurrentValue;
            $this->kolomkarton->ViewValue = FormatNumber($this->kolomkarton->ViewValue, 0, -2, -2, -2);
            $this->kolomkarton->ViewCustomAttributes = "";

            // stackkarton
            $this->stackkarton->ViewValue = $this->stackkarton->CurrentValue;
            $this->stackkarton->ViewValue = FormatNumber($this->stackkarton->ViewValue, 0, -2, -2, -2);
            $this->stackkarton->ViewCustomAttributes = "";

            // isikarton
            $this->isikarton->ViewValue = $this->isikarton->CurrentValue;
            $this->isikarton->ViewValue = FormatNumber($this->isikarton->ViewValue, 0, -2, -2, -2);
            $this->isikarton->ViewCustomAttributes = "";

            // jenislabel
            $this->jenislabel->ViewValue = $this->jenislabel->CurrentValue;
            $this->jenislabel->ViewCustomAttributes = "";

            // keteranganjenislabel
            $this->keteranganjenislabel->ViewValue = $this->keteranganjenislabel->CurrentValue;
            $this->keteranganjenislabel->ViewCustomAttributes = "";

            // kualitaslabel
            $this->kualitaslabel->ViewValue = $this->kualitaslabel->CurrentValue;
            $this->kualitaslabel->ViewCustomAttributes = "";

            // jumlahwarnalabel
            $this->jumlahwarnalabel->ViewValue = $this->jumlahwarnalabel->CurrentValue;
            $this->jumlahwarnalabel->ViewCustomAttributes = "";

            // etiketlabel
            $this->etiketlabel->ViewValue = $this->etiketlabel->CurrentValue;
            $this->etiketlabel->ViewCustomAttributes = "";

            // keteranganetiket
            $this->keteranganetiket->ViewValue = $this->keteranganetiket->CurrentValue;
            $this->keteranganetiket->ViewCustomAttributes = "";

            // kategoridelivery
            $this->kategoridelivery->ViewValue = $this->kategoridelivery->CurrentValue;
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

            // hargapcs
            $this->hargapcs->ViewValue = $this->hargapcs->CurrentValue;
            $this->hargapcs->ViewValue = FormatCurrency($this->hargapcs->ViewValue, 2, -2, -2, -2);
            $this->hargapcs->ViewCustomAttributes = "";

            // lampiran
            if (!EmptyValue($this->lampiran->Upload->DbValue)) {
                $this->lampiran->ViewValue = $this->lampiran->Upload->DbValue;
            } else {
                $this->lampiran->ViewValue = "";
            }
            $this->lampiran->ViewCustomAttributes = "";

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

            // created_by
            $this->created_by->ViewValue = $this->created_by->CurrentValue;
            $this->created_by->ViewValue = FormatNumber($this->created_by->ViewValue, 0, -2, -2, -2);
            $this->created_by->ViewCustomAttributes = "";

            // readonly
            if (ConvertToBool($this->readonly->CurrentValue)) {
                $this->readonly->ViewValue = $this->readonly->tagCaption(1) != "" ? $this->readonly->tagCaption(1) : "Yes";
            } else {
                $this->readonly->ViewValue = $this->readonly->tagCaption(2) != "" ? $this->readonly->tagCaption(2) : "No";
            }
            $this->readonly->ViewCustomAttributes = "";

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

            // bentuk
            $this->bentuk->LinkCustomAttributes = "";
            $this->bentuk->HrefValue = "";
            $this->bentuk->TooltipValue = "";

            // viskositasbarang
            $this->viskositasbarang->LinkCustomAttributes = "";
            $this->viskositasbarang->HrefValue = "";
            $this->viskositasbarang->TooltipValue = "";

            // idaplikasibarang
            $this->idaplikasibarang->LinkCustomAttributes = "";
            $this->idaplikasibarang->HrefValue = "";
            $this->idaplikasibarang->TooltipValue = "";

            // ukuranwadah
            $this->ukuranwadah->LinkCustomAttributes = "";
            $this->ukuranwadah->HrefValue = "";
            $this->ukuranwadah->TooltipValue = "";

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

            // packingkarton
            $this->packingkarton->LinkCustomAttributes = "";
            $this->packingkarton->HrefValue = "";
            $this->packingkarton->TooltipValue = "";

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

            // etiketlabel
            $this->etiketlabel->LinkCustomAttributes = "";
            $this->etiketlabel->HrefValue = "";
            $this->etiketlabel->TooltipValue = "";

            // keteranganetiket
            $this->keteranganetiket->LinkCustomAttributes = "";
            $this->keteranganetiket->HrefValue = "";
            $this->keteranganetiket->TooltipValue = "";

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

            // hargapcs
            $this->hargapcs->LinkCustomAttributes = "";
            $this->hargapcs->HrefValue = "";
            $this->hargapcs->TooltipValue = "";

            // lampiran
            $this->lampiran->LinkCustomAttributes = "";
            $this->lampiran->HrefValue = "";
            $this->lampiran->ExportHrefValue = $this->lampiran->UploadPath . $this->lampiran->Upload->DbValue;
            $this->lampiran->TooltipValue = "";

            // disetujui
            $this->disetujui->LinkCustomAttributes = "";
            $this->disetujui->HrefValue = "";
            $this->disetujui->TooltipValue = "";

            // created_by
            $this->created_by->LinkCustomAttributes = "";
            $this->created_by->HrefValue = "";
            $this->created_by->TooltipValue = "";
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
                            return "`id` IN (SELECT `idnpd` FROM `npd_confirm`)";
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
                        return "`id` IN (SELECT `idnpd` FROM `npd_confirm`)";
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
                    return CurrentPageID() == "add" ? "id IN (SELECT idnpd_sample FROM npd_confirm WHERE readonly=0)" : "";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->idnpd_sample->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idnpd_sample->EditValue = $arwrk;
            }
            $this->idnpd_sample->PlaceHolder = RemoveHtml($this->idnpd_sample->caption());

            // bentuk
            $this->bentuk->EditAttrs["class"] = "form-control";
            $this->bentuk->EditCustomAttributes = "";
            if (!$this->bentuk->Raw) {
                $this->bentuk->CurrentValue = HtmlDecode($this->bentuk->CurrentValue);
            }
            $this->bentuk->EditValue = HtmlEncode($this->bentuk->CurrentValue);
            $this->bentuk->PlaceHolder = RemoveHtml($this->bentuk->caption());

            // viskositasbarang
            $this->viskositasbarang->EditAttrs["class"] = "form-control";
            $this->viskositasbarang->EditCustomAttributes = "";
            if (!$this->viskositasbarang->Raw) {
                $this->viskositasbarang->CurrentValue = HtmlDecode($this->viskositasbarang->CurrentValue);
            }
            $this->viskositasbarang->EditValue = HtmlEncode($this->viskositasbarang->CurrentValue);
            $this->viskositasbarang->PlaceHolder = RemoveHtml($this->viskositasbarang->caption());

            // idaplikasibarang
            $this->idaplikasibarang->EditAttrs["class"] = "form-control";
            $this->idaplikasibarang->EditCustomAttributes = "";
            $curVal = trim(strval($this->idaplikasibarang->CurrentValue));
            if ($curVal != "") {
                $this->idaplikasibarang->ViewValue = $this->idaplikasibarang->lookupCacheOption($curVal);
            } else {
                $this->idaplikasibarang->ViewValue = $this->idaplikasibarang->Lookup !== null && is_array($this->idaplikasibarang->Lookup->Options) ? $curVal : null;
            }
            if ($this->idaplikasibarang->ViewValue !== null) { // Load from cache
                $this->idaplikasibarang->EditValue = array_values($this->idaplikasibarang->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idaplikasibarang->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->idaplikasibarang->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idaplikasibarang->EditValue = $arwrk;
            }
            $this->idaplikasibarang->PlaceHolder = RemoveHtml($this->idaplikasibarang->caption());

            // ukuranwadah
            $this->ukuranwadah->EditAttrs["class"] = "form-control";
            $this->ukuranwadah->EditCustomAttributes = "";
            if (!$this->ukuranwadah->Raw) {
                $this->ukuranwadah->CurrentValue = HtmlDecode($this->ukuranwadah->CurrentValue);
            }
            $this->ukuranwadah->EditValue = HtmlEncode($this->ukuranwadah->CurrentValue);
            $this->ukuranwadah->PlaceHolder = RemoveHtml($this->ukuranwadah->caption());

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

            // packingkarton
            $this->packingkarton->EditAttrs["class"] = "form-control";
            $this->packingkarton->EditCustomAttributes = "";
            if (!$this->packingkarton->Raw) {
                $this->packingkarton->CurrentValue = HtmlDecode($this->packingkarton->CurrentValue);
            }
            $this->packingkarton->EditValue = HtmlEncode($this->packingkarton->CurrentValue);
            $this->packingkarton->PlaceHolder = RemoveHtml($this->packingkarton->caption());

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

            // bariskarton
            $this->bariskarton->EditAttrs["class"] = "form-control";
            $this->bariskarton->EditCustomAttributes = "";
            $this->bariskarton->EditValue = HtmlEncode($this->bariskarton->CurrentValue);
            $this->bariskarton->PlaceHolder = RemoveHtml($this->bariskarton->caption());

            // kolomkarton
            $this->kolomkarton->EditAttrs["class"] = "form-control";
            $this->kolomkarton->EditCustomAttributes = "";
            $this->kolomkarton->EditValue = HtmlEncode($this->kolomkarton->CurrentValue);
            $this->kolomkarton->PlaceHolder = RemoveHtml($this->kolomkarton->caption());

            // stackkarton
            $this->stackkarton->EditAttrs["class"] = "form-control";
            $this->stackkarton->EditCustomAttributes = "";
            $this->stackkarton->EditValue = HtmlEncode($this->stackkarton->CurrentValue);
            $this->stackkarton->PlaceHolder = RemoveHtml($this->stackkarton->caption());

            // isikarton
            $this->isikarton->EditAttrs["class"] = "form-control";
            $this->isikarton->EditCustomAttributes = "";
            $this->isikarton->EditValue = HtmlEncode($this->isikarton->CurrentValue);
            $this->isikarton->PlaceHolder = RemoveHtml($this->isikarton->caption());

            // jenislabel
            $this->jenislabel->EditAttrs["class"] = "form-control";
            $this->jenislabel->EditCustomAttributes = "";
            if (!$this->jenislabel->Raw) {
                $this->jenislabel->CurrentValue = HtmlDecode($this->jenislabel->CurrentValue);
            }
            $this->jenislabel->EditValue = HtmlEncode($this->jenislabel->CurrentValue);
            $this->jenislabel->PlaceHolder = RemoveHtml($this->jenislabel->caption());

            // keteranganjenislabel
            $this->keteranganjenislabel->EditAttrs["class"] = "form-control";
            $this->keteranganjenislabel->EditCustomAttributes = "";
            $this->keteranganjenislabel->EditValue = HtmlEncode($this->keteranganjenislabel->CurrentValue);
            $this->keteranganjenislabel->PlaceHolder = RemoveHtml($this->keteranganjenislabel->caption());

            // kualitaslabel
            $this->kualitaslabel->EditAttrs["class"] = "form-control";
            $this->kualitaslabel->EditCustomAttributes = "";
            if (!$this->kualitaslabel->Raw) {
                $this->kualitaslabel->CurrentValue = HtmlDecode($this->kualitaslabel->CurrentValue);
            }
            $this->kualitaslabel->EditValue = HtmlEncode($this->kualitaslabel->CurrentValue);
            $this->kualitaslabel->PlaceHolder = RemoveHtml($this->kualitaslabel->caption());

            // jumlahwarnalabel
            $this->jumlahwarnalabel->EditAttrs["class"] = "form-control";
            $this->jumlahwarnalabel->EditCustomAttributes = "";
            if (!$this->jumlahwarnalabel->Raw) {
                $this->jumlahwarnalabel->CurrentValue = HtmlDecode($this->jumlahwarnalabel->CurrentValue);
            }
            $this->jumlahwarnalabel->EditValue = HtmlEncode($this->jumlahwarnalabel->CurrentValue);
            $this->jumlahwarnalabel->PlaceHolder = RemoveHtml($this->jumlahwarnalabel->caption());

            // etiketlabel
            $this->etiketlabel->EditAttrs["class"] = "form-control";
            $this->etiketlabel->EditCustomAttributes = "";
            if (!$this->etiketlabel->Raw) {
                $this->etiketlabel->CurrentValue = HtmlDecode($this->etiketlabel->CurrentValue);
            }
            $this->etiketlabel->EditValue = HtmlEncode($this->etiketlabel->CurrentValue);
            $this->etiketlabel->PlaceHolder = RemoveHtml($this->etiketlabel->caption());

            // keteranganetiket
            $this->keteranganetiket->EditAttrs["class"] = "form-control";
            $this->keteranganetiket->EditCustomAttributes = "";
            $this->keteranganetiket->EditValue = HtmlEncode($this->keteranganetiket->CurrentValue);
            $this->keteranganetiket->PlaceHolder = RemoveHtml($this->keteranganetiket->caption());

            // kategoridelivery
            $this->kategoridelivery->EditAttrs["class"] = "form-control";
            $this->kategoridelivery->EditCustomAttributes = "";
            if (!$this->kategoridelivery->Raw) {
                $this->kategoridelivery->CurrentValue = HtmlDecode($this->kategoridelivery->CurrentValue);
            }
            $this->kategoridelivery->EditValue = HtmlEncode($this->kategoridelivery->CurrentValue);
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

            // hargapcs
            $this->hargapcs->EditAttrs["class"] = "form-control";
            $this->hargapcs->EditCustomAttributes = "";
            $this->hargapcs->EditValue = HtmlEncode($this->hargapcs->CurrentValue);
            $this->hargapcs->PlaceHolder = RemoveHtml($this->hargapcs->caption());

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

            // disetujui
            $this->disetujui->EditCustomAttributes = "";
            $this->disetujui->EditValue = $this->disetujui->options(false);
            $this->disetujui->PlaceHolder = RemoveHtml($this->disetujui->caption());

            // created_by
            $this->created_by->EditAttrs["class"] = "form-control";
            $this->created_by->EditCustomAttributes = "";
            $this->created_by->CurrentValue = CurrentUserID();

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

            // bentuk
            $this->bentuk->LinkCustomAttributes = "";
            $this->bentuk->HrefValue = "";

            // viskositasbarang
            $this->viskositasbarang->LinkCustomAttributes = "";
            $this->viskositasbarang->HrefValue = "";

            // idaplikasibarang
            $this->idaplikasibarang->LinkCustomAttributes = "";
            $this->idaplikasibarang->HrefValue = "";

            // ukuranwadah
            $this->ukuranwadah->LinkCustomAttributes = "";
            $this->ukuranwadah->HrefValue = "";

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

            // packingkarton
            $this->packingkarton->LinkCustomAttributes = "";
            $this->packingkarton->HrefValue = "";

            // keteranganpacking
            $this->keteranganpacking->LinkCustomAttributes = "";
            $this->keteranganpacking->HrefValue = "";

            // beltkarton
            $this->beltkarton->LinkCustomAttributes = "";
            $this->beltkarton->HrefValue = "";

            // keteranganbelt
            $this->keteranganbelt->LinkCustomAttributes = "";
            $this->keteranganbelt->HrefValue = "";

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

            // etiketlabel
            $this->etiketlabel->LinkCustomAttributes = "";
            $this->etiketlabel->HrefValue = "";

            // keteranganetiket
            $this->keteranganetiket->LinkCustomAttributes = "";
            $this->keteranganetiket->HrefValue = "";

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

            // hargapcs
            $this->hargapcs->LinkCustomAttributes = "";
            $this->hargapcs->HrefValue = "";

            // lampiran
            $this->lampiran->LinkCustomAttributes = "";
            $this->lampiran->HrefValue = "";
            $this->lampiran->ExportHrefValue = $this->lampiran->UploadPath . $this->lampiran->Upload->DbValue;

            // disetujui
            $this->disetujui->LinkCustomAttributes = "";
            $this->disetujui->HrefValue = "";

            // created_by
            $this->created_by->LinkCustomAttributes = "";
            $this->created_by->HrefValue = "";
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
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
        if ($this->bentuk->Required) {
            if (!$this->bentuk->IsDetailKey && EmptyValue($this->bentuk->FormValue)) {
                $this->bentuk->addErrorMessage(str_replace("%s", $this->bentuk->caption(), $this->bentuk->RequiredErrorMessage));
            }
        }
        if ($this->viskositasbarang->Required) {
            if (!$this->viskositasbarang->IsDetailKey && EmptyValue($this->viskositasbarang->FormValue)) {
                $this->viskositasbarang->addErrorMessage(str_replace("%s", $this->viskositasbarang->caption(), $this->viskositasbarang->RequiredErrorMessage));
            }
        }
        if ($this->idaplikasibarang->Required) {
            if (!$this->idaplikasibarang->IsDetailKey && EmptyValue($this->idaplikasibarang->FormValue)) {
                $this->idaplikasibarang->addErrorMessage(str_replace("%s", $this->idaplikasibarang->caption(), $this->idaplikasibarang->RequiredErrorMessage));
            }
        }
        if ($this->ukuranwadah->Required) {
            if (!$this->ukuranwadah->IsDetailKey && EmptyValue($this->ukuranwadah->FormValue)) {
                $this->ukuranwadah->addErrorMessage(str_replace("%s", $this->ukuranwadah->caption(), $this->ukuranwadah->RequiredErrorMessage));
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
        if ($this->packingkarton->Required) {
            if (!$this->packingkarton->IsDetailKey && EmptyValue($this->packingkarton->FormValue)) {
                $this->packingkarton->addErrorMessage(str_replace("%s", $this->packingkarton->caption(), $this->packingkarton->RequiredErrorMessage));
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
        if ($this->bariskarton->Required) {
            if (!$this->bariskarton->IsDetailKey && EmptyValue($this->bariskarton->FormValue)) {
                $this->bariskarton->addErrorMessage(str_replace("%s", $this->bariskarton->caption(), $this->bariskarton->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->bariskarton->FormValue)) {
            $this->bariskarton->addErrorMessage($this->bariskarton->getErrorMessage(false));
        }
        if ($this->kolomkarton->Required) {
            if (!$this->kolomkarton->IsDetailKey && EmptyValue($this->kolomkarton->FormValue)) {
                $this->kolomkarton->addErrorMessage(str_replace("%s", $this->kolomkarton->caption(), $this->kolomkarton->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->kolomkarton->FormValue)) {
            $this->kolomkarton->addErrorMessage($this->kolomkarton->getErrorMessage(false));
        }
        if ($this->stackkarton->Required) {
            if (!$this->stackkarton->IsDetailKey && EmptyValue($this->stackkarton->FormValue)) {
                $this->stackkarton->addErrorMessage(str_replace("%s", $this->stackkarton->caption(), $this->stackkarton->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->stackkarton->FormValue)) {
            $this->stackkarton->addErrorMessage($this->stackkarton->getErrorMessage(false));
        }
        if ($this->isikarton->Required) {
            if (!$this->isikarton->IsDetailKey && EmptyValue($this->isikarton->FormValue)) {
                $this->isikarton->addErrorMessage(str_replace("%s", $this->isikarton->caption(), $this->isikarton->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->isikarton->FormValue)) {
            $this->isikarton->addErrorMessage($this->isikarton->getErrorMessage(false));
        }
        if ($this->jenislabel->Required) {
            if (!$this->jenislabel->IsDetailKey && EmptyValue($this->jenislabel->FormValue)) {
                $this->jenislabel->addErrorMessage(str_replace("%s", $this->jenislabel->caption(), $this->jenislabel->RequiredErrorMessage));
            }
        }
        if ($this->keteranganjenislabel->Required) {
            if (!$this->keteranganjenislabel->IsDetailKey && EmptyValue($this->keteranganjenislabel->FormValue)) {
                $this->keteranganjenislabel->addErrorMessage(str_replace("%s", $this->keteranganjenislabel->caption(), $this->keteranganjenislabel->RequiredErrorMessage));
            }
        }
        if ($this->kualitaslabel->Required) {
            if (!$this->kualitaslabel->IsDetailKey && EmptyValue($this->kualitaslabel->FormValue)) {
                $this->kualitaslabel->addErrorMessage(str_replace("%s", $this->kualitaslabel->caption(), $this->kualitaslabel->RequiredErrorMessage));
            }
        }
        if ($this->jumlahwarnalabel->Required) {
            if (!$this->jumlahwarnalabel->IsDetailKey && EmptyValue($this->jumlahwarnalabel->FormValue)) {
                $this->jumlahwarnalabel->addErrorMessage(str_replace("%s", $this->jumlahwarnalabel->caption(), $this->jumlahwarnalabel->RequiredErrorMessage));
            }
        }
        if ($this->etiketlabel->Required) {
            if (!$this->etiketlabel->IsDetailKey && EmptyValue($this->etiketlabel->FormValue)) {
                $this->etiketlabel->addErrorMessage(str_replace("%s", $this->etiketlabel->caption(), $this->etiketlabel->RequiredErrorMessage));
            }
        }
        if ($this->keteranganetiket->Required) {
            if (!$this->keteranganetiket->IsDetailKey && EmptyValue($this->keteranganetiket->FormValue)) {
                $this->keteranganetiket->addErrorMessage(str_replace("%s", $this->keteranganetiket->caption(), $this->keteranganetiket->RequiredErrorMessage));
            }
        }
        if ($this->kategoridelivery->Required) {
            if (!$this->kategoridelivery->IsDetailKey && EmptyValue($this->kategoridelivery->FormValue)) {
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
        if ($this->hargapcs->Required) {
            if (!$this->hargapcs->IsDetailKey && EmptyValue($this->hargapcs->FormValue)) {
                $this->hargapcs->addErrorMessage(str_replace("%s", $this->hargapcs->caption(), $this->hargapcs->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->hargapcs->FormValue)) {
            $this->hargapcs->addErrorMessage($this->hargapcs->getErrorMessage(false));
        }
        if ($this->lampiran->Required) {
            if ($this->lampiran->Upload->FileName == "" && !$this->lampiran->Upload->KeepFile) {
                $this->lampiran->addErrorMessage(str_replace("%s", $this->lampiran->caption(), $this->lampiran->RequiredErrorMessage));
            }
        }
        if ($this->disetujui->Required) {
            if ($this->disetujui->FormValue == "") {
                $this->disetujui->addErrorMessage(str_replace("%s", $this->disetujui->caption(), $this->disetujui->RequiredErrorMessage));
            }
        }
        if ($this->created_by->Required) {
            if (!$this->created_by->IsDetailKey && EmptyValue($this->created_by->FormValue)) {
                $this->created_by->addErrorMessage(str_replace("%s", $this->created_by->caption(), $this->created_by->RequiredErrorMessage));
            }
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

        // Check if valid User ID
        $validUser = false;
        if ($Security->currentUserID() != "" && !EmptyValue($this->created_by->CurrentValue) && !$Security->isAdmin()) { // Non system admin
            $validUser = $Security->isValidUserID($this->created_by->CurrentValue);
            if (!$validUser) {
                $userIdMsg = str_replace("%c", CurrentUserID(), $Language->phrase("UnAuthorizedUserID"));
                $userIdMsg = str_replace("%u", $this->created_by->CurrentValue, $userIdMsg);
                $this->setFailureMessage($userIdMsg);
                return false;
            }
        }

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
        $this->idnpd->setDbValueDef($rsnew, $this->idnpd->CurrentValue, 0, strval($this->idnpd->CurrentValue) == "");

        // tglpengajuan
        $this->tglpengajuan->setDbValueDef($rsnew, UnFormatDateTime($this->tglpengajuan->CurrentValue, 0), CurrentDate(), false);

        // idnpd_sample
        $this->idnpd_sample->setDbValueDef($rsnew, $this->idnpd_sample->CurrentValue, 0, strval($this->idnpd_sample->CurrentValue) == "");

        // bentuk
        $this->bentuk->setDbValueDef($rsnew, $this->bentuk->CurrentValue, "", false);

        // viskositasbarang
        $this->viskositasbarang->setDbValueDef($rsnew, $this->viskositasbarang->CurrentValue, "", false);

        // idaplikasibarang
        $this->idaplikasibarang->setDbValueDef($rsnew, $this->idaplikasibarang->CurrentValue, 0, false);

        // ukuranwadah
        $this->ukuranwadah->setDbValueDef($rsnew, $this->ukuranwadah->CurrentValue, "", false);

        // bahanwadah
        $this->bahanwadah->setDbValueDef($rsnew, $this->bahanwadah->CurrentValue, "", false);

        // warnawadah
        $this->warnawadah->setDbValueDef($rsnew, $this->warnawadah->CurrentValue, "", false);

        // bentukwadah
        $this->bentukwadah->setDbValueDef($rsnew, $this->bentukwadah->CurrentValue, "", false);

        // jenistutup
        $this->jenistutup->setDbValueDef($rsnew, $this->jenistutup->CurrentValue, "", false);

        // bahantutup
        $this->bahantutup->setDbValueDef($rsnew, $this->bahantutup->CurrentValue, "", false);

        // warnatutup
        $this->warnatutup->setDbValueDef($rsnew, $this->warnatutup->CurrentValue, "", false);

        // bentuktutup
        $this->bentuktutup->setDbValueDef($rsnew, $this->bentuktutup->CurrentValue, "", false);

        // segel
        $this->segel->setDbValueDef($rsnew, $this->segel->CurrentValue, 0, strval($this->segel->CurrentValue) == "");

        // catatanprimer
        $this->catatanprimer->setDbValueDef($rsnew, $this->catatanprimer->CurrentValue, null, false);

        // packingkarton
        $this->packingkarton->setDbValueDef($rsnew, $this->packingkarton->CurrentValue, "", false);

        // keteranganpacking
        $this->keteranganpacking->setDbValueDef($rsnew, $this->keteranganpacking->CurrentValue, null, false);

        // beltkarton
        $this->beltkarton->setDbValueDef($rsnew, $this->beltkarton->CurrentValue, "", false);

        // keteranganbelt
        $this->keteranganbelt->setDbValueDef($rsnew, $this->keteranganbelt->CurrentValue, null, false);

        // bariskarton
        $this->bariskarton->setDbValueDef($rsnew, $this->bariskarton->CurrentValue, null, false);

        // kolomkarton
        $this->kolomkarton->setDbValueDef($rsnew, $this->kolomkarton->CurrentValue, null, false);

        // stackkarton
        $this->stackkarton->setDbValueDef($rsnew, $this->stackkarton->CurrentValue, null, false);

        // isikarton
        $this->isikarton->setDbValueDef($rsnew, $this->isikarton->CurrentValue, null, false);

        // jenislabel
        $this->jenislabel->setDbValueDef($rsnew, $this->jenislabel->CurrentValue, "", false);

        // keteranganjenislabel
        $this->keteranganjenislabel->setDbValueDef($rsnew, $this->keteranganjenislabel->CurrentValue, null, false);

        // kualitaslabel
        $this->kualitaslabel->setDbValueDef($rsnew, $this->kualitaslabel->CurrentValue, "", false);

        // jumlahwarnalabel
        $this->jumlahwarnalabel->setDbValueDef($rsnew, $this->jumlahwarnalabel->CurrentValue, "", false);

        // etiketlabel
        $this->etiketlabel->setDbValueDef($rsnew, $this->etiketlabel->CurrentValue, "", false);

        // keteranganetiket
        $this->keteranganetiket->setDbValueDef($rsnew, $this->keteranganetiket->CurrentValue, null, false);

        // kategoridelivery
        $this->kategoridelivery->setDbValueDef($rsnew, $this->kategoridelivery->CurrentValue, null, false);

        // alamatpengiriman
        $this->alamatpengiriman->setDbValueDef($rsnew, $this->alamatpengiriman->CurrentValue, null, false);

        // orderperdana
        $this->orderperdana->setDbValueDef($rsnew, $this->orderperdana->CurrentValue, null, false);

        // orderkontrak
        $this->orderkontrak->setDbValueDef($rsnew, $this->orderkontrak->CurrentValue, null, false);

        // hargapcs
        $this->hargapcs->setDbValueDef($rsnew, $this->hargapcs->CurrentValue, 0, false);

        // lampiran
        if ($this->lampiran->Visible && !$this->lampiran->Upload->KeepFile) {
            $this->lampiran->Upload->DbValue = ""; // No need to delete old file
            if ($this->lampiran->Upload->FileName == "") {
                $rsnew['lampiran'] = null;
            } else {
                $rsnew['lampiran'] = $this->lampiran->Upload->FileName;
            }
        }

        // disetujui
        $this->disetujui->setDbValueDef($rsnew, $this->disetujui->CurrentValue, 0, strval($this->disetujui->CurrentValue) == "");

        // created_by
        $this->created_by->setDbValueDef($rsnew, $this->created_by->CurrentValue, null, false);
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

    // Show link optionally based on User ID
    protected function showOptionLink($id = "")
    {
        global $Security;
        if ($Security->isLoggedIn() && !$Security->isAdmin() && !$this->userIDAllow($id)) {
            return $Security->isValidUserID($this->created_by->CurrentValue);
        }
        return true;
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
                        return "`id` IN (SELECT `idnpd` FROM `npd_confirm`)";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_idnpd_sample":
                    $lookupFilter = function () {
                        return CurrentPageID() == "add" ? "id IN (SELECT idnpd_sample FROM npd_confirm WHERE readonly=0)" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_idaplikasibarang":
                    break;
                case "x_segel":
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
        $this->jenislabel->CustomMsg = "Sticker / Printing / Embos / Lainnya";
        $this->kualitaslabel->CustomMsg = "Standar / HD / Premium";
        $this->viskositasbarang->CustomMsg = "Encer / Sedang / Kental / Padat";
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
