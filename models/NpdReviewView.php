<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class NpdReviewView extends NpdReview
{
    use MessagesTrait;

    // Page ID
    public $PageID = "view";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'npd_review';

    // Page object name
    public $PageObjName = "NpdReviewView";

    // Rendering View
    public $RenderingView = false;

    // Page URLs
    public $AddUrl;
    public $EditUrl;
    public $CopyUrl;
    public $DeleteUrl;
    public $ViewUrl;
    public $ListUrl;

    // Export URLs
    public $ExportPrintUrl;
    public $ExportHtmlUrl;
    public $ExportExcelUrl;
    public $ExportWordUrl;
    public $ExportXmlUrl;
    public $ExportCsvUrl;
    public $ExportPdfUrl;

    // Custom export
    public $ExportExcelCustom = false;
    public $ExportWordCustom = false;
    public $ExportPdfCustom = false;
    public $ExportEmailCustom = false;

    // Update URLs
    public $InlineAddUrl;
    public $InlineCopyUrl;
    public $InlineEditUrl;
    public $GridAddUrl;
    public $GridEditUrl;
    public $MultiDeleteUrl;
    public $MultiUpdateUrl;

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

        // Table object (npd_review)
        if (!isset($GLOBALS["npd_review"]) || get_class($GLOBALS["npd_review"]) == PROJECT_NAMESPACE . "npd_review") {
            $GLOBALS["npd_review"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();
        if (($keyValue = Get("id") ?? Route("id")) !== null) {
            $this->RecKey["id"] = $keyValue;
        }
        $this->ExportPrintUrl = $pageUrl . "export=print";
        $this->ExportHtmlUrl = $pageUrl . "export=html";
        $this->ExportExcelUrl = $pageUrl . "export=excel";
        $this->ExportWordUrl = $pageUrl . "export=word";
        $this->ExportXmlUrl = $pageUrl . "export=xml";
        $this->ExportCsvUrl = $pageUrl . "export=csv";
        $this->ExportPdfUrl = $pageUrl . "export=pdf";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'npd_review');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();

        // User table object
        $UserTable = Container("usertable");

        // Export options
        $this->ExportOptions = new ListOptions("div");
        $this->ExportOptions->TagClassName = "ew-export-option";

        // Other options
        if (!$this->OtherOptions) {
            $this->OtherOptions = new ListOptionsArray();
        }
        $this->OtherOptions["action"] = new ListOptions("div");
        $this->OtherOptions["action"]->TagClassName = "ew-action-option";
        $this->OtherOptions["detail"] = new ListOptions("div");
        $this->OtherOptions["detail"]->TagClassName = "ew-detail-option";
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
                $doc = new $class(Container("npd_review"));
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
                    if ($pageName == "NpdReviewView") {
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
    public $ExportOptions; // Export options
    public $OtherOptions; // Other options
    public $DisplayRecords = 1;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecKey = [];
    public $IsModal = false;

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
        $this->CurrentAction = Param("action"); // Set up current action
        $this->id->setVisibility();
        $this->idnpd->setVisibility();
        $this->idnpd_sample->setVisibility();
        $this->tanggal_review->setVisibility();
        $this->tanggal_submit->setVisibility();
        $this->wadah->setVisibility();
        $this->bentuk_opsi->setVisibility();
        $this->bentuk_revisi->setVisibility();
        $this->viskositas_opsi->setVisibility();
        $this->viskositas_revisi->setVisibility();
        $this->jeniswarna_opsi->setVisibility();
        $this->jeniswarna_revisi->setVisibility();
        $this->tonewarna_opsi->setVisibility();
        $this->tonewarna_revisi->setVisibility();
        $this->gradasiwarna_opsi->setVisibility();
        $this->gradasiwarna_revisi->setVisibility();
        $this->bauparfum_opsi->setVisibility();
        $this->bauparfum_revisi->setVisibility();
        $this->estetika_opsi->setVisibility();
        $this->estetika_revisi->setVisibility();
        $this->aplikasiawal_opsi->setVisibility();
        $this->aplikasiawal_revisi->setVisibility();
        $this->aplikasilama_opsi->setVisibility();
        $this->aplikasilama_revisi->setVisibility();
        $this->efekpositif_opsi->setVisibility();
        $this->efekpositif_revisi->setVisibility();
        $this->efeknegatif_opsi->setVisibility();
        $this->efeknegatif_revisi->setVisibility();
        $this->kesimpulan->setVisibility();
        $this->status->setVisibility();
        $this->created_at->setVisibility();
        $this->readonly->setVisibility();
        $this->ukuran->setVisibility();
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

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }

        // Load current record
        $loadCurrentRecord = false;
        $returnUrl = "";
        $matchRecord = false;

        // Set up master/detail parameters
        $this->setupMasterParms();
        if ($this->isPageRequest()) { // Validate request
            if (($keyValue = Get("id") ?? Route("id")) !== null) {
                $this->id->setQueryStringValue($keyValue);
                $this->RecKey["id"] = $this->id->QueryStringValue;
            } elseif (Post("id") !== null) {
                $this->id->setFormValue(Post("id"));
                $this->RecKey["id"] = $this->id->FormValue;
            } elseif (IsApi() && ($keyValue = Key(0) ?? Route(2)) !== null) {
                $this->id->setQueryStringValue($keyValue);
                $this->RecKey["id"] = $this->id->QueryStringValue;
            } else {
                $returnUrl = "NpdReviewList"; // Return to list
            }

            // Get action
            $this->CurrentAction = "show"; // Display
            switch ($this->CurrentAction) {
                case "show": // Get a record to display

                    // Load record based on key
                    if (IsApi()) {
                        $filter = $this->getRecordFilter();
                        $this->CurrentFilter = $filter;
                        $sql = $this->getCurrentSql();
                        $conn = $this->getConnection();
                        $this->Recordset = LoadRecordset($sql, $conn);
                        $res = $this->Recordset && !$this->Recordset->EOF;
                    } else {
                        $res = $this->loadRow();
                    }
                    if (!$res) { // Load record based on key
                        if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                        }
                        $returnUrl = "NpdReviewList"; // No matching record, return to list
                    }
                    break;
            }
        } else {
            $returnUrl = "NpdReviewList"; // Not page request, return to list
        }
        if ($returnUrl != "") {
            $this->terminate($returnUrl);
            return;
        }

        // Set up Breadcrumb
        if (!$this->isExport()) {
            $this->setupBreadcrumb();
        }

        // Render row
        $this->RowType = ROWTYPE_VIEW;
        $this->resetAttributes();
        $this->renderRow();

        // Normal return
        if (IsApi()) {
            $rows = $this->getRecordsFromRecordset($this->Recordset, true); // Get current record only
            $this->Recordset->close();
            WriteJson(["success" => true, $this->TableVar => $rows]);
            $this->terminate(true);
            return;
        }

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

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["action"];

        // Add
        $item = &$option->add("add");
        $addcaption = HtmlTitle($Language->phrase("ViewPageAddLink"));
        if ($this->IsModal) {
            $item->Body = "<a class=\"ew-action ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"#\" onclick=\"return ew.modalDialogShow({lnk:this,url:'" . HtmlEncode(GetUrl($this->AddUrl)) . "'});\">" . $Language->phrase("ViewPageAddLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("ViewPageAddLink") . "</a>";
        }
        $item->Visible = ($this->AddUrl != "" && $Security->canAdd());

        // Edit
        $item = &$option->add("edit");
        $editcaption = HtmlTitle($Language->phrase("ViewPageEditLink"));
        if ($this->IsModal) {
            $item->Body = "<a class=\"ew-action ew-edit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"#\" onclick=\"return ew.modalDialogShow({lnk:this,url:'" . HtmlEncode(GetUrl($this->EditUrl)) . "'});\">" . $Language->phrase("ViewPageEditLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-edit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("ViewPageEditLink") . "</a>";
        }
        $item->Visible = ($this->EditUrl != "" && $Security->canEdit());

        // Delete
        $item = &$option->add("delete");
        if ($this->IsModal) { // Handle as inline delete
            $item->Body = "<a onclick=\"return ew.confirmDelete(this);\" class=\"ew-action ew-delete\" title=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" href=\"" . HtmlEncode(UrlAddQuery(GetUrl($this->DeleteUrl), "action=1")) . "\">" . $Language->phrase("ViewPageDeleteLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-delete\" title=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->DeleteUrl)) . "\">" . $Language->phrase("ViewPageDeleteLink") . "</a>";
        }
        $item->Visible = ($this->DeleteUrl != "" && $Security->canDelete());

        // Set up action default
        $option = $options["action"];
        $option->DropDownButtonPhrase = $Language->phrase("ButtonActions");
        $option->UseDropDownButton = false;
        $option->UseButtonGroup = true;
        $item = &$option->add($option->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;
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
        $this->idnpd_sample->setDbValue($row['idnpd_sample']);
        $this->tanggal_review->setDbValue($row['tanggal_review']);
        $this->tanggal_submit->setDbValue($row['tanggal_submit']);
        $this->wadah->setDbValue($row['wadah']);
        $this->bentuk_opsi->setDbValue($row['bentuk_opsi']);
        $this->bentuk_revisi->setDbValue($row['bentuk_revisi']);
        $this->viskositas_opsi->setDbValue($row['viskositas_opsi']);
        $this->viskositas_revisi->setDbValue($row['viskositas_revisi']);
        $this->jeniswarna_opsi->setDbValue($row['jeniswarna_opsi']);
        $this->jeniswarna_revisi->setDbValue($row['jeniswarna_revisi']);
        $this->tonewarna_opsi->setDbValue($row['tonewarna_opsi']);
        $this->tonewarna_revisi->setDbValue($row['tonewarna_revisi']);
        $this->gradasiwarna_opsi->setDbValue($row['gradasiwarna_opsi']);
        $this->gradasiwarna_revisi->setDbValue($row['gradasiwarna_revisi']);
        $this->bauparfum_opsi->setDbValue($row['bauparfum_opsi']);
        $this->bauparfum_revisi->setDbValue($row['bauparfum_revisi']);
        $this->estetika_opsi->setDbValue($row['estetika_opsi']);
        $this->estetika_revisi->setDbValue($row['estetika_revisi']);
        $this->aplikasiawal_opsi->setDbValue($row['aplikasiawal_opsi']);
        $this->aplikasiawal_revisi->setDbValue($row['aplikasiawal_revisi']);
        $this->aplikasilama_opsi->setDbValue($row['aplikasilama_opsi']);
        $this->aplikasilama_revisi->setDbValue($row['aplikasilama_revisi']);
        $this->efekpositif_opsi->setDbValue($row['efekpositif_opsi']);
        $this->efekpositif_revisi->setDbValue($row['efekpositif_revisi']);
        $this->efeknegatif_opsi->setDbValue($row['efeknegatif_opsi']);
        $this->efeknegatif_revisi->setDbValue($row['efeknegatif_revisi']);
        $this->kesimpulan->setDbValue($row['kesimpulan']);
        $this->status->setDbValue($row['status']);
        $this->created_at->setDbValue($row['created_at']);
        $this->readonly->setDbValue($row['readonly']);
        $this->ukuran->setDbValue($row['ukuran']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['idnpd'] = null;
        $row['idnpd_sample'] = null;
        $row['tanggal_review'] = null;
        $row['tanggal_submit'] = null;
        $row['wadah'] = null;
        $row['bentuk_opsi'] = null;
        $row['bentuk_revisi'] = null;
        $row['viskositas_opsi'] = null;
        $row['viskositas_revisi'] = null;
        $row['jeniswarna_opsi'] = null;
        $row['jeniswarna_revisi'] = null;
        $row['tonewarna_opsi'] = null;
        $row['tonewarna_revisi'] = null;
        $row['gradasiwarna_opsi'] = null;
        $row['gradasiwarna_revisi'] = null;
        $row['bauparfum_opsi'] = null;
        $row['bauparfum_revisi'] = null;
        $row['estetika_opsi'] = null;
        $row['estetika_revisi'] = null;
        $row['aplikasiawal_opsi'] = null;
        $row['aplikasiawal_revisi'] = null;
        $row['aplikasilama_opsi'] = null;
        $row['aplikasilama_revisi'] = null;
        $row['efekpositif_opsi'] = null;
        $row['efekpositif_revisi'] = null;
        $row['efeknegatif_opsi'] = null;
        $row['efeknegatif_revisi'] = null;
        $row['kesimpulan'] = null;
        $row['status'] = null;
        $row['created_at'] = null;
        $row['readonly'] = null;
        $row['ukuran'] = null;
        return $row;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs
        $this->AddUrl = $this->getAddUrl();
        $this->EditUrl = $this->getEditUrl();
        $this->CopyUrl = $this->getCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();
        $this->ListUrl = $this->getListUrl();
        $this->setupOtherOptions();

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id

        // idnpd

        // idnpd_sample

        // tanggal_review

        // tanggal_submit

        // wadah

        // bentuk_opsi

        // bentuk_revisi

        // viskositas_opsi

        // viskositas_revisi

        // jeniswarna_opsi

        // jeniswarna_revisi

        // tonewarna_opsi

        // tonewarna_revisi

        // gradasiwarna_opsi

        // gradasiwarna_revisi

        // bauparfum_opsi

        // bauparfum_revisi

        // estetika_opsi

        // estetika_revisi

        // aplikasiawal_opsi

        // aplikasiawal_revisi

        // aplikasilama_opsi

        // aplikasilama_revisi

        // efekpositif_opsi

        // efekpositif_revisi

        // efeknegatif_opsi

        // efeknegatif_revisi

        // kesimpulan

        // status

        // created_at

        // readonly

        // ukuran
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
                        return "`id` IN (SELECT `idnpd` FROM `npd_sample`)";
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

            // idnpd_sample
            $curVal = trim(strval($this->idnpd_sample->CurrentValue));
            if ($curVal != "") {
                $this->idnpd_sample->ViewValue = $this->idnpd_sample->lookupCacheOption($curVal);
                if ($this->idnpd_sample->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return CurrentPageID() == "add" ? "`status`=0" : "";
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

            // tanggal_review
            $this->tanggal_review->ViewValue = $this->tanggal_review->CurrentValue;
            $this->tanggal_review->ViewValue = FormatDateTime($this->tanggal_review->ViewValue, 0);
            $this->tanggal_review->ViewCustomAttributes = "";

            // tanggal_submit
            $this->tanggal_submit->ViewValue = $this->tanggal_submit->CurrentValue;
            $this->tanggal_submit->ViewValue = FormatDateTime($this->tanggal_submit->ViewValue, 0);
            $this->tanggal_submit->ViewCustomAttributes = "";

            // wadah
            $this->wadah->ViewValue = $this->wadah->CurrentValue;
            $this->wadah->ViewCustomAttributes = "";

            // bentuk_opsi
            if (strval($this->bentuk_opsi->CurrentValue) != "") {
                $this->bentuk_opsi->ViewValue = $this->bentuk_opsi->optionCaption($this->bentuk_opsi->CurrentValue);
            } else {
                $this->bentuk_opsi->ViewValue = null;
            }
            $this->bentuk_opsi->ViewCustomAttributes = "";

            // bentuk_revisi
            $this->bentuk_revisi->ViewValue = $this->bentuk_revisi->CurrentValue;
            $this->bentuk_revisi->ViewCustomAttributes = "";

            // viskositas_opsi
            if (strval($this->viskositas_opsi->CurrentValue) != "") {
                $this->viskositas_opsi->ViewValue = $this->viskositas_opsi->optionCaption($this->viskositas_opsi->CurrentValue);
            } else {
                $this->viskositas_opsi->ViewValue = null;
            }
            $this->viskositas_opsi->ViewCustomAttributes = "";

            // viskositas_revisi
            $this->viskositas_revisi->ViewValue = $this->viskositas_revisi->CurrentValue;
            $this->viskositas_revisi->ViewCustomAttributes = "";

            // jeniswarna_opsi
            if (strval($this->jeniswarna_opsi->CurrentValue) != "") {
                $this->jeniswarna_opsi->ViewValue = $this->jeniswarna_opsi->optionCaption($this->jeniswarna_opsi->CurrentValue);
            } else {
                $this->jeniswarna_opsi->ViewValue = null;
            }
            $this->jeniswarna_opsi->ViewCustomAttributes = "";

            // jeniswarna_revisi
            $this->jeniswarna_revisi->ViewValue = $this->jeniswarna_revisi->CurrentValue;
            $this->jeniswarna_revisi->ViewCustomAttributes = "";

            // tonewarna_opsi
            if (strval($this->tonewarna_opsi->CurrentValue) != "") {
                $this->tonewarna_opsi->ViewValue = $this->tonewarna_opsi->optionCaption($this->tonewarna_opsi->CurrentValue);
            } else {
                $this->tonewarna_opsi->ViewValue = null;
            }
            $this->tonewarna_opsi->ViewCustomAttributes = "";

            // tonewarna_revisi
            $this->tonewarna_revisi->ViewValue = $this->tonewarna_revisi->CurrentValue;
            $this->tonewarna_revisi->ViewCustomAttributes = "";

            // gradasiwarna_opsi
            if (strval($this->gradasiwarna_opsi->CurrentValue) != "") {
                $this->gradasiwarna_opsi->ViewValue = $this->gradasiwarna_opsi->optionCaption($this->gradasiwarna_opsi->CurrentValue);
            } else {
                $this->gradasiwarna_opsi->ViewValue = null;
            }
            $this->gradasiwarna_opsi->ViewCustomAttributes = "";

            // gradasiwarna_revisi
            $this->gradasiwarna_revisi->ViewValue = $this->gradasiwarna_revisi->CurrentValue;
            $this->gradasiwarna_revisi->ViewCustomAttributes = "";

            // bauparfum_opsi
            if (strval($this->bauparfum_opsi->CurrentValue) != "") {
                $this->bauparfum_opsi->ViewValue = $this->bauparfum_opsi->optionCaption($this->bauparfum_opsi->CurrentValue);
            } else {
                $this->bauparfum_opsi->ViewValue = null;
            }
            $this->bauparfum_opsi->ViewCustomAttributes = "";

            // bauparfum_revisi
            $this->bauparfum_revisi->ViewValue = $this->bauparfum_revisi->CurrentValue;
            $this->bauparfum_revisi->ViewCustomAttributes = "";

            // estetika_opsi
            if (strval($this->estetika_opsi->CurrentValue) != "") {
                $this->estetika_opsi->ViewValue = $this->estetika_opsi->optionCaption($this->estetika_opsi->CurrentValue);
            } else {
                $this->estetika_opsi->ViewValue = null;
            }
            $this->estetika_opsi->ViewCustomAttributes = "";

            // estetika_revisi
            $this->estetika_revisi->ViewValue = $this->estetika_revisi->CurrentValue;
            $this->estetika_revisi->ViewCustomAttributes = "";

            // aplikasiawal_opsi
            if (strval($this->aplikasiawal_opsi->CurrentValue) != "") {
                $this->aplikasiawal_opsi->ViewValue = $this->aplikasiawal_opsi->optionCaption($this->aplikasiawal_opsi->CurrentValue);
            } else {
                $this->aplikasiawal_opsi->ViewValue = null;
            }
            $this->aplikasiawal_opsi->ViewCustomAttributes = "";

            // aplikasiawal_revisi
            $this->aplikasiawal_revisi->ViewValue = $this->aplikasiawal_revisi->CurrentValue;
            $this->aplikasiawal_revisi->ViewCustomAttributes = "";

            // aplikasilama_opsi
            if (strval($this->aplikasilama_opsi->CurrentValue) != "") {
                $this->aplikasilama_opsi->ViewValue = $this->aplikasilama_opsi->optionCaption($this->aplikasilama_opsi->CurrentValue);
            } else {
                $this->aplikasilama_opsi->ViewValue = null;
            }
            $this->aplikasilama_opsi->ViewCustomAttributes = "";

            // aplikasilama_revisi
            $this->aplikasilama_revisi->ViewValue = $this->aplikasilama_revisi->CurrentValue;
            $this->aplikasilama_revisi->ViewCustomAttributes = "";

            // efekpositif_opsi
            if (strval($this->efekpositif_opsi->CurrentValue) != "") {
                $this->efekpositif_opsi->ViewValue = $this->efekpositif_opsi->optionCaption($this->efekpositif_opsi->CurrentValue);
            } else {
                $this->efekpositif_opsi->ViewValue = null;
            }
            $this->efekpositif_opsi->ViewCustomAttributes = "";

            // efekpositif_revisi
            $this->efekpositif_revisi->ViewValue = $this->efekpositif_revisi->CurrentValue;
            $this->efekpositif_revisi->ViewCustomAttributes = "";

            // efeknegatif_opsi
            if (strval($this->efeknegatif_opsi->CurrentValue) != "") {
                $this->efeknegatif_opsi->ViewValue = $this->efeknegatif_opsi->optionCaption($this->efeknegatif_opsi->CurrentValue);
            } else {
                $this->efeknegatif_opsi->ViewValue = null;
            }
            $this->efeknegatif_opsi->ViewCustomAttributes = "";

            // efeknegatif_revisi
            $this->efeknegatif_revisi->ViewValue = $this->efeknegatif_revisi->CurrentValue;
            $this->efeknegatif_revisi->ViewCustomAttributes = "";

            // kesimpulan
            $this->kesimpulan->ViewValue = $this->kesimpulan->CurrentValue;
            $this->kesimpulan->ViewCustomAttributes = "";

            // status
            if (strval($this->status->CurrentValue) != "") {
                $this->status->ViewValue = $this->status->optionCaption($this->status->CurrentValue);
            } else {
                $this->status->ViewValue = null;
            }
            $this->status->ViewCustomAttributes = "";

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

            // ukuran
            $this->ukuran->ViewValue = $this->ukuran->CurrentValue;
            $this->ukuran->ViewCustomAttributes = "";

            // idnpd
            $this->idnpd->LinkCustomAttributes = "";
            $this->idnpd->HrefValue = "";
            $this->idnpd->TooltipValue = "";

            // idnpd_sample
            $this->idnpd_sample->LinkCustomAttributes = "";
            $this->idnpd_sample->HrefValue = "";
            $this->idnpd_sample->TooltipValue = "";

            // tanggal_review
            $this->tanggal_review->LinkCustomAttributes = "";
            $this->tanggal_review->HrefValue = "";
            $this->tanggal_review->TooltipValue = "";

            // tanggal_submit
            $this->tanggal_submit->LinkCustomAttributes = "";
            $this->tanggal_submit->HrefValue = "";
            $this->tanggal_submit->TooltipValue = "";

            // wadah
            $this->wadah->LinkCustomAttributes = "";
            $this->wadah->HrefValue = "";
            $this->wadah->TooltipValue = "";

            // bentuk_opsi
            $this->bentuk_opsi->LinkCustomAttributes = "";
            $this->bentuk_opsi->HrefValue = "";
            $this->bentuk_opsi->TooltipValue = "";

            // bentuk_revisi
            $this->bentuk_revisi->LinkCustomAttributes = "";
            $this->bentuk_revisi->HrefValue = "";
            $this->bentuk_revisi->TooltipValue = "";

            // viskositas_opsi
            $this->viskositas_opsi->LinkCustomAttributes = "";
            $this->viskositas_opsi->HrefValue = "";
            $this->viskositas_opsi->TooltipValue = "";

            // viskositas_revisi
            $this->viskositas_revisi->LinkCustomAttributes = "";
            $this->viskositas_revisi->HrefValue = "";
            $this->viskositas_revisi->TooltipValue = "";

            // jeniswarna_opsi
            $this->jeniswarna_opsi->LinkCustomAttributes = "";
            $this->jeniswarna_opsi->HrefValue = "";
            $this->jeniswarna_opsi->TooltipValue = "";

            // jeniswarna_revisi
            $this->jeniswarna_revisi->LinkCustomAttributes = "";
            $this->jeniswarna_revisi->HrefValue = "";
            $this->jeniswarna_revisi->TooltipValue = "";

            // tonewarna_opsi
            $this->tonewarna_opsi->LinkCustomAttributes = "";
            $this->tonewarna_opsi->HrefValue = "";
            $this->tonewarna_opsi->TooltipValue = "";

            // tonewarna_revisi
            $this->tonewarna_revisi->LinkCustomAttributes = "";
            $this->tonewarna_revisi->HrefValue = "";
            $this->tonewarna_revisi->TooltipValue = "";

            // gradasiwarna_opsi
            $this->gradasiwarna_opsi->LinkCustomAttributes = "";
            $this->gradasiwarna_opsi->HrefValue = "";
            $this->gradasiwarna_opsi->TooltipValue = "";

            // gradasiwarna_revisi
            $this->gradasiwarna_revisi->LinkCustomAttributes = "";
            $this->gradasiwarna_revisi->HrefValue = "";
            $this->gradasiwarna_revisi->TooltipValue = "";

            // bauparfum_opsi
            $this->bauparfum_opsi->LinkCustomAttributes = "";
            $this->bauparfum_opsi->HrefValue = "";
            $this->bauparfum_opsi->TooltipValue = "";

            // bauparfum_revisi
            $this->bauparfum_revisi->LinkCustomAttributes = "";
            $this->bauparfum_revisi->HrefValue = "";
            $this->bauparfum_revisi->TooltipValue = "";

            // estetika_opsi
            $this->estetika_opsi->LinkCustomAttributes = "";
            $this->estetika_opsi->HrefValue = "";
            $this->estetika_opsi->TooltipValue = "";

            // estetika_revisi
            $this->estetika_revisi->LinkCustomAttributes = "";
            $this->estetika_revisi->HrefValue = "";
            $this->estetika_revisi->TooltipValue = "";

            // aplikasiawal_opsi
            $this->aplikasiawal_opsi->LinkCustomAttributes = "";
            $this->aplikasiawal_opsi->HrefValue = "";
            $this->aplikasiawal_opsi->TooltipValue = "";

            // aplikasiawal_revisi
            $this->aplikasiawal_revisi->LinkCustomAttributes = "";
            $this->aplikasiawal_revisi->HrefValue = "";
            $this->aplikasiawal_revisi->TooltipValue = "";

            // aplikasilama_opsi
            $this->aplikasilama_opsi->LinkCustomAttributes = "";
            $this->aplikasilama_opsi->HrefValue = "";
            $this->aplikasilama_opsi->TooltipValue = "";

            // aplikasilama_revisi
            $this->aplikasilama_revisi->LinkCustomAttributes = "";
            $this->aplikasilama_revisi->HrefValue = "";
            $this->aplikasilama_revisi->TooltipValue = "";

            // efekpositif_opsi
            $this->efekpositif_opsi->LinkCustomAttributes = "";
            $this->efekpositif_opsi->HrefValue = "";
            $this->efekpositif_opsi->TooltipValue = "";

            // efekpositif_revisi
            $this->efekpositif_revisi->LinkCustomAttributes = "";
            $this->efekpositif_revisi->HrefValue = "";
            $this->efekpositif_revisi->TooltipValue = "";

            // efeknegatif_opsi
            $this->efeknegatif_opsi->LinkCustomAttributes = "";
            $this->efeknegatif_opsi->HrefValue = "";
            $this->efeknegatif_opsi->TooltipValue = "";

            // efeknegatif_revisi
            $this->efeknegatif_revisi->LinkCustomAttributes = "";
            $this->efeknegatif_revisi->HrefValue = "";
            $this->efeknegatif_revisi->TooltipValue = "";

            // kesimpulan
            $this->kesimpulan->LinkCustomAttributes = "";
            $this->kesimpulan->HrefValue = "";
            $this->kesimpulan->TooltipValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
            $this->status->TooltipValue = "";

            // ukuran
            $this->ukuran->LinkCustomAttributes = "";
            $this->ukuran->HrefValue = "";
            $this->ukuran->TooltipValue = "";
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
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
            $this->setSessionWhere($this->getDetailFilter());

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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("NpdReviewList"), "", $this->TableVar, true);
        $pageId = "view";
        $Breadcrumb->add("view", $pageId, $url);
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
                        return "`id` IN (SELECT `idnpd` FROM `npd_sample`)";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_idnpd_sample":
                    $lookupFilter = function () {
                        return CurrentPageID() == "add" ? "`status`=0" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_bentuk_opsi":
                    break;
                case "x_viskositas_opsi":
                    break;
                case "x_jeniswarna_opsi":
                    break;
                case "x_tonewarna_opsi":
                    break;
                case "x_gradasiwarna_opsi":
                    break;
                case "x_bauparfum_opsi":
                    break;
                case "x_estetika_opsi":
                    break;
                case "x_aplikasiawal_opsi":
                    break;
                case "x_aplikasilama_opsi":
                    break;
                case "x_efekpositif_opsi":
                    break;
                case "x_efeknegatif_opsi":
                    break;
                case "x_status":
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
        $this->OtherOptions["action"]->Items["add"]->Visible = false;
        if ($this->readonly->CurrentValue) {
        	$this->OtherOptions["action"]->Items["edit"]->Visible = false;
        	$this->OtherOptions["action"]->Items["delete"]->Visible = false;
        }
    }

    // Page Data Rendering event
    public function pageDataRendering(&$header)
    {
        // Example:
        //$header = "your header";
    	if ($this->bentukok->CurrentValue == 1) {
        	$this->bentukrevisi->Visible = false;
    	}
    	if ($this->viskositasok->CurrentValue == 1) {
        	$this->viskositasrevisi->Visible = false;
    	}
    	if ($this->jeniswarnaok->CurrentValue == 1) {
        	$this->jeniswarnarevisi->Visible = false;
    	}
    	if ($this->tonewarnaok->CurrentValue == 1) {
        	$this->tonewarnarevisi->Visible = false;
    	}
    	if ($this->gradasiwarnaok->CurrentValue == 1) {
        	$this->gradasiwarnarevisi->Visible = false;
    	}
    	if ($this->bauok->CurrentValue == 1) {
        	$this->baurevisi->Visible = false;
    	}
    	if ($this->estetikaok->CurrentValue == 1) {
        	$this->estetikarevisi->Visible = false;
    	}
    	if ($this->aplikasiawalok->CurrentValue == 1) {
        	$this->aplikasiawalrevisi->Visible = false;
    	}
    	if ($this->aplikasilamaok->CurrentValue == 1) {
        	$this->aplikasilamarevisi->Visible = false;
    	}
    	if ($this->efekpositifok->CurrentValue == 1) {
        	$this->efekpositifrevisi->Visible = false;
    	}
    	if ($this->efeknegatifok->CurrentValue == 1) {
        	$this->efeknegatifrevisi->Visible = false;
    	}
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }

    // Page Exporting event
    // $this->ExportDoc = export document object
    public function pageExporting()
    {
        //$this->ExportDoc->Text = "my header"; // Export header
        //return false; // Return false to skip default export and use Row_Export event
        return true; // Return true to use default export and skip Row_Export event
    }

    // Row Export event
    // $this->ExportDoc = export document object
    public function rowExport($rs)
    {
        //$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
    }

    // Page Exported event
    // $this->ExportDoc = export document object
    public function pageExported()
    {
        //$this->ExportDoc->Text .= "my footer"; // Export footer
        //Log($this->ExportDoc->Text);
    }
}
