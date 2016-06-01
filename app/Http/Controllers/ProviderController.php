<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\ProviderApiController;

use App\Document;

use App\ProviderDocument;

use App\Provider;

use Auth;

use App\Helpers\Helper;

class ProviderController extends Controller
{
    protected $ProviderApiController;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProviderApiController $ProviderApiController)
    {
        $this->middleware('provider',['except' => ['change_state']]);
        $this->ProviderApiController = $ProviderApiController;

    }

    /**
     * Show the user dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(\::guard('provider')->user());
        return view('provider.dashboard');
    }

    /**
     * Show the services list.
     *
     * @return \Illuminate\Http\Response
     */
    public function services()
    {
        return view('provider.services');
    }

    /**
     * Show the request list.
     *
     * @return \Illuminate\Http\Response
     */
    public function request()
    {
        return view('provider.request');
    }

    /**
     * Show the profile list.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return view('provider.profile');
    }

    /**
     * Save any changes to the provider profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile_save(Request $request)
    {
        $request->request->add([ 
            'id' => \Auth::guard('provider')->user()->id,
            'token' => \Auth::guard('provider')->user()->token,
            'device_token' => \Auth::guard('provider')->user()->device_token,
        ]);

        $data = $this->ProviderApiController->details_save($request);
        $ApiResponse = $data->getData();

        // dd($ApiResponse->error_messages);

        if($ApiResponse->success == true){
            return back()->with('success', 'Profile has been saved');
        }elseif($ApiResponse->success == false){
            return back()->with('error', $ApiResponse->error_messages);
        }

    }

    /**
     * Save changed password.
     *
     * @return \Illuminate\Http\Response
     */
    public function password(Request $request)
    {
        $request->request->add([ 
            'id' => \Auth::guard('provider')->user()->id,
            'token' => \Auth::guard('provider')->user()->token,
            'device_token' => \Auth::guard('provider')->user()->device_token,
        ]);

        $data = $this->ProviderApiController->changePassword($request);
        $ApiResponse = $data->getData();

        // dd($ApiResponse);

        if($ApiResponse->success == true){
            return back()->with('success', 'Password Updated');
        }elseif($ApiResponse->success == false){
            return back()->with('error', $ApiResponse->error);
        }
    }


    /**
     * change State.
     *
     * @return \Illuminate\Http\Response
     */
    public function change_state(Request $request)
    {
        $request->request->add([ 
            'id' => \Auth::guard('provider')->user()->id,
            'token' => \Auth::guard('provider')->user()->token,
            'device_token' => \Auth::guard('provider')->user()->device_token,
        ]);

        $data = $this->ProviderApiController->available_update($request);
        $ApiResponse = $data->getData();

        return response()->json($ApiResponse);
    }


    /**
     * Update location.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_location(Request $request)
    {
        $request->request->add([ 
            'id' => \Auth::guard('provider')->user()->id,
            'token' => \Auth::guard('provider')->user()->token,
            'device_token' => \Auth::guard('provider')->user()->device_token,
        ]);

        $data = $this->ProviderApiController->location_update($request);
        $ApiResponse = $data->getData();

        // dd($ApiResponse);

        if($ApiResponse->success == true){
            return back()->with('success', 'Location Updated');
        }elseif($ApiResponse->success == false){
            return back()->with('error', $ApiResponse->error);
        }
    }

    /**
     * Show the ongoing list.
     *
     * @return \Illuminate\Http\Response
     */
    public function ongoing()
    {
        return view('provider.ongoing');
    }

    /**
     * Show the documents list.
     *
     * @return \Illuminate\Http\Response
     */
    public function documents()
    {
        $get_documents = Document::all();

        if(Auth::guard('provider')->user()->is_approved == 0){
            return view('provider.documents')->withDocuments($get_documents)->with('error','Please upload your document to get approve from admin');
        }else{

            return view('provider.documents')->withDocuments($get_documents);
        }


    }

    /**
     * Upload Documents.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload_documents(Request $request)
    {
        $get_documents = Document::all();

        foreach ($get_documents as $document) {
            if($request['document_'.$document->id] != ""){

                $provider_document =  new ProviderDocument;
                $provider_document->provider_id = \Auth::guard('provider')->user()->id;
                $provider_document->document_id = $document->id;

                delete_document($request['document_'.$document->id]);
                $provider_document->document_url = upload_document($request['document_'.$document->id]);
                $provider_document->save();
            }
        }

        return back()->with('success', 'Your Documents Updated');
    }


    public function delete_document($document_id)
    {
        if(delete_document($document_id)){

            ProviderDocument::where('provider_id',Auth::guard('provider')->user()->id)
                            ->where('document_id',$document_id)
                            ->delete();

            $provider = Provider::find(Auth::guard('provider')->user()->id);
            $provider->is_approved = 0;
            $provider->save();
            
            return back()->with('success','your document Deleted! and please upload your new document');
        }else{
            return back()->with('error','something went wrong');
        }

    }

    /**
     * Popup incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function incoming_request()
    {
        $request->request->add([ 
            'id' => \Auth::guard('provider')->user()->id,
            'token' => \Auth::guard('provider')->user()->token,
            'device_token' => \Auth::guard('provider')->user()->device_token,
        ]);

        $data = $this->ProviderApiController->get_incoming_request($request);
        $ApiResponse = $data->getData();

        return response()->json($ApiResponse);
    }
}
