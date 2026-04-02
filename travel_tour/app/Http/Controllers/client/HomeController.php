<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tour;
use App\Models\TourCategory;

class HomeController extends Controller
{
    /* =============================
       Trang chủ (CHỈ TOUR NỔI BẬT)
    ============================== */
    public function index()
    {
        $categories = TourCategory::all();

        $featuredTours = Tour::with(['category','images','trips'])
            ->withCount('bookings')
            ->orderBy('bookings_count','desc')
            ->paginate(9);

        return view('clients.home', compact(
            'featuredTours',
            'categories'
        ));
    }

    /* =============================
       Trang GIỚI THIỆU
    ============================== */
    public function about()
    {
        return view('clients.about');
    }

    /* =============================
       Trang LIÊN HỆ
    ============================== */
    public function contact()
    {
        return view('clients.contact');
    }

    /* =============================
       Trang DỊCH VỤ
    ============================== */
    public function service()
    {
        return view('clients.service');
    }

    /* =============================
       Trang ĐIỂM ĐẾN
    ============================== */
    public function destinations()
    {
        $categories = TourCategory::all();

        // TOUR NỔI BẬT (nhiều booking)
        $featuredTours = Tour::with(['category','images','trips'])
            ->withCount('bookings')
            ->orderBy('bookings_count','desc')
            ->take(6)
            ->get();

        // TOUR MỚI
        $latestTours = Tour::with(['category','images','trips'])
            ->latest()
            ->take(6)
            ->get();

        // TOUR GIÁ RẺ
        $cheapTours = Tour::with(['category','images','trips'])
            ->orderBy('price','asc')
            ->take(6)
            ->get();

        // TOUR HOT (nhiều view)
        $hotTours = Tour::with(['category','images','trips'])
            ->orderBy('views','desc')
            ->take(6)
            ->get();

        return view('clients.destinations', compact(
            'categories',
            'featuredTours',
            'latestTours',
            'cheapTours',
            'hotTours'
        ));
    }

    /* =============================
       Chi tiết tour
    ============================== */
    public function show($slug)
    {
        $tour = Tour::with([
            'category',
            'images',
            'itineraries',
            'trips',
            'reviews.user'
        ])->where('slug',$slug)->firstOrFail();

        $tour->increment('views');

        $relatedTours = Tour::where('category_id',$tour->category_id)
            ->where('id','!=',$tour->id)
            ->where('status',1)
            ->take(4)
            ->get();

        return view('clients.tours.show', compact('tour','relatedTours'));
    }

    /* =============================
       SEARCH TOUR
    ============================== */
    public function search(Request $request)
    {
        $query = Tour::with(['category','images','trips']);

        if ($request->keyword) {
            $query->where('name','like','%'.$request->keyword.'%');
        }

        if ($request->departure_location) {
            $query->where('departure_location','like','%'.$request->departure_location.'%');
        }

        if ($request->destination) {
            $query->where('destination','like','%'.$request->destination.'%');
        }

        if ($request->category_id) {
            $query->where('category_id',$request->category_id);
        }

        if ($request->start_date) {
            $query->whereHas('trips', function($q) use ($request){
                $q->whereDate('start_date','>=',$request->start_date);
            });
        }

        if ($request->end_date) {
            $query->whereHas('trips', function($q) use ($request){
                $q->whereDate('end_date','<=',$request->end_date);
            });
        }

        if ($request->price) {
            switch ($request->price) {
                case 1:
                    $query->where('price','<',5000000);
                    break;
                case 2:
                    $query->whereBetween('price',[5000000,10000000]);
                    break;
                case 3:
                    $query->whereBetween('price',[10000000,20000000]);
                    break;
                case 4:
                    $query->where('price','>',20000000);
                    break;
            }
        }

        $tours = $query
            ->withCount('bookings')
            ->orderBy('bookings_count','desc')
            ->paginate(9);

        $tours->appends($request->all());

        $categories = TourCategory::all();

        return view('clients.search', compact('tours','categories'));
    }

    
}