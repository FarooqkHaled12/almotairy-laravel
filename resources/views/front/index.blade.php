@php
    $lang = session('locale', config('app.locale', 'ar'));
@endphp

@extends('front.layouts.app')

@section('title', $lang === 'ar' ? 'المطيري للعقارات - الرئيسية' : 'Al-Motairy Real Estate - Home')

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('front/css/home-hero.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/home-properties.css') }}?v={{ file_exists(public_path('front/css/home-properties.css')) ? filemtime(public_path('front/css/home-properties.css')) : '1' }}">
    <link rel="stylesheet" href="{{ asset('front/css/home-developments.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/home-brand.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/home-about.css') }}?v={{ file_exists(public_path('front/css/home-about.css')) ? filemtime(public_path('front/css/home-about.css')) : '1' }}">
    <link rel="stylesheet" href="{{ asset('front/css/home-services.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/home-explore.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/home-partner.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/home-faq.css') }}">
@endpush

@section('content')
    @include('front.homepage.hero')
    @include('front.homepage.about')
    @include('front.homepage.properties')
    @include('front.homepage.developments')
    @include('front.homepage.services')
    @include('front.homepage.explore')
    @include('front.homepage.partner')
    @include('front.homepage.faq')
    @include('front.homepage.contact')
@endsection
