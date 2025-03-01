<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\ItemCategory;
use App\Models\ModifierGroup;
use App\Models\ModifierOption;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MenuItemSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run($branch): void
    {
        $branchId = $branch->id;

        $itemCategory1 = new ItemCategory();
        $itemCategory1->category_name = 'Starters';
        $itemCategory1->branch_id = $branchId;
        $itemCategory1->saveQuietly();

        $itemCategory2 = new ItemCategory();
        $itemCategory2->category_name = 'Main Course';
        $itemCategory2->branch_id = $branchId;
        $itemCategory2->saveQuietly();

        $itemCategory4 = new ItemCategory();
        $itemCategory4->category_name = 'Breads';
        $itemCategory4->branch_id = $branchId;
        $itemCategory4->saveQuietly();

        $itemCategory5 = new ItemCategory();
        $itemCategory5->category_name = 'Rice';
        $itemCategory5->branch_id = $branchId;
        $itemCategory5->saveQuietly();

        $itemCategory6 = new ItemCategory();
        $itemCategory6->category_name = 'Desserts';
        $itemCategory6->branch_id = $branchId;
        $itemCategory6->saveQuietly();

        $itemCategory7 = new ItemCategory();
        $itemCategory7->category_name = 'Beverages';
        $itemCategory7->branch_id = $branchId;
        $itemCategory7->saveQuietly();

        $itemCategory8 = new ItemCategory();
        $itemCategory8->category_name = 'Salads';
        $itemCategory8->branch_id = $branchId;
        $itemCategory8->saveQuietly();

        $itemCategory9 = new ItemCategory();
        $itemCategory9->category_name = 'Soups';
        $itemCategory9->branch_id = $branchId;
        $itemCategory9->saveQuietly();

        $itemCategory10 = new ItemCategory();
        $itemCategory10->category_name = 'Sides';
        $itemCategory10->branch_id = $branchId;
        $itemCategory10->saveQuietly();

        $itemCategory11 = new ItemCategory();
        $itemCategory11->category_name = 'Snacks';
        $itemCategory11->branch_id = $branchId;
        $itemCategory11->saveQuietly();

        $itemCategory12 = new ItemCategory();
        $itemCategory12->category_name = 'Fast Food';
        $itemCategory12->branch_id = $branchId;
        $itemCategory12->saveQuietly();

        $itemCategory13 = new ItemCategory();
        $itemCategory13->category_name = 'Smoothies';
        $itemCategory13->branch_id = $branchId;
        $itemCategory13->saveQuietly();

        $itemCategory14 = new ItemCategory();
        $itemCategory14->category_name = 'Juices';
        $itemCategory14->branch_id = $branchId;
        $itemCategory14->saveQuietly();
        
        

        $menu1 = new Menu();
        $menu1->menu_name = 'North Indian Delights';
        $menu1->branch_id = $branchId;
        $menu1->saveQuietly();

        $menuItems1 = [
            [
                'item_name' => 'Butter Chicken',
                'menu_id' => $menu1->id,
                'type' => MenuItem::NONVEG,
                'price' => 320,
                'item_category_id' => $itemCategory2->id,
                'image' => 'butter-chicken.jpg',
                'description' => 'Tender chicken cooked in a rich tomato and butter gravy.',
                'preparation_time' => rand(10, 30),
                'branch_id' => $branchId,
            ],
            [
                'item_name' => 'Paneer Tikka',
                'menu_id' => $menu1->id,
                'type' => MenuItem::VEG,
                'price' => 250,
                'item_category_id' => $itemCategory1->id,
                'image' => 'paneer-tikka.jpg',
                'description' => 'Grilled cottage cheese marinated in spicy yogurt.',
                'preparation_time' => rand(10, 30),
                'branch_id' => $branchId,
            ],
            [
                'item_name' => 'Dal Makhani',
                'menu_id' => $menu1->id,
                'type' => MenuItem::VEG,
                'price' => 180,
                'item_category_id' => $itemCategory2->id,
                'image' => 'dal-makhni.jpg',
                'description' => 'Creamy and rich black lentils cooked with butter and spices.',
                'preparation_time' => rand(10, 30),
                'branch_id' => $branchId,
            ],
            [
                'item_name' => 'Tandoori Roti',
                'menu_id' => $menu1->id,
                'type' => MenuItem::VEG,
                'price' => 25,
                'item_category_id' => $itemCategory4->id,
                'image' => 'tandoori-roti.jpg',
                'description' => 'Traditional whole wheat bread cooked in a clay oven.',
                'preparation_time' => rand(10, 30),
                'branch_id' => $branchId,
            ],
            [
                'item_name' => 'Naan',
                'menu_id' => $menu1->id,
                'type' => MenuItem::VEG,
                'price' => 40,
                'item_category_id' => $itemCategory4->id,
                'image' => 'naan-recipe.jpg',
                'description' => 'Soft and fluffy bread baked in a tandoor.',
                'preparation_time' => rand(10, 30),
                'branch_id' => $branchId,
            ],
        ];

        $menu2 = new Menu();
        $menu2->menu_name = 'South Indian Sensations';
        $menu2->branch_id = $branchId;
        $menu2->saveQuietly();

        $menuItems2 = [
            [
                'item_name' => 'Masala Dosa',
                'menu_id' => $menu2->id,
                'type' => MenuItem::VEG,
                'price' => 120,
                'item_category_id' => $itemCategory2->id,
                'image' => 'masala-dosa.jpg',
                'description' => 'Crispy rice and lentil crepe filled with spiced mashed potatoes.',
                'preparation_time' => rand(10, 30),
                'branch_id' => $branchId,
            ],
            [
                'item_name' => 'Idli Sambar',
                'menu_id' => $menu2->id,
                'type' => MenuItem::VEG,
                'price' => 90,
                'item_category_id' => $itemCategory2->id,
                'image' => 'idli-sambar.jpg',
                'description' => 'Steamed rice cakes served with lentil soup and chutney.',
                'preparation_time' => rand(10, 30),
                'branch_id' => $branchId,
            ],
            [
                'item_name' => 'Medu Vada',
                'menu_id' => $menu2->id,
                'type' => MenuItem::VEG,
                'price' => 80,
                'item_category_id' => $itemCategory1->id,
                'image' => 'medu-vada.jpg',
                'description' => 'Crispy lentil fritters with chutney and sambar.',
                'preparation_time' => rand(10, 30),
                'branch_id' => $branchId,
            ],
            [
                'item_name' => 'Uttapam',
                'menu_id' => $menu2->id,
                'type' => MenuItem::VEG,
                'price' => 130,
                'item_category_id' => $itemCategory2->id,
                'image' => 'uttapam.webp',
                'description' => 'Thick rice and lentil pancake topped with onions and tomatoes.',
                'preparation_time' => rand(10, 30),
                'branch_id' => $branchId,
            ],
            [
                'item_name' => 'Hyderabadi Chicken Biryani',
                'menu_id' => $menu2->id,
                'type' => MenuItem::NONVEG,
                'price' => 300,
                'item_category_id' => $itemCategory5->id,
                'image' => 'chicken-hyderabadi-biryani.jpg',
                'description' => 'Fragrant rice cooked with tender meat and aromatic spices.',
                'preparation_time' => rand(10, 30),
                'branch_id' => $branchId,
            ],
        ];

        $menu3 = new Menu();
        $menu3->menu_name = 'Indo-Chinese Fusion';
        $menu3->branch_id = $branchId;
        $menu3->saveQuietly();

        $menuItems3 = [
            [
                'item_name' => 'Chicken Manchurian',
                'menu_id' => $menu3->id,
                'type' => MenuItem::NONVEG,
                'price' => 260,
                'item_category_id' => $itemCategory2->id,
                'image' => 'chicken-manchurian.webp',
                'description' => 'Juicy chicken balls in a tangy Manchurian sauce.',
                'preparation_time' => rand(10, 30),
                'branch_id' => $branchId,
            ],
            [
                'item_name' => 'Vegetable Hakka Noodles',
                'menu_id' => $menu3->id,
                'type' => MenuItem::VEG,
                'price' => 180,
                'item_category_id' => $itemCategory2->id,
                'image' => 'vegetable-hakka-noodles.jpeg',
                'description' => 'Stir-fried noodles with a mix of vegetables in a savory sauce.',
                'preparation_time' => rand(10, 30),
                'branch_id' => $branchId,
            ],
            [
                'item_name' => 'Chilli Paneer',
                'menu_id' => $menu3->id,
                'type' => MenuItem::VEG,
                'price' => 240,
                'item_category_id' => $itemCategory2->id,
                'image' => 'chilli-paneer.jpg',
                'description' => 'Spicy cottage cheese cubes tossed in a tangy Indo-Chinese sauce.',
                'preparation_time' => rand(10, 30),
                'branch_id' => $branchId,
            ],
            [
                'item_name' => 'Spring Rolls',
                'menu_id' => $menu2->id,
                'type' => MenuItem::VEG,
                'price' => 150,
                'item_category_id' => $itemCategory1->id,
                'image' => 'spring-rolls.jpg',
                'description' => 'Crispy rolls stuffed with a mix of vegetables and served with tangy dip.',
                'preparation_time' => rand(10, 30),
                'branch_id' => $branchId,
            ],
            [
                'item_name' => 'Veg Manchow Soup',
                'menu_id' => $menu3->id,
                'type' => MenuItem::VEG,
                'price' => 120,
                'item_category_id' => $itemCategory1->id,
                'image' => 'vegetable-manchow-soup.jpg',
                'description' => 'Spicy vegetable soup with crispy fried noodles.',
                'preparation_time' => rand(10, 30),
                'branch_id' => $branchId,
            ],
        ];

        MenuItem::insert($menuItems1);
        MenuItem::insert($menuItems2);
        MenuItem::insert($menuItems3);

        // Create Modifier Groups
        $modifierGroup1 = new ModifierGroup();
        $modifierGroup1->name = 'Extra Toppings';
        $modifierGroup1->branch_id = $branchId;
        $modifierGroup1->saveQuietly();

        $modifierGroup2 = new ModifierGroup();
        $modifierGroup2->name = 'Dips & Sauces';
        $modifierGroup2->branch_id = $branchId;
        $modifierGroup2->saveQuietly();

        $modifiers1 = [
            [
                'name' => 'Extra Paneer',
                'modifier_group_id' => $modifierGroup1->id,
                'price' => 1.50,
                'is_available' => 1,
            ],
            [
                'name' => 'Shredded Cheese',
                'modifier_group_id' => $modifierGroup1->id,
                'price' => 1.00,
                'is_available' => 1,
            ],
            [
                'name' => 'Caramelized Onions',
                'modifier_group_id' => $modifierGroup1->id,
                'price' => 0.75,
                'is_available' => 1,
            ],
            [
                'name' => 'Grilled Mushrooms',
                'modifier_group_id' => $modifierGroup1->id,
                'price' => 1.25,
                'is_available' => 1,
            ],
        ];

        ModifierOption::insert($modifiers1);

        $modifiers2 = [
            [
                'name' => 'Garlic Aioli',
                'modifier_group_id' => $modifierGroup2->id,
                'price' => 0.50,
                'is_available' => 1,
            ],
            [
                'name' => 'Spicy Mayo',
                'modifier_group_id' => $modifierGroup2->id,
                'price' => 0.50,
                'is_available' => 1,
            ],
            [
                'name' => 'Mint Chutney',
                'modifier_group_id' => $modifierGroup2->id,
                'price' => 0.75,
                'is_available' => 1,
            ],
            [
                'name' => 'Tamarind Sauce',
                'modifier_group_id' => $modifierGroup2->id,
                'price' => 0.75,
                'is_available' => 1,
            ],
        ];

        ModifierOption::insert($modifiers2);

        $menuItems = MenuItem::whereIn('item_name', ['Paneer Tikka', 'Uttapam'])
            ->where('branch_id', $branchId)
            ->get()
            ->keyBy('item_name');

        if (isset($menuItems['Uttapam'])) {
            $menuItems['Uttapam']->modifierGroups()->attach($modifierGroup2->id);
        }

        if (isset($menuItems['Paneer Tikka'])) {
            $menuItems['Paneer Tikka']->modifierGroups()->attach([
            $modifierGroup1->id,
            $modifierGroup2->id,
            ]);
        }
    }

}
