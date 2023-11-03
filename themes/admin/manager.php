<?php if($_SESSION["glycon_manager"] != "logined"): ?>

<!DOCTYPE html>
<html lang="en" <?php if($user['admin_theme'] == 2){ echo 'class="dark"'; } ?>>

    <head>
        <meta charset="utf-8">
        <link href="https://ig/images/favicon.png" rel="shortcut icon">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>GERENTE GERAL</title>
        
      <style>
          .modal-body iframe {
    background: #f7f7f7;
}

.p-5 {
    padding: 3rem;
}

img.intro-y.mx-auto.w-16 {
    text-align: center;
    margin: auto;
    margin-bottom: 3rem;
}

.intro-y.auth {
    text-align: center;
}

.intro-y.auth__title.text-2xl.font-medium.text-center.mt-16 {
    font-size: 30px;
    font-weight: bold;
    color: #000000;
    margin-bottom: 3rem;
    font-family: Nunito;
}

input.intro-y.auth__input.input.input--lg.w-full.border.block {
    display: block;
    padding: .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    -webkit-appearance: none;
    -moz-appearance: none;
    margin: auto;
    min-width: 350px;
    appearance: none;
    margin-bottom: 1rem;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}

button.intro-y.button.button--lg.button--primary.w-full.xl\:mr-3 {
    display: inline-block;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    text-align: center;
    text-decoration: none;
    vertical-align: middle;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
    background-color: transparent;
    border: 1px solid transparent;
    padding: .375rem .75rem;
    font-size: 1rem;
    border-radius: .25rem;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    color: #fff;
    background-color: #3dd5f3;
    border-color: #25cff2;
    min-width: 375px;
    font-weight: b;
}
      </style>
    </head>
    <!-- END: Head -->
    <body>
        <div class="w-full min-h-screen p-5 md:p-20 flex items-center justify-center">
            <div class="intro-y auth">
                <img class="intro-y mx-auto w-16" alt="smmpainel.store" src="https://i.imgur.com/s30nR24.png" width="100" height="100">
                
                <div class="intro-y box px-5 py-8 mt-8">
                    <form method="post" action="/admin/manager/login">
                    <div class="intro-y">
                        <input type="hidden" class="intro-y auth__input input input--lg w-full border block" name="key" placeholder="OwnSMMPanel">
                    </div>
                    <div class="intro-y mt-5 xl:mt-8 text-center xl:text-left">
                        <button class="intro-y button button--lg button--primary w-full xl:mr-3">Ir para o gerente</button>
                    
                    </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- BEGIN: JS Assets-->
        <script src="https://res.cloudinary.com/glycon/raw/upload/v1600016066/app_arjhlo_kuhi2u.js"></script>
        <!-- END: JS Assets-->
    </body>
</html>


<?php  else:

include 'manager.header.php';

