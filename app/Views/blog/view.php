<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($post['title']) ?> - TheGoodOne Blog</title>
    <meta name="description" content="<?= esc($post['meta_description']) ?>">
    <?php
    $ogImage = !empty($post['featured_image'])
        ? base_url($post['featured_image'])
        : base_url('images/default-og-image.jpg');
    ?>

    <meta name="author" content="<?= esc($post['username']) ?>">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="<?= esc($post['title']) ?>">
    <meta property="og:description" content="<?= esc($post['meta_description']) ?>">
    <meta property="og:type" content="article">
    <meta property="og:url" content="<?= current_url() ?>">
    <meta property="og:image" content="<?= esc($ogImage) ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:image" content="<?= esc($ogImage) ?>">

    <meta name="twitter:title" content="<?= esc($post['title']) ?>">
    <meta name="twitter:description" content="<?= esc($post['meta_description']) ?>">

    <!-- Structured Data (Schema.org) -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BlogPosting",
        "headline": "<?= esc($post['title']) ?>",
        "description": "<?= esc($post['meta_description']) ?>",
     "image": "<?= esc($ogImage) ?>",

        "datePublished": "<?= $post['created_at'] ?>",
        "dateModified": "<?= $post['updated_at'] ?>",
        "author": {
            "@type": "Person",
            "name": "<?= esc($post['username']) ?>"
        }
    }
    </script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css">
    <style>
        :root {
            --primary-color: #2563eb;
            --text-color: #1f2937;
            --light-bg: #f9fafb;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            color: var(--text-color);
            line-height: 1.6;
        }

        .blog-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .blog-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 4rem 0;
            margin-bottom: 3rem;
        }

        .blog-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .blog-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            font-size: 0.95rem;
            opacity: 0.95;
            margin-bottom: 1rem;
        }

        .blog-meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .blog-content {
            font-size: 1.05rem;
            color: #374151;
            line-height: 1.8;
        }

        .blog-content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 2rem 0;
        }

        .blog-content h2,
        .blog-content h3 {
            margin-top: 2rem;
            margin-bottom: 1rem;
            color: var(--text-color);
            font-weight: 700;
        }

        .blog-content h2 {
            font-size: 1.75rem;
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 0.5rem;
        }

        .blog-content h3 {
            font-size: 1.35rem;
        }

        .blog-content p {
            margin-bottom: 1.25rem;
        }

        .blog-content ul,
        .blog-content ol {
            margin-bottom: 1.25rem;
            padding-left: 2rem;
        }

        .blog-content li {
            margin-bottom: 0.5rem;
        }

        .blog-content blockquote {
            border-left: 4px solid var(--primary-color);
            padding-left: 1.5rem;
            margin: 1.5rem 0;
            font-style: italic;
            color: #6b7280;
        }

        .blog-content code {
            background-color: var(--light-bg);
            padding: 0.2rem 0.5rem;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            color: #dc2626;
        }

        .blog-content pre {
            background-color: #1f2937;
            color: #f3f4f6;
            padding: 1rem;
            border-radius: 8px;
            overflow-x: auto;
            margin-bottom: 1.25rem;
        }

        .blog-content pre code {
            color: #f3f4f6;
            background: none;
            padding: 0;
        }

        .blog-sidebar {
            position: sticky;
            top: 100px;
        }

        .card {
            transition: box-shadow 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #1d4ed8;
            border-color: #1d4ed8;
        }

        @media (max-width: 768px) {
            .blog-header h1 {
                font-size: 1.75rem;
            }

            .blog-meta {
                flex-direction: column;
                gap: 0.75rem;
            }

            .blog-sidebar {
                position: relative;
                top: auto;
                margin-top: 2rem;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <?= view('partials/navbar') ?>

    <!-- Blog Header -->
    <div class="blog-header">
        <div class="container-lg">
            <h1><?= esc($post['title']) ?></h1>
            <div class="blog-meta">
                <div class="blog-meta-item">
                    <span class="text-muted small">
                        <?= number_format((int) ($post['views'] ?? 0)) ?> views
                    </span>

                </div>
                <div class="blog-meta-item">
                    <span>📅</span>
                    <span><?= date('F d, Y', strtotime($post['created_at'])) ?></span>
                </div>
                <div class="blog-meta-item">
                    <span>✏️</span>
                    <span>By <?= esc($post['username']) ?></span>
                </div>
                <?php if ($post['updated_at'] !== $post['created_at']): ?>
                    <div class="blog-meta-item">
                        <span>🔄</span>
                        <span>Updated <?= date('F d, Y', strtotime($post['updated_at'])) ?></span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="py-5">
        <div class="container-lg">
            <div class="row g-4">
                <!-- Article -->
                <article class="col-lg-8">

                    <?php if (!empty($post['featured_image'])): ?>
                        <div class="mb-4">
                            <a href="<?= base_url($post['featured_image']) ?>" target="_blank" rel="noopener">
                                <img src="<?= base_url($post['featured_image']) ?>" alt="<?= esc($post['title']) ?>"
                                    class="img-fluid rounded" loading="lazy">
                            </a>
                        </div>
                    <?php endif; ?>


                    <!-- Content -->
                    <div class="blog-content mb-5">
                        <?= $post['content'] ?>
                    </div>



                    <!-- Tags -->
                    <?php if (isset($post['tags']) && $post['tags']): ?>
                        <div class="mb-5">
                            <h3 class="mb-3">Tags</h3>
                            <div class="d-flex flex-wrap gap-2">
                                <?php
                                $tagItems = is_object($post['tags']) ? iterator_to_array($post['tags']->items()) : (is_array($post['tags']) ? $post['tags'] : []);
                                foreach ($tagItems as $tag):
                                    $tagSlug = $tag->slug ?? (isset($tag['slug']) ? $tag['slug'] : str_replace(' ', '-', strtolower($tag->name ?? $tag['name'] ?? $tag)));
                                    ?>
                                    <a href="<?= url_to('blog_tag', $tagSlug) ?>"
                                        class="badge bg-light text-dark border text-decoration-none">
                                        <?= esc($tag->name ?? $tag['name'] ?? $tag) ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>



                    <!-- Author Info -->
                    <div class="card border-0 bg-light p-4 mb-5">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 60px; height: 60px; font-weight: bold;">
                                    <?= strtoupper(substr($post['username'], 0, 1)) ?>
                                </div>
                            </div>
                            <div class="col">
                                <h5 class="mb-1"><?= esc($post['username']) ?></h5>
                                <p class="text-muted mb-0"><?= esc($authorBio) ?></p>

                            </div>
                        </div>
                    </div>


                </article>

                <!-- Sidebar -->
                <div class="col-lg-4 blog-sidebar">
                    <?= view('partials/sidebar') ?>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <?= view('partials/footer') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js"></script>
</body>

</html>