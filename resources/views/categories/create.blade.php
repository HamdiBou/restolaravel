<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Categories / Create
            </h2>
            <a href="{{ route('categories.index') }}" class="bg-white text-sm rounded-md text-black px-3 py-3">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('categories.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="" class="text-sm font-medium">Name</label>
                            <div class="mb-3">
                                <input value="{{ old('name') }}" name="name" placeholder="Enter Name" type="text" class="border-gray-300 shadow-sm w-1/2s rounded-1g text-black">
                                @error('name')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <label for="" class="text-sm font-medium">Description</label>
                            <div>
                                <textarea name="description" placeholder="Enter Description" rows="20" class="border-gray-300 shadow-sm w-1/2s rounded-1g text-black">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <label for="" class="text-sm font-medium">Image</label>
                            <div>
                                <input type="file" name="image" class="border-gray-300 shadow-sm w-1/2s rounded-1g text-black">
                                @error('image')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="" class="text-sm font-medium">Status</label>
                                <input type="checkbox" name="isActive" value="1" {{ old('isActive') ? 'checked' : '' }}>
                                @error('isActive')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <button class="bg-white text-sm rounded-md text-black px-5 py-3">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
