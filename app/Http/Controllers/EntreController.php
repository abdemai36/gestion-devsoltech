<?php

namespace App\Http\Controllers;

use App\Models\Entre;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class EntreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {  
        $entress=Entre::orderBy('created_at','DESC');
        if($request->inputSearchentre)
        {
            $entress->where('name','LIKE','%'.$request->inputSearchentre.'%')
            ->orWhere('validation','=',$request->inputSearchentre)
            ->orWhere('date','LIKE','%'.$request->inputSearchentre.'%')
            ->orWhere('charge','LIKE','%'.$request->inputSearchentre.'%');
        }
        elseif($request->dateDebut && $request->dateFin)
        {
            $entress->whereBetween('date', [$request->dateDebut, $request->dateFin]);
        }
        
        $entres=$entress->paginate(5);
        return view("admin.entre",compact('entres'));
    }

    public function exportPDF(Request $request)
    {
        if(empty($request->inputSearchentre) && empty($request->dateDebut) && empty($request->dateFin) )
        {
            return redirect()->back()->with(['error'=>'Veuillez filtrer avant d\'imprimer']);
        }else
        {
            $entress=Entre::orderBy('created_at','DESC');
            if($request->inputSearchentre)
            {
                $entress->where('name','LIKE','%'.$request->inputSearchentre.'%')
                ->orWhere('validation','=',$request->inputSearchentre)
                ->orWhere('date','LIKE','%'.$request->inputSearchentre.'%')
                ->orWhere('charge','LIKE','%'.$request->inputSearchentre.'%');
            }elseif($request->dateDebut && $request->dateFin)
            {
                $entress->whereBetween('date', [$request->dateDebut, $request->dateFin]);
            }
            $entres=$entress->paginate(100);

            $pdf = PDF::loadView('pdf.entre', compact('entres'));
            return $pdf->download(Carbon::now()->format('d-m-y').'-entre.pdf');
        }
        
    }

    // funtion use to export output data archeved to PDF 
    public function exportArchivePDF(Request $request)
    {
        if(empty($request->inputSearcharchive) && empty($request->dateDebut) && empty($request->dateFin) )
        {
            return redirect()->back()->with(['error'=>'Veuillez filtrer avant d\'imprimer']);
        }else
        {
            $archive_entre=Entre::onlyTrashed()->orderBy('created_at','DESC');
            if($request->inputSearcharchive)
            {
                $archive_entre->where('name','LIKE','%'.$request->inputSearcharchive.'%')
                ->orWhere('validation','=',$request->inputSearcharchive)
                ->orWhere('date','LIKE','%'.$request->inputSearcharchive.'%')
                ->orWhere('charge','LIKE','%'.$request->inputSearcharchive.'%');
            }elseif($request->dateDebut && $request->dateFin)
            {
                $archive_entre->whereBetween('date', [$request->dateDebut, $request->dateFin]);
            }
            $entres=$archive_entre->paginate(100);

            $pdf = PDF::loadView('pdf.archiveEntre', compact('entres'));
            return $pdf->download(Carbon::now()->format('d-m-y').'-archive-entre.pdf');
        }
        
    }


    //using this function to send input data to archive 
    public function exportArchiffe(Request $request)
    {
        if(empty($request->inputSearcharchive) && empty($request->dateDebut) && empty($request->dateFin) )
        {
            return redirect()->back()->with(['error'=>'Veuillez filtrer avant d\'imprimer']);
        }else
        {
            $archive_entre=Entre::orderBy('created_at','DESC');
            if($request->inputSearcharchive)
            {
                $archive_entre->where('name','LIKE','%'.$request->inputSearcharchive.'%')
                ->orWhere('validation','=',$request->inputSearcharchive)
                ->orWhere('date','LIKE','%'.$request->inputSearcharchive.'%')
                ->orWhere('charge','LIKE','%'.$request->inputSearcharchive.'%');
            }elseif($request->dateDebut && $request->dateFin)
            {
                $archive_entre->whereBetween('date', [$request->dateDebut, $request->dateFin]);
            }
            $entres=$archive_entre->delete();

            return redirect()->back()->with(['success' => 'L\'archivation de entre avec succès']);
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.entreCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

        return redirect()->back()->with(['success' => 'Ajouté avec success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $entre = Entre::find($id);
        return view('admin.entreEdit')->with(['entre' => $entre]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $entre = Entre::find($id);
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
            if($entre->image != null)
                unlink(public_path('uploards').'/'.$entre->image);
            $entre->image=$image_name;
        }

        $name=$request->name;
        $date=$request->date;
        $montant=$request->montant;
        $designiation=$request->designiation;
        $image=$entre->image;
        $charge=$request->charge;
        $id_user=$request->idUser;

        $entre->update([
            'name'=>$name,
            'date' => $date,
            'montant' => $montant,
            'designiation' => $designiation,
            'image' => $image,
            'charge' => $charge,
            'user_id' => $id_user
        ]);

        return redirect()->back()->with(['success' => 'L\'modification avec success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $entre = Entre::find($id);
        if($entre->image != null)
            unlink(public_path('uploards').'/'.$entre->image);
        $entre->forceDelete();
        return redirect()->back()->with(['success' => 'La suppression avec succès']);
    }

    public function valide(Request $request, $id)
    {
        $entre = Entre::find($id);
        if($request->validation == 'Valide')
        {
            $entre->update([
                'validation' => 'non-valide',
            ]);

        }elseif($request->validation == 'non-valide'){

            $entre->update([
                'validation' => 'Valide',
            ]);
            
        }
        
        return redirect()->back();
    }

    //using this function to display input archiverd data in archive page 
    public function selectArchiffeEntre(Request $request)
    {
        $archives_entre=Entre::onlyTrashed()->orderBy('created_at','DESC');
        if($request->inputSearcharchive)
        {
            $archives_entre->where('name','LIKE','%'.$request->inputSearcharchive.'%')
            ->orWhere('validation','=',$request->inputSearcharchive)
            ->orWhere('date','LIKE','%'.$request->inputSearcharchive.'%')
            ->orWhere('charge','LIKE','%'.$request->inputSearcharchive.'%');
        }
        elseif($request->dateDebut && $request->dateFin)
        {
            $archives_entre->whereBetween('date', [$request->dateDebut, $request->dateFin]);
        }
        $entres=$archives_entre->paginate(5);
        return view('admin.archiveEntre')->with(["archivesEntre" => $entres]);
    }
}
