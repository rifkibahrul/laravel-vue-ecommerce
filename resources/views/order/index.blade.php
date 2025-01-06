<x-app-layout>
    <div class="container mx-auto lg:w-2/3 p-5">
        <h1 class="text-3xl font-bold mb-6">My Orders</h1>
        <div class="bg-white rounded-lg p-3 overflow-x-auto">
            <table class="table-auto w-full">
                <thead>
                    <tr class="border-b-2">
                        <th class="text-left p-2">Order #</th>
                        <th class="text-left p-2">Date</th>
                        <th class="text-left p-2">Status</th>
                        <th class="text-left p-2">Subtotal</th>
                        <th class="text-left p-2">Items</th>
                        <th class="text-left p-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($orders->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center py-8 text-gray-500">
                        You don't have any orders
                        </td>
                    </tr>
                    @endif
                    @foreach($orders as $order)
                    <tr class="border-b">
                        <td class="py-1 px-2">
                            {{ $order->id }}
                        </td>
                        <td class="py-1 px-2 whitespace-nowrap">{{ $order->created_at }}</td>
                        <td class="py-1 px-2">
                            <small
                                class="text-white py-1 px-2 rounded capitalize
                            {{ strtolower($order->status) === 'settlement' ? 'bg-emerald-600' : (strtolower($order->status) === 'pending' ? 'bg-amber-600' : 'bg-red-600') }}">
                                {{ $order->status }}
                            </small>
                        </td>
                        <td class="py-1 px-2">
                            Rp {{ number_format($order->total_price, 2, ',', '.') }}
                        </td>
                        <td class="py-1 px-2 whitespace-nowrap">
                            {{$order->items()->count()}} item(s)
                        </td>
                        <td class="py-1 px-2 flex gap-2 w-[100px]">
                            <a href="{{ route('order.view', $order) }}" class="flex items-center py-1 px-2 whitespace-nowrap text-white hover:text-black bg-sky-600 hover:bg-sky-500  rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 mr-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                                View
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $orders->links() }}
        </div>
    </div>
</x-app-layout>