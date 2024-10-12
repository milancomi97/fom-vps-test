<?php

namespace App\Modules\Materijalno\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateMaterijalRequest;
use App\Models\Materijal;
use App\Models\StanjeZaliha;
use Illuminate\Http\Request;
use PDF;
use App\Models\Category;

class KarticeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materijals = Materijal::with('category')->get();

        $materijalData = [];
        foreach ($materijals as $materijal) {
            $materijalData[] = [
                $materijal->category->name,
                $materijal->sifra_materijala,
                $materijal->naziv_materijala,
                $materijal->standard,
                $materijal->dimenzija,
                $materijal->tezina,
                $materijal->sifra_standarda,
                $materijal->id,
                $materijal->category->id
            ];
        }

        return view('materijalno::materijali.materijali_show_all', ['materijals' => json_encode($materijalData)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('materijalno::kartice.create_kartica',compact('categories'));
    }


    public  function getSelectOptionData(Request $request){

        $query = $request->input('query');

        $materijali = Materijal::with('stanjematerijala')->where('naziv_materijala', 'LIKE', "%{$query}%")
            ->orWhere('sifra_materijala', 'LIKE', "%{$query}%")
            ->get();

        return response()->json($materijali);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $materijal = Materijal::create($input);

        return redirect()->route('materijal.create')->with('message', 'Materijal successfully added.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Materijal $materijal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $materijal = Materijal::findOrFail($id);  // Fetch the materijal by ID
        $categories = Category::all();            // Get all categories for the dropdown
        return view('materijalno::materijali.edit_materijal', compact('materijal', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Materijal $materijal)
    {
        $inputData = $request->input();
        $materijalModel = Materijal::findOrFail($materijal->id);
        $materijalModel->update($inputData);

//         Redirect with success message
        return redirect()->route('materijal.edit', $materijalModel->id)->with('message', 'Materijal successfully updated.');
    }


    /**
     * Update the specified resource in storage.
     */
    public function updatePost(Request $request, Materijal $materijal)
    {
        $test='ttest';
        //
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $status = Materijal::destroy($request->materijal_id);

        if($status){
            return  response()->json([
                'status' => (bool) $status
            ], 200);
        }else{
            return  response()->json([
                'status' => (bool) $status
            ],  404 );
        }

    }

    public function pdfExport(Request $request){

        $materijalIds = explode(',',$request->materijal_ids);

        $sifra_materijala_ids = Materijal::whereIn('id',$materijalIds)->pluck('sifra_materijala')->all();
        $filteredData = StanjeZaliha::whereIn('sifra_materijala',$sifra_materijala_ids)->get();
        $stanjeMaterijala =$filteredData->toArray();
        // SORTIRAJ PO MAGACINIMA
        $stanjeMaterijalaSum=[];
        foreach($stanjeMaterijala as $materijal){

            $stanjeMaterijalaSum[$materijal['sifra_materijala']]='TEST';





        }
        $pdf = PDF::loadView('pdftemplates.materijal_pdf',compact('stanjeMaterijalaSum'));
//        $pdf = PDF::loadView('materijal_pdf',$filteredData);
       return $pdf->download('materijal_pdf.pdf');
    }
}
