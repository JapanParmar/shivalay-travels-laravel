<?php

namespace App\Http\Controllers;

use App\Services\TravelService;
use App\Models\Inquiry;
use App\Models\Booking;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $travelService;

    public function __construct(TravelService $travelService)
    {
        $this->travelService = $travelService;
    }

    public function index()
    {
        $settings = $this->travelService->getSettings();
        return view('welcome', [
            'packages' => $this->travelService->getPackages(),
            'guides' => $this->travelService->getGuides(),
            'cities' => $this->travelService->getCities(),
            'hotels' => $this->travelService->getHotels(),
            'villas' => $this->travelService->getVillas(),
            'testimonials' => $this->travelService->getTestimonials(),
            'settings' => $settings,
        ]);
    }

    public function getCaptcha()
    {
        $code = strval(rand(1000, 9999));
        session(['captcha' => $code]);

        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="140" height="44" viewBox="0 0 140 44">';
        $svg .= '<rect width="100%" height="100%" fill="#18181b"/>';
        for ($i = 0; $i < 4; $i++) {
            $svg .= '<line x1="'.rand(0, 140).'" y1="'.rand(0, 44).'" x2="'.rand(0, 140).'" y2="'.rand(0, 44).'" stroke="#3b3b3b" stroke-width="1"/>';
        }
        $svg .= '<text x="50%" y="60%" font-size="22" fill="#ff0000" font-family="monospace" font-weight="bold" text-anchor="middle" letter-spacing="4">'.$code.'</text>';
        $svg .= '</svg>';

        return response()->json([
            'svg' => $svg,
            'token' => session()->getId(),
        ]);
    }

    public function submitInquiry(Request $request)
    {
        // Bypass CAPTCHA only if it is the quick quote popup request
        if (!$request->input('isPopup')) {
            $captchaInput = $request->input('captchaInput');
            if (session('captcha') !== $captchaInput) {
                return response()->json(['error' => 'Invalid CAPTCHA code.'], 422);
            }
        }

        $count = Inquiry::count();
        $newId = 'INQ-' . str_pad(strval($count + 1), 3, '0', STR_PAD_LEFT);
        while (Inquiry::where('id', $newId)->exists()) {
            $count++;
            $newId = 'INQ-' . str_pad(strval($count + 1), 3, '0', STR_PAD_LEFT);
        }

        $inquiry = Inquiry::create([
            'id' => $newId,
            'customerName' => $request->input('customerName'),
            'customerPhone' => $request->input('customerPhone'),
            'customerEmail' => $request->input('customerEmail'),
            'destinations' => $request->input('destinations'),
            'duration' => $request->input('duration'),
            'travelers' => intval($request->input('travelers', 1)),
            'budget' => $request->input('budget'),
            'accommodation' => $request->input('accommodation'),
            'status' => 'pending',
            'notes' => $request->input('notes'),
        ]);

        $this->travelService->syncToFallback();

        return response()->json($inquiry);
    }

    public function submitBooking(Request $request)
    {
        $captchaInput = $request->input('captchaInput');
        if (session('captcha') !== $captchaInput) {
            return response()->json(['error' => 'Invalid CAPTCHA code.'], 422);
        }

        $count = Booking::count();
        $newId = 'SHV-' . str_pad(strval($count + 1), 3, '0', STR_PAD_LEFT);
        while (Booking::where('id', $newId)->exists()) {
            $count++;
            $newId = 'SHV-' . str_pad(strval($count + 1), 3, '0', STR_PAD_LEFT);
        }

        $booking = Booking::create([
            'id' => $newId,
            'customerName' => $request->input('customerName'),
            'customerPhone' => $request->input('customerPhone'),
            'customerEmail' => $request->input('customerEmail'),
            'fromCity' => $request->input('fromCity'),
            'toCity' => $request->input('toCity'),
            'travelType' => $request->input('travelType', 'bus'),
            'date' => $request->input('date'),
            'returnDate' => $request->input('returnDate'),
            'passengers' => intval($request->input('passengers', 1)),
            'classType' => $request->input('classType'),
            'status' => 'pending',
            'amount' => rand(3000, 15000) * intval($request->input('passengers', 1)),
            'notes' => $request->input('notes'),
        ]);

        $this->travelService->syncToFallback();

        return response()->json($booking);
    }
}
