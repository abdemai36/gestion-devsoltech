@extends('admin.layout.master')

@section('page')
  Employés
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3">
            <a class="nav-link text-white border-radius-lg text-center me-2 mb-5 bg-gradient-success" href="{{ route('admin.create') }}">
                <i class="material-icons opacity-10"></i>
               <strong>+</strong> ajouter un Employee
            </a>
        </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card my-4">
          @if (Session::has("success"))
            <div class="alert alert-success alert-dismissible text-white" role="alert">
              <span class="text-sm">{{ Session::get('success') }}</span><br>
              <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          @endif
          <h3>Gestion des utilisateurs</h3>
          <div class="card-body px-0 pb-2">
            <div class="table-responsive p-0">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Employe</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Function</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Le role</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date d'inscription</th>
                    <th class="text-secondary opacity-7"></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($users as $item)
                  <tr>
                    <td>
                      <div class="d-flex px-2 py-1">
                      
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0 text-sm">{{ $item->name }}</h6>
                          <p class="text-xs text-secondary mb-0">{{ $item->email }}</p>
                        </div>
                      </div>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">{{ $item->function }}</p>
                      <p class="text-xs text-secondary mb-0"></p>
                    </td>
                    <td>
                      @foreach ($item->roles as $role)
                        @if ($role->name == 'admin')
                          <p class="badge badge-sm bg-gradient-success">
                                {{ $role->name }}
                          </p>
                        @else
                          <p class="badge badge-sm bg-gradient-info">
                            {{ $role->name }}
                          </p>
                        @endif
                      @endforeach
                    </td>                    
                    <td class="align-middle text-center">
                      <span class="text-secondary text-xs font-weight-bold">{{ $item->created_at }}</span>
                    </td>
                    <td class="align-middle d-grid">
                      <a href="{{ route('admin.edit',$item->id ) }}" class="btn btn-info font-weight-bold text-xs badge " data-toggle="tooltip" data-original-title="Edit user">
                        modifier
                      </a>
                      <form action="{{ route('admin.delete',$item->id ) }}" method="POST" id="from_delete" class="w-100">
                        @csrf
                        <button type="submit" class="btn btn-danger font-weight-bold text-xs badge w-100" >
                          supprimer
                        </button>
                      </form>
                    </td>
                  </tr>
                  @endforeach                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <footer class="footer py-4  ">
      <div class="container-fluid">
        <div class="row align-items-center justify-content-lg-between">
          <div class="col-lg-6 mb-lg-0 mb-4">
            <div class="copyright text-center text-sm text-muted text-lg-start">
              © <script>
                document.write(new Date().getFullYear())
              </script>,
              made with <i class="fa fa-heart"></i> by
              <a class="font-weight-bold">Abdellah mailal & Mouad el mhali</a>
              for a better web.
            </div>
          </div>

        </div>
      </div>
    </footer>
  </div>
@endsection