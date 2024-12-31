<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Article / Create
            </h2>
            <a href="{{ route('articles.index') }}" class="bg-white text-sm rounded-md text-black px-3 py-3">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Article Name -->
                        <div>
                            <label for="name" class="text-sm font-medium">Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Enter Name" class="border-gray-300 shadow-sm w-full rounded-md">
                            @error('name')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Article Description -->
                        <div class="mt-4">
                            <label for="description" class="text-sm font-medium">Description</label>
                            <textarea name="description" id="description" placeholder="Enter Description" class="border-gray-300 shadow-sm w-full rounded-md">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Article Image -->
                        <div class="mt-4">
                            <label for="image" class="text-sm font-medium">Image</label>
                            <input type="file" name="image" id="image" class="border-gray-300 shadow-sm w-full rounded-md">
                            @error('image')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div class="mt-4">
                            <label for="categorie_id" class="text-sm font-medium">Category</label>
                            <select name="categorie_id" id="categorie_id" class="border-gray-300 shadow-sm w-full rounded-md">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('categorie_id', $article->categorie_id ?? '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categorie_id')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Price and Stock -->
                        <div class="mt-4">
                            <label for="price" class="text-sm font-medium">Price</label>
                            <input type="number" name="price" id="price" value="{{ old('price') }}" class="border-gray-300 shadow-sm w-full rounded-md">
                            @error('price')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="stock" class="text-sm font-medium">Stock</label>
                            <input type="number" name="stock" id="stock" value="{{ old('stock') }}" class="border-gray-300 shadow-sm w-full rounded-md">
                            @error('stock')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mt-4">
                            <label for="isActive" class="text-sm font-medium">Status</label>
                            <input type="checkbox" name="isActive" id="isActive" {{ old('isActive') ? 'checked' : '' }}>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
