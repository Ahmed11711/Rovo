<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\Table;

class ShopController extends Controller
{
    /**
     * Get the branch for the shop based on request or default to first branch
     */
    private function getShopBranch(Restaurant $restaurant): Branch
    {
        if (request()->filled('branch')) {
            return Branch::withoutGlobalScopes()->find(request('branch'));
        }

        return $restaurant->branches->first();
    }

    /**
     * Get enabled package modules and features for the restaurant
     */
    private function getPackageModules(?Restaurant $restaurant): array
    {
        if (!$restaurant?->package) {
            return [];
        }

        $modules = $restaurant->package->modules->pluck('name')->toArray();
        $additionalFeatures = json_decode($restaurant->package->additional_features ?? '[]', true);

        return array_merge($modules, $additionalFeatures);
    }

    /**
     * Show shopping cart page
     */
    public function cart(string $hash)
    {
        $restaurant = Restaurant::with('currency')->where('hash', $hash)->firstOrFail();
        $shopBranch = $this->getShopBranch($restaurant);

        $packageModules = $this->getPackageModules($restaurant);

        $this->redirectIfSubdomainIsEnabled($restaurant);

        return view('shop.index', [
            'restaurant' => $restaurant,
            'shopBranch' => $shopBranch,
            'getTable' => $restaurant->table_required,
            'canCreateOrder' => in_array('Order', $packageModules)
        ]);
    }

    /**
     * Show order success page
     */
    public function orderSuccess(string $id)
    {
        $order = Order::withoutGlobalScopes()->findOrFail($id);
        $shopBranch = request()->filled('branch')
            ? Branch::withoutGlobalScopes()->find(request('branch'))
            : $order->branch;

        return view('shop.order_success', [
            'restaurant' => $order->branch->restaurant,
            'id' => $id,
            'shopBranch' => $shopBranch
        ]);
    }

    /**
     * Show table booking page
     */
    public function bookTable(string $hash)
    {
        $restaurant = Restaurant::with('currency')->where('hash', $hash)->firstOrFail();
        $shopBranch = $this->getShopBranch($restaurant);
        $packageModules = $this->getPackageModules($restaurant);

        $this->redirectIfSubdomainIsEnabled($restaurant);

        abort_if(!in_array('Table Reservation', $packageModules), 403);

        return view('shop.book_a_table', compact('restaurant', 'shopBranch'));
    }

    /**
     * Show user's bookings page
     */
    public function myBookings(string $hash)
    {
        $restaurant = Restaurant::with('currency')->where('hash', $hash)->firstOrFail();
        $shopBranch = $this->getShopBranch($restaurant);
        $packageModules = $this->getPackageModules($restaurant);

        $this->redirectIfSubdomainIsEnabled($restaurant);

        abort_if(!in_array('Table Reservation', $packageModules), 403);

        return view('shop.bookings', compact('restaurant', 'shopBranch'));
    }

    /**
     * Show user profile page
     */
    public function profile(string $hash)
    {
        $restaurant = Restaurant::with('currency')->where('hash', $hash)->firstOrFail();
        $shopBranch = $this->getShopBranch($restaurant);

        $this->redirectIfSubdomainIsEnabled($restaurant);

        return view('shop.profile', compact('restaurant', 'shopBranch'));
    }

    /**
     * Show user's orders page
     */
    public function myOrders(string $hash)
    {
        $restaurant = Restaurant::with('currency')->where('hash', $hash)->firstOrFail();
        $shopBranch = $this->getShopBranch($restaurant);

        $this->redirectIfSubdomainIsEnabled($restaurant);

        return view('shop.orders', compact('restaurant', 'shopBranch'));
    }

    /**
     * Show about page
     */
    public function about(string $hash)
    {
        $restaurant = Restaurant::with('currency')->where('hash', $hash)->firstOrFail();
        $shopBranch = $this->getShopBranch($restaurant);

        $this->redirectIfSubdomainIsEnabled($restaurant);

        return view('shop.about', compact('restaurant', 'shopBranch'));
    }

    /**
     * Show contact page
     */
    public function contact(string $hash)
    {
        $restaurant = Restaurant::with('currency')->where('hash', $hash)->firstOrFail();
        $shopBranch = $this->getShopBranch($restaurant);

        $this->redirectIfSubdomainIsEnabled($restaurant);

        return view('shop.contact', compact('restaurant', 'shopBranch'));
    }

    /**
     * Show table order page
     */
    public function tableOrder(string $hash)
    {
        $table = Table::where('hash', $hash)->first();

        if ($table) {
            $shopBranch = $table->branch;
            $restaurant = $table->branch->restaurant->load('currency');
            $getTable = false;
        } else {
            $restaurant = Restaurant::with('currency')->where('id', $hash)->firstOrFail();
            $shopBranch = $this->getShopBranch($restaurant);
            $hash = null;
            $getTable = true;
        }

        $this->redirectIfSubdomainIsEnabled($restaurant);

        $packageModules = $this->getPackageModules($restaurant);

        return view('shop.index', [
            'tableHash' => $hash,
            'restaurant' => $restaurant,
            'shopBranch' => $shopBranch,
            'getTable' => $getTable,
            'canCreateOrder' => in_array('Order', $packageModules)
        ]);
    }

    /**
     * Redirect to subdomain if enabled
     */
    public function redirectIfSubdomainIsEnabled(Restaurant $restaurant): ?object
    {
        if (!module_enabled('Subdomain')) {
            return null;
        }

        $restaurantDomain = getRestaurantBySubDomain();

        if (is_null($restaurantDomain)) {
            return redirect()
                ->to('https://' . $restaurant->sub_domain . request()->getRequestUri())
                ->send();
        }

        return null;
    }
}
