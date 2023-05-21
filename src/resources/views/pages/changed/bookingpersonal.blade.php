@extends('layouts.master')

@section('content')
<div class="container">

    <?php
    $searchparams = json_decode($sSearchparams);
    $itivalues = json_decode($sItivalues);
    ?>

    <div class="error">
        <!-- Display Validation Errors -->
        @include('common.errors')
    </div>

    <form name="frm_personal" action="{{ url('/booking/personal') }}" method="POST">

        {{ csrf_field() }}
        {{ method_field('POST') }}
        <input name="_personal" type="hidden" value="true"/>
        <input name="itivalues" type="hidden" value="{{$sItivalues}}"/>
        <input name="searchparams" type="hidden" value="{{$sSearchparams}}"/>

        <div class="row gutter_top_10px"></div>
        <div class="col-md-8 gutter_10px bookingconfirm">
            <div class="panel panel-primary">
                <div class="panel-heading">Your Details</div>
            </div>
            <div class="panel panel-body">

                <div class="form-group col-lg-2 col-md-2 col-sm-4 col-xs-6" >
                    <label>Title <span class="text-danger">*</span> </label>
                    <select class="form-control" data-val="true" data-val-required="Missing title" id="ddlTitle1" name="title" onchange="ValidateGender(this, true)"><option value="">-- Select --</option>
                        <option value="Mr">Mr</option>
                        <option value="Mrs">Mrs</option>
                        <option value="Miss">Miss</option>
                        <option value="Dr">Dr</option>
                        <option value="Rev">Rev</option>
                    </select>
                    <input id="hdnPaxType1" name="passengerType" type="hidden" value="adult" />
                    <span class="field-validation-valid" data-valmsg-for="title" data-valmsg-replace="true"></span>

                </div>
                <div class="form-group col-lg-5 col-md-5 col-sm-12 col-xs-12" >
                    <label>First Name <span style="font-size:0.7em;font-weight:normal;">(along with middle name(s) if any)</span><span class="text-danger">*</span> </label>
                    <input autocomplete="off" class="form-control" data-val="true" data-val-length="FirstName should be minimum of 2 and maximum of 20 Characters" data-val-length-max="20" data-val-length-min="2" data-val-regex="Only Alphabets are allowed in FirstName" data-val-regex-pattern="^([a-zA-Z ]+)$" data-val-required="Missing firstName" id="txtFirstName1" maxlength="20" name="firstName" onchange="textboxvalidate(this, & #39; first name & #39; );" onkeyup="fnValidCharactor(this, 4);" placeholder="First Name" type="text" value="" />
                    <span class="field-validation-valid" data-valmsg-for="firstName" data-valmsg-replace="true"></span>
                </div>

                <div class="form-group col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <label>Last name<span class="text-danger">*</span> </label>
                    <input autocomplete="off" class="form-control" data-val="true" data-val-length="LastName should be minimum of 2 and maximum of 20 Characters" data-val-length-max="20" data-val-length-min="2" data-val-regex="Only Alphabets are allowed in LastName" data-val-regex-pattern="^([a-zA-Z ]+)$" data-val-required="Missing LastName" id="txtLastName1" maxlength="20" name="lastName" onchange="textboxvalidate(this, & #39; last name & #39; );" onkeyup="fnValidCharactor(this, 4);" placeholder="Last name" type="text" value="" />
                    <span class="field-validation-valid" data-valmsg-for="lastName" data-valmsg-replace="true"></span>
                </div>

                <p class="col-lg-12 col-xs-12"><small>Note : If you have a Middle name on the passport please add the same with the First Name using space. Eg : First Name Middle Name</small></p>

                <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    <label>Gender<span class="text-danger">*</span> </label>
                    <select class="form-control ddlReadOnly" data-val="true" data-val-required="Missing gender" id="ddlGender1" name="gender"><option value="">-- Select --</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                    <span class="field-validation-valid" data-valmsg-for="gender" data-valmsg-replace="true"></span>
                </div>
                <div class="form-group pos-r col-lg-4 col-md-4 col-sm-6 col-xs-12 calander-icon">
                    <label>DOB<span class="text-danger">*</span> </label>
                    <input class="form-control" data-val="true" data-val-regex="Check DateOfBirth Format"
                           data-val-regex-pattern="(0[1-9]|[12][0-9]|3[01])\-(0[1-9]|1[012])\-(18|19|20)\d\d" data-val-required="Missing DateOfBirth" id="depart_date"
                           name="dateOfBirth" placeholder="yyyy-mm-dd" type="text" value="" />
                    <span class="field-validation-valid" data-valmsg-for="dateOfBirth" data-valmsg-replace="true"></span>
                </div>
            </div>
            <div class="clearfix"></div>
            <div>
                <div class="panel panel-primary">
                    <div class="panel-heading">Booking Confirmation</div>
                </div>
                <p class="sub-text">Your Booking Confirmation will be sent to the Email Address you enter below. </p>

                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label>Email<span class="text-danger">*</span> </label>
                    <input autocomplete="off" class="form-control" data-val="true" data-val-length="Email should be minimum of 5 and maximum of 75 Characters" data-val-length-max="75" data-val-length-min="4" data-val-regex="Check email Format" data-val-regex-pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,4}|[0-9]{1,3})(\]?)$" data-val-required="Missing Email" id="txtEmail1" maxlength="75" name="email" onkeyup="fnInvalidCharactor(this, 1);" placeholder="Email" type="email" value="" />
                    <span class="field-validation-valid" data-valmsg-for="email" data-valmsg-replace="true"></span>
                </div>
                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label>Confirm Email<span class="text-danger">*</span> </label>
                    <input autocomplete="off" class="form-control" data-val="true" data-val-emailidcompare="Email ids not  matched." data-val-length="Confirm Email should be minimum of 5 and maximum of 75 Characters" data-val-length-max="75" data-val-length-min="4" data-val-regex="Check email Format" data-val-regex-pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,4}|[0-9]{1,3})(\]?)$" data-val-required="Missing ConfirmEmail" id="txtConfirmEmail1" maxlength="75" name="confirmEmail" oncopy="return false" onkeyup="fnInvalidCharactor(this, 1);" onpaste="return false" placeholder="Confirm Email" type="email" value="" />
                    <span class="field-validation-valid" data-valmsg-for="confirmEmail" data-valmsg-replace="true"></span>
                </div>
                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label>Phone Number<span class="text-danger">*</span> </label>
                    <input autocomplete="off" class="form-control" data-val="true" data-val-length="PhoneNo should be minimum of 10 and maximum of 15 Digits" data-val-length-max="15" data-val-length-min="10" data-val-regex="Only Numbers are allowed in PhoneNo" data-val-regex-pattern="^([0-9]+)$" data-val-required="Missing PhoneNo" id="txtPhoneNumber1" maxlength="15" name="phoneNo" onkeyup="fnValidCharactor(this, 1);" placeholder="Phone Number" type="tel" value="" />
                    <span class="field-validation-valid" data-valmsg-for="phoneNo" data-valmsg-replace="true"></span>
                    <span id="helpBlock" class="help-block">ex : Country code XXXXXX</span>
                </div>
            </div>
            <div class="clearfix"></div>

            <!--<div class="panel panel-info">
         <div class="panel-heading">Passport Details</div>
       </div>
            <div class="panel panel-body">

                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <label>Passport Number</label>
                    <input autocomplete="off" class="form-control" data-val="true" data-val-length="PassportNumber should be minimum of 3 and maximum of 15 Characters" data-val-length-max="15" data-val-length-min="3" data-val-regex="Check Passport Number Format" data-val-regex-pattern="^[a-zA-Z0-9-]+$" id="txtPassportNumber1" maxlength="15" name="passportNumber" onkeyup="CheckDuplicatePassport(this);" placeholder="Passport Number" type="text" value="" />
                    <span class="field-validation-valid" data-valmsg-for="passportNumber" data-valmsg-replace="true"></span>
                </div>
                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <label>Country </label>
                    <select class="form-control" id="ddlCountry1" name="country"><option value="">-- Select --</option>
                        <option value="AL">ALBANIA</option>
                        <option value="DZ">ALGERIA</option>
                        <option value="AD">ANDORRA</option>
                        <option value="AO">ANGOLA</option>
                        <option value="AI">ANGUILLA</option>
                        <option value="AG">ANTIGUA</option>
                        <option value="AR">ARGENTINA</option>
                        <option value="AM">ARMENIA</option>
                        <option value="AW">ARUBA</option>
                        <option value="AU">AUSTRALIA</option>
                        <option value="AT">AUSTRIA</option>
                        <option value="AZ">AZERBAIJAN</option>
                        <option value="BS">BAHAMAS</option>
                        <option value="BH">BAHRAIN</option>
                        <option value="BD">BANGLADESH</option>
                        <option value="BB">BARBADOS</option>
                        <option value="BY">BELARUS</option>
                        <option value="BE">BELGIUM</option>
                        <option value="BZ">BELIZE</option>
                        <option value="BJ">BENIN</option>
                        <option value="BM">BERMUDA</option>
                        <option value="BO">BOLIVIA</option>
                        <option value="BK">BONAIRE</option>
                        <option value="BA">BOSNIA-HERZEGOVINA</option>
                        <option value="BW">BOTSWANA</option>
                        <option value="BR">BRAZIL</option>
                        <option value="VG">BRITISH VIRGIN ISLANDS</option>
                        <option value="BN">BRUNEI</option>
                        <option value="BG">BULGARIA</option>
                        <option value="BF">BURKINA FASO</option>
                        <option value="KH">CAMBODIA</option>
                        <option value="CM">CAMEROON</option>
                        <option value="CA">CANADA</option>
                        <option value="CV">CAPE VERDE</option>
                        <option value="KY">CAYMAN ISLANDS</option>
                        <option value="CF">CENTRAL AFRI. REP.</option>
                        <option value="TD">CHAD</option>
                        <option value="CL">CHILE</option>
                        <option value="CN">CHINA</option>
                        <option value="CO">COLOMBIA</option>
                        <option value="KM">COMOROS</option>
                        <option value="CK">COOK ISLANDS</option>
                        <option value="CR">COSTA RICA</option>
                        <option value="HR">CROATIA</option>
                        <option value="CU">CUBA</option>
                        <option value="C0">CURA&#195;AO</option>
                        <option value="CW">CURACAO</option>
                        <option value="CY">CYPRUS</option>
                        <option value="CZ">CZECH REPUBLIC</option>
                        <option value="DK">DENMARK</option>
                        <option value="DJ">DJIBOUTI</option>
                        <option value="DO">DOMINICAN REPUBLIC</option>
                        <option value="CD">DR OF CONGO</option>
                        <option value="CG">DR OF CONGO</option>
                        <option value="EC">ECUADOR</option>
                        <option value="EG">EGYPT</option>
                        <option value="SV">EL SALVADOR</option>
                        <option value="GQ">EQUATORIAL GUINEA</option>
                        <option value="EE">ESTONIA</option>
                        <option value="ET">ETHIOPIA</option>
                        <option value="FO">FAROE ISLANDS</option>
                        <option value="FJ">FIJI</option>
                        <option value="FI">FINLAND</option>
                        <option value="FR">FRANCE</option>
                        <option value="GF">FRENCH GUIANA</option>
                        <option value="PF">FRENCH POLYNESIA</option>
                        <option value="GA">GABON</option>
                        <option value="GM">GAMBIA</option>
                        <option value="GE">GEORGIA</option>
                        <option value="DE">GERMANY</option>
                        <option value="GH">GHANA</option>
                        <option value="GI">GIBRALTAR</option>
                        <option value="GR">GREECE</option>
                        <option value="GL">GREENLAND</option>
                        <option value="GD">GRENADA</option>
                        <option value="GP">GUADALUPE</option>
                        <option value="GU">GUAM</option>
                        <option value="GT">GUATEMALA</option>
                        <option value="GY">GUIANA</option>
                        <option value="GN">GUINEA</option>
                        <option value="GW">GUINEA-BISSAU</option>
                        <option value="HT">HAITI</option>
                        <option value="HN">HONDURAS</option>
                        <option value="HK">HONG KONG</option>
                        <option value="HU">HUNGARY</option>
                        <option value="IS">ICELAND</option>
                        <option value="IN">INDIA</option>
                        <option value="ID">INDONESIA</option>
                        <option value="IR">IRAN</option>
                        <option value="IQ">IRAQ</option>
                        <option value="IE">IRELAND</option>
                        <option value="IL">ISRAEL</option>
                        <option value="IT">ITALY</option>
                        <option value="CI">IVORY COAST</option>
                        <option value="JM">JAMAICA</option>
                        <option value="JP">JAPAN</option>
                        <option value="JO">JORDAN</option>
                        <option value="KZ">KAZAKHSTAN</option>
                        <option value="KE">KENYA</option>
                        <option value="KW">KUWAIT</option>
                        <option value="KG">KYRGYZSTAN</option>
                        <option value="LA">LAOS</option>
                        <option value="LV">LATVIA</option>
                        <option value="LB">LEBANON</option>
                        <option value="LS">LESOTHO</option>
                        <option value="LY">LIBYA</option>
                        <option value="LI">LIECHTENSTEIN</option>
                        <option value="LT">LITHUANIA</option>
                        <option value="LU">LUXEMBOURG</option>
                        <option value="MO">MACAU</option>
                        <option value="MK">MACEDONIA F.Y.R.O</option>
                        <option value="MG">MADAGASCAR</option>
                        <option value="MW">MALAWI</option>
                        <option value="MY">MALAYSIA</option>
                        <option value="MV">MALDIVES</option>
                        <option value="ML">MALI</option>
                        <option value="MT">MALTA</option>
                        <option value="MP">MARIANA ISLANDS</option>
                        <option value="MQ">MARTINIQUE</option>
                        <option value="MR">MAURITANIA</option>
                        <option value="MU">MAURITIUS</option>
                        <option value="MX">MEXICO</option>
                        <option value="MD">MOLDOVA</option>
                        <option value="MC">MONACO</option>
                        <option value="MN">MONGOLIA</option>
                        <option value="ME">MONTENEGRO</option>
                        <option value="MA">MOROCCO</option>
                        <option value="MZ">MOZAMBIQUE</option>
                        <option value="MM">MYANMAR (Burma)</option>
                        <option value="NA">NAMIBIA</option>
                        <option value="NP">NEPAL</option>
                        <option value="NL">NETHERLANDS</option>
                        <option value="AN">NETHERLANDS ANTILLES</option>
                        <option value="NC">NEW CALEDONIA</option>
                        <option value="NZ">NEW ZEALAND</option>
                        <option value="NI">NICARAGUA</option>
                        <option value="NE">NIGER</option>
                        <option value="NG">NIGERIA</option>
                        <option value="NY">NORTHERN CYPRUS</option>
                        <option value="NO">NORWAY</option>
                        <option value="OM">OMAN</option>
                        <option value="PK">PAKISTAN</option>
                        <option value="PA">PANAMA</option>
                        <option value="PG">PAPUA NEW GUINEA</option>
                        <option value="PY">PARAGUAY</option>
                        <option value="PE">PERU</option>
                        <option value="PH">PHILIPPINES</option>
                        <option value="PL">POLAND</option>
                        <option value="PT">PORTUGAL</option>
                        <option value="PR">PUERTO RICO</option>
                        <option value="QA">QATAR</option>
                        <option value="PW">REPUBLIC OF PALAU</option>
                        <option value="RE">REUNION (Isl.)</option>
                        <option value="RO">ROMANIA</option>
                        <option value="RU">RUSSIA</option>
                        <option value="RW">RWANDA</option>
                        <option value="BL">SAINT BARTHELEMY</option>
                        <option value="KN">SAINT KITTS AND NEVIS</option>
                        <option value="LC">SAINT LUCIA</option>
                        <option value="SF">SAINT MARTEEN</option>
                        <option value="VC">SAINT VINCENT AND GRENADINES</option>
                        <option value="WS">SAMOA</option>
                        <option value="SM">SAN MARINE</option>
                        <option value="ST">Sao Tome e Principe</option>
                        <option value="SA">SAUDI ARABIA</option>
                        <option value="SN">SENEGAL</option>
                        <option value="RS">SERBIA</option>
                        <option value="SC">SEYCHELLES</option>
                        <option value="SL">SIERRA LEONE</option>
                        <option value="SG">SINGAPORE</option>
                        <option value="SK">SLOVAKIA</option>
                        <option value="SI">SLOVENIA</option>
                        <option value="ZA">SOUTH AFRICA</option>
                        <option value="KR">SOUTH KOREA</option>
                        <option value="ES">SPAIN</option>
                        <option value="LK">SRI LANKA</option>
                        <option value="SD">SUDAN</option>
                        <option value="SR">SURINAME</option>
                        <option value="SZ">SWAZILAND</option>
                        <option value="SE">SWEDEN</option>
                        <option value="CH">SWITZERLAND</option>
                        <option value="SY">SYRIA</option>
                        <option value="TW">TAIWAN</option>
                        <option value="TJ">TAJIKISTAN</option>
                        <option value="TZ">TANZANIA</option>
                        <option value="TH">THAILAND</option>
                        <option value="TG">TOGO</option>
                        <option value="TO">TONGA</option>
                        <option value="TT">TRINIDAD AND TOBAGO</option>
                        <option value="TN">TUNISIA</option>
                        <option value="TR">TURKEY</option>
                        <option value="TC">TURKS AND CAICOS</option>
                        <option value="UG">UGANDA</option>
                        <option value="UA">UKRAINE</option>
                        <option value="AE">UNITED ARAB EMIRATES</option>
                        <option value="UK">UNITED KINGDOM</option>
                        <option value="US">UNITED STATES - USA</option>
                        <option value="UY">URUGUAY</option>
                        <option value="VI">US VIRGIN ISLANDS</option>
                        <option value="UZ">UZBEKISTAN</option>
                        <option value="VU">VANUATU</option>
                        <option value="VE">VENEZUELA</option>
                        <option value="VN">VIETNAM</option>
                        <option value="YE">YEMEN REPUBLIC</option>
                        <option value="ZM">ZAMBIA</option>
                        <option value="ZW">ZIMBABWE</option>
                    </select>
                    <span class="field-validation-valid" data-valmsg-for="country" data-valmsg-replace="true"></span>
                </div>
                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <label>Nationality </label>
                    <select class="form-control" id="ddlNationality1" name="nationality"><option value="">-- Select --</option>
                        <option value="AL">ALBANIA</option>
                        <option value="DZ">ALGERIA</option>
                        <option value="AD">ANDORRA</option>
                        <option value="AO">ANGOLA</option>
                        <option value="AI">ANGUILLA</option>
                        <option value="AG">ANTIGUA</option>
                        <option value="AR">ARGENTINA</option>
                        <option value="AM">ARMENIA</option>
                        <option value="AW">ARUBA</option>
                        <option value="AU">AUSTRALIA</option>
                        <option value="AT">AUSTRIA</option>
                        <option value="AZ">AZERBAIJAN</option>
                        <option value="BS">BAHAMAS</option>
                        <option value="BH">BAHRAIN</option>
                        <option value="BD">BANGLADESH</option>
                        <option value="BB">BARBADOS</option>
                        <option value="BY">BELARUS</option>
                        <option value="BE">BELGIUM</option>
                        <option value="BZ">BELIZE</option>
                        <option value="BJ">BENIN</option>
                        <option value="BM">BERMUDA</option>
                        <option value="BO">BOLIVIA</option>
                        <option value="BK">BONAIRE</option>
                        <option value="BA">BOSNIA-HERZEGOVINA</option>
                        <option value="BW">BOTSWANA</option>
                        <option value="BR">BRAZIL</option>
                        <option value="VG">BRITISH VIRGIN ISLANDS</option>
                        <option value="BN">BRUNEI</option>
                        <option value="BG">BULGARIA</option>
                        <option value="BF">BURKINA FASO</option>
                        <option value="KH">CAMBODIA</option>
                        <option value="CM">CAMEROON</option>
                        <option value="CA">CANADA</option>
                        <option value="CV">CAPE VERDE</option>
                        <option value="KY">CAYMAN ISLANDS</option>
                        <option value="CF">CENTRAL AFRI. REP.</option>
                        <option value="TD">CHAD</option>
                        <option value="CL">CHILE</option>
                        <option value="CN">CHINA</option>
                        <option value="CO">COLOMBIA</option>
                        <option value="KM">COMOROS</option>
                        <option value="CK">COOK ISLANDS</option>
                        <option value="CR">COSTA RICA</option>
                        <option value="HR">CROATIA</option>
                        <option value="CU">CUBA</option>
                        <option value="C0">CURA&#195;AO</option>
                        <option value="CW">CURACAO</option>
                        <option value="CY">CYPRUS</option>
                        <option value="CZ">CZECH REPUBLIC</option>
                        <option value="DK">DENMARK</option>
                        <option value="DJ">DJIBOUTI</option>
                        <option value="DO">DOMINICAN REPUBLIC</option>
                        <option value="CD">DR OF CONGO</option>
                        <option value="CG">DR OF CONGO</option>
                        <option value="EC">ECUADOR</option>
                        <option value="EG">EGYPT</option>
                        <option value="SV">EL SALVADOR</option>
                        <option value="GQ">EQUATORIAL GUINEA</option>
                        <option value="EE">ESTONIA</option>
                        <option value="ET">ETHIOPIA</option>
                        <option value="FO">FAROE ISLANDS</option>
                        <option value="FJ">FIJI</option>
                        <option value="FI">FINLAND</option>
                        <option value="FR">FRANCE</option>
                        <option value="GF">FRENCH GUIANA</option>
                        <option value="PF">FRENCH POLYNESIA</option>
                        <option value="GA">GABON</option>
                        <option value="GM">GAMBIA</option>
                        <option value="GE">GEORGIA</option>
                        <option value="DE">GERMANY</option>
                        <option value="GH">GHANA</option>
                        <option value="GI">GIBRALTAR</option>
                        <option value="GR">GREECE</option>
                        <option value="GL">GREENLAND</option>
                        <option value="GD">GRENADA</option>
                        <option value="GP">GUADALUPE</option>
                        <option value="GU">GUAM</option>
                        <option value="GT">GUATEMALA</option>
                        <option value="GY">GUIANA</option>
                        <option value="GN">GUINEA</option>
                        <option value="GW">GUINEA-BISSAU</option>
                        <option value="HT">HAITI</option>
                        <option value="HN">HONDURAS</option>
                        <option value="HK">HONG KONG</option>
                        <option value="HU">HUNGARY</option>
                        <option value="IS">ICELAND</option>
                        <option value="IN">INDIA</option>
                        <option value="ID">INDONESIA</option>
                        <option value="IR">IRAN</option>
                        <option value="IQ">IRAQ</option>
                        <option value="IE">IRELAND</option>
                        <option value="IL">ISRAEL</option>
                        <option value="IT">ITALY</option>
                        <option value="CI">IVORY COAST</option>
                        <option value="JM">JAMAICA</option>
                        <option value="JP">JAPAN</option>
                        <option value="JO">JORDAN</option>
                        <option value="KZ">KAZAKHSTAN</option>
                        <option value="KE">KENYA</option>
                        <option value="KW">KUWAIT</option>
                        <option value="KG">KYRGYZSTAN</option>
                        <option value="LA">LAOS</option>
                        <option value="LV">LATVIA</option>
                        <option value="LB">LEBANON</option>
                        <option value="LS">LESOTHO</option>
                        <option value="LY">LIBYA</option>
                        <option value="LI">LIECHTENSTEIN</option>
                        <option value="LT">LITHUANIA</option>
                        <option value="LU">LUXEMBOURG</option>
                        <option value="MO">MACAU</option>
                        <option value="MK">MACEDONIA F.Y.R.O</option>
                        <option value="MG">MADAGASCAR</option>
                        <option value="MW">MALAWI</option>
                        <option value="MY">MALAYSIA</option>
                        <option value="MV">MALDIVES</option>
                        <option value="ML">MALI</option>
                        <option value="MT">MALTA</option>
                        <option value="MP">MARIANA ISLANDS</option>
                        <option value="MQ">MARTINIQUE</option>
                        <option value="MR">MAURITANIA</option>
                        <option value="MU">MAURITIUS</option>
                        <option value="MX">MEXICO</option>
                        <option value="MD">MOLDOVA</option>
                        <option value="MC">MONACO</option>
                        <option value="MN">MONGOLIA</option>
                        <option value="ME">MONTENEGRO</option>
                        <option value="MA">MOROCCO</option>
                        <option value="MZ">MOZAMBIQUE</option>
                        <option value="MM">MYANMAR (Burma)</option>
                        <option value="NA">NAMIBIA</option>
                        <option value="NP">NEPAL</option>
                        <option value="NL">NETHERLANDS</option>
                        <option value="AN">NETHERLANDS ANTILLES</option>
                        <option value="NC">NEW CALEDONIA</option>
                        <option value="NZ">NEW ZEALAND</option>
                        <option value="NI">NICARAGUA</option>
                        <option value="NE">NIGER</option>
                        <option value="NG">NIGERIA</option>
                        <option value="NY">NORTHERN CYPRUS</option>
                        <option value="NO">NORWAY</option>
                        <option value="OM">OMAN</option>
                        <option value="PK">PAKISTAN</option>
                        <option value="PA">PANAMA</option>
                        <option value="PG">PAPUA NEW GUINEA</option>
                        <option value="PY">PARAGUAY</option>
                        <option value="PE">PERU</option>
                        <option value="PH">PHILIPPINES</option>
                        <option value="PL">POLAND</option>
                        <option value="PT">PORTUGAL</option>
                        <option value="PR">PUERTO RICO</option>
                        <option value="QA">QATAR</option>
                        <option value="PW">REPUBLIC OF PALAU</option>
                        <option value="RE">REUNION (Isl.)</option>
                        <option value="RO">ROMANIA</option>
                        <option value="RU">RUSSIA</option>
                        <option value="RW">RWANDA</option>
                        <option value="BL">SAINT BARTHELEMY</option>
                        <option value="KN">SAINT KITTS AND NEVIS</option>
                        <option value="LC">SAINT LUCIA</option>
                        <option value="SF">SAINT MARTEEN</option>
                        <option value="VC">SAINT VINCENT AND GRENADINES</option>
                        <option value="WS">SAMOA</option>
                        <option value="SM">SAN MARINE</option>
                        <option value="ST">Sao Tome e Principe</option>
                        <option value="SA">SAUDI ARABIA</option>
                        <option value="SN">SENEGAL</option>
                        <option value="RS">SERBIA</option>
                        <option value="SC">SEYCHELLES</option>
                        <option value="SL">SIERRA LEONE</option>
                        <option value="SG">SINGAPORE</option>
                        <option value="SK">SLOVAKIA</option>
                        <option value="SI">SLOVENIA</option>
                        <option value="ZA">SOUTH AFRICA</option>
                        <option value="KR">SOUTH KOREA</option>
                        <option value="ES">SPAIN</option>
                        <option value="LK">SRI LANKA</option>
                        <option value="SD">SUDAN</option>
                        <option value="SR">SURINAME</option>
                        <option value="SZ">SWAZILAND</option>
                        <option value="SE">SWEDEN</option>
                        <option value="CH">SWITZERLAND</option>
                        <option value="SY">SYRIA</option>
                        <option value="TW">TAIWAN</option>
                        <option value="TJ">TAJIKISTAN</option>
                        <option value="TZ">TANZANIA</option>
                        <option value="TH">THAILAND</option>
                        <option value="TG">TOGO</option>
                        <option value="TO">TONGA</option>
                        <option value="TT">TRINIDAD AND TOBAGO</option>
                        <option value="TN">TUNISIA</option>
                        <option value="TR">TURKEY</option>
                        <option value="TC">TURKS AND CAICOS</option>
                        <option value="UG">UGANDA</option>
                        <option value="UA">UKRAINE</option>
                        <option value="AE">UNITED ARAB EMIRATES</option>
                        <option value="UK">UNITED KINGDOM</option>
                        <option value="US">UNITED STATES - USA</option>
                        <option value="UY">URUGUAY</option>
                        <option value="VI">US VIRGIN ISLANDS</option>
                        <option value="UZ">UZBEKISTAN</option>
                        <option value="VU">VANUATU</option>
                        <option value="VE">VENEZUELA</option>
                        <option value="VN">VIETNAM</option>
                        <option value="YE">YEMEN REPUBLIC</option>
                        <option value="ZM">ZAMBIA</option>
                        <option value="ZW">ZIMBABWE</option>
                    </select>
                    <span class="field-validation-valid" data-valmsg-for="nationality" data-valmsg-replace="true"></span>
                    <span class='field-validation-error' id= "spnNationality1"   style="display:none"></span>
                    <div id= "divNationalityMask1"  class="PaxMask" > </div>
                </div>
                <div class="form-group pos-r col-lg-3 col-md-3 col-sm-6 col-xs-12 calander-icon">
                    <label>Expiry Date<span class="text-danger" id= "spnMandatoryPassExpiryDate1"    style="display:none" >*</span> </label>

                    <input class="form-control" data-val="true" data-val-regex="Check ExpiryDate Format"
                           data-val-regex-pattern="(0[1-9]|[12][0-9]|3[01])\-(0[1-9]|1[012])\-(19|20)\d\d"
                           id="txtPassExpiryDate1" name="passportExpiryDate" placeholder="yyyy-mm-dd" type="text" value="" />
                    <span class="field-validation-valid" data-valmsg-for="expiryDate" data-valmsg-replace="true"></span>
                    <span class='field-validation-error' id= "spntxtPassExpiryDate1"   style="display:none"></span>
                    <div id= "divExpiryDateMask1"  class="PaxMask" > </div>
                </div>
                <div class="clearfix"></div>
                <small>Your Passport details will be treated with the highest standard of security and confidentiality, strictly in accordance with the Data Protection Acts 1988 and 2003.</small>
            </div>    -->
            <div class="clearfix"></div>
            <input type="submit" name="submit" class="btn btn-search" value="Booking Confirm"/>
            <div class="clearfix"></div>

        </div>

