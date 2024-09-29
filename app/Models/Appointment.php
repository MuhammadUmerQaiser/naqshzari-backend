<?php

namespace App\Models;

use App\Http\Resources\AppointmentResource;
use App\Notifications\AppointmentNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;

class Appointment extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'phone', 'date', 'time'];

    public function bookYourAppointment(Request $request)
    {
        $appointment = $this;
        $appointment->name = $request->name;
        $appointment->email = $request->email;
        $appointment->phone = $request->phone;
        $appointment->date = $request->date;
        $appointment->time = $request->time;
        $appointment->save();

        $appointment = new AppointmentResource($appointment);
        // $appointment->notify(new AppointmentNotification($appointment));
        Notification::route('mail', 'naqshzari@yopmail.com')
            ->notify(new AppointmentNotification($appointment));

        return response()->json(['status' => 200, 'message' => 'Catalog created successfully.', 'data' => $appointment]);
    }

    public function getAllAppointments(Request $request)
    {
        $appointments = $this;
        $appointments = $appointments->orderByDesc('id')->get();
        $colection = AppointmentResource::collection($appointments);
        return response()->json(['status' => 200, 'data' => $colection]);
    }
}
