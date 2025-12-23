<?php

namespace App\Controllers\Admin;

use App\Models\PostModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class PostController extends BaseController
{
    protected $postModel;

    public function __construct()
    {
        $this->postModel = new PostModel();

    }

    public function index()
    {
        $pager = service("pager");
        $user = auth()->user();

        $data = [
            "title" => "Posts",
            "posts" => $this->postModel->getPostFromUserId($user->id)->paginate(10, "post"),
            "pager" => $this->postModel->pager,
        ];

        return view("admin/posts/index", $data);
    }

    public function create()
    {

        helper('form');
        $user = auth()->user();
        $data = [
            "title" => "Create New Post",
            "user" => $user,
        ];

        return view("admin/posts/create", $data);
    }

    public function store()
    {
        helper('form');
        $user = auth()->user();

        $rules = [
            "slug" => "required|is_unique[posts.slug]|min_length[3]|max_length[255]|alpha_dash",
            "title" => "required|min_length[3]|max_length[255]",
            "meta_description" => "required|min_length[10]|max_length[255]",
            "content" => "required|min_length[10]",
            "tags" => "permit_empty|max_length[500]",
            "featured_image_token" => "permit_empty|regex_match[/^[a-f0-9]{32}$/]",
            "status" => "required|in_list[draft,published]",
        ];

        $data = [
            "title" => $this->request->getPost("title"),
            "content" => $this->request->getPost("content"),
            "slug" => $this->request->getPost("slug"),
            "meta_description" => $this->request->getPost("meta_description"),
            "user_id" => $user->id,
            "tags" => $this->request->getPost("tags"),
            "status" => $this->request->getPost("status"),
        ];

        if (
            !$this->validateData(array_merge($data, [
                'featured_image_token' => $this->request->getPost('featured_image_token')
            ]), $rules)
        ) {
            return view('admin/posts/create', ['validation' => $this->validator]);
        }

        // Insert and get ID
        $postId = $this->postModel->insert($data);

        // Finalize image if present
        $token = (string) $this->request->getPost('featured_image_token');
        if ($token) {
            $path = $this->finalizeFeaturedImage($token, (int) $postId);
            if ($path) {
                $this->postModel->update($postId, ['featured_image' => $path]);
            }
        }

        return redirect()->to("/admin/posts")->with('berhasil', 'Berhasil menambahkan post baru.');
    }


    public function edit($id)
    {
        helper('form');
        $user = auth()->user();

        $post = $this->postModel->withTags()->find($id);

        if (!$post) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                "Post not found",
            );
        }

        $data = [
            "title" => "Edit Post",
            "post" => $post,
            "user" => $user,
        ];

        return view("admin/posts/edit", $data);
    }

    public function update($id)
    {
        helper('form');

        $post = $this->postModel->find($id);
        if (!$post) {
            return redirect()->to('/admin/posts')->with('gagal', 'Post not found.');
        }

        $rules = [
            "slug" => "required|min_length[3]|max_length[255]|alpha_dash|is_unique[posts.slug,id,{$id}]",
            "title" => "required|min_length[3]|max_length[255]",
            "meta_description" => "required|min_length[10]|max_length[255]",
            "content" => "required|min_length[10]",
            "tags" => "permit_empty|max_length[500]",
            "featured_image_token" => "permit_empty|regex_match[/^[a-f0-9]{32}$/]",
            "status" => "required|in_list[draft,published]"
        ];

        $data = [
            "id" => $id,
            "title" => (string) $this->request->getPost("title"),
            "content" => (string) $this->request->getPost("content"),
            "slug" => (string) $this->request->getPost("slug"),
            "meta_description" => (string) $this->request->getPost("meta_description"),
            "tags" => (string) $this->request->getPost("tags"),
            "status" => (string) $this->request->getPost("status"),
        ];

        $token = (string) $this->request->getPost('featured_image_token');

        if (!$this->validateData(array_merge($data, ['featured_image_token' => $token]), $rules)) {
            return view('admin/posts/edit', [
                'validation' => $this->validator,
                'post' => $post,
            ]);
        }

        // If a new image was uploaded, finalize it and merge it into $data BEFORE updating.
        if ($token) {
            $this->deleteFeaturedImageIfExists($post);

            $path = $this->finalizeFeaturedImage($token, (int) $id);
            if ($path) {
                $data['featured_image'] = $path;
            }
        }


        $this->postModel->save($data);

        return redirect()->to('/admin/posts')->with('berhasil', 'Post updated.');
    }


    public function delete($id)
    {
        $user = auth()->user();

        $this->postModel->delete($id);

        return redirect()->to("/admin/posts")->with('berhasil', 'Berhasil menghapus post.');
    }



    public function processImage()
    {
        // FilePond sends the file using the input name attribute.
        $file = $this->request->getFile('featured_image');

        if (!$file || !$file->isValid()) {
            return $this->response->setStatusCode(400)->setBody('Invalid upload');
        }

        // Validate type + size (adjust)
        $allowed = ['image/jpg', 'image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($file->getMimeType(), $allowed, true)) {
            return $this->response->setStatusCode(415)->setBody('Unsupported type');
        }

        if ($file->getSizeByUnit('mb') > 3) {
            return $this->response->setStatusCode(413)->setBody('Too large');
        }

        $tmpDir = WRITEPATH . 'uploads/tmp';
        if (!is_dir($tmpDir)) {
            mkdir($tmpDir, 0755, true);
        }

        // Create opaque server id (token) and store as token.ext
        $token = bin2hex(random_bytes(16));
        $ext = $file->getClientExtension() ?: 'jpg';
        $name = $token . '.' . $ext;

        $file->move($tmpDir, $name, true);

        // Return token as text/plain (what FilePond expects) :contentReference[oaicite:1]{index=1}
        return $this->response
            ->setHeader('Content-Type', 'text/plain')
            ->setBody($token);
    }

    public function revertImage()
    {
        $token = trim((string) $this->request->getPost('token'));

        if ($token === '' || !preg_match('/^[a-f0-9]{32}$/', $token)) {
            return $this->response->setStatusCode(400)->setBody('Bad token');
        }

        $tmpDir = WRITEPATH . 'uploads/tmp';
        $matches = glob($tmpDir . DIRECTORY_SEPARATOR . $token . '.*');

        if ($matches) {
            foreach ($matches as $path) {
                @unlink($path);
            }
        }

        return $this->response->setStatusCode(200)->setBody('OK');
    }


    /**
     * Move temp file (token.*) to permanent location and return relative path.
     */
    private function finalizeFeaturedImage(string $token, int $postId): ?string
    {
        if ($token === '' || !preg_match('/^[a-f0-9]{32}$/', $token)) {
            return null;
        }

        $tmpDir = WRITEPATH . 'uploads/tmp';
        $matches = glob($tmpDir . DIRECTORY_SEPARATOR . $token . '.*');

        if (!$matches) {
            return null;
        }

        $tmpPath = $matches[0];

        $destDir = FCPATH . 'uploads/posts/' . $postId;
        if (!is_dir($destDir)) {
            mkdir($destDir, 0755, true);
        }

        $destPath = $destDir . DIRECTORY_SEPARATOR . 'featured.webp';

        try {
            $image = service('image')
                ->withFile($tmpPath)
                ->convert(IMAGETYPE_WEBP)
                ->save($destPath, 80); // quality: 0–100 (80 is sane)

        } catch (\Throwable $e) {
            log_message('error', 'Image conversion failed: ' . $e->getMessage());
            return null;
        }

        // Delete temp file no matter what
        @unlink($tmpPath);

        // Return relative public path
        return 'uploads/posts/' . $postId . '/featured.webp';
    }

    private function deleteFeaturedImageIfExists($post): void
    {
        $path = $post['featured_image'] ?? null;
        if (!$path)
            return;

        $full = FCPATH . ltrim($path, '/');
        if (is_file($full)) {
            @unlink($full);
        }
    }

}
