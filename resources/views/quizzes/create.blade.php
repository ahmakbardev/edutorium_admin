@extends('layouts.layout')

@section('content')
    <div class="mx-6 my-10 grid grid-cols-1 grid-rows-1 grid-flow-row-dense gap-6">
        <div>
            <div class="card h-full shadow">
                <div class="border-b border-gray-300 px-5 py-4 flex items-center w-full justify-between">
                    <div>
                        <h4 class="font-semibold text-base">Buat Quiz Baru</h4>
                    </div>
                </div>
                <div class="container mx-auto py-8 px-5">
                    <form action="{{ route('quizzes.store') }}" method="POST" id="quiz-form">
                        @csrf
                        <div class="mb-4">
                            <label for="module_id" class="block text-gray-700">Modul</label>
                            <select id="module_id" name="module_id"
                                class="block w-full mt-1 p-2 border border-gray-300 rounded">
                                @foreach ($modules as $module)
                                    <option value="{{ $module->id }}">{{ $module->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700">Questions</label>
                            <div id="accordionExample" class="grid grid-cols-3 grid-rows-1 gap-3"></div>
                            <button type="button" id="add-question"
                                class="px-4 py-2 bg-blue-600 text-white rounded mt-4">Tambah Pertanyaan</button>
                        </div>

                        <input type="hidden" id="questions" name="questions">

                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan Quiz</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let questionIndex = 0;

            $('#add-question').click(function() {
                addQuestionSection();
            });

            function addQuestionSection() {
                let questionSection = `
                    <div class="border border-gray-400 rounded-md mb-3">
                        <h2 class="accordion-header px-4 py-3">
                            <button class="text-lg fw-semibold flex items-center w-full justify-between" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${questionIndex}" aria-expanded="true" aria-controls="collapse${questionIndex}">
                                <span>Pertanyaan #${questionIndex + 1}</span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down collapse-icon">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </span>
                            </button>
                        </h2>
                        <div id="collapse${questionIndex}" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                            <div class="accordion-body px-4 py-3 border-t border-gray-400">
                                <div class="mb-4">
                                    <label class="block text-gray-700">Question</label>
                                    <input type="text" name="question_${questionIndex}" class="block w-full mt-1 p-2 border border-gray-300 rounded" required>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700">Answers</label>
                                    <input type="text" name="answers_${questionIndex}[]" class="block w-full mt-1 p-2 border border-gray-300 rounded" required placeholder="Answer 1">
                                    <input type="text" name="answers_${questionIndex}[]" class="block w-full mt-1 p-2 border border-gray-300 rounded" required placeholder="Answer 2">
                                    <input type="text" name="answers_${questionIndex}[]" class="block w-full mt-1 p-2 border border-gray-300 rounded" required placeholder="Answer 3">
                                    <input type="text" name="answers_${questionIndex}[]" class="block w-full mt-1 p-2 border border-gray-300 rounded" required placeholder="Answer 4">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700">Correct Answer</label>
                                    <input type="number" name="correct_${questionIndex}" class="block w-full mt-1 p-2 border border-gray-300 rounded" required min="1" max="4" placeholder="Correct Answer (1-4)">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700">Image (optional)</label>
                                    <input type="text" name="image_${questionIndex}" class="block w-full mt-1 p-2 border border-gray-300 rounded" placeholder="Image URL">
                                </div>
                                <button type="button" class="remove-question px-4 py-2 bg-red-600 text-white rounded">Hapus Pertanyaan</button>
                            </div>
                        </div>
                    </div>
                `;
                $('#accordionExample').append(questionSection);
                questionIndex++;
            }

            $(document).on('click', '.remove-question', function() {
                $(this).closest('.border').remove();
            });

            $('#quiz-form').submit(function(e) {
                let questions = [];
                $('.accordion-body').each(function() {
                    let question = $(this).find('input[name^="question_"]').val();
                    let answers = [];
                    $(this).find('input[name^="answers_"]').each(function() {
                        answers.push($(this).val());
                    });
                    let correct = $(this).find('input[name^="correct_"]').val();
                    let image = $(this).find('input[name^="image_"]').val();
                    questions.push({
                        question: question,
                        answers: answers,
                        correct: correct,
                        image: image
                    });
                });
                $('#questions').val(JSON.stringify(questions));
            });
        });
    </script>
@endsection
