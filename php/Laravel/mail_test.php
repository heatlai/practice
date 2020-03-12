<?php

Route::get(
    'send_test_email',
    function () {
        Mail::raw(
            'PRE TEST BODY',
            function ($message) {
                $message->to('testheatlai@gmail.com');
                $message->subject('PRE TEST SUBJECT');
            }
        );
    }
);

Mail::raw(
    'PRODUCTION TEST BODY',
    function ($message) {
        $message->to('testheatlai@gmail.com');
        $message->subject('PRODUCTION TEST SUBJECT');
    }
);
