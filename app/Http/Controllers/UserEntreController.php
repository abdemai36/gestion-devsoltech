<?php

namespace App\Http\Controllers;

use App\Models\Entre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class UserEntreController extends Controller
{
    public function index(Request $request)
    {
        if(Auth::user()->id)
        {
            $entress=Entre::orderBy('created_at','DESC')->where('user_id',Auth::user()->id);
        }

        if($request->dateDebut && $request->dateFin)
        {
            $entress->whereBetween('date', [$request->dateDebut, $request->dateFin]);
        }
        
        $entres=$entress->paginate(5);
        return view("user.entre",compact('entres'));
    }

    public function create()
    {
        return view('user.entreCreate');
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

        Entre::create([
            'name'=>$name,
            'date' => $date,
            'montant' => $montant,
            'designiation' => $designiation,
            'image' => $image,
            'charge' => $charge,
            'user_id' => $id_user
        ]);

        return redirect()->to(route('user.entre'))->with(['success' => 'Ajouté avec success']);
    }

    public function exportPDF(Request $request)
    {
        if(empty($request->dateDebut) && empty($request->dateFin) )
        {
            return redirect()->back()->with(['error'=>'Veuillez filtrer avant d\'imprimer']);
        }else
        {
            $entress=Entre::orderBy('created_at','DESC')->where('user_id',Auth::user()->id);
            
            if($request->dateDebut && $request->dateFin)
            {
                $entress->whereBetween('date', [$request->dateDebut, $request->dateFin]);
            }
            $entres=$entress->paginate(100);

            $pdf = PDF::loadView('pdf.entre', compact('entres'));
            return $pdf->download(Carbon::now()->format('d-m-y').'-entre.pdf');
        }
        
    }

   
    public function edit($id)
    {
        $entre = Entre::find($id);
        return view('user.entreEdit')->with(['entre' => $entre]);
    }

}
