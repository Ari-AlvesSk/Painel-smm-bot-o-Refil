<!DOCTYPE html>
<html lang='en'>
<head>
<base href='<?=site_url()?>'>
<meta charset='utf-8'>
<meta http-equiv='X-UA-Compatible' content='IE=edge'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<title>Tarefas</title>

<?php include 'header.php'; ?>
<div class="container-fluid">
        <?php if( $success ): ?>
          <div class="alert alert-success "><?php echo $successText; ?></div>
        <?php endif; ?>
           <?php if( $error ): ?>
          <div class="alert alert-danger "><?php echo $errorText; ?></div>
        <?php endif; ?>
    
  <ul class="nav nav-tabs p-b">      
      <li class="pull-right custom-search">
         <form class="form-inline" action="<?=site_url("admin/tasks")?>" method="get">
            <div class="input-group">
               <input type="text" name="search" class="form-control" value="<?=$search_word?>" placeholder="Pesquisar tarefa...">
               <span class="input-group-btn search-select-wrap">
                  <select class="form-control search-select" name="search_type">
                     <option value="order_id" <?php if( $search_where == "order_id" ): echo 'selected'; endif; ?> >ID Pedido</option>
                  </select>
                  <button type="submit" class="btn btn-default"><span class="fa fa-search" aria-hidden="true"></span></button>
               </span>
            </div>
         </form>
      </li>
   </ul>
   <table class="table">
      <thead>
         <tr>
         <th>ID da tarefa</th>
          <th>ID do Pedido</th>
          <th>Usuário</th>
          <th>Serviço</th>
          <th>Link</th>
          <th>Começou</th>
          <th>Quantidade</th>
          <th>Solicitar</th>
          <th>Status da tarefa</th>
          <th>Data da tarefa</th>
          <th class="dropdown-th"></th>
         </tr>
      </thead>
      <form id="changebulkForm" action="<?php echo site_url("admin/tasks/multi-action") ?>" method="post">
        <tbody>
          <?php foreach( $orders as $order ): ?>
              <tr>
                 <td class="p-l"><?=$order["task_id"]?>
                 <div class="service-block__provider-value"><?php if($order["refill_orderid"]){ echo $order["refill_orderid"]; } ?></div></td>
                 <td><?php echo $order["order_id"] ?>
                 <div class="service-block__provider-value"><?php if($order["api_orderid"]){ echo $order["api_orderid"]; } ?></div></td>
                 <td><?php echo $user["username"]; ?></td>
                 <td><?php echo $order["service_name"]; ?></td>
                 <td><?php echo $order["order_url"]; ?></td>
                 <td><?php echo $order["order_start"]; ?></td>
                 <td><?php echo $order["order_quantity"]; ?></td>
                 <td><?php if($order["task_type"] == 1): echo "Cancelamento"; elseif($order["task_type"] == 2): echo "Reposição";endif; ?></td>
                 <td><?php if($order["task_status"] == "pending"): echo "Aguardando aprovação"; elseif($order["task_status"] == "success"): echo "Aprovado"; elseif($order["task_status"] == "canceled"): echo "Negado"; endif; ?></td>
                 <td><?php echo $order["task_date"] ?></td>

                 <td class="service-block__action">
                     <div class="dropdown pull-right">
                     <button type="button" class="btn btn-default btn-xs dropdown-toggle btn-xs-caret" data-toggle="dropdown" <?php if( $order["task_status"] !== "pending" ):  echo "disabled"; endif; ?>>Transações <span class="caret"></span></button>
                       <ul class="dropdown-menu">
                           <li><a href="<?=site_url("admin/tasks/no/".$order["task_id"])?>">Rejeitar</a></li>
                           <?php if($order["task_type"] == 2 ){ ?>
                           <li><a href="<?=site_url("admin/tasks/success/".$order["task_id"])?>">Aprovar</a></li>
                           <?php }elseif($order["task_type"] == 1){ ?>
                           <li><a href="#" data-toggle="modal" data-target="#confirmChange" data-href="<?=site_url("admin/tasks/canceled/".$order["order_id"])?>">Cancelar e reembolsar</a></li>
                           <?php } ?>
                       </ul>
                     </div>               
                 </td>
              </tr>
            <?php endforeach; ?>
        </tbody>
        <input type="hidden" name="bulkStatus" id="bulkStatus" value="0">
      </form>
   </table>
   <?php if( $paginationArr["count"] > 1 ): ?>
     <div class="row">
        <div class="col-sm-8">
           <nav>
              <ul class="pagination">
                <?php if( $paginationArr["current"] != 1 ): ?>
                 <li class="prev"><a href="<?php echo site_url("admin/tasks/1/".$status.$search_link) ?>">&laquo;</a></li>
                 <li class="prev"><a href="<?php echo site_url("admin/tasks/".$paginationArr["previous"]."/".$status.$search_link) ?>">&lsaquo;</a></li>
                 <?php
                     endif;
                     for ($page=1; $page<=$pageCount; $page++):
                       if( $page >= ($paginationArr['current']-9) and $page <= ($paginationArr['current']+9) ):
                 ?>
                 <li class="<?php if( $page == $paginationArr["current"] ): echo "active"; endif; ?> "><a href="<?php echo site_url("admin/tasks/".$page."/".$status.$search_link) ?>"><?=$page?></a></li>
                 <?php endif; endfor;
                       if( $paginationArr["current"] != $paginationArr["count"] ):
                 ?>
                 <li class="next"><a href="<?php echo site_url("admin/tasks/".$paginationArr["next"]."/".$status.$search_link) ?>" data-page="1">&rsaquo;</a></li>
                 <li class="next"><a href="<?php echo site_url("admin/tasks/".$paginationArr["count"]."/".$status.$search_link) ?>" data-page="1">&raquo;</a></li>
                 <?php endif; ?>
              </ul>
           </nav>
        </div>
     </div>
   <?php endif; ?>
</div>
<div class="modal modal-center fade" id="confirmChange" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
   <div class="modal-dialog modal-dialog-center" role="document">
      <div class="modal-content">
         <div class="modal-body text-center">
            <h4>Confirmação de cancelamento</h4>
            <h5>Se você cancelar o pedido, o pedido será cancelado e a taxa do pedido será reembolsada ao seu cliente.</h5>
            <div align="center">
               <a class="btn btn-primary" href="" id="confirmYes">Sim</a>
               <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
            </div>
         </div>
      </div>
   </div>
</div>

<?php include 'footer.php'; ?>
