<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button :type="type" class="rounded-md hover:uppercase w-full p-2 text-center text-teal-400 bg-white border border-teal-400 hover:text-white hover:bg-teal-400 text-sm transition">
        <slot />
    </button>
</template>
