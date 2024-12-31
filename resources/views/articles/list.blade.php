<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('articles') }}
            </h2>
            <a href="{{ route('articles.create') }}"
                class="bg-white text-sm rounded-md text-black px-3 py-3">create</a>
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
                        <th class="px-6 py-3 text-left">description</th>
                        <th class="px-6 py-3 text-left">isActive</th>
                        <th class="px-6 py-3 text-left">quantity</th>
                        <th class="px-6 py-3 text-left">price</th>
                        <th class="px-6 py-3 text-left">image</th>
                        <th class="px-6 py-3 text-left">created</th>
                        <th class="px-6 py-3 text-center">action</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if ($articles->isNotEmpty())
                        @foreach ($articles as $article)
                            <tr class="border-b">
                                <td class="px-6 py-3 text-left">
                                    {{ $article->id }}
                                </td>
                                <td class="px-6 py-3 text-left">
                                    {{ $article->name }}
                                </td>
                                <td class="px-6 py-3 text-left">
                                    {{ $article->description }}
                                </td>
                                <td class="px-6 py-3 text-left">
                                    {{ $article->isActive == 1 ? 'Yes' : 'No' }}
                                </td>
                                <td class="px-6 py-3 text-left">
                                    {{ $article->stock }}
                                    </td>
                                <td class="px-6 py-3 text-left">
                                    {{ $article->price }}
                                </td>                           
                                <td class="px-6 py-3 text-left">
                                    @if ($article->image)
                                        <img src="data:image/jpeg;base64,{{ base64_encode($article->image) }}" alt="{{ $article->name }}" class="w-20 h-20 object-cover">
                                    @else
                                        <p>No image available</p>
                                    @endif
                                </td>
                                
                                <td class="px-6 py-3 text-left">
                                    {{ \Carbon\Carbon::parse($article->created_at)->format('d M, Y') }}
                                </td>
                                <td class="px-6 py-3 text-center">
                                    {{-- @can('edit articles') --}}
                                    <a href="{{ route('articles.edit', $article->id) }}"
                                        class="bg-orange-500 text-sm rounded-md text-black px-3 py-3 hover:bg-slate-50">Edit</a>
                                    {{-- @endcan
                                    @can('delete articles') --}}
                                        <a href="#" onclick="deletearticle({{ $article->id }})"
                                        class="bg-red-500 text-sm rounded-md text-black px-3 py-3 hover:bg-slate-50">Delete</a>
                                    {{-- @endcan --}}
                                    </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <div class="my-3">
                {{ $articles->links() }}
            </div>

        </div>
    </div>
    <x-slot name="script">
        <script type="text/javascript">
            function deletearticle($id) {
                if (confirm('Are you sure you want to delete this article?')) {
                    $.ajax({
                        url: '{{ route('articles.destroy') }}',
                        type: 'DELETE',
                        data: {
                            id: $id
                        },
                        dataType: 'json',
                        headers: {
                            'x-csrf-token': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            window.location.href = '{{ route('articles.index') }}';
                        }
                    });

                }
            }
        </script>
    </x-slot>
</x-app-layout>
