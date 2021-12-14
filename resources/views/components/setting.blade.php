@props(['heading'])

<section class="py-8 mx-auto">
    <h1 class="text-lg font-bold mb-8 pb-2 border-b">
        {{ $heading }}
    </h1>

    <div class="flex">
        <aside class="w-48 flex-shrink-0">

            <ul>
                <li class="mb-4">
                    @admin
                        <a href="{{ route('posts.index') }}" class="{{ request()->is(route('posts.index')) ? 'text-blue-500' : '' }}">All Posts</a>
                    @else
                        <a href="{{ route('user-posts') }}" class="{{ request()->is(route('user-posts')) ? 'text-blue-500' : '' }}">All Posts</a>
                    @endadmin

                </li>

                <li class="mb-4">
                    @admin
                        <a href="{{ route('posts.create') }}" class="{{ request()->is(route('posts.create')) ? 'text-blue-500' : '' }}">New Post</a>
                    @else
                    <a href="{{ route('user-post-create') }}" class="{{ request()->is(route('user-post-create')) ? 'text-blue-500' : '' }}">New Post</a>
                    @endadmin

                </li>
            </ul>
        </aside>

        <main class="flex-1">
            <x-panel>
                {{ $slot }}
            </x-panel>
        </main>
    </div>
</section>
