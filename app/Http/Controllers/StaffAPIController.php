<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon; 
use Illuminate\Support\Facades\Auth;


class StaffAPIController extends Controller
{
    public function add_leave_request(Request $request){
        $validator = Validator::make(
            $request->all(),[
                'start_date' => 'required',
                'end_date' => 'required',
                'reason' => 'required|string'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'ok' => false,
                'msg' => 'Adding leave request failed.' . join(" ", $validator->errors()->all())
            ]);
        }

        try {
            DB::table('leave_management')->insert([
                "staff_id" => $request->staff_id,
                "start_date" => $request->start_date,
                "end_date" => $request->end_date,
                "reason" => $request->reason,
                "status" => 'pending'
            ]);

            return response()->json([
                'ok' => true,
                'msg' => 'Successfully added leave request'
            ]);
        } catch (Exception $e) {
            Log::error("Adding leave request failed: " . $e->getMessage());
            return response()->json([
                'ok' => false,
                'msg' => "Adding leave request failed. An internal error occured. If this continues, contact an andministrator",
                'error' => [
                    'msg' => "Could not add leave request. {$e->getMessage()}",
                    'fix' => "Check errors for clues"
                ]
            ]);
        }
    }

    public function delete_leave_request($id){
        DB::table('leave_management')->where('staff_id', $id)
        ->update(['deleted' => 1]);

        return response()->json([
            'ok' => true,
            'msg' => 'Leave request deleted successfully'
        ]);
    }

    public function clockin(Request $request)
    {
    $validator = Validator::make(
        $request->all(), [
            'date' => 'required|date',
            'status' => 'required'
        ]
    );

    if ($validator->fails()) {
        return response()->json([
            'ok' => false,
            'msg' => 'Failed to clock in attendance' . join(" ", $validator->errors()->all())
        ]);
    }

    try {
        // Validate user
        $check = DB::table('users')->where('staff_id', $request->staff_id)->first();

        if (!$check) {
            return response()->json([
                'ok' => false,
                'msg' => 'Invalid staff number'
            ]);
        }

        // Sample school location (replace with actual coordinates)
        $schoolLatitude = 5.55263;
        $schoolLongitude = -0.20583;

        // Maximum allowed distance (adjust as needed)
        $maxAllowedDistance = 10000;

        // Check if the user is within the allowed distance from the school
        $distance = $this->calculateHaversineDistance($request->latitude, $request->longitude, $schoolLatitude, $schoolLongitude);

        if ($distance > $maxAllowedDistance) {
            return response()->json([
                'ok' => false,
                'msg' => 'You are not on campus. Clocking in is only allowed on campus. Distance: ' . $distance
            ]);
        }

        // Check if it's a school day (Monday to Friday)
    $currentDayOfWeek = now()->dayOfWeek;

    if ($currentDayOfWeek >= 1 && $currentDayOfWeek <= 5) {
    // Check if the current time is beyond the allowed clock-in hours
    $currentTime = now()->format('H:i:s');
    $allowedStartTime = '06:00:00';
    $allowedEndTime = '17:00:00';

    if ($currentTime < $allowedStartTime || $currentTime > $allowedEndTime) {
        // If it's after 5 pm, check if the user has already clocked in
        $lastClockInDate = DB::table('staff_attendances')
            ->where('staff_id', $request->staff_id)
            ->latest('attendance_date')
            ->value('last_clockin_date');

        if ($lastClockInDate == now()->toDateString()) {
            return response()->json([
                'ok' => false,
                'msg' => 'You have already clocked in today. Clocking in is allowed once per day.',
            ]);
        }

        // Insert an "absent" record
        DB::table('staff_attendances')->insert([
            'staff_id' => $request->staff_id,
            'attendance_date' => now()->toDateString(),
            'status' => 'Absent',
            'last_clockin_date' => now()->toDateString(),
        ]);

        return response()->json([
            'ok' => false,
            'msg' => 'Clocking in is only allowed between 6 am and 5 pm.'
        ]);
    }
        } else {
            return response()->json([
                'ok' => false,
                'msg' => 'Clocking in is only allowed on Mondays to Fridays.'
            ]);
        }


        // Clock in for attendance
        DB::table('staff_attendances')->insert([
            'staff_id' => $request->staff_id,
            'attendance_date' => $request->date,
            'status' => $request->status,
            'last_clockin_date' => now()->toDateString(),
        ]);

        return response()->json([
            'ok' => true,
            'msg' => 'Successfully clocked in for attendance'
        ]);

    } catch (\Exception $e) {
        Log::error("Clocking in for attendance failed: " . $e->getMessage());
        return response()->json([
            'ok' => false,
            'msg' => "Clocking in for attendance failed. An internal error occurred. If this continues, please contact an administrator",
            'error' => [
                "msg" => "Could not clock in for attendance. {$e->getMessage()}",
                "fix" => "Check the error message for clues",
            ]
        ]);
    }
}

/**
 * Calculate the Haversine distance between two sets of coordinates.
 */
private function calculateHaversineDistance($lat1, $lon1, $lat2, $lon2)
{
    // Radius of the Earth in meters
    $earthRadius = 6371000;

    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);

    $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    // Distance in meters
    $distance = $earthRadius * $c;

    return $distance;
}


}
