<?php

namespace App\Controllers\Admin;

use App\Models\PostModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Dashboard extends BaseController
{
    protected $postModel;

    public function __construct()
    {
        $this->postModel = new PostModel();

    }

    public function index()
    {
        $user = auth()->user();
        if ($user->isNotActivated()) {
            return redirect()->to('/');
        }
        $data = [
            "title" => "Posts",
            "posts" => $this->postModel->getPostFromUserId($user->id)->paginate(10, "post"),
            "post_count" => $this->postModel->getPostFromUserId($user->id)->countAllResults(),
        ];

        return view("admin/dashboard", $data);
    }
}