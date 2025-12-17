<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;

class UserManagement extends Component
{
    use WithPagination;

    public $user_id, $name, $email, $password, $role = 'customer';
    public $search = '';
    public $modal = false;
    public $resetPasswordModal = false;

    protected $rules = [
        'name'  => 'required|min:3',
        'email' => 'required|email',
        'role'  => 'required|in:admin,customer',
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $users = User::where(function ($query) {
                        $query->where('name', 'like', "%{$this->search}%")
                              ->orWhere('email', 'like', "%{$this->search}%");
                    })
                    ->orderBy('id', 'DESC')
                    ->paginate(10);

        return view('livewire.admin.user-management', compact('users'))
                ->layout('layouts.app');
    }

    public function openModal()
    {
        $this->modal = true;
    }

    public function closeModal()
    {
        $this->modal = false;
        $this->resetFields();
    }

    public function resetFields()
    {
        $this->user_id = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = 'customer';
    }

    public function createUser()
    {
        $this->resetFields();
        $this->openModal();
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);

        $this->user_id = $user->id;
        $this->name     = $user->name;
        $this->email    = $user->email;
        $this->role     = $user->role;

        $this->openModal();
    }

    public function saveUser()
    {
        $this->validate();

        if ($this->user_id) {
            $user = User::find($this->user_id);
            $data = [
                'name'  => $this->name,
                'email' => $this->email,
                'role'  => $this->role,
            ];

            if (!empty($this->password)) {
                $data['password'] = Hash::make($this->password);
            }

            $user->update($data);

        } else {
            $this->validate([
                'password' => 'required|min:6',
            ]);

            User::create([
                'name'     => $this->name,
                'email'    => $this->email,
                'password' => Hash::make($this->password),
                'role'     => $this->role,
            ]);
        }

        session()->flash('message', 'User berhasil disimpan.');
        $this->closeModal();
    }

    public function openResetPasswordModal($id)
    {
        $this->user_id = $id;
        $this->password = '';
        $this->resetPasswordModal = true;
    }

    public function closeResetPasswordModal()
    {
        $this->resetPasswordModal = false;
        $this->password = '';
    }

    public function saveResetPassword()
    {
        $this->validate([
            'password' => 'required|min:6'
        ]);

        User::find($this->user_id)->update([
            'password' => Hash::make($this->password),
        ]);

        $this->resetPasswordModal = false;

        session()->flash('message', 'Password berhasil direset.');
    }

    public function deleteUser($id)
    {
        User::find($id)->delete();
        session()->flash('message', 'User berhasil dihapus.');
    }
}
