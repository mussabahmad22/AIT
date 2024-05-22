<?php
$pagename="users";
// print_r($data);
// die($data);
?>

@include('layouts.header')

<script type="text/javascript">
    if (window.performance && window.performance.navigation.type == window.performance.navigation.TYPE_BACK_FORWARD) {
        
        location.href = "{{ route('dashboard') }}";
       
    }
</script>

 <!-- Filepond stylesheet -->
 <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />


<div class="intro-y flex items-center mt-8">

    <h2 class="text-lg font-medium ml-3">
        {{ $data->f_name }} {{ $data->l_name }}
    </h2>
    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">

    </div>
    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">

    </div>
</div>

<div class="intro-y box pb-10">
    <div class="px-5 sm:px-20 mt-10 pt-10 border-t border-gray-200">
        <form  action="{{ route('task_data') }}"  id="login_form" class="validate-form" method="post" enctype="multipart/form-data">
            @csrf
        
            <?php if($data->cds != ""){  $x= $data->cds->current_cd + 1; } else{  $x=1; } ?> 

            <div class="grid grid-cols-12 gap-4 row-gap-5 mt-5">
                <input type="hidden" class="form-control" id="query_id" name="user_id"
                    value="{{ isset($data->id)?$data->id: ''  }}">

                <div class="intro-y col-span-6 sm:col-span-6 px-2">
                    <td>
                        <div class="mb-2">Select Current CD*</div>
                        <select name="current_cd" id="" class="input w-full border flex-1" aria-label required>
                            <option disabled selected>Total CD's In Plan is "{{ $data->total_cds }}"</option>

                            {{-- @for ($i = $x ; $i <= $data->total_cds; $i++) --}}
                            <option value="{{ $x }}">CD {{ $x }}</option>
                            {{-- @endfor --}}

                        </select>
                        <span class="text-theme-6">
                            @error('current_cd')
                            {{ $message }}
                            @enderror
                        </span>
                    </td>
                </div>
                @if($data->daily_time == 2)
                <div class="intro-y col-span-6 sm:col-span-6 px-2">
                    <td>
                        <div class="mb-2">Total Minutes Suggested for Current CD*</div>
                        <input class="input w-full border flex-1" type="number" min="30" step="30" name="time_assigned" list="cd" placeholder="Enter a minutes suggested for Current CD ..." required>
                        <datalist  id="cd" class="input w-full border flex-1" aria-label>
                            {{-- <option disabled selected>Select CD</option> --}}
                          

                            <option value="900" ></option>
                            <option value="1800"></option>
                            <option value="2700"></option>
              
                            {{-- <option value="12" >Other</option> --}}

        
                        </datalist>
                        <span class="text-theme-6">
                            @error('time_assigned')
                            {{ $message }}
                            @enderror
                        </span>
                    </td>
                </div>
                @endif

                @if($data->daily_time == 1 || $data->daily_time == 3 )
                <div class="intro-y col-span-6 sm:col-span-6 px-2">
                    <td>
                        <div class="mb-2">Total Minutes Suggested for Current CD*</div>
                        <input class="input w-full border flex-1" type="number" min="60" step="60" name="time_assigned" list="cd" placeholder="Enter a minutes suggested for Current CD ..." required>
                        <datalist  id="cd" class="input w-full border flex-1" aria-label>
                            {{-- <option disabled selected>Select CD</option> --}}
                          

                            <option value="900" ></option>
                            <option value="1800"></option>
                            <option value="2700"></option>
              
                            {{-- <option value="12" >Other</option> --}}

        
                        </datalist>
                        <span class="text-theme-6">
                            @error('time_assigned')
                            {{ $message }}
                            @enderror
                        </span>
                    </td>
                </div>
                @endif

           
                <div class="intro-y col-span-12 sm:col-span-12 px-2">
                    {{-- <label>Horizontal Radio Button</label> --}}
                    <div class="flex flex-col sm:flex-row mt-2">
                        <div class="flex items-center text-gray-700 dark:text-gray-500 mr-2">
                            <input type="radio" class="input border mr-2" id="horizontal-radio-chris-evans" name="radio"
                                value="one-hour-daily" {{ ($data->daily_time == '1') ? "checked='checked'": "" }} disabled>
                            <label class="cursor-pointer select-none" for="horizontal-radio-chris-evans">One Hour
                                Daily</label>
                        </div>
                        <div class="flex items-center text-gray-700 dark:text-gray-500 mr-2 mt-2 sm:mt-0">
                            <input type="radio" class="input border mr-2" id="horizontal-radio-liam-neeson" name="radio"
                                value="half-hour-daily" {{ ($data->daily_time == '2')? "checked='checked'": "" }}" disabled>
                            <label class="cursor-pointer select-none" for="horizontal-radio-liam-neeson">Half Hour
                                Daily</label>
                        </div>
                        <div class="flex items-center text-gray-700 dark:text-gray-500 mr-2 mt-2 sm:mt-0">
                            <input type="radio" class="input border mr-2" id="horizontal-radio-daniel-craig"
                                name="radio" value="half-hour-twice-daily" {{ ($data->daily_time == '3')?
                            "checked='checked'": "" }} disabled>
                            <label class="cursor-pointer select-none" for="horizontal-radio-daniel-craig">Half Hour
                                Twice Daily</label>
                        </div>
                    </div>
                    <br></br>
                </div>           

            <div class="intro-y col-span-6 sm:col-span-6 px-2">

                <div class="table-responsive">
                    <table class="table align-items-center mb-0" id="dynamicAddRemove">
                        <tr>
                            <th>Add Multiple Tracks(Atleast One*)</th>
                        </tr>
                      
                        <tr>
                            <td><input type="file" name="filenames"
                                    class="input w-full border flex-1"   multiple  required></td>
                        </tr>
                    </table>
                    <span class="text-theme-6">
                        @error('filenames.*')
                        Minimum 1 Track is required
                        @enderror
                    </span>
                </div>
            </div>
            
            
            <div class="intro-y col-span-6 sm:col-span-6 px-2">
            </div>
{{-- 
            <img id="loaderIcon" style="visibility:hidden; display:none " 
            src="https://wh717090.ispot.cc/auditory-integration/public/assets/dist/loading.gif" alt="..."/> --}}

            <br></br>
            <br></br>

          


            <div class="intro-y col-span-12 sm:col-span-12 px-2">
                <div class="mb-2">Description (Optional)</div>
                <textarea type="text" name="desc" class="input w-full border flex-1" size="59"
                    placeholder="Enter The Other Details..."></textarea>
                <span class="text-theme-6">
                    @error('desc')
                    {{$message}}
                    @enderror
                </span>
            </div>

            <input id="alwaysFetch" type="hidden" />


        </div>

        <div class="intro-y col-span-12 items-center justify-center sm:justify-end mt-5">
            <button class="button w-full justify-center block bg-theme-1 text-white ml-2">Save</button>
        </div>
         
    </div>
    </form>

</div>

<script>
    setTimeout(function () {
        var el = document.getElementById('alwaysFetch');
        el.value = el.value ? location.reload() : true;
    }, 0);
</script>

<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<script>
    // Get a reference to the file input element
    const inputElement = document.querySelector('input[type="file"]');

    // Create a FilePond instance
    const pond = FilePond.create(inputElement);

    FilePond.setOptions({
    server: {
        process: '{{ route('tmpUpload') }}',
        revert: '{{ route('tmpDelete') }}',
        chunkSize: '1Mb', // 1 MB
        chunkUploads: true,
        headers: {

            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
 
    },
});
</script>


</script>

<!--  script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" 
crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        $('#login_form').submit(function(e) {
            $('#loaderIcon').css('visibility', 'visible');
            $('#loaderIcon').show();
        });
    })
</script>




@include('layouts.footer')