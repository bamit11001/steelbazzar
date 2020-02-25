@extends('layouts.sidebar')
@section('content')
   <main class="mn-inner">
<div class="row">
<div class="col s12">
<div class="page-title"></div>
</div>
<div class="col s12 m12 l12">
<div class="card">
<div class="card-content">
<form id="registration_form" id="first_form" id="example-form" method="post" onsubmit="return validateForm()" action="/elms/admin/addcustomer.php" name="addemp">
<div>
<h5>Lead Management > Add Lead</h5>
<section>
<div class="wizard-content">
<div class="row">
<div class="col m6">
<div class="row">
<div class="input-field col s12">
<label for="custid">Lead Code<span class="note">*</span>:</label>
<input name="custid" id="custid" onBlur="checkAvailabilityEmpid()" value="" type="text" autocomplete="off" tabindex="1" required>
<span id="empid-availability" style="font-size:12px;"></span>
<span class="custid error"></span>
</div>
<div class="input-field col m6 s12">
<label for="firstName">Name<span class="note">*</span></label>
<input id="firstName" name="firstName" value="" tabindex="2" type="text" required>
<span class="firstName error"> </span>
</div>
<div class="input-field col m6 s12">
<label for="email">Email<span class="note">*</span></label>
<input name="email" type="email" class="email" id="email" value="" onBlur="checkAvailabilityEmailid()" autocomplete="off" tabindex="3" required>
<span id="emailid-availability" style="font-size:12px;"></span>
<span class="error email"></span>
</div>
<!-- <div class="input-field col s12">
<label for="lastName">Last name</label>
<input id="lastName" name="lastName" type="text" autocomplete="off" >
</div> -->
<div class="input-field col m6 s12">
<label for="password">Password<span class="note">*</span></label>
<input id="password" name="password" type="password" value="" autocomplete="off" tabindex="4" required>
<span class="error password"></span>
</div>
<div class="input-field col m6 s12">
<label for="c_password">Confirm password<span class="note">*</span></label>
<input id="c_password" name="c_password" value="" type="password" tabindex="5" autocomplete="off" required>
<span class="error password"></span>
</div>
</div>
</div>
<div class="col m6">
<div class="row">
<div class="input-field col m6 s12">
<select id="gender" name="gender" autocomplete="off" required tabindex="6">
<option value="">Gender...</option>
<option value="Male">Male</option>
<option value="Female">Female</option>
<option value="Other">Other</option>
</select>
<span class="error gender"></span>
</div>
<div class="input-field col m6 s12">
<label for="dob">Birthdate<span class="note">*</span></label>
<input id="dob" name="dob" type="text" value="" tabindex="7" class="datepicker" autocomplete="off" required="">
<span class="error birthdate"></span>
</div>
<div class="input-field col m6 s12">
<label for="address">Address<span class="note">*</span></label>
<input id="address" name="address" type="text" value="" tabindex="8" autocomplete="off" required>
<span class="error address"></span>
</div>
<div class="input-field col m6 s12">
<label for="c_address">Address 2<span class="note">*</span></label>
<input id="c_address" name="c_address" type="text" value="" tabindex="9" autocomplete="off" required>
<span class="error c_address"></span>
</div>
<div class="input-field col m6 s12">
<label for="city">City<span class="note">*</span></label>
<input id="city" name="city" type="text" value="" tabindex="10" autocomplete="off" required="">
<span class="error city"></span>
</div>
<div class="input-field col m6 s12">
<!-- <label for="state">State</label>
<input id="state" name="state" type="text" autocomplete="off" > -->
<select name="state" autocomplete="off" required="" tabindex="11" onchange="changeOption()">
<option value="opt1">State</option>
<option value="opt2">Select State</option>
<option value="36">ANDHRA PRADESH</option>
<option value="37">ASSAM</option>
<option value="38">ARUNACHAL PRADESH</option>
<option value="39">GUJRAT</option>
<option value="40">BIHAR</option>
<option value="41">HARYANA</option>
<option value="42">HIMACHAL PRADESH</option>
<option value="43">JAMMU & KASHMIR</option>
<option value="44">KARNATAKA</option>
<option value="45">KERALA</option>
<option value="46">MADHYA PRADESH</option>
<option value="47">MAHARASHTRA</option>
<option value="48">MANIPUR</option>
<option value="49">MEGHALAYA</option>
<option value="50">MIZORAM</option>
<option value="51">NAGALAND</option>
<option value="52">ORISSA</option>
<option value="53">PUNJAB</option>
<option value="54">RAJASTHAN</option>
<option value="55">SIKKIM</option>
<option value="56">TAMIL NADU</option>
<option value="57">TRIPURA</option>
<option value="58">UTTAR PRADESH</option>
<option value="59">WEST BENGAL</option>
<option value="60">DELHI</option>
<option value="61">GOA</option>
<option value="62">PONDICHERY</option>
<option value="63">LAKSHDWEEP</option>
<option value="64">DAMAN & DIU</option>
<option value="65">DADRA & NAGAR</option>
<option value="66">CHANDIGARH</option>
<option value="67">ANDAMAN & NICOBAR</option>
<option value="68">UTTARANCHAL</option>
<option value="69">JHARKHAND</option>
<option value="70">CHATTISGARH</option>
</select>
<span class="error pincode"></span>
</div>
<div class="input-field col m6 s12">
<label for="pincode">Pin Code<span class="note">*</span></label>
<input id="pincode" name="pincode" type="text" value="" tabindex="12" maxlength="6" autocomplete="off" required>
<span class="error pincode"></span>
</div>
<div class="input-field col m6 s12">
<label for="phone">Mobile Number<span class="note">*</span></label>
<input id="phone" name="mobileno" type="text" minlength="10" tabindex="13" maxlength="10" value="" autocomplete="off" required>
<span class="error phone"></span>
</div>
<div class="input-field col s12">
<!-- <input type="submit" name="submit" value="ADD" class="waves-effect waves-light btn indigo m-b-xs"> -->
<button id="add" type="submit" name="submit" value="submit" class="waves-effect waves-light btn indigo m-b-xs">ADD</button>
</div>
</div>
</div>
</div>
</div>
</section>
</section>
</div>
</form>
</div>
</div>
</div>
</div>
</main>
@stop
