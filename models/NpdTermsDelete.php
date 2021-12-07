<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class NpdTermsDelete extends NpdTerms
{
    use MessagesTrait;

    // Page ID
    public $PageID = "delete";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'npd_terms';

    // Page object name
    public $PageObjName = "NpdTermsDelete";

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

        // Table object (npd_terms)
        if (!isset($GLOBALS["npd_terms"]) || get_class($GLOBALS["npd_terms"]) == PROJECT_NAMESPACE . "npd_terms") {
            $GLOBALS["npd_terms"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'npd_terms');
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
                $doc = new $class(Container("npd_terms"));
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
            SaveDebugMessage();
            Redirect(GetUrl($url));
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
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $TotalRecords = 0;
    public $RecordCount;
    public $RecKeys = [];
    public $StartRowCount = 1;
    public $RowCount = 0;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm;
        $this->CurrentAction = Param("action"); // Set up current action
        $this->id->setVisibility();
        $this->idnpd->setVisibility();
        $this->status->setVisibility();
        $this->tglsubmit->setVisibility();
        $this->sifat_order->setVisibility();
        $this->ukuran_utama->setVisibility();
        $this->utama_harga_isi->setVisibility();
        $this->utama_harga_isi_order->setVisibility();
        $this->utama_harga_primer->setVisibility();
        $this->utama_harga_primer_order->setVisibility();
        $this->utama_harga_sekunder->setVisibility();
        $this->utama_harga_sekunder_order->setVisibility();
        $this->utama_harga_label->setVisibility();
        $this->utama_harga_label_order->setVisibility();
        $this->utama_harga_total->setVisibility();
        $this->utama_harga_total_order->setVisibility();
        $this->ukuran_lain->setVisibility();
        $this->lain_harga_isi->setVisibility();
        $this->lain_harga_isi_order->setVisibility();
        $this->lain_harga_primer->setVisibility();
        $this->lain_harga_primer_order->setVisibility();
        $this->lain_harga_sekunder->setVisibility();
        $this->lain_harga_sekunder_order->setVisibility();
        $this->lain_harga_label->setVisibility();
        $this->lain_harga_label_order->setVisibility();
        $this->lain_harga_total->setVisibility();
        $this->lain_harga_total_order->setVisibility();
        $this->isi_bahan_aktif->setVisibility();
        $this->isi_bahan_lain->setVisibility();
        $this->isi_parfum->setVisibility();
        $this->isi_estetika->setVisibility();
        $this->kemasan_wadah->setVisibility();
        $this->kemasan_tutup->setVisibility();
        $this->kemasan_sekunder->setVisibility();
        $this->label_desain->setVisibility();
        $this->label_cetak->setVisibility();
        $this->label_lainlain->setVisibility();
        $this->delivery_pickup->setVisibility();
        $this->delivery_singlepoint->setVisibility();
        $this->delivery_multipoint->setVisibility();
        $this->delivery_jumlahpoint->setVisibility();
        $this->delivery_termslain->setVisibility();
        $this->catatan_khusus->Visible = false;
        $this->dibuatdi->setVisibility();
        $this->created_at->setVisibility();
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

        // Set up master/detail parameters
        $this->setupMasterParms();

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Load key parameters
        $this->RecKeys = $this->getRecordKeys(); // Load record keys
        $filter = $this->getFilterFromRecordKeys();
        if ($filter == "") {
            $this->terminate("NpdTermsList"); // Prevent SQL injection, return to list
            return;
        }

        // Set up filter (WHERE Clause)
        $this->CurrentFilter = $filter;

        // Get action
        if (IsApi()) {
            $this->CurrentAction = "delete"; // Delete record directly
        } elseif (Post("action") !== null) {
            $this->CurrentAction = Post("action");
        } elseif (Get("action") == "1") {
            $this->CurrentAction = "delete"; // Delete record directly
        } else {
            $this->CurrentAction = "show"; // Display record
        }
        if ($this->isDelete()) {
            $this->SendEmail = true; // Send email on delete success
            if ($this->deleteRows()) { // Delete rows
                if ($this->getSuccessMessage() == "") {
                    $this->setSuccessMessage($Language->phrase("DeleteSuccess")); // Set up success message
                }
                if (IsApi()) {
                    $this->terminate(true);
                    return;
                } else {
                    $this->terminate($this->getReturnUrl()); // Return to caller
                    return;
                }
            } else { // Delete failed
                if (IsApi()) {
                    $this->terminate();
                    return;
                }
                $this->CurrentAction = "show"; // Display record
            }
        }
        if ($this->isShow()) { // Load records for display
            if ($this->Recordset = $this->loadRecordset()) {
                $this->TotalRecords = $this->Recordset->recordCount(); // Get record count
            }
            if ($this->TotalRecords <= 0) { // No record found, exit
                if ($this->Recordset) {
                    $this->Recordset->close();
                }
                $this->terminate("NpdTermsList"); // Return to list
                return;
            }
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

    // Load recordset
    public function loadRecordset($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load recordset
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $stmt = $sql->execute();
        $rs = new Recordset($stmt, $sql);

        // Call Recordset Selected event
        $this->recordsetSelected($rs);
        return $rs;
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
        $this->status->setDbValue($row['status']);
        $this->tglsubmit->setDbValue($row['tglsubmit']);
        $this->sifat_order->setDbValue($row['sifat_order']);
        $this->ukuran_utama->setDbValue($row['ukuran_utama']);
        $this->utama_harga_isi->setDbValue($row['utama_harga_isi']);
        $this->utama_harga_isi_order->setDbValue($row['utama_harga_isi_order']);
        $this->utama_harga_primer->setDbValue($row['utama_harga_primer']);
        $this->utama_harga_primer_order->setDbValue($row['utama_harga_primer_order']);
        $this->utama_harga_sekunder->setDbValue($row['utama_harga_sekunder']);
        $this->utama_harga_sekunder_order->setDbValue($row['utama_harga_sekunder_order']);
        $this->utama_harga_label->setDbValue($row['utama_harga_label']);
        $this->utama_harga_label_order->setDbValue($row['utama_harga_label_order']);
        $this->utama_harga_total->setDbValue($row['utama_harga_total']);
        $this->utama_harga_total_order->setDbValue($row['utama_harga_total_order']);
        $this->ukuran_lain->setDbValue($row['ukuran_lain']);
        $this->lain_harga_isi->setDbValue($row['lain_harga_isi']);
        $this->lain_harga_isi_order->setDbValue($row['lain_harga_isi_order']);
        $this->lain_harga_primer->setDbValue($row['lain_harga_primer']);
        $this->lain_harga_primer_order->setDbValue($row['lain_harga_primer_order']);
        $this->lain_harga_sekunder->setDbValue($row['lain_harga_sekunder']);
        $this->lain_harga_sekunder_order->setDbValue($row['lain_harga_sekunder_order']);
        $this->lain_harga_label->setDbValue($row['lain_harga_label']);
        $this->lain_harga_label_order->setDbValue($row['lain_harga_label_order']);
        $this->lain_harga_total->setDbValue($row['lain_harga_total']);
        $this->lain_harga_total_order->setDbValue($row['lain_harga_total_order']);
        $this->isi_bahan_aktif->setDbValue($row['isi_bahan_aktif']);
        $this->isi_bahan_lain->setDbValue($row['isi_bahan_lain']);
        $this->isi_parfum->setDbValue($row['isi_parfum']);
        $this->isi_estetika->setDbValue($row['isi_estetika']);
        $this->kemasan_wadah->setDbValue($row['kemasan_wadah']);
        $this->kemasan_tutup->setDbValue($row['kemasan_tutup']);
        $this->kemasan_sekunder->setDbValue($row['kemasan_sekunder']);
        $this->label_desain->setDbValue($row['label_desain']);
        $this->label_cetak->setDbValue($row['label_cetak']);
        $this->label_lainlain->setDbValue($row['label_lainlain']);
        $this->delivery_pickup->setDbValue($row['delivery_pickup']);
        $this->delivery_singlepoint->setDbValue($row['delivery_singlepoint']);
        $this->delivery_multipoint->setDbValue($row['delivery_multipoint']);
        $this->delivery_jumlahpoint->setDbValue($row['delivery_jumlahpoint']);
        $this->delivery_termslain->setDbValue($row['delivery_termslain']);
        $this->catatan_khusus->setDbValue($row['catatan_khusus']);
        $this->dibuatdi->setDbValue($row['dibuatdi']);
        $this->created_at->setDbValue($row['created_at']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['idnpd'] = null;
        $row['status'] = null;
        $row['tglsubmit'] = null;
        $row['sifat_order'] = null;
        $row['ukuran_utama'] = null;
        $row['utama_harga_isi'] = null;
        $row['utama_harga_isi_order'] = null;
        $row['utama_harga_primer'] = null;
        $row['utama_harga_primer_order'] = null;
        $row['utama_harga_sekunder'] = null;
        $row['utama_harga_sekunder_order'] = null;
        $row['utama_harga_label'] = null;
        $row['utama_harga_label_order'] = null;
        $row['utama_harga_total'] = null;
        $row['utama_harga_total_order'] = null;
        $row['ukuran_lain'] = null;
        $row['lain_harga_isi'] = null;
        $row['lain_harga_isi_order'] = null;
        $row['lain_harga_primer'] = null;
        $row['lain_harga_primer_order'] = null;
        $row['lain_harga_sekunder'] = null;
        $row['lain_harga_sekunder_order'] = null;
        $row['lain_harga_label'] = null;
        $row['lain_harga_label_order'] = null;
        $row['lain_harga_total'] = null;
        $row['lain_harga_total_order'] = null;
        $row['isi_bahan_aktif'] = null;
        $row['isi_bahan_lain'] = null;
        $row['isi_parfum'] = null;
        $row['isi_estetika'] = null;
        $row['kemasan_wadah'] = null;
        $row['kemasan_tutup'] = null;
        $row['kemasan_sekunder'] = null;
        $row['label_desain'] = null;
        $row['label_cetak'] = null;
        $row['label_lainlain'] = null;
        $row['delivery_pickup'] = null;
        $row['delivery_singlepoint'] = null;
        $row['delivery_multipoint'] = null;
        $row['delivery_jumlahpoint'] = null;
        $row['delivery_termslain'] = null;
        $row['catatan_khusus'] = null;
        $row['dibuatdi'] = null;
        $row['created_at'] = null;
        return $row;
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

        // status

        // tglsubmit

        // sifat_order

        // ukuran_utama

        // utama_harga_isi

        // utama_harga_isi_order

        // utama_harga_primer

        // utama_harga_primer_order

        // utama_harga_sekunder

        // utama_harga_sekunder_order

        // utama_harga_label

        // utama_harga_label_order

        // utama_harga_total

        // utama_harga_total_order

        // ukuran_lain

        // lain_harga_isi

        // lain_harga_isi_order

        // lain_harga_primer

        // lain_harga_primer_order

        // lain_harga_sekunder

        // lain_harga_sekunder_order

        // lain_harga_label

        // lain_harga_label_order

        // lain_harga_total

        // lain_harga_total_order

        // isi_bahan_aktif

        // isi_bahan_lain

        // isi_parfum

        // isi_estetika

        // kemasan_wadah

        // kemasan_tutup

        // kemasan_sekunder

        // label_desain

        // label_cetak

        // label_lainlain

        // delivery_pickup

        // delivery_singlepoint

        // delivery_multipoint

        // delivery_jumlahpoint

        // delivery_termslain

        // catatan_khusus

        // dibuatdi

        // created_at
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // idnpd
            $this->idnpd->ViewValue = $this->idnpd->CurrentValue;
            $this->idnpd->ViewValue = FormatNumber($this->idnpd->ViewValue, 0, -2, -2, -2);
            $this->idnpd->ViewCustomAttributes = "";

            // status
            $this->status->ViewValue = $this->status->CurrentValue;
            $this->status->ViewCustomAttributes = "";

            // tglsubmit
            $this->tglsubmit->ViewValue = $this->tglsubmit->CurrentValue;
            $this->tglsubmit->ViewValue = FormatDateTime($this->tglsubmit->ViewValue, 0);
            $this->tglsubmit->ViewCustomAttributes = "";

            // sifat_order
            if (ConvertToBool($this->sifat_order->CurrentValue)) {
                $this->sifat_order->ViewValue = $this->sifat_order->tagCaption(1) != "" ? $this->sifat_order->tagCaption(1) : "Yes";
            } else {
                $this->sifat_order->ViewValue = $this->sifat_order->tagCaption(2) != "" ? $this->sifat_order->tagCaption(2) : "No";
            }
            $this->sifat_order->ViewCustomAttributes = "";

            // ukuran_utama
            $this->ukuran_utama->ViewValue = $this->ukuran_utama->CurrentValue;
            $this->ukuran_utama->ViewCustomAttributes = "";

            // utama_harga_isi
            $this->utama_harga_isi->ViewValue = $this->utama_harga_isi->CurrentValue;
            $this->utama_harga_isi->ViewValue = FormatNumber($this->utama_harga_isi->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_isi->ViewCustomAttributes = "";

            // utama_harga_isi_order
            $this->utama_harga_isi_order->ViewValue = $this->utama_harga_isi_order->CurrentValue;
            $this->utama_harga_isi_order->ViewValue = FormatNumber($this->utama_harga_isi_order->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_isi_order->ViewCustomAttributes = "";

            // utama_harga_primer
            $this->utama_harga_primer->ViewValue = $this->utama_harga_primer->CurrentValue;
            $this->utama_harga_primer->ViewValue = FormatNumber($this->utama_harga_primer->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_primer->ViewCustomAttributes = "";

            // utama_harga_primer_order
            $this->utama_harga_primer_order->ViewValue = $this->utama_harga_primer_order->CurrentValue;
            $this->utama_harga_primer_order->ViewValue = FormatNumber($this->utama_harga_primer_order->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_primer_order->ViewCustomAttributes = "";

            // utama_harga_sekunder
            $this->utama_harga_sekunder->ViewValue = $this->utama_harga_sekunder->CurrentValue;
            $this->utama_harga_sekunder->ViewValue = FormatNumber($this->utama_harga_sekunder->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_sekunder->ViewCustomAttributes = "";

            // utama_harga_sekunder_order
            $this->utama_harga_sekunder_order->ViewValue = $this->utama_harga_sekunder_order->CurrentValue;
            $this->utama_harga_sekunder_order->ViewValue = FormatNumber($this->utama_harga_sekunder_order->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_sekunder_order->ViewCustomAttributes = "";

            // utama_harga_label
            $this->utama_harga_label->ViewValue = $this->utama_harga_label->CurrentValue;
            $this->utama_harga_label->ViewValue = FormatNumber($this->utama_harga_label->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_label->ViewCustomAttributes = "";

            // utama_harga_label_order
            $this->utama_harga_label_order->ViewValue = $this->utama_harga_label_order->CurrentValue;
            $this->utama_harga_label_order->ViewValue = FormatNumber($this->utama_harga_label_order->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_label_order->ViewCustomAttributes = "";

            // utama_harga_total
            $this->utama_harga_total->ViewValue = $this->utama_harga_total->CurrentValue;
            $this->utama_harga_total->ViewValue = FormatNumber($this->utama_harga_total->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_total->ViewCustomAttributes = "";

            // utama_harga_total_order
            $this->utama_harga_total_order->ViewValue = $this->utama_harga_total_order->CurrentValue;
            $this->utama_harga_total_order->ViewValue = FormatNumber($this->utama_harga_total_order->ViewValue, 0, -2, -2, -2);
            $this->utama_harga_total_order->ViewCustomAttributes = "";

            // ukuran_lain
            $this->ukuran_lain->ViewValue = $this->ukuran_lain->CurrentValue;
            $this->ukuran_lain->ViewCustomAttributes = "";

            // lain_harga_isi
            $this->lain_harga_isi->ViewValue = $this->lain_harga_isi->CurrentValue;
            $this->lain_harga_isi->ViewValue = FormatNumber($this->lain_harga_isi->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_isi->ViewCustomAttributes = "";

            // lain_harga_isi_order
            $this->lain_harga_isi_order->ViewValue = $this->lain_harga_isi_order->CurrentValue;
            $this->lain_harga_isi_order->ViewValue = FormatNumber($this->lain_harga_isi_order->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_isi_order->ViewCustomAttributes = "";

            // lain_harga_primer
            $this->lain_harga_primer->ViewValue = $this->lain_harga_primer->CurrentValue;
            $this->lain_harga_primer->ViewValue = FormatNumber($this->lain_harga_primer->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_primer->ViewCustomAttributes = "";

            // lain_harga_primer_order
            $this->lain_harga_primer_order->ViewValue = $this->lain_harga_primer_order->CurrentValue;
            $this->lain_harga_primer_order->ViewValue = FormatNumber($this->lain_harga_primer_order->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_primer_order->ViewCustomAttributes = "";

            // lain_harga_sekunder
            $this->lain_harga_sekunder->ViewValue = $this->lain_harga_sekunder->CurrentValue;
            $this->lain_harga_sekunder->ViewValue = FormatNumber($this->lain_harga_sekunder->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_sekunder->ViewCustomAttributes = "";

            // lain_harga_sekunder_order
            $this->lain_harga_sekunder_order->ViewValue = $this->lain_harga_sekunder_order->CurrentValue;
            $this->lain_harga_sekunder_order->ViewValue = FormatNumber($this->lain_harga_sekunder_order->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_sekunder_order->ViewCustomAttributes = "";

            // lain_harga_label
            $this->lain_harga_label->ViewValue = $this->lain_harga_label->CurrentValue;
            $this->lain_harga_label->ViewValue = FormatNumber($this->lain_harga_label->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_label->ViewCustomAttributes = "";

            // lain_harga_label_order
            $this->lain_harga_label_order->ViewValue = $this->lain_harga_label_order->CurrentValue;
            $this->lain_harga_label_order->ViewValue = FormatNumber($this->lain_harga_label_order->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_label_order->ViewCustomAttributes = "";

            // lain_harga_total
            $this->lain_harga_total->ViewValue = $this->lain_harga_total->CurrentValue;
            $this->lain_harga_total->ViewValue = FormatNumber($this->lain_harga_total->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_total->ViewCustomAttributes = "";

            // lain_harga_total_order
            $this->lain_harga_total_order->ViewValue = $this->lain_harga_total_order->CurrentValue;
            $this->lain_harga_total_order->ViewValue = FormatNumber($this->lain_harga_total_order->ViewValue, 0, -2, -2, -2);
            $this->lain_harga_total_order->ViewCustomAttributes = "";

            // isi_bahan_aktif
            $this->isi_bahan_aktif->ViewValue = $this->isi_bahan_aktif->CurrentValue;
            $this->isi_bahan_aktif->ViewCustomAttributes = "";

            // isi_bahan_lain
            $this->isi_bahan_lain->ViewValue = $this->isi_bahan_lain->CurrentValue;
            $this->isi_bahan_lain->ViewCustomAttributes = "";

            // isi_parfum
            $this->isi_parfum->ViewValue = $this->isi_parfum->CurrentValue;
            $this->isi_parfum->ViewCustomAttributes = "";

            // isi_estetika
            $this->isi_estetika->ViewValue = $this->isi_estetika->CurrentValue;
            $this->isi_estetika->ViewCustomAttributes = "";

            // kemasan_wadah
            $this->kemasan_wadah->ViewValue = $this->kemasan_wadah->CurrentValue;
            $this->kemasan_wadah->ViewValue = FormatNumber($this->kemasan_wadah->ViewValue, 0, -2, -2, -2);
            $this->kemasan_wadah->ViewCustomAttributes = "";

            // kemasan_tutup
            $this->kemasan_tutup->ViewValue = $this->kemasan_tutup->CurrentValue;
            $this->kemasan_tutup->ViewValue = FormatNumber($this->kemasan_tutup->ViewValue, 0, -2, -2, -2);
            $this->kemasan_tutup->ViewCustomAttributes = "";

            // kemasan_sekunder
            $this->kemasan_sekunder->ViewValue = $this->kemasan_sekunder->CurrentValue;
            $this->kemasan_sekunder->ViewCustomAttributes = "";

            // label_desain
            $this->label_desain->ViewValue = $this->label_desain->CurrentValue;
            $this->label_desain->ViewCustomAttributes = "";

            // label_cetak
            $this->label_cetak->ViewValue = $this->label_cetak->CurrentValue;
            $this->label_cetak->ViewCustomAttributes = "";

            // label_lainlain
            $this->label_lainlain->ViewValue = $this->label_lainlain->CurrentValue;
            $this->label_lainlain->ViewCustomAttributes = "";

            // delivery_pickup
            $this->delivery_pickup->ViewValue = $this->delivery_pickup->CurrentValue;
            $this->delivery_pickup->ViewCustomAttributes = "";

            // delivery_singlepoint
            $this->delivery_singlepoint->ViewValue = $this->delivery_singlepoint->CurrentValue;
            $this->delivery_singlepoint->ViewCustomAttributes = "";

            // delivery_multipoint
            $this->delivery_multipoint->ViewValue = $this->delivery_multipoint->CurrentValue;
            $this->delivery_multipoint->ViewCustomAttributes = "";

            // delivery_jumlahpoint
            $this->delivery_jumlahpoint->ViewValue = $this->delivery_jumlahpoint->CurrentValue;
            $this->delivery_jumlahpoint->ViewCustomAttributes = "";

            // delivery_termslain
            $this->delivery_termslain->ViewValue = $this->delivery_termslain->CurrentValue;
            $this->delivery_termslain->ViewCustomAttributes = "";

            // dibuatdi
            $this->dibuatdi->ViewValue = $this->dibuatdi->CurrentValue;
            $this->dibuatdi->ViewCustomAttributes = "";

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
            $this->created_at->ViewCustomAttributes = "";

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";
            $this->id->TooltipValue = "";

            // idnpd
            $this->idnpd->LinkCustomAttributes = "";
            $this->idnpd->HrefValue = "";
            $this->idnpd->TooltipValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
            $this->status->TooltipValue = "";

            // tglsubmit
            $this->tglsubmit->LinkCustomAttributes = "";
            $this->tglsubmit->HrefValue = "";
            $this->tglsubmit->TooltipValue = "";

            // sifat_order
            $this->sifat_order->LinkCustomAttributes = "";
            $this->sifat_order->HrefValue = "";
            $this->sifat_order->TooltipValue = "";

            // ukuran_utama
            $this->ukuran_utama->LinkCustomAttributes = "";
            $this->ukuran_utama->HrefValue = "";
            $this->ukuran_utama->TooltipValue = "";

            // utama_harga_isi
            $this->utama_harga_isi->LinkCustomAttributes = "";
            $this->utama_harga_isi->HrefValue = "";
            $this->utama_harga_isi->TooltipValue = "";

            // utama_harga_isi_order
            $this->utama_harga_isi_order->LinkCustomAttributes = "";
            $this->utama_harga_isi_order->HrefValue = "";
            $this->utama_harga_isi_order->TooltipValue = "";

            // utama_harga_primer
            $this->utama_harga_primer->LinkCustomAttributes = "";
            $this->utama_harga_primer->HrefValue = "";
            $this->utama_harga_primer->TooltipValue = "";

            // utama_harga_primer_order
            $this->utama_harga_primer_order->LinkCustomAttributes = "";
            $this->utama_harga_primer_order->HrefValue = "";
            $this->utama_harga_primer_order->TooltipValue = "";

            // utama_harga_sekunder
            $this->utama_harga_sekunder->LinkCustomAttributes = "";
            $this->utama_harga_sekunder->HrefValue = "";
            $this->utama_harga_sekunder->TooltipValue = "";

            // utama_harga_sekunder_order
            $this->utama_harga_sekunder_order->LinkCustomAttributes = "";
            $this->utama_harga_sekunder_order->HrefValue = "";
            $this->utama_harga_sekunder_order->TooltipValue = "";

            // utama_harga_label
            $this->utama_harga_label->LinkCustomAttributes = "";
            $this->utama_harga_label->HrefValue = "";
            $this->utama_harga_label->TooltipValue = "";

            // utama_harga_label_order
            $this->utama_harga_label_order->LinkCustomAttributes = "";
            $this->utama_harga_label_order->HrefValue = "";
            $this->utama_harga_label_order->TooltipValue = "";

            // utama_harga_total
            $this->utama_harga_total->LinkCustomAttributes = "";
            $this->utama_harga_total->HrefValue = "";
            $this->utama_harga_total->TooltipValue = "";

            // utama_harga_total_order
            $this->utama_harga_total_order->LinkCustomAttributes = "";
            $this->utama_harga_total_order->HrefValue = "";
            $this->utama_harga_total_order->TooltipValue = "";

            // ukuran_lain
            $this->ukuran_lain->LinkCustomAttributes = "";
            $this->ukuran_lain->HrefValue = "";
            $this->ukuran_lain->TooltipValue = "";

            // lain_harga_isi
            $this->lain_harga_isi->LinkCustomAttributes = "";
            $this->lain_harga_isi->HrefValue = "";
            $this->lain_harga_isi->TooltipValue = "";

            // lain_harga_isi_order
            $this->lain_harga_isi_order->LinkCustomAttributes = "";
            $this->lain_harga_isi_order->HrefValue = "";
            $this->lain_harga_isi_order->TooltipValue = "";

            // lain_harga_primer
            $this->lain_harga_primer->LinkCustomAttributes = "";
            $this->lain_harga_primer->HrefValue = "";
            $this->lain_harga_primer->TooltipValue = "";

            // lain_harga_primer_order
            $this->lain_harga_primer_order->LinkCustomAttributes = "";
            $this->lain_harga_primer_order->HrefValue = "";
            $this->lain_harga_primer_order->TooltipValue = "";

            // lain_harga_sekunder
            $this->lain_harga_sekunder->LinkCustomAttributes = "";
            $this->lain_harga_sekunder->HrefValue = "";
            $this->lain_harga_sekunder->TooltipValue = "";

            // lain_harga_sekunder_order
            $this->lain_harga_sekunder_order->LinkCustomAttributes = "";
            $this->lain_harga_sekunder_order->HrefValue = "";
            $this->lain_harga_sekunder_order->TooltipValue = "";

            // lain_harga_label
            $this->lain_harga_label->LinkCustomAttributes = "";
            $this->lain_harga_label->HrefValue = "";
            $this->lain_harga_label->TooltipValue = "";

            // lain_harga_label_order
            $this->lain_harga_label_order->LinkCustomAttributes = "";
            $this->lain_harga_label_order->HrefValue = "";
            $this->lain_harga_label_order->TooltipValue = "";

            // lain_harga_total
            $this->lain_harga_total->LinkCustomAttributes = "";
            $this->lain_harga_total->HrefValue = "";
            $this->lain_harga_total->TooltipValue = "";

            // lain_harga_total_order
            $this->lain_harga_total_order->LinkCustomAttributes = "";
            $this->lain_harga_total_order->HrefValue = "";
            $this->lain_harga_total_order->TooltipValue = "";

            // isi_bahan_aktif
            $this->isi_bahan_aktif->LinkCustomAttributes = "";
            $this->isi_bahan_aktif->HrefValue = "";
            $this->isi_bahan_aktif->TooltipValue = "";

            // isi_bahan_lain
            $this->isi_bahan_lain->LinkCustomAttributes = "";
            $this->isi_bahan_lain->HrefValue = "";
            $this->isi_bahan_lain->TooltipValue = "";

            // isi_parfum
            $this->isi_parfum->LinkCustomAttributes = "";
            $this->isi_parfum->HrefValue = "";
            $this->isi_parfum->TooltipValue = "";

            // isi_estetika
            $this->isi_estetika->LinkCustomAttributes = "";
            $this->isi_estetika->HrefValue = "";
            $this->isi_estetika->TooltipValue = "";

            // kemasan_wadah
            $this->kemasan_wadah->LinkCustomAttributes = "";
            $this->kemasan_wadah->HrefValue = "";
            $this->kemasan_wadah->TooltipValue = "";

            // kemasan_tutup
            $this->kemasan_tutup->LinkCustomAttributes = "";
            $this->kemasan_tutup->HrefValue = "";
            $this->kemasan_tutup->TooltipValue = "";

            // kemasan_sekunder
            $this->kemasan_sekunder->LinkCustomAttributes = "";
            $this->kemasan_sekunder->HrefValue = "";
            $this->kemasan_sekunder->TooltipValue = "";

            // label_desain
            $this->label_desain->LinkCustomAttributes = "";
            $this->label_desain->HrefValue = "";
            $this->label_desain->TooltipValue = "";

            // label_cetak
            $this->label_cetak->LinkCustomAttributes = "";
            $this->label_cetak->HrefValue = "";
            $this->label_cetak->TooltipValue = "";

            // label_lainlain
            $this->label_lainlain->LinkCustomAttributes = "";
            $this->label_lainlain->HrefValue = "";
            $this->label_lainlain->TooltipValue = "";

            // delivery_pickup
            $this->delivery_pickup->LinkCustomAttributes = "";
            $this->delivery_pickup->HrefValue = "";
            $this->delivery_pickup->TooltipValue = "";

            // delivery_singlepoint
            $this->delivery_singlepoint->LinkCustomAttributes = "";
            $this->delivery_singlepoint->HrefValue = "";
            $this->delivery_singlepoint->TooltipValue = "";

            // delivery_multipoint
            $this->delivery_multipoint->LinkCustomAttributes = "";
            $this->delivery_multipoint->HrefValue = "";
            $this->delivery_multipoint->TooltipValue = "";

            // delivery_jumlahpoint
            $this->delivery_jumlahpoint->LinkCustomAttributes = "";
            $this->delivery_jumlahpoint->HrefValue = "";
            $this->delivery_jumlahpoint->TooltipValue = "";

            // delivery_termslain
            $this->delivery_termslain->LinkCustomAttributes = "";
            $this->delivery_termslain->HrefValue = "";
            $this->delivery_termslain->TooltipValue = "";

            // dibuatdi
            $this->dibuatdi->LinkCustomAttributes = "";
            $this->dibuatdi->HrefValue = "";
            $this->dibuatdi->TooltipValue = "";

            // created_at
            $this->created_at->LinkCustomAttributes = "";
            $this->created_at->HrefValue = "";
            $this->created_at->TooltipValue = "";
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Delete records based on current filter
    protected function deleteRows()
    {
        global $Language, $Security;
        if (!$Security->canDelete()) {
            $this->setFailureMessage($Language->phrase("NoDeletePermission")); // No delete permission
            return false;
        }
        $deleteRows = true;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $rows = $conn->fetchAll($sql);
        if (count($rows) == 0) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
            return false;
        }
        $conn->beginTransaction();

        // Clone old rows
        $rsold = $rows;

        // Call row deleting event
        if ($deleteRows) {
            foreach ($rsold as $row) {
                $deleteRows = $this->rowDeleting($row);
                if (!$deleteRows) {
                    break;
                }
            }
        }
        if ($deleteRows) {
            $key = "";
            foreach ($rsold as $row) {
                $thisKey = "";
                if ($thisKey != "") {
                    $thisKey .= Config("COMPOSITE_KEY_SEPARATOR");
                }
                $thisKey .= $row['id'];
                if (Config("DELETE_UPLOADED_FILES")) { // Delete old files
                    $this->deleteUploadedFiles($row);
                }
                $deleteRows = $this->delete($row); // Delete
                if ($deleteRows === false) {
                    break;
                }
                if ($key != "") {
                    $key .= ", ";
                }
                $key .= $thisKey;
            }
        }
        if (!$deleteRows) {
            // Set up error message
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("DeleteCancelled"));
            }
        }
        if ($deleteRows) {
            $conn->commit(); // Commit the changes
        } else {
            $conn->rollback(); // Rollback changes
        }

        // Call Row Deleted event
        if ($deleteRows) {
            foreach ($rsold as $row) {
                $this->rowDeleted($row);
            }
        }

        // Write JSON for API request
        if (IsApi() && $deleteRows) {
            $row = $this->getRecordsFromRecordset($rsold);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $deleteRows;
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("NpdTermsList"), "", $this->TableVar, true);
        $pageId = "delete";
        $Breadcrumb->add("delete", $pageId, $url);
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
                case "x_sifat_order":
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
}
