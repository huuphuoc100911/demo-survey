<!DOCTYPE html>
<html>

<head>
    <title>SurveyJS for jQuery - Multi-Page Survey</title>
    <meta charset="utf-8">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link href="https://unpkg.com/survey-jquery/defaultV2.min.css" type="text/css" rel="stylesheet">

    <script type="text/javascript" src="https://unpkg.com/survey-jquery/survey.jquery.min.js"></script>
    <style>
        #surveyExternalNavigation {
            padding: 16px 36px;
            line-height: 32px;
        }

        #surveyPrev,
        #surveyNext,
        #surveyComplete {
            color: #1ab394;
            cursor: pointer;
        }

        #pageSelector {
            width: 90px;
            box-sizing: border-box;
            border-radius: 2px;
            height: 34px;
            line-height: 34px;
            background: #fff;
            outline: 1px solid #d4d4d4;
            text-align: left;
            border: none;
            padding: 0 5px;
        }

        #pageSelector:focus {
            outline: 1px solid #1ab394;
        }
    </style>
</head>

<body>
    <div id="surveyExternalNavigation">
        External navigation:
        <span id="surveyProgress"></span>
        <span id="surveyPrev" onclick="window.navSurvey.prevPage();">Prev</span>
        <span id="surveyNext" onclick="window.navSurvey.nextPage();">Next</span>
        <span id="surveyComplete" onclick="window.navSurvey.completeLastPage();">Complete</span>
        <br />
        Go to page directly without validation: <select id="pageSelector"
            onchange="window.navSurvey.currentPageNo = this.value"></select>
    </div>
    <div id="surveyElement"></div>
    <div id="surveyContainer"></div>
    <div id="resultsContainer" style="display:none;">
        <code id="surveyResults" style="white-space:pre;"></code>
    </div>
</body>
<link href="https://unpkg.com/survey-jquery/defaultV2.min.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/survey-jquery/survey.jquery.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/survey-jquery"></script>
<script type="text/javascript" src="/js/common.js"></script>
<script>
    Survey.StylesManager.applyTheme("defaultV2");

    var keyword = 1;

    const surveyJson = {
        title: "Customer Feedback Survey",
        pages: [{
                "elements": [{
                    "type": "html",
                    "name": "",
                    "html": ""
                }]
            }, {
                elements: [{
                    type: "html",
                    name: "introduce",
                    html: "<h2>In this survey, we will ask you a couple questions about your impressions of our product.</h2>"
                }]
            }, {
                elements: [{
                    name: "satisfaction-score",
                    title: "How would you describe your experience with our product?",
                    type: "radiogroup",
                    choices: [{
                            value: "やあ",
                            text: "やあ"
                        },
                        {
                            value: "それは",
                            text: "それは"
                        },
                        {
                            value: "何です",
                            text: "何です"
                        },
                        {
                            value: "ログイン",
                            text: "ログイン"
                        },
                        {
                            value: "ものは",
                            text: "ものは"
                        }
                    ],
                    isRequired: true,
                    requiredErrorText: "Value cannot be empty",
                    visibleIf: "{keyword} == 1"
                }]
            }, {
                elements: [{
                    "name": "date",
                    "type": "text",
                    "title": "Select a date and time",
                    "inputType": "date",
                    "defaultValueExpression": "currentDate()",
                    "dateFormat": "mm/dd/yy",
                    isRequired: true,
                }]
            }, {
                elements: [{
                    name: "what-would-make-you-more-satisfied",
                    title: "What can we do to make your experience more satisfying?",
                    type: "radiogroup",
                    choices: [{
                            value: 'Laravel',
                            text: "Laravel"
                        },
                        {
                            value: "Vibrant",
                            text: "Vibrant"
                        },
                        {
                            value: "HUUPHUOC",
                            text: "HUUPHUOC"
                        },
                        {
                            value: "libraries",
                            text: "libraries"
                        },
                        {
                            value: "package",
                            text: "package"
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
                    "choices": ["Windows", "Linux", "Macintosh OSX", "Android", "IOS"]
                }]
            },
            {
                "elements": [{
                    "type": "comment",
                    "name": "pricelimit",
                    "title": "What is your favorite?",
                    isRequired: true,
                }],
            }, {
                elements: [{
                    "name": "phone",
                    "type": "text",
                    "title": "Enter a phone number",
                    "inputType": "tel",
                    "placeholder": "+84357789210",
                    "autocomplete": "tel",
                    "validators": [{
                        "type": "regex",
                        // "regex": "^(0|84)[0-9]{9}",
                        "regex": "\\+[84]{1}[0-9]{10}",
                        "text": "Phone number must be in the following format: +84123456789"
                    }],
                    isRequired: true,
                }]
            }, {
                "elements": [{
                    "name": "wallet",
                    "type": "text",
                    "title": "Wallet",
                    "placeholder": "0x00000000000",
                    "validators": [{
                        "type": "regex",
                        "regex": "^([0x]{1})",
                        "text": "Please enter your wallet address"
                    }],
                    isRequired: true,
                }],
            }, {
                "elements": [{
                    "type": "html",
                    "name": "info",
                    "html": "<table><body><row><td><img src='/images/tick.png' width='100px' /></td><td style='padding:20px'>Thank you for your feedback!</td></row></body></table>"
                }]
            }
        ],
        showQuestionNumbers: "on",
        pagePrevText: "Back",
        pageNextText: "Next",
        completeText: "Complete",
        showPrevButton: true,
        firstPageIsStarted: true,
        startSurveyText: "Take the Survey",
        completedHtml: "Thank you for your feedback!",
        surveyId: '4aa953e5-2f7e-4474-8cf7-35a95a1ea590',
        surveyPostId: "449ec3f5-c4fa-41c2-b7af-2d792c08cff4",
        surveyShowDataSaving: true,
        showProgressBar: "bottom",
        goNextPageAutomatic: false,
        showNavigationButtons: true,
    };

    const survey = new Survey.Model(surveyJson);
    // survey.locale = "ja";

    survey.start();

    function displayResults(sender) {
        const results = JSON.stringify(sender.data, null, 4);
        document.querySelector("#surveyResults").textContent = results;
        document.querySelector("#resultsContainer").style.display = "block";
        console.log(results);
    }

    const SURVEY_ID = '4aa953e5-2f7e-4474-8cf7-35a95a1ea590';

    function surveyComplete(sender) {
        saveSurveyResults(
            "https://your-web-service.com/" + SURVEY_ID,
            sender.data
        )
    }

    function saveSurveyResults(url, json) {
        const request = new XMLHttpRequest();
        request.open('POST', url);
        request.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
        request.addEventListener('load', () => {
            // Handle "load"
        });
        request.addEventListener('error', () => {
            // Handle "error"
        });
        request.send(JSON.stringify(json));
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
