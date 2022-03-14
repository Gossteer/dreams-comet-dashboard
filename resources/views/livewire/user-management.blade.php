<div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Все клиенты</h5>
                        </div>
                        <button wire:click="addUserData()" class="btn bg-gradient-primary btn-sm mb-0"
                            type="button">Добавить</button>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Телефон
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        ФИО
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Пол
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Тип
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        День рождения
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Адрес
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Описание
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Дата создания
                                    </th>
                                    <th
                                        title="Количество совместных мероприятий"
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        КСМ
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usersData as $userData)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ $userData->phone }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ "$userData->surname $userData->name $userData->patronymic" }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $userData->sex }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $userData->type }}</p>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $userData->birthday }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="text-secondary text-xs font-weight-bold"><a target="_blank"
                                                    href="http://maps.yandex.ru/?text={{ $userData->location }}">{{ $userData->location }}</a></span>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $userData->about }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $userData->created_at }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $userData->excursions_paid_count_count }}</span>
                                        </td>
                                        <td class="text-center">
                                            <a href="#" class="mx-3" data-bs-toggle="tooltip"
                                                data-bs-original-title="Edit user">
                                                <i wire:click="updateUserData({{ $userData->phone }})"
                                                    class="fas fa-user-edit text-secondary"></i>
                                            </a>
                                            <span>
                                                <i wire:click="deleteUserData({{ $userData->phone }})"
                                                    class="cursor-pointer fas fa-trash text-secondary"></i>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-4" style="display: {{ $displayUserAdd ? '' : 'none' }}">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">Информация клиента</h6>
            </div>
            <div class="card-body pt-4 p-3">
                @if ($showSuccesNotification)
                    <div wire:model="showSuccesNotification"
                        class="mt-3 alert alert-primary alert-dismissible fade show" role="alert">
                        <span class="alert-icon text-white"><i class="ni ni-like-2"></i></span>
                        <span class="alert-text text-white">{{ $showSuccesNotification }}</span>
                        <button wire:click="$set('showSuccesNotification', null)" type="button" class="btn-close"
                            data-bs-dismiss="alert" aria-label="Close">
                        </button>
                    </div>
                @endif
                @if ($showErrorNotification)
                    <div wire:model="showSuccesNotification" class="mt-3 alert alert-danger alert-dismissible fade show"
                        role="alert">
                        <span class="alert-icon text-white"><i class="ni ni-like-2"></i></span>
                        <span class="alert-text text-white">{{ $showErrorNotification }}</span>
                        <button wire:click="$set('showErrorNotification', null)" type="button" class="btn-close"
                            data-bs-dismiss="alert" aria-label="Close">
                        </button>
                    </div>
                @endif

                <form wire:submit.prevent="saveUserData" action="#" method="POST" role="form text-left">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="userData-name" class="form-control-label">Имя</label>
                                <div class="@error('userData.name') border border-danger rounded-3 @enderror">
                                    <input wire:model="userData.name" class="form-control" type="text"
                                        placeholder="Александр" id="userData-name">
                                </div>
                                @error('userData.name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="userData-surname" class="form-control-label">Фамилия</label>
                                <div class="@error('userData.surname') border border-danger rounded-3 @enderror">
                                    <input wire:model="userData.surname" class="form-control" type="text"
                                        placeholder="Пупкин" id="userData-surname">
                                </div>
                                @error('userData.surname')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="userData-patronymic" class="form-control-label">Отчество</label>
                                <div class="@error('userData.patronymic') border border-danger rounded-3 @enderror">
                                    <input wire:model="userData.patronymic" class="form-control" type="text"
                                        placeholder="Олегович" id="userData-patronymic">
                                </div>
                                @error('userData.patronymic')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="userData-phone" class="form-control-label">Телефон</label>
                                <div class="@error('userData.phone') border border-danger rounded-3 @enderror">
                                    <input wire:model="userData.phone" class="form-control" type="tel"
                                        placeholder="79264455581" id="userData-phone">
                                </div>
                                @error('userData.phone')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="userData-location" class="form-control-label">Адрес</label>
                                <div class="@error('userData.location') border border-danger rounded-3 @enderror">
                                    <input wire:model="userData.location" class="form-control" type="text"
                                        placeholder="Location" id="userData-location">
                                </div>
                                @error('userData.location')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="userData-sex" class="form-control-label">Пол</label>
                                <div class="@error('userData.sex') border border-danger rounded-3 @enderror">
                                    <select class="form-control" wire:model="userData.sex" name="userData-sex"
                                        id="userData-sex">
                                        @foreach ($userDataSexs as $key => $userDataSex)
                                            <option value="{{ $key }}">{{ $userDataSex }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('userData.sex')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="userData-type" class="form-control-label">Тип</label>
                                <div class="@error('userData.type') border border-danger rounded-3 @enderror">
                                    <select class="form-control" wire:model="userData.type" name="userData-type"
                                        id="userData-type">
                                        @foreach ($userDataTypes as $key => $userDataType)
                                            <option value="{{ $key }}">{{ $userDataType }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('userData.type')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="userData-birthday" class="form-control-label">День рождения</label>
                                <div class="@error('userData.birthday') border border-danger rounded-3 @enderror">
                                    <input wire:model="userData.birthday" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}"
                                        class="form-control" type="date" id="userData-birthday">
                                </div>
                                @error('userData.birthday')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="userData-about">Описание</label>
                        <div class="@error('userData.about') border border-danger rounded-3 @enderror">
                            <textarea wire:model="userData.about" class="form-control" id="userData-about" rows="3"
                                placeholder="Расскажите о клиенте"></textarea>
                        </div>
                        @error('userData.about')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">Сохранить</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
