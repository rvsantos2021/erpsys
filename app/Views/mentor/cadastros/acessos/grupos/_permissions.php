                <div class="row select-wrapper">
                    <div class="col-md-8">
                        <h4><?= $group->name; ?></h4>
                        <label>
                            <?= esc($group->description); ?>
                        </label>
                        <?php if (empty($group->permissions)) : ?>
                            <hr />
                            <h5 class="text-warning">
                                Esse grupo não possui permissão de acesso definida
                            </h5>
                        <?php else : ?>
                            <div class="grid-150">
                                <table id="table-permissions" class="table table-sm">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Permissão</th>
                                            <th class="text-center col-xs-1">Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($permissions as $permission) { ?>
                                            <tr>
                                                <td>
                                                    <?= $permission->description; ?>
                                                </td>
                                                <td class="text-center col-xs-1">
                                                    <button title="Excluir" data-id="" class="btn btn-xs btn-icon btn-outline-danger btn-round btn-del-perm" <?= ($permission->id == 1) ? 'disabled' : ''; ?>><i class="ti ti-close"></i></button>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-4 selects-contant">
                        <?= form_open('/', ['id' => 'formPermission'], ['id' => "$group->id"]) ?>
                        <input type="hidden" name="method" value="permissions_save" />
                        <h4>Permissões disponíveis</h4>
                        <label>
                            Selecione a(s) permissões(s)
                        </label>
                        <select name="permission_id[]" class="js-basic-multiple form-control" data-js-container=".modal" multiple="multiple">
                            <?php foreach ($permissions_list as $permission) : ?>
                                <option value="<?= $permission->id; ?>">
                                    <?= esc($permission->description); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback"></div>
                        <?= form_close(); ?>
                    </div>
                </div>

                <script type="text/javascript">
                    $(document).ready(function() {
                        $(".js-basic-multiple").select2({
                            dropdownParent: $("#modalPermission")
                        });
                    });
                </script>