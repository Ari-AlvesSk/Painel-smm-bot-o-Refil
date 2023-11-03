<div class="col-md-8">
            <?php if( $success ): ?>
          <div class="alert alert-success "><?php echo $successText; ?></div>
        <?php endif; ?>
           <?php if( $error ): ?>
          <div class="alert alert-danger "><?php echo $errorText; ?></div>
        <?php endif; ?>
  <div class="panel panel-default">
    <div class="panel-body">
        
      <form action="" method="post" enctype="multipart/form-data">

        
<div class="settings-emails__block">
    <div class="settings-emails__block-title">
        Configurações de notificação   </div>
    <div class="settings-emails__block-body">
        <table>
            <thead>
            <tr>
                <th class="settings-emails__th-name"></th>
                <th class="settings-emails__th-actions"></th>
            </tr>
            </thead>
            <tbody>
                            <tr class="settings-emails__row <?php if($settings["alert_apibalance"] == 1){ echo 'grey'; } ?>">
                <td>
                    <div class="settings-emails__row-name">Saldo baixo da API</div>
                    <div class="settings-emails__row-description <?php if($settings["alert_apibalance"] == 1){ echo 'grey'; } ?>">
                    Se seu saldo ficar abaixo do valor definido, você receberá uma notificação.              </div>
                </td>
                <td class="settings-emails__td-actions">
                                                
                          <?php if($settings["alert_apibalance"] == 2): ?>
                  <div class="tt" style="font-size: 1.5em;">  
                       <a href="/admin/settings/alert/off/alert_apibalance">
<span class="tt-icon tt-switch-color" style="color: rgb(0, 102, 255);"><i class="tt-switch-on"></i></span></a>
</div>
                        <?php else: ?>
                         <div class="tt" style="font-size: 1.5em;">  

 <a href="/admin/settings/alert/on/alert_apibalance">

<span class="tt-icon tt-switch-color" style="color: rgb(153, 153, 153);"><i class="tt-switch-off"></i></span>

</a> </div>   
                        <?php endif; ?>
                </td>

            </tr> 
           
         
                            <tr class="settings-emails__row <?php if($settings["alert_newmanuelservice"] == 1){ echo 'grey'; } ?>">
                <td>
                    <div class="settings-emails__row-name">Notificação de novo pedido manual</div>
                    <div class="settings-emails__row-description <?php if($settings["alert_newmanuelservice"] == 1){ echo 'grey'; } ?>">
                       A notificação é enviada se novos pedidos manuais forem recebidos.</div>
                </td>
                <td class="settings-emails__td-actions">
                        
              <?php if($settings["alert_newmanuelservice"] == 2): ?>
                  <div class="tt" style="font-size: 1.5em;">  
                       <a href="/admin/settings/alert/off/alert_newmanuelservice">
<span class="tt-icon tt-switch-color" style="color: rgb(0, 102, 255);"><i class="tt-switch-on"></i></span></a>
</div>
                        <?php else: ?>
                         <div class="tt" style="font-size: 1.5em;">  

 <a href="/admin/settings/alert/on/alert_newmanuelservice">

<span class="tt-icon tt-switch-color" style="color: rgb(153, 153, 153);"><i class="tt-switch-off"></i></span>

</a> </div>   
                        <?php endif; ?>
                </td>
                 
            </tr>
                       
                      
                            <tr class="settings-emails__row <?php if($settings["alert_newpayment"] == 1){ echo 'grey'; } ?>">
                <td>
                    <div class="settings-emails__row-name">Novo Aviso de Pagamento</div>
                    <div class="settings-emails__row-description <?php if($settings["alert_newpayment"] == 1){ echo 'grey'; } ?>">
                       A notificação será enviada se um novo pagamento for recebido.</div>
                </td>
                <td class="settings-emails__td-actions">
                     
                 <?php if($settings["alert_newpayment"] == 2): ?>
                  <div class="tt" style="font-size: 1.5em;">  
                       <a href="/admin/settings/alert/off/alert_newpayment">
