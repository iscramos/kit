<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');
include('phpqrcode/qrlib.php'); 
//include('phpqrcode/qrconfig.php'); 

//$bloques = Bloques::getById($id);
//print_r($bloques);
$str="";
if(isset($_REQUEST['atributo']) && ($_SESSION["type"]==1)) // para el admimistrador
{	
	//$mes = $_GET['mes'];
	$atributo = $_REQUEST['atributo'];
	$consulta = $_REQUEST['consulta'];

	//include('../lib/full/qrlib.php'); 
    //include('config.php'); 

    // how to build raw content - QRCode with simple Business Card (VCard) 
    $tempDir = $contentRead."qr_temporal/"; 
     
    // here our data 
    $atributo = $_REQUEST['atributo'];
	$consulta = $_REQUEST['consulta'];
	$qr_destino = $url;
    // we building raw data 
    
    $codeContents = $qr_destino."public_scanner.php?consulta=".$consulta."&atributo=".$atributo."\n";
    $codeContents.= "\nEsta app funciona bajo la red local de NatureSweet";
    /*$codeContents  = 'BEGIN:VCARD'."\n"; 
    $codeContents .= 'FN:'.$name."\n"; 
    $codeContents .= 'TEL;WORK;VOICE:'.$phone."\n"; 
    $codeContents .= 'END:VCARD'; */
     
    // generating 
    QRcode::png($codeContents, $tempDir.$atributo.'.png', QR_ECLEVEL_L, 3); 
    
    // displaying 
    echo '<img src="'.$tempDir.$atributo.'.png" />'; 
}
else
{
	echo "NO REQUEST";
}


echo $str;


?>
