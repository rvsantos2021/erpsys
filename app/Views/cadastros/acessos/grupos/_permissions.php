                <link href="<?php echo site_url('assets/'); ?>vendor/selectize/css/selectize.bootstrap4.css" rel="stylesheet">

                <div class="row">
                    <div class="col-md-8">
                        <h4 class="name text-semibold"><?php echo $group->name; ?></h4>
                        <p class="role"><?php echo esc($group->description); ?></p>
                        <?php if (empty($group->permissions)) : ?>
                            <hr />
                            <h5 class="contributions text-warning">
                                Esse grupo não possui permissão de acesso definida
                            </h5>
                        <?php else : ?>
                            <table id="table-permissions" class="table table-striped table-sm" style="width: 100%">
                                <thead>
                                    <tr class="text-custom">
                                        <th>PERMISSÃO</th>
                                        <th class="center col-xs-1">AÇÃO</th>
                                    </tr>
                                </thead>
                            </table>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-4">
                        <?php echo form_open('/', ['id' => 'formPermission'], ['id' => "$group->id"]) ?>
                        <input type="hidden" name="method" value="permissions_save" />
                        <h5 class="card-title text-bold">Permissões disponíveis</h5>
                        <label class="form-control-label">Selecione a(s) permissões(s)</label>
                        <select name="permission_id[]" class="form-control selectize" multiple="multiple">
                            <?php foreach ($permissions_list as $permission) : ?>
                                <option value="<?php echo $permission->id; ?>">
                                    <?php echo esc($permission->description); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback"></div>
                        <?php echo form_close(); ?>
                    </div>
                </div>

                <script src="<?php echo site_url('assets/'); ?>vendor/selectize/js/selectize.min.js"></script>

                <script type="text/javascript">
                    $(document).ready(function() {
                        $("#table-permissions").DataTable({
                            "oLanguage": language_PTBR,
                            "ajax": "<?php echo site_url('grupos/fetch_permissions/') . $group->id ?>",
                            "columns": [{
                                    "data": "description"
                                },
                                {
                                    "data": "actions"
                                },
                            ],
                            "columnDefs": [{
                                "targets": 1,
                                "className": "center",
                                "orderable": false,
                                "order": []
                            }],
                            "deferRender": true,
                            "stateSave": true,
                            "responsive": true,
                            "ordering": false,
                            "searching": false,
                            "info": false,
                            "lengthChange": false,
                            "pagingType": "simple",
                        });

                        $('.selectize').selectize();
                    });
                </script>