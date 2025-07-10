@php
    use Carbon\Carbon;
@endphp

@extends('components.admin-nav')

@section('css')
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/adminTable.css') }}">
@endsection

@section('content')
    <section class="container-fluid pt-3 pt-sm-4 px-sm-5 d-flex justify-content-between align-items-center">
        <h1 class="text-center m-0">Category List</h1>
        <a href="#" class="btn btn-success d-flex gap-1 align-items-center" data-bs-toggle="modal"
            data-bs-target="#addCategoryModal">
            <span class="material-symbols-outlined">
                add
            </span>
            Category
        </a>
    </section>
    <section class="container-fluid px-sm-5 pb-sm-4">
        <div class="table-responsive">
            <table class="table custom-table mt-3">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Category Name</th>
                        <th scope="col">Created at</th>
                        <th scope="col">Updated at</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $cat)
                        <tr>
                            <td>{{ $cat->categoryId }}</td>
                            <td>{{ $cat->categoryName }}</td>
                            <td>{{ Carbon::parse($cat->created_at)->format('d M Y') }}</td>
                            <td>{{ Carbon::parse($cat->updated_at)->format('d M Y') }}</td>
                            <td class="d-flex flex-wrap gap-1">
                                <a href="#" class="btn btn-primary btn-sm d-flex gap-1 align-items-center">
                                    <span class="material-symbols-outlined">
                                        edit
                                    </span>
                                    Edit
                                </a>
                                <a href="#" class="btn btn-danger btn-sm d-flex gap-1 align-items-center">
                                    <span class="material-symbols-outlined">
                                        delete
                                    </span>
                                    Delete
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">

        </div>
    </div>

    <form action="{{ route('categories.store') }}" method="POST" class="modal-content">
        @csrf
        <label for="categoryName" class="form-label">Category Name</label>
        <input type="text" name="categoryName" id="categoryName"
            class="form-control">
        @error('categoryName')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror
        {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button> --}}
        <button type="submit" class="btn btn-success">Add Category</button>
        {{-- <div class="modal-header">
            <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label for="categoryName" class="form-label">Category Name</label>
                <input type="text" name="categoryName" id="categoryName"
                    class="form-control @error('categoryName') is-invalid @enderror" value="{{ old('categoryName') }}"
                    required>
                @error('categoryName')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success">Add Category</button>
        </div> --}}
    </form>
@endsection

@section('scripts')
    {{-- @if ($errors->has('categoryName'))
        <script>
            console.log($errors);
            const modal = new bootstrap.Modal(document.getElementById('addCategoryModal'));
            modal.show();
        </script>
    @endif --}}
@endsection
