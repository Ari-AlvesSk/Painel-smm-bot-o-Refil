<!DOCTYPE html>
<html lang='en'>
<head>
<base href='<?=site_url()?>'>
<meta charset='utf-8'>
<meta http-equiv='X-UA-Compatible' content='IE=edge'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<title>Pagamentos</title>

<?php include 'header.php'; ?>
<div class="container-fluid">
            <?php if( $success ): ?>
          <div class="alert alert-success "><?php echo $successText; ?></div>
        <?php endif; ?>
           <?php if( $error ): ?>
          <div class="alert alert-danger "><?php echo $errorText; ?></div>
        <?php endif; ?>
   <ul class="nav nav-tabs">
        <li class="p-b">
         <button class="btn btn-default" data-toggle="modal" data-target="#modalDiv" data-action="payment_new">
         <span class="export-title">Adicionar/Remover Saldo</span>
         </button>
      </li>
      
      <li class="pull-right custom-search">
         <form class="form-inline" action="<?php echo site_url("admin/payments/online") ?>" method="get">
            <div class="input-group">
               <input type="text" name="search" class="form-control" value="<?=$search_word?>" placeholder="Pesquisar por pagamento...">
               <span class="input-group-btn search-select-wrap">
                  <select class="form-control search-select" name="search_type">
                     <option value="username" <?php if( $search_where == "username" ): echo 'selected'; endif; ?> >Usuário</option>
                  </select>
                  <button type="submit" class="btn btn-default"><span class="fa fa-search" aria-hidden="true"></span></button>
               </span>
            </div>
         </form>
      </li>
      <li class="pull-right export-li">
         <a href="/admin/payments/bank" class="export">
         <span class="export-title"><?php if(countRow(["table"=>"payments","where"=>["payment_method"=>7,"payment_status"=>1]])): ?><span class="badge" style="background-color: #f0ad4e"><?=countRow(["table"=>"payments","where"=>["payment_method"=>7,"payment_status"=>1]]);?></span> <?php endif; ?> Notificações de pagamento bancário</span>
         </a>
      </li>
   </ul>
   <table class="table">
      <thead>
         <tr>
            <th class="p-l">ID</th>
            <th>Usuárop</th>
            <th>Saldo Antigo</th>
            <th>Valor</th>
            <th>Forma de pagamento</th>
            <th>Status</th>
            <th>Modo</th>
            <th>Observação</th>
            <th>Data de criação</th>
            <th>Data de emissão</th>
            <th></th>
         </tr>
      </thead>
      <form id="changebulkForm" action="<?php echo site_url("admin/payments/online/multi-action") ?>" method="post">
        <tbody>
          <?php foreach($payments as $payment ): ?>
              <tr>
                 <td class="p-l"><?php echo $payment["payment_id"] ?></td>
                 <td><?php echo $payment["username"] ?></td>
                 <td><?php echo $payment["client_balance"] ?></td>
                 <td><?php echo $payment["payment_amount"] ?></td>
                 <td><?php echo $payment["method_name"] ?></td>
                 <td>Completo</td>
                 <td><?php echo $payment["payment_mode"]; ?></td>
                 <td><?php echo $payment["payment_note"] ?></td>
                 <td nowrap=""><?php echo $payment["payment_create_date"] ?></td>
                 <td nowrap=""><?php echo $payment["payment_update_date"] ?></td>
                 <td class="service-block__action">
                   <div class="dropdown pull-right">
                     <button type="button" class="btn btn-default btn-xs dropdown-toggle btn-xs-caret" data-toggle="dropdown">Transações <span class="caret"></span></button>
                     <ul class="dropdown-menu">
                     <?php if( $payment["payment_mode"] == "Otomatik" ): ?>
                       <li><a href="#"  data-toggle="modal" data-target="#modalDiv" data-action="payment_detail" data-id="<?php echo $payment["payment_id"] ?>">Detalhes do pagamento</a></li>
                     <?php endif; ?>
                       <li><a href="#"  data-toggle="modal" data-target="#modalDiv" data-action="payment_edit" data-id="<?php echo $payment["payment_id"] ?>">Editar</a></li>
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
                  <li class="prev"><a href="<?php echo site_url("admin/payments/online/1".$search_link) ?>">&laquo;</a></li>
                 <li class="prev"><a href="<?php echo site_url("admin/payments/online/".$paginationArr["previous"].$search_link) ?>">&lsaquo;</a></li>
                 <?php
                     endif;
                     for ($page=1; $page<=$pageCount; $page++):
                       if( $page >= ($paginationArr['current']-9) and $page <= ($paginationArr['current']+9) ):
                 ?>
                 <li class="<?php if( $page == $paginationArr["current"] ): echo "active"; endif; ?> "><a href="<?php echo site_url("admin/payments/online/".$page.$search_link) ?>"><?=$page?></a></li>
                 <?php endif; endfor;
                       if( $paginationArr["current"] != $paginationArr["count"] ):
                 ?>
                 <li class="next"><a href="<?php echo site_url("admin/payments/online/".$paginationArr["next"].$search_link) ?>" data-page="1">&rsaquo;</a></li>
                 <li class="next"><a href="<?php echo site_url("admin/payments/online/".$paginationArr["next"].$search_link) ?>" data-page="1">&raquo;</a></li>
                 <?php endif; ?>
              </ul>
           </nav>
        </div>
     </div>
   <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
