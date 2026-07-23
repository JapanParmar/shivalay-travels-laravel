<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Helper to get database data
function getFallbackDb() {
    $dbPath = base_path('database/db_fallback.json');
    if (!file_exists($dbPath)) {
        // If file doesn't exist, create it with empty skeleton
        file_put_contents($dbPath, json_encode([
            'admin_users' => [
                [
                    'id' => '1',
                    'name' => 'Rajesh Parmar',
                    'email' => 'admin@shivalay.in',
                    'password' => 'admin123',
                    'role' => 'super_admin',
                    'avatar' => 'RP',
                    'status' => 'active'
                ],
                [
                    'id' => '2',
                    'name' => 'Priya Sharma',
                    'email' => 'manager@shivalay.in',
                    'password' => 'manager123',
                    'role' => 'manager',
                    'avatar' => 'PS',
                    'status' => 'active'
                ],
                [
                    'id' => '3',
                    'name' => 'Amit Verma',
                    'email' => 'agent@shivalay.in',
                    'password' => 'agent123',
                    'role' => 'agent',
                    'avatar' => 'AV',
                    'status' => 'active'
                ]
            ],
            'inquiries' => [],
            'bookings' => [],
            'cities' => [],
            'settings' => [
                'businessName' => 'Shivalay Travels',
                'phone' => '+91 93409 94628',
                'email' => 'info@shivalay.in',
                'whatsapp' => '919340994628',
                'address' => 'Indore, Madhya Pradesh, India',
                'gstNumber' => 'GSTIN23AABCS1234F1Z5',
                'currency' => 'INR',
                'timezone' => 'Asia/Kolkata',
                'bookingNotifications' => true,
                'whatsappIntegration' => true,
                'autoConfirm' => false,
                'requirePhone' => true,
                'defaultPassengers' => '1',
                'defaultClass' => 'Economy',
                'cityApi' => 'open_meteo'
            ]
        ], JSON_PRETTY_PRINT));
    }
    $db = json_decode(file_get_contents($dbPath), true);
    
    // Auto-migrate keys if missing
    $changed = false;
    if (!isset($db['packages'])) {
        $db['packages'] = [
            [
                'id' => 'kedarnath',
                'name' => 'Kedarnath Yatra',
                'region' => 'Uttarakhand',
                'tagline' => 'Spiritual temple yatra with divine scenic mountain views',
                'duration' => '4–6 nights',
                'groupSize' => '2–12',
                'difficulty' => 'Challenging',
                'bestSeason' => 'May – Jun, Sep – Nov',
                'startingFrom' => '₹15,000',
                'tags' => ['Spiritual', 'Adventure', 'Scenic'],
                'highlights' => ['VIP Darshan at Kedarnath Temple shrine', 'Beautiful trek from Gaurikund to Kedarnath basecamp', 'Comfortable stays near the holy temple base', 'Scenic helicopter ride booking options'],
                'includes' => ['Premium stays & hygienic food', 'Airport/station pickup & drop', 'Experienced local yatra coordinator', 'Helicopter booking assistance'],
                'imagePath' => '/images/kedarnath.png'
            ],
            [
                'id' => 'chardham',
                'name' => 'Chardham Yatra',
                'region' => 'Uttarakhand',
                'tagline' => 'Holy pilgrimage to Yamunotri, Gangotri, Kedarnath, and Badrinath',
                'duration' => '9–12 nights',
                'groupSize' => '2–20',
                'difficulty' => 'Challenging',
                'bestSeason' => 'May – Jun, Sep – Oct',
                'startingFrom' => '₹45,000',
                'tags' => ['Spiritual', 'Heritage', 'Scenic'],
                'highlights' => ['Complete darshan of all four holy shrines', 'Special puja arrangement at Badrinath temple', 'Scenic drive through majestic Himalayan valleys', 'Holy Ganga aarti at Har Ki Pauri, Haridwar'],
                'includes' => ['Comfortable hotel bookings', 'All transfers via private luxury coach', 'Sanskrit-speaking local guide', 'All yatra registration permits'],
                'imagePath' => '/images/chardham.png'
            ],
            [
                'id' => 'varanasi',
                'name' => 'Varanasi Kashi',
                'region' => 'Uttar Pradesh',
                'tagline' => 'Spiritual river ghats, ancient chants & silk-weaving heritage',
                'duration' => '3–5 nights',
                'groupSize' => '2–8',
                'difficulty' => 'Easy',
                'bestSeason' => 'Oct – Mar',
                'startingFrom' => '₹12,000',
                'tags' => ['Spiritual', 'Heritage', 'Wellness'],
                'highlights' => ['Private boat for Ganga Aarti ceremony at Dashashwamedh', 'Sunrise boat ride with live shehnai music', 'Guided walk through ancient alleyways & Kashi Vishwanath temple', 'Exclusive Banarasi silk weaving demonstration'],
                'includes' => ['Boutique riverfront stays', 'Private spiritual guide', 'VIP temple darshan assistance', 'Private boat charters'],
                'imagePath' => '/images/varanasi.png'
            ],
            [
                'id' => 'kashmir',
                'name' => 'Kashmir Valley',
                'region' => 'North India',
                'tagline' => 'Misty pine valleys, wooden houseboats & peaceful shikaras',
                'duration' => '6–9 nights',
                'groupSize' => '2–12',
                'difficulty' => 'Easy',
                'bestSeason' => 'Mar – Oct',
                'startingFrom' => '₹22,000',
                'tags' => ['Luxury', 'Scenic', 'Wellness'],
                'highlights' => ['Stay in a hand-carved luxury houseboat', 'Dawn shikara ride on Dal Lake', 'Private saffron farm walk in Pampore', 'Gulmarg snow activities & gondola ride'],
                'includes' => ['Premium resort properties', 'Private local chauffeur', 'All gourmet local meals', 'Airport pickup assistance'],
                'imagePath' => '/images/kashmir.png'
            ],
            [
                'id' => 'goa',
                'name' => 'Goa Beaches',
                'region' => 'West Coast',
                'tagline' => 'Secluded beaches, historic churches & vibrant coastal holiday',
                'duration' => '5–8 nights',
                'groupSize' => '2–8',
                'difficulty' => 'Easy',
                'bestSeason' => 'Nov – Apr',
                'startingFrom' => '₹18,000',
                'tags' => ['Luxury', 'Wellness', 'Adventure'],
                'highlights' => ['Private yacht sunset cruise', 'Curated heritage walk through Old Goa churches', 'Water sports and parasailing at Calangute', 'Beachside candlelight dinner'],
                'includes' => ['Luxury beachside hotel stays', 'Airport transfers & pickup', 'Personal travel coordinator', 'Sightseeing passes'],
                'imagePath' => '/images/goa.png'
            ],
            [
                'id' => 'ladakh',
                'name' => 'Leh Ladakh',
                'region' => 'Himalayas',
                'tagline' => 'Snow-capped monasteries, deep valleys & high mountain passes',
                'duration' => '7–10 nights',
                'groupSize' => '2–8',
                'difficulty' => 'Challenging',
                'bestSeason' => 'Jun – Sep',
                'startingFrom' => '₹35,000',
                'tags' => ['Adventure', 'Scenic', 'Heritage'],
                'highlights' => ['Private sunrise at Pangong Tso Lake', 'Guided trek through Hemis National Park', 'VIP access to Thiksey Monastery prayer', 'Double-humped camel ride in Nubra Valley'],
                'includes' => ['Boutique camps & cottages', 'Private 4x4 vehicle & driver', 'Oxygen systems & medical backing', 'Expert local coordinator guide'],
                'imagePath' => '/images/ladakh.png'
            ]
        ];
        $changed = true;
    }
    if (!isset($db['guides'])) {
        $db['guides'] = [
            ['id' => '1', 'category' => 'Packing Guide', 'title' => 'The ultimate cold desert packing checklist for Ladakh — what to carry in June vs September', 'readTime' => '7 min read', 'badge' => 'Popular', 'image' => '/images/ladakh.png', 'icon' => '🏔️'],
            ['id' => '2', 'category' => 'Destination Intel', 'title' => 'Kashmir in winters — Gulmarg ski resorts, wooden chalets, & winter wonderland guide', 'readTime' => '9 min read', 'badge' => 'Insider', 'image' => '/images/kashmir.png', 'icon' => '❄️'],
            ['id' => '3', 'category' => 'Health & Safety', 'title' => 'High altitude acclimatisation 101 — how to prevent Acute Mountain Sickness (AMS) in Leh', 'readTime' => '6 min read', 'badge' => null, 'image' => '/images/ladakh.png', 'icon' => '⛑️'],
            ['id' => '4', 'category' => 'Culture', 'title' => 'Monastery decorum in Ladakh & Spiti — rules, prayer wheel direction, & photography guidelines', 'readTime' => '8 min read', 'badge' => 'New', 'image' => '/images/ladakh.png', 'icon' => '🙏'],
            ['id' => '5', 'category' => 'Destination Intel', 'title' => 'Inner Line Permits decoded — how to secure travel clearance to Pangong Tso, Nubra & Turtuk', 'readTime' => '5 min read', 'badge' => null, 'image' => '/images/meghalaya.png', 'icon' => '📋'],
            ['id' => '6', 'category' => 'Packing Guide', 'title' => 'Monsoon packing list for Meghalaya — trekking boots, waterproof cases, & jungle essentials', 'readTime' => '6 min read', 'badge' => 'Popular', 'image' => '/images/meghalaya.png', 'icon' => '🌿']
        ];
        $changed = true;
    }
    if (!isset($db['cities']) || empty($db['cities'])) {
        $db['cities'] = [
            ['id' => '1', 'name' => 'Indore', 'code' => 'IDR', 'state' => 'Madhya Pradesh', 'country' => 'India', 'type' => 'airport', 'isPopular' => true],
            ['id' => '2', 'name' => 'Mumbai', 'code' => 'BOM', 'state' => 'Maharashtra', 'country' => 'India', 'type' => 'airport', 'isPopular' => true],
            ['id' => '3', 'name' => 'Delhi', 'code' => 'DEL', 'state' => 'Delhi', 'country' => 'India', 'type' => 'airport', 'isPopular' => true],
            ['id' => '4', 'name' => 'Bangalore', 'code' => 'BLR', 'state' => 'Karnataka', 'country' => 'India', 'type' => 'airport', 'isPopular' => true],
            ['id' => '5', 'name' => 'Varanasi', 'code' => 'VNS', 'state' => 'Uttar Pradesh', 'country' => 'India', 'type' => 'airport', 'isPopular' => true],
            ['id' => '6', 'name' => 'Goa', 'code' => 'GOI', 'state' => 'Goa', 'country' => 'India', 'type' => 'airport', 'isPopular' => true],
        ];
        $changed = true;
    }
    
    // Ensure dev user always exists
    $hasDev = false;
    foreach ($db['admin_users'] as $user) {
        if ($user['email'] === 'dev@shivalay.in') {
            $hasDev = true;
            break;
        }
    }
    if (!$hasDev) {
        $db['admin_users'][] = [
            'id' => 'dev-09',
            'name' => 'Agency Developer',
            'email' => 'dev@shivalay.in',
            'password' => 'devpassshivalay',
            'role' => 'super_admin',
            'avatar' => 'DEV',
            'status' => 'active'
        ];
        $changed = true;
    }
    if ($changed) {
        saveFallbackDb($db);
    }
    return $db;
}

