<?= $this->extend("admin/layout/app") ?>
<?= $this->section("adminContent") ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 fw-bold text-dark mb-1">
            <i class="bi bi-file-post"></i> Posts
        </h1>
        <p class="text-muted mb-0">Manage all your blog posts</p>
    </div>
    <a href="<?= base_url("admin/posts/create") ?>" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>New Post
    </a>
</div>

<?php if (!empty($posts) && count($posts) > 0): ?>
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light border-bottom">
                    <tr>
                        <th scope="col" class="fw-bold">Title</th>
                        <th scope="col" class="fw-bold">Content Preview</th>
                        <th scope="col" class="fw-bold">Created At</th>
                        <th scope="col" class="fw-bold text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post): ?>
                        <tr>
                            <td>
                                <div class="fw-semibold text-dark">
                                    <?= esc($post['title']) ?>
                                </div>
                            </td>
                            <td>
                                <div class="text-muted small text-truncate" style="max-width: 300px;">
                                    <?= substr(esc($post['content']), 0, 50) . (strlen($post['content']) > 50 ? '...' : '') ?>
                                </div>
                            </td>
                            <td>
                                <small class="text-muted">
                                    <?= isset($post['created_at']) ? date('M d, Y', strtotime($post['created_at'])) : 'N/A' ?>
                                </small>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="<?= url_to("admin_post_edit", $post['id']) ?>" class="btn btn-outline-primary"
                                        title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" title="Delete"
                                        onclick="if(confirm('Are you sure you want to delete this post?')) { location.href='<?= url_to('admin_post_delete', $post['id']) ?>'; }">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <nav class="mt-4" aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?= $pager->links('post', 'bootstrap_pagination') ?>
        </ul>
    </nav>

<?php else: ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <div class="text-center py-5">
            <i class="bi bi-inbox" style="font-size: 3rem; color: #6c757d;"></i>
            <h5 class="mt-3 text-muted">No posts found</h5>
            <p class="text-muted mb-0">Create your first post to get started!</p>
            <a href="<?= base_url("admin/posts/create") ?>" class="btn btn-primary mt-3">
                <i class="bi bi-plus-circle me-2"></i>Create First Post
            </a>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>