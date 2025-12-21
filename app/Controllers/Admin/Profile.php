<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\EmailChangeRequestModel;

use CodeIgniter\HTTP\ResponseInterface;
class Profile extends BaseController
{
    protected $currentUser;
    protected $userProvider;
    protected $emailChangeRequestModel;

    public function __construct()
    {
        $this->currentUser = auth()->user();
        $this->userProvider = auth()->getProvider();
        $this->emailChangeRequestModel = new EmailChangeRequestModel();

    }

    public function index()
    {
        $data = [
            'user' => $this->currentUser,
            'title' => 'Admin Profile - TheGoodOne',
        ];

        return view('admin/profile/index', $data);
    }

    public function changeUsername()
    {
        $data = [
            'user' => $this->currentUser,
            'title' => 'Change Username - TheGoodOne',
        ];
        return view('admin/profile/change_username', $data);
    }

    public function updateUsername()
    {
        helper('form');

        if (
            !$this->validate([
                'username' => 'required|alpha_numeric|min_length[3]|max_length[30]|is_unique[users.username,id,' . $this->currentUser->id . ']',
            ])
        ) {
            return redirect()->back()->withInput()->with('gagal', $this->validator->getErrors());
        }

        $newUsername = $this->request->getPost('username');

        $this->currentUser->fill(['username' => $newUsername]);

        $this->userProvider->save($this->currentUser);
        return redirect()->to('/admin/profile')->with('berhasil', 'Username updated successfully.');


    }

    public function updateBio()
    {
        helper('form');

        $rules = [
            'bio' => 'permit_empty|max_length[500]',
        ];

        if (!$this->validate($rules)) {
            // Your profile/index view already pops Swal from flashdata('errors') :contentReference[oaicite:3]{index=3}
            return redirect()
                ->to('/admin/profile')
                ->with('gagal', $this->validator->getErrors())
                ->withInput();
        }

        $bio = trim((string) $this->request->getPost('bio'));

        // Save
        $this->currentUser->fill(['bio' => $bio]);
        $this->userProvider->save($this->currentUser);

        // Your profile/index view listens to flashdata('success') :contentReference[oaicite:4]{index=4}
        return redirect()
            ->to('/admin/profile')
            ->with('berhasil', 'Bio updated.');
    }



    public function changeEmail()
    {
        $data = [
            'user' => $this->currentUser,
            'title' => 'Change Email - TheGoodOne',
        ];
        return view('admin/profile/change_email', $data);
    }

    public function updateEmail()
    {
        helper(['form']);

        $rules = [
            'email' => 'required|valid_email|max_length[255]',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $newEmail = strtolower(trim($this->request->getPost('email')));
        $password = (string) $this->request->getPost('password');

        // 1) confirm password (session hijack protection)
        $result = auth()->check(['email' => $this->currentUser->email, 'password' => $password]);
        if (!$result->isOK()) {
            return redirect()->back()->withInput()->with('gagal', 'Password lu salah blok.');
        }

        // 2) don’t allow same email
        if ($newEmail === strtolower($this->currentUser->email)) {
            return redirect()->back()->with('gagal', 'Itu email elu skrg blok.');
        }

        // 3) ensure email unique (use provider lookup)
        $existing = $this->userProvider->findByCredentials(['email' => $newEmail]);
        if ($existing !== null) {
            return redirect()->back()->withInput()->with('gagal', 'email udh dipake cuk.');
        }

        // 4) create token + store hash
        $rawToken = bin2hex(random_bytes(32));
        $tokenHash = hash('sha256', $rawToken);

        $expiresAt = date('Y-m-d H:i:s', time() + 15 * 60);

        // TODO: save in email_change_requests (upsert per user)
        $this->emailChangeRequestModel->upsertRequest(
            $this->currentUser->id,
            $newEmail,
            $tokenHash,
            $expiresAt,
            $this->request->getIPAddress(),
            substr((string) $this->request->getUserAgent(), 0, 255)
        );

        // 5) email new address verification link
        $verifyUrl = url_to('admin_profile_verify_email_change') . '?token=' . $rawToken;

        service('email')
            ->setTo($newEmail)
            ->setSubject('Confirm your new email')
            ->setMessage("Click to confirm your new email: {$verifyUrl}\n\nThis link expires in 15 minutes.")
            ->send();

        // Optional: notify old email
        // service('email')->setTo($this->currentUser->email)->setSubject(...)->send();

        return redirect()->to('/admin/profile')->with('berhasil', 'Verification link sent to the new email.');
    }

    public function verifyEmailChange()
    {
        $rawToken = (string) $this->request->getGet('token');
        if ($rawToken === '') {
            return redirect()->to('/admin/profile')->with('gagal', 'Missing token.');
        }

        $tokenHash = hash('sha256', $rawToken);


        $req = $this->emailChangeRequestModel->findValidByUserIdAndTokenHash($this->currentUser->id, $tokenHash);

        if (!$req) {
            return redirect()->to('/admin/profile')->with('gagal', 'Invalid or expired token.');
        }

        // Apply the change
        $this->currentUser->fill(['email' => $req->new_email]);
        $this->userProvider->save($this->currentUser);

        // Mark request used
        $this->emailChangeRequestModel->markUsed($req->id);


        return redirect()->to('/admin/profile')->with('berhasil', 'Email changed successfully.');


    }

    public function changePassword()
    {
        return view('admin/profile/change_password');
    }

    public function updatePassword()
    {
        helper(['form']);

        $rules = [
            'current_password' => 'required',
            'password' => 'required|min_length[8]|max_length[255]',
            'password_confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('gagal', $this->validator->getErrors());
        }

        $currentPassword = (string) $this->request->getPost('current_password');
        $newPassword = (string) $this->request->getPost('password');

        // 1) Re-authenticate (session hijack protection)
        $result = auth()->check([
            'email' => $this->currentUser->email,
            'password' => $currentPassword,
        ]);

        if (!$result->isOK()) {
            return redirect()->back()
                ->withInput()
                ->with('gagal', 'Current password is incorrect.');
        }

        // 2) Prevent password reuse (basic but effective)
        if (password_verify($newPassword, $this->currentUser->password_hash)) {
            return redirect()->back()
                ->with('gagal', 'New password cannot be the same as the current password.');
        }

        // 3) Update password via Shield entity
        $this->currentUser->setPassword($newPassword);
        auth()->getProvider()->save($this->currentUser);

        // 4) Kill all sessions (non-negotiable)
        auth()->logout();

        return redirect()->to('/login')
            ->with('berhasil', 'Password changed successfully. Please log in again.');
    }





}