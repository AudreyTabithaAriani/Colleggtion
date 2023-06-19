@extends('template', ['pageTitle' => 'Login'])
@section('content')
<div class="flex justify-center items-center h-screen">
    <div class="w-full max-w-md">
        <div class="bg-base-300 m-7 sm:m-0 sm:h-fit shadow-md rounded-2xl px-8 pt-6 pb-8 mb-4">
            <div class="text-center mb-4">
                <h2 class="text-3xl font-bold">Login</h2>
            </div>
            <div class="mb-4">
                <a href="/auth/google" class="btn btn-primary w-full">
                    Login with Google
                </a>
            </div>
            <div class="divider mb-4">
                <span class="text-gray-400">OR</span>
            </div>
            <form action="">
                @csrf
                <div class="mb-4 w-full">
                    <label class="label-text block text-secondary-content font-bold mb-2" for="email">
                        Email
                    </label>
                    <input disabled class="input w-full input-bordered  @error('email') border-red-500 @enderror"
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                    autofocus>
                    @error('email')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="label-text block text-secondary-content font-bold mb-2" for="password">
                        Password
                    </label>
                    <input disabled class="input w-full input-bordered @error('password') border-red-500 @enderror"
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password">
                    @error('password')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                    <div class="flex flex-col">
                        <div class="mb-4 text-center">
                            <button disabled class="btn btn-disabled w-full" type="submit">
                            Login
                            </button>
                        </div>
                        <div class="text-center">
                            <label class="inline-block align-baseline font-bold text-sm text-gray-500">
                                Forgot Password?
                            </label>
                        </div>
                    </div>
            </form>
            <div class="text-center mt-4">
                <span class="text-gray-400">Don't have an account?</span>
            <label class="text-gray-500 font-bold">Register</label>
        </div>
    </div>
</div>
</div>
@endsection
