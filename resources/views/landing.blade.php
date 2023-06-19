@extends('template', ['pageTitle' => 'Colleggtion'])
@section('header')
@include('navbar.guest')
@endsection
@section('content')
<div class="hero min-h-screen" style="background-image: url(/img/landing.png);">
  <div class="hero-overlay bg-opacity-50"></div>
  <div class="hero-content text-center text-neutral-content">
    <div class="max-w-lg">
      <h1 class="mb-5 text-5xl font-bold">Colleggtion</h1>
      <p class="mb-5">Welcome to Colleggtion! Buy eggs, hatch animals, and trade them with other players to make a profit. Join our community now and see if you have what it takes to become the ultimate Colleggtion master!</p>
      <a class="btn btn-primary" href="/login">Get Started</a>
    </div>
  </div>
</div>
@endsection
