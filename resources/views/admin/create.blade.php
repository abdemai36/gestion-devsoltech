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
                      <h4 class="font-weight-bolder">Ajouter un Employee</h4>
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
                      <form role="form" method="POST" action="{{ route('admin.store') }}">
                        @csrf
                        <div class="input-group input-group-outline mb-3">
                          <label class="form-label">Name</label>
                          <input type="text" name="name" class="form-control">
                        </div>
                        <div class="input-group input-group-outline mb-3">
                          <label class="form-label">Email</label>
                          <input type="email" name="email" class="form-control">
                        </div>
                        <div class="input-group input-group-outline mb-3">
                          <label class="form-label">Fonction</label>
                          <input type="text" name="function" class="form-control">
                        </div>
                        <div class="input-group input-group-outline mb-3">
                          <label class="form-label">Password</label>
                          <input type="password" name="password" class="form-control">
                        </div>
                        <div class="form-check form-check-info text-start ps-0">
                          <input class="form-check-input" type="checkbox" value="" name="admin" id="flexCheckDefault">
                          <label class="form-check-label" for="flexCheckDefault">
                            <a href="javascript:;" class="text-dark font-weight-bolder">Admin ?</a>
                          </label>
                        </div>
                        <div class="text-center">
                          <button type="submit" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">Ajouter</button>
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