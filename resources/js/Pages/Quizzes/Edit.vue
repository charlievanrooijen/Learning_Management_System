<script setup>
import { reactive } from 'vue';
import { useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    quiz: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    title: props.quiz.title,
    description: props.quiz.description,
    status: props.quiz.status,
    content: props.quiz.content ? JSON.parse(props.quiz.content) : [],
});

const addQuestion = () => {
    form.content.push({
        question: '',
        choices: [{ text: '', is_correct: false }],
    });
};

const removeQuestion = (index) => {
    form.content.splice(index, 1);
};

const addChoice = (questionIndex) => {
    form.content[questionIndex].choices.push({ text: '', is_correct: false });
};

const removeChoice = (questionIndex, choiceIndex) => {
    form.content[questionIndex].choices.splice(choiceIndex, 1);
};

const submit = () => {
    form.content = JSON.stringify(form.content);

    form.put(route('quizzes.update', props.quiz.id), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <div class="max-w-2xl mx-auto bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">Edit Quiz</h1>

        <form @submit.prevent="submit">
            <div class="mb-4">
                <InputLabel for="title" value="Title" />
                <TextInput
                    id="title"
                    type="text"
                    v-model="form.title"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    required
                />
            </div>

            <div class="mb-4">
                <InputLabel for="description" value="Description" />
                <textarea
                    id="description"
                    v-model="form.description"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                ></textarea>
            </div>

            <div class="mb-4">
                <InputLabel for="status" value="Status" />
                <select
                    id="status"
                    v-model="form.status"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                >
                    <option value="private">Private</option>
                    <option value="public">Public</option>
                </select>
            </div>

            <div class="mt-6">
                <h3 class="text-lg font-semibold mb-2">Quiz Content</h3>

                <div v-for="(question, questionIndex) in form.content" :key="questionIndex" class="mb-8 border-b pb-6">
                    <div class="mb-4">
                        <InputLabel :for="'question-' + questionIndex" :value="'Question ' + (questionIndex + 1)" />
                        <TextInput
                            :id="'question-' + questionIndex"
                            type="text"
                            v-model="question.question"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            required
                        />
                    </div>

                    <div
                        v-for="(choice, choiceIndex) in question.choices"
                        :key="choiceIndex"
                        class="flex items-center gap-2 mb-3"
                    >
                        <TextInput
                            :id="'choice-' + questionIndex + '-' + choiceIndex"
                            type="text"
                            v-model="choice.text"
                            class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            placeholder="Enter a choice"
                            required
                        />
                        <label class="inline-flex items-center">
                            <input
                                type="checkbox"
                                v-model="choice.is_correct"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            />
                            <span class="ml-2">Correct</span>
                        </label>
                        <button
                            type="button"
                            @click="removeChoice(questionIndex, choiceIndex)"
                            class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600"
                        >
                            Remove
                        </button>
                    </div>

                    <div>
                        <button
                            type="button"
                            @click="addChoice(questionIndex)"
                            class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600"
                        >
                            Add Choice
                        </button>
                    </div>

                    <div class="mt-4">
                        <button
                            type="button"
                            @click="removeQuestion(questionIndex)"
                            class="bg-red-500 text-white px-3 py-2 rounded hover:bg-red-600"
                        >
                            Remove Question
                        </button>
                    </div>
                </div>

                <div>
                    <button
                        type="button"
                        @click="addQuestion"
                        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600"
                    >
                        Add Question
                    </button>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Save Changes
                </PrimaryButton>
            </div>
        </form>
    </div>
</template>
