@extends('layouts.admin')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Dashboard
                </div>

                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                
                    <div class="row">
                        <!-- User Info Section -->
                        <div class="col-md-6">
                            <div class="user-info">
                                <p>You are logged in as:</p>
                                <div class="user-name">{{ Auth::user()->name }}</div>
                                <div class="user-roles">
                                    Roles:
                                    @foreach (Auth::user()->roles as $role)
                                        <span class="role">{{ $role->title }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                
                        <!-- Additional Container -->
                        @if($canViewCharts)
                        <div class="col-md-6">
                            <div class="cloud-info">
                                <p>Apakah kamu ingin ke Cloud Tri Astra Persada?</p>
                                <a href="https://cloud.triastrapersada.com" class="fancy-link" target="_blank">Klik ini</a>
                            </div>
                        </div>
                        @endif
                        
                        <style>
                            .fancy-link {
                                margin-top: 20px;
                                display: inline-block;
                                padding: 12px 25px;
                                background-color: #3498db;
                                color: white;
                                text-decoration: none;
                                font-weight: bold;
                                border-radius: 25px;
                                transition: background-color 0.3s, transform 0.3s;
                                box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
                            }
                        
                            .fancy-link:hover {
                                background-color: #2980b9;
                                transform: translateY(-5px);
                                box-shadow: 0px 12px 20px rgba(0, 0, 0, 0.2);
                            }
                        
                            .fancy-link:active {
                                background-color: #1c598a;
                                transform: translateY(0);
                                box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.1);
                            }
                        </style>
                        
                    </div>
                </div>                
            </div>
        </div>
    </div>

    @if($canViewCharts)
    <div class="row my-0.5">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card p-4 shadow-sm" style="border-left: 5px solid #5A67D8;">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="text-left">
                        <h6 class="card-title" style="color: #5A67D8; font-weight: 600;">TOTAL EMPLOYEE</h6>
                        <h2 class="card-text" style="font-weight: bold; color: #333;">{{$totalemployee}}</h2>
                    </div>
                    <i class="bi bi-person-circle" style="font-size: 2.5rem; color: lightgray;"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card p-4 shadow-sm" style="border-left: 5px solid #48BB78;">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="text-left">
                        <h6 class="card-title" style="color: #48BB78; font-weight: 600;">TOTAL PRODUCTS</h6>
                        <h2 class="card-text" style="font-weight: bold; color: #333;">{{$totalproducts}}</h2>
                    </div>
                    <i class="bi bi-box-seam-fill" style="font-size: 2.5rem; color: lightgray;"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card p-4 shadow-sm" style="border-left: 5px solid #4299E1;">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="text-left">
                        <h6 class="card-title" style="color: #4299E1; font-weight: 600;">ORDER</h6>
                        <h2 class="card-text" style="font-weight: bold; color: #333;">{{ $totalorders }}</h2>
                    </div>
                    <i class="bi bi-clipboard-check-fill" style="font-size: 2.5rem; color: lightgray;"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card p-4 shadow-sm" style="border-left: 5px solid #ECC94B;">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="text-left">
                        <h6 class="card-title" style="color: #ECC94B; font-weight: 600;">TOTAL CLIENT</h6>
                        <h2 class="card-text" style="font-weight: bold; color: #333;">{{ $totalClients }}</h2>
                    </div>
                    <i class="bi bi-people-fill" style="font-size: 2.5rem; color: lightgray;"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Chart Section -->
    <div class="row mb-4 my-0.1">
        <div class="col-lg-6 mb-4">
            <div class="card p-4 shadow-sm">
                <div class="card-body">
                    {!! $chart->container() !!}
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card p-4 shadow-sm">
                <div class="card-body">
                    {!! $chart2->container() !!}
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- <!-- Chart Section -->
    <div class="row mb-4 my-0.1">
        <div class="col-lg-6 mb-4">
            <div class="card p-4 shadow-sm">
                <div class="card-body">
                    {!! $chart->container() !!}
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card p-4 shadow-sm">
                <div class="card-body">
                    {!! $chart2->container() !!}
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection

@section('scripts')

@if($chart)
    <script src="{{ $chart->cdn() }}"></script>
    {{ $chart->script() }}
@endif

@if($chart2)
    <script src="{{ $chart2->cdn() }}"></script>
    {{ $chart2->script() }}
@endif

{{-- <script src="{{ $chart->cdn() }}"></script>
{{ $chart->script() }}
<script src="{{ $chart2->cdn() }}"></script>
{{ $chart2->script() }} --}}



@parent
@endsection
