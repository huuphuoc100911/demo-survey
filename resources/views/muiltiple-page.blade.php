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
</body>
<script>
    Survey.StylesManager.applyTheme("defaultV2");

    const json = {
        title: "Software developer survey.",
        pages: [{
                "title": "What operating system do you use?",
                "elements": [{
                    "type": "checkbox",
                    "name": "opSystem",
                    "title": "OS",
                    "showOtherItem": true,
                    "isRequired": true,
                    "choices": ["Windows", "Linux", "Macintosh OSX"]
                }]
            },
            {
                "title": "What language(s) are you currently using?",
                "elements": [{
                    "type": "checkbox",
                    "name": "langs",
                    "title": "Please select from the list",
                    "colCount": 4,
                    "isRequired": true,
                    "choices": [
                        "Javascript",
                        "Java",
                        "Python",
                        "CSS",
                        "PHP",
                        "Ruby",
                        "C++",
                        "C",
                        "Shell",
                        "C#",
                        "Objective-C",
                        "R",
                        "VimL",
                        "Go",
                        "Perl",
                        "CoffeeScript",
                        "TeX",
                        "Swift",
                        "Scala",
                        "Emacs Lisp",
                        "Haskell",
                        "Lua",
                        "Clojure",
                        "Matlab",
                        "Arduino",
                        "Makefile",
                        "Groovy",
                        "Puppet",
                        "Rust",
                        "PowerShell"
                    ]
                }]
            },
            {
                "title": "Please enter your name and e-mail",
                "elements": [{
                        "type": "text",
                        "name": "name",
                        "title": "Name:"
                    },
                    {
                        "type": "text",
                        "name": "email",
                        "title": "Your e-mail"
                    }
                ]
            }
        ]
    };

    function doOnCurrentPageChanged(survey) {
        var survey = window.navSurvey;
        document.getElementById('pageSelector').value = survey.currentPageNo;
        document.getElementById('surveyPrev').style.display = !survey.isFirstPage ? "inline" : "none";
        document.getElementById('surveyNext').style.display = !survey.isLastPage ? "inline" : "none";
        document.getElementById('surveyComplete').style.display = survey.isLastPage ? "inline" : "none";
        document.getElementById('surveyProgress').innerText = "Page " + (survey.currentPageNo + 1) + " of " + survey
            .visiblePageCount + ".";
        if (document.getElementById('surveyPageNo')) document.getElementById('surveyPageNo').value = survey
            .currentPageNo;
    }

    function setupPageSelector(survey) {
        console.log(survey);
        window.navSurvey = survey;
        var selector = document.getElementById('pageSelector');
        for (var i = 0; i < survey.visiblePages.length; i++) {
            var option = document.createElement("option");
            option.value = i;
            option.text = "Page " + (i + 1);
            selector.add(option);
        }
    }
    const survey = new Survey.Model(json);
    survey.showTitle = false;
    setupPageSelector(survey);
    doOnCurrentPageChanged(survey);
    survey.showTitle = false;

    $("#surveyElement").Survey({
        model: survey,
        onCurrentPageChanged: doOnCurrentPageChanged
    });
</script>

</html>
