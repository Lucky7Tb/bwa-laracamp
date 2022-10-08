<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">                           
                    <div class="overflow-x-auto relative">
                        @include('components.alert')
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs bg-gray-100 text-gray-700 uppercase">
                                <tr class="text-center">
                                    <th scope="col" class="py-3 px-6">
                                        User
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Camp
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Price
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Register Date
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Paid Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($checkouts as $checkout)
                                    <tr class="border-b bg-gray-300 border-gray-300 text-black text-center">
                                        <td class="py-4 px-6">
                                            {{ $checkout->user->name }}
                                        </td>
                                        <td class="py-4 px-6">
                                            {{ $checkout->camp->title }}                                            
                                        </td>
                                        <td class="py-4 px-6">
                                            {{ $checkout->camp->price }}
                                        </td>
                                        <td class="py-4 px-6">
                                            {{ $checkout->created_at->format('M d Y') }}
                                        </td>
                                        <td class="py-4 px-6">
                                            <strong>{{ $checkout->payment_status }}</strong>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">No camp registered</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
