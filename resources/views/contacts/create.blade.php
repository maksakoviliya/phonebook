@extends('layouts.admin')

@section('content')

<div class="container-fluid">
    <form action="{{ route('contacts.store', $phonebookId) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="phonebook_id" value="{{$phonebookId}}">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Добавить контакт</h4>
                        <p class="card-category">Добавление контакта в справочник организации "{{ $phonebookTitle }}"
                        </p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group @error('last_name') has-danger @enderror">
                                    <label class="bmd-label-floating">Фамилия *</label>
                                    <input type="text" class="form-control" name="last_name"
                                        value="{{ old('last_name') }}">
                                    @error('last_name')
                                    <label id="last_name-error" class="error"
                                        for="last_name-error">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group @error('first_name') has-danger @enderror">
                                    <label class="bmd-label-floating">Имя *</label>
                                    <input type="text" class="form-control" name="first_name"
                                        value="{{ old('first_name') }}">
                                    @error('first_name')
                                    <label id="first_name-error" class="error"
                                        for="first_name-error">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group @error('patronymic') has-danger @enderror">
                                    <label class="bmd-label-floating">Отчество</label>
                                    <input type="text" class="form-control" name="patronymic"
                                        value="{{ old('patronymic') }}">
                                    @error('patronymic')
                                    <label id="patronymic-error" class="error"
                                        for="patronymic-error">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group @error('position') has-danger @enderror">
                                    <label class="bmd-label-floating">Должность</label>
                                    <input type="text" class="form-control" name="position"
                                        value="{{ old('position') }}">
                                    @error('position')
                                    <label id="position-error" class="error" for="position-error">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group @error('email') has-danger @enderror">
                                    <label class="bmd-label-floating">Email</label>
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                    @error('email')
                                    <label id="email-error" class="error" for="email-error">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-lg-3">
                                <div class="form-group @error('phone1') has-danger @enderror">
                                    <label class="bmd-label-floating">Телефон 1</label>
                                    <input type="text" class="form-control" name="phone1" value="{{ old('phone1') }}">
                                    @error('phone1')
                                    <label id="phone1-error" class="error" for="phone1-error">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="form-group @error('phone2') has-danger @enderror">
                                    <label class="bmd-label-floating">Телефон 2</label>
                                    <input type="text" class="form-control" name="phone2" value="{{ old('phone2') }}">
                                    @error('phone2')
                                    <label id="phone2-error" class="error" for="phone2-error">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="form-group @error('phone3') has-danger @enderror">
                                    <label class="bmd-label-floating">Телефон 3</label>
                                    <input type="text" class="form-control" name="phone3" value="{{ old('phone3') }}">
                                    @error('phone3')
                                    <label id="phone3-error" class="error" for="phone3-error">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="form-group @error('fax') has-danger @enderror">
                                    <label class="bmd-label-floating">Факс</label>
                                    <input type="text" class="form-control" name="fax" value="{{ old('fax') }}">
                                    @error('fax')
                                    <label id="fax-error" class="error" for="fax-error">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-lg-3">
                                <div class="form-group @error('birthday') has-danger @enderror">
                                    <label class="bmd-label-floating">День рождения</label>
                                    <input type="text" class="form-control" name="birthday"
                                        value="{{ old('birthday') }}">
                                    @error('birthday')
                                    <label id="birthday-error" class="error" for="birthday-error">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success pull-right">Добавить</button>
                        <a href="{{ url()->previous() }}" class="btn btn-outline-light">Назад</a>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-stats">
                    <div class="card-header card-header-success card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">contact_phone</i>
                        </div>
                        <h3 class="card-title">Фото</h3>
                    </div>
                    <div class="card-body text-left">
                        <avatar-input />
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection