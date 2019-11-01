@extends('layouts.template')
@section('page-title')
New Account Application
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
            <div class="panel-heading">
                <h3 class="panel-title">Account Registration</h3>
            </div>
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
                <form action="{{ url('customer-registration') }}" class="wizard-content" id="exampleFormContainer" method="POST" enctype="multipart/form-data">
                    
                    <div class="wizard-pane active" role="tabpanel">
                        <div class="text-center">
                            <h4 class="acc-info-type">Personal Information</h4>
                        </div>
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" id="inputUserNameOne" name="fullname" required="required">
                                    <label class="control-label floating-label" for="inputUserNameOne">Full Name <span class="field-required ">*</span></label>
                                </div>
                                <div class="form-group">
                                    <div class="radio-custom radio-default radio-inline">
                                      <input type="radio" id="inputLabelFather" name="inputfatherorhus" checked value="1"/>
                                      <label for="inputLabelFather">Father</label>
                                    </div>
                                    <div class="radio-custom radio-default radio-inline">
                                      <input type="radio" id="inputLabelHus" name="inputfatherorhus" value="2"/>
                                      <label for="inputLabelHus">Husband</label>
                                    </div>
                                </div>
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" id="inputFatherNameOne" name="fathername" required="required">
                                    <label class="control-label floating-label" for="inputFatherNameOne">Father/Husband Name <span class="field-required ">*</span></label>
                                </div>
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" id="inputMotherNameOne" name="mothername" required="required">
                                    <label class="control-label floating-label" for="inputMotherNameOne">Mother Name <span class="field-required ">*</span></label>
                                </div>
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" id="inpuPreAddresseOne" name="presentaddress" required="required">
                                    <label class="control-label floating-label" for="inputPreAddressOne">Present Address <span class="field-required ">*</span></label>
                                </div>
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" id="inputPerAddressOne" name="permanentaddress" required="required">
                                    <label class="control-label floating-label" for="inputPerAddressOne">Permanent Address <span class="field-required ">*</span></label>
                                </div>
                                <div class="form-group">
                                    <label style="color:#76838f" for="imgUpload">Picture Upload <span class="field-required ">*</span></label>
                                    <div class="input-group input-group-file">
                                        <input type="text" class="form-control" id="imgUpload" readonly="">
                                        <span class="input-group-btn">
                                        <span class="btn btn-success btn-file">
                                            <i class="icon wb-upload" aria-hidden="true"></i>
                                            <input type="file" name="logo">
                                        </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" id="inputOccupationOne" name="occupation" required="required">
                                    <label class="control-label floating-label" for="inputOccupationOne">Occupation <span class="field-required ">*</span></label>
                                </div>
                                <p style="visibility:hidden;margin-bottom: 23px">hello</p>
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" id="inputNationalityOne" name="nationality" required="required">
                                    <label class="control-label floating-label" for="inputNationalityOne">Nationality <span class="field-required ">*</span></label>
                                </div>
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" id="inputNidNoOne" name="nidno">
                                    <label class="control-label floating-label" for="inputNidNoOne">NID No</label>
                                </div>
                                <div class="form-group form-material floating">
                                    <input type="number" class="form-control" id="inputAgeOne" name="age" required="required">
                                    <label class="control-label floating-label" for="inputAgeOne">Age <span class="field-required ">*</span></label>
                                </div>
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" id="inputMobileOne" name="mobile" required="required">
                                    <label class="control-label floating-label" for="inputMobileOne">Mobile <span class="field-required ">*</span></label>
                                </div>
                                <div class="form-group">
                                    <label style="color:#76838f" for="signaturepic">Signature Upload <span class="field-required ">*</span></label>
                                    <div class="input-group input-group-file">
                                        <input type="text" class="form-control" id="signaturepic" readonly="">
                                        <span class="input-group-btn">
                                        <span class="btn btn-success btn-file">
                                            <i class="icon wb-upload" aria-hidden="true"></i>
                                            <input type="file" name="signaturepic">
                                        </span>
                                        </span>
                                    </div>
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
                                    <input type="text" class="form-control" id="inputIntroducerNameOne" name="introducername">
                                    <label class="control-label floating-label" for="inputIntroducerNameOne">Introducer Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" id="inputIntroducerAddressOne" name="introducerpermanentaddress">
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
                                    <input type="text" class="form-control" id="inputNomNameOne" name="nomname" required="required">
                                    <label class="control-label floating-label" for="inputNomNameOne">Full Name <span class="field-required ">*</span></label>
                                </div>
                                <div class="form-group">
                                    <div class="radio-custom radio-default radio-inline">
                                      <input type="radio" id="nomLabelFather" name="nomfatherorhus" checked value="1"/>
                                      <label for="nomLabelFather">Father</label>
                                    </div>
                                    <div class="radio-custom radio-default radio-inline">
                                      <input type="radio" id="nomLabelHus" name="nomfatherorhus" value="2"/>
                                      <label for="nomLabelHus">Husband</label>
                                    </div>
                                </div>
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" id="inputNomFatherNameOne" name="nomfathername" required="required">
                                    <label class="control-label floating-label" for="inputNomFatherNameOne">Father/Husband Name <span class="field-required ">*</span></label>
                                </div>
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" id="inputNomMotherNameOne" name="nommothername" required="required">
                                    <label class="control-label floating-label" for="inputNomMotherNameOne">Mother Name <span class="field-required ">*</span></label>
                                </div>
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" id="inpuNomPreAddresseOne" name="nompresentaddress" required="required">
                                    <label class="control-label floating-label" for="inputNomPreAddressOne">Present Address <span class="field-required ">*</span></label>
                                </div>
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" id="inputNomPerAddressOne" name="nompermanentaddress" required="required">
                                    <label class="control-label floating-label" for="inputNomPerAddressOne">Permanent Address <span class="field-required ">*</span></label>
                                </div>
                                <div class="form-group">
                                    <label style="color:#76838f" for="nompic">Nominee Picture <span class="field-required ">*</span></label>
                                    <div class="input-group input-group-file">
                                        <input type="text" class="form-control" id="nompic" readonly="">
                                        <span class="input-group-btn">
                                        <span class="btn btn-success btn-file">
                                            <i class="icon wb-upload" aria-hidden="true"></i>
                                            <input type="file" name="nompic">
                                        </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" id="inputNomOccupationOne" name="nomoccupation" required="required">
                                    <label class="control-label floating-label" for="inputNomOccupationOne">Occupation <span class="field-required ">*</span></label>
                                </div>
                                <p style="visibility:hidden;margin-bottom: 23px">hello</p>
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" id="inputRelationshipOne" name="relationship" required="required">
                                    <label class="control-label floating-label" for="inputRelationshipOne">Relationship <span class="field-required ">*</span></label>
                                </div>
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" id="inputNomNidNoOne" name="nomnidno">
                                    <label class="control-label floating-label" for="inputNomNidNoOne">NID No</label>
                                </div>
                                <div class="form-group form-material floating">
                                    <input type="number" class="form-control" id="inputNomAgeOne" name="nomage" required="required">
                                    <label class="control-label floating-label" for="inputNomAgeOne">Age <span class="field-required ">*</span></label>
                                </div>
                                <div class="form-group form-material floating">
                                    <input type="text" class="form-control" id="inputNomMobileOne" name="nommobile" required="required">
                                    <label class="control-label floating-label" for="inputNomMobileOne">Mobile <span class="field-required ">*</span></label>
                                </div>
                                <div class="form-group">
                                    <label style="color:#76838f" for="nomsignature">Nominee Signature <span class="field-required ">*</span></label>
                                    <div class="input-group input-group-file">
                                        <input type="text" class="form-control" id="nomsignature" readonly="">
                                        <span class="input-group-btn">
                                        <span class="btn btn-success btn-file">
                                            <i class="icon wb-upload" aria-hidden="true"></i>
                                            <input type="file" name="nomsignature">
                                        </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Nominee END --}}
                    </div>
                    <div class="wizard-pane" id="exampleGettingOne" role="tabpanel">
                        <div class="text-center margin-vertical-20">
                            <h4>Please confrim your Registration.</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-material floating">
                                        <input type="text" class="form-control" id="accountNo" name="accountNo" required="required">
                                        <label class="control-label floating-label" for="accountNo">Account No <span class="field-required ">*</span></label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <div class="input-group input-group-icon form-material floating">
                                        <input type="text" class="form-control datepicker" id="opening_date" name="opening_date" autocomplete="off" >
                                        <label class="control-label floating-label" for="opening_date">Opening Date <span class="field-required ">*</span></label>
                                        <span class="input-group-addon">
                                            <span class="icon fa fa-calendar" aria-hidden="true"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="input-group input-group-icon form-material floating">
                                        <input type="text" class="form-control round" id="balance" name="balance" value="" autocomplete="off" />
                                        <label class="control-label floating-label" for="balance">Opening Balance <span class="field-required ">*</span></label>
                                        <span class="input-group-addon">
                                            <span>৳</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
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