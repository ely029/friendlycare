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
          <div class="breadcrumbs"><a class="breadcrumbs__link" href="provider-management.html">Chatbot Management</a><a class="breadcrumbs__link"></a><a class="breadcrumbs__link"></a></div>
        </div>
        <div class="section__container">
          <a class="button button--create" href="create-fieldset.html">Create Fieldset<i class="fa fa-plus"></i></a>
          <table class="table" id="table">
            <thead>
              <tr>
                <th class="table__head">Fieldset Title</th>
                <th class="table__head">Chatbot Input</th>
              </tr>
            </thead>
            <tbody>
              <tr class="table__row js-view" data-href="view-fieldset.html">
                <td class="table__details">Opening</td>
                <td class="table__details">Good day, what would you like to talk about?</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
@endsection