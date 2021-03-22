<?php

namespace App\Repositories;

use App\Actions\Fortify\PasswordValidationRules;
use App\Actions\Jetstream\DeleteUser;
use App\Models\User;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use Illuminate\Support\Facades\Validator;

/**
 * Class UserRepository.
 */
class UserRepository extends BaseRepository
{
    use PasswordValidationRules;

    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return User::class;
    }

    public function changePassword($request, $id)
    {
        $data = $request->all();
        $user = $this->model->find($id);

        Validator::make($data, [
            'password' => $this->passwordRules(),
        ])->validateWithBag('savePassword');

        $user->password = $data['password'];

        return $user->update();
    }

    public function updateUser($request, $id)
    {
        $data = $request->all();
        $user = $this->model->find($id);
        Validator::make($data, [
            'name' => ['required', 'string', 'min:4', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'photo' => ['nullable', 'image', 'max:1024'],
        ])->validateWithBag('saveUpdate');

        $user->name = $data['name'];
        $user->email = $data['email'];
        $updated = $user->update();

        if (isset($data['photo'])) {
            $user->updateProfilePhoto($data['photo']);
        }

        return $updated;
    }

    public function createUser($request)
    {
        $data = $request->all();
        Validator::make($data, [
            'name' => ['required', 'string', 'min:4', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'password' => $this->passwordRules(),
            'photo' => ['nullable', 'image', 'max:1024'],
        ])->validateWithBag('saveUser');

        $user = $this->model->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        if (isset($data['photo'])) {
            $user->updateProfilePhoto($data['photo']);
        }

        return $user;
    }

    public function deleteUser($id, $soft = true)
    {
        $jetstreamUserDelete = resolve(DeleteUser::class);
        $user = $this->model->find($id);
        if (!$soft) {
            $jetstreamUserDelete->destory($user);
        }

        return $jetstreamUserDelete->delete($user);;
    }
}
