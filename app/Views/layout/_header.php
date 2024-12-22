        <?= helper('authentication'); ?>
        <header class="header">
            <div class="logo-container">
                <a href="#" class="logo">
                    <img src="<?= site_url('assets/'); ?>images/<?php echo APP_LOGOBAR; ?>" height="35" alt="" />
                </a>
                <div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
                    <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
                </div>
            </div>
            <!-- start: search & user box -->
            <div class="header-right">
                <ul class="notifications">
                    <?= $this->include('layout/authenticate/_messages'); ?>
                    <?= $this->include('layout/authenticate/_alerts'); ?>
                </ul>
                <span class="separator"></span>
                <div id="userbox" class="userbox">
                    <a href="#" data-toggle="dropdown">
                        <figure class="profile-picture">
                            <?php if (userIsLogged()->photo != null) { ?>
                                <img src="<?= site_url('users/show_photo/') . userIsLogged()->photo; ?>" alt="Usuário" class="img-circle" />
                            <?php } else { ?>
                                <img src="<?= site_url('assets/images/' . APP_LOGOICON); ?>" alt="Usuário" class="img-circle" />
                            <?php } ?>
                        </figure>
                        <div class="profile-info" data-lock-name="<?= userIsLogged()->name; ?>" data-lock-email="<?= userIsLogged()->email; ?>">
                            <span class="name"><?= userIsLogged()->name; ?></span>
                            <span class="role"><?= userIsLogged()->email; ?></span>
                        </div>
                        <i class="fa custom-caret"></i>
                    </a>
                    <div class="dropdown-menu">
                        <ul class="list-unstyled">
                            <li class="divider"></li>
                            <li>
                                <a role="menuitem" tabindex="-1" href="#"><i class="fa fa-user"></i> Meu Perfil</a>
                            </li>
                            <li>
                                <a role="menuitem" tabindex="-1" href="#" data-lock-screen="true"><i class="fa fa-lock"></i> Bloquear Tela</a>
                            </li>
                            <li>
                                <a role="menuitem" tabindex="-1" href="<?php echo site_url('logout'); ?>"><i class="fa fa-power-off"></i> Encerrar</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- end: search & user box -->
        </header>