@extends('layouts.template')
@section('page-title')
Customer Information Update
@stop

@section('page-css')
<link rel="stylesheet" href="{{URL::to('/')}}/global/vendor/switchery/switchery.css">
<link rel="stylesheet" href="{{URL::to('/')}}/global/vendor/jquery-wizard/jquery-wizard.css">
<link rel="stylesheet" href="{{URL::to('/')}}/global/vendor/formvalidation/formValidation.css">
<style>
.acc-info-type {
    color: #017eff;
    padding: 10px 2px;
    border-radius: 3px;
}
</style>
@stop

@section('content')
<div class="page-header">
    <h1 class="page-title font_lato">Customer Information Update </h1>
    <div class="page-header-actions">
        <ol class="breadcrumb">
            <li><a href="{{URL::to('/dashboard')}}">{{ trans('app.home')}}</a></li>
            <li><a href="{{URL::to('/customer-list')}}">{{ trans('app.customer')}}</a></li>
            <li class="active">{{ $customer_data['fullname'] }}</li>
        </ol>
    </div>
</div>
<div class="page-content padding-20 container-fluid">
    <!------------------------start insert, update, delete message ---------------->
<!------------------------start insert, update, delete message ---------------->
    <div class="row">
    @if(session('msg_success'))
        <div class="alert dark alert-icon alert-success alert-dismissible alertDismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <i class="icon wb-check" aria-hidden="true"></i> 
        {{session('msg_success')}}
        </div>
    @endif
    @if(session('msg_update'))
        <div class="alert dark alert-icon alert-info alert-dismissible alertDismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <i class="icon wb-check" aria-hidden="true"></i> 
        {{session('msg_update')}}
        </div>
    @endif
    @if(session('msg_delete'))
        <div class="alert dark alert-icon alert-danger alert-dismissible alertDismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <i class="icon wb-check" aria-hidden="true"></i> 
        {{session('msg_delete')}}
        </div>
    @endif
    </div>
    <div class="col-md-12">
        <!-- Panel Wizard Form Container -->
        <div class="panel" id="exampleWizardFormContainer">
            <div class="clearfix"></div>
            <div class="panel-body">
                <!-- Steps -->
                <div class="pearls row">
                    <div class="pearl current col-xs-4">
                        <div class="pearl-icon"><i class="icon wb-user" aria-hidden="true"></i></div>
                        <span class="pearl-title">Personal Info</span>
                    </div>
                    <div class="pearl col-xs-4">
                        <div class="pearl-icon"><i class="icon wb-payment" aria-hidden="true"></i></div>
                        <span class="pearl-title">Nominee Info</span>
                    </div>
                    <div class="pearl col-xs-4">
                        <div class="pearl-icon"><i class="icon wb-check" aria-hidden="true"></i></div>
                        <span class="pearl-title">Confirmation</span>
                    </div>
                </div>
                <!-- End Steps -->
                <!-- Wizard Content -->
                <form action="{{ url('customer-edit', $customer_data['id']) }}" class="wizard-content" id="exampleFormContainer" method="POST" enctype="multipart/form-data">
                    
                    <div class="wizard-pane active" role="tabpanel">
                        <div class="text-center">
                            <h4 class="acc-info-type">Personal Information</h4>
                        </div>
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" id="inputUserNameOne" name="fullname" required="required" value="{{ $customer_data['fullname'] }}">
                                    <label class="control-label floating-label" for="inputUserNameOne">Full Name</label>
                                </div>
                                @php
                                    $gurdian_name = explode('-', $customer_data['fathername']);
                                @endphp
                                <div class="form-group">
                                    <div class="radio-custom radio-default radio-inline">
                                      <input type="radio" id="inputLabelFather" name="inputfatherorhus" {{ $gurdian_name[0] == 'F' ? 'checked' : '' }} value="1"/>
                                      <label for="inputLabelFather">Father</label>
                                    </div>
                                    <div class="radio-custom radio-default radio-inline">
                                      <input type="radio" id="inputLabelHus" name="inputfatherorhus" {{ $gurdian_name[0] == 'H' ? 'checked' : '' }} value="2"/>
                                      <label for="inputLabelHus">Husband</label>
                                    </div>
                                </div>
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" id="inputFatherNameOne" name="fathername" required="required" value="{{ $gurdian_name[1] }}">
                                    <label class="control-label floating-label" for="inputFatherNameOne">Father/Husband Name</label>
                                </div>
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" id="inputMotherNameOne" name="mothername" required="required" value="{{ $customer_data['mothername'] }}">
                                    <label class="control-label floating-label" for="inputMotherNameOne">Mother Name</label>
                                </div>
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" id="inpuPreAddresseOne" name="presentaddress" required="required" value="{{ $customer_data['presentaddress'] }}">
                                    <label class="control-label floating-label" for="inputPreAddressOne">Present Address</label>
                                </div>
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" id="inputPerAddressOne" name="permanentaddress" required="required" value="{{ $customer_data['permanentaddress'] }}">
                                    <label class="control-label floating-label" for="inputPerAddressOne">Permanent Address</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" id="inputOccupationOne" name="occupation" required="required" value="{{ $customer_data['occupation'] }}">
                                    <label class="control-label floating-label" for="inputOccupationOne">Occupation</label>
                                </div>
                                <p style="visibility:hidden;margin-bottom: 23px">hello</p>
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" id="inputNationalityOne" name="nationality" required="required" value="{{ $customer_data['nationality'] }}">
                                    <label class="control-label floating-label" for="inputNationalityOne">Nationality</label>
                                </div>
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" id="inputNidNoOne" name="nidno" required="required" value="{{ $customer_data['nidno'] }}">
                                    <label class="control-label floating-label" for="inputNidNoOne">NID No</label>
                                </div>
                                <div class="form-group form-material floating">
                                    <input type="number" class="form-control" id="inputAgeOne" name="age" required="required" value="{{ $customer_data['age'] }}">
                                    <label class="control-label floating-label" for="inputAgeOne">Age</label>
                                </div>
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" id="inputMobileOne" name="mobile" required="required" value="{{ $customer_data['mobile'] }}">
                                    <label class="control-label floating-label" for="inputMobileOne">Mobile</label>
                                </div>
                            </div>
                        </div>
                        {{-- Introducer --}}
                        <div class="text-center">
                            <h4 class="acc-info-type">Introducer Information</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" id="inputIntroducerNameOne" name="introducername" required="required" value="{{ $customer_data['introducername'] }}">
                                    <label class="control-label floating-label" for="inputIntroducerNameOne">Introducer Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" id="inputIntroducerAddressOne" name="introducerpermanentaddress" required="required" value="{{ $customer_data['introducerpermanentaddress'] }}">
                                    <label class="control-label floating-label" for="inputIntroducerAddressOne">Introducer Address</label>
                                </div>
                            </div>
                        </div>
                        {{-- Introducer END --}}
                    </div>
                    <div class="wizard-pane" id="exampleBillingOne" role="tabpanel">
                        {{-- Nominee --}}
                        <div class="text-center">
                            <h4 class="acc-info-type">Nominee Information</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" id="inputNomNameOne" name="nomname" required="required" value="{{ $customer_data['nomname'] }}">
                                    <label class="control-label floating-label" for="inputNomNameOne">Full Name</label>
                                </div>
                                @php
                                    $nom_gurdian_name = explode('-', $customer_data['nomfathername']);
                                @endphp
                                <div class="form-group">
                                    <div class="radio-custom radio-default radio-inline">
                                      <input type="radio" id="nomLabelFather" name="nomfatherorhus" {{ $nom_gurdian_name[0] == 'F' ? 'checked' : '' }} value="1" value="{{ $customer_data['fullname'] }}"/>
                                      <label for="nomLabelFather">Father</label>
                                    </div>
                                    <div class="radio-custom radio-default radio-inline">
                                      <input type="radio" id="nomLabelHus" name="nomfatherorhus" {{ $nom_gurdian_name[0] == 'H' ? 'checked' : '' }} value="2"/>
                                      <label for="nomLabelHus">Husband</label>
                                    </div>
                                </div>
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" id="inputNomFatherNameOne" name="nomfathername" required="required" value="{{ $nom_gurdian_name[1] }}">
                                    <label class="control-label floating-label" for="inputNomFatherNameOne">Father/Husband Name</label>
                                </div>
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" id="inputNomMotherNameOne" name="nommothername" required="required" value="{{ $customer_data['nommothername'] }}">
                                    <label class="control-label floating-label" for="inputNomMotherNameOne">Mother Name</label>
                                </div>
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" id="inpuNomPreAddresseOne" name="nompresentaddress" required="required" value="{{ $customer_data['nompresentaddress'] }}">
                                    <label class="control-label floating-label" for="inputNomPreAddressOne">Present Address</label>
                                </div>
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" id="inputNomPerAddressOne" name="nompermanentaddress" required="required" value="{{ $customer_data['nompermanentaddress'] }}">
                                    <label class="control-label floating-label" for="inputNomPerAddressOne">Permanent Address</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" id="inputNomOccupationOne" name="nomoccupation" required="required" value="{{ $customer_data['nomoccupation'] }}">
                                    <label class="control-label floating-label" for="inputNomOccupationOne">Occupation</label>
                                </div>
                                <p style="visibility:hidden;margin-bottom: 23px">hello</p>
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" id="inputRelationshipOne" name="relationship" required="required" value="{{ $customer_data['relationship'] }}">
                                    <label class="control-label floating-label" for="inputRelationshipOne">Relationship</label>
                                </div>
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" id="inputNomNidNoOne" name="nomnidno" required="required" value="{{ $customer_data['nomnidno'] }}">
                                    <label class="control-label floating-label" for="inputNomNidNoOne">NID No</label>
                                </div>
                                <div class="form-group form-material floating">
                                    <input type="number" class="form-control" id="inputNomAgeOne" name="nomage" required="required" value="{{ $customer_data['nomage'] }}">
                                    <label class="control-label floating-label" for="inputNomAgeOne">Age</label>
                                </div>
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" id="inputNomMobileOne" name="nommobile" required="required" value="{{ $customer_data['nommobile'] }}">
                                    <label class="control-label floating-label" for="inputNomMobileOne">Mobile</label>
                                </div>
                            </div>
                        </div>
                        {{-- Nominee END --}}
                    </div>
                    <div class="wizard-pane" id="exampleGettingOne" role="tabpanel">
                        <div class="text-center margin-vertical-20">
                            <h4>Please confrim your submission.</h4>
                        </div>
                    </div>
                </form>
                <!-- Wizard Content -->
            </div>
        </div>
        <!-- End Panel Wizard Form Container -->
    </div>

</div>

@stop

@section('page-js')
<script>
    function submitRegistration() {
        document.getElementById("exampleFormContainer").submit();
    }

    $('.datepicker').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayBtn: true,
        todayHighlight: true
    });
</script>

@stop