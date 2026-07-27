<?php

namespace App\Services;

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
use Exception;
use Illuminate\Support\Facades\Log;

class TravelService
{
    /**
     * Get all data from MySQL, falling back to JSON if database fails.
     */
    public function getPackages()
    {
        try {
            return Package::all()->toArray();
        } catch (Exception $e) {
            Log::error("MySQL failed in getPackages: " . $e->getMessage());
            return $this->getFallbackData('packages');
        }
    }

    public function getGuides()
    {
        try {
            return Guide::all()->toArray();
        } catch (Exception $e) {
            Log::error("MySQL failed in getGuides: " . $e->getMessage());
            return $this->getFallbackData('guides');
        }
    }

    public function getCities()
    {
        try {
            return City::all()->toArray();
        } catch (Exception $e) {
            Log::error("MySQL failed in getCities: " . $e->getMessage());
            return $this->getFallbackData('cities');
        }
    }

    public function getHotels()
    {
        try {
            return Hotel::all()->toArray();
        } catch (Exception $e) {
            Log::error("MySQL failed in getHotels: " . $e->getMessage());
            return $this->getFallbackData('hotels');
        }
    }

    public function getVillas()
    {
        try {
            return Villa::all()->toArray();
        } catch (Exception $e) {
            Log::error("MySQL failed in getVillas: " . $e->getMessage());
            return $this->getFallbackData('villas');
        }
    }

    public function getTestimonials()
    {
        try {
            return Testimonial::all()->toArray();
        } catch (Exception $e) {
            Log::error("MySQL failed in getTestimonials: " . $e->getMessage());
            return $this->getFallbackData('testimonials');
        }
    }

    public function getSettings()
    {
        try {
            $settings = Setting::all();
            $formatted = [];
            foreach ($settings as $setting) {
                $val = $setting->value;
                $decoded = json_decode($val, true);
                if (json_last_error() === JSON_ERROR_NONE && !is_numeric($val) && (is_array($decoded) || is_object($decoded))) {
                    $formatted[$setting->key] = $decoded;
                } else {
                    if ($val === 'true') $val = true;
                    elseif ($val === 'false') $val = false;
                    elseif (is_numeric($val)) {
                        $val = strpos($val, '.') !== false ? floatval($val) : intval($val);
                    }
                    $formatted[$setting->key] = $val;
                }
            }
            // Populate defaults if settings are empty
            if (empty($formatted)) {
                return $this->getFallbackData('settings');
            }
            return $formatted;
        } catch (Exception $e) {
            Log::error("MySQL failed in getSettings: " . $e->getMessage());
            return $this->getFallbackData('settings');
        }
    }

    public function getAdminUsers()
    {
        try {
            return AdminUser::all()->toArray();
        } catch (Exception $e) {
            Log::error("MySQL failed in getAdminUsers: " . $e->getMessage());
            return $this->getFallbackData('admin_users');
        }
    }

    public function getBookings()
    {
        try {
            return Booking::orderBy('created_at', 'desc')->get()->toArray();
        } catch (Exception $e) {
            Log::error("MySQL failed in getBookings: " . $e->getMessage());
            return $this->getFallbackData('bookings');
        }
    }

    public function getInquiries()
    {
        try {
            return Inquiry::orderBy('created_at', 'desc')->get()->toArray();
        } catch (Exception $e) {
            Log::error("MySQL failed in getInquiries: " . $e->getMessage());
            return $this->getFallbackData('inquiries');
        }
    }

    /**
     * Read a specific key from the fallback JSON file.
     */
    private function getFallbackData($key)
    {
        $dbPath = base_path('database/db_fallback.json');
        if (!file_exists($dbPath)) {
            return [];
        }
        $db = json_decode(file_get_contents($dbPath), true);
        return $db[$key] ?? [];
    }

    /**
     * Dump all MySQL tables into db_fallback.json to keep it in sync.
     */
    public function syncToFallback()
    {
        try {
            $db = [
                'admin_users' => AdminUser::all()->toArray(),
                'inquiries' => Inquiry::all()->map(function($inq) {
                    $arr = $inq->toArray();
                    $arr['createdAt'] = $inq->created_at ? $inq->created_at->toIso8601String() : null;
                    return $arr;
                })->toArray(),
                'bookings' => Booking::all()->map(function($b) {
                    $arr = $b->toArray();
                    $arr['createdAt'] = $b->created_at ? $b->created_at->toIso8601String() : null;
                    return $arr;
                })->toArray(),
                'cities' => City::all()->toArray(),
                'settings' => $this->getSettings(),
                'packages' => Package::all()->toArray(),
                'guides' => Guide::all()->toArray(),
                'hotels' => Hotel::all()->toArray(),
                'villas' => Villa::all()->toArray(),
                'testimonials' => Testimonial::all()->toArray()
            ];

            $dbPath = base_path('database/db_fallback.json');
            file_put_contents($dbPath, json_encode($db, JSON_PRETTY_PRINT));
        } catch (Exception $e) {
            Log::error("syncToFallback failed: " . $e->getMessage());
        }
    }
}
