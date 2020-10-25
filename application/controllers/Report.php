<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Report extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->model('Serial_model');
        $this->load->model('Borrow_model');
    }

    public function stock()
    {
        $head['main_title'] = get_line('menu_rpt_stock');
        $data['categories'] = get_categorie();
        $this->load->view('layout/header', $head);
        $this->load->view('report/stock', $data);
        $this->load->view('layout/footer');
    }

    public function get_stock_datatables()
    {
        $order_index = $this->input->get('order[0][column]');
        $param['page_size'] = $this->input->get('length');
        $param['start'] = $this->input->get('start');
        $param['draw'] = $this->input->get('draw');
        $param['keyword'] = trim($this->input->get('search[value]'));
        $param['column'] = $this->input->get("columns[{$order_index}][data]");
        $param['dir'] = $this->input->get('order[0][dir]');

        // search
        $param['category_id'] = $this->input->get('category_id');

        $results = $this->Product_model->find_with_page_stock($param);

        // transfrom data
        foreach ($results['data'] as &$item) {
            $item['quantity'] = ($item['is_serial_number']) ? $item['serial_quantity'] : $item['quantity'];
            $item['serial_code'] = ($item['is_serial_number']) ? $item['serial_code'] : '-';
        }

        $data['draw'] = $param['draw'];
        $data['recordsTotal'] = $results['count'];
        $data['recordsFiltered'] = $results['count_condition'];
        $data['data'] = $results['data'];
        $data['error'] = $results['error_message'];

        json_output($data);
    }

    public function borrow()
    {
        $head['main_title'] = get_line('menu_rpt_borrow');
        $this->load->view('layout/header', $head);
        $this->load->view('report/borrow');
        $this->load->view('layout/footer');
    }

    public function get_borrow_datatables(){
        $dash_board = $this->input->get('dashboard');
        $order_index = $this->input->get('order[0][column]');
		$param['page_size'] = empty($dash_board) ? $this->input->get('length') : 5;
		$param['start'] = empty($dash_board) ? $this->input->get('start') : 0;
		$param['draw'] = $this->input->get('draw');
		$param['keyword'] = trim($this->input->get('search[value]'));
		$param['column'] = (empty($dash_board)) ? $this->input->get("columns[{$order_index}][data]") : 'created_at';
		$param['dir'] = (empty($dash_board)) ? $this->input->get('order[0][dir]') : 'DESC';
        $param['only_borrow'] = false;               
        $param['dash_board'] = $dash_board;
        $param['balance_status'] = $this->input->get('item_type');
        
        $results = $this->Borrow_model->find_with_page_borrow($param);

		$data['draw'] = $param['draw'];
		$data['recordsTotal'] = $results['count'];
		$data['recordsFiltered'] = $results['count_condition'];
		$data['data'] = $results['data'];
		$data['error'] = $results['error_message'] ;

		json_output($data);
    }
    
    public function export_stock()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $param['keyword'] = trim($this->input->get('keyword'));
        $param['categorie_id'] = $this->input->get('categorie_id');        

        $results = $this->Product_model->export_stock($param);

        $columns = array('รหัสสินค้า', 'ชื่อสินค้า', 'หมวดหมู่สินค้า', 'Serial Number', 'จำนวนคงเหลือ', 'หน่วยนับ', 'สถานะ');
        $col = 'A';
        foreach ($columns as $column) {
            $sheet->setCellValue($col . '1', $column);
            $col++;
        }

        $row = 2;
        foreach ($results as $item) {
            $is_active = $item['is_active'] ? 'ใช้งาน' : 'ยกเลิก';
            $sheet->setCellValue('A' . $row, $item['code'])
                ->setCellValue('B' . $row, $item['name'])
                ->setCellValue('C' . $row, $item['category_name'])
                ->setCellValue('D' . $row, $item['serial_code'])
                ->setCellValue('E' . $row, $item['quantity'])
                ->setCellValue('F' . $row, $item['unit_name'])
                ->setCellValue('G' . $row, $is_active);

            $row++;
        }

        $sheet->getStyle('A2:A' . $row)
            ->getNumberFormat()
            ->setFormatCode(NumberFormat::FORMAT_TEXT);

        $sheet->getStyle('D2:D' . $row)
            ->getNumberFormat()
            ->setFormatCode(NumberFormat::FORMAT_TEXT);

        $sheet->getStyle('E2:E' . $row)
            ->getNumberFormat()
            ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

        $sheet->getStyle('A1:G1')->getFont()->setBold(true);
        foreach (range('A', 'G') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="file.xlsx"');
        $writer->save("php://output");
    }

    public function export_borrow()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $param['keyword'] = trim($this->input->get('keyword'));
        $param['balance_status'] = trim($this->input->get('balance_status'));

        $results = $this->Borrow_model->export_borrow_list($param);

        $columns = array('รหัสผู้ยืม', 'ชื่อผู้ยืม', 'วันที่ยืม', 'กำหนดคืน', 'วันที่คืน', 'รหัสสินค้า', 'ชื่อสินค้า', 'Serial Number', 'ราคา', 'จำนวนยืม', 'จำนวนที่คืน');
        $col = 'A';
        foreach ($columns as $column) {
            $sheet->setCellValue($col . '1', $column);
            $col++;
        }

        $row = 2;
        foreach ($results as $item) {
            $sheet->setCellValue('A' . $row, $item['member_code'])
                ->setCellValue('B' . $row, $item['member_name'])
                ->setCellValue('C' . $row, str_date($item['borrow_date']))
                ->setCellValue('D' . $row, str_date($item['schedule_date']))
                ->setCellValue('E' . $row, str_date($item['return_date']))
                ->setCellValue('F' . $row, $item['product_code'])
                ->setCellValue('G' . $row, $item['product_name'])
                ->setCellValue('H' . $row, $item['serial_code'])
                ->setCellValue('I' . $row, $item['price'])
                ->setCellValue('J' . $row, $item['borrow_quantity'])
                ->setCellValue('K' . $row, $item['return_quantity']);

            $row++;
        }

        $sheet->getStyle('C2:E' . $row)
            ->getNumberFormat()
            ->setFormatCode('dd/mm/yyyy');

        $sheet->getStyle('C2:E' . $row)
            ->getAlignment()
            ->applyFromArray([
                'horizontal' => Alignment::HORIZONTAL_RIGHT,
            ]);

        $sheet->getStyle('A2:A' . $row)
            ->getNumberFormat()
            ->setFormatCode(NumberFormat::FORMAT_TEXT);

        $sheet->getStyle('F2:F' . $row)
            ->getNumberFormat()
            ->setFormatCode(NumberFormat::FORMAT_TEXT);

        $sheet->getStyle('H2:H' . $row)
            ->getNumberFormat()
            ->setFormatCode(NumberFormat::FORMAT_TEXT);

        $sheet->getStyle('I2:K' . $row)
            ->getNumberFormat()
            ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

        $sheet->getStyle('A1:K1')->getFont()->setBold(true);
        foreach (range('A', 'K') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="file.xlsx"');
        $writer->save("php://output");
    }
}
