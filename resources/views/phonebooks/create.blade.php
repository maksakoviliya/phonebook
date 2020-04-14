@extends('layouts.admin')

@section('content')

<div class="container-fluid">
  <form action="{{ route('phonebooks.store') }}" method="POST" enctype="multipart/form-data">
  @csrf
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header card-header-primary">
          <h4 class="card-title">Добавить справочник</h4>
          <p class="card-category">Добавление справочника организации и импорт контактов</p>
        </div>
        <div class="card-body">
            <div class="row">
              <div class="col-md-8">
                <div class="row">
                  <div class="col">
                    <div class="form-group @error('title') has-danger @enderror">
                      <label class="bmd-label-floating">Название организации *</label>
                      <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                      @error('title')
                        <label id="title-error" class="error" for="title-error">{{ $message }}</label>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col">
                    <div class="form-group @error('full_name') has-danger @enderror">
                      <label class="bmd-label-floating">Полное навзание</label>
                      <input type="text" class="form-control" name="full_name" value="{{ old('full_name') }}">
                      @error('full_name')
                        <label id="full_name-error" class="error" for="full_name-error">{{ $message }}</label>
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
              </div>
              <div class="col-md-4">
                <div class="row">
                  <div class="col">
                    <div class="form-group @error('site') has-danger @enderror">
                      <label class="bmd-label-floating">Сайт организации</label>
                      <input type="text" class="form-control" name="site" value="{{old('site')}}">
                      @error('site')
                      <label id="site-error" class="error" for="site-error">{{ $message }}</label>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col">
                    <div class="form-group @error('email') has-danger @enderror">
                      <label class="bmd-label-floating">Email</label>
                      <input type="email" class="form-control" name="email" value="{{old('email')}}">
                      @error('email')
                      <label id="email-error" class="error" for="email-error">{{ $message }}</label>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col">
                    <div class="form-group @error('address') has-danger @enderror">
                      <div class="form-group">
                        <label class="bmd-label-floating">Адрес</label>
                        <textarea class="form-control" rows="6" name="address">{{old('address')}}</textarea>
                        @error('address')
                        <label id="address-error" class="error" for="address-error">{{ $message }}</label>
                        @enderror
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-success pull-right">Добавить</button>
            <a href="{{ route('phonebooks.index') }}" class="btn btn-outline-light">Отменить</a>
            <div class="clearfix"></div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card card-stats mb-5">
        <div class="card-header card-header-info card-header-icon">
          <div class="card-icon">
            <i class="material-icons">home</i>
          </div>
          <h3 class="card-title">К кому относится</h3>
        </div>
        <div class="card-body text-left">
          <phone-book-parent></phone-book-parent>
        </div>
      </div>
      <div class="card card-stats">
        <div class="card-header card-header-success card-header-icon">
          <div class="card-icon">
            <i class="material-icons">contact_phone</i>
          </div>
          <h3 class="card-title">Контакты</h3>
        </div>
        <div class="card-body text-left">
          <label>Выберите Excel файл с контактами</label>
          <div>
            <input type="file" name="file" class="btn btn-primary" value="{{old('file')}}">
            @error('file')
              <label id="file-error" class="error" for="file-error">{{ $message }}</label>
            @enderror
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
</div>

@endsection