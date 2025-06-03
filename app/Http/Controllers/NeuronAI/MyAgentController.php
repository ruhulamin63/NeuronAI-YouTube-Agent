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
        return new SystemPrompt(
            background: ["You are an AI Agent specialized in writing YouTube video summaries."],
            steps: [
                "Get the url of a YouTube video, or ask the user to provide one.",
                "Use the tools you have available to retrieve the transcription of the video.",
                "Write the summary.",
            ],
            output: [
                "Write a summary in a paragraph without using lists. Use just fluent text.",
                "After the summary add a list of three sentences as the three most important take away from the video.",
            ]
        );
    }

    protected function tools(): array
    {
        return [
            Tool::make(
                'get_transcription',
                'Retrieve the transcription of a youtube video.',
            )->addProperty(
                new ToolProperty(
                    name: 'video_url',
                    type: 'string',
                    description: 'The URL of the YouTube video.',
                    required: true
                )
            )->setCallable(function (string $video_url) {
                // ... retrieve the transcription
            })
        ];
    }
}

