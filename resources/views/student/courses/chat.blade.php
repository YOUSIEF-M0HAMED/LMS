@extends('student.layouts.app')

@section('pageTitle')
    Chat
@endsection

@section('pageStyle')
    <link rel="stylesheet" href="{{ asset('assets/css/courses.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row h-100">
            <main class="ms-sm-auto px-md-4">
                <div class="chat-header top-0 p-2 mb-5">
                    <h3 class="d-inline-block">{{ $courseName }}</h3>
                    <span>"number of online users" : {{ $allOnlineUsers }}</span>
                </div>
                <div class="chat-body overflow-x-hidden">
                    @if ($oldMessages->isEmpty())
                        <div class="row align-items-end flex-column msg-out">
                            <div class="bg-success col-lg-6 rounded-3 p-2 mb-3">
                                <h3 class="mt-2">
                                    This Chat Is Empty
                                </h3>
                            </div>
                        </div>
                    @else
                        @foreach ($oldMessages as $message)
                            @if ($message->sender->is(Auth::guard('student')->user()))
                                <div class="row align-items-start justify-content-start flex-row-reverse msg-out">
                                    @if (empty($message->sender->image))
                                        <img class="d-inline-block" src="{{ asset('images/un known person.jpeg') }}"
                                            alt="" />
                                    @else
                                        <img class="d-inline-block" src="{{ asset($message->sender->image) }}"
                                            alt="" />
                                    @endif
                                    <div class="msg-content col-lg-6 rounded-3 p-2 mb-3 w-auto text-white">
                                        <div class="w-full">
                                            <p class="d-inline-block fw-bold">
                                                {{ $message->sender->fname . ' ' . $message->sender->lname }}</p>
                                        </div>
                                        @if ($message->type === 'text')
                                            <span class="mt-2">
                                                {{ $message->message }}
                                            </span>
                                        @elseif ($message->type === 'voice')
                                            <audio controls src="{{ asset($message->message) }}" class="mt-2"></audio>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="row align-items-start flex-row msg-in">
                                    @if (empty($message->sender->image))
                                        <img class="d-inline-block" src="{{ asset('images/un known person.jpeg') }}"
                                            alt="" />
                                    @else
                                        <img class="d-inline-block" src="{{ asset($message->sender->image) }}"
                                            alt="" />
                                    @endif
                                    <div class="msg-content col-lg-6 rounded-3 p-2 mb-3 w-auto text-white">
                                        <div class="w-full">
                                            <p class="d-inline-block fw-bold">
                                                {{ $message->sender->fname . ' ' . $message->sender->lname }}</p>
                                        </div>
                                        @if ($message->type === 'text')
                                            <span class="mt-2">
                                                {{ $message->message }}
                                            </span>
                                        @elseif ($message->type === 'voice')
                                            <audio controls src="{{ asset($message->message) }}" class="mt-2"></audio>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>

                <div class="chat-form-container">
                    <form id="chat-form">
                        @csrf
                        @method('POST')
                        <div class="input-group">
                            <input type="hidden" name="sender_id" value="{{ Auth::guard('student')->id() }}">
                            <input type="hidden" name="sender_type" value="student">
                            <input type="hidden" name="course_id" value="{{ $courseId }}">
                            <input type="text" name="message" class="form-control chat-input" placeholder="type..." />

                            <button id="btn-audio-recorder" type="button"
                                class="btn btn-secondary mic-icon border border-right border-1 border-white">
                                <i class="fa-solid fa-microphone"></i>
                            </button>

                            <button class="btn btn-secondary send-icon" type="submit">
                                <i class="fa-solid fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                    <div id="audio-control-buttons" style="display: none;">
                        <button id="btn-pause-resume" type="button" class="btn btn-warning">Pause</button>
                        <button id="btn-cancel-recording" type="button" class="btn btn-danger">Cancel</button>
                    </div>
                    <audio id="audioPlayback" controls style="display:none;"></audio>
                </div>
            </main>
        </div>
    </div>
@endsection

