<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Flashcard;
use App\Services\OpenRouterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Smalot\PdfParser\Parser;

class FlashcardController extends Controller
{
    protected $openRouterService;

    public function __construct(OpenRouterService $openRouterService)
    {
        $this->openRouterService = $openRouterService;
    }

    public function showGenerateForm()
    {
        return view('quiz.flashcardForm');
    }


    public function generateFlashcards(Request $request)
    {
        // dd($_FILES);
        $request->validate([
            'content' => 'required|string|min:10',
            'pdf' => 'nullable|file|mimes:pdf|max:20480',
        ]);



        try {
            if (!$request->input('content') && !$request->hasFile('pdf')) {
                return back()->with('error', 'Please enter text or upload a PDF.');
            }

            $finalText = '';

            if ($request->hasFile('pdf')) {
                $pdfFile = $request->file('pdf');

                $parser = new Parser();
                $pdf = $parser->parseFile($pdfFile->getPathname());

                $pdfText = $pdf->getText();

                // Make sure PDF text extracted correctly
                if (!$pdfText || strlen(trim($pdfText)) < 10) {
                    return back()->with('error', 'Unable to extract text from the PDF.');
                }

                $finalText .= "\n" . $pdfText;
            }

            if ($request->input('content')) {
                $finalText .= "\n" . $request->input('content');
            }

            $finalText = trim($finalText);


            // 1. Generate flashcard questions using the AI tool
            $questions = $this->generateQuestions($finalText);

            if (!is_array($questions) || count($questions) === 0) {
                return back()->with('error', 'AI did not return any questions.');
            }

            // 2. Create the quiz
            $quiz = Quiz::create([
                'name' => 'Quiz - ' . now()->format('Y-m-d H:i'),
                'user_id' => Auth::id() ?? 1,
            ]);

            // 3. Insert flashcards into DB
            foreach ($questions as $q) {
                Flashcard::create([
                    'question' => $q['question'],
                    'correct_answer' => $q['correct_answer'],
                    'wrong_answer_1' => $q['wrong_answer_1'],
                    'wrong_answer_2' => $q['wrong_answer_2'],
                    'wrong_answer_3' => $q['wrong_answer_3'],
                    'quiz_id' => $quiz->id,
                ]);
            }

            return redirect()
                ->route('quiz.review', $quiz->id)
                ->with('success', 'Flashcards generated successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to generate flashcards: ' . $e->getMessage());
        }
    }


    private function generateQuestions($content)
    {
        $prompt = <<<PROMPT
        You are an educational content creator. Based on the following study material, generate 5 multiple-choice questions with 4 answer options (1 correct, 3 incorrect).

        Study Material:
        $content

        Use the provided tool to return the questions. Do NOT return plain text or explanations.
        PROMPT;

        $messages = [
            ['role' => 'user', 'content' => $prompt]
        ];

        $tools = [
            [
                "type" => "function",
                "function" => [
                    "name" => "create_quiz_questions",
                    "description" => "Create multiple quiz questions in one request",
                    "parameters" => [
                        "type" => "object",
                        "properties" => [
                            "questions" => [
                                "type" => "array",
                                "items" => [
                                    "type" => "object",
                                    "properties" => [
                                        "question" => ["type" => "string"],
                                        "correct_answer" => ["type" => "string"],
                                        "wrong_answer_1" => ["type" => "string"],
                                        "wrong_answer_2" => ["type" => "string"],
                                        "wrong_answer_3" => ["type" => "string"]
                                    ],
                                    "required" => [
                                        "question",
                                        "correct_answer",
                                        "wrong_answer_1",
                                        "wrong_answer_2",
                                        "wrong_answer_3"
                                    ]
                                ]
                            ]
                        ],
                        "required" => ["questions"]
                    ]
                ]
            ]
        ];


        //         $messages = [
//             [
//                 "role" => "system",
//                 "content" => "
// You are an AI that generates quiz data and must call the correct tool when needed.

        // Here is the tool definition:

        // {
//   \"type\": \"function\",
//   \"name\": \"create_quiz_questions\",
//   \"description\": \"Create multiple quiz questions in one request\",
//   \"parameters\": {
//     \"type\": \"object\",
//     \"properties\": {
//       \"questions\": {
//         \"type\": \"array\",
//         \"items\": {
//           \"type\": \"object\",
//           \"properties\": {
//             \"question\": {\"type\": \"string\"},
//             \"correct_answer\": {\"type\": \"string\"},
//             \"wrong_answer_1\": {\"type\": \"string\"},
//             \"wrong_answer_2\": {\"type\": \"string\"},
//             \"wrong_answer_3\": {\"type\": \"string\"}
//           },
//           \"required\": [
//             \"question\",
//             \"correct_answer\",
//             \"wrong_answer_1\",
//             \"wrong_answer_2\",
//             \"wrong_answer_3\"
//           ]
//         }
//       }
//     },
//     \"required\": [\"questions\"]
//   }
// }

        // When the user gives text content, extract multiple quiz questions and call the function.
// "
//             ],
//             [
//                 "role" => "user",
//                 "content" => $content
//             ]
//         ];



        $response = $this->openRouterService->chat($messages, $tools);

        // Log the full response for debugging
        Log::info('OpenRouter API Response:', [
            'response' => $response
        ]);

        // Check if the response contains tool calls
        if (isset($response['choices'][0]['message']['tool_calls'])) {
            $toolCalls = $response['choices'][0]['message']['tool_calls'];

            // Find the tool call with our questions
            foreach ($toolCalls as $toolCall) {
                if ($toolCall['function']['name'] === 'create_quiz_questions') {
                    $arguments = $toolCall['function']['arguments'];

                    // Parse arguments if it's a string, otherwise use as is
                    if (is_string($arguments)) {
                        $arguments = json_decode($arguments, true);
                    }

                    if (isset($arguments['questions']) && is_array($arguments['questions'])) {
                        return $arguments['questions'];
                    }
                }
            }
        }

        // Fallback: check for content response
        if (isset($response['choices'][0]['message']['content'])) {
            $content = $response['choices'][0]['message']['content'];
            $questions = json_decode($content, true);

            if (is_array($questions) && isset($questions['questions'])) {
                return $questions['questions'];
            }

            if (is_array($questions)) {
                return $questions;
            }
        }

        throw new \Exception('Failed to parse AI response: ' . json_encode($response));
    }
}
