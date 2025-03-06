@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Pengaturan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Pengaturan</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-8">

                    <div class="card">
                        <div class="card-header">
                            <strong>Ubah Password</strong>                        
                        </div>
                        <div class="card-body p-4">
                            <form method="POST" action="{{ route('pengaturan.store') }}">
                                @csrf
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" value="" name="password">
                                    </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <strong>Ubah Profile</strong>                        
                        </div>
                        <div class="card-body p-4">
                            <form method="POST" action="{{ route('pengaturan.update', $data->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="name">Nama</label>
                                    <input type="text" class="form-control" value="{{$data->name ?? ''}}" name="name" required>
                                </div>

                                <div class="form-group">
                                    <label for="name">No HP</label>
                                    <input type="text" class="form-control" value="{{$data->no_hp ?? ''}}" name="no_hp" required>
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                    {{-- @if(Auth::user()->role !== 'admin')
                    @endif --}}

                </div>
            </div>
        </div>
    </section>
@endsection