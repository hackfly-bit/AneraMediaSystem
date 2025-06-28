<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected User $user;
    protected Client $client;
    protected Project $project;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $this->client = Client::factory()->create();
        $this->project = Project::factory()->create([
            'client_id' => $this->client->id,
            'budget' => 100000000
        ]);
    }

    public function test_user_can_view_invoice_index(): void
    {
        $this->actingAs($this->user)
            ->get(route('invoices.index'))
            ->assertStatus(200)
            ->assertViewIs('invoices.index');
    }

    public function test_user_can_create_invoice(): void
    {
        $invoiceData = [
            'client_id' => $this->client->id,
            'project_id' => $this->project->id,
            'invoice_number' => 'INV-TEST-001',
            'amount' => 50000000,
            'status' => 'pending',
            'issue_date' => now()->format('Y-m-d'),
            'due_date' => now()->addDays(30)->format('Y-m-d'),
            'payment_percentage' => 50,
            'payment_sequence' => 1,
            'notes' => 'Test invoice creation',
            'items' => [
                [
                    'description' => 'Development Services',
                    'quantity' => 1,
                    'unit_price' => 50000000
                ]
            ]
        ];

        $this->actingAs($this->user)
            ->post(route('invoices.store'), $invoiceData)
            ->assertRedirect(route('invoices.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('invoices', [
            'invoice_number' => 'INV-TEST-001',
            'amount' => 50000000,
            'payment_percentage' => 50,
            'payment_sequence' => 1,
            'currency' => 'IDR'
        ]);

        $this->assertDatabaseHas('invoice_items', [
            'description' => 'Development Services',
            'quantity' => 1,
            'unit_price' => 50000000
        ]);
    }

    public function test_invoice_validation_rules(): void
    {
        $this->actingAs($this->user)
            ->post(route('invoices.store'), [])
            ->assertSessionHasErrors([
                'client_id',
                'amount',
                'status',
                'issue_date',
                'due_date',
            ]);
    }

    public function test_user_can_view_invoice(): void
    {
        $invoice = Invoice::factory()->create([
            'client_id' => $this->client->id,
            'project_id' => $this->project->id
        ]);

        $this->actingAs($this->user)
            ->get(route('invoices.show', $invoice))
            ->assertStatus(200)
            ->assertViewIs('invoices.show')
            ->assertViewHas('invoice', $invoice);
    }

    public function test_user_can_update_invoice(): void
    {
        $invoice = Invoice::factory()->create([
            'client_id' => $this->client->id,
            'project_id' => $this->project->id,
            'status' => 'pending'
        ]);

        $updateData = [
            'client_id' => $this->client->id,
            'project_id' => $this->project->id,
            'invoice_number' => $invoice->invoice_number,
            'amount' => 75000000,
            'tax_rate' => 11,
            'status' => 'paid',
            'issue_date' => $invoice->issue_date->format('Y-m-d'),
            'due_date' => $invoice->due_date->format('Y-m-d'),
            'paid_date' => now()->format('Y-m-d'),
            'payment_percentage' => 100,
            'payment_sequence' => 1,
            'notes' => 'Updated invoice',
            'items' => [
                [
                    'description' => 'Updated Development Services',
                    'quantity' => 1,
                    'unit_price' => 75000000
                ]
            ]
        ];

        $this->actingAs($this->user)
            ->put(route('invoices.update', $invoice), $updateData)
            ->assertRedirect(route('invoices.show', $invoice))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'amount' => 75000000,
            'status' => 'paid'
        ]);
    }

    public function test_user_can_delete_invoice(): void
    {
        $invoice = Invoice::factory()->create([
            'client_id' => $this->client->id,
            'project_id' => $this->project->id
        ]);

        $this->actingAs($this->user)
            ->delete(route('invoices.destroy', $invoice))
            ->assertRedirect(route('invoices.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('invoices', [
            'id' => $invoice->id
        ]);
    }

    public function test_invoice_calculates_tax_automatically(): void
    {
        $invoiceData = [
            'client_id' => $this->client->id,
            'project_id' => $this->project->id,
            'invoice_number' => 'INV-TAX-001',
            'amount' => 100000000,
            'tax_rate' => 11,
            'status' => 'pending',
            'issue_date' => now()->format('Y-m-d'),
            'due_date' => now()->addDays(30)->format('Y-m-d'),
            'payment_percentage' => 100,
            'payment_sequence' => 1,
            'items' => [
                [
                    'description' => 'Development Services',
                    'quantity' => 1,
                    'unit_price' => 100000000
                ]
            ]
        ];

        $this->actingAs($this->user)
            ->post(route('invoices.store'), $invoiceData);

        $invoice = Invoice::where('invoice_number', 'INV-TAX-001')->first();
        
        $this->assertEquals(11000000, $invoice->tax_amount); // 11% of 100M
        $this->assertEquals(111000000, $invoice->total_amount); // 100M + 11M
    }

    public function test_invoice_status_indonesian_accessor(): void
    {
        $paidInvoice = Invoice::factory()->create(['status' => 'paid']);
        $pendingInvoice = Invoice::factory()->create(['status' => 'pending']);
        $overdueInvoice = Invoice::factory()->create(['status' => 'overdue']);

        $this->assertEquals('Lunas', $paidInvoice->status_indonesian);
        $this->assertEquals('Tertunda', $pendingInvoice->status_indonesian);
        $this->assertEquals('Terlambat', $overdueInvoice->status_indonesian);
    }

    public function test_invoice_formatted_currency_accessor(): void
    {
        $invoice = Invoice::factory()->create([
            'total_amount' => 50000000,
            'currency' => 'IDR'
        ]);

        $this->assertEquals('Rp 50.000.000', $invoice->formatted_total);
    }

    public function test_invoice_overdue_scope(): void
    {
        Invoice::factory()->create([
            'status' => 'overdue',
            'due_date' => now()->subDays(5)
        ]);
        
        Invoice::factory()->create([
            'status' => 'pending',
            'due_date' => now()->addDays(5)
        ]);

        $overdueInvoices = Invoice::overdue()->get();
        
        $this->assertCount(1, $overdueInvoices);
    }

    public function test_invoice_due_soon_scope(): void
    {
        Invoice::factory()->create([
            'status' => 'pending',
            'due_date' => now()->addDays(2)
        ]);
        
        Invoice::factory()->create([
            'status' => 'pending',
            'due_date' => now()->addDays(10)
        ]);

        $dueSoonInvoices = Invoice::dueSoon()->get();
        
        $this->assertCount(1, $dueSoonInvoices);
    }
}