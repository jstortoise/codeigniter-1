<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
//        $this->load->library('password');

        $this->load->database();
        date_default_timezone_set('UTC');

//        $this->load->helper(array('language', 'form'));
        //        $this->load->library('ion_auth');

        $this->load->model('admin_model');
        $this->load->model('posts_model');
        $this->load->helper(array('tree_helper', 'url'));
        $this->load->library(array('form_validation', 'session'));
        $exception_url = array(
            'admin/login',
            'admin/check_login',
            'admin/logout',
        );
        if (in_array(uri_string(), $exception_url) == false) {
            if ($this->session->userdata('admin_id') != 1) {
                redirect('admin/login');
            }
        }
    }

    public function index()
    {
        $count_members = $this->admin_model->count_members();
        $total_payments = $this->admin_model->sum_payments();
        $this->data['count_members'] = $count_members[0]['count(id)'];
        $total_payments = $total_payments[0]['SUM(total_payments)'];
        if ($total_payments <= 0) {
            $total_payments = "0";
        }
        $this->data['total_payments'] = $total_payments;
        $this->data['total_active'] = $this->admin_model->count_active_members();
        $this->view('admin/index', $this->data);
    }

    public function reports()
    {
        $this->load->view('admin/reports');
    }

    public function posts()
    {
        $data = [];
        $data['post_duration'] = $this->admin_model->get_post_duration();
        $this->load->view('admin/posts', $data);
    }

    public function login()
    {
        $this->view('admin/login', 'refresh');
    }

    public function logout()
    {
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_email']);
        redirect('admin/login', 'refresh');
    }

    public function check_login()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == true) {
            $login_info = $this->admin_model->get_login_info($this->input->post('email'));
            if ($login_info != false) {
                $this->load->helper('security');
                $valid_password = 0;
                //Sleep a bit to prevent brute force
                sleep(1);
                if (password_verify($this->input->post('password'), $login_info[0]['password'])) {
                    $valid_password = 1;
                }
                if ($valid_password == 1) {
                    $this->session->set_userdata('admin_id', $login_info['0']['id']);
                    $this->session->set_userdata('admin_email', $login_info['0']['email']);
                    redirect('admin', 'refresh');
                } else {
                    $this->session->set_flashdata('message', 'Email or Password didn\'t match');
                    redirect('admin/login', 'refresh');
                }
            } else {
                $this->session->set_flashdata('message', 'Email or Password didn\'t match');
                redirect('admin/login', 'refresh');
            }
        } else {
            $this->session->set_flashdata('message', validation_errors());
            redirect('admin/login', 'refresh');
        }
    }

    public function memberslist()
    {
        $this->view('admin/memberslist', 'refresh');
    }

    public function payments()
    {
        $this->view('admin/payments', 'refresh');
    }

    public function member($id)
    {
        $this->data['member_detail'] = $this->admin_model->get_member($id);
        $this->view('admin/members', $this->data);
    }

    public function editmember($id)
    {
        $this->data['member_detail'] = $this->admin_model->get_member($id);
        $this->view('admin/editmember', $this->data);
    }

    public function updatemember()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        if ($this->form_validation->run() == true) {
            $password = $this->input->post('password');
            if (!empty($password)) {
                $data = ['first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'email' => $this->input->post('email'),
                    'password' => $this->input->post('password'),
                    'active' => $this->input->post('status')];
                $this->admin_model->update_member($this->input->post('id'), $data);
                $this->session->set_flashdata('message', 'Record Successfully updated');
                $this->member($this->input->post('id'));
            } else {
                $data = ['first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'email' => $this->input->post('email'),
                    'active' => $this->input->post('status')];
                $this->admin_model->update_member($this->input->post('id'), $data);
                $this->session->set_flashdata('message', 'Record Successfully updated');
                $this->member($this->input->post('id'));
            }
        } else {
            $this->session->set_flashdata('message', validation_errors());;
            $this->editmember($this->input->post('id'));
        }
    }

    public function paypal()
    {
        $this->data['paypal_detail'] = $this->admin_model->get_paypal_detail();
        $this->view('admin/paypal', $this->data);
    }

    public function editpaypal()
    {
        $this->data['paypal_detail'] = $this->admin_model->get_paypal_detail();
        $this->view('admin/editpaypal', $this->data);
    }

    public function updatepaypal()
    {
        $this->form_validation->set_rules('gateway_name', 'Gateway Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('url', 'Url', 'required');
        $this->form_validation->set_rules('currency', 'Currency', 'required');
        if ($this->form_validation->run() == true) {
            $data = ['gateway_name' => $this->input->post('gateway_name'),
                'email' => $this->input->post('email'),
                'url' => $this->input->post('url'),
                'currency' => $this->input->post('currency')];
            $this->admin_model->update_paypal($data);
            $this->session->set_flashdata('message', 'Record Successfully updated');
            $this->paypal();
        } else {
            $this->session->set_flashdata('message', validation_errors());;
            $this->editpaypal();
        }
    }

    public function setting()
    {
        $this->data['setting'] = $this->admin_model->get_admin_setting();
        $this->view('admin/setting', $this->data);
    }

    public function get_post_duration()
    {
        $result = $this->admin_model->get_admin_setting();
        echo $result[0]['post_duration'];
    }

    public function editsetting()
    {
        $this->data['setting'] = $this->admin_model->get_admin_setting();
        $this->view('admin/editsetting', $this->data);
    }

    public function updatesetting()
    {
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        if ($this->form_validation->run() == true) {
            $password = $this->input->post('password');
            if (isset($password)) {
                $hashToStoreInDb = password_hash($password, PASSWORD_BCRYPT);
                $data = ['name' => $this->input->post('name'),
                    'email' => $this->input->post('email'),
                    'password' => $hashToStoreInDb];
                $this->admin_model->update_admin_setting($data);
                $this->session->set_flashdata('message', 'Record Successfully updated');
                $this->setting();
            } else {
                $data = ['name' => $this->input->post('name'), 'email' => $this->input->post('email')];
                $this->admin_model->update_admin_setting($data);
                $this->session->set_flashdata('message', 'Record Successfully updated');
                $this->setting();
            }
        } else {
            $this->session->set_flashdata('message', validation_errors());;
            $this->editsetting();
        }
    }

    public function control_prices()
    {
    }

    public function get_prices()
    {
    }
//    public  function update_duration()
//    {
//        echo $this->admin_model->update_duration($_GET['id'], $_GET['duration_value']);
//    }
    public function update_post_duration()
    {
        echo $this->admin_model->update_admin_post_duration($_GET['duration']);
    }

    public function get_reported_posts()
    {
        ini_set("memory_limit", -1);
        $aColumns = ['id', 'member_id', 'status', 'photos', 'privacy', 'time'];
        $sIndexColumn = "id";
        $sTable = "posts";
        $sLimit = "";
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $sLimit = "LIMIT " . intval($_GET['iDisplayStart']) . ", " . intval($_GET['iDisplayLength']);
        }
        /* Ordering */
        $sOrder = "";
        if (isset($_GET['iSortCol_0'])) {
            $sOrder = "ORDER BY  ";
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    $sOrder .= "`" . $aColumns[intval($_GET['iSortCol_' . $i])] . "` " . ($_GET['sSortDir_' . $i] === 'asc' ? 'asc' : 'desc') . ", ";
                }
            }
            $sOrder = substr_replace($sOrder, "", -2);
            if ($sOrder == "ORDER BY") {
                $sOrder = "";
            }
        }
        /* Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited */
        $sWhere = "";
        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $_GET['sSearch'] = trim($_GET['sSearch']);
            $_GET['sSearch'] = addslashes($_GET['sSearch']);
            $sWhere = "WHERE (";
            for ($i = 0; $i < count($aColumns); $i++) {
                $sWhere .= "`" . $aColumns[$i] . "` LIKE '%" . ($_GET['sSearch']) . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ')';
        }
        /* Individual column filtering */
        for ($i = 0; $i < count($aColumns); $i++) {
            if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '') {
                if ($sWhere == "") {
                    $sWhere = "WHERE ";
                } else {
                    $sWhere .= " AND ";
                }
                $sWhere .= "`" . $aColumns[$i] . "` LIKE '%" . ($_GET['sSearch_' . $i]) . "%' ";
            }
        }
        $sWhere .= "WHERE is_reported=1";
        /* SQL queries
         * Get data to display
         */
        $sQuery = "SELECT SQL_CALC_FOUND_ROWS `" . str_replace(" , ", " ", implode("`, `", $aColumns)) . "`
                FROM   $sTable
                $sWhere
                $sOrder
                $sLimit
        ";
        $rResult = $this->admin_model->get_members($sQuery);
        /* Data set length after filtering */
        $sQuery = "SELECT FOUND_ROWS()";
        $rResultFilterTotal = $this->admin_model->get_members($sQuery);
        //$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
        $iFilteredTotal = $rResultFilterTotal[0]['FOUND_ROWS()'];
        /* Total data set length */
        $sQuery = "SELECT COUNT(`" . $sIndexColumn . "`)
                FROM   $sTable
        ";
        $rResultTotal = $this->admin_model->get_members($sQuery);
        $aResultTotal = $rResultTotal;
        $iTotal = $aResultTotal[0]['COUNT(`id`)'];
        /*
         * Output
         */
        $output = [
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => []
        ];
        //Kint::dump($rResult);
        //Kint::dump($rResult[0]['first_name']);
        //exit();
        foreach ($rResult as $aRow) {
            $row = [];
            for ($i = 0; $i < count($aColumns); $i++) {
                if ($aColumns[$i] == "member_id") {
                    $mem = $this->admin_model->get_member($aRow[$aColumns[$i]]);
                    $row[] = $mem[0]["first_name"] . ' ' . $mem[0]["last_name"];
                } else if ($i == (count($aColumns) - 1)) {
                    $row[] = $aRow[$aColumns[$i]];
                    $row[] = '<a href="javascript:post_delete(' . $aRow['id'] . ');">Delete</a>';
                } else if ($aColumns[$i] != ' ') {
                    /* General output */
                    $row[] = $aRow[$aColumns[$i]];
                }
            }
            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    public function get_posts()
    {
        ini_set("memory_limit", -1);
        $aColumns = ['id', 'member_id', 'status', 'photos', 'privacy', 'time', 'duration'];
        $sIndexColumn = "id";
        $sTable = "posts";
        $sLimit = "";
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $sLimit = "LIMIT " . intval($_GET['iDisplayStart']) . ", " . intval($_GET['iDisplayLength']);
        }
        /* Ordering */
        $sOrder = "";
        if (isset($_GET['iSortCol_0'])) {
            $sOrder = "ORDER BY  ";
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    $sOrder .= "`" . $aColumns[intval($_GET['iSortCol_' . $i])] . "` " . ($_GET['sSortDir_' . $i] === 'asc' ? 'asc' : 'desc') . ", ";
                }
            }
            $sOrder = substr_replace($sOrder, "", -2);
            if ($sOrder == "ORDER BY") {
                $sOrder = "";
            }
        }
        /* Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited */
        $sWhere = "";
        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $_GET['sSearch'] = trim($_GET['sSearch']);
            $_GET['sSearch'] = addslashes($_GET['sSearch']);
            $sWhere = "WHERE (";
            for ($i = 0; $i < count($aColumns); $i++) {
                $sWhere .= "`" . $aColumns[$i] . "` LIKE '%" . ($_GET['sSearch']) . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ')';
        }
        /* Individual column filtering */
        for ($i = 0; $i < count($aColumns); $i++) {
            if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '') {
                if ($sWhere == "") {
                    $sWhere = "WHERE ";
                } else {
                    $sWhere .= " AND ";
                }
                $sWhere .= "`" . $aColumns[$i] . "` LIKE '%" . ($_GET['sSearch_' . $i]) . "%' ";
            }
        }
        /* SQL queries
         * Get data to display
         */
        $sQuery = "SELECT SQL_CALC_FOUND_ROWS `" . str_replace(" , ", " ", implode("`, `", $aColumns)) . "`
                FROM   $sTable
                $sWhere
                $sOrder
                $sLimit
        ";
        $rResult = $this->admin_model->get_members($sQuery);
        /* Data set length after filtering */
        $sQuery = "SELECT FOUND_ROWS()";
        $rResultFilterTotal = $this->admin_model->get_members($sQuery);
        //$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
        $iFilteredTotal = $rResultFilterTotal[0]['FOUND_ROWS()'];
        /* Total data set length */
        $sQuery = "SELECT COUNT(`" . $sIndexColumn . "`)
                FROM   $sTable
        ";
        $rResultTotal = $this->admin_model->get_members($sQuery);
        $aResultTotal = $rResultTotal;
        $iTotal = $aResultTotal[0]['COUNT(`id`)'];
        /*
         * Output
         */
        $output = [
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => []
        ];
        //Kint::dump($rResult);
        //Kint::dump($rResult[0]['first_name']);
        //exit();
        foreach ($rResult as $aRow) {
            $row = [];
            for ($i = 0; $i < count($aColumns); $i++) {
                if ($aColumns[$i] == "member_id") {
                    $mem = $this->admin_model->get_member($aRow[$aColumns[$i]]);
                    $row[] = $mem[0]["first_name"] . ' ' . $mem[0]["last_name"];
                } else if ($i == (count($aColumns) - 1)) {
                    $row[] = $aRow[$aColumns[$i]];
                    $row[] = '<a href="javascript:post_edit(' . $aRow['id'] . ', ' . $aRow['duration'] . ');">Edit</a>';
                } else if ($aColumns[$i] != ' ') {
                    /* General output */
                    $row[] = $aRow[$aColumns[$i]];
                }
            }
            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    public function get_reports()
    {
        ini_set("memory_limit", -1);
        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        * Easy set variables
        * Array of database columns which should be read and sent back to DataTables. Use a space where
        * you want to insert a non-database field (for example a counter or static image)
        * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
        $aColumns = ['name', 'email', 'reported_issue', 'date_added', 'id'];
        /* Indexed column (used for fast and accurate table cardinality) */
        $sIndexColumn = "id";
        /* DB table to use */
        $sTable = "reports";
        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * If you just want to use the basic configuration for DataTables with PHP server-side, there is
         * no need to edit below this line
         * MySQL connection
         * Paging
         * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
        $sLimit = "";
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $sLimit = "LIMIT " . intval($_GET['iDisplayStart']) . ", " . intval($_GET['iDisplayLength']);
        }
        /* Ordering */
        $sOrder = "";
        if (isset($_GET['iSortCol_0'])) {
            $sOrder = "ORDER BY  ";
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    $sOrder .= "`" . $aColumns[intval($_GET['iSortCol_' . $i])] . "` " . ($_GET['sSortDir_' . $i] === 'asc' ? 'asc' : 'desc') . ", ";
                }
            }
            $sOrder = substr_replace($sOrder, "", -2);
            if ($sOrder == "ORDER BY") {
                $sOrder = "";
            }
        }
        /* Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited */
        $sWhere = "";
        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $_GET['sSearch'] = trim($_GET['sSearch']);
            $_GET['sSearch'] = addslashes($_GET['sSearch']);
            $sWhere = "WHERE (";
            for ($i = 0; $i < count($aColumns); $i++) {
                $sWhere .= "`" . $aColumns[$i] . "` LIKE '%" . ($_GET['sSearch']) . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ')';
        }
        /* Individual column filtering */
        for ($i = 0; $i < count($aColumns); $i++) {
            if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '') {
                if ($sWhere == "") {
                    $sWhere = "WHERE ";
                } else {
                    $sWhere .= " AND ";
                }
                $sWhere .= "`" . $aColumns[$i] . "` LIKE '%" . ($_GET['sSearch_' . $i]) . "%' ";
            }
        }
        /* SQL queries
         * Get data to display
         */
        $sQuery = "SELECT SQL_CALC_FOUND_ROWS `" . str_replace(" , ", " ", implode("`, `", $aColumns)) . "`
                FROM   $sTable
                $sWhere
                $sOrder
                $sLimit
        ";
        $rResult = $this->admin_model->get_members($sQuery);
        /* Data set length after filtering */
        $sQuery = "SELECT FOUND_ROWS()";
        $rResultFilterTotal = $this->admin_model->get_members($sQuery);
        //$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
        $iFilteredTotal = $rResultFilterTotal[0]['FOUND_ROWS()'];
        /* Total data set length */
        $sQuery = "SELECT COUNT(`" . $sIndexColumn . "`)
                FROM   $sTable
        ";
        $rResultTotal = $this->admin_model->get_members($sQuery);
        $aResultTotal = $rResultTotal;
        $iTotal = $aResultTotal[0]['COUNT(`id`)'];
        /*
         * Output
         */
        $output = [
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => []
        ];
        //Kint::dump($rResult);
        //Kint::dump($rResult[0]['first_name']);
        //exit();
        foreach ($rResult as $aRow) {
            $row = [];
            for ($i = 0; $i < count($aColumns); $i++) {
                if ($aColumns[$i] == "first_name") {
                    /* Special output formatting for 'version' column */
                    $row[] = '<a href="' . base_url('admin/member') . '/' . $aRow['id'] . '">' . $aRow[$aColumns[$i]] . '</a>';
                } elseif ($aColumns[$i] == "active") {
                    if ($aRow['active'] == 0) {
                        $row[] = "Inactive";
                    } elseif ($aRow['active'] == 1) {
                        $row[] = "Active";
                    }
                } elseif ($aColumns[$i] == "id") {
                } else if ($aColumns[$i] != ' ') {
                    /* General output */
                    $row[] = $aRow[$aColumns[$i]];
                }
            }
            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    public function members_data()
    {
        ini_set("memory_limit", -1);
        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        * Easy set variables
        * Array of database columns which should be read and sent back to DataTables. Use a space where
        * you want to insert a non-database field (for example a counter or static image)
        * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
        $aColumns = ['id', 'first_name', 'email', 'country', 'active', 'points'];
        /* Indexed column (used for fast and accurate table cardinality) */
        $sIndexColumn = "id";
        /* DB table to use */
        $sTable = "members";
        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * If you just want to use the basic configuration for DataTables with PHP server-side, there is
         * no need to edit below this line
         * MySQL connection
         * Paging
         * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
        $sLimit = "";
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $sLimit = "LIMIT " . intval($_GET['iDisplayStart']) . ", " . intval($_GET['iDisplayLength']);
        }
        /* Ordering */
        $sOrder = "";
        if (isset($_GET['iSortCol_0'])) {
            $sOrder = "ORDER BY  ";
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    $sOrder .= "`" . $aColumns[intval($_GET['iSortCol_' . $i])] . "` " . ($_GET['sSortDir_' . $i] === 'asc' ? 'asc' : 'desc') . ", ";
                }
            }
            $sOrder = substr_replace($sOrder, "", -2);
            if ($sOrder == "ORDER BY") {
                $sOrder = "";
            }
        }
        /* Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited */
        $sWhere = "";
        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $sWhere = "WHERE (";
            for ($i = 0; $i < count($aColumns); $i++) {
                $sWhere .= "`" . $aColumns[$i] . "` LIKE '%" . ($_GET['sSearch']) . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ')';
        }
        /* Individual column filtering */
        for ($i = 0; $i < count($aColumns); $i++) {
            if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '') {
                if ($sWhere == "") {
                    $sWhere = "WHERE ";
                } else {
                    $sWhere .= " AND ";
                }
                $sWhere .= "`" . $aColumns[$i] . "` LIKE '%" . ($_GET['sSearch_' . $i]) . "%' ";
            }
        }
        /* SQL queries
         * Get data to display
         */
        $sQuery = "SELECT SQL_CALC_FOUND_ROWS `" . str_replace(" , ", " ", implode("`, `", $aColumns)) . "`
                FROM   $sTable
                $sWhere
                $sOrder
                $sLimit
        ";
        $rResult = $this->admin_model->get_members($sQuery);
        /* Data set length after filtering */
        $sQuery = "SELECT FOUND_ROWS()";
        $rResultFilterTotal = $this->admin_model->get_members($sQuery);
        //$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
        $iFilteredTotal = $rResultFilterTotal[0]['FOUND_ROWS()'];
        /* Total data set length */
        $sQuery = "SELECT COUNT(`" . $sIndexColumn . "`)
                FROM   $sTable
        ";
        $rResultTotal = $this->admin_model->get_members($sQuery);
        $aResultTotal = $rResultTotal;
        $iTotal = $aResultTotal[0]['COUNT(`id`)'];
        /*
         * Output
         */
        $output = [
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => []
        ];
        //Kint::dump($rResult);
        //Kint::dump($rResult[0]['first_name']);
        //exit();
        foreach ($rResult as $aRow) {
            $row = [];
            for ($i = 0; $i < count($aColumns); $i++) {
                if ($aColumns[$i] == "first_name") {
                    /* Special output formatting for 'version' column */
                    $row[] = '<a href="' . base_url('admin/member') . '/' . $aRow['id'] . '">' . $aRow[$aColumns[$i]] . '</a>';
                } elseif ($aColumns[$i] == "points") {
                    $row[] = "<span id='" . $aRow['id'] . "' class='points-to-update'>" . $aRow['points'] . "</span><input class='points-to-update-field hide form-control' type='text' value='" . $aRow['points'] . "'>";
                } elseif ($aColumns[$i] == "active") {
                    if ($aRow['active'] == 0) {
                        $row[] = "Inactive";
                    } elseif ($aRow['active'] == 1) {
                        $row[] = "Active";
                    }
                } else if ($aColumns[$i] != ' ') {
                    /* General output */
                    $row[] = $aRow[$aColumns[$i]];
                }
            }
            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    public function update_points()
    {
        $user_id = (int)$_POST['id'];
        $points = (int)$_POST['points'];
        $update = $this->admin_model->updatePoints($user_id, $points);
        if ($update) {
            echo "success";
        } else {
            echo "Fail";
        }
    }

    public function update_price()
    {
        $id = (int)$_POST['id'];
        $price = (int)$_POST['price'];
        $update = $this->admin_model->updatePrice($id, $price);
        if ($update) {
            echo "success";
        } else {
            echo "Fail";
        }
    }

    public function prices()
    {
        $this->data['options'] = $this->admin_model->getOptions();
        $this->load->view('admin/prices', $this->data);
    }

    public function payments_data()
    {
        ini_set("memory_limit", -1);
        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        * Easy set variables
        */
        /* Array of database columns which should be read and sent back to DataTables. Use a space where
         * you want to insert a non-database field (for example a counter or static image)
         */
        $aColumns = ['email', 'quantity', 'total_payments', 'transaction_id', 'date', 'member_id'];
        /* Indexed column (used for fast and accurate table cardinality) */
        $sIndexColumn = "id";
        /* DB table to use */
        $sTable = "payments";
        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * If you just want to use the basic configuration for DataTables with PHP server-side, there is
         * no need to edit below this line
         */
        /*
         * MySQL connection
         */
        /*
         * Paging
         */
        $sLimit = "";
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $sLimit = "LIMIT " . intval($_GET['iDisplayStart']) . ", " .
                intval($_GET['iDisplayLength']);
        }
        /*
         * Ordering
         */
        $sOrder = "";
        if (isset($_GET['iSortCol_0'])) {
            $sOrder = "ORDER BY  ";
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    $sOrder .= "`" . $aColumns[intval($_GET['iSortCol_' . $i])] . "` " .
                        ($_GET['sSortDir_' . $i] === 'asc' ? 'asc' : 'desc') . ", ";
                }
            }
            $sOrder = substr_replace($sOrder, "", -2);
            if ($sOrder == "ORDER BY") {
                $sOrder = "";
            }
        }
        /*
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        $sWhere = "";
        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $sWhere = "WHERE (";
            for ($i = 0; $i < count($aColumns); $i++) {
                $sWhere .= "`" . $aColumns[$i] . "` LIKE '%" . ($_GET['sSearch']) . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ')';
        }
        /* Individual column filtering */
        for ($i = 0; $i < count($aColumns); $i++) {
            if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '') {
                if ($sWhere == "") {
                    $sWhere = "WHERE ";
                } else {
                    $sWhere .= " AND ";
                }
                $sWhere .= "`" . $aColumns[$i] . "` LIKE '%" . ($_GET['sSearch_' . $i]) . "%' ";
            }
        }
        /*
         * SQL queries
         * Get data to display
         */
        $sQuery = "
                    SELECT SQL_CALC_FOUND_ROWS `" . str_replace(" , ", " ", implode("`, `", $aColumns)) . "`
                    FROM   $sTable
                    $sWhere
                    $sOrder
                    $sLimit
                    ";
        $rResult = $this->admin_model->get_members($sQuery);
        /* Data set length after filtering */
        $sQuery = "
                    SELECT FOUND_ROWS()
                ";
        $rResultFilterTotal = $this->admin_model->get_members($sQuery);
