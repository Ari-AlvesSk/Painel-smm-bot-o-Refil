<div class="col-md-8">
            <?php if( $success ): ?>
          <div class="alert alert-success "><?php echo $successText; ?></div>
        <?php endif; ?>
           <?php if( $error ): ?>
          <div class="alert alert-danger "><?php echo $errorText; ?></div>
        <?php endif; ?>
  <div class="settings-header__table">
    <button type="button"  class="btn btn-default m-b" data-toggle="modal" data-target="#modalDiv" data-action="new_provider" >Adicionar novo provedor</button>
  </div>
  
  <script>

document.write('<center id=loading><img src="/img/ajax-loader-2.gif"></center>');
window.onload=function(){
    document.getElementById("loading").style.display="none";
}

</script>
   				
<div class="providers"></div>
   
