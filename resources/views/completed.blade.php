<?php
$pagename="completed";

?>
@include('layouts.header')


<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto ml-2">
        List of Completed Tasks Users
    </h2>

    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">

    </div>
</div>
<!-- BEGIN: Datatable -->
<div class="overflow-x-auto intro-y datatable-wrapper box p-5 mt-5">
    <table class="table table-report table-report--bordered display datatable w-full">
        <thead>
            <tr>
                <th class="border-b-2  whitespace-no-wrap">
                    Sr.</th>

                <th class="border-b-2  whitespace-no-wrap">
                    First Name*</th>

                <th class="border-b-2  whitespace-no-wrap">
                    Last Name*</th>

                <th class="border-b-2  whitespace-no-wrap">
                    Client ID*</th>

                <th class="border-b-2  whitespace-no-wrap">
                    Phone*</th>

                <th class="border-b-2  whitespace-no-wrap">
                    Preview Completed Hours*</th>

                <th class="border-b-2  whitespace-no-wrap">
                    Active Status*</th>

                <th class="border-b-2  whitespace-no-wrap">
                    Time Listened*</th>

                <th class="border-b-2  whitespace-no-wrap">
                    Time Assigned*</th>

                <th class="border-b-2  whitespace-no-wrap">
                    Time Remaining*</th>

                    <th class="border-b-2  whitespace-no-wrap">
                        Total CD's In Plan*</th>

                    <th class="border-b-2  whitespace-no-wrap">
                        Current CD*</th>

                <th class="border-b-2  whitespace-no-wrap">
                    Last Active Day*</th>

                <th class="border-b-2  whitespace-no-wrap">
                    View Details</th>
            </tr>
        </thead>
        <tbody>
            <?php  $i = 0; ?>
            @foreach($users as $value)
            <?php $i++; ?>
            <tr>
                <th scope="row">{{ $i }}</th>
                <td>
                    {{ $value->f_name }}
                </td>
                <td>
                    {{ $value->l_name }}
                </td>
                <td>
                    {{ $value->client_id }}
                </td>
                <td>
                    {{ $value->phone }}
                </td>
                <td>
                    {{ $value->complete_hour }} Hours
                </td>
                <td>
                    <?php  if( $value->active_status == 0){
                        echo 'In Progress'; 
                     } else if( $value->active_status == 1){
                        echo "Delayed";
                         
                     }  else if( $value->active_status == 2){
                        echo "Completed";
                         
                     }  ?>
                </td>
                <td>
                    {{ $value->time_listened ? $value->time_listened .' mins': 'N/A' }}
                </td>
                <td>
                    {{ $value->time_assigned ? $value->time_assigned .' mins' : 'N/A' }}
                </td>
                <td>
                    {{ $value->time_remain ? $value->time_remain : 'N/A' }}
                </td>
                <td>
                    {{ $value->total_cds }}
                </td>
                <td>
                    N/A
                </td>
                <td>
                    {{ $value->last_day_active ? $value->last_day_active : 'N/A' }}
                </td>
        
                <td>
                    <a class="flex items-center text-theme-1 mr-3  text-primary"
                        href="{{route('user_details',['id' => $value->id])}}">
                        <i data-feather="eye" class="w-4 h-4 mr-1"></i> completed </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@include('layouts.footer')