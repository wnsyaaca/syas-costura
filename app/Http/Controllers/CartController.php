<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CartController extends Controller
{
    /**
     * Menampilkan halaman keranjang.
     */
    public function index()
    {
        $cart = session()->get('cart', []);

        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        $totalItems = collect($cart)->sum('quantity');

        return view('cart.index', compact(
            'cart',
            'total',
            'totalItems'
        ));
    }

    /**
     * Menambahkan produk ke keranjang.
     */
    public function store(Request $request, Service $service)
    {
        $standardSizes = $service->standard_sizes ?: [
            'S',
            'M',
            'L',
            'XL',
            'XXL',
        ];

        $rules = [
            'quantity' => [
                'required',
                'integer',
                'min:1',
                'max:20',
            ],

            'size_type' => [
                'required',
                Rule::in(['standard', 'custom']),
            ],

            'color' => [
                'nullable',
                'string',
                'max:60',
            ],

            'size_label' => [
                'required_if:size_type,standard',
                'nullable',
                'string',
                Rule::in($standardSizes),
            ],

            'custom_measurements' => [
                'required_if:size_type,custom',
                'nullable',
                'array',
            ],
        ];

        $measurementFields = [
            'chest',
            'waist',
            'hip',
            'shoulder',
            'length',
            'sleeve',
        ];

        foreach ($measurementFields as $field) {
            $rules["custom_measurements.$field"] = [
                'required_if:size_type,custom',
                'nullable',
                'numeric',
                'min:1',
                'max:300',
            ];
        }

        $validated = $request->validate($rules);

        // Periksa apakah produk menerima ukuran custom.
        if (
            $validated['size_type'] === 'custom'
            && !$service->allow_custom_size
        ) {
            return back()
                ->withErrors([
                    'size_type' => 'Produk ini tidak menerima ukuran custom.',
                ])
                ->withInput();
        }

        // Periksa ketersediaan warna.
        $color = $validated['color'] ?? null;

        if (
            $color
            && !empty($service->available_colors)
            && !in_array($color, $service->available_colors, true)
        ) {
            return back()
                ->withErrors([
                    'color' => 'Warna yang dipilih tidak tersedia.',
                ])
                ->withInput();
        }

        $sizeType = $validated['size_type'];

        $sizeLabel = $sizeType === 'standard'
            ? $validated['size_label']
            : 'Custom';

        $measurements = $sizeType === 'custom'
            ? $validated['custom_measurements']
            : null;

        // Identitas variasi produk agar ukuran/warna berbeda
        // disimpan sebagai item keranjang terpisah.
        $identity = [
            $service->id,
            $color,
            $sizeType,
            $sizeLabel,
            $measurements,
        ];

        $key = sha1(json_encode($identity));

        $cart = session()->get('cart', []);

        $quantity = (int) $validated['quantity'];

        if (isset($cart[$key])) {
            $newQuantity = $cart[$key]['quantity'] + $quantity;

            if ($newQuantity > 20) {
                return back()
                    ->withErrors([
                        'quantity' => 'Maksimal 20 produk untuk satu variasi.',
                    ])
                    ->withInput();
            }

            $cart[$key]['quantity'] = $newQuantity;
        } else {
            $image = $service->image_path;

            if ($image && !str_starts_with($image, 'http')) {
                $image = asset('storage/' . $image);
            }

            $cart[$key] = [
                'service_id' => $service->id,
                'name' => $service->name,
                'price' => (float) $service->price,
                'image' => $image,
                'quantity' => $quantity,
                'color' => $color,
                'size_type' => $sizeType,
                'size_label' => $sizeLabel,
                'custom_measurements' => $measurements,
            ];
        }

        session()->put('cart', $cart);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    /**
     * Memperbarui jumlah produk.
     */
    public function update(Request $request, string $key)
    {
        $validated = $request->validate([
            'quantity' => [
                'required',
                'integer',
                'min:1',
                'max:20',
            ],
        ]);

        $cart = session()->get('cart', []);

        abort_unless(isset($cart[$key]), 404);

        $cart[$key]['quantity'] = (int) $validated['quantity'];

        session()->put('cart', $cart);

        return back()->with(
            'success',
            'Jumlah produk berhasil diperbarui.'
        );
    }

    /**
     * Menghapus produk dari keranjang.
     */
    public function destroy(string $key)
    {
        $cart = session()->get('cart', []);

        abort_unless(isset($cart[$key]), 404);

        unset($cart[$key]);

        session()->put('cart', $cart);

        return back()->with(
            'success',
            'Produk berhasil dihapus dari keranjang.'
        );
    }
}
