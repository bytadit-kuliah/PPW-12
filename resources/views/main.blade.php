{{-- <!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.2/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <title>Praktikum 12 - M0520006</title>
  </head>
  <body>
    <div class="container">
        <nav class="navbar navbar-light bg-light">
            <span class="navbar-brand mb-0 h1">Manajemen Barang</span>
        </nav>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="text-right">
          @auth
              <a href="{{ url('/home') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Home</a>
          @else
              <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

              @if (Route::has('register'))
                  <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
              @endif
          @endauth
        </div>
        <div class="main">
            @auth
              <button type="button" class="btn btn-success my-5" data-toggle="modal" data-target="#tambahModal">
                  <i class="bi bi-plus"></i> Tambah Barang
              </button>
            @endauth
            <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Barang</th>
                    <th scope="col">Stok</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($barangs as $barang)
                    <tr>
                      <th scope="row">{{$loop->iteration}}</th>
                      <td>{{$barang->nama}}</td>
                      <td>{{$barang->stok}}</td>
                      <td>
                        @foreach ($barang->barangKategoris as $barangKategori)
                            - {{$barangKategori->kategori->nama}} <br>
                        @endforeach
                      </td>
                      <td>
                        @auth
                          <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" data-toggle="modal" data-target="#editModal{{$barang->id}}" class="btn btn-primary mr-3 rounded">Edit</button>
                            <button type="button" data-toggle="modal" data-target="#deleteModal{{$barang->id}}" class="btn btn-danger rounded">Delete</button>
                          </div>
                        @endauth
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
        </div>
    </div>

    <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="POST" action="{{url('/barang/create')}}">
                    @csrf
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Tambah Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control {{$errors->has('nama') ? 'is-invalid' : ''}}" id="nama" name="nama">
                            @if($errors->has('nama'))
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('nama') }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="Stok">Stok</label>
                            <input type="number" class="form-control {{$errors->has('stok') ? 'is-invalid' : ''}}" id="Stok" name="stok">
                            @if($errors->has('stok'))
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('stok') }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="kategori">Kategori</label> <br>
                            <select name="kategori[]" multiple="multiple" id="kategori" style="width: 100%">
                                @foreach ($kategoris as $kategori)
                                    <option value="{{$kategori->id}}">{{$kategori->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($barangs as $barang)
        <div class="modal fade" id="editModal{{$barang->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form method="POST" action="{{url('/barang/update/'.$barang->id)}}">
                        @csrf
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Update Barang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" value="{{$barang->nama}}" class="form-control {{$errors->has('nama') ? 'is-invalid' : ''}}" id="nama" name="nama">
                                @if($errors->has('nama'))
                                    <div class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nama') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="Stok">Stok</label>
                                <input type="number" value="{{$barang->stok}}" class="form-control {{$errors->has('stok') ? 'is-invalid' : ''}}" id="Stok" name="stok">
                                @if($errors->has('stok'))
                                    <div class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('stok') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="kategori{{$barang->id}}">Kategori</label> <br>
                                <select name="kategori[]" multiple="multiple" id="kategori{{$barang->id}}" style="width: 100%">
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{$kategori->id}}" {{$barang->hasKategoriById($kategori->id) ? 'selected' : ''}}>{{$kategori->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteModal{{$barang->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form method="POST" action="{{url('/barang/delete/'.$barang->id)}}">
                        @csrf
                        <div class="modal-body" style="height:100px; display:flex; align-items:center; justify-content:center;">
                            <h5 class="text-center">Apakah anda yakin ingin menghapus barang?</h5>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">Ya</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#kategori').select2();
        });
    </script>

    @foreach ($barangs as $barang)
    <script>
        $(document).ready(function() {
            $('#kategori'.$barang->id).select2();
        });
    </script>
    @endforeach
  </body>
</html> --}}



@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

            <div class="container">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="main">
                    @auth
                      <button type="button" class="btn btn-success my-5" data-toggle="modal" data-target="#tambahModal">
                          <i class="bi bi-plus"></i> Tambah Barang
                      </button>
                    @endauth
                    <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th scope="col">No</th>
                            <th scope="col">Barang</th>
                            <th scope="col">Stok</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($barangs as $barang)
                            <tr>
                              <th scope="row">{{$loop->iteration}}</th>
                              <td>{{$barang->nama}}</td>
                              <td>{{$barang->stok}}</td>
                              <td>
                                @foreach ($barang->barangKategoris as $barangKategori)
                                    - {{$barangKategori->kategori->nama}} <br>
                                @endforeach
                              </td>
                              <td>
                                @auth
                                  <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" data-toggle="modal" data-target="#editModal{{$barang->id}}" class="btn btn-primary mr-3 rounded">Edit</button>
                                    <button type="button" data-toggle="modal" data-target="#deleteModal{{$barang->id}}" class="btn btn-danger rounded">Delete</button>
                                  </div>
                                @endauth
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                </div>
            </div>

            <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form method="POST" action="{{url('/barang/create')}}">
                            @csrf
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Tambah Barang</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control {{$errors->has('nama') ? 'is-invalid' : ''}}" id="nama" name="nama">
                                    @if($errors->has('nama'))
                                        <div class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nama') }}</strong>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="Stok">Stok</label>
                                    <input type="number" class="form-control {{$errors->has('stok') ? 'is-invalid' : ''}}" id="Stok" name="stok">
                                    @if($errors->has('stok'))
                                        <div class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('stok') }}</strong>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="kategori">Kategori</label> <br>
                                    <select name="kategori[]" multiple="multiple" id="kategori" style="width: 100%">
                                        @foreach ($kategoris as $kategori)
                                            <option value="{{$kategori->id}}">{{$kategori->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @foreach ($barangs as $barang)
                <div class="modal fade" id="editModal{{$barang->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form method="POST" action="{{url('/barang/update/'.$barang->id)}}">
                                @csrf
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle">Update Barang</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="nama">Nama</label>
                                        <input type="text" value="{{$barang->nama}}" class="form-control {{$errors->has('nama') ? 'is-invalid' : ''}}" id="nama" name="nama">
                                        @if($errors->has('nama'))
                                            <div class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('nama') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="Stok">Stok</label>
                                        <input type="number" value="{{$barang->stok}}" class="form-control {{$errors->has('stok') ? 'is-invalid' : ''}}" id="Stok" name="stok">
                                        @if($errors->has('stok'))
                                            <div class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('stok') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="kategori{{$barang->id}}">Kategori</label> <br>
                                        <select name="kategori[]" multiple="multiple" id="kategori{{$barang->id}}" style="width: 100%">
                                            @foreach ($kategoris as $kategori)
                                                <option value="{{$kategori->id}}" {{$barang->hasKategoriById($kategori->id) ? 'selected' : ''}}>{{$kategori->nama}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="deleteModal{{$barang->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form method="POST" action="{{url('/barang/delete/'.$barang->id)}}">
                                @csrf
                                <div class="modal-body" style="height:100px; display:flex; align-items:center; justify-content:center;">
                                    <h5 class="text-center">Apakah anda yakin ingin menghapus barang?</h5>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger">Ya</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach


          <!-- Optional JavaScript -->
            <!-- jQuery first, then Popper.js, then Bootstrap JS -->
            <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <script>
                $(document).ready(function() {
                    $('#kategori').select2();
                });
            </script>

            @foreach ($barangs as $barang)
            <script>
                $(document).ready(function() {
                    $('#kategori'.$barang->id).select2();
                });
            </script>
            @endforeach


    </div>
</div>
@endsection
