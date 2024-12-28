<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Articles / Create
        </h2>
        <a href="{{route('articles.index')}}" class="bg-white text-sm rounded-md text-black px-3 py-3">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{route('articles.store')}}" method="post" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium">Name</label>
                                <input id="name" value="{{old('name')}}" name="name" placeholder="Enter name" type="text" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('name')
                                    <p class="mt-1 text-red-400 text-sm">{{$message}}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium">Description</label>
                                <textarea id="description" name="description" rows="3" placeholder="Enter description" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{old('description')}}</textarea>
                                @error('description')
                                    <p class="mt-1 text-red-400 text-sm">{{$message}}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="image" class="block text-sm font-medium">Image</label>
                                <input id="image" name="image" type="file" accept="image/*" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('image')
                                    <p class="mt-1 text-red-400 text-sm">{{$message}}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="isactive" class="block text-sm font-medium">Status</label>
                                <select id="isactive" name="isactive" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="1" {{ old('isactive') == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('isactive') == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('isactive')
                                    <p class="mt-1 text-red-400 text-sm">{{$message}}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="qte" class="block text-sm font-medium">Quantity</label>
                                <input id="qte" value="{{old('qte')}}" name="qte" type="number" min="0" placeholder="Enter quantity" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('qte')
                                    <p class="mt-1 text-red-400 text-sm">{{$message}}</p>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <button type="submit" 
                                    class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    Create Article
                                </button>
                            </div>
                        </div>
                    </form>
                    <form action="{{route('articles.store')}}" method="post">
                        @csrf
                        <div>
                            <label for="" class="text-sm font-medium">Name</label>
                            <div class="mb-3">
                                <input value="{{old('name')}}" name="name" placeholder="Enter Name" type="text" class="border-gray-300 shadow-sm w-1/2s rounded-1g text-black">
                                @error('name')
                                <p class="text-red-400 font-medium">{{$message}}</p>
                                @enderror
                                <input value="{{old('description')}}" name="description" placeholder="Enter description" type="text" class="border-gray-300 shadow-sm w-1/2s rounded-1g text-black">
                                @error('name')
                                <p class="text-red-400 font-medium">{{$message}}</p>
                                @enderror
                                <input value="{{old('imageUrl')}}" name="image" placeholder="Enter image" type="image" class="border-gray-300 shadow-sm w-1/2s rounded-1g text-black">
                                @error('name')
                                <p class="text-red-400 font-medium">{{$message}}</p>
                                @enderror
                                <input value="{{old('isactive')}}" name="isactive" placeholder="Enter Name" type="text" class="border-gray-300 shadow-sm w-1/2s rounded-1g text-black">
                                
                                <input value="{{old('stock')}}" name="qte" placeholder="Enter qte" type="number" class="border-gray-300 shadow-sm w-1/2s rounded-1g text-black">
                                @error('name')
                                <p class="text-red-400 font-medium">{{$message}}</p>
                                @enderror
                            </div>
                            <button class="bg-white text-sm rounded-md text-black px-5 py-3">submit</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
