<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Article
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Article Name -->
                        <div>
                            <label for="name" class="text-sm font-medium">Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $article->name) }}" placeholder="Enter Name" class="border-gray-300 shadow-sm w-full rounded-md">
                            @error('name')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Article Description -->
                        <div class="mt-4">
                            <label for="description" class="text-sm font-medium">Description</label>
                            <textarea name="description" id="description" placeholder="Enter Description" class="border-gray-300 shadow-sm w-full rounded-md">{{ old('description', $article->description) }}</textarea>
                            @error('description')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Article Image -->
                        <div class="mt-4">
                            <label for="image" class="text-sm font-medium">Image</label>
                            @if($article->image)
                                <div class="mb-3">
                                    <img src="data:image/jpeg;base64,{{ base64_encode($article->image) }}" alt="Article Image" class="max-w-full h-auto rounded-md">
                                </div>
                            @endif
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
                            <input type="number" name="price" id="price" value="{{ old('price', $article->price) }}" class="border-gray-300 shadow-sm w-full rounded-md">
                            @error('price')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="stock" class="text-sm font-medium">Stock</label>
                            <input type="number" name="stock" id="stock" value="{{ old('stock', $article->stock) }}" class="border-gray-300 shadow-sm w-full rounded-md">
                            @error('stock')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mt-4">
                            <label for="isActive" class="text-sm font-medium">Status</label>
                            <input type="checkbox" name="isActive" id="isActive" {{ old('isActive', $article->isActive) ? 'checked' : '' }}>
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
