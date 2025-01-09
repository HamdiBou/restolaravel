<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Payments') }}
            </h2>
            <div class="flex space-x-4">
                <form action="{{ route('payments.index') }}" method="GET" class="flex space-x-4">
                    <select name="status" onchange="this.form.submit()" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                </form>
                @can('export payments')
            <a href="{{ route('payments.export') }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                Download CSV
            </a>
            @endcan
        </div>
    </x-slot>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Articles</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($payments as $payment)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $payment->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $payment->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $payment->phone }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="truncate block max-w-xs" title="{{ $payment->address }}">
                                {{ $payment->address }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button type="button" 
                                    class="text-blue-600 hover:text-blue-900"
                                    onclick="alert('{{ json_encode($payment->articles) }}')">
                                View Articles
                            </button>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @switch($payment->status)
                                    @case('pending')
                                        bg-yellow-100 text-yellow-800
                                        @break
                                    @case('confirmed')
                                        bg-green-100 text-green-800
                                        @break
                                    @case('failed')
                                        bg-red-100 text-red-800
                                        @break
                                @endswitch
                            ">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $payment->created_at->format('Y-m-d H:i') }}
                        </td>
                        @can('update payments')
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            @if($payment->status === 'pending')
                                <div class="flex space-x-2">
                                    <form action="{{ route('payments.updateStatus', $payment) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="confirmed">
                                        <button type="submit" class="text-green-600 hover:text-green-900">
                                            Confirm
                                        </button>
                                    </form>
                                    <form action="{{ route('payments.updateStatus', $payment) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="failed">
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            Fail
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($payments->hasPages())
        <div class="mt-4">
            {{ $payments->links() }}
        </div>
    @endif
</div>
</x-app-layout>