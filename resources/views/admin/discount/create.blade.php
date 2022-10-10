<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Discount') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">                           
                    <div class="overflow-x-auto relative">
                        <form method="POST" action="{{ route('admin.discount.store') }}" class="px-3">
                            @csrf
                            <div class="mb-3">
                                <label class="block font-semibold {{ $errors->has('name') ? 'text-red-500' : null }}" form="name">Name</label>
                                <input type="text" name="name" id="name" class="border-2 focus:border-indigo-700 rounded-full w-full {{ $errors->has('name') ? 'border-red-500' : null }}" value="{{ old('name') }}" placeholder="e.g Birthday Discount" required />
                                @error('name')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="block font-semibold {{ $errors->has('code') ? 'text-red-500' : null }}" form="name">Code</label>
                                <input type="text" name="code" id="code" class="border-2 focus:border-indigo-700 rounded-full w-full {{ $errors->has('code') ? 'border-red-500' : null }}" value="{{ old('code') }}" placeholder="e.g JADICEPE" required />
                                @error('code')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="block font-semibold {{ $errors->has('description') ? 'text-red-500' : null }}" form="description">Description</label>
                                <textarea type="text" name="description" id="description" class="border-2 focus:border-indigo-700 rounded-lg w-full {{ $errors->has('description') ? 'border-red-500' : null }}" required>{{ old('description') }}</textarea> 
                                @error('description')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="block font-semibold {{ $errors->has('percentage') ? 'text-red-500' : null }}" form="percentage">Discount Percentage</label>
                                <input type="number" min="1" max="100" name="percentage" id="percentage" class="border-2 focus:border-indigo-700 rounded-full w-full {{ $errors->has('percentage') ? 'border-red-500' : null }}" value="{{ old('percentage') }}" placeholder="e.g Birthday Discount" required />
                                @error('percentage')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="px-3 py-3 border-gray-200 text-white bg-indigo-500 rounded-full w-full">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