<span class="tt-icon tt-switch-color" style="color: rgb(0, 102, 255);"><i class="tt-switch-on"></i></span></a>
</div>
                        <?php else: ?>
                         <div class="tt" style="font-size: 1.5em;">  

 <a href="/admin/settings/alert/on/alert_newpayment">

<span class="tt-icon tt-switch-color" style="color: rgb(153, 153, 153);"><i class="tt-switch-off"></i></span>

</a> </div>   
                        <?php endif; ?>
                </td>
                 
            </tr>
                       
             <tr class="settings-emails__row <?php if($settings["alert_newbankpayment"] == 1){ echo 'grey'; } ?>">
                <td>
                    <div class="settings-emails__row-name">Nova notificação de solicitação de pagamento bancário</div>
                    <div class="settings-emails__row-description <?php if($settings["alert_newbankpayment"] == 1){ echo 'grey'; } ?>">
                        Uma notificação será enviada se uma nova solicitação de pagamento for recebida.</div>
                </td>
                <td class="settings-emails__td-actions">

                 <?php if($settings["alert_newbankpayment"] == 2): ?>
                  <div class="tt" style="font-size: 1.5em;">  
                       <a href="/admin/settings/alert/off/alert_newbankpayment">
<span class="tt-icon tt-switch-color" style="color: rgb(0, 102, 255);"><i class="tt-switch-on"></i></span></a>
</div>
                        <?php else: ?>
                         <div class="tt" style="font-size: 1.5em;">  

 <a href="/admin/settings/alert/on/alert_newbankpayment">

<span class="tt-icon tt-switch-color" style="color: rgb(153, 153, 153);"><i class="tt-switch-off"></i></span>

</a> </div>   
                        <?php endif; ?>
                </td>
                 
            </tr>
                       
             
                            <tr class="settings-emails__row <?php if($settings["alert_failorder"] == 1){ echo 'grey'; } ?> ">
                <td>
                    <div class="settings-emails__row-name">Nova notificação de pedido com falha</div>
                    <div class="settings-emails__row-description <?php if($settings["alert_failorder"] == 1){ echo 'grey'; } ?>">
                       Uma notificação é enviada se um novo pedido com falha (Falha) for recebido.</div>
                </td>
                <td class="settings-emails__td-actions">
                      
             <?php if($settings["alert_failorder"] == 2): ?>
                  <div class="tt" style="font-size: 1.5em;">  
                       <a href="/admin/settings/alert/off/alert_failorder">
<span class="tt-icon tt-switch-color" style="color: rgb(0, 102, 255);"><i class="tt-switch-on"></i></span></a>
</div>
                        <?php else: ?>
                         <div class="tt" style="font-size: 1.5em;">  

 <a href="/admin/settings/alert/on/alert_failorder">

<span class="tt-icon tt-switch-color" style="color: rgb(153, 153, 153);"><i class="tt-switch-off"></i></span>

</a> </div>   
                        <?php endif; ?>
                </td>
                 
            </tr>
                      </div>
                      
                      
                            <tr class="settings-emails__row <?php if($settings["alert_serviceapialert"] == 1){ echo 'grey'; } ?>">
                <td>
                    <div class="settings-emails__row-name">Alterando as informações do provedor</div>
                    <div class="settings-emails__row-description <?php if($settings["alert_serviceapialert"] == 1){ echo 'grey'; } ?>">
                                          Você receberá notificações de todas as atualizações relacionadas aos serviços no provedor de serviços.</div>
                </td>
                <td class="settings-emails__td-actions">
                       

                    <?php if($settings["alert_serviceapialert"] == 2): ?>
                  <div class="tt" style="font-size: 1.5em;">  
                       <a href="/admin/settings/alert/off/alert_serviceapialert">
<span class="tt-icon tt-switch-color" style="color: rgb(0, 102, 255);"><i class="tt-switch-on"></i></span></a>
</div>
                        <?php else: ?>
                         <div class="tt" style="font-size: 1.5em;">  

 <a href="/admin/settings/alert/on/alert_serviceapialert">

