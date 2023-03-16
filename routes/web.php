<?php

use App\Models\Keyword;
use App\Models\User;
use App\Models\UserSearchHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $users = User::all();
    $keywords = Keyword::withCount(['searchHistory'])->get();
    
    return view('welcome', compact('users', 'keywords'));
})->name('home');

Route::get('/search-history', function (Request $request) {

    $userSearchHistory = UserSearchHistory::orderBy('id', 'asc')->with('user', 'keyword');
    if(isset($request->keyword)){
        $userSearchHistory = $userSearchHistory->whereIn('search_keyword_id', $request->keyword);
    }
    if(isset($request->user)){
        $userSearchHistory = $userSearchHistory->whereIn('user_id', $request->user);
    }
    if(isset($request->range)){
        if($request->range === 'yesterday'){
            $yesterday = Carbon::yesterday();
            $userSearchHistory = $userSearchHistory->whereDate('search_time', $yesterday);
        } else if ($request->range === 'last week'){
            $lastWeekStart = Carbon::now()->subWeek();
            $lastWeekEnd = Carbon::now()->subWeek()->endOfWeek();
            $userSearchHistory = $userSearchHistory->whereBetween('search_time', [$lastWeekStart, $lastWeekEnd]);
        } else if ($request->range === 'last month'){
            return $lastMonthStart = Carbon::now()->subMonth();
            $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();
            $userSearchHistory = $userSearchHistory->whereBetween('search_time', [$lastMonthStart, $lastMonthEnd]);
        }
    }
    if(isset($request->date) && $request->date !== null){
        $dates = explode('-', $request->date);
        foreach ($dates as $key => $date) {
            $dates[$key] = (new Carbon(trim($date), 'UTC'))->format('Y-m-d\TH:i:s.v\Z');
        }
        
        $userSearchHistory = $userSearchHistory->whereBetween('search_time', $dates);
    }

    return $userSearchHistory = $userSearchHistory->paginate(10);
})->name('getSearch');



