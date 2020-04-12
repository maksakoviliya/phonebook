@extends('layouts.admin')

@section('content')

<div class="container-fluid">
  @include('notifications.success')
  @include('notifications.error')

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-primary d-flex align-items-center justify-content-between">
          <div>
            <h4 class="card-title ">Пользователи</h4>
            <p class="card-category">Список всех пользователей</p>
          </div>
          {{-- <a href="{{ route('users.create') }}" class="btn btn-success">
            <i class="material-icons">add</i>
            Добавить
          </a> --}}
        </div>
        <div class="card-body">
          @if ($users->count())
            <div class="table-responsive">
              <table class="table table-hover">
                <thead class=" text-primary">
                  <th>#</th>
                  <th>Название</th>
                  <th>Телефон</th>
                  <th>Дата регистрации</th>
                  <th></th>
                </thead>
                <tbody>
                  @foreach ($users as $user)
                  <tr>
                    <td>{{ $user->id }}</td>
                    <td><a href="{{ route('users.edit', $user->id) }}">{{ $user->name }}</a></td>
                    <td><a href="tel:{{$user->phone}}" rel="tooltip" title="Позвонить">{{ $user->phone }}</a></td>
                    <td>{{ $user->created_at->format('d M Y') }}</td>
                    <td class="td-actions text-right">
                      <a href="{{ route('users.edit', $user->id) }}" rel="tooltip" title="Просомтр" class="btn btn-white btn-link btn-sm">
                        <i class="material-icons">edit</i>
                      </a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <h3 class="mb-4">Пользователей пока нет</h3>
          @endif
        </div>
      </div>
    </div>

  </div>
</div>

@endsection