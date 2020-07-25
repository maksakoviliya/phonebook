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
            <h4 class="card-title ">Контакты</h4>
              <p class="card-category"><a href="{{ route('phonebooks.edit', $phonebook->id) }}">{{ $phonebook->title }}</a></p>
          </div>
          <search-contacts phonebook-id="{{$phonebook->id}}" base-url="{{ config('app.url') }}"></search-contacts>
          <a href="{{ route('contacts.create', $phonebook->id) }}" class="btn btn-success">
            <i class="material-icons">add</i>
            Добавить
          </a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead class=" text-primary">
                <th>Фото</th>
                <th>Фамилия</th>
                <th>Имя</th>
                <th>Отчество</th>
                <th>Должность</th>
                <th>День рождения</th>
                <th>Телефон 1</th>
                <th>Телефон 2</th>
                <th>Телефон 3</th>
                <th>Факс</th>
                <th>Email</th>
                {{-- <th></th> --}}
              </thead>
              <tbody>
                @foreach ($contacts as $contact)
                <tr>
                  <td><img src="{{ strlen($contact->photo) ? $contact->photo : '/img/no-photo.svg' }}" class="img-fluid img-thumbnail bg-transparent border-0" style="max-width: 70px;"></td>
                  <td>{{ $contact->last_name }}</td>
                  <td>{{ $contact->first_name }}</td>
                  <td>{{ $contact->patronymic }}</td>
                  <td>{{ $contact->position }}</td>
                  <td>{{ $contact->birthday }}</td>
                  <td>{{ $contact->phone1 }}</td>
                  <td>{{ $contact->phone2 }}</td>
                  <td>{{ $contact->phone3 }}</td>
                  <td>{{ $contact->fax }}</td>
                  <td>{{ $contact->email }}</td>
                  {{-- <td class="td-actions text-right">
                    <a href="{{ route('contacts.edit', $contact->id) }}" rel="tooltip" title="Открыть для редактирования" class="btn btn-white btn-link btn-sm">
                      <i class="material-icons">edit</i>
                    </a>
                  </td> --}}
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer">
          {{$contacts->links()}}
        </div>
      </div>
    </div>

  </div>
</div>

@endsection