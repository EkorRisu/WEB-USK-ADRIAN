<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\TransactionItem;

class PaymentController extends Controller
{
    public function processCheckout(Request $request)
    {
        $request->validate([
            'alamat' => 'required|string|max:255',
            'telepon' => 'required|string|max:15',
            'metode_pembayaran' => 'required|string',
            'items' => 'required|array', // Pastikan items adalah array
            'items.*.produk_id' => 'required|exists:produks,id', // Validasi setiap produk_id
            'items.*.jumlah' => 'required|integer|min:1', // Validasi jumlah
        ]);

        $user = Auth::user();
        $cartItems = $user->cart; // Corrected variable name

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang belanja Anda kosong.');
        }

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Buat transaksi baru
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'alamat_pengiriman' => $request->alamat,
                'telepon_penerima' => $request->telepon,
                'metode_pembayaran' => $request->metode_pembayaran,
                'total_harga' => 0, // Akan dihitung dalam loop
            ]);

            $totalHarga = 0;

            foreach ($request->items as $item) {
                $produk = Produk::find($item['produk_id']);

                if (!$produk || $produk->stok < $item['jumlah']) {
                    DB::rollBack();
                    return back()->with('error', 'Stok tidak mencukupi untuk ' . $produk->nama);
                }

                // Kurangi stok produk
                $produk->stok -= $item['jumlah'];
                $produk->save();

                // Simpan detail item transaksi
                $transaction->items()->create([
                    'produk_id' => $produk->id,
                    'jumlah' => $item['jumlah'],
                    'harga' => $produk->harga, // Ambil harga dari model Produk untuk mencegah manipulasi
                ]);

                $totalHarga += ($produk->harga * $item['jumlah']);
            }

            // Update total harga pada transaksi
            $transaction->total_harga = $totalHarga;
            $transaction->save();

            // Hapus item dari keranjang setelah berhasil checkout
            $user->cart()->delete();

            // Commit transaksi jika semua berhasil
            DB::commit();

            return redirect()->route('orders.index')->with('success', 'Checkout berhasil!');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat checkout. Silakan coba lagi.');
        }
    }
}
