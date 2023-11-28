<?php declare(strict_types=1);

namespace App\Modules\CoreModule\Controllers;

use App\Http\Controllers\Controller;
use \App\Models\CoreModule;
use App\Modules\CoreModule\Repository\CoreModuleRepositoryInterface;
use App\Modules\CoreModule\Service\EfaktureSubmitService;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class CoreModuleController extends Controller
{
    public function __construct(
        private readonly CoreModuleRepositoryInterface $coreModuleRepository,
        private readonly EfaktureSubmitService         $efaktureSubmitService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->coreModuleRepository->create(['name'=>time()]);
        $data = $this->efaktureSubmitService->sendInvoiceToEfakture();
        return view('coremodule::coremodule.create_coremodule');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('coremodule.create_coremodule');

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
    public function show(CoreModule $coremodule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CoreModule $coremodule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CoreModule $coremodule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CoreModule $coremodule)
    {
        //
    }
    public function sendSoapRequest(Request $request)
    {
        $pibValue= $request->input('pib');
        $client = new Client();
        $xml =  "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<soap:Envelope xmlns:soap=\"http://www.w3.org/2003/05/soap-envelope\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"  xmlns:tns=\"http://communicationoffice.nbs.rs\" xmlns:s1=\"http://microsoft.com/wsdl/types/\" xmlns:tm=\"http://microsoft.com/wsdl/mime/textMatching/\">\n    <soap:Header>\n        <AuthenticationHeader xmlns=\"http://communicationoffice.nbs.rs\">\n            <UserName>rsm_serbia</UserName>\n            <Password>rsm2020serbia</Password>\n            <LicenceID>e24a8ef8-fff1-4b78-8165-c27b8aa985fb</LicenceID>\n        </AuthenticationHeader>\n    </soap:Header>\n    <soap:Body>\n        <GetCompanyAccount xmlns=\"http://communicationoffice.nbs.rs\">\n
  <nationalIdentificationNumber>".$pibValue."</nationalIdentificationNumber>\n            <!--<taxIdentificationNumber></taxIdentificationNumber>-->\n            <!--<bankCode></bankCode>-->\n            <!--<accountNumber></accountNumber>-->\n            <!--<controlNumber></controlNumber>-->\n            <!--<companyName></companyName>-->\n            <!--<city></city>-->\n            <!--<startItemNumber></startItemNumber>-->\n            <!--<endItemNumber></endItemNumber>-->\n        </GetCompanyAccount>\n    </soap:Body>\n</soap:Envelope>";

        $headers = [
            'Content-Type' => 'text/xml; charset=UTF8',
            'Content-Length' => strlen($xml),
        ];

        $response = $client->request('POST', 'https://webservices.nbs.rs/CommunicationOfficeService1_0/CompanyAccountXmlService.asmx', [
            'headers' => $headers,
            'body' => $xml,
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->getBody()->getContents();


        $xmlString  = html_entity_decode($content);

        $pattern = '/<([^>]+)>(.*?)<\/\1>/';
        preg_match_all($pattern, $xmlString, $matches);
        $data = [];

// Iterate over the matches and populate the array

//        for($i=0;$i< count($matches);$i++){
//
//
//        }
//
        $counter=0;
        foreach ($matches[1] as $index => $tag) {
            if($tag=='Account'){
                $counter++;
            }
            $data[$counter][$tag] = $matches[2][$index];
        }

        // Handle the SOAP response as needed
        // You can parse the XML response here
        return response()->json($data);
    }
}
