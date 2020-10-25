<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Borrow extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Borrow_model');
    }

    public function index()
    {
        $head['main_title'] = get_line('menu_borrow');
        $this->load->view('layout/header', $head);
        $this->load->view('borrow/index');
        $this->load->view('layout/footer');
    }

    public function main_form($id = 0)
    {
        $data['id'] = $id;
        $this->load->view('borrow/main_form', $data);
    }

    public function get_datatables()
    {
        $order_index = $this->input->get('order[0][column]');
        $param['page_size'] = $this->input->get('length');
        $param['start'] = $this->input->get('start');
        $param['draw'] = $this->input->get('draw');
        $param['keyword'] = trim($this->input->get('search[value]'));
        $param['column'] = $this->input->get("columns[{$order_index}][data]");
        $param['dir'] = $this->input->get('order[0][dir]');
        $param['only_borrow'] = true;

        $results = $this->Borrow_model->find_with_page($param);

        $data['draw'] = $param['draw'];
        $data['recordsTotal'] = $results['count'];
        $data['recordsFiltered'] = $results['count_condition'];
        $data['data'] = $results['data'];
        $data['error'] = $results['error_message'];

        json_output($data);
    }

    public function export_borrow()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $param['keyword'] = trim($this->input->get('keyword'));
        $param['only_borrow'] = true;

        $results = $this->Borrow_model->export_borrow($param);

        $columns = array('รหัสผู้ยืม', 'ชื่อผู้ยืม', 'วันที่ยืม', 'กำหนดคืน');
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
                ->setCellValue('D' . $row, str_date($item['schedule_date']));
            $row++;
        }

        $sheet->getStyle('C2:D' . $row)
            ->getNumberFormat()
            ->setFormatCode('dd/mm/yyyy');

        $sheet->getStyle('C2:D' . $row)
            ->getAlignment()
            ->applyFromArray([
                'horizontal' => Alignment::HORIZONTAL_RIGHT,
            ]);

        $sheet->getStyle('A2:A' . $row)
            ->getNumberFormat()
            ->setFormatCode(NumberFormat::FORMAT_TEXT);

        $sheet->getStyle('A1:D1')->getFont()->setBold(true);
        foreach (range('A', 'D') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="file.xlsx"');
        $writer->save("php://output");
    }

    public function export_borrow_list()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $param['keyword'] = trim($this->input->get('keyword'));
        $param['only_borrow'] = true;

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

    public function pdf($id)
    {
        $this->load->model('Borrowdetail_model');
        $result['data'] = $this->Borrow_model->find($id);
        $result['details'] = $this->Borrowdetail_model->find_by_borrow($id);

        $page = strtoupper($this->input->get('page'));
        $page_type = $page=='A4' ? 'P' : 'L';
        $pdf = new TCPDF($page_type, 'mm', $page, true, 'UTF-8', false);
        $pdf->SetTitle(get_line('print'));

        /* ตั้งค่าระยะห่างของขอบกระดาษ */
        // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        /* ลบการตั้งค่า Header / footer */
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
        $pdf->SetAuthor('Tawatsak Tangeaim');
        $pdf->SetDisplayMode('real', 'default');
        $pdf->SetHeaderData();

        $pdf->SetFont('thsarabun', '', 13, '', true);

        $html = $this->load->view('borrow/pdf', $result, true);
        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('filename.pdf', 'I');
    }
}
