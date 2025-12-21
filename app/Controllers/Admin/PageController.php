<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PageModel;

class PageController extends BaseController
{
    protected $pageModel;

    public function __construct()
    {
        $this->pageModel = new PageModel();
    }

    public function index()
    {
        $pages = $this->pageModel->orderBy('updated_at', 'DESC')->findAll();

        return view('admin/pages/index', ['pages' => $pages]);
    }

    public function create()
    {
        return view('admin/pages/create', ['validation' => service('validation')]);
    }

    public function store()
    {
        helper(['form']);

        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'slug' => 'required|alpha_dash|min_length[2]|max_length[255]|is_unique[pages.slug]',
            'meta_description' => 'permit_empty|max_length[255]',
            'content' => 'required|min_length[10]',
            'status' => 'required|in_list[draft,published]',
        ];

        $data = [
            'title' => (string) $this->request->getPost('title'),
            'slug' => (string) $this->request->getPost('slug'),
            'meta_description' => (string) $this->request->getPost('meta_description'),
            'content' => (string) $this->request->getPost('content'),
            'status' => (string) $this->request->getPost('status'),
        ];

        if (!$this->validateData($data, $rules)) {
            return view('admin/pages/create', [
                'validation' => $this->validator,
            ]);
        }

        $this->pageModel->insert($data);

        return redirect()->to('/admin/pages')->with('berhasil', 'Page created.');
    }

    public function edit(int $id)
    {
        $page = $this->pageModel->find($id);
        if (!$page) {
            return redirect()->to('/admin/pages')->with('errors', ['Page not found.']);
        }

        return view('admin/pages/edit', [
            'page' => $page,
            'validation' => service('validation'),
        ]);
    }

    public function update(int $id)
    {
        helper(['form']);

        $page = $this->pageModel->find($id);
        if (!$page) {
            return redirect()->to('/admin/pages')->with('errors', ['Page not found.']);
        }

        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'slug' => "required|alpha_dash|min_length[2]|max_length[255]|is_unique[pages.slug,id,{$id}]",
            'meta_description' => 'permit_empty|max_length[255]',
            'content' => 'required|min_length[10]',
            'status' => 'required|in_list[draft,published]',
        ];

        $data = [
            'title' => (string) $this->request->getPost('title'),
            'slug' => (string) $this->request->getPost('slug'),
            'meta_description' => (string) $this->request->getPost('meta_description'),
            'content' => (string) $this->request->getPost('content'),
            'status' => (string) $this->request->getPost('status'),
        ];

        if (!$this->validateData($data, $rules)) {
            return view('admin/pages/edit', [
                'page' => $page,
                'validation' => $this->validator,
            ]);
        }

        $this->pageModel->update($id, $data);

        return redirect()->to('/admin/pages')->with('berhasil', 'Page updated.');
    }

    public function delete(int $id)
    {
        $page = $this->pageModel->find($id);
        if (!$page) {
            return redirect()->to('/admin/pages')->with('gagal', ['Page not found.']);
        }

        $this->pageModel->delete($id);

        return redirect()->to('/admin/pages')->with('berhasil', 'Page deleted.');
    }
}
