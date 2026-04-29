@extends('layouts.admin')

@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <strong>Dashboard</strong>
                </div>

                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="welcome-box">
                        <h5 class="mb-2">You are logged in!</h5>

                        <div class="role-wrapper">
                            <span class="role-label">Role login:</span>

                            @forelse(auth()->user()->roles as $role)
                                <span class="role-badge">
                                    {{ $role->title }}
                                </span>
                            @empty
                                <span class="role-badge role-empty">
                                    Tidak ada role
                                </span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .welcome-box {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px;
    }

    .role-wrapper {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 10px;
    }

    .role-label {
        font-weight: 600;
        color: #374151;
        margin-right: 4px;
    }

    .role-badge {
        display: inline-block;
        padding: 7px 14px;
        border-radius: 999px;
        background: linear-gradient(135deg, #2563eb, #7c3aed);
        color: #ffffff;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.3px;
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.25);
    }

    .role-empty {
        background: #6b7280;
        box-shadow: none;
    }
</style>
@endsection

@section('scripts')
@parent

@endsection