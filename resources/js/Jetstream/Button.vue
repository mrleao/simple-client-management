<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button :type="type" class="rounded-md uppercase w-full p-2 text-center text-main bg-white border border-main hover:text-white hover:bg-main text-sm transition">
        <slot />
    </button>
</template>
