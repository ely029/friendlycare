@extends('layouts.admin.dashboard')

@section('title', 'Basic Pages')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
@include('includes.sidebar')
</div>

<div class="section">
        <div class="section__top">
          <h1 class="section__title">Chatbot Management</h1>
          <div class="breadcrumbs"><a class="breadcrumbs__link" href="{{ route('chatbot.index')}}">Chatbot Management</a><a class="breadcrumbs__link"></a><a class="breadcrumbs__link"></a></div>
        </div>
        <div class="section__container">
          <a class="button button--create" href="{{ route('chatbot.create')}}">Create Fieldset<i class="fa fa-plus"></i></a>
          <table class="table" id="table">
            <thead>
              <tr>
                <th class="table__head">Fieldset Title</th>
                <th class="table__head">Chatbot Input</th>
              </tr>
            </thead>
            <tbody>
              @foreach($details as $detail)
              <tr class="table__row js-view" data-href="{{ route('chatbot.edit', $detail->id)}}">
                <td class="table__details">{{ $detail->field_set_title}}</td>
                <td class="table__details">{{ $detail->chatbot_input}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
@endsection