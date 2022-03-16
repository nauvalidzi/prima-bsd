<?php

namespace PHPMaker2021\production2;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class NpdConfirmprintEdit extends NpdConfirmprint
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'npd_confirmprint';

    // Page object name
    public $PageObjName = "NpdConfirmprintEdit";

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

        // Table object (npd_confirmprint)
        if (!isset($GLOBALS["npd_confirmprint"]) || get_class($GLOBALS["npd_confirmprint"]) == PROJECT_NAMESPACE . "npd_confirmprint") {
            $GLOBALS["npd_confirmprint"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'npd_confirmprint');
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
                $doc = new $class(Container("npd_confirmprint"));
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
                    if ($pageName == "NpdConfirmprintView") {
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
        $this->id->setVisibility();
        $this->idnpd->setVisibility();
        $this->tglterima->setVisibility();
        $this->tglsubmit->setVisibility();
        $this->brand->setVisibility();
        $this->tglkirimprimer->setVisibility();
        $this->tgldisetujuiprimer->setVisibility();
        $this->desainprimer->setVisibility();
        $this->materialprimer->setVisibility();
        $this->aplikasiprimer->setVisibility();
        $this->jumlahcetakprimer->setVisibility();
        $this->tglkirimsekunder->setVisibility();
        $this->tgldisetujuisekunder->setVisibility();
        $this->desainsekunder->setVisibility();
        $this->materialsekunder->setVisibility();
        $this->aplikasisekunder->setVisibility();
        $this->jumlahcetaksekunder->setVisibility();
        $this->submitted_by->setVisibility();
        $this->checked_by->setVisibility();
        $this->approved_by->setVisibility();
        $this->created_at->setVisibility();
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
        $this->setupLookupOptions($this->checked_by);
        $this->setupLookupOptions($this->approved_by);

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
                    $this->terminate("NpdConfirmprintList"); // No matching record, return to list
                    return;
                }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "NpdConfirmprintList") {
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

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        if (!$this->id->IsDetailKey) {
            $this->id->setFormValue($val);
        }

        // Check field name 'idnpd' first before field var 'x_idnpd'
        $val = $CurrentForm->hasValue("idnpd") ? $CurrentForm->getValue("idnpd") : $CurrentForm->getValue("x_idnpd");
        if (!$this->idnpd->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idnpd->Visible = false; // Disable update for API request
            } else {
                $this->idnpd->setFormValue($val);
            }
        }

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

        // Check field name 'brand' first before field var 'x_brand'
        $val = $CurrentForm->hasValue("brand") ? $CurrentForm->getValue("brand") : $CurrentForm->getValue("x_brand");
        if (!$this->brand->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->brand->Visible = false; // Disable update for API request
            } else {
                $this->brand->setFormValue($val);
            }
        }

        // Check field name 'tglkirimprimer' first before field var 'x_tglkirimprimer'
        $val = $CurrentForm->hasValue("tglkirimprimer") ? $CurrentForm->getValue("tglkirimprimer") : $CurrentForm->getValue("x_tglkirimprimer");
        if (!$this->tglkirimprimer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tglkirimprimer->Visible = false; // Disable update for API request
            } else {
                $this->tglkirimprimer->setFormValue($val);
            }
            $this->tglkirimprimer->CurrentValue = UnFormatDateTime($this->tglkirimprimer->CurrentValue, 0);
        }

        // Check field name 'tgldisetujuiprimer' first before field var 'x_tgldisetujuiprimer'
        $val = $CurrentForm->hasValue("tgldisetujuiprimer") ? $CurrentForm->getValue("tgldisetujuiprimer") : $CurrentForm->getValue("x_tgldisetujuiprimer");
        if (!$this->tgldisetujuiprimer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tgldisetujuiprimer->Visible = false; // Disable update for API request
            } else {
                $this->tgldisetujuiprimer->setFormValue($val);
            }
            $this->tgldisetujuiprimer->CurrentValue = UnFormatDateTime($this->tgldisetujuiprimer->CurrentValue, 0);
        }

        // Check field name 'desainprimer' first before field var 'x_desainprimer'
        $val = $CurrentForm->hasValue("desainprimer") ? $CurrentForm->getValue("desainprimer") : $CurrentForm->getValue("x_desainprimer");
        if (!$this->desainprimer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->desainprimer->Visible = false; // Disable update for API request
            } else {
                $this->desainprimer->setFormValue($val);
            }
        }

        // Check field name 'materialprimer' first before field var 'x_materialprimer'
        $val = $CurrentForm->hasValue("materialprimer") ? $CurrentForm->getValue("materialprimer") : $CurrentForm->getValue("x_materialprimer");
        if (!$this->materialprimer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->materialprimer->Visible = false; // Disable update for API request
            } else {
                $this->materialprimer->setFormValue($val);
            }
        }

        // Check field name 'aplikasiprimer' first before field var 'x_aplikasiprimer'
        $val = $CurrentForm->hasValue("aplikasiprimer") ? $CurrentForm->getValue("aplikasiprimer") : $CurrentForm->getValue("x_aplikasiprimer");
        if (!$this->aplikasiprimer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->aplikasiprimer->Visible = false; // Disable update for API request
            } else {
                $this->aplikasiprimer->setFormValue($val);
            }
        }

        // Check field name 'jumlahcetakprimer' first before field var 'x_jumlahcetakprimer'
        $val = $CurrentForm->hasValue("jumlahcetakprimer") ? $CurrentForm->getValue("jumlahcetakprimer") : $CurrentForm->getValue("x_jumlahcetakprimer");
        if (!$this->jumlahcetakprimer->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jumlahcetakprimer->Visible = false; // Disable update for API request
            } else {
                $this->jumlahcetakprimer->setFormValue($val);
            }
        }

        // Check field name 'tglkirimsekunder' first before field var 'x_tglkirimsekunder'
        $val = $CurrentForm->hasValue("tglkirimsekunder") ? $CurrentForm->getValue("tglkirimsekunder") : $CurrentForm->getValue("x_tglkirimsekunder");
        if (!$this->tglkirimsekunder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tglkirimsekunder->Visible = false; // Disable update for API request
            } else {
                $this->tglkirimsekunder->setFormValue($val);
            }
            $this->tglkirimsekunder->CurrentValue = UnFormatDateTime($this->tglkirimsekunder->CurrentValue, 0);
        }

        // Check field name 'tgldisetujuisekunder' first before field var 'x_tgldisetujuisekunder'
        $val = $CurrentForm->hasValue("tgldisetujuisekunder") ? $CurrentForm->getValue("tgldisetujuisekunder") : $CurrentForm->getValue("x_tgldisetujuisekunder");
        if (!$this->tgldisetujuisekunder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tgldisetujuisekunder->Visible = false; // Disable update for API request
            } else {
                $this->tgldisetujuisekunder->setFormValue($val);
            }
            $this->tgldisetujuisekunder->CurrentValue = UnFormatDateTime($this->tgldisetujuisekunder->CurrentValue, 0);
        }

        // Check field name 'desainsekunder' first before field var 'x_desainsekunder'
        $val = $CurrentForm->hasValue("desainsekunder") ? $CurrentForm->getValue("desainsekunder") : $CurrentForm->getValue("x_desainsekunder");
        if (!$this->desainsekunder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->desainsekunder->Visible = false; // Disable update for API request
            } else {
                $this->desainsekunder->setFormValue($val);
            }
        }

        // Check field name 'materialsekunder' first before field var 'x_materialsekunder'
        $val = $CurrentForm->hasValue("materialsekunder") ? $CurrentForm->getValue("materialsekunder") : $CurrentForm->getValue("x_materialsekunder");
        if (!$this->materialsekunder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->materialsekunder->Visible = false; // Disable update for API request
            } else {
                $this->materialsekunder->setFormValue($val);
            }
        }

        // Check field name 'aplikasisekunder' first before field var 'x_aplikasisekunder'
        $val = $CurrentForm->hasValue("aplikasisekunder") ? $CurrentForm->getValue("aplikasisekunder") : $CurrentForm->getValue("x_aplikasisekunder");
        if (!$this->aplikasisekunder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->aplikasisekunder->Visible = false; // Disable update for API request
            } else {
                $this->aplikasisekunder->setFormValue($val);
            }
        }

        // Check field name 'jumlahcetaksekunder' first before field var 'x_jumlahcetaksekunder'
        $val = $CurrentForm->hasValue("jumlahcetaksekunder") ? $CurrentForm->getValue("jumlahcetaksekunder") : $CurrentForm->getValue("x_jumlahcetaksekunder");
        if (!$this->jumlahcetaksekunder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jumlahcetaksekunder->Visible = false; // Disable update for API request
            } else {
                $this->jumlahcetaksekunder->setFormValue($val);
            }
        }

        // Check field name 'submitted_by' first before field var 'x_submitted_by'
        $val = $CurrentForm->hasValue("submitted_by") ? $CurrentForm->getValue("submitted_by") : $CurrentForm->getValue("x_submitted_by");
        if (!$this->submitted_by->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->submitted_by->Visible = false; // Disable update for API request
            } else {
                $this->submitted_by->setFormValue($val);
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

        // Check field name 'created_at' first before field var 'x_created_at'
        $val = $CurrentForm->hasValue("created_at") ? $CurrentForm->getValue("created_at") : $CurrentForm->getValue("x_created_at");
        if (!$this->created_at->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->created_at->Visible = false; // Disable update for API request
            } else {
                $this->created_at->setFormValue($val);
            }
            $this->created_at->CurrentValue = UnFormatDateTime($this->created_at->CurrentValue, 0);
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
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id->CurrentValue = $this->id->FormValue;
        $this->idnpd->CurrentValue = $this->idnpd->FormValue;
        $this->tglterima->CurrentValue = $this->tglterima->FormValue;
        $this->tglterima->CurrentValue = UnFormatDateTime($this->tglterima->CurrentValue, 0);
        $this->tglsubmit->CurrentValue = $this->tglsubmit->FormValue;
        $this->tglsubmit->CurrentValue = UnFormatDateTime($this->tglsubmit->CurrentValue, 0);
        $this->brand->CurrentValue = $this->brand->FormValue;
        $this->tglkirimprimer->CurrentValue = $this->tglkirimprimer->FormValue;
        $this->tglkirimprimer->CurrentValue = UnFormatDateTime($this->tglkirimprimer->CurrentValue, 0);
        $this->tgldisetujuiprimer->CurrentValue = $this->tgldisetujuiprimer->FormValue;
        $this->tgldisetujuiprimer->CurrentValue = UnFormatDateTime($this->tgldisetujuiprimer->CurrentValue, 0);
        $this->desainprimer->CurrentValue = $this->desainprimer->FormValue;
        $this->materialprimer->CurrentValue = $this->materialprimer->FormValue;
        $this->aplikasiprimer->CurrentValue = $this->aplikasiprimer->FormValue;
        $this->jumlahcetakprimer->CurrentValue = $this->jumlahcetakprimer->FormValue;
        $this->tglkirimsekunder->CurrentValue = $this->tglkirimsekunder->FormValue;
        $this->tglkirimsekunder->CurrentValue = UnFormatDateTime($this->tglkirimsekunder->CurrentValue, 0);
        $this->tgldisetujuisekunder->CurrentValue = $this->tgldisetujuisekunder->FormValue;
        $this->tgldisetujuisekunder->CurrentValue = UnFormatDateTime($this->tgldisetujuisekunder->CurrentValue, 0);
        $this->desainsekunder->CurrentValue = $this->desainsekunder->FormValue;
        $this->materialsekunder->CurrentValue = $this->materialsekunder->FormValue;
        $this->aplikasisekunder->CurrentValue = $this->aplikasisekunder->FormValue;
        $this->jumlahcetaksekunder->CurrentValue = $this->jumlahcetaksekunder->FormValue;
        $this->submitted_by->CurrentValue = $this->submitted_by->FormValue;
        $this->checked_by->CurrentValue = $this->checked_by->FormValue;
        $this->approved_by->CurrentValue = $this->approved_by->FormValue;
        $this->created_at->CurrentValue = $this->created_at->FormValue;
        $this->created_at->CurrentValue = UnFormatDateTime($this->created_at->CurrentValue, 0);
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
        $this->tglterima->setDbValue($row['tglterima']);
        $this->tglsubmit->setDbValue($row['tglsubmit']);
        $this->brand->setDbValue($row['brand']);
        $this->tglkirimprimer->setDbValue($row['tglkirimprimer']);
        $this->tgldisetujuiprimer->setDbValue($row['tgldisetujuiprimer']);
        $this->desainprimer->setDbValue($row['desainprimer']);
        $this->materialprimer->setDbValue($row['materialprimer']);
        $this->aplikasiprimer->setDbValue($row['aplikasiprimer']);
        $this->jumlahcetakprimer->setDbValue($row['jumlahcetakprimer']);
        $this->tglkirimsekunder->setDbValue($row['tglkirimsekunder']);
        $this->tgldisetujuisekunder->setDbValue($row['tgldisetujuisekunder']);
        $this->desainsekunder->setDbValue($row['desainsekunder']);
        $this->materialsekunder->setDbValue($row['materialsekunder']);
        $this->aplikasisekunder->setDbValue($row['aplikasisekunder']);
        $this->jumlahcetaksekunder->setDbValue($row['jumlahcetaksekunder']);
        $this->submitted_by->setDbValue($row['submitted_by']);
        $this->checked_by->setDbValue($row['checked_by']);
        $this->approved_by->setDbValue($row['approved_by']);
        $this->created_at->setDbValue($row['created_at']);
        $this->updated_at->setDbValue($row['updated_at']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['idnpd'] = null;
        $row['tglterima'] = null;
        $row['tglsubmit'] = null;
        $row['brand'] = null;
        $row['tglkirimprimer'] = null;
        $row['tgldisetujuiprimer'] = null;
        $row['desainprimer'] = null;
        $row['materialprimer'] = null;
        $row['aplikasiprimer'] = null;
        $row['jumlahcetakprimer'] = null;
        $row['tglkirimsekunder'] = null;
        $row['tgldisetujuisekunder'] = null;
        $row['desainsekunder'] = null;
        $row['materialsekunder'] = null;
        $row['aplikasisekunder'] = null;
        $row['jumlahcetaksekunder'] = null;
        $row['submitted_by'] = null;
        $row['checked_by'] = null;
        $row['approved_by'] = null;
        $row['created_at'] = null;
        $row['updated_at'] = null;
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

        // tglterima

        // tglsubmit

        // brand

        // tglkirimprimer

        // tgldisetujuiprimer

        // desainprimer

        // materialprimer

        // aplikasiprimer

        // jumlahcetakprimer

        // tglkirimsekunder

        // tgldisetujuisekunder

        // desainsekunder

        // materialsekunder

        // aplikasisekunder

        // jumlahcetaksekunder

        // submitted_by

        // checked_by

        // approved_by

        // created_at

        // updated_at
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // idnpd
            $this->idnpd->ViewValue = $this->idnpd->CurrentValue;
            $this->idnpd->ViewValue = FormatNumber($this->idnpd->ViewValue, 0, -2, -2, -2);
            $this->idnpd->ViewCustomAttributes = "";

            // tglterima
            $this->tglterima->ViewValue = $this->tglterima->CurrentValue;
            $this->tglterima->ViewValue = FormatDateTime($this->tglterima->ViewValue, 0);
            $this->tglterima->ViewCustomAttributes = "";

            // tglsubmit
            $this->tglsubmit->ViewValue = $this->tglsubmit->CurrentValue;
            $this->tglsubmit->ViewValue = FormatDateTime($this->tglsubmit->ViewValue, 0);
            $this->tglsubmit->ViewCustomAttributes = "";

            // brand
            $this->brand->ViewValue = $this->brand->CurrentValue;
            $this->brand->ViewCustomAttributes = "";

            // tglkirimprimer
            $this->tglkirimprimer->ViewValue = $this->tglkirimprimer->CurrentValue;
            $this->tglkirimprimer->ViewValue = FormatDateTime($this->tglkirimprimer->ViewValue, 0);
            $this->tglkirimprimer->ViewCustomAttributes = "";

            // tgldisetujuiprimer
            $this->tgldisetujuiprimer->ViewValue = $this->tgldisetujuiprimer->CurrentValue;
            $this->tgldisetujuiprimer->ViewValue = FormatDateTime($this->tgldisetujuiprimer->ViewValue, 0);
            $this->tgldisetujuiprimer->ViewCustomAttributes = "";

            // desainprimer
            $this->desainprimer->ViewValue = $this->desainprimer->CurrentValue;
            $this->desainprimer->ViewCustomAttributes = "";

            // materialprimer
            $this->materialprimer->ViewValue = $this->materialprimer->CurrentValue;
            $this->materialprimer->ViewCustomAttributes = "";

            // aplikasiprimer
            $this->aplikasiprimer->ViewValue = $this->aplikasiprimer->CurrentValue;
            $this->aplikasiprimer->ViewCustomAttributes = "";

            // jumlahcetakprimer
            $this->jumlahcetakprimer->ViewValue = $this->jumlahcetakprimer->CurrentValue;
            $this->jumlahcetakprimer->ViewValue = FormatNumber($this->jumlahcetakprimer->ViewValue, 0, -2, -2, -2);
            $this->jumlahcetakprimer->ViewCustomAttributes = "";

            // tglkirimsekunder
            $this->tglkirimsekunder->ViewValue = $this->tglkirimsekunder->CurrentValue;
            $this->tglkirimsekunder->ViewValue = FormatDateTime($this->tglkirimsekunder->ViewValue, 0);
            $this->tglkirimsekunder->ViewCustomAttributes = "";

            // tgldisetujuisekunder
            $this->tgldisetujuisekunder->ViewValue = $this->tgldisetujuisekunder->CurrentValue;
            $this->tgldisetujuisekunder->ViewValue = FormatDateTime($this->tgldisetujuisekunder->ViewValue, 0);
            $this->tgldisetujuisekunder->ViewCustomAttributes = "";

            // desainsekunder
            $this->desainsekunder->ViewValue = $this->desainsekunder->CurrentValue;
            $this->desainsekunder->ViewCustomAttributes = "";

            // materialsekunder
            $this->materialsekunder->ViewValue = $this->materialsekunder->CurrentValue;
            $this->materialsekunder->ViewCustomAttributes = "";

            // aplikasisekunder
            $this->aplikasisekunder->ViewValue = $this->aplikasisekunder->CurrentValue;
            $this->aplikasisekunder->ViewCustomAttributes = "";

            // jumlahcetaksekunder
            $this->jumlahcetaksekunder->ViewValue = $this->jumlahcetaksekunder->CurrentValue;
            $this->jumlahcetaksekunder->ViewValue = FormatNumber($this->jumlahcetaksekunder->ViewValue, 0, -2, -2, -2);
            $this->jumlahcetaksekunder->ViewCustomAttributes = "";

            // submitted_by
            $this->submitted_by->ViewValue = $this->submitted_by->CurrentValue;
            $this->submitted_by->ViewValue = FormatNumber($this->submitted_by->ViewValue, 0, -2, -2, -2);
            $this->submitted_by->ViewCustomAttributes = "";

            // checked_by
            $curVal = trim(strval($this->checked_by->CurrentValue));
            if ($curVal != "") {
                $this->checked_by->ViewValue = $this->checked_by->lookupCacheOption($curVal);
                if ($this->checked_by->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->checked_by->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->checked_by->Lookup->renderViewRow($rswrk[0]);
                        $this->checked_by->ViewValue = $this->checked_by->displayValue($arwrk);
                    } else {
                        $this->checked_by->ViewValue = $this->checked_by->CurrentValue;
                    }
                }
            } else {
                $this->checked_by->ViewValue = null;
            }
            $this->checked_by->ViewCustomAttributes = "";

            // approved_by
            $curVal = trim(strval($this->approved_by->CurrentValue));
            if ($curVal != "") {
                $this->approved_by->ViewValue = $this->approved_by->lookupCacheOption($curVal);
                if ($this->approved_by->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->approved_by->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->approved_by->Lookup->renderViewRow($rswrk[0]);
                        $this->approved_by->ViewValue = $this->approved_by->displayValue($arwrk);
                    } else {
                        $this->approved_by->ViewValue = $this->approved_by->CurrentValue;
                    }
                }
            } else {
                $this->approved_by->ViewValue = null;
            }
            $this->approved_by->ViewCustomAttributes = "";

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
            $this->created_at->ViewCustomAttributes = "";

            // updated_at
            $this->updated_at->ViewValue = $this->updated_at->CurrentValue;
            $this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, 0);
            $this->updated_at->ViewCustomAttributes = "";

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";
            $this->id->TooltipValue = "";

            // idnpd
            $this->idnpd->LinkCustomAttributes = "";
            $this->idnpd->HrefValue = "";
            $this->idnpd->TooltipValue = "";

            // tglterima
            $this->tglterima->LinkCustomAttributes = "";
            $this->tglterima->HrefValue = "";
            $this->tglterima->TooltipValue = "";

            // tglsubmit
            $this->tglsubmit->LinkCustomAttributes = "";
            $this->tglsubmit->HrefValue = "";
            $this->tglsubmit->TooltipValue = "";

            // brand
            $this->brand->LinkCustomAttributes = "";
            $this->brand->HrefValue = "";
            $this->brand->TooltipValue = "";

            // tglkirimprimer
            $this->tglkirimprimer->LinkCustomAttributes = "";
            $this->tglkirimprimer->HrefValue = "";
            $this->tglkirimprimer->TooltipValue = "";

            // tgldisetujuiprimer
            $this->tgldisetujuiprimer->LinkCustomAttributes = "";
            $this->tgldisetujuiprimer->HrefValue = "";
            $this->tgldisetujuiprimer->TooltipValue = "";

            // desainprimer
            $this->desainprimer->LinkCustomAttributes = "";
            $this->desainprimer->HrefValue = "";
            $this->desainprimer->TooltipValue = "";

            // materialprimer
            $this->materialprimer->LinkCustomAttributes = "";
            $this->materialprimer->HrefValue = "";
            $this->materialprimer->TooltipValue = "";

            // aplikasiprimer
            $this->aplikasiprimer->LinkCustomAttributes = "";
            $this->aplikasiprimer->HrefValue = "";
            $this->aplikasiprimer->TooltipValue = "";

            // jumlahcetakprimer
            $this->jumlahcetakprimer->LinkCustomAttributes = "";
            $this->jumlahcetakprimer->HrefValue = "";
            $this->jumlahcetakprimer->TooltipValue = "";

            // tglkirimsekunder
            $this->tglkirimsekunder->LinkCustomAttributes = "";
            $this->tglkirimsekunder->HrefValue = "";
            $this->tglkirimsekunder->TooltipValue = "";

            // tgldisetujuisekunder
            $this->tgldisetujuisekunder->LinkCustomAttributes = "";
            $this->tgldisetujuisekunder->HrefValue = "";
            $this->tgldisetujuisekunder->TooltipValue = "";

            // desainsekunder
            $this->desainsekunder->LinkCustomAttributes = "";
            $this->desainsekunder->HrefValue = "";
            $this->desainsekunder->TooltipValue = "";

            // materialsekunder
            $this->materialsekunder->LinkCustomAttributes = "";
            $this->materialsekunder->HrefValue = "";
            $this->materialsekunder->TooltipValue = "";

            // aplikasisekunder
            $this->aplikasisekunder->LinkCustomAttributes = "";
            $this->aplikasisekunder->HrefValue = "";
            $this->aplikasisekunder->TooltipValue = "";

            // jumlahcetaksekunder
            $this->jumlahcetaksekunder->LinkCustomAttributes = "";
            $this->jumlahcetaksekunder->HrefValue = "";
            $this->jumlahcetaksekunder->TooltipValue = "";

            // submitted_by
            $this->submitted_by->LinkCustomAttributes = "";
            $this->submitted_by->HrefValue = "";
            $this->submitted_by->TooltipValue = "";

            // checked_by
            $this->checked_by->LinkCustomAttributes = "";
            $this->checked_by->HrefValue = "";
            $this->checked_by->TooltipValue = "";

            // approved_by
            $this->approved_by->LinkCustomAttributes = "";
            $this->approved_by->HrefValue = "";
            $this->approved_by->TooltipValue = "";

            // created_at
            $this->created_at->LinkCustomAttributes = "";
            $this->created_at->HrefValue = "";
            $this->created_at->TooltipValue = "";

            // updated_at
            $this->updated_at->LinkCustomAttributes = "";
            $this->updated_at->HrefValue = "";
            $this->updated_at->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // id
            $this->id->EditAttrs["class"] = "form-control";
            $this->id->EditCustomAttributes = "";
            $this->id->EditValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // idnpd
            $this->idnpd->EditAttrs["class"] = "form-control";
            $this->idnpd->EditCustomAttributes = "";
            $this->idnpd->EditValue = HtmlEncode($this->idnpd->CurrentValue);
            $this->idnpd->PlaceHolder = RemoveHtml($this->idnpd->caption());

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

            // brand
            $this->brand->EditAttrs["class"] = "form-control";
            $this->brand->EditCustomAttributes = "";
            if (!$this->brand->Raw) {
                $this->brand->CurrentValue = HtmlDecode($this->brand->CurrentValue);
            }
            $this->brand->EditValue = HtmlEncode($this->brand->CurrentValue);
            $this->brand->PlaceHolder = RemoveHtml($this->brand->caption());

            // tglkirimprimer
            $this->tglkirimprimer->EditAttrs["class"] = "form-control";
            $this->tglkirimprimer->EditCustomAttributes = "";
            $this->tglkirimprimer->EditValue = HtmlEncode(FormatDateTime($this->tglkirimprimer->CurrentValue, 8));
            $this->tglkirimprimer->PlaceHolder = RemoveHtml($this->tglkirimprimer->caption());

            // tgldisetujuiprimer
            $this->tgldisetujuiprimer->EditAttrs["class"] = "form-control";
            $this->tgldisetujuiprimer->EditCustomAttributes = "";
            $this->tgldisetujuiprimer->EditValue = HtmlEncode(FormatDateTime($this->tgldisetujuiprimer->CurrentValue, 8));
            $this->tgldisetujuiprimer->PlaceHolder = RemoveHtml($this->tgldisetujuiprimer->caption());

            // desainprimer
            $this->desainprimer->EditAttrs["class"] = "form-control";
            $this->desainprimer->EditCustomAttributes = "";
            if (!$this->desainprimer->Raw) {
                $this->desainprimer->CurrentValue = HtmlDecode($this->desainprimer->CurrentValue);
            }
            $this->desainprimer->EditValue = HtmlEncode($this->desainprimer->CurrentValue);
            $this->desainprimer->PlaceHolder = RemoveHtml($this->desainprimer->caption());

            // materialprimer
            $this->materialprimer->EditAttrs["class"] = "form-control";
            $this->materialprimer->EditCustomAttributes = "";
            if (!$this->materialprimer->Raw) {
                $this->materialprimer->CurrentValue = HtmlDecode($this->materialprimer->CurrentValue);
            }
            $this->materialprimer->EditValue = HtmlEncode($this->materialprimer->CurrentValue);
            $this->materialprimer->PlaceHolder = RemoveHtml($this->materialprimer->caption());

            // aplikasiprimer
            $this->aplikasiprimer->EditAttrs["class"] = "form-control";
            $this->aplikasiprimer->EditCustomAttributes = "";
            if (!$this->aplikasiprimer->Raw) {
                $this->aplikasiprimer->CurrentValue = HtmlDecode($this->aplikasiprimer->CurrentValue);
            }
            $this->aplikasiprimer->EditValue = HtmlEncode($this->aplikasiprimer->CurrentValue);
            $this->aplikasiprimer->PlaceHolder = RemoveHtml($this->aplikasiprimer->caption());

            // jumlahcetakprimer
            $this->jumlahcetakprimer->EditAttrs["class"] = "form-control";
            $this->jumlahcetakprimer->EditCustomAttributes = "";
            $this->jumlahcetakprimer->EditValue = HtmlEncode($this->jumlahcetakprimer->CurrentValue);
            $this->jumlahcetakprimer->PlaceHolder = RemoveHtml($this->jumlahcetakprimer->caption());

            // tglkirimsekunder
            $this->tglkirimsekunder->EditAttrs["class"] = "form-control";
            $this->tglkirimsekunder->EditCustomAttributes = "";
            $this->tglkirimsekunder->EditValue = HtmlEncode(FormatDateTime($this->tglkirimsekunder->CurrentValue, 8));
            $this->tglkirimsekunder->PlaceHolder = RemoveHtml($this->tglkirimsekunder->caption());

            // tgldisetujuisekunder
            $this->tgldisetujuisekunder->EditAttrs["class"] = "form-control";
            $this->tgldisetujuisekunder->EditCustomAttributes = "";
            $this->tgldisetujuisekunder->EditValue = HtmlEncode(FormatDateTime($this->tgldisetujuisekunder->CurrentValue, 8));
            $this->tgldisetujuisekunder->PlaceHolder = RemoveHtml($this->tgldisetujuisekunder->caption());

            // desainsekunder
            $this->desainsekunder->EditAttrs["class"] = "form-control";
            $this->desainsekunder->EditCustomAttributes = "";
            if (!$this->desainsekunder->Raw) {
                $this->desainsekunder->CurrentValue = HtmlDecode($this->desainsekunder->CurrentValue);
            }
            $this->desainsekunder->EditValue = HtmlEncode($this->desainsekunder->CurrentValue);
            $this->desainsekunder->PlaceHolder = RemoveHtml($this->desainsekunder->caption());

            // materialsekunder
            $this->materialsekunder->EditAttrs["class"] = "form-control";
            $this->materialsekunder->EditCustomAttributes = "";
            if (!$this->materialsekunder->Raw) {
                $this->materialsekunder->CurrentValue = HtmlDecode($this->materialsekunder->CurrentValue);
            }
            $this->materialsekunder->EditValue = HtmlEncode($this->materialsekunder->CurrentValue);
            $this->materialsekunder->PlaceHolder = RemoveHtml($this->materialsekunder->caption());

            // aplikasisekunder
            $this->aplikasisekunder->EditAttrs["class"] = "form-control";
            $this->aplikasisekunder->EditCustomAttributes = "";
            if (!$this->aplikasisekunder->Raw) {
                $this->aplikasisekunder->CurrentValue = HtmlDecode($this->aplikasisekunder->CurrentValue);
            }
            $this->aplikasisekunder->EditValue = HtmlEncode($this->aplikasisekunder->CurrentValue);
            $this->aplikasisekunder->PlaceHolder = RemoveHtml($this->aplikasisekunder->caption());

            // jumlahcetaksekunder
            $this->jumlahcetaksekunder->EditAttrs["class"] = "form-control";
            $this->jumlahcetaksekunder->EditCustomAttributes = "";
            $this->jumlahcetaksekunder->EditValue = HtmlEncode($this->jumlahcetaksekunder->CurrentValue);
            $this->jumlahcetaksekunder->PlaceHolder = RemoveHtml($this->jumlahcetaksekunder->caption());

            // submitted_by
            $this->submitted_by->EditAttrs["class"] = "form-control";
            $this->submitted_by->EditCustomAttributes = "";
            $this->submitted_by->EditValue = HtmlEncode($this->submitted_by->CurrentValue);
            $this->submitted_by->PlaceHolder = RemoveHtml($this->submitted_by->caption());

            // checked_by
            $this->checked_by->EditAttrs["class"] = "form-control";
            $this->checked_by->EditCustomAttributes = "";
            $curVal = trim(strval($this->checked_by->CurrentValue));
            if ($curVal != "") {
                $this->checked_by->ViewValue = $this->checked_by->lookupCacheOption($curVal);
            } else {
                $this->checked_by->ViewValue = $this->checked_by->Lookup !== null && is_array($this->checked_by->Lookup->Options) ? $curVal : null;
            }
            if ($this->checked_by->ViewValue !== null) { // Load from cache
                $this->checked_by->EditValue = array_values($this->checked_by->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->checked_by->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->checked_by->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->checked_by->EditValue = $arwrk;
            }
            $this->checked_by->PlaceHolder = RemoveHtml($this->checked_by->caption());

            // approved_by
            $this->approved_by->EditAttrs["class"] = "form-control";
            $this->approved_by->EditCustomAttributes = "";
            $curVal = trim(strval($this->approved_by->CurrentValue));
            if ($curVal != "") {
                $this->approved_by->ViewValue = $this->approved_by->lookupCacheOption($curVal);
            } else {
                $this->approved_by->ViewValue = $this->approved_by->Lookup !== null && is_array($this->approved_by->Lookup->Options) ? $curVal : null;
            }
            if ($this->approved_by->ViewValue !== null) { // Load from cache
                $this->approved_by->EditValue = array_values($this->approved_by->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->approved_by->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->approved_by->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->approved_by->EditValue = $arwrk;
            }
            $this->approved_by->PlaceHolder = RemoveHtml($this->approved_by->caption());

            // created_at
            $this->created_at->EditAttrs["class"] = "form-control";
            $this->created_at->EditCustomAttributes = "";
            $this->created_at->EditValue = HtmlEncode(FormatDateTime($this->created_at->CurrentValue, 8));
            $this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());

            // updated_at
            $this->updated_at->EditAttrs["class"] = "form-control";
            $this->updated_at->EditCustomAttributes = "";
            $this->updated_at->EditValue = HtmlEncode(FormatDateTime($this->updated_at->CurrentValue, 8));
            $this->updated_at->PlaceHolder = RemoveHtml($this->updated_at->caption());

            // Edit refer script

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

            // idnpd
            $this->idnpd->LinkCustomAttributes = "";
            $this->idnpd->HrefValue = "";

            // tglterima
            $this->tglterima->LinkCustomAttributes = "";
            $this->tglterima->HrefValue = "";

            // tglsubmit
            $this->tglsubmit->LinkCustomAttributes = "";
            $this->tglsubmit->HrefValue = "";

            // brand
            $this->brand->LinkCustomAttributes = "";
            $this->brand->HrefValue = "";

            // tglkirimprimer
            $this->tglkirimprimer->LinkCustomAttributes = "";
            $this->tglkirimprimer->HrefValue = "";

            // tgldisetujuiprimer
            $this->tgldisetujuiprimer->LinkCustomAttributes = "";
            $this->tgldisetujuiprimer->HrefValue = "";

            // desainprimer
            $this->desainprimer->LinkCustomAttributes = "";
            $this->desainprimer->HrefValue = "";

            // materialprimer
            $this->materialprimer->LinkCustomAttributes = "";
            $this->materialprimer->HrefValue = "";

            // aplikasiprimer
            $this->aplikasiprimer->LinkCustomAttributes = "";
            $this->aplikasiprimer->HrefValue = "";

            // jumlahcetakprimer
            $this->jumlahcetakprimer->LinkCustomAttributes = "";
            $this->jumlahcetakprimer->HrefValue = "";

            // tglkirimsekunder
            $this->tglkirimsekunder->LinkCustomAttributes = "";
            $this->tglkirimsekunder->HrefValue = "";

            // tgldisetujuisekunder
            $this->tgldisetujuisekunder->LinkCustomAttributes = "";
            $this->tgldisetujuisekunder->HrefValue = "";

            // desainsekunder
            $this->desainsekunder->LinkCustomAttributes = "";
            $this->desainsekunder->HrefValue = "";

            // materialsekunder
            $this->materialsekunder->LinkCustomAttributes = "";
            $this->materialsekunder->HrefValue = "";

            // aplikasisekunder
            $this->aplikasisekunder->LinkCustomAttributes = "";
            $this->aplikasisekunder->HrefValue = "";

            // jumlahcetaksekunder
            $this->jumlahcetaksekunder->LinkCustomAttributes = "";
            $this->jumlahcetaksekunder->HrefValue = "";

            // submitted_by
            $this->submitted_by->LinkCustomAttributes = "";
            $this->submitted_by->HrefValue = "";

            // checked_by
            $this->checked_by->LinkCustomAttributes = "";
            $this->checked_by->HrefValue = "";

            // approved_by
            $this->approved_by->LinkCustomAttributes = "";
            $this->approved_by->HrefValue = "";

            // created_at
            $this->created_at->LinkCustomAttributes = "";
            $this->created_at->HrefValue = "";

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
        if ($this->id->Required) {
            if (!$this->id->IsDetailKey && EmptyValue($this->id->FormValue)) {
                $this->id->addErrorMessage(str_replace("%s", $this->id->caption(), $this->id->RequiredErrorMessage));
            }
        }
        if ($this->idnpd->Required) {
            if (!$this->idnpd->IsDetailKey && EmptyValue($this->idnpd->FormValue)) {
                $this->idnpd->addErrorMessage(str_replace("%s", $this->idnpd->caption(), $this->idnpd->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->idnpd->FormValue)) {
            $this->idnpd->addErrorMessage($this->idnpd->getErrorMessage(false));
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
        if ($this->brand->Required) {
            if (!$this->brand->IsDetailKey && EmptyValue($this->brand->FormValue)) {
                $this->brand->addErrorMessage(str_replace("%s", $this->brand->caption(), $this->brand->RequiredErrorMessage));
            }
        }
        if ($this->tglkirimprimer->Required) {
            if (!$this->tglkirimprimer->IsDetailKey && EmptyValue($this->tglkirimprimer->FormValue)) {
                $this->tglkirimprimer->addErrorMessage(str_replace("%s", $this->tglkirimprimer->caption(), $this->tglkirimprimer->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tglkirimprimer->FormValue)) {
            $this->tglkirimprimer->addErrorMessage($this->tglkirimprimer->getErrorMessage(false));
        }
        if ($this->tgldisetujuiprimer->Required) {
            if (!$this->tgldisetujuiprimer->IsDetailKey && EmptyValue($this->tgldisetujuiprimer->FormValue)) {
                $this->tgldisetujuiprimer->addErrorMessage(str_replace("%s", $this->tgldisetujuiprimer->caption(), $this->tgldisetujuiprimer->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tgldisetujuiprimer->FormValue)) {
            $this->tgldisetujuiprimer->addErrorMessage($this->tgldisetujuiprimer->getErrorMessage(false));
        }
        if ($this->desainprimer->Required) {
            if (!$this->desainprimer->IsDetailKey && EmptyValue($this->desainprimer->FormValue)) {
                $this->desainprimer->addErrorMessage(str_replace("%s", $this->desainprimer->caption(), $this->desainprimer->RequiredErrorMessage));
            }
        }
        if ($this->materialprimer->Required) {
            if (!$this->materialprimer->IsDetailKey && EmptyValue($this->materialprimer->FormValue)) {
                $this->materialprimer->addErrorMessage(str_replace("%s", $this->materialprimer->caption(), $this->materialprimer->RequiredErrorMessage));
            }
        }
        if ($this->aplikasiprimer->Required) {
            if (!$this->aplikasiprimer->IsDetailKey && EmptyValue($this->aplikasiprimer->FormValue)) {
                $this->aplikasiprimer->addErrorMessage(str_replace("%s", $this->aplikasiprimer->caption(), $this->aplikasiprimer->RequiredErrorMessage));
            }
        }
        if ($this->jumlahcetakprimer->Required) {
            if (!$this->jumlahcetakprimer->IsDetailKey && EmptyValue($this->jumlahcetakprimer->FormValue)) {
                $this->jumlahcetakprimer->addErrorMessage(str_replace("%s", $this->jumlahcetakprimer->caption(), $this->jumlahcetakprimer->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->jumlahcetakprimer->FormValue)) {
            $this->jumlahcetakprimer->addErrorMessage($this->jumlahcetakprimer->getErrorMessage(false));
        }
        if ($this->tglkirimsekunder->Required) {
            if (!$this->tglkirimsekunder->IsDetailKey && EmptyValue($this->tglkirimsekunder->FormValue)) {
                $this->tglkirimsekunder->addErrorMessage(str_replace("%s", $this->tglkirimsekunder->caption(), $this->tglkirimsekunder->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tglkirimsekunder->FormValue)) {
            $this->tglkirimsekunder->addErrorMessage($this->tglkirimsekunder->getErrorMessage(false));
        }
        if ($this->tgldisetujuisekunder->Required) {
            if (!$this->tgldisetujuisekunder->IsDetailKey && EmptyValue($this->tgldisetujuisekunder->FormValue)) {
                $this->tgldisetujuisekunder->addErrorMessage(str_replace("%s", $this->tgldisetujuisekunder->caption(), $this->tgldisetujuisekunder->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tgldisetujuisekunder->FormValue)) {
            $this->tgldisetujuisekunder->addErrorMessage($this->tgldisetujuisekunder->getErrorMessage(false));
        }
        if ($this->desainsekunder->Required) {
            if (!$this->desainsekunder->IsDetailKey && EmptyValue($this->desainsekunder->FormValue)) {
                $this->desainsekunder->addErrorMessage(str_replace("%s", $this->desainsekunder->caption(), $this->desainsekunder->RequiredErrorMessage));
            }
        }
        if ($this->materialsekunder->Required) {
            if (!$this->materialsekunder->IsDetailKey && EmptyValue($this->materialsekunder->FormValue)) {
                $this->materialsekunder->addErrorMessage(str_replace("%s", $this->materialsekunder->caption(), $this->materialsekunder->RequiredErrorMessage));
            }
        }
        if ($this->aplikasisekunder->Required) {
            if (!$this->aplikasisekunder->IsDetailKey && EmptyValue($this->aplikasisekunder->FormValue)) {
                $this->aplikasisekunder->addErrorMessage(str_replace("%s", $this->aplikasisekunder->caption(), $this->aplikasisekunder->RequiredErrorMessage));
            }
        }
        if ($this->jumlahcetaksekunder->Required) {
            if (!$this->jumlahcetaksekunder->IsDetailKey && EmptyValue($this->jumlahcetaksekunder->FormValue)) {
                $this->jumlahcetaksekunder->addErrorMessage(str_replace("%s", $this->jumlahcetaksekunder->caption(), $this->jumlahcetaksekunder->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->jumlahcetaksekunder->FormValue)) {
            $this->jumlahcetaksekunder->addErrorMessage($this->jumlahcetaksekunder->getErrorMessage(false));
        }
        if ($this->submitted_by->Required) {
            if (!$this->submitted_by->IsDetailKey && EmptyValue($this->submitted_by->FormValue)) {
                $this->submitted_by->addErrorMessage(str_replace("%s", $this->submitted_by->caption(), $this->submitted_by->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->submitted_by->FormValue)) {
            $this->submitted_by->addErrorMessage($this->submitted_by->getErrorMessage(false));
        }
        if ($this->checked_by->Required) {
            if (!$this->checked_by->IsDetailKey && EmptyValue($this->checked_by->FormValue)) {
                $this->checked_by->addErrorMessage(str_replace("%s", $this->checked_by->caption(), $this->checked_by->RequiredErrorMessage));
            }
        }
        if ($this->approved_by->Required) {
            if (!$this->approved_by->IsDetailKey && EmptyValue($this->approved_by->FormValue)) {
                $this->approved_by->addErrorMessage(str_replace("%s", $this->approved_by->caption(), $this->approved_by->RequiredErrorMessage));
            }
        }
        if ($this->created_at->Required) {
            if (!$this->created_at->IsDetailKey && EmptyValue($this->created_at->FormValue)) {
                $this->created_at->addErrorMessage(str_replace("%s", $this->created_at->caption(), $this->created_at->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->created_at->FormValue)) {
            $this->created_at->addErrorMessage($this->created_at->getErrorMessage(false));
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

            // idnpd
            $this->idnpd->setDbValueDef($rsnew, $this->idnpd->CurrentValue, 0, $this->idnpd->ReadOnly);

            // tglterima
            $this->tglterima->setDbValueDef($rsnew, UnFormatDateTime($this->tglterima->CurrentValue, 0), null, $this->tglterima->ReadOnly);

            // tglsubmit
            $this->tglsubmit->setDbValueDef($rsnew, UnFormatDateTime($this->tglsubmit->CurrentValue, 0), null, $this->tglsubmit->ReadOnly);

            // brand
            $this->brand->setDbValueDef($rsnew, $this->brand->CurrentValue, "", $this->brand->ReadOnly);

            // tglkirimprimer
            $this->tglkirimprimer->setDbValueDef($rsnew, UnFormatDateTime($this->tglkirimprimer->CurrentValue, 0), null, $this->tglkirimprimer->ReadOnly);

            // tgldisetujuiprimer
            $this->tgldisetujuiprimer->setDbValueDef($rsnew, UnFormatDateTime($this->tgldisetujuiprimer->CurrentValue, 0), null, $this->tgldisetujuiprimer->ReadOnly);

            // desainprimer
            $this->desainprimer->setDbValueDef($rsnew, $this->desainprimer->CurrentValue, null, $this->desainprimer->ReadOnly);

            // materialprimer
            $this->materialprimer->setDbValueDef($rsnew, $this->materialprimer->CurrentValue, null, $this->materialprimer->ReadOnly);

            // aplikasiprimer
            $this->aplikasiprimer->setDbValueDef($rsnew, $this->aplikasiprimer->CurrentValue, null, $this->aplikasiprimer->ReadOnly);

            // jumlahcetakprimer
            $this->jumlahcetakprimer->setDbValueDef($rsnew, $this->jumlahcetakprimer->CurrentValue, null, $this->jumlahcetakprimer->ReadOnly);

            // tglkirimsekunder
            $this->tglkirimsekunder->setDbValueDef($rsnew, UnFormatDateTime($this->tglkirimsekunder->CurrentValue, 0), null, $this->tglkirimsekunder->ReadOnly);

            // tgldisetujuisekunder
            $this->tgldisetujuisekunder->setDbValueDef($rsnew, UnFormatDateTime($this->tgldisetujuisekunder->CurrentValue, 0), null, $this->tgldisetujuisekunder->ReadOnly);

            // desainsekunder
            $this->desainsekunder->setDbValueDef($rsnew, $this->desainsekunder->CurrentValue, null, $this->desainsekunder->ReadOnly);

            // materialsekunder
            $this->materialsekunder->setDbValueDef($rsnew, $this->materialsekunder->CurrentValue, null, $this->materialsekunder->ReadOnly);

            // aplikasisekunder
            $this->aplikasisekunder->setDbValueDef($rsnew, $this->aplikasisekunder->CurrentValue, null, $this->aplikasisekunder->ReadOnly);

            // jumlahcetaksekunder
            $this->jumlahcetaksekunder->setDbValueDef($rsnew, $this->jumlahcetaksekunder->CurrentValue, null, $this->jumlahcetaksekunder->ReadOnly);

            // submitted_by
            $this->submitted_by->setDbValueDef($rsnew, $this->submitted_by->CurrentValue, null, $this->submitted_by->ReadOnly);

            // checked_by
            $this->checked_by->setDbValueDef($rsnew, $this->checked_by->CurrentValue, null, $this->checked_by->ReadOnly);

            // approved_by
            $this->approved_by->setDbValueDef($rsnew, $this->approved_by->CurrentValue, null, $this->approved_by->ReadOnly);

            // created_at
            $this->created_at->setDbValueDef($rsnew, UnFormatDateTime($this->created_at->CurrentValue, 0), null, $this->created_at->ReadOnly);

            // updated_at
            $this->updated_at->setDbValueDef($rsnew, UnFormatDateTime($this->updated_at->CurrentValue, 0), null, $this->updated_at->ReadOnly);

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

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("NpdConfirmprintList"), "", $this->TableVar, true);
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
                case "x_checked_by":
                    break;
                case "x_approved_by":
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
