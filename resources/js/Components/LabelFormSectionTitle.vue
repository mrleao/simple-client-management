<script setup>
defineProps({
    value: String,
});
</script>

<template>
        <div class="mt-8">
            <p class="uppercase self-center font-bold text-lg text-main sm:text-left text-center"><slot /></p>
        </div>
        <div class="self-center sm:block hidden">
            <hr class="self-center border-2 w-full">
        </div>
</template>
