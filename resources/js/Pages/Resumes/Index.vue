<template>
    <Head title="Resumes" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Resumes</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-medium">Your Resumes</h3>
                            <Link
                                :href="route('resumes.create')"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                            >
                                Create New Resume
                            </Link>
                        </div>

                        <div v-if="resumes.length === 0" class="text-center py-8">
                            <p class="text-gray-500">You haven't created any resumes yet.</p>
                        </div>

                        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div
                                v-for="resume in resumes"
                                :key="resume.id"
                                class="border rounded-lg p-4 hover:shadow-lg transition-shadow"
                            >
                                <h4 class="font-medium mb-2">{{ resume.title }}</h4>
                                <p class="text-sm text-gray-500 mb-4">
                                    Template: {{ resume.template }}
                                </p>
                                <div class="flex justify-between">
                                    <Link
                                        :href="route('resumes.edit', resume.id)"
                                        class="text-blue-500 hover:text-blue-700"
                                    >
                                        Edit
                                    </Link>
                                    <button
                                        @click="deleteResume(resume)"
                                        class="text-red-500 hover:text-red-700"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    resumes: Array,
});

const deleteResume = (resume) => {
    if (confirm('Are you sure you want to delete this resume?')) {
        router.delete(route('resumes.destroy', resume.id));
    }
};
</script>