//            $aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
        $iFilteredTotal = $rResultFilterTotal[0]['FOUND_ROWS()'];
        /* Total data set length */
        $sQuery = "
                    SELECT COUNT(`" . $sIndexColumn . "`)
                    FROM   $sTable
                ";
        $rResultTotal = $this->admin_model->get_members($sQuery);
        $aResultTotal = $rResultTotal;
        $iTotal = $aResultTotal[0]['COUNT(`id`)'];
        /*
         * Output
         */
        $output = [
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => []
        ];
//              Kint::dump($rResult);
//         Kint::dump($rResult[0]['first_name']);
//         exit();
        foreach ($rResult as $aRow) {
            $row = [];
            for ($i = 0; $i < count($aColumns); $i++) {
                if ($aColumns[$i] == "email") {
                    /* Special output formatting for 'version' column */
                    $row[] = '<a href="' . base_url('admin/member') . '/' . $aRow['member_id'] . '">' . $aRow[$aColumns[$i]] . '</a>';
                } elseif ($aColumns[$i] == "active") {
                    if ($aRow['active'] == 0) {
                        $row[] = "Inactive";
                    } elseif ($aRow['active'] == 1) {
                        $row[] = "Active";
                    }
                } elseif ($aColumns[$i] == "id") {
                } else if ($aColumns[$i] != ' ') {
                    /* General output */
                    $row[] = $aRow[$aColumns[$i]];
                }
            }
            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

    public function view($page = 'home', $data = null)
    {
        if (!file_exists(APPPATH . '/views/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            show_404($this->uri->uri_string);
        }
        $this->load->view($page, $data);
    }

    public function top_text(){
        $data=['texts'=>$this->admin_model->getAllTopTexts()];
        $this->load->view('admin/top_text', $data);
    }

    public function set_top_text_ajax(){
        $key=$this->input->post('pk');
        $text=$this->input->post('value');
        if($this->admin_model->setTopText($key, $text)){
            echo json_encode(['result'=>'ok']);
            exit;
        }else{
            echo json_encode(['result'=>'error']);
            exit;
        }
    }

}
