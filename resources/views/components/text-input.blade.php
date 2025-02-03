@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
        'class' =>
            'block w-full p-4 pl-[46px] rounded-[50px] font-semibold placeholder:text-grey placeholder:font-normal text-black text-base bg-no-repeat bg-[calc(16px)] border border-[#F1F1FA] focus:ring-2 focus:ring-secondary focus:outline-none transition-all outline-none',
    ]) !!}
>
