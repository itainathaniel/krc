@extends ('knesset')

@section ('content')
    <div class="row isInside">
        <h1>{{ trans('index.nowInside', ['count' => count($membersInside) ]) }}</h1>

        @foreach ($membersInside as $member)
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 media">
                {{-- <a class="media-center" href="{{ route('member', [$member, $member->slug]) }}">
                    <img src="{{ $member->image }}" alt="{{ $member->name }}" class="img-thumbnail">
                </a> --}}
                <a class="media-body" href="{{ route('member', [$member, $member->slug]) }}">
                    <h5 class="media-heading">{{ $member->name }}</h5>
                </a>
                {{ $member->present ? 'נוכח' : 'לא נוכח' }}
            </div>
        @endforeach
    </div>

    <div class="row">
    	<div class="col-md-6">
            <h3>נכנסו לאחרונה</h3>
            @if (count($membersLatestIn))
                <ul class="media-list users-sniplet">
                    {{-- @include('layouts.partials.membersList', ['members' => $membersLatestIn, 'showTimes' => true]) --}}
                </ul>
            @else
                <div class="alert alert-warning" role="alert">לא נמצאו ח״כים שנכנסו לאחרונה</div>
            @endif
    	</div>
    	<div class="col-md-6">
    	    <h3>יצאו לאחרונה</h3>
    	    @if (count($membersLatestOut))
                <ul class="media-list users-sniplet">
                    {{-- @include('layouts.partials.membersList', ['members' => $membersLatestOut, 'showTimes' => true]) --}}
                </ul>
            @else
                <div class="alert alert-warning" role="alert">לא נמצאו ח״כים שיצאו לאחרונה</div>
            @endif
    	</div>
    </div>
@stop