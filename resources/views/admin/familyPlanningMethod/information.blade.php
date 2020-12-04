@extends('layouts.admin.dashboard')

@section('title', 'Family Planning Method')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
@include('includes.sidebar')
</div>
@foreach ($details as $detail)
<div class="section">
        <div class="section__top">
          <h1 class="section__title">{{ $detail->name }} / {{ $detail->short_name }}</h1>
          <div class="breadcrumbs"><a class="breadcrumbs__link" href="{{  route('familyPlanningMethod.index')}}">Family planning methods</a><a class="breadcrumbs__link" href="method-profile.php">{{ $detail->name }} / {{ $detail->short_name }}</a><a class="breadcrumbs__link"></a></div>
        </div>
        <div class="section__container">
          <form class="form" action="">
            <ul class="form__group form__group--uploadViewMethod">
              <li class="form__group-item">
                <div class="form__wrapper"><img class="form__image form__image--method" src="img/placeholder.jpg" alt="Image placeholder" /></div>
              </li>
              <li class="form__group-item">
                <div class="form__content form__content--reverse"><label class="form__label form__label--blue">{{$detail->name}}</label></div>
              </li>
            </ul>
            <div class="form__content form__content--reverse form__content--gallery">
              <h2 class="section__heading">Gallery</h2>
              <ul class="form__gallery form__gallery--method">
                <li class="form__gallery-item"><img class="form__gallery-image" src="img/placeholder.jpg" alt="Gallery image" /></li>
                <li class="form__gallery-item"><img class="form__gallery-image" src="" alt="" /></li>
                <li class="form__gallery-item"><img class="form__gallery-image" src="" alt="" /></li>
                <li class="form__gallery-item"><img class="form__gallery-image" src="" alt="" /></li>
                <li class="form__gallery-item"><img class="form__gallery-image" src="" alt="" /></li>
              </ul>
              <iframe class="form__video" src="https://www.youtube.com/embed/c6DC2FEzVjM" frameborder="0" allowfullscreen></iframe>
            </div>
            <ul class="form__group form__group--viewMethod">
              <li class="form__group-item">
                <h2 class="section__heading">Effectiveness</h2>
                <div class="form__content form__content--reverse"><label class="form__label form__label--visible">Sa tamang paggamit</label><span class="form__text">{{ $detail->percent_effective }}</span></div>
                <div class="form__content form__content--reverse"><label class="form__label form__label--visible">Tipikal na bisa</label><span class="form__text">{{ $detail->typical_validity }}</span></div>
              </li>
              <li class="form__group-item">
                <h2 class="section__heading">Description</h2>
                <div class="form__content form__content--reverse">
                  <label class="form__label form__label--visible">Description (English)</label>
                  <span class="form__text">{{ $detail->description_english }}</span>
                </div>
                <div class="form__content form__content--reverse">
                  <label class="form__label form__label--visible">Description (Filipino)</label>
                  <span class="form__text">{{ $detail->description_filipino }}</span>
                </div>
                <h2 class="section__heading">How it works</h2>
                <div class="form__content form__content--reverse">
                  <label class="form__label form__label--visible">How it works (English)</label>
                  <span class="form__text">{{ $detail->how_it_works_english }}</span>
                </div>
                <div class="form__content form__content--reverse">
                  <label class="form__label form__label--visible">How it works (Filipino)</label>
                  <span class="form__text">{{ $detail->how_it_works_filipino }}</span>
                </div>
                <h2 class="section__heading">Possible side effects</h2>
                <div class="form__content form__content--reverse">
                  <label class="form__label form__label--visible">Possible side effects (English)</label>
                  <span class="form__text">{{ $detail->side_effect_english }} </span>
                </div>
                <div class="form__content form__content--reverse">
                  <label class="form__label form__label--visible">Possible side effects (Filipino)</label>
                  <span class="form__text">{{ $detail->side_effect_filipino }}</span>
                </div>
                <h2 class="section__heading">Additional notes</h2>
                <div class="form__content form__content--reverse">
                  <label class="form__label form__label--visible">Additional notes (English)</label>
                  <span class="form__text">
                  {{ $detail->additional_note_english }}
                  </span>
                </div>
                <div class="form__content form__content--reverse">
                  <label class="form__label form__label--visible">Additional notes (Filipino)</label>
                  <span class="form__text">
                  {{ $detail->additional_note_filipino }}
                  </span>
                </div>
              </li>
            </ul>
            <div class="form__button form__button--start">
            <a class="button" href="{{ route('familyPlanningMethod.edit',$detail->id)}}">Edit method</a>
            <button class="button button--transparent" data-toggle="modal" data-target="#confirmCreateFPM" type="button">Delete method</button></div>
            <div class="modal fade" id="confirmCreateFPM" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Delete Method</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    You are about to delete this method. Proceed?
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <a type="submit" class="btn btn-success" href="{{ route('familyPlanningMethod.delete', $detail->id)}}">Delete Method</a>
                                </div>
                        </div>
                    </div>
            </div>
          </form>
        </div>
      </div>
@endforeach
<!-- <div class="container-fluid">
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
            hidden spacer
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
                <img height="50" width="50" src="{{ url(('uploads/'.$gallery->file_name)) }}">
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
                      {{ $detail->description_filipino }}
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
                        <a data-toggle="modal" data-target="#confirmProviderCreation" href="#" class="btn btn-secondary">Delete Method</a>
                    </div>
                </div>
                <div class="modal fade" id="confirmProviderCreation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Delete Method</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    You are about to delete "{{$detail->name}}". Proceed?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <a href="{{ route('familyPlanningMethod.delete',$detail->id)}}" class="btn btn-success">Delete Method</a>
                                </div>
                        </div>
                    </div>
            </div>
            </div>
        </main>
        @endforeach
    </div>
</div> -->
@endsection