<span class="tt-icon tt-switch-color" style="color: rgb(153, 153, 153);"><i class="tt-switch-off"></i></span>

</a> </div>   
                        <?php endif; ?>
                </td>
            </tr>
                        
                            <tr class="settings-emails__row <?php if($settings["alert_newticket"] == 1){ echo 'grey'; } ?>">
                <td>
                    <div class="settings-emails__row-name">Novo aviso de suporte</div>
                    <div class="settings-emails__row-description <?php if($settings["alert_newticket"] == 1){ echo 'grey'; } ?>">
                        Você será notificado quando um novo ticket for criado.                    </div>
                </td>
                <td class="settings-emails__td-actions">
                
                          <?php if($settings["alert_newticket"] == 2): ?>
                  <div class="tt" style="font-size: 1.5em;">  
                       <a href="/admin/settings/alert/off/alert_newticket">
<span class="tt-icon tt-switch-color" style="color: rgb(0, 102, 255);"><i class="tt-switch-on"></i></span></a>
</div>
                        <?php else: ?>
                         <div class="tt" style="font-size: 1.5em;">  

 <a href="/admin/settings/alert/on/alert_newticket">

<span class="tt-icon tt-switch-color" style="color: rgb(153, 153, 153);"><i class="tt-switch-off"></i></span>

</a> </div>   
                        <?php endif; ?>
                </td>
            </tr>
                         
                        </tbody>
        </table>
    </div>
</div>
<div class="settings-emails__block">
            <div class="settings-emails__block-title">Informações autorizadas</div>
        <div class="settings-emails__block-body">
            <table>
                <thead>
                <tr>
                    <th class="settings-emails__th-email-name"></th>
                    <th class="settings-emails__th-email-count"></th>
                    <th class="settings-emails__th-actions"></th>
                </tr>
                </thead>
                <tbody>
                                    <tr class="settings-emails__row">
                        <td>
                            <div class="settings-emails__row-name"><?=$settings["admin_mail"]?></div>
                        </td>
                        <td>
                            <div class="settings-emails__row-emails-count">
<?php

$count = 0;
if($settings["alert_apibalance"] == 2 ){
    $count = $count+1;
}
if($settings["alert_failorder"] == 2 ){
    $count = $count+1;
}
if($settings["alert_newmanuelservice"] == 2 ){
    $count = $count+1;
}
if($settings["alert_serviceapialert"] == 2 ){
    $count = $count+1;
}
if($settings["alert_newbankpayment"] == 2 ){
    $count = $count+1;
}
if($settings["alert_newpayment"] == 2 ){
    $count = $count+1;
}
if($settings["alert_newticket"] == 2 ){
    $count = $count+1;
}


                            echo "$count Active notification"; ?>
                            </div>
                        </td>
                        <td class="settings-emails__td-actions">
                       <a href="javascript:;" onclick="showMe('gizlebeni');" class="btn btn-xs btn-default">
                        Editar                    </a>
                        </td>
                    </tr>
                   
                                </tbody>
            </table>
        </div>

</div>   
<div id="gizlebeni" class="row" style="display: none;">
            
             <div class="form-group col-md-6">
           <label class="control-label">Endereço de e-mail para receber notificação</label>
            <input type="text" class="form-control" name="admin_mail" value="<?=$settings["admin_mail"]?>">
            </div>
            
            <div class="form-group col-md-6">
            <label class="control-label">Número de telefone de notificação</label>
            <input type="text" class="form-control" name="admin_telephone" value="<?=$settings["admin_telephone"]?>">
            </div>
			
             </div>
