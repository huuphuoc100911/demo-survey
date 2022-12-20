<!DOCTYPE html>
<html>

<head>
    <title>SurveyJS for jQuery - Multi-Page Survey</title>
    <meta charset="utf-8">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link href="https://unpkg.com/survey-jquery/defaultV2.min.css" type="text/css" rel="stylesheet">

    <script type="text/javascript" src="https://unpkg.com/survey-jquery/survey.jquery.min.js"></script>
    {{-- <script type="text/javascript" src="/js/survey.js"></script> --}}
</head>

<body>
    <h3>Huu Phuoc</h3>
    <div id="surveyContainer"></div>
    <div id="resultsContainer" style="display:none;">
        <p>Result JSON:</p>
        <code id="surveyResults" style="white-space:pre;"></code>
    </div>
</body>
<script>
    Survey.StylesManager.applyTheme("defaultV2");

    const surveyJson = {
        pages: [{
                elements: [{
                    type: "html",
                    html: "<h2>In this survey, we will ask you a couple questions about your impressions of our product.</h2>"
                }]
            }, {
                elements: [{
                    name: "satisfaction-score",
                    title: "How would you describe your experience with our product?",
                    type: "radiogroup",
                    choices: [{
                            value: 5,
                            text: "Fully satisfying"
                        },
                        {
                            value: 4,
                            text: "Generally satisfying"
                        },
                        {
                            value: 3,
                            text: "Neutral"
                        },
                        {
                            value: 2,
                            text: "Rather unsatisfying"
                        },
                        {
                            value: 1,
                            text: "Not satisfying at all"
                        }
                    ],
                    isRequired: true,
                    requiredErrorText: "Value aaaa cannot be empty",
                }]
            }, {
                elements: [{
                    name: "what-would-make-you-more-satisfied",
                    title: "What can we do to make your experience more satisfying?",
                    type: "comment",
                    visibleIf: "{satisfaction-score} = 4",
                    isRequired: true
                }, {
                    name: "nps-score",
                    title: "On a scale of zero to ten, how likely are you to recommend our product to a friend or colleague?",
                    type: "rating",
                    rateMin: 0,
                    rateMax: 10,
                    isRequired: true
                }],
                visibleIf: "{satisfaction-score} >= 4"
            }, {
                elements: [{
                    name: "how-can-we-improve",
                    title: "In your opinion, how could we improve our product?",
                    type: "comment",
                    isRequired: true,
                    validators: [{
                        text: "Value must be a numberaaaaa",
                        type: "numeric",
                    }]
                }],
                visibleIf: "{satisfaction-score} = 3",
            }, {
                elements: [{
                    name: "disappointing-experience",
                    title: "Please let us know why you had such a disappointing experience with our product",
                    type: "comment",
                    isRequired: true
                }],
                visibleIf: "{satisfaction-score} =< 2"
            },
            {
                "title": "What operating system do you use?",
                "elements": [{
                    "type": "checkbox",
                    "name": "opSystem",
                    "title": "OS",
                    "showOtherItem": true,
                    "isRequired": true,
                    "choices": ["Windows", "Linux", "Macintosh OSX"]
                }],
                visibleIf: "{satisfaction-score} = 4"
            }
        ],
        showQuestionNumbers: "off",
        pageNextText: "Next",
        completeText: "Submit",
        showPrevButton: false,
        firstPageIsStarted: true,
        startSurveyText: "Take the Survey",
        completedHtml: "Thank you for your feedback!",
        surveyId: "4aa953e5-2f7e-4474-8cf7-35a95a1ea590",
        surveyPostId: "449ec3f5-c4fa-41c2-b7af-2d792c08cff4",
        surveyShowDataSaving: true
        // showPreviewBeforeComplete: "showAnsweredQuestions"
    };

    const survey = new Survey.Model(surveyJson);
    survey.locale = "ja";

    survey.start();

    function displayResults(sender) {
        const results = JSON.stringify(sender.data, null, 4);
        console.log(results);
        document.querySelector("#surveyResults").textContent = results;
        document.querySelector("#resultsContainer").style.display = "block";
        $.ajax({
            url: "{{ route('user.postDemo') }}",
            method: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                "inputs": results
            },
            success: function(response) {
                console.log(response);
            }
        });
    }

    survey.onComplete.add(displayResults);

    $(function() {
        $("#surveyContainer").Survey({
            model: survey
        });
    });
</script>

</html>
