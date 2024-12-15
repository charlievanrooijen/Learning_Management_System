<script setup>
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    title: '',
    description: '',
    status: 'private',
    content: '',
});

const submit = () => {
    form.post(route('quizzes.store'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <div>
        <Head title="Create Quiz" />

        <h1 class="text-2xl font-bold mb-4">Create a New Quiz</h1>

        <form @submit.prevent="submit">
            <div class="mb-4">
                <label for="title" class="block font-medium">Title</label>
                <input
                    id="title"
                    type="text"
                    v-model="form.title"
                    class="mt-1 block w-full border-gray-300 rounded-md"
                    required
                />
                <span v-if="form.errors.title" class="text-red-500 text-sm">{{ form.errors.title }}</span>
            </div>

            <div class="mb-4">
                <label for="description" class="block font-medium">Description</label>
                <textarea
                    id="description"
                    v-model="form.description"
                    class="mt-1 block w-full border-gray-300 rounded-md"
                ></textarea>
                <span v-if="form.errors.description" class="text-red-500 text-sm">{{ form.errors.description }}</span>
            </div>

            <div class="mb-4">
                <label for="status" class="block font-medium">Status</label>
                <select
                    id="status"
                    v-model="form.status"
                    class="mt-1 block w-full border-gray-300 rounded-md"
                >
                    <option value="private">Private</option>
                    <option value="public">Public</option>
                </select>
                <span v-if="form.errors.status" class="text-red-500 text-sm">{{ form.errors.status }}</span>
            </div>

            <div class="mb-4">
                <label for="content" class="block font-medium">Content (JSON)</label>
                <textarea
                    id="content"
                    v-model="form.content"
                    class="mt-1 block w-full border-gray-300 rounded-md"
                    placeholder='[{"question": "Example?", "choices": [{"id": 1, "text": "Yes", "is_correct": true}, {"id": 2, "text": "No", "is_correct": false}]}]'
                ></textarea>
                <span v-if="form.errors.content" class="text-red-500 text-sm">{{ form.errors.content }}</span>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">
                Create Quiz
            </button>
        </form>
    </div>
</template>
