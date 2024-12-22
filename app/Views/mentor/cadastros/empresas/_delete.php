                    <div class="card-body pb-3 pt-4">
                        <div class="text-center">
                            <div class="pt-1 bg-img m-auto">
                                <?php if ($empresa->photo == null) : ?>
                                    <img src="<?= site_url('assets/images/avatar-empresa.png'); ?>" class="rounded-circle rounded-circle-60" alt="Empresa" />
                                <?php else : ?>
                                    <img src="<?= site_url("empresas/show_photo/$empresa->photo"); ?>" class="rounded-circle rounded-circle-60" alt="Logo da Empresa" />
                                <?php endif; ?>
                            </div>
                            <div class="mt-3">
                                <h4 class="mb-1"><?= $empresa->razao_social; ?></h4>
                                <p class="mb-0 text-muted">
                                    <a href="mailto:<?= esc($empresa->email); ?>" target="_blank"><?= esc($empresa->email); ?></a>
                                </p>
                                <ul class="nav justify-content-between mt-4 px-3 py-2">
                                    <li class="flex-fill">
                                        <p><strong>Cadastrado em</strong></p>
                                        <p><?= formatDateTime($empresa->created_at); ?></p>
                                    </li>
                                    <li class="flex-fill">
                                        <p><strong>Última Atualização</strong></p>
                                        <p><?= formatDateTime($empresa->updated_at); ?></p>
                                    </li>
                                </ul>
                            </div>
                            <input type="hidden" name="id" value="<?= $empresa->id ?>" />
                            <input type="hidden" name="method_del" value="remove" />
                        </div>
                    </div>