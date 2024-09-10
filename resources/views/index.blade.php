@extends('layouts.app')

@section('title', 'Dashboard - Student')

@section('content')
    <div class="container mt-5">
        <div class="card card-primary">
            <div class="card-header text-center">
                <img src="{{ asset('img/energeek2 1.png') }}" alt="Energeek Logo" class="img-fluid" style="max-width: 200px;">
            </div>

            <!-- Form Start -->
            <div class="card-body">
                <div class="row">
                    <input type="hidden" name="created_by" value="{{ $user['created_by'] ?? 1 }}">
                    <!-- Nama Input -->
                    <div class="col-md-4 mb-3">
                        <label for="nama">Nama</label>
                        <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama"
                            value="{{ $user['name'] ?? '' }}" >
                    </div>
                    <!-- Username Input -->
                    <div class="col-md-4 mb-3">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" class="form-control" placeholder="Username"
                            value="{{ $user['username'] ?? '' }}" >
                    </div>
                    <!-- Email Input -->
                    <div class="col-md-4 mb-3">
                        <label for="email">Email</label>
                        <div class="input-group">
                            <input type="email" id="email" name="email" class="form-control" placeholder="Email"
                                value="{{ $user['email'] ?? '' }}" >
                        </div>
                    </div>
                </div>
            </div>
<div class="card-body">
    <div class="row">
        <div class="col-md-12">
            <!-- Gunakan d-flex dan justify-content-between untuk meluruskan elemen -->
            <div class="d-flex justify-content-between align-items-center">
                <h3>To Do List</h3>
                <button type="button" id="addTask" class="btn btn-outline-danger btn-sm">+ Tambah To Do</button>
            </div>
        </div>
    </div>

    <!-- To-Do Items (Full Width) -->
    <div id="todoItems" class="mt-3">
        @foreach ($tasks as $task)
            <div class="row mb-3 todo-item align-items-center">
    <!-- Label dan Title Input -->
    <div class="col-md-9">
        <label for="todoTitle_{{ $task->id }}">Judul To Do</label>
        <input type="text" id="todoTitle_{{ $task->id }}" class="form-control" placeholder="Judul To Do" value="{{ $task->title }}">
    </div>

    <!-- Label dan Category Select -->
    <div class="col-md-2">
        <label for="todoCategory_{{ $task->id }}">Kategori</label>
        <select id="todoCategory_{{ $task->id }}" class="form-control">
            @foreach ($categories as $category)
                <option value="{{ $category['id'] }}" {{ $task->category_id == $category['id'] ? 'selected' : '' }}>
                    {{ $category['name'] }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Delete Button -->
    <div class="col-md-1 mt-4 d-flex align-items-center justify-content-center">
        <form action="{{ route('todo.destroy', $task->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm w-100">
                <i class="bi bi-trash"></i>
            </button>
        </form>
    </div>
</div>

        @endforeach
    </div>
</div>



        </div>
    </div>

    <!-- Modal for Adding New Task -->
    <div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="addTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTaskModalLabel">Tambah To Do</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addTaskForm" action="{{ route('todo.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="taskTitle">Judul</label>
                            <input type="text" class="form-control" id="taskTitle" name="title" placeholder="Judul To Do" required>
                        </div>
                        <div class="form-group">
                            <label for="taskCategory">Kategori</label>
                            <select class="form-control" id="taskCategory" name="category_id" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="taskDescription">Deskripsi</label>
                            <textarea class="form-control" id="taskDescription" name="description" placeholder="Deskripsi To Do"></textarea>
                        </div>
                        <input type="hidden" name="user_id" value="{{ $user['id'] ?? '' }}"> <!-- Use user ID -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- AdminLTE Scripts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Show modal for adding new task
        $('#addTask').click(function() {
            $('#addTaskModal').modal('show');
        });

        // Handle task deletion with SweetAlert2
        $('.btn-danger').click(function(e) {
            e.preventDefault();
            var form = $(this).closest('form');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak akan dapat mengembalikan item ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        // Check for session success or error messages
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 1500
            });
        @elseif (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 1500
            });
        @endif
    </script>
@endsection
