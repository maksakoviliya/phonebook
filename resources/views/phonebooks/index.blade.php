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
                        @if (isset($parent))
                        <p class="card-category">{{$parent['title']}}</p>
                        @else
                        <p class="card-category">Список всех справочников</p>
                        @endif
                    </div>
                    <search-phone-books base-url="{{ config('app.url') }}"></search-phone-books>
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
                                    @if ($phonebook->phonebooks->count())
                                    <td>
                                        <a href="{{ route('phonebooks.show', $phonebook->id) }}" rel="tooltip"
                                            title="Просмотр вложенных справочников">{{ $phonebook->title }}</a> <a
                                            href="{{ route('phonebooks.edit', $phonebook->id) }}" rel="tooltip"
                                            title="Открыть для редактирования" class="btn btn-white btn-link btn-sm"><i
                                                class="material-icons">edit</i></a>
                                    </td>
                                    @else
                                    <td>
                                        <a
                                            href="{{ route('phonebooks.edit', $phonebook->id) }}">{{ $phonebook->title }}</a>
                                    </td>
                                    @endif
                                    <td>{{ $phonebook->phonebooks->count() }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-info"
                                            href="{{ route('phonebooks.contacts', $phonebook->id) }}">{{ $phonebook->contacts }}</a>
                                    </td>
                                    <td class="td-actions text-right">
                                        <a href="{{ route('phonebooks.edit', $phonebook->id) }}" rel="tooltip"
                                            title="Открыть для редактирования" class="btn btn-white btn-link btn-sm">
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
                    {{$phonebooks->links()}}
                </div>
            </div>
        </div>

    </div>
</div>

@endsection