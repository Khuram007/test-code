<?php

namespace DTApi\Helpers;

use Carbon\Carbon;
use DTApi\Models\Job;
use DTApi\Models\User;
use DTApi\Models\Language;
use DTApi\Models\UserMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TeHelper
{
    /**
     * @param $id
     * @return mixed
     */
    public static function fetchLanguageFromJobId($id)
    {
        $language = Language::findOrFail($id);
        return $language1 = $language->language;
    }

    /**
     * @param $user_id
     * @param bool $key
     * @return mixed
     */
    public static function getUsermeta($user_id, $key = false)
    {
        return $user = UserMeta::where('user_id', $user_id)->first()->$key;
    }

    /**
     * @param $jobs_ids
     * @return array
     */
    public static function convertJobIdsInObjs($jobs_ids)
    {
        $jobs = array();
        if ($jobs_ids)
            foreach ($jobs_ids as $job_obj) {
                $jobs[] = Job::findOrFail($job_obj->id);
            }
        return $jobs;
    }

    /**
     * @param $due_time
     * @param $created_at
     * @return mixed
     */
    public static function willExpireAt($due_time, $created_at)
    {
        $due_time = Carbon::parse($due_time);
        $created_at = Carbon::parse($created_at);
        $difference = $due_time->diffInHours($created_at);
        if ($difference <= 90) $time = $due_time;
        elseif ($difference <= 24) $time = $created_at->addMinutes(90);
        elseif ($difference > 24 && $difference <= 72) $time = $created_at->addHours(16);
        else $time = $due_time->subHours(48);
        return $time->format('Y-m-d H:i:s');
    }

}

