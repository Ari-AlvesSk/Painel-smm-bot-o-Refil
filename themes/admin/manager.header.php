<html lang="en" <?php if($user['admin_theme'] == 2){ echo 'class="dark"'; } ?> >
    <!-- BEGIN: Head -->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Gerente</title>
        <!-- BEGIN: CSS Assets-->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <!-- END: CSS Assets-->        
    </head>
  
  <style>
    img.rounded-full.shadow-md {
    max-width: 50px;
}
.manager-active {
    padding: 8px;
    background: #21b9bd;
    border-radius: 10px;
    color: white!important;
    margin: 0px 10px;
}
  </style>
    <body class="app">
      
      <nav class="navbar navbar-expand-lg navbar-light bg-light shadow mb-5">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mx-auto">        
       <li class="nav-item border-end">
          <a class="nav-link <?php if( route(2) == 'update' ): echo 'manager-active'; endif; ?>" href="/admin/manager/update">Detalhes</a>
        </li>
        <li class="nav-item border-end">
          <a class="nav-link <?php if( route(2) == 'guard' ): echo 'manager-active'; endif; ?>" href="/admin/manager/guard">Configurações de proteção</a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link <?php if( route(2) == 'info' ): echo 'manager-active'; endif; ?>" href="https://www.smmpainel.store/">Atualizações!</a>
        </li>
      </ul>
    </div>
  </div>
</nav>