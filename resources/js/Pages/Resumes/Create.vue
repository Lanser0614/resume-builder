<template>
    <Head title="Create Resume" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Resume</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit" class="space-y-6">
                            <div>
                                <InputLabel for="title" value="Resume Title" />
                                <TextInput
                                    id="title"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.title"
                                    required
                                    autofocus
                                />
                                <InputError :message="form.errors.title" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="template" value="Template" />
                                <select
                                    id="template"
                                    v-model="form.template"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    required
                                >
                                    <option value="modern">Modern</option>
                                    <option value="classic">Classic</option>
                                    <option value="professional">Professional</option>
                                </select>
                                <InputError :message="form.errors.template" class="mt-2" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton class="ml-4" :disabled="form.processing">
                                    Create Resume
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    title: '',
    template: 'modern',
    content: {
        sections: [
            {
                type: 'personal',
                title: 'Personal Information',
                content: {
                    name: '',
                    email: '',
                    phone: '',
                    address: '',
                }
            },
            {
                type: 'education',
                title: 'Education',
                content: []
            },
            {
                type: 'experience',
                title: 'Work Experience',
                content: []
            },
            {
                type: 'skills',
                title: 'Skills',
                content: []
            }
        ]
    }
});

const submit = () => {
    form.post(route('resumes.store'));
};
</script>
