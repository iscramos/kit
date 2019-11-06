<?php

require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

 /**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2014 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version    1.8.0, 2014-03-02
 */

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

        

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');

        /** Include PHPExcel */
        require_once('PHPExcel/Classes/PHPExcel.php');

        $estiloTituloReporte = array(
            'font' => array(
                'name'      => 'Verdana',
                'bold'      => true,
                'italic'    => false,
                'strike'    => false,
                'size' =>16,
                'color'     => array(
                    'rgb' => 'FFFFFF'
                )
            ),
            'fill' => array(
              'type'  => PHPExcel_Style_Fill::FILL_SOLID,
              'color' => array(
                    'rgb' => '25733A')
          ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_NONE
                )
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );

        $estiloPrimero = array(
            'font' => array(
                'name'      => 'Verdana',
                'bold'      => true,
                'italic'    => false,
                'strike'    => false,
                'size' =>2,
                'color'     => array(
                    'rgb' => '000000'
                )
            ),
            'fill' => array(
              'type'  => PHPExcel_Style_Fill::FILL_SOLID,
              'color' => array(
                    'rgb' => 'FFDD45')
          ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );

        $estiloInformativo = array(
            'font' => array(
                'name'      => 'Verdana',
                'bold'      => true,
                'italic'    => false,
                'strike'    => false,
                'size' =>14,
                'color'     => array(
                    'rgb' => '000000'
                )
            ),
            'fill' => array(
              'type'  => PHPExcel_Style_Fill::FILL_SOLID,
              'color' => array(
                    'rgb' => 'E0E0E0')
          ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );

        $estiloPersonal = array(
            'font' => array(
                'name'      => 'Verdana',
                'bold'      => true,
                'italic'    => false,
                'strike'    => false,
                'size' =>14,
                'color'     => array(
                    'rgb' => '000000'
                )
            ),
            'fill' => array(
              'type'  => PHPExcel_Style_Fill::FILL_SOLID,
              'color' => array(
                    'rgb' => 'FFFFCC')
          ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );

        $estiloAcademico = array(
            'font' => array(
                'name'      => 'Verdana',
                'bold'      => true,
                'italic'    => false,
                'strike'    => false,
                'size' =>14,
                'color'     => array(
                    'rgb' => '000000'
                )
            ),
            'fill' => array(
              'type'  => PHPExcel_Style_Fill::FILL_SOLID,
              'color' => array(
                    'rgb' => 'FFE5CC')
          ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );
        $estiloProfesional = array(
            'font' => array(
                'name'      => 'Verdana',
                'bold'      => true,
                'italic'    => false,
                'strike'    => false,
                'size' =>14,
                'color'     => array(
                    'rgb' => '000000'
                )
            ),
            'fill' => array(
              'type'  => PHPExcel_Style_Fill::FILL_SOLID,
              'color' => array(
                    'rgb' => 'E5FFCC')
          ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );


        $columna1 = array(
            'font' => array(
                'name'  => 'Arial',
                'bold'  => false,
                'size' =>10,
                'color' => array(
                    'rgb' => '000000'
                )
            ),
            'fill' => array(
              'type'  => PHPExcel_Style_Fill::FILL_SOLID,
              'color' => array(
                    'rgb' => 'E0E0E0')
            ),
            'borders' => array(
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'left' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                )
            ),
            'alignment' =>  array(
                'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'rotation'=>0,
                'wrap'      => TRUE
            )
        );
        $columna2 = array(
            'font' => array(
                'name'  => 'Arial',
                'bold'  => false,
                'size' =>10,
                'color' => array(
                    'rgb' => '000000'
                )
            ),
            'fill' => array(
              'type'  => PHPExcel_Style_Fill::FILL_SOLID,
              'color' => array(
                    'rgb' => 'FFFFCC')
            ),
            'borders' => array(
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'left' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                )
            ),
            'alignment' =>  array(
                'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'rotation'=>0,
                'wrap'      => TRUE
            )
        );
        $columna3 = array(
            'font' => array(
                'name'  => 'Arial',
                'bold'  => TRUE,
                'size' =>10,
                'color' => array(
                    'rgb' => '000000'
                )
            ),
            'fill' => array(
              'type'  => PHPExcel_Style_Fill::FILL_SOLID,
              'color' => array(
                    'rgb' => 'FFE5CC')
            ),
            'borders' => array(
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'left' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                )
            ),
            'alignment' =>  array(
                'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'rotation'=>0,
                'wrap'      => TRUE
            )
        );
        $columna4 = array(
            'font' => array(
                'name'  => 'Arial',
                'bold'  => false,
                'size' =>10,
                'color' => array(
                    'rgb' => '000000'
                )
            ),
            'fill' => array(
              'type'  => PHPExcel_Style_Fill::FILL_SOLID,
              'color' => array(
                    'rgb' => 'E5FFCC')
            ),
            'borders' => array(
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'left' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                )
            ),
            'alignment' =>  array(
                'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'rotation'=>0,
                'wrap'      => TRUE
            )
        );


        $verde_stock = array(
            'font' => array(
                'name'  => 'Arial',
                'bold'  => false,
                'size' =>10,
                'color' => array(
                    'rgb' => '000000'
                )
            ),
            'fill' => array(
              'type'  => PHPExcel_Style_Fill::FILL_SOLID,
              'color' => array(
                    'rgb' => 'D4EDDA')
            ),
            'borders' => array(
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'left' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                )
            ),
            'alignment' =>  array(
                'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'rotation'=>0,
                'wrap'      => TRUE
            )
        );
        // para el semaforo
        $verde = array(
            'font' => array(
                'name'  => 'Arial',
                'bold'  => false,
                'size' =>10,
                'color' => array(
                    'rgb' => '000000'
                )
            ),
            'fill' => array(
              'type'  => PHPExcel_Style_Fill::FILL_SOLID,
              'color' => array(
                    'rgb' => 'CCFF99')
            ),
            'borders' => array(
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'left' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                )
            ),
            'alignment' =>  array(
                'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'rotation'=>0,
                'wrap'      => TRUE
            )
        );
        $naranja = array(
            'font' => array(
                'name'  => 'Arial',
                'bold'  => false,
                'size' =>10,
                'color' => array(
                    'rgb' => '000000'
                )
            ),
            'fill' => array(
              'type'  => PHPExcel_Style_Fill::FILL_SOLID,
              'color' => array(
                    'rgb' => 'fcf8e3')
            ),
            'borders' => array(
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'left' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                )
            ),
            'alignment' =>  array(
                'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'rotation'=>0,
                'wrap'      => TRUE
            )
        );
        $rojo = array(
            'font' => array(
                'name'  => 'Arial',
                'bold'  => false,
                'size' =>10,
                'color' => array(
                    'rgb' => '000000'
                )
            ),
            'fill' => array(
              'type'  => PHPExcel_Style_Fill::FILL_SOLID,
              'color' => array(
                    'rgb' => 'f2dede')
            ),
            'borders' => array(
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'left' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                )
            ),
            'alignment' =>  array(
                'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'rotation'=>0,
                'wrap'      => TRUE
            )
        );
        $blanco = array(
            'font' => array(
                'name'  => 'Arial',
                'bold'  => false,
                'size' =>10,
                'color' => array(
                    'rgb' => '000000'
                )
            ),
            'fill' => array(
              'type'  => PHPExcel_Style_Fill::FILL_SOLID,
              'color' => array(
                    'rgb' => 'FFFFFF')
            ),
            'borders' => array(
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'left' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                )
            ),
            'alignment' =>  array(
                'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'rotation'=>0,
                'wrap'      => TRUE
            )
        );

        $gris = array(
            'font' => array(
                'name'  => 'Arial',
                'bold'  => false,
                'size' =>10,
                'color' => array(
                    'rgb' => '000000'
                )
            ),
            'fill' => array(
              'type'  => PHPExcel_Style_Fill::FILL_SOLID,
              'color' => array(
                    'rgb' => 'E0E0E0')
            ),
            'borders' => array(
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'left' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                )
            ),
            'alignment' =>  array(
                'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'rotation'=>0,
                'wrap'      => TRUE
            )
        );

        $azul = array(
            'font' => array(
                'name'  => 'Arial',
                'bold'  => false,
                'size' =>10,
                'color' => array(
                    'rgb' => '000000'
                )
            ),
            'fill' => array(
              'type'  => PHPExcel_Style_Fill::FILL_SOLID,
              'color' => array(
                    'rgb' => '5bc0de')
            ),
            'borders' => array(
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'left' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                )
            ),
            'alignment' =>  array(
                'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'rotation'=>0,
                'wrap'      => TRUE
            )
        );
        $info = array(
            'font' => array(
                'name'  => 'Arial',
                'bold'  => false,
                'size' =>10,
                'color' => array(
                    'rgb' => '000000'
                )
            ),
            'fill' => array(
              'type'  => PHPExcel_Style_Fill::FILL_SOLID,
              'color' => array(
                    'rgb' => 'd9edf7')
            ),
            'borders' => array(
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                ),
                'left' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => '000000'
                    )
                )
            ),
            'alignment' =>  array(
                'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'rotation'=>0,
                'wrap'      => TRUE
            )
        );

        $estiloInformacion = new PHPExcel_Style();
        $estiloInformacion->applyFromArray( array(
            'font' => array(
                'name'  => 'Arial',
                'color' => array(
                    'rgb' => '000000'
                )
            ),
            'fill' => array(
          'type'  => PHPExcel_Style_Fill::FILL_SOLID,
          'color' => array(
                    'argb' => 'FFd9b7f4')
          ),
            'borders' => array(
                'left' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN ,
              'color' => array(
                      'rgb' => '3a2a47'
                    )
                )
            )
        ));


