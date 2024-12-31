<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Users / Edit
            </h2>
            <a href="{{ route('users.index') }}" class="bg-white text-sm rounded-md text-black px-3 py-3">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('users.update', $users->id) }}" method="POST">
                        @csrf

                        <div>
                            <label for="name" class="text-sm font-medium">Name</label>
                            <div class="mb-3">
                                <input value="{{ old('name', $users->name) }}" name="name" placeholder="Enter Name"
                                       type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg text-black">
                                @error('name')
                                    <p class="text-red-500 text-sm font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="email" class="text-sm font-medium">Email</label>
                            <div class="mb-3">
                                <input value="{{ old('email', $users->email) }}" name="email" placeholder="Enter Email"
                                       type="email" class="border-gray-300 shadow-sm w-1/2 rounded-lg text-black">
                                @error('email')
                                    <p class="text-red-500 text-sm font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-4 gap-4">
                                @if ($roles->isNotEmpty())
                                    @foreach ($roles as $role)
                                        <div class="mt-3">
                                            <input 
                                            {{($hasRoles->contains($role->id)) ? 'checked':''}}
                                                type="checkbox" 
                                                id="role-{{ $role->id }}" 
                                                class="rounded" 
                                                name="roles[]" 
                                                value="{{ $role->name }}"
                                                {{ $users->roles->contains('name', $role->name) ? 'checked' : '' }}>
                                            <label for="role-{{ $role->id }}" class="ml-2 text-sm font-medium">
                                                {{ $role->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-span-4 mt-3 text-gray-500">
                                        No roles available.
                                    </div>
                                @endif
                            </div>

                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-medium rounded-md px-5 py-2 mt-4">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
