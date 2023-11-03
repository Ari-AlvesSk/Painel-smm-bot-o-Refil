<?php

require __DIR__.'/lib/autoload.php';
require __DIR__.'/system/abab1214b922f20db86eff2116a12249.php';

$smmapi   = new SMMApi();

$api_details = $conn->prepare("SELECT * FROM service_api");
$api_details->execute(array());
$api_details = $api_details->fetchAll(PDO::FETCH_ASSOC);

if($user["access"]["providers"]){ ?>

<?php if(!$_GET["q"] == 1){ ?>


	<div class="form-group">

			
<table class="table providers_list">
	<thead>
		<tr>
			<th class="p-l" width="45%">Fornecedor</th>
			<th>Saldo</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	


<?php foreach($api_details as $provider): ?>				
				
				<?php
			 $balance = $smmapi->action(array('key' =>$provider["api_key"],'action' =>'balance'),$provider["api_url"]);
$balance1 = $balance->balance;
$balance2 = $balance->currency;
if($balance1 == null){
    $error = 1;
$call = '<i class="fas fa-question-circle"></i>';
}else{        
$error = 0;
$call = $balance1." ".$balance2;
}

?>			
		<tr <?php if($error == 1 ): echo 'class="grey"'; endif; ?> class="list_item ">
			<td class="name p-l"><?php echo $provider["api_name"]; ?> </td>
			<td><?=$call?></td>
			<td class="p-r">
			
				<button type="button" class="btn btn-default btn-xs pull-right" data-toggle="modal" data-target="#modalDiv" data-action="edit_provider" data-id="<?=$provider["id"]?>" >Editar</button>
			</td>

		
									<input type="hidden" name="privder_changes" value="privder_changes" >
					<?php endforeach; ?>  	
									</tbody>
</table>
	  </div>
</div>


<?php }else{ ?>


	<div class="form-group">

			
<table class="table providers_list">
	<thead>
		<tr>
			<th class="p-l" width="45%">Fornecedor</th>
			<th>Saldo</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	


<?php foreach($api_details as $provider): ?>				
				
							
		<tr id="" class="list_item ">
			<td class="name p-l"><?php echo $provider["api_name"]; ?> </td>
			<td>  <i class="fas fa-spinner fa-spin"></i>
</td>
			<td class="p-r">
			
				<button type="button" class="btn btn-default btn-xs pull-right" data-toggle="modal" data-target="#modalDiv" data-action="edit_provider" data-id="<?=$provider["id"]?>" >Editar</button>
			</td>

		
									<input type="hidden" name="privder_changes" value="privder_changes" >
					<?php endforeach; ?>  	
									</tbody>
</table>
	  </div>
</div>


<?php } ?>

<?php  } ?>
