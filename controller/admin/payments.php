<?php

  if( $user["access"]["payments"] != 1  ):
    header("Location:".site_url("admin"));
    exit();
  endif;

  if( !route(2) ):
    $route[2] = "online";
  endif;

  if( $_SESSION["client"]["data"] ):
    $data = $_SESSION["client"]["data"];
    foreach ($data as $key => $value) {
      $$key = $value;
    }
    unset($_SESSION["client"]);
  endif;

    if( route(3) && is_numeric(route(3)) ):
      $page = route(3);
    else:
      $page = 1;
    endif;


    function searchStatu($statu){

      switch ($statu) {
        case 'completed':
          $statu  = 3;
        break;
        case 'pending':
          $statu  = 1;
        break;
        case 'canceled':
          $statu  = 2;
        break;
      }

      return $statu;
    }

    function paymentStatu($statu){

      switch ($statu) {
        case 3:
          $statu  = "approved";
        break;
        case 1:
          $statu  = "waiting";
        break;
        case 2:
          $statu  = "canceled";
        break;
      }

      return $statu;
    }

    if( $_POST ):

      if( route(2) == "edit-bank" ):
        $id       = route(3);
        $payment  = $conn->prepare("SELECT * FROM payments INNER JOIN clients ON clients.client_id=payments.client_id WHERE payment_id=:id ");
        $payment -> execute(array("id"=>$id));
        $payment  = $payment->fetch(PDO::FETCH_ASSOC);
        foreach ($_POST as $key => $value) {
          $$key = $value;
        }
        if( empty($bank) ):
          $error    = 1;
          $errorText= "O banco não pode estar vazio";
          $icon     = "error";
        elseif( empty($status)  && $payment["payment_delivery"] == 1 ):
          $error    = 1;
          $errorText= "O status do pagamento não pode ficar vazio";
          $icon     = "error";
        else:
          if( $status == "3" && $payment["payment_delivery"] == 1  ):
            $conn->beginTransaction();
            $update = $conn->prepare("UPDATE payments SET payment_status=:status, payment_bank=:bank, payment_delivery=:delivery, payment_note=:note, payment_update_date=:date, client_balance=:balance WHERE payment_id=:id ");
            $update = $update->execute(array("id"=>$id,"status"=>3,"delivery"=>2,"bank"=>$bank,"note"=>$note,"date"=>date("Y-m-d H:i:s"),"balance"=>$payment["balance"] ));
            $update2= $conn->prepare("UPDATE clients SET balance=:balance WHERE client_id=:id ");
            $update2= $update2->execute(array("id"=>$payment["client_id"],"balance"=>$payment["payment_amount"]+$payment["balance"] ));
              if( $update2 && $update ):
                $conn->commit();
                $error    = 1;
                $errorText= "Transação bem-sucedida";
                $icon     = "success";
              else:
                $conn->rollBack();
                $error    = 1;
                $errorText= "Operação falhou";
                $icon     = "error";
              endif;
          else:
              if( !$status ): $status = $payment["payment_status"]; endif;
            $update = $conn->prepare("UPDATE payments SET payment_status=:status, payment_bank=:bank, payment_note=:note, payment_update_date=:date WHERE payment_id=:id ");
            $update = $update->execute(array("id"=>$id,"status"=>$status,"bank"=>$bank,"note"=>$note,"date"=>date("Y-m-d H:i:s") ));
            if( $update ):
              $error    = 1;
              $errorText= "Transação bem-sucedida";
              $icon     = "success";
            else:
              $error    = 1;
              $errorText= "Operação falhou";
              $icon     = "error";
            endif;
          endif;
        endif;
        echo json_encode(["t"=>"error","m"=>$errorText,"s"=>$icon,"r"=>$referrer]);
      elseif( route(2) == "new-bank" ):
        foreach ($_POST as $key => $value) {
          $$key = $value;
        }
        if( empty($bank) ):
          $error    = 1;
          $errorText= "O banco não pode estar vazio";
          $icon     = "error";
        elseif( empty($amount) ):
          $error    = 1;
          $errorText= "O valor não pode estar vazio";
          $icon     = "error";
        elseif( !countRow(["table"=>"clients","where"=>["username"=>$username]]) ):
          $error    = 1;
          $errorText= "User not found";
          $icon     = "error";
        else:
          $user  = $conn->prepare("SELECT * FROM clients WHERE username=:username ");
          $user -> execute(array("username"=>$username));
          $user  = $user->fetch(PDO::FETCH_ASSOC);
          $conn->beginTransaction();
          $insert = $conn->prepare("INSERT INTO payments SET payment_status=:status, payment_mode=:mode, payment_amount=:amount, payment_bank=:bank, payment_method=:method, payment_delivery=:delivery, payment_note=:note, payment_update_date=:date, payment_create_date=:date2, client_id=:client_id, client_balance=:balance ");
          $insert = $insert->execute(array("status"=>3,"delivery"=>2,"bank"=>$bank,"mode"=>"Manuel","amount"=>$amount,"method"=>7,"note"=>$note,"date"=>date("Y-m-d H:i:s"),"date2"=>date("Y-m-d H:i:s"),"balance"=>$user["balance"],"client_id"=>$user["client_id"] ));
          $update2= $conn->prepare("UPDATE clients SET balance=:balance WHERE client_id=:id ");
          $update2= $update2->execute(array("id"=>$user["client_id"],"balance"=>$amount+$user["balance"] ));
            if( $update2 && $insert ):
              $conn->commit();
              $error    = 1;
              $errorText= "Transação bem-sucedida";
              $icon     = "success";
              $referrer = site_url("admin/payments/bank");
            else:
              $conn->rollBack();
              $error    = 1;
              $errorText= "Operação falhou";
              $icon     = "error";
            endif;
        endif;
          echo json_encode(["t"=>"error","m"=>$errorText,"s"=>$icon,"r"=>$referrer]);
      elseif( route(2) == "new-online" ):
        foreach ($_POST as $key => $value) {
          $$key = $value;
        }
        if( empty($method) ):
          $error    = 1;
          $errorText= "A forma de pagamento não pode estar vazia";
          $icon     = "error";
        elseif( empty($amount) ):
          $error    = 1;
          $errorText= "O valor não pode estar vazio";
          $icon     = "error";
        elseif($amount < 0):
            $error = 1;
            $errorText = "O valor não pode assumir um valor negativo.";
            $icon = "error";
        elseif(!isset($_POST["add-remove"])):
            $error = 1;
            $errorText = "A configuração de adição ou subtração não pode ficar em branco como você.";
            $icon = "error";
        elseif( !countRow(["table"=>"clients","where"=>["username"=>$username]]) ):
          $error    = 1;
          $errorText= "Usuário não encontrado";
          $icon     = "error";
        else:
          $user  = $conn->prepare("SELECT * FROM clients WHERE username=:username ");
          $user -> execute(array("username"=>$username));
          $user  = $user->fetch(PDO::FETCH_ASSOC);
          $conn->beginTransaction();
          $insert = $conn->prepare("INSERT INTO payments SET payment_status=:status, payment_mode=:mode, payment_amount=:amount, payment_method=:method, payment_delivery=:delivery, payment_note=:note, payment_update_date=:date, payment_create_date=:date2, client_id=:client_id, client_balance=:balance ");
          $newAmount = null;
          switch($_POST["add-remove"]){
              case "add":
                  $newAmount = $amount;
                  break;
                  
              case "remove":
                  $newAmount = -$amount;
                  break;
                  
              default:
                  $newAmount = $amount;
                  break;
          }
          $insert = $insert->execute(array("status"=>3,"delivery"=>2,"mode"=>"Manuel","amount"=>$newAmount,"method"=>$method,"note"=>$note,"date"=>date("Y-m-d H:i:s"),"date2"=>date("Y-m-d H:i:s"),"balance"=>$user["balance"],"client_id"=>$user["client_id"] ));
          $update2= $conn->prepare("UPDATE clients SET balance=:balance WHERE client_id=:id ");
          $update2= $update2->execute(array("id"=>$user["client_id"],"balance"=>$newAmount+$user["balance"] ));
            if( $update2 && $insert ):
              $conn->commit();
              $error    = 1;
              $errorText= "Transação bem-sucedida";
              $icon     = "success";
              $referrer = site_url("admin/payments/online");
            else:
              $conn->rollBack();
              $error    = 1;
              $errorText= "Operação falhou";
              $icon     = "error";
            endif;
        endif;
          echo json_encode(["t"=>"error","m"=>$errorText,"s"=>$icon,"r"=>$referrer]);
      elseif( route(2) == "edit-online" ):
        $id       = route(3);
        $payment  = $conn->prepare("SELECT * FROM payments INNER JOIN clients ON clients.client_id=payments.client_id WHERE payment_id=:id ");
        $payment -> execute(array("id"=>$id));
        $payment  = $payment->fetch(PDO::FETCH_ASSOC);
        foreach ($_POST as $key => $value) {
          $$key = $value;
        }
        if( empty($method) ):
          $error    = 1;
          $errorText= "A forma de pagamento não pode estar vazia";
          $icon     = "error";
        else:
          $conn->beginTransaction();
          $update = $conn->prepare("UPDATE payments SET  payment_method=:method, payment_note=:note, payment_update_date=:date2 WHERE payment_id=:id ");
          $update = $update->execute(array("method"=>$method,"note"=>$note,"date2"=>date("Y-m-d H:i:s"),"id"=>$id ));
            if( $update ):
              $conn->commit();
              $error    = 1;
              $errorText= "Transação bem-sucedida";
              $icon     = "success";
              $referrer = site_url("admin/payments/online");
            else:
              $conn->rollBack();
              $error    = 1;
              $errorText= "Operação falhou";
              $icon     = "error";
            endif;
        endif;
          echo json_encode(["t"=>"error","m"=>$errorText,"s"=>$icon,"r"=>$referrer]);
      endif;

    endif;

    if( route(2)  == "bank" ):
      $statusList = ["all","pending","canceled","completed"];
      if( route(4) && in_array(route(4),$statusList) ):
        $status   = route(4);
      elseif( !route(4) || !in_array(route(4),$statusList) ):
        $status   = "all";
      endif;

      if( $_GET["search_type"] == "username" && $_GET["search"] && countRow(["table"=>"clients","where"=>["username"=>$_GET["search"]]])):
        $search_where = $_GET["search_type"];
        $search_word  = urldecode($_GET["search"]);
        $clients      = $conn->prepare("SELECT client_id FROM clients WHERE username LIKE '%".$search_word."%' ");
        $clients     -> execute(array());
        $clients      = $clients->fetchAll(PDO::FETCH_ASSOC);
        $id=  "("; foreach ($clients as $client) { $id.=$client["client_id"].","; } if( substr($id,-1) == "," ):  $id = substr($id,0,-1); endif; $id.=")";
        $search       = " payments.client_id IN ".$id;
        $count        = $conn->prepare("SELECT * FROM payments INNER JOIN clients ON clients.client_id = payments.client_id WHERE {$search} && payments.payment_method='7' ");
        $count        -> execute(array());
        $count        = $count->rowCount();
        $search       = "WHERE {$search} && payments.payment_method='7' ";
        $search_link  = "?search=".$search_word."&search_type=".$search_where;
      elseif( $status != "all" ):
        $count          = $conn->prepare("SELECT * FROM payments WHERE payment_method=:method && payment_status=:status ");
        $count        ->execute(array("method"=>7,"status"=>searchStatu($status)));
        $count          = $count->rowCount();
        $search         = "WHERE payments.payment_status='".searchStatu($status)."' && payments.payment_method='7' ";
      elseif( $status == "all" ):
        $count          = $conn->prepare("SELECT * FROM payments WHERE payment_method=:method ");
        $count        ->execute(array("method"=>7));
        $count          = $count->rowCount();
        $search         = "WHERE payments.payment_method='7' ";
      endif;
      $to             = 50;
      $pageCount      = ceil($count/$to); if( $page > $pageCount ): $page = 1; endif;
      $where          = ($page*$to)-$to;
      $paginationArr  = ["count"=>$pageCount,"current"=>$page,"next"=>$page+1,"previous"=>$page-1];
      $payments       = $conn->prepare("SELECT * FROM payments INNER JOIN bank_accounts ON bank_accounts.id=payments.payment_bank INNER JOIN clients ON clients.client_id=payments.client_id $search ORDER BY payments.payment_id DESC LIMIT $where,$to ");
      $payments       -> execute(array());
      $payments       = $payments->fetchAll(PDO::FETCH_ASSOC);
      require admin_view('payments_bank');
    elseif( route(2) == "online" ):

      if( $_GET["search_type"] == "username" && $_GET["search"] && countRow(["table"=>"clients","where"=>["username"=>$_GET["search"]]]) ):
        $search_where = $_GET["search_type"];
        $search_word  = urldecode($_GET["search"]);
        $clients      = $conn->prepare("SELECT client_id FROM clients WHERE username LIKE '%".$search_word."%' ");
        $clients     -> execute(array());
        $clients      = $clients->fetchAll(PDO::FETCH_ASSOC);
        $id=  "("; foreach ($clients as $client) { $id.=$client["client_id"].","; } if( substr($id,-1) == "," ):  $id = substr($id,0,-1); endif; $id.=")";
        $search       = " payments.client_id IN ".$id;
        $count        = $conn->prepare("SELECT * FROM payments INNER JOIN clients ON clients.client_id = payments.client_id WHERE {$search} && payments.payment_method!='7' && payments.payment_status='3' ");
        $count        -> execute(array());
        $count        = $count->rowCount();
        $search       = "WHERE {$search} && payments.payment_method!='7' && payments.payment_status='3' ";
        $search_link  = "?search=".$search_word."&search_type=".$search_where;
      else:
        $count          = $conn->prepare("SELECT * FROM payments WHERE payment_method!=:method && payment_status=:status ");
        $count        ->execute(array("method"=>7,"status"=>3));
        $count          = $count->rowCount();
        $search         = "WHERE payments.payment_method!='7' && payments.payment_status='3' ";
      endif;
      $to             = 50;
      $pageCount      = ceil($count/$to); if( $page > $pageCount ): $page = 1; endif;
      $where          = ($page*$to)-$to;
      $paginationArr  = ["count"=>$pageCount,"current"=>$page,"next"=>$page+1,"previous"=>$page-1];
      $payments       = $conn->prepare("SELECT * FROM payments INNER JOIN payment_methods ON payment_methods.id=payments.payment_method INNER JOIN clients ON clients.client_id=payments.client_id $search ORDER BY payments.payment_id DESC LIMIT $where,$to ");
      $payments       -> execute(array());
      $payments       = $payments->fetchAll(PDO::FETCH_ASSOC);
      require admin_view('payments');
    endif;
