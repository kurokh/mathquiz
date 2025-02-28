<template>
    <div>
        <h3 class="font-bold text-lg mb-4">Generate Answer</h3>
        <blockquote class="border-l-4 pl-4 italic text-gray-600 mb-4">
            {{ question.question }}
        </blockquote>
        <div v-if="generating" class="animate-pulse space-y-2">
            <div class="h-4 bg-gray-300 rounded w-3/4"></div>
            <div class="h-4 bg-gray-300 rounded w-full"></div>
            <div class="h-4 bg-gray-300 rounded w-5/6"></div>
        </div>
        <div v-else class="py-4">
            <div v-html="formattedAnswer"></div>
        </div>
        <div class="modal-action">
            <button @click="$emit('close')" class="btn">Close</button>
        </div>
    </div>
</template>

<script>
import OpenAI from "openai";
import { marked } from "marked";
import { useAnswersStore } from "@/stores/answersStore";

export default {
    name: "GenerateAnswer",
    props: {
        question: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            generating: true,
            answer: "",
        };
    },
    computed: {
        formattedAnswer() {
            let processed = this.answer;
            processed = processed.replace(/\[\s*([\s\S]+?)\s*\]/g, (_, content) => `\\[${content}\\]`);
            processed = processed.replace(/\((\\[a-zA-Z]+(?:\{[^}]+\})+.*?)\)/g, (_, content) => `\\(${content}\\)`);
            return marked.parse(processed);
        },
    },
    watch: {
        formattedAnswer() {
            this.$nextTick(() => {
                if (window.MathJax) {
                    window.MathJax.typesetPromise();
                }
            });
        },
    },
    mounted() {
        const answersStore = useAnswersStore();
        if (answersStore.answers[this.question.id]) {
            this.answer = answersStore.answers[this.question.id];
            this.generating = false;
        } else {
            this.fetchAnswer();
        }
    },
    methods: {
        async fetchAnswer() {
            const prompt = "Answer the following question in plain text (do not use LaTeX, you can use /n for new line and bold font for markdown): " + this.question.question;
            const client = new OpenAI({
                apiKey: import.meta.env.VITE_OPENAI_API_KEY,
                dangerouslyAllowBrowser: true,
            });
            const answersStore = useAnswersStore();
            try {
                const stream = await client.chat.completions.create({
                    model: "gpt-4o-mini",
                    messages: [{ role: "user", content: prompt }],
                    stream: true,
                });
                let firstChunkReceived = false;

                for await (const chunk of stream) {
                    const content = chunk.choices[0]?.delta?.content || "";
                    this.answer += content;

                    if (!firstChunkReceived && content.trim() !== "") {
                        this.generating = false;
                        firstChunkReceived = true;
                    }
                }
                answersStore.setAnswer(this.question.id, this.answer);
            } catch (error) {
                console.error("Error generating answer:", error);
                this.answer = "Error generating answer.";
                this.generating = false;
            }
        },
    },
};
</script>
