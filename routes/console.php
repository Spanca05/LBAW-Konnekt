<?php

use Illuminate\Support\Facades\Schedule;
use App\Models\JobPost;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;

Schedule::call(function () {

    // JOB POSTS ABOUT TO EXPIRE (next 24h)
    $aboutToExpire = JobPost::whereNotNull('deadline')
        ->whereBetween('deadline', [now(), now()->addHours(24)])
        ->get();

    foreach ($aboutToExpire as $jobPost) {

        // evitar spam: não repetir a mesma notificação
        $alreadyNotified = Notification::where('jobpost_id', $jobPost->id)
            ->where('title', 'like', '%about to expire%')
            ->exists();

        if ($alreadyNotified) continue;

        $notification = Notification::create([
            'title' => 'Your job post "' . $jobPost->title . '" is about to expire!',
            'date' => now(),
            'type' => 'JobPostNotification',
            'jobpost_id' => $jobPost->id
        ]);

        $jobPost->employer->notifications()->attach(
            $notification->id,
            ['seen' => false]
        );

    }

    // JOB POSTS EXPIRED
    $expired = JobPost::whereNotNull('deadline')
        ->where('deadline', '<=', now())
        ->get();

    foreach ($expired as $jobPost) {

        $alreadyExpiredNotified = Notification::where('jobpost_id', $jobPost->id)
            ->where('title', 'like', '%has expired%')
            ->exists();

        if ($alreadyExpiredNotified) continue;

        $notification = Notification::create([
            'title' => 'Your job post "' . $jobPost->title . '" has expired!',
            'date' => now(),
            'type' => 'JobPostNotification',
            'jobpost_id' => $jobPost->id
        ]);
           
        $jobPost->employer->notifications()->attach(
            $notification->id,
            ['seen' => false]
        );
    }

})->everyMinute()->name('jobpost-expiration-check')->withoutOverlapping();
