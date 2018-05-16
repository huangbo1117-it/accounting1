<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\accounting\tblDebtor;
use App\accounting\tblcontacts;
use Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this ->middleware('CheckGroup:Main');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->searchCreditor == null) {
            $debtor = null;
            $contacts=null;
        }else{
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
            $contacts = tblcontacts::
            where('CreditorID','=',$request->searchCreditor)
                ->orWhere('ContactID','like','%'.$request->searchCreditor.'%')
                ->orWhere('ClientName','like','%'.$request->searchCreditor.'%')
                ->orWhere('State','like','%'.$request->searchCreditor.'%')
                ->orWhere('Zip','like','%'.$request->searchCreditor.'%')
                ->orWhere('City','like','%'.$request->searchCreditor.'%')
                ->paginate(5);
        }
        return view('home',['debtor' => $debtor,'contacts' => $contacts]);

    }
    public function creditor(Request $request){
        if($request->page != null){
            if (  $request->searchCreditor==null   ){
                $request->searchCreditor=$request->session()->get('searchCreditor');
            }
        }
        //$request->session()->get('creditorID')
        $debtor=null;
        $contacts=null;
        if($request->searchCreditor != null) {
            session(['searchCreditor' => $request->searchCreditor]);
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
            $contacts = tblcontacts::
            where('CreditorID','=',$request->searchCreditor)
                ->orWhere('ContactID','like','%'.$request->searchCreditor.'%')
                ->orWhere('ClientName','like','%'.$request->searchCreditor.'%')
                ->orWhere('State','like','%'.$request->searchCreditor.'%')
                ->orWhere('Zip','like','%'.$request->searchCreditor.'%')
                ->orWhere('City','like','%'.$request->searchCreditor.'%')
                ->paginate(5);
        }



        return view('home',['debtor' => $debtor,'contacts' => $contacts]);
    }
}