<?php if (isset($searchparams) && !empty($searchparams) && isset($itivalues) && !empty($itivalues)) { ?>
            <div class="col-md-3 summarytour">
                <div class="panel panel-body summarytour bg_bluesw">
                    <h2 class="txt_white">Fare Details</h2>
                    <ul class="list-group">
                        <li  class="list-group-item">
                            <div class="content fare">

                                <div class="clearfix">
                                </div>

                                <div class="inline-text">
                                    <label>Passengers</label>
                                    <?php if (isset($searchparams->passengers->adult) && $searchparams->passengers->adult > 0) { ?>
                                        <p class="grey fare">Adult X <?php echo $searchparams->passengers->adult; ?></p>
                                    <?php } ?>
                                    <?php if (isset($searchparams->passengers->child) && $searchparams->passengers->child > 0) { ?>
                                        <p class="grey fare">Children X <?php echo $searchparams->passengers->child; ?></p>
                                    <?php } ?>
                                <?php if (isset($searchparams->passengers->infant) && $searchparams->passengers->infant > 0) { ?>
                                        <p class="grey fare">Infants X <?php echo $searchparams->passengers->infant; ?></p>
    <?php } ?>
                                </div>
    <?php if (isset($itivalues->pricing->totalAmount)) { ?>
                                    <div class="inline-text">
                                        <div class="inline-text tax">
                                            <label style="margin-bottom: 0px;">
                                                <b>Total Cost</b></label>
                                            <p class="grey fare">
                                                <span id="spnTotal">
                                                    {{$currencySymbol}} {{$itivalues->pricing->totalAmount}}
                                                </span>
                                            </p>
                                            <small style="display: inline-block">(Including taxes and fees)</small>
                                        </div>
                                    </div>
    <?php } ?>
                            </div>
                        </li>
                    </ul>
                </div>
    <?php if (isset($itivalues->flightJournies) && !empty($itivalues->flightJournies)) { ?>
                    <div class="panel panel-body  summarytour  bg_bluesw">
                        <h2 class="txt_white">Your Itinerary</h2>
                        <ul class="list-group">
                            <li  class="list-group-item">

                                <?php
                                $flightJournies = $itivalues->flightJournies;
                                $i = 0;
                                foreach ($flightJournies as $fj) {
                                    if ($searchparams->returndate != "") {
                                        if ($i == 0) {
                                            echo '<h4 class="journeytype">Outbound Journey</h4><div class="clearfix"></div>';
                                        } elseif ($i == 1) {
                                            echo '<h4 class="journeytype">Inbound Journey</h4><div class="clearfix"></div>';
                                        }
                                    }
                                    ?>
                                    <div class="inline-text">
                                        <label><?php echo $fj->origin; ?><br/>{{\Carbon\Carbon::parse($fj->departureTime)->format('D, d M')}}</label>
                                        <?php
                                        if ($searchparams->returndate != "" && $i == 1) {
                                            $boundimg = "inbound.jpg";
                                        } else {
                                            $boundimg = "outbound.jpg";
                                        }
                                        ?>
                                        <img src="{{URL::asset('assets/img/airlines/'.$boundimg)}}" class="img-responsive"/>
                                        <p>{{$fj->flyingDuration}}</p>
                                        <?php echo ($fj->totalTransitTime != "" ? "<p>Total Transit:" . $fj->totalTransitTime . "</p>" : ""); ?>
                                        <label><?php echo $fj->destination; ?><br/>{{\Carbon\Carbon::parse($fj->arrivalTime)->format('D, d M')}}</label>
                                        <?php
                                        if (!empty($fj->flights)) {
                                            foreach ($fj->flights as $flight) {
                                                ?>
                                                <div class="booking-item-airline-logo">
                                                    <img src="{{URL::asset('assets/img/airlines/'.$flight->airlineCode.'.jpg')}}" alt="{{$flight->airlineName}}" title="{{$flight->airlineName}}" class="img-responsive"/>
                                                </div>
                                                <p class="grey fare">{{$flight->airlineName}}</p>
                                                <label><?php echo $flight->origin . ($flight->originTerminal != "" ? " T:" . $flight->originTerminal : ""); ?><br/>{{\Carbon\Carbon::parse($flight->departureTime)->format('D, d M')}}</label>
                                                <p>{{$flight->flyingDuration}}</p>
                                                <label><?php echo $flight->destination . ($flight->destinationTerminal != "" ? " T:" . $flight->destinationTerminal : ""); ?><br/>{{\Carbon\Carbon::parse($flight->arrivalTime)->format('D, d M')}}</label>
                                            <?php
                                        }
                                    }
                                    ?>
                                    </div>
            <?php
            $i++;
        }
        ?>

                            </li>
                        </ul>
                    </div>
    <?php } ?>
            </div>
<?php } ?>

    </form>

