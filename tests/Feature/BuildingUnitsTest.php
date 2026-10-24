<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Property;
use App\Models\PropertyCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BuildingUnitsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_add_an_apartment_and_customers_find_it_from_the_building_page(): void
    {
        $category = PropertyCategory::create(['name_ar' => 'سكني', 'name_en' => 'Residential']);
        $otherCategory = PropertyCategory::create(['name_ar' => 'تجاري', 'name_en' => 'Commercial']);
        $building = Property::create([
            'category_id' => $category->id,
            'is_building' => true,
            'name_ar' => 'عمارة النخيل',
            'name_en' => 'Palm Building',
        ]);
        $admin = Admin::create([
            'username' => 'building-manager',
            'name' => 'Building Manager',
            'password' => 'test-password',
        ]);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.properties.units', $building))
            ->assertOk()
            ->assertSee('إضافة شقة');

        $this->post(route('admin.properties.units.store', $building), [
            'category_id' => $otherCategory->id,
            'name_ar' => 'شقة الدور الثاني',
            'name_en' => 'Second Floor Apartment',
            'area_ar' => '١٢٠ متر',
            'area_en' => '120 sqm',
        ])->assertRedirect(route('admin.properties.units', $building));

        $unit = Property::where('building_id', $building->id)->firstOrFail();
        $this->assertSame($category->id, $unit->category_id);
        $this->assertFalse($unit->is_building);

        $this->get(route('front.building.details', $building))
            ->assertOk()
            ->assertSee('شقة الدور الثاني');

        $this->get(route('front.property.details', $building))
            ->assertRedirect(route('front.building.details', $building));

        $legacyBuilding = Property::create([
            'category_id' => $category->id,
            'is_building' => false,
            'name_ar' => 'عمارة قديمة',
            'name_en' => 'Legacy Building',
        ]);

        $this->get(route('front.property.details', $legacyBuilding))
            ->assertRedirect(route('front.building.details', $legacyBuilding));

        $this->get(route('front.properties'))
            ->assertOk()
            ->assertSee('عمارة النخيل')
            ->assertDontSee('شقة الدور الثاني');

        $this->get(route('front.property.details', $unit))
            ->assertOk()
            ->assertSee('property-main', false);
    }
}
