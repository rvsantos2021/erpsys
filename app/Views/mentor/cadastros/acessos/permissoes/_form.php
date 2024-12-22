                <div class="form-row">
                    <div class="form-group col-md-3">
                        <div class="text-center">
                            <img class="img-fluid" src="<?= site_url('assets/images/avatar-permission.png'); ?>" alt="Permissão de Acesso" />
                        </div>
                    </div>
                    <div class="form-group col-md-9">
                        <fieldset class="border pb-4 pr-4 pl-4 rounded">
                            <legend class="legend"> <i class="fa fa-bookmark"></i> Dados Gerais</legend>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Nome</label>
                                    <input type="text" class="form-control" name="name" placeholder="Nome" value="<?= $table->name; ?>" maxlength="100" required />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Descrição</label>
                                    <textarea class="form-control" name="description" rows="3" data-plugin-maxlength maxlength="100" required><?php echo esc($table->description); ?></textarea>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <?= $this->include('mentor/layout/_response'); ?>