@extends('user.layout.master')

@section('page')
  Table de bord
@endsection

@section('content')
<div class="container-fluid py-4">
  <div class="row mb-5">
    <div class="col-md-12">
      <div class="input-group input-group-outline mt-3 w-100 d-flex justify-content-between">
          <div class="cards3 w-100">
            <form action="{{ route('dashboard') }}" class="cards2 w-100">
              <input type="date" class="form-control" name="dateDebut" id="dateDebut" value="{{ request()->input('dateDebut')}}">
              <input type="date" class="form-control" name="dateFin" id="dateFin" value="{{ request()->input('dateFin')}}">
              <button type="submit" class="btn btn-success font-weight-bold text-xs badge h-100 w-100 text-center"><i class="fas fa-search"></i> Filtrer </button>
            </form>
              @if (Request::query('dateDebut') || Request::query('dateFin'))
                <a href="{{ route('dashboard') }}" class="btn btn-warning font-weight-bold text-xs badge h-100 text-center"> Annuler </a>
              @endif
          </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-header p-3 pt-2">
          <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
            <i class="fas fa-arrow-alt-circle-left text-white"></i>
          </div>
          <div class="text-end pt-1">
            <p class="text-sm mb-0 text-capitalize">Total des sorties</p>
            <h4 class="mb-0">{{ $total_Sorte }} DH</h4>
          </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-3">
          <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+55% </span>du mois dernier</p>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-4">
      <div class="card">
        <div class="card-header p-3 pt-2">
          <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
            <i class="fas fa-arrow-alt-circle-right text-white"></i>
          </div>
          <div class="text-end pt-1">
            <p class="text-sm mb-0 text-capitalize">Total des entré</p>
            <h4 class="mb-0">{{ $total_Entre }} DH</h4>
          </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-3">
          <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+5% </span>than yesterday</p>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-header p-3 pt-2">
          <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
            <i class="fas fa-hand-holding-usd"></i>
          </div>
          <div class="text-end pt-1">
            <p class="text-sm mb-0 text-capitalize">Bénéfice net</p>
            @if ($BNT <= 0)
              <h4 class="mb-0 text-danger">{{ $BNT }} DH</h4>
            @else
              <h4 class="mb-0">{{ $BNT }} DH</h4>
            @endif
          </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-3">
          <p class="mb-0"><span class="text-danger text-sm font-weight-bolder">-2%</span> than yesterday</p>
        </div>
      </div>
    </div>
  </div>
  <div class="row mt-4">
    <div class="col-lg-4 col-md-6 mt-4 mb-4">
      <div class="card z-index-2 ">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
          <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
            <div class="chart">
              <canvas id="chart-bars" class="chart-canvas" height="170"></canvas>
            </div>
          </div>
        </div>
        <div class="card-body">
          <h6 class="mb-0 ">Bénéfice par mois</h6>
          <hr class="dark horizontal">
          <div class="d-flex ">
            <i class="material-icons text-sm my-auto me-1">schedule</i>
            <p class="mb-0 text-sm"> campaign sent 2 days ago </p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6 mt-4 mb-4">
      <div class="card z-index-2  ">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
          <div class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1">
            <div class="chart">
              <canvas id="chart-line" class="chart-canvas" height="170"></canvas>
            </div>
          </div>
        </div>
        <div class="card-body">
          <h6 class="mb-0 "> Statiqtique des entré </h6>
          <hr class="dark horizontal">
          <div class="d-flex ">
            <i class="material-icons text-sm my-auto me-1">schedule</i>
            <p class="mb-0 text-sm"> updated 4 min ago </p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 mt-4 mb-3">
      <div class="card z-index-2 ">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
          <div class="bg-gradient-dark shadow-dark border-radius-lg py-3 pe-1">
            <div class="chart">
              <canvas id="chart-line-tasks" class="chart-canvas" height="170"></canvas>
            </div>
          </div>
        </div>
        <div class="card-body">
          <h6 class="mb-0 ">Statiqtique des sortie</h6>
          <hr class="dark horizontal">
          <div class="d-flex ">
            <i class="material-icons text-sm my-auto me-1">schedule</i>
            <p class="mb-0 text-sm"></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row mb-4">
    <div class="col-lg-6 col-md-6 mb-md-0 mb-4">
      <div class="card">
        <div class="card-header pb-0">
          <div class="row">
            <div class="col-lg-6 col-7">
              <h6>Les entrés du mois {{ Carbon\Carbon::now()->format('M') }}</h6>
            </div>
          </div>
        </div>
        <div class="card-body px-0 pb-2">
          <div class="table-responsive">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nom</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Montant</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">La date</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Validation</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">LES CHARGES</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">DÉSIGNATION</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">image</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($last_entres as $last_entre)
                <tr>
                  <td>
                    <div class="d-flex px-2 py-1">
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-0 text-sm">{{ $last_entre->name }}</h6>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="avatar-group mt-2">
                      <h6 class="mb-0 text-sm">{{ $last_entre->montant }}</h6>
                    </div>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <span class="text-xs font-weight-bold"> {{ $last_entre->date }} </span>
                  </td>
                  <td>
                    @if ($last_entre->validation == 'non-valide')
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
                  <td class="align-middle">
                    <div class="align-middle text-center text-sm">
                      <span class="text-xs font-weight-bold"> {{ $last_entre->charge }} </span>
                    </div>
                  </td>
                  <td class="align-middle">
                    <div class="align-middle text-center text-sm">
                      <span class="text-xs font-weight-bold"> {{ Illuminate\Support\Str::limit($last_entre->designiation, 30) }} </span>
                    </div>
                  </td>
                  <td class="align-middle text-center">
                    @if ($last_entre->image != null)
                      <a href="{{ asset('uploards/'.$last_entre->image) }}" target="_blank"><img width="50px" height="50px" class="rounded-circle" src="{{ asset('uploards/'.$last_entre->image) }}" alt=""></a>                                
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 mb-md-0 mb-4">
      <div class="card">
        <div class="card-header pb-0">
          <div class="row">
            <div class="col-lg-6 col-7">
              <h6>Les sorties du mois {{ Carbon\Carbon::now()->format('M') }} </h6>
            </div>

          </div>
        </div>
        <div class="card-body px-0 pb-2">
          <div class="table-responsive">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nom</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Montant</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">La date</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Validation</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">LES CHARGES</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">DÉSIGNATION</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">image</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($last_sortes as $last_sorte)
                <tr>
                  <td>
                    <div class="d-flex px-2 py-1">
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-0 text-sm">{{ $last_sorte->name }}</h6>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="avatar-group mt-2">
                      <h6 class="mb-0 text-sm">{{ $last_sorte->montant }}</h6>
                    </div>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <span class="text-xs font-weight-bold"> {{ $last_sorte->date }} </span>
                  </td>
                  <td>
                    @if ($last_sorte->validation == 'non-valide')
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
                  <td class="align-middle">
                    <div class="align-middle text-center text-sm">
                      <span class="text-xs font-weight-bold"> {{ $last_sorte->charge }} </span>
                    </div>
                  </td>
                  <td class="align-middle">
                    <div class="align-middle text-center text-sm">
                      <span class="text-xs font-weight-bold"> {{Illuminate\Support\Str::limit($last_sorte->designiation, 30) }} </span>
                    </div>
                  </td>
                  <td class="align-middle text-center">
                    @if ($last_sorte->image != null)
                      <a href="{{ asset('uploards/'.$last_sorte->image) }}" target="_blank"><img width="50px" height="50px" class="rounded-circle" src="{{ asset('uploards/'.$last_sorte->image) }}" alt=""></a>                                
                    @endif
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
            <a  class="font-weight-bold" >Abdellah mailal & Mouad el mhali</a>
            for a better web.
          </div>
        </div>
      </div>
    </div>
  </footer>
</div>
@endsection