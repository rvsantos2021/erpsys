                    <div class="card-body pb-3 pt-4">
                        <div class="text-center">
                            <div class="pt-1 bg-img m-auto">
                                <img class="img-fluid" src="<?= site_url('assets/images/avatar-permission.png'); ?>" alt="Permissão de Acesso" />
                            </div>
                            <div class="mt-3">
                                <h4 class="mb-1"><?= $permission->name; ?></h4>
                                <p class="mb-0 text-muted">
                                    <?= esc($permission->description); ?>
                                </p>
                                <ul class="nav justify-content-between mt-4 px-3 py-2">
                                    <li class="flex-fill">
                                        <p><strong>Cadastrado em</strong></p>
                                        <p><?= formatDateTime($permission->created_at); ?></p>
                                    </li>
                                    <li class="flex-fill">
                                        <p><strong>Última Atualização</strong></p>
                                        <p><?= formatDateTime($permission->updated_at); ?></p>
                                    </li>
                                </ul>
                            </div>
                            <input type="hidden" name="id" value="<?= $permission->id ?>" />
                            <input type="hidden" name="method_del" value="remove" />
                        </div>
                    </div>