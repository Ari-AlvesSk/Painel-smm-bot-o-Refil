<div class="col-md-8">

<?php if($active){ ?>
<!-- Active başlangıç -->
   <div class="settings-emails__block">
      <div class="settings-emails__block-title">
         Ativo 
      </div>
      <div class="settings-emails__block-body">
         <table>
            <thead>
               <tr>
                  <th></th>
                  <th class="settings-emails__th-name"></th>
                  <th class="settings-emails__th-actions"></th>
               </tr>
            </thead>
            <tbody>
            <!-- foreach başlangıç -->
              <?php foreach( $active as $int ){ ?>
               <tr class="settings-emails__row settings-emails__row">
                  <td class="settings-emails__row-img">
                     <img src="<?=$int['icon_url']?>" alt="<?=$int['name']?>">
                  </td>
                  <td>
                     <div class="settings-emails__row-name">
                       <?=$int['name']?> 
                     </div>
                     <div class="settings-emails__row-description">
                       <?=$int['description']?> 
                     </div>
                  </td>
                  <td class="settings-emails__td-actions">
                  <?php if($int["id"] == 13){ ?>
                    <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalDiv" data-action="edit_google">Editar</button>
                 <?php }elseif($int["id"] == 14){ ?>
                    <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalDiv" data-action="edit_seo">Editar</button>
                 <?php }else{ ?>
                 
                  <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalDiv" data-action="edit_code" data-id="<?=$int['id']?>">Editar</button>
                 <?php } ?>
                  </td>
               </tr>
              <?php } ?>
            <!-- foreach bitiş -->
            </tbody>
         </table>
      </div>
    </div>  
<!-- Active bitiş -->
              <?php } ?>

<?php if($other){ ?>
<!-- Pasif başlangıç -->
<div class="settings-emails__block">
      <div class="settings-emails__block-title">
         Outros 
      </div>
      <div class="settings-emails__block-body">
         <table>
            <thead>
               <tr>
                  <th></th>
                  <th class="settings-emails__th-name"></th>
                  <th class="settings-emails__th-actions"></th>
               </tr>
            </thead>
            <tbody>
            <!-- foreach başlangıç -->
              <?php foreach( $other as $int ){ ?>
               <tr class="settings-emails__row settings-emails__row-disable">
                  <td class="settings-emails__row-img">
                     <img src="<?=$int['icon_url']?>" alt="<?=$int['name']?>">
                  </td>
                  <td>
                     <div class="settings-emails__row-name">
                        <?=$int['name']?> 
                     </div>
                     <div class="settings-emails__row-description">
                        <?=$int['description']?>
                     </div>
                  </td>
                  <td class="settings-emails__td-actions">
                     <a class="btn btn-xs btn-default activate-integration" href="/admin/settings/integrations/enabled/<?=$int['id']?>">
                       Ativar
                     </a>
                  </td>
               </tr>
              <?php } ?> 
            <!-- foreach bitiş -->
            </tbody>
         </table>
      </div>
    </div>  
<!-- Pasif bitiş -->
<?php } ?>


   </div>