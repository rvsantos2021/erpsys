                <div class="form-row">
                    <div class="form-table col-md-3">
                        <div class="text-center">
                            <img class="img-fluid" src="<?= site_url('assets/images/avatar-group.png'); ?>" alt="Grupo de Usuários" />
                        </div>
                    </div>
                    <div class="form-table col-md-9">
                        <fieldset class="border pr-4 pl-4 rounded">
                            <legend class="legend"> <i class="fa fa-bookmark"></i> Dados Gerais</legend>
                            <div class="form-row">
                                <div class="form-table col-md-12">
                                    <label>Nome</label>
                                    <input type="text" class="form-control" name="name" placeholder="Nome" value="<?= $table->name; ?>" required />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-table col-md-12">
                                    <label>Descrição</label>
                                    <textarea class="form-control" name="description" rows="3" data-plugin-maxlength maxlength="100"><?php echo esc($table->description); ?></textarea>
                                </div>
                            </div>
                            <div class="form-table">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="display" name="display" <?= ($table->display == 1 ? 'checked' : ''); ?> />
                                    <label for="display" class="form-check-label">Exibir</label>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <?= $this->include('mentor/layout/_response'); ?>