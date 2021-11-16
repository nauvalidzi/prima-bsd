<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class NpdEdit extends Npd
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'npd';

    // Page object name
    public $PageObjName = "NpdEdit";

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
    public $FormClassName = "ew-horizontal ew-form ew-edit-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $HashValue; // Hash Value
    public $DisplayRecords = 1;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecordCount;
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
        $this->id->Visible = false;
        $this->status->setVisibility();
        $this->idpegawai->setVisibility();
        $this->idcustomer->setVisibility();
        $this->kodeorder->setVisibility();
        $this->idproduct_acuan->setVisibility();
        $this->nama->setVisibility();
        $this->idjenisbarang->setVisibility();
        $this->idkategoribarang->setVisibility();
        $this->warna->setVisibility();
        $this->parfum->setVisibility();
        $this->tambahan->setVisibility();
        $this->kemasanbarang->setVisibility();
        $this->label->setVisibility();
        $this->orderperdana->setVisibility();
        $this->orderreguler->setVisibility();
        $this->selesai->Visible = false;
        $this->readonly->Visible = false;
        $this->created_at->Visible = false;
        $this->tanggal_order->setVisibility();
        $this->target_selesai->setVisibility();
        $this->kategori->setVisibility();
        $this->fungsi_produk->setVisibility();
        $this->kualitasbarang->setVisibility();
        $this->bahan_campaign->setVisibility();
        $this->ukuran_sediaan->setVisibility();
        $this->hideFieldsForAddEdit();
        $this->idpegawai->Required = false;
        $this->idcustomer->Required = false;
        $this->kodeorder->Required = false;

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
        $this->setupLookupOptions($this->idjenisbarang);
        $this->setupLookupOptions($this->idkategoribarang);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-edit-form ew-horizontal";
        $loaded = false;
        $postBack = false;

        // Set up current action and primary key
        if (IsApi()) {
            // Load key values
            $loaded = true;
            if (($keyValue = Get("id") ?? Key(0) ?? Route(2)) !== null) {
                $this->id->setQueryStringValue($keyValue);
                $this->id->setOldValue($this->id->QueryStringValue);
            } elseif (Post("id") !== null) {
                $this->id->setFormValue(Post("id"));
                $this->id->setOldValue($this->id->FormValue);
            } else {
                $loaded = false; // Unable to load key
            }

            // Load record
            if ($loaded) {
                $loaded = $this->loadRow();
            }
            if (!$loaded) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                $this->terminate();
                return;
            }
            $this->CurrentAction = "update"; // Update record directly
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $postBack = true;
        } else {
            if (Post("action") !== null) {
                $this->CurrentAction = Post("action"); // Get action code
                if (!$this->isShow()) { // Not reload record, handle as postback
                    $postBack = true;
                }

                // Get key from Form
                $this->setKey(Post($this->OldKeyName), $this->isShow());
            } else {
                $this->CurrentAction = "show"; // Default action is display

                // Load key from QueryString
                $loadByQuery = false;
                if (($keyValue = Get("id") ?? Route("id")) !== null) {
                    $this->id->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->id->CurrentValue = null;
                }
            }

            // Load recordset
            if ($this->isShow()) {
                // Load current record
                $loaded = $this->loadRow();
                $this->OldKey = $loaded ? $this->getKey(true) : ""; // Get from CurrentValue
            }
        }

        // Process form if post back
        if ($postBack) {
            $this->loadFormValues(); // Get form values

            // Set up detail parameters
            $this->setupDetailParms();
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues();
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = ""; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "show": // Get a record to display
                if (!$loaded) { // Load record based on key
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("NpdList"); // No matching record, return to list
                    return;
                }

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "update": // Update
                if ($this->getCurrentDetailTable() != "") { // Master/detail edit
                    $returnUrl = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=" . $this->getCurrentDetailTable()); // Master/Detail view page
                } else {
                    $returnUrl = $this->getReturnUrl();
                }
                if (GetPageName($returnUrl) == "NpdList") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) { // Update record based on key
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
                    }
                    if (IsApi()) {
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl); // Return to caller
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } elseif ($this->getFailureMessage() == $Language->phrase("NoRecord")) {
                    $this->terminate($returnUrl); // Return to caller
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Restore form values if update failed

                    // Set up detail parameters
                    $this->setupDetailParms();
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render the record
        $this->RowType = ROWTYPE_EDIT; // Render as Edit
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

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'status' first before field var 'x_status'
        $val = $CurrentForm->hasValue("status") ? $CurrentForm->getValue("status") : $CurrentForm->getValue("x_status");
        if (!$this->status->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->status->Visible = false; // Disable update for API request
            } else {
                $this->status->setFormValue($val);
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

        // Check field name 'kodeorder' first before field var 'x_kodeorder'
        $val = $CurrentForm->hasValue("kodeorder") ? $CurrentForm->getValue("kodeorder") : $CurrentForm->getValue("x_kodeorder");
        if (!$this->kodeorder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kodeorder->Visible = false; // Disable update for API request
            } else {
                $this->kodeorder->setFormValue($val);
            }
        }

        // Check field name 'idproduct_acuan' first before field var 'x_idproduct_acuan'
        $val = $CurrentForm->hasValue("idproduct_acuan") ? $CurrentForm->getValue("idproduct_acuan") : $CurrentForm->getValue("x_idproduct_acuan");
        if (!$this->idproduct_acuan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idproduct_acuan->Visible = false; // Disable update for API request
            } else {
                $this->idproduct_acuan->setFormValue($val);
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

        // Check field name 'idjenisbarang' first before field var 'x_idjenisbarang'
        $val = $CurrentForm->hasValue("idjenisbarang") ? $CurrentForm->getValue("idjenisbarang") : $CurrentForm->getValue("x_idjenisbarang");
        if (!$this->idjenisbarang->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idjenisbarang->Visible = false; // Disable update for API request
            } else {
                $this->idjenisbarang->setFormValue($val);
            }
        }

        // Check field name 'idkategoribarang' first before field var 'x_idkategoribarang'
        $val = $CurrentForm->hasValue("idkategoribarang") ? $CurrentForm->getValue("idkategoribarang") : $CurrentForm->getValue("x_idkategoribarang");
        if (!$this->idkategoribarang->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idkategoribarang->Visible = false; // Disable update for API request
            } else {
                $this->idkategoribarang->setFormValue($val);
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

        // Check field name 'tambahan' first before field var 'x_tambahan'
        $val = $CurrentForm->hasValue("tambahan") ? $CurrentForm->getValue("tambahan") : $CurrentForm->getValue("x_tambahan");
        if (!$this->tambahan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tambahan->Visible = false; // Disable update for API request
            } else {
                $this->tambahan->setFormValue($val);
            }
        }

        // Check field name 'kemasanbarang' first before field var 'x_kemasanbarang'
        $val = $CurrentForm->hasValue("kemasanbarang") ? $CurrentForm->getValue("kemasanbarang") : $CurrentForm->getValue("x_kemasanbarang");
        if (!$this->kemasanbarang->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kemasanbarang->Visible = false; // Disable update for API request
            } else {
                $this->kemasanbarang->setFormValue($val);
            }
        }

        // Check field name 'label' first before field var 'x_label'
        $val = $CurrentForm->hasValue("label") ? $CurrentForm->getValue("label") : $CurrentForm->getValue("x_label");
        if (!$this->label->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->label->Visible = false; // Disable update for API request
            } else {
                $this->label->setFormValue($val);
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

        // Check field name 'orderreguler' first before field var 'x_orderreguler'
        $val = $CurrentForm->hasValue("orderreguler") ? $CurrentForm->getValue("orderreguler") : $CurrentForm->getValue("x_orderreguler");
        if (!$this->orderreguler->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->orderreguler->Visible = false; // Disable update for API request
            } else {
                $this->orderreguler->setFormValue($val);
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

        // Check field name 'kategori' first before field var 'x_kategori'
        $val = $CurrentForm->hasValue("kategori") ? $CurrentForm->getValue("kategori") : $CurrentForm->getValue("x_kategori");
        if (!$this->kategori->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kategori->Visible = false; // Disable update for API request
            } else {
                $this->kategori->setFormValue($val);
            }
        }

        // Check field name 'fungsi_produk' first before field var 'x_fungsi_produk'
        $val = $CurrentForm->hasValue("fungsi_produk") ? $CurrentForm->getValue("fungsi_produk") : $CurrentForm->getValue("x_fungsi_produk");
        if (!$this->fungsi_produk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fungsi_produk->Visible = false; // Disable update for API request
            } else {
                $this->fungsi_produk->setFormValue($val);
            }
        }

        // Check field name 'kualitasbarang' first before field var 'x_kualitasbarang'
        $val = $CurrentForm->hasValue("kualitasbarang") ? $CurrentForm->getValue("kualitasbarang") : $CurrentForm->getValue("x_kualitasbarang");
        if (!$this->kualitasbarang->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kualitasbarang->Visible = false; // Disable update for API request
            } else {
                $this->kualitasbarang->setFormValue($val);
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

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        if (!$this->id->IsDetailKey) {
            $this->id->setFormValue($val);
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id->CurrentValue = $this->id->FormValue;
        $this->status->CurrentValue = $this->status->FormValue;
        $this->idpegawai->CurrentValue = $this->idpegawai->FormValue;
        $this->idcustomer->CurrentValue = $this->idcustomer->FormValue;
        $this->kodeorder->CurrentValue = $this->kodeorder->FormValue;
        $this->idproduct_acuan->CurrentValue = $this->idproduct_acuan->FormValue;
        $this->nama->CurrentValue = $this->nama->FormValue;
        $this->idjenisbarang->CurrentValue = $this->idjenisbarang->FormValue;
        $this->idkategoribarang->CurrentValue = $this->idkategoribarang->FormValue;
        $this->warna->CurrentValue = $this->warna->FormValue;
        $this->parfum->CurrentValue = $this->parfum->FormValue;
        $this->tambahan->CurrentValue = $this->tambahan->FormValue;
        $this->kemasanbarang->CurrentValue = $this->kemasanbarang->FormValue;
        $this->label->CurrentValue = $this->label->FormValue;
        $this->orderperdana->CurrentValue = $this->orderperdana->FormValue;
        $this->orderreguler->CurrentValue = $this->orderreguler->FormValue;
        $this->tanggal_order->CurrentValue = $this->tanggal_order->FormValue;
        $this->tanggal_order->CurrentValue = UnFormatDateTime($this->tanggal_order->CurrentValue, 0);
        $this->target_selesai->CurrentValue = $this->target_selesai->FormValue;
        $this->target_selesai->CurrentValue = UnFormatDateTime($this->target_selesai->CurrentValue, 0);
        $this->kategori->CurrentValue = $this->kategori->FormValue;
        $this->fungsi_produk->CurrentValue = $this->fungsi_produk->FormValue;
        $this->kualitasbarang->CurrentValue = $this->kualitasbarang->FormValue;
        $this->bahan_campaign->CurrentValue = $this->bahan_campaign->FormValue;
        $this->ukuran_sediaan->CurrentValue = $this->ukuran_sediaan->FormValue;
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
        $this->status->setDbValue($row['status']);
        $this->idpegawai->setDbValue($row['idpegawai']);
        $this->idcustomer->setDbValue($row['idcustomer']);
        $this->kodeorder->setDbValue($row['kodeorder']);
        $this->idproduct_acuan->setDbValue($row['idproduct_acuan']);
        $this->nama->setDbValue($row['nama']);
        $this->idjenisbarang->setDbValue($row['idjenisbarang']);
        $this->idkategoribarang->setDbValue($row['idkategoribarang']);
        $this->warna->setDbValue($row['warna']);
        $this->parfum->setDbValue($row['parfum']);
        $this->tambahan->setDbValue($row['tambahan']);
        $this->kemasanbarang->setDbValue($row['kemasanbarang']);
        $this->label->setDbValue($row['label']);
        $this->orderperdana->setDbValue($row['orderperdana']);
        $this->orderreguler->setDbValue($row['orderreguler']);
        $this->selesai->setDbValue($row['selesai']);
        $this->readonly->setDbValue($row['readonly']);
        $this->created_at->setDbValue($row['created_at']);
        $this->tanggal_order->setDbValue($row['tanggal_order']);
        $this->target_selesai->setDbValue($row['target_selesai']);
        $this->kategori->setDbValue($row['kategori']);
        $this->fungsi_produk->setDbValue($row['fungsi_produk']);
        $this->kualitasbarang->setDbValue($row['kualitasbarang']);
        $this->bahan_campaign->setDbValue($row['bahan_campaign']);
        $this->ukuran_sediaan->setDbValue($row['ukuran_sediaan']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['status'] = null;
        $row['idpegawai'] = null;
        $row['idcustomer'] = null;
        $row['kodeorder'] = null;
        $row['idproduct_acuan'] = null;
        $row['nama'] = null;
        $row['idjenisbarang'] = null;
        $row['idkategoribarang'] = null;
        $row['warna'] = null;
        $row['parfum'] = null;
        $row['tambahan'] = null;
        $row['kemasanbarang'] = null;
        $row['label'] = null;
        $row['orderperdana'] = null;
        $row['orderreguler'] = null;
        $row['selesai'] = null;
        $row['readonly'] = null;
        $row['created_at'] = null;
        $row['tanggal_order'] = null;
        $row['target_selesai'] = null;
        $row['kategori'] = null;
        $row['fungsi_produk'] = null;
        $row['kualitasbarang'] = null;
        $row['bahan_campaign'] = null;
        $row['ukuran_sediaan'] = null;
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

        // status

        // idpegawai

        // idcustomer

        // kodeorder

        // idproduct_acuan

        // nama

        // idjenisbarang

        // idkategoribarang

        // warna

        // parfum

        // tambahan

        // kemasanbarang

        // label

        // orderperdana

        // orderreguler

        // selesai

        // readonly

        // created_at

        // tanggal_order

        // target_selesai

        // kategori

        // fungsi_produk

        // kualitasbarang

        // bahan_campaign

        // ukuran_sediaan
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // status
            $this->status->ViewValue = $this->status->CurrentValue;
            $this->status->ViewCustomAttributes = "";

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
            $this->idcustomer->ViewValue = $this->idcustomer->CurrentValue;
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

            // kodeorder
            $this->kodeorder->ViewValue = $this->kodeorder->CurrentValue;
            $this->kodeorder->ViewCustomAttributes = "";

            // idproduct_acuan
            $curVal = trim(strval($this->idproduct_acuan->CurrentValue));
            if ($curVal != "") {
                $this->idproduct_acuan->ViewValue = $this->idproduct_acuan->lookupCacheOption($curVal);
                if ($this->idproduct_acuan->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return (CurrentPageID() == "add" || CurrentPageID() == "edit") ? "idbrand = 1" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->idproduct_acuan->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idproduct_acuan->Lookup->renderViewRow($rswrk[0]);
                        $this->idproduct_acuan->ViewValue = $this->idproduct_acuan->displayValue($arwrk);
                    } else {
                        $this->idproduct_acuan->ViewValue = $this->idproduct_acuan->CurrentValue;
                    }
                }
            } else {
                $this->idproduct_acuan->ViewValue = null;
            }
            $this->idproduct_acuan->ViewCustomAttributes = "";

            // nama
            $this->nama->ViewValue = $this->nama->CurrentValue;
            $this->nama->ViewCustomAttributes = "";

            // idjenisbarang
            $curVal = trim(strval($this->idjenisbarang->CurrentValue));
            if ($curVal != "") {
                $this->idjenisbarang->ViewValue = $this->idjenisbarang->lookupCacheOption($curVal);
                if ($this->idjenisbarang->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->idjenisbarang->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idjenisbarang->Lookup->renderViewRow($rswrk[0]);
                        $this->idjenisbarang->ViewValue = $this->idjenisbarang->displayValue($arwrk);
                    } else {
                        $this->idjenisbarang->ViewValue = $this->idjenisbarang->CurrentValue;
                    }
                }
            } else {
                $this->idjenisbarang->ViewValue = null;
            }
            $this->idjenisbarang->ViewCustomAttributes = "";

            // idkategoribarang
            $curVal = trim(strval($this->idkategoribarang->CurrentValue));
            if ($curVal != "") {
                $this->idkategoribarang->ViewValue = $this->idkategoribarang->lookupCacheOption($curVal);
                if ($this->idkategoribarang->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->idkategoribarang->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idkategoribarang->Lookup->renderViewRow($rswrk[0]);
                        $this->idkategoribarang->ViewValue = $this->idkategoribarang->displayValue($arwrk);
                    } else {
                        $this->idkategoribarang->ViewValue = $this->idkategoribarang->CurrentValue;
                    }
                }
            } else {
                $this->idkategoribarang->ViewValue = null;
            }
            $this->idkategoribarang->ViewCustomAttributes = "";

            // warna
            $this->warna->ViewValue = $this->warna->CurrentValue;
            $this->warna->ViewCustomAttributes = "";

            // parfum
            $this->parfum->ViewValue = $this->parfum->CurrentValue;
            $this->parfum->ViewCustomAttributes = "";

            // tambahan
            $this->tambahan->ViewValue = $this->tambahan->CurrentValue;
            $this->tambahan->ViewCustomAttributes = "";

            // kemasanbarang
            $this->kemasanbarang->ViewValue = $this->kemasanbarang->CurrentValue;
            $this->kemasanbarang->ViewCustomAttributes = "";

            // label
            $this->label->ViewValue = $this->label->CurrentValue;
            $this->label->ViewCustomAttributes = "";

            // orderperdana
            $this->orderperdana->ViewValue = $this->orderperdana->CurrentValue;
            $this->orderperdana->ViewValue = FormatNumber($this->orderperdana->ViewValue, 0, -2, -2, -2);
            $this->orderperdana->ViewCustomAttributes = "";

            // orderreguler
            $this->orderreguler->ViewValue = $this->orderreguler->CurrentValue;
            $this->orderreguler->ViewValue = FormatNumber($this->orderreguler->ViewValue, 0, -2, -2, -2);
            $this->orderreguler->ViewCustomAttributes = "";

            // selesai
            if (strval($this->selesai->CurrentValue) != "") {
                $this->selesai->ViewValue = $this->selesai->optionCaption($this->selesai->CurrentValue);
            } else {
                $this->selesai->ViewValue = null;
            }
            $this->selesai->ViewCustomAttributes = "";

            // readonly
            if (strval($this->readonly->CurrentValue) != "") {
                $this->readonly->ViewValue = $this->readonly->optionCaption($this->readonly->CurrentValue);
            } else {
                $this->readonly->ViewValue = null;
            }
            $this->readonly->ViewCustomAttributes = "";

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
            $this->created_at->ViewCustomAttributes = "";

            // tanggal_order
            $this->tanggal_order->ViewValue = $this->tanggal_order->CurrentValue;
            $this->tanggal_order->ViewValue = FormatDateTime($this->tanggal_order->ViewValue, 0);
            $this->tanggal_order->ViewCustomAttributes = "";

            // target_selesai
            $this->target_selesai->ViewValue = $this->target_selesai->CurrentValue;
            $this->target_selesai->ViewValue = FormatDateTime($this->target_selesai->ViewValue, 0);
            $this->target_selesai->ViewCustomAttributes = "";

            // kategori
            $this->kategori->ViewValue = $this->kategori->CurrentValue;
            $this->kategori->ViewCustomAttributes = "";

            // fungsi_produk
            $this->fungsi_produk->ViewValue = $this->fungsi_produk->CurrentValue;
            $this->fungsi_produk->ViewCustomAttributes = "";

            // kualitasbarang
            $this->kualitasbarang->ViewValue = $this->kualitasbarang->CurrentValue;
            $this->kualitasbarang->ViewCustomAttributes = "";

            // bahan_campaign
            $this->bahan_campaign->ViewValue = $this->bahan_campaign->CurrentValue;
            $this->bahan_campaign->ViewCustomAttributes = "";

            // ukuran_sediaan
            $this->ukuran_sediaan->ViewValue = $this->ukuran_sediaan->CurrentValue;
            $this->ukuran_sediaan->ViewCustomAttributes = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
            $this->status->TooltipValue = "";

            // idpegawai
            $this->idpegawai->LinkCustomAttributes = "";
            $this->idpegawai->HrefValue = "";
            $this->idpegawai->TooltipValue = "";

            // idcustomer
            $this->idcustomer->LinkCustomAttributes = "";
            $this->idcustomer->HrefValue = "";
            $this->idcustomer->TooltipValue = "";

            // kodeorder
            $this->kodeorder->LinkCustomAttributes = "";
            $this->kodeorder->HrefValue = "";
            $this->kodeorder->TooltipValue = "";

            // idproduct_acuan
            $this->idproduct_acuan->LinkCustomAttributes = "";
            $this->idproduct_acuan->HrefValue = "";
            $this->idproduct_acuan->TooltipValue = "";

            // nama
            $this->nama->LinkCustomAttributes = "";
            $this->nama->HrefValue = "";
            $this->nama->TooltipValue = "";

            // idjenisbarang
            $this->idjenisbarang->LinkCustomAttributes = "";
            $this->idjenisbarang->HrefValue = "";
            $this->idjenisbarang->TooltipValue = "";

            // idkategoribarang
            $this->idkategoribarang->LinkCustomAttributes = "";
            $this->idkategoribarang->HrefValue = "";
            $this->idkategoribarang->TooltipValue = "";

            // warna
            $this->warna->LinkCustomAttributes = "";
            $this->warna->HrefValue = "";
            $this->warna->TooltipValue = "";

            // parfum
            $this->parfum->LinkCustomAttributes = "";
            $this->parfum->HrefValue = "";
            $this->parfum->TooltipValue = "";

            // tambahan
            $this->tambahan->LinkCustomAttributes = "";
            $this->tambahan->HrefValue = "";
            $this->tambahan->TooltipValue = "";

            // kemasanbarang
            $this->kemasanbarang->LinkCustomAttributes = "";
            $this->kemasanbarang->HrefValue = "";
            $this->kemasanbarang->TooltipValue = "";

            // label
            $this->label->LinkCustomAttributes = "";
            $this->label->HrefValue = "";
            $this->label->TooltipValue = "";

            // orderperdana
            $this->orderperdana->LinkCustomAttributes = "";
            $this->orderperdana->HrefValue = "";
            $this->orderperdana->TooltipValue = "";

            // orderreguler
            $this->orderreguler->LinkCustomAttributes = "";
            $this->orderreguler->HrefValue = "";
            $this->orderreguler->TooltipValue = "";

            // tanggal_order
            $this->tanggal_order->LinkCustomAttributes = "";
            $this->tanggal_order->HrefValue = "";
            $this->tanggal_order->TooltipValue = "";

            // target_selesai
            $this->target_selesai->LinkCustomAttributes = "";
            $this->target_selesai->HrefValue = "";
            $this->target_selesai->TooltipValue = "";

            // kategori
            $this->kategori->LinkCustomAttributes = "";
            $this->kategori->HrefValue = "";
            $this->kategori->TooltipValue = "";

            // fungsi_produk
            $this->fungsi_produk->LinkCustomAttributes = "";
            $this->fungsi_produk->HrefValue = "";
            $this->fungsi_produk->TooltipValue = "";

            // kualitasbarang
            $this->kualitasbarang->LinkCustomAttributes = "";
            $this->kualitasbarang->HrefValue = "";
            $this->kualitasbarang->TooltipValue = "";

            // bahan_campaign
            $this->bahan_campaign->LinkCustomAttributes = "";
            $this->bahan_campaign->HrefValue = "";
            $this->bahan_campaign->TooltipValue = "";

            // ukuran_sediaan
            $this->ukuran_sediaan->LinkCustomAttributes = "";
            $this->ukuran_sediaan->HrefValue = "";
            $this->ukuran_sediaan->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // status
            $this->status->EditAttrs["class"] = "form-control";
            $this->status->EditCustomAttributes = "";
            if (!$this->status->Raw) {
                $this->status->CurrentValue = HtmlDecode($this->status->CurrentValue);
            }
            $this->status->EditValue = HtmlEncode($this->status->CurrentValue);
            $this->status->PlaceHolder = RemoveHtml($this->status->caption());

            // idpegawai
            $this->idpegawai->EditAttrs["class"] = "form-control";
            $this->idpegawai->EditCustomAttributes = "";
            $curVal = trim(strval($this->idpegawai->CurrentValue));
            if ($curVal != "") {
                $this->idpegawai->EditValue = $this->idpegawai->lookupCacheOption($curVal);
                if ($this->idpegawai->EditValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->idpegawai->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idpegawai->Lookup->renderViewRow($rswrk[0]);
                        $this->idpegawai->EditValue = $this->idpegawai->displayValue($arwrk);
                    } else {
                        $this->idpegawai->EditValue = $this->idpegawai->CurrentValue;
                    }
                }
            } else {
                $this->idpegawai->EditValue = null;
            }
            $this->idpegawai->ViewCustomAttributes = "";

            // idcustomer
            $this->idcustomer->EditAttrs["class"] = "form-control";
            $this->idcustomer->EditCustomAttributes = "";
            $this->idcustomer->EditValue = $this->idcustomer->CurrentValue;
            $curVal = trim(strval($this->idcustomer->CurrentValue));
            if ($curVal != "") {
                $this->idcustomer->EditValue = $this->idcustomer->lookupCacheOption($curVal);
                if ($this->idcustomer->EditValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->idcustomer->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idcustomer->Lookup->renderViewRow($rswrk[0]);
                        $this->idcustomer->EditValue = $this->idcustomer->displayValue($arwrk);
                    } else {
                        $this->idcustomer->EditValue = $this->idcustomer->CurrentValue;
                    }
                }
            } else {
                $this->idcustomer->EditValue = null;
            }
            $this->idcustomer->ViewCustomAttributes = "";

            // kodeorder
            $this->kodeorder->EditAttrs["class"] = "form-control";
            $this->kodeorder->EditCustomAttributes = "";
            $this->kodeorder->EditValue = $this->kodeorder->CurrentValue;
            $this->kodeorder->ViewCustomAttributes = "";

            // idproduct_acuan
            $this->idproduct_acuan->EditAttrs["class"] = "form-control";
            $this->idproduct_acuan->EditCustomAttributes = "";
            $curVal = trim(strval($this->idproduct_acuan->CurrentValue));
            if ($curVal != "") {
                $this->idproduct_acuan->ViewValue = $this->idproduct_acuan->lookupCacheOption($curVal);
            } else {
                $this->idproduct_acuan->ViewValue = $this->idproduct_acuan->Lookup !== null && is_array($this->idproduct_acuan->Lookup->Options) ? $curVal : null;
            }
            if ($this->idproduct_acuan->ViewValue !== null) { // Load from cache
                $this->idproduct_acuan->EditValue = array_values($this->idproduct_acuan->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idproduct_acuan->CurrentValue, DATATYPE_NUMBER, "");
                }
                $lookupFilter = function() {
                    return (CurrentPageID() == "add" || CurrentPageID() == "edit") ? "idbrand = 1" : "";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->idproduct_acuan->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idproduct_acuan->EditValue = $arwrk;
            }
            $this->idproduct_acuan->PlaceHolder = RemoveHtml($this->idproduct_acuan->caption());

            // nama
            $this->nama->EditAttrs["class"] = "form-control";
            $this->nama->EditCustomAttributes = "";
            if (!$this->nama->Raw) {
                $this->nama->CurrentValue = HtmlDecode($this->nama->CurrentValue);
            }
            $this->nama->EditValue = HtmlEncode($this->nama->CurrentValue);
            $this->nama->PlaceHolder = RemoveHtml($this->nama->caption());

            // idjenisbarang
            $this->idjenisbarang->EditAttrs["class"] = "form-control";
            $this->idjenisbarang->EditCustomAttributes = "";
            $curVal = trim(strval($this->idjenisbarang->CurrentValue));
            if ($curVal != "") {
                $this->idjenisbarang->ViewValue = $this->idjenisbarang->lookupCacheOption($curVal);
            } else {
                $this->idjenisbarang->ViewValue = $this->idjenisbarang->Lookup !== null && is_array($this->idjenisbarang->Lookup->Options) ? $curVal : null;
            }
            if ($this->idjenisbarang->ViewValue !== null) { // Load from cache
                $this->idjenisbarang->EditValue = array_values($this->idjenisbarang->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idjenisbarang->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->idjenisbarang->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idjenisbarang->EditValue = $arwrk;
            }
            $this->idjenisbarang->PlaceHolder = RemoveHtml($this->idjenisbarang->caption());

            // idkategoribarang
            $this->idkategoribarang->EditAttrs["class"] = "form-control";
            $this->idkategoribarang->EditCustomAttributes = "";
            $curVal = trim(strval($this->idkategoribarang->CurrentValue));
            if ($curVal != "") {
                $this->idkategoribarang->ViewValue = $this->idkategoribarang->lookupCacheOption($curVal);
            } else {
                $this->idkategoribarang->ViewValue = $this->idkategoribarang->Lookup !== null && is_array($this->idkategoribarang->Lookup->Options) ? $curVal : null;
            }
            if ($this->idkategoribarang->ViewValue !== null) { // Load from cache
                $this->idkategoribarang->EditValue = array_values($this->idkategoribarang->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idkategoribarang->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->idkategoribarang->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idkategoribarang->EditValue = $arwrk;
            }
            $this->idkategoribarang->PlaceHolder = RemoveHtml($this->idkategoribarang->caption());

            // warna
            $this->warna->EditAttrs["class"] = "form-control";
            $this->warna->EditCustomAttributes = "";
            if (!$this->warna->Raw) {
                $this->warna->CurrentValue = HtmlDecode($this->warna->CurrentValue);
            }
            $this->warna->EditValue = HtmlEncode($this->warna->CurrentValue);
            $this->warna->PlaceHolder = RemoveHtml($this->warna->caption());

            // parfum
            $this->parfum->EditAttrs["class"] = "form-control";
            $this->parfum->EditCustomAttributes = "";
            if (!$this->parfum->Raw) {
                $this->parfum->CurrentValue = HtmlDecode($this->parfum->CurrentValue);
            }
            $this->parfum->EditValue = HtmlEncode($this->parfum->CurrentValue);
            $this->parfum->PlaceHolder = RemoveHtml($this->parfum->caption());

            // tambahan
            $this->tambahan->EditAttrs["class"] = "form-control";
            $this->tambahan->EditCustomAttributes = "";
            $this->tambahan->EditValue = HtmlEncode($this->tambahan->CurrentValue);
            $this->tambahan->PlaceHolder = RemoveHtml($this->tambahan->caption());

            // kemasanbarang
            $this->kemasanbarang->EditAttrs["class"] = "form-control";
            $this->kemasanbarang->EditCustomAttributes = "";
            $this->kemasanbarang->EditValue = HtmlEncode($this->kemasanbarang->CurrentValue);
            $this->kemasanbarang->PlaceHolder = RemoveHtml($this->kemasanbarang->caption());

            // label
            $this->label->EditAttrs["class"] = "form-control";
            $this->label->EditCustomAttributes = "";
            $this->label->EditValue = HtmlEncode($this->label->CurrentValue);
            $this->label->PlaceHolder = RemoveHtml($this->label->caption());

            // orderperdana
            $this->orderperdana->EditAttrs["class"] = "form-control";
            $this->orderperdana->EditCustomAttributes = "";
            $this->orderperdana->EditValue = HtmlEncode($this->orderperdana->CurrentValue);
            $this->orderperdana->PlaceHolder = RemoveHtml($this->orderperdana->caption());

            // orderreguler
            $this->orderreguler->EditAttrs["class"] = "form-control";
            $this->orderreguler->EditCustomAttributes = "";
            $this->orderreguler->EditValue = HtmlEncode($this->orderreguler->CurrentValue);
            $this->orderreguler->PlaceHolder = RemoveHtml($this->orderreguler->caption());

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

            // kategori
            $this->kategori->EditAttrs["class"] = "form-control";
            $this->kategori->EditCustomAttributes = "";
            if (!$this->kategori->Raw) {
                $this->kategori->CurrentValue = HtmlDecode($this->kategori->CurrentValue);
            }
            $this->kategori->EditValue = HtmlEncode($this->kategori->CurrentValue);
            $this->kategori->PlaceHolder = RemoveHtml($this->kategori->caption());

            // fungsi_produk
            $this->fungsi_produk->EditAttrs["class"] = "form-control";
            $this->fungsi_produk->EditCustomAttributes = "";
            if (!$this->fungsi_produk->Raw) {
                $this->fungsi_produk->CurrentValue = HtmlDecode($this->fungsi_produk->CurrentValue);
            }
            $this->fungsi_produk->EditValue = HtmlEncode($this->fungsi_produk->CurrentValue);
            $this->fungsi_produk->PlaceHolder = RemoveHtml($this->fungsi_produk->caption());

            // kualitasbarang
            $this->kualitasbarang->EditAttrs["class"] = "form-control";
            $this->kualitasbarang->EditCustomAttributes = "";
            if (!$this->kualitasbarang->Raw) {
                $this->kualitasbarang->CurrentValue = HtmlDecode($this->kualitasbarang->CurrentValue);
            }
            $this->kualitasbarang->EditValue = HtmlEncode($this->kualitasbarang->CurrentValue);
            $this->kualitasbarang->PlaceHolder = RemoveHtml($this->kualitasbarang->caption());

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

            // Edit refer script

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";

            // idpegawai
            $this->idpegawai->LinkCustomAttributes = "";
            $this->idpegawai->HrefValue = "";
            $this->idpegawai->TooltipValue = "";

            // idcustomer
            $this->idcustomer->LinkCustomAttributes = "";
            $this->idcustomer->HrefValue = "";
            $this->idcustomer->TooltipValue = "";

            // kodeorder
            $this->kodeorder->LinkCustomAttributes = "";
            $this->kodeorder->HrefValue = "";
            $this->kodeorder->TooltipValue = "";

            // idproduct_acuan
            $this->idproduct_acuan->LinkCustomAttributes = "";
            $this->idproduct_acuan->HrefValue = "";

            // nama
            $this->nama->LinkCustomAttributes = "";
            $this->nama->HrefValue = "";

            // idjenisbarang
            $this->idjenisbarang->LinkCustomAttributes = "";
            $this->idjenisbarang->HrefValue = "";

            // idkategoribarang
            $this->idkategoribarang->LinkCustomAttributes = "";
            $this->idkategoribarang->HrefValue = "";

            // warna
            $this->warna->LinkCustomAttributes = "";
            $this->warna->HrefValue = "";

            // parfum
            $this->parfum->LinkCustomAttributes = "";
            $this->parfum->HrefValue = "";

            // tambahan
            $this->tambahan->LinkCustomAttributes = "";
            $this->tambahan->HrefValue = "";

            // kemasanbarang
            $this->kemasanbarang->LinkCustomAttributes = "";
            $this->kemasanbarang->HrefValue = "";

            // label
            $this->label->LinkCustomAttributes = "";
            $this->label->HrefValue = "";

            // orderperdana
            $this->orderperdana->LinkCustomAttributes = "";
            $this->orderperdana->HrefValue = "";

            // orderreguler
            $this->orderreguler->LinkCustomAttributes = "";
            $this->orderreguler->HrefValue = "";

            // tanggal_order
            $this->tanggal_order->LinkCustomAttributes = "";
            $this->tanggal_order->HrefValue = "";

            // target_selesai
            $this->target_selesai->LinkCustomAttributes = "";
            $this->target_selesai->HrefValue = "";

            // kategori
            $this->kategori->LinkCustomAttributes = "";
            $this->kategori->HrefValue = "";

            // fungsi_produk
            $this->fungsi_produk->LinkCustomAttributes = "";
            $this->fungsi_produk->HrefValue = "";

            // kualitasbarang
            $this->kualitasbarang->LinkCustomAttributes = "";
            $this->kualitasbarang->HrefValue = "";

            // bahan_campaign
            $this->bahan_campaign->LinkCustomAttributes = "";
            $this->bahan_campaign->HrefValue = "";

            // ukuran_sediaan
            $this->ukuran_sediaan->LinkCustomAttributes = "";
            $this->ukuran_sediaan->HrefValue = "";
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
        if ($this->status->Required) {
            if (!$this->status->IsDetailKey && EmptyValue($this->status->FormValue)) {
                $this->status->addErrorMessage(str_replace("%s", $this->status->caption(), $this->status->RequiredErrorMessage));
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
        if ($this->kodeorder->Required) {
            if (!$this->kodeorder->IsDetailKey && EmptyValue($this->kodeorder->FormValue)) {
                $this->kodeorder->addErrorMessage(str_replace("%s", $this->kodeorder->caption(), $this->kodeorder->RequiredErrorMessage));
            }
        }
        if ($this->idproduct_acuan->Required) {
            if (!$this->idproduct_acuan->IsDetailKey && EmptyValue($this->idproduct_acuan->FormValue)) {
                $this->idproduct_acuan->addErrorMessage(str_replace("%s", $this->idproduct_acuan->caption(), $this->idproduct_acuan->RequiredErrorMessage));
            }
        }
        if ($this->nama->Required) {
            if (!$this->nama->IsDetailKey && EmptyValue($this->nama->FormValue)) {
                $this->nama->addErrorMessage(str_replace("%s", $this->nama->caption(), $this->nama->RequiredErrorMessage));
            }
        }
        if ($this->idjenisbarang->Required) {
            if (!$this->idjenisbarang->IsDetailKey && EmptyValue($this->idjenisbarang->FormValue)) {
                $this->idjenisbarang->addErrorMessage(str_replace("%s", $this->idjenisbarang->caption(), $this->idjenisbarang->RequiredErrorMessage));
            }
        }
        if ($this->idkategoribarang->Required) {
            if (!$this->idkategoribarang->IsDetailKey && EmptyValue($this->idkategoribarang->FormValue)) {
                $this->idkategoribarang->addErrorMessage(str_replace("%s", $this->idkategoribarang->caption(), $this->idkategoribarang->RequiredErrorMessage));
            }
        }
        if ($this->warna->Required) {
            if (!$this->warna->IsDetailKey && EmptyValue($this->warna->FormValue)) {
                $this->warna->addErrorMessage(str_replace("%s", $this->warna->caption(), $this->warna->RequiredErrorMessage));
            }
        }
        if ($this->parfum->Required) {
            if (!$this->parfum->IsDetailKey && EmptyValue($this->parfum->FormValue)) {
                $this->parfum->addErrorMessage(str_replace("%s", $this->parfum->caption(), $this->parfum->RequiredErrorMessage));
            }
        }
        if ($this->tambahan->Required) {
            if (!$this->tambahan->IsDetailKey && EmptyValue($this->tambahan->FormValue)) {
                $this->tambahan->addErrorMessage(str_replace("%s", $this->tambahan->caption(), $this->tambahan->RequiredErrorMessage));
            }
        }
        if ($this->kemasanbarang->Required) {
            if (!$this->kemasanbarang->IsDetailKey && EmptyValue($this->kemasanbarang->FormValue)) {
                $this->kemasanbarang->addErrorMessage(str_replace("%s", $this->kemasanbarang->caption(), $this->kemasanbarang->RequiredErrorMessage));
            }
        }
        if ($this->label->Required) {
            if (!$this->label->IsDetailKey && EmptyValue($this->label->FormValue)) {
                $this->label->addErrorMessage(str_replace("%s", $this->label->caption(), $this->label->RequiredErrorMessage));
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
        if ($this->orderreguler->Required) {
            if (!$this->orderreguler->IsDetailKey && EmptyValue($this->orderreguler->FormValue)) {
                $this->orderreguler->addErrorMessage(str_replace("%s", $this->orderreguler->caption(), $this->orderreguler->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->orderreguler->FormValue)) {
            $this->orderreguler->addErrorMessage($this->orderreguler->getErrorMessage(false));
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
        if ($this->kategori->Required) {
            if (!$this->kategori->IsDetailKey && EmptyValue($this->kategori->FormValue)) {
                $this->kategori->addErrorMessage(str_replace("%s", $this->kategori->caption(), $this->kategori->RequiredErrorMessage));
            }
        }
        if ($this->fungsi_produk->Required) {
            if (!$this->fungsi_produk->IsDetailKey && EmptyValue($this->fungsi_produk->FormValue)) {
                $this->fungsi_produk->addErrorMessage(str_replace("%s", $this->fungsi_produk->caption(), $this->fungsi_produk->RequiredErrorMessage));
            }
        }
        if ($this->kualitasbarang->Required) {
            if (!$this->kualitasbarang->IsDetailKey && EmptyValue($this->kualitasbarang->FormValue)) {
                $this->kualitasbarang->addErrorMessage(str_replace("%s", $this->kualitasbarang->caption(), $this->kualitasbarang->RequiredErrorMessage));
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

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("NpdSampleGrid");
        if (in_array("npd_sample", $detailTblVar) && $detailPage->DetailEdit) {
            $detailPage->validateGridForm();
        }
        $detailPage = Container("NpdReviewGrid");
        if (in_array("npd_review", $detailTblVar) && $detailPage->DetailEdit) {
            $detailPage->validateGridForm();
        }
        $detailPage = Container("NpdConfirmGrid");
        if (in_array("npd_confirm", $detailTblVar) && $detailPage->DetailEdit) {
            $detailPage->validateGridForm();
        }
        $detailPage = Container("NpdHargaGrid");
        if (in_array("npd_harga", $detailTblVar) && $detailPage->DetailEdit) {
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

    // Update record based on key values
    protected function editRow()
    {
        global $Security, $Language;
        $oldKeyFilter = $this->getRecordFilter();
        $filter = $this->applyUserIDFilters($oldKeyFilter);
        $conn = $this->getConnection();
        if ($this->kodeorder->CurrentValue != "") { // Check field with unique index
            $filterChk = "(`kodeorder` = '" . AdjustSql($this->kodeorder->CurrentValue, $this->Dbid) . "')";
            $filterChk .= " AND NOT (" . $filter . ")";
            $this->CurrentFilter = $filterChk;
            $sqlChk = $this->getCurrentSql();
            $rsChk = $conn->executeQuery($sqlChk);
            if (!$rsChk) {
                return false;
            }
            if ($rsChk->fetch()) {
                $idxErrMsg = str_replace("%f", $this->kodeorder->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->kodeorder->CurrentValue, $idxErrMsg);
                $this->setFailureMessage($idxErrMsg);
                $rsChk->closeCursor();
                return false;
            }
        }
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $rsold = $conn->fetchAssoc($sql);
        $editRow = false;
        if (!$rsold) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
            $editRow = false; // Update Failed
        } else {
            // Begin transaction
            if ($this->getCurrentDetailTable() != "") {
                $conn->beginTransaction();
            }

            // Save old values
            $this->loadDbValues($rsold);
            $rsnew = [];

            // status
            $this->status->setDbValueDef($rsnew, $this->status->CurrentValue, "", $this->status->ReadOnly);

            // idproduct_acuan
            $this->idproduct_acuan->setDbValueDef($rsnew, $this->idproduct_acuan->CurrentValue, 0, $this->idproduct_acuan->ReadOnly);

            // nama
            $this->nama->setDbValueDef($rsnew, $this->nama->CurrentValue, "", $this->nama->ReadOnly);

            // idjenisbarang
            $this->idjenisbarang->setDbValueDef($rsnew, $this->idjenisbarang->CurrentValue, 0, $this->idjenisbarang->ReadOnly);

            // idkategoribarang
            $this->idkategoribarang->setDbValueDef($rsnew, $this->idkategoribarang->CurrentValue, 0, $this->idkategoribarang->ReadOnly);

            // warna
            $this->warna->setDbValueDef($rsnew, $this->warna->CurrentValue, "", $this->warna->ReadOnly);

            // parfum
            $this->parfum->setDbValueDef($rsnew, $this->parfum->CurrentValue, "", $this->parfum->ReadOnly);

            // tambahan
            $this->tambahan->setDbValueDef($rsnew, $this->tambahan->CurrentValue, null, $this->tambahan->ReadOnly);

            // kemasanbarang
            $this->kemasanbarang->setDbValueDef($rsnew, $this->kemasanbarang->CurrentValue, "", $this->kemasanbarang->ReadOnly);

            // label
            $this->label->setDbValueDef($rsnew, $this->label->CurrentValue, "", $this->label->ReadOnly);

            // orderperdana
            $this->orderperdana->setDbValueDef($rsnew, $this->orderperdana->CurrentValue, null, $this->orderperdana->ReadOnly);

            // orderreguler
            $this->orderreguler->setDbValueDef($rsnew, $this->orderreguler->CurrentValue, null, $this->orderreguler->ReadOnly);

            // tanggal_order
            $this->tanggal_order->setDbValueDef($rsnew, UnFormatDateTime($this->tanggal_order->CurrentValue, 0), null, $this->tanggal_order->ReadOnly);

            // target_selesai
            $this->target_selesai->setDbValueDef($rsnew, UnFormatDateTime($this->target_selesai->CurrentValue, 0), null, $this->target_selesai->ReadOnly);

            // kategori
            $this->kategori->setDbValueDef($rsnew, $this->kategori->CurrentValue, "", $this->kategori->ReadOnly);

            // fungsi_produk
            $this->fungsi_produk->setDbValueDef($rsnew, $this->fungsi_produk->CurrentValue, "", $this->fungsi_produk->ReadOnly);

            // kualitasbarang
            $this->kualitasbarang->setDbValueDef($rsnew, $this->kualitasbarang->CurrentValue, "", $this->kualitasbarang->ReadOnly);

            // bahan_campaign
            $this->bahan_campaign->setDbValueDef($rsnew, $this->bahan_campaign->CurrentValue, "", $this->bahan_campaign->ReadOnly);

            // ukuran_sediaan
            $this->ukuran_sediaan->setDbValueDef($rsnew, $this->ukuran_sediaan->CurrentValue, "", $this->ukuran_sediaan->ReadOnly);

            // Call Row Updating event
            $updateRow = $this->rowUpdating($rsold, $rsnew);
            if ($updateRow) {
                if (count($rsnew) > 0) {
                    try {
                        $editRow = $this->update($rsnew, "", $rsold);
                    } catch (\Exception $e) {
                        $this->setFailureMessage($e->getMessage());
                    }
                } else {
                    $editRow = true; // No field to update
                }
                if ($editRow) {
                }

                // Update detail records
                $detailTblVar = explode(",", $this->getCurrentDetailTable());
                if ($editRow) {
                    $detailPage = Container("NpdSampleGrid");
                    if (in_array("npd_sample", $detailTblVar) && $detailPage->DetailEdit) {
                        $Security->loadCurrentUserLevel($this->ProjectID . "npd_sample"); // Load user level of detail table
                        $editRow = $detailPage->gridUpdate();
                        $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                    }
                }
                if ($editRow) {
                    $detailPage = Container("NpdReviewGrid");
                    if (in_array("npd_review", $detailTblVar) && $detailPage->DetailEdit) {
                        $Security->loadCurrentUserLevel($this->ProjectID . "npd_review"); // Load user level of detail table
                        $editRow = $detailPage->gridUpdate();
                        $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                    }
                }
                if ($editRow) {
                    $detailPage = Container("NpdConfirmGrid");
                    if (in_array("npd_confirm", $detailTblVar) && $detailPage->DetailEdit) {
                        $Security->loadCurrentUserLevel($this->ProjectID . "npd_confirm"); // Load user level of detail table
                        $editRow = $detailPage->gridUpdate();
                        $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                    }
                }
                if ($editRow) {
                    $detailPage = Container("NpdHargaGrid");
                    if (in_array("npd_harga", $detailTblVar) && $detailPage->DetailEdit) {
                        $Security->loadCurrentUserLevel($this->ProjectID . "npd_harga"); // Load user level of detail table
                        $editRow = $detailPage->gridUpdate();
                        $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                    }
                }

                // Commit/Rollback transaction
                if ($this->getCurrentDetailTable() != "") {
                    if ($editRow) {
                        $conn->commit(); // Commit transaction
                    } else {
                        $conn->rollback(); // Rollback transaction
                    }
                }
            } else {
                if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                    // Use the message, do nothing
                } elseif ($this->CancelMessage != "") {
                    $this->setFailureMessage($this->CancelMessage);
                    $this->CancelMessage = "";
                } else {
                    $this->setFailureMessage($Language->phrase("UpdateCancelled"));
                }
                $editRow = false;
            }
        }

        // Call Row_Updated event
        if ($editRow) {
            $this->rowUpdated($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($editRow) {
        }

        // Write JSON for API request
        if (IsApi() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $editRow;
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
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

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
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

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
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

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
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

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
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
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
                case "x_idjenisbarang":
                    break;
                case "x_idkategoribarang":
                    break;
                case "x_selesai":
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

    // Set up starting record parameters
    public function setupStartRecord()
    {
        if ($this->DisplayRecords == 0) {
            return;
        }
        if ($this->isPageRequest()) { // Validate request
            $startRec = Get(Config("TABLE_START_REC"));
            $pageNo = Get(Config("TABLE_PAGE_NO"));
            if ($pageNo !== null) { // Check for "pageno" parameter first
                if (is_numeric($pageNo)) {
                    $this->StartRecord = ($pageNo - 1) * $this->DisplayRecords + 1;
                    if ($this->StartRecord <= 0) {
                        $this->StartRecord = 1;
                    } elseif ($this->StartRecord >= (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1) {
                        $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1;
                    }
                    $this->setStartRecordNumber($this->StartRecord);
                }
            } elseif ($startRec !== null) { // Check for "start" parameter
                $this->StartRecord = $startRec;
                $this->setStartRecordNumber($this->StartRecord);
            }
        }
        $this->StartRecord = $this->getStartRecordNumber();

        // Check if correct start record counter
        if (!is_numeric($this->StartRecord) || $this->StartRecord == "") { // Avoid invalid start record counter
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->StartRecord > $this->TotalRecords) { // Avoid starting record > total records
            $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to last page first record
            $this->setStartRecordNumber($this->StartRecord);
        } elseif (($this->StartRecord - 1) % $this->DisplayRecords != 0) {
            $this->StartRecord = (int)(($this->StartRecord - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to page boundary
            $this->setStartRecordNumber($this->StartRecord);
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
        $this->warna->CustomMsg = "Gelap / Terang / Transparan / Opaq / Lainnya";
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
