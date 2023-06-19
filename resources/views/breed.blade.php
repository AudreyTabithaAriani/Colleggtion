@extends('template', ['pageTitle' => 'Colleggtion'])
@section('header')
@include('navbar.user')
@endsection
@section('content')
<div class="mx-5 my-5">
	@if($errors->any())
	<div class="mb-5 alert alert-error">
		<ul>
			@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
	@endif
	@if (session('success'))
	<div class="mb-5 alert alert-success">
		{{ session('success') }}
	</div>
	@endif
</div>
<div class="p-5 ">
	<div class="flex justify-center items-center">
		<!-- card here -->
		@if(isset($animalOne))
		<div class="card h-fit bg-base-100 shadow-md shadow-green-600/50 hover:shadow-xl hover:shadow-green-600/90">
		<figure ><img class="w-40" src="{{ asset(App\Models\Animal::find($animalOne)->image) }}" /></figure>
		<div class="card-body">
			<h2 class="card-title">{{App\Models\Animal::find($animalOne)->name()}}</h2>
			<p><img class="inline-block mr-2 h-5" src="{{ asset($system->currencyIcon) }}" />{{App\Models\Animal::find($animalOne)->price}} {{$system->currency}}</p>
			<div class="card-actions justify-end">
				<form method="POST" action="/breed" >
					@csrf
					@if (isset($animalTwo))
					<input type="hidden" name="animalTwo" value="{{$animalTwo}}">
					@endif
					<button class="btn btn-outline btn-error btn-sm">Remove</button>
				</form>
			</div>
		</div>
	</div>
	@endif
	<div class="divider divider-horizontal">♥</div>
	<!-- card here -->
	@if(isset($animalTwo))
	<div class="card h-fit bg-base-100 shadow-md shadow-green-600/50 hover:shadow-xl hover:shadow-green-600/90">
	<figure><img class="w-40" src="{{ asset(App\Models\Animal::find($animalTwo)->image) }}" /></figure>
	<div class="card-body">
		<h2 class="card-title">{{App\Models\Animal::find($animalTwo)->name()}}</h2>
		<p><img class="inline-block mr-2 h-5" src="{{ asset($system->currencyIcon) }}" />{{App\Models\Animal::find($animalTwo)->price}} {{$system->currency}}</p>
		<div class="card-actions justify-end">
			<form method="POST" action="/breed" >
				@csrf
				@if (isset($animalOne))
				<input type="hidden" name="animalOne" value="{{$animalOne}}">
				@endif
				<button class="btn btn-outline btn-error btn-sm">Remove</button>
			</form>
		</div>
	</div>
</div>
@endif
</div>
@if (isset($animalOne) && isset($animalTwo))
<form method="POST" class="mt-10" action="/breed" >
	@csrf
	<input type="hidden" name="animalOne" value="{{$animalOne}}">
	<input type="hidden" name="animalTwo" value="{{$animalTwo}}">
	<input type="hidden" name="confirmBreed" value="true">
<button class="btn w-full">Breed
	</button>
	</form>
	@endif
</div>
<div class="bg-base-200 px-5 md:sm-10 lg:px-20 py-5 min-h-screen grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
@if(isset($animalOne) && isset($animalTwo))
@elseif(isset($animalOne))
@foreach($player->owned() as $animal)
@if($animal->base()->first() != App\Models\Animal::find($animalOne)->base()->first())
<div class="card h-fit bg-base-100 shadow-md shadow-green-600/50 hover:shadow-xl hover:shadow-green-600/90">
<figure><img src="{{ asset($animal->image) }}" /></figure>
<div class="card-body">
<h2 class="card-title">{{$animal->name()}}</h2>
<p><img class="inline-block mr-2 h-5" src="{{ asset($system->currencyIcon) }}" />{{$animal->price}} {{$system->currency}}</p>
<div class="card-actions justify-end">
	<form method="POST" action="/breed" >
		@csrf
		<input type="hidden" name="animalOne" value="{{$animalOne}}">
		<input type="hidden" name="animalTwo" value="{{$animal->id}}">
		<button class="btn btn-sm">Select</button>
	</form>
</div>
</div>
</div>
@endif
@endforeach
@else
@foreach($player->owned() as $animal)
<div class="card h-fit bg-base-100 shadow-md shadow-green-600/50 hover:shadow-xl hover:shadow-green-600/90">
<figure><img src="{{ asset($animal->image) }}" /></figure>
<div class="card-body">
<h2 class="card-title">{{$animal->name()}}</h2>
<p><img class="inline-block mr-2 h-5" src="{{ asset($system->currencyIcon) }}" />{{$animal->price}} {{$system->currency}}</p>
<div class="card-actions justify-end">
<form method="POST" action="/breed" >
	@csrf
	<input type="hidden" name="animalOne" value="{{$animal->id}}">
	<button class="btn btn-sm">Select</button>
</form>
</div>
</div>
</div>
@endforeach
@endif
</div>
@endsection
