<?php

namespace PHPMaker2021\production2;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class IjinbpomEdit extends Ijinbpom
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'ijinbpom';

    // Page object name
    public $PageObjName = "IjinbpomEdit";

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

        // Table object (ijinbpom)
        if (!isset($GLOBALS["ijinbpom"]) || get_class($GLOBALS["ijinbpom"]) == PROJECT_NAMESPACE . "ijinbpom") {
            $GLOBALS["ijinbpom"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'ijinbpom');
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
                $doc = new $class(Container("ijinbpom"));
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
                    if ($pageName == "IjinbpomView") {
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
        $this->tglterima->setVisibility();
        $this->tglsubmit->setVisibility();
        $this->idpegawai->Visible = false;
        $this->idcustomer->Visible = false;
        $this->idbrand->Visible = false;
        $this->kontrakkerjasama->setVisibility();
        $this->suratkuasa->setVisibility();
        $this->suratpembagian->setVisibility();
        $this->status->setVisibility();
        $this->selesai->Visible = false;
        $this->created_at->Visible = false;
        $this->created_by->Visible = false;
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
        $this->setupLookupOptions($this->idpegawai);
        $this->setupLookupOptions($this->idcustomer);
        $this->setupLookupOptions($this->idbrand);

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
                    $this->terminate("IjinbpomList"); // No matching record, return to list
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
                if (GetPageName($returnUrl) == "IjinbpomList") {
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
        $this->kontrakkerjasama->Upload->Index = $CurrentForm->Index;
        $this->kontrakkerjasama->Upload->uploadFile();
        $this->kontrakkerjasama->CurrentValue = $this->kontrakkerjasama->Upload->FileName;
        $this->suratkuasa->Upload->Index = $CurrentForm->Index;
        $this->suratkuasa->Upload->uploadFile();
        $this->suratkuasa->CurrentValue = $this->suratkuasa->Upload->FileName;
        $this->suratpembagian->Upload->Index = $CurrentForm->Index;
        $this->suratpembagian->Upload->uploadFile();
        $this->suratpembagian->CurrentValue = $this->suratpembagian->Upload->FileName;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'tglterima' first before field var 'x_tglterima'
        $val = $CurrentForm->hasValue("tglterima") ? $CurrentForm->getValue("tglterima") : $CurrentForm->getValue("x_tglterima");
        if (!$this->tglterima->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tglterima->Visible = false; // Disable update for API request
            } else {
                $this->tglterima->setFormValue($val);
            }
            $this->tglterima->CurrentValue = UnFormatDateTime($this->tglterima->CurrentValue, 0);
        }

        // Check field name 'tglsubmit' first before field var 'x_tglsubmit'
        $val = $CurrentForm->hasValue("tglsubmit") ? $CurrentForm->getValue("tglsubmit") : $CurrentForm->getValue("x_tglsubmit");
        if (!$this->tglsubmit->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tglsubmit->Visible = false; // Disable update for API request
            } else {
                $this->tglsubmit->setFormValue($val);
            }
            $this->tglsubmit->CurrentValue = UnFormatDateTime($this->tglsubmit->CurrentValue, 0);
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
        $this->tglterima->CurrentValue = $this->tglterima->FormValue;
        $this->tglterima->CurrentValue = UnFormatDateTime($this->tglterima->CurrentValue, 0);
        $this->tglsubmit->CurrentValue = $this->tglsubmit->FormValue;
        $this->tglsubmit->CurrentValue = UnFormatDateTime($this->tglsubmit->CurrentValue, 0);
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
        $this->tglterima->setDbValue($row['tglterima']);
        $this->tglsubmit->setDbValue($row['tglsubmit']);
        $this->idpegawai->setDbValue($row['idpegawai']);
        $this->idcustomer->setDbValue($row['idcustomer']);
        $this->idbrand->setDbValue($row['idbrand']);
        $this->kontrakkerjasama->Upload->DbValue = $row['kontrakkerjasama'];
        $this->kontrakkerjasama->setDbValue($this->kontrakkerjasama->Upload->DbValue);
        $this->suratkuasa->Upload->DbValue = $row['suratkuasa'];
        $this->suratkuasa->setDbValue($this->suratkuasa->Upload->DbValue);
        $this->suratpembagian->Upload->DbValue = $row['suratpembagian'];
        $this->suratpembagian->setDbValue($this->suratpembagian->Upload->DbValue);
        $this->status->setDbValue($row['status']);
        $this->selesai->setDbValue($row['selesai']);
        $this->created_at->setDbValue($row['created_at']);
        $this->created_by->setDbValue($row['created_by']);
        $this->readonly->setDbValue($row['readonly']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['tglterima'] = null;
        $row['tglsubmit'] = null;
        $row['idpegawai'] = null;
        $row['idcustomer'] = null;
        $row['idbrand'] = null;
        $row['kontrakkerjasama'] = null;
        $row['suratkuasa'] = null;
        $row['suratpembagian'] = null;
        $row['status'] = null;
        $row['selesai'] = null;
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

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id

        // tglterima

        // tglsubmit

        // idpegawai

        // idcustomer

        // idbrand

        // kontrakkerjasama

        // suratkuasa

        // suratpembagian

        // status

        // selesai

        // created_at

        // created_by

        // readonly
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // tglterima
            $this->tglterima->ViewValue = $this->tglterima->CurrentValue;
            $this->tglterima->ViewValue = FormatDateTime($this->tglterima->ViewValue, 0);
            $this->tglterima->ViewCustomAttributes = "";

            // tglsubmit
            $this->tglsubmit->ViewValue = $this->tglsubmit->CurrentValue;
            $this->tglsubmit->ViewValue = FormatDateTime($this->tglsubmit->ViewValue, 0);
            $this->tglsubmit->ViewCustomAttributes = "";

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
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return (CurrentPageID() == "add") ? "`ijinbpom` = 0" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->idbrand->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
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

            // kontrakkerjasama
            if (!EmptyValue($this->kontrakkerjasama->Upload->DbValue)) {
                $this->kontrakkerjasama->ViewValue = $this->kontrakkerjasama->Upload->DbValue;
            } else {
                $this->kontrakkerjasama->ViewValue = "";
            }
            $this->kontrakkerjasama->ViewCustomAttributes = "";

            // suratkuasa
            if (!EmptyValue($this->suratkuasa->Upload->DbValue)) {
                $this->suratkuasa->ViewValue = $this->suratkuasa->Upload->DbValue;
            } else {
                $this->suratkuasa->ViewValue = "";
            }
            $this->suratkuasa->ViewCustomAttributes = "";

            // suratpembagian
            if (!EmptyValue($this->suratpembagian->Upload->DbValue)) {
                $this->suratpembagian->ViewValue = $this->suratpembagian->Upload->DbValue;
            } else {
                $this->suratpembagian->ViewValue = "";
            }
            $this->suratpembagian->ViewCustomAttributes = "";

            // status
            if (strval($this->status->CurrentValue) != "") {
                $this->status->ViewValue = $this->status->optionCaption($this->status->CurrentValue);
            } else {
                $this->status->ViewValue = null;
            }
            $this->status->ViewCustomAttributes = "";

            // selesai
            if (strval($this->selesai->CurrentValue) != "") {
                $this->selesai->ViewValue = $this->selesai->optionCaption($this->selesai->CurrentValue);
            } else {
                $this->selesai->ViewValue = null;
            }
            $this->selesai->ViewCustomAttributes = "";

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

            // tglterima
            $this->tglterima->LinkCustomAttributes = "";
            $this->tglterima->HrefValue = "";
            $this->tglterima->TooltipValue = "";

            // tglsubmit
            $this->tglsubmit->LinkCustomAttributes = "";
            $this->tglsubmit->HrefValue = "";
            $this->tglsubmit->TooltipValue = "";

            // kontrakkerjasama
            $this->kontrakkerjasama->LinkCustomAttributes = "";
            $this->kontrakkerjasama->HrefValue = "";
            $this->kontrakkerjasama->ExportHrefValue = $this->kontrakkerjasama->UploadPath . $this->kontrakkerjasama->Upload->DbValue;
            $this->kontrakkerjasama->TooltipValue = "";

            // suratkuasa
            $this->suratkuasa->LinkCustomAttributes = "";
            $this->suratkuasa->HrefValue = "";
            $this->suratkuasa->ExportHrefValue = $this->suratkuasa->UploadPath . $this->suratkuasa->Upload->DbValue;
            $this->suratkuasa->TooltipValue = "";

            // suratpembagian
            $this->suratpembagian->LinkCustomAttributes = "";
            $this->suratpembagian->HrefValue = "";
            $this->suratpembagian->ExportHrefValue = $this->suratpembagian->UploadPath . $this->suratpembagian->Upload->DbValue;
            $this->suratpembagian->TooltipValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
            $this->status->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // tglterima
            $this->tglterima->EditAttrs["class"] = "form-control";
            $this->tglterima->EditCustomAttributes = "";
            $this->tglterima->EditValue = HtmlEncode(FormatDateTime($this->tglterima->CurrentValue, 8));
            $this->tglterima->PlaceHolder = RemoveHtml($this->tglterima->caption());

            // tglsubmit
            $this->tglsubmit->EditAttrs["class"] = "form-control";
            $this->tglsubmit->EditCustomAttributes = "";
            $this->tglsubmit->EditValue = HtmlEncode(FormatDateTime($this->tglsubmit->CurrentValue, 8));
            $this->tglsubmit->PlaceHolder = RemoveHtml($this->tglsubmit->caption());

            // kontrakkerjasama
            $this->kontrakkerjasama->EditAttrs["class"] = "form-control";
            $this->kontrakkerjasama->EditCustomAttributes = "";
            if (!EmptyValue($this->kontrakkerjasama->Upload->DbValue)) {
                $this->kontrakkerjasama->EditValue = $this->kontrakkerjasama->Upload->DbValue;
            } else {
                $this->kontrakkerjasama->EditValue = "";
            }
            if (!EmptyValue($this->kontrakkerjasama->CurrentValue)) {
                $this->kontrakkerjasama->Upload->FileName = $this->kontrakkerjasama->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->kontrakkerjasama);
            }

            // suratkuasa
            $this->suratkuasa->EditAttrs["class"] = "form-control";
            $this->suratkuasa->EditCustomAttributes = "";
            if (!EmptyValue($this->suratkuasa->Upload->DbValue)) {
                $this->suratkuasa->EditValue = $this->suratkuasa->Upload->DbValue;
            } else {
                $this->suratkuasa->EditValue = "";
            }
            if (!EmptyValue($this->suratkuasa->CurrentValue)) {
                $this->suratkuasa->Upload->FileName = $this->suratkuasa->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->suratkuasa);
            }

            // suratpembagian
            $this->suratpembagian->EditAttrs["class"] = "form-control";
            $this->suratpembagian->EditCustomAttributes = "";
            if (!EmptyValue($this->suratpembagian->Upload->DbValue)) {
                $this->suratpembagian->EditValue = $this->suratpembagian->Upload->DbValue;
            } else {
                $this->suratpembagian->EditValue = "";
            }
            if (!EmptyValue($this->suratpembagian->CurrentValue)) {
                $this->suratpembagian->Upload->FileName = $this->suratpembagian->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->suratpembagian);
            }

            // status
            $this->status->EditAttrs["class"] = "form-control";
            $this->status->EditCustomAttributes = "";
            $this->status->EditValue = $this->status->options(true);
            $this->status->PlaceHolder = RemoveHtml($this->status->caption());

            // Edit refer script

            // tglterima
            $this->tglterima->LinkCustomAttributes = "";
            $this->tglterima->HrefValue = "";

            // tglsubmit
            $this->tglsubmit->LinkCustomAttributes = "";
            $this->tglsubmit->HrefValue = "";

            // kontrakkerjasama
            $this->kontrakkerjasama->LinkCustomAttributes = "";
            $this->kontrakkerjasama->HrefValue = "";
            $this->kontrakkerjasama->ExportHrefValue = $this->kontrakkerjasama->UploadPath . $this->kontrakkerjasama->Upload->DbValue;

            // suratkuasa
            $this->suratkuasa->LinkCustomAttributes = "";
            $this->suratkuasa->HrefValue = "";
            $this->suratkuasa->ExportHrefValue = $this->suratkuasa->UploadPath . $this->suratkuasa->Upload->DbValue;

            // suratpembagian
            $this->suratpembagian->LinkCustomAttributes = "";
            $this->suratpembagian->HrefValue = "";
            $this->suratpembagian->ExportHrefValue = $this->suratpembagian->UploadPath . $this->suratpembagian->Upload->DbValue;

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
        if ($this->tglterima->Required) {
            if (!$this->tglterima->IsDetailKey && EmptyValue($this->tglterima->FormValue)) {
                $this->tglterima->addErrorMessage(str_replace("%s", $this->tglterima->caption(), $this->tglterima->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tglterima->FormValue)) {
            $this->tglterima->addErrorMessage($this->tglterima->getErrorMessage(false));
        }
        if ($this->tglsubmit->Required) {
            if (!$this->tglsubmit->IsDetailKey && EmptyValue($this->tglsubmit->FormValue)) {
                $this->tglsubmit->addErrorMessage(str_replace("%s", $this->tglsubmit->caption(), $this->tglsubmit->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tglsubmit->FormValue)) {
            $this->tglsubmit->addErrorMessage($this->tglsubmit->getErrorMessage(false));
        }
        if ($this->kontrakkerjasama->Required) {
            if ($this->kontrakkerjasama->Upload->FileName == "" && !$this->kontrakkerjasama->Upload->KeepFile) {
                $this->kontrakkerjasama->addErrorMessage(str_replace("%s", $this->kontrakkerjasama->caption(), $this->kontrakkerjasama->RequiredErrorMessage));
            }
        }
        if ($this->suratkuasa->Required) {
            if ($this->suratkuasa->Upload->FileName == "" && !$this->suratkuasa->Upload->KeepFile) {
                $this->suratkuasa->addErrorMessage(str_replace("%s", $this->suratkuasa->caption(), $this->suratkuasa->RequiredErrorMessage));
            }
        }
        if ($this->suratpembagian->Required) {
            if ($this->suratpembagian->Upload->FileName == "" && !$this->suratpembagian->Upload->KeepFile) {
                $this->suratpembagian->addErrorMessage(str_replace("%s", $this->suratpembagian->caption(), $this->suratpembagian->RequiredErrorMessage));
            }
        }
        if ($this->status->Required) {
            if (!$this->status->IsDetailKey && EmptyValue($this->status->FormValue)) {
                $this->status->addErrorMessage(str_replace("%s", $this->status->caption(), $this->status->RequiredErrorMessage));
            }
        }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("IjinbpomDetailGrid");
        if (in_array("ijinbpom_detail", $detailTblVar) && $detailPage->DetailEdit) {
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

            // tglterima
            $this->tglterima->setDbValueDef($rsnew, UnFormatDateTime($this->tglterima->CurrentValue, 0), CurrentDate(), $this->tglterima->ReadOnly);

            // tglsubmit
            $this->tglsubmit->setDbValueDef($rsnew, UnFormatDateTime($this->tglsubmit->CurrentValue, 0), CurrentDate(), $this->tglsubmit->ReadOnly);

            // kontrakkerjasama
            if ($this->kontrakkerjasama->Visible && !$this->kontrakkerjasama->ReadOnly && !$this->kontrakkerjasama->Upload->KeepFile) {
                $this->kontrakkerjasama->Upload->DbValue = $rsold['kontrakkerjasama']; // Get original value
                if ($this->kontrakkerjasama->Upload->FileName == "") {
                    $rsnew['kontrakkerjasama'] = null;
                } else {
                    $rsnew['kontrakkerjasama'] = $this->kontrakkerjasama->Upload->FileName;
                }
            }

            // suratkuasa
            if ($this->suratkuasa->Visible && !$this->suratkuasa->ReadOnly && !$this->suratkuasa->Upload->KeepFile) {
                $this->suratkuasa->Upload->DbValue = $rsold['suratkuasa']; // Get original value
                if ($this->suratkuasa->Upload->FileName == "") {
                    $rsnew['suratkuasa'] = null;
                } else {
                    $rsnew['suratkuasa'] = $this->suratkuasa->Upload->FileName;
                }
            }

            // suratpembagian
            if ($this->suratpembagian->Visible && !$this->suratpembagian->ReadOnly && !$this->suratpembagian->Upload->KeepFile) {
                $this->suratpembagian->Upload->DbValue = $rsold['suratpembagian']; // Get original value
                if ($this->suratpembagian->Upload->FileName == "") {
                    $rsnew['suratpembagian'] = null;
                } else {
                    $rsnew['suratpembagian'] = $this->suratpembagian->Upload->FileName;
                }
            }

            // status
            $this->status->setDbValueDef($rsnew, $this->status->CurrentValue, null, $this->status->ReadOnly);
            if ($this->kontrakkerjasama->Visible && !$this->kontrakkerjasama->Upload->KeepFile) {
                $oldFiles = EmptyValue($this->kontrakkerjasama->Upload->DbValue) ? [] : [$this->kontrakkerjasama->htmlDecode($this->kontrakkerjasama->Upload->DbValue)];
                if (!EmptyValue($this->kontrakkerjasama->Upload->FileName)) {
                    $newFiles = [$this->kontrakkerjasama->Upload->FileName];
                    $NewFileCount = count($newFiles);
                    for ($i = 0; $i < $NewFileCount; $i++) {
                        if ($newFiles[$i] != "") {
                            $file = $newFiles[$i];
                            $tempPath = UploadTempPath($this->kontrakkerjasama, $this->kontrakkerjasama->Upload->Index);
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
                                $file1 = UniqueFilename($this->kontrakkerjasama->physicalUploadPath(), $file); // Get new file name
                                if ($file1 != $file) { // Rename temp file
                                    while (file_exists($tempPath . $file1) || file_exists($this->kontrakkerjasama->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                        $file1 = UniqueFilename([$this->kontrakkerjasama->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                    }
                                    rename($tempPath . $file, $tempPath . $file1);
                                    $newFiles[$i] = $file1;
                                }
                            }
                        }
                    }
                    $this->kontrakkerjasama->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                    $this->kontrakkerjasama->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                    $this->kontrakkerjasama->setDbValueDef($rsnew, $this->kontrakkerjasama->Upload->FileName, null, $this->kontrakkerjasama->ReadOnly);
                }
            }
            if ($this->suratkuasa->Visible && !$this->suratkuasa->Upload->KeepFile) {
                $oldFiles = EmptyValue($this->suratkuasa->Upload->DbValue) ? [] : [$this->suratkuasa->htmlDecode($this->suratkuasa->Upload->DbValue)];
                if (!EmptyValue($this->suratkuasa->Upload->FileName)) {
                    $newFiles = [$this->suratkuasa->Upload->FileName];
                    $NewFileCount = count($newFiles);
                    for ($i = 0; $i < $NewFileCount; $i++) {
                        if ($newFiles[$i] != "") {
                            $file = $newFiles[$i];
                            $tempPath = UploadTempPath($this->suratkuasa, $this->suratkuasa->Upload->Index);
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
                                $file1 = UniqueFilename($this->suratkuasa->physicalUploadPath(), $file); // Get new file name
                                if ($file1 != $file) { // Rename temp file
                                    while (file_exists($tempPath . $file1) || file_exists($this->suratkuasa->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                        $file1 = UniqueFilename([$this->suratkuasa->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                    }
                                    rename($tempPath . $file, $tempPath . $file1);
                                    $newFiles[$i] = $file1;
                                }
                            }
                        }
                    }
                    $this->suratkuasa->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                    $this->suratkuasa->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                    $this->suratkuasa->setDbValueDef($rsnew, $this->suratkuasa->Upload->FileName, null, $this->suratkuasa->ReadOnly);
                }
            }
            if ($this->suratpembagian->Visible && !$this->suratpembagian->Upload->KeepFile) {
                $oldFiles = EmptyValue($this->suratpembagian->Upload->DbValue) ? [] : [$this->suratpembagian->htmlDecode($this->suratpembagian->Upload->DbValue)];
                if (!EmptyValue($this->suratpembagian->Upload->FileName)) {
                    $newFiles = [$this->suratpembagian->Upload->FileName];
                    $NewFileCount = count($newFiles);
                    for ($i = 0; $i < $NewFileCount; $i++) {
                        if ($newFiles[$i] != "") {
                            $file = $newFiles[$i];
                            $tempPath = UploadTempPath($this->suratpembagian, $this->suratpembagian->Upload->Index);
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
                                $file1 = UniqueFilename($this->suratpembagian->physicalUploadPath(), $file); // Get new file name
                                if ($file1 != $file) { // Rename temp file
                                    while (file_exists($tempPath . $file1) || file_exists($this->suratpembagian->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                        $file1 = UniqueFilename([$this->suratpembagian->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                    }
                                    rename($tempPath . $file, $tempPath . $file1);
                                    $newFiles[$i] = $file1;
                                }
                            }
                        }
                    }
                    $this->suratpembagian->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                    $this->suratpembagian->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                    $this->suratpembagian->setDbValueDef($rsnew, $this->suratpembagian->Upload->FileName, null, $this->suratpembagian->ReadOnly);
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
                    if ($this->kontrakkerjasama->Visible && !$this->kontrakkerjasama->Upload->KeepFile) {
                        $oldFiles = EmptyValue($this->kontrakkerjasama->Upload->DbValue) ? [] : [$this->kontrakkerjasama->htmlDecode($this->kontrakkerjasama->Upload->DbValue)];
                        if (!EmptyValue($this->kontrakkerjasama->Upload->FileName)) {
                            $newFiles = [$this->kontrakkerjasama->Upload->FileName];
                            $newFiles2 = [$this->kontrakkerjasama->htmlDecode($rsnew['kontrakkerjasama'])];
                            $newFileCount = count($newFiles);
                            for ($i = 0; $i < $newFileCount; $i++) {
                                if ($newFiles[$i] != "") {
                                    $file = UploadTempPath($this->kontrakkerjasama, $this->kontrakkerjasama->Upload->Index) . $newFiles[$i];
                                    if (file_exists($file)) {
                                        if (@$newFiles2[$i] != "") { // Use correct file name
                                            $newFiles[$i] = $newFiles2[$i];
                                        }
                                        if (!$this->kontrakkerjasama->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
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
                                    @unlink($this->kontrakkerjasama->oldPhysicalUploadPath() . $oldFile);
                                }
                            }
                        }
                    }
                    if ($this->suratkuasa->Visible && !$this->suratkuasa->Upload->KeepFile) {
                        $oldFiles = EmptyValue($this->suratkuasa->Upload->DbValue) ? [] : [$this->suratkuasa->htmlDecode($this->suratkuasa->Upload->DbValue)];
                        if (!EmptyValue($this->suratkuasa->Upload->FileName)) {
                            $newFiles = [$this->suratkuasa->Upload->FileName];
                            $newFiles2 = [$this->suratkuasa->htmlDecode($rsnew['suratkuasa'])];
                            $newFileCount = count($newFiles);
                            for ($i = 0; $i < $newFileCount; $i++) {
                                if ($newFiles[$i] != "") {
                                    $file = UploadTempPath($this->suratkuasa, $this->suratkuasa->Upload->Index) . $newFiles[$i];
                                    if (file_exists($file)) {
                                        if (@$newFiles2[$i] != "") { // Use correct file name
                                            $newFiles[$i] = $newFiles2[$i];
                                        }
                                        if (!$this->suratkuasa->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
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
                                    @unlink($this->suratkuasa->oldPhysicalUploadPath() . $oldFile);
                                }
                            }
                        }
                    }
                    if ($this->suratpembagian->Visible && !$this->suratpembagian->Upload->KeepFile) {
                        $oldFiles = EmptyValue($this->suratpembagian->Upload->DbValue) ? [] : [$this->suratpembagian->htmlDecode($this->suratpembagian->Upload->DbValue)];
                        if (!EmptyValue($this->suratpembagian->Upload->FileName)) {
                            $newFiles = [$this->suratpembagian->Upload->FileName];
                            $newFiles2 = [$this->suratpembagian->htmlDecode($rsnew['suratpembagian'])];
                            $newFileCount = count($newFiles);
                            for ($i = 0; $i < $newFileCount; $i++) {
                                if ($newFiles[$i] != "") {
                                    $file = UploadTempPath($this->suratpembagian, $this->suratpembagian->Upload->Index) . $newFiles[$i];
                                    if (file_exists($file)) {
                                        if (@$newFiles2[$i] != "") { // Use correct file name
                                            $newFiles[$i] = $newFiles2[$i];
                                        }
                                        if (!$this->suratpembagian->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
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
                                    @unlink($this->suratpembagian->oldPhysicalUploadPath() . $oldFile);
                                }
                            }
                        }
                    }
                }

                // Update detail records
                $detailTblVar = explode(",", $this->getCurrentDetailTable());
                if ($editRow) {
                    $detailPage = Container("IjinbpomDetailGrid");
                    if (in_array("ijinbpom_detail", $detailTblVar) && $detailPage->DetailEdit) {
                        $Security->loadCurrentUserLevel($this->ProjectID . "ijinbpom_detail"); // Load user level of detail table
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
            // kontrakkerjasama
            CleanUploadTempPath($this->kontrakkerjasama, $this->kontrakkerjasama->Upload->Index);

            // suratkuasa
            CleanUploadTempPath($this->suratkuasa, $this->suratkuasa->Upload->Index);

            // suratpembagian
            CleanUploadTempPath($this->suratpembagian, $this->suratpembagian->Upload->Index);
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
            if (in_array("ijinbpom_detail", $detailTblVar)) {
                $detailPageObj = Container("IjinbpomDetailGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->idijinbpom->IsDetailKey = true;
                    $detailPageObj->idijinbpom->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->idijinbpom->setSessionValue($detailPageObj->idijinbpom->CurrentValue);
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("IjinbpomList"), "", $this->TableVar, true);
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
                case "x_idpegawai":
                    break;
                case "x_idcustomer":
                    break;
                case "x_idbrand":
                    $lookupFilter = function () {
                        return (CurrentPageID() == "add") ? "`ijinbpom` = 0" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_status":
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
