@extends('user.layout.master')

@section('page')
  Entré
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3">
            <a class="nav-link text-white border-radius-lg text-center me-2 mb-5 bg-gradient-success" href="{{ route('user.create.entre') }}">
                <i class="material-icons opacity-10"></i>
               <strong>+</strong> Ajouter un entré
            </a>
        </div>
    </div>
    <div class="row">
      <div class="col-md-6 m-auto">
        @if (Session::has("error"))
        <div class="alert alert-danger alert-dismissible text-white" role="alert">
          <span class="text-sm">{{ Session::get('error') }}</span><br>
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
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card my-4">
          <div class="pe-md-3 d-flex align-items-center ">
            <div class="input-group input-group-outline mt-3 w-100 d-flex justify-content-between p-3">
              <h3>Gestion d'entré</h3>
                <div class="cards2 w-100">
                  <form action="" class="cards">
                    <input type="date" class="form-control" name="dateDebut" id="dateDebut" value="{{ request()->input('dateDebut')}}">
                    <input type="date" class="form-control" name="dateFin" id="dateFin" value="{{ request()->input('dateFin')}}">
                    <button onclick="sort_search();" class="btn btn-success font-weight-bold text-xs badge h-100 w-100 text-center"><i class="fas fa-search"></i> Filtrer</button>
                  </form>
                    @if (Request::query('inputSearchentre') || Request::query('dateDebut') || Request::query('dateFin'))
                      <a href="{{ route('user.entre') }}" class="btn btn-warning font-weight-bold text-xs badge h-100 text-center"> Annuler </a>
                    @endif
                    <form action="{{ route('user.entre.exportPDF') }}" class="d-flex">
                      <input type="hidden" class="form-control" name="dateDebut" id="dateDebut" value="{{ request()->input('dateDebut')}}">
                      <input type="hidden" class="form-control" name="dateFin" id="dateFin" value="{{ request()->input('dateFin')}}">
                      <button type="submit" class="btn btn-danger font-weight-bold text-xs badge h-100 w-100 text-center" >PDF</button>
                    </form>
                </div>
            </div>
          </div>
          <div class="card-body px-0 pb-2">
            <div class="table-responsive p-0">
              <table class="table align-items-center mb-0" id='table_entre'>
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nom </th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Montant</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">La date</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Validation</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Les charges</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Désignation</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Image</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($entres as $entre)
                        <tr>
                            <td>
                              <p class="text-xs font-weight-bold mb-0">{{ $entre->name }}</p>
                            </td>
                            <td>
                                <p class="badge badge-sm bg-gradient-info">
                                    {{ $entre->montant }} DH
                                </p>
                            </td>  
                            <td>
                              <div class="d-flex px-2 py-1">
                                  <div class="d-flex flex-column justify-content-center">
                                  <h6 class="mb-0 text-sm">{{ $entre->date }}</h6>
                                  </div>
                              </div>
                            </td>  
                            <td>
                              @if ($entre->validation == 'non-valide')
                                <div class="d-flex px-2 py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                      <h6 class="badge badge-sm bg-gradient-danger">Non-valide</h6>
                                    </div>
                                </div>
                              @else
                                <div class="d-flex px-2 py-1">
                                  <div class="d-flex flex-column justify-content-center">
                                    <h6 class="badge badge-sm bg-gradient-success">Valide</h6>
                                  </div>
                                </div>
                              @endif
                            </td>                   
                            <td class="align-middle text-center">
                                <span class="text-secondary text-xs font-weight-bold">{{ $entre->charge }}</span>
                            </td>
                            <td class="align-middle text-center">
                                <span class="text-secondary text-xs font-weight-bold">{{ Str::limit($entre->designiation, 50, '...') }} </span>
                            </td>
                            <td class="align-middle text-center">
                              @if ($entre->image != null)
                                <a href="{{ asset('uploards/'.$entre->image) }}" target="_blank"><img class="rounded-circle" width="50px" height="50px" src="{{ asset('uploards/'.$entre->image) }}" alt=""></a>                                
                              @endif
                            </td>
                            <td class="align-middle d-grid">                         
                                <a href="{{ route('user.edit.entre',$entre->id) }}" class="btn btn-info font-weight-bold text-xs badge " data-toggle="tooltip" data-original-title="Edit user">
                                  modifier
                                </a>
                                <form action="{{ route('user.delete.entre',$entre->id) }}" method="POST" id="from_delete" class="w-100">
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
              {{ $entres->links('admin.layout.my_pagination') }}
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
              <a href="" class="font-weight-bold">Abdellah mailal & Mouad el mhali</a>
              for a better web.
            </div>
          </div>
          <div class="col-lg-6">
            
          </div>
        </div>
      </div>
    </footer>
  </div>
@endsection

@section('javascript_entre')
  <script>
    var query = <?php echo json_encode((object)Request::query()); ?>;
    
    function sort_search()
    {
      Object.assign(query{'keyword':$('#inputSearchentre').val()});
      Object.assign(query{'dateDebut':$('#dateDebut').val()});
      Object.assign(query{'dateDebut':$('#dateFin').val()});
      window.location.href= "{{ route('user.entre') }}?"+$.param(query);
    }
    
  </script>
@endsection