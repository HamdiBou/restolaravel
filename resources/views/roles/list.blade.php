<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Roles') }}
            </h2>
            <a href="{{ route('roles.create') }}" class="bg-white text-sm rounded-md text-black px-3 py-3">create</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr class="border-b">
                        <th class="px-6 py-3 text-left">#</th>
                        <th class="px-6 py-3 text-left">Name</th>
                        <th class="px-6 py-3 text-left">Permissions</th>
                        <th class="px-6 py-3 text-left">created</th>
                        <th class="px-6 py-3 text-center">action</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if ($roles->isNotEmpty())
                        @foreach ($roles as $role)
                            <tr class="border-b">
                                <td class="px-6 py-3 text-left">
                                    {{ $role->id }}
                                </td>
                                <td class="px-6 py-3 text-left">
                                    {{ $role->name }}
                                </td>
                                <td class="px-6 py-3 text-left">
                                    {{-- Display permissions as a comma-separated list --}}
                                    {{ $role->permissions->pluck('name')->implode('') }}
                                </td>
                                <td class="px-6 py-3 text-left">
                                    {{ $role->created_at->format('d M, Y') }}
                                </td>
                                <td class="px-6 py-3 text-center">
                                    {{-- Action buttons (Edit/Delete) --}}
                                    <a href="{{ route('roles.edit', $role->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                    <a href="javascript:void(0)" onclick="deleteRole({{ $role->id }})"
                                        class="text-red-500 hover:underline">Delete</a>
                                    
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="px-6 py-3 text-center text-gray-500">
                                No roles available.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            

        </div>
    </div>
    <x-slot name="script">
        <script type="text/javascript">
            function deleteRole($id) {
                if (confirm('Are you sure you want to delete this role?')) {
                    $.ajax({
                        url: '{{ route('roles.destroy') }}',
                        type: 'DELETE',
                        data: {
                            id: $id
                        },
                        dataType: 'json',
                        headers: {
                            'x-csrf-token': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            window.location.href = '{{ route('roles.index') }}';
                        }
                    });

                }
            }
        </script>
    </x-slot>
</x-app-layout>