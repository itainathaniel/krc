@extends ('house')

@section ('content')
	<div class="container">
		<div class="columns">
			<div class="column is-half is-offset-one-quarter">
				<figure class="image is-128x128">
					<img src="{{ $member->image }}" style="border-radius:100%;">
				</figure>
			</div>
		</div>
	</div>
@stop

@section ('content1')
	{{ $member }}
	<nav class="level is-mobile">
		<div class="level-item has-text-centered">
			<div>
				<p class="heading">היום</p>
				<p class="title">123</p>
			</div>
		</div>
		<div class="level-item has-text-centered">
			<div>
				<p class="heading">השבוע</p>
				<p class="title">456K</p>
			</div>
		</div>
		<div class="level-item has-text-centered">
			<div>
				<p class="heading">החודש</p>
				<p class="title">789</p>
			</div>
		</div>
	</nav>
	<figure class="image is-128x128">
		<img src="{{ $member->image }}">
	</figure>
@stop