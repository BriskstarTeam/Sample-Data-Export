<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$startDate  = sanitize_text_field($_POST['startdate']);
$endDate    = sanitize_text_field($_POST['enddate']);
if($startDate != ""){
    global $wpdb;
    $table_name = $wpdb->users;
    if(($startDate != "") || ($endDate != "") ){
        if($endDate == ""){
            $daterange = "date(user_registered) BETWEEN '".$startDate.' 00:00:00'."' AND '".date('Y-m-d').' 00:00:00'."'";
        }else{
            $daterange = "date(user_registered) BETWEEN '".$startDate.' 00:00:00'."' AND '".$endDate.' 00:00:00'."'";
        }

        $datas      = $wpdb->get_results("SELECT * FROM $table_name WHERE $daterange");
        $fileName   = "userData-" . time() . ".csv";
        $dir        = wp_upload_dir();
        $fileDir    = $dir['basedir'].'/csv_file/';
        $file_path  = $fileDir.$fileName;
        $out        = fopen($file_path, 'w');
        $headers    = array('Full Name', 'Email', 'Created Date');
       
        fputcsv($out, $headers);    
        
        foreach($datas as $dataVal){
            fputcsv($out, array($dataVal->user_nicename, $dataVal->user_email, date('m-d-Y', strtotime($dataVal->user_registered))));
        }

        header( "Content-Type: text/csv" );
        header( "Cache-Control: no-cache, must-revalidate" );
        header( "Cache-Control: post-check=0, pre-check=0", false);
        header( "Expires: Sat, 26 Jul 1997 05:00:00 GMT" );
        header( "Content-Disposition: attachment; filename=".basename($file_path));
        header( "Content-length: ".filesize($file_path));
        
        ob_clean();
        flush();
        readfile($file_path);
        unlink($file_path);
        fclose($out);
        die();
    }
}
