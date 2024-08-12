@extends('layouts.layout')

@section('content')
    <div class="mx-6 my-10 grid grid-cols-1 xl:grid-cols-3 grid-rows-1 grid-flow-row-dense gap-6">
        <div class="">
            <div class="card h-full shadow">
                <div class="border-b border-gray-300 px-5 py-4 flex items-center w-full justify-between">
                    <div>
                        <h4 class="font-semibold text-base">Penilaian Livecode untuk {{ $user->name }}</h4>
                    </div>
                </div>

                <div class="container mx-auto py-8 px-5">
                    <form action="{{ route('livecode_assessments.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <input type="hidden" name="livecode_tutorial_id" value="{{ $progress->module_id }}">
                        <div class="mb-4">
                            <label for="livecode_tutorial_name" class="block text-gray-700">Livecode Tutorial</label>
                            <p class="text-lg font-semibold text-black">
                                {{ $livecodeTutorials->where('module_id', $progress->module_id)->first()->name }}</p>
                            <button type="button"
                                class="btn gap-x-2 my-2 w-full bg-indigo-600 text-white border-indigo-600 disabled:opacity-50 disabled:pointer-events-none hover:bg-indigo-800 hover:border-indigo-800 active:bg-indigo-800 active:border-indigo-800 focus:outline-none focus:ring-4 focus:ring-indigo-300"
                                data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" role="button"
                                aria-controls="offcanvasRight">
                                Lihat Tutorial
                            </button>
                        </div>
                        <div class="mb-4">
                            <label for="kriteria_penilaian" class="block text-lg font-semibold text-black">Kriteria
                                Penilaian</label>
                            <div id="kriteria-container" class="grid grid-cols-2 gap-5 mb-2 my-3">
                                @if ($kriteria)
                                    @foreach ($kriteria as $kriteria_item)
                                        <div
                                            class="py-1 text-sm font-medium group hover:scale-105 transition-all ease-in-out rounded-full flex flex-col whitespace-nowrap">
                                            <span class="text-gray-700">{{ $kriteria_item }}</span>
                                            <input type="number" name="kriteria_penilaian[{{ $kriteria_item }}]"
                                                class="p-2 border ml-0 border-gray-300 rounded" placeholder="Nilai"
                                                required>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-red-500">Tidak ada kriteria untuk penilaian.</p>
                                @endif
                            </div>
                        </div>
                        <button type="submit" class="px-4 py-2 bg-blue-600 w-full text-white rounded">Simpan
                            Penilaian</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="xl:col-span-2">
            <div class="card h-full shadow">
                <div class="border-b border-gray-300 px-5 py-4 flex items-center w-full justify-between">
                    <div>
                        <h4 class="font-semibold text-base">Preview Livecode</h4>
                    </div>
                </div>
                <div class="container mx-auto py-8 px-5">
                    @if (isset($livecode['html']))
                        <iframe id="livecodeIframe" class="w-full h-[600px] border border-gray-300 rounded"></iframe>
                    @else
                        <p class="text-red-500">Tidak ada livecode untuk ditampilkan.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="offcanvas translate-x-full fixed top-0 w-full right-0 border-l border-gray-300 transition-all duration-300 transform h-full invisible bg-white z-50 max-w-xl"
        tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="flex items-center p-4 justify-between w-full">
            <h5 class="text-lg" id="offcanvasRightLabel">Livecode Tutorial & Kode</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close menu</span>
            </button>
        </div>

        <ul class="nav nav-tabs mb-3 border-b border-gray-300" id="offcanvas-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link px-5 py-3 rounded-t-md border border-white hover:border-gray-300 active"
                    id="tab-tutorial" data-bs-toggle="pill" href="#tutorialContent" type="button" role="tab"
                    aria-controls="tutorialContent" aria-selected="true">
                    Tutorial
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link px-5 py-3 rounded-t-md border border-white hover:border-gray-300" id="tab-html"
                    data-bs-toggle="pill" href="#htmlContent" type="button" role="tab" aria-controls="htmlContent"
                    aria-selected="false">
                    HTML
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link px-5 py-3 rounded-t-md border border-white hover:border-gray-300" id="tab-css"
                    data-bs-toggle="pill" href="#cssContent" type="button" role="tab" aria-controls="cssContent"
                    aria-selected="false">
                    CSS
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link px-5 py-3 rounded-t-md border border-white hover:border-gray-300" id="tab-js"
                    data-bs-toggle="pill" href="#jsContent" type="button" role="tab" aria-controls="jsContent"
                    aria-selected="false">
                    JavaScript
                </a>
            </li>
        </ul>

        <div class="tab-content py-6" id="offcanvas-tabContent">
            <div class="tab-pane fade show active" id="tutorialContent" role="tabpanel" aria-labelledby="tab-tutorial"
                tabindex="0">
                <div class="p-4 max-h-[800px]" data-simplebar="">
                    @foreach ($livecodeTutorials as $tutorial)
                        <div class="mb-4">
                            <h5 class="text-md font-semibold">{{ $tutorial->name }}</h5>
                            <p>{!! $tutorial->tutorial !!}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="tab-pane fade" id="htmlContent" role="tabpanel" aria-labelledby="tab-html" tabindex="0">
                <textarea id="htmlEditor" class="w-full h-[600px]"></textarea>
            </div>

            <div class="tab-pane fade" id="cssContent" role="tabpanel" aria-labelledby="tab-css" tabindex="0">
                <textarea id="cssEditor" class="w-full h-[600px]"></textarea>
            </div>

            <div class="tab-pane fade" id="jsContent" role="tabpanel" aria-labelledby="tab-js" tabindex="0">
                <textarea id="jsEditor" class="w-full h-[600px]"></textarea>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/xml/xml.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/css/css.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/javascript/javascript.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/theme/material-darker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/addon/hint/show-hint.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/addon/hint/show-hint.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/addon/hint/html-hint.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/addon/hint/css-hint.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/addon/hint/javascript-hint.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/addon/edit/closetag.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/addon/edit/matchtags.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/addon/hint/anyword-hint.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/addon/search/matchesonscrollbar.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/addon/search/searchcursor.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/addon/search/search.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/addon/search/jump-to-line.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/addon/search/matchesonscrollbar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/addon/search/match-highlighter.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize CodeMirror editors for HTML, CSS, and JS content
            const htmlContent = @json($livecode['html'] ?? '');
            const cssContent = @json($livecode['css'] ?? '');
            const jsContent = @json($livecode['js'] ?? '');

            const htmlEditor = CodeMirror.fromTextArea(document.getElementById('htmlEditor'), {
                mode: 'xml',
                theme: 'material-darker',
                lineNumbers: true,
                readOnly: 'nocursor' // Read only, but allow selection
            });
            htmlEditor.setValue(htmlContent);

            const cssEditor = CodeMirror.fromTextArea(document.getElementById('cssEditor'), {
                mode: 'css',
                theme: 'material-darker',
                lineNumbers: true,
                readOnly: 'nocursor' // Read only, but allow selection
            });
            cssEditor.setValue(cssContent);

            const jsEditor = CodeMirror.fromTextArea(document.getElementById('jsEditor'), {
                mode: 'javascript',
                theme: 'material-darker',
                lineNumbers: true,
                readOnly: 'nocursor' // Read only, but allow selection
            });
            jsEditor.setValue(jsContent);

            // Function to refresh editors when the corresponding tab is activated
            function refreshEditors() {
                htmlEditor.refresh();
                cssEditor.refresh();
                jsEditor.refresh();
            }

            // Attach event listeners to tab switches to refresh CodeMirror instances
            const tabLinks = document.querySelectorAll('[data-bs-toggle="pill"]');
            tabLinks.forEach((tabLink) => {
                tabLink.addEventListener('shown.bs.tab', (event) => {
                    const targetTab = event.target.getAttribute('aria-controls');
                    if (['htmlContent', 'cssContent', 'jsContent'].includes(targetTab)) {
                        refreshEditors();
                    }
                });
            });
        });
    </script>



    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const htmlContent = @json($livecode['html'] ?? '');
            const cssContent = @json($livecode['css'] ?? '');
            const jsContent = @json($livecode['js'] ?? '');
            const links = @json($livecode['links'] ?? '');
            const scripts = @json($livecode['scripts'] ?? '');

            const iframe = document.getElementById('livecodeIframe');
            const previewDoc = iframe.contentDocument || iframe.contentWindow.document;

            previewDoc.open();
            previewDoc.write(`
                <html>
                <head>
                    ${links}
                    <style>${cssContent}</style>
                </head>
                <body>
                    ${htmlContent}
                </body>
                </html>
            `);
            previewDoc.close();

            // Add JS content
            if (jsContent) {
                const scriptElement = previewDoc.createElement('script');
                scriptElement.type = 'text/javascript';
                scriptElement.text = jsContent;
                previewDoc.body.appendChild(scriptElement);
            }

            // Add external scripts if any
            if (scripts) {
                const scriptTags = scripts.split(';');
                scriptTags.forEach(scriptTag => {
                    const scriptElement = previewDoc.createElement('script');
                    scriptElement.src = scriptTag.trim();
                    previewDoc.head.appendChild(scriptElement);
                });
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Select all input elements that are used for kriteria penilaian
            const kriteriaInputs = document.querySelectorAll('input[name^="kriteria_penilaian"]');

            // Add event listener to each input to ensure the value does not exceed 100
            kriteriaInputs.forEach(input => {
                input.addEventListener('input', (event) => {
                    const value = parseInt(event.target.value, 10);
                    if (value > 100) {
                        event.target.value = 100;
                    } else if (value < 0) {
                        event.target.value = 0;
                    }
                });

                // Add event listener to prevent typing non-numeric characters
                input.addEventListener('keydown', (event) => {
                    // Allow backspace, delete, tab, escape, enter and '.'
                    if ([46, 8, 9, 27, 13].includes(event.keyCode) ||
                        // Allow: Ctrl+A, Command+A
                        (event.keyCode === 65 && (event.ctrlKey === true || event.metaKey ===
                            true)) ||
                        // Allow: Ctrl+C, Command+C
                        (event.keyCode === 67 && (event.ctrlKey === true || event.metaKey ===
                            true)) ||
                        // Allow: Ctrl+X, Command+X
                        (event.keyCode === 88 && (event.ctrlKey === true || event.metaKey ===
                            true)) ||
                        // Allow: home, end, left, right
                        (event.keyCode >= 35 && event.keyCode <= 39)) {
                        // let it happen, don't do anything
                        return;
                    }
                    // Ensure that it is a number and stop the keypress
                    if ((event.shiftKey || (event.keyCode < 48 || event.keyCode > 57)) && (event
                            .keyCode < 96 || event.keyCode > 105)) {
                        event.preventDefault();
                    }
                });
            });
        });
    </script>

@endsection