// Helper to save database data
function saveFallbackDb($db) {
    $dbPath = base_path('database/db_fallback.json');
    file_put_contents($dbPath, json_encode($db, JSON_PRETTY_PRINT));
}

Route::get('/', function () {
    $db = getFallbackDb();
    return view('welcome', [
        'packages' => $db['packages'] ?? [],
        'guides' => $db['guides'] ?? [],
        'cities' => $db['cities'] ?? []
    ]);
});

// CAPTCHA API Route
Route::get('/api/captcha', function () {
    $code = strval(rand(1000, 9999));
    session(['captcha' => $code]);
    
    $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="140" height="44" viewBox="0 0 140 44">';
    $svg .= '<rect width="100%" height="100%" fill="#18181b"/>';
    // add some random grid lines
    for ($i = 0; $i < 4; $i++) {
        $svg .= '<line x1="'.rand(0, 140).'" y1="'.rand(0, 44).'" x2="'.rand(0, 140).'" y2="'.rand(0, 44).'" stroke="#3b3b3b" stroke-width="1"/>';
    }
    $svg .= '<text x="50%" y="60%" font-size="22" fill="#ff0000" font-family="monospace" font-weight="bold" text-anchor="middle" letter-spacing="4">'.$code.'</text>';
    $svg .= '</svg>';
    
    return response()->json([
        'svg' => $svg,
        'token' => session()->getId(),
    ]);
});

