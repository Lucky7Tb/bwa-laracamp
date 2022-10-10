<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Discount') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">                           
                    <div>
                        @include('components.alert')
                    	<div class="mt-5">
                    		<a href="{{ route('admin.discount.create') }}" class="px-3 py-3 border-gray-200  text-white bg-indigo-500 rounded-full">Add discount</a>
                    	</div>

                    	 <table class="w-full mt-10 text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs bg-gray-100 text-gray-700 uppercase">
                                <tr class="text-center">
                                    <th scope="col" class="py-3 px-6">
                                        Name
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Code
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Description
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Percentage
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($discounts as $discount)
                                    <tr class="text-center">
                                        <td>{{ $discount->name }}</td>
                                    <td> <span class="bg-indigo-500 rounded-md text-bold p-1 text-white">{{ $discount->code }}</span></td>
                                        <td>{{ $discount->description }}</td>
                                        <td>{{ $discount->percentage }} %</td>
                                        <td class="py-5 my-5">
                                            <a href="{{ route('admin.discount.edit', $discount->id) }}" class="px-2 py-1 bg-amber-400 text-black rounded mr-3 hover:bg-amber-500">Edit</a>
                                            <form class="inline" method="POST" action="{{ route('admin.discount.destroy', $discount->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2 py-1 bg-red-400 text-white rounded mr-3 hover:bg-red-600">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="text-center font-semibold text-xl">
                                        <td colspan="5">There is not discount yet :(</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $discounts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
