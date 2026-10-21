<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Inquiry;
use App\Models\Property;
use App\Models\PropertyCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InquiryManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_request_is_saved_for_the_admin_inbox(): void
    {
        $category = PropertyCategory::create(['name_ar' => 'سكني', 'name_en' => 'Residential']);
        $property = Property::create([
            'category_id' => $category->id,
            'name_ar' => 'عقار تجريبي',
            'name_en' => 'Test property',
        ]);

        $contactUrl = route('front.contact').'?property='.$property->id;
        $this->get($contactUrl)
            ->assertOk()
            ->assertSee('name="property_id"', false)
            ->assertSee('value="'.$property->id.'"', false)
            ->assertSee('name="preferred_visit_at"', false);

        $preferredVisitAt = now()->addDays(3)->startOfHour()->format('Y-m-d\\TH:i');

        $response = $this->from($contactUrl)->post(route('front.contact.submit'), [
            'name' => 'Test Client',
            'phone' => '01012345678',
            'interest' => 'buy',
            'message' => 'Looking for an apartment in Giza.',
            'property_id' => $property->id,
            'preferred_visit_at' => $preferredVisitAt,
            'preferred_location' => 'الهرم، الجيزة',
            'preferred_category_id' => $category->id,
            'budget_min' => 1000000,
            'budget_max' => 2000000,
            'area_min' => 100,
            'area_max' => 180,
        ]);

        $response->assertRedirect($contactUrl);
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('inquiries', [
            'name' => 'Test Client',
            'phone' => '01012345678',
            'interest' => 'buy',
            'status' => 'new',
            'locale' => 'ar',
            'property_id' => $property->id,
        ]);
        $this->assertDatabaseHas('inquiries', [
            'phone' => '01012345678',
            'preferred_visit_at' => str_replace('T', ' ', $preferredVisitAt).':00',
            'preferred_location' => 'الهرم، الجيزة',
            'preferred_category_id' => $category->id,
            'budget_min' => 1000000,
            'budget_max' => 2000000,
            'area_min' => 100,
            'area_max' => 180,
        ]);
    }

    public function test_properties_page_offers_area_filter_and_property_specific_viewing(): void
    {
        $category = PropertyCategory::create(['name_ar' => 'سكني', 'name_en' => 'Residential']);
        $property = Property::create([
            'category_id' => $category->id,
            'name_ar' => 'عقار تجريبي',
            'name_en' => 'Test property',
            'area_ar' => '١٢٠ م²',
            'area_en' => '120 sqm',
        ]);

        $this->get(route('front.properties'))
            ->assertOk()
            ->assertSee('id="areaMin"', false)
            ->assertSee('data-area="120"', false)
            ->assertSee('id="listingMatchBanner"', false)
            ->assertSee('data-lead-save-search', false)
            ->assertSee('data-lead-property-id="'.$property->id.'"', false)
            ->assertSee('حجز معاينة');

        $this->get(route('front.property.details', $property))
            ->assertOk()
            ->assertSee('shared-layout.css?v=', false)
            ->assertSee('data-lead-property', false)
            ->assertSee('value="'.$property->id.'"', false);
    }

    public function test_admin_can_move_an_inquiry_to_follow_up(): void
    {
        $admin = Admin::create([
            'username' => 'inquiry-manager',
            'name' => 'Inquiry Manager',
            'password' => 'test-password',
        ]);
        $inquiry = Inquiry::create([
            'name' => 'Test Client',
            'phone' => '01012345678',
            'status' => 'new',
            'locale' => 'ar',
        ]);

        $response = $this->actingAs($admin, 'admin')
            ->patch(route('admin.inquiries.status', $inquiry), ['status' => 'follow_up']);

        $response->assertRedirect();
        $this->assertDatabaseHas('inquiries', [
            'id' => $inquiry->id,
            'status' => 'follow_up',
        ]);
    }

    public function test_invalid_budget_range_is_rejected_without_saving_a_request(): void
    {
        $response = $this->from(route('front.contact'))->post(route('front.contact.submit'), [
            'name' => 'Test Client',
            'phone' => '01012345678',
            'interest' => 'buy',
            'budget_min' => 2000000,
            'budget_max' => 1000000,
        ]);

        $response->assertRedirect(route('front.contact'))
            ->assertSessionHasErrors('budget_max');
        $this->assertDatabaseCount('inquiries', 0);
    }

    public function test_dashboard_and_inquiry_inbox_show_saved_requests(): void
    {
        $admin = Admin::create([
            'username' => 'dashboard-manager',
            'name' => 'Dashboard Manager',
            'password' => 'test-password',
        ]);
        $category = PropertyCategory::create(['name_ar' => 'سكني', 'name_en' => 'Residential']);
        Inquiry::create([
            'name' => 'Inbox Client',
            'phone' => '01012345678',
            'status' => 'new',
            'locale' => 'ar',
            'preferred_location' => 'الهرم',
            'preferred_category_id' => $category->id,
            'budget_min' => 1200000,
            'area_max' => 160,
        ]);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('طلبات جديدة');

        $this->get(route('admin.inquiries.index'))
            ->assertOk()
            ->assertSee('Inbox Client')
            ->assertSee('طلبات التواصل')
            ->assertSee('احتياجات العميل')
            ->assertSee('الهرم')
            ->assertSee('1,200,000');
    }
}