<hr>
        <div class="row">
          <div class="col-md-12 form-group">
            <label class="control-label">Formulário de notificação</label>
            <select class="form-control" name="alert_type">
              <option value="3" <?= $settings["alert_type"] == 3 ? "selected" : null; ?> >Email ou SMS</option>
              <option value="2" <?= $settings["alert_type"] == 2 ? "selected" : null; ?>>E-Mail</option>
              <option value="1" <?= $settings["alert_type"] == 1 ? "selected" : null; ?>>SMS</option>
            </select>
          </div>   
        <div class="form-group col-md-6">
            <label class="control-label">Renovação de senha por SMS</label>
            <select class="form-control" name="resetsms">
              <option value="2" <?= $settings["resetpass_sms"] == 2 ? "selected" : null; ?> >Ativado</option>
              <option value="1" <?= $settings["resetpass_sms"] == 1 ? "selected" : null; ?>>Desativado</option>
            </select>
          </div>
          <div class="form-group col-md-6">
            <label class="control-label">Renovação de senha por e-mail</label>
            <select class="form-control" name="resetmail">
              <option value="2" <?= $settings["resetpass_email"] == 2 ? "selected" : null; ?> >Ativado</option>
              <option value="1" <?= $settings["resetpass_email"] == 1 ? "selected" : null; ?>>Desativado</option>
            </select>
          </div>   

          <div class="col-md-12 help-block">
         <small>A forma mais saudável de notificação é o SMS.</small>
        </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-3 form-group">
            <label class="control-label">SMS Provider</label>
            <select class="form-control" name="sms_provider">
              <option value="bizimsms" <?= $settings["sms_provider"] == "bizimsms" ? "selected" : null; ?> >Bizimsms</option>
              <option value="netgsm" <?= $settings["sms_provider"] == "netgsm" ? "selected" : null; ?> >NetGSM</option>
            </select>
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Cabeçalho SMS</label>
            <input type="text" class="form-control" name="sms_title" value="<?=$settings["sms_title"]?>">
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Usuário</label>
            <input type="text" class="form-control" name="sms_user" value="<?=$settings["sms_user"]?>">
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Senha do usuário</label>
            <input type="text" class="form-control" name="sms_pass" value="<?=$settings["sms_pass"]?>"> 
          </div>
          <div class="col-md-12 help-block">
         <small><i class="fa fa-warning"></i> <code>Bizim SMS</code> Por favor, escreva sua chave de API na seção de senha.</small><br> <small>Preste atenção aos caracteres turcos ao escrever o título do SMS.</small>
         </div>
        </div>
        <hr>
        <div class="row">
          <div class="form-group col-md-6">
            <label class="control-label">EMail</label>
            <input type="text" class="form-control" name="smtp_user" value="<?=$settings["smtp_user"]?>">
          </div>
          <div class="form-group col-md-6">
            <label class="control-label">Senha do e-mail</label>
            <input type="text" class="form-control" name="smtp_pass" value="<?=$settings["smtp_pass"]?>">
          </div>
          <div class="form-group col-md-6">
            <label class="control-label">Servidor SMTP</label>
            <input type="text" class="form-control" name="smtp_server" value="<?=$settings["smtp_server"]?>">
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Porta SMTP</label>
            <input type="text" class="form-control" name="smtp_port" value="<?=$settings["smtp_port"]?>">
          </div>
          <div class="col-md-3 form-group">
            <label class="control-label">Protocolo SMTP</label>
            <select class="form-control" name="smtp_protocol">
              <option value="0" <?= $settings["smtp_protocol"] == 0 ? "selected" : null; ?> >NÃO</option>
              <option value="tls" <?= $settings["smtp_protocol"] == "tls" ? "selected" : null; ?>>TLS</option>
              <option value="ssl" <?= $settings["smtp_protocol"] == "ssl" ? "selected" : null; ?>>SSL</option>
            </select>
          </div> 
        </div>
   
        <hr>
        <button type="submit" class="btn btn-primary">Atualizar</button>
      </form>

<script type="text/javascript">
// göster/gizle
function showMe(blockId) {
     if ( document.getElementById(blockId).style.display == 'none' ) {
          document.getElementById(blockId).style.display = ''; }
else if ( document.getElementById(blockId).style.display == '' ) {
          document.getElementById(blockId).style.display = 'none'; }
}
</script>