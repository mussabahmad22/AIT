<?php
$pagename="users";
?>
@include('layouts.header')




<div class="intro-y flex items-center mt-8">

    <h2 class="text-lg font-medium ml-3">
        User Details
    </h2>
    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">

    </div>
    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">

    </div>
</div>

<div class="overflow-x-auto intro-y box pb-10">
    <div class="px-5 sm:px-20 mt-10 pt-10 border-t border-gray-200">
        <form action="" class="validate-form">

            <div class="grid grid-cols-12 gap-4 row-gap-5 mt-5">
                <input type="hidden" class="form-control" id="query_id" name="user_id"
                    value="{{ isset($record->id)?$record->id: ''  }}">
                <div class="intro-y col-span-6 sm:col-span-6 px-2">
                    <div class="mb-2">First Name*</div>
                    <input type="text" name="f_name" class="input w-full border flex-1"
                        value="{{ isset($record->f_name)?$record->f_name: ''  }}" placeholder="Enter the first name..."
                        disabled>
                    <span class="text-theme-6">
                        @error('f_name')
                        {{'User Name is required'}}
                        @enderror
                    </span>
                </div>

                <div class="intro-y col-span-6 sm:col-span-6 px-2">
                    <div class="mb-2">Last Name*</div>
                    <input type="text" name="l_name" class="input w-full border flex-1"
                        value="{{ isset($record->l_name)?$record->l_name: ''  }}" placeholder="Enter the last name..."
                        disabled>
                    <span class="text-theme-6">
                        @error('l_name')
                        {{'User Name is required'}}
                        @enderror
                    </span>
                </div>

                <div class="intro-y col-span-6 sm:col-span-6 px-2">
                    <div class="mb-2">Client ID*</div>
                    <input type="text" name="client_id" class="input w-full border flex-1" size="59"
                        value="{{ isset($record->client_id)?$record->client_id: ''  }}" placeholder="Enter Your ID..."
                        disabled>
                    <span class="text-theme-6">
                        @error('client_id')
                        {{$message}}
                        @enderror
                    </span>
                </div>

                <div class="intro-y col-span-6 sm:col-span-6 px-2">
                    <div class="mb-2">Phone Number*</div>
                    <input type="text" name="phone" class="input w-full border flex-1"
                        value="{{ isset($record->phone)?$record->phone: ''  }}" placeholder="Enter Number..." disabled>
                    <span class="text-theme-6">
                        @error('phone')
                        {{'User phone is required'}}
                        @enderror
                    </span>
                </div>


                <div class="intro-y col-span-6 sm:col-span-6 px-2">
                    <div class="mb-2">Previous Completed Minutes*</div>
                    <input type="number" name="complete_hour" class="input w-full border flex-1"
                        value="{{ isset($record->complete_hour)?$record->complete_hour: ''  }}"
                        placeholder="Enter The Hours..." disabled>
                    <span class="text-theme-6">
                        @error('complete_hour')
                        {{'Preview Complete Hour is required'}}
                        @enderror
                    </span>
                </div>

                <div class="intro-y col-span-6 sm:col-span-6 px-2">
                    <div class="mb-2">Password*</div>
                    <input type="text" name="password" id="password" class="input w-full border flex-1" size="59"
                        value="{{ isset($record->password)?$record->password: ''  }}" placeholder="Enter Password..."
                        disabled>

                    <span class="text-theme-6">
                        @error('password')
                        {{$message}}
                        @enderror
                    </span>
                </div>

                <div class="intro-y col-span-6 sm:col-span-6 px-2">
                    <div class="mb-2">Time Assigned for {{ isset($details->current_cd) ? 'CD-'. $details->current_cd: ''
                        }}*</div>
                    <input type="text" name="complete_hour" class="input w-full border flex-1"
                        value="{{ isset($details->time_suggest)?$details->time_suggest. ' minutes': 'N/A'  }} "
                        placeholder="N/A" disabled>
                    <span class="text-theme-6">
                        @error('complete_hour')
                        {{'Preview Complete Hour is required'}}
                        @enderror
                    </span>
                </div>

                <?php if($record->active_status == 2){ $value = 'completed'; }elseif($record->active_status == 0){ $value = 'In Progress'; }elseif($record->active_status == 1){ $value = 'Inactive'; } ?>

                <div class="intro-y col-span-6 sm:col-span-6 px-2">
                    <div class="mb-2">Status*</div>
                    <input type="number" name="complete_hour" class="input w-full border flex-1" value="{{ $value }}"
                        placeholder="<?php if($record->active_status == 2){ echo'Completed'; }elseif($record->active_status == 0){ echo'In Progress'; }elseif($record->active_status == 1){ echo'Inactive'; } ?>"
                        disabled>

                </div>

                <div class="intro-y col-span-6 sm:col-span-6 px-2">
                    <div class="mb-2">Time Listened for Current CD *</div>
                    <input type="number" name="complete_hour" class="input w-full border flex-1"
                        value="{{ isset($record->time_listened)?$record->time_listened: 'N/A'  }}" placeholder="N/A"
                        disabled>
                    <span class="text-theme-6">
                        @error('complete_hour')
                        {{'Preview Complete Hour is required'}}
                        @enderror
                    </span>
                </div>



                <div class="intro-y col-span-6 sm:col-span-6 px-2">
                    <div class="mb-2">Time Remaining for Current CD*</div>
                    <input type="number" name="complete_hour" class="input w-full border flex-1"
                        value="{{ isset($record->time_remain)?$record->time_remain: 'N/A'  }}" placeholder="N/A"
                        disabled>
                    <span class="text-theme-6">
                        @error('complete_hour')
                        {{'Preview Complete Hour is required'}}
                        @enderror
                    </span>
                </div>

                <div class="intro-y col-span-6 sm:col-span-6 px-2">
                    <div class="mb-2">Last Active day*</div>
                    <input type="text" name="complete_hour" class="input w-full border flex-1"
                        value="{{ isset($record->last_day_active) ? $record->last_day_active: 'N/A'  }}"
                        placeholder="N/A" disabled>
                    <span class="text-theme-6">
                        @error('complete_hour')
                        {{'Preview Complete Hour is required'}}
                        @enderror
                    </span>
                </div>

                <div class="intro-y col-span-6 sm:col-span-6 px-2">
                    <div class="mb-2">Total CD's In Plan*</div>
                    <input type="number" name="complete_hour" class="input w-full border flex-1"
                        value="{{ isset($record->total_cds) ? $record->total_cds: 'N/A'  }}" placeholder="N/A" disabled>
                    <span class="text-theme-6">
                        @error('complete_hour')
                        {{'Preview Complete Hour is required'}}
                        @enderror
                    </span>
                </div>

                <div class="intro-y col-span-6 sm:col-span-6 px-2">
                    <div class="mb-2">Current CD*</div>
                    <input type="text" name="complete_hour" class="input w-full border flex-1"
                        value="{{ isset($data) ? 'CD-'. $data: ''  }}" placeholder="N/A"
                        disabled>
                    <span class="text-theme-6">
                        @error('complete_hour')
                        {{'Preview Complete Hour is required'}}
                        @enderror
                    </span>
                </div>


                <div class="intro-y col-span-6 sm:col-span-6 px-2">
                    <div class="mb-2"> Selected CD*</div>
                    <input type="text" name="complete_hour" class="input w-full border flex-1"
                        value="{{ isset($details->current_cd) ? 'CD-'. $details->current_cd: ''  }}" placeholder="N/A"
                        disabled>
                    <span class="text-theme-6">
                        @error('complete_hour')
                        {{'Preview Complete Hour is required'}}
                        @enderror
                    </span>
                </div>


                {{-- <div class="intro-y col-span-6 sm:col-span-6 px-2">
                    <div class="mb-2"><strong> Select CD To View Data *</strong></div>
                    <select name="status" onchange="changeStatus({{$record->id}},this.value)"
                        class="input w-full border flex-1 " id="" class="category" aria-label value="">

                        <option disabled selected>Select CD To View Data</option>

                        @for ($i = 1; $i <= $data; $i++) <option value="{{ $i }}">CD {{ $i }}</option>
                            @endfor

                    </select>
                </div> --}}

                <div class="intro-y col-span-6 sm:col-span-6 px-2">
                    <div class="mb-2"> Upload Date*</div>
                    <input type="text" name="complete_hour" class="input w-full border flex-1"
                        value="{{ isset($details->upload_date) ?$details->upload_date: 'N/A'  }}" placeholder="N/A"
                        disabled>
                    <span class="text-theme-6">
                        @error('complete_hour')
                        {{'Preview Complete Hour is required'}}
                        @enderror
                    </span>
                </div>

                <div class="intro-y col-span-6 sm:col-span-6 px-2">
                    <div class="mb-2"> Completed CD Date*</div>
                    <input type="text" name="complete_hour" class="input w-full border flex-1"
                        value="{{ isset($details->completed_date) ?$details->completed_date: 'N/A'  }}"
                        placeholder="N/A" disabled>
                    <span class="text-theme-6">
                        @error('complete_hour')
                        {{'Preview Complete Hour is required'}}
                        @enderror
                    </span>
                </div>


                <div class="intro-y col-span-12 sm:col-span-12 px-2">
                    <div class="mb-2"> Description*</div>
                    <textarea type="text" name="complete_hour" class="input w-full border flex-1" value=""
                        placeholder="N/A"
                        disabled>{{ isset($details->description) ? $details->description: ''  }}</textarea>
                    <span class="text-theme-6">
                        @error('complete_hour')
                        {{'Preview Complete Hour is required'}}
                        @enderror
                    </span>
                </div>


                <div class="intro-y col-span-12 sm:col-span-12 px-2">
                    {{-- <label>Horizontal Radio Button</label> --}}
                    <div class="flex flex-col sm:flex-row mt-2">
                        <div class="flex items-center text-gray-700 dark:text-gray-500 mr-2">
                            <input type="radio" class="input border mr-2" id="horizontal-radio-chris-evans" name="radio"
                                value="one-hour-daily" <?php if(isset($record)){ if($record->daily_time == '1') { echo
                            "checked='checked'"; } } ?> disabled>
                            <label class="cursor-pointer select-none" for="horizontal-radio-chris-evans">One Hour
                                Daily</label>
                        </div>
                        <div class="flex items-center text-gray-700 dark:text-gray-500 mr-2 mt-2 sm:mt-0">
                            <input type="radio" class="input border mr-2" id="horizontal-radio-liam-neeson" name="radio"
                                value="half-hour-daily" <?php if(isset($record)){ if($record->daily_time == '2') { echo
                            "checked='checked'"; } }?> disabled>
                            <label class="cursor-pointer select-none" for="horizontal-radio-liam-neeson">Half Hour
                                Daily</label>
                        </div>
                        <div class="flex items-center text-gray-700 dark:text-gray-500 mr-2 mt-2 sm:mt-0">
                            <input type="radio" class="input border mr-2" id="horizontal-radio-daniel-craig"
                                name="radio" value="half-hour-twice-daily" <?php if(isset($record)){
                                if($record->daily_time == '3') { echo "checked='checked'"; } }?> disabled >
                            <label class="cursor-pointer select-none" for="horizontal-radio-daniel-craig">Half Hour
                                Twice Daily</label>
                        </div>
                    </div>
                </div>

                <div class="intro-y col-span-3 sm:col-span-3 px-2">



                    @if($data == 0)
                    {{-- <button class="button text-white bg-theme-42"> 
                    <a class="flex items-center  mr-3  text-white"
                        href="{{route('upload_tasks_show',['id' => $record->id])}}">
                        <i data-feather="send" class="w-4 h-4 mr-1"></i> Upload </a>
                    </button> --}}

                    <a href="{{route('upload_tasks_show',['id' => $record->id])}}" class="flex items-center mr-3 button text-white bg-theme-42" style="text-decoration: none; margin-right: 220px !important;">
                        <i data-feather="send" class="w-4 h-4 mr-1"></i> Upload
                    </a>

                    @elseif($record->total_cds > 0)
                    @if($record->total_cds != $data)
                        @if($record->time_listened == $record->time_assigned)

                             <a href="{{route('upload_tasks_show',['id' => $record->id])}}" class="flex items-center mr-3 button text-white bg-theme-42" style="text-decoration: none; margin-right: 220px !important;">
                                <i data-feather="send" class="w-4 h-4 mr-1"></i> Upload
                            </a>

                            {{-- <button class="button text-white bg-theme-42"> 
                            <a class="flex items-center mr-3  text-white"
                                href="{{route('upload_tasks_show',['id' => $record->id])}}">
                                <i data-feather="send" class="w-4 h-4 mr-1"></i> Upload </a>
                            </button> --}}
                        @else 
                            <button class="button text-white bg-theme-42"> Current CD Completed First</button>
                        @endif
                    @else
                    <button class="button text-white bg-theme-42">All CD's Uploaded</button>
                    @endif
                    @endif


                </div>

                <div class="intro-y col-span-3 sm:col-span-3 px-2">

                    {{-- <a
                    href="{{route('edit_tasks_show',['id' => $record->id])}}"> <button class="button text-white bg-theme-42 shadow-md mr-2">Edit Tracks Of Current CD</button></a> --}}

                    <a href="{{ route('edit_tasks_show', ['id' => $record->id]) }}" class="flex items-center button text-white bg-theme-42 shadow-md mr-2" style="text-decoration: none; margin-right: 100px !important;">
                        <i data-feather="edit" class="w-4 h-4 mr-1"></i> Edit Tracks Of Current CD
                    </a>


                </div>

                <div class="intro-y col-span-3 sm:col-span-3 px-2">


                    {{-- <a class="flex items-center mr-3 "
                    href="{{route('breakdown',['id' => $record->id])}}"> <button class="button text-white bg-theme-42"> 
                            <i data-feather="eye" class="w-4 h-4 mr-1"></i> Listening Time Breakdown  </button></a> --}}

                            <a href="{{ route('breakdown', ['id' => $record->id]) }}" class="flex items-center mr-3 button text-white bg-theme-42" style="text-decoration: none; margin-right: 100px !important;">
                                <i data-feather="eye" class="w-4 h-4 mr-1"></i> Listening Time Breakdown
                            </a>

                            

                          


                </div>
                
                <div class="intro-y col-span-3 sm:col-span-3 px-2">

                    <select name="status" onchange="changeStatus({{$record->id}},this.value)"
                        class="button text-white bg-theme-42 shadow-md mr-2"  aria-label value="">

                        <option disabled selected>Select CD To View Data</option>

                        @for ($i = 1; $i <= $data; $i++) 
                        <option value="{{ $i }}">CD {{ $i }}</option>
                        @endfor

                    </select>

                </div>


       



                @if($songs == !NULL)
                <?php  $i = 0; ?>
                @foreach($songs as $song)
                <?php $i++; ?>

                <div class="intro-y col-span-6 sm:col-span-6 px-2">
                    <div class="mb-2"> Track {{ $i }}</div>
                    <audio controls>
                        <source src="{{ isset($song->tracks)?asset('/storage/tracks/'.$song->tracks): '' }}"
                            type="audio/mpeg">
                    </audio>

                </div>
                @endforeach

                @endif

            </div>
        </form>
    </div>
</div>

<script>
    function changeStatus(id, val) {
        console.log(id);
        console.log(val);

        window.location.href = "/user_details/" + id + "/cd_data/" + val;






        // $.ajax({
        //     url: "/user_details/"+id+"/cd_data/"+"val",
        //     data: {
        //         id: id,
        //         val: val
        //     },
        //     success: function (result) {
        //         swal({
        //             title: "View CD Data",
        //             text: "Data Changed According to Selected CD Please View!",
        //             icon: "success",
        //             button: "OK",
        //         });
        //     }
        // });
    }
</script>


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


@include('layouts.footer')