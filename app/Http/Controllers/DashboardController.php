<?php

namespace App\Http\Controllers;

use App\Models\CheckIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
    public function search(Request $request)
    {
        try {
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');
    
        
            if (!$startDate) {
                $startDate = now()->subMonths(3)->format('Y-m-d');
            }
    
           
            if (!$endDate) {
                $endDate = now()->format('Y-m-d');
            }
    
            $target = $request->input('targetSelect');
            $age = $request->input('ageSelect');
            $type = $request->input('type');
            $query = Checkin::query();
            $query->join('members', 'check_ins.member_id', '=', 'members.id');
            $query->whereDate('check_in_date', '>=', $startDate)
                ->whereDate('check_in_date', '<=', $endDate);
    
            if ($age == 'under18') {
                $under18Dob = now()->subYears(18)->toDateString();
                $query->where('members.dob', '>', $under18Dob);
            } elseif ($age == 'above18') {
                $above18Dob = now()->subYears(18)->subDay()->toDateString();
                $query->where('members.dob', '<=', $above18Dob);
            }
            if ($type == 'day') {
                $groupBy = 'DATE_FORMAT(check_ins.check_in_date, "%Y-%m-%d")';
            } elseif ($type == 'month') {
                $groupBy = 'DATE_FORMAT(check_ins.check_in_date, "%Y-%m")';
            }
            if ($target == 'member') {
                $results = $query->groupBy(DB::raw($groupBy))
                    ->select(
                        DB::raw("$groupBy as date"),
                        DB::raw('SUM(CASE WHEN is_gues = 0 THEN 1 ELSE 0 END) as members_count')
                    )
                    ->get();
            } elseif ($target == 'non-member') {
                $results = $query->groupBy(DB::raw($groupBy))
                    ->select(
                        DB::raw("$groupBy as date"),
                        DB::raw('SUM(CASE WHEN is_gues = 1 THEN 1 ELSE 0 END) as guests_count')
                    )
                    ->get();
            } else {
                $results = $query->groupBy(DB::raw($groupBy))
                    ->select(
                        DB::raw("$groupBy as date"),
                        DB::raw('SUM(CASE WHEN is_gues = 1 THEN 1 ELSE 0 END) as guests_count'),
                        DB::raw('SUM(CASE WHEN is_gues = 0 THEN 1 ELSE 0 END) as members_count')
                    )
                    ->get();
            }
            return response()->json($results);
         
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function searchIndex()
    {
        try {
            $startDate = now()->subMonths(3)->toDateString();
            $endDate = now()->toDateString();
            $query = Checkin::query();
            $query->join('members', 'check_ins.member_id', '=', 'members.id');
            $query->whereDate('check_in_date', '>=', $startDate)
                  ->whereDate('check_in_date', '<=', $endDate);
            $groupBy = 'DATE_FORMAT(check_ins.check_in_date, "%Y-%m")';
            $results = $query->groupBy(DB::raw($groupBy))
                      ->select(
                          DB::raw("$groupBy as date"),
                          DB::raw('SUM(CASE WHEN is_gues = 1 THEN 1 ELSE 0 END) as guests_count'),
                          DB::raw('SUM(CASE WHEN is_gues = 0 THEN 1 ELSE 0 END) as members_count')
                      )
                      ->get();
    
            return response()->json($results);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
