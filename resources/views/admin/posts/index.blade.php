<x-layout>
    <x-setting heading="Manage Posts">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <form action="" method="get">
                        <div class="flex">
                            <div class="p-2">
                                <x-form.field>
                                    <x-form.label name="Filter Posts by the status: "/>

                                    <select name="status" id="status"  class="mb-4">
                                        <option value="0">All</option>
                                        @foreach (config('helper.status') as $key => $item)
                                            <option
                                                value="{{ $key }}"
                                                {{ old('status', Request::get('status')) == $key ? 'selected' : '' }}
                                            >{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </x-form.field>
                            </div>
                            <div class="p-2">
                                <x-form.field>
                                    <x-form.label name="Order Posts By Date: "/>

                                    <select name="order_by" id="order_by"  class="mb-4">
                                        <option value="0" {{ old('order_by', Request::get('order_by')) == 0 ? 'selected' : '' }}>Ascending</option>
                                        <option value="1" {{ old('order_by', Request::get('order_by')) == 1 ? 'selected' : '' }}>Descending</option>
                                    </select>
                                </x-form.field>
                            </div>

                            <div class="p-10">
                                <button type="submit" class="transition-colors duration-300 text-xs font-semibold bg-red-200 hover:bg-gray-300 rounded-full py-2 px-8">Submit</button>
                            </div>
                        </div>
                    </form>

                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                  <th scope="col">ID</th>
                                  <th scope="col">Image</th>
                                  <th scope="col">Title</th>
                                  <th scope="col">Status</th>
                                  <th scope="col">Created At</th>
                                  <th></th>
                                  <th></th>
                                </tr>
                              </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($posts as $post)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <p>{{ $post->id }}</p>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="" class="rounded-xl ml-6" width="100">
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="text-sm font-medium text-gray-900">
                                                    <a href="/posts/{{ $post->slug }}">
                                                        {{ $post->title }}
                                                    </a>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <p class="{{ ($post->status == App\Models\Post::APPROVED_POST_STATUS) ? 'text-green-500' : 'text-red-500' }}">{{ config('helper.status.' . $post->status) }}</p>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <p class="text-sm font-medium text-gray-900">{{ $post->created_at }}</p>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="text-blue-500 hover:text-blue-600">Edit</a>
                                        </td>


                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form method="POST" action="{{ route('posts.destroy', ['post' => $post->id]) }}">
                                                @csrf
                                                @method('DELETE')

                                                <button class="text-xs text-gray-400">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center pt-4">
            {!! $posts->links() !!}
        </div>
    </x-setting>
</x-layout>
