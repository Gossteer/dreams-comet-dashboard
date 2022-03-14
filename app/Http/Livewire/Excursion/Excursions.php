<?php

namespace App\Http\Livewire\Excursion;

use App\Models\Excursion;
use App\Models\UserData;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

// TODO:: когда будут добавлены учётные записи Users необходимо отрефакторить удаление и другие места
class Excursions extends Component
{
    public Collection $excursions, $allUserDatas, $userDatas;
    public bool $displayUserAdd = false, $showUserDatas = false;
    public ?string $showSuccesNotification, $showErrorNotification;
    public string $searchUser = '';
    public int $selectExcursionsId;

    // protected $rules = [
    //     'userData.name' => 'required|max:40|min:3',
    //     'userData.surname' => 'required|max:40|min:3',
    //     'userData.patronymic' => 'nullable|max:40|min:3',
    //     'userData.phone' => 'required|min:11|max:11',
    //     'userData.about' => 'nullable',
    //     'userData.birthday' => 'nullable|date',
    //     'userData.location' => 'nullable',
    //     'userData.sex' => 'required|integer',
    //     'userData.type' => 'required|integer',
    // ];

    public function getExcursions(bool $needUpdated = false): Collection
    {
        return $needUpdated ? $this->excursions ??= Excursion::with('userDatas')->get() : $this->excursions = Excursion::with('userDatas')->get();
    }

    public function showUserDatas(int $excursionsId)
    {
        $this->selectExcursionsId = $excursionsId;
        $this->getUserDatasByExcursion();

        $this->showUserDatas = !$this->showUserDatas;
    }

    public function getUserDatasByExcursion(?int $id = null)
    {
        $this->userDatas = $this->excursions->find($this->selectExcursionsId)->userDatas;

        if ($id) {
            return $this->userDatas->find($id);
        }
    }

    public function attachUserData(int $phoneUserData)
    {
        $this->excursions->find($this->selectExcursionsId)->userDatas()->attach($phoneUserData);

        $this->getExcursions(true);
    }

    public function detachUserData(int $phoneUserData)
    {
        $this->excursions->find($this->selectExcursionsId)->userDatas()->detach($phoneUserData);

        $this->getExcursions(true);
    }

    public function completeUserUpdate(int $phoneUserData, bool $complete)
    {
        $userData = $this->getUserDatasByExcursion($phoneUserData);
        $userData->pivot->paid = $complete;
        // dd($userData);
        $userData->pivot->save();
        // dd($userData->save(), $complete, $userData);
    }

    public function getUserDatas(bool $need)
    {
        if ($need) {
            $this->getUserDatasByExcursion();

            if ($this->searchUser) {
                return ($this->allUserDatas = UserData::search($this->searchUser)->get()->diff(
                    $this->excursions
                        ->pluck('userDatas')
                        ->collapse()
                ));
            }
        }
    }

    // /**
    //  * Отображение формы работы с UserData
    //  */
    // public function setDisplay(?bool $display = null): void
    // {
    //     $this->displayUserAdd = $display ?? !$this->displayUserAdd;
    // }

    public function addUserData(): void
    {
        $this->excursions->find(1)->hisdden  = 'hlen';
        // $this->setDisplay();
        $this->render();
    }

    // public function updateUserData(int $phone)
    // {
    //     $this->userData = $this->usersData->find($phone);

    //     $this->setDisplay(true);
    // }

    // public function deleteUserData(int $phone): void
    // {
    //     $this->usersData->find($phone)->delete();

    //     $this->setDisplay(false);
    // }

    // public function saveUserData(): void
    // {
    //     $this->validate();

    //     try {
    //         $this->scheckPhoneUser()->save();

    //         $this->showSuccesNotification = 'Успешно сохранено';
    //     } catch (\Throwable $th) {
    //         $this->showErrorNotification = $th->getMessage();
    //     }
    // }

    // /**
    //  * Проверка на то, что телефон уже ранее у нас существовал и был удалён
    //  */
    // private function scheckPhoneUser()
    // {
    //     if (($userData = UserData::onlyTrashed()->find($this->userData->phone)) !== null) {
    //         return $userData->fill(array_merge($this->userData->toArray(), ['deleted_at' => null]));
    //     }

    //     return $this->userData;
    // }

    public function render()
    {
        return view('livewire.excursion', [
            'excursions' => $this->getExcursions(),
            'allUserDatas' => $this->getUserDatas($this->showUserDatas)
        ]);
    }
}
