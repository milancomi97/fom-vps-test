<?php declare(strict_types=1);

namespace App\Modules\FirstModule\Service;

use App\Modules\FirstModule\Repository\FirstModuleRepositoryInterface;

class EfaktureSubmitService
{
    /**
     * @param FirstModuleRepositoryInterface $firstModuleRepository
     */
    public function __construct(
        private readonly FirstModuleRepositoryInterface $firstModuleRepository
    ){
    }

    public function sendInvoiceToEfakture(){
      return  $this->firstModuleRepository->getAll();
    }
}
