<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Validator;
use App\Standar;

class cetakController extends Controller
{
    public function cetak_all(){

        $objPHPExcel = new Spreadsheet();

        $objPHPExcel->setActiveSheetIndex(0); 

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(2.57);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(18.71);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(1.67);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(29.14);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(1.5);

        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(2.57);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(18.71);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(1.67);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(29.14);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(1.5);

        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(2.57);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(18.71);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(1.67);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(29.14);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(1.5);

        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(2.57);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(18.71);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(1.67);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(29.14);

        $awal=1;

        $data=standar::where('freeze','=','N')->where('jenis_item_id','=','1')
            ->join('tb_plant','tb_plant.id_plant','=','standar.plant_id')->get();
        $no=1;
        foreach($data as $_data){
        
            //Inisialisasi tanggal kosong
            if($_data['tgl_masuk']=="0000-00-00"){$_data['tgl_masuk']="-";}
            else{$_data['tgl_masuk']=date('d-M-Y', strtotime($_data['tgl_masuk']));}
        
            if($_data['tgl_kadaluarsa_rnd']=="0000-00-00"){$_data['tgl_kadaluarsa_rnd']="-";}
            else{$_data['tgl_kadaluarsa_rnd']=date('d-M-Y', strtotime($_data['tgl_kadaluarsa_rnd']));}
        
            if($_data['tgl_datang']=="0000-00-00"){$_data['tgl_datang']="-";}
            else{$_data['tgl_datang']=date('d-M-Y', strtotime($_data['tgl_datang']));}
        
            if($_data['tgl_dibuat']=="0000-00-00"){$_data['tgl_dibuat']="-";}
            else{$_data['tgl_dibuat']=date('d-M-Y', strtotime($_data['tgl_dibuat']));}
        
            $baris=$awal;
        
            $styleArray = array(
                'background'  => array(
                    'color' => array('rgb' => 'FF0000'),
                ));

            if($no%4==1){

                //Bagian Isi
                $objPHPExcel->getActiveSheet()->mergeCells('A'.$baris.':B'.$baris);
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.$baris, 'PT. NUTRIFOOD INDONESIA')
                            ->setCellValue('D'.$baris, 'KODE FORM : F.R.12005');
                $objPHPExcel->getActiveSheet()->getStyle("A".$baris)->getFont()->setSize(8);
                $objPHPExcel->getActiveSheet()->getStyle("D".$baris)->getFont()->setSize(8);
                $objPHPExcel->getActiveSheet()->getStyle("D".$baris)->getAlignment()->setHorizontal('right');
        
                $objPHPExcel->getActiveSheet()->getRowDimension( $baris )->setRowHeight( 11 );
        
                $baris++;
        
                $objPHPExcel->getActiveSheet()->mergeCells('A'.$baris.':D'.$baris);
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.$baris, 'Standar WIP (SWI)');

                $objPHPExcel->getActiveSheet()->getStyle("A".$baris)->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('13DFE4');
                $objPHPExcel->getActiveSheet()->getStyle("A".$baris)->getAlignment()->setHorizontal('center');
        
                $baris++;
        
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.$baris, '1')
                            ->setCellValue('B'.$baris, 'Nama Produk')
                            ->setCellValue('C'.$baris, ':')
                            ->setCellValue('D'.$baris, $_data['nama_item']);
        
