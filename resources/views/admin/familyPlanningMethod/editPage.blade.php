@extends('layouts.admin.dashboard')

@section('title', 'Family Planning Method')
@section('description', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <aside class="col-2 px-0 fixed-top" id="left">
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
    
        @foreach ($details as $user)
        <main class="col offset-2 h-100">
            <form method="POST" action="{{ route('familyPlanningMethod.update')}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $user->id }}"/>
            <div class="row bg-white">
                <div class="col-md-12">
                    <span>Method Name</span>
                    <input type="text" class="form-control" name="name" value="{{ $user->name }}"/>
                </div>
            </div>
            <div class="row bg-white">
                <div class="col-md-12">
                    <span>Short Name</span>
                    <input type="text" class="form-control" name="short_name" value="{{ $user->short_name }}"/>
                </div>
            </div>
            <div class="row bg-white">
                <div class="col-md-12">
                    <span>Typikal na bisa</span>
                    <input type="text" class="form-control" name="typical_validity" value="{{ $user->typical_validity }}"/>
                </div>
            </div>
            <div class="row bg-white">
                <div class="col-md-12">
                    <span>Percent Effective</span>
                    <input type="text" class="form-control" name="percent_effective" value="{{ $user->percent_effective }}"/>
                </div>
            </div>
            <div class="row bg-white">
                <div class="col-md-12">
                    <span>Description (English) </span>
                    <textarea name="description_english">{{ $user->description_english }}</textarea>
                </div>
            </div>
            <div class="row bg-white">
                <div class="col-md-12">
                    <span>Description (Filipino) </span>
                    <textarea name="description_tagalog">{{ $user->description_filipino }}</textarea>
                </div>
            </div>
            <div class="row bg-white">
                <div class="col-md-12">
                    <span>How it Works (English) </span>
                    <textarea name="how_it_works_english">{{ $user->how_it_works_english }}</textarea>
                </div>
            </div>
            <div class="row bg-white">
                <div class="col-md-12">
                    <span>How it Works (Tagalog) </span>
                    <textarea name="how_it_works_tagalog">{{ $user->how_it_works_filipino }}</textarea>
                </div>
            </div>
            <div class="row bg-white">
                <div class="col-md-12">
                    <span>Possible Side Effect (English) </span>
                    <textarea name="side_effect_english">{{ $user->side_effect_english }}</textarea>
                </div>
            </div>
            <div class="row bg-white">
                <div class="col-md-12">
                    <span>Possible Side Effect (Tagalog) </span>
                    <textarea name="side_effect_tagalog">{{ $user->side_effect_filipino }}</textarea>
                </div>
            </div>
            <div class="row bg-white">
                <div class="col-md-12">
                    <span>Additional Note (English) </span>
                    <textarea name="additional_note_english">{{ $user->additional_note_english }}</textarea>
                </div>
            </div>
            <div class="row bg-white">
                <div class="col-md-12">
                    <span>Additional Note (Filipino) </span>
                    <textarea name="additional_note_tagalog">{{ $user->additional_note_filipino }}</textarea>
                </div>
            </div>
            <div class="row bg-white">
                <div class="col-md-6">
                <img src="{{ $user->icon_url }}" height="50" width="50"/>
                </div>
                <div class="col-md-6">
                    <input type="file" name="icon" value="{{ $user->icon }}"/>
                </div>
            </div>
            <div class="row bg-white">
                <div class="col-md-4">
                    <input type="submit" class="btn btn-success" value="Edit Method"/>
                </div>
            </div>
            </form>
            
        </main>
        @endforeach
    </div>
</div>
@endsection
