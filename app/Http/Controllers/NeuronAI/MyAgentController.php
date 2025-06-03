<?php

namespace App\Http\Controllers\NeuronAI;

use NeuronAI\Agent;
use NeuronAI\Tools\Tool;
use NeuronAI\SystemPrompt;
use NeuronAI\Tools\ToolProperty;
use NeuronAI\Providers\Gemini\Gemini;
use NeuronAI\Providers\AIProviderInterface;

class MyAgentController extends Agent
{
    protected function provider(): AIProviderInterface
    {
        return new Gemini(
            key: config('services.gemini.key'),
            model: config('services.gemini.model', 'gemini-pro')
        );
    }
    
    public function instructions(): string
    {
        // return new SystemPrompt(
        //     background: ["You are an AI Agent specialized in writing YouTube video summaries."],
        //     steps: [
        //         "Get the url of a YouTube video, or ask the user to provide one.",
        //         "Use the tools you have available to retrieve the transcription of the video.",
        //         "Write the summary.",
        //     ],
        //     output: [
        //         "Write a summary in a paragraph without using lists. Use just fluent text.",
        //         "After the summary add a list of three sentences as the three most important take away from the video.",
        //     ]
        // );

        return new SystemPrompt(
            background: [
                "You are a bilingual Human Resource (HR) expert who can understand both Bangla and English. Your job is to understand user input in either language and respond accordingly.",
                "তুমি একজন দ্বিভাষিক (Bangla ও English) Human Resource (HR) এক্সপার্ট। তোমার কাজ হলো ইউজারের ইনপুট যে ভাষায়ই হোক না কেন, তা বুঝে সঠিক পরামর্শ বা প্রতিক্রিয়া দেয়া।"
            ],
            steps: [
                "Accept user input which can be either in Bangla or English.",
                "Identify the context of the input (e.g., leave request, job application, appraisal, workplace conflict, etc.).",
                "Respond in the same language as the user using a polite and professional tone.",
                "ইনপুটের প্রাসঙ্গিকতা বোঝো—যেমন ছুটির আবেদন, চাকরির আবেদন, কর্মী মূল্যায়ন, অফিস সমস্যা ইত্যাদি।",
                "ইউজার যেভাবে ভাষা ব্যবহার করেছে, ঠিক সেই ভাষায় পেশাদারভাবে এবং ভদ্র ভাষায় উত্তর দাও।"
            ],
            output: [
                "If the user writes in Bangla, respond in Bangla. If the user writes in English, respond in English.",
                "উত্তরটি সংক্ষেপে, প্রাসঙ্গিকভাবে এবং নম্রভাবে দাও।",
                "If applicable, suggest a template or a correction to the message.",
                "প্রয়োজনে, একটি টেমপ্লেট বা সংশোধিত বার্তা সাজেশন দাও।"
            ]
        );
    }

    protected function tools(): array
    {
        // return [
        //     Tool::make(
        //         'get_transcription',
        //         'Retrieve the transcription of a youtube video.',
        //     )->addProperty(
        //         new ToolProperty(
        //             name: 'video_url',
        //             type: 'string',
        //             description: 'The URL of the YouTube video.',
        //             required: true
        //         )
        //     )->setCallable(function (string $video_url) {
        //         // ... retrieve the transcription
        //     })
        // ];

        return [
            Tool::make(
                'get_user_input',
                'Retrieve user input in either Bangla or English.',
            )->addProperty(
                new ToolProperty(
                    name: 'user_input',
                    type: 'string',
                    description: 'The input from the user, which can be in Bangla or English.',
                    required: true
                )
            )->setCallable(function (string $user_input) {
                // Process the user input and respond accordingly
                // return $this->processUserInput($user_input);
            })
        ];
    }
}

