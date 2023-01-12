<script setup>
import { computed } from 'vue';

const props = defineProps({
    active: Boolean,
    iconId: String,
    menuId: String,
});

const classes = computed(() => {
    return props.active
        ? 'block pl-6 flex items-center py-4 border-r-2 border-main text-base font-medium text-main bg-gray-200 focus:outline-none focus:text-main focus:bg-gray-300 focus:bg-gray-300 focus:border-main transition'
        : 'block pl-6 flex items-center py-4 border-r-2 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-100 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-300 focus:border-gray-300 transition';
});

const visible = computed(() => {
    return props.active
        ? 'block'
        : 'hidden';
});
</script>

<template>
    <div>
        <div :class="classes" class="w-full flex cursor-pointer">
            <slot name="menu" />
            <i v-if="active" :id="iconId" class="flex-none pr-2 text-xs fa-solid fa-angle-down"></i>
            <i v-else :id="iconId" class="flex-none pr-2 text-xs submenu-icon fa-solid fa-angle-right"></i>
        </div>
        <div :id="menuId" :class="visible" class="bg-gray-100 submenu">
            <slot name="submenus" />
        </div>
    </div>
</template>
