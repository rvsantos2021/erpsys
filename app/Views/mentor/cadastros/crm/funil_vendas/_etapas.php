                        <?php echo form_open('/', ['id' => 'formEtapa'], ['id' => "$table->id"]); ?>
                        <fieldset class="border pb-4 pr-4 pl-4 rounded">
                            <legend class="legend"> <i class="fa fa-bookmark"></i> Funil de Vendas</legend>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label>Descrição</label>
                                    <input type="text" class="form-control input-sm" name="descricao" value="<?php echo $table->descricao; ?>" disabled />
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="border pb-4 pr-4 pl-4 rounded">
                            <legend class="legend"> <i class="ti ti-menu-alt"></i> Etapas</legend>
                            <div class="form-row">
                                <div class="form-group col-md-11">
                                    <label>Etapa</label>
                                    <input type="text" class="form-control input-sm" name="etapa" placeholder="Etapa" />
                                </div>
                                <div class="form-group col-md-1 text-right">
                                    <button type="button" class="btn btn-sm btn-default mt-26 btn-add-etapa"><i class="ti ti-arrow-down"></i></button>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <div id="tableWrapper" style="min-height: 240px; max-height: 240px; overflow-y: auto;">
                                        <table id="table-etapas" class="table table-sm" style="width: 100%; border-collapse: collapse;">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>ETAPA</th>
                                                    <th class="center col-xs-1">AÇÃO</th>
                                                </tr>
                                            </thead>
                                            <tbody id="lista-etapas">
                                                <?php foreach ($etapas as $etapa) { ?>
                                                    <tr>
                                                        <td>
                                                            <input type="hidden" name="etapa_id[]" value="<?php echo $etapa->id; ?>" />
                                                            <input type="hidden" name="etapa_ordem[]" value="<?php echo $etapa->ordem; ?>" />
                                                            <input type="hidden" name="etapa_nome[]" value="<?php echo $etapa->descricao; ?>" />
                                                            <span><?php echo $etapa->descricao; ?></span>
                                                        </td>
                                                        <td class="center">
                                                            <button type="button" data-toggle="tooltip" data-original-title="Excluir" title="Excluir" data-cep="" class="btn btn-sm btn-icon btn-outline-danger btn-round btn-del-etapa"><i class="ti ti-trash"></i></button>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <?php echo form_close(); ?>

                        <script src="<?php echo site_url('assets/'); ?>javascripts/custom/crm/funil_etapas.js"></script>