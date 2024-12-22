                                    <div class="tab-pane fade" id="fornecedores" role="tabpanel" aria-labelledby="fornecedores-tab">
                                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                                            <legend class="legend"> <i class="fa fa-building"></i> Fornecedores</legend>
                                            <div class="form-row">
                                                <div class="form-group col-md-8">
                                                    <label for="fornecedor">Fornecedor</label>
                                                    <select class="js-basic-single form-control" name="fornecedor" id="fornecedor" <?php echo $method == 'show' ? 'disabled' : '' ?>>
                                                        <option value="">--- Selecione ---</option>
                                                        <?php foreach ($fornecedores as $fornecedor) { ?>
                                                            <option value="<?php echo $fornecedor->id; ?>"><?php echo $fornecedor->razao_social; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="codigo_fornecedor">Código Fornecedor</label>
                                                    <input type="text" class="form-control" name="codigo_fornecedor" placeholder="Código Fornecedor" maxlength="30" <?php echo $method == 'show' ? 'disabled' : '' ?>/>
                                                </div>
                                                <div class="form-group col-md-1 text-right">
                                                    <button type="button" class="btn btn-sm btn-default mt-25 btn-inc-fornec"><i class="ti ti-arrow-down"></i></button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <div id="tableWrapper" style="min-height: 383px; max-height: 383px; overflow-y: auto;">
                                                        <table id="table-fornecedores" class="table table-sm" style="width: 100%; border-collapse: collapse;">
                                                            <thead class="panel-featured panel-featured-custom text-custom">
                                                                <tr class="text-custom">
                                                                    <th>FORNECEDOR</th>
                                                                    <th class="form-group col-xs-3">CÓD. FORNECEDOR</th>
                                                                    <th class="form-group col-xs-1 text-center">AÇÃO</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="lista-fornecedores">
                                                                <?php foreach ($prod_fornecedores as $prod_fornec) { ?>
                                                                    <tr>
                                                                        <td>
                                                                            <input type="hidden" name="fornec_id[]" value="<?php echo $prod_fornec->id; ?>" />
                                                                            <input type="hidden" name="for_id[]" value="<?php echo $prod_fornec->fornecedor_id; ?>" />
                                                                            <?php echo $prod_fornec->fornecedor; ?>
                                                                        </td>
                                                                        <td class="form-group col-xs-3">
                                                                            <input type="hidden" name="for_cod[]" value="<?php echo $prod_fornec->codigo; ?>" />
                                                                            <?php echo $prod_fornec->codigo; ?>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <button type="button" data-toggle="tooltip" data-original-title="Excluir" title="Excluir" class="btn btn-sm btn-icon btn-outline-danger btn-round btn-del-fornec"><i class="ti ti-trash"></i></button>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                            <tfoot class="panel-featured panel-featured-custom text-custom">
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>