<?php
/**
 * Created by PhpStorm.
 * User: Ghazi
 * Date: 2/7/2018
 * Time: 12:23 PM
 */

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
use App\accounting\usercreditormaps;
use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Excel;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Array_;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this ->middleware('CheckGroup:Client');
    }
    public function ClientPortal(Request $request){
        //session(['creditorID' => $request->creditorID]);
        //$request->session()->get('creditorID')
        $Creditors = usercreditormaps::where('userid','=',Auth::user()->id)->get();
        return view('accounting\ClientPortal\ClientPortal',['Creditors' => $Creditors]);
    }
    public function globalSearch(Request $request){

            $debtor = tblDebtor::where(function ($query) use ($request){
                $query->where('CreditorID','=',$request->CreditorID);
            })->where(function($query) use ($request){
                $query->where('DebtorID','like','%'.$request->searchCreditor.'%')
                    ->orWhere('DebtorName','like','%'.$request->searchCreditor.'%')
                    ->orWhere('DFirstName','like','%'.$request->searchCreditor.'%')
                    ->orWhere('DLastName','like','%'.$request->searchCreditor.'%')
                    ->orWhere('ClientAcntNumber','like','%'.$request->searchCreditor.'%')
                    ->orWhere('Phone','like','%'.$request->searchCreditor.'%')
                    ->orWhere('State','like','%'.$request->searchCreditor.'%')
                    ->orWhere('City','like','%'.$request->searchCreditor.'%')
                    ->orWhere('Street','like','%'.$request->searchCreditor.'%')
                    ->orWhere('Zip','like','%'.$request->searchCreditor.'%');
            })->get();


        return response()->json($debtor);
    }

    public function loadProfile(Request $request){
        $creditor = tblDebtor::where('ID','=',$request->ID)->first();
        $Obj= new \stdClass();
        $Obj=$this->calculationDebit($request);
        $Obj->Debtor=$creditor;
        $Obj->StatusID = tblstatus::where('StatusID','=',$creditor->StatusID)->first();
        $Obj->payment  = $debtor = tblTrust::where('DebtorID','=',$creditor->DebtorID)->where('TPaymentType','=','T')->get();
        $Obj->invoice  = $invoices = tblTrust::where('DebtorID','=',$request->DebtorID)->where('TPaymentType','=','C')->get();
        $Obj->notes  = tblnote::where('DebtorID','=',$creditor->DebtorID)->get();
        return response()->json($Obj);
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
        return $Obj;
    }
    public  function TrustReports(Request $request)
    {
        $col = tblcollector::get();
        $saleman = tblsales::get();
        $Creditors = usercreditormaps::where('userid','=',Auth::user()->id)->get();
        return view('accounting\ClientPortal\TrustReports', ['col' => $col, 'saleman' => $saleman,'Creditors' => $Creditors]);
    }
    public  function showTrustReports(Request $request){
        $dt='';
        if($request->sDate != null){
            $dt=' AND DateRcvd BETWEEN "'.$request->sDate.'" and "'.$request->eDate.'" ';
        }
        $parms=$dt;
        If ($request->ReportType == 2) {
            $parms = $parms.' AND tblTrust.ColID='.$request->ColID;
        }
        If ($request->ReportType == 3) {
            $parms = $parms.' AND tblCreditor.SaleID='.$request->SalesID;
        }
        If ($request->ReportType == 4) {
            $parms = $dt .'   AND tblDebtors.ClientAcntNumber="'.$request->CreditorID.'"';
        }
        If ($request->ReportType == 5) {
            $parms = $dt.'  AND tblDebtors.DebtorID='.$request->DebtorID;
        }
        $str='SELECT tblCreditor.SaleID,tblDebtors.ClientAcntNumber, tblTrust.ColID, tblCreditor.CreditorID, tblDebtors.DebtorName, tblTrust.DebtorID, tblTrust.TPaymentID, tblTrust.TPaymentType, tblTrust.DateRcvd, tblTrust.CheckNumb, tblTrust.RelDate, tblTrust.ColID, 
ClastName & " " & CFirstName AS Collector,
COALESCE(AgencyGross,0)-COALESCE(AttyFees,0)+COALESCE(Intrest,0)+COALESCE(MiscFees,0) AS AgencyNet, 
Month(DateRcvd) AS MonthOfPmnt,
Year(DateRcvd) AS ThisYear, 
COALESCE(PaymentReceived,0)-COALESCE(MiscFees,0)+COALESCE(CostRef,0) AS NetClient
FROM tblCreditors tblCreditor LEFT JOIN ((tblTrusts tblTrust RIGHT JOIN tblDebtors ON tblTrust.DebtorID = tblDebtors.DebtorID) LEFT JOIN tblCollectors ON tblTrust.ColID = tblCollectors.ColID) ON tblCreditor.CreditorID = tblDebtors.CreditorID
WHERE tblTrust.TPaymentType="T" and tblCreditor.CreditorID ="'.$request->Creditor.'" '.$parms.'
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

    public  function InvoiceReports(Request $request){
        $col = tblcollector::get();
        $sales = tblsales::get();
        $Creditors = usercreditormaps::where('userid','=',Auth::user()->id)->get();
        return view('accounting\ClientPortal\InvoiceReports',['col'=>$col,'sales'=>$sales,'Creditors' => $Creditors]);
    }
    public  function showInvoiceReports(Request $request){
        $OpenInvoices=False;
        $StrFilter='';
        if($request->ReportType ==6){
            $StrFilter=' tblDebtors.ClientAcntNumber ="'.$request->CreditorID.'"';
            if($request->sDate != null && $request->eDate != null){
                $StrFilter =$StrFilter . " and InvDate >= '".$request->sDate."' And InvDate <= '".$request->eDate."'";
            }
        }
        if($request->ReportType ==7){
            $StrFilter=" tblDebtors.DebtorName like '%".$request->DebtorID."%' ";
            if($request->sDate != null && $request->eDate != null){
                $StrFilter =$StrFilter . " and InvDate >= '".$request->sDate."' And InvDate <= '".$request->eDate."'";
            }
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
COALESCE((case Fee1Type when \'%\'  then (Fee1Balance/100)*Fee1 ELSE Fee1 end) +
(case Fee2Type when Null  then 0 when \'%\' THEN (Fee2Balance/100)*Fee2 ELSE Fee2 end) +
(case Fee3Type when Null  then 0 when \'%\' THEN (Fee3Balance/100)*Fee3 ELSE Fee3 end) -
COALESCE(tblInvoice.AttyFees,0),0) AS DueInv
FROM ((tblCreditors tblCreditor
inner JOIN tblDebtors ON tblCreditor.CreditorID=tblDebtors.CreditorID)
inner JOIN tblTrusts tblTrust ON tblDebtors.DebtorID=tblTrust.DebtorID)
inner JOIN tblInvoices tblInvoice ON (tblTrust.TPaymentType=tblInvoice.IPaymentType) AND (tblTrust.TPaymentID=tblInvoice.IPaymentID)
WHERE  tblTrust.TPaymentType="C" and tblDebtors.CreditorID ="'.$request->Creditor.'" '.$StrFilter );
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

    public  function CreditorsSummary(Request $request){
        $Creditors = usercreditormaps::where('userid','=',Auth::user()->id)->get();
        return view('accounting\ClientPortal\StatusReports',['Creditors' => $Creditors]);
    }
    public  function ShowCreditorsSummary(Request $request){
        $filter='';

        if ($request->chkActiveOnly == 1){
            $filter=' WHERE tblCreditor.CreditorID="'.$request->Creditor.'" AND TD.StatusID Like "%Z%"';
        }else{
            $filter=' WHERE tblCreditor.CreditorID="'.$request->Creditor.'"';
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

}
