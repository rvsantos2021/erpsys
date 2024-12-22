                    <link href="<?php echo site_url('assets/'); ?>vendor/selectize/css/selectize.bootstrap4.css" rel="stylesheet">

                    <div class="row">
                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                            <legend class="legend"> <i class="fa fa-user"></i> Identificação</legend>
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label for="cpnj" id="labelCNPJ">CNPJ</label>
                                    <input type="text" class="form-control input-sm" name="cnpj" placeholder="CNPJ" value="<?php echo $table->cnpj; ?>" data-plugin-masked-input data-input-mask="99.999.999/9999-99" required />
                                </div>
                                <div class="col-md-2">
                                    <label for="inscricao_estadual" id="labelIE">Inscr. Estadual</label>
                                    <input type="text" class="form-control input-sm" name="inscricao_estadual" placeholder="Inscr. Estadual" value="<?php echo $table->inscricao_estadual; ?>" />
                                </div>
                                <div class="col-md-2">
                                    <label for="data_nascimento" id="labelData">Data Fundação</label>
                                    <input type="date" class="form-control input-sm" name="data_nascimento" value="<?php echo $table->data_nascimento; ?>" />
                                </div>
                                <div class="col-md-6">
                                    <div class="radio-custom radio-success custom-control-inline float-right">
                                        <input type="radio" id="tipo-pf" name="tipo" class="custom-control-input" value="F" <?php echo ($table->tipo == 'F' ? 'checked' : ''); ?> />
                                        <label class="custom-control-label" for="tipo-pf">Pessoa Física</label>
                                    </div>
                                    <div class="radio-custom radio-warning custom-control-inline float-right">
                                        <input type="radio" id="tipo-pj" name="tipo" class="custom-control-input" value="J" <?php echo ($table->tipo == 'J' ? 'checked' : ''); ?> />
                                        <label class="custom-control-label" for="tipo-pj">Pessoa Jurídica</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-7">
                                    <label for="razao_social" id='labelRazao'>Razão Social</label>
                                    <input type="text" class="form-control input-sm" name="razao_social" placeholder="Razão Social" value="<?php echo $table->razao_social; ?>" required />
                                </div>
                                <div class="col-md-5">
                                    <label for="nome_fantasia" id='labelFantasia'>Nome Fantasia</label>
                                    <input type="text" class="form-control input-sm" name="nome_fantasia" placeholder="Nome Fantasia" value="<?php echo $table->nome_fantasia; ?>" />
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                            <legend class="legend"> <i class="fa fa-comment"></i> Contato</legend>
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label for="telefone">Telefone</label>
                                    <input type="text" class="form-control input-sm" name="telefone" placeholder="Telefone" value="<?php echo $table->telefone; ?>" data-plugin-masked-input data-input-mask="(99) 9999-9999" />
                                </div>
                                <div class="col-md-2">
                                    <label for="celular">Celular</label>
                                    <input type="text" class="form-control input-sm" name="celular" placeholder="Celular" value="<?php echo $table->celular; ?>" data-plugin-masked-input data-input-mask="(99) 99999-9999" />
                                </div>
                                <div class="col-md-8">
                                    <label for="email">E-mail</label>
                                    <input type="email" class="form-control input-sm" name="email" placeholder="E-mail" value="<?php echo $table->email; ?>" />
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                            <legend class="legend"> <i class="fa fa-file-text"></i> Informações Adicionais</legend>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="obs">Observações</label>
                                    <textarea class="form-control" rows="2" name="obs"><?php echo $table->obs; ?></textarea>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                            <legend class="legend"> <i class="fa fa-map-marker"></i> Endereços</legend>
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label for="cep">CEP</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control input-sm" name="cep" placeholder="CEP" data-plugin-masked-input data-input-mask="99999-999" val="" />
                                        <span class="input-group-btn">
                                            <button class="btn btn-sm btn-default btn-cep" type="button"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                    <span class="error cep-error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="logradouro">Logradouro</label>
                                    <input type="text" class="form-control input-sm" name="logradouro" placeholder="Logradouro" />
                                </div>
                                <div class="col-md-1">
                                    <label for="numero">Número</label>
                                    <input type="text" class="form-control input-sm" name="numero" placeholder="Número" />
                                </div>
                                <div class="col-md-3">
                                    <label for="complemento">Complemento</label>
                                    <input type="text" class="form-control input-sm" name="complemento" placeholder="Complemento" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-5">
                                    <label for="bairro">Bairro</label>
                                    <input type="text" class="form-control input-sm" name="bairro" placeholder="Bairro" />
                                </div>
                                <div class="col-md-4">
                                    <label for="cidade">Cidade / UF</label>
                                    <select class="form-control selectize" name="cidade" id="cidade">
                                        <option value=""></option>
                                        <?php foreach ($cidades as $cidade) : ?>
                                            <option value="<?php echo $cidade->id; ?>">
                                                <?php echo esc($cidade->nome) . '/' . esc($cidade->uf); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="tipo_end">Tipo</label>
                                    <select class="form-control selectize" name="tipo_end" id="tipo_end">
                                        <option value=""></option>
                                        <option value="R">RESIDENCIAL</option>
                                        <option value="C">COMERCIAL</option>
                                        <option value="F">COBRANÇA</option>
                                        <option value="E">ENTREGA</option>
                                    </select>
                                    <input type="hidden" name="id_cidade" />
                                </div>
                                <div class="col-md-1 text-right">
                                    <button type="button" class="btn btn-sm btn-default mt-26 btn-add-end"><i class="fa fa-arrow-circle-down"></i></button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="tableWrapper" style="min-height: 120px; max-height: 120px; overflow-y: auto;">
                                        <table id="table-enderecos" class="table table-sm" style="width: 100%; border-collapse: collapse;">
                                            <thead class="panel-featured panel-featured-custom text-custom">
                                                <tr class="text-custom">
                                                    <th>CEP</th>
                                                    <th>LOGRADOURO</th>
                                                    <th>NÚMERO</th>
                                                    <th>COMPLEMENTO</th>
                                                    <th>BAIRRO</th>
                                                    <th>CIDADE/UF</th>
                                                    <th>TIPO</th>
                                                    <th class="center col-xs-1">AÇÃO</th>
                                                </tr>
                                            </thead>
                                            <tbody id="lista-enderecos">
                                                <?php foreach ($enderecos as $endereco) : ?>
                                                    <tr>
                                                        <td>
                                                            <input type="hidden" name="end_id[]" value="<?php echo $endereco->id; ?>" />
                                                            <input type="hidden" name="end_cep[]" value="<?php echo $endereco->cep; ?>" />
                                                            <span><?php echo $endereco->cep; ?></span>
                                                        </td>
                                                        <td>
                                                            <input type="hidden" name="end_log[]" value="<?php echo $endereco->logradouro; ?>" />
                                                            <span><?php echo $endereco->logradouro; ?></span>
                                                        </td>
                                                        <td>
                                                            <input type="hidden" name="end_nro[]" value="<?php echo $endereco->numero; ?>" />
                                                            <span><?php echo $endereco->numero; ?></span>
                                                        </td>
                                                        <td>
                                                            <input type="hidden" name="end_cpl[]" value="<?php echo $endereco->complemento; ?>" />
                                                            <span><?php echo $endereco->complemento; ?></span>
                                                        </td>
                                                        <td>
                                                            <input type="hidden" name="end_bai[]" value="<?php echo $endereco->bairro; ?>" />
                                                            <span><?php echo $endereco->bairro; ?></span>
                                                        </td>
                                                        <td>
                                                            <input type="hidden" name="end_cid[]" value="<?php echo $endereco->cidade_id; ?>" />
                                                            <span><?php echo $endereco->cidade . '/' . $endereco->uf; ?></span>
                                                        </td>
                                                        <td>
                                                            <input type="hidden" name="end_tip[]" value="<?php echo $endereco->tipo; ?>" />
                                                            <span><?php echo setTipoEndereco($endereco->tipo); ?></span>
                                                        </td>
                                                        <td class="center">
                                                            <button type="button" data-toggle="tooltip" data-original-title="Excluir" title="Excluir" data-cep="" class="btn btn-xs btn-default btn-width-27 btn-del-end"><i class="fas fa-trash-alt text-danger"></i></button>
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
                    <?= $this->include('layout/_response'); ?>

                    <script src="<?php echo site_url('assets/'); ?>vendor/selectize/js/selectize.min.js"></script>
                    <script src="<?php echo site_url('assets/'); ?>vendor/jquery-maskedinput/jquery.maskedinput.js"></script>
                    <script src="<?php echo site_url('assets/'); ?>javascripts/theme.js"></script>
                    <script src="<?php echo site_url('assets/'); ?>javascripts/theme.init.js"></script>
                    <script src="<?php echo site_url('assets/'); ?>javascripts/forms/examples.validation.js"></script>

                    <script type="text/javascript">
                        $(document).ready(function() {
                            $('.selectize').selectize();

                            var cnpj = '<?php echo $table->cnpj; ?>';

                            $('input[name="tipo"]').change(function() {
                                updateLabels();
                            });

                            if ($('[name="tipo"]').val() == '') {
                                $('[name="tipo"]').val('F');
                            }

                            $('[name="cnpj"]').val(cnpj);
                        });

                        $('#lista-enderecos').on('click', '.btn-del-end', function() {
                            Swal.fire({
                                title: 'Confirma a exclusão?',
                                text: "Essa ação não poderá ser revertida.",
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Sim',
                                cancelButtonText: 'Não'
                            }).then((result) => {
                                if (result.value == true) {
                                    var row = $(this).closest('tr');
                                    var id = row.find('[name="end_id[]"]').val();

                                    row.remove();

                                    Swal.fire(
                                        'Excluído!',
                                        'O endereço selecionado foi excluído.',
                                        'success'
                                    )
                                }
                            })
                        });
                    </script>