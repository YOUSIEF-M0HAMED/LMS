<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

  public function markAsRead($id)
  {
      $notification = auth()->guard('student')->user()->notifications()->find($id);
      if ($notification) {
          $notification->markAsRead();
      }
      return redirect()->back();
  }

  public function markAllAsRead(Request $request)
  {
      auth()->guard('student')->user()->unreadNotifications->markAsRead();

      return back();
  }
}