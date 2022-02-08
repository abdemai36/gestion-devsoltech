<?php

namespace App\Http\Controllers;

use App\Models\Sorte;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class UserSortieController extends Controller
{
    public function index(Request $request)
    {
        if(Auth::user()->id)
        {
            $sortiess=Sorte::orderBy('created_at','DESC')->where('user_id',Auth::user()->id);
        }

        if($request->dateDebut && $request->dateFin)
        {
            $sortiess->whereBetween('date', [$request->dateDebut, $request->dateFin]);
        }
        
        $sorties=$sortiess->paginate(5);
        return view("user.sorte",compact('sorties'));
    }

    public function create()
    {
        return view('user.sortieCreate');
    }

    public function store(Request $request)
    {
        $image_name='';
        $validated = $request->validate([
            'date' => 'required|date',
            'name' => 'required',
            'montant' => 'required|numeric',
            'image' => 'mimes:png,jpg,jpeg'
        ]); 

        if($request->has('image'))
        {
            $file=$request->image;
            $image_name=time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploards'),$image_name);
        }

        $name=$request->name;
        $date=$request->date;
        $montant=$request->montant;
        $designiation=$request->designiation;
        $image=$image_name;
        $charge=$request->charge;
        $id_user=$request->idUser;

        Sorte::create([
            'name'=>$name,
            'date' => $date,
            'montant' => $montant,
            'designiation' => $designiation,
            'image' => $image,
            'charge' => $charge,
            'user_id' => $id_user
        ]);

        return redirect()->to(route('user.sortie'))->with(['success' => 'Ajouté avec success']);
    }

    public function exportPDF(Request $request)
    {
        if(empty($request->dateDebut) && empty($request->dateFin) )
        {
            return redirect()->back()->with(['error'=>'Veuillez filtrer avant d\'imprimer']);
        }else
        {
            $sortiess=Sorte::orderBy('created_at','DESC')->where('user_id',Auth::user()->id);
            
            if($request->dateDebut && $request->dateFin)
            {
                $sortiess->whereBetween('date', [$request->dateDebut, $request->dateFin]);
            }
            $sorties=$sortiess->paginate(100);

            $pdf = PDF::loadView('pdf.sorte', compact('sorties'));
            return $pdf->download(Carbon::now()->format('d-m-y').'-sortie.pdf');
        }
        
    }

    public function edit($id)
    {
        $sortie = Sorte::find($id);
        return view('user.sortieEdit')->with(['sortie' => $sortie]);
    }
}
