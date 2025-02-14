<div class="p-4">
    <h2 class="text-lg font-bold mb-4">Manage Coupons</h2>

    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="mb-4 text-green-500">{{ session('message') }}</div>
    @endif

    <!-- Coupon Form -->
    <div class="mb-4 flex">
        <input type="text" wire:model="code" class="border p-2 w-1/4" placeholder="Coupon Code">
        <select wire:model="discount_type" class="border p-2 w-1/4">
            <option value="fixed">Fixed Amount</option>
            <option value="percentage">Percentage</option>
        </select>
        <input type="number" wire:model="discount_value" class="border p-2 w-1/4" placeholder="Discount Value">
        <input type="number" wire:model="minimum_order_amount" class="border p-2 w-1/4" placeholder="Min Order Amount">
        <input type="date" wire:model="expires_at" class="border p-2 w-1/4">
        <button wire:click="{{ $editingId ? 'updateCoupon' : 'addCoupon' }}" class="bg-blue-500 text-white px-4 py-2 ml-2">
            {{ $editingId ? 'Update' : 'Add' }}
        </button>
    </div>

    <!-- Coupons Table -->
    <table class="w-full border">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2 border">Code</th>
                <th class="p-2 border">Type</th>
                <th class="p-2 border">Value</th>
                <th class="p-2 border">Min Order</th>
                <th class="p-2 border">Expires At</th>
                <th class="p-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($coupons as $coupon)
            <tr>
                <td class="p-2 border">{{ $coupon->code }}</td>
                <td class="p-2 border">{{ ucfirst($coupon->discount_type) }}</td>
                <td class="p-2 border">
                    {{ $coupon->discount_type === 'percentage' ? $coupon->discount_value.'%' : '$'.$coupon->discount_value }}
                </td>
                <td class="p-2 border">${{ $coupon->minimum_order_amount ?? 'N/A' }}</td>
                <td class="p-2 border">{{ $coupon->expires_at ? \Carbon\Carbon::parse($coupon->expires_at)->format('d M, Y') : 'No Expiry' }}</td>
                <td class="p-2 border">
                    <button wire:click="editCoupon({{ $coupon->id }})" class="bg-yellow-500 text-white px-2 py-1">Edit</button>
                    <button wire:click="deleteCoupon({{ $coupon->id }})" class="bg-red-500 text-white px-2 py-1">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
