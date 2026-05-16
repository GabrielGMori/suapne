<x-layouts.main title="Testing Components Matrix">
    <form method="POST" action="{{ url()->current() }}" class="flex flex-col gap-10 p-10">
        @csrf

        @php
            $appearances = ['default', 'outlined', 'surface'];
            $sizes = ['tiny', 'small', 'medium', 'large', 'full'];
            $inputTypes = ['text', 'password', 'password_forgot', 'date', 'datetime', 'file', 'textarea'];
            $selectTypes = ['select', 'multiselect'];
            $options = ['20','10','5'];
        @endphp

        @foreach ($appearances as $appearance)
            <div class="flex flex-col gap-6">
                <h2 class="text-headline-large border-b pb-2 uppercase">{{ $appearance }} Appearance</h2>

                <div class="grid grid-cols-1 gap-8">
                    @foreach (array_merge($inputTypes, $selectTypes) as $type)
                        <div class="flex flex-col gap-4">
                            <h3 class="text-title-large text-secondary capitalize">{{ str_replace('_', ' ', $type) }}</h3>
                            
                            <div class="flex flex-wrap items-end gap-4">
                                @foreach ($sizes as $size)
                                    <div class="flex flex-col gap-1">
                                        <span class="text-label-small text-secondary-accent uppercase">{{ $size }}</span>
                                        @if (in_array($type, $selectTypes))
                                            <livewire:form.select 
                                                :key="'select-'.$appearance.'-'.$type.'-'.$size"
                                                :type="$type"
                                                :name="'field_'.$appearance.'_'.$type.'_'.$size"
                                                :label="null"
                                                :options="$options"
                                                :appearance="$appearance"
                                                :size="$size"
                                                :clearable="true"
                                            />
                                        @else
                                            <livewire:form.input 
                                                :key="'input-'.$appearance.'-'.$type.'-'.$size"
                                                :type="$type"
                                                :name="'field_'.$appearance.'_'.$type.'_'.$size"
                                                :label="null"
                                                :placeholder="'Placeholder...'"
                                                :appearance="$appearance"
                                                :size="$size"
                                            />
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="fixed bottom-10 right-10 z-50">
            <x-button type="submit" label="Test old() on all fields" color="primary" size="large" />
        </div>
    </form>
</x-layouts.main>