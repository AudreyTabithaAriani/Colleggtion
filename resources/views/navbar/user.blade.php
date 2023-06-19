<div class="navbar navbar-fixed bg-base-100">
	<div class="navbar-start">
		

	<div class="dropdown">
      <button class="btn btn-square btn-ghost">
	<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-5 h-5 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
	</button>
      <ul tabindex="0" class="menu dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-52">
        <li><a href="/">Homepage</a></li>
        <li><a href="/breed">Breed</a></li>
        <li><a href="/buy">Buy {{$system->currency}}</a></li>
      </ul>
    </div>
</div>
<div class="navbar-center hidden md:flex">
	
	<a class="btn btn-ghost normal-case text-xl" href="/"><img class="h-10" src="{{ asset($system->gameIcon) }}" />Colleggtion</a>
</div>
<div class="navbar-end ">
	<a class="btn btn-ghost normal-case" href="/buy"><img class="h-5" src="{{ asset($system->currencyIcon) }}" />{{number_format(round($player->coins() / 1000, 1),1) . 'K'}} {{$system->currency}}</a>

	<div class="dropdown dropdown-end">
		<label tabindex="0" class="btn btn-ghost btn-circle avatar">
			<div class="w-10 rounded-full">
				<img src="{{ asset($player->profile) }}" />
			</div>
		</label>
		<ul tabindex="0" class="mt-3 p-2 shadow menu dropdown-content bg-base-100 rounded-box w-32">
			<!-- <li><a>Profile</a></li> -->
			<li><a href="logout">Logout</a></li>
		</ul>
	</div>
	
</div>

</div>