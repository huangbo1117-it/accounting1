<?php

namespace App\Http\Controllers\accounting;

use App\accounting\rightsfield;
use App\accounting\Role;
use App\accounting\RoleRightsField;
use App\accounting\tblactivitycode;
use App\accounting\tblattorneys;
use App\accounting\tblCollector;
use App\accounting\tblcreditor;
use App\accounting\tblcontacts;
use App\accounting\tblDebtor;
use App\accounting\tblfile;
use App\accounting\tblinvoice;
use App\accounting\tblnote;
use App\accounting\tblparameter;
use App\accounting\tblpmnttype;
use App\accounting\tblsales;
use App\accounting\tblStatus;
use App\accounting\tbltemplate;
use App\accounting\tblTrust;
use App\accounting\userCreditorMaps;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Excel;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Array_;

class MainController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this ->middleware('CheckGroup:Main');
    }

    public function collector(Request $request){
        $collectors = null;
        if($request->searchCollector == null) {
            $collectors = tblCollector::get();
        }
        else{
            $collectors = tblCollector::
                where('CLastName','like','%'.$request->searchCollector.'%')
                ->orwhere('CFirstName','like','%'.$request->searchCollector.'%')
                ->get();
        }


        return view('accounting\collector\collector', ['collectors' => $collectors]);
    }
    public function addCollector(){
        return view('accounting\collector\addcollector');
    }
    public function saveCollector(Request $request){

        $validatedData = $request->validate([
            'collectorFirstName' => 'required|max:191',
            'collectorLastName' => 'required|max:191',
        ]);

        $newCollector = new tblCollector();
        $newCollector->CLastName = $request->collectorLastName;
        $newCollector->CFirstName = $request->collectorFirstName;
        $newCollector->Closing  =$request->closing;

        $newCollector->save();

        return redirect('/Collector?msg=Collector Successfully Saved.');
    }
    public function editCollector(Request $request){
        if($request->updateCollectorID != null)
        {
            $validatedData = $request->validate([
                'collectorFirstName' => 'required|max:191',
                'collectorLastName' => 'required|max:191',
            ]);

            $collector = new tblCollector();

            $collector->where('ColID','=',$request->updateCollectorID)
                ->update(array(
                        'CLastName' => $request->collectorLastName,
                        'CFirstName' => $request->collectorFirstName,
                        'Closing' => $request->closing
                        ));

            return redirect('/Collector?msg=Collector Successfully Updated.');
        }

        $collector = tblCollector::where('ColID','=',$request->collectorID)->first();
        return view('accounting\collector\collectorEditForm', ['collector'=> $collector]);

    }
    public function delCollector(Request $request){
        tblCollector::where('ColID','=',$request->collectorID)->delete();
        return redirect('/Collector?msg=Collector Successfully Deleted.');
    }

    public function sales(Request $request){
        $sales = null;
        if($request->searchSales == null) {
            $sales = tblsales::get();
        }
        else{
            $sales = tblsales::
                where('SLastName','like','%'.$request->searchSales.'%')
                    ->orwhere('SFirstName','like','%'.$request->searchSales.'%')
                    ->get();
        }


        return view('accounting\sales\sales', ['sales' => $sales]);
    }
    public function addSales(){
        return view('accounting\sales\addsales');
    }
    public function saveSales(Request $request){

        $validatedData = $request->validate([
            'salesFirstName' => 'required|max:191',
            'salesLastName' => 'required|max:191',
        ]);

        $newSales = new tblsales();
        $newSales->SLastName = $request->salesLastName;
        $newSales->SFirstName = $request->salesFirstName;

        $newSales->save();

        return redirect('/Sales?msg=Sales Man Successfully Saved.');
    }
    public function editSales(Request $request){
        if($request->updateSaleID != null)
        {
            $validatedData = $request->validate([
                'salesFirstName' => 'required|max:191',
                'salesLastName' => 'required|max:191',
            ]);

            $sales = new tblsales();

            $sales->where('SalesID','=',$request->updateSaleID)
                ->update(array(
                    'SLastName' => $request->salesLastName,
                    'SFirstName' => $request->salesFirstName,
                ));

            return redirect('/Sales?msg=Sales Man Successfully Updated.');
        }

        $sales = tblsales::where('SalesID','=',$request->salesID)->first();
        return view('accounting\sales\salesEditForm', ['sales'=> $sales]);

    }
    public function delSales(Request $request){
        tblsales::where('SalesID','=',$request->salesID)->delete();
        return redirect('/Sales?msg=Sales Man Successfully Deleted.');
    }

    public function paymentType(Request $request){
        $paymentType = null;
        if($request->searchPaymentType == null) {
            $paymentType = tblpmnttype::get();
        }
        else{
            $paymentType = tblpmnttype::
                where('PmntDesc','like','%'.$request->searchPaymentType.'%')
                    ->get();
        }


        return view('accounting\payment_type\paymenttype', ['paymenttype' => $paymentType]);
    }
    public function addPaymentType(){
        return view('accounting\payment_type\addpaymenttype');
    }
    public function savePaymentType(Request $request){

        $validatedData = $request->validate([
            'pTypeDesc' => 'required|max:191',
        ]);

        $newPaymentType = new tblpmnttype();
        $newPaymentType->PmntDesc = $request->pTypeDesc;

        $newPaymentType->save();

        return redirect('/PaymentType?msg=Payment Type Successfully Saved.');
    }
    public function editPaymentType(Request $request){
        if($request->updatePaymentTypeID != null)
        {
            $validatedData = $request->validate([
                'paymentTypeDescription' => 'required|max:191',
            ]);

            $newPaymentType = new tblpmnttype();

            $newPaymentType->where('PmntID','=',$request->updatePaymentTypeID)
                ->update(array(
                    'PmntDesc' => $request->paymentTypeDescription,
                ));

            return redirect('/PaymentType?msg=Payment Type Successfully Updated.');
        }

        $paymentType = tblpmnttype::where('PmntID','=',$request->paymentTypeID)->first();
        return view('accounting\payment_type\paymenttypeEditForm', ['paymenttype'=> $paymentType]);

    }
    public function delPaymentType(Request $request){
        tblpmnttype::where('PmntID','=',$request->paymentTypeID)->delete();
        return redirect('/PaymentType?msg=Payment Type Successfully Deleted.');
    }

    public function status(Request $request){
        $status = null;
        if($request->searchStatus == null) {
            $status = tblStatus::get();
        }
        else{
            $status = tblStatus::
            where('StatusDesc','like','%'.$request->searchStatus.'%')
                ->get();
        }


        return view('accounting\status\status', ['status' => $status]);
    }
    public function addStatus(){
        return view('accounting\status\addstatus');
    }
    public function saveStatus(Request $request){

        $validatedData = $request->validate([
            'statusID' => 'required|max:191',
            'statusDesc' => 'required|max:191',

        ]);

        $newStatus = new tblStatus();
        $newStatus->StatusID = $request->statusID;
        $newStatus->StatusDesc = $request->statusDesc;

        $newStatus->save();

        return redirect('/Status?msg=Status Successfully Saved.');
    }
    public function editStatus(Request $request){
        if($request->updateStatusID != null)
        {
            $validatedData = $request->validate([
                'updateStatusID' => 'required|max:191',
                'statusDesc' => 'required|max:191',
            ]);

            $newStatus = new tblStatus();

            $newStatus->where('StatusID','=',$request->updateStatusID)
                ->update(array(
                    'StatusDesc' => $request->statusDesc,
                ));

            return redirect('/Status?msg=Status Successfully Updated.');
        }

        $status = tblStatus::where('StatusID','=',$request->statusID)->first();
        return view('accounting\status\statusEditForm', ['status'=> $status]);

    }
    public function delStatus(Request $request){
        tblStatus::where('StatusID','=',$request->statusID)->delete();
        return redirect('/Status?msg=Status Successfully Deleted.');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function creditor(Request $request){

        $creditor = null;
        if($request->Export != null){
            //$creditor = tblcreditor::get();
            $creditor= \DB::select('select * from tblcreditors');
            return  $this->Export($creditor,'Creditors');
        }
        if($request->searchCreditor == null) {
            $creditor = tblcreditor::paginate(5);
           // $creditor = new tblcreditor();
        }
        else{
           /* $clientInfo = tblcontacts::where(function($query){
                $query->where('MainManager','=',true);
            })->where(function($query) use ($request){
                $query->where('ClientName','like','%'.$request->searchCreditor.'%')
                ->orWhere('CFirstName','like','%'.$request->searchCreditor.'%')
                ->orWhere('CLastName','like','%'.$request->searchCreditor.'%')
                ->orWhere('Street','like','%'.$request->searchCreditor.'%')
                ->orWhere('State','like','%'.$request->searchCreditor.'%')
                ->orWhere('City','like','%'.$request->searchCreditor.'%')
                ->orWhere('Zip','like','%'.$request->searchCreditor.'%')
                    ->orWhere('CreditorID','like','%'.$request->searchCreditor.'%')
                ->orWhere('Phone','like','%'.$request->searchCreditor.'%');})
                ->select('CreditorID')
                ->get();
            $filterData='';
            foreach($clientInfo as $ci)
            {
                $filterData=$filterData.'\''.$ci->CreditorID.'\',';
            }
            $filterData=rtrim($filterData,", ");
            if($filterData == ''){
                $creditor = tblcreditor::paginate(5);
            }else{*/
                $creditor= tblcreditor::where('CreditorID','like', '%' . $request->searchCreditor . '%')->paginate(5);
               // $creditor =DB::select('select * from tblcreditors where CreditorID in ('.$filterData.')')->toArray()->paginate(5);


          /*  $creditor = tblcreditor::
            where('CreditorID','like','%'.$request->searchCreditor.'%')
                ->get();*/
        }

        foreach($creditor as $c)
        {

            $mainContact = tblcontacts::where('CreditorID','=',$c->CreditorID)
                                        ->where('MainManager','=',true)->first();
            if($mainContact != null) {
                $c->mainContact = $mainContact->ClientName;
            }
            $mainSaleMan = tblsales::where('SalesID','=',$c->SaleID)->first();

            if($mainSaleMan != null) {
                $c->saleman = $mainSaleMan;
            }else{
            $c->saleman=new tblsales();
        }
        }



        return view('accounting\creditors\creditor', ['creditor' => $creditor]);
    }
    public function addCreditor(){
        $result = rolerightsfield::where('RoleID','=',Auth::user()->is_permission)
            ->where('ScreenName','=','Creditor')
            ->where('FieldName','=','NewCreditor')
            ->first();
        if($result == null){
            return redirect('/Creditor?msg=Access denied.');
        }else{
            if(!$result->Active){
                return redirect('/Creditor?msg=Access denied.');
            }
        }
        $sm = tblsales::get();
        $ContactID = tblcontacts::max('ContactID');
        if($ContactID == null)
            $ContactID = 1;
        else
            $ContactID=$ContactID+1;
        return view('accounting\creditors\addcreditor', ['sm' => $sm,'ContactID'=>$ContactID]);
    }
    public function saveCreditor(Request $request){

        $validatedData = $request->validate([
            'creditorID' => 'required|unique:tblcreditors',
            'salesman' => 'required',
            'clientName' => 'required',
            'mLastName' => 'required',
            'street' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'phone' => 'required',
        ]);
        if($request->comments==null){
            $request->comments='';
        }
        $creditor = new tblcreditor();
        $creditor->CreditorID = $request->creditorID;
        $creditor->SaleID = $request->salesman;
        $creditor->OpenDate = $request->opendate;
        $creditor->Comments = $request->comments;
        if($request->compreport == null) {
            $creditor->CompReport = 0;
        }
        else{
            $creditor->CompReport = $request->compreport;
        }

        $creditor->LastDate = $request->lastdate;
        $creditor->LastUpdate = date('Y-m-d H:i:s');
        $creditor->UserUpdated = Auth::user()->name;

        $creditor->save();
        $maxValue = tblcontacts::max('ContactID');
        if($maxValue == null)
            $maxValue = 1;
        else
            $maxValue=$maxValue+1;
        $contact = new tblcontacts();
        $contact->CreditorID = $request->creditorID;
        $contact->ContactID = $maxValue;
        $contact->ClientName = $request->clientName;
        $contact->Saltnt = $request->sltn;
        $contact->CFirstName = $request->mFirstName;
        $contact->CLastName = $request->mLastName;
        $contact->MainManager = 1;
        $contact->Street = $request->street;
        $contact->City = $request->city;
        $contact->Country = $request->country;
        $contact->State = $request->state;
        $contact->Zip = $request->zip;
        $contact->Phone = $request->phone;
        $contact->Ext = $request->ext;
        $contact->Fax= $request->fax;
        $contact->Email= $request->Email;

        $contact->LastUpdate = date('Y-m-d H:i:s');;
        $contact->UserUpdated = Auth::user()->name;

        $contact->save();
        return redirect('/Creditor?msg=Creditor Successfully Saved.');
    }
    public function editCreditor(Request $request){
        $result = rolerightsfield::where('RoleID','=',Auth::user()->is_permission)
            ->where('ScreenName','=','Creditor')
            ->where('FieldName','=','EditCreditor')
            ->first();
        if($result == null){
            return redirect('/Creditor?msg=Access denied.');
        }else{
            if(!$result->Active){
                return redirect('/Creditor?msg=Access denied.');
            }
        }
        if($request->updateCreditorID != null)
        {
            $validatedData = $request->validate([
                'updateCreditorID' => 'required|max:191',
                'salesman' => 'required',
                'clientName' => 'required',
                'mLastName' => 'required',
                'street' => 'required',
                'state' => 'required',
                'zip' => 'required',
                'phone' => 'required',
            ]);

            $newCreditor = new tblcreditor();
            $compr = 0;

            if($request->compreport != null) {
                $compr = $request->compreport;
            }
            $updateArray= array();
            $updateArray=$this->checkRights($updateArray,'Creditor','CreditorID',$request->creditorID);
            $updateArray=$this->checkRights($updateArray,'Creditor','SaleID',$request->salesman);
            $updateArray=$this->checkRights($updateArray,'Creditor','OpenDate',$request->opendate);
            $updateArray=$this->checkRights($updateArray,'Creditor','Comments',$request->comments);
            $updateArray=$this->checkRights($updateArray,'Creditor','CompReport',$request->$compr);
            $updateArray=$this->checkRights($updateArray,'Creditor','LastDate',$request->lastdate);
            $updateArray=$this->checkRights($updateArray,'Creditor','Email',$request->Email);
            $updateArray = array_add($updateArray, 'LastUpdate', date('Y-m-d H:i:s'));
            $updateArray = array_add($updateArray, 'UserUpdated',  Auth::user()->name);

//            /$data['pussy']='wagon';
            $newCreditor->where('creditorID','=',$request->updateCreditorID)
                ->update($updateArray);
           // dd($newCreditor);
            /*array(
                'creditorID'=>$request->creditorID,
                'SaleID' => $request->salesman,
                'OpenDate' => $request->opendate,
                'Comments' => $request->comments,
                'CompReport' => $compr,
                'LastDate' => $request->lastdate,
                'LastUpdate' => date('Y-m-d H:i:s'),
                'UserUpdated' => Auth::user()->name,
            )*/
            $newContactCheck=tblcontacts::where('CreditorID','=', $request->updateCreditorID)->where('MainManager','=', 1)->first();
            if($newContactCheck != null){
                $newContact= new tblcontacts();
                $updateContactArray= array();
                $updateContactArray=$this->checkRights($updateContactArray,'Creditor','ClientName',$request->clientName);
                $updateContactArray=$this->checkRights($updateContactArray,'Creditor','Saltnt',$request->sltn);
                $updateContactArray=$this->checkRights($updateContactArray,'Creditor','CFirstName',$request->mFirstName);
                $updateContactArray=$this->checkRights($updateContactArray,'Creditor','CLastName',$request->mLastName);
                $updateContactArray=$this->checkRights($updateContactArray,'Creditor','MainManager',1);
                $updateContactArray=$this->checkRights($updateContactArray,'Creditor','Street',$request->street);
                $updateContactArray=$this->checkRights($updateContactArray,'Creditor','City',$request->city);
                $updateContactArray=$this->checkRights($updateContactArray,'Creditor','Country',$request->country);

                $updateContactArray=$this->checkRights($updateContactArray,'Creditor','State',$request->state);
                $updateContactArray=$this->checkRights($updateContactArray,'Creditor','Zip',$request->zip);
                $updateContactArray=$this->checkRights($updateContactArray,'Creditor','Phone',$request->phone);
                $updateContactArray=$this->checkRights($updateContactArray,'Creditor','Fax',$request->fax);
                $updateContactArray=$this->checkRights($updateContactArray,'Creditor','Ext',$request->ext);
                $updateContactArray=$this->checkRights($updateContactArray,'Creditor','Email',$request->Email);

                $updateContactArray = array_add($updateContactArray, 'LastUpdate', date('Y-m-d H:i:s'));
                $updateContactArray = array_add($updateContactArray, 'UserUpdated',  Auth::user()->name);
               // dd($updateContactArray);
                $newContact->where('creditorID','=',$request->updateCreditorID)
                    ->where('ContactID','=',$request->ContactID)
                    ->update($updateContactArray);
               /* array(
                    'ClientName' => $request->clientName,
                    'Saltnt' => $request->sltn,
                    'CFirstName' => $request->mFirstName,
                    'CLastName' => $request->mLastName,
                    'MainManager' => 1,
                    'Street' => $request->street,
                    'City' => $request->city,
                    'State' => $request->state,
                    'Zip' => $request->zip,
                    'Phone' => $request->phone,
                    'Fax' => $request->fax,
                    'Ext' => $request->ext,
                    'Email'=> $request->Email,
                    'LastUpdate' => date('Y-m-d H:i:s'),
                    'UserUpdated' => Auth::user()->name,
                )*/
            }else{
                $maxValue = tblcontacts::max('ContactID');
                if($maxValue == null)
                    $maxValue = 1;
                else
                    $maxValue=$maxValue+1;
                $contact = new tblcontacts();
                $contact->CreditorID = $request->creditorID;
                $contact->ContactID = $maxValue;
                $contact->ClientName = $request->clientName;
                $contact->Saltnt = $request->sltn;
                $contact->CFirstName = $request->mFirstName;
                $contact->CLastName = $request->mLastName;
                $contact->MainManager = 1;
                $contact->Street = $request->street;
                $contact->City = $request->city;
                $contact->State = $request->state;
                $contact->Zip = $request->zip;
                $contact->Phone = $request->phone;
                $contact->Ext = $request->ext;
                $contact->Fax= $request->fax;
                $contact->LastUpdate = date('Y-m-d H:i:s');;
                $contact->UserUpdated = Auth::user()->name;

                $contact->save();
            }
            return redirect('/Creditor?msg=Creditor Successfully Updated.');
        }
        $sm = tblsales::get();
        $creditor = tblcreditor::where('creditorID','=',$request->creditorID)->first();

        $contact = tblcontacts::where('CreditorID','=', $request->creditorID)->where('MainManager','=', 1)->first();
        if($contact == null){
            $contact = new tblcontacts();
        }
        $NumbOfDebt = tblDebtor::where('creditorID','=',$request->creditorID)->get()->Count('DebtorID');
        $TotalPlaced=\DB::select('SELECT tblDebtors.CreditorID, round(Sum(tblDebtors.AmountPlaced),2) AS SumOfAmountPlaced FROM tblDebtors GROUP BY tblDebtors.CreditorID HAVING (((tblDebtors.CreditorID)=\''.$request->creditorID.'\'))');
        $TotalCollected=\DB::select('SELECT tblDebtors.CreditorID,round( Sum(tblTrusts.PaymentReceived),2) AS Credits FROM tblDebtors INNER JOIN tblTrusts ON tblDebtors.DebtorID=tblTrusts.DebtorID WHERE (((tblTrusts.TPaymentType)="C")) GROUP BY tblDebtors.CreditorID HAVING (((tblDebtors.CreditorID)=\''.$request->creditorID.'\' ));');
        $CollectTrust=\DB::select('SELECT DISTINCTROW tblDebtors.CreditorID,
     ROUND(Sum(COALESCE(Intrest,0)-
    COALESCE(AttyFees,0)+
    COALESCE(MiscFees,0)+
    COALESCE(AgencyGross,0)),2) AS SumOfNetClient
    FROM tblDebtors LEFT JOIN tbltrusts tblTrust ON tblDebtors.DebtorID=tblTrust.DebtorID
    WHERE (((tblTrust.TPaymentType)="T") And ((tblTrust.DateRcvd)>\'5/29/2000\') And ((tblDebtors.CreditorID)=\''.$request->creditorID.'\') )
    GROUP BY tblDebtors.CreditorID;');
        $CollectTrustOld=\DB::select('SELECT tblDebtors.CreditorID,  tblTrusts.DebtorID, round(Sum(COALESCE(tblTrusts.PaymentReceived,0)- COALESCE(MiscFees,0)+ COALESCE(CostRef,0)- COALESCE(AttyFees,0)- COALESCE(AgencyGross,0)),2) AS Pmnt FROM tblDebtors LEFT JOIN tblTrusts ON tblDebtors.DebtorID=tblTrusts.DebtorID WHERE (((tblTrusts.TPaymentType)="T") and tbltrusts.DateRcvd <= \'5/29/2000\' AND tbldebtors.CreditorID =\''.$request->creditorID.'\' ) GROUP BY tblDebtors.CreditorID, tblTrusts.DebtorID;');
        //CollectCredits + CollectTrust + CollectTrustOld
        $totalCollectedValue=0;
        if($TotalCollected !=null){
            $totalCollectedValue =$totalCollectedValue +floatval($TotalCollected[0]->Credits);
        }
        $txtTotalRec=0;
        if($CollectTrust !=null){

            $totalCollectedValue  =$totalCollectedValue +floatval($CollectTrust[0]->SumOfNetClient);
            $txtTotalRec=floatval($CollectTrust[0]->SumOfNetClient);
        }
        if($CollectTrustOld != null){
            $totalCollectedValue  =$totalCollectedValue +floatval($CollectTrustOld[0]->Pmnt);
            $txtTotalRec=floatval($txtTotalRec) + floatval($CollectTrustOld[0]->Pmnt);
        }
        //$totalCollectedValue=floatval($TotalCollected[0]->Credits) + floatval($CollectTrust[0]->SumOfNetClient) + floatval($CollectTrustOld[0]->Pmnt);

        $InvDue=\DB::select('select tblDebtors.CreditorID,COALESCE((case Fee1Type when \'%\'  then (Fee1Balance/100)*Fee1 ELSE Fee1 end) +  (case Fee2Type when Null  then 0 when \'%\' THEN (Fee2Balance/100)*Fee2 ELSE Fee2 end) + (case Fee3Type when Null  then 0 when \'%\' THEN (Fee3Balance/100)*Fee3 ELSE Fee3 end) - COALESCE(AttyFees,0),0)\'inv\' from tblDebtors LEFT JOIN tblInvoices ON tblDebtors.DebtorID=tblInvoices.DebtorID  GROUP BY tblDebtors.CreditorID HAVING (((tblDebtors.CreditorID)=\'ADI-112\' ));');
        $InvDues=0;
        if($InvDue != null){
            $InvDues=$InvDue[0]->inv;
        }


        $SumOfAmountPlaced=0;
        if($TotalPlaced != null){
            $SumOfAmountPlaced =$TotalPlaced[0]->SumOfAmountPlaced;
        }

        $ID=\DB::table('tblCreditors')->where('CreditorID', '=', $request->creditorID)->value('ID');
        $first =null;
        $last =null;
        $pID = tblCreditor::where('ID', '<', $ID)->max('ID');
        $previous=\DB::table('tblCreditors')->where('ID', '=', $pID)->value('creditorID');
    // get next user id
        $NID = tblCreditor::where('ID', '>', $ID)->min('ID');
        $Next=\DB::table('tblCreditors')->where('ID', '=', $NID)->value('creditorID');
        return view('accounting\creditors\creditorEditForm', ['creditor'=> $creditor,
            'sm'=>$sm,'NumbOfDebt'=>$NumbOfDebt,'SumOfAmountPlaced'=>$SumOfAmountPlaced,
            'totalCollectedValue'=>$totalCollectedValue,
            'CollectTrust'=>$CollectTrust,'InvDues'=>$InvDues,
            'txtTotalRec'=>$txtTotalRec,
            'first'=>$first,
            'previous'=>$previous,
            'Next'=>$Next,
            'last'=>$last,
            'contact'=>$contact]);



    }
    public function delCreditor(Request $request){
        $result = rolerightsfield::where('RoleID','=',Auth::user()->is_permission)
            ->where('ScreenName','=','Creditor')
            ->where('FieldName','=','DeleteCreditor')
            ->first();
        if($result == null){
            return redirect('/Creditor?msg=Access denied.');
        }else{
            if(!$result->Active){
                return redirect('/Creditor?msg=Access denied.');
            }
        }
        tblcreditor::where('creditorID','=',$request->creditorID)->delete();
        return redirect('/Creditor?msg=Creditor Successfully Deleted.');
    }
    public function GetCreditorID(Request $request){
        $creditor = tblcreditor::where('CreditorID',$request->id)->first();

        return $creditor;

    }



    public function contacts(Request $request){
        session(['creditorID' => $request->creditorID]);
        return redirect('/Contact');
    }
    public function contact(Request $request){
        $contacts = null;
        if($request->searchContact == null) {
            $contacts = tblcontacts::
                where('CreditorID','=',$request->session()->get('creditorID'))->where('MainManager','=', 0)
                ->get();
        }
        else{
            $contacts = tblcontacts::
                where('CreditorID','=','%'.$request->session()->get('creditorID'))->where('MainManager','=', 0)
                ->get();
        }


        return view('accounting\contacts\contact', ['contacts' => $contacts]);
    }
    public function addContact(){
        return view('accounting\contacts\addcontact');
    }
    public function savecontact(Request $request){

        /*$validatedData = $request->validate([
            'creditorID' => 'required|max:191',
            'salesman' => 'required|max:191',

        ]);*/

        $maxValue = tblcontacts::max('ContactID');
        if($maxValue == null)
            $maxValue = 1;
        else
            $maxValue=$maxValue+1;


        $contact = new tblcontacts();
        $contact->CreditorID = session('creditorID');
        $contact->ContactID = $maxValue;
        $contact->ClientName = $request->clientName;
        $contact->Saltnt = $request->sltn;
        $contact->CFirstName = $request->mFirstName;
        $contact->CLastName = $request->mLastName;
        $contact->MainManager = 0;
        $contact->Street = $request->street;
        $contact->City = $request->city;
        $contact->State = $request->state;
        $contact->Zip = $request->zip;
        $contact->Phone = $request->phone;
        $contact->Ext = $request->ext;
        $contact->Fax= $request->fax;
        $contact->Email= $request->Email;
        $contact->LastUpdate = date('Y-m-d H:i:s');;
        $contact->UserUpdated = Auth::user()->name;

        if($request->mainmanager == 1)
        {
            tblcontacts::where('CreditorID','=', session('creditorID'))
                ->update(array(
                    'MainManager' => 0,
                    ));
        }

        $contact->save();

        return redirect('/Contact?msg=Contact Successfully Saved.');
    }
    public function editcontact(Request $request){
        if($request->CreditorID!= null){
        session(['creditorID' => $request->CreditorID]);
        }
        if($request->updateContactID != null)
        {
            /*$validatedData = $request->validate([
                'updateCreditorID' => 'required|max:191',
                'salesman' => 'required|max:191',
            ]);*/

            $newContact = new tblcontacts();
            $mainManager = 0;

            if($mainManager != 0)
            {
                tblcontacts::where('creditorID','=',session('creditorID'))
                    ->update(array(
                        'MainManager' => false,
                    ));
            }

            $newContact->where('creditorID','=',session('creditorID'))
                ->where('ContactID','=',$request->contactID)
                ->update(array(
                    'ClientName' => $request->clientName,
                    'Saltnt' => $request->sltn,
                    'CFirstName' => $request->mFirstName,
                    'CLastName' => $request->mLastName,
                    'MainManager' => 0,
                    'Street' => $request->street,
                    'City' => $request->city,
                    'State' => $request->state,
                    'Zip' => $request->zip,
                    'Phone' => $request->phone,
                    'Fax' => $request->ext,
                    'Email' => $request->Email,
                    'Ext' => $request->fax,
                    'LastUpdate' => date('Y-m-d H:i:s'),
                    'UserUpdated' => Auth::user()->name,
                ));

            return redirect('/Contact?msg=Contact Successfully Updated.');
        }
        $contact = tblcontacts::where('creditorID','=', session('creditorID'))->where('ContactID','=',$request->contactID)->first();
        return view('accounting\contacts\contactEditForm', ['contact'=> $contact]);

    }
    public function delcontact(Request $request){
        tblcontacts::where('creditorID','=', session('creditorID'))->where('ContactID','=',$request->contactID)->delete();
        return redirect('/Contact?msg=Contact Successfully Deleted.');
    }



    public function debtor(Request $request){
        $debtor = null;
        if($request->Export != null){
            //$creditor = tblcreditor::get();
            $creditor= \DB::select('select * from tblDebtors');
            return  $this->Export($creditor,'Debtors');
        }
        if($request->searchCreditor == null) {
            $debtor = tblDebtor::paginate(5);
            //$debtor = new tblDebtor();
        }
        else{
            $debtor = tblDebtor::
            where('CreditorID','like','%'.$request->searchCreditor.'%')
                ->orWhere('DebtorID','like','%'.$request->searchCreditor.'%')
                ->orWhere('DebtorName','like','%'.$request->searchCreditor.'%')
                ->orWhere('DFirstName','like','%'.$request->searchCreditor.'%')
                ->orWhere('DLastName','like','%'.$request->searchCreditor.'%')
                ->orWhere('ClientAcntNumber','like','%'.$request->searchCreditor.'%')
                ->orWhere('Phone','like','%'.$request->searchCreditor.'%')
                ->orWhere('State','like','%'.$request->searchCreditor.'%')
                ->orWhere('City','like','%'.$request->searchCreditor.'%')
                ->orWhere('Street','like','%'.$request->searchCreditor.'%')
                ->orWhere('Zip','like','%'.$request->searchCreditor.'%')
                ->paginate(5);
        }

        return view('accounting\debtors\debtor', ['debtor' => $debtor]);
    }
    public function addDebtor(Request $request){
        $result = rolerightsfield::where('RoleID','=',Auth::user()->is_permission)
            ->where('ScreenName','=','Debitor')
            ->where('FieldName','=','NewDebtor')
            ->first();
        if($result == null){
            return redirect('/Debtor?msg=Access denied.');
        }else{
            if(!$result->Active){
                return redirect('/Debtor?msg=Access denied.');
            }
        }
        $sm = tblStatus::get();
        $cd = DB::table('tblcreditors')
            ->join('tblcontacts','tblcreditors.creditorID','=','tblcontacts.creditorID')
            ->where('tblcontacts.MainManager','=',1)
            ->select('tblcreditors.*','tblcontacts.ClientName')
            ->get();
        $col = tblcollector::get();
        $DID=$request->DID;
        $DebtorID = tblDebtor::max('DebtorID');
        if($DebtorID == null)
            $DebtorID = 1;
        else
            $DebtorID=$DebtorID+1;
        return view('accounting\debtors\adddebtor', ['sm' => $sm,'cd' => $cd,'col' => $col,'DebtorID'=>$DebtorID ,'DID'=>$DID]);
    }
    public function getContact(Request $request){
        $id = $request->id;
        $cd = tblcontacts:: where('CreditorID','=',$id)
            ->get();
        return $cd;
    }
    public function saveDebtor(Request $request){

        $validatedData = $request->validate([
            'creditorID' => 'required|max:191',
            'debtorName' => 'required|max:191',
        ]);
        $DebtorID = tblDebtor::max('DebtorID');
        if($DebtorID == null)
            $DebtorID = 1;
        else
            $DebtorID=$DebtorID+1;

        $creditor = new tblDebtor();
        $creditor->DebtorID=$DebtorID;
        $creditor->CreditorID = $request->creditorID;
        $creditor->ColID = $request->colID;
        $creditor->ContactID = $request->creditorContactName;
        $creditor->DateEntered = $request->dateEntered;
        $creditor->DebtorName = $request->debtorName;
        $creditor->DFirstName = $request->firstName;
        $creditor->DLastName = $request->lastName;
        $creditor->Street = $request->street;
        $creditor->City = $request->city;
        $creditor->Country = $request->Country;

        $creditor->State = $request->state;
        $creditor->Zip = $request->zip;
        $creditor->Phone = $request->phone;
        $creditor->ClientAcntNumber = $request->clientAccount;
        $creditor->StatusID = $request->statusID;
        $creditor->LastDate = $request->lastDate;
        $creditor->AmountPlaced = $request->amountPlaced;
        $creditor->FormDate = $request->formDate;
        $creditor->CostAdv = $request->costAdvance;
        $creditor->CostRec = $request->costRecover;
        $creditor->SuitFee = $request->suitFee;
        $creditor->Fees = $request->fees;
        $creditor->LastUpdate = date('Y-m-d H:i:s');
        $creditor->UserUpdated =Auth::user()->name;
        $creditor->Salutation=$request->Salutation;
        $creditor->Email=$request->Email;
        $creditor->Fax=$request->Fax;
        $creditor->save();
        return redirect('/AddDebtor?DID='.$DebtorID.'&msg=Debtor Successfully Saved.');

    }
    public function editDebtor(Request $request){
        $result = rolerightsfield::where('RoleID','=',Auth::user()->is_permission)
            ->where('ScreenName','=','Debitor')
            ->where('FieldName','=','EditDebtor')
            ->first();
        if($result == null){
            return redirect('/Debtor?msg=Access denied.');
        }else{
            if(!$result->Active){
                return redirect('/Debtor?msg=Access denied.');
            }
        }

        if($request->AttorneyRequest =='Yes'){
            $validatedData = $request->validate([
                'AttorneyName' => 'required|max:191',
            ]);
            if($request->updateAttorneyID !=null){
                $attorney= tblattorneys::where('attorneyID','=',$request->updateAttorneyID)
                    ->update(array(
                        'AttorneyName' => $request->AttorneyName,
                        'FirmName' => $request->FirmName,
                        'Street1' => $request->Street1,
                        'Street2' => $request->Street2,
                        'City' => $request->City,
                        'State' => $request->State,
                        'Zip' => $request->Zip,
                        'Email' => $request->Email,
                        'Cell' => $request->Cell,
                        'Phone' => $request->Phone,
                        'Fax' => $request->Fax,
                        'Website' => $request->Website,
                        'BarNumber' => $request->BarNumber,
                        'RepresentationCapacity' => $request->RepresentationCapacity,
                        'DebtorID' => $request->DebtorID,
                    ));
                $newCreditor = new tblDebtor();
                $newCreditor->where('DebtorID','=',$request->DebtorID)
                    ->update(array(
                        'attorneyID' => $request->updateAttorneyID,
                    ));
                return response()->json($attorney= tblattorneys::where('attorneyID','=',$request->updateAttorneyID)->first());
            }
            $Attorney = new tblattorneys();
            $Attorney->AttorneyName = $request->AttorneyName    ;
            $Attorney->FirmName = $request->FirmName;
            $Attorney->Street1 = $request->Street1;
            $Attorney->Street2 = $request->Street2;
            $Attorney->City = $request->City;
            $Attorney->State = $request->State;
            $Attorney->Zip = $request->Zip;
            $Attorney->Email = $request->Email;
            $Attorney->Cell = $request->Cell;
            $Attorney->Phone = $request->Phone;
            $Attorney->Fax = $request->Fax;
            $Attorney->Website = $request->Website;
            $Attorney->BarNumber = $request->BarNumber;
            $Attorney->RepresentationCapacity = $request->RepresentationCapacity;
            $Attorney->DebtorID = $request->DebtorID;
            $Attorney->save();
            $newCreditor = new tblDebtor();
            $newCreditor->where('DebtorID','=',$request->DebtorID)
                ->update(array(
                    'attorneyID' => $Attorney->id,
                ));
            return response()->json($Attorney);
        }
        if($request->updateDebtorID != null)
        {
            $validatedData = $request->validate([
                'updateDebtorID' => 'required|max:191',
                'debtorName' => 'required|max:191',
            ]);

            $newCreditor = new tblDebtor();
            $updateArray= array();
            $updateArray=$this->checkRights($updateArray,'Debitor','CreditorID',$request->creditorID);
            $updateArray=$this->checkRights($updateArray,'Debitor','ColID',$request->colID);
            $updateArray=$this->checkRights($updateArray,'Debitor','ContactID',$request->creditorContactName);
            $updateArray=$this->checkRights($updateArray,'Debitor','DateEntered',$request->dateEntered);
            $updateArray=$this->checkRights($updateArray,'Debitor','DebtorName',$request->debtorName);
            $updateArray=$this->checkRights($updateArray,'Debitor','DFirstName',$request->firstName);

            $updateArray=$this->checkRights($updateArray,'Debitor','DLastName',$request->lastName);
            $updateArray=$this->checkRights($updateArray,'Debitor','Street',$request->street);
            $updateArray=$this->checkRights($updateArray,'Debitor','City',$request->city);
            $updateArray=$this->checkRights($updateArray,'Debitor','Country',$request->country);
            $updateArray=$this->checkRights($updateArray,'Debitor','State',$request->state);
            $updateArray=$this->checkRights($updateArray,'Debitor','Zip',$request->zip);
            $updateArray=$this->checkRights($updateArray,'Debitor','Phone',$request->phone);

            $updateArray=$this->checkRights($updateArray,'Debitor','ClientAcntNumber',$request->clientAccount);
            $updateArray=$this->checkRights($updateArray,'Debitor','StatusID',$request->statusID);
            $updateArray=$this->checkRights($updateArray,'Debitor','LastDate',$request->lastDate);

            $updateArray=$this->checkRights($updateArray,'Debitor','AmountPlaced', $this->dollorValidate($request->amountPlaced));
            $updateArray=$this->checkRights($updateArray,'Debitor','FormDate',$request->formDate);
            $updateArray=$this->checkRights($updateArray,'Debitor','CostAdv', $this->dollorValidate($request->costAdvance));
            $updateArray=$this->checkRights($updateArray,'Debitor','CostRec', $this->dollorValidate($request->costRecover));

            $updateArray=$this->checkRights($updateArray,'Debitor','SuitFee', $this->dollorValidate($request->suitFee));
            $updateArray=$this->checkRights($updateArray,'Debitor','Fees', $this->dollorValidate($request->fees));
            $updateArray=$this->checkRights($updateArray,'Debitor','Salutation',$request->Salutation);
            $updateArray=$this->checkRights($updateArray,'Debitor','attorneyID',$request->attorneyID);
            $updateArray=$this->checkRights($updateArray,'Debitor','Email',$request->Email);
            $updateArray=$this->checkRights($updateArray,'Debitor','Fax',$request->Fax);
            $updateArray = array_add($updateArray, 'LastUpdate', date('Y-m-d H:i:s'));
            $updateArray = array_add($updateArray, 'UserUpdated',  Auth::user()->name);

            $newCreditor->where('DebtorID','=',$request->updateDebtorID)
                ->update($updateArray);
           /* array(
                'CreditorID' => $request->,
                    'ColID' => $request->,
                    'ContactID' => $request->,
                    'DateEntered' => $request->,
                    'DebtorName' => $request->,
                    'DFirstName' => $request->,
                    'DLastName' => $request->,
                    'Street' => $request->,
                    'City' => $request->,
                    'State' => $request->,
                    'Zip' => $request->,
                    'Phone' => $request->,
                    'ClientAcntNumber' => $request->,
                    'StatusID' => $request->,
                    'LastDate' => $request->,
                    'AmountPlaced' => $request->,
                    'FormDate' => $request->,
                    'CostAdv' => $request->,
                    'CostRec' => $request->,
                    'SuitFee' => $request->,
                    'Fees' => $request->,
                    'LastUpdate' => date('Y-m-d H:i:s'),
                    'UserUpdated' => Auth::user()->name,
                    'Salutation'=>$request->,
                    'Email'=>$request->,
                    'attorneyID'=>$request->,
                )*/
            return redirect('/Debtor?msg=Debtor Successfully Updated.');
        }
        $sm = tblStatus::get();
        $cd = tblcontacts::get();
        $col = tblcollector::get();
        $activityCode = tblactivitycode::get();
        $creditor = tblDebtor::where('DebtorID','=',$request->DebtorID)->first();
        $contact = tblcontacts:: where('CreditorID','=',$creditor->CreditorID)->get();
        $attorney=new tblattorneys();
        if($creditor->attorneyID != null && $creditor->attorneyID != 0){
            $attorney= tblattorneys::where('attorneyID','=',$creditor->attorneyID)->first();
            if($attorney==null)
            {
                $attorney= new tblattorneys();
            }
        }else{
            $attorney= new tblattorneys();
        }
        $files = tblfile::where('DebtorID','=',$creditor->DebtorID)->get();
        $notes = tblnote::where('DebtorID','=',$creditor->DebtorID)->orderBy('DateTime', 'DESC')->get();
        $first =null;
        $last =null;
        $previous = tblDebtor::where('DebtorID', '<', $request->DebtorID)->max('DebtorID');
        $Next= tblDebtor::where('DebtorID', '>', $request->DebtorID)->min('DebtorID');


        $pending =0;
        $FeesVal=0;
        $MISCFeeTrustVal=0;
        $CostRecoveredVal=0;
        $temp= tbltemplate::get();
        
        foreach ($notes as $note){
            $date = $note->DateTime;
//            echo $date;
            if ( strlen($date) == strlen("2018-04-27 12:25:27") ){
                // 2018-04-27 12:25:27
                $yyyy = substr($date, 0,4);
                $mm = substr($date, 5,2);
                $dd = substr($date, 8,2);
                
                $tmp1 = $mm."/".$dd."/".$yyyy." ".substr($date, 11,8);
                $note->DateTime = $tmp1;
            }
//            $note->DateTime = '111';
        }


        return view('accounting\debtors\debtorEditForm', ['creditor'=> $creditor,'sm' => $sm,'cd' => $cd,'col' => $col,
            'first'=>$first,
            'previous'=>$previous,
            'Next'=>$Next,
            'last'=>$last,
            'pending'=>$pending,
            'FeesVal'=>$FeesVal,
            'MISCFeeTrustVal'=>$MISCFeeTrustVal,
            'CostRecoveredVal'=>$CostRecoveredVal,
            'attorney'=>$attorney,
            'notes'=>$notes,
            'files'=>$files,
            'activityCode'=>$activityCode,
            'contact'=>$contact,
            'temp'=>$temp]);

    }
    public function calculationDebit(Request $request){
        $PaidInv=\DB::select('select ROUND(Sum(PaymentReceived),2) AS SumOfAmountPaid from tbltrusts where TPaymentType="C" AND DebtorID ='.$request->DebtorID.' GROUP BY DebtorID;');
        /*$PaidInv=\DB::select('SELECT DISTINCTROW tblDebtors.CreditorID, tblTrust.DebtorID, ROUND(Sum(tblTrust.PaymentReceived),2) AS SumOfAmountPaid
                    FROM tblDebtors LEFT JOIN tbltrusts tblTrust ON tblDebtors.DebtorID = tblTrust.DebtorID
                    WHERE (((tblTrust.TPaymentType)="C") AND tblTrust.DebtorID ='.$request->DebtorID.')
                    GROUP BY tblDebtors.CreditorID, tblTrust.DebtorID;
                    ');*/

        $PaidTrustNew=\DB::select('select ROUND(Sum(CostRef),2) AS CostRef, ROUND(Sum(PaymentReceived+COALESCE(AttyFees,0)),2) AS SumOfNetClient from tbltrusts where TPaymentType="T" AND dateRcvd >\'5/29/2000\' AND DebtorID ='.$request->DebtorID.' GROUP BY DebtorID;');
        /*  $PaidTrustNew=\DB::select('SELECT DISTINCTROW tblDebtors.CreditorID, tblTrust.DebtorID, Sum(tblTrust.CostRef) AS CostRef,
ROUND(Sum(tblTrust.PaymentReceived+COALESCE(AttyFees,0)),2) AS SumOfNetClient
FROM tblDebtors LEFT JOIN tbltrusts tblTrust ON tblDebtors.DebtorID = tblTrust.DebtorID
WHERE (((tblTrust.TPaymentType)="T") AND ((tblTrust.DateRcvd)>\'5/29/2000\') AND tblTrust.DebtorID = '.$request->DebtorID.')
GROUP BY tblDebtors.CreditorID, tblTrust.DebtorID;
');**/
        $pending =0;
        if($PaidInv !=null){ $pending =$pending+$PaidInv[0]->SumOfAmountPaid; }
        if($PaidTrustNew !=null){$pending =$pending+$PaidTrustNew[0]->SumOfNetClient;}
        $AGross=\DB::select('select ROUND(Sum(AgencyGross),2) AS SumOfAgencyGross from tbltrusts where TPaymentType="T"  AND DebtorID ='.$request->DebtorID.'  GROUP BY DebtorID;');
       // $AGross=\DB::select('SELECT tblDebtors.DebtorID, ROUND(Sum(tblTrust.AgencyGross),2) AS SumOfAgencyGross FROM tblDebtors INNER JOIN tbltrusts tblTrust ON tblDebtors.DebtorID=tblTrust.DebtorID WHERE (((tblTrust.TPaymentType)="T")) GROUP BY tblDebtors.DebtorID HAVING (((tblDebtors.DebtorID)='.$request->DebtorID.'))');

        $FeesInv=\DB::select('SELECT
        ROUND(Sum(
        case Fee1Type when "%" then (Fee1Balance/100)*Fee1 else Fee1 end +
        case Fee2Type when null then 0 when Fee2Type="%" then (Fee2Balance/100)*Fee2 when "$" then Fee2 end +
        case Fee3Type when null then 0 when Fee3Type="%" then (Fee3Balance/100)*Fee3 when "$" then Fee3 end
        ) ,2)AS DueInv
        FROM  tblinvoices  WHERE  DebtorID ='.$request->DebtorID.'
        GROUP BY DebtorID;');
       /* $FeesInv=\DB::select('SELECT tblDebtors.DebtorID,
    ROUND(Sum(
    case Fee1Type when "%" then (Fee1Balance/100)*Fee1 else Fee1 end +
    case Fee2Type when null then 0 when Fee2Type="%" then (Fee2Balance/100)*Fee2 when "$" then Fee2 end +
    case Fee3Type when null then 0 when Fee3Type=\'%\' then (Fee3Balance/100)*Fee3 when "$" then Fee3 end
    ) ,2)AS DueInv
    FROM tblDebtors INNER JOIN tblinvoices tblInvoice ON tblDebtors.DebtorID=tblInvoice.DebtorID
    GROUP BY tblDebtors.DebtorID
    HAVING (((tblDebtors.DebtorID)='.$request->DebtorID.'));');*/
        $FeesVal=0;
        if($AGross !=null){
            $FeesVal=$FeesVal+$AGross[0]->SumOfAgencyGross;
        }
        if($FeesInv !=null){
            $FeesVal=$FeesVal+$FeesInv[0]->DueInv;
        }
        $MISCFeeTrust=\DB::select('SELECT round( Sum(MiscFees),2) AS SumOfMiscFees
    FROM  tbltrusts
    WHERE TPaymentType="T" AND DebtorID ='.$request->DebtorID.'
    GROUP BY DebtorID;');
      /*  $MISCFeeTrust=\DB::select('SELECT tblDebtors.DebtorID,round( Sum(tblTrust.MiscFees),2) AS SumOfMiscFees
    FROM tblDebtors INNER JOIN tbltrusts tblTrust ON tblDebtors.DebtorID=tblTrust.DebtorID
    WHERE (((tblTrust.TPaymentType)="T"))
    GROUP BY tblDebtors.DebtorID
    HAVING (((tblDebtors.DebtorID)='.$request->DebtorID.'));');*/
        $MISCFeeTrustVal=0;
        if($MISCFeeTrust != null){
            $MISCFeeTrustVal=$MISCFeeTrust[0]->SumOfMiscFees;
        }
        $CostRecovered=\DB::select('SELECT round(Sum(CostRef),2) AS SumOfCostRef
    FROM  tbltrusts
    WHERE TPaymentType="T" AND DebtorID ='.$request->DebtorID.'
    GROUP BY DebtorID;');
      /*  $CostRecovered=\DB::select('SELECT tblDebtors.DebtorID, round(Sum(tblTrust.CostRef),2) AS SumOfCostRef
    FROM tblDebtors INNER JOIN tbltrusts tblTrust ON tblDebtors.DebtorID=tblTrust.DebtorID
    WHERE (((tblTrust.TPaymentType)="T"))
    GROUP BY tblDebtors.DebtorID
    HAVING (((tblDebtors.DebtorID)='.$request->DebtorID.'));');*/
        $CostRecoveredVal=0;
        if($CostRecovered != null){
            $CostRecoveredVal=$CostRecovered[0]->SumOfCostRef;
        }

        $Obj= new \stdClass();
        $Obj->pending=$pending;
        $Obj->FeesVal=$FeesVal;
        $Obj->MISCFeeTrustVal=$MISCFeeTrustVal;
        $Obj->CostRecoveredVal=$CostRecoveredVal;
        return response()->json($Obj);
    }


    public function delDebtor(Request $request){
        $result = rolerightsfield::where('RoleID','=',Auth::user()->is_permission)
            ->where('ScreenName','=','Debitor')
            ->where('FieldName','=','DeleteDebtor')
            ->first();
        if($result == null){
            return redirect('/Debtor?msg=Access denied.');
        }else{
            if(!$result->Active){
                return redirect('/Debtor?msg=Access denied.');
            }
        }
        tblDebtor::where('DebtorID','=',$request->DebtorID)->delete();
        return redirect('/Debtor?msg=Debtor Successfully Deleted.');
    }
    public function delAttorney(Request $request){

        tblattorneys::where('attorneyID','=',$request->ID)->delete();
        $newCreditor = new tblDebtor();
        $newCreditor->where('DebtorID','=',$request->DebtorID)
            ->update(array(
                'attorneyID' => 0,
            ));
        return redirect('/EditDebtor/'.$request->DebtorID.'?msg=Attorney Successfully Deleted.');
    }
    public function lettersDebtor(Request $request){
        $temp= tbltemplate::get();
        $selected = tblDebtor::
        where('DebtorID','=',$request->DebtorID)
            ->get();

        return view('accounting\debtors\Letters',['temp'=>$temp,'selected'=>$selected]);
    }
    public function ShowlettersDebtor(Request $request){
        if($request->LetterType == 2){
            $data=\DB::select('SELECT tblDebtors.DebtorID, tblDebtors.DebtorName, tblContacts.ContactID, tblDebtors.ClientAcntNumber,
tblContacts.ClientName, tblContacts.Saltnt, tblContacts.CFirstName, tblContacts.CLastName,
CONCAT(Trim(tblSales.SFirstName),"  ", Trim(tblSales.SLastName)) AS Salesman, tblContacts.Street,
CONCAT(Trim(tblContacts.City) ,", " , tblContacts.State , "  " , Trim(tblContacts.Zip)) AS Address2,
tblContacts.ClientName, tblDebtors.AmountPlaced, tblContacts.MainManager
FROM (((tblCreditors tblCreditor LEFT JOIN tblSales ON tblCreditor.SaleID = tblSales.SalesID)
LEFT JOIN tblContacts ON tblCreditor.CreditorID = tblContacts.CreditorID)
LEFT JOIN tblDebtors ON tblCreditor.CreditorID = tblDebtors.CreditorID)
LEFT JOIN tblTrusts tblTrust ON tblDebtors.DebtorID = tblTrust.DebtorID
GROUP BY tblDebtors.DebtorID, tblDebtors.DebtorName, tblContacts.ContactID,
tblDebtors.ClientAcntNumber, tblContacts.Saltnt, tblContacts.CFirstName,
tblContacts.CLastName, Trim(tblSales.SFirstName) & " " & Trim(tblSales.SLastName),
tblContacts.Street, Trim(tblContacts.City) & ", " & tblContacts.State & "  " & Trim(tblContacts.Zip),
tblContacts.ClientName, tblDebtors.AmountPlaced, tblContacts.MainManager, tblContacts.ClientName
HAVING (((tblDebtors.DebtorID)='.$request->DebtorID.') AND ((tblContacts.ContactID)=(select ContactID from tblcontacts WHERE MainManager=1 AND CreditorID=(SELECT CreditorID FROM tbldebtors WHERE DebtorID='.$request->DebtorID.'))));');
            $result=null;
            if($data !=null){$result=$data[0];}
            $CollectTrustOld=\DB::select('SELECT tblDebtors.CreditorID,  tblTrusts.DebtorID,  Sum(COALESCE(tblTrusts.PaymentReceived,0)- COALESCE(MiscFees,0)+ COALESCE(CostRef,0)- COALESCE(AttyFees,0)- COALESCE(AgencyGross,0)) AS Pmnt FROM tblDebtors LEFT JOIN tblTrusts ON tblDebtors.DebtorID=tblTrusts.DebtorID WHERE (((tblTrusts.TPaymentType)="T") and tbltrusts.DateRcvd <= \'5/29/2000\' AND tbldebtors.CreditorID =\''.$request->creditorID.'\' ) GROUP BY tblDebtors.CreditorID, tblTrusts.DebtorID;');
            $PaidInv=\DB::select('SELECT DISTINCTROW tblDebtors.CreditorID, tblTrust.DebtorID, Sum(tblTrust.PaymentReceived) AS SumOfAmountPaid
                    FROM tblDebtors LEFT JOIN tbltrusts tblTrust ON tblDebtors.DebtorID = tblTrust.DebtorID
                    WHERE (((tblTrust.TPaymentType)="C") AND tblTrust.DebtorID ='.$request->DebtorID.')
                    GROUP BY tblDebtors.CreditorID, tblTrust.DebtorID;
                    ');
            $PaidTrustNew=\DB::select('SELECT DISTINCTROW tblDebtors.CreditorID, tblTrust.DebtorID, Sum(tblTrust.CostRef) AS CostRef, Sum(tblTrust.PaymentReceived+COALESCE(AttyFees,0)) AS SumOfNetClient
FROM tblDebtors LEFT JOIN tbltrusts tblTrust ON tblDebtors.DebtorID = tblTrust.DebtorID
WHERE (((tblTrust.TPaymentType)="T") AND ((tblTrust.DateRcvd)>\'5/29/2000\') AND tblTrust.DebtorID = 5)
GROUP BY tblDebtors.CreditorID, tblTrust.DebtorID;
');
            $val=0;
            if($PaidInv!=null){


                $val=$val+$PaidInv[0]->SumOfAmountPaid;
            }
            if($PaidTrustNew !=null){
                $val=$val+$PaidTrustNew[0]->SumOfNetClient;
            }
            if($CollectTrustOld !=null){
                $val=$val+$CollectTrustOld[0]->Pmnt;
            }
            $views='accounting\debtors\C1';
            $data=['result'=>$result,'val'=>$val];

            if($request->view == 'Export') {
                if($request->Export == 'PDF'){

                    $html=view($views,$data)->render();
                    $pdf= new Dompdf();
                    $pdf->loadHtml($html);

                    $pdf->render();
                    $pdf->stream('C1.pdf');
                }else{
                $phpWord = new \PhpOffice\PhpWord\PhpWord();
                $section = $phpWord->addSection();
                $section->addTextBreak();
                $section->addTextBreak();
                $section->addTextBreak();
                $section->addText($result->ClientName);
                $section->addText('Attn: ' . $result->CFirstName . ' ' . $result->CLastName);
                $section->addText($result->Street);
                $section->addText($result->Address2);
                $section->addText('Re : ' . $result->DebtorName, array(), array("align" => "right"));
                $section->addText($result->ClientAcntNumber, array(), array("align" => "right"));
                $section->addText($result->AmountPlaced - $val, array(), array("align" => "right"));
                $section->addText('Dear ' . $result->Saltnt . '  ' . $result->CLastName . ':');
                $section->addText('This is sent to acknowledge the above captioned collection item which we have placed in the hands of our collection department.
Contact will be initiated immediately.  Many times the debtor may now contact you to arrange payment.  Should this occur, we ask that they be referred to this office to maintain a continuity of effort.  Please advance your file approximately 7 to 10 days for our initial report.
Thank you for this item of collection business.');
                $section->addText('Your Truly,', array(), array("align" => "right"));
                $section->addText($result->Salesman, array(), array("align" => "right"));
                $section->addText('Account Exective', array(), array("align" => "right"));

                $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
                $objWriter->save(storage_path('C1.docx'));

                return response()->download(storage_path('C1.docx'));}
                //return view('accounting\debtors\C1',['result'=>$result,'val'=>$val]);
            }
        }

        if($request->LetterType == 5 || $request->LetterType == 6 || $request->LetterType == 7 || $request->LetterType == 8 || $request->LetterType == 9 || $request->LetterType == 3 || $request->LetterType == 4){
            $result=\DB::select('SELECT tblDebtors.DebtorID, tblDebtors.DebtorName,
Format(tblDebtors.FormDate,"mmm dd"", ""yyyy") AS FormDate,
CONCAT(Trim(tblCollectors.CFirstName) , " " , Trim(tblCollectors.CLastName)) AS Collector,
CONCAT("Attn: " , tblDebtors.Salutation , " " , tblDebtors.DFirstName , " " , Trim(tblDebtors.DLastName)) AS DAttn,
tblDebtors.Street, CONCAT(Trim(tblDebtors.City) , ", " , tblDebtors.State , "  " , Trim(tblDebtors.Zip)) AS Address2,
tblContacts.ClientName, tblDebtors.AmountPlaced, tblContacts.MainManager, tblContacts.Street AS CreditorStreet,
tblContacts.City AS CreditorCity, tblContacts.State AS CreditorState, tblContacts.Zip AS CreditorZip,
tblDebtors.Phone AS DebtorPhone, tblDebtors.ClientAcntNumber, qryGetContactID.CFullName
FROM (((tblCreditors tblCreditor
INNER JOIN (select tblContacts.ContactID,CONCAT(CFirstName , " ", CLastName) AS CFullName, tblContacts.CreditorID from tblcontacts WHERE MainManager=1 AND CreditorID=(SELECT CreditorID FROM tbldebtors WHERE DebtorID='.$request->DebtorID.'))qryGetContactID ON tblCreditor.CreditorID = qryGetContactID.CreditorID)
LEFT JOIN tblContacts ON tblCreditor.CreditorID = tblContacts.CreditorID)
LEFT JOIN (tblCollectors
RIGHT JOIN tblDebtors ON tblCollectors.ColID = tblDebtors.ColID) ON tblCreditor.CreditorID = tblDebtors.CreditorID)
LEFT JOIN tbltrusts tblTrust ON tblDebtors.DebtorID = tblTrust.DebtorID
GROUP BY tblDebtors.DebtorID, tblDebtors.DebtorName, Format(tblDebtors.FormDate,"mmm dd"", ""yyyy"),
Trim(tblCollectors.CFirstName) & " " & Trim(tblCollectors.CLastName),
"Attn: " & tblDebtors.Salutation & " " & tblDebtors.DFirstName & " " & Trim(tblDebtors.DLastName),
tblDebtors.Street, Trim(tblDebtors.City) & ", " & tblDebtors.State & "  " & Trim(tblDebtors.Zip),
tblContacts.ClientName, tblDebtors.AmountPlaced, tblContacts.MainManager, tblContacts.Street,
tblContacts.City, tblContacts.State, tblContacts.Zip, tblDebtors.Phone, tblDebtors.ClientAcntNumber,
qryGetContactID.CFullName
HAVING (((tblDebtors.DebtorID)='.$request->DebtorID.') AND ((tblContacts.MainManager)=True));
');
            if($request->LetterType == 5){
                $views='accounting\debtors\D1';
                $data=['result'=>$result[0]];

                if($request->view == 'Export') {
                    if($request->Export == 'PDF'){

                        $html=view($views,$data)->render();
                        $pdf= new Dompdf();
                        $pdf->loadHtml($html);

                        $pdf->render();
                        $pdf->stream('D1.pdf');
                    }else{
                    $result = $result[0];
                    $phpWord = new \PhpOffice\PhpWord\PhpWord();
                    $section = $phpWord->addSection();
                    $section->addTextBreak();
                    $section->addTextBreak();
                    $section->addTextBreak();
                    $section->addText($result->DebtorName);
                    $section->addText($result->DAttn);
                    $section->addText($result->Street);
                    $section->addText($result->Address2);
                    $section->addText('Re : ' . $result->ClientName, array(), array("align" => "right"));
                    $section->addText($result->AmountPlaced, array(), array("align" => "right"));
                    $section->addText('To Whom It May Concern: ');
                    $section->addText('The above captioned creditor has turned this matter over to this office with instructions to us to take whatever action we deem necessary to resolve your past due collection account.
Accordingly, if this matter is to be settled amicable we must have your payment or response by return mail.
Make your check payable to: ' . $result->ClientName . ', however mail it to this office using the enclosed envelope.');
                    $section->addText('Your Truly,', array(), array("align" => "right"));
                    $section->addText($result->Collector, array(), array("align" => "right"));
                    $section->addText('Collection Dept', array(), array("align" => "right"));

                    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
                    $objWriter->save(storage_path('D1.docx'));

                    return response()->download(storage_path('D1.docx'));
                }
                    //return view('accounting\debtors\C1',['result'=>$result,'val'=>$val]);
                }
                //return view('accounting\debtors\D1',['result'=>$result[0]]);
            }
            if($request->LetterType == 6){
                //return view('accounting\debtors\D2',['result'=>$result[0]]);
                $views='accounting\debtors\D2';
                $data=['result'=>$result[0]];
                if($request->view == 'Export') {
                    if($request->Export == 'PDF'){

                        $html=view($views,$data)->render();
                        $pdf= new Dompdf();
                        $pdf->loadHtml($html);

                        $pdf->render();
                        $pdf->stream('D2.pdf');
                    }else{
                    $result = $result[0];
                    $phpWord = new \PhpOffice\PhpWord\PhpWord();
                    $section = $phpWord->addSection();
                    $section->addTextBreak();
                    $section->addTextBreak();
                    $section->addTextBreak();
                    $section->addText($result->DebtorName);
                    $section->addText($result->DAttn);
                    $section->addText($result->Street);
                    $section->addText($result->Address2);
                    $section->addText('Re : ' . $result->ClientName, array(), array("align" => "right"));
                    $section->addText($result->AmountPlaced, array(), array("align" => "right"));
                    $section->addText($result->DAttn);
                    $section->addText('You have failed to respond to our demands for payment on this account.
Don\'t you realize that this is a collection matter and that your creditor has decided to take whatever action is necessary to collect this account?  If further action is to be halted we must have your payment by return mail.  Make you check payble to:' . $result->ClientName . ', but mail it to our office.  A business reply envelope is enclosed.
We will advance our files 7 days from the date of this letter with expectations of hearing from you.');
                    $section->addText('Your Truly,', array(), array("align" => "right"));
                    $section->addText($result->Collector, array(), array("align" => "right"));
                    $section->addText('Collection Dept', array(), array("align" => "right"));

                    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
                    $objWriter->save(storage_path('D2.docx'));

                    return response()->download(storage_path('D2.docx'));
                }
                    //return view('accounting\debtors\C1',['result'=>$result,'val'=>$val]);
                }
            }
            if($request->LetterType == 7){
                $CollectTrustOld=\DB::select('SELECT tblDebtors.CreditorID,  tblTrusts.DebtorID,  Sum(COALESCE(tblTrusts.PaymentReceived,0)- COALESCE(MiscFees,0)+ COALESCE(CostRef,0)- COALESCE(AttyFees,0)- COALESCE(AgencyGross,0)) AS Pmnt FROM tblDebtors LEFT JOIN tblTrusts ON tblDebtors.DebtorID=tblTrusts.DebtorID WHERE (((tblTrusts.TPaymentType)="T") and tbltrusts.DateRcvd <= \'5/29/2000\' AND tbldebtors.CreditorID =\''.$request->creditorID.'\' ) GROUP BY tblDebtors.CreditorID, tblTrusts.DebtorID;');
                $PaidInv=\DB::select('SELECT DISTINCTROW tblDebtors.CreditorID, tblTrust.DebtorID, Sum(tblTrust.PaymentReceived) AS SumOfAmountPaid
                    FROM tblDebtors LEFT JOIN tbltrusts tblTrust ON tblDebtors.DebtorID = tblTrust.DebtorID
                    WHERE (((tblTrust.TPaymentType)="C") AND tblTrust.DebtorID ='.$request->DebtorID.')
                    GROUP BY tblDebtors.CreditorID, tblTrust.DebtorID;
                    ');
                $PaidTrustNew=\DB::select('SELECT DISTINCTROW tblDebtors.CreditorID, tblTrust.DebtorID, Sum(tblTrust.CostRef) AS CostRef, Sum(tblTrust.PaymentReceived+COALESCE(AttyFees,0)) AS SumOfNetClient
FROM tblDebtors LEFT JOIN tbltrusts tblTrust ON tblDebtors.DebtorID = tblTrust.DebtorID
WHERE (((tblTrust.TPaymentType)="T") AND ((tblTrust.DateRcvd)>\'5/29/2000\') AND tblTrust.DebtorID = '.$request->DebtorID.')
GROUP BY tblDebtors.CreditorID, tblTrust.DebtorID;
');
                $val=0;
                if($PaidInv!=null){


                    $val=$val+$PaidInv[0]->SumOfAmountPaid;
                }
                if($PaidTrustNew !=null){
                    $val=$val+$PaidTrustNew[0]->SumOfNetClient;
                }
                if($CollectTrustOld !=null){
                    $val=$val+$CollectTrustOld[0]->Pmnt;
                }
                //return view('accounting\debtors\D8',['result'=>$result[0],'val'=>$val]);
                $views='accounting\debtors\D8';
                $data=['result'=>$result[0],'val'=>$val];
                if($request->view == 'Export') {
                    if($request->Export == 'PDF'){

                        $html=view($views,$data)->render();
                        $pdf= new Dompdf();
                        $pdf->loadHtml($html);

                        $pdf->render();
                        $pdf->stream('D8.pdf');
                    }else{
                    $result = $result[0];
                    $phpWord = new \PhpOffice\PhpWord\PhpWord();
                    $section = $phpWord->addSection();
                    $section->addTextBreak();
                    $section->addTextBreak();
                    $section->addTextBreak();
                    $section->addText($result->DebtorName);
                    $section->addText($result->DAttn);
                    $section->addText($result->Street);
                    $section->addText($result->Address2);
                    $section->addText('Re : ' . $result->ClientName, array(), array("align" => "right"));
                    $section->addText($result->AmountPlaced - $val, array(), array("align" => "right"));
                    $section->addText($result->DAttn);
                    $section->addText('Although we have attempted to speak with you about your past due collection account, you have been unavailable and you have not shown us the courtesy of returning our calls.
You can rest assured that we will not waste our time trying to convince you to resolve this matter.  ' . $result->ClientName . ' has instructed us to turn this account over to their attorneys if we can not resolve it amicably.
Accordingly, if we do not hear from you within 7 days from the date of this letter, we will send this matter to the attorneys for their advice and suit requirments.  A business reply envelope is enclosed.');
                    $section->addText('Your Truly,', array(), array("align" => "right"));
                    $section->addText($result->Collector, array(), array("align" => "right"));
                    $section->addText('Collection Dept', array(), array("align" => "right"));

                    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
                    $objWriter->save(storage_path('D8.docx'));

                    return response()->download(storage_path('D8.docx'));
                }
                    //return view('accounting\debtors\C1',['result'=>$result,'val'=>$val]);
                }
            }
            if($request->LetterType == 8){
                $CollectTrustOld=\DB::select('SELECT tblDebtors.CreditorID,  tblTrusts.DebtorID,  Sum(COALESCE(tblTrusts.PaymentReceived,0)- COALESCE(MiscFees,0)+ COALESCE(CostRef,0)- COALESCE(AttyFees,0)- COALESCE(AgencyGross,0)) AS Pmnt FROM tblDebtors LEFT JOIN tblTrusts ON tblDebtors.DebtorID=tblTrusts.DebtorID WHERE (((tblTrusts.TPaymentType)="T") and tbltrusts.DateRcvd <= \'5/29/2000\' AND tbldebtors.CreditorID =\''.$request->creditorID.'\' ) GROUP BY tblDebtors.CreditorID, tblTrusts.DebtorID;');
                $PaidInv=\DB::select('SELECT DISTINCTROW tblDebtors.CreditorID, tblTrust.DebtorID, Sum(tblTrust.PaymentReceived) AS SumOfAmountPaid
                    FROM tblDebtors LEFT JOIN tbltrusts tblTrust ON tblDebtors.DebtorID = tblTrust.DebtorID
                    WHERE (((tblTrust.TPaymentType)="C") AND tblTrust.DebtorID ='.$request->DebtorID.')
                    GROUP BY tblDebtors.CreditorID, tblTrust.DebtorID;
                    ');
                $PaidTrustNew=\DB::select('SELECT DISTINCTROW tblDebtors.CreditorID, tblTrust.DebtorID, Sum(tblTrust.CostRef) AS CostRef, Sum(tblTrust.PaymentReceived+COALESCE(AttyFees,0)) AS SumOfNetClient
FROM tblDebtors LEFT JOIN tbltrusts tblTrust ON tblDebtors.DebtorID = tblTrust.DebtorID
WHERE (((tblTrust.TPaymentType)="T") AND ((tblTrust.DateRcvd)>\'5/29/2000\') AND tblTrust.DebtorID = '.$request->DebtorID.')
GROUP BY tblDebtors.CreditorID, tblTrust.DebtorID;
');
                $val=0;
                if($PaidInv!=null){


                    $val=$val+$PaidInv[0]->SumOfAmountPaid;
                }
                if($PaidTrustNew !=null){
                    $val=$val+$PaidTrustNew[0]->SumOfNetClient;
                }
                if($CollectTrustOld !=null){
                    $val=$val+$CollectTrustOld[0]->Pmnt;
                }
                //return view('accounting\debtors\D15',['result'=>$result[0],'val'=>$val]);
                $views='accounting\debtors\D15';
                $data=['result'=>$result[0],'val'=>$val];
                if($request->view == 'Export') {
                    if($request->Export == 'PDF'){

                        $html=view($views,$data)->render();
                        $pdf= new Dompdf();
                        $pdf->loadHtml($html);

                        $pdf->render();
                        $pdf->stream('D15.pdf');
                    }else{
                    $result = $result[0];
                    $phpWord = new \PhpOffice\PhpWord\PhpWord();
                    $section = $phpWord->addSection();
                    $section->addTextBreak();
                    $section->addTextBreak();
                    $section->addTextBreak();
                    $section->addText($result->DebtorName);
                    $section->addText($result->DAttn);
                    $section->addText($result->Street);
                    $section->addText($result->Address2);
                    $section->addText('Re : ' . $result->ClientName, array(), array("align" => "right"));
                    $section->addText($result->AmountPlaced - $val, array(), array("align" => "right"));
                    $section->addText($result->DAttn);
                    $section->addText('Just a reminder your promised payment is due by return mail.
Make your check payable to: ' . $result->ClientName . ', however mail it to this office using the enclosed business reply envelope.');
                    $section->addText('Your Truly,', array(), array("align" => "right"));
                    $section->addText($result->Collector, array(), array("align" => "right"));
                    $section->addText('Collection Dept', array(), array("align" => "right"));

                    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
                    $objWriter->save(storage_path('D15.docx'));

                    return response()->download(storage_path('D15.docx'));
                }
                    //return view('accounting\debtors\C1',['result'=>$result,'val'=>$val]);
                }
            }
            if($request->LetterType == 9){
                $CollectTrustOld=\DB::select('SELECT tblDebtors.CreditorID,  tblTrusts.DebtorID,  Sum(COALESCE(tblTrusts.PaymentReceived,0)- COALESCE(MiscFees,0)+ COALESCE(CostRef,0)- COALESCE(AttyFees,0)- COALESCE(AgencyGross,0)) AS Pmnt FROM tblDebtors LEFT JOIN tblTrusts ON tblDebtors.DebtorID=tblTrusts.DebtorID WHERE (((tblTrusts.TPaymentType)="T") and tbltrusts.DateRcvd <= \'5/29/2000\' AND tbldebtors.CreditorID =\''.$request->creditorID.'\' ) GROUP BY tblDebtors.CreditorID, tblTrusts.DebtorID;');
                $PaidInv=\DB::select('SELECT DISTINCTROW tblDebtors.CreditorID, tblTrust.DebtorID, Sum(tblTrust.PaymentReceived) AS SumOfAmountPaid
                    FROM tblDebtors LEFT JOIN tbltrusts tblTrust ON tblDebtors.DebtorID = tblTrust.DebtorID
                    WHERE (((tblTrust.TPaymentType)="C") AND tblTrust.DebtorID ='.$request->DebtorID.')
                    GROUP BY tblDebtors.CreditorID, tblTrust.DebtorID;
                    ');
                $PaidTrustNew=\DB::select('SELECT DISTINCTROW tblDebtors.CreditorID, tblTrust.DebtorID, Sum(tblTrust.CostRef) AS CostRef, Sum(tblTrust.PaymentReceived+COALESCE(AttyFees,0)) AS SumOfNetClient
FROM tblDebtors LEFT JOIN tbltrusts tblTrust ON tblDebtors.DebtorID = tblTrust.DebtorID
WHERE (((tblTrust.TPaymentType)="T") AND ((tblTrust.DateRcvd)>\'5/29/2000\') AND tblTrust.DebtorID = '.$request->DebtorID.')
GROUP BY tblDebtors.CreditorID, tblTrust.DebtorID;
');
                $val=0;
                if($PaidInv!=null){


                    $val=$val+$PaidInv[0]->SumOfAmountPaid;
                }
                if($PaidTrustNew !=null){
                    $val=$val+$PaidTrustNew[0]->SumOfNetClient;
                }
                if($CollectTrustOld !=null){
                    $val=$val+$CollectTrustOld[0]->Pmnt;
                }
                //return view('accounting\debtors\D20',['result'=>$result[0],'val'=>$val]);
                $views='accounting\debtors\D20';
                $data=['result'=>$result[0],'val'=>$val];
                if($request->view == 'Export') {
                    if($request->Export == 'PDF'){

                        $html=view($views,$data)->render();
                        $pdf= new Dompdf();
                        $pdf->loadHtml($html);

                        $pdf->render();
                        $pdf->stream('D20.pdf');
                    }else{
                    $result = $result[0];
                    $phpWord = new \PhpOffice\PhpWord\PhpWord();
                    $section = $phpWord->addSection();
                    $section->addTextBreak();
                    $section->addTextBreak();
                    $section->addTextBreak();
                    $section->addText($result->DebtorName);
                    $section->addText($result->DAttn);
                    $section->addText($result->Street);
                    $section->addText($result->Address2);
                    $section->addText('Re : ' . $result->ClientName, array(), array("align" => "right"));
                    $section->addText($result->AmountPlaced - $val, array(), array("align" => "right"));
                    $section->addText($result->DAttn);
                    $section->addText('It appears that we have reached an impasse at our attempts to resolve this matter amicably.
Accordingly a copy of this letter along with our corresponding attorney\'s suit requirements are being transmitted this date to our client.  Once we have received the necessary authorization, cost and suit requirements, we will immediately forward these to the attorney with instructions to file suit.
This may be your last opportunity to avoid the added expense and possible stigma of a law suit.
Send your payment or explanation today.');
                    $section->addText('Your Truly,', array(), array("align" => "right"));
                    $section->addText($result->Collector, array(), array("align" => "right"));
                    $section->addText('Collection Dept', array(), array("align" => "right"));

                    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
                    $objWriter->save(storage_path('D20.docx'));

                    return response()->download(storage_path('D20.docx'));
                }
                    //return view('accounting\debtors\C1',['result'=>$result,'val'=>$val]);
                }
            }

            if($request->LetterType == 3){
                $CollectTrustOld=\DB::select('SELECT tblDebtors.CreditorID,  tblTrusts.DebtorID,  Sum(COALESCE(tblTrusts.PaymentReceived,0)- COALESCE(MiscFees,0)+ COALESCE(CostRef,0)- COALESCE(AttyFees,0)- COALESCE(AgencyGross,0)) AS Pmnt FROM tblDebtors LEFT JOIN tblTrusts ON tblDebtors.DebtorID=tblTrusts.DebtorID WHERE (((tblTrusts.TPaymentType)="T") and tbltrusts.DateRcvd <= \'5/29/2000\' AND tbldebtors.CreditorID =\''.$request->creditorID.'\' ) GROUP BY tblDebtors.CreditorID, tblTrusts.DebtorID;');
                $PaidInv=\DB::select('SELECT DISTINCTROW tblDebtors.CreditorID, tblTrust.DebtorID, Sum(tblTrust.PaymentReceived) AS SumOfAmountPaid
                    FROM tblDebtors LEFT JOIN tbltrusts tblTrust ON tblDebtors.DebtorID = tblTrust.DebtorID
                    WHERE (((tblTrust.TPaymentType)="C") AND tblTrust.DebtorID ='.$request->DebtorID.')
                    GROUP BY tblDebtors.CreditorID, tblTrust.DebtorID;
                    ');
                $PaidTrustNew=\DB::select('SELECT DISTINCTROW tblDebtors.CreditorID, tblTrust.DebtorID, Sum(tblTrust.CostRef) AS CostRef, Sum(tblTrust.PaymentReceived+COALESCE(AttyFees,0)) AS SumOfNetClient
FROM tblDebtors LEFT JOIN tbltrusts tblTrust ON tblDebtors.DebtorID = tblTrust.DebtorID
WHERE (((tblTrust.TPaymentType)="T") AND ((tblTrust.DateRcvd)>\'5/29/2000\') AND tblTrust.DebtorID = '.$request->DebtorID.')
GROUP BY tblDebtors.CreditorID, tblTrust.DebtorID;
');
                $val=0;
                if($PaidInv!=null){


                    $val=$val+$PaidInv[0]->SumOfAmountPaid;
                }
                if($PaidTrustNew !=null){
                    $val=$val+$PaidTrustNew[0]->SumOfNetClient;
                }
                if($CollectTrustOld !=null){
                    $val=$val+$CollectTrustOld[0]->Pmnt;
                }
                //dd($result[0]);
                //return view('accounting\debtors\ClientFD',['result'=>$result[0],'val'=>$val]);
                $views='accounting\debtors\ClientFD';
                $data=['result'=>$result[0],'val'=>$val];
                if($request->view == 'Export') {
                    if($request->Export == 'PDF'){

                        $html=view($views,$data)->render();
                        $pdf= new Dompdf();
                        $pdf->loadHtml($html);

                        $pdf->render();
                        $pdf->stream('ClientFD.pdf');
                    }else{
                    $result = $result[0];
                    $phpWord = new \PhpOffice\PhpWord\PhpWord();
                    $section = $phpWord->addSection();
                    $section->addTextBreak();
                    $section->addTextBreak();
                    $section->addTextBreak();
                    $section->addText($result->DebtorName);
                    $section->addText($result->DAttn);
                    $section->addText($result->Street);
                    $section->addText($result->Address2);
                    $section->addText($result->DebtorPhone);
                    $a = floatval($result->AmountPlaced) - floatval($val);
                    $section->addText('Amount Due:' . $a, array(), array("align" => "right"));
                    $section->addText('ACCT #:' . $result->ClientAcntNumber, array(), array("align" => "right"));
                    $section->addText($result->DAttn);
                    $section->addText('Your account is now inexcusably PAST DUE. Creditors Recovery Systems, Inc. will be employed to take further action unless your payment is received before: ' . date("d-m-Y", strtotime($result->FormDate)) . '
Your prompt attention to this notice will avoid further proceedings.');


                    $section->addText('Creditor : ' . $result->ClientName, array(), array("align" => "right"));
                    $section->addText('Address : ' . $result->CreditorStreet, array(), array("align" => "right"));
                    $section->addText($result->CreditorCity . ',' . $result->CreditorState . ',' . $result->CreditorZip, array(), array("align" => "right"));
                    $section->addText('BY: ' . $result->CFullName, array(), array("align" => "right"));
                    $section->addText('Credit Manager', array(), array("align" => "right"));
                    $section->addTextBreak();
                    $section->addText('CC:  CREDITORS RECOVERY SYSTEMS, INC.');
                    $section->addText('In the event it becomes necessary to forward the claim to attorneys, we direct and aurhorize you as our agent to send the account to a Commercial Law League attorney designated by us.  Where none is given you are to forward the account to an attorney whose firm appears in a law list publication approved by the American Bar Association upon prevailing rates.  Special Aurhorization is required to file suit, comprise or grant an extension.  You or our attorney are aurhorized to accept any type of payment for deposit, the net proceeds of which you are to remit to us.');

                    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
                    $objWriter->save(storage_path('ClientFD.docx'));

                    return response()->download(storage_path('ClientFD.docx'));
                }
                    //return view('accounting\debtors\C1',['result'=>$result,'val'=>$val]);
                }
            }
            if($request->LetterType == 4){
                $CollectTrustOld=\DB::select('SELECT tblDebtors.CreditorID,  tblTrusts.DebtorID,  Sum(COALESCE(tblTrusts.PaymentReceived,0)- COALESCE(MiscFees,0)+ COALESCE(CostRef,0)- COALESCE(AttyFees,0)- COALESCE(AgencyGross,0)) AS Pmnt FROM tblDebtors LEFT JOIN tblTrusts ON tblDebtors.DebtorID=tblTrusts.DebtorID WHERE (((tblTrusts.TPaymentType)="T") and tbltrusts.DateRcvd <= \'5/29/2000\' AND tbldebtors.CreditorID =\''.$request->creditorID.'\' ) GROUP BY tblDebtors.CreditorID, tblTrusts.DebtorID;');
                $PaidInv=\DB::select('SELECT DISTINCTROW tblDebtors.CreditorID, tblTrust.DebtorID, Sum(tblTrust.PaymentReceived) AS SumOfAmountPaid
                    FROM tblDebtors LEFT JOIN tbltrusts tblTrust ON tblDebtors.DebtorID = tblTrust.DebtorID
                    WHERE (((tblTrust.TPaymentType)="C") AND tblTrust.DebtorID ='.$request->DebtorID.')
                    GROUP BY tblDebtors.CreditorID, tblTrust.DebtorID;
                    ');
                $PaidTrustNew=\DB::select('SELECT DISTINCTROW tblDebtors.CreditorID, tblTrust.DebtorID, Sum(tblTrust.CostRef) AS CostRef, Sum(tblTrust.PaymentReceived+COALESCE(AttyFees,0)) AS SumOfNetClient
FROM tblDebtors LEFT JOIN tbltrusts tblTrust ON tblDebtors.DebtorID = tblTrust.DebtorID
WHERE (((tblTrust.TPaymentType)="T") AND ((tblTrust.DateRcvd)>\'5/29/2000\') AND tblTrust.DebtorID = '.$request->DebtorID.')
GROUP BY tblDebtors.CreditorID, tblTrust.DebtorID;
');
                $val=0;
                if($PaidInv!=null){


                    $val=$val+$PaidInv[0]->SumOfAmountPaid;
                }
                if($PaidTrustNew !=null){
                    $val=$val+$PaidTrustNew[0]->SumOfNetClient;
                }
                if($CollectTrustOld !=null){
                    $val=$val+$CollectTrustOld[0]->Pmnt;
                }
                //dd($result[0]);
                $views='accounting\debtors\DebtorFD';
                $data=['result'=>$result[0],'val'=>$val];
                if($request->view == 'Export') {
                    if($request->Export == 'PDF'){

                        $html=view($views,$data)->render();
                        $pdf= new Dompdf();
                        $pdf->loadHtml($html);

                        $pdf->render();
                        $pdf->stream('DebtorFD.pdf');
                    }else{
                    $result = $result[0];
                    $phpWord = new \PhpOffice\PhpWord\PhpWord();
                    $section = $phpWord->addSection();
                    $section->addTextBreak();
                    $section->addTextBreak();
                    $section->addTextBreak();
                    $section->addText($result->DebtorName, array(), array('spacing' => 120, 'lineHeight' => 1));
                    $section->addText($result->DAttn, array(), array('spacing' => 120, 'lineHeight' => 1));
                    $section->addText($result->Street, array(), array('spacing' => 120, 'lineHeight' => 1));
                    $section->addText($result->Address2, array(), array('spacing' => 120, 'lineHeight' => 1));
                    $section->addText($result->DebtorPhone, array(), array('spacing' => 120, 'lineHeight' => 1));
                    $a = floatval($result->AmountPlaced) - floatval($val);
                    $section->addText('Amount Due:' . $a, array(), array("align" => "right"));
                    $section->addText('ACCT #:' . $result->ClientAcntNumber, array(), array("align" => "right"));
                    $section->addText($result->DAttn);
                    $section->addText('Your account is now inexcusably PAST DUE. Creditors Recovery Systems, Inc. will be employed to take further action unless your payment is received before:  ' . date("d-m-Y", strtotime($result->FormDate)) . '
Your prompt attention to this notice will avoid further proceedings.');


                    $section->addText('Creditor : ' . $result->ClientName, array(), array("align" => "right"));
                    $section->addText('Address : ' . $result->CreditorStreet, array(), array("align" => "right"));
                    $section->addText($result->CreditorCity . ',' . $result->CreditorState . ',' . $result->CreditorZip, array(), array("align" => "right"));
                    $section->addText('BY: ' . $result->CFullName, array(), array("align" => "right"));
                    $section->addText('Credit Manager', array(), array("align" => "right"));
                    $section->addTextBreak();
                    $section->addText('CC:  CREDITORS RECOVERY SYSTEMS, INC.');


                    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
                    $objWriter->save(storage_path('DebtorFD.docx'));

                    return response()->download(storage_path('DebtorFD.docx'));
                }
                    //return view('accounting\debtors\C1',['result'=>$result,'val'=>$val]);
                }
            }


        }


// Adding Text element to the Section having font styled by default...
        return view($views,$data);




        //return view('accounting\debtors\ShowlettersDebtor');
    }

    public function saveNote(Request $request){

        $validatedData = $request->validate([
            'NoteDetail' => 'required',
        ]);

        if($request->updateNoteID != null){
            $note = new tblnote();

            $note = tblnote::where('NoteID','=',$request->updateNoteID)
                ->update(array(
                   'Detail'=>$request->NoteDetail,
                    'User'=>Auth::user()->name,
                    'DebtorID'=>$request->DebtorID
                ));

            return response()->json($note);
        }

        $note = new tblnote();
        $note->Detail = $request->NoteDetail;
        $note->User = Auth::user()->name;
        $note->DebtorID = $request->DebtorID;

        $note->save();

        return response()->json($note);
    }
    public function delNote(Request $request){
        tblnote::where('NoteID','=',$request->ID)->delete();

        return redirect('/EditDebtor/'.$request->DebtorID.'?msg=Note Successfully Deleted.');
    }
    public function saveActivityCode(Request $request){

        $validatedData = $request->validate([
            'CodeDetail' => 'required',
        ]);

        if($request->updateCodeID != null){
            $note = new tblactivitycode();

            $note = tblactivitycode::where('CodeID','=',$request->updateCodeID)
                ->update(array(
                    'Detail'=>$request->CodeDetail,
                ));

            return response()->json($note);
        }

        $note = new tblactivitycode();
        $note->Detail = $request->CodeDetail;
        $note->save();

        return response()->json($note);
    }
    public function delActivityCode(Request $request){
        tblactivitycode::where('CodeID','=',$request->ID)->delete();

        return redirect('/EditDebtor/'.$request->DebtorID.'?msg=Note Successfully Deleted.');
    }

    public function UploadFile(Request $request){
        $validatedData = $request->validate([
            'importFile' => 'required',
        ]);
        if($request->file('importFile')){
            $file= $request->file('importFile');
            $filename= Auth::user()->id.'-D-' . time() . '.' . $file->getClientOriginalExtension();
            $path= public_path('storage/csv');
            $newFile = new tblfile();
            $newFile->DebtorID = $request->DebtorID;
            $newFile->FileName = $file->getClientOriginalName();
            $newFile->FileExtension = $file->getClientOriginalExtension();
            $newFile->Comments = $request->Comments;
            $newFile->Filesize = $file->getSize();
            $newFile->url = $path;
            $newFile->downloadName =$filename;
            $newFile->User =  Auth::user()->name;
            $newFile->save();
            $file->move($path, $filename);
        }
       //
        return redirect('/EditDebtor/'.$request->DebtorID);
    }
    public function DonwloadFile(Request $request){

        $sfile=tblfile::where('FileID','=',$request->FileID)->first();
        $file=$sfile->url.'/'.$sfile->downloadName;
        return \Response::download($file);
    }

    public function saveWord(Request $request){

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        $section ->addText('inam');
        $section ->addText('Attn:aaaa');
        $objWriter =  \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save(storage_path('helloWorld.docx'));

        return response()->download(storage_path('helloWorld.docx'));
    }

    public function trustAccount(Request $request){
        $debtor = null;
        $selected = null;
        if($request->Export != null){
            //$creditor = tblcreditor::get();
            $creditor= \DB::select('select * from tblTrusts where TPaymentType=\'T\'');
            return  $this->Export($creditor,'TrustActivity');
        }
        if($request->DebtorID == null) {
            //$debtor = tblTrust::get();
        }
        else{
            $debtor = tblTrust::
            where('DebtorID','=',$request->DebtorID)->where('TPaymentType','=','T')
                ->get();
            $selected = tblDebtor::
            where('DebtorID','=',$request->DebtorID)
                ->get();
        }
        return view('accounting\trust\trust', ['debtor' => $debtor,'selected'=>$selected]);
    }
    public function addTrustActivity(Request $request){
        $result = rolerightsfield::where('RoleID','=',Auth::user()->is_permission)
            ->where('ScreenName','=','TrustActivity')
            ->where('FieldName','=','NewTrustActivity')
            ->first();
        if($result == null){
            return redirect('/Debtor?msg=Access denied.');
        }else{
            if(!$result->Active){
                return redirect('/Debtor?msg=Access denied.');
            }
        }
        $col = tblcollector::get();
        $debtors  = tblDebtor::
        where('DebtorID','=',$request->DebtorID)
            ->get();
        return view('accounting\trust\addTrustActivity', ['debtors' => $debtors,'col' => $col]);
    }
    public function saveTrustActivity(Request $request){

        $validatedData = $request->validate([
            'DebtorID' => 'required',
            'colID' => 'required',
            'paymentReceived'=>'required|min:1'
        ]);
        $creditor = new tblTrust();
        $creditor->DebtorID = $request->DebtorID;
        $creditor->DateRcvd = $request->dateReceived;
        $creditor->PaymentReceived = $request->paymentReceived;
        $creditor->PaymentType = 0;
        $creditor->	Intrest = $request->Intrest;
        $creditor->AttyFees = $request->AttorneyFee;
        $creditor->MiscFees = $request->MiscFee;
        $creditor->	CostRef = $request->CostRef;
        $creditor->AgencyGross = $request->AgencyGross;
        $creditor->CheckNumb = $request->checkNo;
        $creditor->RelDate = date('Y-m-d', strtotime($request->releaseDate));
        $creditor->ColID = $request->colID;
        $creditor->UserUpdated =Auth::user()->name;
        $creditor->TPaymentID =tblTrust::max('TPaymentID')+1;
        $creditor->TPaymentType='T';
        $creditor->BilledFor=0;
        $creditor->PaymentType=0;
        //->max('id')
        $creditor->save();

        return redirect('/AddTrustActivity/'.$request->DebtorID.'?msg=Trust Activity Successfully Saved.');
    }
    public function editTrust(Request $request)
    {
        $result = rolerightsfield::where('RoleID','=',Auth::user()->is_permission)
            ->where('ScreenName','=','TrustActivity')
            ->where('FieldName','=','EditTrustActivity')
            ->first();
        if($result == null){
            return redirect('/Debtor?msg=Access denied.');
        }else{
            if(!$result->Active){
                return redirect('/Debtor?msg=Access denied.');
            }
        }
        if ($request->updateTPaymentID != null) {
            $validatedData = $request->validate([
                'updateTPaymentID' => 'required|max:191',
                'colID' => 'required|max:191',
            ]);

            $newCreditor = new tblTrust();
           /* array(
                'DebtorID' => $request->DebtorID,
                'DateRcvd' => $request->dateReceived,
                'PaymentReceived' => $request->paymentReceived,
                'PaymentType' => $request->dateEntered,
                'Intrest' => $request->Intrest,
                'AttyFees' => $request->AttorneyFee,
                'MiscFees' => $request->MiscFee,
                'CostRef' => $request->CostRef,
                'AgencyGross' => $request->AgencyGross,
                'CheckNumb' => $request->checkNo,
                'RelDate' => $request->releaseDate,
                'ColID' => $request->colID,
                'UserUpdated' => Auth::user()->name,
                'TPaymentType'=>'T',
                'BilledFor'=>0,
                'PaymentType'=>0,
            )*/
            $updateArray= array();
            $updateArray=$this->checkRights($updateArray,'TrustActivity','DebtorID',$request->DebtorID);
            $updateArray=$this->checkRights($updateArray,'TrustActivity','DateRcvd',$request->dateReceived);
            $updateArray=$this->checkRights($updateArray,'TrustActivity','PaymentReceived',$request->paymentReceived);
            $updateArray=$this->checkRights($updateArray,'TrustActivity','PaymentType',$request->dateEntered);
            $updateArray=$this->checkRights($updateArray,'TrustActivity','Intrest',$request->Intrest);
            $updateArray=$this->checkRights($updateArray,'TrustActivity','AttyFees',$request->AttorneyFee);

            $updateArray=$this->checkRights($updateArray,'TrustActivity','MiscFees',$request->MiscFee);
            $updateArray=$this->checkRights($updateArray,'TrustActivity','CostRef',$request->CostRef);
            $updateArray=$this->checkRights($updateArray,'TrustActivity','AgencyGross',$request->AgencyGross);
            $updateArray=$this->checkRights($updateArray,'TrustActivity','CheckNumb',$request->checkNo);
            $updateArray=$this->checkRights($updateArray,'TrustActivity','RelDate',date('Y-m-d', strtotime($request->releaseDate)));
            $updateArray=$this->checkRights($updateArray,'TrustActivity','ColID',$request->colID);

            $updateArray=$this->checkRights($updateArray,'TrustActivity','TPaymentType','T');
            $updateArray=$this->checkRights($updateArray,'TrustActivity','BilledFor',0);
            $updateArray=$this->checkRights($updateArray,'TrustActivity','PaymentType',0);
          //  $updateArray = array_add($updateArray, 'LastUpdate', date('Y-m-d H:i:s'));
            $updateArray = array_add($updateArray, 'UserUpdated',  Auth::user()->name);
            //  dd($updateArray);
            $newCreditor->where('TPaymentID', '=', $request->updateTPaymentID)
                ->update($updateArray);
            return redirect('/TrustAccount/'.$request->DebtorID.'?msg=Activity Successfully Updated.');
        }

        $col = tblcollector::get();
        $trustActivity = tblTrust::where('TPaymentID','=',$request->TPaymentID)->first();
        $debtors = tblDebtor::
        where('DebtorID', '=', $trustActivity->DebtorID)
            ->get();
//        echo $trustActivity->DateRcvd;
        return view('accounting\trust\editTrustActivity', ['debtors' => $debtors, 'col' => $col,'trustActivity'=>$trustActivity]);
    }
    public function delTrust(Request $request){
        $result = rolerightsfield::where('RoleID','=',Auth::user()->is_permission)
            ->where('ScreenName','=','TrustActivity')
            ->where('FieldName','=','DeleteTrustActivity')
            ->first();
        if($result == null){
            return redirect('/Debtor?msg=Access denied.');
        }else{
            if(!$result->Active){
                return redirect('/Debtor?msg=Access denied.');
            }
        }
        tblTrust::where('TPaymentID','=',$request->TPaymentID)->delete();
        return redirect('/TrustAccount/'.$request->DebtorID.'?msg=Activity Successfully Deleted.');
    }

    public function invoices(Request $request){
        $debtor = null;
        $selected = null;
        if($request->Export != null){
            //$creditor = tblcreditor::get();
            $creditor= \DB::select('select * from tblTrusts where TPaymentType=\'C\'');
            return  $this->Export($creditor,'invoices');
        }
        if($request->DebtorID == null) {
            //$debtor = tblTrust::get();
        }
        else{
            $debtor = tblTrust::
            where('DebtorID','=',$request->DebtorID)
                ->where('TPaymentType','=','C')
                ->get();
            $selected = tblDebtor::
            where('DebtorID','=',$request->DebtorID)
                ->get();
        }
        return view('accounting\invoice\invoice', ['debtor' => $debtor,'selected'=>$selected]);
    }
    public function unpaidInvoices(Request $request){
        $data=DB::select('SELECT tblInvoice.InvoiceNumb, tblInvoice.InvoiceNumb, tblInvoice.IPaymentID,
tblInvoice.IPaymentType, tblInvoice.InvDate,
tblInvoice.DebtorID, tblInvoice.PaidDate,
tblInvoice.CAmountPaid,
tblInvoice.TotalBillFor, tblInvoice.AttyFees,
tblInvoice.Fee1Type, tblInvoice.Fee1Balance, tblInvoice.Fee1,
tblInvoice.Fee2Type, tblInvoice.Fee2Balance, tblInvoice.Fee2, tblInvoice.Fee3Type,
tblInvoice.Fee3Balance, tblInvoice.Fee3, tblInvoice.InvText, tblInvoice.InvLbl,
COALESCE(Fee1Balance,0)+
COALESCE(Fee2Balance,0)+
COALESCE(Fee3Balance,0) AS Collected,
COALESCE((case Fee1Type when \'%\'  then (Fee1Balance/100)*Fee1 ELSE Fee1 end) -
COALESCE(AttyFees,0),0) AS DueInv
FROM tblinvoices tblInvoice
WHERE (((tblInvoice.PaidDate) Is Null))
ORDER BY tblInvoice.InvoiceNumb DESC;');
      //  dd($data);
        $sumOfCollected=0;
        $sumOfDueInv=0;
        foreach($data as $c)
        {
            $sumOfDueInv+=floatval($c->DueInv);
            $sumOfCollected+=floatval($c->Collected);
        }
        return view('accounting\invoice\AllUnpaidInvoice', ['data' => $data,'sumOfDueInv'=>$sumOfDueInv,'sumOfCollected'=>$sumOfCollected]);
    }
    public function DeleteInvoice(Request $request){
        $result = rolerightsfield::where('RoleID','=',Auth::user()->is_permission)
            ->where('ScreenName','=','Invoice')
            ->where('FieldName','=','DeleteInvoice')
            ->first();
        if($result == null){
            return redirect('/Debtor?msg=Access denied.');
        }else{
            if(!$result->Active){
                return redirect('/Debtor?msg=Access denied.');
            }
        }

        tblTrust::where('ID','=',$request->ID)->delete();
        tblinvoice::where('IPaymentID','=',$request->IPaymentID)->delete();
        return redirect('/Invoices/'.$request->DebtorID.'?msg=Invoice Deleted Succefully.');
    }


    public function paidInvoice(Request $request){
        $newinvoice = new tblinvoice();

        $newinvoice->where('InvoiceNumb', '=', $request->InvoiceNumb)
            ->update(array(
                'PaidDate'=>0,
                'CAmountPaid'=>0,

            ));
//tblInvoice.LastUpdate = Date(), tblInvoice.UserUpdated = CurrentUser()
        $data=DB::select('SELECT tblInvoice.InvoiceNumb, tblInvoice.InvoiceNumb, tblInvoice.IPaymentID,
tblInvoice.IPaymentType, tblInvoice.InvDate,
tblInvoice.DebtorID, tblInvoice.PaidDate,
tblInvoice.CAmountPaid,
tblInvoice.TotalBillFor, tblInvoice.AttyFees,
tblInvoice.Fee1Type, tblInvoice.Fee1Balance, tblInvoice.Fee1,
tblInvoice.Fee2Type, tblInvoice.Fee2Balance, tblInvoice.Fee2, tblInvoice.Fee3Type,
tblInvoice.Fee3Balance, tblInvoice.Fee3, tblInvoice.InvText, tblInvoice.InvLbl,
COALESCE(Fee1Balance,0)+
COALESCE(Fee2Balance,0)+
COALESCE(Fee3Balance,0) AS Collected,
COALESCE((case Fee1Type when \'%\'  then (Fee1Balance/100)*Fee1 ELSE Fee1 end) +
(case Fee2Type when Null  then 0 when \'%\' THEN (Fee2Balance/100)*Fee2 ELSE Fee2 end) +
(case Fee3Type when Null  then 0 when \'%\' THEN (Fee3Balance/100)*Fee3 ELSE Fee3 end) -
COALESCE(AttyFees,0),0) AS DueInv
FROM tblinvoices tblInvoice
WHERE (((tblInvoice.PaidDate) Is Null))
ORDER BY tblInvoice.InvoiceNumb DESC;');
        //  dd($data);
        $sumOfCollected=0;
        $sumOfDueInv=0;
        foreach($data as $c)
        {
            $sumOfDueInv+=floatval($c->DueInv);
            $sumOfCollected+=floatval($c->Collected);
        }
        return view('accounting\invoice\AllUnpaidInvoice', ['data' => $data,'sumOfDueInv'=>$sumOfDueInv,'sumOfCollected'=>$sumOfCollected]);
    }
    public function addCredit(Request $request){
        $result = rolerightsfield::where('RoleID','=',Auth::user()->is_permission)
            ->where('ScreenName','=','Invoice')
            ->where('FieldName','=','NewCredit')
            ->first();
        if($result == null){
            return redirect('/Debtor?msg=Access denied.');
        }else{
            if(!$result->Active){
               return redirect('/Debtor?msg=Access denied.');
            }
        }
        $col = tblcollector::get();
        $debtors  = tblpmnttype::get();
        $selected = tblDebtor::
        where('DebtorID','=',$request->DebtorID)
            ->get();
        return view('accounting\invoice\addCredit', ['debtors' => $debtors,'col' => $col,'selected'=>$selected]);
    }

    public function saveCredit(Request $request){

        $validatedData = $request->validate([
            'amountPaid' => 'required',
        ]);

        $creditor = new tblTrust();
        $creditor->DebtorID = $request->DebtorID;
        $creditor->DateRcvd = $request->dateReceived;
        $creditor->PaymentReceived = $request->amountPaid;
        $creditor->PaymentType = $request->TOPID;
        $creditor->Intrest = 0;
        $creditor->AttyFees = 0;
        $creditor->MiscFees =0;
        $creditor->CostRef = 0;
        $creditor->AgencyGross = 0;
        $creditor->CheckNumb = '';
        $creditor->RelDate = date('Y-m-d H:i:s');
        $creditor->ColID = $request->colID;
        $creditor->TPaymentID =tblTrust::max('TPaymentID')+1;
        $creditor->TPaymentType='C';
        if($request->BilledFor == 'on'){
            $creditor->BilledFor=1;
        }else{
            $creditor->BilledFor=0;
        }
        $creditor->UserUpdated =Auth::user()->name;
        //->max('id')


        $creditor->save();

        return redirect('/Invoices/'.$request->DebtorID.'?msg=Trust Activity Successfully Saved.');
    }

    public function addInvoice(Request $request){

        $result = rolerightsfield::where('RoleID','=',Auth::user()->is_permission)
            ->where('ScreenName','=','Invoice')
            ->where('FieldName','=','NewInvoice')
            ->first();
        if($result == null){
            return redirect('/Debtor?msg=Access denied.');
        }else{
            if(!$result->Active){
                return redirect('/Debtor?msg=Access denied.');
            }
        }
        $col = tblcollector::get();
        $debtors  = tblpmnttype::get();
        $trustActivity = tblTrust::where('TPaymentID','=',$request->TPaymentID)->first();
        return view('accounting\invoice\addInvoice', ['debtors' => $debtors,'col' => $col,'trustActivity'=>$trustActivity]);
    }
    public function saveInvoice(Request $request){

        $validatedData = $request->validate([
            'DebtorID' => 'required',
            'TotalBill' => 'required',
        ]);
        $results= \DB::select('SELECT  CONCAT(DATE_FORMAT(CURDATE(), \'%y\'),\'-\', LPAD(COUNT(*)+1,4,0)) inv FROM `tblinvoices`  WHERE YEAR(InvDate)="'. date("Y") .'"');
        $invNo =$results[0]->inv;
        $creditor = new tblinvoice();
        $creditor->DebtorID = $request->DebtorID;
        $creditor->InvoiceNumb = $invNo;
       // $creditor->InvoiceNumb =str_pad( $creditor->InvoiceNumb , 5, '0', STR_PAD_LEFT);
        $creditor->IPaymentID = $request->TPaymentID;
        $creditor->IPaymentType = $request->IPaymentType;
        $creditor->	InvDate = date('Y-m-d H:i:s');
        $creditor->PaidDate = null;
        $creditor->CAmountPaid = null;
        $creditor->	TotalBillFor = $request->TotalBill;
        $creditor->AttyFees = $request->AttyDue;
        $creditor->Fee1Type = $request->Fee1Type;
        $creditor->Fee1Balance = $request->Fee1Balance;
        $creditor->Fee1 = $request->Fee1;
        $creditor->Fee2Type = $request->Fee2Type;
        $creditor->Fee2Balance = $request->Fee2Balance;
        $creditor->Fee2=$request->Fee2;
        $creditor->Fee3Type = $request->Fee3Type;
        $creditor->Fee3Balance = $request->Fee3Balance;
            //tblTrust::max('TPaymentID')+1;
        $creditor->Fee3=$request->Fee3;
        $creditor->InvText =$request->InvoiceText;
        $creditor->InvLbl =$request->InvoiceLabel;
        $creditor->LastUpdate=date('Y-m-d H:i:s');
        $creditor->UserUpdated=Auth::user()->name;

        $creditor->save();
        $trustActivity = new tblTrust();
        $trustActivity->where('TPaymentID', '=', $request->TPaymentID)
            ->update(array(
                'BilledFor'=>1,
            ));
        return redirect('/Invoices/'.$request->DebtorID.'?msg=Invoice Saved.');
    }

    public function editInvoice(Request $request){
        $result = rolerightsfield::where('RoleID','=',Auth::user()->is_permission)
            ->where('ScreenName','=','Invoice')
            ->where('FieldName','=','EditInvoice')
            ->first();
        if($result == null){
            return redirect('/Debtor?msg=Access denied.');
        }else{
            if(!$result->Active){
                return redirect('/Debtor?msg=Access denied.');
            }
        }
        if($request->updateInvoiceID != null)
        {
            $validatedData = $request->validate([
                'DebtorID' => 'required',
                'TotalBill' => 'required',
            ]);

            $newCreditor = new tblinvoice();
            $updateArray= array();
            $updateArray=$this->checkRights($updateArray,'Invoice','TotalBillFor',$request->TotalBill);
            $updateArray=$this->checkRights($updateArray,'Invoice','AttyFees',$request->AttyDue);
            $updateArray=$this->checkRights($updateArray,'Invoice','Fee1Type',$request->Fee1Type);
            $updateArray=$this->checkRights($updateArray,'Invoice','Fee1Balance',$request->Fee1Balance);
            $updateArray=$this->checkRights($updateArray,'Invoice','Fee1',$request->Fee1);
            $updateArray=$this->checkRights($updateArray,'Invoice','InvText',$request->InvoiceText);

            $updateArray=$this->checkRights($updateArray,'Invoice','InvLbl',$request->InvoiceLabel);

            $updateArray = array_add($updateArray, 'LastUpdate', date('Y-m-d H:i:s'));
            $updateArray = array_add($updateArray, 'UserUpdated',  Auth::user()->name);
            $newCreditor->where('IPaymentID','=',$request->updateInvoiceID)
                ->update($updateArray);
            /*array(
                'TotalBillFor'  => $request->TotalBill,
                'AttyFees'  => $request->AttyDue,
                'Fee1Type'  => $request->Fee1Type,
                'Fee1Balance'  => $request->Fee1Balance,
                'Fee1'  => $request->Fee1,
                'InvText'  =>$request->InvoiceText,
                'InvLbl'  =>$request->InvoiceLabel,
                'LastUpdate' =>date('Y-m-d H:i:s'),
                'UserUpdated' =>Auth::user()->name,
            )*/
            return redirect('/Debtor?msg=Debtor Successfully Updated.');
        }
        $invoice=tblinvoice::where('IPaymentID','=',$request->TPaymentID)->first();

        return view('accounting\invoice\editInvoice',['invoice'=>$invoice]);
    }
    public function UpdateInvoice(Request $request){


    }

    public  function   ShowInvoice(Request $request){

        $trustActivity = tblinvoice::where('IPaymentID','=',$request->TPaymentID)->first();
        if($trustActivity == null){
            return view('accounting\invoice\showInvoice',['trustActivity'=>$trustActivity]);
        }
        $debtor = tblDebtor::where('DebtorID','=',$trustActivity->DebtorID)->first();
        $creditor = tblcontacts::where('CreditorID','=',$debtor->CreditorID)->first();
		$contact = tblcontacts:: where('CreditorID','=',$debtor->CreditorID)
            ->where('ContactID','=',$debtor->ContactID)
            ->first();
        $PaidInv  = tblTrust::where('DebtorID','=',$trustActivity->DebtorID)
            ->where('TPaymentType','=','C')
            ->sum('PaymentReceived');
        $PaidTrustNew1 = tblTrust::where('DebtorID','=',$trustActivity->DebtorID)
            ->where('TPaymentType','=','T')
            ->sum('PaymentReceived');
        $PaidTrustNew2 = tblTrust::where('DebtorID','=',$trustActivity->DebtorID)
            ->where('TPaymentType','=','T')
            ->sum('AttyFees');
        $PaidTrustNew=$PaidTrustNew1+$PaidTrustNew2;
        $total=$debtor->AmountPlaced-$PaidInv-$PaidTrustNew;

        return view('accounting\invoice\showInvoice',['trustActivity'=>$trustActivity,'debtor'=>$debtor,'creditor'=>$creditor,'total'=>$total,'contact'=>$contact]);
    }

    public function updatePaidInvoice(Request $request){
        $debtor=tblinvoice::where('IPaymentID','=',$request->IPaymentID)->first();

        $invocie = new tblinvoice();
        $invocie->where('IPaymentID', '=', $request->IPaymentID)
            ->update(array(
                'PaidDate'=>date('Y-m-d H:i:s'),
                'CAmountPaid'=>$request->InvoiceTotal2,
                'Paid'=>1,
            ));
        return redirect('/Invoices/'.$debtor->DebtorID.'?msg=Invoice Paid.');
    }

    public  function DebtorReports(Request $request){
        $col = tblcollector::get();
        return view('accounting\Reports\DebtorReports',['col'=>$col]);
    }
    public  function InvoiceReports(Request $request){
        $col = tblcollector::get();
        $sales = tblsales::get();
        return view('accounting\Reports\InvoiceReports',['col'=>$col,'sales'=>$sales]);
    }
    public  function showInvoiceReports(Request $request){
        $OpenInvoices=False;
        $StrFilter='';
        if($request->ReportType ==1){
            $StrFilter=' InvDate =CURDATE() ';
        }
        elseif($request->ReportType ==6){
            $StrFilter=' tblCreditor.CreditorID ="'.$request->CreditorID.'"';
            if($request->sDate != null && $request->eDate != null){
                $StrFilter =$StrFilter . " and InvDate >= '".$request->sDate."' And InvDate <= '".$request->eDate."'";
            }
        }
        else{
            $StrFilter = " InvDate >= '".$request->sDate."' And InvDate <= '".$request->eDate."'";
        }
        if($request->ReportType ==2){
            if($request->InvoiceStatus == 2){
                if($StrFilter ==''){
                    $StrFilter =" tblInvoice.PaidDate is not null ";
                }else{
                    $StrFilter = $StrFilter." AND tblInvoice.PaidDate is not null ";
                }
            }
        }

        if($request->ReportType ==3){
            $results= \DB::select("Select round(Sum(qryInvoiceTotals.Collected),2) AS SumOfCollected,
round(Sum(qryInvoiceTotals.DueInv),2) AS SumOfDueInv,
Count(qryInvoiceTotals.InvoiceNumb) AS CountOfInvoiceNumb,
case PaidDate when null then 'Unpaid' else 'Paid' end AS Paid
 from (SELECT DISTINCTROW tblInvoice.InvDate, tblInvoice.InvoiceNumb, tblInvoice.PaidDate,
TotalBillFor AS Collected,
round(COALESCE((case Fee1Type when '%'  then (Fee1Balance/100)*Fee1 ELSE Fee1 end) -
COALESCE(tblInvoice.AttyFees,0),0),2) AS DueInv
FROM tblInvoices tblInvoice
WHERE (((tblInvoice.InvDate)>='".$request->sDate."' And (tblInvoice.InvDate)<='".$request->eDate."'))) qryInvoiceTotals");
        return response()->json($results);
        }

      //  else{
       //     $StrFilter = " InvDate >= '".$request->sDate."' And InvDate <= '".$request->eDate."'";
       // }

       if($request->ReportType ==4 || $request->ReportType ==5){
            $StrFilter='';
            $StrFilter="tblInvoice.PaidDate >= '".$request->sDate."' And tblInvoice.PaidDate <= '".$request->eDate."'";
            if($request->ReportType ==4){
                $StrFilter = $StrFilter . " AND tblTrust.ColID=".$request->colID;
            }
            if($request->ReportType ==5){
                $StrFilter = $StrFilter . " AND tblCreditor.SaleID =".$request->SaleID;
            }
        }

        if($StrFilter != ''){
            $StrFilter=' And '.$StrFilter;
        }

       $results= \DB::select('SELECT  tblDebtors.CreditorID, tblInvoice.InvDate,
 tblTrust.PaymentReceived, tblDebtors.DebtorID,  tblDebtors.DebtorName,
 tblInvoice.InvoiceNumb, tblInvoice.PaidDate, tblInvoice.CAmountPaid,
 tblInvoice.TotalBillFor, tblInvoice.AttyFees, tblInvoice.Fee1Type, tblInvoice.Fee1Balance,
 tblInvoice.Fee1, tblInvoice.Fee2Type, tblInvoice.Fee2Balance, tblInvoice.Fee2,
 tblInvoice.Fee3Type, tblInvoice.Fee3Balance, tblInvoice.Fee3, tblInvoice.InvText,
 tblInvoice.InvLbl, tblTrust.TPaymentType,
 COALESCE(Fee1Balance,0)+
COALESCE(Fee2Balance,0)+
COALESCE(Fee3Balance,0) AS Collected,
COALESCE((case Fee1Type when \'%\'  then (Fee1Balance/100)*Fee1 ELSE Fee1 end) -
COALESCE(tblInvoice.AttyFees,0),0) AS DueInv
FROM ((tblCreditors tblCreditor
inner JOIN tblDebtors ON tblCreditor.CreditorID=tblDebtors.CreditorID)
inner JOIN tblTrusts tblTrust ON tblDebtors.DebtorID=tblTrust.DebtorID)
inner JOIN tblInvoices tblInvoice ON (tblTrust.TPaymentType=tblInvoice.IPaymentType) AND (tblTrust.TPaymentID=tblInvoice.IPaymentID)
WHERE  tblTrust.TPaymentType="C"  '.$StrFilter );

        return response()->json($results);
        //DateEntered >= #9/1/2012# And DateEntered <= #9/30/2012# And AmountPlaced < 30000
        if($request->view == 'Export'){
            if($request->Export == 'PDF'){
                $data=[
                    'invoice'=>$results,
                ];
                $html=view('accounting\Reports\showDebtorBySalemanReports',['results'=>$results])->render();
                $pdf= new Dompdf();
                $pdf->loadHtml($html);
                $pdf->render();
                $pdf->stream('DebtorBySalemanReports.pdf');
            }else{
                $paymentsArray = array();
                foreach ($results as $payment) {
                    $paymentsArray[] = (array)$payment;
                }

                Excel::create('DebtorBySalemanReports', function($excel) use($paymentsArray) {
                    $excel->sheet('Sheetname', function($sheet) use($paymentsArray) {
                        $sheet->with($paymentsArray, null, 'A1', false, false);
                    });
                })->export('xls');
            }
        }
        return view('accounting\Reports\showInvoiceReports',['results'=>$results]);
    }
    public  function DebtorBySalemanReports(Request $request){
        $col = tblcollector::get();
        return view('accounting\Reports\DebtorBySalemanReports');
    }
    public  function CreditorReports(Request $request){
        $saleman = tblsales::get();
        return view('accounting\Reports\CreditorReports',['saleman'=>$saleman]);
    }
    public  function TrustReports(Request $request)
    {
        $col = tblcollector::get();
        $saleman = tblsales::get();
        return view('accounting\Reports\TrustReports', ['col' => $col, 'saleman' => $saleman]);
    }
    public  function showDebtorBySalemanReports(Request $request){

        $Filter='';
        if($request->ReportType ==1){ $Filter='';}
        if($request->ReportType ==2){ $Filter='DateEntered >= \''.$request->sDate.'\' And DateEntered <=\''.$request->eDate.'\'';}
        if($request->ReportType ==3){ $Filter='DateEntered >= \''.$request->sDate.'\' And DateEntered <=\''.$request->eDate.'\' And AmountPlaced < 30000';}
        if($request->ReportType ==4){ $Filter='tblDebtors.LastUpdate >= \''.$request->sDate.'\' And tblDebtors.LastUpdate <=\''.$request->eDate.'\' and tblDebtors.StatusID Not Like \'%z%\'';}
        if($request->ReportType ==5){ $Filter='tblDebtors.LastUpdate >= \''.$request->sDate.'\' And tblDebtors.LastUpdate <=\''.$request->eDate.'\' and tblDebtors.StatusID Not Like \'%z%\' And AmountPlaced < 30000';}
        if($request->ReportType ==6){ $Filter='tblDebtors.StatusID Not Like \'%z%\'';}

        if($Filter != ''){
            $Filter =' where '.$Filter;
        }

        $str='SELECT tblcreditors.CreditorID, tblcreditors.SaleID, tblDebtors.DebtorID, tblDebtors.DebtorName, tblDebtors.AmountPlaced,
 tblDebtors.StatusID, tblDebtors.DateEntered, Month(DateEntered) AS MonthOfPmnt, Year(DateEntered) AS ThisYear,
 tblcreditors.LastDate, tblDebtors.LastUpdate, ts.StatusDesc FROM tblcreditors
 inner JOIN tblDebtors ON tblcreditors.CreditorID = tblDebtors.CreditorID INNER  JOIN tblstatuses TS on ts.StatusID=tblDebtors.StatusID '.$Filter ;

        $results= \DB::select($str);
        //DateEntered >= #9/1/2012# And DateEntered <= #9/30/2012# And AmountPlaced < 30000
        return response()->json($results);
        if($request->view == 'Export'){
            if($request->Export == 'PDF'){
                $data=[
                    'invoice'=>$results,
                ];
                $html=view('accounting\Reports\showDebtorBySalemanReports',['results'=>$results])->render();
                $pdf= new Dompdf();
                $pdf->loadHtml($html);
                $pdf->render();
                $pdf->stream('DebtorBySalemanReports.pdf');
            }else{
                $paymentsArray = array();
                foreach ($results as $payment) {
                    $paymentsArray[] = (array)$payment;
                }

                Excel::create('DebtorBySalemanReports', function($excel) use($paymentsArray) {
                    $excel->sheet('Sheetname', function($sheet) use($paymentsArray) {
                        $sheet->with($paymentsArray, null, 'A1', false, false);
                    });
                })->export('xls');
            }
        }

        return view('accounting\Reports\showDebtorBySalemanReports',['results'=>$results]);
    }
    public  function showCreditorReports(Request $request){

        If ($request->ReportType == 4) {
            $CID='';
            if($request->CreditorID !=null){
                $CID=' AND tblCreditors.CreditorID = "'.$request->CreditorID.'"';
            }
            $results= \DB::select('SELECT tblCreditors.CreditorID, tblSales.SLastName, tblSales.SFirstName,
tblCreditors.SaleID, tblCreditors.OpenDate, tblCreditors.Comments, tblCreditors.CompReport, tblCreditors.LastDate, tblContacts.ContactID,
 tblContacts.ClientName, tblContacts.Saltnt, tblContacts.CFirstName, tblContacts.CLastName, tblContacts.MainManager, tblContacts.Street,
 tblContacts.City, tblContacts.State, tblContacts.Zip, tblContacts.Phone, tblContacts.Fax, tblContacts.Ext
  FROM (tblSales INNER JOIN tblCreditors ON tblSales.SalesID = tblCreditors.SaleID)
  INNER JOIN tblContacts ON tblCreditors.CreditorID = tblContacts.CreditorID WHERE (((tblContacts.MainManager)=True)) '.$CID );

            //$paymentsArray = [];

            // Define the Excel spreadsheet headers


            //return $pdf->download('invoice.pdf');

            return response()->json($results);
            if($request->view == 'Export'){
                if($request->Export == 'PDF'){
                    $data=[
                        'invoice'=>$results,
                    ];
                    $html=view('accounting\Reports\rptCreditorsBYSales',['results'=>$results])->render();
                    $pdf= new Dompdf();
                    $pdf->loadHtml($html);

                    $pdf->render();
                    $pdf->stream('CreditorReports.pdf');
                }else{
                    $paymentsArray = array();
                    foreach ($results as $payment) {
                        $rs=array();
                        $rs['SFirstName']= $payment->SFirstName;
                        $rs['SLastName']= $payment->SLastName;
                        $rs['CreditorID']= $payment->CreditorID;
                        $rs['ClientName']= $payment->ClientName;
                        $rs['Phone']= $payment->Phone;
                        $paymentsArray[] = (array)$rs;
                    }
                    if(count($paymentsArray) == 0){
                        $rs=array();
                        $rs['SFirstName']= '';
                        $rs['SLastName']= '';
                        $rs['CreditorID']= '';
                        $rs['ClientName']= '';
                        $rs['Phone']= '';

                        $paymentsArray[] = (array)$rs;
                    }
                    Excel::create('CreditorReport', function($excel) use($paymentsArray) {
                        $excel->sheet('Sheetname', function($sheet) use($paymentsArray) {
                            $sheet->with($paymentsArray, null, 'A1', false, false);
                        });
                    })->export('xls');
                }
            }
            return view('accounting\Reports\rptCreditorsBYSales',['results'=>$results]);
        }
        If ($request->ReportType == 5) {
            $CID='';
            if($request->CreditorID !=null){
                $CID=' AND tblCreditor.CreditorID ="'.$request->CreditorID.'"';
            }
            $str= 'SELECT tblCreditor.CreditorID, tblCreditor.SaleID, tblDebtors.DateEntered, tblDebtors.DebtorName, tblDebtors.DebtorID, tblDebtors.StatusID, tblDebtors.AmountPlaced, tblDebtors.ColID, qryTotalTrustPerDateLetters.SumOfNetClient, qryTotalPaymentsLetters.SumOfAmountPaid,ROUND(qryTotalTrustPerDateLetters.SumOfNetClient-qryTotalPaymentsLetters.SumOfAmountPaid ,2) \'AmountPd\',
 ROUND(tblDebtors.AmountPlaced-qryTotalTrustPerDateLetters.SumOfNetClient-qryTotalPaymentsLetters.SumOfAmountPaid ,2) \'BalanceDue\' from tblcreditors tblCreditor
            INNER JOIN ((tblDebtors LEFT JOIN
            (SELECT DISTINCTROW tblDebtors.CreditorID, tblTrust.DebtorID, Sum(tblTrust.CostRef) AS CostRef, Sum(PaymentReceived) AS SumOfNetClient FROM tblDebtors LEFT JOIN tbltrusts tblTrust ON tblDebtors.DebtorID = tblTrust.DebtorID WHERE tblTrust.TPaymentType="T" GROUP BY tblDebtors.CreditorID, tblTrust.DebtorID)qryTotalTrustPerDateLetters ON tblDebtors.DebtorID = qryTotalTrustPerDateLetters.DebtorID)
            LEFT JOIN (SELECT tblDebtors.CreditorID, tblTrusts.DebtorID, Sum(PaymentReceived) AS SumOfAmountPaid FROM tblDebtors LEFT JOIN tblTrusts ON tblDebtors.DebtorID = tblTrusts.DebtorID WHERE (((tblTrusts.TPaymentType)="C")) GROUP BY tblDebtors.CreditorID, tblTrusts.DebtorID) qryTotalPaymentsLetters
            ON tblDebtors.DebtorID = qryTotalPaymentsLetters.DebtorID)
            ON tblCreditor.CreditorID = tblDebtors.CreditorID
            WHERE tblDebtors.DebtorName Is Not Null '.$CID.' and SaleID ='.$request->SalesID.'';

            $results= \DB::select($str);
            return response()->json($results);
            if($request->view == 'Export'){
                if($request->Export == 'PDF'){
                    $data=[
                        'invoice'=>$results,
                    ];
                    $html=view('accounting\Reports\rptSalemansDbtrs',['results'=>$results])->render();
                    $pdf= new Dompdf();
                    $pdf->loadHtml($html);

                    $pdf->render();
                    $pdf->stream('CreditorReports.pdf');
                }else{
                    $paymentsArray = array();
                    foreach ($results as $payment) {
                        $rs=array();
                        $rs['DebtorName']= $payment->DebtorName;
                        $rs['DateEntered']= $payment->DateEntered;
                        $rs['CreditorID']= $payment->CreditorID;
                        $rs['AmountPl']= $payment->AmountPlaced;
                        $rs['AmountPd']= floatval($payment->SumOfAmountPaid)+floatval($payment->SumOfNetClient);
                        $rs['BalanceDue']= floatval($payment->AmountPlaced)-floatval($payment->SumOfAmountPaid)-floatval($payment->SumOfNetClient);
                        $rs['Status']= $payment->StatusID;
                        $rs['ColID']= $payment->ColID;
                        $paymentsArray[] = (array)$rs;
                    }
                    if(count($paymentsArray) == 0){
                        $rs=array();
                        $rs['DebtorName']= '';
                        $rs['DateEntered']= '';
                        $rs['CreditorID']= '';
                        $rs['AmountPl']= '';
                        $rs['AmountPd']= '';
                        $rs['BalanceDue']=  '';
                        $rs['Status']= '';
                        $rs['ColID']= '';
                        $paymentsArray[] = (array)$rs;
                    }
                    Excel::create('CreditorReport', function($excel) use($paymentsArray) {
                        $excel->sheet('Sheetname', function($sheet) use($paymentsArray) {
                            $sheet->with($paymentsArray, null, 'A1', false, false);
                        });
                    })->export('xls');
                }
            }
            return view('accounting\Reports\rptSalemansDbtrs',['results'=>$results]);
        }

        If ($request->ReportType == 6) {
            $CID='';
            if($request->CreditorID !=null){
                $CID=' AND tblCreditor.CreditorID = "'.$request->CreditorID.'"';
            }
            $strQry='SELECT tblCreditor.CreditorID, tblCreditor.SaleID, tblDebtors.DateEntered, tblDebtors.DebtorName, tblDebtors.DebtorID, tblDebtors.StatusID, tblDebtors.AmountPlaced, tblDebtors.ColID, qryTotalTrustPerDateLetters.SumOfNetClient, qryTotalPaymentsLetters.SumOfAmountPaid,ROUND(qryTotalTrustPerDateLetters.SumOfNetClient-qryTotalPaymentsLetters.SumOfAmountPaid ,2) \'AmountPd\',
 ROUND(tblDebtors.AmountPlaced-qryTotalTrustPerDateLetters.SumOfNetClient-qryTotalPaymentsLetters.SumOfAmountPaid ,2) \'BalanceDue\' from tblcreditors tblCreditor
            INNER JOIN ((tblDebtors LEFT JOIN
            (SELECT DISTINCTROW tblDebtors.CreditorID, tblTrust.DebtorID, Sum(tblTrust.CostRef) AS CostRef, Sum(PaymentReceived) AS SumOfNetClient FROM tblDebtors INNER JOIN tbltrusts tblTrust ON tblDebtors.DebtorID = tblTrust.DebtorID WHERE tblTrust.TPaymentType="T" GROUP BY tblDebtors.CreditorID, tblTrust.DebtorID)qryTotalTrustPerDateLetters ON tblDebtors.DebtorID = qryTotalTrustPerDateLetters.DebtorID)
            LEFT JOIN (SELECT tblDebtors.CreditorID, tblTrusts.DebtorID, Sum(PaymentReceived) AS SumOfAmountPaid FROM tblDebtors INNER JOIN tblTrusts ON tblDebtors.DebtorID = tblTrusts.DebtorID WHERE (((tblTrusts.TPaymentType)="C")) GROUP BY tblDebtors.CreditorID, tblTrusts.DebtorID) qryTotalPaymentsLetters
            ON tblDebtors.DebtorID = qryTotalPaymentsLetters.DebtorID)
            ON tblCreditor.CreditorID = tblDebtors.CreditorID
            WHERE tblDebtors.DebtorName Is Not Null '.$CID.' and SaleID = '. $request->SalesID .' AND DateEntered >="'.$request->sDate.'" And DateEntered <= "'.$request->eDate.'"';

            $results= \DB::select($strQry);
            return response()-> json($results);
            if($request->view == 'Export'){
                if($request->Export == 'PDF'){
                    $data=[
                        'invoice'=>$results,
                    ];
                    $html=view('accounting\Reports\rptSalemansDbtrs',['results'=>$results])->render();
                    $pdf= new Dompdf();
                    $pdf->loadHtml($html);

                    $pdf->render();
                    $pdf->stream('CreditorReports.pdf');
                }else{
                    $paymentsArray = array();
                    foreach ($results as $payment) {
                        $rs=array();
                        $rs['DebtorName']= $payment->DebtorName;
                        $rs['DateEntered']= $payment->DateEntered;
                        $rs['CreditorID']= $payment->CreditorID;
                        $rs['AmountPl']= $payment->AmountPlaced;
                        $rs['AmountPd']= floatval($payment->SumOfAmountPaid)+floatval($payment->SumOfNetClient);
                        $rs['BalanceDue']= floatval($payment->AmountPlaced)-floatval($payment->SumOfAmountPaid)-floatval($payment->SumOfNetClient);
                        $rs['Status']= $payment->StatusID;
                        $rs['ColID']= $payment->ColID;
                        $paymentsArray[] = (array)$rs;
                    }
                    if(count($paymentsArray) == 0){
                        $rs=array();
                        $rs['DebtorName']= '';
                        $rs['DateEntered']= '';
                        $rs['CreditorID']= '';
                        $rs['AmountPl']= '';
                        $rs['AmountPd']= '';
                        $rs['BalanceDue']=  '';
                        $rs['Status']= '';
                        $rs['ColID']= '';
                        $paymentsArray[] = (array)$rs;
                    }
                    Excel::create('CreditorReport', function($excel) use($paymentsArray) {
                        $excel->sheet('Sheetname', function($sheet) use($paymentsArray) {
                            $sheet->with($paymentsArray, null, 'A1', false, false);
                        });
                    })->export('xls');
                }
            }
            return view('accounting\Reports\rptSalemansDbtrs',['results'=>$results]);
        }
        $perms='';
        If ($request->ReportType == 2) {
            $perms='  AND SaleID = '. $request->SalesID .' AND OpenDate >="'.$request->sDate.'" AND OpenDate <="'.$request->eDate.'"';
        }
        If ($request->ReportType == 3) {
            $perms=' AND SaleID ='. $request->SalesID .' AND LastDate >="'.$request->sDate.'" AND LastDate <="'.$request->eDate.'"';
        }
        If ($request->ReportType == 1) {
            $perms=' AND SaleID ='. $request->SalesID .'';
        }

        if($request->CreditorID !=null){
            $perms=' AND tblCreditor.CreditorID = "'.$request->CreditorID.'" '.$perms;
        }

        $results= \DB::select('SELECT tblContacts.ClientName,
                             tblCreditor.CreditorID, tblCreditor.SaleID, tblCreditor.OpenDate, tblCreditor.LastDate,
                            COALESCE(qryCountOfDebt.CountOfDebtorID,0)CountOfDebtorID,
                           ROUND( COALESCE(qryTotalPlacedAll.SumOfAmountPlaced,0),2)SumOfAmountPlaced,
                           ROUND(  COALESCE(qryAGrossDbtrAll.SumOfAgencyGross,0),2)SumOfAgencyGross,
                             ROUND(COALESCE(qryInvoiceDbtrAll.DueInv,0),2)DueInv,
                            ROUND(COALESCE(qryTotalClctCrdtsAll.Credits,0),2)Credits,
                            ROUND(  COALESCE(qryAGrossDbtrAll.SumOfAgencyGross,0),2)+ROUND(COALESCE(qryInvoiceDbtrAll.DueInv,0),2)FEES,
                            ROUND(COALESCE(qryTotalClctCrdtsAll.Credits,0),2)+ROUND(COALESCE(qryTotalTrustPerCreditorAll.SumOfNetClient,0),2)DLRCOL,
                            ROUND(COALESCE(qryTotalTrustPerCreditorAll.SumOfNetClient,0),2)SumOfNetClient from tblcreditors tblCreditor
                            INNER JOIN (SELECT tblDebtors.CreditorID, Count(tblDebtors.DebtorID) AS CountOfDebtorID FROM tblDebtors GROUP BY tblDebtors.CreditorID) qryCountOfDebt ON tblCreditor.CreditorID = qryCountOfDebt.CreditorID
                            INNER JOIN (SELECT tblDebtors.CreditorID, Sum(tblDebtors.AmountPlaced) AS SumOfAmountPlaced FROM tblDebtors GROUP BY tblDebtors.CreditorID)qryTotalPlacedAll ON tblCreditor.CreditorID = qryTotalPlacedAll.CreditorID
                            LEFT JOIN (SELECT tblDebtors.CreditorID, Sum(tblTrust.PaymentReceived) AS Credits FROM tblDebtors INNER JOIN tbltrusts tblTrust ON tblDebtors.DebtorID = tblTrust.DebtorID WHERE (((tblTrust.TPaymentType)="C")) GROUP BY tblDebtors.CreditorID)qryTotalClctCrdtsAll ON tblCreditor.CreditorID = qryTotalClctCrdtsAll.CreditorID
                            LEFT JOIN (SELECT  tblDebtors.CreditorID, Sum(tblTrust.PaymentReceived) AS SumOfNetClient FROM tblDebtors LEFT JOIN tbltrusts tblTrust ON tblDebtors.DebtorID = tblTrust.DebtorID WHERE tblTrust.TPaymentType="T" GROUP BY tblDebtors.CreditorID)qryTotalTrustPerCreditorAll ON tblCreditor.CreditorID = qryTotalTrustPerCreditorAll.CreditorID
                            LEFT JOIN (SELECT tblDebtors.CreditorID, Sum(tblTrust.AgencyGross) AS SumOfAgencyGross FROM tblDebtors INNER JOIN tbltrusts tblTrust ON tblDebtors.DebtorID = tblTrust.DebtorID WHERE tblTrust.TPaymentType="T" GROUP BY tblDebtors.CreditorID)qryAGrossDbtrAll ON tblCreditor.CreditorID = qryAGrossDbtrAll.CreditorID
                            LEFT JOIN (SELECT tblDebtors.CreditorID, COALESCE(SUM((case Fee1Type when \'%\' then (Fee1Balance / 100)*Fee1 ELSE Fee1 end )+ (case Fee2Type when \'%\' then (Fee2Balance / 100)*Fee2 ELSE Fee2 end )+ (case Fee3Type when \'%\' then (Fee3Balance / 100)*Fee3 ELSE Fee3 end )),0) as DueInv FROM tblDebtors INNER JOIN tblinvoices tblInvoice ON tblDebtors.DebtorID = tblInvoice.DebtorID GROUP BY tblDebtors.CreditorID)qryInvoiceDbtrAll ON tblCreditor.CreditorID = qryInvoiceDbtrAll.CreditorID
                            LEFT JOIN tblContacts ON tblCreditor.CreditorID = tblContacts.CreditorID WHERE tblContacts.MainManager=True '. $perms .'
                            ORDER BY tblContacts.ClientName, tblCreditor.CreditorID;');

        return response()-> json($results);
        if($request->view == 'Export'){
            if($request->Export == 'PDF'){
                $data=[
                    'invoice'=>$results,
                ];
                $html=view('accounting\Reports\rptCreditorsTotals',['results'=>$results])->render();
                $pdf= new Dompdf();
                $pdf->loadHtml($html);
                $pdf->render();
                $pdf->stream('CreditorReports.pdf');
            }else{
                $paymentsArray = array();
                foreach ($results as $payment) {
                    $rs=array();
                    $rs['ClientName']= $payment->ClientName;
                    $rs['SL']= $payment->SaleID;
                    $rs['OpenDate']= $payment->OpenDate;
                    $rs['TTLPL']= $payment->CountOfDebtorID;
                    $rs['DLRSPL']= $payment->SumOfAmountPlaced;
                    $rs['LastDate']=  $payment->LastDate;
                    $rs['DLRCOL']= floatval($payment->Credits)+floatval($payment->SumOfNetClient);
                    $rs['FEES']= floatval($payment->DueInv)+floatval($payment->SumOfAgencyGross);
                    $paymentsArray[] = (array)$rs;
                }
                if(count($paymentsArray) == 0){
                    $rs=array();
                    $rs['ClientName']= '';
                    $rs['SL']= '';
                    $rs['OpenDate']= '';
                    $rs['TTLPL']= '';
                    $rs['DLRSPL']= '';
                    $rs['LastDate']=  '';
                    $rs['DLRCOL']= '';
                    $rs['FEES']= '';
                    $paymentsArray[] = (array)$rs;
                }
                Excel::create('CreditorReport', function($excel) use($paymentsArray) {
                    $excel->sheet('Sheetname', function($sheet) use($paymentsArray) {
                        $sheet->with($paymentsArray, null, 'A1', false, false);
                    });
                })->export('xls');
            }
        }
        return view('accounting\Reports\rptCreditorsTotals',['results'=>$results]);
    }
    public  function showDebtorReports(Request $request){

        $strFilterColl ='';
        $newString='%Z%';

        if ($request->ReportType ==1){
            $strFilterColl = "tblCollectors.ColID = 0";
        }
        elseif ($request->ReportType ==2){
            $strFilterColl = "tblCollectors.ColID =". $request->colID ."";
        }

        elseif ($request->ReportType ==3){
            $strFilterColl = "";
        }
        elseif ($request->ReportType ==4){
            $strFilterColl = "tblDebtors.AmountPlaced < 30000";
        }
        if ($request->chkActiveOnly ==true){
            If ($strFilterColl == "")
            {
                $strFilterColl = "tblDebtors.StatusID Like '".$newString."'";
            }else{
                $strFilterColl = $strFilterColl. " AND tblDebtors.StatusID Like '%Z%'";
            }
        }
        if ($strFilterColl != ''){
            $strFilterColl ="where ".$strFilterColl;
        }
        $results= 'SELECT TD.StatusID, TD.DebtorID, TD.DebtorName, TD.Phone, round(TD.AmountPlaced,2)AmountPlaced,
TC.ColID,TC.CLastName, TC.CFirstName,
 round (qryTotalPaymentsLetters.SumOfAmountPaid,2)SumOfAmountPaid, round (QueryTrust.SumOfNetClient,2)SumOfNetClient,
 round(TD.AmountPlaced,2)-round (qryTotalPaymentsLetters.SumOfAmountPaid,2)BalanceDue
 from tbldebtors TD
INNER JOIN tblcollectors TC on TD.ColID=TC.ColID
INNER JOIN (SELECT tblTrusts.DebtorID, Sum(PaymentReceived) AS SumOfAmountPaid FROM tblDebtors INNER JOIN tblTrusts ON tblDebtors.DebtorID = tblTrusts.DebtorID  WHERE (((tblTrusts.TPaymentType)="C")) GROUP BY tblTrusts.DebtorID) as qryTotalPaymentsLetters on qryTotalPaymentsLetters.DebtorID = TD.DebtorID
INNER JOIN (SELECT tblTrusts.DebtorID, Sum(tblTrusts.CostRef) AS CostRef,
Sum(PaymentReceived) AS SumOfNetClient FROM tblDebtors
 INNER JOIN tblTrusts ON tblDebtors.DebtorID = tblTrusts.DebtorID
 GROUP by tbldebtors.CreditorID,tbltrusts.DebtorID) QueryTrust
 ON QueryTrust.DebtorID = TD.DebtorID ';
        $str='SELECT tblDebtors.StatusID, tblDebtors.DebtorID, tblDebtors.DebtorName, tblDebtors.Phone,
 tblCollectors.ColID, tblCollectors.CLastName, tblCollectors.CFirstName,
  COALESCE(tblDebtors.AmountPlaced,0)AmountPlaced, 
  COALESCE(qryTotalPaymentsLetters.SumOfAmountPaid,0)SumOfAmountPaid, 
  COALESCE(tblDebtors.AmountPlaced,0)-COALESCE(qryTotalPaymentsLetters.SumOfAmountPaid,0)BalanceDue, 
  COALESCE(qryTotalTrustPerDateLetters.SumOfNetClient,0)SumOfNetClient
FROM ((tblCollectors 
       RIGHT JOIN tblDebtors ON tblCollectors.ColID= tblDebtors.ColID) 
      LEFT JOIN (SELECT DISTINCTROW tblDebtors.CreditorID, tblTrust.DebtorID, Sum(tblTrust.PaymentReceived) AS SumOfAmountPaid
FROM tblDebtors LEFT JOIN tblTrusts tblTrust ON tblDebtors.DebtorID = tblTrust.DebtorID
WHERE (((tblTrust.TPaymentType)="C"))
GROUP BY tblDebtors.CreditorID, tblTrust.DebtorID)qryTotalPaymentsLetters ON tblDebtors.DebtorID = qryTotalPaymentsLetters.DebtorID) 
      LEFT JOIN (SELECT DISTINCTROW tblDebtors.CreditorID, tblTrust.DebtorID, Sum(tblTrust.CostRef) AS CostRef, Sum(tblTrust.PaymentReceived+COALESCE(tblTrust.AttyFees,0)) AS SumOfNetClient
FROM tblDebtors LEFT JOIN tblTrusts tblTrust ON tblDebtors.DebtorID = tblTrust.DebtorID
WHERE (((tblTrust.TPaymentType)="T") AND ((tblTrust.DateRcvd)>\'5/29/2000\'))
GROUP BY tblDebtors.CreditorID, tblTrust.DebtorID)qryTotalTrustPerDateLetters ON tblDebtors.DebtorID = qryTotalTrustPerDateLetters.DebtorID
     '.$strFilterColl.'        
GROUP BY tblDebtors.StatusID, tblDebtors.DebtorID, tblDebtors.DebtorName, tblDebtors.Phone, tblCollectors.ColID, tblCollectors.CLastName, tblCollectors.CFirstName, tblDebtors.AmountPlaced, qryTotalPaymentsLetters.SumOfAmountPaid, qryTotalTrustPerDateLetters.SumOfNetClient
';
        $results= \DB::select($str);
        return response()->json($results);
       /* $results= \DB::select('SELECT TD.StatusID, TD.DebtorID, TD.DebtorName, TD.Phone, TC.ColID,
TC.CLastName, TC.CFirstName, TD.AmountPlaced,
 qryTotalPaymentsLetters.SumOfAmountPaid, QueryTrust.SumOfNetClient from tbldebtors TD
RIGHT JOIN tblcollectors TC on TD.ColID=TC.ColID
LEFT JOIN (SELECT tblDebtors.CreditorID, tblTrusts.DebtorID, Sum(PaymentReceived) AS SumOfAmountPaid FROM tblDebtors LEFT JOIN tblTrusts ON tblDebtors.DebtorID = tblTrusts.DebtorID WHERE (((tblTrusts.TPaymentType)="C")) GROUP BY tblDebtors.CreditorID, tblTrusts.DebtorID) as qryTotalPaymentsLetters on qryTotalPaymentsLetters.DebtorID = TD.DebtorID
LEFT JOIN (SELECT tblDebtors.CreditorID, tblTrusts.DebtorID, Sum(tblTrusts.CostRef) AS CostRef, Sum(PaymentReceived) AS SumOfNetClient FROM tblDebtors LEFT JOIN tblTrusts ON tblDebtors.DebtorID = tblTrusts.DebtorID GROUP by tbldebtors.CreditorID,tbltrusts.DebtorID) QueryTrust ON QueryTrust.DebtorID = TD.DebtorID '  );
*/
        if($request->view == 'Export'){
            if($request->Export == 'PDF'){
                $data=[
                    'invoice'=>$results,
                ];
                $html=view('accounting\Reports\showDebtorReports',['results'=>$results])->render();
                $pdf= new Dompdf();
                $pdf->loadHtml($html);

                $pdf->render();
                $pdf->stream('DebtorReport.pdf');
            }else{
                $paymentsArray = array();
                foreach ($results as $payment) {
                    $rs=array();
                    $rs['CFirstName']= $payment->SFirstName;
                    $rs['CLastName']= $payment->SLastName;
                    $rs['DebtorName']= $payment->CreditorID;
                    $rs['DebtorID']= $payment->ClientName;
                    $rs['Phone']= $payment->Phone;
                    $rs['AmountPlaced']= $payment->Phone;
                    $rs['BalanceDue']= floatval($payment->AmountPlaced)-floatval($payment->SumOfAmountPaid);
                    $paymentsArray[] = (array)$rs;
                }
                if(count($paymentsArray) == 0){
                    $rs=array();
                    $rs['CFirstName']= '';
                    $rs['CLastName']= '';
                    $rs['DebtorName']= '';
                    $rs['DebtorID']= '';
                    $rs['Phone']= '';
                    $rs['AmountPlaced']= '';
                    $rs['BalanceDue']= '';
                    $paymentsArray[] = (array)$rs;
                }
                Excel::create('DebtorReport', function($excel) use($paymentsArray) {
                    $excel->sheet('Sheetname', function($sheet) use($paymentsArray) {
                        $sheet->with($paymentsArray, null, 'A1', false, false);
                    });
                })->export('xls');
            }
        }
        return view('accounting\Reports\showDebtorReports',['results'=>$results]);
    }
    public  function showTrustReports(Request $request){
        $parms=' AND DateRcvd BETWEEN "'.$request->Year.'-'.$request->Month.'-01" and "'.$request->Year.'-'.$request->Month.'-31" ';
        If ($request->ReportType == 2) {
            $parms = $parms.' AND tblTrust.ColID='.$request->ColID;
        }
        If ($request->ReportType == 3) {
            $parms = $parms.' AND tblCreditor.SaleID='.$request->SalesID;
        }
        If ($request->ReportType == 4) {
            $parms = '  AND DateRcvd BETWEEN "'.$request->sDate.'" and "'.$request->eDate.'"  AND tblCreditor.CreditorID="'.$request->CreditorID.'"';
        }
        If ($request->ReportType == 5) {
            $parms = ' AND DateRcvd BETWEEN "'.$request->sDate.'" and "'.$request->eDate.'" AND tblDebtors.DebtorID='.$request->DebtorID;
        }
        $str='SELECT tblCreditor.SaleID, tblTrust.ColID, tblCreditor.CreditorID, tblDebtors.DebtorName,tblDebtors.ClientAcntNumber, tblTrust.DebtorID, tblTrust.TPaymentID, tblTrust.TPaymentType, tblTrust.DateRcvd, tblTrust.CheckNumb, tblTrust.RelDate, tblTrust.ColID, 
ClastName & " " & CFirstName AS Collector,
COALESCE(AgencyGross,0)-COALESCE(AttyFees,0)+COALESCE(Intrest,0)+COALESCE(MiscFees,0) AS AgencyNet, 
Month(DateRcvd) AS MonthOfPmnt,
Year(DateRcvd) AS ThisYear, 
COALESCE(PaymentReceived,0)-COALESCE(MiscFees,0)+COALESCE(CostRef,0) AS NetClient
FROM tblCreditors tblCreditor LEFT JOIN ((tblTrusts tblTrust RIGHT JOIN tblDebtors ON tblTrust.DebtorID = tblDebtors.DebtorID) LEFT JOIN tblCollectors ON tblTrust.ColID = tblCollectors.ColID) ON tblCreditor.CreditorID = tblDebtors.CreditorID
WHERE tblTrust.TPaymentType="T" '.$parms.'
ORDER BY tblTrust.DateRcvd DESC;
';

$results= \DB::select($str);

        /*$results= \DB::select('SELECT tblCreditor.SaleID,
                             tblTrust.ColID, tblCreditor.CreditorID,
                            tblDebtors.DebtorName, tblTrust.DebtorID, tblTrust.TPaymentID,
                             tblTrust.TPaymentType, tblTrust.DateRcvd, tblTrust.CheckNumb,
                             tblTrust.RelDate, tblTrust.ColID,
                            ClastName ,CFirstName,
                            ((CASE AgencyGross WHEN null THEN 0 ELSE AgencyGross END )-
                            (CASE AttyFees WHEN null THEN 0 ELSE AttyFees END )+
                            (CASE Intrest WHEN null THEN 0 ELSE Intrest END )+
                            (CASE MiscFees WHEN null THEN 0 ELSE MiscFees END )) AS AgencyNet,
                             Month(DateRcvd) AS MonthOfPmnt,
                             Year(DateRcvd) AS ThisYear,
                             ((CASE PaymentReceived WHEN null THEN 0 ELSE PaymentReceived END )-
                             (CASE MiscFees WHEN null THEN 0 ELSE MiscFees END )+(CASE CostRef WHEN null THEN 0 ELSE CostRef END )) AS NetClient
                            FROM tblcreditors tblCreditor
                             LEFT JOIN ((tbltrusts tblTrust
                            RIGHT JOIN tblDebtors ON tblTrust.DebtorID = tblDebtors.DebtorID)
                            LEFT JOIN tblCollectors ON tblTrust.ColID = tblCollectors.ColID)
                            ON tblCreditor.CreditorID = tblDebtors.CreditorID
                            WHERE (((tblTrust.TPaymentType)="T") AND  EXTRACT(YEAR_MONTH FROM DateRcvd)=\''.c.''.$request->Month.'\''.$parms.')
                            ORDER BY tblTrust.DateRcvd DESC;');*/
       /* $results_Creditor= \DB::select('SELECT tblDebtors.DebtorName, tblCreditor.CreditorID, tblTrust.PaymentReceived,
tblCreditor.SaleID,
((CASE PaymentReceived WHEN null THEN 0 ELSE PaymentReceived END )-
(CASE MiscFees WHEN null THEN 0 ELSE MiscFees END )+
(CASE CostRef WHEN null THEN 0 ELSE CostRef END )-
(CASE agencygross WHEN null THEN 0 ELSE agencygross END )+
(CASE attyfees WHEN null THEN 0 ELSE attyfees END )) AS NetClient,
tblDebtors.ClientAcntNumber, tblTrust.ColID, tblTrust.DebtorID,
tblTrust.TPaymentID, tblTrust.TPaymentType, tblTrust.DateRcvd, tblTrust.CheckNumb, tblTrust.RelDate, tblTrust.ColID,
ClastName , CFirstName ,

((CASE AgencyGross WHEN null THEN 0 ELSE AgencyGross END )-
(CASE AttyFees WHEN null THEN 0 ELSE AttyFees END )+
(CASE Intrest WHEN null THEN 0 ELSE Intrest END )+
(CASE MiscFees WHEN null THEN 0 ELSE MiscFees END )) AS AgencyNet,

Month(DateRcvd) AS MonthOfPmnt,
Year(DateRcvd) AS ThisYear,
((CASE PaymentReceived WHEN null THEN 0 ELSE PaymentReceived END )-
(CASE AttyFees WHEN null THEN 0 ELSE AttyFees END )) AS GrossClient
FROM tblcreditors tblCreditor LEFT JOIN ((tbltrusts tblTrust RIGHT JOIN tblDebtors ON tblTrust.DebtorID=tblDebtors.DebtorID)
LEFT JOIN tblCollectors ON tblTrust.ColID=tblCollectors.ColID) ON tblCreditor.CreditorID=tblDebtors.CreditorID
WHERE tblTrust.TPaymentType="T" And (tblTrust.DateRcvd)>=\'\' And (tblTrust.DateRcvd)<=\'\' AND tblCreditor.CreditorID=" Any"
ORDER BY tblDebtors.DebtorName, tblTrust.DateRcvd DESC;');*/
        //rightJoin('tblcollectors','tblcollectors.ColID','=','tblDebtors.ColID')->get();
        return response()->json($results);
        if($request->view == 'Export'){
            if($request->Export == 'PDF'){
                $data=[
                    'invoice'=>$results,
                ];
                $html=view('accounting\Reports\showTrustReports',['results'=>$results])->render();
                $pdf= new Dompdf();
                $pdf->loadHtml($html);

                $pdf->render();
                $pdf->stream('TrustReport.pdf');
            }else{
                $paymentsArray = array();
                foreach ($results as $payment) {
                    $rs=array();
                    $rs['DateRcvd']= $payment->DateRcvd;
                    $rs['CheckNumb']= $payment->CheckNumb;
                    $rs['DebtorName']= $payment->DebtorName;
                    $rs['CreditorID']= $payment->CreditorID;
                    $rs['NetClient']= $payment->NetClient;
                    $rs['AgencyNet']= $payment->AgencyNet;
                    $rs['RelDate']= $payment->RelDate;
                    $paymentsArray[] = (array)$rs;
                }
                if(count($paymentsArray) == 0){
                    $rs=array();
                    $rs['DateRcvd']= '';
                    $rs['CheckNumb']= '';
                    $rs['DebtorName']= '';
                    $rs['CreditorID']= '';
                    $rs['NetClient']= '';
                    $rs['AgencyNet']= '';
                    $rs['RelDate']= '';
                    $paymentsArray[] = (array)$rs;
                }
                Excel::create('TrustReport', function($excel) use($paymentsArray) {
                    $excel->sheet('Sheetname', function($sheet) use($paymentsArray) {
                        $sheet->with($paymentsArray, null, 'A1', false, false);
                    });
                })->export('xls');
            }
        }
        return view('accounting\Reports\showTrustReports',['results'=>$results]);
    }
    public function  Export($results,$name){
        $paymentsArray = array();

        foreach ($results as $payment) {

            $paymentsArray[] = (array)$payment;
        }

      return  Excel::create($name, function($excel) use($paymentsArray) {
            $excel->sheet('Sheetname', function($sheet) use($paymentsArray) {
                $sheet->with($paymentsArray, null, 'A1', false, false);
            });
        })->export('xls');
    }
    public  function CreditorsSummary(Request $request){
        return view('accounting\Reports\CreditorsSummary',["creditorID"=>$request->creditorID]);
    }
    public  function ShowCreditorsSummary(Request $request){
        $filter='';

        if ($request->chkActiveOnly == 1){
            $filter=' WHERE tblCreditor.CreditorID="'.$request->creditorID.'" AND TD.StatusID Like "%Z%"';
        }else{
            $filter=' WHERE tblCreditor.CreditorID="'.$request->creditorID.'"';
        }

        if($request->sDate != null && $request->eDate != null){
            $filter=$filter .' and TD.DateEntered >="'.$request->sDate.'" AND TD.DateEntered <="'.$request->eDate.'"';
        }

        $str='SELECT DISTINCT TD.DebtorID, tblCreditor.CompReport, tblCreditor.OpenDate, tblContacts.ClientName, tblContacts.Saltnt, 
tblContacts.CFirstName, tblStatus.StatusDesc, tblContacts.CLastName, TD.CreditorID, TD.ColID, TD.ContactID,
 TD.DateEntered, TD.Salutation, TD.DebtorName, TD.DFirstName, TD.DLastName, TD.Street, TD.City, TD.State, TD.Zip, TD.Phone,
  TD.ClientAcntNumber, TD.StatusID, TD.LastDate, ROUND(TD.AmountPlaced,2)AmountPlaced, TD.FormDate, ROUND(TD.CostAdv,2)CostAdv, 
  ROUND(qryTotalTrustPerDateLetters.CostRef,2) AS CostRec, TD.SuitFee, TD.Fees,
   ROUND(COALESCE(qryTotalTrustPerDateLetters.SumOfNetClient,0),2)SumOfNetClient, 
   ROUND(COALESCE(qryTotalPaymentsLetters.SumOfAmountPaid,0),2)SumOfAmountPaid,
ROUND(COALESCE(ROUND(COALESCE(qryTotalTrustPerDateLetters.SumOfNetClient,0),2)+ROUND(COALESCE(qryTotalPaymentsLetters.SumOfAmountPaid,0),2) ,0),2)AmountPaid
,ROUND(COALESCE(TD.AmountPlaced,0) -COALESCE(COALESCE(qryTotalTrustPerDateLetters.SumOfNetClient,0)+COALESCE(qryTotalPaymentsLetters.SumOfAmountPaid,0) ,0),2) BalanceDue, COALESCE((SumTotalFees),0) AS SumOfTotalFees
FROM tblCreditors tblCreditor 
	  INNER JOIN tbldebtors TD ON tblCreditor.CreditorID = TD.CreditorID
      INNER JOIN tblContacts ON tblCreditor.CreditorID = tblContacts.CreditorID AND tblContacts.MainManager=True
       LEFT JOIN tblstatuses tblStatus ON td.StatusID = tblStatus.StatusID 
       LEFT JOIN (SELECT DISTINCTROW tblDebtors.CreditorID, tblTrust.DebtorID, Sum(tblTrust.PaymentReceived) AS SumOfAmountPaid FROM tblDebtors LEFT JOIN tblTrusts tblTrust ON tblDebtors.DebtorID = tblTrust.DebtorID WHERE (((tblTrust.TPaymentType)="C")) GROUP BY tblDebtors.CreditorID, tblTrust.DebtorID) qryTotalPaymentsLetters 
      ON TD.DebtorID = qryTotalPaymentsLetters.DebtorID
      LEFT JOIN (SELECT DISTINCTROW tblDebtors.CreditorID, tblTrust.DebtorID, Sum(tblTrust.CostRef) AS CostRef, Sum(tblTrust.PaymentReceived+COALESCE(tblTrust.AttyFees,0)) AS SumOfNetClient FROM tblDebtors LEFT JOIN tblTrusts tblTrust ON tblDebtors.DebtorID = tblTrust.DebtorID
WHERE (((tblTrust.TPaymentType)="T") AND ((tblTrust.DateRcvd)>"5/29/2000"))
GROUP BY tblDebtors.CreditorID, tblTrust.DebtorID) qryTotalTrustPerDateLetters 
                   ON TD.DebtorID = qryTotalTrustPerDateLetters.DebtorID
 LEFT JOIN (SELECT tblInvoice.DebtorID, SUM(COALESCE(tblInvoice.Fee1,0)+COALESCE(tblInvoice.Fee2,0)+COALESCE(tblInvoice.Fee3,0)) AS Inv_Fees FROM tblinvoices tblInvoice GROUP BY tblInvoice.DebtorID) qryInvoice_Fees   ON td.DebtorID = qryInvoice_Fees.DebtorID
 LEFT JOIN (SELECT DebtorID,sum(TotalFees)SumTotalFees FROM (SELECT tblInvoice.DebtorID,
SUM(COALESCE(tblInvoice.Fee1,0)+COALESCE(tblInvoice.Fee2,0)+COALESCE(tblInvoice.Fee3,0)) AS TotalFees FROM tblinvoices tblInvoice GROUP BY tblInvoice.DebtorID
UNION
SELECT tblTrust.DebtorID,  Sum(COALESCE(tblTrust.Intrest,0)+COALESCE(tblTrust.MiscFees,0)+COALESCE(tblTrust.AgencyGross,0)) AS TotalFees FROM tbltrusts tblTrust GROUP BY tblTrust.DebtorID)aa )qryTotal_Fees_Final 
                 ON td.DebtorID = qryTotal_Fees_Final.DebtorID
                 '.$filter;

        $results= \DB::select($str);
        return response()->json($results);
    }

    public function ImportExport(Request $request){

        return view('accounting\ImportExport\ImportExport');
    }

    public function postUploadCsv(Request $request)
    {

        if($request->has('Collector')){
            try {

                $data = Excel::load(\Input::file('Collector'))->get();
                foreach ($data as $key => $row) {
                    if($row->has('colid') == true && $row->has('clastname') && $row->has('cfirstname') == true && $row->has('closing') == true){
                    $isExist = tblCollector::where('ColID','=',$row->colid)->first();
                    if($isExist  ==null){
                        $newCollector = new tblCollector();

                        $newCollector->ColID = $row->colid;
                        $newCollector->CLastName = $row->clastname;
                        $newCollector->CFirstName = $row->cfirstname;
                        $newCollector->Closing  =$row->closing;

                        $newCollector->save();
                    }
                }else{
                        return redirect('/ImportExport?msg=Collector Columns Not Found');
                    }
                }

            } catch (\Exception $e) {
                dd($e);

            }
        }
        if($request->has('Status')){
            try {

                $data = Excel::load(\Input::file('Status'))->get();
                foreach ($data as $key => $row) {
                    if($row->has('statusid') == true && $row->has('statusdesc') == true){
                    $isExist = tblStatus::where('statusID','=',$row->statusid)->first();
                    if($isExist  ==null){
                        $newStatus = new tblStatus();
                        $newStatus->StatusID = $row->statusid;
                        $newStatus->StatusDesc = $row->statusdesc;

                        $newStatus->save();
                    }
                    }else{
                        return redirect('/ImportExport?msg=Status Columns Not Found');
                    }
                }

            } catch (\Exception $e) {
                dd($e);

            }
        }

        if($request->has('Payment')){
            // process the form
            try {

                $data = Excel::load(\Input::file('Payment'))->get();
                foreach ($data as $key => $row) {

                    if($row->has('tpaymentid') == true && $row->has('debtorid') == true){
                        $isExist = tblTrust::where('TPaymentID','=',$row->tpaymentid)->first();
                        if($isExist  ==null){
                            $creditor = new tblTrust();
                            $creditor->DebtorID = $row->debtorid;
                            $creditor->TPaymentType=$row->tpaymenttype;
                            $creditor->DateRcvd =  date('Y-m-d', strtotime($row->datercvd));
                            $creditor->PaymentReceived =$this->dollorValidate($row->paymentreceived);
                            $creditor->PaymentType =$row->paymenttype;
                            $creditor->	Intrest = $this->dollorValidate($row->intrest);
                            $creditor->AttyFees = $this->dollorValidate($row->attyfees);
                            $creditor->MiscFees = $this->dollorValidate($row->miscfees);
                            $creditor->	CostRef = $this->dollorValidate($row->costref);
                            $creditor->AgencyGross = $this->dollorValidate($row->agencygross);
                            $creditor->CheckNumb = $row->checknumb;
                            $creditor->RelDate = date('Y-m-d', strtotime($row->reldate));
                            $creditor->ColID = $row->colid;
                            $creditor->UserUpdated =Auth::user()->name;
                            $creditor->TPaymentID =$row->tpaymentid;
                            if($row->billedfor == False){
                                $creditor->BilledFor=0;
                            }else{
                                $creditor->BilledFor=1;
                            }

                            $creditor->save();

                        }
                    }else{
                        return redirect('/ImportExport?msg=Payment Columns Not Found');
                    }
                }

            } catch (\Exception $e) {
                dd($e);

            }
        }
        if($request->has('Debtor')){
            try {
                $data = Excel::load(\Input::file('Debtor'))->get();
                foreach ($data as $key => $row) {
                    if($row->has('debtorname') == true && $row->has('amountplaced') == true){
                        $isExist = tblDebtor::where('DebtorID','=',$row->debtorid)->first();
                        if($isExist  ==null) {
                            $isCreditorExist = tblcreditor::where('CreditorID', '=', $row->creditorid)->first();
                            if ($isCreditorExist != null) {
                                $creditor = new tblDebtor();
                                $creditor->DebtorID = $row->debtorid;
                                $creditor->CreditorID = $row->creditorid;
                                $creditor->ColID = $row->colid;
                                $creditor->ContactID = $row->contactid;
                                if ($row->dateentered == null) {
                                    $creditor->DateEntered = null;
                                } else {
                                    $creditor->DateEntered = date('Y-m-d', strtotime($row->dateentered));
                                }
                                $creditor->DebtorName = $row->debtorname;
                                $creditor->DFirstName = $row->dfirstname;
                                $creditor->DLastName = $row->dlastname;
                                $creditor->Street = $row->street;
                                $creditor->City = $row->city;
                                $creditor->Country = $row->country;
                                $creditor->State = $row->state;
                                $creditor->Zip = $row->zip;
                                $creditor->Phone = $row->phone;
                                $creditor->ClientAcntNumber = $row->clientacntnumber;
                                $creditor->StatusID = $row->statusid;
                                if ($row->lastdate == null) {
                                    $creditor->LastDate = null;
                                } else {
                                    $creditor->LastDate = date('Y-m-d', strtotime($row->lastdate));
                                }
                                if ($row->formdate == null) {
                                    $creditor->FormDate = null;
                                } else {
                                    $creditor->FormDate = date('Y-m-d', strtotime($row->formdate));
                                }
                                $creditor->AmountPlaced = $this->dollorValidate($row->amountplaced);
                                $creditor->CostAdv = $this->dollorValidate($row->costadv);
                                $creditor->CostRec = $this->dollorValidate($row->costrec);
                                $creditor->SuitFee = $this->dollorValidate($row->suitfee);
                                $creditor->Fees = $this->dollorValidate($row->fees);
                                $creditor->LastUpdate = date('Y-m-d H:i:s');
                                $creditor->UserUpdated = Auth::user()->name;
                                $creditor->Salutation = $row->salutation;
                                $creditor->Email = null;
                                $creditor->CID = tblcreditor::where('CreditorID', '=', $row->creditorid)->value('ID');
                                $creditor->save();
                            }else{
                                return redirect('/ImportExport?msg=Import Creditor First');
                            }
                        }
                    }else{
                        return redirect('/ImportExport?msg=Debtor Columns Not Found');
                    }
                }

            } catch (\Exception $e) {
                dd($e);

            }
        }
        if($request->has('SaleMan')){
            try {

                $data = Excel::load(\Input::file('SaleMan'))->get();
                foreach ($data as $key => $row) {

                    if($row->has('salesid') == true   && $row->has('slastname') == true){
                        $isExist = tblsales::where('SalesID','=',$row->salesid)->first();
                        if($isExist  ==null){
                            $newSales = new tblsales();
                            $newSales->SalesID = $row->salesid;
                            $newSales->SLastName = $row->slastname;
                            $newSales->SFirstName = $row->sfirstname;
                            $newSales->save();
                        }
                    }else{
                        return redirect('/ImportExport?msg=Saleman Columns Not Found');
                    }
                }

            } catch (\Exception $e) {
                dd($e);

            }
        }
        if($request->has('Invoice')){
            try {

                $data = Excel::load(\Input::file('Invoice'))->get();
                foreach ($data as $key => $row) {

                    if($row->has('ipaymentid') == true   && $row->has('debtorid') == true){

                        $isExist = tblinvoice::where('ipaymentid','=',$row->ipaymentid)->first();
                        if($isExist  ==null){
                            $creditor = new tblinvoice();
                            $creditor->DebtorID = $row->debtorid;
                            $creditor->InvoiceNumb = $row->invoicenumb;
                            $creditor->IPaymentID = $row->ipaymentid;
                            $creditor->IPaymentType = $row->ipaymenttype;
                            $creditor->	InvDate =  date('Y-m-d', strtotime($row->invdate));
                            if($row->paiddate == null){
                                $creditor->PaidDate=null;
                            }else{
                                $creditor->PaidDate =   date('Y-m-d', strtotime($row->paiddate));
                            }
                            $creditor->CAmountPaid =  $this->dollorValidate($row->camountpaid);
                            $creditor->	TotalBillFor = $this->dollorValidate($row->totalbillfor);
                            $creditor->AttyFees = $this->dollorValidate($row->attyfees);
                            $creditor->Fee1Type = $this->dollorValidate($row->fee1type);
                            $creditor->Fee1Balance = $this->dollorValidate($row->fee1balance);
                            $creditor->Fee1 = $this->dollorValidate($row->fee1);
                            $creditor->Fee2Type = $this->dollorValidate($row->fee2type);
                            $creditor->Fee2Balance = $this->dollorValidate($row->fee2balance);
                            $creditor->Fee2=$this->dollorValidate($row->fee2);
                            $creditor->Fee3Type = $this->dollorValidate($row->fee3type);
                            $creditor->Fee3Balance = $this->dollorValidate($row->fee3balance);
                            $creditor->Fee3=$this->dollorValidate($row->fee3);
                            $creditor->InvText =$row->invtext;
                            $creditor->InvLbl =$row->invlbl;
                            $creditor->LastUpdate=date('Y-m-d H:i:s');
                            $creditor->UserUpdated=Auth::user()->name;
                            $creditor->save();
                        }
                    }else{
                        return redirect('/ImportExport?msg=Invoice Columns Not Found');
                    }
                }

            } catch (\Exception $e) {
                dd($e);

            }
        }
        if($request->has('Creditor') && $request->has('CreditorContact')){
        try {
            $data = Excel::load(\Input::file('Creditor'))->get();
            foreach ($data as $key => $row) {
                    $isExist = tblcreditor::where('CreditorID','=',$row->creditorid)->first();
                if($isExist  ==null){

                    $creditor = new tblcreditor();
                   $creditor->CreditorID = $row->creditorid;
                   $creditor->SaleID = $row->salesid;
                   $creditor->OpenDate = date('Y-m-d', strtotime($row->opendate));
                   $creditor->Comments = $row->comments;
                   if($row->compreport == False) {
                       $creditor->CompReport = 0;
                   }
                   else{
                       $creditor->CompReport = 0;
                   }
                   $creditor->LastDate = date('Y-m-d', strtotime($row->lastdate));
                   $creditor->LastUpdate = date('Y-m-d H:i:s');
                   $creditor->UserUpdated = Auth::user()->name;
                   $creditor->save();
                }
            }

        } catch (\Exception $e) {dd($e);}

        try {

            $data = Excel::load(\Input::file('CreditorContact'))->get();
            foreach ($data as $key => $row) {

                $isExist = tblcontacts::where('ContactID','=',$row->contactid)
                    ->where('CreditorID','=',$row->creditorid)->first();
                if($isExist  ==null){
                    $contact = new tblcontacts();
                    $contact->CreditorID = $row->creditorid;
                    $contact->ContactID = $row->contactid;
                    $contact->ClientName = $row->clientname;
                    $contact->Saltnt = $row->saltnt;
                    $contact->CFirstName = $row->cfirstname;
                    $contact->CLastName = $row->clastname;
                    $contact->Street = $row->street;
                    $contact->City = $row->city;
                    $contact->Country = $row->country;
                    $contact->State = $row->state;
                    $contact->Zip = $row->zip;
                    $contact->Phone = $row->phone;
                    $contact->Ext = $row->ext;
                    $contact->Fax= $row->fax;
                    $contact->LastUpdate = date('Y-m-d H:i:s');;
                    $contact->UserUpdated = Auth::user()->name;
                    $contact->MainManager = 0;
                    if($row->mainmanager == True)
                    {
                        $contact->MainManager = 1;
                        tblcontacts::where('CreditorID','=', $row->creditorid)
                            ->update(array(
                                'MainManager' => 0,
                            ));
                    }

                    $contact->save();
                }
            }

        } catch (\Exception $e) {dd($e);}
        }
        if($request->has('Notes')){
            // process the form
            try {

                $data = Excel::load(\Input::file('Notes'))->get();
                foreach ($data as $key => $row) {

                    if($row->has('detail') == true && $row->has('debtorid') == true){

                            $note = new tblnote();
                            $note->Detail = str_replace('"', "''", $row->detail);
                            $note->User = $row->user;
                            $note->DebtorID = $row->debtorid;
                            $note->created_at =date('Y-m-d', strtotime($row->created_at));
                            $note->save();

                    }else{
                        return redirect('/ImportExport?msg=Payment Columns Not Found');
                    }
                }

            } catch (\Exception $e) {
                dd($e);

            }
        }

        return redirect('/ImportExport?msg=Import Succesfully');
    }


    public function Template(Request $request){
        $parms = tbltemplate::get();
        return view('accounting\Template\Template',['parms'=>$parms]);
    }
    public function AddTemplate(Request $request){
        $parms = tblparameter::get();
        return view('accounting\Template\AddTemplate',['parms'=>$parms]);
    }
    public function EditTemplate(Request $request){
        $template = tbltemplate::where('TemplateID','=',$request->TemplateID)->first();
        $parms = tblparameter::get();
        return view('accounting\Template\EditTemplate',['parms'=>$parms,'template'=>$template]);
    }
    public function SaveTemplate(Request $request){
        $newTemplate = new tbltemplate();
        $newTemplate->Name=$request ->Name;
        $newTemplate->Detail=$request ->TemplateData;
        $newTemplate->save();
        return response()->json(true);
    }
    public function UpdateTemplate(Request $request){
        $newTemplate = new tbltemplate();
        $newTemplate =tbltemplate::where('TemplateID','=',$request->TemplateID)
            ->update(array(
                'Name'=>$request ->Name,
                'Detail'=>$request ->TemplateData,
            ));
        return response()->json(true);
    }
    public function DelTemplate(Request $request){
        tbltemplate::where('TemplateID','=',$request->TemplateID)->delete();
        return redirect('/Template?msg=Template Successfully Deleted.');
    }
    public function PrintTemplate(Request $request){
       // $data=tbltemplate::fromView()->where('Debtors_DebtorID','=',$request->DebtorID)->value('Debtors_Street');

        $str=tbltemplate::where('TemplateID','=',$request->LetterType)->value('Detail');
        $html=$this->replaceValue($request->DebtorID,$str);
            if($request->Export == 'PDF'){

                $pdf= new Dompdf();
                $pdf->loadHtml($html);
                $pdf->render();
                $pdf->stream('C1.pdf');
                $this->saveDocGen(tbltemplate::where('TemplateID','=',$request->LetterType)->value('Name'),$request->DebtorID);
                return;
            }
        $this->saveDocGen(tbltemplate::where('TemplateID','=',$request->LetterType)->value('Name'),$request->DebtorID);
        return view('accounting\Template\PrintTemplate',['html'=>$html]);
    }
    public function saveDocGen($request,$DebtorID){
        $note = new tblnote();
        $note->Detail = 'Document Generated : '.$request;
        $note->User = Auth::user()->name;
        $note->DebtorID = $DebtorID;
        $note->save();
    }
    public function replaceValue($DebtorID,$str){

        $parms = tblparameter::get();
        foreach ($parms as $items) {
            if (strpos($str, '[['.$items->Name.']]') !== false) {

                if(substr( $items->Name, 0, 9 ) === "attorney_"){
                    $rpl = tbltemplate::FromViewAttorney()->where('attorney_DebtorID','=',$DebtorID)->value($items->Name);
                    $rpl_str='[['.$items->Name.']]';
                    $str=str_replace($rpl_str, $rpl, $str);
                }
               elseif(substr( $items->Name, 0, 8 ) === "Debtors_"){
                    $rpl = tblDebtor::where('DebtorID','=',$DebtorID)->value(substr( $items->Name,8));
                    $rpl_str='[['.$items->Name.']]';
                    $str=str_replace($rpl_str, $rpl, $str);
                }
                elseif(substr( $items->Name, 0, 9 ) === "Contacts_"){
                    $CID=tblDebtor::where('DebtorID','=',$DebtorID)->value('CreditorID');
                    $rpl = tblcontacts::where('CreditorID','=',$CID)->where('MainManager','=',1)->value(substr( $items->Name,9));
                    $rpl_str='[['.$items->Name.']]';
                    $str=str_replace($rpl_str, $rpl, $str);
                }
                elseif(substr( $items->Name, 0, 6 ) === "sales_"){
                    $CID=tblDebtor::where('DebtorID','=',$DebtorID)->value('CreditorID');
                    $SaleID=tblcreditor::where('CreditorID','=',$CID)->value('SaleID');
                    $rpl = tblsales::where('SalesID','=',$SaleID)->value(substr( $items->Name,6));
                    $rpl_str='[['.$items->Name.']]';
                    $str=str_replace($rpl_str, $rpl, $str);
                }
                elseif(substr( $items->Name, 0, 7 ) === "trusts_"){
                    $rpl = tblTrust::where('DebtorID','=',$DebtorID)->value(substr( $items->Name,7));
                    $rpl_str='[['.$items->Name.']]';
                    $str=str_replace($rpl_str, $rpl, $str);
                }
                elseif($items->Name == 'BalanceDue'){
                    $debtor = tblDebtor::where('DebtorID','=',$DebtorID)->first();
                    $PaidInv  = tblTrust::where('DebtorID','=',$DebtorID)
                        ->where('TPaymentType','=','C')
                        ->sum('PaymentReceived');
                    $PaidTrustNew1 = tblTrust::where('DebtorID','=',$DebtorID)
                        ->where('TPaymentType','=','T')
                        ->sum('PaymentReceived');
                    $PaidTrustNew2 = tblTrust::where('DebtorID','=',$DebtorID)
                        ->where('TPaymentType','=','T')
                        ->sum('AttyFees');
                    $PaidTrustNew=$PaidTrustNew1+$PaidTrustNew2;
                    $total=$debtor->AmountPlaced-$PaidInv-$PaidTrustNew;
                    $rpl_str='[['.$items->Name.']]';

                    $str=str_replace($rpl_str,'$'.number_format($total, 2, '.', ','), $str);
                }
                elseif(substr( $items->Name, 0, 10 ) === "Collector_"){
                    //ColID
                    if($items->Name =='Collector_Username'){
                        $ColID = tblDebtor::where('DebtorID','=',$DebtorID)->value('ColID');
                        $rpl_FirstName = tblcollector::where('ColID','=',$ColID)->value('CFirstName');
                        $rpl_LastName = tblcollector::where('ColID','=',$ColID)->value('CLastName');
                        $rpl=$rpl_FirstName . ' '. $rpl_LastName ;
                        $rpl_str='[['.$items->Name.']]';
                        $str=str_replace($rpl_str, $rpl, $str);
                    }
                }
                elseif($items->Name == 'CurrentDate'){
                    $rpl_str='[['.$items->Name.']]';
                    $str=str_replace($rpl_str, date('m-d-Y'), $str);
                }

            }
        }
        return $str;
    }

    public function dollorValidate($value){
        if($value == ''){
            $value='0';
        }

        if (0 === strpos($value, '(')) {
            $value=substr($value, 1, -1);
            if (0 === strpos($value, '$')) {
                $value=substr($value, 1);
            }
            $value=-round(str_replace(',', '', $value),2);
        }
        if (0 === strpos($value, '$')) {

            $value=substr($value, 1);
            $value=round(str_replace(',', '', $value),2);

        }else{
            $value=round(str_replace(',', '', $value),2);
        }

        return $value;
    }

    public function Rights(Request $request){
        $result = rolerightsfield::where('RoleID','=',Auth::user()->is_permission)
            ->where('ScreenName','=','Menu')
            ->where('FieldName','=','Rights')
            ->first();
        if($result == null){
            return redirect('/home?msg=Access denied.');
        }else{
            if(!$result->Active){
                return redirect('/home?msg=Access denied.');
            }
        }
        $Role = Role::get();
        return view('accounting\Rights\rights',['Role'=>$Role]);
    }
    public function SaveRights(Request $request){
        $result = rolerightsfield::where('RoleID','=',Auth::user()->is_permission)
            ->where('ScreenName','=','Menu')
            ->where('FieldName','=','Rights')
            ->first();
        if($result == null){
            return redirect('/home?msg=Access denied.');
        }else{
            if(!$result->Active){
                return redirect('/home?msg=Access denied.');
            }
        }
        $Role = Role::get();

        $validatedData = $request->validate([
            'GroupName' => 'required|max:191',
        ]);

        $Role = new Role();
        $Role->name = $request->GroupName;
        $Role->display_name = $request->GroupName;
        $Role->save();
        $rights = rightsfield::get();
        foreach ($rights as $sku){

            $rolerightsfield = new rolerightsfield();
            $rolerightsfield->RoleID=$Role->id;
            $rolerightsfield->RightsFieldID=$sku->ID;
            $rolerightsfield->Active=0;
            $rolerightsfield->ScreenName=$sku->ScreenName;
            $rolerightsfield->FieldName=$sku->FieldName;
            $rolerightsfield->Alies=$sku->Alies;
            $rolerightsfield->save();
        }

        return redirect('/Rights?msg=Group Successfully Saved.');
    }
    public function RightsFields(Request $request){
        $rights = rightsfield::get();
        //$f = Role::get();


        $str='SELECT *,case WHEN RF.RightsFieldID is null THEN 0 ELSE 1 end as \'Active\'  
          FROM `rightsfields` R LEFT join rolerightsfields RF on R.ID=RF.RightsFieldID
          where RF.RoleID ='.$request->RoleID;
        //$results= \DB::select($str);
        $results= rolerightsfield::where('RoleID','=',$request->RoleID)->get();
        return  response()->json($results);
    }
    
    public function checkRights($Arr,$ScreeName,$fieldName,$Value){
        //$trustActivity = tblTrust::where('TPaymentID','=',$Value->TPaymentID)->first();


        //$result = rolerightsfield::where('RoleID','=',Auth::user()->is_permission)
         //   ->where('RightsFieldID','=',3)->first();
        //dd(Auth::user()->is_permission);
        $result = rolerightsfield::where('RoleID','=',Auth::user()->is_permission)
            ->where('ScreenName','=',$ScreeName)
            ->where('FieldName','=',$fieldName)
            ->first();
if ($fieldName == 'CheckNumb'){
//dd($result);
}
        if ($result!=null){
            if ($result->Active){
                $Arr = array_add($Arr, $fieldName, $Value);
            }
        }else{
            $Arr = array_add($Arr, $fieldName, $Value);
        }
        return  $Arr;
    }

    public function updateRightsFields(Request $request){
        foreach ($request->RightsFields as $sku){

            $newTemplate = rolerightsfield::where('ID','=',$sku['ID'])
                ->where('RoleID','=',$sku['RoleID'])
                ->where('ScreenName','=',$sku['ScreenName'])
                ->where('FieldName','=',$sku['FieldName'])
                ->update(array(
                    'Active'=> $sku['Set'] === 'true'? true: false,
                ));

        }
        return response()->json(true);
    }

    public function RightsFieldsConfig(Request $request){
        $result = rolerightsfield::where('RoleID','=',Auth::user()->is_permission)
            ->where('ScreenName','=','Menu')
            ->where('FieldName','=','Rights')
            ->first();
        if($result == null){
            return redirect('/home?msg=Access denied.');
        }else{
            if(!$result->Active){
                return redirect('/home?msg=Access denied.');
            }
        }
        $result = rightsfield::where('ScreenName','=', $request->ScreenName)
            ->where('FieldName','=',$request->FieldName)
            ->first();
        if($result != null){
            return redirect('/Rights?msg=FieldName Already Exist.');
        }
        $Role = new rightsfield();
        $Role->ScreenName = $request->ScreenName;
        $Role->FieldName = $request->FieldName;
        $Role->Alies = $request->Alies;
        $Role->save();
        return redirect('/Rights?msg=FieldName Successfully Saved.');
    }



    public function users(Request $request){
        $result = rolerightsfield::where('RoleID','=',Auth::user()->is_permission)
            ->where('ScreenName','=','Menu')
            ->where('FieldName','=','Users')
            ->first();
        if($result == null){
            return redirect('/home?msg=Access denied.');
        }else{
            if(!$result->Active){
                return redirect('/home?msg=Access denied.');
            }
        }
        $creditor = null;

        if($request->searchUser == null) {
            //$User = User::paginate(5);

            $User = \DB::table('Roles')
                ->join('Users','Roles.ID','=','Users.is_permission')
                ->select('Users.*','Roles.name as groupName')
                ->paginate(5);
            // $creditor = new tblcreditor();
        }
        else{
            /* $clientInfo = tblcontacts::where(function($query){
                 $query->where('MainManager','=',true);
             })->where(function($query) use ($request){
                 $query->where('ClientName','like','%'.$request->searchCreditor.'%')
                 ->orWhere('CFirstName','like','%'.$request->searchCreditor.'%')
                 ->orWhere('CLastName','like','%'.$request->searchCreditor.'%')
                 ->orWhere('Street','like','%'.$request->searchCreditor.'%')
                 ->orWhere('State','like','%'.$request->searchCreditor.'%')
                 ->orWhere('City','like','%'.$request->searchCreditor.'%')
                 ->orWhere('Zip','like','%'.$request->searchCreditor.'%')
                     ->orWhere('CreditorID','like','%'.$request->searchCreditor.'%')
                 ->orWhere('Phone','like','%'.$request->searchCreditor.'%');})
                 ->select('CreditorID')
                 ->get();
             $filterData='';
             foreach($clientInfo as $ci)
             {
                 $filterData=$filterData.'\''.$ci->CreditorID.'\',';
             }
             $filterData=rtrim($filterData,", ");
             if($filterData == ''){
                 $creditor = tblcreditor::paginate(5);
             }else{*/
            $User = \DB::table('Roles')
                ->join('Users','Roles.ID','=','Users.is_permission')
                ->select('Users.*','Roles.name as groupName')
                ->where('Users.email','like','%' . $request->searchUser . '%')
                ->paginate(5);
           // $creditor= tblcreditor::where('CreditorID','like', '%' . $request->searchCreditor . '%')->paginate(5);
            // $creditor =DB::select('select * from tblcreditors where CreditorID in ('.$filterData.')')->toArray()->paginate(5);


            /*  $creditor = tblcreditor::
              where('CreditorID','like','%'.$request->searchCreditor.'%')
                  ->get();*/
        }

        return view('accounting\User\Users', ['user' => $User]);
    }
    public function addUser(){
        $result = rolerightsfield::where('RoleID','=',Auth::user()->is_permission)
            ->where('ScreenName','=','Menu')
            ->where('FieldName','=','Users')
            ->first();
        if($result == null){
            return redirect('/home?msg=Access denied.');
        }else{
            if(!$result->Active){
                return redirect('/home?msg=Access denied.');
            }
        }
        $Role = Role::get();
        return view('accounting\User\AddUser',['Role'=>$Role]);
    }
    public function saveUser(Request $request){

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'is_permission'=>'required',
        ]);
        $user = new User();
        $user->name= $request->name;
        $user->email= $request->email;
        $user->password=  bcrypt($request->password);
        $user->is_permission= (int)$request->is_permission;
        $user->save();
        return redirect('/Users?msg=User Successfully Saved.');
    }
    public function editUser(Request $request){
        $result = rolerightsfield::where('RoleID','=',Auth::user()->is_permission)
            ->where('ScreenName','=','Menu')
            ->where('FieldName','=','Users')
            ->first();
        if($result == null){
            return redirect('/home?msg=Access denied.');
        }else{
            if(!$result->Active){
                return redirect('/home?msg=Access denied.');
            }
        }
        if($request->updateUserID != null)
        {

                $validatedData = $request->validate([
                    'name' => 'required|string|max:255',
                    'is_permission'=>'required',
					'password' => 'string|min:6|confirmed',
                ]);
            $newCreditor = new User();
            $newCreditor->where('id','=',$request->updateUserID)
                ->update([
                    'name'=>$request->name,
                    'is_permission'=>$request->is_permission,
					'password'=>bcrypt($request->password),
                ]);
            return redirect('/Users?msg=User Successfully Updated.');
        }
        $user = User::where('id','=',$request->id)->first();
        $Role = Role::get();
        return view('accounting\User\EditUser', [
            'user'=>$user,
            'Role'=>$Role]);
    }
    public function deleteUser()
    {$result = rolerightsfield::where('RoleID','=',Auth::user()->is_permission)
        ->where('ScreenName','=','Menu')
        ->where('FieldName','=','Users')
        ->first();
        if($result == null){
            return redirect('/home?msg=Access denied.');
        }else{
            if(!$result->Active){
                return redirect('/home?msg=Access denied.');
            }
        }
        $products = \DB::table("Users")->get();
        return view('accounting\User\Users',compact('products'));
    }
    public function delUser(Request $request){
        $result = rolerightsfield::where('RoleID','=',Auth::user()->is_permission)
            ->where('ScreenName','=','Creditor')
            ->where('FieldName','=','DeleteCreditor')
            ->first();
        if($result == null){
            return redirect('/Creditor?msg=Access denied.');
        }else{
            if(!$result->Active){
                return redirect('/Creditor?msg=Access denied.');
            }
        }
        tblcreditor::where('creditorID','=',$request->creditorID)->delete();
        return redirect('/Creditor?msg=Creditor Successfully Deleted.');
    }

    public function saveUserCreditor(Request $request){

        $validatedData = $request->validate([
            'userid' => 'required|string|max:255',
            'CreditorID' => 'required|string|max:255',
        ]);
        $user = new usercreditormaps();
        $user->userid= $request->userid;
        $user->CreditorID= $request->CreditorID;
        $user->save();
        return response()->json(true);
    }
    public function GetUserCreditor(Request $request){
        return response()->json(\DB::table('userCreditorMaps')->Where('userid','=',$request->id)->get());
    }
	public function DeleteUserCreditor(Request $request){
		
        return response()->json(\DB::table('userCreditorMaps')->Where('userid','=',$request->id)->Where('CreditorID','=',$request->CreditorID)->delete());
    }
}


/*
 $creditor = new tblinvoice();
        $creditor->DebtorID = $request->DebtorID;
        $creditor->InvoiceNumb = tblinvoice::max('InvoiceNumb')+1;
        $creditor->IPaymentID = $request->TPaymentID;
        $creditor->IPaymentType = $request->IPaymentType;
        $creditor->	InvDate = date('Y-m-d H:i:s');
        $creditor->PaidDate = null;
        $creditor->CAmountPaid = null;
        $creditor->	TotalBillFor = $request->TotalBill;
        $creditor->AttyFees = $request->AttyDue;
        $creditor->Fee1Type = $request->Fee1Type;
        $creditor->Fee1Balance = $request->Fee1Balance;
        $creditor->Fee1 = $request->Fee1;
        $creditor->Fee2Type = $request->Fee2Type;
        $creditor->Fee2Balance = $request->Fee2Balance;
        $creditor->Fee2=$request->Fee2;
        $creditor->Fee3Type = $request->Fee3Type;
        $creditor->Fee3Balance = $request->Fee3Balance;
            //tblTrust::max('TPaymentID')+1;
        $creditor->Fee3=$request->Fee3;
        $creditor->InvText =$request->InvoiceText;
        $creditor->InvLbl =$request->InvoiceLabel;
        $creditor->LastUpdate=date('Y-m-d H:i:s');
        $creditor->UserUpdated=Auth::user()->name;
        $creditor->save();
*/