<?php

namespace App\Contracts\Services\Attendance;

use Illuminate\Http\Request;

/**
 * Interface for attendance service
 */
interface AttendanceServiceInterface
{
    /**
     * To get attendance lists
     * @return $array of attendances
     */
    public function getAttendances();

    /**
     * To store daily attendance record
     * @return attendance object
     */
    public function saveAttendance(Request $request);

    /**
     * To update daily attendance record
     * @return attendance object
     */
    public function updateAttendance();
}