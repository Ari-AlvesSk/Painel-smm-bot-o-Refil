<!DOCTYPE html>
<html lang='en'>
<head>
<base href='<?=site_url()?>'>
<meta charset='utf-8'>
<meta http-equiv='X-UA-Compatible' content='IE=edge'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<title>Relatorios</title>

<?php include 'header.php'; ?>
<div class="container-fluid">
   <ul class="nav nav-tabs p-b">
        <li class="<?php if( $action == "profit" ): echo "active"; endif; ?>"><a href="<?php echo site_url("admin/reports") ?>">Ganhos de pedidos</a></li>
        <li class="<?php if( $action == "payments" ): echo "active"; endif; ?>"><a href="<?php echo site_url("admin/reports/payments") ?>">Ganhos de pagamentos</a></li>
        <li class="<?php if( $action == "orders" ): echo "active"; endif; ?>"><a href="<?php echo site_url("admin/reports/orders") ?>">Ganhos de pedidos</a></li>
  


     <form class="" action="<?php echo site_url("admin/reports/".$action."?year=".$year) ?>" method="post">

<li class="pull-right">
              <div class="btn-group" role="group">
            <?php foreach($yearList as $yearl): ?>
              <a href="<?php echo site_url("admin/reports/".$action."?year=".$yearl) ?>" class="btn btn-default <?php if( $yearl == $year ): echo "active"; endif; ?> ">
                  <?php echo $yearl; ?>
              </a>
            <?php endforeach; ?>
          </div>
       </li>

       <?php if( $action == "payments" ): ?>
<li class="pull-right">
           <select class="selectpicker" data-actions-box="true" data-live-search="true" name="methods[]" multiple="" data-max-options="100" data-size="10" title="Métodos de Pagamento" tabindex="-98">
             <?php foreach($methods as $method ): ?>
                <option value="<?php echo $method["id"]; ?>" <?php if( $_POST ): if( in_array($method["id"],$_POST["methods"]) ): echo 'selected'; endif; else: echo 'selected'; endif; ?>> <?php echo $method["method_name"] ?> </option>
              <?php endforeach; ?>
          </select>
</li>
       <?php endif; ?>

       <?php if( $action == "profit" || $action == "orders" ): ?>
<li class="pull-right">
           <select class="selectpicker" data-actions-box="true" data-live-search="true" name="services[]" multiple="" data-max-options="100" data-size="10" title="Servidor" tabindex="-98">
             <?php $c=0;foreach($serviceList as $category => $services ): $c++; ?>
                <optgroup label="<?=$category?>">
                  <?php if( !empty($services[0]["service_id"]) ): ?>
                    <?php for($i=0;$i<count($services);$i++): ?>
                      <option value="<?php echo $services[$i]["service_id"]; ?>" <?php if( $_POST ): if( in_array($services[$i]["service_id"],$_POST["services"]) ): echo 'selected'; endif; else: echo 'selected'; endif; ?>> <?php echo $services[$i]["service_id"]." - ".$services[$i]["service_name"] ?> </option>
                    <?php endfor; ?>
                  <?php endif; ?>
                </optgroup>
              <?php endforeach; ?>
          </select>
