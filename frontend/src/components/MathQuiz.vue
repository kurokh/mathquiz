<template>
    <div class="container py-8 max-w-[960px] mx-auto">
        <div v-if="loading">
            <div
                v-for="n in 3"
                :key="n"
                class="card bg-base-200 mb-6 p-6 rounded-lg animate-pulse"
            >
                <div class="h-6 bg-gray-300 rounded w-3/4 mb-4"></div>
                <div v-for="i in 3" :key="i" class="mb-2">
                    <div class="h-4 bg-gray-300 rounded w-1/2 mb-1"></div>
                    <div class="h-4 bg-gray-300 rounded w-1/3"></div>
                </div>
                <div class="mt-4">
                    <div class="h-10 bg-gray-300 rounded-full w-1/3"></div>
                </div>
            </div>
        </div>
        <div v-else>
            <div
                v-for="question in questions"
                :key="question.id"
                class="card bg-base-200 mb-6 p-6 rounded-lg"
            >
                <div class="mb-4 flex flex-col-reverse md:flex-row md:justify-between md:items-center">
                    <h2 class="card-title text-xl">{{ question.question }}</h2>
                    <div 
                        class="mt-2 mb-2 md:mt-0 md:mb-0 self-end"
                        :class="{ tooltip: !feedback[question.id] }" 
                        :data-tip="!feedback[question.id] ? 'Please submit your answer first' : null"
                    >
                        <button
                            @click="openModal(question)"
                            type="button"
                            :disabled="!feedback[question.id]"
                            :class="[
                                'btn btn-sm flex items-center gap-2 bg-gray-200 text-gray-700 hover:bg-gray-300',
                                !feedback[question.id] && 'disabled:opacity-50 disabled:cursor-not-allowed'
                            ]"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 576 512"
                                class="w-4 h-4"
                                fill="currentColor"
                            >
                                <path d="M458.3 34.9c3.1-3.1 8.2-3.1 11.3 0l39.4 39.4c3.1 3.1 3.1 8.2 0 11.3L388.7 206.1l-50.7-50.7L458.3 34.9zM66.9 426.3L315.3 177.9l50.7 50.7L117.7 477.1c-3.1 3.1-8.2 3.1-11.3 0L66.9 437.7c-3.1-3.1-3.1-8.2 0-11.3zM435.7 12.3L44.3 403.7c-15.6 15.6-15.6 40.9 0 56.6l39.4 39.4c15.6 15.6 40.9 15.6 56.6 0L531.7 108.3c15.6-15.6 15.6-40.9 0-56.6L492.3 12.3c-15.6-15.6-40.9-15.6-56.6 0zM128 80c0-8.8-7.2-16-16-16s-16 7.2-16 16v48H48c-8.8 0-16 7.2-16 16s7.2 16 16 16H96v48c0 8.8 7.2 16 16 16s16-7.2 16-16V160h48c8.8 0 16-7.2 16-16s-7.2-16-16-16H128V80zM464 320c-8.8 0-16 7.2-16 16v48H400c-8.8 0-16 7.2-16 16s7.2 16 16 16h48v48c0 8.8 7.2 16 16 16s16-7.2 16-16V416h48c8.8 0 16-7.2 16-16s-7.2-16-16-16H480V336c0-8.8-7.2-16-16-16zM252.2 16c0-6.7-5.4-12.2-12.2-12.2s-12.2 5.4-12.2 12.2V35.8H208c-6.7 0-12.2 5.4-12.2 12.2s5.4 12.2 12.2 12.2h19.8V80c0 6.7 5.4 12.2 12.2 12.2s12.2-5.4 12.2-12.2V60.2H272c6.7 0 12.2-5.4 12.2-12.2s-5.4-12.2-12.2-12.2H252.2V16z"/></svg>
                            Generate Answer
                        </button>
                    </div>
                </div>
                <form @submit.prevent="checkAnswer(question)">
                    <div
                        v-for="option in question.options"
                        :key="option.id"
                        class="form-control mb-2"
                    >
                        <label class="label cursor-pointer">
                            <input
                                type="radio"
                                :name="'question-' + question.id"
                                :value="option.id"
                                v-model="userAnswers[question.id]"
                                class="radio radio-primary mr-2"
                            />
                            <span class="label-text">{{ option.option_text }}</span>
                        </label>
                    </div>
                    <button
                        type="button"
                        @click="checkAnswer(question)"
                        class="btn btn-primary mt-4 rounded-full"
                    >
                        Submit Answer
                    </button>
                    <div
                        v-if="feedback[question.id]"
                        class="alert mt-4 rounded-lg"
                        :class="{
                            'alert-success': feedback[question.id].correct,
                            'alert-error': !feedback[question.id].correct
                        }"
                    >
                        <p>{{ feedback[question.id].message }}</p>
                    </div>
                </form>
            </div>
        </div>
        <div v-if="showModal" class="modal modal-open shadow-lg bg-transparent">
            <div class="modal-box">
                <GenerateAnswer :question="modalQuestion" @close="closeModal" />
            </div>
        </div>
    </div>
</template>

<script>
import GenerateAnswer from './GenerateAnswer.vue';

export default {
    name: 'MathQuiz',
    components: {
        GenerateAnswer
    },
    data() {
        return {
            questions: [],
            userAnswers: {},
            feedback: {},
            loading: true,
            showModal: false,
            modalQuestion: {}
        };
    },
    mounted() {
        fetch(import.meta.env.VITE_BACKEND_API_URL+'/math-questions')
            .then(response => response.json())
            .then(data => {
                this.questions = data;
                this.loading = false;
            })
            .catch(error => {
                console.error('Error fetching questions:', error);
                this.loading = false;
            });
    },
    methods: {
        checkAnswer(question) {
            const selectedOptionId = this.userAnswers[question.id];
            if (!selectedOptionId) {
                this.feedback[question.id] = {
                    correct: false,
                    message: 'Please select an answer.'
                };
                this.feedback = { ...this.feedback };
                return;
            }
            const selectedOption = question.options.find(
                opt => opt.id === selectedOptionId
            );
            if (selectedOption && selectedOption.is_correct) {
                this.feedback[question.id] = {
                    correct: true,
                    message: 'Correct answer!'
                };
            } else {
                this.feedback[question.id] = {
                    correct: false,
                    message: 'Incorrect answer. Try again!'
                };
            }
            this.feedback = { ...this.feedback };
        },
        openModal(question) {
            this.modalQuestion = question;
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
            this.modalQuestion = {};
        }
    }
};
</script>
<style>
    .modal:before {
        background-color: transparent !important;
    }
</style>