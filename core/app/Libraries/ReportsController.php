<?php

namespace App\Libraries;

use App\Controllers\BaseController;
use App\Models\CustomModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportsController extends BaseController {

    public function init() {
        $type = request()->getGet('type');
        $file = request()->getGet('file');
        $download = request()->getGet('download');
        
        $allowedType = [
            'user-report',
            'visitor-report',
            'referrer-report',
            'log-report'
        ];

        $allowedFile = [
            'csv',
            'excel',
            'text',
        ];


        if(in_array($type, $allowedType) && in_array($file, $allowedFile)) {
            $data = $this->get_data($type);

            $downloadable ;

            switch($file) {
                case 'csv':
                    $downloadable = $this->parseToCSV($type, $data);
                    break;
                case 'excel':
                     $downloadable = $this->parseToExcel($type, $data);
                    break;
                case 'text':
                     $downloadable = $this->parseToText($type, $data);
                    break;
                case 'pdf':
                     $downloadable = $this->parseToPDF($type, $data);
                    break;
                default:
                    'invalid file type';
                    break;
            }
        }
    }

    public function get_data($type) {

        $config = [
            'user-report' => [
                'table' => 'lites_users',
                'select' => 'id, username, first_name, last_name,
                            position, image',
                'order' => 'id DESC'
            ],
            'visitor-report' => [
                'table' => 'lites_site_visitors',
                'order' => 'id DESC'
            ],
            'referrer-report' => [
                'table' => 'lites_site_referrers',
                'order' => 'id DESC'
            ],
            'log-report' => [
                'table' => 'lites_logs',
                'order' => 'id DESC'
            ],
        ];
        
        $model = new CustomModel();
        try {
            $data = $model->get_data($config[$type]);

            return $data;
        } catch (\Exception $e) {
            print_r($e);
        }            

    }

    public function parseToCSV($type, $data) {
        
        $csv = '';
        $header = array_keys((array) $data[0]);
        $csv .= implode(',', $header) . PHP_EOL;

        foreach($data as $value) {
            $value = array_map('strtolower', (array) $value);
            $csv .= implode(',', $value) . PHP_EOL;
        }

        $filename = strtolower(date('F_d_Y') . '_' . $type . '.csv');
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        echo $csv;
        exit();
    }

    public function parseToExcel($type, $data) {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = array_keys((array) $data[0]);

        foreach($headers as $key => $value) { 
            $sheet->setCellValueByColumnAndRow($key + 1, 1, strtoupper($value));
        }

        $rowIndex = 2;

        foreach ($data as $row) {
            $columnIndex = 1;
            foreach ((array) $row as $value) {
                $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, strtoupper($value));
                $columnIndex++;
            }
            $rowIndex++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = strtolower(date('F_d_Y') . '_' . $type . '.xlsx');

        $writer->save($filename);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        exit();

    }
    
    public function parseToText($type, $data) {
        $text = '';
        foreach ($data as $row) {
            foreach ((array) $row as $key => $value) {
                $text .= strtolower("$key: $value ") . PHP_EOL;
            }
            $text .= PHP_EOL;
        }
        $filename = strtolower(date('F_d_Y') . '_' . $type . '.txt');
        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        echo $text;
        exit();
    }



}