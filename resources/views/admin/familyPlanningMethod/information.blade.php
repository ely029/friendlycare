@extends('layouts.admin.dashboard')

@section('title', 'Family Planning Method')
@section('description', 'Dashboard')

@section('content')
<div class="wrapper">
@include('includes.sidebar')
</div>
<div class="section">
        <div class="section__top">
          <h1 class="section__title">COC / pills</h1>
          <div class="breadcrumbs"><a class="breadcrumbs__link" href="family-planning-methods.php">Family planning methods</a><a class="breadcrumbs__link" href="method-profile.php">COC / pills</a><a class="breadcrumbs__link"></a></div>
        </div>
        <div class="section__container">
          <form class="form" action="">
            <ul class="form__group form__group--uploadViewMethod">
              <li class="form__group-item">
                <div class="form__wrapper"><img class="form__image form__image--method" src="img/placeholder.jpg" alt="Image placeholder" /></div>
              </li>
              <li class="form__group-item">
                <div class="form__content form__content--reverse"><label class="form__label form__label--blue">Combined oral contraceptive (COC) or pills</label></div>
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
                <div class="form__content form__content--reverse"><label class="form__label form__label--visible">Sa tamang paggamit</label><span class="form__text">99.7%</span></div>
                <div class="form__content form__content--reverse"><label class="form__label form__label--visible">Tipikal na bisa</label><span class="form__text">92.0%</span></div>
              </li>
              <li class="form__group-item">
                <h2 class="section__heading">Description</h2>
                <div class="form__content form__content--reverse">
                  <label class="form__label form__label--visible">Description (English)</label>
                  <span class="form__text">Naglalaman ng dalawang synthetic hormones (estrogen at progesterone), gaya ng natural na ginagawa ng katawan ng babae.</span>
                </div>
                <div class="form__content form__content--reverse">
                  <label class="form__label form__label--visible">Description (Filipino)</label>
                  <span class="form__text">Naglalaman ng dalawang synthetic hormones (estrogen at progesterone), gaya ng natural na ginagawa ng katawan ng babae.</span>
                </div>
                <h2 class="section__heading">How it works</h2>
                <div class="form__content form__content--reverse">
                  <label class="form__label form__label--visible">How it works (English)</label>
                  <span class="form__text">Sa pag dagdag ng estrogen at progesterone, mapipigilan ang paglabas ng itlog mula sa ovaries. Pinapakapal ang cervical mucus na humahadlang sa pagpasok ng itlog sa uterus or matris.</span>
                </div>
                <div class="form__content form__content--reverse">
                  <label class="form__label form__label--visible">How it works (Filipino)</label>
                  <span class="form__text">Sa pag dagdag ng estrogen at progesterone, mapipigilan ang paglabas ng itlog mula sa ovaries. Pinapakapal ang cervical mucus na humahadlang sa pagpasok ng itlog sa uterus or matris.</span>
                </div>
                <h2 class="section__heading">Possible side effects</h2>
                <div class="form__content form__content--reverse">
                  <label class="form__label form__label--visible">Possible side effects (English)</label><span class="form__text">Pagkahilo o pagsusuka </span>
                  <span class="form__text">Spotting, light bleeding na hindi napapanahon sa regla </span><span class="form__text">Weight gain </span><span class="form__text">Bahagyang sakit ng ulo </span>
                  <span class="form__text">Breast tenderness</span>
                </div>
                <div class="form__content form__content--reverse">
                  <label class="form__label form__label--visible">Possible side effects (Filipino)</label><span class="form__text">Pagkahilo o pagsusuka </span>
                  <span class="form__text">Spotting, light bleeding na hindi napapanahon sa regla </span><span class="form__text">Weight gain </span><span class="form__text">Bahagyang sakit ng ulo </span>
                  <span class="form__text">Breast tenderness</span>
                </div>
                <h2 class="section__heading">Additional notes</h2>
                <div class="form__content form__content--reverse">
                  <label class="form__label form__label--visible">Additional notes (English)</label>
                  <span class="form__text">
                    Walang dapat ikabahala sa mga karaniwang side effect ng paggamit ng COC. Unti-unting nababawasan ang mga ito sa tuluyan at di napuputol na paggamit. Karaniwang nawawala ang mga side effect makalipas ng ilang buwan.
                  </span>
                </div>
                <div class="form__content form__content--reverse">
                  <label class="form__label form__label--visible">Additional notes (Filipino)</label>
                  <span class="form__text">
                    Walang dapat ikabahala sa mga karaniwang side effect ng paggamit ng COC. Unti-unting nababawasan ang mga ito sa tuluyan at di napuputol na paggamit. Karaniwang nawawala ang mga side effect makalipas ng ilang buwan.
                  </span>
                </div>
              </li>
            </ul>
            <div class="form__button form__button--start"><a class="button" href="edit-method.php">Edit method</a><button class="button button--transparent" type="button">Delete method</button></div>
          </form>
        </div>
      </div>
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
