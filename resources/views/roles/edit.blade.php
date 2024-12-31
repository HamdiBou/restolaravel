<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Roles / Edit
            </h2>
            <a href="{{ route('roles.index') }}" class="bg-white text-sm rounded-md text-black px-3 py-3">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('roles.update', $roles->id) }}" method="post">
                        @csrf
                        {{-- @method('PUT') --}} <!-- Add method directive -->

                        <div>
                            <!-- Role Name -->
                            <label for="name" class="text-sm font-medium">Name</label>
                            <div class="mb-3">
                                <input value="{{ old('name', $roles->name) }}" name="name" id="name" placeholder="Enter Name"
                                    type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg text-black">
                                @error('name')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Permissions -->
                            <div class="grid grid-cols-4 gap-4">
                                @if ($permissions->isNotEmpty())
                                    @foreach ($permissions as $permission)
                                        <div class="mt-3">
                                            <input {{ $haspermissions->contains($permission->name) ? 'checked' : '' }} 
                                                type="checkbox" id="permission-{{ $permission->id }}" class="rounded" 
                                                name="permissions[]" value="{{ $permission->name }}">
                                            <label for="permission-{{ $permission->id }}" class="ml-2 text-sm font-medium">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-span-4 mt-3 text-gray-500">
                                        No permissions available.
                                    </div>
                                @endif
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="bg-white text-sm rounded-md text-black px-5 py-3 mt-4">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
