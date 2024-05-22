<?php
$pagename="profile";
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
        Update Profile
    </h2>
  
</div>

<div class="intro-y box pb-10">
    <div class="px-5 sm:px-20 mt-10 pt-10 border-t border-gray-200">
        <form action="{{ route('profile_data') }}" class="validate-form" method="post" enctype="multipart/form-data">
            @csrf
     

                <div class="grid grid-cols-12 gap-4 row-gap-5 mt-5">
                  
                    <div class="intro-y col-span-6 sm:col-span-6 px-2">
                        <div class="mb-2">Name*</div>
                        <input type="text" name="f_name" class="input w-full border flex-1"
                            value="{{ isset($record->f_name)?$record->f_name: '' }}"
                            placeholder="Enter the first name..." required>
                        <span class="text-theme-6">
                            @error('f_name')
                            {{'Name is required'}}
                            @enderror
                        </span>
                    </div>

                    <div class="intro-y col-span-6 sm:col-span-6 px-2">
                        <div class="mb-2">Email*</div>
                        <input type="text" name="email" class="input w-full border flex-1"
                            value="{{ isset($record->email)?$record->email: '' }}"
                            placeholder="Enter the last name..." required>
                        <span class="text-theme-6">
                            @error('email')
                            {{'Email is required'}}
                            @enderror
                        </span>
                    </div>

                    <div class="intro-y col-span-6 sm:col-span-6 px-2">
                        <div class="mb-2"> Old Password</div>
                        <input type="text" name="old_password"  class="input w-full border flex-1" size="59"
                             placeholder="Enter your old Password...">
                        <span class="text-theme-6">
                            @error('old_password')
                            {{$message}}
                            @enderror
                        </span>
                    </div>


             
                    <div class="intro-y col-span-6 sm:col-span-6 px-2">
                        <div class="mb-2">New Password</div>
                        <input type="password" name="new_password" id="password" class="input  border flex-1" size="59"
                            placeholder="Enter new password..."
                            >
                            <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        <span class="text-theme-6">
                            @error('new_password')
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


                    <div class="intro-y col-span-12 items-center justify-center sm:justify-end mt-5">
                        <button class="button w-full justify-center block bg-theme-1 text-white ml-2">Update</button>
                    </div>
                </div>
        </form>
    </div>
</div>






@include('layouts.footer')