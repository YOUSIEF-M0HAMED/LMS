<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Message;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ChatController extends Controller
{
  public function show($courseId, $userId)
  {
    $minutes = 2;
    $onlineThreshold = Carbon::now()->subMinutes($minutes);
    $course = Course::find($courseId);
    $onlineStudentCount = $course->students()->where('last_seen', '>=', $onlineThreshold)->count();
    $onlineTeacherCount = $course->teacher()->where('last_seen', '>=', $onlineThreshold)->count();
    $allOnlineUsers= $onlineStudentCount+$onlineTeacherCount;
    $courseName=$course->name;
    $currentCourse = Course::findOrfail($courseId);
    $oldMessages = $currentCourse->messages;
      return view('teacher.courses.chat', compact('courseId','oldMessages'
    ,'allOnlineUsers','courseName'));

  }

  public function sendMessage(Request $request)
  {
      // Validate the request data
      $request->validate([
          'sender_id' => 'required|integer',
          'sender_type' => 'required|string|in:teacher,student',
          'course_id' => 'required|integer|exists:courses,id',
          'message' => 'required|string',
      ]);

      Message::create([
        'sender_id' => $request->sender_id ,
        'sender_type' => $request->sender_type ,
        'course_id' => $request->course_id ,
        'message' => $request->message ,
        'type' => 'text'  ,
      ]);

      $message = Message::latest()->first();
      $sender = $message->sender;

      try {
        event(new MessageSent($message));
        Log::info('MessageSent event fired successfully.');
    } catch (\Exception $e) {
        Log::error('Failed to fire MessageSent event: ' . $e->getMessage());
    }

      $response = [
        'success' => true,
        'message' => $message,
        'sender' => $sender,
    ];


    // Return the response as JSON
    return response()->json($response);


    }


    public function uploadVoice(Request $request)
    {
        if ($request->hasFile('audio')) {
            $file = $request->file('audio');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('courses/chat-voice-messages');
            $file->move($destinationPath, $filename);

            $path = 'courses/chat-voice-messages/' . $filename;

            $voiceMessage = new Message();
            $voiceMessage->sender_id = $request->sender_id;
            $voiceMessage->sender_type = $request->sender_type;
            $voiceMessage->course_id = $request->course_id;
            $voiceMessage->message = $path;
            $voiceMessage->type = 'voice';
            $voiceMessage->save();

            return response()->json(['success' => true, 'message' => 'Voice message uploaded successfully', 'path' => $path]);
        }

        return response()->json(['success' => false, 'message' => 'No audio file uploaded'], 400);
    }


    public function getLatestMessages($courseId)
{
    $latestMessages = Message::where('course_id', $courseId)
    ->where('created_at', '>', now()->subSeconds(2)) // Adjust the timeframe to 2 seconds
                             ->orderBy('created_at', 'asc')
                             ->with('sender')
                             ->get();
    return response()->json($latestMessages);
}

}