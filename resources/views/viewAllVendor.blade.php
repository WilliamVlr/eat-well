@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/viewall.css') }}">
@endsection

<x-admin-nav></x-admin-nav>


<h1 class="text-center mt-5 fw-semibold">All Vendors</h1>

<div class="d-flex justify-content-center align-items-center mt-2" style="width: 100vw">
    <div class="" style="width: 80vw">
        <form action="/view-vendors" method="POST" class="d-flex jusify-content-center align-items-center" role="search">
            @csrf
            @method('post')
            <input class="form-control me-2" type="search" placeholder="Search vendor name" aria-label="Search"
                name="name" />
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
    </div>

</div>


<div class="container mt-3">
    <div class="row d-flex justify-content-center align-items-center">
        @foreach ($vendors as $vendor)
                <div class="card col-md-3 mt-3 mx-3" style="width: 18rem;">
                    <div class="imgstyle m-2"
                        style="background-color:black; border-radius:100%; width:100px; height:100px">
                        {{-- <img class="card-img-top" src="{{ $vendor->logo }}" alt="Card image cap" width="100px"> --}}
                        <img class="card-img-top" src="{{ asset('asset/catering/homepage/breakfastPreview.jpg') }}" alt="Card image cap" width="120px" style="border-radius: 100%">
                    </div>

                    <hr>

                    <div class="card-body">
                        <h5 class="card-title">{{ $vendor->name }}</h5>
                        <p class="card-text">Telp : {{ $vendor->phone_number }}</p>
                        <p class="card-text">Address : {{ $vendor->address->jalan . ', ' . $vendor->address->kota }}</p>
                        <a href="{{ route('catering-detail', $vendor) }}" class="btn btn-primary" style="background-color: green">View Detail</a>
                    </div>
                </div>
        @endforeach


    </div>
</div>



<!-- Nothing in life is to be feared, it is only to be understood. Now is the time to understand more, so that we may fear less. - Marie Curie -->
</div>

{{-- nanti pakai card saja, bisa di ridirect ke vendor detail --}}
