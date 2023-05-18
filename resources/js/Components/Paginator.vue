<script setup lang="ts">
import { ArrowLongLeftIcon, ArrowLongRightIcon } from '@heroicons/vue/24/solid';
import { Link } from "@inertiajs/vue3"

defineProps({
    currentPage: String,
    pages: String
})
</script>

<template>
    <nav class="flex items-center justify-between border-t border-gray-200 px-4 sm:px-0">
        <div class="-mt-px flex w-0 flex-1">
            <Link v-if="currentPage && parseInt(currentPage) - 1 > 0" :href="`/users?page=${parseInt(currentPage) - 1}`" class="inline-flex items-center border-t-2 border-transparent pr-1 pt-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                <ArrowLongLeftIcon class="mr-3 h-5 w-5 text-gray-400" aria-hidden="true" />
                Previous
            </Link>
            </div>
            <div class="hidden md:-mt-px md:flex">
            <Link v-for="i in pages" :href="`/users?page=${i}`" class="inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">{{ i }}</Link>
            <!-- Current: "border-indigo-500 text-indigo-600", Default: "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" -->
            </div>
            <div class="-mt-px flex w-0 flex-1 justify-end">
            <Link v-if="currentPage && pages && parseInt(currentPage) + 1 <= parseInt(pages)" :href="`users?page=${parseInt(currentPage) + 1}`" class="inline-flex items-center border-t-2 border-transparent pl-1 pt-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                Next
                <ArrowLongRightIcon class="ml-3 h-5 w-5 text-gray-400" aria-hidden="true" />
            </Link>
        </div>
    </nav>
</template>
