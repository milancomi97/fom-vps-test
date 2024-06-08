<?php

namespace App\Modules\Osnovnipodaci\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Osnovnipodaci\Repository\OrganizacionecelineRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\RadniciRepository;
use Illuminate\Http\Request;

class OrganizacionecelineController  extends Controller
{


    public function __construct(
        readonly private OrganizacionecelineRepositoryInterface $organizacionecelineInterface,
        private readonly RadniciRepository $radniciInterface,

    )
    {
    }

    public function index(){

        $data = $this->organizacionecelineInterface->getAll();
        $radniciCollection = $this->radniciInterface->where('active',1)->get()->keyBy('id');
        $dataFullData = $data->map(function ($item, $key) {
          $item['odgovorna_lica_ids']=json_decode($item['odgovorna_lica_ids'],true);
          $item['poenteri_ids']=json_decode($item['poenteri_ids'],true);

          return $item;
        });

        $test='test';
        return view('osnovnipodaci::organizacioneceline.organizacioneceline_index', ['data' => $dataFullData,'radniciFullData'=>$radniciCollection]);

    }

    public function edit($id){
        $data = $this->organizacionecelineInterface->getById($id);
        $radnici = $this->radniciInterface->getAllActive();
        $radniciCollection = $this->radniciInterface->where('active',1)->get()->keyBy('id');
        $radniciSelect2 = $radniciCollection->map(function ($item, $key) {
            return ['id'=>$key,'text'=>$item['maticni_broj']];
        });

            $odgovornaLica =$data->odgovorna_lica_ids;
            $odgovorniPoenteri = $data->poenteri_ids;
         $potpisiFormated =implode(" , ",  json_decode($data->odgovorni_direktori_pravila));

        $test='test';
        return view('osnovnipodaci::organizacioneceline.organizacioneceline_edit',
            [
                'radnici'=>$radnici,
                'data' => $data,
                'radniciSelect2'=>$radniciSelect2->toJson(),
                'odgovornaLica'=>$odgovornaLica,
                'odgovorniPoenteri'=>$odgovorniPoenteri,
                'potpisiFormated'=>$potpisiFormated
            ]);

    }

    public function update(Request $request){
        $updateData = $request->all();
        unset($updateData['_token']);

        $updateData['poenteri_ids'] = json_encode($updateData['poenteri_ids'] );
        $updateData['odgovorna_lica_ids'] = json_encode($updateData['odgovorna_lica_ids'] );

        $updateData['odgovorni_direktori_pravila']=array_map('trim', explode(',', $updateData['odgovorni_direktori_pravila']));

        $data = $this->organizacionecelineInterface->update($request->id,$updateData);
        return redirect()->route('organizacioneceline.index');
    }
}
