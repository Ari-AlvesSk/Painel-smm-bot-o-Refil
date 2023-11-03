<?php


    session_start();
    ob_start();
    use Slim\Http\Request;
    use Slim\Http\Response;
    
    
    
    if(isset($_REQUEST['collection_id']) || isset($_REQUEST['id'])){
            
        if(isset($_REQUEST['collection_id'])){
          $id = $_REQUEST['collection_id'];
        }else{
          $id = $_REQUEST['id'];
        }

        require_once '../../vendor/autoload.php';
        require_once '../../vendor/pix_auto/autoload.php';
        $config = require_once '../../system/835fa18dc2d7d18b612881e301dca97f.php';
    
        try {
            $conn = new PDO("mysql:host=" . $config["db"]["host"] . ";dbname=" . $config["db"]["name"] . ";charset=" . $config["db"]["charset"] . ";", $config["db"]["user"], $config["db"]["pass"]);
        }
        catch(PDOException $e) {
            die($e->getMessage());
        }
    
        $method = $conn->prepare("SELECT * FROM payment_methods WHERE id=:id");
        $method->execute(array("id" => 19));
        $method = $method->fetch(PDO::FETCH_ASSOC);
        $extra = json_decode($method["method_extras"], true);
    
        $sysset = $conn->prepare("SELECT * FROM settings WHERE id=:id");
        $sysset->execute(array("id" => 1));
        $sysset = $sysset->fetch(PDO::FETCH_ASSOC);
        
        //CONSULTA PAGAMENTO
        
          $curl = curl_init();
    
           curl_setopt_array($curl, array(
             CURLOPT_URL => 'https://api.mercadopago.com/v1/payments/'.$id,
             CURLOPT_RETURNTRANSFER => true,
             CURLOPT_ENCODING => '',
             CURLOPT_MAXREDIRS => 10,
             CURLOPT_TIMEOUT => 0,
             CURLOPT_FOLLOWLOCATION => true,
             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
             CURLOPT_CUSTOMREQUEST => 'GET',
             CURLOPT_HTTPHEADER => array(
                   'Authorization: Bearer '.$extra['access_token']
             ),
           ));
        
          $payment_info = json_decode(curl_exec($curl), true);
          curl_close($curl);
          
     
        
          $status = $payment_info["status"];
          $ref    = $payment_info["external_reference"];
              
        //CONSULTA PAGAMENTO
    
    
        $payments = $conn->prepare("SELECT * FROM payments WHERE payment_extra=:extra ORDER BY payment_id DESC");
        $payments->execute(array("extra" => $ref));
        $payments = $payments->fetch(PDO::FETCH_ASSOC);
        
        if($payments){
            
            $user = $conn->prepare("SELECT * FROM clients WHERE client_id=:id");
            $user->execute(array("id" => $payments['client_id']));
            $user = $user->fetch(PDO::FETCH_ASSOC);
            
                
           // $amount = ($payments['payment_amount'] + ($payments['payment_amount'] * $extra["fee"] / 100));
            
             // pending | approved
              
            if($status == 'approved'){
    
                $update = $conn->prepare('UPDATE payments SET client_balance=:balance, payment_status=:status, payment_delivery=:delivery, payment_extra=:extra WHERE payment_id=:id ');
                $update = $update->execute(['balance' => $payments['balance'], 'status' => 3, 'delivery' => 2, 'extra' => $extra, 'id' => $payments['payment_id']]);
                $balance = $conn->prepare('UPDATE clients SET balance=:balance WHERE client_id=:id ');
                $balance = $balance->execute(['id' => $payments['client_id'], 'balance' => $user['balance'] + $payments['payment_amount']]);
                
            }
        
            
        
        }
    
    }
