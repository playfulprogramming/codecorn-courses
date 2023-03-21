@extends('layouts.admin')
@section('content')
<div class="bg-white card">
    <div class="border-b card-header border-slate-200">
        <div class="card-header-container">
            <h6 class="card-title">
                {{ trans('cruds.user.title_singular') }}
                {{ trans('global.list') }}
            </h6>

            @can('user_create')
                <a class="btn btn-indigo" href="{{ route('admin.users.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.user.title_singular') }}
                </a>
            @endcan
        </div>
    </div>
    <livewire:user.index />

</div>
@endsection
