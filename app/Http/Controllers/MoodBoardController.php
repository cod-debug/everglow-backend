<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MoodBoardModel;

class MoodBoardController extends Controller
{
    //

    public function getPublicIpAddress()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            // Check if IP is from shared internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // Check if IP is passed from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            // Use remote IP address
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public function postMood(Request $request){
        $ip_address = base64_decode($request->get('ip_address'));
        $mood = $request->mood;
        $day = $request->day;

        if(empty($ip_address) || empty($mood) || empty($day)){
            return response()->json([
                'message' => 'Failed to save mood. Kindly check input'
            ], 400);
        }

        // update status if device already voted
        $mood_model = MoodBoardModel::where('ip_address', $ip_address)
        ->where('day', $day)->first();

        if($mood_model){
            $mood_model->mood = $mood;
            $mood_model->save();

            return response()->json([
                'message' => 'Successfully updated mood'
            ], 200);
        }

        // save mood
        MoodBoardModel::create([
            'ip_address' => $ip_address,
            'mood' => $mood,
            'day' => $day
        ]);

        return response()->json([
            'message' => 'Successfully saved mood'
        ], 200);
    }

    public function getMoodCount(Request $request){
        $day = $request->get('day');
        $ip_address = base64_decode($request->get('ip_address'));
        $moods = [
            'wow',
            'happy',
            'pleading',
            'pray',
            'heart'
        ];

        $mood = MoodBoardModel::select(\DB::raw('count(mood) as value, mood as name'))
        ->where('day', $day)
        ->groupBy('name')
        ->get()
        ->toArray();
        $mood_total_count = MoodBoardModel::where('day', $day)->count();
        $selected_mood = MoodBoardModel::select('mood')->where('day', $day)->where('ip_address', $ip_address)->first() ?? '';
        
        foreach($moods as $m){
            if(!array_filter($mood, fn($item) => $item['name'] == $m)){
                $mood[] = ['value' => 0, 'name' => $m];
            }
        }

        $data = [
            'moods' => $mood,
            'total_count' => $mood_total_count,
            'selected_mood' => $selected_mood->mood ?? '',
        ];
        
        return response()->json($data, 200);
    }
}
