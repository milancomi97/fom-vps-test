<?php declare(strict_types=1);

namespace App\Modules\CoreModule\Service;

use App\Modules\CoreModule\Repository\CoreModuleRepositoryInterface;

class EfaktureSubmitService
{
    /**
     * @param CoreModuleRepositoryInterface $coreModuleRepository
     */
    public function __construct(
        private readonly CoreModuleRepositoryInterface $coreModuleRepository
    ){
    }

    public function sendInvoiceToEfakture(){
      return  $this->coreModuleRepository->getAll();
    }
}
