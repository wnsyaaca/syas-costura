<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\StoreBooking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class BookingCalendarController extends Controller
{
    private array $timeSlots = [
        '09:00',
        '10:00',
        '11:00',
        '13:00',
        '14:00',
        '15:00',
        '16:00',
    ];

    /**
     * Menampilkan kalender booking fitting.
     */
    public function index(Request $request)
    {
        $month = $request->query('month', now()->format('Y-m'));

        try {
            $startDate = Carbon::createFromFormat('!Y-m', $month)
                ->startOfMonth();
        } catch (\Exception $e) {
            $startDate = now()->startOfMonth();
        }

        $endDate = $startDate->copy()->endOfMonth();

        // Ambil jumlah booking fitting setiap tanggal langsung dari database.
        $bookingCounts = StoreBooking::query()
            ->where('booking_type', 'fitting')
            ->whereBetween('booking_date', [
                $startDate->toDateString(),
                $endDate->toDateString(),
            ])
            ->selectRaw('DATE(booking_date) as booking_day, COUNT(*) as total')
            ->groupByRaw('DATE(booking_date)')
            ->pluck('total', 'booking_day');

        // Ambil jam yang sudah dipesan.
        $bookedSlots = StoreBooking::query()
            ->where('booking_type', 'fitting')
            ->whereBetween('booking_date', [
                $startDate->toDateString(),
                $endDate->toDateString(),
            ])
            ->get(['booking_date', 'time_slot'])
            ->groupBy(function ($booking) {
                return Carbon::parse($booking->booking_date)->format('Y-m-d');
            })
            ->map(function ($items) {
                return $items->pluck('time_slot')->values();
            });

        // Tanggal yang sedang dipilih.
        $selectedDate = $request->query('date');

        $selectedSlots = collect(
            $selectedDate
                ? $bookedSlots->get($selectedDate, collect())
                : []
        );

        return view('booking.calendar', [
            'currentMonth' => $startDate,
            'bookingCounts' => $bookingCounts,
            'bookedSlots' => $bookedSlots,
            'selectedDate' => $selectedDate,
            'selectedSlots' => $selectedSlots,
            'timeSlots' => $this->timeSlots,
        ]);
    }

    /**
     * Menyimpan booking fitting pelanggan.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
            'time_slot' => [
                'required',
                'string',
                'in:' . implode(',', $this->timeSlots),
            ],
            'phone' => [
                'required',
                'string',
                'max:20',
            ],
        ], [
            'booking_date.required' => 'Silakan pilih tanggal booking.',
            'booking_date.after_or_equal' => 'Tanggal booking tidak boleh sebelum hari ini.',
            'time_slot.required' => 'Silakan pilih jam fitting.',
            'time_slot.in' => 'Jam fitting yang dipilih tidak valid.',
            'phone.required' => 'Nomor WhatsApp wajib diisi.',
        ]);

        $bookingDate = Carbon::parse($validated['booking_date']);

        // Tidak menerima booking pada Sabtu dan Minggu.
        if ($bookingDate->isWeekend()) {
            return back()
                ->withInput()
                ->withErrors([
                    'booking_date' => 'Booking fitting hanya tersedia pada hari Senin sampai Jumat.',
                ]);
        }

        try {
            DB::transaction(function () use ($request, $validated) {

                $dailyBookings = StoreBooking::query()
                    ->where('booking_type', 'fitting')
                    ->whereDate('booking_date', $validated['booking_date'])
                    ->lockForUpdate()
                    ->get();

                // Maksimal 3 booking setiap hari.
                if ($dailyBookings->count() >= 3) {
                    throw new \RuntimeException(
                        'Maaf, jadwal pada tanggal tersebut sudah penuh.'
                    );
                }

                // Cegah jam yang sama dipesan dua kali.
                if ($dailyBookings->contains('time_slot', $validated['time_slot'])) {
                    throw new \RuntimeException(
                        'Jam tersebut sudah dipesan. Silakan pilih jam lain.'
                    );
                }

                // Ambil atau buat data pelanggan.
                $customer = Customer::firstOrNew([
                    'user_id' => $request->user()->id,
                ]);

                $customer->phone = $validated['phone'];
                $customer->save();

                // Simpan booking fitting.
                StoreBooking::create([
                    'order_id' => null,
                    'customer_id' => $customer->id,
                    'booking_date' => $validated['booking_date'],
                    'time_slot' => $validated['time_slot'],
                    'booking_type' => 'fitting',
                    'status' => 'pending',
                ]);
            });

        } catch (\RuntimeException $e) {
            return back()
                ->withInput()
                ->withErrors([
                    'booking' => $e->getMessage(),
                ]);

        } catch (QueryException $e) {
            return back()
                ->withInput()
                ->withErrors([
                    'booking' => 'Jadwal baru saja dipesan pelanggan lain. Silakan pilih jam berbeda.',
                ]);
        }

        return redirect()
            ->route('booking.index', [
                'month' => Carbon::parse($validated['booking_date'])->format('Y-m'),
            ])
            ->with('success', 'Booking fitting berhasil dikirim! Silakan menunggu konfirmasi admin.');
    }
}
