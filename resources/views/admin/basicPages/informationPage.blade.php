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
                <a href="{{ route('familyPlanningMethod.index')}}" class="list-group-item">Family Planning Method</a>
            </div>

        </aside>
        <main class="col-10 invisible">
            <!--hidden spacer-->
        </main>
        <main class="col offset-2 h-100">
        @foreach ($content as $contentss)
        @if($contentss->id = '3')
        <div class="row">
            <div class="col-md-12">
                {{$contentss->content_name}}
            </div>
        </div>
                @foreach($contents as $content)
                <small>Title</small>
                <div class="row">
                      <div class="col-md-12">
                          {{ $content->section_title}}
                      </div>
                </div>
                <small>Content</small>
                <div class="row">
                      <div class="col-md-12">
                          {{ $content->content}}
                      </div>
                </div>
                @endforeach
        @else
        <div class="row">
                <div class="col-12 py-4">
                    <h2>{{ $contents->content_name }}</h2>
                    <span>{{ $contents->content_name }}</span>
                </div>
            </div>
           <div class="row">
                <div class="col-md-12">
                <h4> {{ $contents->content_name }}</h4>
                </div>
           </div>
           <div class="row">
                <div class="col-md-12">
                {{ $contents->content }}
                </div>
           </div>
        @endif
        
           <div class="row">
                <div class="col-md-12">
                    @if ($contentss->id == 4)
                    @else
                    <a href="{{ route('basicPages.editPage',$contentss->id)}}" class="btn btn-success">Edit content</a>
                    @endif
                </div>
           </div>
        </main>
    </div>
    @endforeach
</div>
@endsection
