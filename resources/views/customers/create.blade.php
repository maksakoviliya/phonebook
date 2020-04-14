@extends('layouts.admin')

@section('content')

<div class="container-fluid">
  <form action="{{ route('customers.store') }}" method="POST">
  @csrf

  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header card-header-primary">
          <h4 class="card-title">Добавить заказчика</h4>
          <p class="card-category">Добавление заказчика</p>
        </div>
        <div class="card-body">
            <div class="row">
              <div class="col">
                <div class="form-group @error('name') has-danger @enderror">
                  <label class="bmd-label-floating">Фамилия Имя Отчество *</label>
                  <input type="text" class="form-control" name="name" value="{{ old('name') }}">
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
                  <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
                  @error('phone')
                    <label id="phone-error" class="error" for="phone-error">{{ $message }}</label>
                  @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                  <div class="form-group @error('description') has-danger @enderror">
                    <label class="bmd-label-floating">Описание</label>
                    <textarea class="form-control" rows="5" name="description">{{ old('description') }}</textarea>
                    @error('description')
                      <label id="description-error" class="error" for="description-error">{{ $message }}</label>
                    @enderror
                  </div>
              </div>
            </div>
            <button type="submit" class="btn btn-success pull-right">Добавить</button>
            <a href="{{ route('customers.index') }}" class="btn btn-outline-light">Отменить</a>
            <div class="clearfix"></div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card card-stats">
        <div class="card-header card-header-info card-header-icon">
          <div class="card-icon">
            <i class="material-icons">attach_file</i>
          </div>
          <h3 class="card-title">Ссылка на файлы</h3>
        </div>
        <div class="card-body text-left">
            <div class="form-group @error('files_link') has-danger @enderror">
              <label class="bmd-label-floating">Ссылка на файлы</label>
              <input type="text" class="form-control" name="files_link" value="{{ old('files_link') }}">
              @error('files_link')
                <label id="files_link-error" class="error" for="files_link-error">{{ $message }}</label>
              @enderror
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
</div>

@endsection