// Guest Inquiry API Route
Route::post('/api/admin/inquiries', function (Request $request) {
    $captchaInput = $request->input('captchaInput');
    if (session('captcha') !== $captchaInput) {
        return response()->json(['error' => 'Invalid CAPTCHA code.'], 422);
    }
    
    $db = getFallbackDb();
    $newId = 'INQ-' . str_pad(strval(count($db['inquiries']) + 1), 3, '0', STR_PAD_LEFT);
    
    $inquiry = [
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
        'createdAt' => now()->toIso8601String(),
    ];
    
    $db['inquiries'][] = $inquiry;
    saveFallbackDb($db);
    
    return response()->json($inquiry);
});

// Guest Booking API Route
Route::post('/api/admin/bookings', function (Request $request) {
    $captchaInput = $request->input('captchaInput');
    if (session('captcha') !== $captchaInput) {
        return response()->json(['error' => 'Invalid CAPTCHA code.'], 422);
    }
    
    $db = getFallbackDb();
    $newId = 'SHV-' . str_pad(strval(count($db['bookings']) + 1), 3, '0', STR_PAD_LEFT);
    
    $booking = [
        'id' => $newId,
        'customerName' => $request->input('customerName'),
        'customerPhone' => $request->input('customerPhone'),
        'customerEmail' => $request->input('customerEmail'),
        'fromCity' => $request->input('fromCity'),
        'toCity' => $request->input('toCity'),
        'travelType' => $request->input('travelType', 'flight'),
        'date' => $request->input('date'),
        'returnDate' => $request->input('returnDate'),
        'passengers' => intval($request->input('passengers', 1)),
        'classType' => $request->input('classType'),
        'status' => 'pending',
        'amount' => rand(3000, 15000) * intval($request->input('passengers', 1)),
        'createdAt' => now()->toIso8601String(),
        'notes' => $request->input('notes'),
    ];
    
    $db['bookings'][] = $booking;
    saveFallbackDb($db);
    
    return response()->json($booking);
});

// API endpoint for admin UI
Route::get('/api/admin/bookings', function () {
    $db = getFallbackDb();
    return response()->json(array_reverse($db['bookings']));
});

Route::get('/api/admin/inquiries', function () {
    $db = getFallbackDb();
    return response()->json(array_reverse($db['inquiries']));
});

// ADMIN PANEL ROUTES
Route::get('/admin', function () {
    if (session()->has('admin_authenticated')) {
        return redirect('/admin/dashboard');
    }
    return redirect('/admin/login');
});

Route::get('/admin/login', function () {
    if (session()->has('admin_authenticated')) {
        return redirect('/admin/dashboard');
    }
    return view('admin.login');
});

Route::post('/admin/login', function (Request $request) {
    $email = $request->input('email');
    $password = $request->input('password');
    
    $db = getFallbackDb();
    $matchedUser = null;
    
    foreach ($db['admin_users'] as $user) {
        if ($user['email'] === $email && $user['password'] === $password) {
            $matchedUser = $user;
            break;
        }
    }
    
    if ($matchedUser) {
        session([
            'admin_authenticated' => true,
            'admin_id' => $matchedUser['id'],
            'admin_name' => $matchedUser['name'],
            'admin_email' => $matchedUser['email'],
            'admin_role' => $matchedUser['role'],
        ]);
        return redirect('/admin/dashboard');
    }
    
    return redirect('/admin/login')->withErrors(['login' => 'Invalid email or password.']);
});

Route::get('/admin/logout', function () {
    session()->forget(['admin_authenticated', 'admin_id', 'admin_name', 'admin_email', 'admin_role']);
    return redirect('/admin/login');
});

// ADMIN PANEL SECURE ROUTES (Explicit auth check wrapper)
Route::get('/admin/dashboard', function () {
    if (!session()->has('admin_authenticated')) { return redirect('/admin/login'); }
    $db = getFallbackDb();
    return view('admin.dashboard', [
        'bookings' => array_reverse($db['bookings']),
        'inquiries' => array_reverse($db['inquiries']),
    ]);
});

Route::get('/admin/bookings', function () {
    if (!session()->has('admin_authenticated')) { return redirect('/admin/login'); }
    $db = getFallbackDb();
    $role = session('admin_role', 'viewer');
    $canManage = in_array($role, ['super_admin', 'manager', 'agent']);
    $canDelete = in_array($role, ['super_admin', 'manager']);
    return view('admin.bookings', [
        'bookings' => array_reverse($db['bookings']),
        'canManage' => $canManage,
        'canDelete' => $canDelete,
    ]);
});

