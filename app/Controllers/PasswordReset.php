<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Exceptions\PageNotFoundException;

class PasswordReset extends BaseController
{
    protected $helpers = ['setting', 'url', 'form'];


    public function index()
    {
        // block route change-password if see befor login
        if (!auth()->loggedIn()) {
            throw PageNotFoundException::forPageNotFound();
        }

        if (auth()->user()->requiresPasswordReset()) {
            if (!$this->request->is('post')) {
                return view('change_password');
            }

            if (!$this->validate($this->getValidationRules())) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $result = auth()->check([
                'email' => auth()->user()->email,
                'password' => $this->request->getPost('old_password'),
            ]);

            if (!$result->isOK()) {
                return redirect()->to(config('Auth')->forcePasswordResetRedirect())->withInput()->with('error', 'Auth.oldPasswordWrong');
            }

            // Success!

            $users = auth()->getProvider();

            $user = auth()->user()->fill([
                'password' => $this->request->getPost('password')
            ]);

            $users->save($user);

            // Remove force password reset flag
            auth()->user()->undoForcePasswordReset();
            auth()->forget($user);
            // logout user and print login via new password
            auth()->logout();
            return redirect()->to(config('Auth')->logoutRedirect())
                ->with('message', lang('Auth.changePasswordSuccess'));

        }

        // if user login but NOT need requiresPasswordReset
        throw PageNotFoundException::forPageNotFound();

    }

    /**
     * Returns the rules that should be used for validation.
     *
     * @return array<string, array<string, array<string>|string>>
     * @phpstan-return array<string, array<string, string|list<string>>>
     */
    protected function getValidationRules(): array
    {
        return setting('Validation.changePassword') ?? [
            'password' => [
                'label' => 'Auth.password',
                'rules' => 'required|strong_password',
            ],
            'password_confirm' => [
                'label' => 'Auth.passwordConfirm',
                'rules' => 'required|matches[password]',
            ],
        ];
    }
}
