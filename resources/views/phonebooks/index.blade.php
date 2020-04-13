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
                  <td class="w-50"><a href="{{ route('phonebooks.edit', $phonebook->id) }}">{{ $phonebook->title }}</a></td>
                  <td class="w-25">{{ $phonebook->phonebooks->count() }}</td>
                  <td class="w-25">{{ count($phonebook->contacts) }}</td>
                  <td class="td-actions text-right">
                    <a href="{{ route('phonebooks.edit', $phonebook->id) }}" rel="tooltip" title="Просомтр" class="btn btn-white btn-link btn-sm">
                      <i class="material-icons">edit</i>
                    </a>
                  </td>
                </tr>
                @if ($phonebook->phonebooks->count())
                  <tr>
                    <td colspan="5" class="pr-0 pl-5">
                      <div class="table-responsive">
                        <table class="table mb-0 bg-dark">
                          <tbody>
                            @foreach ($phonebook->phonebooks as $subPhonebook)
                            <tr>
                              <td>{{ $subPhonebook->id }}</td>
                              <td class="w-50"><a href="{{ route('phonebooks.edit', $subPhonebook->id) }}">{{ $subPhonebook->title }}</a></td>
                              <td class="w-25">{{ $subPhonebook->phonebooks->count() }}</td>
                              <td class="w-25">{{ count($subPhonebook->contacts) }}</td>
                              <td class="td-actions text-right">
                                <a href="{{ route('phonebooks.edit', $subPhonebook->id) }}" rel="tooltip" title="Просомтр" class="btn btn-white btn-link btn-sm">
                                  <i class="material-icons">edit</i>
                                </a>
                              </td>
                            </tr>

                            @if ($subPhonebook->phonebooks->count())
                              <tr>
                                <td colspan="5" class="pr-0 pl-5">
                                  <div class="table-responsive">
                                    <table class="table mb-0 bg-grey">
                                      <tbody>
                                        @foreach ($subPhonebook->phonebooks as $subSubPhonebook)
                                          <tr>
                                            <td>{{ $subSubPhonebook->id }}</td>
                                            <td class="w-50"><a href="{{ route('phonebooks.edit', $subSubPhonebook->id) }}">{{ $subSubPhonebook->title }}</a></td>
                                            <td class="w-25">{{ $subSubPhonebook->phonebooks->count() }}</td>
                                            <td class="w-25">{{ count($subSubPhonebook->contacts) }}</td>
                                            <td class="td-actions text-right">
                                              <a href="{{ route('phonebooks.edit', $subSubPhonebook->id) }}" rel="tooltip" title="Просомтр" class="btn btn-white btn-link btn-sm">
                                                <i class="material-icons">edit</i>
                                              </a>
                                            </td>
                                          </tr>
                                        @endforeach
                                      </tbody>
                                    </table>
                                  </div>
                                </td>
                              </tr>
                            @endif

                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </td>
                  </tr>
                @endif
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer">
          {{$phonebooks->links()}}
        </div>
      </div>
    </div>

  </div>
</div>

@endsection