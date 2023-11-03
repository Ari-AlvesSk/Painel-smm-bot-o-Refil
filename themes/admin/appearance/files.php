
    <div class="col-md-8">
<div class="p-b">                
<div class="pull-left">
                  <form action="/admin/appearance/files" method="POST" enctype="multipart/form-data">

       <input type="file" name="logo" accept="image/*"> 

                   
                    </div>
                                    <div class="pull-right">
                                        
                                        <button style="margin-bottom: 12px;" type="submit" class="btn btn-default">Subir arquivo</button>
</div>  </form>   
            </div>

                        <div id="filesContainer">
                <table class="table files__table">
    <thead>
    <tr>
        <th class="p-l" colspan="2">Arquivo</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
<?php foreach( $fileList as $file ){ ?>

    <tr>
        <td>
            <div class="files__table-preview">
                <img src="<?=$file['link']?>" onerror="this.style.display='none'">
            </div
        </td>
        <td class="p-l">
            <a href="<?=$file['link']?>" target="_blank">
                <?php
                $m2 = str_ireplace(site_url(),"",$file["link"]);
                echo $m2;

                ?>
                        </a>
        </td>
        <td class="p-r text-right">
            <a class="btn btn-default btn-xs delete-file " href="/admin/appearance/files/delete/<?=$file['id']?>">Deletar</a>        </td>
    </tr>
<?php } ?>
    </tbody>
</table>

<nav>
    </nav>            </div>
        </div>
    </div>
</div>