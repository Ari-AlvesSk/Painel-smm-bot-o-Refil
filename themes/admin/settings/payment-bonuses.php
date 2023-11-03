<div class="col-md-8">
            <?php if( $success ): ?>
          <div class="alert alert-success "><?php echo $successText; ?></div>
        <?php endif; ?>
           <?php if( $error ): ?>
          <div class="alert alert-danger "><?php echo $errorText; ?></div>
        <?php endif; ?>
  <div class="settings-header__table">
    <button type="button"  class="btn btn-default m-b" data-toggle="modal" data-target="#modalDiv" data-action="new_paymentbonus" >Adicionar novo bônus de pagamento</button>
  </div>
   <table class="table">
      <thead>
         <tr>
           <th>
             ID
           </th>
           <th>
             Pagamento minimo
           </th>
           <th>
             Forma de pagamento
           </th>
           <th>
             Porcentagem de bônus
           </th>
            <th></th>
         </tr>
      </thead>
      <tbody class="methods-sortable">
         <?php foreach($bonusList as $bonus): ?>
           <tr>
            <td>
              <?php echo $bonus["id"]; ?>
            </td>
            <td>
          <?php echo $bonus["bonus_from"]; ?>
            </td>
                <td>
      <?php echo $bonus["method_name"]; ?>
            </td>
            <td>
              %<?php echo $bonus["bonus_amount"]; ?>
            </td>
            <td class="p-r">
               <button type="button" class="btn btn-default btn-xs pull-right edit-payment-method" data-toggle="modal" data-target="#modalDiv" data-action="edit_paymentbonus" data-id="<?php echo $bonus["bonus_id"]; ?>">Editar</button>
            </td>
         </tr>
         <?php endforeach; ?>
      </tbody>
   </table>
</div>
