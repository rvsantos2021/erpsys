                        <?php echo form_open('/', ['id' => 'formEtapa'], ['id' => "$funil->id"]) ?>
                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                            <legend class="legend"> <i class="fas fa-filter"></i> Funil de Vendas</legend>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label>Descrição</label>
                                    <input type="text" class="form-control input-sm" name="descricao" value="<?php echo $funil->descricao; ?>" disabled />
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                            <legend class="legend"> <i class="fas fa-th-list"></i> Etapas</legend>
                            <div class="form-group row">
                                <div class="col-md-11">
                                    <label>Etapa</label>
                                    <input type="text" class="form-control input-sm" name="etapa" placeholder="Etapa" />
                                </div>
                                <div class="col-md-1 text-right">
                                    <button type="button" class="btn btn-sm btn-default mt-26 btn-add-etapa"><i class="fa fa-arrow-circle-down"></i></button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="tableWrapper" style="min-height: 240px; max-height: 240px; overflow-y: auto;">
                                        <table id="table-etapas" class="table table-sm" style="width: 100%; border-collapse: collapse;">
                                            <thead class="panel-featured panel-featured-custom text-custom">
                                                <tr class="text-custom">
                                                    <th>ETAPA</th>
                                                    <th class="center col-xs-1">AÇÃO</th>
                                                </tr>
                                            </thead>
                                            <tbody id="lista-etapas">
                                                <?php foreach ($etapas as $etapa) : ?>
                                                    <tr>
                                                        <td>
                                                            <input type="hidden" name="etapa_id[]" value="<?php echo $etapa->id; ?>" />
                                                            <input type="hidden" name="etapa_ordem[]" value="<?php echo $etapa->ordem; ?>" />
                                                            <input type="hidden" name="etapa_nome[]" value="<?php echo $etapa->descricao; ?>" />
                                                            <span><?php echo $etapa->descricao; ?></span>
                                                        </td>
                                                        <td class="center">
                                                            <button type="button" data-toggle="tooltip" data-original-title="Excluir" title="Excluir" data-cep="" class="btn btn-xs btn-default btn-width-27 btn-del-etapa"><i class="fas fa-trash-alt text-danger"></i></button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <?php echo form_close(); ?>

                        <script src="<?php echo site_url('assets/'); ?>javascripts/custom/crm/funil_etapas.js"></script>