<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'project_id' => 'nullable|exists:projects,id',
            'invoice_number' => 'nullable|string|unique:invoices,invoice_number',
            'amount' => 'required|numeric|min:0',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'tax_amount' => 'nullable|numeric|min:0',
            'total_amount' => 'nullable|numeric|min:0',
            'status' => ['required', Rule::in(['pending', 'paid', 'overdue'])],
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after:issue_date',
            'paid_date' => 'nullable|date',
            'notes' => 'nullable|string|max:1000',
            'payment_percentage' => 'nullable|numeric|min:1|max:100',
            'payment_sequence' => 'nullable|integer|min:1',
            
            // Invoice items validation
            'items' => 'nullable|array',
            'items.*.description' => 'required_with:items|string|max:255',
            'items.*.quantity' => 'required_with:items|integer|min:1',
            'items.*.unit_price' => 'required_with:items|numeric|min:0',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'client_id.required' => 'Klien harus dipilih.',
            'client_id.exists' => 'Klien yang dipilih tidak valid.',
            'project_id.exists' => 'Proyek yang dipilih tidak valid.',
            'invoice_number.unique' => 'Nomor invoice sudah digunakan.',
            'amount.required' => 'Jumlah invoice harus diisi.',
            'amount.numeric' => 'Jumlah invoice harus berupa angka.',
            'amount.min' => 'Jumlah invoice tidak boleh negatif.',
            'tax_rate.numeric' => 'Tarif pajak harus berupa angka.',
            'tax_rate.min' => 'Tarif pajak tidak boleh negatif.',
            'tax_rate.max' => 'Tarif pajak tidak boleh lebih dari 100%.',
            'status.required' => 'Status invoice harus dipilih.',
            'status.in' => 'Status invoice tidak valid.',
            'issue_date.required' => 'Tanggal terbit harus diisi.',
            'issue_date.date' => 'Tanggal terbit harus berupa tanggal yang valid.',
            'due_date.required' => 'Tanggal jatuh tempo harus diisi.',
            'due_date.date' => 'Tanggal jatuh tempo harus berupa tanggal yang valid.',
            'due_date.after' => 'Tanggal jatuh tempo harus setelah tanggal terbit.',
            'paid_date.date' => 'Tanggal pembayaran harus berupa tanggal yang valid.',
            'notes.max' => 'Catatan tidak boleh lebih dari 1000 karakter.',
            'payment_percentage.numeric' => 'Persentase pembayaran harus berupa angka.',
            'payment_percentage.min' => 'Persentase pembayaran minimal 1%.',
            'payment_percentage.max' => 'Persentase pembayaran maksimal 100%.',
            'payment_sequence.integer' => 'Urutan pembayaran harus berupa angka.',
            'payment_sequence.min' => 'Urutan pembayaran minimal 1.',
            
            // Invoice items messages
            'items.array' => 'Item invoice harus berupa array.',
            'items.*.description.required_with' => 'Deskripsi item harus diisi.',
            'items.*.description.string' => 'Deskripsi item harus berupa teks.',
            'items.*.description.max' => 'Deskripsi item tidak boleh lebih dari 255 karakter.',
            'items.*.quantity.required_with' => 'Kuantitas item harus diisi.',
            'items.*.quantity.integer' => 'Kuantitas item harus berupa angka bulat.',
            'items.*.quantity.min' => 'Kuantitas item minimal 1.',
            'items.*.unit_price.required_with' => 'Harga satuan item harus diisi.',
            'items.*.unit_price.numeric' => 'Harga satuan item harus berupa angka.',
            'items.*.unit_price.min' => 'Harga satuan item tidak boleh negatif.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'client_id' => 'klien',
            'project_id' => 'proyek',
            'invoice_number' => 'nomor invoice',
            'amount' => 'jumlah',
            'tax_rate' => 'tarif pajak',
            'tax_amount' => 'jumlah pajak',
            'total_amount' => 'total jumlah',
            'status' => 'status',
            'issue_date' => 'tanggal terbit',
            'due_date' => 'tanggal jatuh tempo',
            'paid_date' => 'tanggal pembayaran',
            'notes' => 'catatan',
            'payment_percentage' => 'persentase pembayaran',
            'payment_sequence' => 'urutan pembayaran',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Auto-calculate total amount if not provided
        if (!$this->has('total_amount') && $this->has('amount')) {
            $amount = (float) $this->input('amount', 0);
            $taxRate = (float) $this->input('tax_rate', 0);
            $taxAmount = $amount * ($taxRate / 100);
            $totalAmount = $amount + $taxAmount;
            
            $this->merge([
                'tax_amount' => $taxAmount,
                'total_amount' => $totalAmount,
            ]);
        }
    }
}