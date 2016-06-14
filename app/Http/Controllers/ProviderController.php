<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Requests;

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

        $ApiResponse = $this->ProviderApiController->update_profile($request)->getData();
        
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

        $ApiResponse = $this->ProviderApiController->changePassword($request)->getData();

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

        $ApiResponse = $this->ProviderApiController->available_update($request)->getData();

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

        $ApiResponse = $this->ProviderApiController->location_update($request)->getData();

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
    public function ongoing(Request $request)
    {
        $request->request->add([ 
            'id' => \Auth::guard('provider')->user()->id,
            'token' => \Auth::guard('provider')->user()->token,
            'device_token' => \Auth::guard('provider')->user()->device_token,
        ]);

        $ApiResponse = $this->ProviderApiController->request_status_check($request)->getData();

        if($ApiResponse->success == true){
            return view('provider.ongoing')->with('request_data',$ApiResponse->data);
        }elseif($ApiResponse->success == false){
            return view('provider.ongoing')->with('error', 'Something Went Wrong');
        }
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
    public function incoming_request(Request $request)
    {
        $request->request->add([ 
            'id' => \Auth::guard('provider')->user()->id,
            'token' => \Auth::guard('provider')->user()->token,
            'device_token' => \Auth::guard('provider')->user()->device_token,
        ]);

        $ApiResponse = $this->ProviderApiController->get_incoming_request($request)->getData();

        return response()->json($ApiResponse);
    }

    /**
     * Accept request.
     *
     * @return \Illuminate\Http\Response
     */
    public function accept_request(Request $request)
    {
        $request->request->add([ 
            'id' => \Auth::guard('provider')->user()->id,
            'token' => \Auth::guard('provider')->user()->token,
            'device_token' => \Auth::guard('provider')->user()->device_token,
        ]);

        $ApiResponse = $this->ProviderApiController->service_accept($request)->getData();

        if($ApiResponse->success == true){
            return redirect(route('provider.ongoing'))->with('success', 'New Request Accepted');
        }elseif($ApiResponse->success == false){
            return back()->with('error', 'Something Went Wrong');
        }

    }

    /**
     * Decline request.
     *
     * @return \Illuminate\Http\Response
     */
    public function decline_request(Request $request)
    {
        $request->request->add([ 
            'id' => \Auth::guard('provider')->user()->id,
            'token' => \Auth::guard('provider')->user()->token,
            'device_token' => \Auth::guard('provider')->user()->device_token,
        ]);

        $ApiResponse = $this->ProviderApiController->service_reject($request)->getData();

        if($ApiResponse->success == true){
            return redirect(route('provider.ongoing'))->with('success', 'Request Declined!');
        }elseif($ApiResponse->success == false){
            return back()->with('error', 'Something Went Wrong');
        }

    }

    /**
     * switch provider action.
     *
     * @return \Illuminate\Http\Response
     */
    public function switch_state(Request $request)
    {
        $ApiResponse = '';

        $request->request->add([ 
            'id' => \Auth::guard('provider')->user()->id,
            'token' => \Auth::guard('provider')->user()->token,
            'device_token' => \Auth::guard('provider')->user()->device_token,
        ]);

        switch ($request->type) {
            case "STARTED":
                $ApiResponse = $this->ProviderApiController->providerstarted($request)->getData();
                break;
            case "ARRIVED":
                $ApiResponse = $this->ProviderApiController->arrived($request)->getData();
                break;
            case "SERVICE_STARTED":
                $ApiResponse = $this->ProviderApiController->servicestarted($request)->getData();
                break;
            case "SERVICE_COMPLETED":
                $ApiResponse = $this->ProviderApiController->servicecompleted($request)->getData();
                break;
            default:
                return back()->with('error','something went wrong');
        }

        if($ApiResponse->success == true){
            return redirect(route('provider.ongoing'))->with('success', 'YOU ARE '.$request->type);
        }elseif($ApiResponse->success == false){
            return back()->with('error', 'Something Went Wrong');
        }
    }

    /**
     * submit review.
     *
     * @return \Illuminate\Http\Response
     */
    public function submit_review(Request $request)
    {

        $request->request->add([ 
            'id' => \Auth::guard('provider')->user()->id,
            'token' => \Auth::guard('provider')->user()->token,
            'device_token' => \Auth::guard('provider')->user()->device_token,
        ]);

        $ApiResponse = $this->ProviderApiController->rate_user($request)->getData();

        if($ApiResponse->success == true){
            return redirect(route('provider.ongoing'))->with('success', 'Service Completed!');
        }elseif($ApiResponse->success == false){
            return back()->with('error', 'Something Went Wrong');
        }

    }

    /**
     * service history.
     *
     * @return \Illuminate\Http\Response
     */
    public function history(Request $request)
    {

        $request->request->add([ 
            'id' => \Auth::guard('provider')->user()->id,
            'token' => \Auth::guard('provider')->user()->token,
            'device_token' => \Auth::guard('provider')->user()->device_token,
        ]);

        $ApiResponse = $this->ProviderApiController->history($request)->getData();

        if($ApiResponse->success == true){
            return view('provider.services')->with('requests',$ApiResponse->requests);
        }elseif($ApiResponse->success == false){
            return back()->with('error', 'Something Went Wrong');
        }

    }

    public function cancel_service(Request $request)
    {
        $request->request->add([ 
            'id' => \Auth::guard('provider')->user()->id,
            'token' => \Auth::guard('provider')->user()->token,
            'device_token' => \Auth::guard('provider')->user()->device_token,
        ]);

        $ApiResponse = $this->ProviderApiController->cancelrequest($request)->getData();

        if($ApiResponse->success == true){
            return redirect(route('provider.ongoing'))->with('success', 'Service Cancelled');
        }elseif($ApiResponse->success == false){
            return back()->with('error', 'Something Went Wrong');
        }
    }

    public function paid_status(Request $request)
    {
        $request_state = Requests::find($request->request_id);
        $request_state->is_paid = 1;
        $request_state->save();

        if($request_state){
            return redirect(route('provider.ongoing'))->with('success', 'User Paid');
        }else{
            return back()->with('error', 'Something Went Wrong');
        }
    }
}
