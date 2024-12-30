<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Categories / Edit
            </h2>
            <a href="{{ route('categories.index') }}" class="bg-white text-sm rounded-md text-black px-3 py-3">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('categories.update', $categorie->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')  <!-- Add PUT method to update the record -->
                        
                        <div>
                            <!-- Name Input -->
                            <label for="name" class="text-sm font-medium">Name</label>
                            <div class="mb-3">
                                <input value="{{ old('name', $categorie->name) }}" name="name"
                                    placeholder="Enter Name" type="text"
                                    class="border-gray-300 shadow-sm w-1/2 rounded-lg text-black">
                                @error('name')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description Input -->
                            <label for="description" class="text-sm font-medium">Description</label>
                            <div class="mb-3">
                                <textarea name="description" placeholder="Enter Description" cols="50" rows="10"
                                    class="border-gray-300 shadow-sm w-1/2 rounded-lg text-black">{{ old('description', $categorie->description) }}</textarea>
                                @error('description')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Image Input -->
                            <label for="image" class="text-sm font-medium">Image</label>
                            <div class="mb-3">
                                @if ($categorie->image)
                                    <!-- Check if the category has a base64 image -->
                                    <div class="mb-2">
                                        <img src="data:image/jpeg;base64,{{ base64_encode($categorie->image) }}"
                                            alt="Category Image" class="max-w-full h-auto rounded-md">
                                    </div>
                                @endif
                                <input type="file" name="image"
                                    class="border-gray-300 shadow-sm w-1/2 rounded-lg text-black">
                                @error('image')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status Checkbox -->
                            <div class="mb-3">
                                <label for="status" class="text-sm font-medium">Status</label>
                                <input 
                                    type="checkbox" 
                                    name="isActive" 
                                    class="border-gray-300 shadow-sm rounded-lg text-black"
                                    {{ old('isActive', $categorie->isActive) == 1 ? 'checked' : '' }}  
                                >
                                @error('isActive')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="bg-white text-sm rounded-md text-black px-5 py-3">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
