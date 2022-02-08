<?php

namespace App\Http\Controllers;

use App\Models\Entre;
use App\Models\Sorte;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
     public function index(Request $request)
     {
          if(Auth::user()->hasRole('user'))
          {
               $total_Entre=Entre::orderBy('created_at','DESC')->where('user_id',Auth::user()->id);
               $total_Sorte=Sorte::orderBy('created_at','DESC')->where('user_id',Auth::user()->id);
               if($request->dateDebut && $request->dateFin)
               {
                   $total_Entre->whereBetween('date',[$request->dateDebut,$request->dateFin]);
                   $total_Sorte->whereBetween('date',[$request->dateDebut,$request->dateFin]);
               }
               $total_E =$total_Entre->whereMonth('date',Carbon::now()->month)->where('user_id',Auth::user()->id)->sum('montant');
               $total_S =$total_Sorte->whereMonth('date',Carbon::now()->month)->where('user_id',Auth::user()->id)->sum('montant');
               $BNT =$total_E - $total_S;
     
               //select last 10 entre 
               $last_entres=Entre::whereMonth('date',Carbon::now()->month)->where('user_id',Auth::user()->id)->orderBy('id', 'desc')->take(10)->get();
     
               //select last 10 sorte 
               $last_sortes=Sorte::whereMonth('date',Carbon::now()->month)->where('user_id',Auth::user()->id)->orderBy('id', 'desc')->take(10)->get();
               
               
               return view('user.dashboard')->with([
               'total_Entre' => $total_E,
               'total_Sorte' => $total_S,
               'BNT' => $BNT,
               'last_entres' => $last_entres,
               'last_sortes' => $last_sortes
               ]);     

          }elseif(Auth::user()->hasRole('admin'))
          {
               $total_Entre=Entre::orderBy('created_at','DESC');
               $total_Sorte=Sorte::orderBy('created_at','DESC');
               if($request->dateDebut && $request->dateFin)
               {
                   $total_Entre->whereBetween('date',[$request->dateDebut,$request->dateFin]);
                   $total_Sorte->whereBetween('date',[$request->dateDebut,$request->dateFin]);
               }
               $total_E =$total_Entre->whereMonth('date',Carbon::now()->month)->sum('montant');
               $total_S =$total_Sorte->whereMonth('date',Carbon::now()->month)->sum('montant');
               $BNT =$total_E - $total_S;
     
               //total users
               $user = User::whereRoleIs('user')->count();
     
               //select last 10 entre 
               $last_entres=Entre::whereMonth('date',Carbon::now()->month)->orderBy('id', 'desc')->take(10)->get();
     
               //select last 10 sorte 
               $last_sortes=Sorte::whereMonth('date',Carbon::now()->month)->orderBy('id', 'desc')->take(10)->get();
               
               
               return view('admin.dashboard')->with([
               //'total_Utilis' => $total_Utilis, 
               'total_Entre' => $total_E,
               'total_Sorte' => $total_S,
               'user' => $user,
               'BNT' => $BNT,
               'last_entres' => $last_entres,
               'last_sortes' => $last_sortes
               ]);     
          } 

          
     }
}
