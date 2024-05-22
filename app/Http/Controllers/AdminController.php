<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserDetailTrack;
use App\Models\Notification;
use App\Models\Breakdown;
use App\Models\TemporaryFile;
use App\Models\Contact;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{

    public function logout()
    {

        Session::flush();
        Auth::logout();
        return redirect('login');
    }

    public function dashboard()
    {

        $users = User::where('remember_token', NULL)->count();
        $completed =  User::where('remember_token', NULL)->where('completed_status', 1)->where('suspended_status', 0)->count();
        $in =  User::where('remember_token', NULL)->where('active_status', 1)->where('suspended_status', 0)->count();
        $sus =  User::where('suspended_status', 1)->count();

        return view('dashboard', compact('users', 'completed', 'in', 'sus'));
    }

    public function users()
    {
        $users =  User::where('remember_token', NULL)->where('suspended_status', 0)->get();
        $value = 3;

        $data = [];

        foreach ($users as $list) {

            $details = UserDetail::where('user_id', $list->id)->orderBy('current_cd', 'desc')->first();
            if ($details) {

                $list->cds = $details;
                array_push($data, $list);
            } else {

                $list->cds = "";
                array_push($data, $list);
            }
        }

        // $users =  UserDetail::select('id', 'user_id', 'current_cd' , DB::raw('MAX(current_cd) as current_cd') )->where('user_id', '2')->get();


        // dd($users);



        // $users =  DB::table('users')
        //     ->leftjoin('user_details', 'users.id', '=', 'user_details.user_id')
        //     ->select('users.*','user_details.current_cd')->where('users.remember_token', NULL)->where('users.suspended_status', 0)->get();


        // $users =  DB::table('users')
        // ->leftjoin('user_details', 'users.id', '=', 'user_details.user_id')
        // ->select('users.*' ,DB::raw('MAX(user_details.current_cd) as max_id'))->where('users.remember_token', NULL)->where('users.suspended_status', 0)->orderBy('user_details.current_cd','desc')->groupBy('user_details.current_cd')->get();

        return view('users', compact('data', 'value'));
    }

    public function add_users_show()
    {
        $url = url('add_users');
        $title = 'Add User';
        $text = 'Save';

        return view('add_user', ['url' => $url, 'title' => $title, 'text' => $text]);
    }

    //=========================== Add Users Api ======================================
    public function add_users(Request $request)
    {

        if ($request->file('profile_img') == null) {
            $image_name = "";
        } else {
            $path_title = $request->file('profile_img')->store('public/images');

            $image_name = basename($path_title);
        }
        $request->validate([

            'f_name' => 'required ',
            'l_name' => 'required ',
            'client_id' => 'required|unique:users,client_id',
            'phone' => 'required ',
            'complete_hour' => 'required ',
            'password' => 'required|min:8',
            'total_cd' => 'required ',
            'total_minutes' => 'required ',
            'radio' => 'required ',
            'practise_location' => 'required ',
            'extra_email' => 'required ',
            'extra_phone' => 'required ',

        ]);

        $users = new User();
        $users->profile_img = "images/" . $image_name;
        $users->f_name = $request->f_name;
        $users->l_name = $request->l_name;
        $users->client_id = $request->client_id;
        $users->phone = $request->phone;
        $users->complete_hour = $request->complete_hour;
        $users->password = $request->password;
        $users->total_cds = $request->total_cd;
        $users->total_minutes = $request->total_minutes;
        $users->practise_location = $request->practise_location;
        $users->extra_email = $request->extra_email;
        $users->extra_phone = $request->extra_phone;


        if ($request->radio == 'one-hour-daily') {

            $users->daily_time = 1;
        } elseif ($request->radio == 'half-hour-daily') {

            $users->daily_time = 2;
        } elseif ($request->radio == 'half-hour-twice-daily') {

            $users->daily_time = 3;
        }
        $users->save();
        return redirect(route('users', compact('users')))->with('add_message', 'User Added successfully');
    }


    public function edit_user($id)
    {
        $record = User::find($id);
        $url = url('update_user') . "/" . $id;
        $title = 'Edit User';
        $text = 'Update';
        return view('add_user', ['record' => $record, 'url' => $url, 'title' => $title, 'text' => $text]);
    }

    public function update_user($id, Request $request)
    {


        $request->validate([

            'f_name' => 'required ',
            'l_name' => 'required ',
            'client_id' => 'required ',
            'phone' => 'required ',
            'complete_hour' => 'required ',
            'password' => 'required|min:8',
            'total_cd' => 'required ',
            'total_minutes' => 'required ',
            // 'radio' => 'required ',
            'practise_location' => 'required ',
            'extra_email' => 'required ',
            'extra_phone' => 'required ',
        ]);

        $users = User::findOrFail($id);
        if ($request->file('profile_img') == null) {
            if ($users->profile_img) {
                $image_name = $users->profile_img;
            } else {
                $image_name = "";
            }
        } else {

            $path_title = $request->file('profile_img')->store('public/images');

            $image_name = "images/" .  basename($path_title);
        }
        $users->profile_img = $image_name;
        $users->f_name = $request->f_name;
        $users->l_name = $request->l_name;
        $users->client_id = $request->client_id;
        $users->phone = $request->phone;
        $users->complete_hour = $request->complete_hour;
        $users->password = $request->password;
        $users->total_cds = $request->total_cd;
        $users->total_minutes = $request->total_minutes;
        $users->practise_location = $request->practise_location;
        $users->extra_email = $request->extra_email;
        $users->extra_phone = $request->extra_phone;


        // if ($request->radio == 'one-hour-daily') {

        //     $users->daily_time = 1;
        // } elseif ($request->radio == 'half-hour-daily') {

        //     $users->daily_time = 2;
        // } elseif ($request->radio == 'half-hour-twice-daily') {

        //     $users->daily_time = 3;
        // }
        $users->save();

        return redirect(route('users'))->with('update_message', 'User Update successfully');
    }

    public function delete_user(Request $request)
    {
        $user_id = $request->delete_user_id;

        $user_details = UserDetail::where('user_id', $user_id)->get();
        if ($user_details) {

            foreach ($user_details as $list) {
                $songs = UserDetailTrack::where('details_id', $list->id);
                $songs->delete();

                $breakdown = Breakdown::where('details_id', $list->id)->get();

                if ($breakdown) {
                    $breakdown = Breakdown::where('details_id', $list->id);
                    $breakdown->delete();
                }
            }
        }

        $user_details = UserDetail::where('user_id', $user_id);
        $user_details->delete();

        $noti = Notification::where('user_id', $user_id);
        $noti->delete();

        $users = User::findOrFail($user_id);
        $users->delete();
        return redirect(route('users'))->with('delete_message', 'User Deleted successfully');
    }


    public function upload_tasks_show($id)
    {
        $temporary_files = TemporaryFile::all();

        if (isset($temporary_files)) {

            $temporary_files = TemporaryFile::truncate();
        }

        $user = User::find($id);

        $details = UserDetail::where('user_id', $id)->orderBy('current_cd', 'desc')->first();

        if ($details) {

            $user->cds = $details;
            $data = $user;
        } else {

            $user->cds = "";
            $data = $user;
        }

        // dd($data);


        return view('add_user_tracks', compact('data'));
    }



    public function task_data(Request $request)
    {

        date_default_timezone_set('America/Los_Angeles');
        $time = date('h:i:s');
        $date = date('d-m-Y');


        $request->validate([

            'user_id' => 'required ',
            'current_cd' => 'required ',
            'time_assigned' => 'required ',
            // 'radio' => 'required ',
            'filenames' => 'required ',

        ]);

        try {

            $users = User::find($request->user_id);


            // if ($request->radio == 'one-hour-daily') {

            //     $users->daily_time = 1;
            // } elseif ($request->radio == 'half-hour-daily') {

            //     $users->daily_time = 2;
            // } elseif ($request->radio == 'half-hour-twice-daily') {

            //     $users->daily_time = 3;
            // }

            $users->time_assigned = $request->time_assigned;
            $users->upload_status = 1;
            $users->time_listened = 0;
            $users->save();

            $user_details = new UserDetail();
            $user_details->user_id = $request->user_id;
            $user_details->current_cd = $request->current_cd;
            $user_details->description = $request->desc ? $request->desc : 'Brain Wellness Center';
            $user_details->time_suggest = $request->time_assigned;
            $user_details->upload_date = $date;
            $user_details->save();

            $this->UserNofication($request->user_id, 'CD ' . $request->current_cd . ' Assigned ', $request->desc ? $request->desc : 'Brain Wellness Center  ', $time);

            $tmp_file = TemporaryFile::all();

            if ($tmp_file) {

                foreach ($tmp_file as $file) {

                    Storage::copy('public/tracks/tmp/' . $file->folder . '/' . $file->file, 'public/tracks/' . $file->folder . '/' . $file->file);

                    $tracks = new UserDetailTrack();
                    $tracks->details_id = $user_details->id;
                    $tracks->tracks = $file->folder . '/' . $file->file;
                    $tracks->track_size = $file->size;
                    $tracks->save();

                    Storage::deleteDirectory('public/tracks/tmp/' . $file->folder);
                }
            }
            DB::table('temporary_files')->delete();
            // if($request->file('filenames') == null) {

            //     $songs = "";

            // } else {

            //     $files = $request->file('filenames');

            //     foreach ($files as $file) {

            //         $path_title = $file->store('public/songs');

            //         $songs = basename($path_title);

            //         $tracks = new UserDetailTrack();
            //         $tracks->details_id = $user_details->id;
            //         $tracks->tracks ="songs/" .  $songs;
            //         $tracks->save();
            //     }
            // }


            return redirect(route('users', compact('users')))->with('add_message', 'Add Tasks Against User successfully');
        } catch (\Exception $e) {

            $temporary_files = TemporaryFile::all();

            if (isset($temporary_files)) {

                $temporary_files = TemporaryFile::truncate();
            }

            return redirect(route('users'))->with('error', 'Something went wrong!');


            // return response()->json(['message' => 'Something went wrong: ' . $e->getMessage()], 500);
        }
    }


    public function edit_tasks_show($id)
    {
        $temporary_files = TemporaryFile::all();

        if (isset($temporary_files)) {

            $temporary_files = TemporaryFile::truncate();
        }

        $user = User::find($id);


        $details = UserDetail::where('user_id', $id)->orderBy('current_cd', 'desc')->first();


        if ($details) {

            $tracks = UserDetailTrack::where('details_id', $details->id)->get();

            $user->cds = $details;
            $user->tracks_data = $tracks;
            $data = $user;
        } else {

            return redirect()->back()->with('cd_message', 'upload cd first');

            $user->cds = "";
            $user->tracks_data = "";
            $data = $user;
        }


        return view('edit_user_tracks', compact('data'));
    }

    public function update_task_data(Request $request)
    {


        $request->validate([

            'user_id' => 'required ',
            'time_assigned' => 'required ',
            // 'radio' => 'required ',

        ]);

        try {

            $users = User::find($request->user_id);


            // if ($request->radio == 'one-hour-daily') {

            //     $users->daily_time = 1;
            // } elseif ($request->radio == 'half-hour-daily') {

            //     $users->daily_time = 2;
            // } elseif ($request->radio == 'half-hour-twice-daily') {

            //     $users->daily_time = 3;
            // }
            $users->save();


            $user = User::find($request->user_id);
            $user->time_assigned = $request->time_assigned;
            $user->save();

            $user_details = UserDetail::where('user_id', $request->user_id)->orderBy('current_cd', 'desc')->first();
            $user_details->description = $request->desc ? $request->desc : 'Brain Wellness Center';
            $user_details->time_suggest = $request->time_assigned;
            $user_details->save();

            // $this->UserNofication($request->user_id, 'CD ' .$request->current_cd .' Assigned ' , $request->desc ? $request->desc : 'Brain Wellness Center  '  , $time);

            $tmp_file = TemporaryFile::all();


            if ($tmp_file) {

                foreach ($tmp_file as $file) {

                    Storage::copy('public/tracks/tmp/' . $file->folder . '/' . $file->file, 'public/tracks/' . $file->folder . '/' . $file->file);

                    $tracks = new UserDetailTrack();
                    $tracks->details_id = $user_details->id;
                    $tracks->tracks = $file->folder . '/' . $file->file;
                    $tracks->track_size = $file->size;
                    $tracks->save();

                    Storage::deleteDirectory('public/tracks/tmp/' . $file->folder);
                }
            }
            DB::table('temporary_files')->delete();
            // if($request->file('filenames') == null) {

            //     $songs = "";

            // } else {

            //     $files = $request->file('filenames');

            //     foreach ($files as $file) {

            //         $path_title = $file->store('public/songs');

            //         $songs = basename($path_title);

            //         $tracks = new UserDetailTrack();
            //         $tracks->details_id = $user_details->id;
            //         $tracks->tracks ="songs/" .  $songs;
            //         $tracks->save();
            //     }
            // }


            return redirect(route('users', compact('users')))->with('update_message', 'Add Tasks Against User successfully');
        } catch (\Exception $e) {

            $temporary_files = TemporaryFile::all();

            if (isset($temporary_files)) {

                $temporary_files = TemporaryFile::truncate();
            }

            return redirect(route('users'))->with('error', 'Something went wrong!');
            // return response()->json(['message' => 'Something went wrong: ' . $e->getMessage()], 500);
        }
    }

    public function delete_song(Request $request)
    {
        //     UserDetailTrack::find($id)->delete($id);

        // return response()->json([
        //     'success' => 'Record deleted successfully!'
        // ]);

        $track_id = $request->delete_track_id;

        $track = UserDetailTrack::findOrFail($track_id);
        $track->delete();
        return redirect()->back()->with('delete_message', 'sdsddsdsdsds');
    }


    public function multiple_delete_tracks(Request $request)
    {

        $id = $request->delete_track_ids[0];

        $explode_id = array_map('intval', explode(',', $id));
        // dd($explode_id);

        foreach ($explode_id as $key => $track) {
            if ($track > 0) {

                UserDetailTrack::where('id', $track)->delete();
            }
        }
        return redirect()->back()->with('delete_message', 'sdsddsdsdsds');
    }


    public function user_details($id)
    {

        $record = User::find($id);

        $details = UserDetail::where('user_id', $record->id)->orderBy('current_cd', 'desc')->first();

        if ($details) {
            $songs = UserDetailTrack::where('details_id', $details->id)->get();
        } else {
            $songs = NULL;
        }

        $cd = UserDetail::where('user_id', $id)->orderBy('current_cd', 'desc')->first();

        if ($cd) {

            $cd = UserDetail::select('current_cd')->where('user_id', $id)->orderBy('current_cd', 'desc')->first();
            $data  = $cd->current_cd;
        } else {
            $data = 0;
        }

        return view('user_details_view', compact('record', 'details', 'songs', 'data'));
    }

    public function breakdown($id)
    {

        $record = User::find($id);

        $details = UserDetail::where('user_id', $record->id)->first();

        if ($details) {
            $songs = UserDetailTrack::where('details_id', $details->id)->get();
            $details = UserDetail::where('user_id', $record->id)->orderBy('current_cd', 'desc')->first();
        } else {
            $songs = NULL;
            $details = 'N/A';
        }

        $cd = UserDetail::where('user_id', $id)->orderBy('current_cd', 'desc')->first();

        if ($cd) {

            $cd = UserDetail::select('current_cd')->where('user_id', $id)->orderBy('current_cd', 'desc')->first();
            $data  = $cd->current_cd;
        } else {
            $data = 0;
        }

        $cd = UserDetail::where('user_id', $id)->orderBy('current_cd', 'desc')->first();

        if ($cd) {
            // $breakdown = Breakdown::where('details_id', $cd->id)->orderBy('id', 'desc')->get();
            $breakdown = Breakdown::where('details_id', $cd->id)->orderBy('date', 'desc')->orderBy('start_time', 'desc')->get();

        } else {
            $breakdown = [];
        }


        return view('breakdown', compact('record', 'details', 'songs', 'data', 'breakdown'));
    }

    public function search_breakdown(Request $request)
    {


        $request->validate([

            'user_id' => 'required ',
            'search_date' => 'required ',
            'selected_cd' => 'required ',


        ]);

        $inputDate = $request->search_date;

        $dateParts = explode('-', $inputDate);

        $newDate = $dateParts[1] . '-' . $dateParts[2] . '-' . $dateParts[0];




        // $breakdown = Breakdown::where('date', $newDate)->sum('duration');

        $breakdown = Breakdown::join('user_details', 'breakdowns.details_id', '=', 'user_details.id')
            ->where('breakdowns.date', $newDate)
            ->where('user_details.user_id', $request->user_id)
            ->where('user_details.current_cd', $request->selected_cd)
            ->sum('duration');


        $sum = strval($breakdown);

        $record = User::find($request->user_id);

        $details = UserDetail::where('user_id', $record->id)->first();

        if ($details) {
            $songs = UserDetailTrack::where('details_id', $details->id)->get();
            // $details = UserDetail::where('user_id', $record->id)->orderBy('current_cd', 'desc')->first();
            $details = UserDetail::where('user_id', $record->id)->where('current_cd', $request->selected_cd)->first();
        } else {
            $songs = NULL;
            $details = 'N/A';
        }

        // $cd = UserDetail::where('user_id', $request->user_id)->orderBy('current_cd', 'desc')->first();
        $cd = UserDetail::where('user_id', $request->user_id)->where('current_cd',  $request->selected_cd)->first();


        if ($cd) {

            $cd = UserDetail::select('current_cd')->where('user_id', $request->user_id)->orderBy('current_cd', 'desc')->first();
            // $cd = UserDetail::select('current_cd')->where('user_id', $request->user_id)->where('current_cd', $request->selected_cd)->first();

            $data  = $cd->current_cd;
        } else {
            $data = 0;
        }

        // $cd = UserDetail::where('user_id', $request->user_id)->orderBy('current_cd', 'desc')->first();
        $cd = UserDetail::where('user_id', $request->user_id)->where('current_cd',  $request->selected_cd)->first();


        if ($cd) {
            // $breakdown = Breakdown::where('details_id', $cd->id)->orderBy('id', 'desc')->get();
            $breakdown = Breakdown::where('details_id', $cd->id)->where('date',  $newDate)->orderBy('date', 'desc')->orderBy('start_time', 'desc')->get();
        } else {
            $breakdown = [];
        }

        return view('breakdown', compact('record', 'details', 'songs', 'data', 'breakdown', 'sum', 'inputDate'));
    }

    public function in_active_users()
    {
        $users =  User::where('remember_token', NULL)->where('active_status', 1)->where('suspended_status', 0)->get();
        return view('in_active', compact('users'));
    }

    public function completed_tasks()
    {
        $users =  User::where('remember_token', NULL)->where('completed_status', 1)->where('active_status', 2)->where('suspended_status', 0)->get();
        return view('completed', compact('users'));
    }

    public function suspended_users()
    {
        $users =  User::where('suspended_status', 1)->get();
        return view('suspended', compact('users'));
    }

    public function change_suspended_status(Request $request)
    {
        $users =  User::find($request->user_id);
        $users->suspended_status = 1;
        $users->save();
        return redirect(route('suspended_users'))->with('error_message', 'You have Suspend this User successfully');
    }

    public function change_un_suspended_status($id)
    {
        $users =  User::find($id);
        $users->suspended_status = 0;
        $users->save();
        return redirect(route('users'))->with('un_suspend', 'You have Suspend this User successfully');
    }

    public function cd_data($id, $val)
    {
        // dd($request);
        // $record = User::find($id);

        // $details = UserDetail::where('user_id', $record->id)->where('current_cd', $val)->first();

        // if($details){
        //     $songs = UserDetailTrack::where('details_id', $details->id)->get();
        // } else {
        //     $songs = NULL;
        // }

        // $cd = UserDetail::where('user_id', $id)->orderBy('current_cd', 'desc')->first();

        // if($cd){

        //      $cd = UserDetail::select('current_cd')->where('user_id', $id)->orderBy('current_cd', 'desc')->first();
        //      $data  = $cd->current_cd;

        // } else {
        //     $data = 0;
        // }

        return redirect(route('user_details_view', ['id' => $id, 'val' => $val]))->with('cd', 'Add Tasks Against User successfully');


        // session()->flash('cd', 'Action completed with 0 errors'); //==== display message 
        // return view('user_details_view', compact('record', 'details', 'songs','data'));

    }

    public function user_details_view($id, $val)
    {
        // dd($request);
        $record = User::find($id);

        $details = UserDetail::where('user_id', $record->id)->where('current_cd', $val)->first();

        if ($details) {
            $songs = UserDetailTrack::where('details_id', $details->id)->get();
        } else {
            $songs = NULL;
        }

        $cd = UserDetail::where('user_id', $id)->orderBy('current_cd', 'desc')->first();

        if ($cd) {

            $cd = UserDetail::select('current_cd')->where('user_id', $id)->orderBy('current_cd', 'desc')->first();
            $data  = $cd->current_cd;
        } else {
            $data = 0;
        }

        // session()->flash('cd', 'Action completed with 0 errors'); //==== display message 
        return view('user_details_view', compact('record', 'details', 'songs', 'data'));
    }

    public function cd_data_breakdown($id, $val)
    {
        // dd($request);
        // $record = User::find($id);

        // $details = UserDetail::where('user_id', $record->id)->where('current_cd', $val)->first();

        // if($details){
        //     $breakdown = Breakdown::where('details_id', $details->id)->get();
        // }

        // $cd = UserDetail::where('user_id', $id)->orderBy('current_cd', 'desc')->first();

        // if($cd){

        //      $cd = UserDetail::select('current_cd')->where('user_id', $id)->orderBy('current_cd', 'desc')->first();
        //      $data  = $cd->current_cd;

        // } else {
        //     $data = 0;
        // }

        //    session()->flash('cd', 'Action completed with 0 errors'); //==== display message 

        return redirect(route('cd_data_breakdown_view', ['id' => $id, 'val' => $val]))->with('cd', 'Add Tasks Against User successfully');

        // return view('breakdown', compact('record', 'details','data','breakdown'))->with('cd', 'Action completed with 0 errors');

    }

    public function cd_data_breakdown_view($id, $val)
    {

        $record = User::find($id);

        $details = UserDetail::where('user_id', $record->id)->where('current_cd', $val)->first();

        if ($details) {
            $breakdown = Breakdown::where('details_id', $details->id)->orderBy('date', 'desc')->orderBy('start_time', 'desc')->get();
            //die($breakdown);
        } else {
            $breakdown = [];
        }


        $cd = UserDetail::where('user_id', $id)->orderBy('current_cd', 'desc')->first();

        if ($cd) {

            $cd = UserDetail::select('current_cd')->where('user_id', $id)->orderBy('current_cd', 'desc')->first();
            $data  = $cd->current_cd;
        } else {
            $data = 0;
        }


        return view('breakdown', compact('record', 'details', 'data', 'breakdown'));
    }



    public function users_by_status($id = 3)
    {

        $value = $id;

        if ($value == 0) {

            $users =  User::where('remember_token', NULL)->where('active_status', 0)->where('suspended_status', 0)->get();

            $data = [];

            foreach ($users as $list) {

                $details = UserDetail::where('user_id', $list->id)->orderBy('current_cd', 'desc')->first();
                if ($details) {

                    $list->cds = $details;
                    array_push($data, $list);
                } else {

                    $list->cds = "";
                    array_push($data, $list);
                }
            }

            return view('users', compact('data', 'value'));
        } else if ($value == 1) {


            $users =  User::where('remember_token', NULL)->where('active_status', 1)->where('suspended_status', 0)->get();

            $data = [];

            foreach ($users as $list) {

                $details = UserDetail::where('user_id', $list->id)->orderBy('current_cd', 'desc')->first();
                if ($details) {

                    $list->cds = $details;
                    array_push($data, $list);
                } else {

                    $list->cds = "";
                    array_push($data, $list);
                }
            }

            return view('users', compact('data', 'value'));
        } else if ($value == 2) {


            $users =  User::where('remember_token', NULL)->where('completed_status', 1)->where('active_status', 2)->where('suspended_status', 0)->get();

            $data = [];

            foreach ($users as $list) {

                $details = UserDetail::where('user_id', $list->id)->orderBy('current_cd', 'desc')->first();
                if ($details) {

                    $list->cds = $details;
                    array_push($data, $list);
                } else {

                    $list->cds = "";
                    array_push($data, $list);
                }
            }

            return view('users', compact('data', 'value'));
        } else if ($value == 3) {

            $users =  User::where('remember_token', NULL)->where('suspended_status', 0)->get();

            $data = [];

            foreach ($users as $list) {

                $details = UserDetail::where('user_id', $list->id)->orderBy('current_cd', 'desc')->first();
                if ($details) {

                    $list->cds = $details;
                    array_push($data, $list);
                } else {

                    $list->cds = "";
                    array_push($data, $list);
                }
            }

            return view('users', compact('data', 'value'));
        }
    }

    public function contact_form_show()
    {

        $data = Contact::find(1);

        return view('contact', compact('data'));
    }

    public function contact_data(Request $request)
    {

        $request->validate([

            'email' => 'required ',
            'contact' => 'required ',

        ]);

        // $users = User::find($request->user_id);


        $user_details = Contact::find(1);
        $user_details->email = $request->email;
        $user_details->contact = $request->contact;
        $user_details->save();

        return redirect(route('contact_form_show'))->with('update_message', 'record add');
    }

    public function change_status_operator($id, $val)
    {


        if ($val == 2) {
            $user = User::find($id);
            $user->active_status = $val;
            $user->completed_status = 1;
            $user->save();
            return redirect()->back()->with('status', 'status changed');
        } else {

            $user = User::find($id);
            $user->active_status = $val;
            $user->save();
            return redirect()->back()->with('status', 'status changed');
        }
    }

    public function change_resolved_status(Request $request)
    {

        $user = User::find($request->user_id_res);
        $user->error_status = 0;
        $user->resolved_status = 1;
        $user->save();
        return redirect()->back()->with('resolved', 'status changed');
    }



    public function tmpUpload(Request $request)
    {

        if ($request->hasFile('filenames')) {

            $file =  $request->file('filenames');
            $file_name = $file->getClientOriginalName();
            $size = $file->getSize();

            $folder = uniqid('track', true);
            $file->storeAs('public/tracks/tmp/' . $folder, $file_name);
            TemporaryFile::create([

                'folder' => $folder,
                'file' => $file_name,
                'size' => $size,
            ]);

            return $folder;
        }
    }

    public function tmpDelete(Request $request)
    {

        dd($request);
    }

    public function profile()
    {

        $record = User::find(1);

        return view('admin_profile', ['record' => $record]);
    }

    public function profile_data(Request $request)
    {
        $request->validate([

            'email' => 'required ',
            'f_name' => 'required '

        ]);

        $record = User::find(1);
        $record->f_name = $request->f_name;
        $record->email = $request->email;
        $record->save();


        if ($request->old_password) {

            $request->validate([

                'old_password' => 'required ',
                'new_password' => 'required '

            ]);

            $hashedPassword = $record->password;

            $userProvidedPassword = $request->old_password;

            // dd($userProvidedPassword); 

            if (password_verify($userProvidedPassword, $hashedPassword)) {

                // return "okay";
                $record = User::find(1);
                $record->password = Hash::make($request->new_password);
                $record->update();
            } else {

                return redirect(route('profile'))->with('wrong_password', 'wrong password');
            }
        }

        return redirect(route('profile'))->with('update_message', 'sdfsdfsdfs');
    }

    public function UserNofication($id, $title, $description, $time)
    {

        $notification = new Notification();
        $notification->user_id = $id;
        $notification->title = $title;
        $notification->description = $description;
        $notification->time = $time;
        $notification->save();

        $user = User::find($id);
        $user_token = $user->device_token;

        $SERVER_API_KEY = 'AAAAaAinbK4:APA91bGxZOevtpzFmGOYbwSlZMfDwGdO0T4Pcc6eAoIvER7GWkP7wGzJPmFs99sJZ6TqcsyjJvRaVGvs1NTmqrBvrPOgYYRPEBf9IfbW9KBM-hjHtMadZHXdvooNmIDmiTkOQyusGLQ4';

        $data = [
            "registration_ids" => [$user_token],
            "data" => [
                "title" => $title,
                "body" => $description,
            ]
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        //dd($response);
    }
}
