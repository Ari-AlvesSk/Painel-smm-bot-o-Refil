<div class="col-md-8">
    <?php if ($success) : ?>
        <div class="alert alert-success "><?php echo $successText; ?></div>
    <?php
    endif; ?>
    <?php if ($error) : ?>
        <div class="alert alert-danger "><?php echo $errorText; ?></div>
    <?php
    endif; ?>
    <div class="panel panel-default">
        <div class="panel-body">

            <form action="" method="post" enctype="multipart/form-data">


                <div class="settings-emails__block">
                    <div class="settings-emails__block-title">
                        Configurações Cron </div>
                    <div class="settings-emails__block-body">
                        <table>
                            <thead>
                                <tr>
                                    <th class="settings-emails__th-name"></th>
                                    <th class="settings-emails__th-actions"></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($cronList as $cronData) { ?>
                                    <tr class="settings-emails__row <?php if ($cronData["cron_status"] != 1) {echo 'grey';} ?>">
                                        <td>
                                            <div class="settings-emails__row-name"><?= $cronData["cron_name"] ?></div>
                                            <div class="settings-emails__row-description <?php if ($cronData["cron_status"] != 1) {echo 'grey';} ?>">
                                                <?= $cronData["cron_operation"] ?></div>
                                        </td>
                                        <td class="settings-emails__td-actions">
                                            <a href="#" data-toggle="modal" data-target="#edit_crons<?= $cronData["cron_id"] ?>" class="btn btn-default btn-xs pull-right edit_crons">Detalhe</a>
                                        </td>
                                    </tr>

                                    <div class="modal fade in" id="edit_crons<?= $cronData["cron_id"] ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">×</button>
                                                    <h4 class="modal-title"><?= $cronData["cron_name"] ?></h4>
                                                </div>
                                                <form class="form" action="/admin/settings/crons/edit/<?= $cronData["cron_id"] ?>" method="post" data-xhr="true">
                                                    <input type="hidden" name="cron_id" value="<?= $cronData["cron_id"] ?>">
                                                    <div class="modal-body" style="padding: 0px;">

                                                        <div class="modal-body">
                                                            <div id="editIntegrationError" class="error-summary alert alert-danger hidden"></div>
                                                            <div class="form edit-integration-modal-body">
                                                                <div class="form-group field-editintegrationform-code">
                                                                    <label class="control-label" for="editintegrationform-code">Intervalo de trabalho do Cron (minuto)</label>
                                                                    <input disabled class="form-control" name="code" rows="7" placeholder="<?= $cronData["cron_updefault"] ?>" value="<?= $cronData["cron_endup"] ?>">
                                                                </div>
                                                                <div class="form-group field-editintegrationform-visibility">
                                                                    <label class="control-label" for="editintegrationform-visibility">Cron Status</label>
                                                                    <select disabled class="form-control" name="visibility">
                                                                        <option value="1" <?php if ($cronData["cron_status"] == 1) {echo 'selected=""';} ?>>Ativado</option>
                                                                        <option value="2" <?php if ($cronData["cron_status"] != 1) {echo 'selected=""';} ?>>Não ativo</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <!--<button type="submit" class="btn btn-primary">
                                                                Güncelle </button>-->
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                                                Fechar </button>
                                                        </div>
                                                </form>
                                            </div>

                                        </div>

                                    </div>
                    </div>
                <?php } ?>

                </tbody>
                </table>
                </div>
        </div>
        <hr>
        <div class="row">
            <div class="form-group col-md-12">
                <label class="control-label">Cron URL:</label>
               <input type="text" class="form-control" disabled value="<?= URL."/OSPKing.php?token=". $keys_key_moto?>">
            </div>
            <div class="col-md-12 help-block">
                <small><i class="fa fa-warning"></i> <code>Cron Key</code> Por favor, escreva sua chave de API na seção de senha.</small> <small>Preste atenção aos caracteres turcos ao escrever o título do SMS.</small>
            </div>
        </div>
    </div>


    
    </form>