@extends('layouts.admin.dashboard')

@section('title', 'Family Planning Method')
@section('description', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <aside class="col-2 px-0 fixed-top" id="left">
        @csrf
            <div class="list-group w-100">
                <span>Management</span>
                <a href="{{ route('userManagement') }}" class="list-group-item">User Management</a>
                <a href="{{ route('providerManagement')}}" class="list-group-item">Provider Management</a>
                <span>Content</span>
                <a href="{{ route('basicPages')}}" class="list-group-item">Basic Pages</a>
                <a href="{{ route('familyPlanningMethod.index')}}" class="list-group-item active">Family Planning Method</a>
            </div>

        </aside>
        <main class="col-10 invisible">
            <!--hidden spacer-->
        </main>
        <main class="col offset-2 h-100">
            <div class="row">
                <div class="col-12 py-4">
                    <h2>Create Service</h2>
                    <span>Family Planning Methods</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h3>Content</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h4>Description</h4>
                </div>
            </div>
            <form method="POST" action=" {{ route('familyPlanningMethod.createTwo')}}">
             @csrf
            <div class="row">
                <div class="col-md-6">
                    <span>Description (English)</span>
                    <textarea name="description_english">{{ old('description_english') }}</textarea>
                </div>
                <div class="col-md-6">
                    <span>Description (Tagalog)</span>
                    <textarea name="description_tagalog">{{ old('description_tagalog') }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h4>How It Works</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <span>How It works (English)</span>
                    <textarea name="how_it_works_english">{{ old('how_it_works_english')}}</textarea>
                </div>
                <div class="col-md-6">
                    <span>How It works (Tagalog)</span>
                    <textarea name="how_it_works_tagalog">{{ old('how_it_works_tagalog') }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h4>Possible Side Effect</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <span>Possible Side Effect (English)</span>
                    <textarea name="side_effect_english">{{ old('side_effect_english') }}</textarea>
                </div>
                <div class="col-md-6">
                    <span>Possible Side Effect (Tagalog)</span>
                    <textarea name="side_effect_tagalog">{{ old('side_effect_tagalog') }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h4>Additional Effect</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <span>Additional Note (English)</span>
                    <textarea name="additional_note_english">{{ old('additional_note_english') }}</textarea>
                </div>
                <div class="col-md-6">
                    <span>Additional Note (Tagalog)</span>
                    <textarea name="additional_note_tagalog">{{ old('additional_note_tagalog') }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                @if ($errors->any())
  <div class="alert alert-danger">
     <ul>
        @foreach ($errors->all() as $error)
           <li>{{ $error }}</li>
        @endforeach
     </ul>
  </div>
@endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                </div>
                <div class="col-md-6">
                    <input type="submit" value="Next" class="btn btn-success"/>
                </div>
            </div>
            </form>            
        </main>
    </div>
</div>
@endsection
