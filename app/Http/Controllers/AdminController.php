<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function index(){
        return view('auth.login');
    }

    public function dashboard(){
        $totalStaffCount = DB::table('staff')->where('deleted', 0)->count();
        $notices = DB::table('announcement')->select('title')->where('deleted', 0)->get();
        $items = DB::table('staff_attendances')->select('*', 'users.staff_id')
        ->join('users', 'staff_attendances.staff_id', 'users.staff_id')
        ->where('staff_attendances.attendance_date', now()->toDateString())
        ->where('users.staff_id', Auth::user()->staff_id)
        ->first();
        $totalAttendanceCount = DB::table('staff_attendances')->count();
        // Get the authenticated user
        $user = Auth::user();
            // dd($user->role);
        // Check the user's role and redirect accordingly
        switch ($user->role) {
            case 'HOD':
                return view('admin_dash.index', ['totalStaffCount' => $totalStaffCount, 'notices' => $notices, 'totalAttendanceCount' => $totalAttendanceCount]);
            case 'staff':
                return view('user_dash.index', ['notices' => $notices, 'items' => $items]); // Adjust this to the user dashboard view
            // Add more cases for other roles if needed
            }
        }

    public function admin_attendance(){
        $items = DB::table('leave_management')
        ->select('*', 'users.name')
        ->join('users', 'leave_management.staff_id', 'users.staff_id')
        ->where('leave_management.deleted', 0)
        ->get();
        $clockinstatus = DB::table('staff_attendances')
        ->select('*' , 'users.name')
        ->join('users', 'staff_attendances.staff_id', 'users.staff_id')
        // ->where('users.deleted', 0)
        ->get();
        $attendanceData = DB::table('staff_attendances')
        ->select(
        DB::raw('MONTH(attendance_date) as month'),
        DB::raw('COUNT(*) as attendance_count'),
        DB::raw('SUM(CASE WHEN status = "Clock In" THEN 1 ELSE 0 END) as clock_in_count'),
        DB::raw('SUM(CASE WHEN status = "Absent" THEN 1 ELSE 0 END) as absent_count')
    )
    ->groupBy(DB::raw('MONTH(attendance_date)'))
    ->get();
        // dd($attendanceData); 
        return view('admin_dash.attendance', ['items' => $items, 'clockinstatus' => $clockinstatus, 'attendanceData' => $attendanceData]);
    }

    public function admin_staff(){
        $staffs = DB::table('staff')->select('*')
        ->where('deleted', 0)
        ->get();
        return view('admin_dash.staff', ['staffs' => $staffs]);
    }

    public function admin_notice(){
        $notices = DB::table('announcement')->select('*')->where('deleted', 0)
        ->get();
        return view('admin_dash.notice', ['notices' => $notices]);
    }

    public function getStaffAttendanceData(){
        $attendanceData = DB::table('staff_attendances')
            ->select('staff_id', DB::raw('COUNT(*) as attendance_count'))
            ->groupBy('staff_id')
            ->get();

        $attendanceData = $attendanceData->map(function ($entry) {
            $entry->staff_name = DB::table('users')->where('staff_id', $entry->staff_id)->value('name');
            return $entry;
        });

        return response()->json($attendanceData);
    }
}
