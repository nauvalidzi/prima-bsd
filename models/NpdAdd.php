<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class NpdAdd extends Npd
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'npd';

    // Page object name
    public $PageObjName = "NpdAdd";

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

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "NpdView") {
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
    public $DetailPages; // Detail pages object

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
        $this->id->setVisibility();
        $this->tanggal_order->setVisibility();
        $this->target_selesai->setVisibility();
        $this->idbrand->setVisibility();
        $this->sifatorder->setVisibility();
        $this->kodeorder->setVisibility();
        $this->nomororder->setVisibility();
        $this->idpegawai->setVisibility();
        $this->idcustomer->setVisibility();
        $this->idproduct_acuan->Visible = false;
        $this->idkategoriproduk->setVisibility();
        $this->idjenisproduk->setVisibility();
        $this->fungsiproduk->setVisibility();
        $this->kualitasproduk->setVisibility();
        $this->bahan_campaign->setVisibility();
        $this->ukuran_sediaan->setVisibility();
        $this->bentuk->setVisibility();
        $this->viskositas->setVisibility();
        $this->warna->setVisibility();
        $this->parfum->setVisibility();
        $this->aplikasi->setVisibility();
        $this->estetika->setVisibility();
        $this->tambahan->setVisibility();
        $this->ukurankemasan->setVisibility();
        $this->kemasanbentuk->setVisibility();
        $this->kemasantutup->setVisibility();
        $this->kemasancatatan->setVisibility();
        $this->labelbahan->setVisibility();
        $this->labelkualitas->setVisibility();
        $this->labelposisi->setVisibility();
        $this->labelcatatan->setVisibility();
        $this->status->setVisibility();
        $this->readonly->Visible = false;
        $this->selesai->Visible = false;
        $this->created_at->Visible = false;
        $this->updated_at->Visible = false;
        $this->hideFieldsForAddEdit();

        // Do not use lookup cache
        $this->setUseLookupCache(false);

        // Set up detail page object
        $this->setupDetailPages();

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->idpegawai);
        $this->setupLookupOptions($this->idcustomer);
        $this->setupLookupOptions($this->idproduct_acuan);
        $this->setupLookupOptions($this->idkategoriproduk);
        $this->setupLookupOptions($this->idjenisproduk);
        $this->setupLookupOptions($this->bentuk);
        $this->setupLookupOptions($this->viskositas);
        $this->setupLookupOptions($this->warna);
        $this->setupLookupOptions($this->parfum);
        $this->setupLookupOptions($this->aplikasi);
        $this->setupLookupOptions($this->estetika);
        $this->setupLookupOptions($this->kemasanbentuk);
        $this->setupLookupOptions($this->kemasantutup);
        $this->setupLookupOptions($this->labelbahan);
        $this->setupLookupOptions($this->labelkualitas);
        $this->setupLookupOptions($this->labelposisi);

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

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

        // Set up detail parameters
        $this->setupDetailParms();

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
                    $this->terminate("NpdList"); // No matching record, return to list
                    return;
                }

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($this->OldRecordset)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    if ($this->getCurrentDetailTable() != "") { // Master/detail add
                        $returnUrl = $this->getDetailUrl();
                    } else {
                        $returnUrl = $this->getReturnUrl();
                    }
                    if (GetPageName($returnUrl) == "NpdList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "NpdView") {
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

                    // Set up detail parameters
                    $this->setupDetailParms();
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
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->id->CurrentValue = null;
        $this->id->OldValue = $this->id->CurrentValue;
        $this->tanggal_order->CurrentValue = null;
        $this->tanggal_order->OldValue = $this->tanggal_order->CurrentValue;
        $this->target_selesai->CurrentValue = null;
        $this->target_selesai->OldValue = $this->target_selesai->CurrentValue;
        $this->idbrand->CurrentValue = null;
        $this->idbrand->OldValue = $this->idbrand->CurrentValue;
        $this->sifatorder->CurrentValue = null;
        $this->sifatorder->OldValue = $this->sifatorder->CurrentValue;
        $this->kodeorder->CurrentValue = null;
        $this->kodeorder->OldValue = $this->kodeorder->CurrentValue;
        $this->nomororder->CurrentValue = null;
        $this->nomororder->OldValue = $this->nomororder->CurrentValue;
        $this->idpegawai->CurrentValue = CurrentUserID();
        $this->idcustomer->CurrentValue = null;
        $this->idcustomer->OldValue = $this->idcustomer->CurrentValue;
        $this->idproduct_acuan->CurrentValue = null;
        $this->idproduct_acuan->OldValue = $this->idproduct_acuan->CurrentValue;
        $this->idkategoriproduk->CurrentValue = null;
        $this->idkategoriproduk->OldValue = $this->idkategoriproduk->CurrentValue;
        $this->idjenisproduk->CurrentValue = null;
        $this->idjenisproduk->OldValue = $this->idjenisproduk->CurrentValue;
        $this->fungsiproduk->CurrentValue = null;
        $this->fungsiproduk->OldValue = $this->fungsiproduk->CurrentValue;
        $this->kualitasproduk->CurrentValue = null;
        $this->kualitasproduk->OldValue = $this->kualitasproduk->CurrentValue;
        $this->bahan_campaign->CurrentValue = null;
        $this->bahan_campaign->OldValue = $this->bahan_campaign->CurrentValue;
        $this->ukuran_sediaan->CurrentValue = null;
        $this->ukuran_sediaan->OldValue = $this->ukuran_sediaan->CurrentValue;
        $this->bentuk->CurrentValue = null;
        $this->bentuk->OldValue = $this->bentuk->CurrentValue;
        $this->viskositas->CurrentValue = null;
        $this->viskositas->OldValue = $this->viskositas->CurrentValue;
        $this->warna->CurrentValue = null;
        $this->warna->OldValue = $this->warna->CurrentValue;
        $this->parfum->CurrentValue = null;
        $this->parfum->OldValue = $this->parfum->CurrentValue;
        $this->aplikasi->CurrentValue = null;
        $this->aplikasi->OldValue = $this->aplikasi->CurrentValue;
        $this->estetika->CurrentValue = null;
        $this->estetika->OldValue = $this->estetika->CurrentValue;
        $this->tambahan->CurrentValue = null;
        $this->tambahan->OldValue = $this->tambahan->CurrentValue;
        $this->ukurankemasan->CurrentValue = null;
        $this->ukurankemasan->OldValue = $this->ukurankemasan->CurrentValue;
        $this->kemasanbentuk->CurrentValue = null;
        $this->kemasanbentuk->OldValue = $this->kemasanbentuk->CurrentValue;
        $this->kemasantutup->CurrentValue = null;
        $this->kemasantutup->OldValue = $this->kemasantutup->CurrentValue;
        $this->kemasancatatan->CurrentValue = null;
        $this->kemasancatatan->OldValue = $this->kemasancatatan->CurrentValue;
        $this->labelbahan->CurrentValue = null;
        $this->labelbahan->OldValue = $this->labelbahan->CurrentValue;
        $this->labelkualitas->CurrentValue = null;
        $this->labelkualitas->OldValue = $this->labelkualitas->CurrentValue;
        $this->labelposisi->CurrentValue = null;
        $this->labelposisi->OldValue = $this->labelposisi->CurrentValue;
        $this->labelcatatan->CurrentValue = null;
        $this->labelcatatan->OldValue = $this->labelcatatan->CurrentValue;
        $this->status->CurrentValue = null;
        $this->status->OldValue = $this->status->CurrentValue;
        $this->readonly->CurrentValue = 0;
        $this->selesai->CurrentValue = 0;
        $this->created_at->CurrentValue = null;
        $this->created_at->OldValue = $this->created_at->CurrentValue;
        $this->updated_at->CurrentValue = null;
        $this->updated_at->OldValue = $this->updated_at->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        if (!$this->id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->id->Visible = false; // Disable update for API request
            } else {
                $this->id->setFormValue($val);
            }
        }

        // Check field name 'tanggal_order' first before field var 'x_tanggal_order'
        $val = $CurrentForm->hasValue("tanggal_order") ? $CurrentForm->getValue("tanggal_order") : $CurrentForm->getValue("x_tanggal_order");
        if (!$this->tanggal_order->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tanggal_order->Visible = false; // Disable update for API request
            } else {
                $this->tanggal_order->setFormValue($val);
            }
            $this->tanggal_order->CurrentValue = UnFormatDateTime($this->tanggal_order->CurrentValue, 0);
        }

        // Check field name 'target_selesai' first before field var 'x_target_selesai'
        $val = $CurrentForm->hasValue("target_selesai") ? $CurrentForm->getValue("target_selesai") : $CurrentForm->getValue("x_target_selesai");
        if (!$this->target_selesai->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->target_selesai->Visible = false; // Disable update for API request
            } else {
                $this->target_selesai->setFormValue($val);
            }
            $this->target_selesai->CurrentValue = UnFormatDateTime($this->target_selesai->CurrentValue, 0);
        }

        // Check field name 'idbrand' first before field var 'x_idbrand'
        $val = $CurrentForm->hasValue("idbrand") ? $CurrentForm->getValue("idbrand") : $CurrentForm->getValue("x_idbrand");
        if (!$this->idbrand->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idbrand->Visible = false; // Disable update for API request
            } else {
                $this->idbrand->setFormValue($val);
            }
        }

        // Check field name 'sifatorder' first before field var 'x_sifatorder'
        $val = $CurrentForm->hasValue("sifatorder") ? $CurrentForm->getValue("sifatorder") : $CurrentForm->getValue("x_sifatorder");
        if (!$this->sifatorder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->sifatorder->Visible = false; // Disable update for API request
            } else {
                $this->sifatorder->setFormValue($val);
            }
        }

        // Check field name 'kodeorder' first before field var 'x_kodeorder'
        $val = $CurrentForm->hasValue("kodeorder") ? $CurrentForm->getValue("kodeorder") : $CurrentForm->getValue("x_kodeorder");
        if (!$this->kodeorder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kodeorder->Visible = false; // Disable update for API request
            } else {
                $this->kodeorder->setFormValue($val);
            }
        }

        // Check field name 'nomororder' first before field var 'x_nomororder'
        $val = $CurrentForm->hasValue("nomororder") ? $CurrentForm->getValue("nomororder") : $CurrentForm->getValue("x_nomororder");
        if (!$this->nomororder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nomororder->Visible = false; // Disable update for API request
            } else {
                $this->nomororder->setFormValue($val);
            }
        }

        // Check field name 'idpegawai' first before field var 'x_idpegawai'
        $val = $CurrentForm->hasValue("idpegawai") ? $CurrentForm->getValue("idpegawai") : $CurrentForm->getValue("x_idpegawai");
        if (!$this->idpegawai->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idpegawai->Visible = false; // Disable update for API request
            } else {
                $this->idpegawai->setFormValue($val);
            }
        }

        // Check field name 'idcustomer' first before field var 'x_idcustomer'
        $val = $CurrentForm->hasValue("idcustomer") ? $CurrentForm->getValue("idcustomer") : $CurrentForm->getValue("x_idcustomer");
        if (!$this->idcustomer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idcustomer->Visible = false; // Disable update for API request
            } else {
                $this->idcustomer->setFormValue($val);
            }
        }

        // Check field name 'idkategoriproduk' first before field var 'x_idkategoriproduk'
        $val = $CurrentForm->hasValue("idkategoriproduk") ? $CurrentForm->getValue("idkategoriproduk") : $CurrentForm->getValue("x_idkategoriproduk");
        if (!$this->idkategoriproduk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idkategoriproduk->Visible = false; // Disable update for API request
            } else {
                $this->idkategoriproduk->setFormValue($val);
            }
        }

        // Check field name 'idjenisproduk' first before field var 'x_idjenisproduk'
        $val = $CurrentForm->hasValue("idjenisproduk") ? $CurrentForm->getValue("idjenisproduk") : $CurrentForm->getValue("x_idjenisproduk");
        if (!$this->idjenisproduk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idjenisproduk->Visible = false; // Disable update for API request
            } else {
                $this->idjenisproduk->setFormValue($val);
            }
        }

        // Check field name 'fungsiproduk' first before field var 'x_fungsiproduk'
        $val = $CurrentForm->hasValue("fungsiproduk") ? $CurrentForm->getValue("fungsiproduk") : $CurrentForm->getValue("x_fungsiproduk");
        if (!$this->fungsiproduk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fungsiproduk->Visible = false; // Disable update for API request
            } else {
                $this->fungsiproduk->setFormValue($val);
            }
        }

        // Check field name 'kualitasproduk' first before field var 'x_kualitasproduk'
        $val = $CurrentForm->hasValue("kualitasproduk") ? $CurrentForm->getValue("kualitasproduk") : $CurrentForm->getValue("x_kualitasproduk");
        if (!$this->kualitasproduk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kualitasproduk->Visible = false; // Disable update for API request
            } else {
                $this->kualitasproduk->setFormValue($val);
            }
        }

        // Check field name 'bahan_campaign' first before field var 'x_bahan_campaign'
        $val = $CurrentForm->hasValue("bahan_campaign") ? $CurrentForm->getValue("bahan_campaign") : $CurrentForm->getValue("x_bahan_campaign");
        if (!$this->bahan_campaign->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bahan_campaign->Visible = false; // Disable update for API request
            } else {
                $this->bahan_campaign->setFormValue($val);
            }
        }

        // Check field name 'ukuran_sediaan' first before field var 'x_ukuran_sediaan'
        $val = $CurrentForm->hasValue("ukuran_sediaan") ? $CurrentForm->getValue("ukuran_sediaan") : $CurrentForm->getValue("x_ukuran_sediaan");
        if (!$this->ukuran_sediaan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ukuran_sediaan->Visible = false; // Disable update for API request
            } else {
                $this->ukuran_sediaan->setFormValue($val);
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

        // Check field name 'parfum' first before field var 'x_parfum'
        $val = $CurrentForm->hasValue("parfum") ? $CurrentForm->getValue("parfum") : $CurrentForm->getValue("x_parfum");
        if (!$this->parfum->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->parfum->Visible = false; // Disable update for API request
            } else {
                $this->parfum->setFormValue($val);
            }
        }

        // Check field name 'aplikasi' first before field var 'x_aplikasi'
        $val = $CurrentForm->hasValue("aplikasi") ? $CurrentForm->getValue("aplikasi") : $CurrentForm->getValue("x_aplikasi");
        if (!$this->aplikasi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->aplikasi->Visible = false; // Disable update for API request
            } else {
                $this->aplikasi->setFormValue($val);
            }
        }

        // Check field name 'estetika' first before field var 'x_estetika'
        $val = $CurrentForm->hasValue("estetika") ? $CurrentForm->getValue("estetika") : $CurrentForm->getValue("x_estetika");
        if (!$this->estetika->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->estetika->Visible = false; // Disable update for API request
            } else {
                $this->estetika->setFormValue($val);
            }
        }

        // Check field name 'tambahan' first before field var 'x_tambahan'
        $val = $CurrentForm->hasValue("tambahan") ? $CurrentForm->getValue("tambahan") : $CurrentForm->getValue("x_tambahan");
        if (!$this->tambahan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tambahan->Visible = false; // Disable update for API request
            } else {
                $this->tambahan->setFormValue($val);
            }
        }

        // Check field name 'ukurankemasan' first before field var 'x_ukurankemasan'
        $val = $CurrentForm->hasValue("ukurankemasan") ? $CurrentForm->getValue("ukurankemasan") : $CurrentForm->getValue("x_ukurankemasan");
        if (!$this->ukurankemasan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ukurankemasan->Visible = false; // Disable update for API request
            } else {
                $this->ukurankemasan->setFormValue($val);
            }
        }

        // Check field name 'kemasanbentuk' first before field var 'x_kemasanbentuk'
        $val = $CurrentForm->hasValue("kemasanbentuk") ? $CurrentForm->getValue("kemasanbentuk") : $CurrentForm->getValue("x_kemasanbentuk");
        if (!$this->kemasanbentuk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kemasanbentuk->Visible = false; // Disable update for API request
            } else {
                $this->kemasanbentuk->setFormValue($val);
            }
        }

        // Check field name 'kemasantutup' first before field var 'x_kemasantutup'
        $val = $CurrentForm->hasValue("kemasantutup") ? $CurrentForm->getValue("kemasantutup") : $CurrentForm->getValue("x_kemasantutup");
        if (!$this->kemasantutup->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kemasantutup->Visible = false; // Disable update for API request
            } else {
                $this->kemasantutup->setFormValue($val);
            }
        }

        // Check field name 'kemasancatatan' first before field var 'x_kemasancatatan'
        $val = $CurrentForm->hasValue("kemasancatatan") ? $CurrentForm->getValue("kemasancatatan") : $CurrentForm->getValue("x_kemasancatatan");
        if (!$this->kemasancatatan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kemasancatatan->Visible = false; // Disable update for API request
            } else {
                $this->kemasancatatan->setFormValue($val);
            }
        }

        // Check field name 'labelbahan' first before field var 'x_labelbahan'
        $val = $CurrentForm->hasValue("labelbahan") ? $CurrentForm->getValue("labelbahan") : $CurrentForm->getValue("x_labelbahan");
        if (!$this->labelbahan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->labelbahan->Visible = false; // Disable update for API request
            } else {
                $this->labelbahan->setFormValue($val);
            }
        }

        // Check field name 'labelkualitas' first before field var 'x_labelkualitas'
        $val = $CurrentForm->hasValue("labelkualitas") ? $CurrentForm->getValue("labelkualitas") : $CurrentForm->getValue("x_labelkualitas");
        if (!$this->labelkualitas->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->labelkualitas->Visible = false; // Disable update for API request
            } else {
                $this->labelkualitas->setFormValue($val);
            }
        }

        // Check field name 'labelposisi' first before field var 'x_labelposisi'
        $val = $CurrentForm->hasValue("labelposisi") ? $CurrentForm->getValue("labelposisi") : $CurrentForm->getValue("x_labelposisi");
        if (!$this->labelposisi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->labelposisi->Visible = false; // Disable update for API request
            } else {
                $this->labelposisi->setFormValue($val);
            }
        }

        // Check field name 'labelcatatan' first before field var 'x_labelcatatan'
        $val = $CurrentForm->hasValue("labelcatatan") ? $CurrentForm->getValue("labelcatatan") : $CurrentForm->getValue("x_labelcatatan");
        if (!$this->labelcatatan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->labelcatatan->Visible = false; // Disable update for API request
            } else {
                $this->labelcatatan->setFormValue($val);
            }
        }

        // Check field name 'status' first before field var 'x_status'
        $val = $CurrentForm->hasValue("status") ? $CurrentForm->getValue("status") : $CurrentForm->getValue("x_status");
        if (!$this->status->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->status->Visible = false; // Disable update for API request
            } else {
                $this->status->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id->CurrentValue = $this->id->FormValue;
        $this->tanggal_order->CurrentValue = $this->tanggal_order->FormValue;
        $this->tanggal_order->CurrentValue = UnFormatDateTime($this->tanggal_order->CurrentValue, 0);
        $this->target_selesai->CurrentValue = $this->target_selesai->FormValue;
        $this->target_selesai->CurrentValue = UnFormatDateTime($this->target_selesai->CurrentValue, 0);
        $this->idbrand->CurrentValue = $this->idbrand->FormValue;
        $this->sifatorder->CurrentValue = $this->sifatorder->FormValue;
        $this->kodeorder->CurrentValue = $this->kodeorder->FormValue;
        $this->nomororder->CurrentValue = $this->nomororder->FormValue;
        $this->idpegawai->CurrentValue = $this->idpegawai->FormValue;
        $this->idcustomer->CurrentValue = $this->idcustomer->FormValue;
        $this->idkategoriproduk->CurrentValue = $this->idkategoriproduk->FormValue;
        $this->idjenisproduk->CurrentValue = $this->idjenisproduk->FormValue;
        $this->fungsiproduk->CurrentValue = $this->fungsiproduk->FormValue;
        $this->kualitasproduk->CurrentValue = $this->kualitasproduk->FormValue;
        $this->bahan_campaign->CurrentValue = $this->bahan_campaign->FormValue;
        $this->ukuran_sediaan->CurrentValue = $this->ukuran_sediaan->FormValue;
        $this->bentuk->CurrentValue = $this->bentuk->FormValue;
        $this->viskositas->CurrentValue = $this->viskositas->FormValue;
        $this->warna->CurrentValue = $this->warna->FormValue;
        $this->parfum->CurrentValue = $this->parfum->FormValue;
        $this->aplikasi->CurrentValue = $this->aplikasi->FormValue;
        $this->estetika->CurrentValue = $this->estetika->FormValue;
        $this->tambahan->CurrentValue = $this->tambahan->FormValue;
        $this->ukurankemasan->CurrentValue = $this->ukurankemasan->FormValue;
        $this->kemasanbentuk->CurrentValue = $this->kemasanbentuk->FormValue;
        $this->kemasantutup->CurrentValue = $this->kemasantutup->FormValue;
        $this->kemasancatatan->CurrentValue = $this->kemasancatatan->FormValue;
        $this->labelbahan->CurrentValue = $this->labelbahan->FormValue;
        $this->labelkualitas->CurrentValue = $this->labelkualitas->FormValue;
        $this->labelposisi->CurrentValue = $this->labelposisi->FormValue;
        $this->labelcatatan->CurrentValue = $this->labelcatatan->FormValue;
        $this->status->CurrentValue = $this->status->FormValue;
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
        $this->tanggal_order->setDbValue($row['tanggal_order']);
        $this->target_selesai->setDbValue($row['target_selesai']);
        $this->idbrand->setDbValue($row['idbrand']);
        $this->sifatorder->setDbValue($row['sifatorder']);
        $this->kodeorder->setDbValue($row['kodeorder']);
        $this->nomororder->setDbValue($row['nomororder']);
        $this->idpegawai->setDbValue($row['idpegawai']);
        $this->idcustomer->setDbValue($row['idcustomer']);
        $this->idproduct_acuan->setDbValue($row['idproduct_acuan']);
        $this->idkategoriproduk->setDbValue($row['idkategoriproduk']);
        $this->idjenisproduk->setDbValue($row['idjenisproduk']);
        $this->fungsiproduk->setDbValue($row['fungsiproduk']);
        $this->kualitasproduk->setDbValue($row['kualitasproduk']);
        $this->bahan_campaign->setDbValue($row['bahan_campaign']);
        $this->ukuran_sediaan->setDbValue($row['ukuran_sediaan']);
        $this->bentuk->setDbValue($row['bentuk']);
        $this->viskositas->setDbValue($row['viskositas']);
        $this->warna->setDbValue($row['warna']);
        $this->parfum->setDbValue($row['parfum']);
        $this->aplikasi->setDbValue($row['aplikasi']);
        $this->estetika->setDbValue($row['estetika']);
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
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['id'] = $this->id->CurrentValue;
        $row['tanggal_order'] = $this->tanggal_order->CurrentValue;
        $row['target_selesai'] = $this->target_selesai->CurrentValue;
        $row['idbrand'] = $this->idbrand->CurrentValue;
        $row['sifatorder'] = $this->sifatorder->CurrentValue;
        $row['kodeorder'] = $this->kodeorder->CurrentValue;
        $row['nomororder'] = $this->nomororder->CurrentValue;
        $row['idpegawai'] = $this->idpegawai->CurrentValue;
        $row['idcustomer'] = $this->idcustomer->CurrentValue;
        $row['idproduct_acuan'] = $this->idproduct_acuan->CurrentValue;
        $row['idkategoriproduk'] = $this->idkategoriproduk->CurrentValue;
        $row['idjenisproduk'] = $this->idjenisproduk->CurrentValue;
        $row['fungsiproduk'] = $this->fungsiproduk->CurrentValue;
        $row['kualitasproduk'] = $this->kualitasproduk->CurrentValue;
        $row['bahan_campaign'] = $this->bahan_campaign->CurrentValue;
        $row['ukuran_sediaan'] = $this->ukuran_sediaan->CurrentValue;
        $row['bentuk'] = $this->bentuk->CurrentValue;
        $row['viskositas'] = $this->viskositas->CurrentValue;
        $row['warna'] = $this->warna->CurrentValue;
        $row['parfum'] = $this->parfum->CurrentValue;
        $row['aplikasi'] = $this->aplikasi->CurrentValue;
        $row['estetika'] = $this->estetika->CurrentValue;
        $row['tambahan'] = $this->tambahan->CurrentValue;
        $row['ukurankemasan'] = $this->ukurankemasan->CurrentValue;
        $row['kemasanbentuk'] = $this->kemasanbentuk->CurrentValue;
        $row['kemasantutup'] = $this->kemasantutup->CurrentValue;
        $row['kemasancatatan'] = $this->kemasancatatan->CurrentValue;
        $row['labelbahan'] = $this->labelbahan->CurrentValue;
        $row['labelkualitas'] = $this->labelkualitas->CurrentValue;
        $row['labelposisi'] = $this->labelposisi->CurrentValue;
        $row['labelcatatan'] = $this->labelcatatan->CurrentValue;
        $row['status'] = $this->status->CurrentValue;
        $row['readonly'] = $this->readonly->CurrentValue;
        $row['selesai'] = $this->selesai->CurrentValue;
        $row['created_at'] = $this->created_at->CurrentValue;
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

        // tanggal_order

        // target_selesai

        // idbrand

        // sifatorder

        // kodeorder

        // nomororder

        // idpegawai

        // idcustomer

        // idproduct_acuan

        // idkategoriproduk

        // idjenisproduk

        // fungsiproduk

        // kualitasproduk

        // bahan_campaign

        // ukuran_sediaan

        // bentuk

        // viskositas

        // warna

        // parfum

        // aplikasi

        // estetika

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
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // tanggal_order
            $this->tanggal_order->ViewValue = $this->tanggal_order->CurrentValue;
            $this->tanggal_order->ViewValue = FormatDateTime($this->tanggal_order->ViewValue, 0);
            $this->tanggal_order->ViewCustomAttributes = "";

            // target_selesai
            $this->target_selesai->ViewValue = $this->target_selesai->CurrentValue;
            $this->target_selesai->ViewValue = FormatDateTime($this->target_selesai->ViewValue, 0);
            $this->target_selesai->ViewCustomAttributes = "";

            // idbrand
            $this->idbrand->ViewValue = $this->idbrand->CurrentValue;
            $this->idbrand->ViewValue = FormatNumber($this->idbrand->ViewValue, 0, -2, -2, -2);
            $this->idbrand->ViewCustomAttributes = "";

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

            // idkategoriproduk
            $curVal = trim(strval($this->idkategoriproduk->CurrentValue));
            if ($curVal != "") {
                $this->idkategoriproduk->ViewValue = $this->idkategoriproduk->lookupCacheOption($curVal);
                if ($this->idkategoriproduk->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->idkategoriproduk->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idkategoriproduk->Lookup->renderViewRow($rswrk[0]);
                        $this->idkategoriproduk->ViewValue = $this->idkategoriproduk->displayValue($arwrk);
                    } else {
                        $this->idkategoriproduk->ViewValue = $this->idkategoriproduk->CurrentValue;
                    }
                }
            } else {
                $this->idkategoriproduk->ViewValue = null;
            }
            $this->idkategoriproduk->ViewCustomAttributes = "";

            // idjenisproduk
            $curVal = trim(strval($this->idjenisproduk->CurrentValue));
            if ($curVal != "") {
                $this->idjenisproduk->ViewValue = $this->idjenisproduk->lookupCacheOption($curVal);
                if ($this->idjenisproduk->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->idjenisproduk->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idjenisproduk->Lookup->renderViewRow($rswrk[0]);
                        $this->idjenisproduk->ViewValue = $this->idjenisproduk->displayValue($arwrk);
                    } else {
                        $this->idjenisproduk->ViewValue = $this->idjenisproduk->CurrentValue;
                    }
                }
            } else {
                $this->idjenisproduk->ViewValue = null;
            }
            $this->idjenisproduk->ViewCustomAttributes = "";

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
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->bentuk->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->bentuk->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->bentuk->Lookup->renderViewRow($row);
                            $this->bentuk->ViewValue->add($this->bentuk->displayValue($arwrk));
                        }
                    } else {
                        $this->bentuk->ViewValue = $this->bentuk->CurrentValue;
                    }
                }
            } else {
                $this->bentuk->ViewValue = null;
            }
            $this->bentuk->ViewCustomAttributes = "";

            // viskositas
            $curVal = trim(strval($this->viskositas->CurrentValue));
            if ($curVal != "") {
                $this->viskositas->ViewValue = $this->viskositas->lookupCacheOption($curVal);
                if ($this->viskositas->ViewValue === null) { // Lookup from database
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->viskositas->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->viskositas->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->viskositas->Lookup->renderViewRow($row);
                            $this->viskositas->ViewValue->add($this->viskositas->displayValue($arwrk));
                        }
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
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->warna->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->warna->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->warna->Lookup->renderViewRow($row);
                            $this->warna->ViewValue->add($this->warna->displayValue($arwrk));
                        }
                    } else {
                        $this->warna->ViewValue = $this->warna->CurrentValue;
                    }
                }
            } else {
                $this->warna->ViewValue = null;
            }
            $this->warna->ViewCustomAttributes = "";

            // parfum
            $curVal = trim(strval($this->parfum->CurrentValue));
            if ($curVal != "") {
                $this->parfum->ViewValue = $this->parfum->lookupCacheOption($curVal);
                if ($this->parfum->ViewValue === null) { // Lookup from database
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->parfum->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->parfum->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->parfum->Lookup->renderViewRow($row);
                            $this->parfum->ViewValue->add($this->parfum->displayValue($arwrk));
                        }
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
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->aplikasi->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->aplikasi->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->aplikasi->Lookup->renderViewRow($row);
                            $this->aplikasi->ViewValue->add($this->aplikasi->displayValue($arwrk));
                        }
                    } else {
                        $this->aplikasi->ViewValue = $this->aplikasi->CurrentValue;
                    }
                }
            } else {
                $this->aplikasi->ViewValue = null;
            }
            $this->aplikasi->ViewCustomAttributes = "";

            // estetika
            $curVal = trim(strval($this->estetika->CurrentValue));
            if ($curVal != "") {
                $this->estetika->ViewValue = $this->estetika->lookupCacheOption($curVal);
                if ($this->estetika->ViewValue === null) { // Lookup from database
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->estetika->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->estetika->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->estetika->Lookup->renderViewRow($row);
                            $this->estetika->ViewValue->add($this->estetika->displayValue($arwrk));
                        }
                    } else {
                        $this->estetika->ViewValue = $this->estetika->CurrentValue;
                    }
                }
            } else {
                $this->estetika->ViewValue = null;
            }
            $this->estetika->ViewCustomAttributes = "";

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
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
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
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
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

            // kemasancatatan
            $this->kemasancatatan->ViewValue = $this->kemasancatatan->CurrentValue;
            $this->kemasancatatan->ViewCustomAttributes = "";

            // labelbahan
            $curVal = trim(strval($this->labelbahan->CurrentValue));
            if ($curVal != "") {
                $this->labelbahan->ViewValue = $this->labelbahan->lookupCacheOption($curVal);
                if ($this->labelbahan->ViewValue === null) { // Lookup from database
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->labelbahan->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->labelbahan->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->labelbahan->Lookup->renderViewRow($row);
                            $this->labelbahan->ViewValue->add($this->labelbahan->displayValue($arwrk));
                        }
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
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->labelkualitas->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->labelkualitas->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->labelkualitas->Lookup->renderViewRow($row);
                            $this->labelkualitas->ViewValue->add($this->labelkualitas->displayValue($arwrk));
                        }
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
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->labelposisi->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->labelposisi->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->labelposisi->Lookup->renderViewRow($row);
                            $this->labelposisi->ViewValue->add($this->labelposisi->displayValue($arwrk));
                        }
                    } else {
                        $this->labelposisi->ViewValue = $this->labelposisi->CurrentValue;
                    }
                }
            } else {
                $this->labelposisi->ViewValue = null;
            }
            $this->labelposisi->ViewCustomAttributes = "";

            // labelcatatan
            $this->labelcatatan->ViewValue = $this->labelcatatan->CurrentValue;
            $this->labelcatatan->ViewCustomAttributes = "";

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

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";
            $this->id->TooltipValue = "";

            // tanggal_order
            $this->tanggal_order->LinkCustomAttributes = "";
            $this->tanggal_order->HrefValue = "";
            $this->tanggal_order->TooltipValue = "";

            // target_selesai
            $this->target_selesai->LinkCustomAttributes = "";
            $this->target_selesai->HrefValue = "";
            $this->target_selesai->TooltipValue = "";

            // idbrand
            $this->idbrand->LinkCustomAttributes = "";
            $this->idbrand->HrefValue = "";
            $this->idbrand->TooltipValue = "";

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

            // idpegawai
            $this->idpegawai->LinkCustomAttributes = "";
            $this->idpegawai->HrefValue = "";
            $this->idpegawai->TooltipValue = "";

            // idcustomer
            $this->idcustomer->LinkCustomAttributes = "";
            $this->idcustomer->HrefValue = "";
            $this->idcustomer->TooltipValue = "";

            // idkategoriproduk
            $this->idkategoriproduk->LinkCustomAttributes = "";
            $this->idkategoriproduk->HrefValue = "";
            $this->idkategoriproduk->TooltipValue = "";

            // idjenisproduk
            $this->idjenisproduk->LinkCustomAttributes = "";
            $this->idjenisproduk->HrefValue = "";
            $this->idjenisproduk->TooltipValue = "";

            // fungsiproduk
            $this->fungsiproduk->LinkCustomAttributes = "";
            $this->fungsiproduk->HrefValue = "";
            $this->fungsiproduk->TooltipValue = "";

            // kualitasproduk
            $this->kualitasproduk->LinkCustomAttributes = "";
            $this->kualitasproduk->HrefValue = "";
            $this->kualitasproduk->TooltipValue = "";

            // bahan_campaign
            $this->bahan_campaign->LinkCustomAttributes = "";
            $this->bahan_campaign->HrefValue = "";
            $this->bahan_campaign->TooltipValue = "";

            // ukuran_sediaan
            $this->ukuran_sediaan->LinkCustomAttributes = "";
            $this->ukuran_sediaan->HrefValue = "";
            $this->ukuran_sediaan->TooltipValue = "";

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

            // parfum
            $this->parfum->LinkCustomAttributes = "";
            $this->parfum->HrefValue = "";
            $this->parfum->TooltipValue = "";

            // aplikasi
            $this->aplikasi->LinkCustomAttributes = "";
            $this->aplikasi->HrefValue = "";
            $this->aplikasi->TooltipValue = "";

            // estetika
            $this->estetika->LinkCustomAttributes = "";
            $this->estetika->HrefValue = "";
            $this->estetika->TooltipValue = "";

            // tambahan
            $this->tambahan->LinkCustomAttributes = "";
            $this->tambahan->HrefValue = "";
            $this->tambahan->TooltipValue = "";

            // ukurankemasan
            $this->ukurankemasan->LinkCustomAttributes = "";
            $this->ukurankemasan->HrefValue = "";
            $this->ukurankemasan->TooltipValue = "";

            // kemasanbentuk
            $this->kemasanbentuk->LinkCustomAttributes = "";
            $this->kemasanbentuk->HrefValue = "";
            $this->kemasanbentuk->TooltipValue = "";

            // kemasantutup
            $this->kemasantutup->LinkCustomAttributes = "";
            $this->kemasantutup->HrefValue = "";
            $this->kemasantutup->TooltipValue = "";

            // kemasancatatan
            $this->kemasancatatan->LinkCustomAttributes = "";
            $this->kemasancatatan->HrefValue = "";
            $this->kemasancatatan->TooltipValue = "";

            // labelbahan
            $this->labelbahan->LinkCustomAttributes = "";
            $this->labelbahan->HrefValue = "";
            $this->labelbahan->TooltipValue = "";

            // labelkualitas
            $this->labelkualitas->LinkCustomAttributes = "";
            $this->labelkualitas->HrefValue = "";
            $this->labelkualitas->TooltipValue = "";

            // labelposisi
            $this->labelposisi->LinkCustomAttributes = "";
            $this->labelposisi->HrefValue = "";
            $this->labelposisi->TooltipValue = "";

            // labelcatatan
            $this->labelcatatan->LinkCustomAttributes = "";
            $this->labelcatatan->HrefValue = "";
            $this->labelcatatan->TooltipValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
            $this->status->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // id
            $this->id->EditAttrs["class"] = "form-control";
            $this->id->EditCustomAttributes = "";
            $this->id->EditValue = HtmlEncode($this->id->CurrentValue);
            $this->id->PlaceHolder = RemoveHtml($this->id->caption());

            // tanggal_order
            $this->tanggal_order->EditAttrs["class"] = "form-control";
            $this->tanggal_order->EditCustomAttributes = "";
            $this->tanggal_order->EditValue = HtmlEncode(FormatDateTime($this->tanggal_order->CurrentValue, 8));
            $this->tanggal_order->PlaceHolder = RemoveHtml($this->tanggal_order->caption());

            // target_selesai
            $this->target_selesai->EditAttrs["class"] = "form-control";
            $this->target_selesai->EditCustomAttributes = "";
            $this->target_selesai->EditValue = HtmlEncode(FormatDateTime($this->target_selesai->CurrentValue, 8));
            $this->target_selesai->PlaceHolder = RemoveHtml($this->target_selesai->caption());

            // idbrand
            $this->idbrand->EditAttrs["class"] = "form-control";
            $this->idbrand->EditCustomAttributes = "";
            $this->idbrand->EditValue = HtmlEncode($this->idbrand->CurrentValue);
            $this->idbrand->PlaceHolder = RemoveHtml($this->idbrand->caption());

            // sifatorder
            $this->sifatorder->EditCustomAttributes = "";
            $this->sifatorder->EditValue = $this->sifatorder->options(false);
            $this->sifatorder->PlaceHolder = RemoveHtml($this->sifatorder->caption());

            // kodeorder
            $this->kodeorder->EditAttrs["class"] = "form-control";
            $this->kodeorder->EditCustomAttributes = "";
            if (!$this->kodeorder->Raw) {
                $this->kodeorder->CurrentValue = HtmlDecode($this->kodeorder->CurrentValue);
            }
            $this->kodeorder->EditValue = HtmlEncode($this->kodeorder->CurrentValue);
            $this->kodeorder->PlaceHolder = RemoveHtml($this->kodeorder->caption());

            // nomororder
            $this->nomororder->EditAttrs["class"] = "form-control";
            $this->nomororder->EditCustomAttributes = "";
            if (!$this->nomororder->Raw) {
                $this->nomororder->CurrentValue = HtmlDecode($this->nomororder->CurrentValue);
            }
            $this->nomororder->EditValue = HtmlEncode($this->nomororder->CurrentValue);
            $this->nomororder->PlaceHolder = RemoveHtml($this->nomororder->caption());

            // idpegawai
            $this->idpegawai->EditAttrs["class"] = "form-control";
            $this->idpegawai->EditCustomAttributes = "";
            $curVal = trim(strval($this->idpegawai->CurrentValue));
            if ($curVal != "") {
                $this->idpegawai->ViewValue = $this->idpegawai->lookupCacheOption($curVal);
            } else {
                $this->idpegawai->ViewValue = $this->idpegawai->Lookup !== null && is_array($this->idpegawai->Lookup->Options) ? $curVal : null;
            }
            if ($this->idpegawai->ViewValue !== null) { // Load from cache
                $this->idpegawai->EditValue = array_values($this->idpegawai->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idpegawai->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->idpegawai->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idpegawai->EditValue = $arwrk;
            }
            $this->idpegawai->PlaceHolder = RemoveHtml($this->idpegawai->caption());

            // idcustomer
            $this->idcustomer->EditAttrs["class"] = "form-control";
            $this->idcustomer->EditCustomAttributes = "";
            $curVal = trim(strval($this->idcustomer->CurrentValue));
            if ($curVal != "") {
                $this->idcustomer->ViewValue = $this->idcustomer->lookupCacheOption($curVal);
            } else {
                $this->idcustomer->ViewValue = $this->idcustomer->Lookup !== null && is_array($this->idcustomer->Lookup->Options) ? $curVal : null;
            }
            if ($this->idcustomer->ViewValue !== null) { // Load from cache
                $this->idcustomer->EditValue = array_values($this->idcustomer->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idcustomer->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->idcustomer->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idcustomer->EditValue = $arwrk;
            }
            $this->idcustomer->PlaceHolder = RemoveHtml($this->idcustomer->caption());

            // idkategoriproduk
            $this->idkategoriproduk->EditAttrs["class"] = "form-control";
            $this->idkategoriproduk->EditCustomAttributes = "";
            $curVal = trim(strval($this->idkategoriproduk->CurrentValue));
            if ($curVal != "") {
                $this->idkategoriproduk->ViewValue = $this->idkategoriproduk->lookupCacheOption($curVal);
            } else {
                $this->idkategoriproduk->ViewValue = $this->idkategoriproduk->Lookup !== null && is_array($this->idkategoriproduk->Lookup->Options) ? $curVal : null;
            }
            if ($this->idkategoriproduk->ViewValue !== null) { // Load from cache
                $this->idkategoriproduk->EditValue = array_values($this->idkategoriproduk->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idkategoriproduk->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->idkategoriproduk->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idkategoriproduk->EditValue = $arwrk;
            }
            $this->idkategoriproduk->PlaceHolder = RemoveHtml($this->idkategoriproduk->caption());

            // idjenisproduk
            $this->idjenisproduk->EditAttrs["class"] = "form-control";
            $this->idjenisproduk->EditCustomAttributes = "";
            $curVal = trim(strval($this->idjenisproduk->CurrentValue));
            if ($curVal != "") {
                $this->idjenisproduk->ViewValue = $this->idjenisproduk->lookupCacheOption($curVal);
            } else {
                $this->idjenisproduk->ViewValue = $this->idjenisproduk->Lookup !== null && is_array($this->idjenisproduk->Lookup->Options) ? $curVal : null;
            }
            if ($this->idjenisproduk->ViewValue !== null) { // Load from cache
                $this->idjenisproduk->EditValue = array_values($this->idjenisproduk->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idjenisproduk->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->idjenisproduk->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idjenisproduk->EditValue = $arwrk;
            }
            $this->idjenisproduk->PlaceHolder = RemoveHtml($this->idjenisproduk->caption());

            // fungsiproduk
            $this->fungsiproduk->EditAttrs["class"] = "form-control";
            $this->fungsiproduk->EditCustomAttributes = "";
            if (!$this->fungsiproduk->Raw) {
                $this->fungsiproduk->CurrentValue = HtmlDecode($this->fungsiproduk->CurrentValue);
            }
            $this->fungsiproduk->EditValue = HtmlEncode($this->fungsiproduk->CurrentValue);
            $this->fungsiproduk->PlaceHolder = RemoveHtml($this->fungsiproduk->caption());

            // kualitasproduk
            $this->kualitasproduk->EditAttrs["class"] = "form-control";
            $this->kualitasproduk->EditCustomAttributes = "";
            if (!$this->kualitasproduk->Raw) {
                $this->kualitasproduk->CurrentValue = HtmlDecode($this->kualitasproduk->CurrentValue);
            }
            $this->kualitasproduk->EditValue = HtmlEncode($this->kualitasproduk->CurrentValue);
            $this->kualitasproduk->PlaceHolder = RemoveHtml($this->kualitasproduk->caption());

            // bahan_campaign
            $this->bahan_campaign->EditAttrs["class"] = "form-control";
            $this->bahan_campaign->EditCustomAttributes = "";
            if (!$this->bahan_campaign->Raw) {
                $this->bahan_campaign->CurrentValue = HtmlDecode($this->bahan_campaign->CurrentValue);
            }
            $this->bahan_campaign->EditValue = HtmlEncode($this->bahan_campaign->CurrentValue);
            $this->bahan_campaign->PlaceHolder = RemoveHtml($this->bahan_campaign->caption());

            // ukuran_sediaan
            $this->ukuran_sediaan->EditAttrs["class"] = "form-control";
            $this->ukuran_sediaan->EditCustomAttributes = "";
            if (!$this->ukuran_sediaan->Raw) {
                $this->ukuran_sediaan->CurrentValue = HtmlDecode($this->ukuran_sediaan->CurrentValue);
            }
            $this->ukuran_sediaan->EditValue = HtmlEncode($this->ukuran_sediaan->CurrentValue);
            $this->ukuran_sediaan->PlaceHolder = RemoveHtml($this->ukuran_sediaan->caption());

            // bentuk
            $this->bentuk->EditCustomAttributes = "";
            $curVal = trim(strval($this->bentuk->CurrentValue));
            if ($curVal != "") {
                $this->bentuk->ViewValue = $this->bentuk->lookupCacheOption($curVal);
            } else {
                $this->bentuk->ViewValue = $this->bentuk->Lookup !== null && is_array($this->bentuk->Lookup->Options) ? $curVal : null;
            }
            if ($this->bentuk->ViewValue !== null) { // Load from cache
                $this->bentuk->EditValue = array_values($this->bentuk->Lookup->Options);
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
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                }
                $sqlWrk = $this->bentuk->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->bentuk->EditValue = $arwrk;
            }
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
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
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
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                }
                $sqlWrk = $this->warna->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->warna->EditValue = $arwrk;
            }
            $this->warna->PlaceHolder = RemoveHtml($this->warna->caption());

            // parfum
            $this->parfum->EditCustomAttributes = "";
            $curVal = trim(strval($this->parfum->CurrentValue));
            if ($curVal != "") {
                $this->parfum->ViewValue = $this->parfum->lookupCacheOption($curVal);
            } else {
                $this->parfum->ViewValue = $this->parfum->Lookup !== null && is_array($this->parfum->Lookup->Options) ? $curVal : null;
            }
            if ($this->parfum->ViewValue !== null) { // Load from cache
                $this->parfum->EditValue = array_values($this->parfum->Lookup->Options);
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
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                }
                $sqlWrk = $this->parfum->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->parfum->EditValue = $arwrk;
            }
            $this->parfum->PlaceHolder = RemoveHtml($this->parfum->caption());

            // aplikasi
            $this->aplikasi->EditCustomAttributes = "";
            $curVal = trim(strval($this->aplikasi->CurrentValue));
            if ($curVal != "") {
                $this->aplikasi->ViewValue = $this->aplikasi->lookupCacheOption($curVal);
            } else {
                $this->aplikasi->ViewValue = $this->aplikasi->Lookup !== null && is_array($this->aplikasi->Lookup->Options) ? $curVal : null;
            }
            if ($this->aplikasi->ViewValue !== null) { // Load from cache
                $this->aplikasi->EditValue = array_values($this->aplikasi->Lookup->Options);
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
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                }
                $sqlWrk = $this->aplikasi->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->aplikasi->EditValue = $arwrk;
            }
            $this->aplikasi->PlaceHolder = RemoveHtml($this->aplikasi->caption());

            // estetika
            $this->estetika->EditCustomAttributes = "";
            $curVal = trim(strval($this->estetika->CurrentValue));
            if ($curVal != "") {
                $this->estetika->ViewValue = $this->estetika->lookupCacheOption($curVal);
            } else {
                $this->estetika->ViewValue = $this->estetika->Lookup !== null && is_array($this->estetika->Lookup->Options) ? $curVal : null;
            }
            if ($this->estetika->ViewValue !== null) { // Load from cache
                $this->estetika->EditValue = array_values($this->estetika->Lookup->Options);
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
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                }
                $sqlWrk = $this->estetika->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->estetika->EditValue = $arwrk;
            }
            $this->estetika->PlaceHolder = RemoveHtml($this->estetika->caption());

            // tambahan
            $this->tambahan->EditAttrs["class"] = "form-control";
            $this->tambahan->EditCustomAttributes = "";
            $this->tambahan->EditValue = HtmlEncode($this->tambahan->CurrentValue);
            $this->tambahan->PlaceHolder = RemoveHtml($this->tambahan->caption());

            // ukurankemasan
            $this->ukurankemasan->EditAttrs["class"] = "form-control";
            $this->ukurankemasan->EditCustomAttributes = "";
            if (!$this->ukurankemasan->Raw) {
                $this->ukurankemasan->CurrentValue = HtmlDecode($this->ukurankemasan->CurrentValue);
            }
            $this->ukurankemasan->EditValue = HtmlEncode($this->ukurankemasan->CurrentValue);
            $this->ukurankemasan->PlaceHolder = RemoveHtml($this->ukurankemasan->caption());

            // kemasanbentuk
            $this->kemasanbentuk->EditCustomAttributes = "";
            $curVal = trim(strval($this->kemasanbentuk->CurrentValue));
            if ($curVal != "") {
                $this->kemasanbentuk->ViewValue = $this->kemasanbentuk->lookupCacheOption($curVal);
            } else {
                $this->kemasanbentuk->ViewValue = $this->kemasanbentuk->Lookup !== null && is_array($this->kemasanbentuk->Lookup->Options) ? $curVal : null;
            }
            if ($this->kemasanbentuk->ViewValue !== null) { // Load from cache
                $this->kemasanbentuk->EditValue = array_values($this->kemasanbentuk->Lookup->Options);
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
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                }
                $sqlWrk = $this->kemasanbentuk->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->kemasanbentuk->EditValue = $arwrk;
            }
            $this->kemasanbentuk->PlaceHolder = RemoveHtml($this->kemasanbentuk->caption());

            // kemasantutup
            $this->kemasantutup->EditCustomAttributes = "";
            $curVal = trim(strval($this->kemasantutup->CurrentValue));
            if ($curVal != "") {
                $this->kemasantutup->ViewValue = $this->kemasantutup->lookupCacheOption($curVal);
            } else {
                $this->kemasantutup->ViewValue = $this->kemasantutup->Lookup !== null && is_array($this->kemasantutup->Lookup->Options) ? $curVal : null;
            }
            if ($this->kemasantutup->ViewValue !== null) { // Load from cache
                $this->kemasantutup->EditValue = array_values($this->kemasantutup->Lookup->Options);
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
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                }
                $sqlWrk = $this->kemasantutup->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->kemasantutup->EditValue = $arwrk;
            }
            $this->kemasantutup->PlaceHolder = RemoveHtml($this->kemasantutup->caption());

            // kemasancatatan
            $this->kemasancatatan->EditAttrs["class"] = "form-control";
            $this->kemasancatatan->EditCustomAttributes = "";
            $this->kemasancatatan->EditValue = HtmlEncode($this->kemasancatatan->CurrentValue);
            $this->kemasancatatan->PlaceHolder = RemoveHtml($this->kemasancatatan->caption());

            // labelbahan
            $this->labelbahan->EditCustomAttributes = "";
            $curVal = trim(strval($this->labelbahan->CurrentValue));
            if ($curVal != "") {
                $this->labelbahan->ViewValue = $this->labelbahan->lookupCacheOption($curVal);
            } else {
                $this->labelbahan->ViewValue = $this->labelbahan->Lookup !== null && is_array($this->labelbahan->Lookup->Options) ? $curVal : null;
            }
            if ($this->labelbahan->ViewValue !== null) { // Load from cache
                $this->labelbahan->EditValue = array_values($this->labelbahan->Lookup->Options);
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
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                }
                $sqlWrk = $this->labelbahan->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->labelbahan->EditValue = $arwrk;
            }
            $this->labelbahan->PlaceHolder = RemoveHtml($this->labelbahan->caption());

            // labelkualitas
            $this->labelkualitas->EditCustomAttributes = "";
            $curVal = trim(strval($this->labelkualitas->CurrentValue));
            if ($curVal != "") {
                $this->labelkualitas->ViewValue = $this->labelkualitas->lookupCacheOption($curVal);
            } else {
                $this->labelkualitas->ViewValue = $this->labelkualitas->Lookup !== null && is_array($this->labelkualitas->Lookup->Options) ? $curVal : null;
            }
            if ($this->labelkualitas->ViewValue !== null) { // Load from cache
                $this->labelkualitas->EditValue = array_values($this->labelkualitas->Lookup->Options);
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
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                }
                $sqlWrk = $this->labelkualitas->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->labelkualitas->EditValue = $arwrk;
            }
            $this->labelkualitas->PlaceHolder = RemoveHtml($this->labelkualitas->caption());

            // labelposisi
            $this->labelposisi->EditCustomAttributes = "";
            $curVal = trim(strval($this->labelposisi->CurrentValue));
            if ($curVal != "") {
                $this->labelposisi->ViewValue = $this->labelposisi->lookupCacheOption($curVal);
            } else {
                $this->labelposisi->ViewValue = $this->labelposisi->Lookup !== null && is_array($this->labelposisi->Lookup->Options) ? $curVal : null;
            }
            if ($this->labelposisi->ViewValue !== null) { // Load from cache
                $this->labelposisi->EditValue = array_values($this->labelposisi->Lookup->Options);
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
                        $filterWrk .= "`value`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                }
                $sqlWrk = $this->labelposisi->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->labelposisi->EditValue = $arwrk;
            }
            $this->labelposisi->PlaceHolder = RemoveHtml($this->labelposisi->caption());

            // labelcatatan
            $this->labelcatatan->EditAttrs["class"] = "form-control";
            $this->labelcatatan->EditCustomAttributes = "";
            $this->labelcatatan->EditValue = HtmlEncode($this->labelcatatan->CurrentValue);
            $this->labelcatatan->PlaceHolder = RemoveHtml($this->labelcatatan->caption());

            // status
            $this->status->EditAttrs["class"] = "form-control";
            $this->status->EditCustomAttributes = "";
            if (!$this->status->Raw) {
                $this->status->CurrentValue = HtmlDecode($this->status->CurrentValue);
            }
            $this->status->EditValue = HtmlEncode($this->status->CurrentValue);
            $this->status->PlaceHolder = RemoveHtml($this->status->caption());

            // Add refer script

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

            // tanggal_order
            $this->tanggal_order->LinkCustomAttributes = "";
            $this->tanggal_order->HrefValue = "";

            // target_selesai
            $this->target_selesai->LinkCustomAttributes = "";
            $this->target_selesai->HrefValue = "";

            // idbrand
            $this->idbrand->LinkCustomAttributes = "";
            $this->idbrand->HrefValue = "";

            // sifatorder
            $this->sifatorder->LinkCustomAttributes = "";
            $this->sifatorder->HrefValue = "";

            // kodeorder
            $this->kodeorder->LinkCustomAttributes = "";
            $this->kodeorder->HrefValue = "";

            // nomororder
            $this->nomororder->LinkCustomAttributes = "";
            $this->nomororder->HrefValue = "";

            // idpegawai
            $this->idpegawai->LinkCustomAttributes = "";
            $this->idpegawai->HrefValue = "";

            // idcustomer
            $this->idcustomer->LinkCustomAttributes = "";
            $this->idcustomer->HrefValue = "";

            // idkategoriproduk
            $this->idkategoriproduk->LinkCustomAttributes = "";
            $this->idkategoriproduk->HrefValue = "";

            // idjenisproduk
            $this->idjenisproduk->LinkCustomAttributes = "";
            $this->idjenisproduk->HrefValue = "";

            // fungsiproduk
            $this->fungsiproduk->LinkCustomAttributes = "";
            $this->fungsiproduk->HrefValue = "";

            // kualitasproduk
            $this->kualitasproduk->LinkCustomAttributes = "";
            $this->kualitasproduk->HrefValue = "";

            // bahan_campaign
            $this->bahan_campaign->LinkCustomAttributes = "";
            $this->bahan_campaign->HrefValue = "";

            // ukuran_sediaan
            $this->ukuran_sediaan->LinkCustomAttributes = "";
            $this->ukuran_sediaan->HrefValue = "";

            // bentuk
            $this->bentuk->LinkCustomAttributes = "";
            $this->bentuk->HrefValue = "";

            // viskositas
            $this->viskositas->LinkCustomAttributes = "";
            $this->viskositas->HrefValue = "";

            // warna
            $this->warna->LinkCustomAttributes = "";
            $this->warna->HrefValue = "";

            // parfum
            $this->parfum->LinkCustomAttributes = "";
            $this->parfum->HrefValue = "";

            // aplikasi
            $this->aplikasi->LinkCustomAttributes = "";
            $this->aplikasi->HrefValue = "";

            // estetika
            $this->estetika->LinkCustomAttributes = "";
            $this->estetika->HrefValue = "";

            // tambahan
            $this->tambahan->LinkCustomAttributes = "";
            $this->tambahan->HrefValue = "";

            // ukurankemasan
            $this->ukurankemasan->LinkCustomAttributes = "";
            $this->ukurankemasan->HrefValue = "";

            // kemasanbentuk
            $this->kemasanbentuk->LinkCustomAttributes = "";
            $this->kemasanbentuk->HrefValue = "";

            // kemasantutup
            $this->kemasantutup->LinkCustomAttributes = "";
            $this->kemasantutup->HrefValue = "";

            // kemasancatatan
            $this->kemasancatatan->LinkCustomAttributes = "";
            $this->kemasancatatan->HrefValue = "";

            // labelbahan
            $this->labelbahan->LinkCustomAttributes = "";
            $this->labelbahan->HrefValue = "";

            // labelkualitas
            $this->labelkualitas->LinkCustomAttributes = "";
            $this->labelkualitas->HrefValue = "";

            // labelposisi
            $this->labelposisi->LinkCustomAttributes = "";
            $this->labelposisi->HrefValue = "";

            // labelcatatan
            $this->labelcatatan->LinkCustomAttributes = "";
            $this->labelcatatan->HrefValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
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
        if ($this->id->Required) {
            if (!$this->id->IsDetailKey && EmptyValue($this->id->FormValue)) {
                $this->id->addErrorMessage(str_replace("%s", $this->id->caption(), $this->id->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->id->FormValue)) {
            $this->id->addErrorMessage($this->id->getErrorMessage(false));
        }
        if ($this->tanggal_order->Required) {
            if (!$this->tanggal_order->IsDetailKey && EmptyValue($this->tanggal_order->FormValue)) {
                $this->tanggal_order->addErrorMessage(str_replace("%s", $this->tanggal_order->caption(), $this->tanggal_order->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tanggal_order->FormValue)) {
            $this->tanggal_order->addErrorMessage($this->tanggal_order->getErrorMessage(false));
        }
        if ($this->target_selesai->Required) {
            if (!$this->target_selesai->IsDetailKey && EmptyValue($this->target_selesai->FormValue)) {
                $this->target_selesai->addErrorMessage(str_replace("%s", $this->target_selesai->caption(), $this->target_selesai->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->target_selesai->FormValue)) {
            $this->target_selesai->addErrorMessage($this->target_selesai->getErrorMessage(false));
        }
        if ($this->idbrand->Required) {
            if (!$this->idbrand->IsDetailKey && EmptyValue($this->idbrand->FormValue)) {
                $this->idbrand->addErrorMessage(str_replace("%s", $this->idbrand->caption(), $this->idbrand->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->idbrand->FormValue)) {
            $this->idbrand->addErrorMessage($this->idbrand->getErrorMessage(false));
        }
        if ($this->sifatorder->Required) {
            if ($this->sifatorder->FormValue == "") {
                $this->sifatorder->addErrorMessage(str_replace("%s", $this->sifatorder->caption(), $this->sifatorder->RequiredErrorMessage));
            }
        }
        if ($this->kodeorder->Required) {
            if (!$this->kodeorder->IsDetailKey && EmptyValue($this->kodeorder->FormValue)) {
                $this->kodeorder->addErrorMessage(str_replace("%s", $this->kodeorder->caption(), $this->kodeorder->RequiredErrorMessage));
            }
        }
        if ($this->nomororder->Required) {
            if (!$this->nomororder->IsDetailKey && EmptyValue($this->nomororder->FormValue)) {
                $this->nomororder->addErrorMessage(str_replace("%s", $this->nomororder->caption(), $this->nomororder->RequiredErrorMessage));
            }
        }
        if ($this->idpegawai->Required) {
            if (!$this->idpegawai->IsDetailKey && EmptyValue($this->idpegawai->FormValue)) {
                $this->idpegawai->addErrorMessage(str_replace("%s", $this->idpegawai->caption(), $this->idpegawai->RequiredErrorMessage));
            }
        }
        if ($this->idcustomer->Required) {
            if (!$this->idcustomer->IsDetailKey && EmptyValue($this->idcustomer->FormValue)) {
                $this->idcustomer->addErrorMessage(str_replace("%s", $this->idcustomer->caption(), $this->idcustomer->RequiredErrorMessage));
            }
        }
        if ($this->idkategoriproduk->Required) {
            if (!$this->idkategoriproduk->IsDetailKey && EmptyValue($this->idkategoriproduk->FormValue)) {
                $this->idkategoriproduk->addErrorMessage(str_replace("%s", $this->idkategoriproduk->caption(), $this->idkategoriproduk->RequiredErrorMessage));
            }
        }
        if ($this->idjenisproduk->Required) {
            if (!$this->idjenisproduk->IsDetailKey && EmptyValue($this->idjenisproduk->FormValue)) {
                $this->idjenisproduk->addErrorMessage(str_replace("%s", $this->idjenisproduk->caption(), $this->idjenisproduk->RequiredErrorMessage));
            }
        }
        if ($this->fungsiproduk->Required) {
            if (!$this->fungsiproduk->IsDetailKey && EmptyValue($this->fungsiproduk->FormValue)) {
                $this->fungsiproduk->addErrorMessage(str_replace("%s", $this->fungsiproduk->caption(), $this->fungsiproduk->RequiredErrorMessage));
            }
        }
        if ($this->kualitasproduk->Required) {
            if (!$this->kualitasproduk->IsDetailKey && EmptyValue($this->kualitasproduk->FormValue)) {
                $this->kualitasproduk->addErrorMessage(str_replace("%s", $this->kualitasproduk->caption(), $this->kualitasproduk->RequiredErrorMessage));
            }
        }
        if ($this->bahan_campaign->Required) {
            if (!$this->bahan_campaign->IsDetailKey && EmptyValue($this->bahan_campaign->FormValue)) {
                $this->bahan_campaign->addErrorMessage(str_replace("%s", $this->bahan_campaign->caption(), $this->bahan_campaign->RequiredErrorMessage));
            }
        }
        if ($this->ukuran_sediaan->Required) {
            if (!$this->ukuran_sediaan->IsDetailKey && EmptyValue($this->ukuran_sediaan->FormValue)) {
                $this->ukuran_sediaan->addErrorMessage(str_replace("%s", $this->ukuran_sediaan->caption(), $this->ukuran_sediaan->RequiredErrorMessage));
            }
        }
        if ($this->bentuk->Required) {
            if ($this->bentuk->FormValue == "") {
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
        if ($this->parfum->Required) {
            if ($this->parfum->FormValue == "") {
                $this->parfum->addErrorMessage(str_replace("%s", $this->parfum->caption(), $this->parfum->RequiredErrorMessage));
            }
        }
        if ($this->aplikasi->Required) {
            if ($this->aplikasi->FormValue == "") {
                $this->aplikasi->addErrorMessage(str_replace("%s", $this->aplikasi->caption(), $this->aplikasi->RequiredErrorMessage));
            }
        }
        if ($this->estetika->Required) {
            if ($this->estetika->FormValue == "") {
                $this->estetika->addErrorMessage(str_replace("%s", $this->estetika->caption(), $this->estetika->RequiredErrorMessage));
            }
        }
        if ($this->tambahan->Required) {
            if (!$this->tambahan->IsDetailKey && EmptyValue($this->tambahan->FormValue)) {
                $this->tambahan->addErrorMessage(str_replace("%s", $this->tambahan->caption(), $this->tambahan->RequiredErrorMessage));
            }
        }
        if ($this->ukurankemasan->Required) {
            if (!$this->ukurankemasan->IsDetailKey && EmptyValue($this->ukurankemasan->FormValue)) {
                $this->ukurankemasan->addErrorMessage(str_replace("%s", $this->ukurankemasan->caption(), $this->ukurankemasan->RequiredErrorMessage));
            }
        }
        if ($this->kemasanbentuk->Required) {
            if ($this->kemasanbentuk->FormValue == "") {
                $this->kemasanbentuk->addErrorMessage(str_replace("%s", $this->kemasanbentuk->caption(), $this->kemasanbentuk->RequiredErrorMessage));
            }
        }
        if ($this->kemasantutup->Required) {
            if ($this->kemasantutup->FormValue == "") {
                $this->kemasantutup->addErrorMessage(str_replace("%s", $this->kemasantutup->caption(), $this->kemasantutup->RequiredErrorMessage));
            }
        }
        if ($this->kemasancatatan->Required) {
            if (!$this->kemasancatatan->IsDetailKey && EmptyValue($this->kemasancatatan->FormValue)) {
                $this->kemasancatatan->addErrorMessage(str_replace("%s", $this->kemasancatatan->caption(), $this->kemasancatatan->RequiredErrorMessage));
            }
        }
        if ($this->labelbahan->Required) {
            if ($this->labelbahan->FormValue == "") {
                $this->labelbahan->addErrorMessage(str_replace("%s", $this->labelbahan->caption(), $this->labelbahan->RequiredErrorMessage));
            }
        }
        if ($this->labelkualitas->Required) {
            if ($this->labelkualitas->FormValue == "") {
                $this->labelkualitas->addErrorMessage(str_replace("%s", $this->labelkualitas->caption(), $this->labelkualitas->RequiredErrorMessage));
            }
        }
        if ($this->labelposisi->Required) {
            if ($this->labelposisi->FormValue == "") {
                $this->labelposisi->addErrorMessage(str_replace("%s", $this->labelposisi->caption(), $this->labelposisi->RequiredErrorMessage));
            }
        }
        if ($this->labelcatatan->Required) {
            if (!$this->labelcatatan->IsDetailKey && EmptyValue($this->labelcatatan->FormValue)) {
                $this->labelcatatan->addErrorMessage(str_replace("%s", $this->labelcatatan->caption(), $this->labelcatatan->RequiredErrorMessage));
            }
        }
        if ($this->status->Required) {
            if (!$this->status->IsDetailKey && EmptyValue($this->status->FormValue)) {
                $this->status->addErrorMessage(str_replace("%s", $this->status->caption(), $this->status->RequiredErrorMessage));
            }
        }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("NpdSampleGrid");
        if (in_array("npd_sample", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->validateGridForm();
        }
        $detailPage = Container("NpdReviewGrid");
        if (in_array("npd_review", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->validateGridForm();
        }
        $detailPage = Container("NpdConfirmGrid");
        if (in_array("npd_confirm", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->validateGridForm();
        }
        $detailPage = Container("NpdHargaGrid");
        if (in_array("npd_harga", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->validateGridForm();
        }
        $detailPage = Container("NpdDesainGrid");
        if (in_array("npd_desain", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->validateGridForm();
        }
        $detailPage = Container("NpdTermsGrid");
        if (in_array("npd_terms", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->validateGridForm();
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
        if ($this->kodeorder->CurrentValue != "") { // Check field with unique index
            $filter = "(`kodeorder` = '" . AdjustSql($this->kodeorder->CurrentValue, $this->Dbid) . "')";
            $rsChk = $this->loadRs($filter)->fetch();
            if ($rsChk !== false) {
                $idxErrMsg = str_replace("%f", $this->kodeorder->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->kodeorder->CurrentValue, $idxErrMsg);
                $this->setFailureMessage($idxErrMsg);
                return false;
            }
        }
        $conn = $this->getConnection();

        // Begin transaction
        if ($this->getCurrentDetailTable() != "") {
            $conn->beginTransaction();
        }

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // id
        $this->id->setDbValueDef($rsnew, $this->id->CurrentValue, 0, strval($this->id->CurrentValue) == "");

        // tanggal_order
        $this->tanggal_order->setDbValueDef($rsnew, UnFormatDateTime($this->tanggal_order->CurrentValue, 0), null, false);

        // target_selesai
        $this->target_selesai->setDbValueDef($rsnew, UnFormatDateTime($this->target_selesai->CurrentValue, 0), null, false);

        // idbrand
        $this->idbrand->setDbValueDef($rsnew, $this->idbrand->CurrentValue, 0, strval($this->idbrand->CurrentValue) == "");

        // sifatorder
        $this->sifatorder->setDbValueDef($rsnew, $this->sifatorder->CurrentValue, "", false);

        // kodeorder
        $this->kodeorder->setDbValueDef($rsnew, $this->kodeorder->CurrentValue, "", false);

        // nomororder
        $this->nomororder->setDbValueDef($rsnew, $this->nomororder->CurrentValue, "", false);

        // idpegawai
        $this->idpegawai->setDbValueDef($rsnew, $this->idpegawai->CurrentValue, 0, false);

        // idcustomer
        $this->idcustomer->setDbValueDef($rsnew, $this->idcustomer->CurrentValue, 0, strval($this->idcustomer->CurrentValue) == "");

        // idkategoriproduk
        $this->idkategoriproduk->setDbValueDef($rsnew, $this->idkategoriproduk->CurrentValue, 0, false);

        // idjenisproduk
        $this->idjenisproduk->setDbValueDef($rsnew, $this->idjenisproduk->CurrentValue, null, false);

        // fungsiproduk
        $this->fungsiproduk->setDbValueDef($rsnew, $this->fungsiproduk->CurrentValue, null, false);

        // kualitasproduk
        $this->kualitasproduk->setDbValueDef($rsnew, $this->kualitasproduk->CurrentValue, null, false);

        // bahan_campaign
        $this->bahan_campaign->setDbValueDef($rsnew, $this->bahan_campaign->CurrentValue, null, false);

        // ukuran_sediaan
        $this->ukuran_sediaan->setDbValueDef($rsnew, $this->ukuran_sediaan->CurrentValue, "", false);

        // bentuk
        $this->bentuk->setDbValueDef($rsnew, $this->bentuk->CurrentValue, "", false);

        // viskositas
        $this->viskositas->setDbValueDef($rsnew, $this->viskositas->CurrentValue, "", false);

        // warna
        $this->warna->setDbValueDef($rsnew, $this->warna->CurrentValue, "", false);

        // parfum
        $this->parfum->setDbValueDef($rsnew, $this->parfum->CurrentValue, "", false);

        // aplikasi
        $this->aplikasi->setDbValueDef($rsnew, $this->aplikasi->CurrentValue, "", false);

        // estetika
        $this->estetika->setDbValueDef($rsnew, $this->estetika->CurrentValue, "", false);

        // tambahan
        $this->tambahan->setDbValueDef($rsnew, $this->tambahan->CurrentValue, null, false);

        // ukurankemasan
        $this->ukurankemasan->setDbValueDef($rsnew, $this->ukurankemasan->CurrentValue, "", false);

        // kemasanbentuk
        $this->kemasanbentuk->setDbValueDef($rsnew, $this->kemasanbentuk->CurrentValue, "", false);

        // kemasantutup
        $this->kemasantutup->setDbValueDef($rsnew, $this->kemasantutup->CurrentValue, "", false);

        // kemasancatatan
        $this->kemasancatatan->setDbValueDef($rsnew, $this->kemasancatatan->CurrentValue, null, false);

        // labelbahan
        $this->labelbahan->setDbValueDef($rsnew, $this->labelbahan->CurrentValue, "", false);

        // labelkualitas
        $this->labelkualitas->setDbValueDef($rsnew, $this->labelkualitas->CurrentValue, "", false);

        // labelposisi
        $this->labelposisi->setDbValueDef($rsnew, $this->labelposisi->CurrentValue, "", false);

        // labelcatatan
        $this->labelcatatan->setDbValueDef($rsnew, $this->labelcatatan->CurrentValue, null, false);

        // status
        $this->status->setDbValueDef($rsnew, $this->status->CurrentValue, "", false);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);

        // Check if key value entered
        if ($insertRow && $this->ValidateKey && strval($rsnew['id']) == "") {
            $this->setFailureMessage($Language->phrase("InvalidKeyValue"));
            $insertRow = false;
        }

        // Check for duplicate key
        if ($insertRow && $this->ValidateKey) {
            $filter = $this->getRecordFilter($rsnew);
            $rsChk = $this->loadRs($filter)->fetch();
            if ($rsChk !== false) {
                $keyErrMsg = str_replace("%f", $filter, $Language->phrase("DupKey"));
                $this->setFailureMessage($keyErrMsg);
                $insertRow = false;
            }
        }
        $addRow = false;
        if ($insertRow) {
            try {
                $addRow = $this->insert($rsnew);
            } catch (\Exception $e) {
                $this->setFailureMessage($e->getMessage());
            }
            if ($addRow) {
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

        // Add detail records
        if ($addRow) {
            $detailTblVar = explode(",", $this->getCurrentDetailTable());
            $detailPage = Container("NpdSampleGrid");
            if (in_array("npd_sample", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->idnpd->setSessionValue($this->id->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "npd_sample"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->idnpd->setSessionValue(""); // Clear master key if insert failed
                }
            }
            $detailPage = Container("NpdReviewGrid");
            if (in_array("npd_review", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->idnpd->setSessionValue($this->id->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "npd_review"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->idnpd->setSessionValue(""); // Clear master key if insert failed
                }
            }
            $detailPage = Container("NpdConfirmGrid");
            if (in_array("npd_confirm", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->idnpd->setSessionValue($this->id->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "npd_confirm"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->idnpd->setSessionValue(""); // Clear master key if insert failed
                }
            }
            $detailPage = Container("NpdHargaGrid");
            if (in_array("npd_harga", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->idnpd->setSessionValue($this->id->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "npd_harga"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->idnpd->setSessionValue(""); // Clear master key if insert failed
                }
            }
            $detailPage = Container("NpdDesainGrid");
            if (in_array("npd_desain", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->idnpd->setSessionValue($this->id->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "npd_desain"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->idnpd->setSessionValue(""); // Clear master key if insert failed
                }
            }
            $detailPage = Container("NpdTermsGrid");
            if (in_array("npd_terms", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->idnpd->setSessionValue($this->id->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "npd_terms"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->idnpd->setSessionValue(""); // Clear master key if insert failed
                }
            }
        }

        // Commit/Rollback transaction
        if ($this->getCurrentDetailTable() != "") {
            if ($addRow) {
                $conn->commit(); // Commit transaction
            } else {
                $conn->rollback(); // Rollback transaction
            }
        }
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($addRow) {
        }

        // Write JSON for API request
        if (IsApi() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $addRow;
    }

    // Set up detail parms based on QueryString
    protected function setupDetailParms()
    {
        // Get the keys for master table
        $detailTblVar = Get(Config("TABLE_SHOW_DETAIL"));
        if ($detailTblVar !== null) {
            $this->setCurrentDetailTable($detailTblVar);
        } else {
            $detailTblVar = $this->getCurrentDetailTable();
        }
        if ($detailTblVar != "") {
            $detailTblVar = explode(",", $detailTblVar);
            if (in_array("npd_sample", $detailTblVar)) {
                $detailPageObj = Container("NpdSampleGrid");
                if ($detailPageObj->DetailAdd) {
                    if ($this->CopyRecord) {
                        $detailPageObj->CurrentMode = "copy";
                    } else {
                        $detailPageObj->CurrentMode = "add";
                    }
                    $detailPageObj->CurrentAction = "gridadd";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->idnpd->IsDetailKey = true;
                    $detailPageObj->idnpd->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->idnpd->setSessionValue($detailPageObj->idnpd->CurrentValue);
                    $detailPageObj->idserahterima->setSessionValue(""); // Clear session key
                }
            }
            if (in_array("npd_review", $detailTblVar)) {
                $detailPageObj = Container("NpdReviewGrid");
                if ($detailPageObj->DetailAdd) {
                    if ($this->CopyRecord) {
                        $detailPageObj->CurrentMode = "copy";
                    } else {
                        $detailPageObj->CurrentMode = "add";
                    }
                    $detailPageObj->CurrentAction = "gridadd";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->idnpd->IsDetailKey = true;
                    $detailPageObj->idnpd->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->idnpd->setSessionValue($detailPageObj->idnpd->CurrentValue);
                }
            }
            if (in_array("npd_confirm", $detailTblVar)) {
                $detailPageObj = Container("NpdConfirmGrid");
                if ($detailPageObj->DetailAdd) {
                    if ($this->CopyRecord) {
                        $detailPageObj->CurrentMode = "copy";
                    } else {
                        $detailPageObj->CurrentMode = "add";
                    }
                    $detailPageObj->CurrentAction = "gridadd";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->idnpd->IsDetailKey = true;
                    $detailPageObj->idnpd->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->idnpd->setSessionValue($detailPageObj->idnpd->CurrentValue);
                }
            }
            if (in_array("npd_harga", $detailTblVar)) {
                $detailPageObj = Container("NpdHargaGrid");
                if ($detailPageObj->DetailAdd) {
                    if ($this->CopyRecord) {
                        $detailPageObj->CurrentMode = "copy";
                    } else {
                        $detailPageObj->CurrentMode = "add";
                    }
                    $detailPageObj->CurrentAction = "gridadd";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->idnpd->IsDetailKey = true;
                    $detailPageObj->idnpd->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->idnpd->setSessionValue($detailPageObj->idnpd->CurrentValue);
                }
            }
            if (in_array("npd_desain", $detailTblVar)) {
                $detailPageObj = Container("NpdDesainGrid");
                if ($detailPageObj->DetailAdd) {
                    if ($this->CopyRecord) {
                        $detailPageObj->CurrentMode = "copy";
                    } else {
                        $detailPageObj->CurrentMode = "add";
                    }
                    $detailPageObj->CurrentAction = "gridadd";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->idnpd->IsDetailKey = true;
                    $detailPageObj->idnpd->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->idnpd->setSessionValue($detailPageObj->idnpd->CurrentValue);
                }
            }
            if (in_array("npd_terms", $detailTblVar)) {
                $detailPageObj = Container("NpdTermsGrid");
                if ($detailPageObj->DetailAdd) {
                    if ($this->CopyRecord) {
                        $detailPageObj->CurrentMode = "copy";
                    } else {
                        $detailPageObj->CurrentMode = "add";
                    }
                    $detailPageObj->CurrentAction = "gridadd";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->idnpd->IsDetailKey = true;
                    $detailPageObj->idnpd->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->idnpd->setSessionValue($detailPageObj->idnpd->CurrentValue);
                }
            }
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("NpdList"), "", $this->TableVar, true);
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $Breadcrumb->add("add", $pageId, $url);
    }

    // Set up detail pages
    protected function setupDetailPages()
    {
        $pages = new SubPages();
        $pages->Style = "tabs";
        $pages->add('npd_sample');
        $pages->add('npd_review');
        $pages->add('npd_confirm');
        $pages->add('npd_harga');
        $pages->add('npd_desain');
        $pages->add('npd_terms');
        $this->DetailPages = $pages;
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
                case "x_sifatorder":
                    break;
                case "x_idpegawai":
                    break;
                case "x_idcustomer":
                    break;
                case "x_idproduct_acuan":
                    $lookupFilter = function () {
                        return (CurrentPageID() == "add" || CurrentPageID() == "edit") ? "idbrand = 1" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_idkategoriproduk":
                    break;
                case "x_idjenisproduk":
                    break;
                case "x_bentuk":
                    break;
                case "x_viskositas":
                    break;
                case "x_warna":
                    break;
                case "x_parfum":
                    break;
                case "x_aplikasi":
                    break;
                case "x_estetika":
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

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in CustomError
        return true;
    }
}