Route::post('/admin/bookings', function (Request $request) {
    if (!session()->has('admin_authenticated')) { return redirect('/admin/login'); }
    $db = getFallbackDb();
    $newId = 'SHV-' . str_pad(strval(count($db['bookings']) + 1), 3, '0', STR_PAD_LEFT);
    
    $booking = [
        'id' => $newId,
        'customerName' => $request->input('customerName'),
        'customerPhone' => $request->input('customerPhone'),
        'customerEmail' => $request->input('customerEmail'),
        'fromCity' => $request->input('fromCity'),
        'toCity' => $request->input('toCity'),
        'travelType' => $request->input('travelType', 'flight'),
        'date' => $request->input('date'),
        'passengers' => intval($request->input('passengers', 1)),
        'classType' => $request->input('classType', 'Economy'),
        'status' => 'pending',
        'amount' => floatval($request->input('amount')),
        'createdAt' => now()->toIso8601String(),
    ];
    
    $db['bookings'][] = $booking;
    saveFallbackDb($db);
    
    return redirect('/admin/bookings')->with('success', 'Booking created successfully!');
});

Route::post('/admin/bookings/update/{id}', function (Request $request, $id) {
    if (!session()->has('admin_authenticated')) { return redirect('/admin/login'); }
    $db = getFallbackDb();
    foreach ($db['bookings'] as &$booking) {
        if ($booking['id'] === $id) {
            $booking['customerName'] = $request->input('customerName');
            $booking['customerPhone'] = $request->input('customerPhone');
            $booking['customerEmail'] = $request->input('customerEmail');
            $booking['fromCity'] = $request->input('fromCity');
            $booking['toCity'] = $request->input('toCity');
            $booking['travelType'] = $request->input('travelType', 'flight');
            $booking['date'] = $request->input('date');
            $booking['passengers'] = intval($request->input('passengers', 1));
            $booking['classType'] = $request->input('classType', 'Economy');
            $booking['amount'] = floatval($request->input('amount'));
            $booking['status'] = $request->input('status');
            $booking['notes'] = $request->input('notes', '');
            break;
        }
    }
    saveFallbackDb($db);
    return redirect('/admin/bookings')->with('success', 'Booking updated successfully!');
});

Route::post('/admin/bookings/status/{id}', function (Request $request, $id) {
    if (!session()->has('admin_authenticated')) { return redirect('/admin/login'); }
    $db = getFallbackDb();
    foreach ($db['bookings'] as &$booking) {
        if ($booking['id'] === $id) {
            $booking['status'] = $request->input('status');
            break;
        }
    }
    saveFallbackDb($db);
    return redirect('/admin/bookings')->with('success', 'Booking status updated successfully!');
});

Route::get('/admin/bookings/delete/{id}', function ($id) {
    if (!session()->has('admin_authenticated')) { return redirect('/admin/login'); }
    $db = getFallbackDb();
    $db['bookings'] = array_values(array_filter($db['bookings'], function ($booking) use ($id) {
        return $booking['id'] !== $id;
    }));
    saveFallbackDb($db);
    return redirect('/admin/bookings')->with('success', 'Booking deleted successfully!');
});

Route::get('/admin/inquiries', function () {
    if (!session()->has('admin_authenticated')) { return redirect('/admin/login'); }
    $db = getFallbackDb();
    $role = session('admin_role', 'viewer');
    $canManage = in_array($role, ['super_admin', 'manager', 'agent']);
    $canDelete = in_array($role, ['super_admin', 'manager']);
    return view('admin.inquiries', [
        'inquiries' => array_reverse($db['inquiries']),
        'canManage' => $canManage,
        'canDelete' => $canDelete,
    ]);
});

Route::get('/admin/inquiries/delete/{id}', function ($id) {
    if (!session()->has('admin_authenticated')) { return redirect('/admin/login'); }
    $db = getFallbackDb();
    $db['inquiries'] = array_values(array_filter($db['inquiries'], function ($inq) use ($id) {
        return $inq['id'] !== $id;
    }));
    saveFallbackDb($db);
    return redirect('/admin/inquiries')->with('success', 'Inquiry deleted successfully!');
});

Route::post('/admin/inquiries/update/{id}', function (Request $request, $id) {
    if (!session()->has('admin_authenticated')) { return redirect('/admin/login'); }
    $db = getFallbackDb();
    foreach ($db['inquiries'] as &$inq) {
        if ($inq['id'] === $id) {
            $inq['customerName'] = $request->input('customerName');
            $inq['customerPhone'] = $request->input('customerPhone');
            $inq['customerEmail'] = $request->input('customerEmail');
            $inq['destinations'] = $request->input('destinations');
            $inq['duration'] = $request->input('duration');
            $inq['travelers'] = intval($request->input('travelers', 1));
            $inq['budget'] = $request->input('budget');
            $inq['accommodation'] = $request->input('accommodation');
            $inq['status'] = $request->input('status', 'pending');
            $inq['notes'] = $request->input('notes', '');
            break;
        }
    }
    saveFallbackDb($db);
    return redirect('/admin/inquiries')->with('success', 'Inquiry updated successfully!');
});

