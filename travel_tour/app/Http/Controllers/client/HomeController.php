<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tour;
use App\Models\Booking;
use App\Models\TourCategory;
class HomeController extends Controller
{

    /* =============================
       Trang chủ
    ============================== */
    public function index()
    {
    $categories = TourCategory::all();
        // tour mới nhất
        $latestTours = Tour::with(['category','images'])
            ->latest()
            ->take(6)
            ->get();

        // tour nổi bật (booking nhiều nhất)
        $featuredTours = Tour::with(['category','images'])
            ->withCount('bookings')
            ->orderBy('bookings_count','desc')
            ->take(6)
            ->get();

        // tour giá thấp
        $cheapTours = Tour::with(['category','images'])
            ->orderBy('price','asc')
            ->take(6)
            ->get();

        // tour hot (xem nhiều)
        $hotTours = Tour::with(['category','images'])
            ->orderBy('views','desc')
            ->take(6)
            ->get();

        return view('clients.home',compact(
            'latestTours',
            'featuredTours',
            'cheapTours',
            'hotTours',
            'categories'
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

        // tăng lượt xem
        $tour->increment('views');

        $relatedTours = Tour::where('category_id',$tour->category_id)
            ->where('id','!=',$tour->id)
            ->where('status','active')
            ->take(4)
            ->get();

        return view('clients.tours.show', compact('tour','relatedTours'));
    }


    /* =============================
       Trang tour nổi bật
    ============================== */
    public function featured()
    {
        $tours = Tour::with(['category','images'])
            ->withCount('bookings')
            ->orderBy('bookings_count','desc')
            ->paginate(9);

        return view('clients.tours.list',[
            'title' => 'Tour nổi bật',
            'tours' => $tours
        ]);
    }


    /* =============================
       Trang tour mới
    ============================== */
    public function latest()
    {
        $tours = Tour::with(['category','images'])
            ->latest()
            ->paginate(9);

        return view('clients.tours.list',[
            'title' => 'Tour mới nhất',
            'tours' => $tours
        ]);
    }


    /* =============================
       Trang tour giá rẻ
    ============================== */
    public function cheap()
    {
        $tours = Tour::with(['category','images'])
            ->orderBy('price','asc')
            ->paginate(9);

        return view('clients.tours.list',[
            'title' => 'Tour giá rẻ',
            'tours' => $tours
        ]);
    }


    /* =============================
       Trang tour hot
    ============================== */
    public function hot()
    {
        $tours = Tour::with(['category','images'])
            ->orderBy('views','desc')
            ->paginate(9);

        return view('clients.tours.list',[
            'title' => 'Tour hot',
            'tours' => $tours
        ]);
    }
    //trang dịch vụ
    public function service(){
        $categories = TourCategory::all();
        // tour mới nhất
        $latestTours = Tour::with(['category','images'])
            ->latest()
            ->take(6)
            ->get();

        // tour nổi bật (booking nhiều nhất)
        $featuredTours = Tour::with(['category','images'])
            ->withCount('bookings')
            ->orderBy('bookings_count','desc')
            ->take(6)
            ->get();

        // tour giá thấp
        $cheapTours = Tour::with(['category','images'])
            ->orderBy('price','asc')
            ->take(6)
            ->get();

        // tour hot (xem nhiều)
        $hotTours = Tour::with(['category','images'])
            ->orderBy('views','desc')
            ->take(6)
            ->get();
        return view('clients.service',compact(
            'latestTours',
            'featuredTours',
            'cheapTours',
            'hotTours',
            'categories'));
    }
    // trang liên hệ
    public function contact(){
        $categories = TourCategory::all();
        // tour mới nhất
        $latestTours = Tour::with(['category','images'])
            ->latest()
            ->take(6)
            ->get();

        // tour nổi bật (booking nhiều nhất)
        $featuredTours = Tour::with(['category','images'])
            ->withCount('bookings')
            ->orderBy('bookings_count','desc')
            ->take(6)
            ->get();

        // tour giá thấp
        $cheapTours = Tour::with(['category','images'])
            ->orderBy('price','asc')
            ->take(6)
            ->get();

        // tour hot (xem nhiều)
        $hotTours = Tour::with(['category','images'])
            ->orderBy('views','desc')
            ->take(6)
            ->get();
        return view('clients.contact',compact(
            'latestTours',
            'featuredTours',
            'cheapTours',
            'hotTours',
            'categories'));
    }
    //trang about
    public function about(){
        $categories = TourCategory::all();
        // tour mới nhất
        $latestTours = Tour::with(['category','images'])
            ->latest()
            ->take(6)
            ->get();

        // tour nổi bật (booking nhiều nhất)
        $featuredTours = Tour::with(['category','images'])
            ->withCount('bookings')
            ->orderBy('bookings_count','desc')
            ->take(6)
            ->get();

        // tour giá thấp
        $cheapTours = Tour::with(['category','images'])
            ->orderBy('price','asc')
            ->take(6)
            ->get();

        // tour hot (xem nhiều)
        $hotTours = Tour::with(['category','images'])
            ->orderBy('views','desc')
            ->take(6)
            ->get();
        return view('clients.about',compact(
            'latestTours',
            'featuredTours',
            'cheapTours',
            'hotTours',
            'categories'));
    }
    //destinations
    public function destinations(){
        $categories = TourCategory::all();
        // tour mới nhất
        $latestTours = Tour::with(['category','images'])
            ->latest()
            ->take(6)
            ->get();

        // tour nổi bật (booking nhiều nhất)
        $featuredTours = Tour::with(['category','images'])
            ->withCount('bookings')
            ->orderBy('bookings_count','desc')
            ->take(6)
            ->get();

        // tour giá thấp
        $cheapTours = Tour::with(['category','images'])
            ->orderBy('price','asc')
            ->take(6)
            ->get();

        // tour hot (xem nhiều)
        $hotTours = Tour::with(['category','images'])
            ->orderBy('views','desc')
            ->take(6)
            ->get();
        return view('clients.destinations',compact(
            'latestTours',
            'featuredTours',
            'cheapTours',
            'hotTours',
            'categories'));
    }
// tìm kiếm tour
   public function search(Request $request)
{

$query = Tour::with(['category','images','trips']);


// tìm theo tên
if($request->keyword){

$query->where('name','like','%'.$request->keyword.'%');

}


// tìm theo danh mục
if($request->category_id){

$query->where('category_id',$request->category_id);

}


// tìm theo ngày khởi hành
if($request->departure_date){

$query->whereHas('trips',function($q) use ($request){

$q->whereDate('start_date',$request->departure_date);

});

}


// lấy kết quả
$tours = $query->paginate(9);

return view('clients.search',compact('tours'));

}
}