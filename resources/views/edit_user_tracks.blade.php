<?php
$pagename = "users";
// print_r($data);
//  die($data);
?>
@include('layouts.header')

<meta name="csrf-token" content="{{ csrf_token() }}">

{{--
<script type="text/javascript">
    if (window.performance && window.performance.navigation.type == window.performance.navigation.TYPE_BACK_FORWARD) {

        location.href = "{{ route('dashboard') }}";

    }
</script> --}}

{{-- Filepond stylesheet --}}
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />


    <div class="intro-y flex items-center mt-8">

        <h2 class="text-lg font-medium ml-3">
            Edit Current CD Tracks Of "{{ $data->f_name }} {{ $data->l_name }}"
        </h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">

        </div>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">

        </div>
    </div>

    <div class="intro-y box pb-10">
        <div class="px-5 sm:px-20 mt-10 pt-10 border-t border-gray-200">
            <form action="{{ route('update_task_data') }}" id="login_form" class="validate-form" method="post"
                enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-12 gap-4 row-gap-5 mt-5">
                    <input type="hidden" class="form-control" id="query_id" name="user_id"
                        value="{{ isset($data->id)?$data->id: ''  }}">

                    <div class="intro-y col-span-6 sm:col-span-6 px-2">
                        <td>
                            <div class="mb-2">Current CD*</div>
                            <input class="input w-full border flex-1" type="text" name="time_assigned"
                                value="{{ isset($data->cds->current_cd)? " CD-". $data->cds->current_cd: '' }}"
                            disabled>

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
                            <input class="input w-full border flex-1"  min="30" step="30" type="number" name="time_assigned" list="cd"
                                value="{{ isset($data->cds->time_suggest)?$data->cds->time_suggest: ''  }}"
                                placeholder="Enter a minutes suggested for Current CD ..." required readonly>
                            <datalist id="cd" class="input w-full border flex-1" aria-label>
                                {{-- <option disabled selected>Select CD</option> --}}


                                <option value="900"></option>
                                <option value="1800"></option>
                                <option value="2700"></option>

                                {{-- <option value="12">Other</option> --}}


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
                            <input class="input w-full border flex-1"  min="60" type="number" name="time_assigned" list="cd"
                                value="{{ isset($data->cds->time_suggest)?$data->cds->time_suggest: ''  }}"
                                placeholder="Enter a minutes suggested for Current CD ..." required readonly>
                            <datalist id="cd" class="input w-full border flex-1" aria-label>
                                {{-- <option disabled selected>Select CD</option> --}}


                                <option value="900"></option>
                                <option value="1800"></option>
                                <option value="2700"></option>

                                {{-- <option value="12">Other</option> --}}


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
                                <input type="radio" class="input border mr-2" id="horizontal-radio-chris-evans"
                                    name="radio" value="one-hour-daily" {{ ($data->daily_time == '1') ?
                                "checked='checked'": "" }} disabled>
                                <label class="cursor-pointer select-none" for="horizontal-radio-chris-evans">One Hour
                                    Daily</label>
                            </div>
                            <div class="flex items-center text-gray-700 dark:text-gray-500 mr-2 mt-2 sm:mt-0">
                                <input type="radio" class="input border mr-2" id="horizontal-radio-liam-neeson"
                                    name="radio" value="half-hour-daily" {{ ($data->daily_time == '2')?
                                "checked='checked'": "" }}" disabled>
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
                                <?php $songs =  $data->tracks_data?>


                                <tr>
                                    <td><input type="file" name="filenames" class="input w-full border flex-1" multiple>
                                    </td>
                                </tr>
                            </table>
                            <span class="text-theme-6">
                                @error('filenames.*')
                                Minimum 1 Track is required
                                @enderror
                            </span>
                        </div>
                        @if($songs)
                        {{-- <form method="post" action="{{route('multiple_delete_tracks')}}">
                            {{ csrf_field() }} --}}
                            <th class="text-center"> <input type="checkbox" id="checkAll"><strong> Select All </strong>
                            </th>
                            <br></br>
                            @foreach($songs as $key => $track)

                            <div class="flex">
                                <input name='id[]' type="checkbox" id="checkItem" class="checkItem"
                                    value="<?php  echo $songs[$key]->id; ?>"> &nbsp;&nbsp;
                                <audio controls>
                                    <source
                                        src="{{ isset($track->tracks)?asset('/storage/tracks/'.$track->tracks): ''  }}"
                                        type="audio/mpeg">
                                </audio>
                                &nbsp;
                                <button style="border:none;" type="button" value="{{ $track->id }}"
                                    class="deletebtn btn-lg">

                                    <a class=" flex items-center text-theme-6" href="javascript:;" data-toggle="modal"
                                        data-target="#delete-modal-preview"> <svg xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            icon-name="trash" data-lucide="trash" class="lucide lucide-trash w-5 h-5">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path
                                                d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2">
                                            </path>
                                        </svg>
                                    </a>
                                </button>
                            </div>
                            &nbsp;
                            @endforeach
                            <br>
                            {{-- <button class="button text-white bg-theme-6 shadow-md mr-2" onclick="getInputArray()"
                                value="">Delete All Tracks</button> --}}

                            <button style="border:none;" type="button" onclick="getInputArray()"
                                class="deletebtn1 btn-lg">

                                <a class=" button text-white bg-theme-6 shadow-md mr-2" href="javascript:;"
                                    data-toggle="modal" data-target="#select-delete-modal-preview">Delete Selected
                                    Tracks</a>
                            </button>

                            {{--
                        </form> --}}
                        @endif
                    </div>

                    <div class="intro-y col-span-6 sm:col-span-6 px-2">
                    </div>

                    <br></br>
                    <br></br>


                    <div class="intro-y col-span-12 sm:col-span-12 px-2">
                        <div class="mb-2">Description (Optional)</div>
                        <textarea type="text" name="desc" class="input w-full border flex-1" size="59"
                            value="">{{ isset($data->cds->description)?$data->cds->description: ''  }}</textarea>
                        <span class="text-theme-6">
                            @error('desc')
                            {{$message}}
                            @enderror
                        </span>
                    </div>

                    <input id="alwaysFetch" type="hidden" />


                </div>

                <div class="intro-y col-span-12 items-center justify-center sm:justify-end mt-5">
                    <button class="button w-full justify-center block bg-theme-1 text-white ml-2">Update</button>
                </div>

        </div>
        </form>

        <div class="modal" id="delete-modal-preview">
            <div class="modal__content">
                <div class="p-5 text-center">
                    <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
                    <div class="text-3xl mt-5">Are you sure?</div>
                    <div class="text-gray-600 mt-2">Do you really want to delete This File? This process cannot be
                        undone.
                    </div>
                </div>
                <div class="px-5 pb-8 text-center">
                    <form type="submit" action="{{ route('delete_song') }}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="delete_track_id" id="deleting_id"></input>
                        <button type="button" data-dismiss="modal"
                            class="button w-24 border text-gray-700 mr-1">Cancel</button>
                        <button type="submit" class="button w-24 bg-theme-6 text-white p-3 pl-5 pr-5">Delete</button>
                        {{-- < button class="deleteRecord button w-24 bg-theme-6 text-white p-3 pl-5 pr-5"
                            id="deleting_id">Delete</button> --}}
                    </form>
                </div>
            </div>
        </div>

        <div class="modal" id="select-delete-modal-preview">
            <div class="modal__content">
                <div class="p-5 text-center">
                    <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
                    <div class="text-3xl mt-5">Are you sure?</div>
                    <div class="text-gray-600 mt-2">Do you really want to delete Selected Tracks? This process cannot be
                        undone.
                    </div>
                </div>
                <div class="px-5 pb-8 text-center">
                    <form type="submit" action="{{ route('multiple_delete_tracks') }}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="delete_track_ids[]" id="deleting_ids"></input>
                        <button type="button" data-dismiss="modal"
                            class="button w-24 border text-gray-700 mr-1">Cancel</button>
                        <button type="submit" class="button w-24 bg-theme-6 text-white p-3 pl-5 pr-5">Delete</button>
                        {{-- < button class="deleteRecord button w-24 bg-theme-6 text-white p-3 pl-5 pr-5"
                            id="deleting_id">Delete</button> --}}
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script>

        $('.checkItem').change(function () {
            let str = $('#deleting_ids').val()
            if (str) {
                str.split(',')
            }
            // else{
            //     str=[]
            //    }
            const value = $(this).val();

            if (this.checked) {
                return $('#deleting_ids').val(`${str}${value},`);

            }
            const arr = str.split(',');
            const newArr = arr.filter(item => item != value);

            return $('#deleting_ids').val(newArr);
        });

        $('#checkAll').change(function () {
            if (this.checked) {
                var str = $("input[name='id[]']").map(function () { return $(this).val(); }).get();
                return $('#deleting_ids').val(str);
            }
            return $('#deleting_ids').val([]);

        });






        function getInputArray() {
            const str = $('#deleting_ids').val();
            console.log(str);

        }
    </script>

    <script language="javascript">
        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>

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


    <script>

        $(document).on('click', '.deletebtn', function () {
            var user_id = $(this).val();
            $('#deleting_id').val(user_id);
        });

// $(".deleteRecord").click(function(){
//     var id = $(this).val();
//     var token = $("meta[name='csrf-token']").attr("content");

//     $.ajax(
//     {
//         url: "delete_song/"+id,
//         type: 'DELETE',
//         data: {
//             "id": id,
//             "_token": token,
//         },
//         success: function (){
//             console.log("it Works");
//         }
//     });

// });
// </script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function () {
                $('#login_form').submit(function (e) {
                    $('#loaderIcon').css('visibility', 'visible');
                    $('#loaderIcon').show();
                });
            })
        </script>




        @include('layouts.footer')