if( isset($_REQUEST["parametro"]) ) 
{
	$parametro = $_REQUEST["parametro"];
	if ($parametro == "STOCK_ALMACEN") 
	{
            
                # code...
                // Create new PHPExcel object
                $objPHPExcel = new PHPExcel();

                // Set document properties
                $objPHPExcel->getProperties()->setCreator("Nature Sweet Planta Colima")
                                             ->setLastModifiedBy("KIT")
                                             ->setTitle("KT")
                                             ->setSubject("Reporte General de stock de almacen")
                                             ->setDescription("ALMACEN")
                                             ->setKeywords("- L")
                                             ->setCategory("PRODUCCION");


                // Add some data
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A1', '')
                            ->mergeCells('A1:E1')
                            ->setCellValue('A2', 'REPORTE GENERAL DE STOCK')
                            ->mergeCells('A2:E2')
                            ->setCellValue('A3', 'CLAVE')
                            ->setCellValue('B3', 'CATEGORIA')
                            ->setCellValue('C3', 'DESCRIPCION')
                            ->setCellValue('D3', 'STOCK')
                            ->setCellValue('E3', 'UNIDAD DE MEDIDA');


                $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->applyFromArray($estiloPrimero);
                $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(5);
                $objPHPExcel->getActiveSheet()->getStyle('A2:E2')->applyFromArray($estiloTituloReporte);
                $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(50);
                /*$objPHPExcel->getActiveSheet()->getStyle('A3:E3')->applyFromArray($estiloInformativo); // para datos informativos
                $objPHPExcel->getActiveSheet()->getStyle('F3:W3')->applyFromArray($estiloPersonal); // para datos personales
                $objPHPExcel->getActiveSheet()->getStyle('X3:BF3')->applyFromArray($estiloAcademico); // para datos academicos
                $objPHPExcel->getActiveSheet()->getStyle('BG3:BK3')->applyFromArray($estiloProfesional); // para datos profesionales
                $objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(25);*/

                $objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($columna3); // para datos informativos
                $objPHPExcel->getActiveSheet()->getStyle('B3')->applyFromArray($columna3); // para datos informativos
                $objPHPExcel->getActiveSheet()->getStyle('C3')->applyFromArray($columna3); // para datos informativos
                $objPHPExcel->getActiveSheet()->getStyle('D3')->applyFromArray($columna3); // para datos informativos
                $objPHPExcel->getActiveSheet()->getStyle('E3')->applyFromArray($columna3); // para datos informativos

                $objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);

                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(100);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);

                
                $consulta = "SELECT herramientas_herramientas.*, herramientas_stock.stock, herramientas_udm.descripcion AS udm_descripcion, herramientas_categorias.categoria AS categoria_descripcion
                FROM herramientas_herramientas
                    LEFT JOIN herramientas_stock ON herramientas_herramientas.clave = herramientas_stock.clave
                    INNER JOIN herramientas_udm ON herramientas_herramientas.id_udm = herramientas_udm.id 
                    INNER JOIN herramientas_categorias ON herramientas_herramientas.id_categoria = herramientas_categorias.id  
                    WHERE herramientas_herramientas.activaStock = 1
                ORDER BY herramientas_herramientas.id_categoria, herramientas_herramientas.clave ASC";

                $herramientas_herramientas = Herramientas_herramientas::getAllByQuery($consulta);
                
                $pocision = 4;
                $registro = 1;
                foreach ($herramientas_herramientas as $herramienta):
                {
                        
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$pocision, $herramienta->clave);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$pocision)->applyFromArray($blanco);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$pocision, $herramienta->categoria_descripcion);
                    $objPHPExcel->getActiveSheet()->getStyle('B'.$pocision)->applyFromArray($blanco);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$pocision, $herramienta->descripcion);
                    $objPHPExcel->getActiveSheet()->getStyle('C'.$pocision)->applyFromArray($blanco);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$pocision, $herramienta->stock);
                    $objPHPExcel->getActiveSheet()->getStyle('D'.$pocision)->applyFromArray($verde_stock);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$pocision, $herramienta->udm_descripcion);
                    $objPHPExcel->getActiveSheet()->getStyle('E'.$pocision)->applyFromArray($blanco);
                    
                    $registro++;
                    $pocision++;
                }
                endforeach;
            

        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('KIT Almacen');


        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);


        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="ALMACEN_STOCK.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;

    }
    if ($parametro == "ZANCOS_DESFASE") 
    {
            
                # code...
                // Create new PHPExcel object
                $objPHPExcel = new PHPExcel();

                // Set document properties
                $objPHPExcel->getProperties()->setCreator("Nature Sweet Planta Colima")
                                             ->setLastModifiedBy("KIT")
                                             ->setTitle("KT")
                                             ->setSubject("Reporte Zancos en Desfase")
                                             ->setDescription("ZANCOS")
                                             ->setKeywords("- L")
                                             ->setCategory("PRODUCCION");


                // Add some data
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A1', '')
                            ->mergeCells('A1:I1')
                            ->setCellValue('A2', 'REPORTE ZANCOS EN DESFASE')
                            ->mergeCells('A2:I2')
                            ->setCellValue('A3', 'ZANCO')
                            ->setCellValue('B3', 'TAMAÑO')
                            ->setCellValue('C3', 'DESAFASE SEMANAS')
                            ->setCellValue('D3', 'ULTIMO REGISTRO')
                            ->setCellValue('E3', 'ZONA')
                            ->setCellValue('F3', 'GH')
                            ->setCellValue('G3', 'FECHA SALIDA')
                            ->setCellValue('H3', 'CODIGO')
                            ->setCellValue('I3', 'NOMBRE');


                $objPHPExcel->getActiveSheet()->getStyle('A1:I1')->applyFromArray($estiloPrimero);
                $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(5);
                $objPHPExcel->getActiveSheet()->getStyle('A2:I2')->applyFromArray($estiloTituloReporte);
                $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(50);
                /*$objPHPExcel->getActiveSheet()->getStyle('A3:E3')->applyFromArray($estiloInformativo); // para datos informativos
                $objPHPExcel->getActiveSheet()->getStyle('F3:W3')->applyFromArray($estiloPersonal); // para datos personales
                $objPHPExcel->getActiveSheet()->getStyle('X3:BF3')->applyFromArray($estiloAcademico); // para datos academicos
                $objPHPExcel->getActiveSheet()->getStyle('BG3:BK3')->applyFromArray($estiloProfesional); // para datos profesionales
                $objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(25);*/

                $objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($columna3); // para datos informativos
                $objPHPExcel->getActiveSheet()->getStyle('B3')->applyFromArray($columna3); // para datos informativos
                $objPHPExcel->getActiveSheet()->getStyle('C3')->applyFromArray($columna3); // para datos informativos
                $objPHPExcel->getActiveSheet()->getStyle('D3')->applyFromArray($columna3); // para datos informativos
                $objPHPExcel->getActiveSheet()->getStyle('E3')->applyFromArray($columna3); // para datos informativos
                $objPHPExcel->getActiveSheet()->getStyle('F3')->applyFromArray($columna3); // para datos informativos
                $objPHPExcel->getActiveSheet()->getStyle('G3')->applyFromArray($columna3); // para datos informativos
                $objPHPExcel->getActiveSheet()->getStyle('H3')->applyFromArray($columna3); // para datos informativos
                $objPHPExcel->getActiveSheet()->getStyle('I3')->applyFromArray($columna3); // para datos informativos

                $objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);

                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(100);

                
                $fecha_hoy = date("Y-m-d");
    
                $q = "SELECT m.*, zancos_tamanos.tamano AS tamano_descripcion

                    FROM zancos_movimientos m
                    INNER JOIN
                    (
                        SELECT max(id_registro) reg, no_zanco, fecha_salida
                        FROM zancos_movimientos
                        GROUP BY no_zanco
                    ) m2
                      ON m.no_zanco = m2.no_zanco
                      INNER JOIN zancos_tamanos ON m.tamano = zancos_tamanos.id
                      AND m.id_registro = m2.reg
                      AND m.tipo_movimiento = 3
                      AND m.fecha_entrega = 0
                      AND (DATEDIFF('$fecha_hoy', m.fecha_salida) ) > (m.tiempo_limite * 7)
                    order by m.no_zanco ASC";
                      
                $zancos_movimientos = Zancos_movimientos::getAllByQuery($q);
                
                $pocision = 4;
                $registro = 1;

                foreach ($zancos_movimientos as $zanco):
                {
                    
                   // aquí sacamos los años, para ver si son mayores a 1.5 años
                    $fechaHoy = date_create(date("Y-m-d"));
                    $fecha_salida = date_create($zanco->fecha_salida);

                            $d_dias = date_diff($fechaHoy, $fecha_salida);
                            $d_dias = $d_dias->format('%a');
                            $semanas_limite = $zanco->tiempo_limite;
                            $semanas_convertidas = $d_dias / 7;
                            $semanas_convertidas = round($semanas_convertidas, 2);
                   
                   
                        $diferencia_semanas = $semanas_convertidas - $semanas_limite;
                               
                      
                       
                        
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$pocision, $zanco->no_zanco);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$pocision)->applyFromArray($blanco);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$pocision, $zanco->tamano_descripcion);
                    $objPHPExcel->getActiveSheet()->getStyle('B'.$pocision)->applyFromArray($blanco);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$pocision, $diferencia_semanas);
                    $objPHPExcel->getActiveSheet()->getStyle('C'.$pocision)->applyFromArray($rojo);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$pocision, $zanco->id_registro);
                    $objPHPExcel->getActiveSheet()->getStyle('D'.$pocision)->applyFromArray($blanco);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$pocision, $zanco->zona);
                    $objPHPExcel->getActiveSheet()->getStyle('E'.$pocision)->applyFromArray($blanco);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$pocision, $zanco->gh);
                    $objPHPExcel->getActiveSheet()->getStyle('F'.$pocision)->applyFromArray($blanco);

                    if($zanco->fecha_salida > 0)
                    {
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$pocision, date("d-m-Y", strtotime($zanco->fecha_salida)));
                        $objPHPExcel->getActiveSheet()->getStyle('G'.$pocision)->applyFromArray($blanco);
                    }
                    else
                    {
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$pocision, '-');
                        $objPHPExcel->getActiveSheet()->getStyle('G'.$pocision)->applyFromArray($blanco);
                    }
                    
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$pocision, $zanco->ns_salida_lider);
                    $objPHPExcel->getActiveSheet()->getStyle('H'.$pocision)->applyFromArray($blanco);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$pocision, $zanco->nombre_lider_salida);
                    $objPHPExcel->getActiveSheet()->getStyle('I'.$pocision)->applyFromArray($blanco);
                    
                    $registro++;
                    $pocision++;
                }
                endforeach;
            

        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('KIT ZANCOS');


        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);


        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="ZANCOS_DESFASE.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;

    }  
}
else
{
	echo "NO DATA";
}


//echo $str;
?>