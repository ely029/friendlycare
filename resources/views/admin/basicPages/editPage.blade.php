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

           @if($contents->id = 3)
           <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{ route('basicPages.storeEdit')}}">
                        @csrf
                        <span>Title</span><br/>
                        <input type="text" name="content_name" value="{{ $contents->content_name}}"/>
                        <input type="hidden" name="id" value="{{ $contents->id }}">
                        <br/>
                        @foreach($contentss as $contentsss)
                        <div class="row">
                            <div class="col-md-12">
                                <small>Title</small>
                            <input type="text" name="title[]" value="{{ $contentsss->title}}"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <small>Content</small>
                                <textarea name="content[]" style="width:500px;height:200px;">{{ $contentsss->content }}</textarea>
                            </div>
                        </div>
                        @endforeach
                        <div class="sections">
                        </div>
                        <br/>
                        <input type="submit" value="Save Changes" class="btn btn-success"/>
                        <input type="button"  class="btn btn-primary add-section" value="Add Section"/>
                    </form>
                </div>
           </div>
           @else
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
           @endif
           @endforeach
        </main>
    </div>
</div>
@endsection
