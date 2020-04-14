@extends('layouts.admin')

@section('content')

<div class="container-fluid">
  @include('notifications.success')
  @include('notifications.error')

  <form action="{{ route('customers.update', $customer->id) }}" method="POST">
  @csrf
  @method('PUT')

  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header card-header-primary">
          <h4 class="card-title">{{ $customer->name }}</h4>
          <p class="card-category">Изменение данных заказчика</p>
        </div>
        <div class="card-body">
            <div class="row">
              <div class="col">
                <div class="form-group @error('name') has-danger @enderror">
                  <label class="bmd-label-floating">Фамилия Имя Отчество *</label>
                  <input type="text" class="form-control" name="name" value="{{ old('_token') || old('name') ? old('name') : $customer->name }}">
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
                  <input type="text" class="form-control" name="phone" value="{{ old('_token') || old('phone') ? old('phone') : $customer->phone }}">
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
                    <textarea class="form-control" rows="5" name="description">{{ old('_token') || old('description') ? old('description') : $customer->description }}</textarea>
                    @error('description')
                      <label id="description-error" class="error" for="description-error">{{ $message }}</label>
                    @enderror
                  </div>
              </div>
            </div>
            <div class="d-flex align-items-center justify-content-between">
              <div>
                <button type="submit" class="btn btn-success pull-right">Изменить</button>
                <a href="{{ route('customers.index') }}" class="btn btn-outline-light">Отменить</a>
              </div>
              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteCustomer"><i class="material-icons">delete</i> Удалить</button>
            </div>
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
              <div class="input-group">
                <div class="input-group-prepend">
                  <a href="{{ old('_token') || old('files_link') ? old('files_link') : $customer->files_link }}" class="btn btn-info btn-sm" target="_blank">
                    <i class="material-icons">link</i>
                  </a>
                </div>
                <input type="text" class="form-control pl-3"  name="files_link" value="{{ old('_token') || old('files_link') ? old('files_link') : $customer->files_link }}">
              </div>
              @error('files_link')
                <label id="files_link-error" class="error" for="files_link-error">{{ $message }}</label>
              @enderror
            </div>
          </div>
        </div>
        <div class="card card-stats mt-5">
          <div class="card-header card-header-success card-header-icon">
            <div class="card-icon">
              <i class="material-icons">library_add_check</i>
            </div>
            <h3 class="card-title">Коды активации</h3>
            <p class="card-category">{{ $customer->codes->count() }}</p>
          </div>
          @if ($customer->codes->count() > 0 )
            <div class="card-body text-left">
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead >
                    <th>#</th>
                    <th>Справочник</th>
                    <th>Пользователи</th>
                    <th>Код</th>
                  </thead>
                  <tbody>
                    @foreach ($customer->codes as $code)
                    <tr>
                      <td>{{ $code->id }}</td>
                      <td><a href="{{ route('phonebooks.edit',$code->phonebook->id ) }}">{{ $code->phonebook->title }}</a></td>
                      <td>{{ $code->users_count }} / {{ $code->users_total }}</td>
                      <td>
                        <div class="d-flex align-items-center">
                          <span id="code_clip_{{$code->id}}">{{ $code->code }}</span> 
                          <button type="button" class="copyToClipBoardBtn" data-clipboard-target="#code_clip_{{$code->id}}">
                            <i class="material-icons">file_copy</i>
                          </button>
                        </div>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          @endif
          <div class="card-footer">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addActivationCode"><i class="material-icons">add</i> Создать</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
</div>

<div class="modal fade" id="deleteCustomer" tabindex="-1" role="dialog" aria-labelledby="deleteCustomerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title mt-0" id="deleteCustomerLabel" class="text-danger">Удалить заказчика</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Будут навсегда удалены все его данные!
      </div>
      <div class="modal-footer">
        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST">
          @csrf
          @method('DELETE')
          
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
          <button type="submit" class="btn btn-danger">Удалить</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade @error('phonebook_id') showIfErrors @enderror" id="addActivationCode" tabindex="-1" role="dialog" aria-labelledby="addActivationCodeLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form action="{{ route('codes.create') }}" method="POST">
        @csrf
        
        <input type="text" class="d-none" hidden="" name="customer_id" value="{{$customer->id}}">

          <div class="modal-header">
            <h3 class="modal-title mt-0" id="addActivationCodeLabel">Создать код активации</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <div class="modal-body">
          <div class="row align-items-center mb-3">
            <div class="col-md-4">
              <p class="label mb-0">Заказчик</p>
            </div>
            <div class="col">
              <p class="mb-0">#ID {{$customer->id}} | {{$customer->name}}</p>
              @error('customer_id')
                  <label id="customer_id-error" class="error text-danger" for="customer_id-error">{{ $message }}</label>
                @enderror
            </div>
          </div>
          <div class="row align-items-center mb-3">
            <div class="col-md-4">
              <p class="label mb-0">Справочник</p>
            </div>
            <div class="col-md-8">
              <div class="dropdown bootstrap-select w-100">
                <select class="selectpicker" data-size="7" data-style="btn btn-primary" required="" data-width="100%" title="Выберите справочник" tabindex="-98" name="phonebook_id">
                  @foreach ($phonebooks as $phonebook)
                    @if ($phonebook->parent_id == 0)
                      <option value="{{$phonebook->id}}">{{$phonebook->title}}</option>
                    @endif
                  @endforeach
                </select>
                @error('phonebook_id')
                  <label id="phonebook_id-error" class="error text-danger" for="phonebook_id-error">{{ $message }}</label>
                @enderror
              </div>
            </div>
          </div>
          <div class="row align-items-center">
            <div class="col-md-4">
              <p class="label mb-0">Пользователи</p>
            </div>
            <div class="col">
              <div class="form-group">
                <label class="bmd-label-floating">Введите число кодов</label>
                <input type="text" class="form-control text-dark" name="users_total" required="" value="">
                @error('users_total')
                  <label id="users_total-error" class="error text-danger" for="users_total-error">{{ $message }}</label>
                @enderror
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Создать</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
@error ('customer_id','phonebook_id', 'phonebook_id')
    if ($('.showIfErrors').length) {
    console.log('Log text');
    $('.showIfErrors').modal('show')
  }
@enderror
</script>

@endsection