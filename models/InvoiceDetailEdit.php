<?php

namespace PHPMaker2021\production2;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class InvoiceDetailEdit extends InvoiceDetail
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'invoice_detail';

    // Page object name
    public $PageObjName = "InvoiceDetailEdit";

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

        // Table object (invoice_detail)
        if (!isset($GLOBALS["invoice_detail"]) || get_class($GLOBALS["invoice_detail"]) == PROJECT_NAMESPACE . "invoice_detail") {
            $GLOBALS["invoice_detail"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'invoice_detail');
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
                $doc = new $class(Container("invoice_detail"));
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
                    if ($pageName == "InvoiceDetailView") {
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
        $this->idinvoice->Visible = false;
        $this->idorder_detail->Visible = false;
        $this->jumlahorder->setVisibility();
        $this->bonus->setVisibility();
        $this->stockdo->setVisibility();
        $this->jumlahkirim->setVisibility();
        $this->jumlahbonus->setVisibility();
        $this->harga->setVisibility();
        $this->totalnondiskon->setVisibility();
        $this->diskonpayment->setVisibility();
        $this->bbpersen->setVisibility();
        $this->totaltagihan->setVisibility();
        $this->blackbonus->setVisibility();
        $this->created_at->Visible = false;
        $this->created_by->Visible = false;
        $this->readonly->setVisibility();
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
        $this->setupLookupOptions($this->idorder_detail);

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
                    $this->terminate("InvoiceDetailList"); // No matching record, return to list
                    return;
                }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "InvoiceDetailList") {
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

        // Check field name 'jumlahorder' first before field var 'x_jumlahorder'
        $val = $CurrentForm->hasValue("jumlahorder") ? $CurrentForm->getValue("jumlahorder") : $CurrentForm->getValue("x_jumlahorder");
        if (!$this->jumlahorder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jumlahorder->Visible = false; // Disable update for API request
            } else {
                $this->jumlahorder->setFormValue($val);
            }
        }

        // Check field name 'bonus' first before field var 'x_bonus'
        $val = $CurrentForm->hasValue("bonus") ? $CurrentForm->getValue("bonus") : $CurrentForm->getValue("x_bonus");
        if (!$this->bonus->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bonus->Visible = false; // Disable update for API request
            } else {
                $this->bonus->setFormValue($val);
            }
        }

        // Check field name 'stockdo' first before field var 'x_stockdo'
        $val = $CurrentForm->hasValue("stockdo") ? $CurrentForm->getValue("stockdo") : $CurrentForm->getValue("x_stockdo");
        if (!$this->stockdo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->stockdo->Visible = false; // Disable update for API request
            } else {
                $this->stockdo->setFormValue($val);
            }
        }

        // Check field name 'jumlahkirim' first before field var 'x_jumlahkirim'
        $val = $CurrentForm->hasValue("jumlahkirim") ? $CurrentForm->getValue("jumlahkirim") : $CurrentForm->getValue("x_jumlahkirim");
        if (!$this->jumlahkirim->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jumlahkirim->Visible = false; // Disable update for API request
            } else {
                $this->jumlahkirim->setFormValue($val);
            }
        }

        // Check field name 'jumlahbonus' first before field var 'x_jumlahbonus'
        $val = $CurrentForm->hasValue("jumlahbonus") ? $CurrentForm->getValue("jumlahbonus") : $CurrentForm->getValue("x_jumlahbonus");
        if (!$this->jumlahbonus->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jumlahbonus->Visible = false; // Disable update for API request
            } else {
                $this->jumlahbonus->setFormValue($val);
            }
        }

        // Check field name 'harga' first before field var 'x_harga'
        $val = $CurrentForm->hasValue("harga") ? $CurrentForm->getValue("harga") : $CurrentForm->getValue("x_harga");
        if (!$this->harga->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->harga->Visible = false; // Disable update for API request
            } else {
                $this->harga->setFormValue($val);
            }
        }

        // Check field name 'totalnondiskon' first before field var 'x_totalnondiskon'
        $val = $CurrentForm->hasValue("totalnondiskon") ? $CurrentForm->getValue("totalnondiskon") : $CurrentForm->getValue("x_totalnondiskon");
        if (!$this->totalnondiskon->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->totalnondiskon->Visible = false; // Disable update for API request
            } else {
                $this->totalnondiskon->setFormValue($val);
            }
        }

        // Check field name 'diskonpayment' first before field var 'x_diskonpayment'
        $val = $CurrentForm->hasValue("diskonpayment") ? $CurrentForm->getValue("diskonpayment") : $CurrentForm->getValue("x_diskonpayment");
        if (!$this->diskonpayment->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->diskonpayment->Visible = false; // Disable update for API request
            } else {
                $this->diskonpayment->setFormValue($val);
            }
        }

        // Check field name 'bbpersen' first before field var 'x_bbpersen'
        $val = $CurrentForm->hasValue("bbpersen") ? $CurrentForm->getValue("bbpersen") : $CurrentForm->getValue("x_bbpersen");
        if (!$this->bbpersen->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bbpersen->Visible = false; // Disable update for API request
            } else {
                $this->bbpersen->setFormValue($val);
            }
        }

        // Check field name 'totaltagihan' first before field var 'x_totaltagihan'
        $val = $CurrentForm->hasValue("totaltagihan") ? $CurrentForm->getValue("totaltagihan") : $CurrentForm->getValue("x_totaltagihan");
        if (!$this->totaltagihan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->totaltagihan->Visible = false; // Disable update for API request
            } else {
                $this->totaltagihan->setFormValue($val);
            }
        }

        // Check field name 'blackbonus' first before field var 'x_blackbonus'
        $val = $CurrentForm->hasValue("blackbonus") ? $CurrentForm->getValue("blackbonus") : $CurrentForm->getValue("x_blackbonus");
        if (!$this->blackbonus->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->blackbonus->Visible = false; // Disable update for API request
            } else {
                $this->blackbonus->setFormValue($val);
            }
        }

        // Check field name 'readonly' first before field var 'x_readonly'
        $val = $CurrentForm->hasValue("readonly") ? $CurrentForm->getValue("readonly") : $CurrentForm->getValue("x_readonly");
        if (!$this->readonly->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->readonly->Visible = false; // Disable update for API request
            } else {
                $this->readonly->setFormValue($val);
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
        $this->jumlahorder->CurrentValue = $this->jumlahorder->FormValue;
        $this->bonus->CurrentValue = $this->bonus->FormValue;
        $this->stockdo->CurrentValue = $this->stockdo->FormValue;
        $this->jumlahkirim->CurrentValue = $this->jumlahkirim->FormValue;
        $this->jumlahbonus->CurrentValue = $this->jumlahbonus->FormValue;
        $this->harga->CurrentValue = $this->harga->FormValue;
        $this->totalnondiskon->CurrentValue = $this->totalnondiskon->FormValue;
        $this->diskonpayment->CurrentValue = $this->diskonpayment->FormValue;
        $this->bbpersen->CurrentValue = $this->bbpersen->FormValue;
        $this->totaltagihan->CurrentValue = $this->totaltagihan->FormValue;
        $this->blackbonus->CurrentValue = $this->blackbonus->FormValue;
        $this->readonly->CurrentValue = $this->readonly->FormValue;
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
            $res = $this->showOptionLink("edit");
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
        $this->idinvoice->setDbValue($row['idinvoice']);
        $this->idorder_detail->setDbValue($row['idorder_detail']);
        $this->jumlahorder->setDbValue($row['jumlahorder']);
        $this->bonus->setDbValue($row['bonus']);
        $this->stockdo->setDbValue($row['stockdo']);
        $this->jumlahkirim->setDbValue($row['jumlahkirim']);
        $this->jumlahbonus->setDbValue($row['jumlahbonus']);
        $this->harga->setDbValue($row['harga']);
        $this->totalnondiskon->setDbValue($row['totalnondiskon']);
        $this->diskonpayment->setDbValue($row['diskonpayment']);
        $this->bbpersen->setDbValue($row['bbpersen']);
        $this->totaltagihan->setDbValue($row['totaltagihan']);
        $this->blackbonus->setDbValue($row['blackbonus']);
        $this->created_at->setDbValue($row['created_at']);
        $this->created_by->setDbValue($row['created_by']);
        $this->readonly->setDbValue($row['readonly']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['idinvoice'] = null;
        $row['idorder_detail'] = null;
        $row['jumlahorder'] = null;
        $row['bonus'] = null;
        $row['stockdo'] = null;
        $row['jumlahkirim'] = null;
        $row['jumlahbonus'] = null;
        $row['harga'] = null;
        $row['totalnondiskon'] = null;
        $row['diskonpayment'] = null;
        $row['bbpersen'] = null;
        $row['totaltagihan'] = null;
        $row['blackbonus'] = null;
        $row['created_at'] = null;
        $row['created_by'] = null;
        $row['readonly'] = null;
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
        if ($this->diskonpayment->FormValue == $this->diskonpayment->CurrentValue && is_numeric(ConvertToFloatString($this->diskonpayment->CurrentValue))) {
            $this->diskonpayment->CurrentValue = ConvertToFloatString($this->diskonpayment->CurrentValue);
        }

        // Convert decimal values if posted back
        if ($this->bbpersen->FormValue == $this->bbpersen->CurrentValue && is_numeric(ConvertToFloatString($this->bbpersen->CurrentValue))) {
            $this->bbpersen->CurrentValue = ConvertToFloatString($this->bbpersen->CurrentValue);
        }

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id

        // idinvoice

        // idorder_detail

        // jumlahorder

        // bonus

        // stockdo

        // jumlahkirim

        // jumlahbonus

        // harga

        // totalnondiskon

        // diskonpayment

        // bbpersen

        // totaltagihan

        // blackbonus

        // created_at

        // created_by

        // readonly
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // idinvoice
            $this->idinvoice->ViewValue = $this->idinvoice->CurrentValue;
            $this->idinvoice->ViewValue = FormatNumber($this->idinvoice->ViewValue, 0, -2, -2, -2);
            $this->idinvoice->ViewCustomAttributes = "";

            // idorder_detail
            $curVal = trim(strval($this->idorder_detail->CurrentValue));
            if ($curVal != "") {
                $this->idorder_detail->ViewValue = $this->idorder_detail->lookupCacheOption($curVal);
                if ($this->idorder_detail->ViewValue === null) { // Lookup from database
                    $filterWrk = "`idorder_detail`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return (CurrentPageID() == "add" || CurrentPageID() == "edit") ? "jumlah > 0" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->idorder_detail->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idorder_detail->Lookup->renderViewRow($rswrk[0]);
                        $this->idorder_detail->ViewValue = $this->idorder_detail->displayValue($arwrk);
                    } else {
                        $this->idorder_detail->ViewValue = $this->idorder_detail->CurrentValue;
                    }
                }
            } else {
                $this->idorder_detail->ViewValue = null;
            }
            $this->idorder_detail->ViewCustomAttributes = "";

            // jumlahorder
            $this->jumlahorder->ViewValue = $this->jumlahorder->CurrentValue;
            $this->jumlahorder->ViewValue = FormatNumber($this->jumlahorder->ViewValue, 0, -2, -2, -2);
            $this->jumlahorder->ViewCustomAttributes = "";

            // bonus
            $this->bonus->ViewValue = $this->bonus->CurrentValue;
            $this->bonus->ViewValue = FormatNumber($this->bonus->ViewValue, 0, -2, -2, -2);
            $this->bonus->ViewCustomAttributes = "";

            // stockdo
            $this->stockdo->ViewValue = $this->stockdo->CurrentValue;
            $this->stockdo->ViewValue = FormatNumber($this->stockdo->ViewValue, 0, -2, -2, -2);
            $this->stockdo->ViewCustomAttributes = "";

            // jumlahkirim
            $this->jumlahkirim->ViewValue = $this->jumlahkirim->CurrentValue;
            $this->jumlahkirim->ViewValue = FormatNumber($this->jumlahkirim->ViewValue, 0, -2, -2, -2);
            $this->jumlahkirim->ViewCustomAttributes = "";

            // jumlahbonus
            $this->jumlahbonus->ViewValue = $this->jumlahbonus->CurrentValue;
            $this->jumlahbonus->ViewValue = FormatNumber($this->jumlahbonus->ViewValue, 0, -2, -2, -2);
            $this->jumlahbonus->ViewCustomAttributes = "";

            // harga
            $this->harga->ViewValue = $this->harga->CurrentValue;
            $this->harga->ViewValue = FormatCurrency($this->harga->ViewValue, 2, -2, -2, -2);
            $this->harga->ViewCustomAttributes = "";

            // totalnondiskon
            $this->totalnondiskon->ViewValue = $this->totalnondiskon->CurrentValue;
            $this->totalnondiskon->ViewValue = FormatCurrency($this->totalnondiskon->ViewValue, 2, -2, -2, -2);
            $this->totalnondiskon->ViewCustomAttributes = "";

            // diskonpayment
            $this->diskonpayment->ViewValue = $this->diskonpayment->CurrentValue;
            $this->diskonpayment->ViewValue = FormatNumber($this->diskonpayment->ViewValue, 2, -2, -2, -2);
            $this->diskonpayment->ViewCustomAttributes = "";

            // bbpersen
            $this->bbpersen->ViewValue = $this->bbpersen->CurrentValue;
            $this->bbpersen->ViewValue = FormatNumber($this->bbpersen->ViewValue, 2, -2, -2, -2);
            $this->bbpersen->ViewCustomAttributes = "";

            // totaltagihan
            $this->totaltagihan->ViewValue = $this->totaltagihan->CurrentValue;
            $this->totaltagihan->ViewValue = FormatCurrency($this->totaltagihan->ViewValue, 2, -2, -2, -2);
            $this->totaltagihan->ViewCustomAttributes = "";

            // blackbonus
            $this->blackbonus->ViewValue = $this->blackbonus->CurrentValue;
            $this->blackbonus->ViewValue = FormatCurrency($this->blackbonus->ViewValue, 2, -2, -2, -2);
            $this->blackbonus->ViewCustomAttributes = "";

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
            $this->created_at->ViewCustomAttributes = "";

            // created_by
            $this->created_by->ViewValue = $this->created_by->CurrentValue;
            $this->created_by->ViewValue = FormatNumber($this->created_by->ViewValue, 0, -2, -2, -2);
            $this->created_by->ViewCustomAttributes = "";

            // readonly
            $this->readonly->ViewValue = $this->readonly->CurrentValue;
            $this->readonly->ViewCustomAttributes = "";

            // jumlahorder
            $this->jumlahorder->LinkCustomAttributes = "";
            $this->jumlahorder->HrefValue = "";
            $this->jumlahorder->TooltipValue = "";

            // bonus
            $this->bonus->LinkCustomAttributes = "";
            $this->bonus->HrefValue = "";
            $this->bonus->TooltipValue = "";

            // stockdo
            $this->stockdo->LinkCustomAttributes = "";
            $this->stockdo->HrefValue = "";
            $this->stockdo->TooltipValue = "";

            // jumlahkirim
            $this->jumlahkirim->LinkCustomAttributes = "";
            $this->jumlahkirim->HrefValue = "";
            $this->jumlahkirim->TooltipValue = "";

            // jumlahbonus
            $this->jumlahbonus->LinkCustomAttributes = "";
            $this->jumlahbonus->HrefValue = "";
            $this->jumlahbonus->TooltipValue = "";

            // harga
            $this->harga->LinkCustomAttributes = "";
            $this->harga->HrefValue = "";
            $this->harga->TooltipValue = "";

            // totalnondiskon
            $this->totalnondiskon->LinkCustomAttributes = "";
            $this->totalnondiskon->HrefValue = "";
            $this->totalnondiskon->TooltipValue = "";

            // diskonpayment
            $this->diskonpayment->LinkCustomAttributes = "";
            $this->diskonpayment->HrefValue = "";
            $this->diskonpayment->TooltipValue = "";

            // bbpersen
            $this->bbpersen->LinkCustomAttributes = "";
            $this->bbpersen->HrefValue = "";
            $this->bbpersen->TooltipValue = "";

            // totaltagihan
            $this->totaltagihan->LinkCustomAttributes = "";
            $this->totaltagihan->HrefValue = "";
            $this->totaltagihan->TooltipValue = "";

            // blackbonus
            $this->blackbonus->LinkCustomAttributes = "";
            $this->blackbonus->HrefValue = "";
            $this->blackbonus->TooltipValue = "";

            // readonly
            $this->readonly->LinkCustomAttributes = "";
            $this->readonly->HrefValue = "";
            $this->readonly->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // jumlahorder
            $this->jumlahorder->EditAttrs["class"] = "form-control";
            $this->jumlahorder->EditCustomAttributes = "readonly";
            $this->jumlahorder->EditValue = HtmlEncode($this->jumlahorder->CurrentValue);
            $this->jumlahorder->PlaceHolder = RemoveHtml($this->jumlahorder->caption());

            // bonus
            $this->bonus->EditAttrs["class"] = "form-control";
            $this->bonus->EditCustomAttributes = "readonly";
            $this->bonus->EditValue = HtmlEncode($this->bonus->CurrentValue);
            $this->bonus->PlaceHolder = RemoveHtml($this->bonus->caption());

            // stockdo
            $this->stockdo->EditAttrs["class"] = "form-control";
            $this->stockdo->EditCustomAttributes = "readonly";
            $this->stockdo->EditValue = HtmlEncode($this->stockdo->CurrentValue);
            $this->stockdo->PlaceHolder = RemoveHtml($this->stockdo->caption());

            // jumlahkirim
            $this->jumlahkirim->EditAttrs["class"] = "form-control";
            $this->jumlahkirim->EditCustomAttributes = "";
            $this->jumlahkirim->EditValue = HtmlEncode($this->jumlahkirim->CurrentValue);
            $this->jumlahkirim->PlaceHolder = RemoveHtml($this->jumlahkirim->caption());

            // jumlahbonus
            $this->jumlahbonus->EditAttrs["class"] = "form-control";
            $this->jumlahbonus->EditCustomAttributes = "readonly";
            $this->jumlahbonus->EditValue = HtmlEncode($this->jumlahbonus->CurrentValue);
            $this->jumlahbonus->PlaceHolder = RemoveHtml($this->jumlahbonus->caption());

            // harga
            $this->harga->EditAttrs["class"] = "form-control";
            $this->harga->EditCustomAttributes = "readonly";
            $this->harga->EditValue = HtmlEncode($this->harga->CurrentValue);
            $this->harga->PlaceHolder = RemoveHtml($this->harga->caption());

            // totalnondiskon
            $this->totalnondiskon->EditAttrs["class"] = "form-control";
            $this->totalnondiskon->EditCustomAttributes = "readonly";
            $this->totalnondiskon->EditValue = HtmlEncode($this->totalnondiskon->CurrentValue);
            $this->totalnondiskon->PlaceHolder = RemoveHtml($this->totalnondiskon->caption());

            // diskonpayment
            $this->diskonpayment->EditAttrs["class"] = "form-control";
            $this->diskonpayment->EditCustomAttributes = "";
            $this->diskonpayment->EditValue = HtmlEncode($this->diskonpayment->CurrentValue);
            $this->diskonpayment->PlaceHolder = RemoveHtml($this->diskonpayment->caption());
            if (strval($this->diskonpayment->EditValue) != "" && is_numeric($this->diskonpayment->EditValue)) {
                $this->diskonpayment->EditValue = FormatNumber($this->diskonpayment->EditValue, -2, -2, -2, -2);
            }

            // bbpersen
            $this->bbpersen->EditAttrs["class"] = "form-control";
            $this->bbpersen->EditCustomAttributes = "";
            $this->bbpersen->EditValue = HtmlEncode($this->bbpersen->CurrentValue);
            $this->bbpersen->PlaceHolder = RemoveHtml($this->bbpersen->caption());
            if (strval($this->bbpersen->EditValue) != "" && is_numeric($this->bbpersen->EditValue)) {
                $this->bbpersen->EditValue = FormatNumber($this->bbpersen->EditValue, -2, -2, -2, -2);
            }

            // totaltagihan
            $this->totaltagihan->EditAttrs["class"] = "form-control";
            $this->totaltagihan->EditCustomAttributes = "readonly";
            $this->totaltagihan->EditValue = HtmlEncode($this->totaltagihan->CurrentValue);
            $this->totaltagihan->PlaceHolder = RemoveHtml($this->totaltagihan->caption());

            // blackbonus
            $this->blackbonus->EditAttrs["class"] = "form-control";
            $this->blackbonus->EditCustomAttributes = "readonly";
            $this->blackbonus->EditValue = HtmlEncode($this->blackbonus->CurrentValue);
            $this->blackbonus->PlaceHolder = RemoveHtml($this->blackbonus->caption());

            // readonly
            $this->readonly->EditAttrs["class"] = "form-control";
            $this->readonly->EditCustomAttributes = "";

            // Edit refer script

            // jumlahorder
            $this->jumlahorder->LinkCustomAttributes = "";
            $this->jumlahorder->HrefValue = "";

            // bonus
            $this->bonus->LinkCustomAttributes = "";
            $this->bonus->HrefValue = "";

            // stockdo
            $this->stockdo->LinkCustomAttributes = "";
            $this->stockdo->HrefValue = "";

            // jumlahkirim
            $this->jumlahkirim->LinkCustomAttributes = "";
            $this->jumlahkirim->HrefValue = "";

            // jumlahbonus
            $this->jumlahbonus->LinkCustomAttributes = "";
            $this->jumlahbonus->HrefValue = "";

            // harga
            $this->harga->LinkCustomAttributes = "";
            $this->harga->HrefValue = "";

            // totalnondiskon
            $this->totalnondiskon->LinkCustomAttributes = "";
            $this->totalnondiskon->HrefValue = "";

            // diskonpayment
            $this->diskonpayment->LinkCustomAttributes = "";
            $this->diskonpayment->HrefValue = "";

            // bbpersen
            $this->bbpersen->LinkCustomAttributes = "";
            $this->bbpersen->HrefValue = "";

            // totaltagihan
            $this->totaltagihan->LinkCustomAttributes = "";
            $this->totaltagihan->HrefValue = "";

            // blackbonus
            $this->blackbonus->LinkCustomAttributes = "";
            $this->blackbonus->HrefValue = "";

            // readonly
            $this->readonly->LinkCustomAttributes = "";
            $this->readonly->HrefValue = "";
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
        if ($this->jumlahorder->Required) {
            if (!$this->jumlahorder->IsDetailKey && EmptyValue($this->jumlahorder->FormValue)) {
                $this->jumlahorder->addErrorMessage(str_replace("%s", $this->jumlahorder->caption(), $this->jumlahorder->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->jumlahorder->FormValue)) {
            $this->jumlahorder->addErrorMessage($this->jumlahorder->getErrorMessage(false));
        }
        if ($this->bonus->Required) {
            if (!$this->bonus->IsDetailKey && EmptyValue($this->bonus->FormValue)) {
                $this->bonus->addErrorMessage(str_replace("%s", $this->bonus->caption(), $this->bonus->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->bonus->FormValue)) {
            $this->bonus->addErrorMessage($this->bonus->getErrorMessage(false));
        }
        if ($this->stockdo->Required) {
            if (!$this->stockdo->IsDetailKey && EmptyValue($this->stockdo->FormValue)) {
                $this->stockdo->addErrorMessage(str_replace("%s", $this->stockdo->caption(), $this->stockdo->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->stockdo->FormValue)) {
            $this->stockdo->addErrorMessage($this->stockdo->getErrorMessage(false));
        }
        if ($this->jumlahkirim->Required) {
            if (!$this->jumlahkirim->IsDetailKey && EmptyValue($this->jumlahkirim->FormValue)) {
                $this->jumlahkirim->addErrorMessage(str_replace("%s", $this->jumlahkirim->caption(), $this->jumlahkirim->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->jumlahkirim->FormValue)) {
            $this->jumlahkirim->addErrorMessage($this->jumlahkirim->getErrorMessage(false));
        }
        if ($this->jumlahbonus->Required) {
            if (!$this->jumlahbonus->IsDetailKey && EmptyValue($this->jumlahbonus->FormValue)) {
                $this->jumlahbonus->addErrorMessage(str_replace("%s", $this->jumlahbonus->caption(), $this->jumlahbonus->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->jumlahbonus->FormValue)) {
            $this->jumlahbonus->addErrorMessage($this->jumlahbonus->getErrorMessage(false));
        }
        if ($this->harga->Required) {
            if (!$this->harga->IsDetailKey && EmptyValue($this->harga->FormValue)) {
                $this->harga->addErrorMessage(str_replace("%s", $this->harga->caption(), $this->harga->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->harga->FormValue)) {
            $this->harga->addErrorMessage($this->harga->getErrorMessage(false));
        }
        if ($this->totalnondiskon->Required) {
            if (!$this->totalnondiskon->IsDetailKey && EmptyValue($this->totalnondiskon->FormValue)) {
                $this->totalnondiskon->addErrorMessage(str_replace("%s", $this->totalnondiskon->caption(), $this->totalnondiskon->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->totalnondiskon->FormValue)) {
            $this->totalnondiskon->addErrorMessage($this->totalnondiskon->getErrorMessage(false));
        }
        if ($this->diskonpayment->Required) {
            if (!$this->diskonpayment->IsDetailKey && EmptyValue($this->diskonpayment->FormValue)) {
                $this->diskonpayment->addErrorMessage(str_replace("%s", $this->diskonpayment->caption(), $this->diskonpayment->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->diskonpayment->FormValue)) {
            $this->diskonpayment->addErrorMessage($this->diskonpayment->getErrorMessage(false));
        }
        if ($this->bbpersen->Required) {
            if (!$this->bbpersen->IsDetailKey && EmptyValue($this->bbpersen->FormValue)) {
                $this->bbpersen->addErrorMessage(str_replace("%s", $this->bbpersen->caption(), $this->bbpersen->RequiredErrorMessage));
            }
        }
        if (!CheckNumber($this->bbpersen->FormValue)) {
            $this->bbpersen->addErrorMessage($this->bbpersen->getErrorMessage(false));
        }
        if ($this->totaltagihan->Required) {
            if (!$this->totaltagihan->IsDetailKey && EmptyValue($this->totaltagihan->FormValue)) {
                $this->totaltagihan->addErrorMessage(str_replace("%s", $this->totaltagihan->caption(), $this->totaltagihan->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->totaltagihan->FormValue)) {
            $this->totaltagihan->addErrorMessage($this->totaltagihan->getErrorMessage(false));
        }
        if ($this->blackbonus->Required) {
            if (!$this->blackbonus->IsDetailKey && EmptyValue($this->blackbonus->FormValue)) {
                $this->blackbonus->addErrorMessage(str_replace("%s", $this->blackbonus->caption(), $this->blackbonus->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->blackbonus->FormValue)) {
            $this->blackbonus->addErrorMessage($this->blackbonus->getErrorMessage(false));
        }
        if ($this->readonly->Required) {
            if (!$this->readonly->IsDetailKey && EmptyValue($this->readonly->FormValue)) {
                $this->readonly->addErrorMessage(str_replace("%s", $this->readonly->caption(), $this->readonly->RequiredErrorMessage));
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
            // Save old values
            $this->loadDbValues($rsold);
            $rsnew = [];

            // jumlahorder
            $this->jumlahorder->setDbValueDef($rsnew, $this->jumlahorder->CurrentValue, 0, $this->jumlahorder->ReadOnly);

            // bonus
            $this->bonus->setDbValueDef($rsnew, $this->bonus->CurrentValue, 0, $this->bonus->ReadOnly);

            // stockdo
            $this->stockdo->setDbValueDef($rsnew, $this->stockdo->CurrentValue, 0, $this->stockdo->ReadOnly);

            // jumlahkirim
            $this->jumlahkirim->setDbValueDef($rsnew, $this->jumlahkirim->CurrentValue, 0, $this->jumlahkirim->ReadOnly);

            // jumlahbonus
            $this->jumlahbonus->setDbValueDef($rsnew, $this->jumlahbonus->CurrentValue, 0, $this->jumlahbonus->ReadOnly);

            // harga
            $this->harga->setDbValueDef($rsnew, $this->harga->CurrentValue, 0, $this->harga->ReadOnly);

            // totalnondiskon
            $this->totalnondiskon->setDbValueDef($rsnew, $this->totalnondiskon->CurrentValue, 0, $this->totalnondiskon->ReadOnly);

            // diskonpayment
            $this->diskonpayment->setDbValueDef($rsnew, $this->diskonpayment->CurrentValue, 0, $this->diskonpayment->ReadOnly);

            // bbpersen
            $this->bbpersen->setDbValueDef($rsnew, $this->bbpersen->CurrentValue, 0, $this->bbpersen->ReadOnly);

            // totaltagihan
            $this->totaltagihan->setDbValueDef($rsnew, $this->totaltagihan->CurrentValue, 0, $this->totaltagihan->ReadOnly);

            // blackbonus
            $this->blackbonus->setDbValueDef($rsnew, $this->blackbonus->CurrentValue, 0, $this->blackbonus->ReadOnly);

            // readonly
            $this->readonly->setDbValueDef($rsnew, $this->readonly->CurrentValue, 0, $this->readonly->ReadOnly);

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
            if ($masterTblVar == "invoice") {
                $validMaster = true;
                $masterTbl = Container("invoice");
                if (($parm = Get("fk_id", Get("idinvoice"))) !== null) {
                    $masterTbl->id->setQueryStringValue($parm);
                    $this->idinvoice->setQueryStringValue($masterTbl->id->QueryStringValue);
                    $this->idinvoice->setSessionValue($this->idinvoice->QueryStringValue);
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
            if ($masterTblVar == "invoice") {
                $validMaster = true;
                $masterTbl = Container("invoice");
                if (($parm = Post("fk_id", Post("idinvoice"))) !== null) {
                    $masterTbl->id->setFormValue($parm);
                    $this->idinvoice->setFormValue($masterTbl->id->FormValue);
                    $this->idinvoice->setSessionValue($this->idinvoice->FormValue);
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
            if ($masterTblVar != "invoice") {
                if ($this->idinvoice->CurrentValue == "") {
                    $this->idinvoice->setSessionValue("");
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("InvoiceDetailList"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
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
                case "x_idorder_detail":
                    $lookupFilter = function () {
                        return (CurrentPageID() == "add" || CurrentPageID() == "edit") ? "jumlah > 0" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
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
        return true;
    }
}