if($e_route == "update"){ ?>
    <style>
    .alert-message
{
    margin: 20px 0;
    padding: 20px;
    border-left: 3px solid #eee;
}
.alert-message h4
{
    margin-top: 0;
    margin-bottom: 5px;
}
.alert-message p:last-child
{
    margin-bottom: 0;
}
.alert-message code
{
    background-color: #fff;
    border-radius: 3px;
}
.alert-message-success
{
    background-color: #F4FDF0;
    border-color: #3C763D;
}
.alert-message-success h4
{
    color: #3C763D;
}
.alert-message-danger
{
    background-color: #fdf7f7;
    border-color: #d9534f;
}
.alert-message-danger h4
{
    color: #d9534f;
}
.alert-message-warning
{
    background-color: #fcf8f2;
    border-color: #f0ad4e;
}
.alert-message-warning h4
{
    color: #f0ad4e;
}
.alert-message-info
{
    background-color: #f4f8fa;
    border-color: #5bc0de;
}
.alert-message-info h4
{
    color: #5bc0de;
}
.alert-message-default
{
    background-color: #EEE;
    border-color: #B4B4B4;
}
.alert-message-default h4
{
    color: #000;
}
.alert-message-notice
{
    background-color: #FCFCDD;
    border-color: #BDBD89;
}
.alert-message-notice h4
{
    color: #444;
}
</style>
     <div class="container">
            <div class="w-full md:w-full lg:w-3/4 p-6 mx-auto card shadow border p-5">
                <div class="intro-y text-xl font-medium fs-2">Detalhes do painel</div>
                <div class="settings grid grid-cols-12 gap-6 mt-5  row">
                    <div class="col-md-4">
                        <div class="card shadow border p-2 mb-2" style="border-radius:10px;">
                           Serviço total : <?php echo countRow(["table"=>"services"]); ?><br><br>
                           Categoria Total : <?php echo countRow(["table"=>"categories"]); ?> <br><br>
                           Serviços ativos totais : <?php echo countRow(["table"=>"services","where"=>["service_type"=>2]]); ?> <br><br>
                           Serviços desativados total : <?php echo countRow(["table"=>"services","where"=>["service_type"=>1]]); ?> 
                        </div>
                </div>
          <div class="col-md-4">
                        <div class="card shadow border p-2 mb-2" style="border-radius:10px;">
                           Total de membros : <?php echo countRow(["table"=>"clients"]); ?><br><br>
                           Membros enviados : <?=$count9?> <br><br>
                           Membros este mês : <?=$count?> <br><br>
                           Membros de hoje : <?=$count2?> 
                        </div>
                </div>
          <div class="col-md-4">
                        <div class="card shadow border p-2 mb-2" style="border-radius:10px;">
                           Pagamentos totais : <?php echo round($query['SUM(payment_amount)']); ?><br><br>
                           Total gasto : <?php echo round($query2['order_charge']); ?> <br><br>
                           Ganhos de hoje : <?=$kazanc2['SUM(payment_amount)'];?> <br><br>
                           Ganhos deste mês : <?=$kazanc['SUM(payment_amount)'];?> 
                        </div>
                </div>
          <div class="col-md-4">
                        <div class="card shadow border p-2 mb-2" style="border-radius:10px;">
                           Total de pedidos : <?php echo countRow(["table"=>"orders"]); ?><br><br>
                           Pedido com API : <?php echo countRow(["table"=>"orders","where"=>["order_where"=>"api"]]); ?><br><br>
                          Pedido deste mês : <?=$count3?> <br><br>
                           Pedidos de hoje : <?=$count4?> 
                        </div>
                </div>
          <div class="col-md-4">
                        <div class="card shadow border p-2 mb-2" style="border-radius:10px;">
                           Total de solicitações de suporte : <?php echo countRow(["table"=>"tickets"]); ?> <br><br>
                           Total resolvido : <?php echo countRow(["table"=>"tickets","where"=>["status"=>"closed"]]); ?>  <br><br>
                           Solicitações de suporte hoje : <?=$count6?> <br><br>
                           Solicitações de suporte deste mês : <?=$count5?> 

                        </div>
                </div>
               <div class="col-md-4">
                        <div class="card shadow border p-2 mb-2" style="border-radius:10px;">
                           Total de interações : <?php echo countRow(["table"=>"client_report"]); ?> <br><br>
                           Interação de hoje : <?=$count8?> <br><br>
                           Interação deste mês : <?=$count7?> <br><br>
                           
                        </div>
                </div>
                  
            </div>
        </div>
                </div>
                

                
            </div>
        </div>
       

<?php }elseif($e_route == "guard"){ ?>
<style>
    .alert-message
{
    margin: 20px 0;
    padding: 20px;
    border-left: 3px solid #eee;
}
.alert-message h4
{
    margin-top: 0;
    margin-bottom: 5px;
}
.alert-message p:last-child
{
    margin-bottom: 0;
}
.alert-message code
{
    background-color: #fff;
    border-radius: 3px;
}
.alert-message-success
{
    background-color: #F4FDF0;
    border-color: #3C763D;
}
.alert-message-success h4
{
    color: #3C763D;
}
.alert-message-danger
{
    background-color: #fdf7f7;
    border-color: #d9534f;
}
.alert-message-danger h4
{
    color: #d9534f;
}
.alert-message-warning
{
    background-color: #fcf8f2;
    border-color: #f0ad4e;
}
.alert-message-warning h4
{
    color: #f0ad4e;
}
.alert-message-info
{
    background-color: #f4f8fa;
    border-color: #5bc0de;
}
.alert-message-info h4
{
    color: #5bc0de;
}
.alert-message-default
{
    background-color: #EEE;
    border-color: #B4B4B4;
}
.alert-message-default h4
{
    color: #000;
}
.alert-message-notice
{
    background-color: #FCFCDD;
    border-color: #BDBD89;
}
.alert-message-notice h4
{
    color: #444;
}
</style>

       <div class="container">
            <div class="w-full md:w-full lg:w-3/4 p-5 mx-auto card shadow border">
                <div class="intro-y text-xl font-medium fs-2">Configurações de proteção</div>
                <div class="settings grid grid-cols-12 gap-6 mt-5">
                    <div class="intro-y col-span-12">
                                   <?php if( $success ): ?>
 <div class="alert-message alert-message-success">
                <h4>Transação bem-sucedida!</h4>
             
            </div>        <?php endif; ?>
           <?php if( $error ): ?>
          <div class="alert alert-danger "><?php echo $errorText; ?></div>
        <?php endif; ?>
                        <div class="intro-y box">
                            <form method="post" action="/admin/manager/guard">
             <div class="m*j*r">

              <label>Sistema de guarda</label>
              <select class="form-select" name="guard_system_status">
                <option value="2" <?php if( $settings["guard_system_status"] == 2 ): echo "selected"; endif; ?>>Ativado</option>
                <option value="1"  <?php if( $settings["guard_system_status"] == 1 ): echo "selected"; endif; ?>>Desativado</option>
              </select>
            </div>
            
        <hr>
        <div class="mt-3">

              <label>Proteção de apagamento de serviço</label>
              <select class="form-select" name="guard_services_status">
                <option value="2"  <?php if( $settings["guard_services_status"] == 2 ): echo "selected"; endif; ?>>Ativado</option>
                <option value="1"  <?php if( $settings["guard_services_status"] == 1 ): echo "selected"; endif; ?>>Desativado</option>
              </select>
            </div>
        <div class="mt-3">

              <label>Se o serviço excluir</label>
              <select class="form-select" name="guard_services_type">
                <option value="2"  <?php if( $settings["guard_services_type"] == 2 ): echo "selected"; endif; ?>>Obtenha todos os seus poderes</option>
                <option value="1"  <?php if( $settings["guard_services_type"] == 1 ): echo "selected"; endif; ?>>Encerrar sua sessão</option>
              </select>
            </div>
<hr>
       <div class="mt-3">

              <label>Proteção de notificação em massa</label>
              <select class="form-select" name="guard_notify_status">
                <option value="2"  <?php if( $settings["guard_notify_status"] == 2 ): echo "selected"; endif; ?>>Ativado</option>
                <option value="1"  <?php if( $settings["guard_notify_status"] == 1 ): echo "selected"; endif; ?>>Desativado</option>
              </select>
            </div>
        <div class="mt-3">

              <label>Se a notificação em massa for enviada</label>
              <select class="form-select" name="guard_notify_type">
                <option value="2"  <?php if( $settings["guard_notify_type"] == 2 ): echo "selected"; endif; ?>>Obtenha todos os seus poderes</option>
                <option value="1"  <?php if( $settings["guard_notify_type"] == 1 ): echo "selected"; endif; ?>>Encerrar sua sessão</option>
              </select>
            </div>
<hr>
       <div class="mt-3">

              <label>Proteção de Autoridade</label>
              <select class="form-select" name="guard_roles_status">
                <option value="2"  <?php if( $settings["guard_roles_status"] == 2 ): echo "selected"; endif; ?>>Ativado</option>
                <option value="1"  <?php if( $settings["guard_roles_status"] == 1 ): echo "selected"; endif; ?>>Desativado</option>
              </select>
            </div>
        <div class="mt-3">

              <label>Se a autorização for emitida</label>
              <select class="form-select" name="guard_roles_type">
                <option value="2"  <?php if( $settings["guard_roles_type"] == 2 ): echo "selected"; endif; ?>>Obtenha todos os seus poderes</option>
                <option value="1"  <?php if( $settings["guard_roles_type"] == 1 ): echo "selected"; endif; ?>>Encerrar sua sessão</option>
              </select>
            </div>
<hr>
       <div class="mt-3">

              <label>Exibição de chave de API <small>(É criptografado de 6 maneiras diferentes e é impossível decifrar.)</small></label>
              <select class="form-select" name="guard_apikey_type">
                <option value="2"  <?php if( $settings["guard_apikey_type"] == 2 ): echo "selected"; endif; ?>>Mostrar como criptografado</option>
                <option value="1"  <?php if( $settings["guard_apikey_type"] == 1 ): echo "selected"; endif; ?>>Mostrar diretamente</option>
              </select>
            </div>
</div>
                            <button type="submit" class="btn btn-success mt-3">Atualizar Configurações</button>
                            </form>
                        </div>
                </div>
        </div>

<?php }elseif($e_route == "info"){ ?>
    
           
<?php }elseif($e_route == "details"){ ?>      

          
        

<?php } ?>

<?php include 'manager.footer.php'; endif; ?>