@extends('layouts.admin')

@section('content')

<div class="container-fluid">
    <form action="{{ route('contacts.update', ['phonebookId'=>$contact->phonebook_id, 'id'=>$contact->id]) }}"
        method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <input type="hidden" name="phonebook_id" value="{{$contact->phonebook_id}}">
        <div class="row">
            @if($errors->any())
            {!! implode('', $errors->all('<div>:message</div>')) !!}
            @endif
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title mb-0">Изменить контакт</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group @error('last_name') has-danger @enderror">
                                    <label class="bmd-label-floating">Фамилия *</label>
                                    <input type="text" class="form-control" name="last_name"
                                        value="{{ $contact->last_name }}">
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
                                        value="{{ $contact->first_name }}">
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
                                        value="{{ $contact->patronymic }}">
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
                                        value="{{ $contact->position }}">
                                    @error('position')
                                    <label id="position-error" class="error" for="position-error">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group @error('email') has-danger @enderror">
                                    <label class="bmd-label-floating">Email</label>
                                    <input type="email" class="form-control" name="email" value="{{ $contact->email }}">
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
                                    <input type="text" class="form-control" name="phone1"
                                        value="{{ $contact->phone1 }}">
                                    @error('phone1')
                                    <label id="phone1-error" class="error" for="phone1-error">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="form-group @error('phone2') has-danger @enderror">
                                    <label class="bmd-label-floating">Телефон 2</label>
                                    <input type="text" class="form-control" name="phone2"
                                        value="{{ $contact->phone2 }}">
                                    @error('phone2')
                                    <label id="phone2-error" class="error" for="phone2-error">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="form-group @error('phone3') has-danger @enderror">
                                    <label class="bmd-label-floating">Телефон 3</label>
                                    <input type="text" class="form-control" name="phone3"
                                        value="{{ $contact->phone3 }}">
                                    @error('phone3')
                                    <label id="phone3-error" class="error" for="phone3-error">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="form-group @error('fax') has-danger @enderror">
                                    <label class="bmd-label-floating">Факс</label>
                                    <input type="text" class="form-control" name="fax" value="{{ $contact->fax }}">
                                    @error('fax')
                                    <label id="fax-error" class="error" for="fax-error">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group @error('birthday') has-danger @enderror">
                                    <label class="bmd-label-floating">День рождения</label>
                                    <input type="text" class="form-control" name="birthday"
                                        value="{{ $contact->birthday }}">
                                    @error('birthday')
                                    <label id="birthday-error" class="error" for="birthday-error">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <button type="submit" class="btn btn-success pull-right">Изменить</button>
                                <a href="{{ route('phonebooks.contacts', $contact->phonebook_id) }}"
                                    class="btn btn-outline-light">Отменить</a>
                            </div>
                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                data-target="#deleteContact"><i class="material-icons">delete</i> Удалить</button>
                        </div>
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
                        <avatar-input photo="{{ $contact->photo }}" />
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="deleteContact" tabindex="-1" role="dialog" aria-labelledby="deletePhoneBookLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletePhoneBookLabel" class="text-danger">Удалить контакт</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Контакт будет удален навсегда!
            </div>
            <div class="modal-footer">
                <form action="{{ route('contacts.destroy', [$contact->phonebook_id, $contact->id]) }}" class="mb-0"
                    method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
                    <button type="submit" class="btn btn-danger">Удалить</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection