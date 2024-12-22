                    <div class="card-body pb-3 pt-4">
                        <div class="text-center">
                            <div class="pt-1 bg-img m-auto">
                                <?php if ($fornecedor->photo == null) : ?>
                                    <img src="<?= site_url('assets/images/avatar-fornecedor.png'); ?>" class="rounded-circle rounded-circle-60" alt="Fornecedor" />
                                <?php else : ?>
                                    <img src="<?= site_url("fornecedors/show_photo/$fornecedor->photo"); ?>" class="rounded-circle rounded-circle-60" alt="Foto do Fornecedor" />
                                <?php endif; ?>
                            </div>
                            <div class="mt-3">
                                <h4 class="mb-1"><?= $fornecedor->razao_social; ?></h4>
                                <p class="mb-0 text-muted">
                                    <a href="mailto:<?= esc($fornecedor->email); ?>" target="_blank"><?= esc($fornecedor->email); ?></a>
                                </p>
                                <ul class="nav justify-content-between mt-4 px-3 py-2">
                                    <li class="flex-fill">
                                        <p><strong>Cadastrado em</strong></p>
                                        <p><?= formatDateTime($fornecedor->created_at); ?></p>
                                    </li>
                                    <li class="flex-fill">
                                        <p><strong>Excluído em</strong></p>
                                        <p><?= formatDateTime($fornecedor->deleted_at); ?></p>
                                    </li>
                                </ul>
                            </div>
                            <input type="hidden" name="id" value="<?= $fornecedor->id ?>" />
                            <input type="hidden" name="method_del" value="restore" />
                        </div>
                    </div>