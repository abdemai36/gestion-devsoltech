<?php

namespace App\Http\Controllers;

use App\Models\Sorte;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SorterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     //function using to display output data 
    public function index(Request $request)
    {
        $sortess=Sorte::orderBy('created_at','DESC');
        if($request->inputSearchSorte)
        {
            $sortess->where('name','LIKE','%'.$request->inputSearchSorte.'%')
            ->orWhere('validation','=',$request->inputSearchSorte)
            ->orWhere('date','LIKE','%'.$request->inputSearchSorte.'%')
            ->orWhere('charge','LIKE','%'.$request->inputSearchSorte.'%');
        }
        elseif($request->dateDebut && $request->dateFin)
        {
            $sortess->whereBetween('date', [$request->dateDebut, $request->dateFin]);
        }
        $sortes=$sortess->paginate(5);
        return view("admin.sorte",compact('sortes'));
    }

    //using this function to export output data to PDF  
    public function exportPDF(Request $request)
    {
        if(empty($request->inputSearchSorte) && empty($request->dateDebut) && empty($request->dateFin) )
        {
            return redirect()->back()->with(['error'=>'Veuillez filtrer avant d\'imprimer']);
        }else
        {
            $sortess=Sorte::orderBy('created_at','DESC');
            if($request->inputSearchSorte)
            {
                $sortess->where('name','LIKE','%'.$request->inputSearchSorte.'%')
                ->orWhere('validation','=',$request->inputSearchSorte)
                ->orWhere('date','LIKE','%'.$request->inputSearchSorte.'%')
                ->orWhere('charge','LIKE','%'.$request->inputSearchSorte.'%');
            }elseif($request->dateDebut && $request->dateFin)
            {
                $sortess->whereBetween('date', [$request->dateDebut, $request->dateFin]);
            }
            $sortes=$sortess->paginate(100);

            $pdf = PDF::loadView('pdf.sorte', compact('sortes'));
            return $pdf->download(Carbon::now()->format('d-m-y').'-sortie.pdf');
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
            $archive_sorte=Sorte::onlyTrashed()->orderBy('created_at','DESC');
            if($request->inputSearcharchive)
            {
                $archive_sorte->where('name','LIKE','%'.$request->inputSearcharchive.'%')
                ->orWhere('validation','=',$request->inputSearcharchive)
                ->orWhere('date','LIKE','%'.$request->inputSearcharchive.'%')
                ->orWhere('charge','LIKE','%'.$request->inputSearcharchive.'%');
            }elseif($request->dateDebut && $request->dateFin)
            {
                $archive_sorte->whereBetween('date', [$request->dateDebut, $request->dateFin]);
            }
            $sortes=$archive_sorte->paginate(100);

            $pdf = PDF::loadView('pdf.archiveSorte', compact('sortes'));
            return $pdf->download(Carbon::now()->format('d-m-y').'-archive-sortie.pdf');
        }
        
    }

    //using this function to send output data to archive 
    public function exportArchiffe(Request $request)
    {
        if(empty($request->inputSearcharchive) && empty($request->dateDebut) && empty($request->dateFin) )
        {
            return redirect()->back()->with(['error'=>'Veuillez filtrer avant d\'imprimer']);
        }else
        {
            $archive_sorte=Sorte::orderBy('created_at','DESC');
            if($request->inputSearcharchive)
            {
                $archive_sorte->where('name','LIKE','%'.$request->inputSearcharchive.'%')
                ->orWhere('validation','=',$request->inputSearcharchive)
                ->orWhere('date','LIKE','%'.$request->inputSearcharchive.'%')
                ->orWhere('charge','LIKE','%'.$request->inputSearcharchive.'%');
            }elseif($request->dateDebut && $request->dateFin)
            {
                $archive_sorte->whereBetween('date', [$request->dateDebut, $request->dateFin]);
            }
            $sortes=$archive_sorte->delete();

            return redirect()->back()->with(['success' => 'L\'archivation de sorte avec succès']);
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sorteCreate');
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

        Sorte::create([
            'name'=>$name,
            'date' => $date,
            'montant' => $montant,
            'designiation' => $designiation,
            'image' => $image,
            'charge' => $charge,
            'user_id' => $id_user
        ]);

        return redirect()->back()->with(['success' => 'Ajouté de sorte avec success']);
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
        $sorte = Sorte::find($id);
        return view('admin.sorteEdit')->with(['sorte' => $sorte]);
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
        
        $sorte = Sorte::find($id);
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
            if($sorte->image != null)
                unlink(public_path('uploards').'/'.$sorte->image);
            $sorte->image=$image_name;
        }

        $name=$request->name;
        $date=$request->date;
        $montant=$request->montant;
        $designiation=$request->designiation;
        $image=$sorte->image;
        $charge=$request->charge;
        $id_user=$request->idUser;

        $sorte->update([
            'name'=>$name,
            'date' => $date,
            'montant' => $montant,
            'designiation' => $designiation,
            'image' => $image,
            'charge' => $charge,
            'user_id' => $id_user
        ]);

        return redirect()->back()->with(['success' => 'L\'modification de sorte avec success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sorte = Sorte::find($id);
        if($sorte->image != null)
            unlink(public_path('uploards').'/'.$sorte->image);
        $sorte->forceDelete();
        return redirect()->back()->with(['success' => 'La suppression de sorte avec succès']);
    }

    public function valide(Request $request, $id)
    {
        $entre = Sorte::find($id);
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

    //using this function to display output archiverd data in archive page 
    public function selectArchiffeSorte(Request $request)
    {
        $archives_sorte=Sorte::onlyTrashed()->orderBy('created_at','DESC');
        if($request->inputSearcharchive)
        {
            $archives_sorte->where('name','LIKE','%'.$request->inputSearcharchive.'%')
            ->orWhere('validation','=',$request->inputSearcharchive)
            ->orWhere('date','LIKE','%'.$request->inputSearcharchive.'%')
            ->orWhere('charge','LIKE','%'.$request->inputSearcharchive.'%');
        }
        elseif($request->dateDebut && $request->dateFin)
        {
            $archives_sorte->whereBetween('date', [$request->dateDebut, $request->dateFin]);
        }
        $sortes=$archives_sorte->paginate(5);
        return view('admin.archive')->with(["archives" => $sortes]);
    }

}