                $baris++;
        
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.$baris, '2')
                            ->setCellValue('B'.$baris, 'Kode Formula')
                            ->setCellValue('C'.$baris, ':')
                            ->setCellValue('D'.$baris, $_data['kode_formula']);
        
                $baris++;
        
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.$baris, '3')
                            ->setCellValue('B'.$baris, 'Kode Revisi Formula')
                            ->setCellValue('C'.$baris, ':')
                            ->setCellValue('D'.$baris, $_data['kode_revisi_formula']);
        
                $baris++;

                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.$baris, '4')
                            ->setCellValue('B'.$baris, 'Plant')
                            ->setCellValue('C'.$baris, ':')
                            ->setCellValue('D'.$baris, $_data['plant']);
        
                $baris++;
        
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.$baris, '5')
                            ->setCellValue('B'.$baris, 'Tgl Dibuat Standar')
                            ->setCellValue('C'.$baris, ':')
                            ->setCellValue('D'.$baris, $_data['tgl_dibuat']);
        
                $baris++;
        
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.$baris, '6')
                            ->setCellValue('B'.$baris, 'Expire Date (Std)')
                            ->setCellValue('C'.$baris, ':')
                            ->setCellValue('D'.$baris, $_data['tgl_kadaluarsa_rnd']);
        
                $baris++;
        
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.$baris, '7')
                            ->setCellValue('B'.$baris, 'Tempat Penyimpanan')
                            ->setCellValue('C'.$baris, ':')
                            ->setCellValue('D'.$baris, $_data['tempat_penyimpanan']);
        
                $baris++;
        
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.$baris, '8')
                            ->setCellValue('B'.$baris, 'Serving Size (g/mL)')
                            ->setCellValue('C'.$baris, ':')
                            ->setCellValue('D'.$baris, $_data['catatan_serving_size']);
        
                $baris++;
        
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.$baris, '9')
                            ->setCellValue('B'.$baris, 'Dibuat Oleh')
                            ->setCellValue('C'.$baris, ':')
                            ->setCellValue('D'.$baris, $_data['pembuat']);
        
                $baris++;
        
                $objPHPExcel->getActiveSheet()->mergeCells('A'.$baris.':B'.$baris);
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.$baris, '')
                            ->setCellValue('D'.$baris, 'Revisi /Berlaku : 01/04.12.2012');
                $objPHPExcel->getActiveSheet()->getStyle("D".$baris)->getFont()->setSize(8);
                $objPHPExcel->getActiveSheet()->getStyle("D".$baris)->getAlignment()->setHorizontal('right');
        
                $objPHPExcel->getActiveSheet()->getRowDimension( $baris )->setRowHeight( 11 );
        
                $baris++;
        
                $objPHPExcel->getActiveSheet()->mergeCells('A'.$baris.':B'.$baris);
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.$baris, '')
                            ->setCellValue('D'.$baris, 'Lama simpan : selama proses');
                $objPHPExcel->getActiveSheet()->getStyle("A".$baris)->getFont()->setSize(8);
                $objPHPExcel->getActiveSheet()->getStyle("D".$baris)->getFont()->setSize(8);
                $objPHPExcel->getActiveSheet()->getStyle("A".$baris)->getAlignment()->setHorizontal('right');
                $objPHPExcel->getActiveSheet()->getStyle("D".$baris)->getAlignment()->setHorizontal('right');
        
                $objPHPExcel->getActiveSheet()->getRowDimension( $baris )->setRowHeight( 11 );
        
            }
        
            if($no%4==2){
        
                //Bagian Isi
                $objPHPExcel->getActiveSheet()->mergeCells('F'.$baris.':G'.$baris);
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('F'.$baris, 'PT. NUTRIFOOD INDONESIA')
                            ->setCellValue('I'.$baris, 'KODE FORM : F.R.12005');
                $objPHPExcel->getActiveSheet()->getStyle("F".$baris)->getFont()->setSize(8);
                $objPHPExcel->getActiveSheet()->getStyle("I".$baris)->getFont()->setSize(8);
                $objPHPExcel->getActiveSheet()->getStyle("I".$baris)->getAlignment()->setHorizontal('right');
        
                $objPHPExcel->getActiveSheet()->getRowDimension( $baris )->setRowHeight( 11 );
        
                $baris++;
        
                $objPHPExcel->getActiveSheet()->mergeCells('F'.$baris.':I'.$baris);
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('F'.$baris, 'Standar WIP (SWI)');

                $objPHPExcel->getActiveSheet()->getStyle("F".$baris)->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('13DFE4');
                            
                $objPHPExcel->getActiveSheet()->getStyle("F".$baris)->getAlignment()->setHorizontal('center');
        
                $baris++;
        
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('F'.$baris, '1')
                            ->setCellValue('G'.$baris, 'Nama Produk')
                            ->setCellValue('H'.$baris, ':')
                            ->setCellValue('I'.$baris, $_data['nama_item']);
        
                $baris++;
        
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('F'.$baris, '2')
                            ->setCellValue('G'.$baris, 'Kode Formula')
                            ->setCellValue('H'.$baris, ':')
                            ->setCellValue('I'.$baris, $_data['kode_formula']);
        
                $baris++;
        
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('F'.$baris, '3')
                            ->setCellValue('G'.$baris, 'Kode Revisi Formula')
                            ->setCellValue('H'.$baris, ':')
                            ->setCellValue('I'.$baris, $_data['kode_revisi_formula']);
        
                $baris++;
        
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('F'.$baris, '4')
                            ->setCellValue('G'.$baris, 'plant')
                            ->setCellValue('H'.$baris, ':')
                            ->setCellValue('I'.$baris, $_data['plant']);
        
                $baris++;

                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('F'.$baris, '5')
                            ->setCellValue('G'.$baris, 'Tgl Dibuat Standar')
                            ->setCellValue('H'.$baris, ':')
                            ->setCellValue('I'.$baris, $_data['tgl_dibuat']);
        
                $baris++;
        
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('F'.$baris, '6')
                            ->setCellValue('G'.$baris, 'Expire Date (Std)')
                            ->setCellValue('H'.$baris, ':')
                            ->setCellValue('I'.$baris, $_data['tgl_kadaluarsa_rnd']);
                $baris++;
        
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('F'.$baris, '7')
                            ->setCellValue('G'.$baris, 'Tempat Penyimpanan')
                            ->setCellValue('H'.$baris, ':')
                            ->setCellValue('I'.$baris, $_data['tempat_penyimpanan']);
        
                $baris++;
        
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('F'.$baris, '8')
                            ->setCellValue('G'.$baris, 'Serving Size (g/mL)')
                            ->setCellValue('H'.$baris, ':')
                            ->setCellValue('I'.$baris, $_data['serving_size']);
        
                $baris++;
        
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('F'.$baris, '9')
                            ->setCellValue('G'.$baris, 'Dibuat Oleh')
                            ->setCellValue('H'.$baris, ':')
                            ->setCellValue('I'.$baris, $_data['pembuat']);
        
                $baris++;
        
                $objPHPExcel->getActiveSheet()->mergeCells('F'.$baris.':G'.$baris);
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('F'.$baris, '')
                            ->setCellValue('I'.$baris, 'Revisi /Berlaku : 01/04.12.2012');
                $objPHPExcel->getActiveSheet()->getStyle("I".$baris)->getFont()->setSize(8);
                $objPHPExcel->getActiveSheet()->getStyle("I".$baris)->getAlignment()->setHorizontal('right');
        
                $objPHPExcel->getActiveSheet()->getRowDimension( $baris )->setRowHeight( 11 );
        
                $baris++;
        
                $objPHPExcel->getActiveSheet()->mergeCells('F'.$baris.':G'.$baris);
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('F'.$baris, '')
                            ->setCellValue('I'.$baris, 'Lama simpan : selama proses');
                $objPHPExcel->getActiveSheet()->getStyle("F".$baris)->getFont()->setSize(8);
                $objPHPExcel->getActiveSheet()->getStyle("I".$baris)->getFont()->setSize(8);
                $objPHPExcel->getActiveSheet()->getStyle("F".$baris)->getAlignment()->setHorizontal('right');
                $objPHPExcel->getActiveSheet()->getStyle("I".$baris)->getAlignment()->setHorizontal('right');
        
                $objPHPExcel->getActiveSheet()->getRowDimension( $baris )->setRowHeight( 11 );
        
            }
        
            if($no%4==3){
        
                //Bagian Isi
                $objPHPExcel->getActiveSheet()->mergeCells('K'.$baris.':L'.$baris);
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('K'.$baris, 'PT. NUTRIFOOD INDONESIA')
                            ->setCellValue('N'.$baris, 'KODE FORM : F.R.12005');
                $objPHPExcel->getActiveSheet()->getStyle("K".$baris)->getFont()->setSize(8);
                $objPHPExcel->getActiveSheet()->getStyle("N".$baris)->getFont()->setSize(8);
                $objPHPExcel->getActiveSheet()->getStyle("N".$baris)->getAlignment()->setHorizontal('right');
        
                $objPHPExcel->getActiveSheet()->getRowDimension( $baris )->setRowHeight( 11 );
        
                $baris++;
        
                $objPHPExcel->getActiveSheet()->mergeCells('K'.$baris.':N'.$baris);
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('K'.$baris, 'Standar WIP (SWI)');
        
                $objPHPExcel->getActiveSheet()->getStyle("K".$baris)->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('13DFE4');
                $objPHPExcel->getActiveSheet()->getStyle("K".$baris)->getAlignment()->setHorizontal('center');
                $baris++;
        
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('K'.$baris, '1')
                            ->setCellValue('L'.$baris, 'Nama Produk')
                            ->setCellValue('M'.$baris, ':')
                            ->setCellValue('N'.$baris, $_data['nama_item']);
        
                $baris++;
        
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('K'.$baris, '2')
                            ->setCellValue('L'.$baris, 'Kode Formula')
                            ->setCellValue('M'.$baris, ':')
                            ->setCellValue('N'.$baris, $_data['kode_formula']);
        
                $baris++;
        
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('K'.$baris, '3')
                            ->setCellValue('L'.$baris, 'Kode Revisi Formula')
                            ->setCellValue('M'.$baris, ':')
                            ->setCellValue('N'.$baris, $_data['kode_revisi_formula']);
        
                $baris++;

                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('K'.$baris, '4')
                            ->setCellValue('L'.$baris, 'Plant')
                            ->setCellValue('M'.$baris, ':')
                            ->setCellValue('N'.$baris, $_data['plant']);
        
                $baris++;
        
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('K'.$baris, '5')
                            ->setCellValue('L'.$baris, 'Tgl Dibuat Standar')
                            ->setCellValue('M'.$baris, ':')
                            ->setCellValue('N'.$baris, $_data['tgl_dibuat']);
        
                $baris++;
        
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('K'.$baris, '6')
                            ->setCellValue('L'.$baris, 'Expire Date (Std)')
                            ->setCellValue('M'.$baris, ':')
                            ->setCellValue('N'.$baris, $_data['tgl_kadaluarsa_rnd']);
        
                $baris++;
        
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('K'.$baris, '7')
                            ->setCellValue('L'.$baris, 'Tempat Penyimpanan')
                            ->setCellValue('M'.$baris, ':')
                            ->setCellValue('N'.$baris, $_data['tempat_penyimpanan']);
        
                $baris++;
        
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('K'.$baris, '8')
                            ->setCellValue('L'.$baris, 'Serving Size (g/mL)')
                            ->setCellValue('M'.$baris, ':')
                            ->setCellValue('N'.$baris, $_data['catatan_serving_size']);
        
                $baris++;
        
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('K'.$baris, '9')
                            ->setCellValue('L'.$baris, 'Dibuat Oleh')
                            ->setCellValue('M'.$baris, ':')
                            ->setCellValue('N'.$baris, $_data['pembuat']);
        
                $baris++;
        
                $objPHPExcel->getActiveSheet()->mergeCells('K'.$baris.':L'.$baris);
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('K'.$baris, '')
                            ->setCellValue('N'.$baris, 'Revisi /Berlaku : 01/04.12.2012');
                $objPHPExcel->getActiveSheet()->getStyle("N".$baris)->getFont()->setSize(8);
                $objPHPExcel->getActiveSheet()->getStyle("N".$baris)->getAlignment()->setHorizontal('right');
        
                $objPHPExcel->getActiveSheet()->getRowDimension( $baris )->setRowHeight( 11 );
        
                $baris++;
        
                $objPHPExcel->getActiveSheet()->mergeCells('K'.$baris.':L'.$baris);
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('K'.$baris, '')
                            ->setCellValue('N'.$baris, 'Lama simpan : selama proses');
                $objPHPExcel->getActiveSheet()->getStyle("K".$baris)->getFont()->setSize(8);
                $objPHPExcel->getActiveSheet()->getStyle("N".$baris)->getFont()->setSize(8);
                $objPHPExcel->getActiveSheet()->getStyle("K".$baris)->getAlignment()->setHorizontal('right');
                $objPHPExcel->getActiveSheet()->getStyle("N".$baris)->getAlignment()->setHorizontal('right');
        
                $objPHPExcel->getActiveSheet()->getRowDimension( $baris )->setRowHeight( 11 );
        
            }
        
            if($no%4==0){
        
                //Bagian Isi
                $objPHPExcel->getActiveSheet()->mergeCells('P'.$baris.':Q'.$baris);
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('P'.$baris, 'PT. NUTRIFOOD INDONESIA')
                            ->setCellValue('S'.$baris, 'KODE FORM : F.R.12005');
                $objPHPExcel->getActiveSheet()->getStyle("P".$baris)->getFont()->setSize(8);
                $objPHPExcel->getActiveSheet()->getStyle("S".$baris)->getFont()->setSize(8);
                $objPHPExcel->getActiveSheet()->getStyle("S".$baris)->getAlignment()->setHorizontal('right');
        
                $objPHPExcel->getActiveSheet()->getRowDimension( $baris )->setRowHeight( 11 );
        
                $baris++;
        
                $objPHPExcel->getActiveSheet()->mergeCells('P'.$baris.':S'.$baris);
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('P'.$baris, 'Standar WIP (SWI)');

                $objPHPExcel->getActiveSheet()->getStyle("P".$baris)->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('13DFE4');
                $objPHPExcel->getActiveSheet()->getStyle("P".$baris)->getAlignment()->setHorizontal('center');
        
                $baris++;
        
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('P'.$baris, '1')
                            ->setCellValue('Q'.$baris, 'Nama Produk')
                            ->setCellValue('R'.$baris, ':')
                            ->setCellValue('S'.$baris, $_data['nama_item']);
        
                $baris++;
        
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('P'.$baris, '2')
                            ->setCellValue('Q'.$baris, 'Kode Formula')
                            ->setCellValue('R'.$baris, ':')
                            ->setCellValue('S'.$baris, $_data['kode_formula']);
        
                $baris++;
        
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('P'.$baris, '3')
                            ->setCellValue('Q'.$baris, 'Kode Revisi Formula')
                            ->setCellValue('R'.$baris, ':')
                            ->setCellValue('S'.$baris, $_data['kode_revisi_formula']);
        
                $baris++;
        
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('P'.$baris, '4')
                            ->setCellValue('Q'.$baris, 'Plant')
                            ->setCellValue('R'.$baris, ':')
                            ->setCellValue('S'.$baris, $_data['plant']);
        
                $baris++;

                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('P'.$baris, '5')
                            ->setCellValue('Q'.$baris, 'Tgl Dibuat Standar')
                            ->setCellValue('R'.$baris, ':')
                            ->setCellValue('S'.$baris, $_data['tgl_dibuat']);
        
                $baris++;
        
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('P'.$baris, '6')
                            ->setCellValue('Q'.$baris, 'Expire Date (Std)')
                            ->setCellValue('R'.$baris, ':')
                            ->setCellValue('S'.$baris, $_data['tgl_kadaluarsa_rnd']);
        
                $baris++;
        
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('P'.$baris, '7')
                            ->setCellValue('Q'.$baris, 'Tempat Penyimpanan')
                            ->setCellValue('R'.$baris, ':')
                            ->setCellValue('S'.$baris, $_data['tempat_penyimpanan']);
        
                $baris++;
        
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('P'.$baris, '8')
                            ->setCellValue('Q'.$baris, 'Serving Size (g/mL)')
                            ->setCellValue('R'.$baris, ':')
                            ->setCellValue('S'.$baris, $_data['catatan_serving_size']);
        
                $baris++;
        
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('P'.$baris, '9')
                            ->setCellValue('Q'.$baris, 'Dibuat Oleh')
                            ->setCellValue('R'.$baris, ':')
                            ->setCellValue('S'.$baris, $_data['pembuat']);
        
                $baris++;
        
                $objPHPExcel->getActiveSheet()->mergeCells('P'.$baris.':Q'.$baris);
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('P'.$baris, '')
                            ->setCellValue('S'.$baris, 'Revisi /Berlaku : 01/04.12.2012');
                $objPHPExcel->getActiveSheet()->getStyle("S".$baris)->getFont()->setSize(8);
                $objPHPExcel->getActiveSheet()->getStyle("S".$baris)->getAlignment()->setHorizontal('right');
        
                $objPHPExcel->getActiveSheet()->getRowDimension( $baris )->setRowHeight( 11 );
        
                $baris++;
        
                $objPHPExcel->getActiveSheet()->mergeCells('P'.$baris.':Q'.$baris);
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('P'.$baris, '')
                            ->setCellValue('S'.$baris, 'Lama simpan : selama proses');
                $objPHPExcel->getActiveSheet()->getStyle("P".$baris)->getFont()->setSize(8);
                $objPHPExcel->getActiveSheet()->getStyle("S".$baris)->getFont()->setSize(8);
                $objPHPExcel->getActiveSheet()->getStyle("P".$baris)->getAlignment()->setHorizontal('right');
                $objPHPExcel->getActiveSheet()->getStyle("S".$baris)->getAlignment()->setHorizontal('right');
        
                $objPHPExcel->getActiveSheet()->getRowDimension( $baris )->setRowHeight( 11 );
        
                $jeda=$baris+1;
        
                $objPHPExcel->getActiveSheet()->getRowDimension( $jeda )->setRowHeight( 12 );
        
                $awal=$baris+2;
        
            }
        
            $no++;
        }

        $objPHPExcel->getActiveSheet()->setTitle('Label Standar');

        $skrg=date('d m Y');

        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="LABEL_STANDAR_WIP_ALL_'.$skrg.'.xls"'); 

        header('Cache-Control: max-age=0'); 
        $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, "Xlsx");
        ob_end_clean();
        $objWriter->save('php://output');
    }

    public function cetak_id(Request $request){
        $objPHPExcel = new Spreadsheet();

        $objPHPExcel->setActiveSheetIndex(0); 

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(2.57);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(18.71);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(1.67);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(29.14);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(1.5);

        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(2.57);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(18.71);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(1.67);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(29.14);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(1.5);

        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(2.57);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(18.71);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(1.67);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(29.14);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(1.5);

        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(2.57);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(18.71);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(1.67);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(29.14);

        $no=1;
        $awal=1;

        $rules = array(
        ); 

        if($request->id!=''){
        $validator = Validator::make($request->all(), $rules);  
        if ($validator->passes()) {
        $idz = implode(",", $request->input('id'));
        $ids = explode(",", $idz);
        $idb = implode(",", $request->input('std'));
        $ida = explode(",", $idb);
        for ($i = 0; $i < count($ids); $i++)
            {
                //BAGIAN ISI
                $data=standar::where('id_standar','=',$ids[$i])
                ->join('tb_plant','tb_plant.id_plant','=','standar.plant_id')->get();
                foreach($data as $_data){

                    //Inisialisasi tanggal kosong
                    if($_data['tgl_masuk']=="0000-00-00"){$_data['tgl_masuk']="-";}
                    else{$_data['tgl_masuk']=date('d-M-Y', strtotime($_data['tgl_masuk']));}

                    if($_data['tgl_kadaluarsa_rnd']=="0000-00-00"){$_data['tgl_kadaluarsa_rnd']="-";}
                    else{$_data['tgl_kadaluarsa_rnd']=date('d-M-Y', strtotime($_data['tgl_kadaluarsa_rnd']));}

                    if($_data['tgl_datang']=="0000-00-00"){$_data['tgl_datang']="-";}
                    else{$_data['tgl_datang']=date('d-M-Y', strtotime($_data['tgl_datang']));}

                    if($_data['tgl_dibuat']=="0000-00-00"){$_data['tgl_dibuat']="-";}
                    else{$_data['tgl_dibuat']=date('d-M-Y', strtotime($_data['tgl_dibuat']));}

                    $baris=$awal;

                    if($no%4==1){

                        //Bagian Isi
                        $objPHPExcel->getActiveSheet()->mergeCells('A'.$baris.':B'.$baris);
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('A'.$baris, 'PT. NUTRIFOOD INDONESIA')
                                    ->setCellValue('D'.$baris, 'KODE FORM : F.R.12005');
                        $objPHPExcel->getActiveSheet()->getStyle("A".$baris)->getFont()->setSize(8);
                        $objPHPExcel->getActiveSheet()->getStyle("D".$baris)->getFont()->setSize(8);
                        $objPHPExcel->getActiveSheet()->getStyle("D".$baris)->getAlignment()->setHorizontal('right');
                
                        $objPHPExcel->getActiveSheet()->getRowDimension( $baris )->setRowHeight( 11 );
                
                        $baris++;
                
                        $objPHPExcel->getActiveSheet()->mergeCells('A'.$baris.':D'.$baris);
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('A'.$baris, 'Standar WIP (SWI)');
        
                        $objPHPExcel->getActiveSheet()->getStyle("A".$baris)->getFill()
                                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                    ->getStartColor()->setARGB('13DFE4');
                        $objPHPExcel->getActiveSheet()->getStyle("A".$baris)->getAlignment()->setHorizontal('center');
                
                        $baris++;
                
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('A'.$baris, '1')
                                    ->setCellValue('B'.$baris, 'Nama Produk')
                                    ->setCellValue('C'.$baris, ':')
                                    ->setCellValue('D'.$baris, $_data['nama_item']);
                
                        $baris++;
                
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('A'.$baris, '2')
                                    ->setCellValue('B'.$baris, 'Kode Formula')
                                    ->setCellValue('C'.$baris, ':')
                                    ->setCellValue('D'.$baris, $_data['kode_formula']);
                
                        $baris++;
                
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('A'.$baris, '3')
                                    ->setCellValue('B'.$baris, 'Kode Revisi Formula')
                                    ->setCellValue('C'.$baris, ':')
                                    ->setCellValue('D'.$baris, $_data['kode_revisi_formula']);
                
                        $baris++;
                
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('A'.$baris, '4')
                                    ->setCellValue('B'.$baris, 'Plant')
                                    ->setCellValue('C'.$baris, ':')
                                    ->setCellValue('D'.$baris, $_data['plant']);
                
                        $baris++;

                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('A'.$baris, '5')
                                    ->setCellValue('B'.$baris, 'Tgl Dibuat Standar')
                                    ->setCellValue('C'.$baris, ':')
                                    ->setCellValue('D'.$baris, $_data['tgl_dibuat']);
                
                        $baris++;
                
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('A'.$baris, '7')
                                    ->setCellValue('B'.$baris, 'Expire Date (Std)')
                                    ->setCellValue('C'.$baris, ':')
                                    ->setCellValue('D'.$baris, $_data['tgl_kadaluarsa_rnd']);
                
                        $baris++;
                
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('A'.$baris, '8')
                                    ->setCellValue('B'.$baris, 'Tempat Penyimpanan')
                                    ->setCellValue('C'.$baris, ':')
                                    ->setCellValue('D'.$baris, $_data['tempat_penyimpanan']);
                
                        $baris++;
                
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('A'.$baris, '8')
                                    ->setCellValue('B'.$baris, 'Serving Size (g/mL)')
                                    ->setCellValue('C'.$baris, ':')
                                    ->setCellValue('D'.$baris, $_data['catatan_serving_size']);
                
                        $baris++;
                
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('A'.$baris, '8')
                                    ->setCellValue('B'.$baris, 'Dibuat Oleh')
                                    ->setCellValue('C'.$baris, ':')
                                    ->setCellValue('D'.$baris, $_data['pembuat']);
                
                        $baris++;
                
                        $objPHPExcel->getActiveSheet()->mergeCells('A'.$baris.':B'.$baris);
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('A'.$baris, '')
                                    ->setCellValue('D'.$baris, 'Revisi /Berlaku : 01/04.12.2012');
                        $objPHPExcel->getActiveSheet()->getStyle("D".$baris)->getFont()->setSize(8);
                        $objPHPExcel->getActiveSheet()->getStyle("D".$baris)->getAlignment()->setHorizontal('right');
                
                        $objPHPExcel->getActiveSheet()->getRowDimension( $baris )->setRowHeight( 11 );
                
                        $baris++;
                
                        $objPHPExcel->getActiveSheet()->mergeCells('A'.$baris.':B'.$baris);
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('A'.$baris, '')
                                    ->setCellValue('D'.$baris, 'Lama simpan : selama proses');
                        $objPHPExcel->getActiveSheet()->getStyle("A".$baris)->getFont()->setSize(8);
                        $objPHPExcel->getActiveSheet()->getStyle("D".$baris)->getFont()->setSize(8);
                        $objPHPExcel->getActiveSheet()->getStyle("A".$baris)->getAlignment()->setHorizontal('right');
                        $objPHPExcel->getActiveSheet()->getStyle("D".$baris)->getAlignment()->setHorizontal('right');
                
                        $objPHPExcel->getActiveSheet()->getRowDimension( $baris )->setRowHeight( 11 );
                
                    }
                
                    if($no%4==2){
                
                        //Bagian Isi
                        $objPHPExcel->getActiveSheet()->mergeCells('F'.$baris.':G'.$baris);
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('F'.$baris, 'PT. NUTRIFOOD INDONESIA')
                                    ->setCellValue('I'.$baris, 'KODE FORM : F.R.12005');
                        $objPHPExcel->getActiveSheet()->getStyle("F".$baris)->getFont()->setSize(8);
                        $objPHPExcel->getActiveSheet()->getStyle("I".$baris)->getFont()->setSize(8);
                        $objPHPExcel->getActiveSheet()->getStyle("I".$baris)->getAlignment()->setHorizontal('right');
                
                        $objPHPExcel->getActiveSheet()->getRowDimension( $baris )->setRowHeight( 11 );
                
                        $baris++;
                
                        $objPHPExcel->getActiveSheet()->mergeCells('F'.$baris.':I'.$baris);
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('F'.$baris, 'Standar WIP (SWI)');
        
                        $objPHPExcel->getActiveSheet()->getStyle("F".$baris)->getFill()
                                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                    ->getStartColor()->setARGB('13DFE4');
                                    
                        $objPHPExcel->getActiveSheet()->getStyle("F".$baris)->getAlignment()->setHorizontal('center');
                
                        $baris++;
                
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('F'.$baris, '1')
                                    ->setCellValue('G'.$baris, 'Nama Produk')
                                    ->setCellValue('H'.$baris, ':')
                                    ->setCellValue('I'.$baris, $_data['nama_item']);
                
                        $baris++;
                
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('F'.$baris, '2')
                                    ->setCellValue('G'.$baris, 'Kode Formula')
                                    ->setCellValue('H'.$baris, ':')
                                    ->setCellValue('I'.$baris, $_data['kode_formula']);
                
                        $baris++;
                
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('F'.$baris, '3')
                                    ->setCellValue('G'.$baris, 'Kode Revisi Formula')
                                    ->setCellValue('H'.$baris, ':')
                                    ->setCellValue('I'.$baris, $_data['kode_revisi_formula']);
                
                        $baris++;
                
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('F'.$baris, '4')
                                    ->setCellValue('G'.$baris, 'Plant')
                                    ->setCellValue('H'.$baris, ':')
                                    ->setCellValue('I'.$baris, $_data['plant']);
                
                        $baris++;

                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('F'.$baris, '5')
                                    ->setCellValue('G'.$baris, 'Tgl Dibuat Standar')
                                    ->setCellValue('H'.$baris, ':')
                                    ->setCellValue('I'.$baris, $_data['tgl_dibuat']);
                
                        $baris++;
                
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('F'.$baris, '6')
                                    ->setCellValue('G'.$baris, 'Expire Date (Std)')
                                    ->setCellValue('H'.$baris, ':')
                                    ->setCellValue('I'.$baris, $_data['tgl_kadaluarsa_rnd']);
                        $baris++;
                
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('F'.$baris, '7')
                                    ->setCellValue('G'.$baris, 'Tempat Penyimpanan')
                                    ->setCellValue('H'.$baris, ':')
                                    ->setCellValue('I'.$baris, $_data['tempat_penyimpanan']);
                
                        $baris++;
                
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('F'.$baris, '8')
                                    ->setCellValue('G'.$baris, 'Serving Size (g/mL)')
                                    ->setCellValue('H'.$baris, ':')
                                    ->setCellValue('I'.$baris, $_data['catatan_serving_size']);
                
                        $baris++;
                
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('F'.$baris, '9')
                                    ->setCellValue('G'.$baris, 'Dibuat Oleh')
                                    ->setCellValue('H'.$baris, ':')
                                    ->setCellValue('I'.$baris, $_data['pembuat']);
                
                        $baris++;
                
                        $objPHPExcel->getActiveSheet()->mergeCells('F'.$baris.':G'.$baris);
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('F'.$baris, '')
                                    ->setCellValue('I'.$baris, 'Revisi /Berlaku : 01/04.12.2012');
                        $objPHPExcel->getActiveSheet()->getStyle("I".$baris)->getFont()->setSize(8);
                        $objPHPExcel->getActiveSheet()->getStyle("I".$baris)->getAlignment()->setHorizontal('right');
                
                        $objPHPExcel->getActiveSheet()->getRowDimension( $baris )->setRowHeight( 11 );
                
                        $baris++;
                
                        $objPHPExcel->getActiveSheet()->mergeCells('F'.$baris.':G'.$baris);
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('F'.$baris, '')
                                    ->setCellValue('I'.$baris, 'Lama simpan : selama proses');
                        $objPHPExcel->getActiveSheet()->getStyle("F".$baris)->getFont()->setSize(8);
                        $objPHPExcel->getActiveSheet()->getStyle("I".$baris)->getFont()->setSize(8);
                        $objPHPExcel->getActiveSheet()->getStyle("F".$baris)->getAlignment()->setHorizontal('right');
                        $objPHPExcel->getActiveSheet()->getStyle("I".$baris)->getAlignment()->setHorizontal('right');
                
                        $objPHPExcel->getActiveSheet()->getRowDimension( $baris )->setRowHeight( 11 );
                
                    }
                
                    if($no%4==3){
                
                        //Bagian Isi
                        $objPHPExcel->getActiveSheet()->mergeCells('K'.$baris.':L'.$baris);
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('K'.$baris, 'PT. NUTRIFOOD INDONESIA')
                                    ->setCellValue('N'.$baris, 'KODE FORM : F.R.12005');
                        $objPHPExcel->getActiveSheet()->getStyle("K".$baris)->getFont()->setSize(8);
                        $objPHPExcel->getActiveSheet()->getStyle("N".$baris)->getFont()->setSize(8);
                        $objPHPExcel->getActiveSheet()->getStyle("N".$baris)->getAlignment()->setHorizontal('right');
                
                        $objPHPExcel->getActiveSheet()->getRowDimension( $baris )->setRowHeight( 11 );
                
                        $baris++;
                
                        $objPHPExcel->getActiveSheet()->mergeCells('K'.$baris.':N'.$baris);
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('K'.$baris, 'Standar WIP (SWI)');
                
                        $objPHPExcel->getActiveSheet()->getStyle("K".$baris)->getFill()
                                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                    ->getStartColor()->setARGB('13DFE4');
                        $objPHPExcel->getActiveSheet()->getStyle("K".$baris)->getAlignment()->setHorizontal('center');
                        $baris++;
                
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('K'.$baris, '1')
                                    ->setCellValue('L'.$baris, 'Nama Produk')
                                    ->setCellValue('M'.$baris, ':')
                                    ->setCellValue('N'.$baris, $_data['nama_item']);
                
                        $baris++;
                
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('K'.$baris, '2')
                                    ->setCellValue('L'.$baris, 'Kode Formula')
                                    ->setCellValue('M'.$baris, ':')
                                    ->setCellValue('N'.$baris, $_data['kode_formula']);
                
                        $baris++;
                
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('K'.$baris, '3')
                                    ->setCellValue('L'.$baris, 'Kode Revisi Formula')
                                    ->setCellValue('M'.$baris, ':')
                                    ->setCellValue('N'.$baris, $_data['kode_revisi_formula']);
                
                        $baris++;
                
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('K'.$baris, '4')
                                    ->setCellValue('L'.$baris, 'Plant')
                                    ->setCellValue('M'.$baris, ':')
                                    ->setCellValue('N'.$baris, $_data['plant']);
                
                        $baris++;

                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('K'.$baris, '5')
                                    ->setCellValue('L'.$baris, 'Tgl Dibuat Standar')
                                    ->setCellValue('M'.$baris, ':')
                                    ->setCellValue('N'.$baris, $_data['tgl_dibuat']);
                
                        $baris++;
                
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('K'.$baris, '6')
                                    ->setCellValue('L'.$baris, 'Expire Date (Std)')
                                    ->setCellValue('M'.$baris, ':')
                                    ->setCellValue('N'.$baris, $_data['tgl_kadaluarsa_rnd']);
                
                        $baris++;
                
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('K'.$baris, '7')
                                    ->setCellValue('L'.$baris, 'Tempat Penyimpanan')
                                    ->setCellValue('M'.$baris, ':')
                                    ->setCellValue('N'.$baris, $_data['tempat_penyimpanan']);
                
                        $baris++;
                
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('K'.$baris, '8')
                                    ->setCellValue('L'.$baris, 'Serving Size (g/mL)')
                                    ->setCellValue('M'.$baris, ':')
                                    ->setCellValue('N'.$baris, $_data['catatan_serving_size']);
                
                        $baris++;
                
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('K'.$baris, '9')
                                    ->setCellValue('L'.$baris, 'Dibuat Oleh')
                                    ->setCellValue('M'.$baris, ':')
                                    ->setCellValue('N'.$baris, $_data['pembuat']);
                
                        $baris++;
                
                        $objPHPExcel->getActiveSheet()->mergeCells('K'.$baris.':L'.$baris);
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('K'.$baris, '')
                                    ->setCellValue('N'.$baris, 'Revisi /Berlaku : 01/04.12.2012');
                        $objPHPExcel->getActiveSheet()->getStyle("N".$baris)->getFont()->setSize(8);
                        $objPHPExcel->getActiveSheet()->getStyle("N".$baris)->getAlignment()->setHorizontal('right');
                
                        $objPHPExcel->getActiveSheet()->getRowDimension( $baris )->setRowHeight( 11 );
                
                        $baris++;
                
                        $objPHPExcel->getActiveSheet()->mergeCells('K'.$baris.':L'.$baris);
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('K'.$baris, '')
                                    ->setCellValue('N'.$baris, 'Lama simpan : selama proses');
                        $objPHPExcel->getActiveSheet()->getStyle("K".$baris)->getFont()->setSize(8);
                        $objPHPExcel->getActiveSheet()->getStyle("N".$baris)->getFont()->setSize(8);
                        $objPHPExcel->getActiveSheet()->getStyle("K".$baris)->getAlignment()->setHorizontal('right');
                        $objPHPExcel->getActiveSheet()->getStyle("N".$baris)->getAlignment()->setHorizontal('right');
                
                        $objPHPExcel->getActiveSheet()->getRowDimension( $baris )->setRowHeight( 11 );
                
                    }
                
                    if($no%4==0){
                
                        //Bagian Isi
                        $objPHPExcel->getActiveSheet()->mergeCells('P'.$baris.':Q'.$baris);
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('P'.$baris, 'PT. NUTRIFOOD INDONESIA')
                                    ->setCellValue('S'.$baris, 'KODE FORM : F.R.12005');
                        $objPHPExcel->getActiveSheet()->getStyle("P".$baris)->getFont()->setSize(8);
                        $objPHPExcel->getActiveSheet()->getStyle("S".$baris)->getFont()->setSize(8);
                        $objPHPExcel->getActiveSheet()->getStyle("S".$baris)->getAlignment()->setHorizontal('right');
                
                        $objPHPExcel->getActiveSheet()->getRowDimension( $baris )->setRowHeight( 11 );
                
                        $baris++;
                
                        $objPHPExcel->getActiveSheet()->mergeCells('P'.$baris.':S'.$baris);
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('P'.$baris, 'Standar WIP (SWI)');
        
                        $objPHPExcel->getActiveSheet()->getStyle("P".$baris)->getFill()
                                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                    ->getStartColor()->setARGB('13DFE4');
                        $objPHPExcel->getActiveSheet()->getStyle("P".$baris)->getAlignment()->setHorizontal('center');
                
                        $baris++;
                
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('P'.$baris, '1')
                                    ->setCellValue('Q'.$baris, 'Nama Produk')
                                    ->setCellValue('R'.$baris, ':')
                                    ->setCellValue('S'.$baris, $_data['nama_item']);
                
                        $baris++;
                
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('P'.$baris, '2')
                                    ->setCellValue('Q'.$baris, 'Kode Formula')
                                    ->setCellValue('R'.$baris, ':')
                                    ->setCellValue('S'.$baris, $_data['kode_formula']);
                
                        $baris++;
                
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('P'.$baris, '3')
                                    ->setCellValue('Q'.$baris, 'Kode Revisi Formula')
                                    ->setCellValue('R'.$baris, ':')
                                    ->setCellValue('S'.$baris, $_data['kode_revisi_formula']);
                
                        $baris++;
                
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('P'.$baris, '4')
                                    ->setCellValue('Q'.$baris, 'Plant')
                                    ->setCellValue('R'.$baris, ':')
                                    ->setCellValue('S'.$baris, $_data['plant']);
                
                        $baris++;

                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('P'.$baris, '4')
                                    ->setCellValue('Q'.$baris, 'Tgl Dibuat Standar')
                                    ->setCellValue('R'.$baris, ':')
                                    ->setCellValue('S'.$baris, $_data['tgl_dibuat']);
                
                        $baris++;
                
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('P'.$baris, '5')
                                    ->setCellValue('Q'.$baris, 'Expire Date (Std)')
                                    ->setCellValue('R'.$baris, ':')
                                    ->setCellValue('S'.$baris, $_data['tgl_kadaluarsa_rnd']);
                
                        $baris++;
                
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('P'.$baris, '6')
                                    ->setCellValue('Q'.$baris, 'Tempat Penyimpanan')
                                    ->setCellValue('R'.$baris, ':')
                                    ->setCellValue('S'.$baris, $_data['tempat_penyimpanan']);
                
                        $baris++;
                
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('P'.$baris, '7')
                                    ->setCellValue('Q'.$baris, 'Serving Size (g/mL)')
                                    ->setCellValue('R'.$baris, ':')
                                    ->setCellValue('S'.$baris, $_data['catatan_serving_size']);
                
                        $baris++;
                
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('P'.$baris, '8')
                                    ->setCellValue('Q'.$baris, 'Dibuat Oleh')
                                    ->setCellValue('R'.$baris, ':')
                                    ->setCellValue('S'.$baris, $_data['pembuat']);
                
                        $baris++;
                
                        $objPHPExcel->getActiveSheet()->mergeCells('P'.$baris.':Q'.$baris);
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('P'.$baris, '')
                                    ->setCellValue('S'.$baris, 'Revisi /Berlaku : 01/04.12.2012');
                        $objPHPExcel->getActiveSheet()->getStyle("S".$baris)->getFont()->setSize(8);
                        $objPHPExcel->getActiveSheet()->getStyle("S".$baris)->getAlignment()->setHorizontal('right');
                
                        $objPHPExcel->getActiveSheet()->getRowDimension( $baris )->setRowHeight( 11 );
                
                        $baris++;
                
                        $objPHPExcel->getActiveSheet()->mergeCells('P'.$baris.':Q'.$baris);
                        $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue('P'.$baris, '')
                                    ->setCellValue('S'.$baris, 'Lama simpan : selama proses');
                        $objPHPExcel->getActiveSheet()->getStyle("P".$baris)->getFont()->setSize(8);
                        $objPHPExcel->getActiveSheet()->getStyle("S".$baris)->getFont()->setSize(8);
                        $objPHPExcel->getActiveSheet()->getStyle("P".$baris)->getAlignment()->setHorizontal('right');
                        $objPHPExcel->getActiveSheet()->getStyle("S".$baris)->getAlignment()->setHorizontal('right');
                
                        $objPHPExcel->getActiveSheet()->getRowDimension( $baris )->setRowHeight( 11 );
                
                        $jeda=$baris+1;
                
                        $objPHPExcel->getActiveSheet()->getRowDimension( $jeda )->setRowHeight( 12 );
                
                        $awal=$baris+2;
                
                    }

                    $no++;

                }

            }
            
            $objPHPExcel->getActiveSheet()->setTitle('Label Standar');

            $skrg=date('d m Y');
    
            header('Content-Type: application/vnd.ms-excel'); 
            header('Content-Disposition: attachment;filename="LABEL_STANDAR_WIP_'.$skrg.'.xls"'); 
    
            header('Cache-Control: max-age=0'); 
            $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, "Xlsx");
            ob_end_clean();
            $objWriter->save('php://output');
        }

        }
    }
}
