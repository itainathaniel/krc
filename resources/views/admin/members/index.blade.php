{{-- @extends ('admin') --}}
@extends ('layouts.app')

@section ('content')
	<div class="container-fluid">
	    <div class="row">
    	    <div class="col-md-8 col-md-offset-2">
        	    <div class="panel panel-default">
            	    <div class="panel-heading">All Members</div>

	                <div class="panel-body">
						@foreach ($members as $member)
							{{ $member->name_english }}<br>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
@stop