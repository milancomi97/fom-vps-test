<?php declare(strict_types=1);

namespace App\Modules\Obracunzarada\Repository;

use App\Models\Maticnadatotekaradnika;
use App\Repository\BaseRepository;

class MaticnadatotekaradnikaRepository extends BaseRepository implements MaticnadatotekaradnikaRepositoryInterface
{
    /**
     *
     * @param Maticnadatotekaradnika $model
     */
    public function __construct(Maticnadatotekaradnika $model)
    {
        parent::__construct($model);
    }


    public function createMaticnadatotekaradnika($attributes)
    {
        $dataa = '{"_token":"OUoygWUjELveoEwyNEpCeLjlFf9KKTyt2PPCphH4","maticni_broj":"0010299","prezime":"JONIC","ime":"IVICA","sifra_mesta_troska_id":"32270000","radno_mesto":"12","isplatno_mesto":"13","tekuci_racun":null,"redosled_poentazi":"9999","vrsta_rada":"4","radna_jedinica":null,"brigada":null,"godine":"0","meseci":"0","minuli_rad_aktivan":"on","stvarna_strucna_sprema":"13","priznata_strucna_sprema":"10","osnovna_zarada":"60000","jmbg":"Voluptatum","pol_mu\u0161ki":"on","prosecni_sati":"0","prosecna_zarada":"0","adresa_ulica_broj":"Accusamus laborum O","opstina_id":"122"}';
        $attributes['minuli_rad_aktivan'] = ( $attributes['minuli_rad_aktivan'] ?? "") =='on';
        $attributes['pol_muski'] = ( $attributes['pol_muski'] ?? "") =='on';
        return $this->create($attributes);
    }
}
