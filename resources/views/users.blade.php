<?php
$pagename = 'users';
use App\Models\User;
use App\Models\UserDetail;

date_default_timezone_set('America/Los_Angeles');

// dd($data);
// dd($current_time  , $time);

foreach ($data as $list) {
    $details = UserDetail::where('user_id', $list->id)
        ->orderBy('current_cd', 'desc')
        ->first();

    if ($details) {
        $upload_date_time = $details->upload_date;

        $time1 = date('H:i:s', strtotime('11 PM'));

        $current_time1 = date('Y-m-d H:i:s');

        // dd($current_time1);

        $time = strtotime($upload_date_time . ' ' . $time1);
        //    dd($time);
        $current_time = strtotime($current_time1);

        // dd($time);

        if ($list->upload_status == 1 && $list->time_listened == 0 && $list->resolved_status == 0 && $current_time > $time) {
            $user = User::find($list->id);
            $user->error_status = 1;
            $user->save();
        }

        if ($list->daily_time == 1 && $list->resolved_status == 0) {
            if ($list->time_listened < 60 && $list->time_listened > 3) {
                $user = User::find($list->id);
                $user->error_status = 2;
                $user->save();
            }
        } elseif ($list->daily_time == 2 && $list->resolved_status == 0) {
            if ($list->time_listened < 30 && $list->time_listened > 3) {
                $user = User::find($list->id);
                $user->error_status = 2;
                $user->save();
            }
        } elseif ($list->daily_time == 3 && $list->resolved_status == 0) {
            if ($list->time_listened < 60 && $list->time_listened > 3) {
                $user = User::find($list->id);
                $user->error_status = 2;
                $user->save();
            }
        }

        if ($list->resolved_status == 0 && $list->time_listened == $list->time_assigned) {
            $user = User::find($list->id);
            $user->error_status = 0;
            $user->save();
        }
    }
}
?>
@include('layouts.header')

{{-- <script type="text/javascript">
    if (window.performance && window.performance.navigation.type == window.performance.navigation.TYPE_BACK_FORWARD) {
        
        location.href = "{{ route('dashboard') }}";
       
    }
</script> --}}


<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto ml-2">
        List of Users
    </h2>

    <!-- <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
        <button style="border:none;" type="button" class="button text-white bg-theme-42 shadow-md mr-2">
            <select name="status" class=" border-0 bg-theme-42 shadow-md mr-2 " name="month" id="" class="category"
                aria-label value="" onchange="window.location.href='/users_by_status/'+this.value">
                <option value="3" <?php echo $value == 3 ? 'selected' : ''; ?>>All Users</option>
                <option value="0" <?php echo $value == 0 ? 'selected' : ''; ?>>In Progress Users</option>
                <option value="1"<?php echo $value == 1 ? 'selected' : ''; ?> >Inactive Users</option>
                <option value="2" <?php echo $value == 2 ? 'selected' : ''; ?>>Completed</option>
      
            </select>
        </button>
    </div> -->


    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
        {{-- <button class="button text-white bg-theme-42 shadow-md mr-2"><a href="{{route('add_users_show')}}">Add New
                User</a></button> --}}

        <a href="{{ route('add_users_show') }}" class="flex items-center mr-2 button text-white bg-theme-42"
            style="text-decoration: none; margin-right: 2px !important;">
            <i data-feather="send" class="w-4 h-4 mr-1"></i> Add New User
        </a>
    </div>
    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">

    </div>
</div>


