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
            <h4 class="card-title ">Справочники</h4>
            <p class="card-category">Список всех справочников</p>
          </div>
          <a href="{{ route('phonebooks.create') }}" class="btn btn-success">
            <i class="material-icons">add</i>
            Добавить
          </a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead class=" text-primary">
                <th>#</th>
                <th>Название</th>
                <th>Вложенных организаций</th>
                <th>Контактов</th>
                <th></th>
              </thead>
              <tbody>
                @foreach ($phonebooks as $phonebook)
                <tr>
                  <td>{{ $phonebook->id }}</td>
                  <td><a href="{{ route('phonebooks.edit', $phonebook->id) }}">{{ $phonebook->title }}</a></td>
                  <td>{{ $phonebook->phonebooks->count() }}</td>
                  <td>{{ count($phonebook->contacts) }}</td>
                  <td class="td-actions text-right">
                    <a href="{{ route('phonebooks.edit', $phonebook->id) }}" rel="tooltip" title="Просомтр" class="btn btn-white btn-link btn-sm">
                      <i class="material-icons">edit</i>
                    </a>
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
</div>

@endsection