                                    <div id="fornecedores" class="tab-pane">
                                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                                            <legend class="legend"> <i class="fa fa-building"></i> Fornecedores</legend>
                                            <div class="form-group row">
                                                <div class="col-md-8">
                                                    <label for="fornecedor">Fornecedor</label>
                                                    <div class="input-group btn-group">
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn btn-sm btn-default btn-add-fornecedor"><i class="fa fa-plus"></i></button>
                                                        </div>
                                                        <select data-plugin-selectTwo class="form-control input-sm" name="fornecedor" data-plugin-options='{ "allowClear": true }'>
                                                            <option value=""></option>
                                                            <?php foreach ($fornecedores as $fornecedor) : ?>
                                                                <option value="<?php echo $fornecedor->id; ?>"><?php echo $fornecedor->razao_social; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="codigo_fornecedor">Código Fornecedor</label>
                                                    <input type="text" class="form-control input-sm" name="codigo_fornecedor" placeholder="Código Fornecedor" maxlength="30" />
                                                </div>
                                                <div class="col-md-1 text-right">
                                                    <button type="button" class="btn btn-sm btn-default mt-26 btn-inc-fornec"><i class="fa fa-arrow-circle-down"></i></button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div id="tableWrapper" style="min-height: 383px; max-height: 383px; overflow-y: auto;">
                                                        <table id="table-fornecedores" class="table table-sm" style="width: 100%; border-collapse: collapse;">
                                                            <thead class="panel-featured panel-featured-custom text-custom">
                                                                <tr class="text-custom">
                                                                    <th>FORNECEDOR</th>
                                                                    <th class="col-xs-3">CÓD. FORNECEDOR</th>
                                                                    <th class="col-xs-1 center">AÇÃO</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="lista-fornecedores">
                                                                <?php foreach ($prod_fornecedores as $prod_fornec) : ?>
                                                                    <tr>
                                                                        <td>
                                                                            <input type="hidden" name="fornec_id[]" value="<?= $prod_fornec->id; ?>" />
                                                                            <input type="hidden" name="for_id[]" value="<?= $prod_fornec->fornecedor_id; ?>" />
                                                                            <?= $prod_fornec->fornecedor; ?>
                                                                        </td>
                                                                        <td class="col-xs-3">
                                                                            <input type="hidden" name="for_cod[]" value="<?= $prod_fornec->codigo; ?>" />
                                                                            <?= $prod_fornec->codigo; ?>
                                                                        </td>
                                                                        <td class="center">
                                                                            <button type="button" data-toggle="tooltip" data-original-title="Excluir" title="Excluir" data-cep="" class="btn btn-xs btn-default btn-width-27 btn-del-fornec"><i class="fas fa-trash-alt text-danger"></i></button>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            </tbody>
                                                            <tfoot class="panel-featured panel-featured-custom text-custom">
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>