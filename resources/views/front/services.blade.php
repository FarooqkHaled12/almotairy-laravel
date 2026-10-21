@extends('front.layouts.app')

@php($lang = session('locale', 'ar'))

@section('title', $lang === 'ar' ? 'خدماتنا العقارية | المطيري للعقارات' : 'Our Services | Almotairy Real Estate')

@push('styles')
    <link rel="stylesheet" href="{{ asset('front/css/home-services.css') }}">
@endpush

@section('content')
    @include('front.homepage.services')
@endsection
