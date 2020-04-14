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
            <h4 class="card-title ">Заказчики</h4>
            <p class="card-category">Список всех заказчиков</p>
          </div>
          <search-customers></search-customers>
          <a href="{{ route('customers.create') }}" class="btn btn-success">
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
                <th>Телефон</th>
                <th></th>
              </thead>
              <tbody>
                @foreach ($customers as $customer)
                <tr>
                  <td>{{ $customer->id }}</td>
                  <td><a href="{{ route('customers.edit', $customer->id) }}">{{ $customer->name }}</a></td>
                  <td><a href="tel:{{$customer->phone}}" rel="tooltip" title="Позвонить">{{ $customer->phone }}</a></td>
                  <td class="td-actions text-right">
                    <a href="{{ route('customers.edit', $customer->id) }}" rel="tooltip" title="Просмотр" class="btn btn-white btn-link btn-sm">
                      <i class="material-icons">edit</i>
                    </a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer">
          {{$customers->links()}}
        </div>
      </div>
    </div>

  </div>
</div>

@endsection