@extends('layouts.admin.dashboard')

@section('title', 'User Management')
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
                <a href="{{ route('basicPages')}}" class="list-group-item active">Basic Pages</a>
                <a href="{{ route('familyPlanningMethod.index')}}" class="list-group-item ">Family Planning Method</a>
            </div>

        </aside>
        <main class="col-10 invisible">
            <!--hidden spacer-->
        </main>
        <main class="col offset-2 h-100">
        <div class="row">
                <div class="col-12 py-4">
                    <h2>Basic Pages</h2>
                    <span>Basic Pages</span>
                </div>
            </div>
           @foreach ($content as $contents)
           <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{ route('basicPages.storeEdit')}}">
                        @csrf
                        <input type="text" name="content_name" value="{{ $contents->content_name}}"/>
                        <input type="hidden" name="id" value="{{ $contents->id }}">
                        <textarea name="contents" width="250" height="250">{{ $contents->content }}</textarea>
                        <br/>
                        <input type="submit" value="Edit Content" class="btn btn-success"/>
                    </form>
                </div>
           </div>
           @endforeach
        </main>
    </div>
</div>
@endsection
