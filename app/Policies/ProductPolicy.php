<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // biar semua user bisa lihat list product
    }

    public function view(User $user, Product $product): bool
    {
        return true; // semua bisa lihat detail
    }

    public function create(User $user): bool
    {
        return true; // semua user boleh tambah product
    }

    public function update(User $user, Product $product): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        return $user->id === $product->user_id;
    }   

    public function delete(User $user, Product $product): bool
    {
        // kalau admin → boleh hapus semua
        if ($user->role === 'admin') {
            return true;
        }

        // kalau user biasa → hanya miliknya
        return $user->id === $product->user_id;
    }

    public function restore(User $user, Product $product): bool
    {
        return false;
    }

    public function forceDelete(User $user, Product $product): bool
    {
        return false;
    }
}