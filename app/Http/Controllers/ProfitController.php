<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Profile;
use App\Models\Profit;
use App\Models\Read;
use Illuminate\Http\Request;

class ProfitController extends Controller
{
    const SECONDS_IN_WEEK = 60 * 60 * 24 * 7;

    public function index(Request $request)
    {
        return response()->json(Profit::query()
            ->where('profile_id', '=', $request->input('profile_id'))
            ->first());
    }

    public static function update(Request $request)
    {
        $profit = Profit::query()
            ->where('profile_id', '=', $request->input('profile_id'))
            ->first();

        if (!$profit) {
            $profit = new Profit();
        }

        $readBooks = Book::all()
            ->where('profile_id', '=', $request->input('profile_id'))
            ->where('is_read', '=', true);

        $profile = Profile::query()
            ->where('id', '=', $request->input('profile_id'))
            ->first();
        $weeks = ceil(($profile->timestamp_end - $profile->timestamp_start) / self::SECONDS_IN_WEEK);

        $profit->profile_id     = $profile->id;
        $profit->pages_per_day  = Read::query()->where('profile_id', '=', $request->input('profile_id'))->average('pages');
        $profit->books_per_week = ceil(count($readBooks) / $weeks);
        $profit->pages_still    = $profile->need_pages - $profit->pages_per_day;
        $profit->books_still    = $profile->need_books - count($readBooks);

        $profit->save();
    }
}
