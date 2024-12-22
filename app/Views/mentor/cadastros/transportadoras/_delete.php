                    <div class="card-body pb-3 pt-4">
                        <div class="text-center">
                            <div class="pt-1 bg-img m-auto">
                                <?php if ($transportadora->photo == null) : ?>
                                    <img src="<?= site_url('assets/images/avatar-transportadora.png'); ?>" class="rounded-circle rounded-circle-60" alt="Transportadora" />
                                <?php else : ?>
                                    <img src="<?= site_url("transportadoraes/show_photo/$transportadora->photo"); ?>" class="rounded-circle rounded-circle-60" alt="Logo da Transportadora" />
                                <?php endif; ?>
                            </div>
                            <div class="mt-3">
                                <h4 class="mb-1"><?= $transportadora->razao_social; ?></h4>
                                <p class="mb-0 text-muted">
                                    <a href="mailto:<?= esc($transportadora->email); ?>" target="_blank"><?= esc($transportadora->email); ?></a>
                                </p>
                                <ul class="nav justify-content-between mt-4 px-3 py-2">
                                    <li class="flex-fill">
                                        <p><strong>Cadastrado em</strong></p>
                                        <p><?= formatDateTime($transportadora->created_at); ?></p>
                                    </li>
                                    <li class="flex-fill">
                                        <p><strong>Última Atualização</strong></p>
                                        <p><?= formatDateTime($transportadora->updated_at); ?></p>
                                    </li>
                                </ul>
                            </div>
                            <input type="hidden" name="id" value="<?= $transportadora->id ?>" />
                            <input type="hidden" name="method_del" value="remove" />
                        </div>
                    </div>