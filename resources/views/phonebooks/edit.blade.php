@extends('layouts.admin')

@section('content')

<div class="container-fluid">
  @include('notifications.success')
  @include('notifications.error')

  <form action="{{ route('phonebooks.update', $phonebook->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title">{{$phonebook->title}}</h4>
            <p class="card-category">{{$phonebook->full_name}}</p>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col">
                <div class="form-group @error('title') has-danger @enderror">
                  <label class="bmd-label-floating">Название организации *</label>
                  <input type="text" class="form-control" name="title" value="{{$phonebook->title}}">
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
                  <input type="text" class="form-control" name="full_name" value="{{$phonebook->full_name}}">
                  @error('full_name')
                  <label id="full_name-error" class="error" for="full_name-error">{{ $message }}</label>
                  @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <div class="form-group @error('description') has-danger @enderror">
                  <div class="form-group">
                    <label class="bmd-label-floating">Описание</label>
                    <textarea class="form-control" rows="5" name="description">{{$phonebook->description}}</textarea>
                    @error('description')
                    <label id="description-error" class="error" for="description-error">{{ $message }}</label>
                    @enderror
                  </div>
                </div>
              </div>
            </div>
            <div class="d-flex align-items-center justify-content-between">
              <div>
                <button type="submit" class="btn btn-primary pull-right">Обновить</button>
                <a href="{{ redirect()->back() }}" class="btn btn-outline-light">Отменить</a>
              </div>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deletePhoneBook"><i class="material-icons">delete</i> Удалить</button>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        @if ($phonebook->phonebooks->count())
        <div class="card card-stats mb-5">
          <div class="card-header card-header-primary card-header-icon">
            <div class="card-icon">
              <i class="material-icons">pie_chart</i>
            </div>
            <h3 class="card-title">Внутренние организации</h3>
            <p class="card-category">{{$phonebook->phonebooks->count()}}</p>
          </div>
          <div class="card-body text-left">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead >
                  <th>
                    #
                  </th>
                  <th>
                    Название
                  </th>
                </thead>
                <tbody>
                  @foreach ($phonebook->phonebooks as $subPhonebook)
                  <tr>
                    <td>{{ $subPhonebook->id }}</td>
                    <td><a href="{{ route('phonebooks.edit', $subPhonebook->id) }}">{{ $subPhonebook->title }}</a></td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
        @endif
        <div class="card card-stats mb-5">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">home</i>
            </div>
            <h3 class="card-title">К кому относится</h3>
          </div>
          <div class="card-body text-left">
            <div class="row">
              <div class="col">
                <div class="dropdown bootstrap-select show- w-100">
                  <select class="selectpicker" data-style="select-with-transition" data-width="100%" title="Выберите организацию" data-size="7" tabindex="-98" name="parent_id">
                    @if ($phonebook->parent_id == 0)
                      <option value="0" selected="">Самостоятельная организация</option>
                    @else
                      <option value="0">Самостоятельная организация</option>
                    @endif
                    @foreach ($phonebooks as $category)
                      @if ($category->id != $phonebook->id)
                        <option value="{{$category->id}}" @if ($category->id == $phonebook->parent_id) selected @endif>
                          {{$category->title}}
                        </option>
                      @endif
                    @endforeach
                  </select>
                </div>
                @error('parent_id')
                  <label id="parent_id-error" class="error text-danger" for="parent_id-error">{{ $message }}</label>
                @enderror
              </div>
            </div>
          </div>
        </div>
        <div class="card card-stats">
          <div class="card-header card-header-success card-header-icon">
            <div class="card-icon">
              <i class="material-icons">contact_phone</i>
            </div>
            <p class="card-category">Контакты</p>
            <h3 class="card-title">{{count($phonebook->contacts)}}</h3>
          </div>
          <div class="card-footer">
            <div>
              <div class="custom-file-upload w-100 mt-0">
                <input type="file" name="file" class="btn btn-primary" value="{{old('file')}}">
                @error('file')
                  <label id="file-error" class="error" for="file-error">{{ $message }}</label>
                @enderror
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
</div>

<div class="modal fade" id="deletePhoneBook" tabindex="-1" role="dialog" aria-labelledby="deletePhoneBookLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deletePhoneBookLabel" class="text-danger">Удалить справочник</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Будут удалены все контакты, а также вложенные справочники!
      </div>
      <div class="modal-footer">
        <form action="{{ route('phonebooks.destroy', $phonebook->id) }}" method="POST">
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