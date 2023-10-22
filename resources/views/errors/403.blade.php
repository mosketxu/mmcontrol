@extends('errors::illustrated-layout')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Forbidden'))

@section('image')
{{-- <a href="{{ route('logout') }}" class="ml-4 text-sm text-gray-700 underline" onclick="event.preventDefault(); this.closest('form').submit();"> {{ __('Log Out') }} </a> --}}
{{-- <div style="background-image: url('/img/grafitexLogo.png');" class="absolute bg-no-repeat bg-cover pin md:bg-left lg:bg-center">
{{-- </div> --}}
@endsection
