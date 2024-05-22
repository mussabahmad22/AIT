<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserDetailTrack;
use App\Models\Notification;
use App\Models\Breakdown;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    //=============================== User Login Api==========================
    // public function login(Request $request)
    // {
    //     // date_default_timezone_set('Asia/Karachi');
    //     date_default_timezone_set('America/Los_Angeles');
    //     $date = date("Y/m/d");
    //     $day = date('l', strtotime($date));



    //     $rules = [
    //         'client_id' => 'required',
    //         'password' => 'required',
    //         'device_token' => 'required'
    //     ];

    //     $validator = FacadesValidator::make($request->all(), $rules);

    //     if ($validator->fails()) {
    //         $err = $validator->errors()->getMessages();
    //         $msg = array_values($err)[0][0];
    //         $res['status'] = false;
    //         $res['message'] = $msg;

    //         return response()->json($res);
    //     }

    //     $user = User::where('client_id', $request->client_id)->first();

    //     if ($user) {

    //         if ($user->device_id == NULL || $user->device_id == $request->device_id) {


    //             if ($request->password == $user->password) {

    //                 $token  = User::find($user->id);
    //                 $token->device_token = $request->device_token;
    //                 $token->last_active_date = $date;
    //                 $token->last_day_active = $day;
    //                 $token->active_status = 0;
    //                 $token->device_id = $request->device_id;
    //                 $token->device_previous_id = $request->device_id;
    //                 $token->device_type = $request->device_type;
    //                 $token->save();


    //                 $res['status'] = true;
    //                 $res['message'] = "Password Matched! You have Login successfully!";
    //                 $res['data'] =     $token;
    //                 return response()->json($res);
    //             } else {

    //                 $res['status'] = false;
    //                 $res['message'] = "Password mismatch";
    //                 return response()->json($res);
    //             }
    //         } else if ($user->device_id != $request->device_id) {

    //             if ($request->password == $user->password) {

    //                 $token  = User::find($user->id);
    //                 $token->device_token = $request->device_token;
    //                 $token->last_active_date = $date;
    //                 $token->last_day_active = $day;
    //                 $token->active_status = 0;
    //                 $token->device_id = $request->device_id;

    //                 if ($token->device_previous_id !== null) {

    //                     $token->device_previous_id = $token->device_previous_id;

    //                 }
    //                 $token->device_type = $request->device_type;
    //                 $token->device_change = 1;
    //                 $token->save();


    //                 $res['status'] = true;
    //                 $res['message'] = "Password Matched! You have Login successfully!";
    //                 $res['data'] =     $token;
    //                 return response()->json($res);
    //             } else {

    //                 $res['status'] = false;
    //                 $res['message'] = "Password mismatch";
    //                 return response()->json($res);
    //             }
    //         }
    //     } else {

    //         $res['status'] = false;
    //         $res['message'] = "User does not exist";
    //         return response()->json($res);
    //     }
    // }


    public function login(Request $request)
    {
        // date_default_timezone_set('Asia/Karachi');
        date_default_timezone_set('America/Los_Angeles');
        $date = date("Y/m/d");
        $day = date('l', strtotime($date));

        $rules = [
            'client_id' => 'required',
            'password' => 'required',
            'device_token' => 'required'
        ];

        $validator = FacadesValidator::make($request->all(), $rules);

        if ($validator->fails()) {
            $err = $validator->errors()->getMessages();
            $msg = array_values($err)[0][0];
            $res['status'] = false;
            $res['message'] = $msg;

            return response()->json($res);
        }

        $user = User::where('client_id', $request->client_id)->first();

        if ($user) {

            if ($request->password == $user->password) {

                $token  = User::find($user->id);
                $token->device_token = $request->device_token;
                $token->last_active_date = $date;
                $token->last_day_active = $day;
                $token->active_status = 0;
                $token->device_type = $request->device_type;
                $token->save();


                $res['status'] = true;
                $res['message'] = "Password Matched! You have Login successfully!";
                $res['data'] =     $token;
                return response()->json($res);
            } else {

                $res['status'] = false;
                $res['message'] = "Password mismatch";
                return response()->json($res);
            }
        } else {

            $res['status'] = false;
            $res['message'] = "User does not exist";
            return response()->json($res);
        }
    }

    public function device_change_status(Request $request)
    {

        $rules = [
            'user_id' => 'required',

        ];

        $validator = FacadesValidator::make($request->all(), $rules);

        if ($validator->fails()) {
            $err = $validator->errors()->getMessages();
            $msg = array_values($err)[0][0];
            $res['status'] = false;
            $res['message'] = $msg;

            return response()->json($res);
        }

        $user = User::find($request->user_id);

        if ($user) {

            $user->device_change = 0;
            $user->save();


            $res['status'] = true;
            $res['message'] = "Status Changed Successfully!!";
            return response()->json($res);
        } else {

            $res['status'] = false;
            $res['message'] = "User can't exist";
            return response()->json($res);
        }
    }

    public function replace_device_id(Request $request)
    {

        $rules = [
            'user_id' => 'required',
            'device_id' => 'required',


        ];

        $validator = FacadesValidator::make($request->all(), $rules);

        if ($validator->fails()) {
            $err = $validator->errors()->getMessages();
            $msg = array_values($err)[0][0];
            $res['status'] = false;
            $res['message'] = $msg;

            return response()->json($res);
        }

        $user = User::find($request->user_id);

        if ($user) {

            $user->device_id = $request->device_id;
            $user->save();


            $res['status'] = true;
            $res['message'] = "Device ID Changed Successfully!!";
            return response()->json($res);
        } else {

            $res['status'] = false;
            $res['message'] = "User can't exist";
            return response()->json($res);
        }
    }


    // //=============================== User Login Api==========================
    // public function login(Request $request)
    // {
    //     // date_default_timezone_set('Asia/Karachi');
    //     date_default_timezone_set('America/Los_Angeles');
    //     $date = date("Y/m/d");
    //     $day = date('l', strtotime($date));



    //     $rules = [
    //         'client_id' => 'required',
    //         'password' => 'required',
    //         'device_token' => 'required'
    //     ];

    //     $validator = FacadesValidator::make($request->all(), $rules);

    //     if ($validator->fails()) {
    //         $err = $validator->errors()->getMessages();
    //         $msg = array_values($err)[0][0];
    //         $res['status'] = false;
    //         $res['message'] = $msg;

    //         return response()->json($res);
    //     }

    //     $user = User::where('client_id', $request->client_id)->first();

    //     if ($user) {
    //         if ($request->password == $user->password) {

    //             $token  = User::find($user->id);
    //             $token->device_token = $request->device_token;
    //             $token->last_active_date = $date;
    //             $token->last_day_active = $day;
    //             $token->active_status = 0;
    //             $token->device_id = $request->device_id;
    //             $token->device_type = $request->device_type;
    //             $token->save();


    //             $res['status'] = true;
    //             $res['message'] = "Password Matched! You have Login successfully!";
    //             $res['data'] =     $token;
    //             return response()->json($res);
    //         } else {

    //             $res['status'] = false;
    //             $res['message'] = "Password mismatch";
    //             return response()->json($res);
    //         }
    //     } else {

    //         $res['status'] = false;
    //         $res['message'] = "User does not exist";
    //         return response()->json($res);
    //     }
    // }


    //==========================current_cd_details Against User Api ==================================
    public function current_cd_details(Request $request)
    {

        $rules = [
            'user_id' => 'required',
        ];

        $validator = FacadesValidator::make($request->all(), $rules);

        if ($validator->fails()) {
            $err = $validator->errors()->getMessages();
            $msg = array_values($err)[0][0];
            $res['status'] = false;
            $res['message'] = $msg;

            return response()->json($res);
        }

        $user = User::find($request->user_id);
        if (is_null($user)) {
            $res['status'] = false;
            $res['message'] = "user cannot exist";
            return $res;
        }

        $users = User::where('id', $request->user_id)->where('remember_token', NULL)->where('suspended_status', 0)->get();

        $data = [];
        foreach ($users as $list) {

            $details = UserDetail::where('user_id', $list->id)->orderBy('current_cd', 'desc')->first();
            if ($details) {
                $tracks = UserDetailTrack::where('details_id', $details->id)->get();
                $list->user_details =  $details;
                $list->user_tracks =  $tracks;
                array_push($data, $list);
            } else {

                $list->user_details = NULL;
                $list->user_tracks =  [];
                array_push($data, $list);
            }
        }


        if (count($users) == 0) {

            $res['status'] = false;
            $res['message'] = "User Can't Found!";
            return response()->json($res);
        } else {

            $res['status'] = true;
            $res['message'] = "user details";
            $res['data'] = $data;
            return response()->json($res);
        }
    }

    //===================================Notification Against User ==========================
    public function notification(Request $request)
    {

        $user = User::find($request->user_id);
        if (is_null($user)) {
            $res['status'] = false;
            $res['message'] = "user cannot exist";
            return $res;
        }

        $notification = Notification::where('user_id', $request->user_id)->get();

        if (count($notification) == 0) {

            $res['status'] = false;
            $res['message'] = "Notification List Can't Found Against User!!";
            return response()->json($res);
        } else {

            $res['status'] = true;
            $res['message'] = "Notification List Against User!!";
            $res['data'] = $notification;
            return response()->json($res);
        }
    }


    //===================================history Against User ==========================
    public function history(Request $request)
    {

        $user = User::find($request->user_id);
        if (is_null($user)) {
            $res['status'] = false;
            $res['message'] = "user cannot exist";
            return $res;
        }

        $users =  User::where('id', $request->user_id)->where('remember_token', NULL)->where('suspended_status', 0)->get();



        $data = [];

        foreach ($users as $list) {

            $details = UserDetail::where('user_id', $list->id)->whereNotNull('completed_date')->get();
            if ($details) {

                $list->user_details =  $details;

                array_push($data, $list);
            } else {

                $list->user_details =  [];

                array_push($data, $list);
            }
        }

        if (count($users) == 0) {

            $res['status'] = false;
            $res['message'] = "History List Can't Found Against User!!";
            return response()->json($res);
        } else {

            $res['status'] = true;
            $res['message'] = "History List Against User!!";
            $res['data'] = $data;
            return response()->json($res);
        }
    }

    public function time_listened(Request $request)
    {

        $rules = [
            'user_id' => 'required',
            'time_listened' => 'required',

        ];


        $validator = FacadesValidator::make($request->all(), $rules);

        if ($validator->fails()) {
            $err = $validator->errors()->getMessages();
            $msg = array_values($err)[0][0];
            $res['status'] = false;
            $res['message'] = $msg;

            return response()->json($res);
        }

        if ($request->time_listened > 0) {


            $user = User::find($request->user_id);
            if (is_null($user)) {
                $res['status'] = false;
                $res['message'] = "user cannot exist";
                return $res;
            }

            $user = User::find($request->user_id);
            $details = UserDetail::where('user_id', $user->id)->orderBy('current_cd', 'desc')->first();

            $date = date('d-m-Y');
            $date1 = date('Y-m-d');
            $date2 = $user->last_active_date;

            $diff = abs(strtotime($date2) - strtotime($date1));
            $years = floor($diff / (365 * 60 * 60 * 24));
            $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
            $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

            if ($days > 7.0) {
                $user->active_status = 1;
                $user->save();
            }

            if ($request->time_listened  <= $user->time_assigned) {

                // $time = $user->time_listened + $request->time_listened;
                $time = $request->time_listened;
                $time_rmain = $user->time_assigned - $time;

                if ($time_rmain >= 0) {

                    $user->time_remain = $time_rmain;
                    $user->time_listened = $time;
                    $user->save();

                    $res['status'] = true;
                    $res['message'] = "Time Listened Added Sucessfully!!";
                } else {

                    $user->time_remain = 0;
                    $user->time_listened = $time;
                    // $user->total_listened_all_cds =  $user->total_listened_all_cds + $time;

                    $user->save();

                    $res['status'] = true;
                    $res['message'] = "Time Listened Added Sucessfully!!";
                }
            } else {

                $res['status'] = false;
                $res['message'] = "Time Listened is greater than time assigned!!";
            }


            $time1 = $user->time_listened;

            if ($time1 == $user->time_assigned) {

                $details = UserDetail::where('user_id', $user->id)->orderBy('current_cd', 'desc')->first();
                $details->completed_date = $date;
                $details->save();

                if ($details->current_cd == $user->total_cds) {
                    $user->active_status = 2;
                    $user->completed_status = 1;
                    $user->save();
                }
            }
        } else {

            $res['status'] = false;
            $res['message'] = "Please Input Correct Format Value!!";
        }

        return response()->json($res);
    }

    public function breakout(Request $request)
    {

        $result = json_decode($request->getContent(), true);



        // date_default_timezone_set('America/Los_Angeles');
        // $date = date('m-d-Y');

        //dd($date);

        $rules = [
            'user_id' => 'required',
            'time_listened' => 'required',
            'breakdown' => 'required',

        ];

        $validator = FacadesValidator::make($request->all(), $rules);

        if ($validator->fails()) {
            $err = $validator->errors()->getMessages();
            $msg = array_values($err)[0][0];
            $res['status'] = false;
            $res['message'] = $msg;

            return response()->json($res);
        }

        if ($request->time_listened > 0) {

            $cd = UserDetail::where('user_id', $result['user_id'])->orderBy('current_cd', 'desc')->first();

            if ($cd) {


                $user = User::find($result['user_id']);
                if (is_null($user)) {
                    $res['status'] = false;
                    $res['message'] = "user cannot exist";
                    return $res;
                }

                $users = User::find($request->user_id);
                $details = UserDetail::where('user_id', $users->id)->orderBy('current_cd', 'desc')->first();

                $date = date('d-m-Y');
                $date1 = date('Y-m-d');
                $date2 = $user->last_active_date;

                $diff = abs(strtotime($date2) - strtotime($date1));
                $years = floor($diff / (365 * 60 * 60 * 24));
                $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

                if ($days > 7.0) {
                    $users->active_status = 1;
                    $users->save();
                }

                if ($request->time_listened  <= $users->time_assigned) {

                    // $time = $user->time_listened + $request->time_listened;
                    $time = $request->time_listened;

                    if ($users->time_remain == NULL) {

                        $time_rmain = $users->time_assigned - $time;
                    } else {

                        $time_rmain = $users->time_remain - $time;
                    }


                    if ($time_rmain >= 0) {

                        $users->time_remain = $time_rmain;
                        $users->time_listened = $users->time_listened + $time;
                        $users->save();

                        $res['status'] = true;
                        $res['message'] = "Time Listened Added Sucessfully!!";
                    } else {

                        $users->time_remain = 0;
                        $users->time_listened = $users->time_listened + $time;
                        $users->save();

                        $res['status'] = true;
                        $res['message'] = "Time Listened Added Sucessfully!!";
                    }
                } else {

                    $res['status'] = false;
                    $res['message'] = "Time Listened is greater than time assigned!!";
                    return response()->json($res);
                }


                $time1 = $users->time_listened;

                if ($time1 == $users->time_assigned) {

                    $details = UserDetail::where('user_id', $users->id)->orderBy('current_cd', 'desc')->first();
                    $details->completed_date = $date;
                    $details->save();

                    if ($details->current_cd == $user->total_cds) {
                        $user->active_status = 2;
                        $user->completed_status = 1;
                        $user->save();
                    }
                }


                $user = User::find($result['user_id']);

                if ($user) {

                    $cd = UserDetail::where('user_id', $result['user_id'])->orderBy('current_cd', 'desc')->first();


                    $breakdowns = $result['breakdown'];

                    // return $breakdowns;

                    $break_down_delete = Breakdown::where('details_id',  $cd->id);
                    if ($break_down_delete) {

                        foreach ($breakdowns as $list) {

                            $var = Breakdown::where('details_id',  $cd->id)->where('date',  $list['start_date'])->where('start_time', $list['start_time']);
                            $var->delete();
                        }
                    }


                    foreach ($breakdowns as $list) {


                        $breakdown = new Breakdown();
                        $breakdown->details_id = $cd->id;
                        $breakdown->date = $list['start_date'];
                        $breakdown->start_time = $list['start_time'];
                        $breakdown->duration =  $list['duration'];
                        $breakdown->save();
                    }


                    $res['status'] = true;
                    $res['message'] = "Data Inserted Sucessfully Both Breakdown and Time Listened!! ";
                    return response()->json($res);
                } else {


                    $res['status'] = false;
                    $res['message'] = "User Can't Exist!!";
                    return response()->json($res);
                }
            } else {

                $res['status'] = false;
                $res['message'] = "CD Is Not Yet Assigned!!";
                return response()->json($res);
            }
        } else {

            $res['status'] = false;
            $res['message'] = "Please Input Correct Format Value!!";
            return response()->json($res);
        }
    }

    //===================================Chk User Against User ==========================
    public function chk_user(Request $request)
    {

        $user = User::find($request->user_id);

        if (is_null($user)) {

            $res['status'] = true;
            $res['message'] = "User Not Found!!";
            $res['user_status'] = 2;
            return response()->json($res);
        } else {

            $users =  User::where('id', $request->user_id)->where('remember_token', NULL)->where('suspended_status', 0)->count();

            if ($users > 0) {

                $res['status'] = true;
                $res['message'] = "User Found!!";
                $res['user_status'] = 0;
                return response()->json($res);
            } else {
                $res['status'] = true;
                $res['message'] = "User Found!!";
                $res['user_status'] = 1;
                return response()->json($res);
            }
        }
    }

    //===================================Player_time Against User ==========================
    public function player_time(Request $request)
    {

        $user = User::find($request->user_id);
        if (is_null($user)) {
            $res['status'] = false;
            $res['message'] = "user cannot exist";
            return $res;
        }

        $user = User::select('time_listened', 'time_assigned')->where('id', $request->user_id)->first();

        if ($user->time_assigned > 0) {

            $percentage = $user->time_listened / $user->time_assigned * 100;

            $percent = number_format($percentage, 2);
        } else {

            $percent = 0;
        }


        if (is_null($user)) {

            $res['status'] = false;
            $res['message'] = "User Not Found!!";
            return response()->json($res);
        } else {

            $res['status'] = true;
            $res['message'] = "User Found!!";
            $res['data'] = $user;
            $res['percent'] = $percent;
            return response()->json($res);
        }
    }

    //===================================Player_time Against User ==========================
    public function percentage(Request $request)
    {

        $user = User::find($request->user_id);
        if (is_null($user)) {
            $res['status'] = false;
            $res['message'] = "user cannot exist";
            return $res;
        }

        $user = User::select('time_listened', 'time_assigned')->where('id', $request->user_id)->first();

        if (is_null($user)) {

            $res['status'] = false;
            $res['message'] = "User Not Found!!";
            return response()->json($res);
        } else {

            if ($user->time_assigned > 0) {

                $percentage = $user->time_listened / $user->time_assigned * 100;

                $percent = number_format($percentage, 2);
            } else {

                $percent = 0;
            }

            // $percentage = $user->time_listened / $user->time_assigned * 100;

            // $percent = number_format($percentage,2);

            $res['status'] = true;
            $res['message'] = "Percentage!!";
            $res['percent'] = $percent;
            return response()->json($res);
        }
    }



    // public function breakout(Request $request)
    // {

    //     $result = json_decode($request->getContent(), true);



    //     // date_default_timezone_set('America/Los_Angeles');
    //     // $date = date('m-d-Y');

    //     //dd($date);

    //     $rules = [
    //         'user_id' => 'required',
    //         'breakdown' => 'required',

    //     ];

    //     $validator = FacadesValidator::make($request->all(), $rules);

    //     if ($validator->fails()) {
    //         $err = $validator->errors()->getMessages();
    //         $msg = array_values($err)[0][0];
    //         $res['status'] = false;
    //         $res['message'] = $msg;

    //         return response()->json($res);
    //     }

    //     $user = User::find($result['user_id']);
    //     if (is_null($user)) {
    //         $res['status'] = false;
    //         $res['message'] = "user cannot exist";
    //         return $res;
    //     }


    //     $user = User::find($result['user_id']);

    //     if ($user) {

    //         $cd = UserDetail::where('user_id', $result['user_id'])->orderBy('current_cd', 'desc')->first();

    //         if ($cd) {

    //             $breakdowns = $result['breakdown'];

    //             // return $breakdowns;

    //             $break_down_delete = Breakdown::where('details_id',  $cd->id);
    //             if ($break_down_delete) {

    //                 foreach ($breakdowns as $list) {

    //                     $var = Breakdown::where('details_id',  $cd->id)->where('date',  $list['start_date'])->where('start_time', $list['start_time']);
    //                     $var->delete();
    //                 }
    //             }
    //             // $break_down_delete->delete();


    //             foreach ($breakdowns as $list) {

    //                 // $date = date("mm-dd-YYYY");

    //                 // if()


    //                 $breakdown = new Breakdown();
    //                 $breakdown->details_id = $cd->id;
    //                 $breakdown->date = $list['start_date'];
    //                 $breakdown->start_time = $list['start_time'];
    //                 $breakdown->duration =  $list['duration'];
    //                 $breakdown->save();
    //             }


    //             $res['status'] = true;
    //             $res['message'] = "Data Inserted Sucessfully!!";
    //             return response()->json($res);
    //         } else {

    //             $res['status'] = false;
    //             $res['message'] = "CD Is Not Yet Assigned!!";
    //             return response()->json($res);
    //         }
    //     } else {

    //         $res['status'] = false;
    //         $res['message'] = "User Can't Exist!!";
    //         return response()->json($res);
    //     }
    // }

    public function breakdown(Request $request)
    {


        $rules = [
            'detail_id' => 'required',
        ];

        $validator = FacadesValidator::make($request->all(), $rules);

        if ($validator->fails()) {
            $err = $validator->errors()->getMessages();
            $msg = array_values($err)[0][0];
            $res['status'] = false;
            $res['message'] = $msg;

            return response()->json($res);
        }


        $breakdown = Breakdown::where('details_id', $request->detail_id)->get();

        if (is_null($breakdown)) {

            $res['status'] = false;
            $res['message'] = "Breakdown Can't Exist!!";
            return response()->json($res);
        } else {

            $res['status'] = true;
            $res['message'] = "Breakdown Data !!";
            $res['data'] = $breakdown;
            return response()->json($res);
        }
    }

    public function breakdown_all_user(Request $request)
    {

        $rules = [
            'user_id' => 'required',
        ];

        $validator = FacadesValidator::make($request->all(), $rules);

        if ($validator->fails()) {
            $err = $validator->errors()->getMessages();
            $msg = array_values($err)[0][0];
            $res['status'] = false;
            $res['message'] = $msg;

            return response()->json($res);
        }


        $details = UserDetail::where('user_id', $request->user_id)->get();

        $data = [];

        foreach ($details as $list) {

            // $breakdown = Breakdown::where('details_id', $list->id)->get();

            $breakdown = Breakdown::where('details_id', $list->id)->orderBy('date', 'desc')->orderBy('start_time', 'desc')->get();


            $list->breakdown_list = $breakdown;
            array_push($data, $list);
        }

        $res['status'] = true;
        $res['message'] = "User Breakdown Details !!";
        $res['data'] = $data;
        return response()->json($res);
    }

    public function contact()
    {

        $contact = Contact::find(1);

        if (is_null($contact)) {

            $res['status'] = false;
            $res['message'] = "Contact Can't Exist!!";
            return response()->json($res);
        } else {

            $res['status'] = true;
            $res['message'] = "Contact Details !!";
            $res['data'] = $contact;
            return response()->json($res);
        }
    }

    public function token(Request $request)
    {

        $token = User::select('device_id')->where('id', $request->user_id)->first();

        if (is_null($token)) {

            $res['status'] = false;
            $res['message'] = "User Can't Exist!!";
            return response()->json($res);
        } else {

            $res['status'] = true;
            $res['message'] = " Token !!";
            $res['data'] = $token;
            return response()->json($res);
        }
    }

    public function silent_noti(Request $request)
    {

        // date_default_timezone_set('America/Los_Angeles');
        // date_default_timezone_set('Asia/Karachi');


        // $time = date("h:i:sa");

        // $time11 = "11:00:00pm";
        // $time12 = "12:00:00am";



        // if ($time > $time11 && $time < $time12 ) {

        //     // $user = User::find(14);
        //     // $user->l_name = "Cron_Job_run_11pm";
        //     // $user->save();

        //     $users = User::all();

        //     foreach ($users as $user) {

        //         if ($user->device_type == 1) {

        //             $device_token = $user->device_token;

        //             $SERVER_API_KEY = 'AAAAaAinbK4:APA91bGxZOevtpzFmGOYbwSlZMfDwGdO0T4Pcc6eAoIvER7GWkP7wGzJPmFs99sJZ6TqcsyjJvRaVGvs1NTmqrBvrPOgYYRPEBf9IfbW9KBM-hjHtMadZHXdvooNmIDmiTkOQyusGLQ4';

        //             $data = [
        //                 "registration_ids" => [$device_token],
        //                 "data" => [
        //                     "title" => 'Silent Notification',
        //                     "content_available" => true,
        //                 ]
        //             ];
        //             $dataString = json_encode($data);

        //             $headers = [
        //                 'Authorization: key=' . $SERVER_API_KEY,
        //                 'Content-Type: application/json',
        //                 'apns-push-type' => 'background',
        //                 'apns-priority ' => '5',
        //             ];

        //             $ch = curl_init();

        //             curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        //             curl_setopt($ch, CURLOPT_POST, true);
        //             curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //             curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //             curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        //             $response = curl_exec($ch);

        //             //dd($response);
        //         }
        //     }
        // }



        $rules = [
            'token' => 'required',
        ];

        $validator = FacadesValidator::make($request->all(), $rules);

        if ($validator->fails()) {
            $err = $validator->errors()->getMessages();
            $msg = array_values($err)[0][0];
            $res['status'] = false;
            $res['message'] = $msg;

            return response()->json($res);
        }

        $this->silentNotification($request->token);
    }


    public function silentNotification($token)
    {

        $device_token = $token;

        $SERVER_API_KEY = 'AAAAaAinbK4:APA91bGxZOevtpzFmGOYbwSlZMfDwGdO0T4Pcc6eAoIvER7GWkP7wGzJPmFs99sJZ6TqcsyjJvRaVGvs1NTmqrBvrPOgYYRPEBf9IfbW9KBM-hjHtMadZHXdvooNmIDmiTkOQyusGLQ4';

        $data = [
            "registration_ids" => [$device_token],
            "data" => [
                "title" => 'Silent Notification',
                "content_available" => true,

            ]
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
            'apns-push-type' => 'background',
            'apns-priority ' => '5',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        // dd($response);
    }
}
