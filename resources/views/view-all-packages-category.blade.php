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
        <button type="button" onclick="openModal()" class="btn btn-success d-flex gap-1 align-items-center">
            <span class="material-symbols-outlined">
                add
            </span>
            Category
        </button>
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
    <div id="addCategoryModal" class="custom-modal hidden">
        <div class="custom-modal-content">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="custom-modal-header">
                    <h5 class="modal-title">Add New Category</h5>
                    <button type="button" class="close-modal-btn" onclick="closeModal()">×</button>
                </div>
                <div class="custom-modal-body">
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Category Name</label>
                        <input type="text" name="categoryName" id="categoryName"
                            class="form-control @error('categoryName') is-invalid @enderror"
                            value="{{ old('categoryName') }}" required>
                        @error('categoryName')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="custom-modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn btn-success">Add Category</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalBackdrop" class="modal-backdrop hidden" onclick="closeModal()"></div>
@endsection

@section('scripts')
    <script>
        function openModal() {
            document.getElementById('addCategoryModal').classList.remove('hidden');
            document.getElementById('modalBackdrop').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('addCategoryModal').classList.add('hidden');
            document.getElementById('modalBackdrop').classList.add('hidden');
        }

        // Show modal if there is validation error
        @if ($errors->has('categoryName'))
            window.addEventListener('DOMContentLoaded', () => {
                openModal();
            });
        @endif
    </script>
@endsection
