<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Validator;
use App\Standar;
use App\Order;
use DB;

class excelController extends Controller
{
    public function download_order(){

        $objPHPExcel = new Spreadsheet();

        $objPHPExcel->setActiveSheetIndex(0); 

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5.57);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25.71);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(18.67);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(18.14);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(9.5);

        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12.57);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12.71);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(14.67);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(21.14);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15.5);

        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15.57);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(22.71);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15.67);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(25.14);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(11.5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(12.57);

        $awal=1;
        $pertama=2;

        $data=order::join('standar','standar.id_standar','order.standar_id')
            ->join('tb_plant','tb_plant.id_plant','standar.plant_id')
            ->join('tb_satuan','tb_satuan.id_satuan','=','standar.satuan_id')->get();
        $no=1;
        
        
            //Inisialisasi tanggal kosong
        
        
            $styleArray = array(
                'background'  => array(
                    'color' => array('rgb' => 'FF0000'),
                ));


                //Bagian Isi
        
                $baris=$awal;
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.$baris, 'Id')
                            ->setCellValue('B'.$baris, 'Nama Item')
                            ->setCellValue('C'.$baris, 'Kode Formula')
                            ->setCellValue('D'.$baris, 'Revisi Formula')
                            ->setCellValue('E'.$baris, 'Nolot')
                            ->setCellValue('F'.$baris, 'Jumlah')
                            ->setCellValue('G'.$baris, 'Satuan')
                            ->setCellValue('H'.$baris, 'Status')
                            ->setCellValue('I'.$baris, 'Alasan')
                            ->setCellValue('J'.$baris, 'Tgl Kirim')
                            ->setCellValue('K'.$baris, 'Tgl Order')
                            ->setCellValue('L'.$baris, 'Pemohon')
                            ->setCellValue('M'.$baris, 'Tgl Kadaluarsa')
                            ->setCellValue('N'.$baris, 'Pengirim')
                            ->setCellValue('O'.$baris, 'Plant')
                            ->setCellValue('P'.$baris, 'Pembuat');
                            
                $objPHPExcel->getActiveSheet()->getStyle("A".$baris)->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('13DFE4');
                $objPHPExcel->getActiveSheet()->getStyle("A".$baris)->getAlignment()->setHorizontal('center');

                $objPHPExcel->getActiveSheet()->getStyle("B".$baris)->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('13DFE4');
                $objPHPExcel->getActiveSheet()->getStyle("B".$baris)->getAlignment()->setHorizontal('center');
                
                $objPHPExcel->getActiveSheet()->getStyle("c".$baris)->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('13DFE4');
                $objPHPExcel->getActiveSheet()->getStyle("c".$baris)->getAlignment()->setHorizontal('center');
                
                $objPHPExcel->getActiveSheet()->getStyle("D".$baris)->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('13DFE4');
                $objPHPExcel->getActiveSheet()->getStyle("D".$baris)->getAlignment()->setHorizontal('center');
                
                $objPHPExcel->getActiveSheet()->getStyle("E".$baris)->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('13DFE4');
                $objPHPExcel->getActiveSheet()->getStyle("E".$baris)->getAlignment()->setHorizontal('center');
                
                $objPHPExcel->getActiveSheet()->getStyle("F".$baris)->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('13DFE4');
                $objPHPExcel->getActiveSheet()->getStyle("F".$baris)->getAlignment()->setHorizontal('center');
                
                $objPHPExcel->getActiveSheet()->getStyle("G".$baris)->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('13DFE4');
                $objPHPExcel->getActiveSheet()->getStyle("G".$baris)->getAlignment()->setHorizontal('center');
                
                $objPHPExcel->getActiveSheet()->getStyle("H".$baris)->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('13DFE4');
                $objPHPExcel->getActiveSheet()->getStyle("H".$baris)->getAlignment()->setHorizontal('center');
                
                $objPHPExcel->getActiveSheet()->getStyle("I".$baris)->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('13DFE4');
                $objPHPExcel->getActiveSheet()->getStyle("I".$baris)->getAlignment()->setHorizontal('center');
                
                $objPHPExcel->getActiveSheet()->getStyle("J".$baris)->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('13DFE4');
                $objPHPExcel->getActiveSheet()->getStyle("J".$baris)->getAlignment()->setHorizontal('center');
                
                $objPHPExcel->getActiveSheet()->getStyle("K".$baris)->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('13DFE4');
                $objPHPExcel->getActiveSheet()->getStyle("K".$baris)->getAlignment()->setHorizontal('center');
                
                $objPHPExcel->getActiveSheet()->getStyle("L".$baris)->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('13DFE4');
                $objPHPExcel->getActiveSheet()->getStyle("L".$baris)->getAlignment()->setHorizontal('center');
                
                $objPHPExcel->getActiveSheet()->getStyle("M".$baris)->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('13DFE4');
                $objPHPExcel->getActiveSheet()->getStyle("M".$baris)->getAlignment()->setHorizontal('center');
                
                $objPHPExcel->getActiveSheet()->getStyle("N".$baris)->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('13DFE4');
                $objPHPExcel->getActiveSheet()->getStyle("N".$baris)->getAlignment()->setHorizontal('center');
                
                $objPHPExcel->getActiveSheet()->getStyle("O".$baris)->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('13DFE4');
                $objPHPExcel->getActiveSheet()->getStyle("O".$baris)->getAlignment()->setHorizontal('center');
                
                $objPHPExcel->getActiveSheet()->getStyle("p".$baris)->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('13DFE4');
                $objPHPExcel->getActiveSheet()->getStyle("p".$baris)->getAlignment()->setHorizontal('center');
        
                foreach($data as $_data){
                $line=$pertama;
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.$pertama, $_data['id_standar'])
                            ->setCellValue('B'.$pertama, $_data['nama_item'])
                            ->setCellValue('C'.$pertama, $_data['kode_formula'])
                            ->setCellValue('D'.$pertama, $_data['kode_revisi_formula'])
                            ->setCellValue('E'.$pertama, $_data['nolot'])
                            ->setCellValue('F'.$pertama, $_data['jumlah_pesan'])
                            ->setCellValue('G'.$pertama, $_data['satuan'])
                            ->setCellValue('H'.$pertama, $_data['stat'])
                            ->setCellValue('I'.$pertama, $_data['alasan'])
                            ->setCellValue('J'.$pertama, $_data['tgl_kirim'])
                            ->setCellValue('K'.$pertama, $_data['tgl_order'])
                            ->setCellValue('L'.$pertama, $_data['pemohon'])
                            ->setCellValue('M'.$pertama, $_data['tgl_kadaluarsa_rnd'])
                            ->setCellValue('N'.$pertama, $_data['pengirim'])
                            ->setCellValue('O'.$pertama, $_data['plant'])
                            ->setCellValue('P'.$pertama, $_data['pembuat']);
        
                            $pertama++;
                        }
        
            $no++;

        $objPHPExcel->getActiveSheet()->setTitle('Label Standar');

        $skrg=date('d m Y');

        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="Data_Order'.$skrg.'.xls"'); 

        header('Cache-Control: max-age=0'); 
        $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, "Xlsx");
        ob_end_clean();
        $objWriter->save('php://output');
    }
}