</div>

</div>

</div>

<?php //    ?>
</div>

<!-- AJAX request -->
<script type="text/javascript">
    $(document).ready(function(){
    $(".showFlightsDetails").click(function() {
    var oFdata = $(this).parents('.booking-item-flight-details').find('.flightsindetail');
    if (oFdata.hasClass("hideflightdetails")){
    oFdata.addClass('showflightdetails');
    oFdata.removeClass('hideflightdetails');
    } else {
    oFdata.addClass('hideflightdetails');
    oFdata.removeClass('showflightdetails');
    }
    });
    $("#depart_date").datepicker({
    dateFormat : 'dd/mm/yy',
            changeMonth : true,
            changeYear : true,
            yearRange: '-100y:c+nn',
            maxDate: '-1d'
    });
    // Left side bar filter
    $('#ckNonDirect').change(function() {
    if (this.checked) { // show non-direct
    $('.nondirectflights').show();
    } else { // dont show non-direct
    $('.nondirectflights').hide();
    }
    });
    $('#ckDirect').change(function() {
    if (this.checked) { // show non-direct
    $('.directflights').show();
    } else { // dont show non-direct
    $('.directflights').hide();
    }
    });
    $('.filterfcode').change(function() {
    var cls = '.flightcode' + $(this).data('id');
    if (this.checked) { // show non-direct
    $(cls).show();
    } else { // dont show non-direct
    $(cls).hide();
    }
    });
    $("#filterSelectAll").click(function() {
    $('.flightitineraries').show();
    $('.filterfcode').prop('checked', true);
    });
    $("#filterClearAll").click(function() {
    $('.flightitineraries').hide();
    $('.filterfcode').prop('checked', false);
    });
    });
</script>
@endsection
