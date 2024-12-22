            <div class="modal-wrapper-custom">
                <fieldset class="border pt-4 pb-4 pr-4 pl-4 mb-2 rounded">
                    <div class="pr-4 pl-4">
                        <div class="row row-title">
                            <div class="col-md-1">
                                <span class="text-bold">ID</span>
                            </div>
                            <div class="col-md-2">
                                <span class="text-bold" id="cnpj-label">CNPJ</span>
                            </div>
                            <div class="col-md-2">
                                <span class="text-bold" id="ie-label">INSCR. ESTADUAL</span>
                            </div>
                            <div class="col-md-6">

                            </div>
                            <div class="col-md-1">
                                <span class="text-bold">STATUS</span>
                            </div>
                        </div>
                        <div class="row row-content">
                            <div class="col-md-1">
                                <span><?php echo $vendedor->id; ?></span>
                            </div>
                            <div class="col-md-2">
                                <span><?php echo $vendedor->cnpj; ?></span>
                            </div>
                            <div class="col-md-2">
                                <span><?php echo $vendedor->inscricao_estadual; ?></span>
                            </div>
                            <div class="col-md-6">

                            </div>
                            <div class="col-md-1">
                                <?php echo ($vendedor->active == true ? '<span class="text-success">ATIVO</span>' : '<span class="text-danger">INATIVO</span>'); ?>
                            </div>
                        </div>
                        <div class="row row-space">

                        </div>
                        <div class="row row-title">
                            <div class="col-md-8">
                                <span class="text-bold" id="razao-label">RAZÃO SOCIAL</span>
                            </div>
                            <div class="col-md-4">
                                <span class="text-bold" id="fantasia-label">NOME FANTASIA</span>
                            </div>
                        </div>
                        <div class="row row-content">
                            <div class="col-md-8">
                                <span><?php echo $vendedor->razao_social; ?></span>
                            </div>
                            <div class="col-md-4">
                                <span><?php echo $vendedor->nome_fantasia; ?></span>
                            </div>
                        </div>
                        <div class="row row-space">

                        </div>
                        <div class="row row-title">
                            <div class="col-md-3">
                                <span class="text-bold">TELEFONE</span>
                            </div>
                            <div class="col-md-3">
                                <span class="text-bold">CELULAR</span>
                            </div>
                            <div class="col-md-6">
                                <span class="text-bold">DATA FUNDAÇÃO</span>
                            </div>
                        </div>
                        <div class="row row-content">
                            <div class="col-md-3">
                                <span><?php echo $vendedor->telefone; ?></span>
                            </div>
                            <div class="col-md-3">
                                <span><?php echo $vendedor->celular; ?></span>
                            </div>
                            <div class="col-md-6">
                                <span><?php echo formatDate($vendedor->data_nascimento); ?></span>
                            </div>
                        </div>
                        <div class="row row-space">

                        </div>
                        <div class="row row-title">
                            <div class="col-md-2">
                                <span class="text-bold">% COMISSÃO</span>
                            </div>
                            <div class="col-md-10">
                                <span class="text-bold">E-MAIL</span>
                            </div>
                        </div>
                        <div class="row row-content">
                            <div class="col-md-2">
                                <span><?php echo formatPercent($vendedor->perc_comissao, false); ?></span>
                            </div>
                            <div class="col-md-10">
                                <span><?php echo $vendedor->email; ?></span>
                            </div>
                        </div>
                        <div class="row row-space">

                        </div>
                        <div class="row row-title">
                            <div class="col-md-12">
                                <span class="text-bold">OBSERVAÇÕES</span>
                            </div>
                        </div>
                        <div class="row row-textarea">
                            <div class="col-md-12">
                                <span><?php echo $vendedor->obs; ?></span>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <div class="row">
                    <div class="col-md-4">
                        <span class="text-primary">
                            <i class="fas fa-clock"></i><strong> Última Atualização:</strong> <?php echo formatDateTime($vendedor->updated_at); ?>
                        </span>
                    </div>
                </div>
            </div>