<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    private $otp;

    // public function __construct()
    // {
    //     $this->otp = new Otp;
    // }

    // public function sendEmailVerification() {
    //     $request->user()->notify(new EmailVerificationNotification());
    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'success send email verification',
    //     ], 200);
    // }
}
