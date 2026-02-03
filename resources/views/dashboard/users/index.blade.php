@extends('layouts.dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">
                
                <div class="card-header bg-white border-0 py-4 px-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1 fw-bold" style="color: #2d3436;">Data Users</h4>
                        <p class="text-muted small mb-0">Kelola informasi akun dan hak akses pengguna di sini.</p>
                    </div>
                    <a href="{{ route('dashboard.users.create') }}" class="btn btn-primary shadow-sm px-4 py-2" style="border-radius: 12px; transition: all 0.3s;">
                        <i class="fas fa-plus-circle me-2"></i> Add New User
                    </a>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive p-4">
                        <table class="table align-middle" id="users-table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">ID</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User Info</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Role Access</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="border-top-0">
                                @foreach ($users as $user)
                                <tr>
                                    <td class="ps-4">
                                        <span class="text-xs font-weight-bold text-secondary">#{{ $user->id }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1 align-items-center">
                                            <div class="avatar-circle me-3">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-0 text-sm fw-bold" style="color: #2d3436;">{{ $user->name }}</h6>
                                                <p class="text-xs text-muted mb-0">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($user->role === 'admin')
                                            <span class="badge badge-admin">ADMIN</span>
                                        @else
                                            <span class="badge badge-user">PETUGAS</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('dashboard.users.edit', $user->id) }}" 
                                               class="btn btn-action btn-edit" 
                                               title="Edit User">
                                                <i class="fas fa-pen-to-square"></i>
                                            </a>
                                            
                                            @unless($loop->first && $user->role === 'admin')
                                            <a href="{{ route('dashboard.users.destroy', $user->id) }}" 
                                               class="btn btn-action btn-delete" 
                                               data-confirm-delete="true"
                                               title="Delete User">
                                                <i class="fas fa-trash-can"></i>
                                            </a>
                                            @endunless
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.6/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* Global Overrides */
    body { background-color: #f8f9fe; }
    
    /* Table Styling */
    .table thead th {
        background-color: #fbfbfb;
        border-bottom: 1px solid #f0f0f0 !important;
        letter-spacing: 0.05em;
    }
    .table tbody td {
        border-bottom: 1px solid #f8f9fa;
        padding: 1rem 0.5rem;
    }
    
    /* Avatar Circle */
    .avatar-circle {
        width: 38px;
        height: 38px;
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 14px;
    }

    /* Modern Badges */
    .badge-admin {
        background-color: #e3f2fd;
        color: #1976d2;
        padding: 0.5em 1em;
        border-radius: 8px;
        font-size: 0.7rem;
    }
    .badge-user {
        background-color: #f5f5f5;
        color: #616161;
        padding: 0.5em 1em;
        border-radius: 8px;
        font-size: 0.7rem;
    }

    /* Action Buttons */
    .btn-action {
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        transition: all 0.2s;
        border: none;
    }
    .btn-edit { background-color: #fff4e5; color: #ff9800; }
    .btn-edit:hover { background-color: #ff9800; color: white; transform: translateY(-2px); }
    
    .btn-delete { background-color: #ffebee; color: #f44336; }
    .btn-delete:hover { background-color: #f44336; color: white; transform: translateY(-2px); }

    /* Customizing DataTable Search */
    .dataTables_filter input {
        border-radius: 10px !important;
        border: 1px solid #eee !important;
        padding: 8px 15px !important;
        background-color: #fcfcfc !important;
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.3.6/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.6/js/dataTables.bootstrap5.js"></script>

<script>
    $(document).ready(function () {
        $('#users-table').DataTable({
            responsive: true,
            language: {
                search: "",
                searchPlaceholder: "Search users...",
                paginate: {
                    previous: "<i class='fas fa-chevron-left'></i>",
                    next: "<i class='fas fa-chevron-right'></i>"
                }
            },
            dom: '<"d-flex justify-content-between align-items-center mb-3"fl>rt<"d-flex justify-content-between align-items-center mt-3"ip>'
        });
    });
</script>
@endpush