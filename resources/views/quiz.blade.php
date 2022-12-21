<!DOCTYPE html>
<html>

<head>
    <title>SurveyJS for jQuery - Quiz Survey</title>
    <meta charset="utf-8">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link href="https://unpkg.com/survey-jquery/defaultV2.min.css" type="text/css" rel="stylesheet">

    <script type="text/javascript" src="https://unpkg.com/survey-jquery/survey.jquery.min.js"></script>
    {{-- <script type="text/javascript" src="/js/survey.js"></script> --}}
</head>

<body>
    <div id="surveyContainer"></div>
    <div id="resultsContainer" style="display:none;">
        <code id="surveyResults" style="white-space:pre;"></code>
    </div>
</body>
<script>
    Survey.StylesManager.applyTheme("defaultV2");

    const surveyJson = {
        title: "Customer Feedback Survey",
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
                            text: "やあ"
                        },
                        {
                            value: 4,
                            text: "それは"
                        },
                        {
                            value: 3,
                            text: "何です"
                        },
                        {
                            value: 2,
                            text: "それは"
                        },
                        {
                            value: 1,
                            text: "ものは"
                        }
                    ],
                    isRequired: true,
                    requiredErrorText: "Value cannot be empty",
                }]
            }, {
                elements: [{
                    "name": "datetime-local",
                    "type": "text",
                    "title": "Select a date and time",
                    "inputType": "datetime-local",
                    "defaultValueExpression": "currentDate()",
                    isRequired: true,
                }]
            }, {
                elements: [{
                    name: "what-would-make-you-more-satisfied",
                    title: "What can we do to make your experience more satisfying?",
                    type: "radiogroup",
                    choices: [{
                            value: 5,
                            text: "やあ"
                        },
                        {
                            value: 4,
                            text: "それは"
                        },
                        {
                            value: 3,
                            text: "何です"
                        },
                        {
                            value: 2,
                            text: "それは"
                        },
                        {
                            value: 1,
                            text: "ものは"
                        }
                    ],
                    isRequired: true,
                    requiredErrorText: "Value cannot be empty",
                }],
            }, {
                "elements": [{
                    "type": "dropdown",
                    "name": "car",
                    "title": "Which is the brand of your car?",
                    "isRequired": true,
                    "showNoneItem": false,
                    "showOtherItem": false,
                    "choices": ["Ford", "Vauxhall", "Volkswagen", "Nissan", "Audi", "Mercedes-Benz",
                        "BMW", "Peugeot", "Toyota", "Citroen"
                    ]
                }],
                "showQuestionNumbers": false
            }, {
                "title": "What operating system do you use?",
                "elements": [{
                    "type": "checkbox",
                    "name": "opSystem",
                    "title": "OS",
                    "showOtherItem": false,
                    "isRequired": true,
                    "choices": ["Windows", "Linux", "Macintosh OSX"]
                }]
            },
            {
                "elements": [{
                    "type": "comment",
                    "name": "pricelimit",
                    "title": "What is the... ",
                    isRequired: true,
                }],
            },
        ],
        showQuestionNumbers: "off",
        pagePrevText: "Back",
        pageNextText: "Next",
        completeText: "Submit",
        showPrevButton: true,
        firstPageIsStarted: true,
        startSurveyText: "Take the Survey",
        completedHtml: "Thank you for your feedback!",
        surveyId: '4aa953e5-2f7e-4474-8cf7-35a95a1ea590',
        surveyPostId: "449ec3f5-c4fa-41c2-b7af-2d792c08cff4",
        surveyShowDataSaving: true
        showPreviewBeforeComplete: "showAnsweredQuestions"
    };

    const survey = new Survey.Model(surveyJson);
    survey.locale = "ja";

    survey.start();

    function displayResults(sender) {
        const results = JSON.stringify(sender.data, null, 4);
        alert('Khao sat thanh cong');
        // document.querySelector("#surveyResults").textContent = results;
        // document.querySelector("#resultsContainer").style.display = "block";
    }

    survey.onComplete.add(displayResults);

    $(function() {
        $("#surveyContainer").PopupSurvey({
            model: survey,
            isExpanded: true
        });
    });
</script>

</html>
