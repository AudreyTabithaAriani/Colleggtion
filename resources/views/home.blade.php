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
<div class="bg-base-200 px-5 md:sm-10 lg:px-20 py-5 min-h-screen grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
	<div class="card h-fit bg-base-100 shadow-md shadow-green-600/50 hover:shadow-xl hover:shadow-green-600/90">
	<figure><img src="/img/landingEgg.png" alt="Shoes" /></figure>
	<div class="card-body">
		<h2 class="card-title">Egg</h2>
		<p><img class="inline-block mr-2 h-5" src="{{ asset($system->currencyIcon) }}" />{{$player->eggPrice()}} {{$system->currency}}</p>
		<div class="card-actions justify-end">
			<button class="btn btn-sm" onclick="buyEgg.showModal()">Buy Egg</button>
		</div>
	</div>
</div>
<dialog id="buyEgg" class="modal">
<form method="POST" action="/buyEgg" class="dialog modal-box">
	@csrf
	<button for="buyEgg" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" onClick="buyEgg.close()" type="button">✕</button>
	<h3 class="font-bold text-xl">Buy Egg</h3>
	<div class="mt-5 mb-3">
		Are you sure you want to buy an egg for {{$player->eggPrice()}} {{$system->currency}}?
	</div>
	<button class="w-full btn rounded-xl join-item" >Buy</button>
</form>
</dialog>
@foreach($player->unhatchedEggs() as $egg)
<div class="card h-fit bg-base-100 shadow-md shadow-green-600/50 hover:shadow-xl hover:shadow-green-600/90">
<figure><img src="/img/landingEgg.png" alt="Shoes" /></figure>
<div class="card-body">
	<form method="POST" action="/hatch" >
		@csrf
		<input type="hidden" name="egg" value="{{$egg->id}}">
		<h2 class="card-title">Egg</h2>
		<p>Unhatched Egg</p>
		<div class="card-actions justify-end">
			<button class="btn btn-sm">Hatch</button>
		</div>
	</form>
</div>
</div>
@endforeach
@foreach($player->owned() as $animal)
@if ($animal->rarity <= 0.7)
<div class="card h-fit bg-base-100 shadow-md shadow-green-600/50 hover:shadow-xl hover:shadow-green-600/90">
@elseif ($animal->rarity <= 0.2)
<div class="card h-fit bg-base-100 shadow-md shadow-yellow-600/50 hover:shadow-xl hover:shadow-yellow-600/90">
	@elseif ($animal->rarity <= 0.07)
	<div class="card h-fit bg-base-100 shadow-md shadow-orange-600/50 hover:shadow-xl hover:shadow-orange-600/90">
		@elseif ($animal->rarity <= 0.02)
		<div class="card h-fit bg-base-100 shadow-md shadow-red-600/50 hover:shadow-xl hover:shadow-red-600/90">
			@elseif ($animal->rarity <= 0.01)
			<div class="card h-fit bg-base-100 shadow-md shadow-blue-600/50 hover:shadow-xl hover:shadow-blue-600/90">
				@endif
			<figure><img src="{{ asset($animal->image) }}" /></figure>
			<div class="card-body">
				<h2 class="card-title">{{$animal->name()}}</h2>
				<p><img class="inline-block mr-2 h-5" src="{{ asset($system->currencyIcon) }}" />{{$animal->price}} {{$system->currency}}</p>
				<p class="mb-5">{{(1-$animal->rarity)*100}}% Rarity</p>
				<div class="card-actions justify-end">
					<button class="btn btn-outline btn-error btn-sm" onclick="burnConfirm{{$animal->id}}.showModal()">Burn</button>
					<form method="POST" action="/breed" >
						@csrf
						<input type="hidden" name="animalOne" value="{{$animal->id}}">
						<button class="btn btn-sm">Breed</button>
					</form>
				</div>
			</div>
		</div>
		<dialog id="burnConfirm{{$animal->id}}" class="modal">
		<form method="POST" action="/burn" class="dialog modal-box">
			@csrf
			<input type="hidden" name="animal" value="{{$animal->id}}">
			<button for="burnConfirm{{$animal->id}}" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" onClick="burnConfirm{{$animal->id}}.close()" type="button">✕</button>
			<h3 class="font-bold text-xl">Burn {{$animal->name()}}</h3>
			<div class="my-5">Are you sure you want to burn {{$animal->name()}}? This action can't be undone</div>
			<button class="w-full btn btn-error rounded-xl join-item" >Burn</button>
		</form>
		</dialog>
		@endforeach
	</div>
	@endsection
