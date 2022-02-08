@extends('admin.layout.master')
@section('page')
  Employés
@endsection
@section('content')
    <div class="container-fluid py-4">
        <div class="page-header">
            <div class="container">
              <div class="row">
                <div class="col-md-12 d-flex flex-column ">
                  <div class="card card-plain">
                    <div class="card-header">
                      <h4 class="font-weight-bolder">Modifier l'employee</h4>
                      <p class="mb-0"></p>
                    </div>
                    <div class="card-body">
                      @if ($errors->any())
                        <div class="alert alert-primary alert-dismissible text-white" role="alert">
                          <span class="text-sm">{{ $errors->first() }}</span><br>
                          <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                      @endif

                      @if (Session::has("success"))
                        <div class="alert alert-success alert-dismissible text-white" role="alert">
                          <span class="text-sm">{{ Session::get('success') }}</span><br>
                          <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                      @endif
                      <form role="form" method="POST" action="{{ route('admin.update',$user->id) }}">
                        @csrf
                        @method('put')
                        <div class="input-group input-group-outline mb-3">
                          <label class="form-label">Name</label>
                          <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                        </div>
                        <div class="input-group input-group-outline mb-3">
                          <label class="form-label">Email</label>
                          <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                        </div>
                        <div class="input-group input-group-outline mb-3">
                          <label class="form-label">Fonction</label>
                          <input type="text" name="function" class="form-control" value="{{ $user->function }}">
                        </div>
                        <div class="input-group input-group-outline mb-3">
                          <label class="form-label">Password</label>
                          <input type="password" name="password" class="form-control">
                        </div>
                        <div class="form-check form-check-info text-start ps-0">
                          @foreach ($user->roles as $role)
                          @if ($role->name == 'admin')
                            <input class="form-check-input" type="checkbox" value="{{ $role->name }}" name="admin" id="flexCheckDefault" checked>
                            <label class="form-check-label" for="flexCheckDefault">
                              <a href="javascript:;" class="text-dark font-weight-bolder">Admin ?</a>
                            </label>
                          @else
                            <input class="form-check-input" type="checkbox" value="{{ $role->name }}" name="admin" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                              <a href="javascript:;" class="text-dark font-weight-bolder">Admin ?</a>
                            </label>
                          @endif
                        @endforeach
                        </div>
                        <div class="text-center">
                          <button type="submit" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">Modifier</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
    </div>
@endsection