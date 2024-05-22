<?php
$pagename = 'users';
?>
@include('layouts.header')


<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto ml-2">
        Listening Time Breakdown Of &nbsp; "{{ $record->f_name }} {{ $record->l_name }}"
    </h2>


    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">

        <form action="{{ route('search_breakdown') }}">

            <input type="hidden" name="details_id"  value="{{ isset($details->id) ? $details->id : '' }}" >

            <input type="hidden" name="user_id"  value="{{ $record->id }}" >

            <input type="hidden" name="selected_cd"  value="{{ isset($details->current_cd) ? $details->current_cd : 'N/A' }}" >


            <?php $newDate = isset($inputDate) ? date('Y-m-d', strtotime($inputDate)) : '';?>

            <input type="date" name="search_date" class="input  border flex-1"  value="{{ $newDate }}"
                min="1997-01-01" max="2030-12-31">

                {{-- <input type="text" name="" class="input border flex-1" value="{{ isset($newDate) ? 'Data against '.$newDate : 'Please select date' }}" readonly> --}}


            <button style="border:none;" type="submit" class="button text-white bg-theme-42 shadow-md mr-2">
                check
            </button>

        </form>

        <input type="text" name="" class="input border flex-1" value="Session sum is - {{ isset($sum) ? $sum : '0' }}" readonly>
        &nbsp;&nbsp;&nbsp;
        


        {{-- <div class="mb-2"><strong> View Only Uploaded CD Data*</strong></div> --}}
        <button style="border:none;" type="button" class="button text-white bg-theme-42 shadow-md mr-2">
            Selected CD - {{ isset($details->current_cd) ? $details->current_cd : 'N/A' }}
        </button>



    </div>
    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">


        {{-- <div class="mb-2"><strong> View Only Uploaded CD Data*</strong></div> --}}
        <button style="border:none;" type="button" class="button text-white bg-theme-42 shadow-md mr-2">
            <select name="status" onchange="changeStatus({{ $record->id }},this.value)"
                class=" border-0 bg-theme-42 shadow-md mr-2 " id="" class="category" aria-label value="">

                <option disabled selected>Select CD to View Breakdown"</option>

                @for ($i = 1; $i <= $data; $i++)
                    <option value="{{ $i }}">CD {{ $i }}</option>
                @endfor

            </select>
        </button>

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
                    Date</th>

                <th class="border-b-2  whitespace-no-wrap">
                    Start Time</th>

                <th class="border-b-2  whitespace-no-wrap">
                    Duration</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0; ?>
            @foreach ($breakdown as $value)
                <?php $i++; ?>
                <tr>
                    <th>{{ $i }}</th>
                    <td>
                        {{ $value->date }}
                    </td>
                    <td>
                        {{ $value->start_time }}
                    </td>
                    <td>
                        {{ $value->duration }} mins
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>



<script>
    function changeStatus(id, val) {
        console.log(id);
        console.log(val);

        window.location.href = "/user_details_breakdown/" + id + "/cd_data/" + val;

    }
</script>


<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            scrollX: true,
        });
    });
</script>
@include('layouts.footer')
