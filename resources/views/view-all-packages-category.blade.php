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
        <a href="#" class="btn btn-success d-flex gap-1 align-items-center">
            <span class="material-symbols-outlined">
                add
            </span>
            Category
        </a>
    </section>
    <section class="container-fluid px-sm-5 pb-sm-4">
        <table class="table custom-table mt-3">
            <thead class="table-dark">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Category Name</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Adventure</td>
                    <td class="d-flex flex-wrap gap-1">
                        <a href="#" class="btn btn-primary btn-sm d-flex gap-1 align-items-center" >
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
            </tbody>
        </table>
    </section>
@endsection
