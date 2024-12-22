                <div class="form-row">
                    <div class="form-group col-md-3">
                        <div class="text-center">
                            <img src="<?= site_url('assets/images/avatar-permission.png'); ?>" class="rounded-circle" alt="Permissões de Acesso" />
                        </div>
                    </div>
                    <div class="form-group col-md-9">
                        <fieldset class="border pr-4 pl-4 rounded">
                            <legend class="legend"> <i class="fa fa-bookmark"></i> Dados Gerais</legend>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Nome</label>
                                    <input type="text" class="form-control" name="name" value="<?= $permission->name; ?>" disabled />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Descrição</label>
                                    <textarea class="form-control" name="description" rows="3" disabled><?php echo esc($permission->description); ?></textarea>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Cadastrado em</label>
                                    <input type="text" class="form-control" name="created_at" value="<?= formatDateTime($permission->created_at); ?>" disabled />
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Última atualização</label>
                                    <input type="text" class="form-control" name="updated_at" value="<?= formatDateTime($permission->updated_at); ?>" disabled />
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Excluído em</label>
                                    <input type="text" class="form-control" name="deleted_at" value="<?= formatDateTime($permission->deleted_at); ?>" disabled />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                </div>
                                <div class="form-group col-md-4">
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="active" <?= ($permission->active == 1 ? 'checked' : ''); ?> />
                                        <label>Ativo</label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>