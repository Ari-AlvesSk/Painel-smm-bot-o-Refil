<?php include 'header.php'; ?>

<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
              <?php if( $success ): ?>
          <div class="alert alert-success "><?php echo $successText; ?></div>
        <?php endif; ?>
           <?php if( $error ): ?>
          <div class="alert alert-danger "><?php echo $errorText; ?></div>
        <?php endif; ?>
      <div class="panel panel-default">
          <div class="panel-body">
        <form method="post" action="/admin/account">

          <div class="form-group">
            <label for="charge" class="control-label">Senha atual</label>
            <input type="password" class="form-control" value="" name="current_password">
          </div>

          <div class="form-group">
            <label for="charge" class="control-label">Nova Senha</label>
            <input type="password" class="form-control" value="" name="password">
          </div>

          <div class="form-group">
            <label for="charge" class="control-label">Nova senha (novamente)</label>
            <input type="password" class="form-control" value="" name="confirm_password">
          </div>
          <button type="submit" class="btn btn-primary">Alterar</button>
        </form>
      </div>
</div>

    </div>
  </div>
</div>
   

<?php include 'footer.php'; ?>
