@extends('admin.layouts.main')
@section('title', 'Team Members')

@section('styles')
    <link href="{{ asset('assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content')
    <div class="row small-spacing">
        <div class="col-xs-12">
            <div class="box-content">
                <div class="clearfix bg-lighter">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="mb-0">Team Members</h3>
                        <a href="{{ route('admin.team.create') }}" class="btn btn-primary">
                            <i class="ri-add-box-line"></i> Add Team Member
                        </a>
                    </div>
                </div>

                <!-- Filters -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <form action="{{ route('admin.team.index') }}" method="GET" class="row g-3">
                            <div class="col-md-8">
                                <input type="text" name="search" class="form-control" placeholder="Search by name, position, or email..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="is_active" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                            </div>
                        </form>
                    </div>
                </div>

                <hr>

                <div class="table-responsive">
                    <table id="team-datatable" class="table table-striped table-bordered display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Contact</th>
                                <th>Social Links</th>
                                <th>Status</th>
                                <th>Sort Order</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($teamMembers as $key => $member)
                                <tr id="row_{{ $key }}">
                                    <td>
                                        @if($member->image)
                                            <img src="{{ asset('storage/' . $member->image) }}" alt="{{ $member->name }}" class="rounded-circle" width="50" height="50" style="object-fit: cover;">
                                        @else
                                            <div style="width: 50px; height: 50px; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                <i class="ri-user-line"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td><strong>{{ $member->name }}</strong></td>
                                    <td>{{ $member->position }}</td>
                                    <td>
                                        @if($member->email)
                                            <small><i class="ri-mail-line"></i> {{ $member->email }}</small><br>
                                        @endif
                                        @if($member->phone)
                                            <small><i class="ri-phone-line"></i> {{ $member->phone }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($member->facebook)
                                            <a href="{{ $member->facebook }}" target="_blank" class="btn btn-sm btn-primary" title="Facebook">
                                                <i class="ri-facebook-fill"></i>
                                            </a>
                                        @endif
                                        @if($member->twitter)
                                            <a href="{{ $member->twitter }}" target="_blank" class="btn btn-sm btn-info" title="Twitter">
                                                <i class="ri-twitter-fill"></i>
                                            </a>
                                        @endif
                                        @if($member->linkedin)
                                            <a href="{{ $member->linkedin }}" target="_blank" class="btn btn-sm btn-primary" title="LinkedIn">
                                                <i class="ri-linkedin-fill"></i>
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $member->is_active ? 'success' : 'secondary' }}">
                                            {{ $member->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td><span class="badge bg-secondary">{{ $member->sort_order ?? 0 }}</span></td>
                                    <td>
                                        <div class="btn-group-vertical" role="group">
                                            <a href="{{ route('admin.team.show', $member->id) }}" class="btn btn-info btn-sm" title="View">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <a href="{{ route('admin.team.edit', $member->id) }}" class="btn btn-primary btn-sm" title="Edit">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                            <button type="button"
                                                onclick="toggleStatus('{{ route('admin.team.toggle-status', $member->id) }}', {{ $key }}, '{{ csrf_token() }}', {{ $member->is_active ? 'true' : 'false' }})"
                                                class="btn btn-{{ $member->is_active ? 'warning' : 'success' }} btn-sm">
                                                <i class="ri-{{ $member->is_active ? 'pause' : 'play' }}-line"></i>
                                            </button>
                                            <button type="button"
                                                onclick="confirmDelete('{{ route('admin.team.destroy', $member->id) }}', {{ $key }}, '{{ csrf_token() }}')"
                                                class="btn btn-danger btn-sm">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No team members found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $teamMembers->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/ajax-delete.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#team-datatable').DataTable({
                "paging": false,
                "info": false,
                "searching": false,
                "ordering": true,
                "responsive": true
            });
        });
    </script>
@endsection

