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
            <form method="POST" action="{{ route('storeThirdPage') }}">
                @csrf
            <div class="row">
                   <div class="col-md-12">
                       <h5>Modern Method</h5>
                   </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @foreach ($modernMethod as $method)
                    <input type="checkbox" name="modern[]" value="{{ $method->id }}">{{ $method->name }}
                    @endforeach
                </div>
            </div>
            <div class="row">
                   <div class="col-md-12">
                       <h5>Permanent Method</h5>
                   </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @foreach ($permanentMethod as $method)
                    <input type="checkbox" name="permanent[]" value="{{ $method->id }}">{{ $method->name }}
                    @endforeach
                </div>
            </div>
            <div class="row">
                   <div class="col-md-12">
                       <h5>Natural Method</h5>
                   </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @foreach ($naturalMethod as $method)
                    <input type="checkbox" name="natural[]" value="{{ $method->id }}">{{ $method->name }}
                    @endforeach
                </div>
            </div>
            <div class="row">
            </div>
            <div class="row">
            </div>
            <div class="row">
            </div>
            <div class="row">
                 <div class="col-md-12">
                     <span>Do you have paid services?</span><br/>
                     <span><input type="radio" name="paid" value="1">Yes&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="paid" value="0" checked>No</span>
                 </div>
            </div>
            <div class="row">
               <div class="col-md-12">
               <h4>Modern Method</h4>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
               @foreach ($modernMethod as $method)
                    <input type="checkbox" name="service[]" value="{{ $method->id }}">{{ $method->name }}
                    @endforeach
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                   <span></span>
               <h4>Natural Method</h4>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
               @foreach ($naturalMethod as $method)
                    <input type="checkbox" name="service[]" value="{{ $method->id }}">{{ $method->name }}
                    @endforeach
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
               <h4>Permanent Method</h4>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
               @foreach ($permanentMethod as $method)
                    <input type="checkbox" name="service[]" value="{{ $method->id }}">{{ $method->name }}
                    @endforeach
               </div>
            </div>
            <div class="row h-100">
                  <div class="col-md-12">
                      <input type="submit" value="Next" class="btn btn-success">
                  </div>
            </div>
            </form>       
        </main>
    </div>
</div>
@endsection
