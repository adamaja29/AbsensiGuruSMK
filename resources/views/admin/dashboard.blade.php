@extends ('layouts.admin.main')
@section('title','Dashboard')
@section('content')
<div class="container-xl admin-page">
    <div class="page-header admin-page-header">
        <div>
            <h2 class="page-title">Dashboard</h2>
            <div class="text-secondary mt-2">Ringkasan aktivitas dan pengelolaan absensi sekolah.</div>
        </div>
    </div>

    <div class="row row-deck row-cards">
        <div class="col-sm-6 col-lg-4">
            <div class="card admin-stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="admin-stat-icon bg-primary-lt text-primary me-3">
                            <i class="bi bi-person-badge"></i>
                        </div>
                        <div>
                            <div class="text-secondary mb-1">Data Guru</div>
                            <div class="h1 mb-0">Kelola</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
