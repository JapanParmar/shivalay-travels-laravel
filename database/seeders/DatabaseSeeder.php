<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminUser;
use App\Models\Inquiry;
use App\Models\Booking;
use App\Models\City;
use App\Models\Setting;
use App\Models\Package;
use App\Models\Guide;
use App\Models\Hotel;
use App\Models\Villa;
use App\Models\Testimonial;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $dbPath = base_path('database/db_fallback.json');
        if (!file_exists($dbPath)) {
            $this->command->error("db_fallback.json not found.");
            return;
        }

        $db = json_decode(file_get_contents($dbPath), true);
        if (!$db) {
            $this->command->error("Invalid db_fallback.json format.");
            return;
        }

        // Seed admin_users
        if (isset($db['admin_users'])) {
            AdminUser::truncate();
            foreach ($db['admin_users'] as $user) {
                AdminUser::create([
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'password' => $user['password'],
                    'role' => $user['role'] ?? 'agent',
                    'avatar' => $user['avatar'] ?? null,
                    'status' => $user['status'] ?? 'active',
                ]);
            }
            $this->command->info("Seeded Admin Users.");
        }

        // Seed inquiries
        if (isset($db['inquiries'])) {
            Inquiry::truncate();
            foreach ($db['inquiries'] as $inq) {
                Inquiry::create([
                    'id' => $inq['id'],
                    'customerName' => $inq['customerName'],
                    'customerPhone' => $inq['customerPhone'],
                    'customerEmail' => $inq['customerEmail'] ?? null,
                    'destinations' => $inq['destinations'] ?? null,
                    'duration' => $inq['duration'] ?? null,
                    'travelers' => intval($inq['travelers'] ?? 1),
                    'budget' => $inq['budget'] ?? null,
                    'accommodation' => $inq['accommodation'] ?? null,
                    'status' => $inq['status'] ?? 'pending',
                    'notes' => $inq['notes'] ?? null,
                    'created_at' => isset($inq['createdAt']) ? date('Y-m-d H:i:s', strtotime($inq['createdAt'])) : now(),
                    'updated_at' => isset($inq['createdAt']) ? date('Y-m-d H:i:s', strtotime($inq['createdAt'])) : now(),
                ]);
            }
            $this->command->info("Seeded Inquiries.");
        }

        // Seed bookings
        if (isset($db['bookings'])) {
            Booking::truncate();
            foreach ($db['bookings'] as $b) {
                Booking::create([
                    'id' => $b['id'],
                    'customerName' => $b['customerName'],
                    'customerPhone' => $b['customerPhone'],
                    'customerEmail' => $b['customerEmail'] ?? null,
                    'fromCity' => $b['fromCity'] ?? null,
                    'toCity' => $b['toCity'] ?? null,
                    'travelType' => $b['travelType'],
                    'date' => $b['date'],
                    'returnDate' => $b['returnDate'] ?? null,
                    'passengers' => intval($b['passengers'] ?? 1),
                    'classType' => $b['classType'] ?? null,
                    'status' => $b['status'] ?? 'pending',
                    'amount' => floatval($b['amount'] ?? 0.00),
                    'agentId' => $b['agentId'] ?? null,
                    'notes' => $b['notes'] ?? null,
                    'created_at' => isset($b['createdAt']) ? date('Y-m-d H:i:s', strtotime($b['createdAt'])) : now(),
                    'updated_at' => isset($b['createdAt']) ? date('Y-m-d H:i:s', strtotime($b['createdAt'])) : now(),
                ]);
            }
            $this->command->info("Seeded Bookings.");
        }

        // Seed cities
        if (isset($db['cities'])) {
            City::truncate();
            foreach ($db['cities'] as $city) {
                City::create([
                    'name' => $city['name'],
                    'code' => $city['code'] ?? null,
                    'state' => $city['state'] ?? null,
                    'country' => $city['country'] ?? 'India',
                    'type' => $city['type'] ?? 'airport',
                    'isPopular' => (bool)($city['isPopular'] ?? false),
                ]);
            }
            $this->command->info("Seeded Cities.");
        }

        // Seed settings
        if (isset($db['settings'])) {
            Setting::truncate();
            foreach ($db['settings'] as $key => $value) {
                Setting::create([
                    'key' => $key,
                    'value' => is_scalar($value) ? $value : json_encode($value),
                ]);
            }
            $this->command->info("Seeded Settings.");
        }

        // Seed packages
        if (isset($db['packages'])) {
            Package::truncate();
            foreach ($db['packages'] as $p) {
                Package::create([
                    'id' => $p['id'],
                    'name' => $p['name'],
                    'region' => $p['region'] ?? null,
                    'tagline' => $p['tagline'] ?? null,
                    'duration' => $p['duration'] ?? null,
                    'groupSize' => $p['groupSize'] ?? null,
                    'difficulty' => $p['difficulty'] ?? null,
                    'bestSeason' => $p['bestSeason'] ?? null,
                    'startingFrom' => $p['startingFrom'] ?? null,
                    'tags' => $p['tags'] ?? [],
                    'highlights' => $p['highlights'] ?? [],
                    'includes' => $p['includes'] ?? [],
                    'imagePath' => $p['imagePath'] ?? null,
                    'gallery' => $p['gallery'] ?? [],
                ]);
            }
            $this->command->info("Seeded Packages.");
        }

        // Seed guides
        if (isset($db['guides'])) {
            Guide::truncate();
            foreach ($db['guides'] as $g) {
                Guide::create([
                    'category' => $g['category'] ?? null,
                    'title' => $g['title'],
                    'readTime' => $g['readTime'] ?? null,
                    'badge' => $g['badge'] ?? null,
                    'image' => $g['image'] ?? null,
                    'icon' => $g['icon'] ?? null,
                ]);
            }
            $this->command->info("Seeded Guides.");
        }

        // Seed hotels
        if (isset($db['hotels'])) {
            Hotel::truncate();
            foreach ($db['hotels'] as $h) {
                Hotel::create([
                    'id' => $h['id'],
                    'name' => $h['name'],
                    'location' => $h['location'] ?? null,
                    'description' => $h['description'] ?? null,
                    'price' => $h['price'] ?? null,
                    'imagePath' => $h['imagePath'] ?? null,
                    'rating' => $h['rating'] ?? null,
                    'amenities' => $h['amenities'] ?? [],
                    'gallery' => $h['gallery'] ?? [],
                ]);
            }
            $this->command->info("Seeded Hotels.");
        }

        // Seed villas
        if (isset($db['villas'])) {
            Villa::truncate();
            foreach ($db['villas'] as $v) {
                Villa::create([
                    'id' => $v['id'],
                    'name' => $v['name'],
                    'location' => $v['location'] ?? null,
                    'description' => $v['description'] ?? null,
                    'price' => $v['price'] ?? null,
                    'imagePath' => $v['imagePath'] ?? null,
                    'rating' => $v['rating'] ?? null,
                    'amenities' => $v['amenities'] ?? [],
                    'gallery' => $v['gallery'] ?? [],
                ]);
            }
            $this->command->info("Seeded Villas.");
        }

        // Seed testimonials
        if (isset($db['testimonials'])) {
            Testimonial::truncate();
            foreach ($db['testimonials'] as $t) {
                Testimonial::create([
                    'quote' => $t['quote'],
                    'name' => $t['name'],
                    'location' => $t['location'] ?? null,
                    'destination' => $t['destination'] ?? null,
                    'trip' => $t['trip'] ?? null,
                    'rating' => intval($t['rating'] ?? 5),
                    'avatar' => $t['avatar'] ?? null,
                    'image' => $t['image'] ?? null,
                    'clientImage' => $t['clientImage'] ?? null,
                ]);
            }
            $this->command->info("Seeded Testimonials.");
        }
    }
}
