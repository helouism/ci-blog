<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= esc($page['title']) ?></title>
    <?php if (!empty($page['meta_description'])): ?>
        <meta name="description" content="<?= esc($page['meta_description']) ?>">
    <?php endif; ?>

    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta property="og:title" content="<?= esc($page['title']) ?>">
    <meta property="og:description" content="<?= esc($page['meta_description'] ?? '') ?>">
    <meta property="og:type" content="article">
    <meta property="og:url" content="<?= current_url() ?>">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="<?= esc($page['title']) ?>">
    <meta name="twitter:description" content="<?= esc($page['meta_description'] ?? '') ?>">

    <link rel="canonical" href="<?= current_url() ?>">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.13.1/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary-color: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary-color: #667eea;
            --text-color: #1f2937;
            --light-bg: #f9fafb;
            --border-color: #e5e7eb;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            color: var(--text-color);
            line-height: 1.6;
            background: #fff;
        }

        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 3.5rem 0;
            margin-bottom: 2rem;
        }

        .page-header h1 {
            font-size: 2.25rem;
            font-weight: 700;
            margin: 0;
        }

        .page-content {
            font-size: 1.05rem;
        }

        .page-content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .page-content a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .page-content a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <?= view('partials/navbar') ?>

    <!-- Header -->
    <header class="page-header">
        <div class="container-lg">
            <h1><?= esc($page['title']) ?></h1>
            <?php if (!empty($page['meta_description'])): ?>
                <p class="mb-0 mt-2 opacity-75"><?= esc($page['meta_description']) ?></p>
            <?php endif; ?>
        </div>
    </header>

    <main class="py-4">
        <div class="container-lg">
            <div class="card shadow-sm">
                <div class="card-body page-content">
                    <?= $page['content'] ?>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <?= view('partials/footer') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>