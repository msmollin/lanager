@extends('layouts.default')

@section('title')
    @lang('title.create-item', ['item' => __('title.navigation-link')])
@endsection

@section('content')
    <h1>@lang('title.create-item', ['item' => __('title.navigation-link')])</h1>
    {{ Breadcrumbs::render('navigation-links.create') }}
    @include('components.alerts.all')
    @include('components.form.create', ['route' => route('navigation-links.store')])
    @include('pages.navigation-links.partials.form')
    @include('components.form.close')
@endsection