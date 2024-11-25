<template>
    <div>
        <label class="sr-only">{{ label }}</label>
        <div class="mt-1 flex rounded-md shadow-sm">
            <!-- Prepend (opsional) -->
            <span v-if="prepend" class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                {{ prepend }}
            </span>

            <!-- Input Type Select -->
            <template v-if="type === 'select'">
                <select
                    :id="id"
                    :name="name"
                    :required="required"
                    :value="modelValue"
                    :class="inputClasses"
                    @change="onChange($event.target.value)"
                >
                    <option v-for="option of selectOptions" :key="option.key" :value="option.key">
                        {{ option.text }}
                    </option>
                </select>
            </template>

            <!-- Input Type Textarea -->
            <template v-else-if="type === 'textarea'">
                <textarea
                    :id="id"
                    :name="name"
                    :required="required"
                    :value="modelValue"
                    @input="emit('update:modelValue', $event.target.value)"
                    :class="inputClasses"
                    :placeholder="label"
                ></textarea>
            </template>

            <!-- Input Type File -->
            <template v-else-if="type === 'file'">
                <input
                    :id="id"
                    :type="type"
                    :name="name"
                    :required="required"
                    @change="onChange($event.target.files[0])"
                    :class="inputClasses"
                    :placeholder="label"
                />
            </template>

            <!-- Input Type Checkbox -->
            <template v-else-if="type === 'checkbox'">
                <div class="flex items-center">
                    <input
                        :id="id"
                        :name="name"
                        :type="type"
                        :checked="modelValue"
                        :required="required"
                        @change="emit('update:modelValue', $event.target.checked)"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                    />
                    <label :for="id" class="ml-2 block text-sm text-gray-900">{{ label }}</label>
                </div>
            </template>

            <!-- Input Type Default -->
            <template v-else>
                <input
                    :id="id"
                    :type="type"
                    :name="name"
                    :required="required"
                    :value="modelValue"
                    @input="emit('update:modelValue', $event.target.value)"
                    :class="inputClasses"
                    :placeholder="label"
                />
            </template>

            <!-- Append (opsional) -->
            <span v-if="append" class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                {{ append }}
            </span>
        </div>
    </div>
</template>

<script setup>
import { computed } from "vue";

// Properti input
const props = defineProps({
    modelValue: [String, Number, File, Boolean], // Menambahkan Boolean
    label: String,
    type: {
        type: String,
        default: "text",
    },
    name: String,
    required: Boolean,
    prepend: {
        type: String,
        default: "",
    },
    append: {
        type: String,
        default: "",
    },
    selectOptions: {
        type: Array,
        default: () => [],
    },
    id: {
        type: String,
        default: () => `id-${Math.floor(1000000 + Math.random() * 1000000)}`,
    },
});

// Kelas untuk elemen input
const inputClasses = computed(() => {
    const cls = [
        `block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm`,
    ];

    if (props.append && !props.prepend) {
        cls.push(`rounded-l-md`);
    } else if (props.prepend && !props.append) {
        cls.push(`rounded-r-md`);
    } else if (!props.prepend && !props.append) {
        cls.push(`rounded-md`);
    }

    return cls.join(" ");
});

// Emit event
const emit = defineEmits(["update:modelValue", "change"]);

// Event handler untuk input
function onChange(value) {
    emit("update:modelValue", value);
    emit("change", value);
}
</script>
