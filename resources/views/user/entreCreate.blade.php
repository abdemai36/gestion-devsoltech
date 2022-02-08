@extends('user.layout.master')

@section('page')
  Entré
@endsection


@section('content')
    <div class="container-fluid py-4">
        <div class="page-header">
            <div class="container-sm">
              <div class="row">
                <div class="col-md-12 d-flex flex-column ">
                  <div class="card card-plain">
                    <div class="card-header">
                      <h4 class="font-weight-bolder">Ajouter un entre</h4>
                      <p class="mb-0"></p>
                    </div>
                    <div class="card-body" style="background: white;border-radius: 0 0 0.75rem 0.75rem">
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
                      <form role="form" method="POST" action="{{ route('user.store.entre') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="idUser" value="{{ Auth::user()->id }}">
                        <div class="input-group input-group-outline mb-3">
                          <input type="text" name="date" class="form-control" value="{{Carbon\Carbon::now()->format('Y-m-d')."  ".Carbon\Carbon::now()->format('H:i')}}" readonly>
                        </div>
                        <div class="input-group input-group-outline mb-3">
                          <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" readonly>
                        </div>
                        <div class="form-group">
                            <select id="charge" class="form-control mb-3 p-2" style="border: 1px solid #ddd">
                              <option selected="true" disabled="disabled">Les charges</option>
                              <option value="Charge simple">Charge simple</option>
                              <option value="Charge fix">Charge fix</option>
                              <option value="Charge fournisseur">Charge fournisseur</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select id="sousCharge" name="charge" class="form-control mb-3 p-2" style="border: 1px solid #ddd">
                            </select>
                        </div>
                        <div class="input-group input-group-outline mb-3">
                          <label class="form-label">Montant</label>
                          <input type="number" name="montant" class="form-control" value="{{ old('montant') }}">
                        </div>
                        <div class="custom-file">
                            <input type="file" name="image" class="custom-file-input w-100" id="validatedCustomFile" accept="image/*" capture="camera" style="border: 1px solid #ddd;padding:5px">
                        </div>
                        <div class="form-check form-check-info text-start ps-0">
                            <label for="Désignation">Désignation</label>
                            <textarea style="border: 1px solid #ddd" class="form-control" name="designiation" id="Désignation">{{ old('designiation') }}</textarea> 
                        </div>
                        <div class="text-center">
                          <button type="submit" class="btn btn-lg text-white btn-lg w-100 mt-4 mb-0" style="background: #00B1EB">Ajouter</button>
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