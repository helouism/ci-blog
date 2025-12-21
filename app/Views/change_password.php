<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.changePassword') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="container d-flex justify-content-center p-5">
    <div class="card col-12 col-md-5 shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-5"><?= lang('Auth.changePassword') ?></h5>

            <?php if (session('error') !== null): ?>
                <div class="alert alert-danger" role="alert"><?= session('error') ?></div>
            <?php elseif (session('errors') !== null): ?>
                <div class="alert alert-danger" role="alert">
                    <?php if (is_array(session('errors'))): ?>
                        <?php foreach (session('errors') as $error): ?>
                            <?= $error ?>
                            <br>
                        <?php endforeach ?>
                    <?php else: ?>
                        <?= session('errors') ?>
                    <?php endif ?>
                </div>
            <?php endif ?>

            <?php if (session('message') !== null): ?>
                <div class="alert alert-success" role="alert"><?= session('message') ?></div>
            <?php endif ?>

            <form action="<?= url_to('change-password') ?>" method="post">
                <?= csrf_field() ?>

                <!-- Password -->
                <div class="mb-2">
                    <input type="password" class="form-control" name="password" inputmode="text"
                        autocomplete="new-password" placeholder="<?= lang('Auth.password') ?>" required />
                </div>

                <!-- Password Confirm -->
                <div class="mb-2">
                    <input type="password" class="form-control" name="password_confirm" inputmode="text"
                        autocomplete="new-password" placeholder="<?= lang('Auth.passwordConfirm') ?>" required />
                </div>
                <!-- Old Password -->
                <div class="mb-2">
                    <input type="password" class="form-control" name="old_password" inputmode="text"
                        autocomplete="current-password" placeholder="<?= lang('Auth.OldPassword') ?>" required />
                </div>

                <p class="text-center"><?= lang('Auth.logout') ?> <a
                        href="<?= url_to('logout') ?>"><?= lang('Auth.logout') ?></a></p>

                <div class="d-grid col-12 col-md-8 mx-auto m-3">
                    <button type="submit" class="btn btn-primary btn-block"><?= lang('Auth.changePassword') ?></button>
                </div>

            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>