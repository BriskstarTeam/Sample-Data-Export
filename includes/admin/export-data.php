<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if (isset($_POST['startdate']))
{
    if(!empty($_POST['startdate']) && isset($_POST['startdate'])){
        $startDate  = sanitize_text_field($_POST['startdate']);
    }
    if(!empty($_POST['enddate']) && isset($_POST['enddate']))
    {
        $endDate    = sanitize_text_field($_POST['enddate']);
    }
    else{
        $endDate = date('Y-m-d h:i:s');
    }
    global $wpdb;
    $table_name = $wpdb->users;
    $args = array (
        'date_query'    => array(
            array(
                'before'    => $endDate,
                'after'     => $startDate,
                'inclusive' => true,
            ),
        ),
    );

    $user_query = new WP_User_Query( $args );
    $data = $user_query->results;
    $fileName   = "userData-" . time() . ".csv";
    $dir        = wp_upload_dir();
    $fileDir    = $dir['basedir'].'/csv_file/';
    $file_path  = $fileDir.$fileName;
    $out        = fopen($file_path, 'w');
    if (!file_exists($file_path)) 
    {
        mkdir($file_path, 0777, true);
        chmod($file_path, 0777);
    }
    $headers    = array('Full Name', 'Email', 'Created Date');
           
    fputcsv($out, $headers);    
    foreach($data as $dataVal){
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
   