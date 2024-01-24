<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'name' => 'Fadiyah Irbati',
            'username' => 'fadiyaiu',
            'role' => 'siswa',
            'password' => Hash::make('fadiyah'),        
        ]);
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'role' => 'admin',
            'password' => Hash::make('fadiyah'),        
        ]);
        User::create([
            'name' => 'Kantin',
            'username' => 'kantin',
            'role' => 'kantin',
            'password' => Hash::make('fadiyah'),        
        ]);
        User::create([
            'name' => 'Bank',
            'username' => 'bank',
            'role' => 'bank',
            'password' => Hash::make('fadiyah'),        
        ]);

        Category::create([
            'name' => 'Minuman'
        ]);
        Category::create([
            'name' => 'Makanan'
        ]);
        Category::create([
            'name' => 'Cemilan'
        ]);

        Product::create([
            'name' => 'Esteh',
            'price' => 4000,
            'stock' => 100,
            'photo' =>  'images/esteh.png',
            'description' => 'Ini Esteh',
            'category_id' => 1
        ]);
        Product::create([
            'name' => 'Nasi Goreng',
            'price' => 10000,
            'stock' => 100,
            'photo' =>  'images/nasgor.png',
            'description' => 'Ini Nasgor',
            'category_id' => 2
        ]);
        Product::create([
            'name' => 'Pisang Goreng',
            'price' => 2000,
            'stock' => 100,
            'photo' =>  'images/pisgor.jpg',
            'description' => 'Ini Pisgor',
            'category_id' => 3
        ]);

        $total_debit = 0;

        $transactions = Transaction::where('order_id' == 'INV_12345');

        foreach($transactions as $transaction){
            $total_price = $transaction->price * $transaction->quantity;
            $total_debit += $total_price;
        }

        foreach($transactions as $transaction){
            Transaction::find($transaction->id)->update([
                'status' => 'di keranjang'
            ]);
        }
        foreach($transactions as $transaction){
            Transaction::find($transaction->id)->update([
                'status' => 'dibayar'
            ]);
        }
        foreach($transactions as $transaction){
            Transaction::find($transaction->id)->update([
                'status' => 'diambil'
            ]);
        }
    }
}
