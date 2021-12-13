<?php

namespace PHPMaker2021\distributor;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class PenagihanDelete extends Penagihan
{
    use MessagesTrait;

    // Page ID
    public $PageID = "delete";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'penagihan';

    // Page object name
    public $PageObjName = "PenagihanDelete";

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

        // Table object (penagihan)
        if (!isset($GLOBALS["penagihan"]) || get_class($GLOBALS["penagihan"]) == PROJECT_NAMESPACE . "penagihan") {
            $GLOBALS["penagihan"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'penagihan');
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
                $doc = new $class(Container("penagihan"));
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
        $this->id->Visible = false;
        $this->messages->Visible = false;
        $this->tgl_order->setVisibility();
        $this->kode_order->setVisibility();
        $this->nama_customer->setVisibility();
        $this->nomor_handphone->setVisibility();
        $this->nilai_po->setVisibility();
        $this->tgl_faktur->setVisibility();
        $this->nilai_faktur->setVisibility();
        $this->piutang->setVisibility();
        $this->umur_faktur->setVisibility();
        $this->tgl_antrian->setVisibility();
        $this->status->setVisibility();
        $this->tgl_penagihan->setVisibility();
        $this->tgl_return->setVisibility();
        $this->tgl_cancel->setVisibility();
        $this->messagets->Visible = false;
        $this->statusts->setVisibility();
        $this->statusbayar->setVisibility();
        $this->nomorfaktur->setVisibility();
        $this->pembayaran->setVisibility();
        $this->keterangan->setVisibility();
        $this->saldo->setVisibility();
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

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Load key parameters
        $this->RecKeys = $this->getRecordKeys(); // Load record keys
        $filter = $this->getFilterFromRecordKeys();
        if ($filter == "") {
            $this->terminate("PenagihanList"); // Prevent SQL injection, return to list
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
                $this->terminate("PenagihanList"); // Return to list
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
        $this->messages->setDbValue($row['messages']);
        $this->tgl_order->setDbValue($row['tgl_order']);
        $this->kode_order->setDbValue($row['kode_order']);
        $this->nama_customer->setDbValue($row['nama_customer']);
        $this->nomor_handphone->setDbValue($row['nomor_handphone']);
        $this->nilai_po->setDbValue($row['nilai_po']);
        $this->tgl_faktur->setDbValue($row['tgl_faktur']);
        $this->nilai_faktur->setDbValue($row['nilai_faktur']);
        $this->piutang->setDbValue($row['piutang']);
        $this->umur_faktur->setDbValue($row['umur_faktur']);
        $this->tgl_antrian->setDbValue($row['tgl_antrian']);
        $this->status->setDbValue($row['status']);
        $this->tgl_penagihan->setDbValue($row['tgl_penagihan']);
        $this->tgl_return->setDbValue($row['tgl_return']);
        $this->tgl_cancel->setDbValue($row['tgl_cancel']);
        $this->messagets->setDbValue($row['messagets']);
        $this->statusts->setDbValue($row['statusts']);
        $this->statusbayar->setDbValue($row['statusbayar']);
        $this->nomorfaktur->setDbValue($row['nomorfaktur']);
        $this->pembayaran->setDbValue($row['pembayaran']);
        $this->keterangan->setDbValue($row['keterangan']);
        $this->saldo->setDbValue($row['saldo']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['messages'] = null;
        $row['tgl_order'] = null;
        $row['kode_order'] = null;
        $row['nama_customer'] = null;
        $row['nomor_handphone'] = null;
        $row['nilai_po'] = null;
        $row['tgl_faktur'] = null;
        $row['nilai_faktur'] = null;
        $row['piutang'] = null;
        $row['umur_faktur'] = null;
        $row['tgl_antrian'] = null;
        $row['status'] = null;
        $row['tgl_penagihan'] = null;
        $row['tgl_return'] = null;
        $row['tgl_cancel'] = null;
        $row['messagets'] = null;
        $row['statusts'] = null;
        $row['statusbayar'] = null;
        $row['nomorfaktur'] = null;
        $row['pembayaran'] = null;
        $row['keterangan'] = null;
        $row['saldo'] = null;
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

        // messages

        // tgl_order

        // kode_order

        // nama_customer

        // nomor_handphone

        // nilai_po

        // tgl_faktur

        // nilai_faktur

        // piutang

        // umur_faktur

        // tgl_antrian

        // status

        // tgl_penagihan

        // tgl_return

        // tgl_cancel

        // messagets

        // statusts

        // statusbayar

        // nomorfaktur

        // pembayaran

        // keterangan

        // saldo
        if ($this->RowType == ROWTYPE_VIEW) {
            // tgl_order
            $this->tgl_order->ViewValue = $this->tgl_order->CurrentValue;
            $this->tgl_order->ViewValue = FormatDateTime($this->tgl_order->ViewValue, 0);
            $this->tgl_order->ViewCustomAttributes = "";

            // kode_order
            $this->kode_order->ViewValue = $this->kode_order->CurrentValue;
            $this->kode_order->ViewCustomAttributes = "";

            // nama_customer
            $this->nama_customer->ViewValue = $this->nama_customer->CurrentValue;
            $this->nama_customer->ViewCustomAttributes = "";

            // nomor_handphone
            $this->nomor_handphone->ViewValue = $this->nomor_handphone->CurrentValue;
            $this->nomor_handphone->ViewCustomAttributes = "";

            // nilai_po
            $this->nilai_po->ViewValue = $this->nilai_po->CurrentValue;
            $this->nilai_po->ViewValue = FormatNumber($this->nilai_po->ViewValue, 0, -2, -2, -2);
            $this->nilai_po->ViewCustomAttributes = "";

            // tgl_faktur
            $this->tgl_faktur->ViewValue = $this->tgl_faktur->CurrentValue;
            $this->tgl_faktur->ViewValue = FormatDateTime($this->tgl_faktur->ViewValue, 0);
            $this->tgl_faktur->ViewCustomAttributes = "";

            // nilai_faktur
            $this->nilai_faktur->ViewValue = $this->nilai_faktur->CurrentValue;
            $this->nilai_faktur->ViewValue = FormatNumber($this->nilai_faktur->ViewValue, 0, -2, -2, -2);
            $this->nilai_faktur->ViewCustomAttributes = "";

            // piutang
            $this->piutang->ViewValue = $this->piutang->CurrentValue;
            $this->piutang->ViewValue = FormatNumber($this->piutang->ViewValue, 0, -2, -2, -2);
            $this->piutang->ViewCustomAttributes = "";

            // umur_faktur
            $this->umur_faktur->ViewValue = $this->umur_faktur->CurrentValue;
            $this->umur_faktur->ViewValue = FormatNumber($this->umur_faktur->ViewValue, 0, -2, -2, -2);
            $this->umur_faktur->ViewCustomAttributes = "";

            // tgl_antrian
            $this->tgl_antrian->ViewValue = $this->tgl_antrian->CurrentValue;
            $this->tgl_antrian->ViewValue = FormatDateTime($this->tgl_antrian->ViewValue, 0);
            $this->tgl_antrian->ViewCustomAttributes = "";

            // status
            if (ConvertToBool($this->status->CurrentValue)) {
                $this->status->ViewValue = $this->status->tagCaption(1) != "" ? $this->status->tagCaption(1) : "Yes";
            } else {
                $this->status->ViewValue = $this->status->tagCaption(2) != "" ? $this->status->tagCaption(2) : "No";
            }
            $this->status->ViewCustomAttributes = "";

            // tgl_penagihan
            $this->tgl_penagihan->ViewValue = $this->tgl_penagihan->CurrentValue;
            $this->tgl_penagihan->ViewValue = FormatDateTime($this->tgl_penagihan->ViewValue, 0);
            $this->tgl_penagihan->ViewCustomAttributes = "";

            // tgl_return
            $this->tgl_return->ViewValue = $this->tgl_return->CurrentValue;
            $this->tgl_return->ViewValue = FormatDateTime($this->tgl_return->ViewValue, 0);
            $this->tgl_return->ViewCustomAttributes = "";

            // tgl_cancel
            $this->tgl_cancel->ViewValue = $this->tgl_cancel->CurrentValue;
            $this->tgl_cancel->ViewValue = FormatDateTime($this->tgl_cancel->ViewValue, 0);
            $this->tgl_cancel->ViewCustomAttributes = "";

            // statusts
            $this->statusts->ViewValue = $this->statusts->CurrentValue;
            $this->statusts->ViewValue = FormatNumber($this->statusts->ViewValue, 0, -2, -2, -2);
            $this->statusts->ViewCustomAttributes = "";

            // statusbayar
            $this->statusbayar->ViewValue = $this->statusbayar->CurrentValue;
            $this->statusbayar->ViewCustomAttributes = "";

            // nomorfaktur
            $this->nomorfaktur->ViewValue = $this->nomorfaktur->CurrentValue;
            $this->nomorfaktur->ViewCustomAttributes = "";

            // pembayaran
            $this->pembayaran->ViewValue = $this->pembayaran->CurrentValue;
            $this->pembayaran->ViewValue = FormatNumber($this->pembayaran->ViewValue, 0, -2, -2, -2);
            $this->pembayaran->ViewCustomAttributes = "";

            // keterangan
            $this->keterangan->ViewValue = $this->keterangan->CurrentValue;
            $this->keterangan->ViewCustomAttributes = "";

            // saldo
            $this->saldo->ViewValue = $this->saldo->CurrentValue;
            $this->saldo->ViewValue = FormatNumber($this->saldo->ViewValue, 0, -2, -2, -2);
            $this->saldo->ViewCustomAttributes = "";

            // tgl_order
            $this->tgl_order->LinkCustomAttributes = "";
            $this->tgl_order->HrefValue = "";
            $this->tgl_order->TooltipValue = "";

            // kode_order
            $this->kode_order->LinkCustomAttributes = "";
            $this->kode_order->HrefValue = "";
            $this->kode_order->TooltipValue = "";

            // nama_customer
            $this->nama_customer->LinkCustomAttributes = "";
            $this->nama_customer->HrefValue = "";
            $this->nama_customer->TooltipValue = "";

            // nomor_handphone
            $this->nomor_handphone->LinkCustomAttributes = "";
            $this->nomor_handphone->HrefValue = "";
            $this->nomor_handphone->TooltipValue = "";

            // nilai_po
            $this->nilai_po->LinkCustomAttributes = "";
            $this->nilai_po->HrefValue = "";
            $this->nilai_po->TooltipValue = "";

            // tgl_faktur
            $this->tgl_faktur->LinkCustomAttributes = "";
            $this->tgl_faktur->HrefValue = "";
            $this->tgl_faktur->TooltipValue = "";

            // nilai_faktur
            $this->nilai_faktur->LinkCustomAttributes = "";
            $this->nilai_faktur->HrefValue = "";
            $this->nilai_faktur->TooltipValue = "";

            // piutang
            $this->piutang->LinkCustomAttributes = "";
            $this->piutang->HrefValue = "";
            $this->piutang->TooltipValue = "";

            // umur_faktur
            $this->umur_faktur->LinkCustomAttributes = "";
            $this->umur_faktur->HrefValue = "";
            $this->umur_faktur->TooltipValue = "";

            // tgl_antrian
            $this->tgl_antrian->LinkCustomAttributes = "";
            $this->tgl_antrian->HrefValue = "";
            $this->tgl_antrian->TooltipValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
            $this->status->TooltipValue = "";

            // tgl_penagihan
            $this->tgl_penagihan->LinkCustomAttributes = "";
            $this->tgl_penagihan->HrefValue = "";
            $this->tgl_penagihan->TooltipValue = "";

            // tgl_return
            $this->tgl_return->LinkCustomAttributes = "";
            $this->tgl_return->HrefValue = "";
            $this->tgl_return->TooltipValue = "";

            // tgl_cancel
            $this->tgl_cancel->LinkCustomAttributes = "";
            $this->tgl_cancel->HrefValue = "";
            $this->tgl_cancel->TooltipValue = "";

            // statusts
            $this->statusts->LinkCustomAttributes = "";
            $this->statusts->HrefValue = "";
            $this->statusts->TooltipValue = "";

            // statusbayar
            $this->statusbayar->LinkCustomAttributes = "";
            $this->statusbayar->HrefValue = "";
            $this->statusbayar->TooltipValue = "";

            // nomorfaktur
            $this->nomorfaktur->LinkCustomAttributes = "";
            $this->nomorfaktur->HrefValue = "";
            $this->nomorfaktur->TooltipValue = "";

            // pembayaran
            $this->pembayaran->LinkCustomAttributes = "";
            $this->pembayaran->HrefValue = "";
            $this->pembayaran->TooltipValue = "";

            // keterangan
            $this->keterangan->LinkCustomAttributes = "";
            $this->keterangan->HrefValue = "";
            $this->keterangan->TooltipValue = "";

            // saldo
            $this->saldo->LinkCustomAttributes = "";
            $this->saldo->HrefValue = "";
            $this->saldo->TooltipValue = "";
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

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("PenagihanList"), "", $this->TableVar, true);
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
                case "x_status":
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
