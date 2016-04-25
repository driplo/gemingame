@extends('layouts.main')

@section('content')


<div class="mdl-grid">
  <h3>Ideas list</h3>
</div>

@if (isset($isAuth))
  <a href="ideas/new">Create idea</a>
@else
  <p>Salut</p>
@endif


<div class="mdl-grid">
  @foreach ($ideas as $idea)
  <div class="mdl-cell mdl-cell--4-col-desktop">
    <div class="mdl-card mdl-shadow--2dp">
      <div class="mdl-card__title mdl-card--expand">
        <h2 class="mdl-card__title-text">{{ $idea->title}}</h2>
      </div>
      <div class="mdl-card__supporting-text">
        {{ $idea->content}}
      </div>
      <div class="mdl-card__actions mdl-card--border">
        <a href="/idea/{{$idea->id}}" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
          View details
        </a>
        <a href="ideas/new/{{$idea->id}}" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
          Rebondir sur cette idée
        </a>
      </div>
    </div>
  </div>
  @endforeach

</div>
@endsection
