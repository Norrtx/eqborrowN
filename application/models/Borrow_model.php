<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Borrow_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->_table = 'borrow';
        $this->delete_db = false;
        $this->delete_tbref = array();
    }

    public function data()
    {
        $data = array(
            'id' => null,
            'borrow_date' => null,
            'schedule_date' => null,
            'return_date' => null,
            'return_status' => null,
            'member_id' => null,
            'created_at' => date('Y-m-d H:i:s'),
            'modified_at' => null,
            'created_on' => get_user_id(),
            'modified_on' => null,
        );
        return $data;
    }

    public function find($id)
    {
        $this->db->select('b.*, m.name as member_name, m.code as member_code, d.name as department_name');
        $this->db->from('borrow b');
        $this->db->join('member m', 'm.id=b.member_id');
        $this->db->join('department d', 'm.department_id=d.id');
        $this->db->where('b.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function find_with_page($param)
    {
        $keyword = $param['keyword'];
        $this->db->select('b.*, m.name as member_name, m.code as member_code');

        $condition = "1=1";
        if (!empty($keyword)) {
            $condition .= " and (m.code like '%{$keyword}%' or m.name like '%{$keyword}%' or m.email like '%{$keyword}%' or m.tel like '%{$keyword}%')";
        }

        // status filter
        $condition .= !empty($param['only_borrow']) ? " and return_status=0" : "";

        // user only see filter
        $curr_login = get_user_id();
        $current_user = get_user_id();
        $condition .= ("id = '{$curr_login}'") ? " and b.created_on='{$current_user}'" : "";

        $this->db->from('borrow b');
        $this->db->join('member m', 'b.member_id=m.id');
        $this->db->where($condition);
        $this->db->limit($param['page_size'], $param['start']);
        $this->db->order_by($param['column'], $param['dir']);

        $query = $this->db->get();
        $data = [];
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        $count_condition = $this->db->from('borrow b')->join('member m', 'b.member_id=m.id')->where($condition)->count_all_results();
        $count = $this->db->from('borrow')->count_all_results();
        $result = array('count' => $count, 'count_condition' => $count_condition, 'data' => $data, 'error_message' => '');
        return $result;
    }

    public function find_with_page_borrow($param)
    {
        $keyword = $param['keyword'];
        $this->db->select('b.*, m.name as member_name, m.code as member_code, d.borrow_quantity, d.return_quantity, d.return_status as detail_status,
        p.name as product_name, p.code as product_code, s.code as serial_code');
        $curr_login = get_user_id();
		$condition = "b.created_on = '{$curr_login}' and ";
        $condition .= "1=1";
        if (!empty($keyword)) {
            $condition .= " and (m.code like '%{$keyword}%' or m.name like '%{$keyword}%' or p.code like '%{$keyword}%' or p.name like '%{$keyword}%' or s.code like '%{$keyword}%')";
        }

        if (!empty($param['balance_status'])) {
            $now = date('Y-m-d');
            $condition .= " and d.return_status = 0 and b.schedule_date < '{$now}'";
        } else {
            // status filter
            $condition .= !empty($param['only_borrow']) ? " and return_status=0" : "";
        }

        $this->db->from('borrow b');
        $this->db->join('borrow_detail d', 'b.id=d.borrow_id');
        $this->db->join('product p', 'd.product_id=p.id');
        $this->db->join('serial_number s', 'p.id=s.product_id and s.id=d.serial_number_id', 'left');
        $this->db->join('member m', 'b.member_id=m.id');
        $this->db->where($condition);
        $this->db->limit($param['page_size'], $param['start']);

        // ordering
        if(!empty($param['dash_board'])){
            $this->db->order_by('modified_at', 'desc');
            $this->db->order_by('created_at', 'desc');     
        }
        $this->db->order_by($param['column'], $param['dir']);        

        $query = $this->db->get();        
        $data = [];
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }

        $count_condition = $this->db->from('borrow b')
            ->join('member m', 'b.member_id=m.id')
            ->join('borrow_detail d', 'b.id=d.borrow_id')
            ->join('product p', 'd.product_id=p.id')
            ->join('serial_number s', 'p.id=s.product_id and s.id=d.serial_number_id', 'left')
            ->where($condition)
            ->count_all_results();

        $count = $this->db->from('borrow b')->join('borrow_detail d', 'b.id=d.borrow_id')->count_all_results();
        $result = array('count' => $count, 'count_condition' => $count_condition, 'data' => $data, 'error_message' => '');
        return $result;
    }

    public function count_not_return(){
        $curr_login = get_user_id();
        $query = $this->db->from('borrow')
        ->where('return_status', false)
        ->where('created_on =', $curr_login)
        ->count_all_results();
        return $query;
    }

    public function count(){
        $curr_login = get_user_id();
        $query = $this->db->from('borrow')
        ->where('created_on =', $curr_login)
        ->count_all_results();
        return $query;
    }

    public function export_borrow($param)
    {
        $keyword = $param['keyword'];
        $this->db->select('b.*, m.name as member_name, m.code as member_code');

        $condition = "1=1";
        if (!empty($keyword)) {
            $condition .= " and (m.code like '%{$keyword}%' or m.name like '%{$keyword}%' or m.email like '%{$keyword}%' or m.tel like '%{$keyword}%')";
        }

        // status filter
        $condition .= !empty($param['only_borrow']) ? " and return_status=0" : "";

        // user only see filter
        $current_user = get_user_id();
        $condition .= (get_usertype() !== 'ADMIN') ? " and b.created_on='{$current_user}'" : "";

        $this->db->from('borrow b');
        $this->db->join('member m', 'b.member_id=m.id');
        $this->db->where($condition);

        $query = $this->db->get();        
        return $query->result_array();
    }

    public function export_borrow_list($param)
    {
        $keyword = $param['keyword'];
        $balance_status = $param['balance_status'];
        $this->db->select('d.*, m.name as member_name, m.code as member_code, b.borrow_date, b.schedule_date, b.return_date,
        p.name as product_name, p.code as product_code, p.model, s.code as serial_code');
        $curr_login = get_user_id();
		$condition = "m.created_on = '{$curr_login}' and ";
        $condition .= "1=1";
        if (!empty($keyword)) {
            $condition .= " and (m.code like '%{$keyword}%' or m.name like '%{$keyword}%' or m.email like '%{$keyword}%' or m.tel like '%{$keyword}%')";
        }

        if (!empty($balance_status)) {
            $now = date('Y-m-d');
            $condition .= " and d.return_status = 0 and b.schedule_date < '{$now}'";
        }

        // status filter
        $condition .= !empty($param['only_borrow']) ? " and b.return_status=0" : "";

        // user only see filter
        $current_user = get_user_id();
        $condition .= (get_usertype() !== 'ADMIN') ? " and b.created_on='{$current_user}'" : "";

        $this->db->from('borrow b');
        $this->db->join('borrow_detail d', 'b.id=d.borrow_id');
        $this->db->join('product p', 'd.product_id=p.id');
        $this->db->join('serial_number s', 'p.id=s.product_id and s.id=d.serial_number_id', 'left');
        $this->db->join('member m', 'b.member_id=m.id');
        $this->db->where($condition);

        $query = $this->db->get();        
        return $query->result_array();
    }
}