@section('pageScript')
    <script src="{{ asset('assets/js/courses.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('chat-form');
            const recordButton = document.getElementById('btn-audio-recorder');
            const pauseResumeButton = document.getElementById('btn-pause-resume');
            const cancelButton = document.getElementById('btn-cancel-recording');
            const audioControlButtons = document.getElementById('audio-control-buttons');
            const audioPlayback = document.getElementById('audioPlayback');
            let mediaRecorder;
            let audioChunks = [];

            form.addEventListener('submit', function(event) {
                event.preventDefault();

                const formData = new FormData(form);
                const url = '{{ route('student.chat.sendMessage') }}';

                fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            form.reset();
                        } else {
                            console.error('Error sending message:', data.error);
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });

            recordButton.addEventListener('click', async () => {
                if (!mediaRecorder || mediaRecorder.state === 'inactive') {
                    const stream = await navigator.mediaDevices.getUserMedia({
                        audio: true
                    });
                    mediaRecorder = new MediaRecorder(stream);
                    mediaRecorder.start();

                    audioChunks = [];
                    mediaRecorder.ondataavailable = event => {
                        audioChunks.push(event.data);
                    };

                    recordButton.innerHTML = '<i class="fa-solid fa-stop"></i>';
                    audioControlButtons.style.display = 'block';
                    pauseResumeButton.innerText = 'Pause';
                } else {
                    mediaRecorder.stop();
                    mediaRecorder.onstop = async () => {
                        const audioBlob = new Blob(audioChunks, {
                            type: 'audio/wav'
                        });
                        const audioUrl = URL.createObjectURL(audioBlob);
                        audioPlayback.src = audioUrl;

                        const formData = new FormData();
                        formData.append('audio', audioBlob, 'voiceMessage.wav');
                        formData.append('_token', '{{ csrf_token() }}');
                        formData.append('sender_id', '{{ Auth::guard('student')->id() }}');
                        formData.append('sender_type', 'student');
                        formData.append('course_id', '{{ $courseId }}');

                        const response = await fetch(
                            '{{ route('student.chat.uploadVoice') }}', {
                                method: 'POST',
                                body: formData
                            });

                        const result = await response.json();
                        if (result.success) {
                            console.log('Voice message uploaded successfully');
                        } else {
                            console.error('Error uploading voice message:', result.error);
                        }

                        recordButton.innerHTML = '<i class="fa-solid fa-microphone"></i>';
                        audioControlButtons.style.display = 'none';
                        audioPlayback.style.display = 'none';
                    };
                }
            });

            pauseResumeButton.addEventListener('click', () => {
                if (mediaRecorder.state === 'recording') {
                    mediaRecorder.pause();
                    pauseResumeButton.innerText = 'Resume';
                } else if (mediaRecorder.state === 'paused') {
                    mediaRecorder.resume();
                    pauseResumeButton.innerText = 'Pause';
                }
            });

            cancelButton.addEventListener('click', () => {
                if (mediaRecorder) {
                    mediaRecorder.stop();
                    mediaRecorder = null;
                    audioChunks = [];
                    recordButton.innerHTML = '<i class="fa-solid fa-microphone"></i>';
                    audioControlButtons.style.display = 'none';
                    audioPlayback.style.display = 'none';
                }
            });

            function fetchLatestMessages() {
                const courseId = {{ $courseId }};
                const url = `{{ route('student.chat.latestMessages', ['courseId' => '__courseId__']) }}`.replace(
                    '__courseId__', courseId);

                fetch(url)
                    .then(response => response.json())
                    .then(messages => {
                        const chatBody = document.querySelector('.chat-body');

                        messages.forEach(message => {
                            let messageHtml;

                            if (message.type === 'text') {
                                messageHtml = `
                                    <div class="row align-items-start ${message.sender_id == {{ Auth::guard('student')->id() }} && message.sender_type == 'student' ? 'flex-row-reverse' : ''} msg-out">
                                        <img class="d-inline-block" src="/${message.sender.image || '/images/un known person.jpeg' }" alt="" />
                                        <div class="msg-content col-lg-6 rounded-3 p-2 mb-3 w-auto text-white">
                                            <div class="w-full">
                                                <p  class="d-inline-block fw-bold">${message.sender.fname} ${message.sender.lname}</p>
                                            </div>
                                            <span class="mt-2">${message.message}</span>
                                        </div>
                                    </div>`;
                            } else if (message.type === 'voice') {
                                messageHtml = `
                                    <div class="row align-items-start ${message.sender_id == {{ Auth::guard('student')->id() }} && message.sender_type == 'student' ? 'flex-row-reverse' : ''} msg-out">
                                        <img class="d-inline-block" src="/${message.sender.image || '/images/un known person.jpeg' }" alt="" />
                                        <div class="msg-content col-lg-6 rounded-3 p-2 mb-3 w-auto text-white">
                                            <div class="w-full">
                                                <p class="d-inline-block fw-bold">${message.sender.fname} ${message.sender.lname}</p>
                                            </div>
                                            <audio controls src="{{ asset('${message.message}') }}" class="mt-2"></audio>
                                        </div>
                                    </div>`;
                            }
                            chatBody.insertAdjacentHTML('beforeend', messageHtml);
                        });

                    })
                    .catch(error => console.error('Error fetching messages:', error));
            }

            setInterval(fetchLatestMessages, 2000);

            function scrollToLastMessage() {
                const chatMessages = document.querySelectorAll('.chat-body .msg-out, .chat-body .msg-in');
                if (chatMessages.length > 0) {
                    const lastMessage = chatMessages[chatMessages.length - 1];
                    lastMessage.scrollIntoView({
                        behavior: 'smooth',
                        block: 'end'
                    });
                }
            }

            scrollToLastMessage();
        });
    </script>
@endsection
