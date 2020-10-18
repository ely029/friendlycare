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
    
        @foreach ($details as $detail)
        <main class="col offset-2 h-100">
            <div class="row bg-light">
                <div class="col-12 py-4">
                    <h2>{{ $detail->name }} / {{ $detail->short_name }}</h2>
                    <span>Family Planning Method</span>
                </div>
            </div>
            <div class="row bg-white">
               <div class="col-md-6">
                   <img height="75" width="75" src="{{ asset('assets/app/img/'.$detail->icon) }}"/> <span>{{ $detail->name }} or {{ $detail->short_name }}</span>
               </div>
            </div>
            <div class="row bg-white">
                <div class="col-md-6">
                    <h4>Gallery</h4>
                </div>
            </div>
            <div class="row bg-white">
            @foreach($detail->serviceGalleries as $gallery)
            <div class="col-md-2">
                <img height="50" width="50" src="{{ asset('assets/app/img/'.$gallery->file_name) }}">
                </div>
                    @endforeach
                <br/>
            </div>
            <div class="row bg-white">
                  <div class="col-md-12">
                      {{ $detail->video_link }}
                  </div>
            </div>
            <div class="row bg-white">
                <div class="col-md-4">
                    <h5>Effectiveness</h5>
                </div>
                <div class="col-md-4">
                    <h5>Description</h5>
                </div>
                <div class="col-md-4">
                </div>
            </div>
            <div class="row bg-white">
                    <div class="col-md-4">
                    <small>Sa Tamang Paggamit</small>
                    </div>
                    <div class="col-md-4">
                    <small>Description (English)</small>
                    </div>
              </div>
              <div class="row">
                  <div class="col-md-4">
                      {{ $detail->percent_effective }}
                  </div>
                  <div class="col-md-4">
                      {{ $detail->description_english }}
                  </div>
              </div>
              <div class="row bg-white">
                    <div class="col-md-4">
                    <small>Tipikal na bisa</small>
                    </div>
                    <div class="col-md-4">
                    <small>Description (Filipino)</small>
                    </div>
              </div>
              <div class="row bg-white">
                  <div class="col-md-4">
                      {{ $detail->typical_validity }}
                  </div>
                  <div class="col-md-4">
                      {{ $detail->description_tagalog }}
                  </div>
                  <div class="col-md-4">
                  </div>
              </div>
              <div class="row bg-white">
                  <div class="col-md-4">
                  </div>
                  <div class="col-md-4">
                    <h5>How It Works</h5>
                  </div>
                  <div class="col-md-4">
                  </div>
               </div>
               <div class="row">
                   <div class="col-md-4">
                   </div>
                   <div class="col-md-4">
                       <small> How it Works (English)</small><br/>
                       <span>{{ $detail->how_it_works_english }}</span>
                   </div>
                   <div class="col-md-4">
                   </div>
               </div>
               <div class="row bg-white">
                     <div class="col-md-4">
                     </div>
                     <div class="col-md-4">
                         <small>How It Works (Filipino)</small><br/>
                         <span>{{ $detail->how_it_works_filipino }}</span>
                     </div>
                     <div class="col-md-4">
                     </div>
                </div>
                <div class="row bg-white">
                       <div class="col-md-4">
                       </div>
                       <div class="col-md-4">
                           <h5>Possible Side Effect</h5>
                       </div>
                       <div class="col-md-4">
                       </div>
                </div>
                <div class="row bg-white">
                       <div class="col-md-4">
                       </div>
                       <div class="col-md-4">
                           <small>Possible Side Effect (English)</small><br/>
                           <span>{{ $detail->side_effect_english }}</span>
                       </div>
                       <div class="col-md-4">
                       </div>
                </div>
                <div class="row bg-white">
                       <div class="col-md-4">
                       </div>
                       <div class="col-md-4">
                           <small>Possible Side Effect (Filipino)</small><br/>
                           <span>{{ $detail->side_effect_filipino }}</span>
                       </div>
                       <div class="col-md-4">
                       </div>
                </div>
               </div>
               <div class="row bg-white">
                       <div class="col-md-4">
                       </div>
                       <div class="col-md-4">
                           <h5>Additional Note</h5>
                       </div>
                       <div class="col-md-4">
                       </div>
                </div>
                <div class="row bg-white">
                       <div class="col-md-4">
                       </div>
                       <div class="col-md-4">
                           <small>Additional Note (English)</small><br/>
                           <span>{{ $detail->additional_note_english }}</span>
                       </div>
                       <div class="col-md-4">
                       </div>
                </div>
                <div class="row bg-white">
                       <div class="col-md-4">
                       </div>
                       <div class="col-md-4">
                           <small>Additional Note (Filipino)</small><br/>
                           <span>{{ $detail->additional_note_filipino }}</span>
                       </div>
                       <div class="col-md-4">
                       </div>
                </div>
                <div class="row big-white">
                    <div class="col-md-6">
                        <a href="{{ route('familyPlanningMethod.edit',$detail->id)}}" class="btn btn-success">Edit Method</a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('familyPlanningMethod.delete',$detail->id)}}" class="btn btn-secondary">Delete Method</a>
                    </div>
                </div>
            </div>
        </main>
        @endforeach
    </div>
</div>
@endsection
