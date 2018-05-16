@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="/Debtor">Debtor</a></li>
            <li class="breadcrumb-item active"><a href="/TrustAccount/{{$debtors[0]->DebtorID}}">Trust Account</a> </li>
        </ol>
        <h1>Add Trust Activity</h1>

        <form name="form" method="post">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="creditorID">Debtor:</label>
                        <select class="form-control" name="DebtorID" required>
                            @foreach($debtors as $d)
                                <option value="{{$d->DebtorID}}">{{$d->DebtorName}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="creditorID">Collector's Name:</label>

                        <select class="form-control" name="colID" required>
                            @foreach($col as $s)
                                <option value="{{$s->ColID}}" @if($s->ColID == $debtors[0]->ColID) selected @endif>{{$s->CLastName}}  {{$s->CFirstName}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Date Received:</label>
                        <input type="date" class="form-control" id="datee" name="dateReceived" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Check No:</label>
                        <input type="text" class="form-control" name="checkNo" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Payment Received:</label>
                        <input type="text" class="form-control" name="paymentReceived"  id="paymentReceived"  onchange="calculate()" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Release Date:</label>
                        <!--<input type="date" class="form-control" name="" required>-->
                        <input type="text" name="releaseDate" class="form-control" id="date"  size="12" />
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="creditorID">Intrest:</label>
                        <input type="text" class="form-control" name="Intrest" value="0" onchange="calculate()" >
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="creditorID">Attorney Fee:</label>
                        <input type="text" class="form-control" name="AttorneyFee" value="0" onchange="calculate()" >
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="creditorID">Misc Fee:</label>
                        <input type="text" class="form-control" name="MiscFee"  value="0" onchange="calculate()" >
                    </div>
                </div>




                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Cost Ref:</label>
                        <input type="text" class="form-control" name="CostRef"  value="0"  onchange="calculate()" >
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="creditorID">Agency Gross:</label>
                        <input type="text" class="form-control" name="AgencyGross" value="0" id="AgencyGross"  onchange="calculate()" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="creditorID">Net Client:</label>
                        <input type="text" class="form-control" name="NetClient"  value="0" id="NetClient" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="creditorID">Agency Net:</label>
                        <input type="text" class="form-control" name="AgencyNet"  value="0" id="AgencyNet" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="creditorID">Gross:</label>
                        <input type="text" class="form-control" name="Gross" value="0" id="Gross" required>
                    </div>
                </div>
            </div>


            <br><br>
            <div class="form-group">
                <input type="submit" class="form-control btn btn-primary" value="Save">
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script>
        $(function(){
            //$('#paymentReceived').val(0);
            $('#AgencyGross').val(0);
            $('#NetClient').val(0);
            $('#AgencyNet').val(0);
            $('#Gross').val(0);
           // calculate();
            var now = new Date();
            var numberOfDaysToAdd = -1;
            now.setDate(now.getDate() + numberOfDaysToAdd);

            var day = ("0" + now.getDate()).slice(-2);
            var month = ("0" + (now.getMonth() + 1)).slice(-2);
            var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
            $('input[type=date]').val(today);

            var w1=new Date(today);
            w1.setDate(w1.getDate() + 7);
            if(w1.getDay() == 0){
                w1.setDate(w1.getDate() + 1);
            }
            if(w1.getDay() == 7){
                w1.setDate(w1.getDate() + 2);
            }
            var w2=new Date(w1);
            w2.setDate(w2.getDate() + 7);
            if(w2.getDay() == 0){
                w2.setDate(w2.getDate() + 1);
            }
            if(w2.getDay() == 7){
                w2.setDate(w2.getDate() + 2);
            }
            var w3=new Date(w2);
            w3.setDate(w3.getDate() + 7);
            if(w3.getDay() == 0){
                w3.setDate(w3.getDate() + 1);
            }
            if(w3.getDay() == 7){
                w3.setDate(w3.getDate() + 2);
            }
            var weak1=new Date(w1);
            var weak2=new Date(w2);
            var weak3=new Date(w3);
            var availableDates = [""+("0" + weak1.getDate()).slice(-2)+"-"+ ("0" + (weak1.getMonth() + 1)).slice(-2) +"-"+weak1.getFullYear()+"",""+("0" + weak2.getDate()).slice(-2)+"-"+ ("0" + (weak2.getMonth() + 1)).slice(-2) +"-"+weak2.getFullYear()+"",""+("0" + weak3.getDate()).slice(-2)+"-"+ ("0" + (weak3.getMonth() + 1)).slice(-2) +"-"+weak3.getFullYear()+""];
            console.log(availableDates);
            function available(date) {
                dmy = date.getDate() + "-" + (date.getMonth()+1) + "-" + date.getFullYear();
                if ($.inArray(dmy, availableDates) != -1) {
                    return [true, "","Available"];
                } else {
                    return [false,"","unAvailable"];
                }
            }
            $('#datee').change(function() {

                    var date = new Date($(this).val());
                    var day = ("0" + date.getDate()).slice(-2);
                    var month = ("0" + (date.getMonth() + 1)).slice(-2);
                    var today = date.getFullYear()+"-"+(month)+"-"+(day) ;

                    var w1=new Date(today);
                    w1.setDate(w1.getDate() + 7);
                    if(w1.getDay() == 0){
                        w1.setDate(w1.getDate() + 1);
                    }
                    if(w1.getDay() == 7){
                        w1.setDate(w1.getDate() + 2);
                    }
                    var w2=new Date(w1);
                    w2.setDate(w2.getDate() + 7);
                    if(w2.getDay() == 0){
                        w2.setDate(w2.getDate() + 1);
                    }
                    if(w2.getDay() == 7){
                        w2.setDate(w2.getDate() + 2);
                    }
                    var w3=new Date(w2);
                    w3.setDate(w3.getDate() + 7);
                    if(w3.getDay() == 0){
                        w3.setDate(w3.getDate() + 1);
                    }
                    if(w3.getDay() == 7){
                        w3.setDate(w3.getDate() + 2);
                    }
                    weak1=new Date(w1);
                    weak2=new Date(w2);
                    weak3=new Date(w3);

            });
            $('#date').datepicker({
                beforeShowDay: function(date){
                    var month = date.getMonth()+1;
                    var year = date.getFullYear();
                    var day = date.getDay();

                    if (date.getDate() == weak1.getDate() && date.getMonth() == weak1.getMonth()){
                        return [true];
                    }else if (date.getDate() == weak2.getDate() && date.getMonth() == weak2.getMonth()){
                        return [true];
                    }
                    else if (date.getDate() == weak3.getDate() && date.getMonth() == weak3.getMonth()){
                        return [true];
                    }
                    else{
                        return [false];
                    }
                    // Change format of date
               ///     var newdate = day+"-"+month+'-'+year;

                    // Set tooltip text when mouse over date
                  //  var tooltip_text = "New event on " + newdate;

                    // Check date in Array
                 //   if(jQuery.inArray(newdate, availableDates) != -1){
                 //       return [true, "highlight", tooltip_text ];
                 //   }
                 //   return [true];
                },
                onSelect: function(date) {

                    var day = ("0" + date.getDate()).slice(-2);
                    var month = ("0" + (date.getMonth() + 1)).slice(-2);
                    var today = date.getFullYear()+"-"+(month)+"-"+(day) ;

                    var w1=new Date(today);
                    w1.setDate(w1.getDate() + 7);
                    if(w1.getDay() == 0){
                        w1.setDate(w1.getDate() + 1);
                    }
                    if(w1.getDay() == 7){
                        w1.setDate(w1.getDate() + 2);
                    }
                    var w2=new Date(w1);
                    w2.setDate(w2.getDate() + 7);
                    if(w2.getDay() == 0){
                        w2.setDate(w2.getDate() + 1);
                    }
                    if(w2.getDay() == 7){
                        w2.setDate(w2.getDate() + 2);
                    }
                    var w3=new Date(w2);
                    w3.setDate(w3.getDate() + 7);
                    if(w3.getDay() == 0){
                        w3.setDate(w3.getDate() + 1);
                    }
                    if(w3.getDay() == 7){
                        w3.setDate(w3.getDate() + 2);
                    }
                     weak1=new Date(w1);
                     weak2=new Date(w2);
                    weak3=new Date(w3);
                }
            });
        });
        function calculate(){
            var AttorneyFee=$('input[name=AttorneyFee]').val();
            if(AttorneyFee ==0 ||  AttorneyFee == ''){
                AttorneyFee=0;
                $('input[name=AttorneyFee]').val(0)
            }
            var Intrest=$('input[name=Intrest]').val();
            if(Intrest ==0 ||  Intrest == ''){
                Intrest=0;
                $('input[name=Intrest]').val(0)
            }
            var MiscFee=$('input[name=MiscFee]').val();
            if(MiscFee ==0 ||  MiscFee == ''){
                MiscFee=0;
                $('input[name=MiscFee]').val(0)
            }
            var CostRef=$('input[name=CostRef]').val();
            if(CostRef ==0 ||  CostRef == ''){
                CostRef=0;
                $('input[name=CostRef]').val(0)
            }
            var AgencyGross=$('input[name=AgencyGross]').val();
            if(AgencyGross ==0 ||  AgencyGross == ''){
                AgencyGross=0;
                $('input[name=AgencyGross]').val(0)
            }

            var paymentReceived=$('#paymentReceived').val();
            var GrossValue=parseFloat(paymentReceived)+parseFloat(AttorneyFee);
            $('#Gross').val(GrossValue.toFixed(2))
            var AgencyNet=0;

            var NetClint=0;
            var aa=$('input[name=dateReceived]').val();
            if(aa <'05-29-2000'){
                var TempPaymentrec=parseFloat(paymentReceived)-parseFloat(AttorneyFee);
                $('#paymentReceived').val(TempPaymentrec);
                NetClint= parseFloat(paymentReceived) - parseFloat(MiscFee) - parseFloat(AgencyGross) + parseFloat(CostRef);
                AgencyNet=parseFloat(Intrest) - parseFloat(AttorneyFee) + parseFloat(MiscFee) + parseFloat(AgencyGross);
                var Gross=0;
                Gross = parseFloat(paymentReceived) + parseFloat(AttorneyFee);
                $('#AgencyNet').val(parseFloat(AgencyNet).toFixed(2));
                $('#Gross').val(parseFloat(Gross).toFixed(2))
            }else{
                NetClint = parseFloat(GrossValue) - parseFloat(MiscFee) + parseFloat(CostRef) - parseFloat(AgencyGross);
                AgencyNet =parseFloat(AgencyGross) - parseFloat(AttorneyFee) + parseFloat(Intrest) + parseFloat(MiscFee);
                $('#NetClient').val(parseFloat(NetClint).toFixed(2));
                $('#AgencyNet').val(parseFloat(AgencyNet).toFixed(2));
            }
        }
    </script>

@endsection

