<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class CustomerEdit extends Customer
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'customer';

    // Page object name
    public $PageObjName = "CustomerEdit";

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
        $this->kode->Visible = false;
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
        $this->budget_bonus_persen->setVisibility();
        $this->hutang_max->setVisibility();
        $this->keterangan->setVisibility();
        $this->aktif->setVisibility();
        $this->created_at->Visible = false;
        $this->updated_at->Visible = false;
        $this->created_by->Visible = false;
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
        $this->setupLookupOptions($this->idtipecustomer);
        $this->setupLookupOptions($this->idpegawai);
        $this->setupLookupOptions($this->idprov);
        $this->setupLookupOptions($this->idkab);
        $this->setupLookupOptions($this->idkec);
        $this->setupLookupOptions($this->idkel);

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

            // Set up master detail parameters
            $this->setupMasterParms();

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
                    $this->terminate("CustomerList"); // No matching record, return to list
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
                if (GetPageName($returnUrl) == "CustomerList") {
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
        $this->ktp->Upload->Index = $CurrentForm->Index;
        $this->ktp->Upload->uploadFile();
        $this->ktp->CurrentValue = $this->ktp->Upload->FileName;
        $this->npwp->Upload->Index = $CurrentForm->Index;
        $this->npwp->Upload->uploadFile();
        $this->npwp->CurrentValue = $this->npwp->Upload->FileName;
        $this->foto->Upload->Index = $CurrentForm->Index;
        $this->foto->Upload->uploadFile();
        $this->foto->CurrentValue = $this->foto->Upload->FileName;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'idtipecustomer' first before field var 'x_idtipecustomer'
        $val = $CurrentForm->hasValue("idtipecustomer") ? $CurrentForm->getValue("idtipecustomer") : $CurrentForm->getValue("x_idtipecustomer");
        if (!$this->idtipecustomer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idtipecustomer->Visible = false; // Disable update for API request
            } else {
                $this->idtipecustomer->setFormValue($val);
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

        // Check field name 'nama' first before field var 'x_nama'
        $val = $CurrentForm->hasValue("nama") ? $CurrentForm->getValue("nama") : $CurrentForm->getValue("x_nama");
        if (!$this->nama->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nama->Visible = false; // Disable update for API request
            } else {
                $this->nama->setFormValue($val);
            }
        }

        // Check field name 'kodenpd' first before field var 'x_kodenpd'
        $val = $CurrentForm->hasValue("kodenpd") ? $CurrentForm->getValue("kodenpd") : $CurrentForm->getValue("x_kodenpd");
        if (!$this->kodenpd->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kodenpd->Visible = false; // Disable update for API request
            } else {
                $this->kodenpd->setFormValue($val);
            }
        }

        // Check field name 'usaha' first before field var 'x_usaha'
        $val = $CurrentForm->hasValue("usaha") ? $CurrentForm->getValue("usaha") : $CurrentForm->getValue("x_usaha");
        if (!$this->usaha->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->usaha->Visible = false; // Disable update for API request
            } else {
                $this->usaha->setFormValue($val);
            }
        }

        // Check field name 'jabatan' first before field var 'x_jabatan'
        $val = $CurrentForm->hasValue("jabatan") ? $CurrentForm->getValue("jabatan") : $CurrentForm->getValue("x_jabatan");
        if (!$this->jabatan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jabatan->Visible = false; // Disable update for API request
            } else {
                $this->jabatan->setFormValue($val);
            }
        }

        // Check field name 'idprov' first before field var 'x_idprov'
        $val = $CurrentForm->hasValue("idprov") ? $CurrentForm->getValue("idprov") : $CurrentForm->getValue("x_idprov");
        if (!$this->idprov->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idprov->Visible = false; // Disable update for API request
            } else {
                $this->idprov->setFormValue($val);
            }
        }

        // Check field name 'idkab' first before field var 'x_idkab'
        $val = $CurrentForm->hasValue("idkab") ? $CurrentForm->getValue("idkab") : $CurrentForm->getValue("x_idkab");
        if (!$this->idkab->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idkab->Visible = false; // Disable update for API request
            } else {
                $this->idkab->setFormValue($val);
            }
        }

        // Check field name 'idkec' first before field var 'x_idkec'
        $val = $CurrentForm->hasValue("idkec") ? $CurrentForm->getValue("idkec") : $CurrentForm->getValue("x_idkec");
        if (!$this->idkec->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idkec->Visible = false; // Disable update for API request
            } else {
                $this->idkec->setFormValue($val);
            }
        }

        // Check field name 'idkel' first before field var 'x_idkel'
        $val = $CurrentForm->hasValue("idkel") ? $CurrentForm->getValue("idkel") : $CurrentForm->getValue("x_idkel");
        if (!$this->idkel->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idkel->Visible = false; // Disable update for API request
            } else {
                $this->idkel->setFormValue($val);
            }
        }

        // Check field name 'kodepos' first before field var 'x_kodepos'
        $val = $CurrentForm->hasValue("kodepos") ? $CurrentForm->getValue("kodepos") : $CurrentForm->getValue("x_kodepos");
        if (!$this->kodepos->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kodepos->Visible = false; // Disable update for API request
            } else {
                $this->kodepos->setFormValue($val);
            }
        }

        // Check field name 'alamat' first before field var 'x_alamat'
        $val = $CurrentForm->hasValue("alamat") ? $CurrentForm->getValue("alamat") : $CurrentForm->getValue("x_alamat");
        if (!$this->alamat->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->alamat->Visible = false; // Disable update for API request
            } else {
                $this->alamat->setFormValue($val);
            }
        }

        // Check field name 'telpon' first before field var 'x_telpon'
        $val = $CurrentForm->hasValue("telpon") ? $CurrentForm->getValue("telpon") : $CurrentForm->getValue("x_telpon");
        if (!$this->telpon->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->telpon->Visible = false; // Disable update for API request
            } else {
                $this->telpon->setFormValue($val);
            }
        }

        // Check field name 'hp' first before field var 'x_hp'
        $val = $CurrentForm->hasValue("hp") ? $CurrentForm->getValue("hp") : $CurrentForm->getValue("x_hp");
        if (!$this->hp->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hp->Visible = false; // Disable update for API request
            } else {
                $this->hp->setFormValue($val);
            }
        }

        // Check field name 'email' first before field var 'x__email'
        $val = $CurrentForm->hasValue("email") ? $CurrentForm->getValue("email") : $CurrentForm->getValue("x__email");
        if (!$this->_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_email->Visible = false; // Disable update for API request
            } else {
                $this->_email->setFormValue($val);
            }
        }

        // Check field name 'website' first before field var 'x_website'
        $val = $CurrentForm->hasValue("website") ? $CurrentForm->getValue("website") : $CurrentForm->getValue("x_website");
        if (!$this->website->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->website->Visible = false; // Disable update for API request
            } else {
                $this->website->setFormValue($val);
            }
        }

        // Check field name 'budget_bonus_persen' first before field var 'x_budget_bonus_persen'
        $val = $CurrentForm->hasValue("budget_bonus_persen") ? $CurrentForm->getValue("budget_bonus_persen") : $CurrentForm->getValue("x_budget_bonus_persen");
        if (!$this->budget_bonus_persen->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->budget_bonus_persen->Visible = false; // Disable update for API request
            } else {
                $this->budget_bonus_persen->setFormValue($val);
            }
        }

        // Check field name 'hutang_max' first before field var 'x_hutang_max'
        $val = $CurrentForm->hasValue("hutang_max") ? $CurrentForm->getValue("hutang_max") : $CurrentForm->getValue("x_hutang_max");
        if (!$this->hutang_max->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hutang_max->Visible = false; // Disable update for API request
            } else {
                $this->hutang_max->setFormValue($val);
            }
        }

        // Check field name 'keterangan' first before field var 'x_keterangan'
        $val = $CurrentForm->hasValue("keterangan") ? $CurrentForm->getValue("keterangan") : $CurrentForm->getValue("x_keterangan");
        if (!$this->keterangan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->keterangan->Visible = false; // Disable update for API request
            } else {
                $this->keterangan->setFormValue($val);
            }
        }

        // Check field name 'aktif' first before field var 'x_aktif'
        $val = $CurrentForm->hasValue("aktif") ? $CurrentForm->getValue("aktif") : $CurrentForm->getValue("x_aktif");
        if (!$this->aktif->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->aktif->Visible = false; // Disable update for API request
            } else {
                $this->aktif->setFormValue($val);
            }
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        if (!$this->id->IsDetailKey) {
            $this->id->setFormValue($val);
        }
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id->CurrentValue = $this->id->FormValue;
        $this->idtipecustomer->CurrentValue = $this->idtipecustomer->FormValue;
        $this->idpegawai->CurrentValue = $this->idpegawai->FormValue;
        $this->nama->CurrentValue = $this->nama->FormValue;
        $this->kodenpd->CurrentValue = $this->kodenpd->FormValue;
        $this->usaha->CurrentValue = $this->usaha->FormValue;
        $this->jabatan->CurrentValue = $this->jabatan->FormValue;
        $this->idprov->CurrentValue = $this->idprov->FormValue;
        $this->idkab->CurrentValue = $this->idkab->FormValue;
        $this->idkec->CurrentValue = $this->idkec->FormValue;
        $this->idkel->CurrentValue = $this->idkel->FormValue;
        $this->kodepos->CurrentValue = $this->kodepos->FormValue;
        $this->alamat->CurrentValue = $this->alamat->FormValue;
        $this->telpon->CurrentValue = $this->telpon->FormValue;
        $this->hp->CurrentValue = $this->hp->FormValue;
        $this->_email->CurrentValue = $this->_email->FormValue;
        $this->website->CurrentValue = $this->website->FormValue;
        $this->budget_bonus_persen->CurrentValue = $this->budget_bonus_persen->FormValue;
        $this->hutang_max->CurrentValue = $this->hutang_max->FormValue;
        $this->keterangan->CurrentValue = $this->keterangan->FormValue;
        $this->aktif->CurrentValue = $this->aktif->FormValue;
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
        $this->kode->setDbValue($row['kode']);
        $this->idtipecustomer->setDbValue($row['idtipecustomer']);
        $this->idpegawai->setDbValue($row['idpegawai']);
        $this->nama->setDbValue($row['nama']);
        $this->kodenpd->setDbValue($row['kodenpd']);
        $this->usaha->setDbValue($row['usaha']);
        $this->jabatan->setDbValue($row['jabatan']);
        $this->ktp->Upload->DbValue = $row['ktp'];
        if (is_resource($this->ktp->Upload->DbValue) && get_resource_type($this->ktp->Upload->DbValue) == "stream") { // Byte array
            $this->ktp->Upload->DbValue = stream_get_contents($this->ktp->Upload->DbValue);
        }
        $this->npwp->Upload->DbValue = $row['npwp'];
        if (is_resource($this->npwp->Upload->DbValue) && get_resource_type($this->npwp->Upload->DbValue) == "stream") { // Byte array
            $this->npwp->Upload->DbValue = stream_get_contents($this->npwp->Upload->DbValue);
        }
        $this->idprov->setDbValue($row['idprov']);
        $this->idkab->setDbValue($row['idkab']);
        $this->idkec->setDbValue($row['idkec']);
        $this->idkel->setDbValue($row['idkel']);
        $this->kodepos->setDbValue($row['kodepos']);
        $this->alamat->setDbValue($row['alamat']);
        $this->telpon->setDbValue($row['telpon']);
        $this->hp->setDbValue($row['hp']);
        $this->_email->setDbValue($row['email']);
        $this->website->setDbValue($row['website']);
        $this->foto->Upload->DbValue = $row['foto'];
        $this->foto->setDbValue($this->foto->Upload->DbValue);
        $this->budget_bonus_persen->setDbValue($row['budget_bonus_persen']);
        $this->hutang_max->setDbValue($row['hutang_max']);
        $this->keterangan->setDbValue($row['keterangan']);
        $this->aktif->setDbValue($row['aktif']);
        $this->created_at->setDbValue($row['created_at']);
        $this->updated_at->setDbValue($row['updated_at']);
        $this->created_by->setDbValue($row['created_by']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['kode'] = null;
        $row['idtipecustomer'] = null;
        $row['idpegawai'] = null;
        $row['nama'] = null;
        $row['kodenpd'] = null;
        $row['usaha'] = null;
        $row['jabatan'] = null;
        $row['ktp'] = null;
        $row['npwp'] = null;
        $row['idprov'] = null;
        $row['idkab'] = null;
        $row['idkec'] = null;
        $row['idkel'] = null;
        $row['kodepos'] = null;
        $row['alamat'] = null;
        $row['telpon'] = null;
        $row['hp'] = null;
        $row['email'] = null;
        $row['website'] = null;
        $row['foto'] = null;
        $row['budget_bonus_persen'] = null;
        $row['hutang_max'] = null;
        $row['keterangan'] = null;
        $row['aktif'] = null;
        $row['created_at'] = null;
        $row['updated_at'] = null;
        $row['created_by'] = null;
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

        // Convert decimal values if posted back
        if ($this->budget_bonus_persen->FormValue == $this->budget_bonus_persen->CurrentValue && is_numeric(ConvertToFloatString($this->budget_bonus_persen->CurrentValue))) {
            $this->budget_bonus_persen->CurrentValue = ConvertToFloatString($this->budget_bonus_persen->CurrentValue);
        }

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

        // budget_bonus_persen

        // hutang_max

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

            // budget_bonus_persen
            $this->budget_bonus_persen->ViewValue = $this->budget_bonus_persen->CurrentValue;
            $this->budget_bonus_persen->ViewValue = FormatNumber($this->budget_bonus_persen->ViewValue, 2, -2, -2, -2);
            $this->budget_bonus_persen->ViewCustomAttributes = "";

            // hutang_max
            $this->hutang_max->ViewValue = $this->hutang_max->CurrentValue;
            $this->hutang_max->ViewValue = FormatCurrency($this->hutang_max->ViewValue, 2, -2, -2, -2);
            $this->hutang_max->ViewCustomAttributes = "";

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

            // budget_bonus_persen
            $this->budget_bonus_persen->LinkCustomAttributes = "";
            $this->budget_bonus_persen->HrefValue = "";
            $this->budget_bonus_persen->TooltipValue = "";

            // hutang_max
            $this->hutang_max->LinkCustomAttributes = "";
            $this->hutang_max->HrefValue = "";
            $this->hutang_max->TooltipValue = "";

            // keterangan
            $this->keterangan->LinkCustomAttributes = "";
            $this->keterangan->HrefValue = "";
            $this->keterangan->TooltipValue = "";

            // aktif
            $this->aktif->LinkCustomAttributes = "";
            $this->aktif->HrefValue = "";
            $this->aktif->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // idtipecustomer
            $this->idtipecustomer->EditAttrs["class"] = "form-control";
            $this->idtipecustomer->EditCustomAttributes = "";
            $curVal = trim(strval($this->idtipecustomer->CurrentValue));
            if ($curVal != "") {
                $this->idtipecustomer->ViewValue = $this->idtipecustomer->lookupCacheOption($curVal);
            } else {
                $this->idtipecustomer->ViewValue = $this->idtipecustomer->Lookup !== null && is_array($this->idtipecustomer->Lookup->Options) ? $curVal : null;
            }
            if ($this->idtipecustomer->ViewValue !== null) { // Load from cache
                $this->idtipecustomer->EditValue = array_values($this->idtipecustomer->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idtipecustomer->CurrentValue, DATATYPE_NUMBER, "");
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
            if ($this->idpegawai->getSessionValue() != "") {
                $this->idpegawai->CurrentValue = GetForeignKeyValue($this->idpegawai->getSessionValue());
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
            } else {
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
            }

            // nama
            $this->nama->EditAttrs["class"] = "form-control";
            $this->nama->EditCustomAttributes = "";
            if (!$this->nama->Raw) {
                $this->nama->CurrentValue = HtmlDecode($this->nama->CurrentValue);
            }
            $this->nama->EditValue = HtmlEncode($this->nama->CurrentValue);
            $this->nama->PlaceHolder = RemoveHtml($this->nama->caption());

            // kodenpd
            $this->kodenpd->EditAttrs["class"] = "form-control";
            $this->kodenpd->EditCustomAttributes = "";
            if (!$this->kodenpd->Raw) {
                $this->kodenpd->CurrentValue = HtmlDecode($this->kodenpd->CurrentValue);
            }
            $this->kodenpd->EditValue = HtmlEncode($this->kodenpd->CurrentValue);
            $this->kodenpd->PlaceHolder = RemoveHtml($this->kodenpd->caption());

            // usaha
            $this->usaha->EditAttrs["class"] = "form-control";
            $this->usaha->EditCustomAttributes = "";
            if (!$this->usaha->Raw) {
                $this->usaha->CurrentValue = HtmlDecode($this->usaha->CurrentValue);
            }
            $this->usaha->EditValue = HtmlEncode($this->usaha->CurrentValue);
            $this->usaha->PlaceHolder = RemoveHtml($this->usaha->caption());

            // jabatan
            $this->jabatan->EditAttrs["class"] = "form-control";
            $this->jabatan->EditCustomAttributes = "";
            if (!$this->jabatan->Raw) {
                $this->jabatan->CurrentValue = HtmlDecode($this->jabatan->CurrentValue);
            }
            $this->jabatan->EditValue = HtmlEncode($this->jabatan->CurrentValue);
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
            if ($this->isShow()) {
                RenderUploadField($this->ktp);
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
            if ($this->isShow()) {
                RenderUploadField($this->npwp);
            }

            // idprov
            $this->idprov->EditAttrs["class"] = "form-control";
            $this->idprov->EditCustomAttributes = "";
            $curVal = trim(strval($this->idprov->CurrentValue));
            if ($curVal != "") {
                $this->idprov->ViewValue = $this->idprov->lookupCacheOption($curVal);
            } else {
                $this->idprov->ViewValue = $this->idprov->Lookup !== null && is_array($this->idprov->Lookup->Options) ? $curVal : null;
            }
            if ($this->idprov->ViewValue !== null) { // Load from cache
                $this->idprov->EditValue = array_values($this->idprov->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idprov->CurrentValue, DATATYPE_STRING, "");
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
            $curVal = trim(strval($this->idkab->CurrentValue));
            if ($curVal != "") {
                $this->idkab->ViewValue = $this->idkab->lookupCacheOption($curVal);
            } else {
                $this->idkab->ViewValue = $this->idkab->Lookup !== null && is_array($this->idkab->Lookup->Options) ? $curVal : null;
            }
            if ($this->idkab->ViewValue !== null) { // Load from cache
                $this->idkab->EditValue = array_values($this->idkab->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idkab->CurrentValue, DATATYPE_STRING, "");
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
            $curVal = trim(strval($this->idkec->CurrentValue));
            if ($curVal != "") {
                $this->idkec->ViewValue = $this->idkec->lookupCacheOption($curVal);
            } else {
                $this->idkec->ViewValue = $this->idkec->Lookup !== null && is_array($this->idkec->Lookup->Options) ? $curVal : null;
            }
            if ($this->idkec->ViewValue !== null) { // Load from cache
                $this->idkec->EditValue = array_values($this->idkec->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idkec->CurrentValue, DATATYPE_STRING, "");
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
            $curVal = trim(strval($this->idkel->CurrentValue));
            if ($curVal != "") {
                $this->idkel->ViewValue = $this->idkel->lookupCacheOption($curVal);
            } else {
                $this->idkel->ViewValue = $this->idkel->Lookup !== null && is_array($this->idkel->Lookup->Options) ? $curVal : null;
            }
            if ($this->idkel->ViewValue !== null) { // Load from cache
                $this->idkel->EditValue = array_values($this->idkel->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idkel->CurrentValue, DATATYPE_STRING, "");
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
                $this->kodepos->CurrentValue = HtmlDecode($this->kodepos->CurrentValue);
            }
            $this->kodepos->EditValue = HtmlEncode($this->kodepos->CurrentValue);
            $this->kodepos->PlaceHolder = RemoveHtml($this->kodepos->caption());

            // alamat
            $this->alamat->EditAttrs["class"] = "form-control";
            $this->alamat->EditCustomAttributes = "";
            if (!$this->alamat->Raw) {
                $this->alamat->CurrentValue = HtmlDecode($this->alamat->CurrentValue);
            }
            $this->alamat->EditValue = HtmlEncode($this->alamat->CurrentValue);
            $this->alamat->PlaceHolder = RemoveHtml($this->alamat->caption());

            // telpon
            $this->telpon->EditAttrs["class"] = "form-control";
            $this->telpon->EditCustomAttributes = "";
            if (!$this->telpon->Raw) {
                $this->telpon->CurrentValue = HtmlDecode($this->telpon->CurrentValue);
            }
            $this->telpon->EditValue = HtmlEncode($this->telpon->CurrentValue);
            $this->telpon->PlaceHolder = RemoveHtml($this->telpon->caption());

            // hp
            $this->hp->EditAttrs["class"] = "form-control";
            $this->hp->EditCustomAttributes = "";
            if (!$this->hp->Raw) {
                $this->hp->CurrentValue = HtmlDecode($this->hp->CurrentValue);
            }
            $this->hp->EditValue = HtmlEncode($this->hp->CurrentValue);
            $this->hp->PlaceHolder = RemoveHtml($this->hp->caption());

            // email
            $this->_email->EditAttrs["class"] = "form-control";
            $this->_email->EditCustomAttributes = "";
            if (!$this->_email->Raw) {
                $this->_email->CurrentValue = HtmlDecode($this->_email->CurrentValue);
            }
            $this->_email->EditValue = HtmlEncode($this->_email->CurrentValue);
            $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

            // website
            $this->website->EditAttrs["class"] = "form-control";
            $this->website->EditCustomAttributes = "";
            if (!$this->website->Raw) {
                $this->website->CurrentValue = HtmlDecode($this->website->CurrentValue);
            }
            $this->website->EditValue = HtmlEncode($this->website->CurrentValue);
            $this->website->PlaceHolder = RemoveHtml($this->website->caption());

            // foto
            $this->foto->EditAttrs["class"] = "form-control";
            $this->foto->EditCustomAttributes = "";
            if (!EmptyValue($this->foto->Upload->DbValue)) {
                $this->foto->ImageAlt = $this->foto->alt();
                $this->foto->EditValue = $this->foto->Upload->DbValue;
            } else {
                $this->foto->EditValue = "";
            }
            if (!EmptyValue($this->foto->CurrentValue)) {
                $this->foto->Upload->FileName = $this->foto->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->foto);
            }

            // budget_bonus_persen
            $this->budget_bonus_persen->EditAttrs["class"] = "form-control";
            $this->budget_bonus_persen->EditCustomAttributes = "";
            $this->budget_bonus_persen->EditValue = HtmlEncode($this->budget_bonus_persen->CurrentValue);
            $this->budget_bonus_persen->PlaceHolder = RemoveHtml($this->budget_bonus_persen->caption());
            if (strval($this->budget_bonus_persen->EditValue) != "" && is_numeric($this->budget_bonus_persen->EditValue)) {
                $this->budget_bonus_persen->EditValue = FormatNumber($this->budget_bonus_persen->EditValue, -2, -2, -2, -2);
            }

            // hutang_max
            $this->hutang_max->EditAttrs["class"] = "form-control";
            $this->hutang_max->EditCustomAttributes = "";
            $this->hutang_max->EditValue = HtmlEncode($this->hutang_max->CurrentValue);
            $this->hutang_max->PlaceHolder = RemoveHtml($this->hutang_max->caption());

            // keterangan
            $this->keterangan->EditAttrs["class"] = "form-control";
            $this->keterangan->EditCustomAttributes = "";
            $this->keterangan->EditValue = HtmlEncode($this->keterangan->CurrentValue);
            $this->keterangan->PlaceHolder = RemoveHtml($this->keterangan->caption());

            // aktif
            $this->aktif->EditCustomAttributes = "";
            $this->aktif->EditValue = $this->aktif->options(false);
            $this->aktif->PlaceHolder = RemoveHtml($this->aktif->caption());

            // Edit refer script

            // idtipecustomer
            $this->idtipecustomer->LinkCustomAttributes = "";
            $this->idtipecustomer->HrefValue = "";

            // idpegawai
            $this->idpegawai->LinkCustomAttributes = "";
            $this->idpegawai->HrefValue = "";

            // nama
            $this->nama->LinkCustomAttributes = "";
            $this->nama->HrefValue = "";

            // kodenpd
            $this->kodenpd->LinkCustomAttributes = "";
            $this->kodenpd->HrefValue = "";

            // usaha
            $this->usaha->LinkCustomAttributes = "";
            $this->usaha->HrefValue = "";

            // jabatan
            $this->jabatan->LinkCustomAttributes = "";
            $this->jabatan->HrefValue = "";

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

            // idprov
            $this->idprov->LinkCustomAttributes = "";
            $this->idprov->HrefValue = "";

            // idkab
            $this->idkab->LinkCustomAttributes = "";
            $this->idkab->HrefValue = "";

            // idkec
            $this->idkec->LinkCustomAttributes = "";
            $this->idkec->HrefValue = "";

            // idkel
            $this->idkel->LinkCustomAttributes = "";
            $this->idkel->HrefValue = "";

            // kodepos
            $this->kodepos->LinkCustomAttributes = "";
            $this->kodepos->HrefValue = "";

            // alamat
            $this->alamat->LinkCustomAttributes = "";
            $this->alamat->HrefValue = "";

            // telpon
            $this->telpon->LinkCustomAttributes = "";
            $this->telpon->HrefValue = "";

            // hp
            $this->hp->LinkCustomAttributes = "";
            $this->hp->HrefValue = "";

            // email
            $this->_email->LinkCustomAttributes = "";
            $this->_email->HrefValue = "";

            // website
            $this->website->LinkCustomAttributes = "";
            $this->website->HrefValue = "";

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

            // budget_bonus_persen
            $this->budget_bonus_persen->LinkCustomAttributes = "";
            $this->budget_bonus_persen->HrefValue = "";

            // hutang_max
            $this->hutang_max->LinkCustomAttributes = "";
            $this->hutang_max->HrefValue = "";

            // keterangan
            $this->keterangan->LinkCustomAttributes = "";
            $this->keterangan->HrefValue = "";

            // aktif
            $this->aktif->LinkCustomAttributes = "";
            $this->aktif->HrefValue = "";
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
        if ($this->idtipecustomer->Required) {
            if (!$this->idtipecustomer->IsDetailKey && EmptyValue($this->idtipecustomer->FormValue)) {
                $this->idtipecustomer->addErrorMessage(str_replace("%s", $this->idtipecustomer->caption(), $this->idtipecustomer->RequiredErrorMessage));
            }
        }
        if ($this->idpegawai->Required) {
            if (!$this->idpegawai->IsDetailKey && EmptyValue($this->idpegawai->FormValue)) {
                $this->idpegawai->addErrorMessage(str_replace("%s", $this->idpegawai->caption(), $this->idpegawai->RequiredErrorMessage));
            }
        }
        if ($this->nama->Required) {
            if (!$this->nama->IsDetailKey && EmptyValue($this->nama->FormValue)) {
                $this->nama->addErrorMessage(str_replace("%s", $this->nama->caption(), $this->nama->RequiredErrorMessage));
            }
        }
        if ($this->kodenpd->Required) {
            if (!$this->kodenpd->IsDetailKey && EmptyValue($this->kodenpd->FormValue)) {
                $this->kodenpd->addErrorMessage(str_replace("%s", $this->kodenpd->caption(), $this->kodenpd->RequiredErrorMessage));
            }
        }
        if ($this->usaha->Required) {
            if (!$this->usaha->IsDetailKey && EmptyValue($this->usaha->FormValue)) {
                $this->usaha->addErrorMessage(str_replace("%s", $this->usaha->caption(), $this->usaha->RequiredErrorMessage));
            }
        }
        if ($this->jabatan->Required) {
            if (!$this->jabatan->IsDetailKey && EmptyValue($this->jabatan->FormValue)) {
                $this->jabatan->addErrorMessage(str_replace("%s", $this->jabatan->caption(), $this->jabatan->RequiredErrorMessage));
            }
        }
        if ($this->ktp->Required) {
            if ($this->ktp->Upload->FileName == "" && !$this->ktp->Upload->KeepFile) {
                $this->ktp->addErrorMessage(str_replace("%s", $this->ktp->caption(), $this->ktp->RequiredErrorMessage));
            }
        }
        if ($this->npwp->Required) {
            if ($this->npwp->Upload->FileName == "" && !$this->npwp->Upload->KeepFile) {
                $this->npwp->addErrorMessage(str_replace("%s", $this->npwp->caption(), $this->npwp->RequiredErrorMessage));
            }
        }
        if ($this->idprov->Required) {
            if (!$this->idprov->IsDetailKey && EmptyValue($this->idprov->FormValue)) {
                $this->idprov->addErrorMessage(str_replace("%s", $this->idprov->caption(), $this->idprov->RequiredErrorMessage));
            }
        }
        if ($this->idkab->Required) {
            if (!$this->idkab->IsDetailKey && EmptyValue($this->idkab->FormValue)) {
                $this->idkab->addErrorMessage(str_replace("%s", $this->idkab->caption(), $this->idkab->RequiredErrorMessage));
            }
        }
        if ($this->idkec->Required) {
            if (!$this->idkec->IsDetailKey && EmptyValue($this->idkec->FormValue)) {
                $this->idkec->addErrorMessage(str_replace("%s", $this->idkec->caption(), $this->idkec->RequiredErrorMessage));
            }
        }
        if ($this->idkel->Required) {
            if (!$this->idkel->IsDetailKey && EmptyValue($this->idkel->FormValue)) {
                $this->idkel->addErrorMessage(str_replace("%s", $this->idkel->caption(), $this->idkel->RequiredErrorMessage));
            }
        }
        if ($this->kodepos->Required) {
            if (!$this->kodepos->IsDetailKey && EmptyValue($this->kodepos->FormValue)) {
                $this->kodepos->addErrorMessage(str_replace("%s", $this->kodepos->caption(), $this->kodepos->RequiredErrorMessage));
            }
        }
        if ($this->alamat->Required) {
            if (!$this->alamat->IsDetailKey && EmptyValue($this->alamat->FormValue)) {
                $this->alamat->addErrorMessage(str_replace("%s", $this->alamat->caption(), $this->alamat->RequiredErrorMessage));
            }
        }
        if ($this->telpon->Required) {
            if (!$this->telpon->IsDetailKey && EmptyValue($this->telpon->FormValue)) {
                $this->telpon->addErrorMessage(str_replace("%s", $this->telpon->caption(), $this->telpon->RequiredErrorMessage));
            }
        }
        if ($this->hp->Required) {
            if (!$this->hp->IsDetailKey && EmptyValue($this->hp->FormValue)) {
                $this->hp->addErrorMessage(str_replace("%s", $this->hp->caption(), $this->hp->RequiredErrorMessage));
            }
        }
        if ($this->_email->Required) {
            if (!$this->_email->IsDetailKey && EmptyValue($this->_email->FormValue)) {
                $this->_email->addErrorMessage(str_replace("%s", $this->_email->caption(), $this->_email->RequiredErrorMessage));
            }
        }
        if ($this->website->Required) {
            if (!$this->website->IsDetailKey && EmptyValue($this->website->FormValue)) {
                $this->website->addErrorMessage(str_replace("%s", $this->website->caption(), $this->website->RequiredErrorMessage));
            }
        }
        if ($this->foto->Required) {
            if ($this->foto->Upload->FileName == "" && !$this->foto->Upload->KeepFile) {
                $this->foto->addErrorMessage(str_replace("%s", $this->foto->caption(), $this->foto->RequiredErrorMessage));
            }
        }
        if ($this->budget_bonus_persen->Required) {
            if (!$this->budget_bonus_persen->IsDetailKey && EmptyValue($this->budget_bonus_persen->FormValue)) {
                $this->budget_bonus_persen->addErrorMessage(str_replace("%s", $this->budget_bonus_persen->caption(), $this->budget_bonus_persen->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->budget_bonus_persen->FormValue)) {
            $this->budget_bonus_persen->addErrorMessage($this->budget_bonus_persen->getErrorMessage(false));
        }
        if ($this->hutang_max->Required) {
            if (!$this->hutang_max->IsDetailKey && EmptyValue($this->hutang_max->FormValue)) {
                $this->hutang_max->addErrorMessage(str_replace("%s", $this->hutang_max->caption(), $this->hutang_max->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->hutang_max->FormValue)) {
            $this->hutang_max->addErrorMessage($this->hutang_max->getErrorMessage(false));
        }
        if ($this->keterangan->Required) {
            if (!$this->keterangan->IsDetailKey && EmptyValue($this->keterangan->FormValue)) {
                $this->keterangan->addErrorMessage(str_replace("%s", $this->keterangan->caption(), $this->keterangan->RequiredErrorMessage));
            }
        }
        if ($this->aktif->Required) {
            if ($this->aktif->FormValue == "") {
                $this->aktif->addErrorMessage(str_replace("%s", $this->aktif->caption(), $this->aktif->RequiredErrorMessage));
            }
        }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("AlamatCustomerGrid");
        if (in_array("alamat_customer", $detailTblVar) && $detailPage->DetailEdit) {
            $detailPage->validateGridForm();
        }
        $detailPage = Container("BrandGrid");
        if (in_array("brand", $detailTblVar) && $detailPage->DetailEdit) {
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

            // idtipecustomer
            $this->idtipecustomer->setDbValueDef($rsnew, $this->idtipecustomer->CurrentValue, 0, $this->idtipecustomer->ReadOnly);

            // idpegawai
            if ($this->idpegawai->getSessionValue() != "") {
                $this->idpegawai->ReadOnly = true;
            }
            $this->idpegawai->setDbValueDef($rsnew, $this->idpegawai->CurrentValue, 0, $this->idpegawai->ReadOnly);

            // nama
            $this->nama->setDbValueDef($rsnew, $this->nama->CurrentValue, "", $this->nama->ReadOnly);

            // kodenpd
            $this->kodenpd->setDbValueDef($rsnew, $this->kodenpd->CurrentValue, null, $this->kodenpd->ReadOnly);

            // usaha
            $this->usaha->setDbValueDef($rsnew, $this->usaha->CurrentValue, null, $this->usaha->ReadOnly);

            // jabatan
            $this->jabatan->setDbValueDef($rsnew, $this->jabatan->CurrentValue, null, $this->jabatan->ReadOnly);

            // ktp
            if ($this->ktp->Visible && !$this->ktp->ReadOnly && !$this->ktp->Upload->KeepFile) {
                if ($this->ktp->Upload->Value === null) {
                    $rsnew['ktp'] = null;
                } else {
                    $rsnew['ktp'] = $this->ktp->Upload->Value;
                }
                $this->ktp->setDbValueDef($rsnew, $this->ktp->Upload->FileName, null, false);
            }

            // npwp
            if ($this->npwp->Visible && !$this->npwp->ReadOnly && !$this->npwp->Upload->KeepFile) {
                if ($this->npwp->Upload->Value === null) {
                    $rsnew['npwp'] = null;
                } else {
                    $rsnew['npwp'] = $this->npwp->Upload->Value;
                }
                $this->npwp->setDbValueDef($rsnew, $this->npwp->Upload->FileName, null, false);
            }

            // idprov
            $this->idprov->setDbValueDef($rsnew, $this->idprov->CurrentValue, null, $this->idprov->ReadOnly);

            // idkab
            $this->idkab->setDbValueDef($rsnew, $this->idkab->CurrentValue, null, $this->idkab->ReadOnly);

            // idkec
            $this->idkec->setDbValueDef($rsnew, $this->idkec->CurrentValue, null, $this->idkec->ReadOnly);

            // idkel
            $this->idkel->setDbValueDef($rsnew, $this->idkel->CurrentValue, null, $this->idkel->ReadOnly);

            // kodepos
            $this->kodepos->setDbValueDef($rsnew, $this->kodepos->CurrentValue, null, $this->kodepos->ReadOnly);

            // alamat
            $this->alamat->setDbValueDef($rsnew, $this->alamat->CurrentValue, null, $this->alamat->ReadOnly);

            // telpon
            $this->telpon->setDbValueDef($rsnew, $this->telpon->CurrentValue, null, $this->telpon->ReadOnly);

            // hp
            $this->hp->setDbValueDef($rsnew, $this->hp->CurrentValue, "", $this->hp->ReadOnly);

            // email
            $this->_email->setDbValueDef($rsnew, $this->_email->CurrentValue, null, $this->_email->ReadOnly);

            // website
            $this->website->setDbValueDef($rsnew, $this->website->CurrentValue, null, $this->website->ReadOnly);

            // foto
            if ($this->foto->Visible && !$this->foto->ReadOnly && !$this->foto->Upload->KeepFile) {
                $this->foto->Upload->DbValue = $rsold['foto']; // Get original value
                if ($this->foto->Upload->FileName == "") {
                    $rsnew['foto'] = null;
                } else {
                    $rsnew['foto'] = $this->foto->Upload->FileName;
                }
            }

            // budget_bonus_persen
            $this->budget_bonus_persen->setDbValueDef($rsnew, $this->budget_bonus_persen->CurrentValue, null, $this->budget_bonus_persen->ReadOnly);

            // hutang_max
            $this->hutang_max->setDbValueDef($rsnew, $this->hutang_max->CurrentValue, null, $this->hutang_max->ReadOnly);

            // keterangan
            $this->keterangan->setDbValueDef($rsnew, $this->keterangan->CurrentValue, null, $this->keterangan->ReadOnly);

            // aktif
            $this->aktif->setDbValueDef($rsnew, $this->aktif->CurrentValue, 0, $this->aktif->ReadOnly);
            if ($this->foto->Visible && !$this->foto->Upload->KeepFile) {
                $oldFiles = EmptyValue($this->foto->Upload->DbValue) ? [] : explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $this->foto->htmlDecode(strval($this->foto->Upload->DbValue)));
                if (!EmptyValue($this->foto->Upload->FileName)) {
                    $newFiles = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), strval($this->foto->Upload->FileName));
                    $NewFileCount = count($newFiles);
                    for ($i = 0; $i < $NewFileCount; $i++) {
                        if ($newFiles[$i] != "") {
                            $file = $newFiles[$i];
                            $tempPath = UploadTempPath($this->foto, $this->foto->Upload->Index);
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
                                $file1 = UniqueFilename($this->foto->physicalUploadPath(), $file); // Get new file name
                                if ($file1 != $file) { // Rename temp file
                                    while (file_exists($tempPath . $file1) || file_exists($this->foto->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                        $file1 = UniqueFilename([$this->foto->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                    }
                                    rename($tempPath . $file, $tempPath . $file1);
                                    $newFiles[$i] = $file1;
                                }
                            }
                        }
                    }
                    $this->foto->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                    $this->foto->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                    $this->foto->setDbValueDef($rsnew, $this->foto->Upload->FileName, null, $this->foto->ReadOnly);
                }
            }

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
                    if ($this->foto->Visible && !$this->foto->Upload->KeepFile) {
                        $oldFiles = EmptyValue($this->foto->Upload->DbValue) ? [] : explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $this->foto->htmlDecode(strval($this->foto->Upload->DbValue)));
                        if (!EmptyValue($this->foto->Upload->FileName)) {
                            $newFiles = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $this->foto->Upload->FileName);
                            $newFiles2 = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $this->foto->htmlDecode($rsnew['foto']));
                            $newFileCount = count($newFiles);
                            for ($i = 0; $i < $newFileCount; $i++) {
                                if ($newFiles[$i] != "") {
                                    $file = UploadTempPath($this->foto, $this->foto->Upload->Index) . $newFiles[$i];
                                    if (file_exists($file)) {
                                        if (@$newFiles2[$i] != "") { // Use correct file name
                                            $newFiles[$i] = $newFiles2[$i];
                                        }
                                        if (!$this->foto->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
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
                                    @unlink($this->foto->oldPhysicalUploadPath() . $oldFile);
                                }
                            }
                        }
                    }
                }

                // Update detail records
                $detailTblVar = explode(",", $this->getCurrentDetailTable());
                if ($editRow) {
                    $detailPage = Container("AlamatCustomerGrid");
                    if (in_array("alamat_customer", $detailTblVar) && $detailPage->DetailEdit) {
                        $Security->loadCurrentUserLevel($this->ProjectID . "alamat_customer"); // Load user level of detail table
                        $editRow = $detailPage->gridUpdate();
                        $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                    }
                }
                if ($editRow) {
                    $detailPage = Container("BrandGrid");
                    if (in_array("brand", $detailTblVar) && $detailPage->DetailEdit) {
                        $Security->loadCurrentUserLevel($this->ProjectID . "brand"); // Load user level of detail table
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
            // ktp
            CleanUploadTempPath($this->ktp, $this->ktp->Upload->Index);

            // npwp
            CleanUploadTempPath($this->npwp, $this->npwp->Upload->Index);

            // foto
            CleanUploadTempPath($this->foto, $this->foto->Upload->Index);
        }

        // Write JSON for API request
        if (IsApi() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $editRow;
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
            if ($masterTblVar == "pegawai") {
                $validMaster = true;
                $masterTbl = Container("pegawai");
                if (($parm = Get("fk_id", Get("idpegawai"))) !== null) {
                    $masterTbl->id->setQueryStringValue($parm);
                    $this->idpegawai->setQueryStringValue($masterTbl->id->QueryStringValue);
                    $this->idpegawai->setSessionValue($this->idpegawai->QueryStringValue);
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
            if ($masterTblVar == "pegawai") {
                $validMaster = true;
                $masterTbl = Container("pegawai");
                if (($parm = Post("fk_id", Post("idpegawai"))) !== null) {
                    $masterTbl->id->setFormValue($parm);
                    $this->idpegawai->setFormValue($masterTbl->id->FormValue);
                    $this->idpegawai->setSessionValue($this->idpegawai->FormValue);
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
            $this->setSessionWhere($this->getDetailFilter());

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "pegawai") {
                if ($this->idpegawai->CurrentValue == "") {
                    $this->idpegawai->setSessionValue("");
                }
            }
        }
        $this->DbMasterFilter = $this->getMasterFilter(); // Get master filter
        $this->DbDetailFilter = $this->getDetailFilter(); // Get detail filter
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
            if (in_array("alamat_customer", $detailTblVar)) {
                $detailPageObj = Container("AlamatCustomerGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->idcustomer->IsDetailKey = true;
                    $detailPageObj->idcustomer->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->idcustomer->setSessionValue($detailPageObj->idcustomer->CurrentValue);
                }
            }
            if (in_array("brand", $detailTblVar)) {
                $detailPageObj = Container("BrandGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->idcustomer->IsDetailKey = true;
                    $detailPageObj->idcustomer->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->idcustomer->setSessionValue($detailPageObj->idcustomer->CurrentValue);
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("CustomerList"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
    }

    // Set up detail pages
    protected function setupDetailPages()
    {
        $pages = new SubPages();
        $pages->Style = "tabs";
        $pages->add('alamat_customer');
        $pages->add('brand');
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
        $count = ExecuteScalar("SELECT COUNT(*) FROM customer WHERE kodenpd='".$this->kodenpd->FormValue."' AND id NOT IN (".$this->id->CurrentValue.")");
        if ($count>0) {
        	$customError = "Kode NPD sudah terpakai.";
    //        $this->kodenpd->addErrorMessage("Kode NPD sudah terpakai.");
            return false;
        }
        return true;
    }
}