<!-- BEGIN: Datatable -->
<div class="overflow-x-auto intro-y datatable-wrapper box p-5 mt-5">
    <table class="table table-report table-report--bordered display datatable w-full">
        <thead>
            <tr>

                <th class="border-b-2  whitespace-no-wrap">
                    LastName</th>

                <th class="border-b-2  whitespace-no-wrap">
                    FirstName</th>

                <th class="border-b-2  whitespace-no-wrap">
                    LastActive</th>

                <th class="border-b-2  whitespace-no-wrap">
                    Client ID</th>

                <th class="border-b-2  whitespace-no-wrap">
                    <button style="border:none;" type="button" class="button text-black shadow-md mr-2">
                        <select name="status" class=" border-0 shadow-md mr-2 " name="month" id=""
                            class="category" aria-label value=""
                            onchange="window.location.href='/users_by_status/'+this.value">
                            <option value="3" <?php echo $value == 3 ? 'selected' : ''; ?>>Status*</option>
                            <option value="0" <?php echo $value == 0 ? 'selected' : ''; ?>>In Progress Users</option>
                            <option value="1"<?php echo $value == 1 ? 'selected' : ''; ?>>Inactive Users</option>
                            <option value="2" <?php echo $value == 2 ? 'selected' : ''; ?>>Completed</option>

                        </select>
                    </button>
                </th>

                <th class="border-b-2  whitespace-no-wrap">
                    Total CD</th>

                <th class="border-b-2  whitespace-no-wrap">
                    Time Used</th>

                <th class="border-b-2  whitespace-no-wrap">
                    T-Suggested</th>

                <th class="border-b-2  whitespace-no-wrap">
                    T-Left</th>

                <th class="border-b-2  whitespace-no-wrap"> {{-- Total minutes for all CD's --}}
                    #CD Plan</th>

                <th class="border-b-2  whitespace-no-wrap">
                    Now CD</th>

                <th class="border-b-2  whitespace-no-wrap">
                    Completed Minutes</th>

                <th class="border-b-2  whitespace-no-wrap">
                    Tracks</th>


                <th class="border-b-2  whitespace-no-wrap">
                    Error</th>

                <th class="border-b-2  whitespace-no-wrap">
                    Actions</th>

            </tr>
        </thead>

        <tbody>

            @foreach ($data as $value)

                @if ($value->error_status == 0)

                    <tr>

                        <td>
                            <a href="{{ route('user_details', ['id' => $value->id]) }}"> {{ $value->l_name }} </a>
                        </td>
                        <td>
                            <a href="{{ route('user_details', ['id' => $value->id]) }}"> {{ $value->f_name }} </a>
                        </td>
                        <td>
                            {{ $value->last_day_active ? $value->last_day_active : 'N/A' }}
                        </td>
                        <td>
                            {{ $value->client_id }}
                        </td>
                        <td>
                            <button style="border:none;" type="button" class="button text-black shadow-md mr-2">
                                <select name="status" class=" border-0 shadow-md mr-2 " name="month" id=""
                                    class="category" aria-label value=""
                                    onchange="window.location.href='/change_status_operator/'+ {{ $value->id }} +'/'+ this.value">
                                    <option value="0" <?php echo $value->active_status == 0 ? 'selected' : ''; ?>>In Progress User</option>
                                    <option value="1"<?php echo $value->active_status == 1 ? 'selected' : ''; ?>>Inactive User</option>
                                    <option value="2" <?php echo $value->active_status == 2 ? 'selected' : ''; ?>>Completed</option>

                                </select>
                            </button>
                        </td>
                        <td>
                            {{ $value->total_cds }}
                        </td>

                        <td>
                            {{ $value->time_listened ? $value->time_listened . ' mins' : '0' }}
                        </td>
                        <td>
                            {{ $value->time_assigned ? $value->time_assigned . ' mins' : '0' }}
                        </td>
                        <td>
                            {{ $value->time_remain ? $value->time_remain : '0' }}
                        </td>
                        <td>
                            {{ $value->total_minutes }} mins
                        </td>
                        <td>
                            <?php if ($value->cds == '') {
                                echo 'N/A';
                            } else {
                                echo $value->cds->current_cd;
                            } ?>
                        </td>


                        <td>
                            {{ $value->complete_hour }} mins
                        </td>

                        {{-- <td>
                    <?php if ($value->active_status == 0) {
                        echo 'In Progress';
                    } elseif ($value->active_status == 1) {
                        echo 'Delayed';
                    } elseif ($value->active_status == 2) {
                        echo 'Completed';
                    } ?>
                </td> --}}


                        <td>

                            @if ($value->cds == '')
                                <a class="flex items-center text-theme-1 mr-3 text-primary"
                                    href="{{ route('upload_tasks_show', ['id' => $value->id]) }}">
                                    <i data-feather="send" class="w-4 h-4 mr-1"></i> Upload </a>
                            @elseif($value->cds)
                                @if ($value->total_cds != $value->cds->current_cd)
                                    @if ($value->time_listened == $value->time_assigned)
                                        <a class="flex items-center text-theme-1 mr-3  text-primary"
                                            href="{{ route('upload_tasks_show', ['id' => $value->id]) }}">
                                            <i data-feather="send" class="w-4 h-4 mr-1"></i> Upload </a>
                                    @else
                                        Current CD-{{ $value->cds->current_cd }} in Progress
                                    @endif
                                @else
                                    All CD's Uploaded
                                @endif
                            @endif
                        </td>


                        <td>

                            <button style="border:none;" type="button" class="button text-black shadow-md mr-2"
                                disabled>

                                <?php if ($value->error_status == 0) {
                                    echo 'No Error';
                                } elseif ($value->error_status == 1) {
                                    echo 'No Report';
                                } elseif ($value->error_status == 2) {
                                    echo 'Use Time';
                                } ?>

                            </button>

                            {{-- <button style="border:none;" type="button" onchange="window.location.href=" class="button  text-black shadow-md mr-2">Resolved</button> --}}
                        </td>

                        <td>
                            <a class="flex items-center text-theme-1 mr-3  text-primary"
                                href="{{ route('user_details', ['id' => $value->id]) }}">
                                <i data-feather="eye" class="w-4 h-4 mr-1"></i> view </a>

                            <a class="flex items-center text-theme-1 mr-1"
                                href="{{ route('edit_user', ['id' => $value->id]) }}"><i data-feather="edit"
                                    class="w-4 h-4 mr-1"></i>
                                Edit </a>
                            <button style="border:none;" type="button" value="{{ $value->id }}"
                                class="deletebtn btn"><a class=" flex items-center text-theme-6" href="javascript:;"
                                    data-toggle="modal" data-target="#delete-modal-preview"> <i data-feather="trash-2"
                                        class="w-4 h-4 mr-1"></i>
                                    Delete </a>
                            </button>

                            <button style="border:none;" type="button" value="{{ $value->id }}"
                                class="deletebtn1 btn"><a class=" flex items-center text-theme-11"
                                    href="javascript:;" data-toggle="modal" data-target="#delete-modal-preview1"> <i
                                        data-feather="x-circle" class="w-4 h-4 mr-1"></i>
                                    Suspend </a>
                            </button>
                        </td>


                    </tr>
                @elseif($value->error_status == 1)
                    <tr style="background-color: #ffb056;">
                        <td style="color: #eeeeee">
                            <a href="{{ route('user_details', ['id' => $value->id]) }}"> {{ $value->l_name }} </a>
                        </td>
                        <td style="color: #eeeeee">
                            <a href="{{ route('user_details', ['id' => $value->id]) }}"> {{ $value->f_name }} </a>
                        </td>
                        <td style="color: #eeeeee">
                            {{ $value->last_day_active ? $value->last_day_active : 'N/A' }}
                        </td>
                        <td style="color: #eeeeee">
                            {{ $value->client_id }}
                        </td>
                        <td>
                            <button style="border:none;" type="button" class="button text-black shadow-md mr-2">
                                <select name="status" class=" border-0 shadow-md mr-2 " name="month"
                                    id="" class="category" aria-label value=""
                                    onchange="window.location.href='/change_status_operator/'+ {{ $value->id }} +'/'+ this.value">
                                    <option value="0" <?php echo $value->active_status == 0 ? 'selected' : ''; ?>>In Progress User</option>
                                    <option value="1"<?php echo $value->active_status == 1 ? 'selected' : ''; ?>>Inactive User</option>
                                    <option value="2" <?php echo $value->active_status == 2 ? 'selected' : ''; ?>>Completed</option>

                                </select>
                            </button>
                        </td>
                        <td style="color: #eeeeee">
                            {{ $value->total_cds }}
                        </td>

                        <td style="color: #eeeeee">
                            {{ $value->time_listened ? $value->time_listened . ' mins' : '0' }}
                        </td>
                        <td style="color: #eeeeee">
                            {{ $value->time_assigned ? $value->time_assigned . ' mins' : '0' }}
                        </td>
                        <td style="color: #eeeeee">
                            {{ $value->time_remain ? $value->time_remain : '0' }}
                        </td>
                        <td style="color: #eeeeee">
                            {{ $value->total_minutes }} mins
                        </td>
                        <td style="color: #eeeeee">
                            <?php if ($value->cds == '') {
                                echo 'N/A';
                            } else {
                                echo $value->cds->current_cd;
                            } ?>
                        </td>
                        <td style="color: #eeeeee">
                            {{ $value->complete_hour }} mins
                        </td>

                        {{-- <td>
                    <?php if ($value->active_status == 0) {
                        echo 'In Progress';
                    } elseif ($value->active_status == 1) {
                        echo 'Delayed';
                    } elseif ($value->active_status == 2) {
                        echo 'Completed';
                    } ?>
                </td> --}}

                        <td style="color: #eeeeee">

                            @if ($value->cds == '')
                                <a class="flex items-center text-theme-2 mr-3 text-primary"
                                    href="{{ route('upload_tasks_show', ['id' => $value->id]) }}">
                                    <i data-feather="send" class="w-4 h-4 mr-1"></i> Upload </a>
                            @elseif($value->cds)
                                @if ($value->total_cds != $value->cds->current_cd)
                                    @if ($value->time_listened == $value->time_assigned)
                                        <a class="flex items-center text-theme-2 mr-3  text-primary"
                                            href="{{ route('upload_tasks_show', ['id' => $value->id]) }}">
                                            <i data-feather="send" class="w-4 h-4 mr-1"></i> Upload </a>
                                    @else
                                        Current CD-{{ $value->cds->current_cd }} in Progress
                                    @endif
                                @else
                                    All CD's Uploaded
                                @endif
                            @endif
                        </td>


                        <td>
                            <button style="border:none;" type="button" class="button text-white shadow-md mr-2"
                                disabled>

                                <?php if ($value->error_status == 3) {
                                    echo 'No Error';
                                } elseif ($value->error_status == 1) {
                                    echo 'No Report';
                                } elseif ($value->error_status == 2) {
                                    echo 'Use Time';
                                } ?>

                            </button>
                            <br> </br>


                            <button style="border:none;" type="button" value="{{ $value->id }}"
                                class="deletebtn2 btn"><a class=" flex items-center text-theme-2" href="javascript:;"
                                    data-toggle="modal" data-target="#delete-modal-preview2"> <i data-feather="check"
                                        class="w-4 h-4 mr-1"></i>
                                    Click me Resolved </a>
                            </button>
                        </td>
                        <td style="color: #eeeeee">
                            <a class="flex items-center text-theme-2 mr-3  text-primary"
                                href="{{ route('user_details', ['id' => $value->id]) }}">
                                <i data-feather="eye" class="w-4 h-4 mr-1"></i> view </a>

                            <a class="flex items-center text-theme-2 mr-1"
                                href="{{ route('edit_user', ['id' => $value->id]) }}"><i data-feather="edit"
                                    class="w-4 h-4 mr-1"></i>
                                Edit </a>
                            <button style="border:none;" type="button" value="{{ $value->id }}"
                                class="deletebtn btn"><a class=" flex items-center text-theme-2" href="javascript:;"
                                    data-toggle="modal" data-target="#delete-modal-preview"> <i
                                        data-feather="trash-2" class="w-4 h-4 mr-1"></i>
                                    Delete </a>
                            </button>

                            <button style="border:none;" type="button" value="{{ $value->id }}"
                                class="deletebtn1 btn"><a class=" flex items-center text-theme-2" href="javascript:;"
                                    data-toggle="modal" data-target="#delete-modal-preview1"> <i
                                        data-feather="x-circle" class="w-4 h-4 mr-1"></i>
                                    Suspend </a>
                            </button>
                        </td>

                    </tr>
                @elseif($value->error_status == 2)
                    <tr style="background-color: #f86652;">
                        <td style="color: #eeeeee">
                            <a href="{{ route('user_details', ['id' => $value->id]) }}"> {{ $value->l_name }} </a>
                        </td>
                        <td style="color: #eeeeee">
                            <a href="{{ route('user_details', ['id' => $value->id]) }}"> {{ $value->f_name }} </a>
                        </td>
                        <td style="color: #eeeeee">
                            {{ $value->last_day_active ? $value->last_day_active : 'N/A' }}
                        </td>
                        <td style="color: #eeeeee">
                            {{ $value->client_id }}
                        </td>
                        <td>
                            <button style="border:none;" type="button" class="button text-black shadow-md mr-2">
                                <select name="status" class=" border-0 shadow-md mr-2 " name="month"
                                    id="" class="category" aria-label value=""
                                    onchange="window.location.href='/change_status_operator/'+ {{ $value->id }} +'/'+ this.value">
                                    <option value="0" <?php echo $value->active_status == 0 ? 'selected' : ''; ?>>In Progress User</option>
                                    <option value="1"<?php echo $value->active_status == 1 ? 'selected' : ''; ?>>Inactive User</option>
                                    <option value="2" <?php echo $value->active_status == 2 ? 'selected' : ''; ?>>Completed</option>

                                </select>
                            </button>
                        </td>
                        <td style="color: #eeeeee">
                            {{ $value->total_cds }}
                        </td>

                        <td style="color: #eeeeee">
                            {{ $value->time_listened ? $value->time_listened . ' mins' : '0' }}
                        </td>
                        <td style="color: #eeeeee">
                            {{ $value->time_assigned ? $value->time_assigned . ' mins' : '0' }}
                        </td>
                        <td style="color: #eeeeee">
                            {{ $value->time_remain ? $value->time_remain : '0' }}
                        </td>
                        <td style="color: #eeeeee">
                            {{ $value->total_minutes }} mins
                        </td>
                        <td style="color: #eeeeee">
                            <?php if ($value->cds == '') {
                                echo 'N/A';
                            } else {
                                echo $value->cds->current_cd;
                            } ?>
                        </td>
                        <td style="color: #eeeeee">
                            {{ $value->complete_hour }} mins
                        </td>

                        {{-- <td>
                    <?php if ($value->active_status == 0) {
                        echo 'In Progress';
                    } elseif ($value->active_status == 1) {
                        echo 'Delayed';
                    } elseif ($value->active_status == 2) {
                        echo 'Completed';
                    } ?>
                </td> --}}

                        <td style="color: #eeeeee">

                            @if ($value->cds == '')
                                <a class="flex items-center text-theme-2 mr-3 text-primary"
                                    href="{{ route('upload_tasks_show', ['id' => $value->id]) }}">
                                    <i data-feather="send" class="w-4 h-4 mr-1"></i> Upload </a>
                            @elseif($value->cds)
                                @if ($value->total_cds != $value->cds->current_cd)
                                    @if ($value->time_listened == $value->time_assigned)
                                        <a class="flex items-center text-theme-2 mr-3  text-primary"
                                            href="{{ route('upload_tasks_show', ['id' => $value->id]) }}">
                                            <i data-feather="send" class="w-4 h-4 mr-1"></i> Upload </a>
                                    @else
                                        Current CD-{{ $value->cds->current_cd }} in Progress
                                    @endif
                                @else
                                    All CD's Uploaded
                                @endif
                            @endif
                        </td>


                        <td>
                            <button style="border:none;" type="button" class="button text-white shadow-md mr-2"
                                disabled>

                                <?php if ($value->error_status == 3) {
                                    echo 'No Error';
                                } elseif ($value->error_status == 1) {
                                    echo 'No Report';
                                } elseif ($value->error_status == 2) {
                                    echo 'Use Time';
                                } ?>

                            </button>
                            <br> </br>


                            <button style="border:none;" type="button" value="{{ $value->id }}"
                                class="deletebtn2 btn"><a class=" flex items-center text-theme-2" href="javascript:;"
                                    data-toggle="modal" data-target="#delete-modal-preview2"> <i data-feather="check"
                                        class="w-4 h-4 mr-1"></i>
                                    Click me Resolved </a>
                            </button>
                        </td>
                        <td style="color: #eeeeee">
                            <a class="flex items-center text-theme-2 mr-3  text-primary"
                                href="{{ route('user_details', ['id' => $value->id]) }}">
                                <i data-feather="eye" class="w-4 h-4 mr-1"></i> view </a>

                            <a class="flex items-center text-theme-2 mr-1"
                                href="{{ route('edit_user', ['id' => $value->id]) }}"><i data-feather="edit"
                                    class="w-4 h-4 mr-1"></i>
                                Edit </a>
                            <button style="border:none;" type="button" value="{{ $value->id }}"
                                class="deletebtn btn"><a class=" flex items-center text-theme-2" href="javascript:;"
                                    data-toggle="modal" data-target="#delete-modal-preview"> <i
                                        data-feather="trash-2" class="w-4 h-4 mr-1"></i>
                                    Delete </a>
                            </button>

                            <button style="border:none;" type="button" value="{{ $value->id }}"
                                class="deletebtn1 btn"><a class=" flex items-center text-theme-2" href="javascript:;"
                                    data-toggle="modal" data-target="#delete-modal-preview1"> <i
                                        data-feather="x-circle" class="w-4 h-4 mr-1"></i>
                                    Suspend </a>
                            </button>
                        </td>

                    </tr>

                @endif

            @endforeach
        </tbody>
    </table>
</div>
<!-- END: Datatable -->
<div class="modal" id="delete-modal-preview">
    <div class="modal__content">
        <div class="p-5 text-center">
            <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
            <div class="text-3xl mt-5">Are you sure?</div>
            <div class="text-gray-600 mt-2">Do you really want to delete these records? This process cannot be
                undone.
            </div>
        </div>
        <div class="px-5 pb-8 text-center">
            <form type="submit" action="{{ route('delete_user') }}" method="post">
                @csrf
                @method('DELETE')
                <input type="hidden" name="delete_user_id" id="deleting_id"></input>
                <button type="button" data-dismiss="modal"
                    class="button w-24 border text-gray-700 mr-1">Cancel</button>
                <button type="submit" class="button w-24 bg-theme-6 text-white p-3 pl-5 pr-5">Delete</button>
            </form>
        </div>
    </div>
</div>

<!-- END: Datatable -->
<div class="modal" id="delete-modal-preview1">
    <div class="modal__content">
        <div class="p-5 text-center">
            <i data-feather="x-circle" class="w-16 h-16 text-theme-11 mx-auto mt-3"></i>
            <div class="text-3xl mt-5">Are you sure?</div>
            <div class="text-gray-600 mt-2">Do you really want to Suspend This User? This process cannot be undone &
                Previous Record Also Be Deleted Sucessfully.
            </div>
        </div>
        <div class="px-5 pb-8 text-center">
            <form type="submit" action="{{ route('change_suspended_status') }}" method="post">
                @csrf
                @method('post')
                <input type="hidden" name="user_id" id="user_id"></input>
                <button type="button" data-dismiss="modal"
                    class="button w-24 border text-gray-700 mr-1">Cancel</button>
                <button type="submit" class="button w-24 bg-theme-11 text-white p-3 pl-4 pr-4">Suspended</button>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="delete-modal-preview2">
    <div class="modal__content">
        <div class="p-5 text-center">
            <i data-feather="check" class="w-16 h-16 text-theme-9 mx-auto mt-3"></i>
            <div class="text-3xl mt-5">Are you sure?</div>
            <div class="text-gray-600 mt-2">Do you really want to Resolved This Error? This process cannot be undone.
            </div>
        </div>
        <div class="px-5 pb-8 text-center">
            <form type="submit" action="{{ route('change_resolved_status') }}" method="post">
                @csrf
                @method('post')
                <input type="hidden" name="user_id_res" id="user_id_res"></input>
                <button type="button" data-dismiss="modal"
                    class="button w-24 border text-gray-700 mr-1">Cancel</button>
                <button type="submit" class="button w-24 bg-theme-9 text-white p-3 pl-4 pr-4">Resolved</button>
            </form>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            scrollX: true,
        });
    });

    $(document).on('click', '.deletebtn', function() {
        var user_id = $(this).val();
        $('#deleting_id').val(user_id);
    });

    $(document).on('click', '.deletebtn1', function() {
        var user_id = $(this).val();
        $('#user_id').val(user_id);
    });

    $(document).on('click', '.deletebtn2', function() {
        var user_id = $(this).val();
        $('#user_id_res').val(user_id);
    });
</script>


@include('layouts.footer')
