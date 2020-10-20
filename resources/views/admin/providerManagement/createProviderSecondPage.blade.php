@extends('layouts.admin.dashboard')

@section('title', 'Admin Dashboard')
@section('description', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <aside class="col-2 px-0 fixed-top" id="left"> 
            <div class="list-group w-100">
                <span>Management</span>
                <a href="{{ route('userManagement') }}" class="list-group-item">User Management</a>
                <a href="{{ route('providerManagement')}}" class="list-group-item active">Provider Management</a>
            </div>

        </aside>
        <main class="col-10 invisible">
            <!--hidden spacer-->
        </main>
        <main class="col offset-2 h-100">
            <div class="row bg-light">
                <div class="col-12 py-4">
                    <h2>Create provider</h2>
                    <span>Provider Management</span><span>Create Provider</span>
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
            <form method="POST" action="{{ route('storeSecondPage')}}" enctype="multipart/form-data">
                @csrf
            <div class="row">
                  <div class="col-md-6">
                      <input type="hidden" name="id" id="id" value="{{ session()->get('id') }}"/>
                  </div>
            </div>  
            <div class="row">
                <input type="file" name="files[]" multiple/>
            </div>  
            <div class="row">
                
            </div> 
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                <span>Sunday</span>
                    <input checked type="checkbox" name="days[]" value="sunday">
                    <input type="time" name="from[]">
                    <input type="time" name="to[]">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                <span>Monday</span>
                    <input checked type="checkbox" name="days[]" value="monday">
                    <input type="time" name="from[]">
                    <input type="time" name="to[]">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                <span>Tuesday</span>
                    <input checked type="checkbox" name="days[]" value="tuesday">
                    <input type="time" name="from[]">
                    <input type="time" name="to[]">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                <span>Wednesday</span>
                    <input checked type="checkbox" name="days[]" value="wednesday">
                    <input type="time" name="from[]">
                    <input type="time" name="to[]">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                <span>Thursday</span>
                    <input checked type="checkbox" name="days[]" value="thursday">
                    <input type="time" name="from[]">
                    <input type="time" name="to[]">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                <span>Friday</span>
                    <input checked type="checkbox" name="days[]" value="friday">
                    <input type="time" name="from[]">
                    <input type="time" name="to[]">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                <span>Saturday</span>
                    <input checked type="checkbox" name="days[]" value="saturday">
                    <input type="time" name="from[]">
                    <input type="time" name="to[]">
                </div>
            </div> 
            <div class="row">
                  <div class="col-md-12">
                     <input type="submit" class="btn btn-success" value="Next">                    
                  </div>
            </div>
            </form>           
        </main>
    </div>
</div>
@endsection
