<?php declare(strict_types=1);

namespace App\Modules\FirstModule\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FirstModule;
use App\Modules\FirstModule\Repository\FirstModuleRepositoryInterface;
use App\Modules\FirstModule\Service\EfaktureSubmitService;
use Illuminate\Http\Request;
use GuzzleHttp\Psr7\Request as RequestGuzzle;
use GuzzleHttp\Client;
use SimpleXMLElement;

class FirstModuleController extends Controller
{
    public function __construct(
        private readonly FirstModuleRepositoryInterface $firstModuleRepository,
        private readonly EfaktureSubmitService $efaktureSubmitService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->firstModuleRepository->create(['name'=>time()]);
        $data = $this->efaktureSubmitService->sendInvoiceToEfakture();
        return view('firstmodule::firstmodule.create_firstmodule');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('firstmodule.create_firstmodule');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(FirstModule $firstmodule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FirstModule $firstmodule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FirstModule $firstmodule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FirstModule $firstmodule)
    {
        //
    }
}
