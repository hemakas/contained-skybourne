<?php
namespace App\Repositories;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class ReportsRepository {
  
    private $creator = "Samurdhi";
    private $company = "S2S";
    
    public function generateExportExcel($fileName, $title, $sheetName, $description, $dataRows, $headers = []) {
        
        if (empty($headers) && isset($dataRows[0]) && is_array($dataRows[0])) {
            $headers = array_keys($dataRows[0]);
        }
        
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
                    ->setCreator($this->creator)
                    ->setLastModifiedBy($this->creator)
                    ->setTitle($title)
                    ->setSubject($title)
                    ->setDescription($description)
                    ->setKeywords('Report')
                    ->setCategory('deliveries');


        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle($sheetName);
        //$sheet->setCellValue('A1', 'Hello World !');
        $sheet->fromArray($headers, NULL, 'A1');
        $sheet->fromArray($dataRows, NULL, 'A2');
        $objWriter = new Xls($spreadsheet);

                // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');

        // It will be called file.xls
        header('Content-Disposition: attachment; filename="'.$fileName.'"');

        // Write file to the browser
        $objWriter->save('php://output');
        
    }
}

