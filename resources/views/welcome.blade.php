@extends('layouts.home')

@section('content')
    <section class="section-header overflow-hidden pt-7 pt-lg-8 pb-9 pb-lg-12 bg-primary text-white">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="fw-bolder">Dinas Pendidikan Cabang Wilayah Kediri</h1>
                    <h2 class="lead fw-normal text-muted mb-5">Monitoring Pelayanan</h2>
                </div>
            </div>
            <div class="d-flex justify-content-center gap-3">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-secondary">Login</a>
                    <a href="{{ route('track') }}" class="btn btn-secondary">Tracking layanan</a>
                @else
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Dashboard</a>
                @endguest
            </div>
        </div>
        <figure class="position-absolute bottom-0 left-0 w-100 d-none d-md-block mb-n2">
            <svg class="home-pattern" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3000 185.4">
                <path d="M3000,0v185.4H0V0c496.4,115.6,996.4,173.4,1500,173.4S2503.6,115.6,3000,0z"></path>
            </svg>
        </figure>
    </section>
@endsection
