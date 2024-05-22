<?php
$pagename="users";
?>
@include('layouts.header')
<style>
    /* body {
  background-color: #efefef;
} */

.profile-pic {
    width: 200px;
    max-height: 200px;
    display: inline-block;
}

 .file-upload {
    display: none;
}
.circle {
    border-radius: 100% !important;
    overflow: hidden;
    width: 128px;
    height: 128px;
    border: 2px solid rgba(255, 255, 255, 0.2);
    /* position: absolute;
    top: 72px; */
}

img {
    max-width: 100%;
    height: auto;
}
.p-image {
  /* position: absolute;
  top: 167px;
  right: 30px; */
  color: #666666;
  transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
}
.p-image:hover {
  transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
}
.upload-button {
  font-size: 1.2em;
}

.upload-button:hover {
  transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
  color: #999;
} 

.disaplayInput{
display: none;
}
</style> 

<div class="intro-y flex flex-col sm:flex-row items-center mt-8">

    <h2 class="text-lg font-medium mr-auto ml-2">
        {{ $title }}
    </h2>
  
</div>

<div class="intro-y box pb-10">
    <div class="px-5 sm:px-20 mt-10 pt-10 border-t border-gray-200">
        <form action="{{ $url }}" class="validate-form" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-2">Profile Picture <strong>(Optional)</strong></div>  
            <div class="small-12 medium-2 large-2 columns">
                <div class="circle">
                    
                  <img class="profile-pic" src="{{ isset($record->profile_img)?asset('public/storage/'.$record->profile_img): 'https://t3.ftcdn.net/jpg/03/46/83/96/360_F_346839683_6nAPzbhpSkIpb8pmAwufkC7c5eD7wYws.jpg'  }}">
           
                </div>
                <div class="p-image">
                  <i class="fa fa-camera upload-button"></i>
                   <input class="file-upload" type="file" name="profile_img" accept="image/*"/>
                </div>
             </div>

                <div class="grid grid-cols-12 gap-4 row-gap-5 mt-5">
                    <input type="hidden" class="form-control" id="query_id" name="user_id"
                        value="{{ isset($record->id)?$record->id: ''  }}">
                    <div class="intro-y col-span-6 sm:col-span-6 px-2">
                        <div class="mb-2">First Name*</div>
                        <input type="text" name="f_name" class="input w-full border flex-1"
                            value="{{ isset($record->f_name)?$record->f_name: old('f_name') }}"
                            placeholder="Enter the first name..." required>
                        <span class="text-theme-6">
                            @error('f_name')
                            {{'First Name is required'}}
                            @enderror
                        </span>
                    </div>

                    <div class="intro-y col-span-6 sm:col-span-6 px-2">
                        <div class="mb-2">Last Name*</div>
                        <input type="text" name="l_name" class="input w-full border flex-1"
                            value="{{ isset($record->l_name)?$record->l_name: old('l_name')  }}"
                            placeholder="Enter the last name..." required>
                        <span class="text-theme-6">
                            @error('l_name')
                            {{'Last Name is required'}}
                            @enderror
                        </span>
                    </div>

                    <div class="intro-y col-span-6 sm:col-span-6 px-2">
                        <div class="mb-2">Client ID (6 Digits)*</div>
                        <input type="text" name="client_id" class="input w-full border flex-1" size="59"
                            value="{{ isset($record->client_id)?$record->client_id: old('client_id')  }}" placeholder="Enter Your 6 Digit ID... " maxlength="6"
                            required>
                        <span class="text-theme-6">
                            @error('client_id')
                            {{$message}}
                            @enderror
                        </span>
                    </div>

                    <div class="intro-y col-span-6 sm:col-span-6 px-2">
                        <div class="mb-2">Phone Number*</div>
                        <input type="text" name="phone" class="input w-full border flex-1"
                            value="{{ isset($record->phone)?$record->phone: old('phone')  }}"
                            placeholder="Enter Number..." required>
                        <span class="text-theme-6">
                            @error('phone')
                            {{'User phone is required'}}
                            @enderror
                        </span>
                    </div>

                    
                    <div class="intro-y col-span-6 sm:col-span-6 px-2">
                        <div class="mb-2">Previous Completed Minutes*</div>
                        <input type="number" name="complete_hour" class="input w-full border flex-1" min="0"
                            value="{{ isset($record->complete_hour)?$record->complete_hour: old('complete_hour')  }}"
                            placeholder="Enter the minutes..." required>
                        <span class="text-theme-6">
                            @error('complete_hour')
                            {{'Preview Complete Hour is required'}}
                            @enderror
                        </span>
                    </div>
             
                    <div class="intro-y col-span-6 sm:col-span-6 px-2">
                        <div class="mb-2">Password*</div>
                        <input type="password" name="password" id="password" class="input  border flex-1" size="59"
                            value="{{ isset($record->password)?$record->password: old('password')    }}" placeholder="Enter Password..."
                            required>
                            <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        <span class="text-theme-6">
                            @error('password')
                            {{$message}}
                            @enderror
                        </span>
                    </div>
                    <script>
                        $(".toggle-password").click(function() {

                            $(this).toggleClass("fa-eye fa-eye-slash");
                           var input = $('#password');
                            if (input.attr("type") == "password") {
                            input.attr("type", "text");
                            } else {
                            input.attr("type", "password");
                            }
                        });
                    </script>

                    <div class="intro-y col-span-6 sm:col-span-6 px-2">
                        <td>
                            <div class="mb-2">Total CD's In Plan*</div>
                            <input class="input w-full border flex-1" type="number" min="0" name="total_cd" list="cd" value="{{ isset($record->total_cds)?$record->total_cds: old('total_cds')  }}" placeholder="Enter a Number of CD's in plan..." required>
                            <datalist  id="cd" class="input w-full border flex-1" aria-label>
                                {{-- <option disabled selected>Select CD</option> --}}
                              

                                <option value="1"></option>
                                <option value="2" ></option>
                                <option value="3" ></option>
                                <option value="4" ></option>
                                <option value="5" ></option>
                                <option value="6" ></option>
                                <option value="7" ></option>
                                <option value="8" ></option>
                                <option value="9" ></option>
                                <option value="10" ></option>
                                <option value="11" ></option>
                                <option value="12" ></option>
                                {{-- <option value="12" >Other</option> --}}

            
                            </datalist>
                            <span class="text-theme-6">
                                @error('total_cd')
                                {{ $message }}
                                @enderror
                            </span>
                        </td>
                    </div>

                    <div class="intro-y col-span-6 sm:col-span-6 px-2">
                        <div class="mb-2">Total Minutes For All CD's*</div>
                        <input type="number" name="total_minutes" min="0" class="input w-full border flex-1"
                            value="{{ isset($record->total_minutes)?$record->total_minutes: old('total_minutes')   }}"
                            placeholder="Enter The minutes..." required>
                        <span class="text-theme-6">
                            @error('complete_hour')
                            {{'Preview Complete Hour is required'}}
                            @enderror
                        </span>
                    </div>

                    @if(!isset($record))
                    <div class="intro-y col-span-12 sm:col-span-12 px-2">
                        {{-- <label>Horizontal Radio Button</label> --}}
                        <div class="flex flex-col sm:flex-row mt-2">
                            <div class="flex items-center text-gray-700 dark:text-gray-500 mr-2">
                                <input type="radio" class="input border mr-2" id="horizontal-radio-chris-evans" name="radio" value="one-hour-daily"<?php if(isset($record)){ if($record->daily_time == '1') { echo "checked='checked'"; } } ?> required>
                                <label class="cursor-pointer select-none" for="horizontal-radio-chris-evans">One Hour Daily</label>
                            </div>
                            <div class="flex items-center text-gray-700 dark:text-gray-500 mr-2 mt-2 sm:mt-0">
                                <input type="radio" class="input border mr-2" id="horizontal-radio-liam-neeson" name="radio" value="half-hour-daily"<?php if(isset($record)){ if($record->daily_time == '2') { echo "checked='checked'"; } }?> >
                                <label class="cursor-pointer select-none" for="horizontal-radio-liam-neeson">Half Hour Daily</label>
                            </div>
                            <div class="flex items-center text-gray-700 dark:text-gray-500 mr-2 mt-2 sm:mt-0">
                                <input type="radio" class="input border mr-2" id="horizontal-radio-daniel-craig" name="radio" value="half-hour-twice-daily" <?php if(isset($record)){ if($record->daily_time == '3') { echo "checked='checked'"; } }?> >
                                <label class="cursor-pointer select-none" for="horizontal-radio-daniel-craig">Half Hour Twice Daily</label>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="intro-y col-span-6 sm:col-span-6 px-2">
                        <div class="mb-2">Practice Location (Contact Information)*</div>
                        <input type="text" name="practise_location" class="input w-full border flex-1" size="59"
                            value="{{ isset($record->practise_location)?$record->practise_location: old('practise_location')  }}" placeholder="Enter Your Location... " 
                            required>
                        <span class="text-theme-6">
                            @error('practise_location')
                            {{$message}}
                            @enderror
                        </span>
                    </div>

                    <div class="intro-y col-span-6 sm:col-span-6 px-2">
                        <div class="mb-2">Practice Location (Email)*</div>
                        <input type="text" name="extra_email" class="input w-full border flex-1" size="59"
                            value="{{ isset($record->extra_email)?$record->extra_email: old('extra_email')  }}" placeholder="Enter Your email... " 
                            required>
                        <span class="text-theme-6">
                            @error('extra_email')
                            {{$message}}
                            @enderror
                        </span>
                    </div> 

                    <div class="intro-y col-span-6 sm:col-span-6 px-2">
                        <div class="mb-2">Practice Location (Phone)*</div>
                        <input type="text" name="extra_phone" class="input w-full border flex-1" size="59"
                            value="{{ isset($record->extra_phone)?$record->extra_phone: old('extra_phone')  }}" placeholder="Enter Your phone... " 
                            required>
                        <span class="text-theme-6">
                            @error('extra_phone')
                            {{$message}}
                            @enderror
                        </span>
                    </div>
 
                

                    <div class="intro-y col-span-12 items-center justify-center sm:justify-end mt-5">
                        <button class="button w-full justify-center block bg-theme-1 text-white ml-2">{{ $text }}</button>
                    </div>
                </div>
        </form>
    </div>
