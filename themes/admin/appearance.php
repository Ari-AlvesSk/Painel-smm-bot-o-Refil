<!DOCTYPE html>
<html lang='en'>
<head>
<base href='<?=site_url()?>'>
<meta charset='utf-8'>
<meta http-equiv='X-UA-Compatible' content='IE=edge'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<title>Aparencia</title>

<?php include 'header.php'; ?>


<div class="container">
  <div class="row">
    <?php if( ( route(2) == "language" && !route(3) ) || ( route(2) != "themes" ) && route(2) != "language"  ):  ?>
          <div class="col-md-2 col-md-offset-1">
            <ul class="nav nav-pills nav-stacked p-b">
              <?php foreach($menuList as $menuName => $menuLink ): ?>
                <li class="settings_menus <?php if( $route["2"] == $menuLink ): echo "active"; endif; ?>"><a href="<?=site_url("admin/appearance/".$menuLink)?>"><?=$menuName?></a></li>
              <?php endforeach; ?>
            </ul>
          </div>
    <?php  endif;
          if( $access ):
            include admin_view('appearance/'.route(2));
          else:
            include admin_view('appearance/access');
          endif;
    ?>


  </div>
</div>


<?php include 'footer.php'; ?>
