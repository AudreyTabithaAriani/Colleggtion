@extends('template', ['pageTitle' => "Balance"])
@section('header')
@include('navbar.user')
@endsection
@section('content')
<div class="flex justify-center items-center min-h-screen">
	<div class="w-full max-w-2xl px-5">
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
		<div class="card card-normal mb-5 w-full bg-base-content text-base-100 shadow-xl">
			<div class="card-body w-full">
				<h2 class="card-title text-3xl font-bold">Balance</h2>
				<span class="text-xl font-light text-base-100"><img class="inline-block mr-2 h-8" src="{{ asset($system->currencyIcon) }}" />{{number_format($player->coins())}} {{$system->currency}}</span>
				<span class="text-xl font-light text-base-100"><img class="inline-block mr-2 h-6" src="img/icons/cash.png" />{{number_format($player->balance())}} IDR</span>
				<div class="card-actions justify-end mt-5">
					<div class="join w-full">
						<button class="btn btn-outline text-base-100 hover:bg-base-300/20 w-1/2 join-item" onclick="withdraw.showModal()">Withdraw</button>
						<button class="btn join-item w-1/2" onclick="deposit.showModal()">Deposit</button>
					</div>
				</div>
			</div>
			<dialog id="withdraw" class="modal">
			<form method="POST" action="/withdraw" class="dialog modal-box">
				@csrf
				<button for="withdraw" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" onClick="withdraw.close()" type="button">✕</button>
				<h3 class="font-bold text-xl">Withdraw</h3>
				<div class="join input-group mt-5 mb-3">
					<input class="w-full input input-bordered join-item" placeholder="Amount" name="amount"/>
					<span class="join-item">IDR</span>
				</div>
				<button class="w-full btn rounded-xl join-item" >Withdraw</button>
			</form>
			</dialog>
			<dialog id="deposit" class="modal">
			<form method="POST" action="/deposit" class="dialog modal-box">
				@csrf
				<button for="deposit" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" onClick="deposit.close()" type="button">✕</button>
				<h3 class="font-bold text-xl">Withdraw</h3>
				<div class="join input-group mt-5 mb-3">
					<input class="w-full input input-bordered join-item" placeholder="Amount" name="amount"/>
					<span class="join-item">IDR</span>
				</div>
				<button class="w-full btn rounded-xl" >Deposit</button>
			</form>
			</dialog>
		</div>
		<div class="card card-normal w-full bg-base-300 shadow-xl px-5">
			<div class="card-body w-full">
				<h2 class="card-title text-3xl font-bold">Trade {{$system->currency}}</h2>
				<button class="w-full btn rounded-xl join-item" onclick="sellCoin.showModal()">Sell</button>
				<dialog id="sellCoin" class="modal">
				<form method="POST" action="/sellCoins" class="dialog modal-box">
					@csrf
					<button for="sellCoin" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" onClick="sellCoin.close()" type="button">✕</button>
					<h3 class="font-bold text-xl">Sell {{$system->currency}}</h3>
					<div class="join input-group mt-5 mb-3">
						<input class="w-full input input-bordered join-item" placeholder="Amount" name="amount"/>
						<span class="join-item">{{$system->currency}}</span>
						<input class="w-full input input-bordered join-item" placeholder="Price" name="price"/>
						<span class="join-item">IDR</span>
					</div>
					<button class="w-full btn rounded-xl join-item" >Sell</button>
				</form>
				</dialog>
				<div class="overflow-x-auto">
					<table class="table">
						<!-- head -->
						<thead>
							<tr>
								<th class="hidden sm:table-cell"></th>
								<th>Amount</th>
								<th>Price</th>
								<th class="hidden sm:table-cell">Average</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<!-- row 1 -->
							@foreach ($trades as $trade)
							<tr>
								<td class="hidden sm:table-cell">
									<div class="flex items-center space-x-2">
										<div class="avatar">
											<div class="mask mask-circle w-10 h-10">
												<img src="{{$trade->player()->first()->profile}}"  />
											</div>
										</div>
									</div>
								</td>
								<td>
									{{$trade->coins}}
								</td>
								<td>
									{{$trade->price}}
								</td>
								<td class="hidden sm:table-cell">
									{{$trade->coins/$trade->price}}
								</td>
								<th>
									@if($trade->user != $player->id)
									<button class="btn w-full" onclick="buyTrade{{$trade->id}}.showModal()">Buy</button>
									@else
									<button class="btn btn-error btn-outline w-full" onclick="buyTrade{{$trade->id}}.showModal()">Remove</button>
									@endif
								</th>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				@foreach ($trades as $trade)
				<dialog id="buyTrade{{$trade->id}}" class="modal">
				<form method="POST" action="/buyCoins" class="dialog modal-box">
					@csrf
					<input type="hidden" name="trade" value="{{$trade->id}}">
					<button for="buyTrade{{$trade->id}}" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" onClick="buyTrade{{$trade->id}}.close()" type="button">✕</button>
					<h3 class="font-bold text-xl">Buy {{$system->currency}}</h3>
					@if($trade->user != $player->id)
					<div class="my-5">Are you sure you want to buy {{$trade->coins}} {{$system->currency}} for {{$trade->price}} IDR?</div>
					@else
					<div class="my-5">Are you sure you want to remove this trade?</div>
					@endif
					@if($trade->user != $player->id)
					<button class="w-full btn rounded-xl join-item mt-5" >Buy</button>
					@else
					<button class="w-full btn rounded-xl join-item mt-5" >Remove</button>
					@endif
				</form>
				</dialog>
				@endforeach
			</div>
		</div>
	</div>
</div>
@endsection
