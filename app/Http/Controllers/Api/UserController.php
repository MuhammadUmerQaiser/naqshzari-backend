<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AppointmentRequest;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $appointment, $user;
    function __construct(Appointment $appointment, User $user)
    {
        $this->appointment = $appointment;
        $this->user = $user;
    }

    public function bookYourAppointment(AppointmentRequest $request)
    {
        try {
            return $this->appointment->bookYourAppointment($request);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function getAllAppointments(Request $request)
    {
        try {
            return $this->appointment->getAllAppointments($request);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => 500]);
        }
    }

    public function changeUserPassword(Request $request, $userId)
    {
        try {
            return $this->user->changeUserPassword($request, $userId);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => 500]);
        }
    }
}