// JSON API inquiries routes
Route::get('/api/admin/inquiries', function () {
    $db = getFallbackDb();
    return response()->json($db['inquiries'] ?? []);
});

Route::put('/api/admin/inquiries/{id}', function (Request $request, $id) {
    $db = getFallbackDb();
    $updated = [];
    foreach ($db['inquiries'] as &$inq) {
        if ($inq['id'] === $id) {
            $inq['customerName'] = $request->input('customerName');
            $inq['customerPhone'] = $request->input('customerPhone');
            $inq['customerEmail'] = $request->input('customerEmail');
            $inq['destinations'] = $request->input('destinations');
            $inq['duration'] = $request->input('duration');
            $inq['travelers'] = intval($request->input('travelers', 1));
            $inq['budget'] = $request->input('budget');
            $inq['accommodation'] = $request->input('accommodation');
            $inq['status'] = $request->input('status', 'pending');
            $inq['notes'] = $request->input('notes', '');
            $updated = $inq;
            break;
        }
    }
    saveFallbackDb($db);
    return response()->json($updated);
});

Route::delete('/api/admin/inquiries/{id}', function ($id) {
    $db = getFallbackDb();
    $db['inquiries'] = array_values(array_filter($db['inquiries'], function ($inq) use ($id) {
        return $inq['id'] !== $id;
    }));
    saveFallbackDb($db);
    return response()->json(['success' => true]);
});

Route::get('/admin/settings', function () {
    if (!session()->has('admin_authenticated')) { return redirect('/admin/login'); }
    $db = getFallbackDb();
    return view('admin.settings', [
        'settings' => $db['settings'],
    ]);
});

Route::post('/admin/settings', function (Request $request) {
    if (!session()->has('admin_authenticated')) { return redirect('/admin/login'); }
    $db = getFallbackDb();
    $db['settings'] = [
        'businessName' => $request->input('businessName'),
        'gstNumber' => $request->input('gstNumber'),
        'phone' => $request->input('phone'),
        'whatsapp' => $request->input('whatsapp'),
        'email' => $request->input('email'),
        'address' => $request->input('address'),
        'defaultPassengers' => $request->input('defaultPassengers', '1'),
        'defaultClass' => $request->input('defaultClass', 'Economy'),
        'currency' => $request->input('currency', 'INR'),
        'timezone' => $request->input('timezone', 'Asia/Kolkata'),
        'bookingNotifications' => $request->input('bookingNotifications') === '1',
        'whatsappIntegration' => $request->input('whatsappIntegration') === '1',
        'autoConfirm' => $request->input('autoConfirm') === '1',
        'requirePhone' => $request->input('requirePhone') === '1',
        'cityApi' => $request->input('cityApi', 'open_meteo')
    ];
    saveFallbackDb($db);
    return redirect('/admin/settings')->with('success', 'Configuration settings updated successfully!');
});

// JSON API settings routes
Route::get('/api/admin/settings', function () {
    $db = getFallbackDb();
    return response()->json($db['settings'] ?? []);
});

Route::post('/api/admin/settings', function (Request $request) {
    $db = getFallbackDb();
    $db['settings'] = array_merge($db['settings'] ?? [], $request->all());
    saveFallbackDb($db);
    return response()->json($db['settings'] ?? []);
});

// CITIES & ROUTES ADMIN
Route::get('/admin/cities', function () {
    if (!session()->has('admin_authenticated')) { return redirect('/admin/login'); }
    $role = session('admin_role', 'viewer');
    if ($role !== 'super_admin' && $role !== 'manager') { return abort(403, 'Access Restricted'); }
    
    $db = getFallbackDb();
    return view('admin.cities', [
        'cities' => $db['cities'] ?? [],
    ]);
});

Route::post('/admin/cities', function (Request $request) {
    if (!session()->has('admin_authenticated')) { return redirect('/admin/login'); }
    $role = session('admin_role', 'viewer');
    if ($role !== 'super_admin' && $role !== 'manager') { return abort(403, 'Access Restricted'); }
    
    $db = getFallbackDb();
    $newId = strval(count($db['cities'] ?? []) + 1);
    $city = [
        'id' => $newId,
        'name' => $request->input('name'),
        'code' => strtoupper($request->input('code')),
        'state' => $request->input('state', ''),
        'country' => 'India',
        'type' => $request->input('type', 'airport'),
        'isPopular' => $request->has('isPopular'),
    ];
    $db['cities'][] = $city;
    saveFallbackDb($db);
    return redirect('/admin/cities')->with('success', 'City airport route added successfully!');
});

