@extends('admin.layouts.main')
@section('title')
	{{ ucfirst(request()->segment(2)) }}
@endsection
@section('content')

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-header">
                <h2 class="text-center">Trashed Users</h2>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="users" class="table table-sm table-head-fixed text-nowrap">
                <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Status</th>
                  <th>Deleted At</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  @forelse($trashedUsers as $user)
                  <tr>
                    <td><a href="#">{{ $user['name'] }}</a></td>
                    <td>{{ $user['email'] }}</td>
                    <td>
                      <span class="badge badge-info">Admin</span>
                      <span class="badge badge-info">Editor</span>
                    </td>
                    <td>
                      <span class="badge badge-success">Active</span>
                    </td>
                    <td>{{ $user['deleted_at'] }}</td>
                    <td>
                      <form action="{{ route('admin.users.forceDelete', $user['id']) }}" method="post" class="form-horizontal">
                          @csrf
                          @method('DELETE')
                          <div class="btn-group">
                              <a href="{{ route('admin.users.restore', $user['id']) }}" class="btn btn-primary btn-sm" title="Restore">Restore</a>
                              <button  type="submit"  onclick="return confirm('Are you sure!')" class="btn btn-danger btn-sm" title="Delete">Force Delete</button>
                          </div>
                      </form>
                    </td>
                  </tr>
                   
                  @empty
                      <td colspan="5">No Record found</td>
                  @endforelse
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

@section('scripts')

	<script>
	  $(function () {
	    $('#users').DataTable();
	  });
	</script>
@endsection