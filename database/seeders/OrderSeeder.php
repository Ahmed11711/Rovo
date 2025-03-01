<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Kot;
use App\Models\KotItem;
use App\Models\MenuItem;
use App\Models\OnboardingStep;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderTax;
use App\Models\Payment;
use App\Models\Table;
use App\Models\Tax;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run($branch): void
    {
        $this->submitCustomerName($branch);

        OnboardingStep::where('branch_id', $branch->id)->update([
            'add_area_completed' => 1,
            'add_table_completed' => 1,
            'add_menu_completed' => 1,
            'add_menu_items_completed' => 1
        ]);
    }

    public function submitCustomerName($branch)
    {
        for ($i = 0; $i < 11; $i++) {
            $customer = new Customer();
            $customer->restaurant_id = $branch->restaurant_id;
            $customer->name = fake()->name();
            $customer->email = fake()->unique()->safeEmail();
            $customer->delivery_address = fake()->address();
            $customer->save();

            $this->placeOrder($customer, $branch);
        }
    }

    public function placeOrder($customer, $branch)
    {
        $table = Table::inRandomOrder()->where('branch_id', $branch->id)->first();
        $waiter = User::inRandomOrder()->where('branch_id', $branch->id)->first();
        $orderNumber = Order::where('branch_id', $branch->id)->max('id') + 1;

        $order = Order::create([
            'order_number' => $orderNumber,
            'table_id' => $table->id,
            'customer_id' => $customer->id,
            'waiter_id' => $waiter->id,
            'date_time' => now()->subDays(rand(0, 3))->toDateTimeString(),
            'sub_total' => 0,
            'total' => 0,
            'status' => 'draft',
            'branch_id' => $branch->id
        ]);

        $kot = Kot::create([
            'kot_number' => (Kot::max('id') + 1),
            'order_id' => $order->id,
            'branch_id' => $branch->id
        ]);

        $orderItemList = MenuItem::inRandomOrder()->where('branch_id', $branch->id)->limit(rand(1, 5))->get();

        foreach ($orderItemList as $value) {
            $quantity = rand(1, 3);

            KotItem::create([
                'kot_id' => $kot->id,
                'menu_item_id' => $value->id,
                'menu_item_variation_id' => null,
                'quantity' => $quantity
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'menu_item_id' => $value->id,
                'menu_item_variation_id' => null,
                'quantity' => $quantity,
                'price' => $value->price,
                'amount' => ($quantity * $value->price),
                'branch_id' => $branch->id
            ]);
        }

        $taxes = Tax::all();

        foreach ($taxes as $value) {
            OrderTax::create([
                'order_id' => $order->id,
                'tax_id' => $value->id
            ]);
        }

        $total = 0;
        $subTotal = 0;

        foreach ($order->load('items')->items as $value) {
            $subTotal = ($subTotal + $value->amount);
            $total = ($total + $value->amount);
        }

        foreach ($taxes as $value) {
            $total = ($total + (($value->tax_percent / 100) * $subTotal));
        }

        $total = round($total);

        Order::where('id', $order->id)->update([
            'sub_total' => $subTotal,
            'total' => $total
        ]);

        $paymentMethod = ['card', 'cash', 'upi'];

        Payment::create([
            'order_id' => $order->id,
            'payment_method' => $paymentMethod[array_rand($paymentMethod)],
            'amount' => $total,
            'branch_id' => $branch->id
        ]);

        Order::where('id', $order->id)->update([
            'status' => 'paid'
        ]);
    }
}
