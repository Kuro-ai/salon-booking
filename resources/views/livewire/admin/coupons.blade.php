<div class="p-4 bg-white shadow-md rounded-lg">
    <h2 class="text-lg font-bold mb-4 text-gray-900">Manage Coupons</h2>

    <!-- Flash Message -->
    @if (session()->has('message'))
        <div class="bg-green-500 text-white p-3 mb-4 rounded">
            {{ session('message') }}
        </div>
    @endif

    <div class="mb-4">
        <input type="text" wire:model.live="search" class="border p-2 w-full rounded" placeholder="Search by coupon code...">
    </div>    

    <table class="w-full border border-gray-300">
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
            <!-- New Row for Adding a Coupon -->
            <tr class="hover:bg-gray-100 transition">
                <td class="p-2 border">
                    <input type="text" wire:model="code" class="border p-1 w-full" placeholder="Coupon Code">
                </td>
                <td class="p-2 border">
                    <select wire:model="discount_type" class="border p-1 w-full">
                        <option value="fixed">Fixed</option>
                        <option value="percentage">Percentage</option>
                    </select>
                </td>
                <td class="p-2 border">
                    <input type="number" min=0 wire:model="discount_value" class="border p-1 w-full" placeholder="Value">
                </td>
                <td class="p-2 border">
                    <input type="number" min=0 wire:model="minimum_order_amount" class="border p-1 w-full" placeholder="Min Order">
                </td>
                <td class="p-2 border">
                    <input type="date" wire:model="expires_at" class="border p-1 w-full" min="{{ \Carbon\Carbon::now()->toDateString() }}">
                </td>
                <td class="p-2 border">
                    <button wire:click="addCoupon" class="bg-green-500 text-white px-2 py-1 rounded">Save</button>
                </td>
            </tr>

            <!-- Existing Coupons -->
            @foreach($coupons as $coupon)
            <tr class="hover:bg-gray-100 transition">
                <td class="p-2 border">
                    @if ($editingId === $coupon->id)
                        <input type="text" wire:model="code" class="border p-1 w-full">
                    @else
                        {{ $coupon->code }}
                    @endif
                </td>
                <td class="p-2 border">
                    @if ($editingId === $coupon->id)
                        <select wire:model="discount_type" class="border p-1 w-full">
                            <option value="fixed">Fixed</option>
                            <option value="percentage">Percentage</option>
                        </select>
                    @else
                        {{ ucfirst($coupon->discount_type) }}
                    @endif
                </td>
                <td class="p-2 border">
                    @if ($editingId === $coupon->id)
                        <input type="number" wire:model="discount_value" class="border p-1 w-full">
                    @else
                        {{ $coupon->discount_type === 'percentage' ? $coupon->discount_value.'%' : '$'.$coupon->discount_value }}
                    @endif
                </td>
                <td class="p-2 border">
                    @if ($editingId === $coupon->id)
                        <input type="number" wire:model="minimum_order_amount" class="border p-1 w-full">
                    @else
                        ${{ $coupon->minimum_order_amount ?? 'N/A' }}
                    @endif
                </td>
                <td class="p-2 border">
                    @if ($editingId === $coupon->id)
                        <input type="date" wire:model="expires_at" class="border p-1 w-full" min="{{ \Carbon\Carbon::now()->toDateString() }}">
                    @else
                        {{ $coupon->expires_at ? \Carbon\Carbon::parse($coupon->expires_at)->format('d M, Y') : 'No Expiry' }}
                    @endif
                </td>
                <td class="p-2 border">
                    @if ($editingId === $coupon->id)
                        <button wire:click="updateCoupon" class="bg-blue-500 text-white px-2 py-1 rounded">Save</button>
                        <button wire:click="cancelEdit" class="bg-gray-500 text-white px-2 py-1 rounded">Cancel</button>
                    @else
                        <button wire:click="editCoupon({{ $coupon->id }})" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                        <button wire:click="confirmDelete({{ $coupon->id }})" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Confirmation Modal -->
    @if($confirmingDelete)
    <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="bg-white p-6 rounded shadow-md">
            <h2 class="text-lg font-bold mb-4">Confirm Delete</h2>
            <p>Are you sure you want to delete this coupon?</p>
            <div class="mt-4 flex justify-end">
                <button wire:click="cancelDelete" class="bg-gray-500 text-white px-3 py-1 rounded mr-2">Cancel</button>
                <button wire:click="deleteCoupon({{ $confirmingDelete }})" class="bg-red-500 text-white px-3 py-1 rounded">Delete</button>
            </div>
        </div>
    </div>
    @endif
</div>
