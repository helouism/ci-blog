<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts tagged with "<?= esc($tag->name) ?>" - TheGoodOne Blog</title>
    <meta name="description" content="<?= esc($metaDescription) ?>">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="Posts tagged with &quot;<?= esc($tag->name) ?>&quot;">
    <meta property="og:description" content="<?= esc($metaDescription) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= current_url() ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Posts tagged with &quot;<?= esc($tag->name) ?>&quot;">
    <meta name="twitter:description" content="<?= esc($metaDescription) ?>">

    <!-- Canonical URL -->
    <link rel="canonical" href="<?= current_url() ?>">

    <!-- Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "CollectionPage",
        "name": "Posts tagged with <?= esc($tag->name) ?>",
        "description": "<?= esc($metaDescription) ?>",
        "url": "<?= current_url() ?>"
    }
    </script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        :root {
            --primary-color: #2563eb;
            --text-color: #1f2937;
            --light-bg: #f9fafb;
            --border-color: #e5e7eb;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            color: var(--text-color);
            line-height: 1.6;
        }

        .tag-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 3rem 0;
            margin-bottom: 3rem;
        }

        .tag-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .tag-header p {
            font-size: 1.1rem;
            opacity: 0.95;
        }

        .tag-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            margin-top: 1rem;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 2rem;
            color: var(--text-color);
        }

        .post-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .post-card:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transform: translateY(-4px);
            border-color: var(--primary-color);
        }

        .post-card-header {
            position: relative;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            text-align: center;
            padding: 1rem;

            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .post-card-header.has-image::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(0, 0, 0, 0.05), rgba(0, 0, 0, 0.35));
        }

        .post-card-header .post-card-header-text {
            position: relative;
            z-index: 1;
        }


        .post-card-body {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .post-card-title {
            font-size: 1.15rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 0.75rem;
            line-height: 1.4;
        }

        .post-card-title a {
            color: var(--text-color);
            text-decoration: none;
        }

        .post-card-title a:hover {
            color: var(--primary-color);
        }

        .post-meta {
            font-size: 0.85rem;
            color: #9ca3af;
            margin-bottom: 0.75rem;
        }

        .post-description {
            color: #6b7280;
            font-size: 0.95rem;
            margin-bottom: 1rem;
            flex-grow: 1;
        }

        .post-tag {
            font-size: 0.75rem;
            background-color: var(--light-bg);
            color: var(--primary-color);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            display: inline-block;
        }

        .pagination {
            margin-top: 3rem;
            justify-content: center;
        }

        .pagination .page-link {
            color: var(--primary-color);
        }

        .pagination .page-link:hover {
            color: white;
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-state h2 {
            font-size: 1.75rem;
            margin-bottom: 1rem;
        }

        .empty-state p {
            color: #6b7280;
            margin-bottom: 2rem;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #1d4ed8;
            border-color: #1d4ed8;
        }

        .ad-space {
            background-color: var(--light-bg);
            border: 1px dashed var(--border-color);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
            font-size: 0.9rem;
            margin: 2rem 0;
            padding: 2rem;
        }

        @media (max-width: 768px) {
            .tag-header h1 {
                font-size: 1.75rem;
            }

            .section-title {
                font-size: 1.5rem;
            }

            .post-card-header {
                height: 150px;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <?= view('partials/navbar') ?>

    <!-- Tag Header -->
    <div class="tag-header">
        <div class="container-lg">
            <h1>Tag: <?= esc($tag->name) ?></h1>
            <p>Explore all posts tagged with <strong><?= esc($tag->name) ?></strong></p>
            <div class="tag-badge">
                📁 <?= count($posts) ?> post<?= count($posts) !== 1 ? 's' : '' ?>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="py-5">
        <div class="container-lg">
            <!-- Ad Space (Top) -->
            <div class="ad-space">
                <!-- Google AdSense code here -->
            </div>

            <?php if (!empty($posts)): ?>
                <div class="row g-4 mb-5">
                    <?php foreach ($posts as $post): ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="post-card">
                                <?php
                                $thumbUrl = !empty($post['featured_image']) ? base_url($post['featured_image']) : null;
                                ?>
                                <div class="post-card-header <?= $thumbUrl ? 'has-image' : '' ?>" <?= $thumbUrl ? 'style="background-image: url(\'' . esc($thumbUrl, 'attr') . '\')"' : '' ?>>
                                    <?php if (!$thumbUrl): ?>
                                        <span class="post-card-header-text">
                                            <?= esc(strtoupper(substr($post['title'], 0, 3))) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="visually-hidden"><?= esc($post['title']) ?></span>
                                    <?php endif; ?>
                                </div>

                                <div class="post-card-body">
                                    <h3 class="post-card-title">
                                        <a href="<?= url_to('blog_view', $post['slug']) ?>">
                                            <?= esc(substr($post['title'], 0, 60) . (strlen($post['title']) > 60 ? '...' : '')) ?>
                                        </a>
                                    </h3>
                                    <div class="post-meta">
                                        📅 <?= date('M d, Y', strtotime($post['created_at'])) ?> • ✏️
                                        <?= esc($post['username']) ?>
                                    </div>
                                    <p class="post-description">
                                        <?= esc($post['meta_description']) ?>
                                    </p>
                                    <a href="<?= url_to('blog_view', $post['slug']) ?>" class="post-tag mt-auto">+ Read More</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <?php if ($pager): ?>
                    <nav aria-label="Page navigation">
                        <?= $pager->links('default', 'bootstrap_pagination') ?>
                    </nav>
                <?php endif; ?>
            <?php else: ?>
                <div class="empty-state">
                    <h2>No posts found</h2>
                    <p>There are no posts with the tag "<?= esc($tag->name) ?>" yet.</p>
                    <a href="<?= url_to('landing_page') ?>#blog" class="btn btn-primary">View All Posts</a>
                </div>
            <?php endif; ?>

            <!-- Ad Space (Bottom) -->
            <div class="ad-space mt-5">
                <!-- Google AdSense code here -->
            </div>
        </div>
    </main>

    <!-- Footer -->
    <?= view('partials/footer') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>