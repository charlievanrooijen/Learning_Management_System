<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { reactive } from 'vue';

const form = useForm({
    title: '',
    description: '',
    status: 'private',
    content: [],
});

const questions = reactive([
    {
        question: '',
        choices: [
            { text: '', is_correct: false },
        ],
    },
]);

const addQuestion = () => {
    questions.push({
        question: '',
        choices: [
            { text: '', is_correct: false },
        ],
    });
};

const removeQuestion = (index) => {
    questions.splice(index, 1);
};

const addChoice = (questionIndex) => {
    questions[questionIndex].choices.push({ text: '', is_correct: false });
};

const removeChoice = (questionIndex, choiceIndex) => {
    questions[questionIndex].choices.splice(choiceIndex, 1);
};

const submit = () => {
    form.content = JSON.stringify(questions);

    form.post(route('quizzes.store'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Create Quiz" />

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="title" value="Title" />
                <TextInput id="title" type="text" class="mt-1 block w-full" v-model="form.title" required autofocus autocomplete="off" />
                <InputError class="mt-2" :message="form.errors.title" />
            </div>

            <div class="mt-4">
                <InputLabel for="description" value="Description" />
                <textarea id="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    v-model="form.description"></textarea>
                <InputError class="mt-2" :message="form.errors.description" />
            </div>

            <div class="mt-4">
                <InputLabel for="status" value="Status" />
                <select id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    v-model="form.status" required>
                    <option value="private">Private</option>
                    <option value="public">Public</option>
                </select>
                <InputError class="mt-2" :message="form.errors.status" />
            </div>

            <div class="mt-6">
                <h3 class="text-lg font-semibold mb-2">Quiz Content</h3>

                <div v-for="(question, questionIndex) in questions" :key="questionIndex" class="mb-8 border-b pb-6">
                    <div class="mb-4">
                        <InputLabel :for="'question-' + questionIndex" :value="'Question ' + (questionIndex + 1)" />
                        <TextInput :id="'question-' + questionIndex" type="text" class="mt-1 block w-full" v-model="question.question" required
                            autocomplete="off" placeholder="Enter your question" />
                    </div>

                    <div v-for="(choice, choiceIndex) in question.choices" :key="choiceIndex" class="flex items-center gap-2 mb-3">
                        <TextInput :id="'choice-' + questionIndex + '-' + choiceIndex" type="text" class="flex-1" v-model="choice.text"
                            placeholder="Enter a choice" required />
                        <label class="inline-flex items-center">
                            <input type="checkbox" v-model="choice.is_correct" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                            <span class="ml-2">Correct</span>
                        </label>
                        <button type="button" @click="removeChoice(questionIndex, choiceIndex)"
                            class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">
                            Remove
                        </button>
                    </div>

                    <div>
                        <button type="button" @click="addChoice(questionIndex)"
                            class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600">
                            Add Choice
                        </button>
                    </div>

                    <div class="mt-4">
                        <button type="button" @click="removeQuestion(questionIndex)"
                            class="bg-red-500 text-white px-3 py-2 rounded hover:bg-red-600">
                            Remove Question
                        </button>
                    </div>
                </div>

                <div>
                    <button type="button" @click="addQuestion" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                        Add Question
                    </button>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end">
                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Create Quiz
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
