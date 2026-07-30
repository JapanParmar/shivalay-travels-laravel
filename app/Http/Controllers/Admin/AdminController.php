<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TravelService;
use App\Models\Booking;
use App\Models\Inquiry;
use App\Models\City;
use App\Models\Setting;
use App\Models\AdminUser;
use App\Models\Package;
use App\Models\Guide;
use App\Models\Hotel;
use App\Models\Villa;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $travelService;

    public function __construct(TravelService $travelService)
    {
        $this->travelService = $travelService;
    }

    public function dashboard()
    {
        return view('admin.dashboard', [
            'bookings' => $this->travelService->getBookings(),
            'inquiries' => $this->travelService->getInquiries(),
        ]);
    }

    public function bookings()
    {
        $role = session('admin_role', 'viewer');
        $canManage = in_array($role, ['super_admin', 'manager', 'agent']);
        $canDelete = in_array($role, ['super_admin', 'manager']);
        return view('admin.bookings', [
            'bookings' => $this->travelService->getBookings(),
            'canManage' => $canManage,
            'canDelete' => $canDelete,
        ]);
    }

    public function storeBooking(Request $request)
    {
        $count = Booking::count();
        $newId = 'SHV-' . str_pad(strval($count + 1), 3, '0', STR_PAD_LEFT);
        while (Booking::where('id', $newId)->exists()) {
            $count++;
            $newId = 'SHV-' . str_pad(strval($count + 1), 3, '0', STR_PAD_LEFT);
        }

        Booking::create([
            'id' => $newId,
            'customerName' => $request->input('customerName'),
            'customerPhone' => $request->input('customerPhone'),
            'customerEmail' => $request->input('customerEmail'),
            'fromCity' => $request->input('fromCity'),
            'toCity' => $request->input('toCity'),
            'travelType' => $request->input('travelType', 'bus'),
            'date' => $request->input('date'),
            'passengers' => intval($request->input('passengers', 1)),
            'classType' => $request->input('classType', 'Economy'),
            'status' => 'pending',
            'amount' => floatval($request->input('amount')),
        ]);

        $this->travelService->syncToFallback();

        return redirect('/admin/bookings')->with('success', 'Booking created successfully!');
    }

    public function updateBooking(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update([
            'customerName' => $request->input('customerName'),
            'customerPhone' => $request->input('customerPhone'),
            'customerEmail' => $request->input('customerEmail'),
            'fromCity' => $request->input('fromCity'),
            'toCity' => $request->input('toCity'),
            'travelType' => $request->input('travelType', 'bus'),
            'date' => $request->input('date'),
            'passengers' => intval($request->input('passengers', 1)),
            'classType' => $request->input('classType', 'Economy'),
            'amount' => floatval($request->input('amount')),
            'status' => $request->input('status'),
            'notes' => $request->input('notes', ''),
        ]);

        $this->travelService->syncToFallback();

        return redirect('/admin/bookings')->with('success', 'Booking updated successfully!');
    }

    public function updateBookingStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update([
            'status' => $request->input('status')
        ]);

        $this->travelService->syncToFallback();

        return redirect('/admin/bookings')->with('success', 'Booking status updated successfully!');
    }

    public function deleteBooking($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        $this->travelService->syncToFallback();

        return redirect('/admin/bookings')->with('success', 'Booking deleted successfully!');
    }

    public function inquiries()
    {
        $role = session('admin_role', 'viewer');
        $canManage = in_array($role, ['super_admin', 'manager', 'agent']);
        $canDelete = in_array($role, ['super_admin', 'manager']);
        return view('admin.inquiries', [
            'inquiries' => $this->travelService->getInquiries(),
            'canManage' => $canManage,
            'canDelete' => $canDelete,
        ]);
    }

    public function deleteInquiry($id)
    {
        $inquiry = Inquiry::findOrFail($id);
        $inquiry->delete();

        $this->travelService->syncToFallback();

        return redirect('/admin/inquiries')->with('success', 'Inquiry deleted successfully!');
    }

    public function updateInquiry(Request $request, $id)
    {
        $inquiry = Inquiry::findOrFail($id);
        $inquiry->update([
            'customerName' => $request->input('customerName'),
            'customerPhone' => $request->input('customerPhone'),
            'customerEmail' => $request->input('customerEmail'),
            'destinations' => $request->input('destinations'),
            'duration' => $request->input('duration'),
            'travelers' => intval($request->input('travelers', 1)),
            'budget' => $request->input('budget'),
            'accommodation' => $request->input('accommodation'),
            'status' => $request->input('status', 'pending'),
            'notes' => $request->input('notes', ''),
        ]);

        $this->travelService->syncToFallback();

        return redirect('/admin/inquiries')->with('success', 'Inquiry updated successfully!');
    }

    public function apiGetInquiries()
    {
        return response()->json($this->travelService->getInquiries());
    }

    public function apiUpdateInquiry(Request $request, $id)
    {
        $inquiry = Inquiry::findOrFail($id);
        $inquiry->update([
            'customerName' => $request->input('customerName'),
            'customerPhone' => $request->input('customerPhone'),
            'customerEmail' => $request->input('customerEmail'),
            'destinations' => $request->input('destinations'),
            'duration' => $request->input('duration'),
            'travelers' => intval($request->input('travelers', 1)),
            'budget' => $request->input('budget'),
            'accommodation' => $request->input('accommodation'),
            'status' => $request->input('status', 'pending'),
            'notes' => $request->input('notes', ''),
        ]);

        $this->travelService->syncToFallback();

        return response()->json($inquiry);
    }

    public function apiDeleteInquiry($id)
    {
        $inquiry = Inquiry::findOrFail($id);
        $inquiry->delete();

        $this->travelService->syncToFallback();

        return response()->json(['success' => true]);
    }

    public function settings()
    {
        return view('admin.settings', [
            'settings' => $this->travelService->getSettings(),
        ]);
    }

    public function updateSettings(Request $request)
    {
        $keys = [
            'businessName', 'gstNumber', 'phone', 'whatsapp', 'email', 'address',
            'defaultPassengers', 'defaultClass', 'currency', 'timezone',
            'bookingNotifications', 'whatsappIntegration', 'autoConfirm', 'requirePhone', 'cityApi',
            'staff1_name', 'staff1_phone', 'staff1_email',
            'staff2_name', 'staff2_phone', 'staff2_email'
        ];

        foreach ($keys as $key) {
            $val = $request->input($key);
            if (in_array($key, ['bookingNotifications', 'whatsappIntegration', 'autoConfirm', 'requirePhone'])) {
                $val = ($val === '1' || $val === 'true') ? 'true' : 'false';
            }
            Setting::updateOrCreate(['key' => $key], ['value' => $val]);
        }

        $this->travelService->syncToFallback();

        return redirect('/admin/settings')->with('success', 'Configuration settings updated successfully!');
    }

    public function apiGetSettings()
    {
        return response()->json($this->travelService->getSettings());
    }

    public function apiUpdateSettings(Request $request)
    {
        foreach ($request->all() as $key => $value) {
            $val = is_scalar($value) ? $value : json_encode($value);
            Setting::updateOrCreate(['key' => $key], ['value' => $val]);
        }

        $this->travelService->syncToFallback();

        return response()->json($this->travelService->getSettings());
    }

    public function cities()
    {
        $role = session('admin_role', 'viewer');
        if ($role !== 'super_admin' && $role !== 'manager') { return abort(403, 'Access Restricted'); }

        return view('admin.cities', [
            'cities' => City::all()->toArray(),
        ]);
    }

    public function storeCity(Request $request)
    {
        $role = session('admin_role', 'viewer');
        if ($role !== 'super_admin' && $role !== 'manager') { return abort(403, 'Access Restricted'); }

        City::create([
            'name' => $request->input('name'),
            'code' => strtoupper($request->input('code')),
            'state' => $request->input('state', ''),
            'country' => 'India',
            'type' => $request->input('type', 'airport'),
            'isPopular' => $request->has('isPopular'),
        ]);

        $this->travelService->syncToFallback();

        return redirect('/admin/cities')->with('success', 'City airport route added successfully!');
    }

    public function toggleCityPopular($id)
    {
        $role = session('admin_role', 'viewer');
        if ($role !== 'super_admin' && $role !== 'manager') { return abort(403, 'Access Restricted'); }

        $city = City::findOrFail($id);
        $city->update([
            'isPopular' => !$city->isPopular
        ]);

        $this->travelService->syncToFallback();

        return redirect('/admin/cities')->with('success', 'City popularity status toggled!');
    }

    public function deleteCity($id)
    {
        $role = session('admin_role', 'viewer');
        if ($role !== 'super_admin') { return abort(403, 'Access Restricted'); }

        $city = City::findOrFail($id);
        $city->delete();

        $this->travelService->syncToFallback();

        return redirect('/admin/cities')->with('success', 'City airport route deleted successfully!');
    }

    public function users()
    {
        $role = session('admin_role', 'viewer');
        if ($role !== 'super_admin') { return abort(403, 'Access Restricted'); }

        return view('admin.users', [
            'users' => AdminUser::all()->toArray(),
        ]);
    }

    public function storeUser(Request $request)
    {
        $role = session('admin_role', 'viewer');
        if ($role !== 'super_admin') { return abort(403, 'Access Restricted'); }

        $name = $request->input('name');
        $parts = explode(' ', $name);
        $avatar = strtoupper(substr($parts[0] ?? 'A', 0, 1) . substr($parts[1] ?? ($parts[0] ?? 'A'), 0, 1));

        $count = AdminUser::count();
        $newId = 'usr-' . str_pad(strval($count + 1), 2, '0', STR_PAD_LEFT);
        while (AdminUser::where('id', $newId)->exists()) {
            $count++;
            $newId = 'usr-' . str_pad(strval($count + 1), 2, '0', STR_PAD_LEFT);
        }

        AdminUser::create([
            'id' => $newId,
            'name' => $name,
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'role' => $request->input('role', 'agent'),
            'avatar' => $avatar,
            'status' => 'active',
        ]);

        $this->travelService->syncToFallback();

        return redirect('/admin/users')->with('success', 'User account created successfully!');
    }

    public function updateUserRole(Request $request, $id)
    {
        $role = session('admin_role', 'viewer');
        if ($role !== 'super_admin') { return abort(403, 'Access Restricted'); }
        if (session('admin_id') === $id) { return abort(400, 'Cannot change your own role.'); }

        $user = AdminUser::findOrFail($id);
        $user->update([
            'role' => $request->input('role')
        ]);

        $this->travelService->syncToFallback();

        return redirect('/admin/users')->with('success', 'User role updated successfully!');
    }

    public function toggleUserStatus($id)
    {
        $role = session('admin_role', 'viewer');
        if ($role !== 'super_admin') { return abort(403, 'Access Restricted'); }
        if (session('admin_id') === $id) { return abort(400, 'Cannot toggle your own status.'); }

        $user = AdminUser::findOrFail($id);
        $user->update([
            'status' => $user->status === 'active' ? 'inactive' : 'active'
        ]);

        $this->travelService->syncToFallback();

        return redirect('/admin/users')->with('success', 'User status updated successfully!');
    }

    public function deleteUser($id)
    {
        $role = session('admin_role', 'viewer');
        if ($role !== 'super_admin') { return abort(403, 'Access Restricted'); }
        if (session('admin_id') === $id) { return abort(400, 'Cannot remove yourself.'); }

        $user = AdminUser::findOrFail($id);
        $user->delete();

        $this->travelService->syncToFallback();

        return redirect('/admin/users')->with('success', 'User account deleted successfully!');
    }

    public function analytics()
    {
        $role = session('admin_role', 'viewer');
        if ($role === 'agent') { return abort(403, 'Access Restricted'); }

        return view('admin.analytics', [
            'bookings' => Booking::all()->toArray(),
            'inquiries' => Inquiry::all()->toArray(),
        ]);
    }

    public function destinations()
    {
        $email = session('admin_email', '');
        if ($email !== 'dev@shivalay.in') { return redirect('/admin/dashboard'); }

        return view('admin.destinations', [
            'packages' => Package::all()->toArray(),
        ]);
    }

    public function storeDestination(Request $request)
    {
        $email = session('admin_email', '');
        if ($email !== 'dev@shivalay.in') { return redirect('/admin/dashboard'); }

        $editingId = $request->input('editing_id');
        $tags = array_filter(array_map('trim', explode(',', $request->input('tags', ''))));
        $highlights = array_filter(array_map('trim', explode("\n", $request->input('highlights', ''))));
        $includes = array_filter(array_map('trim', explode("\n", $request->input('includes', ''))));

        $packageData = [
            'name' => $request->input('name'),
            'region' => $request->input('region'),
            'tagline' => $request->input('tagline', ''),
            'duration' => $request->input('duration', ''),
            'groupSize' => $request->input('groupSize', '2-12'),
            'difficulty' => $request->input('difficulty', 'Easy'),
            'bestSeason' => $request->input('bestSeason', ''),
            'startingFrom' => $request->input('startingFrom', '₹15,000'),
            'tags' => array_values($tags),
            'highlights' => array_values($highlights),
            'includes' => array_values($includes),
            'imagePath' => $request->input('imagePath', '/images/kedarnath.png'),
        ];

        if ($editingId) {
            $package = Package::findOrFail($editingId);
            $package->update($packageData);
        } else {
            $packageData['id'] = strtolower(str_replace(' ', '-', $request->input('name')));
            Package::create($packageData);
        }

        $this->travelService->syncToFallback();

        return redirect('/admin/destinations')->with('success', 'Destination package saved successfully!');
    }

    public function deleteDestination($id)
    {
        $email = session('admin_email', '');
        if ($email !== 'dev@shivalay.in') { return redirect('/admin/dashboard'); }

        $package = Package::findOrFail($id);
        $package->delete();

        $this->travelService->syncToFallback();

        return redirect('/admin/destinations')->with('success', 'Destination package deleted successfully!');
    }

    public function guides()
    {
        $email = session('admin_email', '');
        if ($email !== 'dev@shivalay.in') { return redirect('/admin/dashboard'); }

        return view('admin.guides', [
            'guides' => Guide::all()->toArray(),
        ]);
    }

    public function storeGuide(Request $request)
    {
        $email = session('admin_email', '');
        if ($email !== 'dev@shivalay.in') { return redirect('/admin/dashboard'); }

        $editingId = $request->input('editing_id');
        $guideData = [
            'category' => $request->input('category'),
            'title' => $request->input('title'),
            'readTime' => $request->input('readTime', '5 min read'),
            'badge' => $request->input('badge'),
            'image' => $request->input('image', '/images/ladakh.png'),
            'icon' => $request->input('icon', '🏔️'),
        ];

        if ($editingId) {
            $guide = Guide::findOrFail($editingId);
            $guide->update($guideData);
        } else {
            Guide::create($guideData);
        }

        $this->travelService->syncToFallback();

        return redirect('/admin/guides')->with('success', 'Travel guide saved successfully!');
    }

    public function deleteGuide($id)
    {
        $email = session('admin_email', '');
        if ($email !== 'dev@shivalay.in') { return redirect('/admin/dashboard'); }

        $guide = Guide::findOrFail($id);
        $guide->delete();

        $this->travelService->syncToFallback();

        return redirect('/admin/guides')->with('success', 'Travel guide deleted successfully!');
    }

    public function hotels()
    {
        $role = session('admin_role', 'viewer');
        if ($role !== 'super_admin' && $role !== 'manager') { return abort(403, 'Access Restricted'); }

        return view('admin.hotels', [
            'hotels' => Hotel::all()->toArray(),
        ]);
    }

    public function storeHotel(Request $request)
    {
        $role = session('admin_role', 'viewer');
        if ($role !== 'super_admin' && $role !== 'manager') { return abort(403, 'Access Restricted'); }

        $request->validate([
            'name' => 'required|string|min:3|max:150',
            'location' => 'required|string|min:3|max:150',
            'price' => 'required|string',
            'rating' => 'required|numeric|min:1|max:5',
            'imagePath' => 'required|string',
            'description' => 'required|string|min:10',
        ]);

        $editingId = $request->input('editing_id');
        $amenitiesStr = $request->input('amenities', '');
        $amenities = array_filter(array_map('trim', explode(',', $amenitiesStr)));
        if (empty($amenities)) {
            $amenities = array_filter(array_map('trim', explode("\n", $amenitiesStr)));
        }

        $galleryStr = $request->input('gallery', '');
        $gallery = array_filter(array_map('trim', explode(',', $galleryStr)));

        $hotelData = [
            'name' => $request->input('name'),
            'location' => $request->input('location'),
            'description' => $request->input('description', ''),
            'price' => $request->input('price'),
            'rating' => $request->input('rating', '5.0'),
            'imagePath' => $request->input('imagePath', '/images/hotel1.png'),
            'amenities' => array_values($amenities),
            'gallery' => array_values($gallery),
        ];

        if ($editingId) {
            $hotel = Hotel::findOrFail($editingId);
            $hotel->update($hotelData);
        } else {
            $hotelData['id'] = 'hotel-' . time();
            Hotel::create($hotelData);
        }

        $this->travelService->syncToFallback();

        return redirect('/admin/hotels')->with('success', 'Hotel saved successfully!');
    }

    public function deleteHotel($id)
    {
        $role = session('admin_role', 'viewer');
        if ($role !== 'super_admin' && $role !== 'manager') { return abort(403, 'Access Restricted'); }

        $hotel = Hotel::findOrFail($id);
        $hotel->delete();

        $this->travelService->syncToFallback();

        return redirect('/admin/hotels')->with('success', 'Hotel deleted successfully!');
    }

    public function villas()
    {
        $role = session('admin_role', 'viewer');
        if ($role !== 'super_admin' && $role !== 'manager') { return abort(403, 'Access Restricted'); }

        return view('admin.villas', [
            'villas' => Villa::all()->toArray(),
        ]);
    }

    public function storeVilla(Request $request)
    {
        $role = session('admin_role', 'viewer');
        if ($role !== 'super_admin' && $role !== 'manager') { return abort(403, 'Access Restricted'); }

        $request->validate([
            'name' => 'required|string|min:3|max:150',
            'location' => 'required|string|min:3|max:150',
            'price' => 'required|string',
            'rating' => 'required|numeric|min:1|max:5',
            'imagePath' => 'required|string',
            'description' => 'required|string|min:10',
        ]);

        $editingId = $request->input('editing_id');
        $amenitiesStr = $request->input('amenities', '');
        $amenities = array_filter(array_map('trim', explode(',', $amenitiesStr)));
        if (empty($amenities)) {
            $amenities = array_filter(array_map('trim', explode("\n", $amenitiesStr)));
        }

        $galleryStr = $request->input('gallery', '');
        $gallery = array_filter(array_map('trim', explode(',', $galleryStr)));

        $villaData = [
            'name' => $request->input('name'),
            'location' => $request->input('location'),
            'description' => $request->input('description', ''),
            'price' => $request->input('price'),
            'rating' => $request->input('rating', '5.0'),
            'imagePath' => $request->input('imagePath', '/images/villa1.png'),
            'amenities' => array_values($amenities),
            'gallery' => array_values($gallery),
        ];

        if ($editingId) {
            $villa = Villa::findOrFail($editingId);
            $villa->update($villaData);
        } else {
            $villaData['id'] = 'villa-' . time();
            Villa::create($villaData);
        }

        $this->travelService->syncToFallback();

        return redirect('/admin/villas')->with('success', 'Villa saved successfully!');
    }

    public function deleteVilla($id)
    {
        $role = session('admin_role', 'viewer');
        if ($role !== 'super_admin' && $role !== 'manager') { return abort(403, 'Access Restricted'); }

        $villa = Villa::findOrFail($id);
        $villa->delete();

        $this->travelService->syncToFallback();

        return redirect('/admin/villas')->with('success', 'Villa deleted successfully!');
    }

    public function uploadImage(Request $request)
    {
        if (!session()->has('admin_authenticated')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        if (!$request->hasFile('image')) {
            return response()->json(['error' => 'No image file uploaded'], 400);
        }

        $file = $request->file('image');
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'];
        $ext = strtolower($file->getClientOriginalExtension());
        if (!in_array($ext, $allowed)) {
            return response()->json(['error' => 'Invalid file extension. Only JPG, PNG, GIF, SVG, and WEBP are allowed.'], 400);
        }

        $maxSize = 4 * 1024 * 1024; // 4MB
        if ($file->getSize() > $maxSize) {
            return response()->json(['error' => 'File size exceeds maximum limit of 4MB.'], 400);
        }

        $filename = time() . '_' . uniqid() . '.' . $ext;
        if (!file_exists(public_path('uploads'))) {
            mkdir(public_path('uploads'), 0777, true);
        }
        $file->move(public_path('uploads'), $filename);

        return response()->json(['url' => '/uploads/' . $filename]);
    }

    public function apiGetBookings()
    {
        return response()->json($this->travelService->getBookings());
    }
}
