<?php

namespace App\Http\Livewire\UserManagments;

use App\Models\UserData;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

// TODO:: когда будут добавлены учётные записи Users необходимо отрефакторить удаление и другие места
class UserManagement extends Component
{
    public Collection $usersData;
    public bool $displayUserAdd = false;
    public UserData $userData;
    public ?string $showSuccesNotification;
    public ?string $showErrorNotification;

    protected $rules = [
        'userData.name' => 'required|max:40|min:3',
        'userData.surname' => 'required|max:40|min:3',
        'userData.patronymic' => 'nullable|max:40|min:3',
        'userData.phone' => 'required|min:11|max:11',
        'userData.about' => 'nullable',
        'userData.birthday' => 'nullable|date',
        'userData.location' => 'nullable',
        'userData.sex' => 'required|integer',
        'userData.type' => 'required|integer',
    ];

    public function getUsersData(): Collection
    {
        return $this->usersData = UserData::withCount('excursionsPaidCount')->get();
    }

    /**
     * Отображение формы работы с UserData
     */
    public function setDisplay(?bool $display = null): void
    {
        $this->displayUserAdd = $display ?? !$this->displayUserAdd;
    }

    public function addUserData(): void
    {
        $this->userData = new UserData();

        $this->setDisplay();
    }

    public function updateUserData(int $phone)
    {
        $this->userData = $this->usersData->find($phone);

        $this->setDisplay(true);
    }

    public function deleteUserData(int $phone): void
    {
        $this->usersData->find($phone)->delete();

        $this->setDisplay(false);
    }

    public function saveUserData(): void
    {
        $this->validate();

        try {
            $this->scheckPhoneUser()->save();

            $this->showSuccesNotification = 'Успешно сохранено';
        } catch (\Throwable $th) {
            $this->showErrorNotification = $th->getMessage();
        }
    }

    /**
     * Проверка на то, что телефон уже ранее у нас существовал и был удалён
     */
    private function scheckPhoneUser()
    {
        if (($userData = UserData::onlyTrashed()->find($this->userData->phone)) !== null) {
            return $userData->fill(array_merge($this->userData->toArray(), ['deleted_at' => null]));
        }

        return $this->userData;
    }

    public function render()
    {
        return view('livewire.user-management', [
            'usersData' => $this->getUsersData(),
            'userDataTypes' => UserData::getType(),
            'userDataSexs' => UserData::getSex(),
        ]);
    }
}
