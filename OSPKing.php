<?php 
date_default_timezone_set('America/Sao_Paulo');
require __DIR__.'/lib/autoload.php';
require __DIR__.'/system/abab1214b922f20db86eff2116a12249.php';
/*********************************************/

/* if( empty($_GET["token"]) || $_GET["token"] != $keys_key_moto ):
  die("Invalid request! For More Info Contact OwnSMMPanel.in");
endif; */
/*********************************************/


$crons_details = $conn->prepare("SELECT * FROM crons");
$crons_details->execute(array("cron_status"=>"1"));
$crons_details = $crons_details->fetchAll(PDO::FETCH_ASSOC);



  //crons status
  $CRON_GUVENLIK = true;
  /**************************************************************************************************************************************************/
  foreach($crons_details as $cron){
    // echo $cron['cron_endup']. ' intervalo de execução do cron (minutos) - '.$cron['cron_name'].'  '.$cron['cron_id'].'<br>';
    $cron_date_update = date('d.m.Y H:i:s', strtotime($cron['cron_date_update']));
    // echo $cron_date_update. ' data da última execução do cron <br>';
    $newdate = date('d.m.Y H:i:s', strtotime('+'.$cron['cron_endup'].' minutes', strtotime($cron_date_update))); 
      //echo $newdate. ' data em que o cron deve ser executado<br>';
    /**************************************************************************************************************************************/
    if(strtotime($newdate) < strtotime(date('d.m.Y H:i:s'))){
          //echo '<br> cron correu <br>';
      /*******************************************************************************************************************/
      if($cron['cron_id'] == 1){

        include('api_orders.php');
        
        $update = $conn->prepare("UPDATE crons SET cron_date_update=:date WHERE cron_id=:cron_id ");
        $update->execute(array("cron_id"=>1,"date"=>date("Y.m.d H:i:s") ));
                
        if($update){
            $cronname = $cron['cron_name'];
            $report = $conn->prepare("INSERT INTO crons_report SET crons_service_name=:crons_service_name, crons_detail=:crons_detail ");
            $report = $report->execute(array("crons_service_name"=>$cronname, "crons_detail"=>$cronname." chamado cron ".date("d.m.Y H:i:s"). " foi executado." ));
            
        }else{
            exit;
        }
      }
      /*******************************************************************************************************************/
      /*******************************************************************************************************************/
      if($cron['cron_id'] == 2){

        include('site_orders.php');
        
        $update = $conn->prepare("UPDATE crons SET cron_date_update=:date WHERE cron_id=:cron_id ");
        $update->execute(array("cron_id"=>2,"date"=>date("Y.m.d H:i:s") ));
                
        if($update){
            $cronname = $cron['cron_name'];
            $report = $conn->prepare("INSERT INTO crons_report SET crons_service_name=:crons_service_name, crons_detail=:crons_detail ");
            $report = $report->execute(array("crons_service_name"=>$cronname, "crons_detail"=>$cronname." chamado cron ".date("d.m.Y H:i:s"). " foi executado." ));
            
        }else{
            exit;
        }
      }
      /*******************************************************************************************************************/
      /*******************************************************************************************************************/
      if($cron['cron_id'] == 3){

        include('dripfeed.php');
        
        $update = $conn->prepare("UPDATE crons SET cron_date_update=:date WHERE cron_id=:cron_id ");
        $update->execute(array("cron_id"=>3,"date"=>date("Y.m.d H:i:s") ));
                
        if($update){
            $cronname = $cron['cron_name'];
            $report = $conn->prepare("INSERT INTO crons_report SET crons_service_name=:crons_service_name, crons_detail=:crons_detail ");
            $report = $report->execute(array("crons_service_name"=>$cronname, "crons_detail"=>$cronname." chamado cron ".date("d.m.Y H:i:s"). " foi executado." ));
            
        }else{
            exit;
        }
      }
      /*******************************************************************************************************************/
      /*******************************************************************************************************************/
      if($cron['cron_id'] == 4){

        include('sync.php');
        
        $update = $conn->prepare("UPDATE crons SET cron_date_update=:date WHERE cron_id=:cron_id ");
        $update->execute(array("cron_id"=>4,"date"=>date("Y.m.d H:i:s") ));
                
        if($update){
            $cronname = $cron['cron_name'];
            $report = $conn->prepare("INSERT INTO crons_report SET crons_service_name=:crons_service_name, crons_detail=:crons_detail ");
            $report = $report->execute(array("crons_service_name"=>$cronname, "crons_detail"=>$cronname." chamado cron ".date("d.m.Y H:i:s"). " foi executado." ));
            
        }else{
            exit;
        }
      }
      /*******************************************************************************************************************/
      /*******************************************************************************************************************/
      if($cron['cron_id'] == 5){

        include('providers.php');
        
        $update = $conn->prepare("UPDATE crons SET cron_date_update=:date WHERE cron_id=:cron_id ");
        $update->execute(array("cron_id"=>5,"date"=>date("Y.m.d H:i:s") ));
                
        if($update){
            $cronname = $cron['cron_name'];
            $report = $conn->prepare("INSERT INTO crons_report SET crons_service_name=:crons_service_name, crons_detail=:crons_detail ");
            $report = $report->execute(array("crons_service_name"=>$cronname, "crons_detail"=>$cronname." chamado cron ".date("d.m.Y H:i:s"). " foi executado." ));
            
        }else{
            exit;
        }
      }
      /*******************************************************************************************************************/
      /*******************************************************************************************************************/
      if($cron['cron_id'] == 6){

        include('send_tasks.php');
        
        $update = $conn->prepare("UPDATE crons SET cron_date_update=:date WHERE cron_id=:cron_id ");
        $update->execute(array("cron_id"=>6,"date"=>date("Y.m.d H:i:s") ));
                
        if($update){
            $cronname = $cron['cron_name'];
            $report = $conn->prepare("INSERT INTO crons_report SET crons_service_name=:crons_service_name, crons_detail=:crons_detail ");
            $report = $report->execute(array("crons_service_name"=>$cronname, "crons_detail"=>$cronname." chamado cron ".date("d.m.Y H:i:s"). " foi executado." ));
            
        }else{
            exit;
        }
      }
      /*******************************************************************************************************************/
      /*******************************************************************************************************************/
      if($cron['cron_id'] == 7){

        include('balance_alert.php');
        
        $update = $conn->prepare("UPDATE crons SET cron_date_update=:date WHERE cron_id=:cron_id ");
        $update->execute(array("cron_id"=>7,"date"=>date("Y.m.d H:i:s") ));
                
        if($update){
            $cronname = $cron['cron_name'];
            $report = $conn->prepare("INSERT INTO crons_report SET crons_service_name=:crons_service_name, crons_detail=:crons_detail ");
            $report = $report->execute(array("crons_service_name"=>$cronname, "crons_detail"=>$cronname." chamado cron ".date("d.m.Y H:i:s"). " foi executado." ));
            
        }else{
            exit;
        }
      }
    /*******************************************************************************************************************/
    
    
     //echo '<br> ------------------------- <br>';
    
    
  } else{/*echo '<br> cron çalışmadı<br><br><br>';*/}
  /**************************************************************************************************************************************/
}
/**************************************************************************************************************************************************/
?>          