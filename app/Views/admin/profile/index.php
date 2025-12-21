<?= $this->extend("admin/layout/app") ?>
<?= $this->section("adminContent") ?>

<div class="row mb-4">
    <div class="col-12">
        <h1 class="h3 mb-3">
            <i class="bi bi-person-circle"></i> My Profile
        </h1>
    </div>
</div>

<!-- Profile Information Card -->
<div class="row mb-4">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="bi bi-info-circle"></i> Profile Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Username</h6>
                        <p class="fs-6 fw-semibold"><?= htmlspecialchars($user->username) ?></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Email</h6>
                        <p class="fs-6 fw-semibold"><?= htmlspecialchars($user->email) ?></p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-muted mb-2">Bio</h6>

                        <form action="<?= url_to('admin_profile_update_bio') ?>" method="post">
                            <?= csrf_field() ?>

                            <textarea class="form-control" name="bio" rows="4" maxlength="500"
                                placeholder="Write a short bio (max 500 characters)"><?= old('bio', esc((string) ($user->bio ?? ''))) ?></textarea>

                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <small class="text-muted">Max 500 characters</small>
                                <button type="submit" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-save"></i> Save Bio
                                </button>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Account Status</h6>
                        <p>
                            <?php if ($user->active): ?>
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle"></i> Active
                                </span>
                            <?php else: ?>
                                <span class="badge bg-warning">
                                    <i class="bi bi-exclamation-circle"></i> Inactive
                                </span>
                            <?php endif; ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Member Since</h6>
                        <p class="fs-6">
                            <?= date('F d, Y', strtotime($user->created_at)) ?>
                        </p>
                    </div>
                </div>

                <hr>

                <h6 class="text-muted mb-3">Account Actions</h6>
                <div class="d-flex flex-wrap gap-2">
                    <a href="<?= base_url('admin/profile/change-username') ?>" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-pencil"></i> Change Username
                    </a>
                    <a href="<?= base_url('admin/profile/change-email') ?>" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-pencil"></i> Change Email
                    </a>
                    <a href="<?= base_url('admin/profile/change-password') ?>" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-pencil"></i> Change Password
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Summary Card -->
    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">
                    <i class="bi bi-speedometer2"></i> Quick Stats
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted d-block mb-1">User ID</small>
                    <p class="mb-3"><code><?= htmlspecialchars($user->id) ?></code></p>
                </div>

            </div>
        </div>
    </div>
</div><?= $this->endSection() ?>