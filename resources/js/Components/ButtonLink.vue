<script setup>
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    href: String,
    active: Boolean,
});
</script>

<template>
    <Link :href="href" >
        <div class="rounded-md hover:uppercase w-full p-2 text-center text-teal-400 bg-white border border-teal-400 hover:text-white hover:bg-teal-400 text-sm transition">
            <slot />
        </div>
    </Link>
</template>
