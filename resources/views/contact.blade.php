<?php
$pagename="contact";
// print_r($data);
// die($data);
?>

@include('layouts.header')



 <!-- Filepond stylesheet -->
 <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />


<div class="intro-y flex items-center mt-8">

    <h2 class="text-lg font-medium ml-3">
        Add Contact Information 
    </h2>
    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">

    </div>
    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">

    </div>
</div>

<div class="intro-y box pb-10">
    <div class="px-5 sm:px-20 mt-10 pt-10 border-t border-gray-200">
        <form  action="{{ route('contact_data') }}"  id="login_form" class="validate-form" method="post" enctype="multipart/form-data">
            @csrf
        

            <div class="grid grid-cols-12 gap-4 row-gap-5 mt-5">


                <div class="intro-y col-span-12 sm:col-span-12 px-2">
                    <div class="mb-2">Email*</div>
                    <input type="text" name="email" class="input w-full border flex-1" value="{{ isset($data->email)?$data->email: ''  }}"
                        placeholder="Enter The Email..."></input>
                    <span class="text-theme-6">
                        @error('email')
                        {{$message}}
                        @enderror
                    </span>
                </div>

                <div class="intro-y col-span-12 sm:col-span-12 px-2">
                    <div class="mb-2">Contact Number*</div>
                    <input type="text" name="contact" class="input w-full border flex-1"  value="{{ isset($data->contact)?$data->contact: ''  }}" 
                        placeholder="Enter The Contact Number..."></input>
                    <span class="text-theme-6">
                        @error('contact')
                        {{$message}}
                        @enderror
                    </span>
                </div>

        </div>

        <div class="intro-y col-span-12 items-center justify-center sm:justify-end mt-5">
            <button class="button w-full justify-center block bg-theme-1 text-white ml-2">Update</button>
        </div>
         
    </div>
    </form>

</div>

@include('layouts.footer')