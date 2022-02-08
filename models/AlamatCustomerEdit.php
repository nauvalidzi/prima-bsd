<?php

namespace PHPMaker2021\production2;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class AlamatCustomerEdit extends AlamatCustomer
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'alamat_customer';

    // Page object name
    public $PageObjName = "AlamatCustomerEdit";

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

        // Table object (alamat_customer)
        if (!isset($GLOBALS["alamat_customer"]) || get_class($GLOBALS["alamat_customer"]) == PROJECT_NAMESPACE . "alamat_customer") {
            $GLOBALS["alamat_customer"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'alamat_customer');
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
                $doc = new $class(Container("alamat_customer"));
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
                    if ($pageName == "AlamatCustomerView") {
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
        $this->idcustomer->Visible = false;
        $this->alias->setVisibility();
        $this->penerima->setVisibility();
        $this->telepon->setVisibility();
        $this->alamat->setVisibility();
        $this->idprovinsi->setVisibility();
        $this->idkabupaten->setVisibility();
        $this->idkecamatan->setVisibility();
        $this->idkelurahan->setVisibility();
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
        $this->setupLookupOptions($this->idcustomer);
        $this->setupLookupOptions($this->idprovinsi);
        $this->setupLookupOptions($this->idkabupaten);
        $this->setupLookupOptions($this->idkecamatan);
        $this->setupLookupOptions($this->idkelurahan);

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
                    $this->terminate("AlamatCustomerList"); // No matching record, return to list
                    return;
                }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "AlamatCustomerList") {
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

        // Check field name 'alias' first before field var 'x_alias'
        $val = $CurrentForm->hasValue("alias") ? $CurrentForm->getValue("alias") : $CurrentForm->getValue("x_alias");
        if (!$this->alias->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->alias->Visible = false; // Disable update for API request
            } else {
                $this->alias->setFormValue($val);
            }
        }

        // Check field name 'penerima' first before field var 'x_penerima'
        $val = $CurrentForm->hasValue("penerima") ? $CurrentForm->getValue("penerima") : $CurrentForm->getValue("x_penerima");
        if (!$this->penerima->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->penerima->Visible = false; // Disable update for API request
            } else {
                $this->penerima->setFormValue($val);
            }
        }

        // Check field name 'telepon' first before field var 'x_telepon'
        $val = $CurrentForm->hasValue("telepon") ? $CurrentForm->getValue("telepon") : $CurrentForm->getValue("x_telepon");
        if (!$this->telepon->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->telepon->Visible = false; // Disable update for API request
            } else {
                $this->telepon->setFormValue($val);
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

        // Check field name 'idprovinsi' first before field var 'x_idprovinsi'
        $val = $CurrentForm->hasValue("idprovinsi") ? $CurrentForm->getValue("idprovinsi") : $CurrentForm->getValue("x_idprovinsi");
        if (!$this->idprovinsi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idprovinsi->Visible = false; // Disable update for API request
            } else {
                $this->idprovinsi->setFormValue($val);
            }
        }

        // Check field name 'idkabupaten' first before field var 'x_idkabupaten'
        $val = $CurrentForm->hasValue("idkabupaten") ? $CurrentForm->getValue("idkabupaten") : $CurrentForm->getValue("x_idkabupaten");
        if (!$this->idkabupaten->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idkabupaten->Visible = false; // Disable update for API request
            } else {
                $this->idkabupaten->setFormValue($val);
            }
        }

        // Check field name 'idkecamatan' first before field var 'x_idkecamatan'
        $val = $CurrentForm->hasValue("idkecamatan") ? $CurrentForm->getValue("idkecamatan") : $CurrentForm->getValue("x_idkecamatan");
        if (!$this->idkecamatan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idkecamatan->Visible = false; // Disable update for API request
            } else {
                $this->idkecamatan->setFormValue($val);
            }
        }

        // Check field name 'idkelurahan' first before field var 'x_idkelurahan'
        $val = $CurrentForm->hasValue("idkelurahan") ? $CurrentForm->getValue("idkelurahan") : $CurrentForm->getValue("x_idkelurahan");
        if (!$this->idkelurahan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idkelurahan->Visible = false; // Disable update for API request
            } else {
                $this->idkelurahan->setFormValue($val);
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
        $this->alias->CurrentValue = $this->alias->FormValue;
        $this->penerima->CurrentValue = $this->penerima->FormValue;
        $this->telepon->CurrentValue = $this->telepon->FormValue;
        $this->alamat->CurrentValue = $this->alamat->FormValue;
        $this->idprovinsi->CurrentValue = $this->idprovinsi->FormValue;
        $this->idkabupaten->CurrentValue = $this->idkabupaten->FormValue;
        $this->idkecamatan->CurrentValue = $this->idkecamatan->FormValue;
        $this->idkelurahan->CurrentValue = $this->idkelurahan->FormValue;
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
        $this->idcustomer->setDbValue($row['idcustomer']);
        $this->alias->setDbValue($row['alias']);
        $this->penerima->setDbValue($row['penerima']);
        $this->telepon->setDbValue($row['telepon']);
        $this->alamat->setDbValue($row['alamat']);
        $this->idprovinsi->setDbValue($row['idprovinsi']);
        $this->idkabupaten->setDbValue($row['idkabupaten']);
        $this->idkecamatan->setDbValue($row['idkecamatan']);
        $this->idkelurahan->setDbValue($row['idkelurahan']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['idcustomer'] = null;
        $row['alias'] = null;
        $row['penerima'] = null;
        $row['telepon'] = null;
        $row['alamat'] = null;
        $row['idprovinsi'] = null;
        $row['idkabupaten'] = null;
        $row['idkecamatan'] = null;
        $row['idkelurahan'] = null;
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

        // idcustomer

        // alias

        // penerima

        // telepon

        // alamat

        // idprovinsi

        // idkabupaten

        // idkecamatan

        // idkelurahan
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

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

            // alias
            $this->alias->ViewValue = $this->alias->CurrentValue;
            $this->alias->ViewCustomAttributes = "";

            // penerima
            $this->penerima->ViewValue = $this->penerima->CurrentValue;
            $this->penerima->ViewCustomAttributes = "";

            // telepon
            $this->telepon->ViewValue = $this->telepon->CurrentValue;
            $this->telepon->ViewCustomAttributes = "";

            // alamat
            $this->alamat->ViewValue = $this->alamat->CurrentValue;
            $this->alamat->ViewCustomAttributes = "";

            // idprovinsi
            $curVal = trim(strval($this->idprovinsi->CurrentValue));
            if ($curVal != "") {
                $this->idprovinsi->ViewValue = $this->idprovinsi->lookupCacheOption($curVal);
                if ($this->idprovinsi->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->idprovinsi->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idprovinsi->Lookup->renderViewRow($rswrk[0]);
                        $this->idprovinsi->ViewValue = $this->idprovinsi->displayValue($arwrk);
                    } else {
                        $this->idprovinsi->ViewValue = $this->idprovinsi->CurrentValue;
                    }
                }
            } else {
                $this->idprovinsi->ViewValue = null;
            }
            $this->idprovinsi->ViewCustomAttributes = "";

            // idkabupaten
            $curVal = trim(strval($this->idkabupaten->CurrentValue));
            if ($curVal != "") {
                $this->idkabupaten->ViewValue = $this->idkabupaten->lookupCacheOption($curVal);
                if ($this->idkabupaten->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->idkabupaten->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idkabupaten->Lookup->renderViewRow($rswrk[0]);
                        $this->idkabupaten->ViewValue = $this->idkabupaten->displayValue($arwrk);
                    } else {
                        $this->idkabupaten->ViewValue = $this->idkabupaten->CurrentValue;
                    }
                }
            } else {
                $this->idkabupaten->ViewValue = null;
            }
            $this->idkabupaten->ViewCustomAttributes = "";

            // idkecamatan
            $curVal = trim(strval($this->idkecamatan->CurrentValue));
            if ($curVal != "") {
                $this->idkecamatan->ViewValue = $this->idkecamatan->lookupCacheOption($curVal);
                if ($this->idkecamatan->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->idkecamatan->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idkecamatan->Lookup->renderViewRow($rswrk[0]);
                        $this->idkecamatan->ViewValue = $this->idkecamatan->displayValue($arwrk);
                    } else {
                        $this->idkecamatan->ViewValue = $this->idkecamatan->CurrentValue;
                    }
                }
            } else {
                $this->idkecamatan->ViewValue = null;
            }
            $this->idkecamatan->ViewCustomAttributes = "";

            // idkelurahan
            $curVal = trim(strval($this->idkelurahan->CurrentValue));
            if ($curVal != "") {
                $this->idkelurahan->ViewValue = $this->idkelurahan->lookupCacheOption($curVal);
                if ($this->idkelurahan->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->idkelurahan->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idkelurahan->Lookup->renderViewRow($rswrk[0]);
                        $this->idkelurahan->ViewValue = $this->idkelurahan->displayValue($arwrk);
                    } else {
                        $this->idkelurahan->ViewValue = $this->idkelurahan->CurrentValue;
                    }
                }
            } else {
                $this->idkelurahan->ViewValue = null;
            }
            $this->idkelurahan->ViewCustomAttributes = "";

            // alias
            $this->alias->LinkCustomAttributes = "";
            $this->alias->HrefValue = "";
            $this->alias->TooltipValue = "";

            // penerima
            $this->penerima->LinkCustomAttributes = "";
            $this->penerima->HrefValue = "";
            $this->penerima->TooltipValue = "";

            // telepon
            $this->telepon->LinkCustomAttributes = "";
            $this->telepon->HrefValue = "";
            $this->telepon->TooltipValue = "";

            // alamat
            $this->alamat->LinkCustomAttributes = "";
            $this->alamat->HrefValue = "";
            $this->alamat->TooltipValue = "";

            // idprovinsi
            $this->idprovinsi->LinkCustomAttributes = "";
            $this->idprovinsi->HrefValue = "";
            $this->idprovinsi->TooltipValue = "";

            // idkabupaten
            $this->idkabupaten->LinkCustomAttributes = "";
            $this->idkabupaten->HrefValue = "";
            $this->idkabupaten->TooltipValue = "";

            // idkecamatan
            $this->idkecamatan->LinkCustomAttributes = "";
            $this->idkecamatan->HrefValue = "";
            $this->idkecamatan->TooltipValue = "";

            // idkelurahan
            $this->idkelurahan->LinkCustomAttributes = "";
            $this->idkelurahan->HrefValue = "";
            $this->idkelurahan->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // alias
            $this->alias->EditAttrs["class"] = "form-control";
            $this->alias->EditCustomAttributes = "";
            if (!$this->alias->Raw) {
                $this->alias->CurrentValue = HtmlDecode($this->alias->CurrentValue);
            }
            $this->alias->EditValue = HtmlEncode($this->alias->CurrentValue);
            $this->alias->PlaceHolder = RemoveHtml($this->alias->caption());

            // penerima
            $this->penerima->EditAttrs["class"] = "form-control";
            $this->penerima->EditCustomAttributes = "";
            if (!$this->penerima->Raw) {
                $this->penerima->CurrentValue = HtmlDecode($this->penerima->CurrentValue);
            }
            $this->penerima->EditValue = HtmlEncode($this->penerima->CurrentValue);
            $this->penerima->PlaceHolder = RemoveHtml($this->penerima->caption());

            // telepon
            $this->telepon->EditAttrs["class"] = "form-control";
            $this->telepon->EditCustomAttributes = "";
            if (!$this->telepon->Raw) {
                $this->telepon->CurrentValue = HtmlDecode($this->telepon->CurrentValue);
            }
            $this->telepon->EditValue = HtmlEncode($this->telepon->CurrentValue);
            $this->telepon->PlaceHolder = RemoveHtml($this->telepon->caption());

            // alamat
            $this->alamat->EditAttrs["class"] = "form-control";
            $this->alamat->EditCustomAttributes = "";
            $this->alamat->EditValue = HtmlEncode($this->alamat->CurrentValue);
            $this->alamat->PlaceHolder = RemoveHtml($this->alamat->caption());

            // idprovinsi
            $this->idprovinsi->EditAttrs["class"] = "form-control";
            $this->idprovinsi->EditCustomAttributes = "";
            $curVal = trim(strval($this->idprovinsi->CurrentValue));
            if ($curVal != "") {
                $this->idprovinsi->ViewValue = $this->idprovinsi->lookupCacheOption($curVal);
            } else {
                $this->idprovinsi->ViewValue = $this->idprovinsi->Lookup !== null && is_array($this->idprovinsi->Lookup->Options) ? $curVal : null;
            }
            if ($this->idprovinsi->ViewValue !== null) { // Load from cache
                $this->idprovinsi->EditValue = array_values($this->idprovinsi->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idprovinsi->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->idprovinsi->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idprovinsi->EditValue = $arwrk;
            }
            $this->idprovinsi->PlaceHolder = RemoveHtml($this->idprovinsi->caption());

            // idkabupaten
            $this->idkabupaten->EditAttrs["class"] = "form-control";
            $this->idkabupaten->EditCustomAttributes = "";
            $curVal = trim(strval($this->idkabupaten->CurrentValue));
            if ($curVal != "") {
                $this->idkabupaten->ViewValue = $this->idkabupaten->lookupCacheOption($curVal);
            } else {
                $this->idkabupaten->ViewValue = $this->idkabupaten->Lookup !== null && is_array($this->idkabupaten->Lookup->Options) ? $curVal : null;
            }
            if ($this->idkabupaten->ViewValue !== null) { // Load from cache
                $this->idkabupaten->EditValue = array_values($this->idkabupaten->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idkabupaten->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->idkabupaten->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idkabupaten->EditValue = $arwrk;
            }
            $this->idkabupaten->PlaceHolder = RemoveHtml($this->idkabupaten->caption());

            // idkecamatan
            $this->idkecamatan->EditAttrs["class"] = "form-control";
            $this->idkecamatan->EditCustomAttributes = "";
            $curVal = trim(strval($this->idkecamatan->CurrentValue));
            if ($curVal != "") {
                $this->idkecamatan->ViewValue = $this->idkecamatan->lookupCacheOption($curVal);
            } else {
                $this->idkecamatan->ViewValue = $this->idkecamatan->Lookup !== null && is_array($this->idkecamatan->Lookup->Options) ? $curVal : null;
            }
            if ($this->idkecamatan->ViewValue !== null) { // Load from cache
                $this->idkecamatan->EditValue = array_values($this->idkecamatan->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idkecamatan->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->idkecamatan->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idkecamatan->EditValue = $arwrk;
            }
            $this->idkecamatan->PlaceHolder = RemoveHtml($this->idkecamatan->caption());

            // idkelurahan
            $this->idkelurahan->EditAttrs["class"] = "form-control";
            $this->idkelurahan->EditCustomAttributes = "";
            $curVal = trim(strval($this->idkelurahan->CurrentValue));
            if ($curVal != "") {
                $this->idkelurahan->ViewValue = $this->idkelurahan->lookupCacheOption($curVal);
            } else {
                $this->idkelurahan->ViewValue = $this->idkelurahan->Lookup !== null && is_array($this->idkelurahan->Lookup->Options) ? $curVal : null;
            }
            if ($this->idkelurahan->ViewValue !== null) { // Load from cache
                $this->idkelurahan->EditValue = array_values($this->idkelurahan->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->idkelurahan->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->idkelurahan->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->idkelurahan->EditValue = $arwrk;
            }
            $this->idkelurahan->PlaceHolder = RemoveHtml($this->idkelurahan->caption());

            // Edit refer script

            // alias
            $this->alias->LinkCustomAttributes = "";
            $this->alias->HrefValue = "";

            // penerima
            $this->penerima->LinkCustomAttributes = "";
            $this->penerima->HrefValue = "";

            // telepon
            $this->telepon->LinkCustomAttributes = "";
            $this->telepon->HrefValue = "";

            // alamat
            $this->alamat->LinkCustomAttributes = "";
            $this->alamat->HrefValue = "";

            // idprovinsi
            $this->idprovinsi->LinkCustomAttributes = "";
            $this->idprovinsi->HrefValue = "";

            // idkabupaten
            $this->idkabupaten->LinkCustomAttributes = "";
            $this->idkabupaten->HrefValue = "";

            // idkecamatan
            $this->idkecamatan->LinkCustomAttributes = "";
            $this->idkecamatan->HrefValue = "";

            // idkelurahan
            $this->idkelurahan->LinkCustomAttributes = "";
            $this->idkelurahan->HrefValue = "";
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
        if ($this->alias->Required) {
            if (!$this->alias->IsDetailKey && EmptyValue($this->alias->FormValue)) {
                $this->alias->addErrorMessage(str_replace("%s", $this->alias->caption(), $this->alias->RequiredErrorMessage));
            }
        }
        if ($this->penerima->Required) {
            if (!$this->penerima->IsDetailKey && EmptyValue($this->penerima->FormValue)) {
                $this->penerima->addErrorMessage(str_replace("%s", $this->penerima->caption(), $this->penerima->RequiredErrorMessage));
            }
        }
        if ($this->telepon->Required) {
            if (!$this->telepon->IsDetailKey && EmptyValue($this->telepon->FormValue)) {
                $this->telepon->addErrorMessage(str_replace("%s", $this->telepon->caption(), $this->telepon->RequiredErrorMessage));
            }
        }
        if ($this->alamat->Required) {
            if (!$this->alamat->IsDetailKey && EmptyValue($this->alamat->FormValue)) {
                $this->alamat->addErrorMessage(str_replace("%s", $this->alamat->caption(), $this->alamat->RequiredErrorMessage));
            }
        }
        if ($this->idprovinsi->Required) {
            if (!$this->idprovinsi->IsDetailKey && EmptyValue($this->idprovinsi->FormValue)) {
                $this->idprovinsi->addErrorMessage(str_replace("%s", $this->idprovinsi->caption(), $this->idprovinsi->RequiredErrorMessage));
            }
        }
        if ($this->idkabupaten->Required) {
            if (!$this->idkabupaten->IsDetailKey && EmptyValue($this->idkabupaten->FormValue)) {
                $this->idkabupaten->addErrorMessage(str_replace("%s", $this->idkabupaten->caption(), $this->idkabupaten->RequiredErrorMessage));
            }
        }
        if ($this->idkecamatan->Required) {
            if (!$this->idkecamatan->IsDetailKey && EmptyValue($this->idkecamatan->FormValue)) {
                $this->idkecamatan->addErrorMessage(str_replace("%s", $this->idkecamatan->caption(), $this->idkecamatan->RequiredErrorMessage));
            }
        }
        if ($this->idkelurahan->Required) {
            if (!$this->idkelurahan->IsDetailKey && EmptyValue($this->idkelurahan->FormValue)) {
                $this->idkelurahan->addErrorMessage(str_replace("%s", $this->idkelurahan->caption(), $this->idkelurahan->RequiredErrorMessage));
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

            // alias
            $this->alias->setDbValueDef($rsnew, $this->alias->CurrentValue, "", $this->alias->ReadOnly);

            // penerima
            $this->penerima->setDbValueDef($rsnew, $this->penerima->CurrentValue, "", $this->penerima->ReadOnly);

            // telepon
            $this->telepon->setDbValueDef($rsnew, $this->telepon->CurrentValue, "", $this->telepon->ReadOnly);

            // alamat
            $this->alamat->setDbValueDef($rsnew, $this->alamat->CurrentValue, null, $this->alamat->ReadOnly);

            // idprovinsi
            $this->idprovinsi->setDbValueDef($rsnew, $this->idprovinsi->CurrentValue, null, $this->idprovinsi->ReadOnly);

            // idkabupaten
            $this->idkabupaten->setDbValueDef($rsnew, $this->idkabupaten->CurrentValue, null, $this->idkabupaten->ReadOnly);

            // idkecamatan
            $this->idkecamatan->setDbValueDef($rsnew, $this->idkecamatan->CurrentValue, null, $this->idkecamatan->ReadOnly);

            // idkelurahan
            $this->idkelurahan->setDbValueDef($rsnew, $this->idkelurahan->CurrentValue, null, $this->idkelurahan->ReadOnly);

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
            if ($masterTblVar == "customer") {
                $validMaster = true;
                $masterTbl = Container("customer");
                if (($parm = Get("fk_id", Get("idcustomer"))) !== null) {
                    $masterTbl->id->setQueryStringValue($parm);
                    $this->idcustomer->setQueryStringValue($masterTbl->id->QueryStringValue);
                    $this->idcustomer->setSessionValue($this->idcustomer->QueryStringValue);
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
            if ($masterTblVar == "customer") {
                $validMaster = true;
                $masterTbl = Container("customer");
                if (($parm = Post("fk_id", Post("idcustomer"))) !== null) {
                    $masterTbl->id->setFormValue($parm);
                    $this->idcustomer->setFormValue($masterTbl->id->FormValue);
                    $this->idcustomer->setSessionValue($this->idcustomer->FormValue);
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
            if ($masterTblVar != "customer") {
                if ($this->idcustomer->CurrentValue == "") {
                    $this->idcustomer->setSessionValue("");
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("AlamatCustomerList"), "", $this->TableVar, true);
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
                case "x_idcustomer":
                    break;
                case "x_idprovinsi":
                    break;
                case "x_idkabupaten":
                    break;
                case "x_idkecamatan":
                    break;
                case "x_idkelurahan":
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