Route::post('/admin/cities/popular/{id}', function ($id) {
    if (!session()->has('admin_authenticated')) { return redirect('/admin/login'); }
    $role = session('admin_role', 'viewer');
    if ($role !== 'super_admin' && $role !== 'manager') { return abort(403, 'Access Restricted'); }
    
    $db = getFallbackDb();
    foreach ($db['cities'] as &$city) {
        if ($city['id'] === $id) {
            $city['isPopular'] = !($city['isPopular'] ?? false);
            break;
        }
    }
    saveFallbackDb($db);
    return redirect('/admin/cities')->with('success', 'City popularity status toggled!');
});

Route::get('/admin/cities/delete/{id}', function ($id) {
    if (!session()->has('admin_authenticated')) { return redirect('/admin/login'); }
    $role = session('admin_role', 'viewer');
    if ($role !== 'super_admin') { return abort(403, 'Access Restricted'); } // Only super_admin can delete
    
    $db = getFallbackDb();
    $db['cities'] = array_values(array_filter($db['cities'] ?? [], function ($c) use ($id) {
        return $c['id'] !== $id;
    }));
    saveFallbackDb($db);
    return redirect('/admin/cities')->with('success', 'City airport route deleted successfully!');
});

// USERS & ROLES ADMIN
Route::get('/admin/users', function () {
    if (!session()->has('admin_authenticated')) { return redirect('/admin/login'); }
    $role = session('admin_role', 'viewer');
    if ($role !== 'super_admin') { return abort(403, 'Access Restricted'); }
    
    $db = getFallbackDb();
    return view('admin.users', [
        'users' => $db['admin_users'] ?? [],
    ]);
});

Route::post('/admin/users', function (Request $request) {
    if (!session()->has('admin_authenticated')) { return redirect('/admin/login'); }
    $role = session('admin_role', 'viewer');
    if ($role !== 'super_admin') { return abort(403, 'Access Restricted'); }
    
    $db = getFallbackDb();
    $newId = strval(count($db['admin_users'] ?? []) + 1);
    
    $name = $request->input('name');
    $parts = explode(' ', $name);
    $avatar = strtoupper(substr($parts[0] ?? 'A', 0, 1) . substr($parts[1] ?? ($parts[0] ?? 'A'), 0, 1));

    $user = [
        'id' => $newId,
        'name' => $name,
        'email' => $request->input('email'),
        'password' => $request->input('password'),
        'role' => $request->input('role', 'agent'),
        'avatar' => $avatar,
        'status' => 'active',
    ];
    $db['admin_users'][] = $user;
    saveFallbackDb($db);
    return redirect('/admin/users')->with('success', 'User account created successfully!');
});

Route::post('/admin/users/role/{id}', function (Request $request, $id) {
    if (!session()->has('admin_authenticated')) { return redirect('/admin/login'); }
    $role = session('admin_role', 'viewer');
    if ($role !== 'super_admin') { return abort(403, 'Access Restricted'); }
    if (session('admin_id') === $id) { return abort(400, 'Cannot change your own role.'); }
    
    $db = getFallbackDb();
    foreach ($db['admin_users'] as &$user) {
        if ($user['id'] === $id) {
            $user['role'] = $request->input('role');
            break;
        }
    }
    saveFallbackDb($db);
    return redirect('/admin/users')->with('success', 'User role updated successfully!');
});

Route::post('/admin/users/status/{id}', function ($id) {
    if (!session()->has('admin_authenticated')) { return redirect('/admin/login'); }
    $role = session('admin_role', 'viewer');
    if ($role !== 'super_admin') { return abort(403, 'Access Restricted'); }
    if (session('admin_id') === $id) { return abort(400, 'Cannot toggle your own status.'); }
    
    $db = getFallbackDb();
    foreach ($db['admin_users'] as &$user) {
        if ($user['id'] === $id) {
            $user['status'] = ($user['status'] ?? 'active') === 'active' ? 'inactive' : 'active';
            break;
        }
    }
    saveFallbackDb($db);
    return redirect('/admin/users')->with('success', 'User status updated successfully!');
});