</div>


<script>
$(document).ready(function() {

    
var readURL = function(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('.profile-pic').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}


$(".file-upload").on('change', function(){
    readURL(this);
});

$(".upload-button").on('click', function() {
   $(".file-upload").click();
});
});
</script>

<script>
const mySelect = document.getElementById("textSelect");
const inputOther = document.getElementById("form12");
const labelInput = document.getElementById("inputLabel");
const divInput = document.getElementById("inputDiv");
const selectDiv = document.getElementById("textSelectdiv");

mySelect.addEventListener('optionSelect.mdb.select', function(e){
const SelectValue = document.getElementById('textSelect').value;
if (SelectValue === 'customOption') {
inputOther.style.display='inline';
inputOther.removeAttribute('disabled');
labelInput.classList.remove('disaplayInput');
divInput.classList.remove('disaplayInput');
selectDiv.style.display='none';
inputOther.focus();
mySelect.disabled = 'true';

} else {
a.style.display='none';
}
})

function hideInput(){
if (inputOther !== null && inputOther.value === "")
{
inputOther.style.display='none';
inputOther.setAttribute('disabled', '');
selectDiv.style.display='inline';
mySelect.removeAttribute('disabled');
labelInput.classList.add('disaplayInput');
divInput.classList.add('disaplayInput');
}
}
</script>


@include('layouts.footer')