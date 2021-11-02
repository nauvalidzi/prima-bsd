<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class CustomerView extends Customer
{
    use MessagesTrait;

    // Page ID
    public $PageID = "view";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'customer';

    // Page object name
    public $PageObjName = "CustomerView";

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

        // Table object (customer)
        if (!isset($GLOBALS["customer"]) || get_class($GLOBALS["customer"]) == PROJECT_NAMESPACE . "customer") {
            $GLOBALS["customer"] = &$this;
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
        $this->CurrentAction = Param("action"); // Set up current action
        $this->id->setVisibility();
        $this->kode->setVisibility();
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
        $this->level_customer_id->setVisibility();
        $this->limit_kredit_order->setVisibility();
        $this->jatuh_tempo_invoice->setVisibility();
        $this->keterangan->setVisibility();
        $this->aktif->setVisibility();
        $this->created_at->setVisibility();
        $this->updated_at->setVisibility();
        $this->created_by->setVisibility();
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
        $this->setupLookupOptions($this->level_customer_id);
        $this->setupLookupOptions($this->jatuh_tempo_invoice);

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
                $returnUrl = "CustomerList"; // Return to list
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
                        $returnUrl = "CustomerList"; // No matching record, return to list
                    }
                    break;
            }
        } else {
            $returnUrl = "CustomerList"; // Not page request, return to list
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

        // Set up detail parameters
        $this->setupDetailParms();

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
        $option = $options["detail"];
        $detailTableLink = "";
        $detailViewTblVar = "";
        $detailCopyTblVar = "";
        $detailEditTblVar = "";

        // "detail_alamat_customer"
        $item = &$option->add("detail_alamat_customer");
        $body = $Language->phrase("ViewPageDetailLink") . $Language->TablePhrase("alamat_customer", "TblCaption");
        $body .= "&nbsp;" . str_replace("%c", Container("alamat_customer")->Count, $Language->phrase("DetailCount"));
        $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode(GetUrl("AlamatCustomerList?" . Config("TABLE_SHOW_MASTER") . "=customer&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "")) . "\">" . $body . "</a>";
        $links = "";
        $detailPageObj = Container("AlamatCustomerGrid");
        if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'customer')) {
            $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailViewLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=alamat_customer"))) . "\">" . HtmlImageAndText($Language->phrase("MasterDetailViewLink")) . "</a></li>";
            if ($detailViewTblVar != "") {
                $detailViewTblVar .= ",";
            }
            $detailViewTblVar .= "alamat_customer";
        }
        if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'customer')) {
            $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailEditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=alamat_customer"))) . "\">" . HtmlImageAndText($Language->phrase("MasterDetailEditLink")) . "</a></li>";
            if ($detailEditTblVar != "") {
                $detailEditTblVar .= ",";
            }
            $detailEditTblVar .= "alamat_customer";
        }
        if ($links != "") {
            $body .= "<button class=\"dropdown-toggle btn btn-default ew-detail\" data-toggle=\"dropdown\"></button>";
            $body .= "<ul class=\"dropdown-menu\">" . $links . "</ul>";
        }
        $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">" . $body . "</div>";
        $item->Body = $body;
        $item->Visible = $Security->allowList(CurrentProjectID() . 'alamat_customer');
        if ($item->Visible) {
            if ($detailTableLink != "") {
                $detailTableLink .= ",";
            }
            $detailTableLink .= "alamat_customer";
        }
        if ($this->ShowMultipleDetails) {
            $item->Visible = false;
        }

        // "detail_brand"
        $item = &$option->add("detail_brand");
        $body = $Language->phrase("ViewPageDetailLink") . $Language->TablePhrase("brand", "TblCaption");
        $body .= "&nbsp;" . str_replace("%c", Container("brand")->Count, $Language->phrase("DetailCount"));
        $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode(GetUrl("BrandList?" . Config("TABLE_SHOW_MASTER") . "=customer&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "")) . "\">" . $body . "</a>";
        $links = "";
        $detailPageObj = Container("BrandGrid");
        if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'customer')) {
            $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailViewLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=brand"))) . "\">" . HtmlImageAndText($Language->phrase("MasterDetailViewLink")) . "</a></li>";
            if ($detailViewTblVar != "") {
                $detailViewTblVar .= ",";
            }
            $detailViewTblVar .= "brand";
        }
        if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'customer')) {
            $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailEditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=brand"))) . "\">" . HtmlImageAndText($Language->phrase("MasterDetailEditLink")) . "</a></li>";
            if ($detailEditTblVar != "") {
                $detailEditTblVar .= ",";
            }
            $detailEditTblVar .= "brand";
        }
        if ($links != "") {
            $body .= "<button class=\"dropdown-toggle btn btn-default ew-detail\" data-toggle=\"dropdown\"></button>";
            $body .= "<ul class=\"dropdown-menu\">" . $links . "</ul>";
        }
        $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">" . $body . "</div>";
        $item->Body = $body;
        $item->Visible = $Security->allowList(CurrentProjectID() . 'brand');
        if ($item->Visible) {
            if ($detailTableLink != "") {
                $detailTableLink .= ",";
            }
            $detailTableLink .= "brand";
        }
        if ($this->ShowMultipleDetails) {
            $item->Visible = false;
        }

        // "detail_order"
        $item = &$option->add("detail_order");
        $body = $Language->phrase("ViewPageDetailLink") . $Language->TablePhrase("order", "TblCaption");
        $body .= "&nbsp;" . str_replace("%c", Container("order")->Count, $Language->phrase("DetailCount"));
        $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode(GetUrl("OrderList?" . Config("TABLE_SHOW_MASTER") . "=customer&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "")) . "\">" . $body . "</a>";
        $links = "";
        $detailPageObj = Container("OrderGrid");
        if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'customer')) {
            $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailViewLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=order"))) . "\">" . HtmlImageAndText($Language->phrase("MasterDetailViewLink")) . "</a></li>";
            if ($detailViewTblVar != "") {
                $detailViewTblVar .= ",";
            }
            $detailViewTblVar .= "order";
        }
        if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'customer')) {
            $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailEditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=order"))) . "\">" . HtmlImageAndText($Language->phrase("MasterDetailEditLink")) . "</a></li>";
            if ($detailEditTblVar != "") {
                $detailEditTblVar .= ",";
            }
            $detailEditTblVar .= "order";
        }
        if ($links != "") {
            $body .= "<button class=\"dropdown-toggle btn btn-default ew-detail\" data-toggle=\"dropdown\"></button>";
            $body .= "<ul class=\"dropdown-menu\">" . $links . "</ul>";
        }
        $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">" . $body . "</div>";
        $item->Body = $body;
        $item->Visible = $Security->allowList(CurrentProjectID() . 'order');
        if ($item->Visible) {
            if ($detailTableLink != "") {
                $detailTableLink .= ",";
            }
            $detailTableLink .= "order";
        }
        if ($this->ShowMultipleDetails) {
            $item->Visible = false;
        }

        // "detail_invoice"
        $item = &$option->add("detail_invoice");
        $body = $Language->phrase("ViewPageDetailLink") . $Language->TablePhrase("invoice", "TblCaption");
        $body .= "&nbsp;" . str_replace("%c", Container("invoice")->Count, $Language->phrase("DetailCount"));
        $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode(GetUrl("InvoiceList?" . Config("TABLE_SHOW_MASTER") . "=customer&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue) . "")) . "\">" . $body . "</a>";
        $links = "";
        $detailPageObj = Container("InvoiceGrid");
        if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'customer')) {
            $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailViewLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=invoice"))) . "\">" . HtmlImageAndText($Language->phrase("MasterDetailViewLink")) . "</a></li>";
            if ($detailViewTblVar != "") {
                $detailViewTblVar .= ",";
            }
            $detailViewTblVar .= "invoice";
        }
        if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'customer')) {
            $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailEditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=invoice"))) . "\">" . HtmlImageAndText($Language->phrase("MasterDetailEditLink")) . "</a></li>";
            if ($detailEditTblVar != "") {
                $detailEditTblVar .= ",";
            }
            $detailEditTblVar .= "invoice";
        }
        if ($links != "") {
            $body .= "<button class=\"dropdown-toggle btn btn-default ew-detail\" data-toggle=\"dropdown\"></button>";
            $body .= "<ul class=\"dropdown-menu\">" . $links . "</ul>";
        }
        $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">" . $body . "</div>";
        $item->Body = $body;
        $item->Visible = $Security->allowList(CurrentProjectID() . 'invoice');
        if ($item->Visible) {
            if ($detailTableLink != "") {
                $detailTableLink .= ",";
            }
            $detailTableLink .= "invoice";
        }
        if ($this->ShowMultipleDetails) {
            $item->Visible = false;
        }

        // Multiple details
        if ($this->ShowMultipleDetails) {
            $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">";
            $links = "";
            if ($detailViewTblVar != "") {
                $links .= "<li><a class=\"ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailViewLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailViewTblVar))) . "\">" . HtmlImageAndText($Language->phrase("MasterDetailViewLink")) . "</a></li>";
            }
            if ($detailEditTblVar != "") {
                $links .= "<li><a class=\"ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailEditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailEditTblVar))) . "\">" . HtmlImageAndText($Language->phrase("MasterDetailEditLink")) . "</a></li>";
            }
            if ($detailCopyTblVar != "") {
                $links .= "<li><a class=\"ew-row-link ew-detail-copy\" data-action=\"add\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailCopyLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getCopyUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailCopyTblVar))) . "\">" . HtmlImageAndText($Language->phrase("MasterDetailCopyLink")) . "</a></li>";
            }
            if ($links != "") {
                $body .= "<button class=\"dropdown-toggle btn btn-default ew-master-detail\" title=\"" . HtmlTitle($Language->phrase("MultipleMasterDetails")) . "\" data-toggle=\"dropdown\">" . $Language->phrase("MultipleMasterDetails") . "</button>";
                $body .= "<ul class=\"dropdown-menu ew-menu\">" . $links . "</ul>";
            }
            $body .= "</div>";
            // Multiple details
            $item = &$option->add("details");
            $item->Body = $body;
        }

        // Set up detail default
        $option = $options["detail"];
        $options["detail"]->DropDownButtonPhrase = $Language->phrase("ButtonDetails");
        $ar = explode(",", $detailTableLink);
        $cnt = count($ar);
        $option->UseDropDownButton = ($cnt > 1);
        $option->UseButtonGroup = true;
        $item = &$option->add($option->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;

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
        $this->level_customer_id->setDbValue($row['level_customer_id']);
        $this->limit_kredit_order->setDbValue($row['limit_kredit_order']);
        $this->jatuh_tempo_invoice->setDbValue($row['jatuh_tempo_invoice']);
        $this->keterangan->setDbValue($row['keterangan']);
        $this->aktif->setDbValue($row['aktif']);
        $this->created_at->setDbValue($row['created_at']);
        $this->updated_at->setDbValue($row['updated_at']);
        $this->created_by->setDbValue($row['created_by']);
        $detailTbl = Container("alamat_customer");
        $detailFilter = $detailTbl->sqlDetailFilter_customer();
        $detailFilter = str_replace("@idcustomer@", AdjustSql($this->id->DbValue, "DB"), $detailFilter);
        $detailTbl->setCurrentMasterTable("customer");
        $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
        $detailTbl->Count = $detailTbl->loadRecordCount($detailFilter);
        $detailTbl = Container("brand");
        $detailFilter = $detailTbl->sqlDetailFilter_customer();
        $detailFilter = str_replace("@idcustomer@", AdjustSql($this->id->DbValue, "DB"), $detailFilter);
        $detailTbl->setCurrentMasterTable("customer");
        $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
        $detailTbl->Count = $detailTbl->loadRecordCount($detailFilter);
        $detailTbl = Container("order");
        $detailFilter = $detailTbl->sqlDetailFilter_customer();
        $detailFilter = str_replace("@idcustomer@", AdjustSql($this->id->DbValue, "DB"), $detailFilter);
        $detailTbl->setCurrentMasterTable("customer");
        $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
        $detailTbl->Count = $detailTbl->loadRecordCount($detailFilter);
        $detailTbl = Container("invoice");
        $detailFilter = $detailTbl->sqlDetailFilter_customer();
        $detailFilter = str_replace("@idcustomer@", AdjustSql($this->id->DbValue, "DB"), $detailFilter);
        $detailTbl->setCurrentMasterTable("customer");
        $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
        $detailTbl->Count = $detailTbl->loadRecordCount($detailFilter);
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
        $row['level_customer_id'] = null;
        $row['limit_kredit_order'] = null;
        $row['jatuh_tempo_invoice'] = null;
        $row['keterangan'] = null;
        $row['aktif'] = null;
        $row['created_at'] = null;
        $row['updated_at'] = null;
        $row['created_by'] = null;
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

        // level_customer_id

        // limit_kredit_order

        // jatuh_tempo_invoice

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

            // level_customer_id
            $curVal = trim(strval($this->level_customer_id->CurrentValue));
            if ($curVal != "") {
                $this->level_customer_id->ViewValue = $this->level_customer_id->lookupCacheOption($curVal);
                if ($this->level_customer_id->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->level_customer_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->level_customer_id->Lookup->renderViewRow($rswrk[0]);
                        $this->level_customer_id->ViewValue = $this->level_customer_id->displayValue($arwrk);
                    } else {
                        $this->level_customer_id->ViewValue = $this->level_customer_id->CurrentValue;
                    }
                }
            } else {
                $this->level_customer_id->ViewValue = null;
            }
            $this->level_customer_id->ViewCustomAttributes = "";

            // limit_kredit_order
            $this->limit_kredit_order->ViewValue = $this->limit_kredit_order->CurrentValue;
            $this->limit_kredit_order->ViewValue = FormatCurrency($this->limit_kredit_order->ViewValue, 2, -2, -2, -2);
            $this->limit_kredit_order->ViewCustomAttributes = "";

            // jatuh_tempo_invoice
            $curVal = trim(strval($this->jatuh_tempo_invoice->CurrentValue));
            if ($curVal != "") {
                $this->jatuh_tempo_invoice->ViewValue = $this->jatuh_tempo_invoice->lookupCacheOption($curVal);
                if ($this->jatuh_tempo_invoice->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->jatuh_tempo_invoice->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->jatuh_tempo_invoice->Lookup->renderViewRow($rswrk[0]);
                        $this->jatuh_tempo_invoice->ViewValue = $this->jatuh_tempo_invoice->displayValue($arwrk);
                    } else {
                        $this->jatuh_tempo_invoice->ViewValue = $this->jatuh_tempo_invoice->CurrentValue;
                    }
                }
            } else {
                $this->jatuh_tempo_invoice->ViewValue = null;
            }
            $this->jatuh_tempo_invoice->ViewCustomAttributes = "";

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

            // kode
            $this->kode->LinkCustomAttributes = "";
            $this->kode->HrefValue = "";
            $this->kode->TooltipValue = "";

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

            // level_customer_id
            $this->level_customer_id->LinkCustomAttributes = "";
            $this->level_customer_id->HrefValue = "";
            $this->level_customer_id->TooltipValue = "";

            // limit_kredit_order
            $this->limit_kredit_order->LinkCustomAttributes = "";
            $this->limit_kredit_order->HrefValue = "";
            $this->limit_kredit_order->TooltipValue = "";

            // jatuh_tempo_invoice
            $this->jatuh_tempo_invoice->LinkCustomAttributes = "";
            $this->jatuh_tempo_invoice->HrefValue = "";
            $this->jatuh_tempo_invoice->TooltipValue = "";

            // keterangan
            $this->keterangan->LinkCustomAttributes = "";
            $this->keterangan->HrefValue = "";
            $this->keterangan->TooltipValue = "";

            // aktif
            $this->aktif->LinkCustomAttributes = "";
            $this->aktif->HrefValue = "";
            $this->aktif->TooltipValue = "";
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
                if ($detailPageObj->DetailView) {
                    $detailPageObj->CurrentMode = "view";

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
                if ($detailPageObj->DetailView) {
                    $detailPageObj->CurrentMode = "view";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->idcustomer->IsDetailKey = true;
                    $detailPageObj->idcustomer->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->idcustomer->setSessionValue($detailPageObj->idcustomer->CurrentValue);
                }
            }
            if (in_array("order", $detailTblVar)) {
                $detailPageObj = Container("OrderGrid");
                if ($detailPageObj->DetailView) {
                    $detailPageObj->CurrentMode = "view";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->idcustomer->IsDetailKey = true;
                    $detailPageObj->idcustomer->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->idcustomer->setSessionValue($detailPageObj->idcustomer->CurrentValue);
                }
            }
            if (in_array("invoice", $detailTblVar)) {
                $detailPageObj = Container("InvoiceGrid");
                if ($detailPageObj->DetailView) {
                    $detailPageObj->CurrentMode = "view";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->idcustomer->IsDetailKey = true;
                    $detailPageObj->idcustomer->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->idcustomer->setSessionValue($detailPageObj->idcustomer->CurrentValue);
                    $detailPageObj->id->setSessionValue(""); // Clear session key
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
        $pageId = "view";
        $Breadcrumb->add("view", $pageId, $url);
    }

    // Set up detail pages
    protected function setupDetailPages()
    {
        $pages = new SubPages();
        $pages->Style = "tabs";
        $pages->add('alamat_customer');
        $pages->add('brand');
        $pages->add('order');
        $pages->add('invoice');
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
                case "x_level_customer_id":
                    break;
                case "x_jatuh_tempo_invoice":
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