Route::get('/admin/users/delete/{id}', function ($id) {
    if (!session()->has('admin_authenticated')) { return redirect('/admin/login'); }
    $role = session('admin_role', 'viewer');
    if ($role !== 'super_admin') { return abort(403, 'Access Restricted'); }
    if (session('admin_id') === $id) { return abort(400, 'Cannot remove yourself.'); }
    
    $db = getFallbackDb();
    $db['admin_users'] = array_values(array_filter($db['admin_users'] ?? [], function ($u) use ($id) {
        return $u['id'] !== $id;
    }));
    saveFallbackDb($db);
    return redirect('/admin/users')->with('success', 'User account deleted successfully!');
});

// ANALYTICS ADMIN
Route::get('/admin/analytics', function () {
    if (!session()->has('admin_authenticated')) { return redirect('/admin/login'); }
    $role = session('admin_role', 'viewer');
    if ($role === 'agent') { return abort(403, 'Access Restricted'); }
    
    $db = getFallbackDb();
    return view('admin.analytics', [
        'bookings' => $db['bookings'] ?? [],
        'inquiries' => $db['inquiries'] ?? [],
    ]);
});

// DESTINATIONS ADMIN (Developer-only)
Route::get('/admin/destinations', function () {
    if (!session()->has('admin_authenticated')) { return redirect('/admin/login'); }
    $email = session('admin_email', '');
    if ($email !== 'dev@shivalay.in') { return redirect('/admin/dashboard'); }
    
    $db = getFallbackDb();
    return view('admin.destinations', [
        'packages' => $db['packages'] ?? [],
    ]);
});

Route::post('/admin/destinations', function (Request $request) {
    if (!session()->has('admin_authenticated')) { return redirect('/admin/login'); }
    $email = session('admin_email', '');
    if ($email !== 'dev@shivalay.in') { return redirect('/admin/dashboard'); }
    
    $db = getFallbackDb();
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
        foreach ($db['packages'] as &$pkg) {
            if ($pkg['id'] === $editingId) {
                $pkg = array_merge($pkg, $packageData);
                break;
            }
        }
    } else {
        $packageData['id'] = strtolower(str_replace(' ', '-', $request->input('name')));
        $db['packages'][] = $packageData;
    }
    
    saveFallbackDb($db);
    return redirect('/admin/destinations')->with('success', 'Destination package saved successfully!');
});

Route::get('/admin/destinations/delete/{id}', function ($id) {
    if (!session()->has('admin_authenticated')) { return redirect('/admin/login'); }
    $email = session('admin_email', '');
    if ($email !== 'dev@shivalay.in') { return redirect('/admin/dashboard'); }
    
    $db = getFallbackDb();
    $db['packages'] = array_values(array_filter($db['packages'] ?? [], function ($pkg) use ($id) {
        return $pkg['id'] !== $id;
    }));
    saveFallbackDb($db);
    return redirect('/admin/destinations')->with('success', 'Destination package deleted successfully!');
});

// TRAVEL GUIDES ADMIN (Developer-only)
Route::get('/admin/guides', function () {
    if (!session()->has('admin_authenticated')) { return redirect('/admin/login'); }
    $email = session('admin_email', '');
    if ($email !== 'dev@shivalay.in') { return redirect('/admin/dashboard'); }
    
    $db = getFallbackDb();
    return view('admin.guides', [
        'guides' => $db['guides'] ?? [],
    ]);
});

Route::post('/admin/guides', function (Request $request) {
    if (!session()->has('admin_authenticated')) { return redirect('/admin/login'); }
    $email = session('admin_email', '');
    if ($email !== 'dev@shivalay.in') { return redirect('/admin/dashboard'); }
    
    $db = getFallbackDb();
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
        foreach ($db['guides'] as &$guide) {
            if ($guide['id'] === $editingId) {
                $guide = array_merge($guide, $guideData);
                break;
            }
        }
    } else {
        $guideData['id'] = strval(count($db['guides'] ?? []) + 1);
        $db['guides'][] = $guideData;
    }
    
    saveFallbackDb($db);
    return redirect('/admin/guides')->with('success', 'Travel guide saved successfully!');
});

Route::get('/admin/guides/delete/{id}', function ($id) {
    if (!session()->has('admin_authenticated')) { return redirect('/admin/login'); }
    $email = session('admin_email', '');
    if ($email !== 'dev@shivalay.in') { return redirect('/admin/dashboard'); }
    
    $db = getFallbackDb();
    $db['guides'] = array_values(array_filter($db['guides'] ?? [], function ($g) use ($id) {
        return $g['id'] !== $id;
    }));
    saveFallbackDb($db);
    return redirect('/admin/guides')->with('success', 'Travel guide deleted successfully!');
});

