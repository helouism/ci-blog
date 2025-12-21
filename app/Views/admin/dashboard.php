<?= $this->extend("admin/layout/app") ?>
<?= $this->section("adminContent") ?>


<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="mb-0"><?= esc($title) ?></h1>
    </div>
    <div class="col-md-4 text-end">
        <a href="<?= url_to("admin_posts_create") ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create New Post
        </a>
    </div>
</div>

<!-- Stats Card -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total Posts</h5>
                <h2 class="text-primary"><?= $post_count ?></h2>
            </div>
        </div>
    </div>
</div>

<!-- Posts Table -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Your Posts</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($posts)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>

                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($posts as $post): ?>
                                    <tr>
                                        <td>
                                            <a href="<?= route_to('admin.post.edit', $post['id']) ?>"
                                                class="text-decoration-none">
                                                <?= esc($post['title']) ?>
                                            </a>
                                        </td>

                                        <td><?= date('M d, Y', strtotime($post['created_at'])) ?></td>
                                        <td>
                                            <a href="<?= url_to("admin_post_edit", $post['id']) ?>"
                                                class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="<?= url_to('admin_post_delete', $post['id']) ?>"
                                                class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info" role="alert">
                        <i class="fas fa-info-circle"></i> No posts yet. <a
                            href="<?= url_to('admin_posts_create') ?>">Create your first post</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>