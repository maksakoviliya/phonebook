@extends('layouts.admin')

@section('content')

<div class="container-fluid">
  @include('notifications.success')
  @include('notifications.error')

  <form action="{{ route('users.update', $user->id) }}" method="POST">
  @csrf
  @method('PUT')

  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header card-header-primary">
          <h4 class="card-title">{{ $user->name }}</h4>
          <p class="card-category">Изменение данных заказчика</p>
        </div>
        <div class="card-body">
            <div class="row">
              <div class="col">
                <div class="form-group @error('name') has-danger @enderror">
                  <label class="bmd-label-floating">Фамилия Имя Отчество *</label>
                  <input type="text" class="form-control" name="name" value="{{ old('_token') || old('name') ? old('name') : $user->name }}">
                  @error('name')
                    <label id="name-error" class="error" for="name-error">{{ $message }}</label>
                  @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <div class="form-group @error('phone') has-danger @enderror">
                  <label class="bmd-label-floating">Телефон</label>
                  <input type="text" class="form-control" name="phone" value="{{ old('_token') || old('phone') ? old('phone') : $user->phone }}">
                  @error('phone')
                    <label id="phone-error" class="error" for="phone-error">{{ $message }}</label>
                  @enderror
                </div>
              </div>
            </div>
            
            <div class="d-flex align-items-center justify-content-between">
              <div>
                <button type="submit" class="btn btn-success pull-right">Изменить</button>
                <a href="{{ url()->previous() }}" class="btn btn-outline-light">Отменить</a>
              </div>
              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteuser"><i class="material-icons">delete</i> Удалить</button>
            </div>
            <div class="clearfix"></div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card card-stats">
        <div class="card-header card-header-info card-header-icon">
          <div class="card-icon">
            <i class="material-icons">toll</i>
          </div>
          <h3 class="card-title">Примененные коды</h3>
        </div>
        <div class="card-body text-left">
          <p>\{\{Активные коды\}\}</p>
        </div>
      </div>
    </div>
    </div>
  </div>
</form>
</div>

<div class="modal fade" id="deleteuser" tabindex="-1" role="dialog" aria-labelledby="deleteuserLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title mt-0" id="deleteuserLabel" class="text-danger">Удалить пользователя</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Будут навсегда удалены все его данные!
      </div>
      <div class="modal-footer">
        <form action="{{ route('users.destroy', $user->id) }}" method="POST">
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