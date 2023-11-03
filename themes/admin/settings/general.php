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

        <div class="form-group">
          <div class="row">
            <div class="col-md-10">
              <label for="preferenceLogo" class="control-label">Logo</label>
              <input type="file" name="logo" id="preferenceLogo">
                        <p class="help-block">200 x 80px são os tamanhos recomendados</p>
            </div>
            <div class="col-md-2">
              <?php if( $settings["site_logo"] ):  ?>
                <div class="setting-block__image">
                      <img class="img-thumbnail" src="<?=$settings["site_logo"]?>">
                    <div class="setting-block__image-remove">
                      <a href="" data-toggle="modal" data-target="#confirmChange" data-href="<?=site_url("admin/settings/general/delete-logo")?>"><span class="fa fa-remove"></span></a>
                    </div>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-11">
              <label for="preferenceFavicon" class="control-label">Favicon</label>
              <input type="file" name="favicon" id="preferenceFavicon">
                        <p class="help-block">16 x 16px .png são os tamanhos recomendados</p>
            </div>
            <div class="col-md-1">
              <?php if( $settings["favicon"] ):  ?>
                <div class="setting-block__image">
                    <img class="img-thumbnail" src="<?=$settings["favicon"]?>">
                    <div class="setting-block__image-remove">
                      <a href="" data-toggle="modal" data-target="#confirmChange" data-href="<?=site_url("admin/settings/general/delete-favicon")?>"><span class="fa fa-remove"></span></a>
                    </div>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
   <hr>  
   <div class="form-group">
          <label class="control-label">Nome do painel</label>
          <input type="text" class="form-control" name="name" value="<?=$settings["site_name"]?>">
        </div>
        
        <div class="form-group">
                            <label class="control-label" for="createorderform-currency">Moeda</label>
                            <select class="form-control" name="site_currency">
                                                                                            <option value="BRL" <?php if($settings["site_currency"] == "BRL"): echo"selected"; endif; ?>>
                                        Brasil (BRL)
                                    </option>
                                                                 
                                                            </select>
                        </div>
                        
                      
                        
     <div class="form-group">
            <label class="control-label">Fuso horário</label>
            <select class="form-control" name="timezone">
                        <?php
                                foreach($timezones as $timezoneKey => $timezoneVal){
                                    if($settings["site_timezone"] == $timezoneVal["timezone"]){
                                        echo '<option selected value="'.$timezoneVal["timezone"].'">'.$timezoneVal["label"].'</option>';
                                    }else{
                                        echo '<option value="'.$timezoneVal["timezone"].'">'.$timezoneVal["label"].'</option>';
                                    }
                                }
                        
                        ?>
              </select>
          </div>
        <div class="form-group">
          <label class="control-label">Modo de manutenção</label>
          <select class="form-control" name="site_maintenance"> 
            <option value="1" <?= $settings["site_maintenance"] == 1 ? "selected" : null; ?>>Ativado</option>
            <option value="2" <?= $settings["site_maintenance"] == 2 ? "selected" : null; ?> >Desativado</option>
          </select>
        </div>  
        <hr>
        <div class="form-group">
          <label class="control-label">Sistema de suporte</label>
          <select class="form-control" name="ticket_system">
            <option value="2" <?= $settings["ticket_system"] == 2 ? "selected" : null; ?> >Ativado</option>
            <option value="1" <?= $settings["ticket_system"] == 1 ? "selected" : null; ?>>Desativado</option>
          </select>
        </div>
                <?php if( $settings["ticket_system"] == 2): ?>
        <div class="form-group">
          <label class="control-label">Máximo de tickets pendentes por usuário</label>
          <select class="form-control" name="max_ticket">
            <option value="1" <?= $settings["max_ticket"] == 1 ? "selected" : null; ?>>1</option>
<option value="2" <?= $settings["max_ticket"] == 2 ? "selected" : null; ?>>2 (Sugerido)</option>
<option value="3" <?= $settings["max_ticket"] == 3 ? "selected" : null; ?>>3</option>
<option value="4" <?= $settings["max_ticket"] == 4 ? "selected" : null; ?>>4</option>
<option value="5" <?= $settings["max_ticket"] == 5 ? "selected" : null; ?>>5</option>
<option value="6" <?= $settings["max_ticket"] == 6 ? "selected" : null; ?>>6</option>
<option value="7" <?= $settings["max_ticket"] == 7 ? "selected" : null; ?>>7</option>
<option value="8" <?= $settings["max_ticket"] == 8 ? "selected" : null; ?>>8</option>
<option value="9" <?= $settings["max_ticket"] == 9 ? "selected" : null; ?>>9</option>
<option value="99" <?= $settings["max_ticket"] == 99 ? "selected" : null; ?>>Ilimitado</option>
          </select>
        </div> <hr />
    <?php endif; ?>
        
        
              <div class="form-group">
          <label class="control-label">Novo usuário <span class="fa fa-info-circle" data-toggle="tooltip" data-placement="top"></span></label>
          <select class="form-control" name="registration_page">
            <option value="2" <?= $settings["register_page"] == 2 ? "selected" : null; ?>>Ativado</option>
            <option value="1" <?= $settings["register_page"] == 1 ? "selected" : null; ?>>Desativado</option>
          </select>
        </div>
        <div class="form-group">
          <label class="control-label">Número na inscrição <span class="fa fa-info-circle" data-toggle="tooltip" data-placement="top"></span></label>
          <select class="form-control" name="skype_area">
            <option value="2" <?= $settings["skype_area"] == 2 ? "selected" : null; ?>>Ativado</option>
            <option value="1" <?= $settings["skype_area"] == 1 ? "selected" : null; ?>>Desativado</option>
          </select>
        </div>

        <div class="form-group">
          <label class="control-label">Nome na inscrição <span class="fa fa-info-circle" data-toggle="tooltip" data-placement="top"></span></label>
          <select class="form-control" name="name_secret">
            <option value="2" <?= $settings["name_secret"] == 2 ? "selected" : null; ?>>Ativado</option>
            <option value="1" <?= $settings["name_secret"] == 1 ? "selected" : null; ?>>Desativado</option>
          </select>
        </div>
               
        <div class="form-group">
          <label class="control-label">Termos no registro <span class="fa fa-info-circle" data-toggle="tooltip" data-placement="top"></span></label>
          <select class="form-control" name="terms_checkbox">
            <option value="2" <?= $settings["terms_checkbox"] == 2 ? "selected" : null; ?>>Ativado</option>
            <option value="1" <?= $settings["terms_checkbox"] == 1 ? "selected" : null; ?>>Desativado</option>
          </select>
        </div>
        <div class="form-group">
          <label class="control-label">Confirmação em Novo Pedido <span class="fa fa-info-circle" data-toggle="tooltip" data-placement="top"></span></label>
          <select class="form-control" name="neworder_terms">
            <option value="2" <?= $settings["neworder_terms"] == 2 ? "selected" : null; ?>>Ativado</option>
            <option value="1" <?= $settings["neworder_terms"] == 1 ? "selected" : null; ?>>Desativado</option>
          </select>
        </div>
       
        <div class="form-group">
            <label class="control-label">Esqueci a minha senha<span class="fa fa-info-circle" data-toggle="tooltip" data-placement="top"></span></label>
            <select class="form-control" name="resetpass">
              <option value="2" <?= $settings["resetpass_page"] == 2 ? "selected" : null; ?> >Ativado</option>
              <option value="1" <?= $settings["resetpass_page"] == 1 ? "selected" : null; ?>>Desativado</option>
            </select>
        </div> 
        <hr>
      <div class="row">
        <div class="form-group col-md-6">
            <label class="control-label">Lista de serviços <span class="fa fa-info-circle" data-toggle="tooltip" data-placement="top"></span></label>
            <select class="form-control" name="service_list">
              <option value="2" <?php if($settings["service_list"] == 2){ echo "selected"; } ?>>Aberto a todos</option>
              <option value="1" <?php if($settings["service_list"] == 1){ echo "selected"; } ?>>Apenas membros</option>
            </select>
        </div> 
     
         <div class="form-group col-md-6">
            <label class="control-label">Recarga automática <span class="fa fa-info-circle" data-toggle="tooltip" data-placement="top"></span></label>
            <select class="form-control" name="auto_refill">
              <option value="2" <?php if($settings["auto_refill"] == 2){ echo "selected"; } ?>>Ativado</option>
              <option value="1" <?php if($settings["auto_refill"] == 1){ echo "selected"; } ?>>Desativado</option>
            </select> </div> 
        <div class="form-group col-md-6">
            <label class="control-label">Tempos médios de conclusão <span class="fa fa-info-circle" data-toggle="tooltip" data-placement="top"></span></label>
            <select class="form-control" name="avarage">
              <option value="2" <?php if($settings["avarage"] == 2){ echo "selected"; } ?>>Ativado</option>
              <option value="1" <?php if($settings["avarage"] == 1){ echo "selected"; } ?>>Desativado</option>
            </select>
        </div> 
               
            <div class="form-group col-md-6">
            <label class="control-label">Se o serviço cair no provedor <span class="fa fa-info-circle" data-toggle="tooltip" data-placement="top"></span></label>
            <select class="form-control" name="ser_sync">
              <option value="2" <?= $settings["ser_sync"] == 2 ? "selected" : null; ?> >Apenas Alerta</option>
              <option value="1" <?= $settings["ser_sync"] == 1 ? "selected" : null; ?>>Avisar & Desativar o serviço</option>
            </select>
        </div> 
        </div>
<hr>
<div class="row">
<div class="form-group col-md-6">
            <label class="control-label">Verificação por SMS <span class="fa fa-info-circle" data-toggle="tooltip" data-placement="top"></span></label>
            <select class="form-control" name="sms_verify">
              <option value="2" <?= $settings["sms_verify"] == 2 ? "selected" : null; ?> >Ativado</option>
              <option value="1" <?= $settings["sms_verify"] == 1 ? "selected" : null; ?>>Desativado</option>
            </select>
        </div> 
        <div class="form-group col-md-6">
            <label class="control-label">Verificação de e-mail <span class="fa fa-info-circle" data-toggle="tooltip" data-placement="top"></span></label>
            <select class="form-control" name="mail_verify">
              <option value="2" <?php if($settings["mail_verify"] == 2){ echo "selected"; } ?>>Ativado</option>
              <option value="1" <?php if($settings["mail_verify"] == 1){ echo "selected"; } ?>>Desativado</option>
            </select>
        </div> 
    </div>    
        <hr />
        
        <div class="form-group">
          <label class="control-label">Campo de código de cabeçalho (visível em todas as páginas) <span class="fa fa-info-circle" data-toggle="tooltip" data-placement="top"></span></label>
          <textarea class="form-control" rows="7" name="custom_header" placeholder='<style type="text/css">...</style>'><?=$settings["custom_header"]?></textarea>
        </div>
        <div class="form-group">
          <label>Campo de código de rodapé (visível em todas as páginas) <span class="fa fa-info-circle" data-toggle="tooltip" data-placement="top"></span></label>
          <textarea class="form-control" rows="7" name="custom_footer" placeholder='<script>...</script>'><?=$settings["custom_footer"]?></textarea>
        </div>
    <hr>
        <button type="submit" class="btn btn-primary">Atualizar</button>
      </form>
    </div>
  </div>
</div>

<div class="modal modal-center fade" id="confirmChange" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
 <div class="modal-dialog modal-dialog-center" role="document">
   <div class="modal-content">
     <div class="modal-body text-center">
       <h4>Você aprova a transação?</h4>
       <div align="center">
         <a class="btn btn-primary" href="" id="confirmYes">Sim</a>
         <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
       </div>
     </div>
   </div>
 </div>
</div>
