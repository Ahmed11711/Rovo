<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class RestaurantScope implements Scope
{

    public function apply(Builder $builder, Model $model)
    {

        // Check if model has restaurant method which comes from HasRestaurant Trait.
        // If that has method then it has restaurant otherwise it do not have restaurant id
        // and we can simply return from here
        if (!method_exists($model, 'restaurant')) {
            return $builder;
        }

        // When user is logged in
        // auth()->user() do not work in apply so we have use auth()->hasUser()
        if (auth()->hasUser()) {

            $restaurant = restaurant();

            // We are not checking if table has restaurant_id or not to avoid extra queries.
            // We need to be extra careful with migrations we have created. For all the migration when doing something with update
            // we need to add withoutGlobalScope(RestaurantScope::class)
            // Otherwise we will get the error of restaurant_id not found when application is updating or modules are installing

            if ($restaurant) {
                $builder->where($model->getTable() . '.restaurant_id', '=', $restaurant->id);
            }
        }
    }
}