</li>
         <li class="pull-right">
           <select class="selectpicker" name="statuses[]" multiple="" data-max-options="100" data-size="10" title="Status do pedido" tabindex="-98">
             <option value="cron" <?php if( $_POST ): if( in_array("cron",$_POST["statuses"]) ): echo 'selected'; endif; else: echo 'selected'; endif; ?>>Aguardando cron</option>
             <option value="fail"  <?php if( $_POST ): if( in_array("fail",$_POST["statuses"]) ): echo 'selected'; endif; else: echo 'selected'; endif; ?>>Falhou</option>
             <option value="pending"  <?php if( $_POST ): if( in_array("pending",$_POST["statuses"]) ): echo 'selected'; endif; else: echo 'selected'; endif; ?>>Pendente</option>
             <option value="inprogress"  <?php if( $_POST ): if( in_array("inprogress",$_POST["statuses"]) ): echo 'selected'; endif; else: echo 'selected'; endif; ?>>Em andamento</option>
             <option value="completed"  <?php if( $_POST ): if( in_array("completed",$_POST["statuses"]) ): echo 'selected'; endif; else: echo 'selected'; endif; ?>>Concluído</option>
             <option value="partial"  <?php if( $_POST ): if( in_array("partial",$_POST["statuses"]) ): echo 'selected'; endif; else: echo 'selected'; endif; ?>>Parcial</option>
             <option value="canceled"  <?php if( $_POST ): if( in_array("canceled",$_POST["statuses"]) ): echo 'selected'; endif; else: echo 'selected'; endif; ?>>Cancelado</option>
             <option value="processing"  <?php if( $_POST ): if( in_array("processing",$_POST["statuses"]) ): echo 'selected'; endif; else: echo 'selected'; endif; ?>>Em processamento</option>
           </select>
         </li>

       <?php endif; ?>

      <li class="pull-right">
            <button type="submit" class="btn btn-primary">
              Atualizar
            </button>
        </li>
     </ul>
     </form>

   <div class="row">
      <div class="col-md-12">
         <table class="table report-table" style="border:1px solid #ddd">
            <thead>
               <tr>
                  <th>
                  </th>
                  <th align="right" style="text-align:center;">Janeiro</th>
                  <th align="right" style="text-align:center;">Fevereiro</th>
                  <th align="right" style="text-align:center;">Março</th>
                  <th align="right" style="text-align:center;">Abril</th>
                  <th align="right" style="text-align:center;">Maio</th>
                  <th align="right" style="text-align:center;">Junho</th>
                  <th align="right" style="text-align:center;">Julho</th>
                  <th align="right" style="text-align:center;">Agosto</th>
                  <th align="right" style="text-align:center;">Setembro</th>
                  <th align="right" style="text-align:center;">Outubro</th>
                  <th align="right" style="text-align:center;">Novembro</th>
                  <th align="right" style="text-align:center;">Dezembro</th>
               </tr>
            </thead>
            <tbody>
              <?php if( $action == "profit" ): ?>
                <?php for ($day=1; $day <=31; $day++): ?>
                 <tr>
                    <td align="center"><?=$day?></td>
                    <?php for( $month=1; $month<=12; $month++ ): ?>
                      <td align="center">
                         <?php echo dayCharge($day,$month,$year,["services"=>$_POST["services"],"status"=>$_POST["statuses"]]); ?>
                      </td>
                    <?php endfor; ?>
                 </tr>
               <?php endfor; ?>
               <tr>
                 <td align="center"><b>Lucro bruto: </b></td>
                 <?php for( $month=1; $month<=12; $month++ ): ?>
                   <td align="center">
                     <b>  <?php echo monthCharge($month,$year,["services"=>$_POST["services"],"status"=>$_POST["statuses"]]); ?> </b>
                   </td>
                 <?php endfor; ?>
               </tr>
               <tr>
                 <td align="center"><b>Lucro líquido: </b></td>
                 <?php for( $month=1; $month<=12; $month++ ): ?>
                   <td align="center">
                     <b>  <?php echo monthChargeNet($month,$year,["services"=>$_POST["services"],"status"=>$_POST["statuses"]]); ?> </b>
                   </td>
                 <?php endfor; ?>
               </tr>
              <?php elseif( $action == "payments" ): ?>
               <?php for ($day=1; $day <=31; $day++): ?>
                <tr>
                   <td align="center"><?=$day?></td>
                   <?php for( $month=1; $month<=12; $month++ ): ?>
                     <td align="center">
                        <?php echo dayPayments($day,$month,$year,["methods"=>$_POST["methods"]]); ?>
                     </td>
                   <?php endfor; ?>
                </tr>
                <?php endfor; ?>
                <tr>
                  <td align="center"><b>Total: </b></td>
                  <?php for( $month=1; $month<=12; $month++ ): ?>
                    <td align="center">
                      <b>  <?php echo monthPayments($month,$year,["methods"=>$_POST["methods"]]); ?> </b>
                    </td>
                  <?php endfor; ?>
                </tr>
              <?php elseif( $action == "orders" ): ?>
               <?php for ($day=1; $day <=31; $day++): ?>
                <tr>
                   <td align="center"><?=$day?></td>
                   <?php for( $month=1; $month<=12; $month++ ): ?>
                     <td align="center">
                        <?php echo dayOrders($day,$month,$year,["services"=>$_POST["services"],"status"=>$_POST["statuses"]]); ?>
                     </td>
                   <?php endfor; ?>
                </tr>
                <?php endfor; ?>
                <tr>
                  <td align="center"><b>Total: </b></td>
                  <?php for( $month=1; $month<=12; $month++ ): ?>
                    <td align="center">
                      <b>  <?php echo monthOrders($month,$year,["services"=>$_POST["services"],"status"=>$_POST["statuses"]]); ?> </b>
                    </td>
                  <?php endfor; ?>
                </tr>
              <?php endif; ?>
            </tbody>
         </table>
      </div>
   </div>
</div>
<?php include 'footer.php'; ?>
